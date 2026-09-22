<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();

echo "=== PEDIDOS (compras do curso) ===\n";
$stmt = $pdo->query("SELECT status, COUNT(*) c, SUM(valor_centavos)/100 total FROM pedidos GROUP BY status");
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) echo "{$r['status']}: {$r['c']} pedidos, R$ " . number_format((float)$r['total'],2,',','.') . "\n";

echo "\n=== PEDIDOS por mes (ultimos 6 meses) ===\n";
$stmt = $pdo->query("SELECT DATE_FORMAT(criado_em,'%Y-%m') mes, status, COUNT(*) c FROM pedidos WHERE criado_em >= DATE_SUB(NOW(), INTERVAL 6 MONTH) GROUP BY mes, status ORDER BY mes");
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) echo "{$r['mes']} {$r['status']}: {$r['c']}\n";

echo "\n=== ALUNOS (total matriculados) ===\n";
$stmt = $pdo->query("SELECT COUNT(*) c FROM alunos");
echo "total: " . $stmt->fetchColumn() . "\n";

echo "\n=== WHATSAPP_LEADS (aula gratis) por mes ===\n";
$stmt = $pdo->query("SELECT DATE_FORMAT(criado_em,'%Y-%m') mes, COUNT(*) c FROM whatsapp_leads WHERE criado_em >= DATE_SUB(NOW(), INTERVAL 6 MONTH) GROUP BY mes ORDER BY mes");
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) echo "{$r['mes']}: {$r['c']}\n";

echo "\n=== PIPELINE STATUS (leads whatsapp) ===\n";
$stmt = $pdo->query("SELECT COALESCE(p.status,'novo') st, COUNT(*) c FROM whatsapp_leads w LEFT JOIN whatsapp_lead_pipeline p ON p.lead_id=w.id GROUP BY st");
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) echo "{$r['st']}: {$r['c']}\n";

echo "\n=== AULAS PARTICULARES por status ===\n";
$stmt = $pdo->query("SELECT status, COUNT(*) c, SUM(valor_centavos)/100 total FROM aulas_particulares_leads GROUP BY status");
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) echo "{$r['status']}: {$r['c']}, R$ " . number_format((float)$r['total'],2,',','.') . "\n";

echo "\n=== ORIGEM DOS PEDIDOS PAGOS (utm_source) ===\n";
$stmt = $pdo->query("SELECT COALESCE(NULLIF(TRIM(origem),''),'direto') origem, COUNT(*) c FROM pedidos WHERE status='pago' GROUP BY origem ORDER BY c DESC LIMIT 15");
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) echo "{$r['origem']}: {$r['c']}\n";

echo "\n=== SOCIAL_POSTS resumo ===\n";
$stmt = $pdo->query("SELECT canal, tipo, status, COUNT(*) c FROM social_posts GROUP BY canal, tipo, status ORDER BY canal, tipo");
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) echo "{$r['canal']}/{$r['tipo']} {$r['status']}: {$r['c']}\n";

echo "\n=== AVALIACOES (prova social interna) ===\n";
$stmt = $pdo->query("SHOW TABLES LIKE 'avaliacoes'");
if ($stmt->fetchColumn()) {
    $stmt2 = $pdo->query("SELECT COUNT(*) c, AVG(nota) media FROM avaliacoes");
    $r = $stmt2->fetch(PDO::FETCH_ASSOC);
    echo "total: {$r['c']}, media: " . round((float)$r['media'],2) . "\n";
} else {
    echo "tabela nao existe\n";
}
@unlink(__FILE__);
