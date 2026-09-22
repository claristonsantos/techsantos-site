<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$stmt = $pdo->query("SELECT id, status, agendado_para, imagem_url, LEFT(legenda,60) legenda FROM social_posts WHERE tipo='story' AND agendado_para >= CURDATE() ORDER BY agendado_para");
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
    echo "#{$r['id']} {$r['status']} {$r['agendado_para']} " . basename((string)$r['imagem_url']) . " | {$r['legenda']}\n";
}
@unlink(__FILE__);
