<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';

$key = (string)($_GET['key'] ?? '');
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$videoUrl = 'https://media.techsantos.com.br/reels/reel-kpi-sem-definicao-1080x1920.mp4';
$caption = "Um indicador não começa no DAX. Começa em uma definição que todos entendem da mesma forma.\n\nAntes de criar a medida, registre:\n• o que será contado;\n• quais registros entram;\n• quais ficam de fora;\n• qual período será considerado;\n• quem valida a regra.\n\nQual indicador mais gera discussão na sua empresa? Comente o nome do indicador.\n\n#PowerBI #DAX #BusinessIntelligence #Dados #TechSantosBR";

$schedule = [
    'facebook' => new DateTimeImmutable('2026-08-17 11:00:00', new DateTimeZone('America/Sao_Paulo')),
    'instagram' => new DateTimeImmutable('2026-08-17 20:00:00', new DateTimeZone('America/Sao_Paulo')),
];

$check = $pdo->prepare(
    "SELECT id, status FROM social_posts WHERE canal = ? AND tipo = 'reels' AND imagem_url = ? AND agendado_para = ? LIMIT 1"
);
$insert = $pdo->prepare(
    'INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, link_url, agendado_para, status, meta_post_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
);
$out = [];

foreach ($schedule as $channel => $date) {
    $utcDate = $date->setTimezone(new DateTimeZone('UTC'))->format('Y-m-d H:i:s');
    $check->execute([$channel, $videoUrl, $utcDate]);
    $existing = $check->fetch();
    if ($existing) {
        $out[] = sprintf('%s: já existia (id %s, status %s)', $channel, $existing['id'], $existing['status']);
        continue;
    }

    if ($channel === 'facebook') {
        $apiError = null;
        $postId = meta_schedule_facebook_reel($caption, $videoUrl, $date->getTimestamp(), $apiError);
        if ($postId === null) {
            $insert->execute([$channel, 'reels', 'video', $caption, $videoUrl, null, $utcDate, 'erro', null]);
            $out[] = 'facebook: falha — ' . ($apiError ?: 'erro não informado');
            continue;
        }

        $insert->execute([$channel, 'reels', 'video', $caption, $videoUrl, null, $utcDate, 'agendado_meta', $postId]);
        $out[] = sprintf('facebook: agendado (id local %s, Meta %s)', $pdo->lastInsertId(), $postId);
        continue;
    }

    $insert->execute([$channel, 'reels', 'video', $caption, $videoUrl, null, $utcDate, 'pendente', null]);
    $out[] = sprintf('instagram: enfileirado (id %s)', $pdo->lastInsertId());
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
