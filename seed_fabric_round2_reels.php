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
    ['file' => 'fabric-deploy.mp4', 'when' => '2026-08-28 13:00:00', 'caption' => "Dois pipelines no Microsoft Fabric — e eles não fazem a mesma coisa.\n\nPipeline de dados executa atividades e movimenta dados. Pipeline de implantação promove conteúdo entre desenvolvimento, teste e produção.\n\nSalve para não confundir no próximo projeto.\n\n#MicrosoftFabric #DataFactory #DevOps #BusinessIntelligence"],
    ['file' => 'fabric-git.mp4', 'when' => '2026-08-31 13:00:00', 'caption' => "Seu projeto no Fabric ainda depende de “não mexe nisso agora”?\n\nA integração com Git ajuda a versionar itens compatíveis, trabalhar com branches, revisar mudanças e recuperar versões anteriores.\n\nVocê já versiona seus projetos de dados?\n\n#MicrosoftFabric #GitHub #Dados #PowerBI"],
    ['file' => 'fabric-variables.mp4', 'when' => '2026-09-03 13:00:00', 'caption' => "Ainda troca IDs e conexões na mão entre desenvolvimento, teste e produção?\n\nA biblioteca de variáveis centraliza configurações e permite usar um conjunto de valores em cada ambiente.\n\nSalve para a próxima implantação.\n\n#MicrosoftFabric #CICD #DataEngineering #DevOps"],
    ['file' => 'fabric-capacity.mp4', 'when' => '2026-09-07 13:00:00', 'caption' => "A capacidade ficou lenta — mas qual item causou o pico?\n\nO Fabric Capacity Metrics ajuda a localizar o horário, o workspace, o item e a operação que contribuíram para o consumo.\n\nInvestigue antes de aumentar a capacidade.\n\n#MicrosoftFabric #CapacityMetrics #Performance #FinOps"],
    ['file' => 'fabric-mirroring.mp4', 'when' => '2026-09-10 13:00:00', 'caption' => "Quer analisar um banco operacional no Fabric sem começar por um ETL complexo?\n\nCom Mirroring, origens compatíveis podem ser replicadas continuamente para o OneLake e usadas em análise e engenharia.\n\nQual banco você gostaria de espelhar?\n\n#MicrosoftFabric #Mirroring #AzureSQL #OneLake"],
    ['file' => 'fabric-monitoring.mp4', 'when' => '2026-09-14 13:00:00', 'caption' => "Seu fluxo falhou. Você sabe onde procurar o histórico?\n\nO monitoramento do workspace centraliza logs e métricas de itens compatíveis para consultas, dashboards e diagnóstico.\n\nSalve antes do próximo erro difícil de rastrear.\n\n#MicrosoftFabric #KQL #Monitoramento #DataOps"],
    ['file' => 'fabric-eventstream.mp4', 'when' => '2026-09-17 13:00:00', 'caption' => "Seu dado não chega em lote. Ele acontece agora.\n\nEventstream captura, transforma e encaminha eventos em tempo real. Monitore entrada, saída, atraso e erros do fluxo.\n\nComente “tempo real” se quer um exemplo prático.\n\n#MicrosoftFabric #Eventstream #RealTimeAnalytics #Dados"],
    ['file' => 'fabric-sql-database.mp4', 'when' => '2026-09-21 13:00:00', 'caption' => "SQL Database ou Warehouse no Microsoft Fabric?\n\nSQL Database atende aplicações e cargas transacionais. Warehouse é voltado à análise em escala. A escolha começa pela natureza da carga.\n\nEnvie para quem trabalha com arquitetura de dados.\n\n#MicrosoftFabric #SQLDatabase #DataWarehouse #TSQL"],
];

$pdo = db();
$instagramExists = $pdo->prepare("SELECT id FROM social_posts WHERE canal = 'instagram' AND tipo = 'reels' AND imagem_url = ? LIMIT 1");
$instagramInsert = $pdo->prepare("INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, agendado_para, status) VALUES ('instagram', 'reels', 'video', ?, ?, ?, 'pendente')");
$facebookExists = $pdo->prepare("SELECT id FROM social_posts WHERE canal = 'facebook' AND tipo = 'reels' AND imagem_url = ? LIMIT 1");
$facebookInsert = $pdo->prepare("INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, link_url, agendado_para, status, meta_post_id) VALUES ('facebook', 'reels', 'video', ?, ?, NULL, ?, 'agendado_meta', ?)");
$out = [];

foreach ($posts as $post) {
    $url = 'https://techsantos.com.br/assets/social-video/fabric/' . $post['file'];
    $instagramExists->execute([$url]);
    if ($instagramExists->fetchColumn()) {
        $out[] = "INSTAGRAM|IGNORADO|{$post['file']}";
    } else {
        $instagramInsert->execute([$post['caption'], $url, $post['when']]);
        $out[] = "INSTAGRAM|OK|id={$pdo->lastInsertId()}|{$post['when']} UTC|{$post['file']}";
    }

    $facebookExists->execute([$url]);
    if ($facebookExists->fetchColumn()) {
        $out[] = "FACEBOOK|IGNORADO|{$post['file']}";
        continue;
    }

    $error = null;
    $videoId = meta_schedule_facebook_reel($post['caption'], $url, strtotime($post['when'] . ' UTC'), $error);
    if ($videoId === null) {
        $out[] = "FACEBOOK|ERRO|{$post['file']}|{$error}";
        continue;
    }
    $facebookInsert->execute([$post['caption'], $url, $post['when'], $videoId]);
    $out[] = "FACEBOOK|OK|id={$pdo->lastInsertId()}|video_id={$videoId}|{$post['when']} UTC|{$post['file']}";
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";
@unlink(__FILE__);
