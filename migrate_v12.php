<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$out = [];

$cols = $pdo->query("SHOW COLUMNS FROM social_posts")->fetchAll(PDO::FETCH_COLUMN);

if (!in_array('fb_story_status', $cols, true)) {
    $pdo->exec("ALTER TABLE social_posts ADD COLUMN fb_story_status ENUM('nenhum','publicado','erro') NOT NULL DEFAULT 'nenhum' AFTER meta_container_id");
    $out[] = 'Coluna social_posts.fb_story_status adicionada.';
} else {
    $out[] = 'Coluna social_posts.fb_story_status já existia.';
}

if (!in_array('fb_story_id', $cols, true)) {
    $pdo->exec("ALTER TABLE social_posts ADD COLUMN fb_story_id VARCHAR(100) NULL AFTER fb_story_status");
    $out[] = 'Coluna social_posts.fb_story_id adicionada.';
} else {
    $out[] = 'Coluna social_posts.fb_story_id já existia.';
}

if (!in_array('fb_story_erro', $cols, true)) {
    $pdo->exec("ALTER TABLE social_posts ADD COLUMN fb_story_erro VARCHAR(500) NULL AFTER fb_story_id");
    $out[] = 'Coluna social_posts.fb_story_erro adicionada.';
} else {
    $out[] = 'Coluna social_posts.fb_story_erro já existia.';
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
