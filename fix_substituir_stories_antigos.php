<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();

$rows = [
    242 => [
        'file' => 'dica-powerbi-botoes.mp4',
        'when' => '2026-09-24 21:00:00',
        'caption' => "Seu relatório trava numa página só?\n\nBotões de navegação levam o usuário entre páginas com um clique, sem depender da barra lateral — insere uma forma, define a ação e pronto.\n\nSalve pra deixar seu próximo relatório guiado.\n\n#PowerBI #Navegação #Dashboard #Produtividade",
    ],
    243 => [
        'file' => 'dica-powerbi-marcadores.mp4',
        'when' => '2026-09-25 21:00:00',
        'caption' => "Quer mostrar dois cenários sem duplicar página?\n\nMarcadores salvam o estado exato dos filtros e visuais — um clique volta o relatório pra aquele momento.\n\nSalve pra contar uma história melhor com os dados.\n\n#PowerBI #Marcadores #Storytelling #Dashboard",
    ],
    244 => [
        'file' => 'dica-powerbi-tempo-relativo.mp4',
        'when' => '2026-09-26 21:00:00',
        'caption' => "Cansou de atualizar o filtro de data toda semana?\n\nO filtro de tempo relativo se ajusta sozinho — últimos 7 dias, mês atual, sempre contando a partir de hoje.\n\nConfigura uma vez, nunca mais mexe.\n\n#PowerBI #Filtros #DataAnalytics #Produtividade",
    ],
    245 => [
        'file' => 'dica-powerbi-tema.mp4',
        'when' => '2026-09-27 21:00:00',
        'caption' => "Seu relatório não tem a cara da empresa?\n\nTemas personalizados trocam cor, fonte e estilo de todos os visuais de uma vez — escolha um pronto ou importe as cores da sua marca.\n\nSalve pra dar identidade ao próximo relatório.\n\n#PowerBI #Design #Dashboard #Branding",
    ],
    247 => [
        'file' => 'dica-excel-index-corresp.mp4',
        'when' => '2026-09-28 21:00:00',
        'caption' => "PROCV só olha pra direita e trava com coluna fora de ordem.\n\nÍNDICE junto com CORRESP busca em qualquer direção, sem se importar com a posição da coluna — a dupla clássica antes do PROCX.\n\nSalve pra próxima planilha bagunçada.\n\n#Excel #IndiceCorresp #PROCV #Produtividade",
    ],
    239 => [
        'file' => 'dica-excel-escala-cor.mp4',
        'when' => '2026-09-29 21:00:00',
        'caption' => "Precisa comparar centenas de números sem ler um a um?\n\nEscala de cor pinta a célula pela grandeza do valor — o padrão salta aos olhos antes mesmo de você somar qualquer coisa.\n\nSalve pra próxima planilha cheia de número.\n\n#Excel #FormatacaoCondicional #DataVisualization #Produtividade",
    ],
    240 => [
        'file' => 'dica-powerbi-powerpoint.mp4',
        'when' => '2026-09-30 21:00:00',
        'caption' => "Vai apresentar o relatório numa reunião sem print estático?\n\nO suplemento do Power BI pro PowerPoint deixa o slide interativo de verdade — filtra e atualiza dado ao vivo, direto na apresentação.\n\nSalve pra sua próxima reunião de resultado.\n\n#PowerBI #PowerPoint #BusinessIntelligence #Reuniao",
    ],
];

$select = $pdo->prepare("SELECT id, status FROM social_posts WHERE id = ? AND tipo='story'");
$update = $pdo->prepare("UPDATE social_posts SET imagem_url = ?, legenda = ?, agendado_para = ?, status = 'pendente', erro_msg = NULL, meta_container_id = NULL, meta_post_id = NULL, fb_story_status = 'nenhum', fb_story_id = NULL, fb_story_erro = NULL WHERE id = ?");
$out = [];
foreach ($rows as $id => $r) {
    $select->execute([$id]);
    $row = $select->fetch();
    if (!$row) { $out[] = "SKIP|story not found|id={$id}"; continue; }
    $url = 'https://media.techsantos.com.br/reels/' . $r['file'];
    $headers = @get_headers($url, true);
    $status = is_array($headers) ? (string)($headers[0] ?? '') : '';
    if (!str_contains($status, '200')) { $out[] = "MIDIA|ERRO|id={$id}|{$r['file']}|{$status}"; continue; }
    $update->execute([$url, $r['caption'], $r['when'], $id]);
    $out[] = "OK|id={$id}|{$r['file']}|{$r['when']}";
}
echo implode("\n", $out) . "\n";
@unlink(__FILE__);
