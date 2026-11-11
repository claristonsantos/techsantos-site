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
foreach ($pdo->query("SELECT id, tipo, midia_tipo, agendado_para, meta_post_id FROM social_posts WHERE id IN (488, 485, 464, 389, 166, 53, 3)") as $p) {
    echo "#{$p['id']} {$p['tipo']}/{$p['midia_tipo']} {$p['agendado_para']} id={$p['meta_post_id']}\n";
    foreach (['published,status,permalink_url', 'is_published,permalink_url', 'id'] as $f) {
        $e = null;
        $d = meta_graph_get($p['meta_post_id'], ['fields' => $f, 'access_token' => META_PAGE_TOKEN], $e);
        echo "   [$f] " . ($d ? json_encode($d, JSON_UNESCAPED_SLASHES) : 'ERRO ' . mb_substr((string)$e, 0, 90)) . "\n";
    }
}
echo "\ndone\n";
@unlink(__FILE__);
