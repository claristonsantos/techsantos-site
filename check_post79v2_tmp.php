<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/config.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('forbidden');
}

$pdo = db();
header('Content-Type: text/plain; charset=utf-8');

$row = $pdo->query("SELECT id, canal, tipo, status, meta_post_id, meta_container_id, erro_msg, agendado_para FROM social_posts WHERE id = 79")->fetch();
foreach ($row as $k => $v) {
    echo "$k: $v\n";
}

@unlink(__FILE__);
