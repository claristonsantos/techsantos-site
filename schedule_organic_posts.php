<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';

$pdo = db();

$base = 'https://techsantos.com.br/assets/img/';
$baseVideo = 'https://techsantos.com.br/assets/social-video/';

$posts = [
    [
        'canal' => 'facebook', 'tipo' => 'feed', 'midia_tipo' => 'imagem',
        'imagem_url' => $base . 'dica-excel-tabela-dinamica.jpg',
        'agendado_para' => '2026-07-16 10:00',
        'legenda' => "Pare de somar linha por linha no Excel. Com a Tabela Dinâmica, você resume milhares de linhas em segundos, sem escrever uma fórmula sequer — e o resumo atualiza sozinho quando os dados mudam.\n\nQuer aprender isso e muito mais de Excel e Power BI? clique no link abaixo.\nhttps://techsantos.com.br/curso-power-bi.php",
    ],
    [
        'canal' => 'instagram', 'tipo' => 'feed', 'midia_tipo' => 'imagem',
        'imagem_url' => $base . 'dica-excel-ctrlt.jpg',
        'agendado_para' => '2026-07-18 18:00',
        'legenda' => "Aperte Ctrl+T e transforme aquele intervalo comum em uma Tabela de verdade — fórmula copia sozinha pra linha nova, filtro já vem pronto, e fica muito mais fácil usar PROCX e Power BI depois.\n\nCurso completo de Power BI, do zero ao dashboard pronto — link na bio.",
    ],
    [
        'canal' => 'instagram', 'tipo' => 'reels', 'midia_tipo' => 'video',
        'imagem_url' => $baseVideo . 'dica-excel-procx.mp4',
        'agendado_para' => '2026-07-21 10:00',
        'legenda' => "Sua planilha quebra toda vez que alguém reordena uma coluna? Isso é o PROCV te dando trabalho. O PROCX busca em qualquer direção, não quebra com a reordenação e ainda aceita valor padrão pra quando não encontra nada.\n\nMais Excel e Power BI na prática no curso completo — link na bio.",
    ],
    [
        'canal' => 'facebook', 'tipo' => 'feed', 'midia_tipo' => 'imagem',
        'imagem_url' => $base . 'dica-powerbi-import.jpg',
        'agendado_para' => '2026-07-23 10:00',
        'legenda' => "Import ou DirectQuery no Power BI? Na dúvida, comece com Import: é mais rápido pra maioria dos casos. DirectQuery só compensa quando o dado precisa estar sempre ao vivo ou a base é gigante demais pra importar.\n\nIsso e muito mais no curso completo de Power BI da TECH SANTOS BR — clique no link abaixo.\nhttps://techsantos.com.br/curso-power-bi.php",
    ],
    [
        'canal' => 'instagram', 'tipo' => 'feed', 'midia_tipo' => 'imagem',
        'imagem_url' => $base . 'dica-powerbi-medida-coluna.jpg',
        'agendado_para' => '2026-07-25 18:00',
        'legenda' => "Medida ou coluna calculada no Power BI? Use medida sempre que puder: ela calcula na hora, reage a filtro e segmentação, e não ocupa espaço fixo no modelo. Coluna calculada fica só pros casos que realmente precisam.\n\nMergulha em DAX de verdade no curso completo — link na bio.",
    ],
    [
        'canal' => 'instagram', 'tipo' => 'reels', 'midia_tipo' => 'video',
        'imagem_url' => $baseVideo . 'dica-powerbi-relacionamentos.mp4',
        'agendado_para' => '2026-07-28 10:00',
        'legenda' => "Número duplicado aparecendo do nada no seu painel? Antes de mexer na fórmula, confira o relacionamento: dimensão tem 1 valor único por linha, fatos repetem o mesmo valor várias vezes — e a relação certa é sempre 1 pra muitos, nunca muitos-pra-muitos.\n\nModelagem de dados na prática, do zero, no curso completo de Power BI — link na bio.",
    ],
    [
        'canal' => 'facebook', 'tipo' => 'feed', 'midia_tipo' => 'imagem',
        'imagem_url' => $base . 'promo-curso-1.jpg',
        'agendado_para' => '2026-07-30 10:00',
        'legenda' => "O curso completo de Power BI da TECH SANTOS BR tem uma aula de apresentação gratuita: um tour pelos 13 módulos, a apostila teórica de apoio e como funciona o certificado de conclusão — antes de você decidir se matricular.\n\nAssista de graça, clique no link abaixo.\nhttps://techsantos.com.br/aula-gratis.php",
    ],
];

$results = [];

$ins = $pdo->prepare(
    'INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, agendado_para, status) VALUES (?, ?, ?, ?, ?, ?, ?)'
);

foreach ($posts as $p) {
    $scheduledTs = strtotime($p['agendado_para'] . ' -03:00');

    if ($p['canal'] === 'facebook') {
        $apiError = null;
        $postId = meta_schedule_facebook_post($p['legenda'], $p['imagem_url'], $scheduledTs, $apiError);
        if ($postId === null) {
            $ins->execute(['facebook', $p['tipo'], $p['midia_tipo'], $p['legenda'], $p['imagem_url'], date('Y-m-d H:i:s', $scheduledTs), 'erro']);
            $results[] = "ERRO facebook {$p['imagem_url']}: {$apiError}";
        } else {
            $ins->execute(['facebook', $p['tipo'], $p['midia_tipo'], $p['legenda'], $p['imagem_url'], date('Y-m-d H:i:s', $scheduledTs), 'agendado_meta']);
            $newId = $pdo->lastInsertId();
            $pdo->prepare('UPDATE social_posts SET meta_post_id = ? WHERE id = ?')->execute([$postId, $newId]);
            $results[] = "OK facebook {$p['imagem_url']} -> post_id={$postId}";
        }
    } else {
        $ins->execute(['instagram', $p['tipo'], $p['midia_tipo'], $p['legenda'], $p['imagem_url'], date('Y-m-d H:i:s', $scheduledTs), 'pendente']);
        $results[] = "OK instagram (pendente, cron publica) {$p['imagem_url']}";
    }
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $results) . "\n";

unlink(__FILE__);
