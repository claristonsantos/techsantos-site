<?php
declare(strict_types=1);

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/meta_social.php';
require_once __DIR__ . '/mailer.php';

const MONITOR_ALERT_TO = 'claristonsantos@hotmail.com';

function alerta(string $assunto, string $mensagem): void
{
    $html = '<p style="font-family:Arial,sans-serif; font-size:15px;"><strong>' . htmlspecialchars($assunto, ENT_QUOTES) . '</strong></p>'
        . '<p style="font-family:Arial,sans-serif; font-size:14px; color:#48546A;">' . nl2br(htmlspecialchars($mensagem, ENT_QUOTES)) . '</p>'
        . '<p style="font-family:Arial,sans-serif; font-size:13px; color:#7C8798;">Detectado automaticamente em ' . date('d/m/Y H:i:s') . '.</p>';
    $text = $assunto . "\n\n" . $mensagem . "\n\nDetectado automaticamente em " . date('d/m/Y H:i:s') . '.';
    send_html_email(MONITOR_ALERT_TO, '[Instagram] ' . $assunto . ' — techsantos.com.br', $html, $text);
}

$error = null;
$me = meta_http_get(meta_ig_graph_url('me'), ['fields' => 'id,username', 'access_token' => META_IG_TOKEN], $error);

if ($me === null) {
    $msg = "O token de publicação do Instagram (META_IG_TOKEN) parou de funcionar.\n\nErro: {$error}\n\nAté reconectar, nenhum Reels/Story vai publicar — eles vão se acumular como 'erro' na fila. Reconecte em /admin/social_setup.php (botão \"Conectar com Instagram\", login @tech_santos_br) e passe o novo token pra atualizar o config.php do servidor.";
    echo date('Y-m-d H:i:s') . " - FALHA: {$error}\n";
    alerta('Token do Instagram expirou/inválido', $msg);
    exit;
}

echo date('Y-m-d H:i:s') . " - token ok (@{$me['username']})\n";

// Verifica quanto tempo falta pro vencimento (tokens de usuário do Instagram
// duram ~60 dias) usando o inspetor de token do Graph com o token do próprio
// app — evita descobrir só quando já parou de publicar, como aconteceu em 11/09.
$debugError = null;
$appToken = META_APP_ID . '|' . META_APP_SECRET;
$debug = meta_http_get(meta_graph_url('debug_token'), ['input_token' => META_IG_TOKEN, 'access_token' => $appToken], $debugError);

if ($debug === null || empty($debug['data']['expires_at'])) {
    echo date('Y-m-d H:i:s') . " - nao foi possivel checar validade/expiracao: " . ($debugError ?? 'expires_at ausente') . "\n";
    exit;
}

$expiresAt = (int)$debug['data']['expires_at'];
$diasRestantes = (int)floor(($expiresAt - time()) / 86400);
echo date('Y-m-d H:i:s') . " - expira em {$diasRestantes} dia(s) (" . date('d/m/Y', $expiresAt) . ")\n";

if ($diasRestantes <= 7) {
    $msg = "O token de publicação do Instagram vence em {$diasRestantes} dia(s), em " . date('d/m/Y', $expiresAt) . ".\n\nReconecte antes disso em /admin/social_setup.php (botão \"Conectar com Instagram\", login @tech_santos_br) pra não repetir o que aconteceu em 11/09 (11 dias sem publicar sem ninguém perceber).";
    alerta('Token do Instagram vence em breve', $msg);
}
