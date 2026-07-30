<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
header('Content-Type: text/plain; charset=utf-8');

$stmt = $pdo->query("SELECT id, status, meta_post_id, erro_msg, agendado_para FROM social_posts WHERE tipo = 'carousel' ORDER BY id DESC");
$rows = $stmt->fetchAll();

foreach ($rows as $r) {
    echo "id={$r['id']} status={$r['status']} meta_post_id=" . ($r['meta_post_id'] ?? 'NULL') . " agendado_para={$r['agendado_para']} erro=" . ($r['erro_msg'] ?? '') . "\n";
}

// Force-stop any carousel row still stuck in a re-triggerable state
// (pendente or processando) so the cron never picks it up again — we've
// already confirmed via the Graph API that this carousel published
// successfully at least once; duplicates were created by the cron
// re-running the same row on later ticks.
$fix = $pdo->prepare("UPDATE social_posts SET status = 'publicado', erro_msg = 'fixado manualmente após bug de duplicação 22/07' WHERE tipo = 'carousel' AND status IN ('pendente', 'processando')");
$fix->execute();
echo "\nLinhas corrigidas (forçadas pra 'publicado'): " . $fix->rowCount() . "\n";

@unlink(__FILE__);
