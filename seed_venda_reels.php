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
        'video' => $base . '/assets/social-video/venda-modelagem-dados.mp4',
        'legenda' => "Se sua planilha trava toda vez que a base cresce, o problema não é o Excel.\n\nÉ a modelagem de dados. Relatório que aguenta crescer se aprende do jeito certo, desde o início — e é exatamente por aí que o curso completo de Power BI começa.\n\nCurso completo, do zero, com certificado. Link na bio.",
        'agendado_para' => '2026-08-01 10:00:00',
    ],
    [
        'video' => $base . '/assets/social-video/venda-modelagem-antes-formula.mp4',
        'legenda' => "Antes de aprender fórmula em Power BI, tem uma coisa que quase todo mundo pula: a modelagem.\n\nRelacionamento certo evita dado duplicado, e é a base de tudo — inclusive de DAX. Depois que a modelagem tá redonda, o resto fica fácil.\n\nModelagem, DAX e dashboard, do zero. Link na bio.",
        'agendado_para' => '2026-08-04 18:00:00',
    ],
    [
        'video' => $base . '/assets/social-video/venda-tour-curso.mp4',
        'legenda' => "Isso aqui foi feito em Power BI — e no curso completo você sai sabendo construir do zero.\n\nSão 13 módulos: modelagem, Power Query e DAX, relatórios e dashboards publicados, apostila teórica e certificado ao final.\n\nA aula de apresentação é grátis. Link na bio.",
        'agendado_para' => '2026-08-07 10:00:00',
    ],
    [
        'video' => $base . '/assets/social-video/venda-pra-quem-e.mp4',
        'legenda' => "Você não precisa saber programar pra aprender Power BI.\n\nO curso é pra quem trabalha com dados no dia a dia: financeiro, áreas de gestão, quem quer sair da planilha manual ou está em transição de carreira.\n\nAssista a aula grátis e veja se é pra você. Link na bio.",
        'agendado_para' => '2026-08-11 10:00:00',
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
