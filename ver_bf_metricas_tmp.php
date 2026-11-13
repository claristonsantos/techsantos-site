<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único, somente leitura e agregado (sem dados pessoais): Black Friday (pedidos, lembretes, comentários) + Instagram/Facebook.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
set_time_limit(60);
$pdo = db();
$q = function (string $t, string $sql) use ($pdo) { echo "== $t\n"; try { foreach ($pdo->query($sql) as $r) echo "  " . implode(' | ', array_map(fn($k, $v) => "$k=$v", array_keys($r), $r)) . "\n"; } catch (Throwable $e) { echo "  ERRO " . $e->getMessage() . "\n"; } };
$filtro = "p.email NOT LIKE '%techsantos%' AND p.email NOT LIKE '%.invalid' AND p.email NOT LIKE '%claristonsantos%'";
$q('pedidos desde 12/11 por oferta/status', "SELECT COALESCE(p.oferta,'-') oferta, c.slug, p.status, COUNT(*) n, ROUND(SUM(p.valor_centavos)/100,2) v FROM pedidos p JOIN cursos c ON c.id=p.curso_id WHERE p.criado_em >= '2026-11-12' AND $filtro GROUP BY oferta, c.slug, p.status");
$q('pedidos por hora desde 12/11 (UTC)', "SELECT DATE_FORMAT(p.criado_em,'%m-%d %H') h, p.status, COUNT(*) n FROM pedidos p WHERE p.criado_em >= '2026-11-12' AND $filtro GROUP BY h, p.status ORDER BY h");
$q('pedidos internos/teste desde 12/11', "SELECT COUNT(*) n FROM pedidos p WHERE p.criado_em >= '2026-11-12' AND NOT ($filtro)");
$q('bf_lembretes por origem/dia', "SELECT DATE(criado_em) d, COALESCE(origem,'-') o, COUNT(*) n, SUM(whatsapp IS NOT NULL AND whatsapp<>'') com_whats FROM bf_lembretes WHERE email NOT LIKE '%techsantos%' GROUP BY d, o ORDER BY d");
$q('leads aula gratis desde 10/11', "SELECT DATE(criado_em) d, COUNT(*) n FROM whatsapp_leads WHERE criado_em >= '2026-11-10' GROUP BY d");
$q('leads aula particular desde 10/11', "SELECT DATE(criado_em) d, status, COUNT(*) n FROM aulas_particulares_leads WHERE criado_em >= '2026-11-10' GROUP BY d, status");
$q('auto-reply desde 12/11 por regra', "SELECT l.plataforma, COALESCE(r.palavra_chave,'(sem regra)') k, l.status, COUNT(*) n FROM social_auto_reply_log l LEFT JOIN social_auto_reply_rules r ON r.id=l.regra_id WHERE l.criado_em >= '2026-11-12' GROUP BY l.plataforma, k, l.status");
$q('social posts 12-13/11', "SELECT id, canal, tipo, status, agendado_para, LEFT(COALESCE(meta_post_id,''),40) mid, LEFT(COALESCE(erro_msg,''),80) e FROM social_posts WHERE agendado_para >= '2026-11-12' AND agendado_para < '2026-11-14' ORDER BY agendado_para");

$get = function (string $url, array $p, string $tok) { $p['access_token'] = $tok; $ch = curl_init($url . '?' . http_build_query($p));
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 15]); $r = curl_exec($ch); curl_close($ch); return json_decode((string)$r, true) ?: []; };
$ig = fn(string $path, array $p = []) => $get(meta_ig_graph_url($path), $p, META_IG_TOKEN);

