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

$stmt = $pdo->query("SHOW COLUMNS FROM pedidos LIKE 'lembrete_enviado'");
if ($stmt->rowCount() === 0) {
    $pdo->exec("ALTER TABLE pedidos ADD COLUMN lembrete_enviado TINYINT(1) NOT NULL DEFAULT 0 AFTER status");
    $out[] = 'Coluna pedidos.lembrete_enviado criada.';

    // Backfill: marca todo pedido pendente já existente como "já tratado" para
    // que o cron de lembrete não dispare e-mail retroativo para pedidos de
    // teste antigos — só pedidos criados a partir de agora entram no fluxo.
    $n = $pdo->exec("UPDATE pedidos SET lembrete_enviado = 1 WHERE status = 'pendente'");
    $out[] = "Backfill: {$n} pedido(s) pendente(s) existentes marcados como já tratados.";
} else {
    $out[] = 'Coluna pedidos.lembrete_enviado já existia — nada a fazer.';
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
