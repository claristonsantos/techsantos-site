<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$ids = [58, 59, 60, 61];

$sel = $pdo->prepare("SELECT id, status, imagem_url FROM social_posts WHERE id = ?");
$del = $pdo->prepare("DELETE FROM social_posts WHERE id = ? AND status = 'pendente'");

$out = [];
foreach ($ids as $id) {
    $sel->execute([$id]);
    $row = $sel->fetch();
    if (!$row) {
        $out[] = "id {$id}: não encontrado";
        continue;
    }
    if ($row['status'] !== 'pendente') {
        $out[] = "id {$id}: status '{$row['status']}' — não removido (só cancela pendente)";
        continue;
    }
    $del->execute([$id]);
    $out[] = "id {$id}: removido (" . basename($row['imagem_url']) . ")";
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
