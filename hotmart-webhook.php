<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/mercadopago.php';

function hotmart_hottok_recebido(): string
{
    $headers = function_exists('getallheaders') ? getallheaders() : [];
    foreach ($headers as $nome => $valor) {
        if (strcasecmp($nome, 'X-Hotmart-Hottok') === 0) {
            return (string)$valor;
        }
    }
    return '';
}

/**
 * Reembolso/chargeback da Hotmart: marca o pedido como 'reembolsado' e tira a
 * matrícula do curso — a não ser que o aluno tenha OUTRO pedido pago do mesmo
 * curso (ex.: comprou também no site). Se era o curso principal do aluno
 * (alunos.curso_id), troca para outra matrícula; sem nenhuma, desativa o login
 * (senão aluno_aplicar_curso_ativo() recriaria a matrícula no próximo acesso).
 */
function hotmart_revogar_acesso(PDO $pdo, string $transaction, string $evento): string
{
    if ($transaction === '') return 'sem transacao';
    require_once __DIR__ . '/matriculas.php';
    require_once __DIR__ . '/mailer.php';
    matriculas_ensure_schema($pdo);

    // Garante o valor 'reembolsado' no ENUM de pedidos.status (acrescenta, sem mexer nos existentes).
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
            ->execute(['Hotmart: ' . $evento . ' em ' . date('Y-m-d H:i'), $pedido['id']]);
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

    $resumo = sprintf('Hotmart %s — pedido #%d (%s, %s), curso %s. Acesso %s.',
        $evento, $pedido['id'], $pedido['nome'], $pedido['email'], $pedido['curso_nome'],
        $revogou ? 'REVOGADO' : 'mantido (aluno tem outro pedido pago do mesmo curso)');
    error_log('hotmart-webhook: ' . $resumo);
    try {
        send_html_email(OWNER_COPY_EMAIL, '[Hotmart] ' . $evento . ' — pedido #' . $pedido['id'],
            '<p>' . htmlspecialchars($resumo, ENT_QUOTES) . '</p>', $resumo);
    } catch (Throwable $ignored) {}
    return $revogou ? 'acesso revogado' : 'acesso mantido';
}

if (!hash_equals(HOTMART_HOTTOK, hotmart_hottok_recebido())) {
    http_response_code(403);
    exit('hottok invalido');
}

$raw = file_get_contents('php://input') ?: '';
$payload = json_decode($raw, true);

// Reembolso / chargeback / cancelamento: tira a matrícula do curso daquele
// pedido. PURCHASE_PROTEST (cliente só PEDIU reembolso) não revoga nada —
// a Hotmart manda PURCHASE_REFUNDED quando o reembolso for concluído.
const HOTMART_EVENTOS_REVOGAM = ['PURCHASE_REFUNDED', 'PURCHASE_CHARGEBACK', 'PURCHASE_CANCELED'];
if (is_array($payload) && in_array($payload['event'] ?? '', HOTMART_EVENTOS_REVOGAM, true)) {
    $transaction = (string)($payload['data']['purchase']['transaction'] ?? '');
    try {
        $msg = hotmart_revogar_acesso(db(), $transaction, (string)$payload['event']);
    } catch (Throwable $e) {
        error_log('hotmart-webhook: falha ao revogar ' . $transaction . ': ' . $e->getMessage());
        http_response_code(500); // a Hotmart reenvia
        exit('erro ao revogar');
    }
    http_response_code(200);
    exit($msg);
}

if (!is_array($payload) || ($payload['event'] ?? '') !== 'PURCHASE_APPROVED') {
    http_response_code(200);
    exit('ignorado');
}

$purchase = $payload['data']['purchase'] ?? [];
$buyer = $payload['data']['buyer'] ?? [];

if (($purchase['status'] ?? '') !== 'APPROVED') {
    http_response_code(200);
    exit('status nao aprovado');
}

$transaction = (string)($purchase['transaction'] ?? '');
$email = trim((string)($buyer['email'] ?? ''));
if ($transaction === '' || $email === '') {
    http_response_code(200);
    exit('dados insuficientes');
}

$pdo = db();

// A Hotmart reenvia a mesma notificação até 5x em caso de falha — evita
// duplicar o pedido se a transação já foi processada.
// Pedido 'pendente' com a mesma transação = liberação que falhou antes: tenta de novo abaixo.
$dup = $pdo->prepare('SELECT id, status FROM pedidos WHERE hotmart_transaction = ?');
$dup->execute([$transaction]);
$existente = $dup->fetch();
if ($existente && $existente['status'] === 'pago') {
    http_response_code(200);
    exit('ja processado');
}

