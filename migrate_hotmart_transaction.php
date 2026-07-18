<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$out = [];

$stmt = $pdo->query("SHOW COLUMNS FROM pedidos LIKE 'hotmart_transaction'");
if ($stmt->rowCount() === 0) {
    $pdo->exec("ALTER TABLE pedidos ADD COLUMN hotmart_transaction VARCHAR(60) NULL UNIQUE AFTER mercadopago_preference_id");
    $out[] = 'Coluna pedidos.hotmart_transaction criada.';
} else {
    $out[] = 'Coluna pedidos.hotmart_transaction já existia — nada a fazer.';
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
