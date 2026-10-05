<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
// Posts que saíram de fato mas ficaram com status preso em 'processando' (cron interrompido).
$pub = $pdo->prepare("UPDATE social_posts SET status='publicado', meta_post_id=COALESCE(?, meta_post_id) WHERE id=? AND status='processando'");
foreach ([[290, null], [327, '18121912147898565'], [329, '18093022379384536']] as [$id, $mid]) { $pub->execute([$mid, $id]); echo "#{$id} -> publicado (" . $pub->rowCount() . ")\n"; }
// Dois registros antigos de julho presos desde então.
$old = $pdo->prepare("UPDATE social_posts SET status='erro', erro_msg='travado em processando desde jul/2026 (limpeza 05/10)' WHERE id=? AND status='processando'");
foreach ([80, 102] as $id) { $old->execute([$id]); echo "#{$id} -> erro (" . $old->rowCount() . ")\n"; }
@unlink(__FILE__);
