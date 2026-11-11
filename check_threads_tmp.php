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
$pdo = db();
@unlink(__FILE__);

// Carrosséis presos em 'processando' sem nenhuma lâmina: o cron morreu no meio da
// criação das lâminas (ver social_publish_cron.php). Viram 'erro' com o motivo.
$n = $pdo->exec("UPDATE social_posts SET status = 'erro', erro_msg = 'carrossel travado: o cron era interrompido antes de salvar as lâminas (corrigido em 11/11/2026)'"
    . " WHERE tipo = 'carousel' AND status = 'processando' AND meta_container_id IS NULL AND carousel_children IS NULL AND agendado_para < NOW() - INTERVAL 1 DAY");
echo "carrosséis travados marcados como erro: $n\n";

echo "\nthreads ainda em processando:\n";
foreach ($pdo->query("SELECT id, tipo, agendado_para, meta_container_id FROM social_posts WHERE canal='threads' AND status='processando'") as $r) {
    echo "  #{$r['id']} {$r['tipo']} {$r['agendado_para']} {$r['meta_container_id']}\n";
}

foreach (['video_reels' => 'id,created_time,description', 'published_posts' => 'id,created_time,message'] as $edge => $fields) {
    $e = null;
    $d = meta_graph_get(META_PAGE_ID . '/' . $edge, ['fields' => $fields, 'limit' => 12, 'access_token' => META_PAGE_TOKEN], $e);
    echo "\nFacebook /$edge:\n";
    if ($d === null) { echo "  ERRO $e\n"; continue; }
    foreach ($d['data'] ?? [] as $x) {
        echo '  ' . substr((string)$x['created_time'], 0, 16) . ' ' . mb_substr(strtok((string)($x['description'] ?? $x['message'] ?? ''), "\n"), 0, 60) . "\n";
    }
}
echo "\ndone\n";
