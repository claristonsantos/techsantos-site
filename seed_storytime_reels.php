<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$out = [];

// Storytime format test (silent screen-demo b-roll + cursive first-person
// caption + licensed ambient bed) vs the templated Dica/Promo pipeline.
// Spaced 2-4 days apart on purpose -- a same-day batch of near-identical
// Reels tanked reach on 2026-07-16/19 (see project_techsantos_meta_social_api
// memory), so these three go out on separate days, not back to back.
$rows = [
    [
        'imagem_url' => 'https://techsantos.com.br/assets/social-video/storytime-mapa-continente.mp4',
        'legenda' => 'Era só filtro de continente.',
        'agendado_para' => '2026-07-23 23:00:00', // 23/07 20h BRT (UTC-3)
    ],
    [
        'imagem_url' => 'https://techsantos.com.br/assets/social-video/storytime-slider-preco.mp4',
        'legenda' => 'Um slider. Pronto.',
        'agendado_para' => '2026-07-27 23:00:00', // 27/07 20h BRT
    ],
    [
        'imagem_url' => 'https://techsantos.com.br/assets/social-video/storytime-numero-duplicado.mp4',
        'legenda' => 'Fato com fato direto. Só faltava uma dimensão.',
        'agendado_para' => '2026-07-29 22:00:00', // 29/07 19h BRT
    ],
];

$ins = $pdo->prepare(
    'INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, agendado_para, status) VALUES (?, ?, ?, ?, ?, ?, ?)'
);

foreach ($rows as $r) {
    $ins->execute(['instagram', 'reels', 'video', $r['legenda'], $r['imagem_url'], $r['agendado_para'], 'pendente']);
    $out[] = 'Agendado: ' . $r['imagem_url'] . ' para ' . $r['agendado_para'] . ' UTC (id ' . $pdo->lastInsertId() . ')';
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
