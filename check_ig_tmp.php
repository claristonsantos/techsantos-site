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
set_time_limit(120);

function ig(string $path, array $p): array
{
    $p['access_token'] = META_IG_TOKEN;
    $err = null;
    $r = meta_http_get(meta_ig_graph_url($path), $p, $err);
    return $r ?? ['erro' => (string)$err];
}

$me = ig('me', ['fields' => 'username,followers_count,media_count']);
echo 'conta: ' . json_encode($me, JSON_UNESCAPED_UNICODE) . "\n";
if (isset($me['erro'])) { @unlink(__FILE__); exit; }

$agora = time();
$janelas = ['30d' => [$agora - 30 * 86400, $agora], '30d anteriores' => [$agora - 60 * 86400, $agora - 30 * 86400]];
foreach (['reach' => [], 'follower_count' => [], 'profile_views' => ['metric_type' => 'total_value'], 'accounts_engaged' => ['metric_type' => 'total_value'], 'views' => ['metric_type' => 'total_value']] as $met => $extra) {
    foreach ($janelas as $rot => [$a, $b]) {
        $r = ig('me/insights', ['metric' => $met, 'period' => 'day', 'since' => $a, 'until' => $b] + $extra);
        if (isset($r['erro'])) { echo "$met $rot: ERRO {$r['erro']}\n"; continue; }
        $d = $r['data'][0] ?? [];
        if (isset($d['total_value'])) { echo "$met $rot: {$d['total_value']['value']}\n"; continue; }
        $vals = array_column($d['values'] ?? [], 'value');
        echo "$met $rot: soma=" . array_sum($vals) . ' dias=' . count($vals) . ' ultimos10=' . implode(',', array_slice($vals, -10)) . "\n";
    }
}

echo "\nposts desde 10/10:\n";
$media = ig('me/media', ['fields' => 'id,media_product_type,timestamp,caption,like_count,comments_count', 'limit' => 40]);
foreach ($media['data'] ?? [] as $m) {
    if ($m['timestamp'] < '2026-10-10') continue;
    $reel = ($m['media_product_type'] ?? '') === 'REELS';
    $ins = ig($m['id'] . '/insights', ['metric' => 'reach,views,saved,shares,total_interactions' . ($reel ? ',ig_reels_avg_watch_time' : '')]);
    $v = [];
    foreach ($ins['data'] ?? [] as $x) $v[$x['name']] = $x['values'][0]['value'] ?? null;
    if (isset($v['ig_reels_avg_watch_time'])) $v['ig_reels_avg_watch_time'] = round($v['ig_reels_avg_watch_time'] / 1000, 1) . 's';
    $cap = mb_substr(strtok((string)($m['caption'] ?? ''), "\n"), 0, 55);
    echo '  ' . substr($m['timestamp'], 0, 10) . " {$m['media_product_type']} likes={$m['like_count']} com={$m['comments_count']} " . ($v ? json_encode($v) : json_encode($ins)) . " | $cap\n";
}

$pdo = db();
echo "\nthreads processando/pendentes:\n";
foreach ($pdo->query("SELECT id, tipo, status, agendado_para, meta_container_id, LEFT(erro_msg,120) erro FROM social_posts WHERE canal='threads' AND status IN ('processando','pendente') ORDER BY agendado_para") as $r) {
    echo '  ' . implode(' | ', array_map(static fn($v) => $v ?? 'NULL', $r)) . "\n";
}
echo "\ninstagram pendentes antigos:\n";
foreach ($pdo->query("SELECT id, tipo, status, agendado_para, LEFT(erro_msg,120) erro FROM social_posts WHERE canal='instagram' AND status IN ('processando','pendente')") as $r) {
    echo '  ' . implode(' | ', array_map(static fn($v) => $v ?? 'NULL', $r)) . "\n";
}
echo "\ndone\n";
@unlink(__FILE__);
