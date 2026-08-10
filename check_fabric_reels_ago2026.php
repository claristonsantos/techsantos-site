<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$urls = [
    'https://media.techsantos.com.br/reels/fabric-onelake.mp4',
    'https://media.techsantos.com.br/reels/fabric-lakehouse-warehouse.mp4',
    'https://media.techsantos.com.br/reels/fabric-data-factory.mp4',
    'https://media.techsantos.com.br/reels/fabric-pipeline.mp4',
];

$placeholders = implode(',', array_fill(0, count($urls), '?'));
$query = db()->prepare(
    "SELECT id, imagem_url, agendado_para, status
     FROM social_posts
     WHERE canal = 'instagram' AND tipo = 'reels' AND imagem_url IN ({$placeholders})
     ORDER BY agendado_para"
);
$query->execute($urls);

header('Content-Type: application/json; charset=utf-8');
echo json_encode($query->fetchAll(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

@unlink(__FILE__);
