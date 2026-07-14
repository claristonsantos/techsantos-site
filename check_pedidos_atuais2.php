<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();

header('Content-Type: text/plain; charset=utf-8');

try {
    $pedidos = $pdo->query('SELECT * FROM pedidos ORDER BY id')->fetchAll();
    echo "=== Pedidos (" . count($pedidos) . ") ===\n";
    foreach ($pedidos as $p) {
        echo json_encode($p, JSON_UNESCAPED_UNICODE) . "\n";
    }
} catch (Throwable $e) {
    echo "ERRO pedidos: " . $e->getMessage() . "\n";
}

echo "\n";

try {
    $alunos = $pdo->query('SELECT * FROM alunos ORDER BY id')->fetchAll();
    echo "=== Alunos (" . count($alunos) . ") ===\n";
    foreach ($alunos as $a) {
        unset($a['senha_hash']);
        echo json_encode($a, JSON_UNESCAPED_UNICODE) . "\n";
    }
} catch (Throwable $e) {
    echo "ERRO alunos: " . $e->getMessage() . "\n";
}

@unlink(__FILE__);
