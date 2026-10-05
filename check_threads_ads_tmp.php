<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$e = null;
$r = meta_http_get(threads_graph_url('me/threads'), ['fields' => 'id,media_type,timestamp,permalink,text', 'limit' => 15, 'access_token' => threads_cfg('META_THREADS_TOKEN')], $e);
echo "=== posts no Threads ===\n";
if ($r === null) echo "erro: {$e}\n";
foreach ($r['data'] ?? [] as $p) echo "{$p['timestamp']} {$p['media_type']} {$p['id']} | " . mb_substr(str_replace("\n", ' ', $p['text'] ?? ''), 0, 50) . "\n";
echo "=== insights Threads (se permitido) ===\n";
foreach (array_slice($r['data'] ?? [], 0, 6) as $p) {
    $i = meta_http_get(threads_graph_url($p['id'] . '/insights'), ['metric' => 'views,likes,replies,reposts,quotes', 'access_token' => threads_cfg('META_THREADS_TOKEN')], $e);
    echo $p['id'] . ': ' . ($i === null ? "sem acesso ({$e})" : json_encode(array_map(fn($d) => [$d['name'] => $d['values'][0]['value'] ?? ($d['total_value']['value'] ?? null)], $i['data'] ?? []))) . "\n";
}
@unlink(__FILE__);
