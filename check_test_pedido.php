<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$stmt = $pdo->prepare("SELECT id, status, valor_centavos, criado_em FROM pedidos WHERE email = ? ORDER BY id DESC");
$stmt->execute(['teste-pixel-meta@techsantos.com.br']);
$rows = $stmt->fetchAll();

header('Content-Type: text/plain; charset=utf-8');
foreach ($rows as $r) {
    echo "id={$r['id']} status={$r['status']} valor_centavos={$r['valor_centavos']} criado_em={$r['criado_em']}\n";
}

@unlink(__FILE__);
