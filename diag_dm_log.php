<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: DMs automáticas das últimas 72h (origem de pedido). Só leitura.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$pdo = db();
foreach ($pdo->query("SELECT l.*, r.palavra_chave FROM social_auto_reply_log l LEFT JOIN social_auto_reply_rules r ON r.id=l.regra_id ORDER BY l.id DESC LIMIT 15") as $r) {
    echo json_encode(array_filter($r, fn($v) => $v !== null && $v !== ''), JSON_UNESCAPED_UNICODE) . "\n";
}
echo "\n== posts publicados 72h ==\n";
foreach ($pdo->query("SELECT canal,tipo,agendado_para,LEFT(legenda,90) leg FROM social_posts WHERE status='publicado' AND agendado_para >= NOW() - INTERVAL 72 HOUR ORDER BY agendado_para") as $r) echo json_encode($r, JSON_UNESCAPED_UNICODE) . "\n";
