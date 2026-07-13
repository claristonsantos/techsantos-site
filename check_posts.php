<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$stmt = $pdo->query("SELECT id, canal, imagem_url, agendado_para, status, meta_post_id FROM social_posts ORDER BY agendado_para, canal");
$out = [];
foreach ($stmt->fetchAll() as $row) {
    $out[] = "#{$row['id']} [{$row['canal']}] {$row['status']} {$row['agendado_para']} :: " . basename($row['imagem_url']) . " (meta_id={$row['meta_post_id']})";
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
