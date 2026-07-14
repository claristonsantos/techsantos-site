<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$pedidos = $pdo->query('SELECT id, nome, email, status, valor_centavos, criado_em FROM pedidos ORDER BY id')->fetchAll();
$alunos = $pdo->query('SELECT id, nome, email, ativo, criado_em FROM alunos ORDER BY id')->fetchAll();

header('Content-Type: text/plain; charset=utf-8');
echo "=== Pedidos (" . count($pedidos) . ") ===\n";
foreach ($pedidos as $p) {
    echo "#{$p['id']} [{$p['status']}] {$p['nome']} <{$p['email']}> R$ " . number_format($p['valor_centavos'] / 100, 2, ',', '.') . " em {$p['criado_em']}\n";
}

echo "\n=== Alunos (" . count($alunos) . ") ===\n";
foreach ($alunos as $a) {
    echo "#{$a['id']} {$a['nome']} <{$a['email']}> " . ($a['ativo'] ? 'ativo' : 'inativo') . " desde {$a['criado_em']}\n";
}

@unlink(__FILE__);
