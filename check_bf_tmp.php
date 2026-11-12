<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: confere o que o seed da Black Friday gravou antes do erro 500.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$pdo = db();
echo "colunas regras: " . implode(',', array_column($pdo->query('SHOW COLUMNS FROM social_auto_reply_rules')->fetchAll(), 'Field')) . "\n";
foreach ($pdo->query("SELECT id, palavra_chave, ativo FROM social_auto_reply_rules WHERE palavra_chave LIKE '%BLACK%'")->fetchAll() as $r) echo "regra " . json_encode($r) . "\n";
$q = $pdo->query("SELECT id, canal, tipo, status, agendado_para, SUBSTRING_INDEX(imagem_url,'/',-1) AS arq, meta_post_id FROM social_posts
  WHERE imagem_url LIKE '%promo-bf-%' OR imagem_url LIKE '%-bf.jpg' OR imagem_url LIKE '%black-friday-4-cursos%' OR legenda LIKE '%black-friday-2026%' ORDER BY agendado_para, canal");
foreach ($q->fetchAll() as $r) echo implode(' | ', array_map('strval', $r)) . "\n";
$err = ini_get('error_log');
echo "error_log: " . var_export($err, true) . "\n";
foreach ([$err, dirname(__DIR__) . '/logs/error_log', __DIR__ . '/error_log'] as $f) {
    if ($f && is_file($f)) { $l = file($f); echo "--- $f\n" . implode('', array_slice($l, -15)); }
}
