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

$posts = [
    [
        'url' => 'https://media.techsantos.com.br/reels/fabric-onelake.mp4',
        'when' => '2026-08-14 13:00:00', // 10h BRT
        'caption' => "Microsoft Fabric não é só Power BI na nuvem.\n\nO OneLake cria uma base comum para organizar os dados usados por diferentes experiências da plataforma, sem montar um quebra-cabeça de serviços.\n\nSalve para consultar depois e acompanhe a série Microsoft Fabric sem enrolação.\n\n#MicrosoftFabric #OneLake #PowerBI #Dados #Analytics",
    ],
    [
        'url' => 'https://media.techsantos.com.br/reels/fabric-lakehouse-warehouse.mp4',
        'when' => '2026-08-17 13:00:00', // 10h BRT
        'caption' => "Lakehouse ou Warehouse no Microsoft Fabric?\n\nA escolha depende do caso de uso: arquivos, Spark e dados estruturados ou não estruturados apontam para Lakehouse; desenvolvimento em T-SQL e transações entre tabelas podem apontar para Warehouse.\n\nSalve para lembrar na hora de desenhar sua próxima solução.\n\n#MicrosoftFabric #Lakehouse #DataWarehouse #PowerBI #EngenhariaDeDados",
    ],
    [
        'url' => 'https://media.techsantos.com.br/reels/fabric-data-factory.mp4',
        'when' => '2026-08-21 13:00:00', // 10h BRT
        'caption' => "Banco, arquivo, API e nuvem no mesmo fluxo.\n\nO Data Factory no Microsoft Fabric conecta fontes, transforma os dados com Dataflow Gen2 e organiza a execução com pipelines.\n\nSalve este mapa rápido para planejar sua próxima integração.\n\n#MicrosoftFabric #DataFactory #DataflowGen2 #Pipeline #PowerBI",
    ],
    [
        'url' => 'https://media.techsantos.com.br/reels/fabric-pipeline.mp4',
        'when' => '2026-08-24 13:00:00', // 10h BRT
        'caption' => "Um pipeline bem montado deixa cada etapa do fluxo visível e controlada.\n\nIngestão, transformação, notebooks, dataflows, atividades de cópia e monitoramento podem trabalhar em sequência no Microsoft Fabric.\n\nCompartilhe com quem ainda executa esse processo manualmente.\n\n#MicrosoftFabric #DataPipeline #DataEngineering #Automação #PowerBI",
    ],
];

$insert = $pdo->prepare(
    "INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, agendado_para, status)
     SELECT 'instagram', 'reels', 'video', ?, ?, ?, 'pendente'
     WHERE NOT EXISTS (
         SELECT 1 FROM social_posts
         WHERE canal = 'instagram' AND tipo = 'reels' AND imagem_url = ?
     )"
);

foreach ($posts as $post) {
    $insert->execute([$post['caption'], $post['url'], $post['when'], $post['url']]);
    $out[] = $insert->rowCount() > 0
        ? "Agendado: {$post['url']} para {$post['when']} UTC"
        : "Ignorado (já existente): {$post['url']}";
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
