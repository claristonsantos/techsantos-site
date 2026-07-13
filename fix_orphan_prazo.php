<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$out = [];
$base = 'https://techsantos.com.br';

$orphanId = '982806068476559_1691912559609641';
$apiError = null;
$deleted = meta_delete_facebook_post($orphanId, $apiError);
$out[] = $deleted ? "Post orfao cancelado ({$orphanId})" : "Falha ao cancelar orfao: {$apiError}";

$ts = 1784311200; // 2026-07-17 18:00:00 UTC, mesmo horario do post orfao
$dataHora = gmdate('Y-m-d H:i:s', $ts);
$imagem = $base . '/assets/img/sobre-prazo.jpg';

$fbCaption = "Prazo médio de ~30 dias pra um projeto de baixa complexidade.\n\nSediados em Itumbiara-GO, com atendimento remoto pra todo o Brasil — do primeiro diagnóstico ao painel em produção.\n\nFala com a gente — clique no link abaixo:\n{$base}/contato.html";
$igCaption = "Prazo médio de ~30 dias pra um projeto de baixa complexidade.\n\nSediados em Itumbiara-GO, com atendimento remoto pra todo o Brasil.\n\nFala com a gente: link na bio.";

$ins = $pdo->prepare('INSERT INTO social_posts (canal, legenda, imagem_url, agendado_para, status, meta_post_id) VALUES (?, ?, ?, ?, ?, ?)');

$apiError = null;
$newId = meta_schedule_facebook_post($fbCaption, $imagem, $ts, $apiError);
if ($newId === null) {
    $ins->execute(['facebook', $fbCaption, $imagem, $dataHora, 'erro', null]);
    $out[] = "Facebook {$dataHora}: FALHOU — {$apiError}";
} else {
    $ins->execute(['facebook', $fbCaption, $imagem, $dataHora, 'agendado_meta', $newId]);
    $out[] = "Facebook {$dataHora}: agendado (id {$newId})";
}

$ins->execute(['instagram', $igCaption, $imagem, $dataHora, 'pendente', null]);
$out[] = "Instagram {$dataHora}: enfileirado (pendente)";

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
