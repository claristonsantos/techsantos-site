<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
foreach ($pdo->query("SELECT id, canal, status, agendado_para, meta_post_id, imagem_url FROM social_posts WHERE imagem_url LIKE '%aula-trecho-%' AND agendado_para >= '2026-10-12' ORDER BY agendado_para, canal") as $r) {
    echo "#{$r['id']} {$r['canal']} {$r['status']} {$r['agendado_para']} {$r['meta_post_id']} " . basename((string)$r['imagem_url']) . "\n";
}
// Reels agendados na Página do Facebook (para achar uploads órfãos sem linha no banco)
$url = 'https://graph.facebook.com/v21.0/' . META_PAGE_ID . '/scheduled_posts?fields=id,created_time,message&limit=50&access_token=' . urlencode(META_PAGE_TOKEN);
$res = @file_get_contents($url);
echo "--- scheduled_posts da página ---\n";
if ($res === false) { echo "falha ao consultar\n"; } else {
    $j = json_decode($res, true);
    if (isset($j['error'])) echo "erro: " . ($j['error']['message'] ?? '') . "\n";
    foreach ($j['data'] ?? [] as $p) echo $p['id'] . ' | ' . mb_substr(str_replace("\n", ' ', $p['message'] ?? ''), 0, 60) . "\n";
}
$url2 = 'https://graph.facebook.com/v21.0/' . META_PAGE_ID . '/videos?fields=id,created_time,scheduled_publish_time,published,description&limit=40&access_token=' . urlencode(META_PAGE_TOKEN);
$res2 = @file_get_contents($url2);
echo "--- vídeos da página (não publicados) ---\n";
if ($res2 !== false) { $j2 = json_decode($res2, true); if (isset($j2['error'])) echo "erro: " . ($j2['error']['message'] ?? '') . "\n";
 foreach ($j2['data'] ?? [] as $v) { if (!empty($v['published'])) continue; echo $v['id'] . ' | sched=' . ($v['scheduled_publish_time'] ?? '-') . ' | ' . mb_substr(str_replace("\n", ' ', $v['description'] ?? ''), 0, 50) . "\n"; } }
@unlink(__FILE__);
