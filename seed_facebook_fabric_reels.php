<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$posts = [
    ['https://media.techsantos.com.br/reels/fabric-onelake.mp4', '2026-08-14 13:00:00', '1718586190275611', "Microsoft Fabric não é só Power BI na nuvem.\n\nO OneLake cria uma base comum para organizar os dados usados pelas diferentes experiências da plataforma.\n\nSalve para consultar depois.\n\n#MicrosoftFabric #OneLake #PowerBI #Dados #Analytics"],
    ['https://media.techsantos.com.br/reels/fabric-lakehouse-warehouse.mp4', '2026-08-17 13:00:00', '1718586600275570', "Lakehouse ou Warehouse no Microsoft Fabric?\n\nA escolha depende do caso de uso: arquivos e Spark apontam para Lakehouse; desenvolvimento em T-SQL e transações entre tabelas podem apontar para Warehouse.\n\n#MicrosoftFabric #Lakehouse #DataWarehouse #PowerBI"],
    ['https://media.techsantos.com.br/reels/fabric-data-factory.mp4', '2026-08-21 13:00:00', '1718586706942226', "Banco, arquivo, API e nuvem no mesmo fluxo.\n\nO Data Factory no Microsoft Fabric conecta fontes, transforma dados com Dataflow Gen2 e organiza a execução com pipelines.\n\n#MicrosoftFabric #DataFactory #DataflowGen2 #PowerBI"],
    ['https://media.techsantos.com.br/reels/fabric-pipeline.mp4', '2026-08-24 13:00:00', '1718586793608884', "Um pipeline bem montado deixa cada etapa do fluxo visível e controlada.\n\nIngestão, transformação, notebooks, dataflows, atividades de cópia e monitoramento podem trabalhar em sequência no Microsoft Fabric.\n\n#MicrosoftFabric #DataPipeline #DataEngineering #PowerBI"],
];

$pdo = db();
$insert = $pdo->prepare(
    "INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, link_url, agendado_para, status, meta_post_id)
     SELECT 'facebook', 'reels', 'video', ?, ?, NULL, ?, 'agendado_meta', ?
     WHERE NOT EXISTS (
         SELECT 1 FROM social_posts WHERE canal = 'facebook' AND tipo = 'reels' AND imagem_url = ?
     )"
);
$out = [];

foreach ($posts as [$url, $when, $postId, $caption]) {
    $insert->execute([$caption, $url, $when, $postId, $url]);
    $out[] = $insert->rowCount() > 0
        ? "OK|id={$pdo->lastInsertId()}|post_id={$postId}|{$when} UTC"
        : "IGNORADO|já existe|{$url}";
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";
@unlink(__FILE__);