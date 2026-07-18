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
$dup = $pdo->prepare('SELECT id FROM pedidos WHERE hotmart_transaction = ?');
$dup->execute([$transaction]);
if ($dup->fetch()) {
    http_response_code(200);
    exit('ja processado');
}

$nome = trim((string)($buyer['name'] ?? (trim(($buyer['first_name'] ?? '') . ' ' . ($buyer['last_name'] ?? '')))));
$cpf = substr(preg_replace('/\D/', '', (string)($buyer['document'] ?? '')) ?? '', 0, 11);
$telefone = preg_replace('/\D/', '', (string)($buyer['checkout_phone'] ?? '')) ?? '';
$valor = (float)($purchase['price']['value'] ?? 0);

$cursoStmt = $pdo->prepare("SELECT id, nome FROM cursos WHERE slug = 'power-bi'");
$cursoStmt->execute();
$curso = $cursoStmt->fetch();

if (!$curso || $valor <= 0) {
    http_response_code(200);
    exit('curso ou valor invalido');
}

// O curso já é entregue pela própria Hotmart (Área de Membros de lá) — não
// criamos aluno nem mandamos e-mail de acesso ao site. Só registramos o
// pedido (pra aparecer em Pedidos no admin) e mandamos o Purchase pro Meta.
$ins = $pdo->prepare("INSERT INTO pedidos (nome, email, cpf, telefone, curso_id, valor_centavos, status, hotmart_transaction, atualizado_em) VALUES (?, ?, ?, ?, ?, ?, 'pago', ?, NOW())");
$ins->execute([$nome, $email, $cpf, $telefone, $curso['id'], (int)round($valor * 100), $transaction]);
$pedidoId = (int)$pdo->lastInsertId();

meta_capi_send_purchase($pedidoId, $email, $telefone, $valor, $curso['nome']);

http_response_code(200);
echo 'ok';
