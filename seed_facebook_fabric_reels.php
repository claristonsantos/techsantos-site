<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$posts = [
    [
        'url' => 'https://media.techsantos.com.br/reels/fabric-onelake.mp4',
        'when' => '2026-08-14 13:00:00',
        'caption' => "Microsoft Fabric não é só Power BI na nuvem.\n\nO OneLake cria uma base comum para organizar os dados usados pelas diferentes experiências da plataforma.\n\nSalve para consultar depois.\n\n#MicrosoftFabric #OneLake #PowerBI #Dados #Analytics",
    ],
    [
        'url' => 'https://media.techsantos.com.br/reels/fabric-lakehouse-warehouse.mp4',
        'when' => '2026-08-17 13:00:00',
        'caption' => "Lakehouse ou Warehouse no Microsoft Fabric?\n\nA escolha depende do caso de uso: arquivos e Spark apontam para Lakehouse; desenvolvimento em T-SQL e transações entre tabelas podem apontar para Warehouse.\n\n#MicrosoftFabric #Lakehouse #DataWarehouse #PowerBI",
    ],
    [
        'url' => 'https://media.techsantos.com.br/reels/fabric-data-factory.mp4',
        'when' => '2026-08-21 13:00:00',
        'caption' => "Banco, arquivo, API e nuvem no mesmo fluxo.\n\nO Data Factory no Microsoft Fabric conecta fontes, transforma dados com Dataflow Gen2 e organiza a execução com pipelines.\n\n#MicrosoftFabric #DataFactory #DataflowGen2 #PowerBI",
    ],
    [
        'url' => 'https://media.techsantos.com.br/reels/fabric-pipeline.mp4',
        'when' => '2026-08-24 13:00:00',
        'caption' => "Um pipeline bem montado deixa cada etapa do fluxo visível e controlada.\n\nIngestão, transformação, notebooks, dataflows, atividades de cópia e monitoramento podem trabalhar em sequência no Microsoft Fabric.\n\n#MicrosoftFabric #DataPipeline #DataEngineering #PowerBI",
    ],
];

$pdo = db();
$exists = $pdo->prepare("SELECT id FROM social_posts WHERE canal = 'facebook' AND tipo = 'reels' AND imagem_url = ? LIMIT 1");
$insert = $pdo->prepare(
    "INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, link_url, agendado_para, status, meta_post_id)
     VALUES ('facebook', 'reels', 'video', ?, ?, NULL, ?, 'agendado_meta', ?)"
);
$out = [];

foreach ($posts as $post) {
    $exists->execute([$post['url']]);
    if ($exists->fetchColumn()) {
        $out[] = "IGNORADO|já existe|{$post['url']}";
        continue;
    }

    $error = null;
    $timestamp = strtotime($post['when'] . ' UTC');
    $videoId = meta_schedule_facebook_reel($post['caption'], $post['url'], $timestamp, $error);
    if ($videoId === null) {
        $out[] = "ERRO|{$post['url']}|{$error}";
        break;
    }

    $insert->execute([$post['caption'], $post['url'], $post['when'], $videoId]);
    $out[] = "OK|id={$pdo->lastInsertId()}|video_id={$videoId}|{$post['when']} UTC";
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