$nome = trim((string)($buyer['name'] ?? (trim(($buyer['first_name'] ?? '') . ' ' . ($buyer['last_name'] ?? '')))));
$cpf = substr(preg_replace('/\D/', '', (string)($buyer['document'] ?? '')) ?? '', 0, 11);
$telefone = preg_replace('/\D/', '', (string)($buyer['checkout_phone'] ?? '')) ?? '';
$valor = (float)($purchase['price']['value'] ?? 0);

// Produto Hotmart => curso do site. entrega_site=true: área de membros externa
// = nosso site; a compra cria o login/matrícula e manda o e-mail de acesso
// (mesmo fluxo do Mercado Pago). entrega_site=false (entrega pela Área de
// Membros da Hotmart, só registra o pedido) não é mais usado: desde
// 2026-11-17 todos os cursos, inclusive o Power BI, são entregues no site.
const HOTMART_PRODUTOS = [
    8144321 => ['slug' => 'power-bi', 'entrega_site' => true],
    9002171 => ['slug' => 'excel', 'entrega_site' => true],
    9002212 => ['slug' => 'python', 'entrega_site' => true],
    9002242 => ['slug' => 'ingles', 'entrega_site' => true],
];
$produtoId = (int)($payload['data']['product']['id'] ?? 0);
$mapa = HOTMART_PRODUTOS[$produtoId] ?? null;
if ($mapa === null) {
    error_log('hotmart-webhook: produto desconhecido ' . $produtoId . ' transacao ' . $transaction);
    http_response_code(200);
    exit('produto desconhecido');
}

$cursoStmt = $pdo->prepare("SELECT id, nome FROM cursos WHERE slug = ?");
$cursoStmt->execute([$mapa['slug']]);
$curso = $cursoStmt->fetch();

if (!$curso || $valor <= 0) {
    http_response_code(200);
    exit('curso ou valor invalido');
}

if ($existente) {
    $pedidoId = (int)$existente['id'];
} else {
    $status = $mapa['entrega_site'] ? 'pendente' : 'pago';
    $ins = $pdo->prepare("INSERT INTO pedidos (nome, email, cpf, telefone, curso_id, valor_centavos, status, hotmart_transaction, atualizado_em) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $ins->execute([$nome, $email, $cpf, $telefone, $curso['id'], (int)round($valor * 100), $status, $transaction]);
    $pedidoId = (int)$pdo->lastInsertId();
}

// Origem da venda: src/sck/xcod do link (?src=ig etc.), afiliado e parcelas.
require_once __DIR__ . '/pedidos.php';
$origin = $purchase['origin'] ?? [];
$afiliado = $payload['data']['affiliates'][0] ?? [];
pedido_registrar_origem($pdo, $pedidoId, [
    'plataforma' => 'hotmart',
    'src' => $origin['src'] ?? '',
    'sck' => $origin['sck'] ?? '',
    'xcod' => $origin['xcod'] ?? '',
    'afiliado' => trim((string)($afiliado['name'] ?? '') . ' ' . (string)($afiliado['affiliate_code'] ?? '')),
    'parcelas' => $purchase['payment']['installments_number'] ?? '',
    'oferta' => $purchase['offer']['code'] ?? '',
]);

if ($mapa['entrega_site']) {
    try {
        $res = marcar_pedido_pago($pedidoId, $cpf !== '' ? $cpf : null);
        // Quem já tinha login no site não recebe senha nova: avisa que o curso foi liberado.
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
        error_log('hotmart-webhook: falha ao liberar pedido ' . $pedidoId . ': ' . $e->getMessage());
        http_response_code(500); // a Hotmart reenvia; o pedido fica com webhook_ultimo_erro preenchido
        exit('erro ao liberar acesso');
    }
}

meta_capi_send_purchase($pedidoId, $email, $telefone, $valor, $curso['nome']);
// Sem cookie _ga aqui — o checkout roda inteiro dentro do domínio da Hotmart,
// então ga4_send_purchase() cai no client_id aleatório de fallback e a venda
// aparece no GA4 sem atribuição de canal (melhor que não aparecer nenhuma).
ga4_send_purchase($pedidoId, null, $valor, $curso['nome']);

http_response_code(200);
echo 'ok';
