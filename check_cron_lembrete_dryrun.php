<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$rows = $pdo->query(
    "SELECT p.id, p.email, p.status, p.lembrete_enviado, p.criado_em
     FROM pedidos p
     WHERE p.status = 'pendente'
       AND p.lembrete_enviado = 0
       AND p.criado_em <= NOW() - INTERVAL 2 HOUR
       AND p.criado_em >= NOW() - INTERVAL 7 DAY"
)->fetchAll();

header('Content-Type: text/plain; charset=utf-8');
echo "Pedidos que receberiam lembrete agora: " . count($rows) . "\n";
foreach ($rows as $r) {
    echo "id={$r['id']} email={$r['email']} criado_em={$r['criado_em']}\n";
}

@unlink(__FILE__);
