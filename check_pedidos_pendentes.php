<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$rows = $pdo->query("SELECT id, nome, email, status, criado_em, TIMESTAMPDIFF(HOUR, criado_em, NOW()) AS horas_atras FROM pedidos WHERE status = 'pendente' ORDER BY criado_em DESC")->fetchAll();

header('Content-Type: text/plain; charset=utf-8');
if (!$rows) {
    echo "Nenhum pedido pendente.\n";
}
foreach ($rows as $r) {
    echo "id={$r['id']} email={$r['email']} criado_em={$r['criado_em']} ({$r['horas_atras']}h atrás)\n";
}

@unlink(__FILE__);
