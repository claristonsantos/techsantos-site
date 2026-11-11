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
$pdo = db();

$tok = threads_cfg('META_THREADS_TOKEN');
echo 'token presente: ' . ($tok !== '' ? 'sim (' . strlen($tok) . ' chars)' : 'NAO') . "\n";
$err = null;
$me = meta_threads_me($tok, $err);
echo 'me: ' . ($me ? json_encode($me) : "ERRO {$err}") . "\n";

echo "\nlinhas travadas:\n";
$rows = $pdo->query("SELECT id, tipo, midia_tipo, agendado_para, meta_container_id, carousel_children, carousel_urls, imagem_url FROM social_posts WHERE canal='threads' AND status='processando' ORDER BY agendado_para")->fetchAll();
foreach ($rows as $r) {
    $st = '';
    if ($r['meta_container_id']) {
        $e = null;
        $res = meta_http_get(threads_graph_url($r['meta_container_id']), ['fields' => 'status,error_message', 'access_token' => $tok], $e);
        $st = $res ? json_encode($res) : "ERRO $e";
    }
    $urls = json_decode((string)$r['carousel_urls'], true);
    echo "  #{$r['id']} {$r['tipo']}/{$r['midia_tipo']} {$r['agendado_para']} container=" . ($r['meta_container_id'] ?? 'NULL')
        . ' children=' . ($r['carousel_children'] ?? 'NULL') . ' urls=' . (is_array($urls) ? count($urls) . ' ex: ' . ($urls[0] ?? '') : 'NULL')
        . " status=$st\n";
}

// Teste real de criação de lâmina (só cria o container, não publica nada)
$c = $pdo->query("SELECT carousel_urls FROM social_posts WHERE canal='threads' AND tipo='carousel' AND status='processando' ORDER BY agendado_para DESC LIMIT 1")->fetchColumn();
$urls = json_decode((string)$c, true);
if (is_array($urls) && $urls) {
    $u = (string)$urls[0];
    $isVid = (bool)preg_match('/\.(mp4|mov)(\?|$)/i', $u);
    $t0 = microtime(true);
    $e = null;
    $id = meta_threads_create_container($isVid ? 'VIDEO' : 'IMAGE', '', $u, $e, true);
    echo "\nteste lâmina ($u, " . ($isVid ? 'video' : 'imagem') . '): ' . ($id ?: "ERRO $e") . ' em ' . round(microtime(true) - $t0, 1) . "s\n";
    echo 'HEAD da URL: ';
    $h = @get_headers($u, true);
    echo $h ? $h[0] . ' ' . (is_array($h['Content-Type'] ?? '') ? end($h['Content-Type']) : ($h['Content-Type'] ?? '')) : 'falhou';
    echo "\n";
}
echo "\ndone\n";
@unlink(__FILE__);