$acc = $ig(META_IG_USER_ID, ['fields' => 'followers_count,media_count']);
echo "== IG conta\n  " . json_encode($acc) . "\n";
echo "== IG conta por dia (reach | views | profile_views | accounts_engaged | website_clicks | follows)\n";
for ($i = 7; $i >= 1; $i--) {
    $since = strtotime("2026-11-14 03:00:00 UTC -$i day"); $until = $since + 86400;
    $r = $ig(META_IG_USER_ID . '/insights', ['metric' => 'reach,views,profile_views,accounts_engaged,website_clicks,follows_and_unfollows', 'metric_type' => 'total_value', 'period' => 'day', 'since' => $since, 'until' => $until]);
    $v = []; foreach ($r['data'] ?? [] as $d) $v[$d['name']] = $d['total_value']['value'] ?? ($d['total_value']['breakdowns'][0]['results'][0]['value'] ?? '?');
    echo '  ' . gmdate('m-d', $since - 10800 + 86400 - 1) . ' | ' . implode(' | ', array_map(fn($k) => $v[$k] ?? '-', ['reach', 'views', 'profile_views', 'accounts_engaged', 'website_clicks', 'follows_and_unfollows'])) . (isset($r['error']) ? ' ERR ' . $r['error']['message'] : '') . "\n";
}
$m = $ig(META_IG_USER_ID . '/media', ['fields' => 'id,media_type,media_product_type,timestamp,like_count,comments_count,caption,permalink', 'limit' => 14]);
echo "== IG ultimas midias (data UTC | tipo | likes | coment | reach | views | saved | shares | watch_ms | skip% | total_watch_ms | legenda)\n";
foreach ($m['data'] ?? [] as $x) {
    $isReel = ($x['media_product_type'] ?? '') === 'REELS';
    $met = $isReel ? 'reach,views,saved,shares,ig_reels_avg_watch_time,ig_reels_video_view_total_time' : 'reach,views,saved,shares,profile_visits,follows';
    $ins = $ig($x['id'] . '/insights', ['metric' => $met]); $v = [];
    foreach ($ins['data'] ?? [] as $d) $v[$d['name']] = $d['values'][0]['value'] ?? '';
    $skip = '-';
    if ($isReel) { $s = $ig($x['id'] . '/insights', ['metric' => 'reels_skip_rate']); $skip = $s['data'][0]['values'][0]['value'] ?? ('?' . substr($s['error']['message'] ?? '', 0, 30)); }
    echo '  ' . substr($x['timestamp'], 0, 16) . ' | ' . ($x['media_product_type'] ?? '') . ' | ' . ($x['like_count'] ?? 0) . ' | ' . ($x['comments_count'] ?? 0)
        . ' | ' . ($v['reach'] ?? '-') . ' | ' . ($v['views'] ?? '-') . ' | ' . ($v['saved'] ?? '-') . ' | ' . ($v['shares'] ?? '-') . ' | ' . ($v['ig_reels_avg_watch_time'] ?? '-')
        . ' | ' . $skip . ' | ' . ($v['ig_reels_video_view_total_time'] ?? ($v['profile_visits'] ?? '-'))
        . ' | ' . mb_substr(str_replace("\n", ' ', $x['caption'] ?? ''), 0, 50) . (isset($ins['error']) ? ' ERR ' . substr($ins['error']['message'], 0, 60) : '') . "\n";
}
// Facebook: últimos reels/vídeos da página
$fb = fn(string $path, array $p = []) => $get('https://graph.facebook.com/v25.0/' . $path, $p, META_PAGE_TOKEN);
$vids = $fb(META_PAGE_ID . '/video_reels', ['fields' => 'id,created_time,description', 'limit' => 6]);
echo "== FB reels (data | plays | reach | avg_watch_ms | descr)\n";
foreach ($vids['data'] ?? [] as $x) {
    $ins = $fb($x['id'] . '/video_insights', ['metric' => 'blue_reels_play_count,post_impressions_unique,post_video_avg_time_watched']); $v = [];
    foreach ($ins['data'] ?? [] as $d) $v[$d['name']] = $d['values'][0]['value'] ?? '';
    echo '  ' . substr($x['created_time'] ?? '', 0, 16) . ' | ' . ($v['blue_reels_play_count'] ?? '-') . ' | ' . ($v['post_impressions_unique'] ?? '-') . ' | ' . ($v['post_video_avg_time_watched'] ?? '-')
        . ' | ' . mb_substr(str_replace("\n", ' ', $x['description'] ?? ''), 0, 45) . (isset($ins['error']) ? ' ERR ' . substr($ins['error']['message'], 0, 60) : '') . "\n";
}
if (isset($vids['error'])) echo "  ERR " . $vids['error']['message'] . "\n";
