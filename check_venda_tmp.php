<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

header('Content-Type: text/plain; charset=utf-8');
$stmt = db()->query(
    "SELECT id, nome, email, status, mercadopago_preference_id, hotmart_transaction, criado_em, atualizado_em
     FROM pedidos
     WHERE status = 'pago'
     ORDER BY id DESC LIMIT 5"
);
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    echo implode(' | ', $row) . "\n";
}
