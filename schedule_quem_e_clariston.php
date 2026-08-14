<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$pdo = db();
$mediaUrl = 'https://techsantos.com.br/assets/social-video/quem-e-clariston-santos.mp4';
$scheduledAt = '2026-08-14 23:00:00'; // 20h em Brasilia, salvo em UTC.
$caption = <<<'TEXT'
Quem é Clariston Santos?

Especialista em Business Intelligence, fundador da TECH SANTOS BR e certificado pela Microsoft como Power BI Data Analyst e Fabric Analytics Engineer.

Ao longo da trajetória, já participou de mais de 50 projetos de dados em diferentes setores. Hoje, compartilha essa experiência por meio de cursos, aulas particulares e projetos para empresas.

O objetivo é transformar dados em análises confiáveis e decisões melhores.

Conheça mais conteúdos de Excel, Power BI e Microsoft Fabric acompanhando a TECH SANTOS BR.

#PowerBI #BusinessIntelligence #MicrosoftFabric #Excel #Dados #DataAnalytics #TechSantosBR
TEXT;

$check = $pdo->prepare(
    "SELECT id, status FROM social_posts WHERE canal = 'instagram' AND tipo = 'reels' AND imagem_url = ? AND agendado_para = ? LIMIT 1"
);
$check->execute([$mediaUrl, $scheduledAt]);
$existing = $check->fetch();

if ($existing) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['ok' => true, 'existing' => true, 'id' => (int)$existing['id'], 'status' => $existing['status']], JSON_UNESCAPED_UNICODE);
    @unlink(__FILE__);
    exit;
}

$insert = $pdo->prepare(
    "INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, link_url, agendado_para, status) VALUES ('instagram', 'reels', 'video', ?, ?, NULL, ?, 'pendente')"
);
$insert->execute([$caption, $mediaUrl, $scheduledAt]);

header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'ok' => true,
    'id' => (int)$pdo->lastInsertId(),
    'canal' => 'instagram',
    'tipo' => 'reels',
    'agendado_para_brasilia' => '2026-08-14 20:00:00',
    'status' => 'pendente',
    'media_url' => $mediaUrl,
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

@unlink(__FILE__);
