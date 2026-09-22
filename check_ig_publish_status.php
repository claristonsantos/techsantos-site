<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
echo "=== instagram posts since 2026-09-11, ordered by agendado_para ===\n";
$stmt = $pdo->query("SELECT id, tipo, status, agendado_para, meta_post_id, meta_container_id, LEFT(erro_msg,100) AS erro FROM social_posts WHERE canal='instagram' AND agendado_para >= '2026-09-11' ORDER BY agendado_para");
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
    echo "#{$r['id']} {$r['tipo']} {$r['status']} {$r['agendado_para']} meta_post={$r['meta_post_id']} container={$r['meta_container_id']} erro={$r['erro']}\n";
}
echo "\n=== status counts (all time, instagram) ===\n";
$stmt2 = $pdo->query("SELECT status, COUNT(*) c FROM social_posts WHERE canal='instagram' GROUP BY status");
foreach ($stmt2->fetchAll(PDO::FETCH_ASSOC) as $r) echo "{$r['status']}: {$r['c']}\n";
@unlink(__FILE__);
