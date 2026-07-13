<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$base = 'https://techsantos.com.br';

$posts = [
    [
        'video' => $base . '/assets/social-video/dica-excel-tabela-dinamica.mp4',
        'legenda' => "Planilha gigante e você precisa de um resumo rápido?\n\nUse Tabela Dinâmica: arraste os campos, e o Excel soma, conta e agrupa pra você, sem fórmula nenhuma.\n\nMais dicas assim: link na bio.",
        'agendado_para' => '2026-07-18 12:00:00',
    ],
    [
        'video' => $base . '/assets/social-video/dica-excel-ctrlt.mp4',
        'legenda' => "Antes de copiar fórmula linha por linha, aperte Control T.\n\nIsso transforma o intervalo em Tabela: a fórmula copia sozinha, o filtro já vem pronto, e o cabeçalho trava quando você rola a tela.\n\nMais dicas assim: link na bio.",
        'agendado_para' => '2026-07-18 18:00:00',
    ],
    [
        'video' => $base . '/assets/social-video/dica-powerbi-medida-coluna.mp4',
        'legenda' => "Medida ou coluna calculada no Power BI?\n\nColuna calculada ocupa espaço no modelo, linha por linha. Medida calcula na hora, só quando o gráfico pede — mais leve e sempre atualizada com o filtro da tela. Na dúvida: comece com medida.\n\nMais dicas assim: link na bio.",
        'agendado_para' => '2026-07-19 12:00:00',
    ],
    [
        'video' => $base . '/assets/social-video/dica-powerbi-relacionamentos.mp4',
        'legenda' => "Modelo travando no Power BI?\n\nConfira o relacionamento: a tabela de dimensão precisa ter um valor único por linha, ligada à tabela de fatos, sempre um pra muitos. Isso evita contagem duplicada.\n\nMais dicas assim: link na bio.",
        'agendado_para' => '2026-07-19 18:00:00',
    ],
];

$ins = $pdo->prepare(
    "INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, agendado_para, status) VALUES ('instagram', 'reels', 'video', ?, ?, ?, 'pendente')"
);

$out = [];
foreach ($posts as $p) {
    $ins->execute([$p['legenda'], $p['video'], $p['agendado_para']]);
    $out[] = "Reels agendado pra {$p['agendado_para']} UTC (id " . $pdo->lastInsertId() . "): " . basename($p['video']);
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
