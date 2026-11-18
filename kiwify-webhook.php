<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/mercadopago.php';

/*
 * Webhook da Kiwify — mesmo fluxo do hotmart-webhook.php:
 *  - compra aprovada  => cria pedido + login/matrícula no site + e-mail de acesso
 *  - reembolso/chargeback => revoga a matrícula (se não houver outro pedido pago do curso)
 * Autenticação: a Kiwify assina o corpo com HMAC-SHA1 usando o token do webhook
 * e manda a assinatura em ?signature=. O token fica em config.php (KIWIFY_WEBHOOK_TOKEN).
 * O id do pedido Kiwify é gravado em pedidos.hotmart_transaction com prefixo "KW-"
 * (coluna já indexada para idempotência; evita migração de schema).
 */

// Produto Kiwify (product_id, o UUID da URL de edição do produto) => slug do curso no site.
const KIWIFY_PRODUTOS = [
    '4e9ad820-8302-11f1-b9d9-6f36757d8507' => 'power-bi',
    '0d424840-e3a6-11f1-9fee-495c52c8b6eb' => 'excel',
    '74524120-e3a6-11f1-88e1-77d7a6d4deac' => 'python',
    '9f434be0-e3a6-11f1-9fee-495c52c8b6eb' => 'ingles',
];
// Reserva caso o product_id do payload não seja o UUID acima: casa pelo início do nome do produto.
const KIWIFY_PRODUTOS_NOME = [
    'Power BI Completo' => 'power-bi',
    'Excel Completo' => 'excel',
    'Python para Dados' => 'python',
    'Inglês para Dados' => 'ingles',
];

if (!defined('KIWIFY_WEBHOOK_TOKEN') || KIWIFY_WEBHOOK_TOKEN === '') {
    http_response_code(503);
    exit('kiwify nao configurado');
}

$raw = file_get_contents('php://input') ?: '';
$assinatura = (string)($_GET['signature'] ?? '');
if ($assinatura === '' || !hash_equals(hash_hmac('sha1', $raw, KIWIFY_WEBHOOK_TOKEN), $assinatura)) {
    http_response_code(403);
    exit('assinatura invalida');
}

$payload = json_decode($raw, true);
if (!is_array($payload)) {
    http_response_code(200);
    exit('ignorado');
}

$orderId = (string)($payload['order_id'] ?? '');
$status = (string)($payload['order_status'] ?? '');
$transaction = $orderId !== '' ? 'KW-' . $orderId : '';
$pdo = db();

