<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$stmt = $pdo->prepare("SELECT id, status, imagem_url, legenda FROM social_posts WHERE id IN (26,27,28,29) ORDER BY id");
$stmt->execute();

header('Content-Type: text/plain; charset=utf-8');
foreach ($stmt->fetchAll() as $row) {
    echo "#{$row['id']} [{$row['status']}] " . basename($row['imagem_url']) . "\n";
    echo $row['legenda'] . "\n---\n";
}

@unlink(__FILE__);
