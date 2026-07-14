<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$stmt = $pdo->prepare("SELECT * FROM pedidos WHERE email = ?");
$stmt->execute(['teste-fluxo-final@techsantos.com.br']);

header('Content-Type: text/plain; charset=utf-8');
foreach ($stmt->fetchAll() as $row) {
    echo json_encode($row, JSON_UNESCAPED_UNICODE) . "\n";
}

@unlink(__FILE__);
