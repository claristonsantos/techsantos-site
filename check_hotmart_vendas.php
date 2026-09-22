<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$stmt = $pdo->query("SELECT id, nome, email, valor_centavos, criado_em, atualizado_em, hotmart_transaction FROM pedidos WHERE hotmart_transaction IS NOT NULL ORDER BY criado_em");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "total vendas hotmart registradas: " . count($rows) . "\n\n";
foreach ($rows as $r) {
    echo "#{$r['id']} {$r['nome']} <{$r['email']}> R$" . number_format($r['valor_centavos']/100,2,',','.') . " criado={$r['criado_em']} tx={$r['hotmart_transaction']}\n";
}
@unlink(__FILE__);
