<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/config.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('forbidden');
}
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
@unlink(__FILE__);
foreach ($pdo->query("SELECT id, tipo, status, meta_post_id, LEFT(erro_msg, 120) erro FROM social_posts WHERE id IN (484, 487, 518, 519)") as $r) {
    echo implode(' | ', array_map(static fn($v) => $v ?? 'NULL', $r)) . "\n";
}
$m = dirname(__DIR__) . '/.threads_token_renovado';
echo 'marca renovação Threads: ' . (is_file($m) ? date('Y-m-d H:i', filemtime($m)) : 'não existe') . "\n";
echo "done\n";
