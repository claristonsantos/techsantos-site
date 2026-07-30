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

// The emergency fix a moment ago wrongly force-marked id=102 (DAX carousel,
// scheduled 27/07, never actually sent to Meta -- meta_post_id was NULL) as
// 'publicado' along with id=100 (today's, which really had published 3x).
// Revert 102 back to pendente so it actually goes out on its scheduled date.
$stmt = $pdo->prepare("SELECT id, status, meta_post_id, agendado_para FROM social_posts WHERE id = 102");
$stmt->execute();
$before = $stmt->fetch();
echo "antes: " . json_encode($before) . "\n";

if ($before && $before['meta_post_id'] === null) {
    $pdo->prepare("UPDATE social_posts SET status = 'pendente', erro_msg = NULL WHERE id = 102")->execute();
    echo "id=102 revertido pra 'pendente' (nao tinha meta_post_id, nunca foi publicado de verdade)\n";
} else {
    echo "id=102 tem meta_post_id preenchido -- NAO revertido, pode ja ter publicado de verdade. Confira manualmente.\n";
}

$stmt2 = $pdo->prepare("SELECT id, status, meta_post_id, agendado_para FROM social_posts WHERE id IN (100, 102)");
$stmt2->execute();
foreach ($stmt2->fetchAll() as $r) {
    echo "depois: " . json_encode($r) . "\n";
}

@unlink(__FILE__);
