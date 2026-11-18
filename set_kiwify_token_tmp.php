<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';
// Uso único: grava KIWIFY_WEBHOOK_TOKEN no config.php do servidor (o token chega por POST, não fica no git).
header('Content-Type: text/plain; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !hash_equals(SETUP_KEY, (string)($_POST['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
@unlink(__FILE__);
$token = (string)($_POST['token'] ?? '');
if (!preg_match('/^[A-Za-z0-9]{8,64}$/', $token)) { http_response_code(400); exit('token invalido'); }
if (defined('KIWIFY_WEBHOOK_TOKEN')) exit('ja definido');
$cfg = __DIR__ . '/config.php';
$s = (string)file_get_contents($cfg);
if (preg_match('/\?>\s*$/', $s)) { http_response_code(500); exit('config termina com ?>'); }
$ok = file_put_contents($cfg, rtrim($s) . "\n\n// Kiwify: token do webhook (Apps > Webhooks), valida a assinatura HMAC-SHA1.\ndefine('KIWIFY_WEBHOOK_TOKEN', '" . $token . "');\n", LOCK_EX);
echo $ok ? 'ok' : 'falha ao gravar';
