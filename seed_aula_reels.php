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
        'video' => $base . '/assets/social-video/reel-apresentacao-curso-certificado.mp4',
        'legenda' => "Isso aqui é o certificado que fecha o curso completo de Power BI da TECH SANTOS BR, depois da avaliação final.\n\n13 módulos, do zero ao dashboard pronto, no seu ritmo.\n\nA aula de apresentação é grátis. Link na bio.",
        'agendado_para' => '2026-07-17 10:00:00',
    ],
    [
        'video' => $base . '/assets/social-video/reel-aula-perfil-de-dados.mp4',
        'legenda' => "Antes de qualquer fórmula, o Power Query já te mostra isso: o perfil de cada coluna da sua base, sozinho.\n\nDado fora do padrão, distribuição estranha, tudo aparece antes de você perder tempo com erro.\n\nAprenda a usar o Perfil de Dados no curso completo. Link na bio.",
        'agendado_para' => '2026-07-20 18:00:00',
    ],
    [
        'video' => $base . '/assets/social-video/reel-aula-construindo-dashboard.mp4',
        'legenda' => "Isso aqui é um dashboard comercial sendo montado ao vivo, dentro do curso.\n\nCard por card, com os números reais aparecendo, sem trabalho manual, só configuração certa.\n\nAprenda a montar o seu do zero. Link na bio.",
        'agendado_para' => '2026-07-24 10:00:00',
    ],
    [
        'video' => $base . '/assets/social-video/reel-aula-filtro-cruzado.mp4',
        'legenda' => "Clica num gráfico e o resto do painel responde sozinho.\n\nIsso é filtro cruzado no Power BI, você nunca mais precisa refazer relatório na mão pra ver um recorte diferente dos dados.\n\nFiltros e análise estatística no curso completo. Link na bio.",
        'agendado_para' => '2026-07-27 18:00:00',
    ],
];

$ins = $pdo->prepare(
    "INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, agendado_para, status) VALUES ('instagram', 'reels', 'video', ?, ?, ?, 'pendente')"
);

$out = [];
foreach ($posts as $p) {
    $ins->execute([$p['legenda'], $p['video'], $p['agendado_para']]);
    $out[] = "Reels agendado pra {$p['agendado_para']} BRT (id " . $pdo->lastInsertId() . "): " . basename($p['video']);
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
