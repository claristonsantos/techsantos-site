<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../tiktok_api.php';
require_admin();

// Retorno do Login Kit do TikTok: valida o state (anti-CSRF) e troca o code pelo token.
$state = (string)($_GET['state'] ?? '');
$esperado = (string)($_SESSION['tt_oauth_state'] ?? '');
unset($_SESSION['tt_oauth_state']);

if (isset($_GET['error'])) {
    $_SESSION['tt_flash'] = ['erro', 'Conexão cancelada no TikTok: ' . (string)($_GET['error_description'] ?? $_GET['error'])];
} elseif ($esperado === '' || !hash_equals($esperado, $state)) {
    $_SESSION['tt_flash'] = ['erro', 'Retorno do TikTok inválido (state não confere). Tente conectar de novo.'];
} else {
    $err = null;
    if (tt_exchange_code((string)($_GET['code'] ?? ''), $err)) {
        $_SESSION['tt_flash'] = ['ok', 'Conta do TikTok conectada.'];
    } else {
        $_SESSION['tt_flash'] = ['erro', 'Falha ao conectar: ' . $err];
    }
}
header('Location: /admin/tiktok.php');
exit;
