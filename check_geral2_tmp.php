<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/config.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('forbidden');
}

$pdo = db();
header('Content-Type: text/plain; charset=utf-8');

echo "=== social_posts (proximos pendentes/processando) ===\n";
foreach ($pdo->query("SELECT id, canal, tipo, status, agendado_para, erro_msg FROM social_posts WHERE status IN ('pendente','processando','agendado_meta') ORDER BY agendado_para ASC LIMIT 15") as $row) {
    $erro = $row['erro_msg'] ? " | ERRO: {$row['erro_msg']}" : '';
    echo "  #{$row['id']} | {$row['canal']} | {$row['tipo']} | {$row['status']} | agendado_para={$row['agendado_para']} UTC{$erro}\n";
}

echo "\n=== social_posts (ultimos publicados/erro) ===\n";
foreach ($pdo->query("SELECT id, canal, tipo, status, agendado_para, erro_msg FROM social_posts WHERE status IN ('publicado','erro') ORDER BY agendado_para DESC LIMIT 15") as $row) {
    $erro = $row['erro_msg'] ? " | ERRO: {$row['erro_msg']}" : '';
    echo "  #{$row['id']} | {$row['canal']} | {$row['tipo']} | {$row['status']} | agendado_para={$row['agendado_para']}{$erro}\n";
}

echo "\n=== social_posts por status (geral) ===\n";
foreach ($pdo->query("SELECT status, COUNT(*) c FROM social_posts GROUP BY status") as $row) {
    echo "  {$row['status']}: {$row['c']}\n";
}

echo "\ndone\n";
@unlink(__FILE__);