function kiwify_revogar_acesso(PDO $pdo, string $transaction, string $evento): string
{
    if ($transaction === '') return 'sem pedido';
    require_once __DIR__ . '/matriculas.php';
    require_once __DIR__ . '/mailer.php';
    matriculas_ensure_schema($pdo);
    $tipo = (string)($pdo->query("SHOW COLUMNS FROM pedidos LIKE 'status'")->fetch()['Type'] ?? '');
    if (stripos($tipo, 'enum(') === 0 && stripos($tipo, "'reembolsado'") === false) {
        $pdo->exec('ALTER TABLE pedidos MODIFY COLUMN status ' . substr($tipo, 0, -1) . ",'reembolsado') NOT NULL DEFAULT 'pendente'");
    }
    $st = $pdo->prepare('SELECT p.id, p.status, p.aluno_id, p.curso_id, p.nome, p.email, c.nome AS curso_nome
                         FROM pedidos p JOIN cursos c ON c.id = p.curso_id WHERE p.hotmart_transaction = ?');
    $st->execute([$transaction]);
    $pedido = $st->fetch();
    if (!$pedido) return 'pedido nao encontrado';
    if ($pedido['status'] === 'reembolsado') return 'ja revogado';
    if ($pedido['status'] !== 'pago') {
        $pdo->prepare("UPDATE pedidos SET status='cancelado', atualizado_em=NOW() WHERE id=?")->execute([$pedido['id']]);
        return 'pedido nao pago cancelado';
    }
    $pdo->beginTransaction();
    try {
        $pdo->prepare("UPDATE pedidos SET status='reembolsado', webhook_ultimo_erro=?, atualizado_em=NOW() WHERE id=?")
            ->execute(['Kiwify: ' . $evento . ' em ' . date('Y-m-d H:i'), $pedido['id']]);
        $alunoId = (int)$pedido['aluno_id'];
        $cursoId = (int)$pedido['curso_id'];
        $revogou = false;
        if ($alunoId > 0) {
            $outro = $pdo->prepare("SELECT COUNT(*) FROM pedidos WHERE aluno_id=? AND curso_id=? AND status='pago' AND id<>?");
            $outro->execute([$alunoId, $cursoId, $pedido['id']]);
            if ((int)$outro->fetchColumn() === 0) {
                $pdo->prepare('DELETE FROM matriculas WHERE aluno_id=? AND curso_id=?')->execute([$alunoId, $cursoId]);
                $principal = $pdo->prepare('SELECT curso_id FROM alunos WHERE id=?');
                $principal->execute([$alunoId]);
                if ((int)$principal->fetchColumn() === $cursoId) {
                    $resto = $pdo->prepare('SELECT curso_id FROM matriculas WHERE aluno_id=? ORDER BY criado_em LIMIT 1');
                    $resto->execute([$alunoId]);
                    $novo = $resto->fetchColumn();
                    if ($novo !== false) {
                        $pdo->prepare('UPDATE alunos SET curso_id=? WHERE id=?')->execute([(int)$novo, $alunoId]);
                    } else {
                        $pdo->prepare('UPDATE alunos SET ativo=0 WHERE id=?')->execute([$alunoId]);
                    }
                }
                $revogou = true;
            }
        }
        $pdo->commit();
    } catch (Throwable $e) {
        $pdo->rollBack();
        throw $e;
    }
    $resumo = sprintf('Kiwify %s — pedido #%d (%s, %s), curso %s. Acesso %s.',
        $evento, $pedido['id'], $pedido['nome'], $pedido['email'], $pedido['curso_nome'],
        $revogou ? 'REVOGADO' : 'mantido (aluno tem outro pedido pago do mesmo curso)');
    error_log('kiwify-webhook: ' . $resumo);
    try {
        send_html_email(OWNER_COPY_EMAIL, '[Kiwify] ' . $evento . ' — pedido #' . $pedido['id'],
            '<p>' . htmlspecialchars($resumo, ENT_QUOTES) . '</p>', $resumo);
    } catch (Throwable $ignored) {}
    return $revogou ? 'acesso revogado' : 'acesso mantido';
}

if (in_array($status, ['refunded', 'chargedback'], true)) {
    try {
        $msg = kiwify_revogar_acesso($pdo, $transaction, $status);
    } catch (Throwable $e) {
        error_log('kiwify-webhook: falha ao revogar ' . $transaction . ': ' . $e->getMessage());
        http_response_code(500);
        exit('erro ao revogar');
    }
    http_response_code(200);
    exit($msg);
}

if ($status !== 'paid') {
    http_response_code(200);
    exit('status ' . $status . ' ignorado');
}

$customer = $payload['Customer'] ?? [];
$email = trim((string)($customer['email'] ?? ''));
if ($transaction === '' || $email === '') {
    http_response_code(200);
    exit('dados insuficientes');
}

$dup = $pdo->prepare('SELECT id, status FROM pedidos WHERE hotmart_transaction = ?');
$dup->execute([$transaction]);
$existente = $dup->fetch();
if ($existente && $existente['status'] === 'pago') {
    http_response_code(200);
    exit('ja processado');
}

$produtoId = (string)($payload['Product']['product_id'] ?? '');
$slug = KIWIFY_PRODUTOS[$produtoId] ?? null;
if ($slug === null) {
    $produtoNome = (string)($payload['Product']['product_name'] ?? '');
    foreach (KIWIFY_PRODUTOS_NOME as $prefixo => $s) {
        if (strpos($produtoNome, $prefixo) === 0) { $slug = $s; break; }
    }
}
if ($slug === null) {
    error_log('kiwify-webhook: produto desconhecido ' . $produtoId . ' pedido ' . $orderId);
    http_response_code(200);
    exit('produto desconhecido');
}

$nome = trim((string)($customer['full_name'] ?? ''));
$cpf = substr(preg_replace('/\D/', '', (string)($customer['CPF'] ?? $customer['cnpj'] ?? '')) ?? '', 0, 11);
$telefone = preg_replace('/\D/', '', (string)($customer['mobile'] ?? '')) ?? '';
// charge_amount vem em centavos (valor pago pelo cliente).
$valorCentavos = (int)($payload['Commissions']['charge_amount'] ?? 0);
$valor = $valorCentavos / 100;

$cursoStmt = $pdo->prepare('SELECT id, nome FROM cursos WHERE slug = ?');
$cursoStmt->execute([$slug]);
$curso = $cursoStmt->fetch();
if (!$curso || $valorCentavos <= 0) {
    http_response_code(200);
    exit('curso ou valor invalido');
}

if ($existente) {
    $pedidoId = (int)$existente['id'];
} else {
    $ins = $pdo->prepare("INSERT INTO pedidos (nome, email, cpf, telefone, curso_id, valor_centavos, status, hotmart_transaction, atualizado_em) VALUES (?, ?, ?, ?, ?, ?, 'pendente', ?, NOW())");
    $ins->execute([$nome, $email, $cpf, $telefone, $curso['id'], $valorCentavos, $transaction]);
    $pedidoId = (int)$pdo->lastInsertId();
}

require_once __DIR__ . '/pedidos.php';
try {
    $res = marcar_pedido_pago($pedidoId, $cpf !== '' ? $cpf : null);
    if (($res['email_enviado'] ?? null) === null) {
        $primeiro = htmlspecialchars(explode(' ', trim($nome))[0] ?: 'Olá', ENT_QUOTES);
        $cursoHtml = htmlspecialchars($curso['nome'], ENT_QUOTES);
        $html = "<p>Oi, {$primeiro}!</p><p>O curso <strong>{$cursoHtml}</strong> já está liberado na sua conta da Tech Santos.</p>"
            . "<p>Entre com o mesmo e-mail e senha de sempre em <a href=\"https://techsantos.com.br/login.php\">techsantos.com.br/login.php</a>. "
            . "Esqueceu a senha? Use \"Esqueci minha senha\" na tela de login.</p>" . email_footer_html();
        $text = "Oi! O curso {$curso['nome']} já está liberado na sua conta da Tech Santos. Entre em https://techsantos.com.br/login.php com o mesmo e-mail e senha de sempre.";
        send_html_email($email, 'Curso liberado: ' . $curso['nome'] . ' — TECH SANTOS BR', $html, $text, OWNER_COPY_EMAIL);
    }
} catch (Throwable $e) {
    error_log('kiwify-webhook: falha ao liberar pedido ' . $pedidoId . ': ' . $e->getMessage());
    http_response_code(500);
    exit('erro ao liberar acesso');
}

// Sem Meta CAPI aqui: o checkout da Kiwify já dispara o Purchase pelo pixel
// configurado em cada produto — mandar de novo contaria a venda 2x.
ga4_send_purchase($pedidoId, null, $valor, $curso['nome']);

http_response_code(200);
echo 'ok';
