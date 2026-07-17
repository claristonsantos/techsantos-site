<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$rows = $pdo->query("SELECT id, nome, email, status, valor_centavos, criado_em FROM pedidos WHERE criado_em >= NOW() - INTERVAL 10 DAY ORDER BY criado_em DESC")->fetchAll();

header('Content-Type: text/plain; charset=utf-8');
if (!$rows) {
    echo "Nenhum pedido nos ultimos 10 dias.\n";
}
foreach ($rows as $r) {
    echo "id={$r['id']} status={$r['status']} valor=R$" . number_format($r['valor_centavos']/100,2,',','.') . " criado_em={$r['criado_em']} email={$r['email']}\n";
}

@unlink(__FILE__);
