<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

header('Content-Type: text/plain; charset=utf-8');
$stmt = db()->prepare("DELETE FROM pedidos WHERE email = ?");
$stmt->execute(['teste.diagnostico@example.com']);
echo "pedidos de teste removidos: " . $stmt->rowCount() . "\n";

@unlink(__FILE__);
