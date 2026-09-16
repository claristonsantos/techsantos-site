<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

header('Content-Type: text/plain; charset=utf-8');
$pdo = db();

echo "=== Agendados/pendentes/processando (futuro ou recente) ===\n";
$stmt = $pdo->query(
    "SELECT id, canal, tipo, midia_tipo, status, agendado_para, imagem_url, legenda, meta_post_id
     FROM social_posts
     WHERE (status IN ('pendente','processando','agendado_meta') OR agendado_para >= DATE_SUB(NOW(), INTERVAL 3 DAY))
     ORDER BY agendado_para ASC"
);
foreach ($stmt->fetchAll() as $row) {
    $cap = mb_substr((string)$row['legenda'], 0, 60);
    echo "#{$row['id']} [{$row['canal']}/{$row['tipo']}/{$row['midia_tipo']}] {$row['status']} agendado={$row['agendado_para']} midia=" . basename((string)$row['imagem_url']) . " | \"{$cap}\"\n";
}

echo "\n=== Contagem por tipo (todos os tempos) ===\n";
foreach ($pdo->query("SELECT canal, tipo, COUNT(*) qtd FROM social_posts GROUP BY canal, tipo ORDER BY canal, tipo") as $row) {
    echo "{$row['canal']}/{$row['tipo']}: {$row['qtd']}\n";
}

echo "\n=== Últimos 10 publicados ===\n";
$stmt = $pdo->query("SELECT id, canal, tipo, agendado_para, legenda FROM social_posts WHERE status='publicado' ORDER BY agendado_para DESC LIMIT 10");
foreach ($stmt->fetchAll() as $row) {
    $cap = mb_substr((string)$row['legenda'], 0, 60);
    echo "#{$row['id']} [{$row['canal']}/{$row['tipo']}] {$row['agendado_para']} | \"{$cap}\"\n";
}

@unlink(__FILE__);

