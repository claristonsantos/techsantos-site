<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$pdo->prepare("DELETE FROM pedidos WHERE hotmart_transaction = 'HP16015479281022'")->execute();
$pdo->prepare("DELETE FROM alunos WHERE email = 'testeComprador271101postman15@example.com'")->execute();

header('Content-Type: text/plain; charset=utf-8');
echo "pedido e aluno de teste da Hotmart removidos\n";

@unlink(__FILE__);
