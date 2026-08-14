<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = (string)($_GET['key'] ?? '');
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$base = 'https://techsantos.com.br/assets/social-feed/organico/kpi-sem-definicao';
$urls = [];
for ($i = 1; $i <= 7; $i++) {
    $urls[] = $base . '/slide-' . str_pad((string)$i, 2, '0', STR_PAD_LEFT) . '.png';
}

$caption = "Um KPI pode estar matematicamente certo e ainda assim levar a empresa para a decisão errada.\n\nAntes de abrir o Power BI, responda estas 5 perguntas:\n\n1. Qual decisão esse indicador precisa apoiar?\n2. O que entra — e o que fica de fora?\n3. Qual período será considerado?\n4. Qual é a fonte oficial?\n5. Quem valida a regra?\n\nSalve este carrossel para consultar antes de criar sua próxima medida.\n\nQual indicador mais gera discussão na sua empresa?\n\n#PowerBI #DAX #BusinessIntelligence #Indicadores #Dados #TechSantosBR";
$scheduled = new DateTimeImmutable('2026-08-19 20:00:00', new DateTimeZone('America/Sao_Paulo'));
$utcDate = $scheduled->setTimezone(new DateTimeZone('UTC'))->format('Y-m-d H:i:s');

$check = $pdo->prepare(
    "SELECT id, status FROM social_posts WHERE canal = 'instagram' AND tipo = 'carousel' AND imagem_url = ? AND agendado_para = ? LIMIT 1"
);
$check->execute([$urls[0], $utcDate]);
$existing = $check->fetch();

header('Content-Type: text/plain; charset=utf-8');
if ($existing) {
    echo sprintf("instagram: já existia (id %s, status %s)\n", $existing['id'], $existing['status']);
    @unlink(__FILE__);
    exit;
}

$insert = $pdo->prepare(
    'INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, carousel_urls, agendado_para, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
);
$insert->execute([
    'instagram',
    'carousel',
    'imagem',
    $caption,
    $urls[0],
    json_encode($urls, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
    $utcDate,
    'pendente',
]);

echo sprintf("instagram: carrossel enfileirado (id %s, %s UTC)\n", $pdo->lastInsertId(), $utcDate);
@unlink(__FILE__);
