<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

/**
 * Integração com a API oficial do TikTok (Login Kit + Content Posting API + video.list),
 * usada só na nossa própria conta. Chaves do app e tokens ficam no BANCO (tabelas
 * tiktok_app / tiktok_tokens), não no config.php: o deploy substitui o config.php do
 * servidor e apagaria um token gravado lá.
 * Docs: developers.tiktok.com/doc/content-posting-api-reference-direct-post
 */

const TT_SCOPES = 'user.info.basic,video.publish,video.upload,video.list';
const TT_REDIRECT_URI = 'https://techsantos.com.br/admin/tiktok-callback.php';
const TT_MEDIA_PREFIX = 'https://media.techsantos.com.br/'; // domínio verificado para PULL_FROM_URL

function tt_schema(PDO $pdo): void
{
    $pdo->exec("CREATE TABLE IF NOT EXISTS tiktok_app (
        id TINYINT PRIMARY KEY,
        client_key VARCHAR(100) NOT NULL,
        client_secret VARCHAR(200) NOT NULL,
        ambiente VARCHAR(20) NOT NULL DEFAULT 'sandbox',
        atualizado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    $pdo->exec("CREATE TABLE IF NOT EXISTS tiktok_tokens (
        id TINYINT PRIMARY KEY,
        open_id VARCHAR(100) NOT NULL,
        access_token TEXT NOT NULL,
        refresh_token TEXT NOT NULL,
        expira_em DATETIME NOT NULL,
        refresh_expira_em DATETIME NOT NULL,
        scope VARCHAR(255) NOT NULL DEFAULT '',
        display_name VARCHAR(150) NULL,
        avatar_url TEXT NULL,
        atualizado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    $pdo->exec("CREATE TABLE IF NOT EXISTS tiktok_posts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        publish_id VARCHAR(100) NOT NULL,
        modo VARCHAR(10) NOT NULL,
        video_url TEXT NOT NULL,
        legenda TEXT NOT NULL,
        privacidade VARCHAR(40) NOT NULL,
        status VARCHAR(40) NOT NULL DEFAULT 'PROCESSING',
        detalhe TEXT NULL,
        criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        atualizado_em DATETIME NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
}

function tt_app(): ?array
{
    $pdo = db();
    tt_schema($pdo);
    $row = $pdo->query('SELECT client_key, client_secret, ambiente FROM tiktok_app WHERE id = 1')->fetch();
    return $row ?: null;
}

function tt_save_app(string $key, string $secret, string $ambiente): void
{
    $pdo = db();
    tt_schema($pdo);
    $pdo->prepare('REPLACE INTO tiktok_app (id, client_key, client_secret, ambiente) VALUES (1, ?, ?, ?)')
        ->execute([trim($key), trim($secret), $ambiente === 'producao' ? 'producao' : 'sandbox']);
    $pdo->exec('DELETE FROM tiktok_tokens'); // trocar de app invalida o token antigo
}

function tt_auth_url(string $state): ?string
{
    $app = tt_app();
    if (!$app) return null;
    return 'https://www.tiktok.com/v2/auth/authorize/?' . http_build_query([
        'client_key' => $app['client_key'], 'scope' => TT_SCOPES, 'response_type' => 'code',
        'redirect_uri' => TT_REDIRECT_URI, 'state' => $state,
    ]);
}

/** POST x-www-form-urlencoded (OAuth) ou JSON (demais endpoints). Retorna o JSON decodificado ou null. */
function tt_http(string $url, array $body, ?string $token, bool $json, ?string &$error): ?array
{
    $headers = $json ? ['Content-Type: application/json; charset=UTF-8'] : ['Content-Type: application/x-www-form-urlencoded'];
    if ($token !== null) $headers[] = 'Authorization: Bearer ' . $token;
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true, CURLOPT_POST => true, CURLOPT_TIMEOUT => 30, CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POSTFIELDS => $json ? ($body ? json_encode($body, JSON_UNESCAPED_UNICODE) : '{}') : http_build_query($body),
    ]);
    $resp = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlErr = curl_error($ch);
    curl_close($ch);
    if ($resp === false) { $error = 'Falha de conexão: ' . $curlErr; return null; }
    $data = json_decode((string)$resp, true);
    if (!is_array($data)) { $error = "HTTP $code: resposta inválida"; return null; }
    $apiErr = $data['error'] ?? null;
    if (is_array($apiErr) && ($apiErr['code'] ?? 'ok') !== 'ok') {
        $error = ($apiErr['code'] ?? '') . ': ' . ($apiErr['message'] ?? '');
        return null;
    }
    if (is_string($apiErr) && $apiErr !== '') { // erro no formato OAuth
        $error = $apiErr . ': ' . (string)($data['error_description'] ?? '');
        return null;
    }
    if ($code >= 400) { $error = "HTTP $code"; return null; }
    return $data;
}

function tt_get(string $url, string $token, ?string &$error): ?array
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 30, CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $token]]);
    $resp = curl_exec($ch);
    curl_close($ch);
    $data = json_decode((string)$resp, true);
    if (!is_array($data)) { $error = 'resposta inválida'; return null; }
    if (($data['error']['code'] ?? 'ok') !== 'ok') { $error = ($data['error']['code'] ?? '') . ': ' . ($data['error']['message'] ?? ''); return null; }
    return $data;
}

