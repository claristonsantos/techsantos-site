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

$items = [
    [
        'video' => $base . '/assets/social-video/dica-excel-validacao-dados.mp4',
        'legenda' => "Gente ainda digita qualquer coisa numa planilha compartilhada?\n\nTrava a célula numa lista de opções com Validação de Dados: vai em Dados → Validação de Dados, escolhe Lista e digita as opções. Ninguém mais digita errado.\n\nMais dicas assim: link na bio.",
        'story' => '2026-07-18 09:00:00',
        'reels' => '2026-07-18 10:00:00',
    ],
    [
        'video' => $base . '/assets/social-video/dica-excel-somase.mp4',
        'legenda' => "Ainda soma linha por linha no dedo pra saber o total de um grupo?\n\nUsa SOMASE: ela soma um intervalo, mas só a parte que bate com o critério, tipo só uma região. Duas ou mais condições? Usa SOMASES.\n\nMais dicas assim: link na bio.",
        'story' => '2026-07-19 09:00:00',
        'reels' => '2026-07-19 10:00:00',
    ],
    [
        'video' => $base . '/assets/social-video/dica-powerbi-medidas-rapidas.mp4',
        'legenda' => "Travou na hora de escrever uma fórmula DAX do zero?\n\nUsa Medida Rápida: clique direito na tabela, escolhe o cálculo que quer (tipo % do total), e o Power BI já monta o DAX pronto pra você estudar.\n\nMais dicas assim: link na bio.",
        'story' => '2026-07-20 09:00:00',
        'reels' => '2026-07-20 10:00:00',
    ],
    [
        'video' => $base . '/assets/social-video/dica-powerbi-tooltip.mp4',
        'legenda' => "Cansou de lotar o relatório de gráfico só pra mostrar um detalhe a mais?\n\nUsa Tooltip Personalizado: cria uma página, marca como Dica de Ferramenta, monta um mini relatório nela e vincula ao gráfico principal.\n\nMais dicas assim: link na bio.",
        'story' => '2026-07-21 09:00:00',
        'reels' => '2026-07-21 10:00:00',
    ],
];

$ins = $pdo->prepare(
    "INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, agendado_para, status) VALUES ('instagram', ?, 'video', ?, ?, ?, 'pendente')"
);

$out = [];
foreach ($items as $it) {
    $ins->execute(['story', $it['legenda'], $it['video'], $it['story']]);
    $out[] = "story agendado pra {$it['story']} BRT (id " . $pdo->lastInsertId() . "): " . basename($it['video']);
    $ins->execute(['reels', $it['legenda'], $it['video'], $it['reels']]);
    $out[] = "reels agendado pra {$it['reels']} BRT (id " . $pdo->lastInsertId() . "): " . basename($it['video']);
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
