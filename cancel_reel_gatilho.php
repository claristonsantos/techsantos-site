<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$id = 62;

$sel = $pdo->prepare("SELECT id, status, imagem_url FROM social_posts WHERE id = ?");
$sel->execute([$id]);
$row = $sel->fetch();

header('Content-Type: text/plain; charset=utf-8');

if (!$row) {
    echo "id {$id}: não encontrado\n";
} elseif ($row['status'] !== 'pendente') {
    echo "id {$id}: status '{$row['status']}' — não removido (só cancela pendente)\n";
} else {
    $pdo->prepare("DELETE FROM social_posts WHERE id = ? AND status = 'pendente'")->execute([$id]);
    echo "id {$id}: removido (" . basename($row['imagem_url']) . ")\n";
}

@unlink(__FILE__);
