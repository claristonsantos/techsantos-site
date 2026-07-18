<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$stmt = db()->query(
    "SELECT id, nome, email, status, hotmart_transaction, aluno_id, criado_em
     FROM pedidos
     WHERE hotmart_transaction IS NOT NULL
     ORDER BY id DESC LIMIT 5"
);

header('Content-Type: text/plain; charset=utf-8');
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (!$rows) {
    echo "nenhum pedido com hotmart_transaction ainda\n";
}
foreach ($rows as $row) {
    echo implode(' | ', $row) . "\n";
}
