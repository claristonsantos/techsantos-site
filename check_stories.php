<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$stmt = $pdo->query("SELECT id, canal, tipo, status, agendado_para, imagem_url, LEFT(legenda,50) AS legenda_ini FROM social_posts WHERE tipo='story' AND agendado_para >= CURDATE() ORDER BY agendado_para");
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
    echo "#{$r['id']} {$r['canal']} {$r['status']} {$r['agendado_para']} " . basename((string)$r['imagem_url']) . " | {$r['legenda_ini']}\n";
}
echo "--- all story files ever used (imagem_url) ---\n";
$stmt2 = $pdo->query("SELECT DISTINCT imagem_url FROM social_posts WHERE tipo='story' ORDER BY imagem_url");
foreach ($stmt2->fetchAll(PDO::FETCH_COLUMN) as $u) echo basename((string)$u) . "\n";
@unlink(__FILE__);
