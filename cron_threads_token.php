<?php
declare(strict_types=1);

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

// Renova todo dia o token do Threads (vale 60 dias e só pode ser renovado
// enquanto não expirou — se ninguém renovar, morre de vez, como aconteceu com
// o token do Instagram em 09/2026). Se a renovação e o teste falharem, avisa
// por e-mail para reconectar em /admin/social_setup.php.

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/meta_social.php';
require_once __DIR__ . '/config_writer.php';
require_once __DIR__ . '/mailer.php';

const THREADS_ALERT_TO = 'claristonsantos@hotmail.com';

$token = threads_cfg('META_THREADS_TOKEN');
if ($token === '') {
    echo date('Y-m-d H:i:s') . " - Threads ainda não conectado, nada a fazer\n";
    exit;
}

$error = null;
$res = meta_threads_refresh_token($token, $error);
if ($res !== null && !empty($res['access_token'])) {
    $saveError = null;
    if (config_set_define('META_THREADS_TOKEN', (string)$res['access_token'], $saveError)) {
        echo date('Y-m-d H:i:s') . " - token do Threads renovado (" . (int)round(((int)($res['expires_in'] ?? 0)) / 86400) . " dias)\n";
        exit;
    }
    $error = 'renovou mas não gravou: ' . $saveError;
}

// Renovação falhou (ex.: token com menos de 24h). Só alerta se o token atual
// também não funciona mais.
$meError = null;
if (meta_threads_me($token, $meError) !== null) {
    echo date('Y-m-d H:i:s') . " - renovação não aplicada ({$error}), mas o token atual ainda funciona\n";
    exit;
}

$msg = "O token de publicação do Threads parou de funcionar.\n\nErro: {$meError}\nRenovação: {$error}\n\nAté reconectar, os posts do Threads vão falhar. Reconecte em https://techsantos.com.br/admin/social_setup.php (botão \"Conectar com Threads\").";
echo date('Y-m-d H:i:s') . " - FALHA: {$meError}\n";
$html = '<p style="font-family:Arial,sans-serif; font-size:14px;">' . nl2br(htmlspecialchars($msg, ENT_QUOTES)) . '</p>';
send_html_email(THREADS_ALERT_TO, '[Threads] Token expirou/inválido — techsantos.com.br', $html, $msg);
