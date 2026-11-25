<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único, somente leitura e agregado (sem dados pessoais): visão geral 30d vs 30d anteriores.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
set_time_limit(90);
$pdo = db();
$q = function (string $t, string $sql) use ($pdo) { echo "== $t\n"; try { foreach ($pdo->query($sql) as $r) echo "  " . implode(' | ', array_map(fn($k, $v) => "$k=$v", array_keys($r), $r)) . "\n"; } catch (Throwable $e) { echo "  ERRO " . $e->getMessage() . "\n"; } };
$f = "p.email NOT LIKE '%techsantos%' AND p.email NOT LIKE '%.invalid' AND p.email NOT LIKE '%claristonsantos%'";
$per = "CASE WHEN p.criado_em >= NOW() - INTERVAL 30 DAY THEN 'a_30d' WHEN p.criado_em >= NOW() - INTERVAL 60 DAY THEN 'b_30d_ant' ELSE 'c_antes' END";
$q('pedidos 60d por periodo/canal/curso/status', "SELECT $per per, CASE WHEN p.hotmart_transaction LIKE 'KW-%' THEN 'kiwify' WHEN p.hotmart_transaction IS NULL OR p.hotmart_transaction='' THEN 'site' ELSE 'hotmart' END canal, c.slug, COALESCE(p.oferta,'-') oferta, p.status, COUNT(*) n, ROUND(SUM(p.valor_centavos)/100,2) v FROM pedidos p JOIN cursos c ON c.id=p.curso_id WHERE p.criado_em >= NOW() - INTERVAL 60 DAY AND $f GROUP BY per, canal, c.slug, oferta, p.status ORDER BY per, canal");
$q('pedidos 7d por canal/status', "SELECT CASE WHEN p.hotmart_transaction LIKE 'KW-%' THEN 'kiwify' WHEN p.hotmart_transaction IS NULL OR p.hotmart_transaction='' THEN 'site' ELSE 'hotmart' END canal, c.slug, COALESCE(p.oferta,'-') oferta, p.status, COUNT(*) n, ROUND(SUM(p.valor_centavos)/100,2) v FROM pedidos p JOIN cursos c ON c.id=p.curso_id WHERE p.criado_em >= NOW() - INTERVAL 7 DAY AND $f GROUP BY canal, c.slug, oferta, p.status");
$q('precos app', "SELECT (SELECT COUNT(*) FROM precos_usuarios) u, (SELECT COUNT(*) FROM precos_notas) notas, (SELECT COUNT(*) FROM precos_itens) itens, (SELECT COUNT(*) FROM precos_lojas) lojas, (SELECT COUNT(*) FROM precos_falhas) falhas");
$q('precos falhas', "SELECT host, LEFT(motivo,80) m, criado_em FROM precos_falhas ORDER BY id DESC LIMIT 5");
$q('ultimos 5 pagos (data, canal, curso, valor)', "SELECT DATE(p.criado_em) d, CASE WHEN p.hotmart_transaction LIKE 'KW-%' THEN 'kiwify' WHEN p.hotmart_transaction IS NULL OR p.hotmart_transaction='' THEN 'site' ELSE 'hotmart' END canal, c.slug, ROUND(p.valor_centavos/100,2) v FROM pedidos p JOIN cursos c ON c.id=p.curso_id WHERE p.status='pago' AND $f ORDER BY p.id DESC LIMIT 5");
$q('pedidos internos/teste 30d', "SELECT COUNT(*) n FROM pedidos p WHERE p.criado_em >= NOW() - INTERVAL 30 DAY AND NOT ($f)");
$q('consultoria leads 60d', "SELECT IF(criado_em >= NOW() - INTERVAL 30 DAY,'a_30d','b_ant') per, COUNT(*) n, MAX(criado_em) ultimo FROM consultoria_leads WHERE criado_em >= NOW() - INTERVAL 60 DAY GROUP BY per");
$q('consultoria pipeline', "SELECT * FROM consultoria_lead_pipeline ORDER BY 1 DESC LIMIT 5");
$q('lista_espera reais', "SELECT produto, COUNT(*) n, MAX(criado_em) ultimo FROM lista_espera WHERE email NOT LIKE '%techsantos%' AND email NOT LIKE '%claristonsantos%' GROUP BY produto");
$q('pedidos BF pagos', "SELECT status, COUNT(*) n FROM pedidos p WHERE oferta='black-friday-2026' AND $f GROUP BY status");
$q('bf_lembretes total', "SELECT COUNT(*) n, SUM(whatsapp IS NOT NULL AND whatsapp<>'') com_whats, MAX(criado_em) ultimo FROM bf_lembretes WHERE email NOT LIKE '%techsantos%'");
$q('whatsapp_leads 30d / ant', "SELECT SUM(criado_em >= NOW() - INTERVAL 30 DAY) a30, SUM(criado_em < NOW() - INTERVAL 30 DAY AND criado_em >= NOW() - INTERVAL 60 DAY) ant30, COUNT(*) total FROM whatsapp_leads");
$q('aulas particulares leads 60d', "SELECT IF(criado_em >= NOW() - INTERVAL 30 DAY,'a_30d','b_ant') per, status, COUNT(*) n FROM aulas_particulares_leads WHERE criado_em >= NOW() - INTERVAL 60 DAY GROUP BY per, status");
$q('prevenda/fundador (tabelas com lista)', "SELECT table_name t, table_rows r FROM information_schema.tables WHERE table_schema = DATABASE() AND (table_name LIKE '%espera%' OR table_name LIKE '%waitlist%' OR table_name LIKE '%prevenda%' OR table_name LIKE '%fundador%' OR table_name LIKE '%painel%' OR table_name LIKE '%proposta%')");
$q('matriculas novas 30d / ant por curso', "SELECT c.slug, SUM(m.criado_em >= NOW() - INTERVAL 30 DAY) a30, SUM(m.criado_em < NOW() - INTERVAL 30 DAY AND m.criado_em >= NOW() - INTERVAL 60 DAY) ant30, COUNT(*) total FROM matriculas m JOIN cursos c ON c.id=m.curso_id GROUP BY c.slug");
$q('auto-reply 30d por plataforma/regra', "SELECT l.plataforma, COALESCE(r.palavra_chave,'(sem regra)') k, l.status, COUNT(*) n FROM social_auto_reply_log l LEFT JOIN social_auto_reply_rules r ON r.id=l.regra_id WHERE l.criado_em >= NOW() - INTERVAL 30 DAY GROUP BY l.plataforma, k, l.status");
$q('social posts 30d por canal/status', "SELECT canal, status, COUNT(*) n FROM social_posts WHERE agendado_para >= NOW() - INTERVAL 30 DAY AND agendado_para < NOW() GROUP BY canal, status");
$q('social posts futuros', "SELECT canal, COUNT(*) n, MIN(agendado_para) prox, MAX(agendado_para) ultimo FROM social_posts WHERE agendado_para >= NOW() AND status IN ('agendado','pendente') GROUP BY canal");
$q('social erros 7d', "SELECT canal, LEFT(COALESCE(erro_msg,''),90) e, COUNT(*) n FROM social_posts WHERE agendado_para >= NOW() - INTERVAL 7 DAY AND status NOT IN ('publicado','agendado') GROUP BY canal, e");

