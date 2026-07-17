<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/pagbank.php';
require_once __DIR__ . '/pedidos.php';

$rawPayload = file_get_contents('php://input') ?: '';
$receivedToken = $_SERVER['HTTP_X_AUTHENTICITY_TOKEN'] ?? '';

if ($receivedToken === '' || !pagbank_verify_signature($rawPayload, $receivedToken)) {
    http_response_code(401);
    exit('invalid signature');
}

$data = json_decode($rawPayload, true);
if (!is_array($data)) {
    http_response_code(400);
    exit('bad payload');
}

$referenceId = (string)($data['reference_id'] ?? '');
if (!preg_match('/^PEDIDO-(\d+)$/', $referenceId, $m)) {
    http_response_code(200); // acknowledge, nothing we recognize
    exit('ignored');
}
$pedidoId = (int)$m[1];

$paid = false;
foreach ($data['charges'] ?? [] as $charge) {
    if (($charge['status'] ?? '') === 'PAID') {
        $paid = true;
        break;
    }
}

if (!$paid) {
    http_response_code(200);
    exit('no paid charge yet');
}

marcar_pedido_pago($pedidoId);

http_response_code(200);
echo 'ok';
