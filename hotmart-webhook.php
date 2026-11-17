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

if (!hash_equals(HOTMART_HOTTOK, hotmart_hottok_recebido())) {
    http_response_code(403);
    exit('hottok invalido');
}

$raw = file_get_contents('php://input') ?: '';
$payload = json_decode($raw, true);

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

if ($mapa['entrega_site']) {
    require_once __DIR__ . '/pedidos.php';
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
