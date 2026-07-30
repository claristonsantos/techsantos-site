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

if (!in_array('carousel_urls', $cols, true)) {
    $pdo->exec("ALTER TABLE social_posts ADD COLUMN carousel_urls TEXT NULL AFTER link_url");
    $out[] = 'Coluna social_posts.carousel_urls adicionada.';
} else {
    $out[] = 'Coluna social_posts.carousel_urls já existia.';
}

$pdo->exec("ALTER TABLE social_posts MODIFY COLUMN tipo ENUM('feed','story','reels','carousel') NOT NULL DEFAULT 'feed'");
$out[] = "Enum social_posts.tipo agora inclui 'carousel'.";

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
