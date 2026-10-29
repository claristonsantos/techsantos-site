<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único, somente leitura e agregado (sem dados pessoais): vendas, leads, nutrição, fila social e Instagram.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$pdo = db();
$q = function (string $t, string $sql) use ($pdo) { echo "== $t\n"; try { foreach ($pdo->query($sql) as $r) echo "  " . implode(' | ', array_map(fn($k, $v) => "$k=$v", array_keys($r), $r)) . "\n"; } catch (Throwable $e) { echo "  ERRO " . $e->getMessage() . "\n"; } };
$q('pedidos 30d por curso/status', "SELECT c.slug, p.status, COUNT(*) n, ROUND(SUM(p.valor_centavos)/100,2) v FROM pedidos p JOIN cursos c ON c.id=p.curso_id WHERE p.criado_em >= NOW() - INTERVAL 30 DAY AND p.email NOT LIKE '%techsantos%' AND p.email NOT LIKE '%.invalid' GROUP BY c.slug, p.status");
$q('pedidos por dia desde 22/10', "SELECT DATE(criado_em) d, status, COUNT(*) n FROM pedidos WHERE criado_em >= '2026-10-22' AND email NOT LIKE '%.invalid' AND email NOT LIKE '%techsantos%' GROUP BY d, status ORDER BY d");
$q('pedidos lembretes', "SELECT SUM(lembrete_enviado) lembrete1, SUM(lembrete2_em IS NOT NULL) lembrete2 FROM pedidos WHERE criado_em >= '2026-10-22'");
$q('matriculas 30d por curso', "SELECT c.slug, COUNT(*) n FROM matriculas m JOIN cursos c ON c.id=m.curso_id WHERE m.criado_em >= NOW() - INTERVAL 30 DAY GROUP BY c.slug");
$q('matriculas total por curso', "SELECT c.slug, COUNT(*) n FROM matriculas m JOIN cursos c ON c.id=m.curso_id GROUP BY c.slug");
$q('leads aula gratis desde 01/10', "SELECT DATE(criado_em) d, COUNT(*) n, SUM(email IS NOT NULL AND email<>'') com_email FROM whatsapp_leads WHERE criado_em >= '2026-10-01' GROUP BY d");
$q('leads aula gratis total', "SELECT COUNT(*) n, SUM(email IS NOT NULL AND email<>'') com_email FROM whatsapp_leads");
$q('nutricao', "SELECT nutricao_etapa, nutricao_optout, COUNT(*) n FROM whatsapp_leads GROUP BY nutricao_etapa, nutricao_optout");
$q('pipeline leads', "SELECT status, COUNT(*) n FROM whatsapp_lead_pipeline GROUP BY status");
$q('leads aula particular desde 01/10', "SELECT status, COUNT(*) n, MIN(DATE(criado_em)) de, MAX(DATE(criado_em)) ate FROM aulas_particulares_leads WHERE criado_em >= '2026-10-01' GROUP BY status");
$q('social posts 22/10-agora', "SELECT canal, tipo, status, COUNT(*) n FROM social_posts WHERE agendado_para >= '2026-10-22' AND agendado_para <= NOW() GROUP BY canal, tipo, status ORDER BY canal, tipo");
$q('social erros recentes', "SELECT id, canal, tipo, agendado_para, LEFT(COALESCE(erro_msg,''),120) e FROM social_posts WHERE status='erro' AND agendado_para >= '2026-10-22' ORDER BY agendado_para");
$q('social agendados futuros', "SELECT canal, tipo, COUNT(*) n, MIN(DATE(agendado_para)) de, MAX(DATE(agendado_para)) ate FROM social_posts WHERE status='agendado' AND agendado_para > NOW() GROUP BY canal, tipo");
$q('cursos', "SELECT id, slug, ativo, preco_centavos FROM cursos ORDER BY id");
$q('carrosseis lote5', "SELECT id, canal, status, agendado_para, meta_post_id, LEFT(COALESCE(erro_msg,''),120) e FROM social_posts WHERE tipo='carousel' AND agendado_para >= '2026-10-22'");
$q('auto-reply 14d', "SELECT r.palavra_chave, COUNT(*) n FROM social_auto_reply_log l JOIN social_auto_reply_rules r ON r.id=l.rule_id WHERE l.criado_em >= NOW() - INTERVAL 14 DAY GROUP BY r.palavra_chave");
// Instagram
$get = function (string $path, array $p = []) { $p['access_token'] = META_IG_TOKEN; $u = meta_ig_graph_url($path) . '?' . http_build_query($p);
    $ch = curl_init($u); curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 20]); $r = curl_exec($ch); curl_close($ch); return json_decode((string)$r, true) ?: []; };
$acc = $get(META_IG_USER_ID, ['fields' => 'followers_count,media_count']);
echo "== IG conta\n  " . json_encode($acc) . "\n";
$m = $get(META_IG_USER_ID . '/media', ['fields' => 'id,media_type,media_product_type,timestamp,like_count,comments_count,caption', 'limit' => 25]);
echo "== IG ultimas midias (data | tipo | likes | coment | reach | views | saved | shares | watch_ms | legenda)\n";
foreach ($m['data'] ?? [] as $x) {
    $isReel = ($x['media_product_type'] ?? '') === 'REELS';
    $met = $isReel ? 'reach,views,saved,shares,ig_reels_avg_watch_time' : 'reach,views,saved,shares';
    $ins = $get($x['id'] . '/insights', ['metric' => $met]); $v = [];
    foreach ($ins['data'] ?? [] as $d) $v[$d['name']] = $d['values'][0]['value'] ?? '';
    echo '  ' . substr($x['timestamp'], 0, 10) . ' | ' . ($x['media_product_type'] ?? '') . '/' . $x['media_type'] . ' | ' . ($x['like_count'] ?? 0) . ' | ' . ($x['comments_count'] ?? 0)
        . ' | ' . ($v['reach'] ?? '-') . ' | ' . ($v['views'] ?? '-') . ' | ' . ($v['saved'] ?? '-') . ' | ' . ($v['shares'] ?? '-') . ' | ' . ($v['ig_reels_avg_watch_time'] ?? '-')
        . ' | ' . mb_substr(str_replace("\n", ' ', $x['caption'] ?? ''), 0, 45) . (isset($ins['error']) ? ' ERR ' . $ins['error']['message'] : '') . "\n";
}
