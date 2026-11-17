<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: diagnóstico de origem dos pedidos recentes. Só leitura.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$pdo = db();
echo "NOW_DB=" . $pdo->query("SELECT NOW()")->fetchColumn() . "\n\n== PEDIDOS (7 dias) ==\n";
$q = $pdo->query("SELECT p.*, c.slug curso_slug FROM pedidos p LEFT JOIN cursos c ON c.id=p.curso_id WHERE p.criado_em >= NOW() - INTERVAL 7 DAY ORDER BY p.id DESC LIMIT 20");
foreach ($q as $r) {
    if (!empty($r['cpf'])) $r['cpf'] = substr((string)$r['cpf'], 0, 3) . '***';
    $r = array_filter($r, fn($v) => $v !== null && $v !== '');
    echo json_encode($r, JSON_UNESCAPED_UNICODE) . "\n";
}
foreach (['lista_espera' => 'criado_em', 'whatsapp_leads' => 'criado_em', 'aulas_particulares' => 'criado_em'] as $t => $col) {
    try {
        echo "\n== $t (7 dias) ==\n";
        foreach ($pdo->query("SELECT * FROM $t WHERE $col >= NOW() - INTERVAL 7 DAY ORDER BY 1 DESC LIMIT 10") as $r) {
            echo json_encode(array_filter($r, fn($v) => $v !== null && $v !== ''), JSON_UNESCAPED_UNICODE) . "\n";
        }
    } catch (Throwable $e) { echo "ERRO " . $e->getMessage() . "\n"; }
}