function tt_store_tokens(array $t): void
{
    $pdo = db();
    $pdo->prepare('REPLACE INTO tiktok_tokens (id, open_id, access_token, refresh_token, expira_em, refresh_expira_em, scope) VALUES (1, ?, ?, ?, DATE_ADD(NOW(), INTERVAL ? SECOND), DATE_ADD(NOW(), INTERVAL ? SECOND), ?)')
        ->execute([(string)($t['open_id'] ?? ''), (string)$t['access_token'], (string)$t['refresh_token'],
            max(60, (int)($t['expires_in'] ?? 0) - 300), (int)($t['refresh_expires_in'] ?? 0), (string)($t['scope'] ?? '')]);
}

function tt_exchange_code(string $code, ?string &$error): bool
{
    $app = tt_app();
    if (!$app) { $error = 'App não configurado'; return false; }
    $t = tt_http('https://open.tiktokapis.com/v2/oauth/token/', [
        'client_key' => $app['client_key'], 'client_secret' => $app['client_secret'], 'code' => $code,
        'grant_type' => 'authorization_code', 'redirect_uri' => TT_REDIRECT_URI,
    ], null, false, $error);
    if (!$t || empty($t['access_token'])) { $error = $error ?: 'sem access_token'; return false; }
    tt_store_tokens($t);
    tt_refresh_profile();
    return true;
}

/** Token válido (renova com o refresh_token quando vence). */
function tt_token(?string &$error = null): ?string
{
    $pdo = db();
    tt_schema($pdo);
    $row = $pdo->query('SELECT access_token, refresh_token, expira_em > NOW() AS valido, refresh_expira_em > NOW() AS refresh_valido FROM tiktok_tokens WHERE id = 1')->fetch();
    if (!$row) { $error = 'Conta do TikTok não conectada'; return null; }
    if ((int)$row['valido'] === 1) return (string)$row['access_token'];
    if ((int)$row['refresh_valido'] !== 1) { $error = 'Conexão expirada: conecte o TikTok de novo'; return null; }
    $app = tt_app();
    $t = tt_http('https://open.tiktokapis.com/v2/oauth/token/', [
        'client_key' => $app['client_key'], 'client_secret' => $app['client_secret'],
        'grant_type' => 'refresh_token', 'refresh_token' => (string)$row['refresh_token'],
    ], null, false, $error);
    if (!$t || empty($t['access_token'])) return null;
    tt_store_tokens($t);
    return (string)$t['access_token'];
}

function tt_refresh_profile(): void
{
    $err = null;
    $tok = tt_token($err);
    if (!$tok) return;
    $u = tt_get('https://open.tiktokapis.com/v2/user/info/?fields=open_id,avatar_url,display_name', $tok, $err);
    $user = $u['data']['user'] ?? null;
    if ($user) db()->prepare('UPDATE tiktok_tokens SET display_name = ?, avatar_url = ? WHERE id = 1')->execute([$user['display_name'] ?? null, $user['avatar_url'] ?? null]);
}

