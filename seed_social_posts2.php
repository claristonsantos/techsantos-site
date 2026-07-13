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
$out = [];

$base = 'https://techsantos.com.br';
$wa = '(64) 99290-5785';

$posts = [
    [
        'ts' => 1783981800, // seg 13/07 19:30 BRT
        'imagem' => $base . '/assets/img/dica-excel-procx.jpg',
        'fb' => "PROCV travando quando a planilha cresce? Troque pelo PROCX.\n\nO PROCV só busca da esquerda pra direita e trava fácil com base grande. O PROCX (XLOOKUP) busca em qualquer direção, é mais rápido e não quebra quando você insere uma coluna no meio da tabela.\n\nSe sua planilha já passou dos 10 mil linhas, vale a troca. Dúvida? Chama no WhatsApp — clique no link abaixo:\nhttps://wa.me/5564992905785",
        'ig' => "PROCV travando quando a planilha cresce? Troque pelo PROCX.\n\nO PROCV só busca da esquerda pra direita e trava fácil com base grande. O PROCX (XLOOKUP) busca em qualquer direção, é mais rápido e não quebra quando você insere uma coluna no meio da tabela.\n\nSe sua planilha já passou dos 10 mil linhas, vale a troca. Dúvida? Chama no WhatsApp: {$wa}",
    ],
    [
        'ts' => 1784052000, // ter 14/07 15:00 BRT
        'imagem' => $base . '/assets/img/goiasa.jpg',
        'fb' => "TCH estimado x realizado, ATR ponderado e área colhida — 2013 a 2021 num painel só.\n\nEsse é um recorte real de um dos painéis que sustentamos pra Goiasa (Grupo Construcap), no agronegócio: acompanhamento de produtividade de cana safra a safra, direto no Power BI.\n\nQuer um painel assim pra sua operação? Clique no link abaixo:\nhttps://wa.me/5564992905785",
        'ig' => "TCH estimado x realizado, ATR ponderado e área colhida — 2013 a 2021 num painel só.\n\nRecorte real de um painel que sustentamos pra Goiasa (Grupo Construcap), agronegócio: produtividade de cana acompanhada safra a safra, direto no Power BI.\n\nQuer um painel assim? WhatsApp: {$wa}",
    ],
    [
        'ts' => 1784138400, // qua 15/07 15:00 BRT
        'imagem' => $base . '/assets/img/dica-powerbi-import.jpg',
        'fb' => "Import ou DirectQuery no Power BI: qual escolher?\n\nImport copia os dados pro arquivo — mais rápido, mas precisa de atualização programada. DirectQuery consulta a fonte em tempo real, só que mais lento e mais limitado nas transformações.\n\nNa dúvida: comece com Import, resolve a maioria dos casos. Dúvida? Clique no link abaixo:\nhttps://wa.me/5564992905785",
        'ig' => "Import ou DirectQuery no Power BI: qual escolher?\n\nImport copia os dados pro arquivo — mais rápido, mas precisa de atualização programada. DirectQuery consulta a fonte em tempo real, só que mais lento e mais limitado.\n\nNa dúvida: comece com Import. WhatsApp: {$wa}",
    ],
    [
        'ts' => 1784224800, // qui 16/07 15:00 BRT
        'imagem' => $base . '/assets/img/nankarana.jpg',
        'fb' => "R$ 697 mil em faturamento, 2.778 vendas monitoradas em tempo real.\n\nPainel real que sustentamos pra Nanakarana (varejo de moda): faturamento, estoque e comportamento de cliente num só lugar, com mapa de vendas por estado.\n\nQuer organizar os dados do seu negócio assim? Clique no link abaixo:\nhttps://wa.me/5564992905785",
        'ig' => "R$ 697 mil em faturamento, 2.778 vendas monitoradas em tempo real.\n\nPainel real que sustentamos pra Nanakarana (varejo de moda): faturamento, estoque e comportamento de cliente num só lugar.\n\nQuer organizar os dados do seu negócio assim? WhatsApp: {$wa}",
    ],
    [
        'ts' => 1784311200, // sex 17/07 15:00 BRT
        'imagem' => $base . '/assets/img/iapredcare.jpg',
        'fb' => "201 sensores, 804 canais monitorados em tempo real.\n\nCentral de Monitoramento Preditivo que sustentamos pra IA PredCare (indústria): disponibilidade de equipamento acompanhada ao vivo, direto no Power BI.\n\nQuer um painel de monitoramento assim? Clique no link abaixo:\nhttps://wa.me/5564992905785",
        'ig' => "201 sensores, 804 canais monitorados em tempo real.\n\nCentral de Monitoramento Preditivo que sustentamos pra IA PredCare (indústria): disponibilidade de equipamento acompanhada ao vivo, direto no Power BI.\n\nQuer um painel assim? WhatsApp: {$wa}",
    ],
];

$ins = $pdo->prepare('INSERT INTO social_posts (canal, legenda, imagem_url, agendado_para, status, meta_post_id) VALUES (?, ?, ?, ?, ?, ?)');

foreach ($posts as $p) {
    $dataHora = date('Y-m-d H:i:s', $p['ts']);

    $apiError = null;
    $postId = meta_schedule_facebook_post($p['fb'], $p['imagem'], $p['ts'], $apiError);
    if ($postId === null) {
        $ins->execute(['facebook', $p['fb'], $p['imagem'], $dataHora, 'erro', null]);
        $out[] = "Facebook {$dataHora}: FALHOU — {$apiError}";
    } else {
        $ins->execute(['facebook', $p['fb'], $p['imagem'], $dataHora, 'agendado_meta', $postId]);
        $out[] = "Facebook {$dataHora}: agendado (id {$postId})";
    }

    $ins->execute(['instagram', $p['ig'], $p['imagem'], $dataHora, 'pendente', null]);
    $out[] = "Instagram {$dataHora}: enfileirado (pendente)";
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
