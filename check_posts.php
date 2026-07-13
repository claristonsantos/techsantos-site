<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$stmt = $pdo->query("SELECT id, canal, tipo, midia_tipo, status, agendado_para, meta_post_id, meta_container_id FROM social_posts WHERE id >= 20 ORDER BY id");
$out = [];
foreach ($stmt->fetchAll() as $row) {
    $out[] = "#{$row['id']} [{$row['canal']}/{$row['tipo']}/{$row['midia_tipo']}] {$row['status']} {$row['agendado_para']} meta_post={$row['meta_post_id']} container={$row['meta_container_id']}";
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
