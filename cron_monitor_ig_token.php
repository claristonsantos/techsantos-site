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

// Nota: tentamos também checar dias restantes via /debug_token, mas esse
// endpoint devolve consistentemente "(#2) Service temporarily unavailable"
// pra tokens do fluxo "Instagram API com Login do Instagram" — não é falha
// passageira, é limitação real desse tipo de token. Sem essa info, o alerta
// fica reativo (dispara no primeiro dia em que o token já não funciona mais),
// mas isso já corta o tempo de detecção de 11 dias pra no máximo 24h.
