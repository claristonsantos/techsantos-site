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

echo "=== whatsapp_leads ===\n";
$r = $pdo->query("SELECT COUNT(*) c, MIN(criado_em) primeiro, MAX(criado_em) ultimo FROM whatsapp_leads")->fetch();
echo "total: {$r['c']} | primeiro: {$r['primeiro']} | ultimo: {$r['ultimo']}\n";
foreach ($pdo->query("SELECT telefone, origem, criado_em FROM whatsapp_leads ORDER BY criado_em DESC LIMIT 10") as $row) {
    echo "  {$row['criado_em']} | {$row['origem']} | {$row['telefone']}\n";
}

echo "\n=== pedidos (ultimos 15) ===\n";
foreach ($pdo->query("SELECT id, status, valor_centavos, email, criado_em, lembrete_enviado FROM pedidos ORDER BY criado_em DESC LIMIT 15") as $row) {
    echo "  #{$row['id']} | {$row['status']} | R$" . number_format($row['valor_centavos']/100, 2, ',', '.') . " | {$row['email']} | {$row['criado_em']} | lembrete_enviado={$row['lembrete_enviado']}\n";
}

echo "\n=== pedidos por status (geral) ===\n";
foreach ($pdo->query("SELECT status, COUNT(*) c FROM pedidos GROUP BY status") as $row) {
    echo "  {$row['status']}: {$row['c']}\n";
}

echo "\n=== social_posts (proximos 10 pendentes) ===\n";
foreach ($pdo->query("SELECT id, plataforma, tipo, status, agendado_para, erro FROM social_posts WHERE status = 'pendente' ORDER BY agendado_para ASC LIMIT 10") as $row) {
    echo "  #{$row['id']} | {$row['plataforma']} | {$row['tipo']} | agendado_para={$row['agendado_para']} UTC\n";
}

echo "\n=== social_posts (ultimos 10 publicados/erro) ===\n";
foreach ($pdo->query("SELECT id, plataforma, tipo, status, agendado_para, erro FROM social_posts WHERE status IN ('publicado','erro') ORDER BY agendado_para DESC LIMIT 10") as $row) {
    $erro = $row['erro'] ? " | ERRO: {$row['erro']}" : '';
    echo "  #{$row['id']} | {$row['plataforma']} | {$row['tipo']} | {$row['status']} | agendado_para={$row['agendado_para']}{$erro}\n";
}

echo "\ndone\n";
@unlink(__FILE__);
