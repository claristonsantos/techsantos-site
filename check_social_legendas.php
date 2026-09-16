<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$stmt = $pdo->prepare("SELECT id, canal, tipo, status, erro_msg, legenda FROM social_posts WHERE id IN (170,171,172,174)");
$stmt->execute();
foreach ($stmt->fetchAll() as $row) {
    echo "=== #{$row['id']} [{$row['canal']}/{$row['tipo']}] status={$row['status']} erro=" . ($row['erro_msg'] ?: '-') . " ===\n{$row['legenda']}\n\n";
}
@unlink(__FILE__);
