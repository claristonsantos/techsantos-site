<?php
declare(strict_types=1);
require_once __DIR__ . '/tiktok_api.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: apaga as "chaves" do app TikTok que o navegador preencheu sozinho com login/senha salvos.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$pdo = db();
tt_schema($pdo);
$pdo->exec('DELETE FROM tiktok_tokens');
$n = $pdo->exec('DELETE FROM tiktok_app');
echo "apagado tiktok_app: $n\nrestantes: " . (int)$pdo->query('SELECT COUNT(*) FROM tiktok_app')->fetchColumn() . "\n";
