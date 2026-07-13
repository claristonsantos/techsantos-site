<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$rows = $pdo->query('SELECT * FROM social_auto_reply_log ORDER BY id DESC LIMIT 10')->fetchAll();

header('Content-Type: text/plain; charset=utf-8');
foreach ($rows as $r) {
    echo "#{$r['id']} [{$r['plataforma']}] comment={$r['comment_id']} autor={$r['autor']} regra={$r['regra_id']} status={$r['status']} erro={$r['erro_msg']}\n";
}
if (!$rows) {
    echo "vazio\n";
}

@unlink(__FILE__);
