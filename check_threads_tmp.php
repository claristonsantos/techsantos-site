<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/meta_social.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('forbidden');
}
header('Content-Type: text/plain; charset=utf-8');
set_time_limit(300);
$pdo = db();

echo 'max_execution_time web: ' . ini_get('max_execution_time') . "\n";
$t = microtime(true);
$fb = $pdo->query("SELECT id, agendado_para, meta_post_id FROM social_posts WHERE canal = 'facebook' AND status = 'agendado_meta' AND meta_post_id IS NOT NULL AND agendado_para <= NOW()")->fetchAll();
echo 'fb agendado_meta vencidos: ' . count($fb) . "\n";
foreach ($fb as $p) {
    $t0 = microtime(true);
    $e = null;
    $d = meta_graph_get($p['meta_post_id'], ['fields' => 'is_published', 'access_token' => META_PAGE_TOKEN], $e);
    echo "  #{$p['id']} {$p['agendado_para']} " . ($d ? json_encode($d) : "ERRO $e") . ' ' . round(microtime(true) - $t0, 1) . "s\n";
}
$ig = $pdo->query("SELECT id, meta_container_id FROM social_posts WHERE canal = 'instagram' AND status = 'processando' AND meta_container_id IS NOT NULL")->fetchAll();
echo 'ig processando com container: ' . count($ig) . "\n";
foreach ($ig as $p) {
    $t0 = microtime(true);
    $e = null;
    $s = meta_get_instagram_container_status($p['meta_container_id'], $e);
    echo "  #{$p['id']} " . ($s ?? "ERRO $e") . ' ' . round(microtime(true) - $t0, 1) . "s\n";
}
echo 'total ' . round(microtime(true) - $t, 1) . "s\n";
// log do cron, se existir
foreach (glob(__DIR__ . '/../*.log') ?: [] as $f) echo basename($f) . ' ' . date('Y-m-d H:i', filemtime($f)) . "\n";
foreach (glob(__DIR__ . '/../logs/*') ?: [] as $f) echo 'logs/' . basename($f) . ' ' . date('Y-m-d H:i', filemtime($f)) . "\n";
echo "\ndone\n";
@unlink(__FILE__);
