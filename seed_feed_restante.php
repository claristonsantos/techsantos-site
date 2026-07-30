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

// Melhor janela real da conta (calculada em cima do reach de cada post já
// publicado, não benchmark genérico): 09h-09h15 BRT = reach médio 69,8 (5
// posts). Segunda melhor: 11h15-11h30 BRT = reach médio 48,3 (3 posts).
// Noite (18h-20h) foi a PIOR faixa nos dados reais desta conta — reach
// médio 9-12 — o oposto do benchmark genérico usado antes. Ver
// project_techsantos_meta_social_api memory para o cálculo completo.
// Datas espaçadas 2+ dias (mesma lição de não empilhar posts).

$dax = [
    'https://techsantos.com.br/assets/social-feed/carrossel-dax/01.png',
    'https://techsantos.com.br/assets/social-feed/carrossel-dax/02.png',
    'https://techsantos.com.br/assets/social-feed/carrossel-dax/03.png',
    'https://techsantos.com.br/assets/social-feed/carrossel-dax/04.png',
    'https://techsantos.com.br/assets/social-feed/carrossel-dax/05.png',
    'https://techsantos.com.br/assets/social-feed/carrossel-dax/06.png',
    'https://techsantos.com.br/assets/social-feed/carrossel-dax/07.png',
];

$rows = [
    [
        'tipo' => 'feed',
        'imagem_url' => 'https://techsantos.com.br/assets/social-feed/resultado-projeto.png',
        'carousel_urls' => null,
        'legenda' => "R\$ 697 mil em faturamento monitorado em tempo real — um dos projetos de BI que já entregamos.\n\nDashboard comercial em Power BI: receita, margem e meta, tudo atualizado sozinho, decisão baseada em dado.\n\nQuer um assim pro seu negócio: https://techsantos.com.br/servicos.html",
        'agendado_para' => '2026-07-24 12:00:00', // 24/07 09h BRT
    ],
    [
        'tipo' => 'carousel',
        'imagem_url' => $dax[0],
        'carousel_urls' => json_encode($dax, JSON_UNESCAPED_SLASHES),
        'legenda' => "5 funções DAX que você vai usar toda semana no Power BI.\n\nSUM, CALCULATE, FILTER, RELATED e SUMX — a base de qualquer medida que funciona de verdade.\n\nAprende DAX do jeito certo no curso completo: https://techsantos.com.br/curso-power-bi.php",
        'agendado_para' => '2026-07-27 12:00:00', // 27/07 09h BRT
    ],
    [
        'tipo' => 'feed',
        'imagem_url' => 'https://techsantos.com.br/assets/social-feed/institucional.png',
        'carousel_urls' => null,
        'legenda' => "Quem é a Tech Santos BR.\n\n+50 projetos de BI entregues, parceiro Microsoft desde 2021, atendimento 100% remoto — sede em Itumbiara-GO, mas atende o Brasil inteiro.\n\nConheça nossos projetos: https://techsantos.com.br/projetos.html",
        'agendado_para' => '2026-07-29 14:00:00', // 29/07 11h BRT
    ],
    [
        'tipo' => 'feed',
        'imagem_url' => 'https://techsantos.com.br/assets/social-feed/oferta-curso.png',
        'carousel_urls' => null,
        'legenda' => "Curso Power BI Completo — R\$ 129,90.\n\nAcesso vitalício, certificado ao final, e você assiste a aula grátis antes de decidir se é pra você.\n\nMatricule-se: https://techsantos.com.br/comprar.php\nOu assista a aula grátis primeiro: https://techsantos.com.br/aula-gratis.php",
        'agendado_para' => '2026-07-31 12:00:00', // 31/07 09h BRT
    ],
    [
        'tipo' => 'feed',
        'imagem_url' => 'https://techsantos.com.br/assets/social-feed/repost-youtube.png',
        'carousel_urls' => null,
        'legenda' => "+22 mil visualizações no nosso canal do YouTube — tutoriais práticos de Power BI, toda semana.\n\nSe você aprende vendo na prática, o canal é seu próximo passo antes (ou depois) do curso completo.\n\nInscreva-se: https://www.youtube.com/@claristonsantos8129?sub_confirmation=1",
        'agendado_para' => '2026-08-03 14:00:00', // 03/08 11h BRT
    ],
];

$ins = $pdo->prepare(
    'INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, carousel_urls, agendado_para, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
);

foreach ($rows as $r) {
    $ins->execute(['instagram', $r['tipo'], 'imagem', $r['legenda'], $r['imagem_url'], $r['carousel_urls'], $r['agendado_para'], 'pendente']);
    $out[] = "Agendado (id {$pdo->lastInsertId()}): {$r['tipo']} — {$r['agendado_para']} UTC — {$r['imagem_url']}";
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
