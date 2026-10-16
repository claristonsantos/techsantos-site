<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: troca o vídeo do selfie do combo (posts 390 IG e 391 Threads de 16/10) pela regravação v2 (URL conferida com 200 antes do deploy).
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$novo = 'https://media.techsantos.com.br/reels/promo-combo-selfie-v2.mp4';
$h = @get_headers($novo); echo "check servidor: " . (is_array($h) ? (string)$h[0] : 'falhou') . "\n";
$pdo = db();
$up = $pdo->prepare("UPDATE social_posts SET imagem_url = ? WHERE id = ? AND status = 'pendente' AND imagem_url LIKE '%promo-combo-selfie.mp4'");
foreach ([390, 391] as $id) { $up->execute([$novo, $id]); echo "post $id: " . ($up->rowCount() ? 'trocado' : 'NÃO trocado') . "\n"; }
foreach ($pdo->query("SELECT id, canal, status, agendado_para, imagem_url FROM social_posts WHERE id IN (390,391)") as $r) echo implode(' | ', [$r['id'], $r['canal'], $r['status'], $r['agendado_para'], basename($r['imagem_url'])]), "\n";
