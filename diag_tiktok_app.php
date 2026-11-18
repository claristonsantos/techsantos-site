<?php
declare(strict_types=1);
require_once __DIR__ . '/tiktok_api.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: confere a chave PÚBLICA (client_key) do app TikTok salva no banco. Não exibe o secret.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$a = tt_app();
if (!$a) { echo "sem app salvo\n"; exit; }
$k = $a['client_key'];
echo "ambiente=" . $a['ambiente'] . "\nclient_key=" . $k . "\nlen_key=" . strlen($k) . "\nkey_tem_espaco_ou_quebra=" . (preg_match('/\s/', $k) ? 'SIM' : 'nao') . "\nlen_secret=" . strlen($a['client_secret']) . "\nconta_conectada=" . (tt_account() ? 'sim' : 'nao') . "\n";
echo "auth_url=" . tt_auth_url('teste') . "\n";
