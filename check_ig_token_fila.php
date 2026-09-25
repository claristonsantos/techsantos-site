<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$err = null;
$me = meta_http_get(meta_ig_graph_url('me'), ['fields' => 'id,username', 'access_token' => META_IG_TOKEN], $err);
echo $me ? "TOKEN OK @{$me['username']}\n" : "TOKEN FALHA: " . substr((string)$err, 0, 160) . "\n";
echo "config.php modificado em " . date('Y-m-d H:i:s', filemtime(__DIR__ . '/config.php')) . " (UTC)\n\n";
$stmt = db()->query("SELECT id, canal, tipo, status, agendado_para, LEFT(COALESCE(erro_msg,''),90) erro FROM social_posts WHERE agendado_para >= '2026-09-20' ORDER BY agendado_para");
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
    echo "#{$r['id']} {$r['canal']} {$r['tipo']} {$r['status']} {$r['agendado_para']}" . ($r['erro'] !== '' ? " | {$r['erro']}" : '') . "\n";
}
@unlink(__FILE__);