$get = function (string $url, array $p, string $tok) { $p['access_token'] = $tok; $ch = curl_init($url . '?' . http_build_query($p));
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 15]); $r = curl_exec($ch); curl_close($ch); return json_decode((string)$r, true) ?: []; };
$ig = fn(string $path, array $p = []) => $get(meta_ig_graph_url($path), $p, META_IG_TOKEN);
$acc = $ig(META_IG_USER_ID, ['fields' => 'followers_count,media_count']);
echo "== IG conta\n  " . json_encode($acc) . "\n";
echo "== IG blocos de 10 dias, mais antigo primeiro (reach | views | profile_views | accounts_engaged | website_clicks | follows)\n";
$fim = strtotime(gmdate('Y-m-d') . ' 03:00:00 UTC');
for ($b = 5; $b >= 0; $b--) {
    $until = $fim - $b * 10 * 86400; $since = $until - 10 * 86400;
    $r = $ig(META_IG_USER_ID . '/insights', ['metric' => 'reach,views,profile_views,accounts_engaged,website_clicks,follows_and_unfollows', 'metric_type' => 'total_value', 'period' => 'day', 'since' => $since, 'until' => $until]);
    $v = []; foreach ($r['data'] ?? [] as $d) $v[$d['name']] = $d['total_value']['value'] ?? ($d['total_value']['breakdowns'][0]['results'][0]['value'] ?? '?');
    echo '  ' . gmdate('m-d', $since) . '..' . gmdate('m-d', $until - 1) . ' | ' . implode(' | ', array_map(fn($k) => $v[$k] ?? '-', ['reach', 'views', 'profile_views', 'accounts_engaged', 'website_clicks', 'follows_and_unfollows'])) . (isset($r['error']) ? ' ERR ' . substr($r['error']['message'], 0, 80) : '') . "\n";
}
$m = $ig(META_IG_USER_ID . '/media', ['fields' => 'id,media_type,media_product_type,timestamp,like_count,comments_count,caption', 'limit' => 25]);
echo "== IG ultimas 25 midias (data UTC | tipo | likes | coment | reach | views | saved | shares | avg_watch_ms | legenda)\n";
foreach ($m['data'] ?? [] as $x) {
    $isReel = ($x['media_product_type'] ?? '') === 'REELS';
    $met = $isReel ? 'reach,views,saved,shares,ig_reels_avg_watch_time' : 'reach,views,saved,shares';
    $ins = $ig($x['id'] . '/insights', ['metric' => $met]); $v = [];
    foreach ($ins['data'] ?? [] as $d) $v[$d['name']] = $d['values'][0]['value'] ?? '';
    echo '  ' . substr($x['timestamp'], 0, 10) . ' | ' . ($x['media_product_type'] ?? '') . ' | ' . ($x['like_count'] ?? 0) . ' | ' . ($x['comments_count'] ?? 0)
        . ' | ' . ($v['reach'] ?? '-') . ' | ' . ($v['views'] ?? '-') . ' | ' . ($v['saved'] ?? '-') . ' | ' . ($v['shares'] ?? '-') . ' | ' . ($v['ig_reels_avg_watch_time'] ?? '-')
        . ' | ' . mb_substr(str_replace("\n", ' ', $x['caption'] ?? ''), 0, 45) . (isset($ins['error']) ? ' ERR ' . substr($ins['error']['message'], 0, 50) : '') . "\n";
}
$fb = fn(string $path, array $p = []) => $get('https://graph.facebook.com/v25.0/' . $path, $p, META_PAGE_TOKEN);
$vids = $fb(META_PAGE_ID . '/video_reels', ['fields' => 'id,created_time,description', 'limit' => 10]);
echo "== FB reels (data | plays | reach | avg_watch_ms | descr)\n";
foreach ($vids['data'] ?? [] as $x) {
    $ins = $fb($x['id'] . '/video_insights', ['metric' => 'blue_reels_play_count,post_impressions_unique,post_video_avg_time_watched']); $v = [];
    foreach ($ins['data'] ?? [] as $d) $v[$d['name']] = $d['values'][0]['value'] ?? '';
    echo '  ' . substr($x['created_time'] ?? '', 0, 10) . ' | ' . ($v['blue_reels_play_count'] ?? '-') . ' | ' . ($v['post_impressions_unique'] ?? '-') . ' | ' . ($v['post_video_avg_time_watched'] ?? '-')
        . ' | ' . mb_substr(str_replace("\n", ' ', $x['description'] ?? ''), 0, 40) . "\n";
}
if (isset($vids['error'])) echo "  ERR " . $vids['error']['message'] . "\n";
$pg = $fb(META_PAGE_ID, ['fields' => 'followers_count,fan_count']);
echo "== FB pagina\n  " . json_encode($pg) . "\n";
