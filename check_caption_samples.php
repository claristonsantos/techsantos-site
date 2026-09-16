<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$ids = [187, 205, 197, 203, 183];
$stmt = $pdo->prepare('SELECT id, canal, imagem_url, legenda FROM social_posts WHERE id = ?');
foreach ($ids as $id) {
    $stmt->execute([$id]);
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$r) continue;
    echo "=== #{$r['id']} {$r['canal']} " . basename((string)$r['imagem_url']) . " ===\n{$r['legenda']}\n\n";
}
@unlink(__FILE__);
