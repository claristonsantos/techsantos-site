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

if (!in_array('link_url', $cols, true)) {
    $pdo->exec("ALTER TABLE social_posts ADD COLUMN link_url VARCHAR(500) NULL AFTER imagem_url");
    $out[] = 'Coluna social_posts.link_url adicionada.';
} else {
    $out[] = 'Coluna social_posts.link_url já existia.';
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
