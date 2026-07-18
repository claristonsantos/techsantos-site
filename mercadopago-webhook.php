<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/mercadopago.php';
require_once __DIR__ . '/pedidos.php';

$raw = file_get_contents('php://input') ?: '';
$data = json_decode($raw, true);

// Webhooks novos chegam como {"type":"payment","data":{"id":"123"}} no corpo;
// o formato antigo (IPN) manda topic/id via query string. Aceita os dois.
$paymentId = null;
if (is_array($data) && (($data['type'] ?? '') === 'payment' || ($data['action'] ?? '') === 'payment.updated' || ($data['action'] ?? '') === 'payment.created')) {
    $paymentId = $data['data']['id'] ?? null;
}
if (!$paymentId && (($_GET['type'] ?? '') === 'payment' || ($_GET['topic'] ?? '') === 'payment')) {
    $paymentId = $_GET['data_id'] ?? $_GET['id'] ?? null;
}

if (!$paymentId) {
    http_response_code(200);
    exit('ignored');
}

$payment = mercadopago_get_payment((string)$paymentId);
if (!$payment) {
    http_response_code(200);
    exit('payment not found');
}

$referenceId = (string)($payment['external_reference'] ?? '');
if (!preg_match('/^PEDIDO-(\d+)$/', $referenceId, $m)) {
    http_response_code(200);
    exit('ignored');
}

if (($payment['status'] ?? '') !== 'approved') {
    http_response_code(200);
    exit('not approved yet');
}

// O CPF não é mais coletado no nosso formulário (reduz fricção antes do
// pagamento) — o Mercado Pago pede documento dentro do próprio checkout dele,
// então aproveitamos esse valor aqui pra preencher o cadastro do aluno
// (necessário depois pra emissão do certificado).
$cpfDoPagamento = $payment['payer']['identification']['number'] ?? null;

$pedidoId = (int)$m[1];
marcar_pedido_pago($pedidoId, $cpfDoPagamento);

$stmt = db()->prepare('SELECT p.email, p.telefone, p.valor_centavos, c.nome AS curso_nome FROM pedidos p JOIN cursos c ON c.id = p.curso_id WHERE p.id = ?');
$stmt->execute([$pedidoId]);
if ($pedido = $stmt->fetch()) {
    meta_capi_send_purchase($pedidoId, $pedido['email'], $pedido['telefone'], $pedido['valor_centavos'] / 100, $pedido['curso_nome']);
}

http_response_code(200);
echo 'ok';
