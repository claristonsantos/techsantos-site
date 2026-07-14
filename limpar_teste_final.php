<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$pdo->prepare("DELETE FROM pedidos WHERE email = 'teste-fluxo-final@techsantos.com.br'")->execute();
$pdo->prepare("DELETE FROM alunos WHERE email = 'teste-fluxo-final@techsantos.com.br'")->execute();

header('Content-Type: text/plain; charset=utf-8');
echo "Pedido e aluno de teste removidos.\n";

@unlink(__FILE__);
