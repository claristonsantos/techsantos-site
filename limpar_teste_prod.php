<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$stmt = $pdo->prepare("DELETE FROM pedidos WHERE email = 'teste-verificacao-producao@techsantos.com.br'");
$stmt->execute();

header('Content-Type: text/plain; charset=utf-8');
echo "{$stmt->rowCount()} pedido(s) de teste removido(s).\n";

@unlink(__FILE__);
