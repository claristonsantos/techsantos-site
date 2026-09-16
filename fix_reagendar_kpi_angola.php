<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$out = [];

// #172 — carrossel do Instagram ficou travado em "processando" desde
// 19/08/2026 (falha silenciosa, nunca publicou). Volta pra pendente com
// data nova pro cron reprocessar do zero.
$upd = $pdo->prepare("UPDATE social_posts SET status='pendente', agendado_para=?, meta_post_id=NULL, meta_container_id=NULL, erro_msg=NULL WHERE id=172 AND status='processando'");
$upd->execute(['2026-09-17 21:00:00']);
$out[] = "post 172 (carrossel kpi): " . ($upd->rowCount() ? 'reagendado pra 17/09 18h BRT' : 'nao encontrado no estado esperado, nao mexido');

// #174 — reels do Instagram (cliente Angola) falhou com "Container ERROR"
// (erro transitorio comum da API do Meta). Reagenda pra tentar de novo.
$upd = $pdo->prepare("UPDATE social_posts SET status='pendente', agendado_para=?, meta_post_id=NULL, meta_container_id=NULL, erro_msg=NULL WHERE id=174 AND status='erro'");
$upd->execute(['2026-09-18 21:00:00']);
$out[] = "post 174 (reels angola): " . ($upd->rowCount() ? 'reagendado pra 18/09 18h BRT' : 'nao encontrado no estado esperado, nao mexido');

// 4 Stories do Instagram do lote kpi-sem-definicao que nunca tinham sido
// agendadas (so o Reel/Carrossel foram, as imagens de story ficaram paradas).
$legenda = "Antes de criar o indicador, alinhe a definicao. Reel e carrossel completos no feed.\n\n#PowerBI #DAX #TechSantosBR";
$stories = [
    ['https://techsantos.com.br/assets/social-story/organico/kpi-sem-definicao/story-01.png', '2026-09-19 21:00:00'],
    ['https://techsantos.com.br/assets/social-story/organico/kpi-sem-definicao/story-02.png', '2026-09-20 21:00:00'],
    ['https://techsantos.com.br/assets/social-story/organico/kpi-sem-definicao/story-03.png', '2026-09-21 21:00:00'],
    ['https://techsantos.com.br/assets/social-story/organico/kpi-sem-definicao/story-04.png', '2026-09-22 21:00:00'],
];
$ins = $pdo->prepare("INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, link_url, agendado_para, status) VALUES ('instagram','story','imagem',?,?,NULL,?,'pendente')");
foreach ($stories as [$url, $quando]) {
    $ins->execute([$legenda, $url, $quando]);
    $out[] = "story inserida: {$url} -> {$quando} UTC (id=" . $pdo->lastInsertId() . ")";
}

echo implode("\n", $out) . "\n";
@unlink(__FILE__);
