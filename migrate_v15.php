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

$cols = $pdo->query("SHOW COLUMNS FROM pedidos")->fetchAll(PDO::FETCH_COLUMN);

if (!in_array('ga4_client_id', $cols, true)) {
    $pdo->exec("ALTER TABLE pedidos ADD COLUMN ga4_client_id VARCHAR(40) NULL AFTER hotmart_transaction");
    $out[] = 'Coluna pedidos.ga4_client_id criada.';
} else {
    $out[] = 'Coluna pedidos.ga4_client_id já existia.';
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
