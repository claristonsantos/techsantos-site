<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
echo "NOW UTC: " . $pdo->query("SELECT NOW()")->fetchColumn() . "\n";
foreach ($pdo->query("SELECT id, canal, tipo, status, agendado_para, imagem_url FROM social_posts WHERE agendado_para >= '2026-09-30' ORDER BY agendado_para") as $r) {
    echo "#{$r['id']} {$r['canal']} {$r['tipo']} {$r['status']} {$r['agendado_para']} " . basename((string)$r['imagem_url']) . "\n";
}
echo "--- auto reply rules ---\n";
foreach ($pdo->query("SELECT * FROM social_auto_reply_rules ORDER BY id") as $r) {
    echo "#{$r['id']} ativo={$r['ativo']} kw={$r['palavra_chave']} | " . mb_substr(str_replace("\n", ' ', (string)($r['resposta'] ?? $r['mensagem'] ?? '')), 0, 90) . "\n";
}
@unlink(__FILE__);