function tt_account(): ?array
{
    $pdo = db();
    tt_schema($pdo);
    $r = $pdo->query('SELECT open_id, display_name, avatar_url, scope, expira_em, refresh_expira_em FROM tiktok_tokens WHERE id = 1')->fetch();
    return $r ?: null;
}

function tt_disconnect(): void
{
    db()->exec('DELETE FROM tiktok_tokens');
}

/** creator_info: apelido, privacidades permitidas, interações bloqueadas e duração máxima. Obrigatório antes de postar. */
function tt_creator_info(?string &$error): ?array
{
    $tok = tt_token($error);
    if (!$tok) return null;
    $r = tt_http('https://open.tiktokapis.com/v2/post/publish/creator_info/query/', [], $tok, true, $error);
    return $r['data'] ?? null;
}

/** Publica (direct) ou envia como rascunho (draft) um vídeo hospedado em media.techsantos.com.br. */
function tt_post_video(string $modo, string $videoUrl, string $legenda, string $privacy, array $flags, ?string &$error): ?string
{
    if (strpos($videoUrl, TT_MEDIA_PREFIX) !== 0) { $error = 'O vídeo precisa estar em ' . TT_MEDIA_PREFIX; return null; }
    $tok = tt_token($error);
    if (!$tok) return null;
    $source = ['source' => 'PULL_FROM_URL', 'video_url' => $videoUrl];
    if ($modo === 'draft') {
        $r = tt_http('https://open.tiktokapis.com/v2/post/publish/inbox/video/init/', ['source_info' => $source], $tok, true, $error);
    } else {
        $r = tt_http('https://open.tiktokapis.com/v2/post/publish/video/init/', [
            'post_info' => [
                'title' => $legenda, 'privacy_level' => $privacy,
                'disable_comment' => !empty($flags['disable_comment']), 'disable_duet' => !empty($flags['disable_duet']),
                'disable_stitch' => !empty($flags['disable_stitch']),
                'brand_content_toggle' => !empty($flags['brand_content']), 'brand_organic_toggle' => !empty($flags['brand_organic']),
            ],
            'source_info' => $source,
        ], $tok, true, $error);
    }
    $id = $r['data']['publish_id'] ?? null;
    if (!$id) { $error = $error ?: 'sem publish_id'; return null; }
    db()->prepare('INSERT INTO tiktok_posts (publish_id, modo, video_url, legenda, privacidade) VALUES (?, ?, ?, ?, ?)')
        ->execute([$id, $modo === 'draft' ? 'draft' : 'direct', $videoUrl, $legenda, $modo === 'draft' ? '-' : $privacy]);
    return (string)$id;
}

function tt_post_status(string $publishId, ?string &$error): ?array
{
    $tok = tt_token($error);
    if (!$tok) return null;
    $r = tt_http('https://open.tiktokapis.com/v2/post/publish/status/fetch/', ['publish_id' => $publishId], $tok, true, $error);
    $d = $r['data'] ?? null;
    if ($d) db()->prepare('UPDATE tiktok_posts SET status = ?, detalhe = ?, atualizado_em = NOW() WHERE publish_id = ?')
        ->execute([(string)($d['status'] ?? ''), (string)($d['fail_reason'] ?? ''), $publishId]);
    return $d;
}

/** Nossos vídeos publicados (video.list). */
function tt_video_list(int $max, ?string &$error): ?array
{
    $tok = tt_token($error);
    if (!$tok) return null;
    $fields = 'id,title,video_description,cover_image_url,share_url,create_time,duration,view_count,like_count,comment_count,share_count';
    $r = tt_http('https://open.tiktokapis.com/v2/video/list/?fields=' . $fields, ['max_count' => min(20, max(1, $max))], $tok, true, $error);
    return $r['data']['videos'] ?? null;
}
