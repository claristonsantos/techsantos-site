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

$pedido = $pdo->query("SELECT * FROM pedidos WHERE email = 'teste-fluxo-final@techsantos.com.br'")->fetch();
echo "=== Pedido ===\n";
echo $pedido ? json_encode($pedido, JSON_UNESCAPED_UNICODE) . "\n" : "não encontrado\n";

$aluno = $pdo->query("SELECT * FROM alunos WHERE email = 'teste-fluxo-final@techsantos.com.br'")->fetch();
echo "\n=== Aluno ===\n";
if ($aluno) {
    unset($aluno['senha_hash']);
    echo json_encode($aluno, JSON_UNESCAPED_UNICODE) . "\n";
} else {
    echo "NÃO encontrado\n";
}

@unlink(__FILE__);
