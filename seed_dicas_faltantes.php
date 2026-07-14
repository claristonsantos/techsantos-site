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
$base = 'https://techsantos.com.br';
$linkFb = "\n\nMais dicas como essa — clique no link abaixo:\n{$base}/servicos.html";
$linkIg = "\n\nMais dicas assim: link na bio.";

$out = [];

function brasilia_ts(string $localTime): int
{
    return (int)strtotime($localTime . ' -03:00');
}

// ---- Reels (Instagram only) para PROCX e Import x DirectQuery ----
$reels = [
    [
        'video' => $base . '/assets/social-video/dica-excel-procx.mp4',
        'legenda' => "PROCV travando quando a planilha cresce?\n\nTroque pelo PROCX (XLOOKUP): busca em qualquer direção, é mais rápido e não quebra quando você insere uma coluna no meio da tabela." . $linkIg,
        'quando' => '2026-07-16 12:00:00',
    ],
    [
        'video' => $base . '/assets/social-video/dica-powerbi-import.mp4',
        'legenda' => "Import ou DirectQuery: qual escolher?\n\nImport copia os dados pro arquivo — mais rápido, mas precisa de atualização programada. DirectQuery consulta a fonte em tempo real, só que é mais lento e limitado. Na dúvida: comece com Import." . $linkIg,
        'quando' => '2026-07-16 18:00:00',
    ],
];

$insReels = $pdo->prepare(
    "INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, agendado_para, status) VALUES ('instagram', 'reels', 'video', ?, ?, ?, 'pendente')"
);
foreach ($reels as $r) {
    $ts = brasilia_ts($r['quando']);
    $insReels->execute([$r['legenda'], $r['video'], date('Y-m-d H:i:s', $ts)]);
    $out[] = "Reels IG agendado pra {$r['quando']} BRT (id " . $pdo->lastInsertId() . "): " . basename($r['video']);
}

// ---- Feed (Facebook + Instagram) para Tabela Dinâmica, Control T, Medida x Coluna ----
$feeds = [
    [
        'img' => $base . '/assets/img/dica-excel-tabela-dinamica.jpg',
        'texto' => "Planilha com milhares de linhas e você só precisa de um resumo rápido?\n\nUse Tabela Dinâmica: arraste os campos, e o Excel soma, conta e agrupa pra você, sem fórmula nenhuma.",
        'quando' => '2026-07-20 12:00:00',
    ],
    [
        'img' => $base . '/assets/img/dica-excel-ctrlt.jpg',
        'texto' => "Antes de copiar fórmula linha por linha, aperte Control T.\n\nIsso transforma o intervalo em Tabela: a fórmula copia sozinha, o filtro já vem pronto, e o cabeçalho trava quando você rola a tela.",
        'quando' => '2026-07-20 18:00:00',
    ],
    [
        'img' => $base . '/assets/img/dica-powerbi-medida-coluna.jpg',
        'texto' => "Medida ou coluna calculada no Power BI?\n\nColuna calculada ocupa espaço no modelo, linha por linha. Medida calcula na hora, só quando o gráfico pede — mais leve e sempre atualizada com o filtro da tela. Na dúvida: comece com medida.",
        'quando' => '2026-07-21 12:00:00',
    ],
];

$insIg = $pdo->prepare(
    "INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, agendado_para, status) VALUES ('instagram', 'feed', 'imagem', ?, ?, ?, 'pendente')"
);
$insFbDone = $pdo->prepare(
    "INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, agendado_para, status, meta_post_id) VALUES ('facebook', 'feed', 'imagem', ?, ?, ?, 'agendado_meta', ?)"
);
$insFbErro = $pdo->prepare(
    "INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, agendado_para, status, erro_msg) VALUES ('facebook', 'feed', 'imagem', ?, ?, ?, 'erro', ?)"
);

foreach ($feeds as $f) {
    $ts = brasilia_ts($f['quando']);
    $legFb = $f['texto'] . $linkFb;
    $legIg = $f['texto'] . $linkIg;

    $apiError = null;
    $postId = meta_schedule_facebook_post($legFb, $f['img'], $ts, $apiError);
    if ($postId === null) {
        $insFbErro->execute([$legFb, $f['img'], date('Y-m-d H:i:s', $ts), (string)$apiError]);
        $out[] = "ERRO Facebook (" . basename($f['img']) . "): {$apiError}";
    } else {
        $insFbDone->execute([$legFb, $f['img'], date('Y-m-d H:i:s', $ts), $postId]);
        $out[] = "Facebook agendado pra {$f['quando']} BRT (id " . $pdo->lastInsertId() . ", meta_post={$postId}): " . basename($f['img']);
    }

    $insIg->execute([$legIg, $f['img'], date('Y-m-d H:i:s', $ts)]);
    $out[] = "Instagram feed agendado pra {$f['quando']} BRT (id " . $pdo->lastInsertId() . "): " . basename($f['img']);
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
