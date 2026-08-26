<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/mercadopago.php';

$pedidoId = filter_input(INPUT_GET, 'pedido', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$token = trim((string)($_GET['token'] ?? ''));
if (!$pedidoId || !preg_match('/^[a-f0-9]{64}$/', $token)) {
    http_response_code(400);
    exit('Link de pagamento inválido.');
}

$stmt = db()->prepare('SELECT id, status, mercadopago_preference_id FROM pedidos WHERE id = ? LIMIT 1');
$stmt->execute([$pedidoId]);
$pedido = $stmt->fetch();
if (!$pedido || empty($pedido['mercadopago_preference_id'])) {
    http_response_code(404);
    exit('Pedido não encontrado.');
}

$preferenceId = (string)$pedido['mercadopago_preference_id'];
if (!hash_equals(mercadopago_resume_token((int)$pedido['id'], $preferenceId), $token)) {
    http_response_code(403);
    exit('Link de pagamento inválido.');
}
if ((string)$pedido['status'] === 'pago') {
    header('Location: /pagbank-retorno.php?pedido=' . (int)$pedido['id'], true, 302);
    exit;
}

$checkoutUrl = mercadopago_get_preference_checkout_url($preferenceId);
if ($checkoutUrl === null) {
    header('Location: /comprar.php?retomar=indisponivel', true, 302);
    exit;
}
header('Location: ' . $checkoutUrl, true, 302);
exit;