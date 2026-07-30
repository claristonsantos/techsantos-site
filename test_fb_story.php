<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

header('Content-Type: text/plain; charset=utf-8');

$error = null;
$storyId = meta_publish_facebook_story(
    'https://techsantos.com.br/assets/social-video/storytime-mapa-continente.mp4',
    true,
    $error
);

if ($storyId === null) {
    echo "FALHOU: {$error}\n";
} else {
    echo "OK: story publicado, id={$storyId}\n";
}

@unlink(__FILE__);
