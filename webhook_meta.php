<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';

// Verification handshake: Meta calls this with hub.mode/hub.verify_token/hub.challenge
// (dots become underscores in $_GET) when the webhook is first configured.
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'GET') {
    if (($_GET['hub_mode'] ?? '') === 'subscribe' && hash_equals(META_WEBHOOK_VERIFY_TOKEN, (string)($_GET['hub_verify_token'] ?? ''))) {
        header('Content-Type: text/plain');
        echo (string)($_GET['hub_challenge'] ?? '');
        exit;
    }
    http_response_code(403);
    exit('Forbidden.');
}

$raw = file_get_contents('php://input') ?: '';
$data = json_decode($raw, true);

if (!is_array($data)) {
    http_response_code(400);
    exit('bad payload');
}

$object = (string)($data['object'] ?? '');
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';

// Try both app secrets: Meta may have consolidated the old child IG app's
// webhook subscription into the main app, so the signing secret for
// object=instagram payloads is no longer reliably META_IG_APP_SECRET.
$validSignature = meta_verify_webhook_signature($raw, $signature, META_APP_SECRET)
    || meta_verify_webhook_signature($raw, $signature, META_IG_APP_SECRET);

if (!$validSignature) {
    http_response_code(403);
    exit('invalid signature');
}

// Acknowledge quickly regardless of what we find below — Meta retries on
// non-200 responses, and we don't want duplicate processing.
http_response_code(200);

$pdo = db();

function handle_comment(PDO $pdo, string $plataforma, string $commentId, string $autorId, string $autorNome, string $texto): void
{
    $ourId = $plataforma === 'instagram' ? META_IG_USER_ID : META_PAGE_ID;
    if ($autorId === $ourId) {
        return; // avoid replying to our own comments
    }

    $exists = $pdo->prepare('SELECT id FROM social_auto_reply_log WHERE comment_id = ?');
    $exists->execute([$commentId]);
    if ($exists->fetch()) {
        return; // already processed (Meta may retry the same event)
    }

    $rules = $pdo->query("SELECT * FROM social_auto_reply_rules WHERE ativo = 1")->fetchAll();
    $matched = null;
    $textoLower = mb_strtolower($texto);
    foreach ($rules as $rule) {
        if (mb_strpos($textoLower, mb_strtolower($rule['palavra_chave'])) !== false) {
            $matched = $rule;
            break;
        }
    }

    if ($matched === null) {
        return;
    }

    $apiError = null;
    $sent = $plataforma === 'instagram'
        ? meta_send_instagram_private_reply($commentId, $matched['mensagem'], $apiError)
        : meta_send_facebook_private_reply($commentId, $matched['mensagem'], $apiError);

    $ins = $pdo->prepare(
        'INSERT INTO social_auto_reply_log (plataforma, comment_id, autor, texto_comentario, regra_id, status, erro_msg) VALUES (?, ?, ?, ?, ?, ?, ?)'
    );
    $ins->execute([
        $plataforma,
        $commentId,
        $autorNome,
        $texto,
        $matched['id'],
        $sent ? 'enviado' : 'falha',
        $sent ? null : $apiError,
    ]);
}

foreach ($data['entry'] ?? [] as $entry) {
    foreach ($entry['changes'] ?? [] as $change) {
        $field = $change['field'] ?? '';
        $value = $change['value'] ?? [];

        if ($object === 'page' && $field === 'feed' && ($value['item'] ?? '') === 'comment' && ($value['verb'] ?? '') === 'add') {
            handle_comment(
                $pdo,
                'facebook',
                (string)($value['comment_id'] ?? ''),
                (string)($value['from']['id'] ?? ''),
                (string)($value['from']['name'] ?? ''),
                (string)($value['message'] ?? '')
            );
        }

        if ($object === 'instagram' && $field === 'comments') {
            handle_comment(
                $pdo,
                'instagram',
                (string)($value['id'] ?? ''),
                (string)($value['from']['id'] ?? ''),
                (string)($value['from']['username'] ?? ''),
                (string)($value['text'] ?? '')
            );
        }
    }
}

echo 'ok';
