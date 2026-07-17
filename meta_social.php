<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

const META_GRAPH_VERSION = 'v21.0';

function meta_graph_url(string $path): string
{
    return 'https://graph.facebook.com/' . META_GRAPH_VERSION . '/' . ltrim($path, '/');
}

function meta_ig_graph_url(string $path): string
{
    return 'https://graph.instagram.com/' . META_GRAPH_VERSION . '/' . ltrim($path, '/');
}

/**
 * Low-level POST against a full URL. Returns the decoded JSON body on
 * success, or null on failure (with $error filled in by reference).
 */
function meta_http_post(string $url, array $fields, ?string &$error = null): ?array
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($fields),
        CURLOPT_TIMEOUT => 25,
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    $data = $response !== false ? json_decode($response, true) : null;

    if ($response === false || $httpCode < 200 || $httpCode >= 300 || !is_array($data)) {
        $error = $curlError ?: ($data['error']['message'] ?? ('HTTP ' . $httpCode));
        return null;
    }

    return $data;
}

/**
 * Low-level GET against a full URL.
 */
function meta_http_get(string $url, array $query, ?string &$error = null): ?array
{
    $ch = curl_init($url . '?' . http_build_query($query));
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 25,
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    $data = $response !== false ? json_decode($response, true) : null;

    if ($response === false || $httpCode < 200 || $httpCode >= 300 || !is_array($data)) {
        $error = $curlError ?: ($data['error']['message'] ?? ('HTTP ' . $httpCode));
        return null;
    }

    return $data;
}

function meta_graph_post(string $path, array $fields, ?string &$error = null): ?array
{
    return meta_http_post(meta_graph_url($path), $fields, $error);
}

function meta_graph_get(string $path, array $query, ?string &$error = null): ?array
{
    return meta_http_get(meta_graph_url($path), $query, $error);
}

/**
 * Schedules a Facebook Page post. Meta holds and publishes it automatically
 * at $scheduledUnixTime — no cron needed on our side for Facebook.
 * Returns the scheduled post id on success, or null (with $error set) on failure.
 */
function meta_schedule_facebook_post(string $message, ?string $imageUrl, int $scheduledUnixTime, ?string &$error = null): ?string
{
    $fields = [
        'access_token' => META_PAGE_TOKEN,
        'published' => 'false',
        'scheduled_publish_time' => (string)$scheduledUnixTime,
    ];

    if ($imageUrl) {
        $fields['url'] = $imageUrl;
        $fields['caption'] = $message;
        $data = meta_graph_post(META_PAGE_ID . '/photos', $fields, $error);
    } else {
        $fields['message'] = $message;
        $data = meta_graph_post(META_PAGE_ID . '/feed', $fields, $error);
    }

    if ($data === null) {
        return null;
    }

    return (string)($data['post_id'] ?? $data['id'] ?? '');
}

/**
 * Cancels a scheduled (not-yet-published) Facebook Page post.
 */
function meta_delete_facebook_post(string $postId, ?string &$error = null): bool
{
    $ch = curl_init(meta_graph_url($postId) . '?' . http_build_query(['access_token' => META_PAGE_TOKEN]));
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'DELETE',
        CURLOPT_TIMEOUT => 25,
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $data = $response !== false ? json_decode($response, true) : null;

    if ($httpCode < 200 || $httpCode >= 300 || !is_array($data) || empty($data['success'])) {
        $error = $data['error']['message'] ?? ('HTTP ' . $httpCode);
        return false;
    }

    return true;
}

/**
 * Step 1 of Instagram publishing: creates a media container. Must be followed
 * by meta_publish_instagram_container() to actually make it go live — Instagram
 * has no native scheduling, so this pair must run at the intended publish time.
 * Uses graph.instagram.com with META_IG_TOKEN (Instagram API with Instagram
 * Login — a separate token from the Facebook Page token).
 *
 * $mediaType: 'FEED' (default, image), 'STORIES' (image or video), or 'REELS'
 * (video only). Poll meta_get_instagram_container_status() until FINISHED
 * before publishing — this matters for video, but also for images, since
 * Meta may not have finished fetching image_url immediately after creation.
 */
function meta_create_instagram_container(string $mediaUrl, string $caption, ?string &$error = null, string $mediaType = 'FEED', bool $isVideo = false): ?string
{
    $fields = [
        'access_token' => META_IG_TOKEN,
        'caption' => $caption,
    ];

    if ($isVideo) {
        $fields['video_url'] = $mediaUrl;
    } else {
        $fields['image_url'] = $mediaUrl;
    }

    if ($mediaType === 'STORIES') {
        $fields['media_type'] = 'STORIES';
    } elseif ($mediaType === 'REELS') {
        $fields['media_type'] = 'REELS';
    }

    $data = meta_http_post(meta_ig_graph_url(META_IG_USER_ID . '/media'), $fields, $error);

    if ($data === null) {
        return null;
    }

    return (string)($data['id'] ?? '');
}

function meta_publish_instagram_container(string $containerId, ?string &$error = null): ?string
{
    $data = meta_http_post(meta_ig_graph_url(META_IG_USER_ID . '/media_publish'), [
        'access_token' => META_IG_TOKEN,
        'creation_id' => $containerId,
    ], $error);

    if ($data === null) {
        return null;
    }

    return (string)($data['id'] ?? '');
}

/**
 * Polls an Instagram media container's processing status. Used for every
 * container (image or video) before publishing — Meta may still be fetching
 * image_url/video_url right after container creation, and publishing too
 * early fails with "Media ID is not available".
 * Returns one of IN_PROGRESS / FINISHED / ERROR / EXPIRED, or null on API failure.
 */
function meta_get_instagram_container_status(string $containerId, ?string &$error = null): ?string
{
    $data = meta_http_get(meta_ig_graph_url($containerId), [
        'access_token' => META_IG_TOKEN,
        'fields' => 'status_code',
    ], $error);

    if ($data === null) {
        return null;
    }

    return (string)($data['status_code'] ?? '');
}

/**
 * Sends a private reply to a Facebook Page comment (Messenger "Private Replies").
 * Only works within Meta's messaging window after the comment was posted.
 */
function meta_send_facebook_private_reply(string $commentId, string $message, ?string &$error = null): bool
{
    $data = meta_graph_post('me/messages', [
        'access_token' => META_PAGE_TOKEN,
        'recipient' => json_encode(['comment_id' => $commentId]),
        'message' => json_encode(['text' => $message]),
    ], $error);

    return $data !== null && isset($data['message_id']);
}

/**
 * Sends a private reply to an Instagram comment.
 */
function meta_send_instagram_private_reply(string $commentId, string $message, ?string &$error = null): bool
{
    // Instagram API with Instagram Login sends private replies through the unified
    // messaging endpoint (POST /{ig-user-id}/messages), not the legacy
    // /{comment-id}/private_replies edge — the comment being replied to is identified
    // via the recipient.comment_id field in the body, both JSON-encoded as strings.
    $data = meta_http_post(meta_ig_graph_url(META_IG_USER_ID . '/messages'), [
        'access_token' => META_IG_TOKEN,
        'recipient' => json_encode(['comment_id' => $commentId]),
        'message' => json_encode(['text' => $message]),
    ], $error);

    return $data !== null;
}

/**
 * Verifies a Meta webhook's X-Hub-Signature-256 header against the raw request
 * body using the given app secret. Always use hash_equals (timing-safe).
 */
function meta_verify_webhook_signature(string $rawBody, string $signatureHeader, string $secret): bool
{
    if (!str_starts_with($signatureHeader, 'sha256=')) {
        return false;
    }

    $expected = 'sha256=' . hash_hmac('sha256', $rawBody, $secret);
    return hash_equals($expected, $signatureHeader);
}

/**
 * One-time setup helper: exchanges a short-lived Facebook user token (from the
 * Graph API Explorer) for a long-lived one, then resolves the Page access token.
 * Used only by admin/social_setup.php.
 */
function meta_exchange_long_lived_token(string $shortLivedToken, ?string &$error = null): ?string
{
    $data = meta_graph_get('oauth/access_token', [
        'grant_type' => 'fb_exchange_token',
        'client_id' => META_APP_ID,
        'client_secret' => META_APP_SECRET,
        'fb_exchange_token' => $shortLivedToken,
    ], $error);

    if ($data === null) {
        return null;
    }

    return (string)($data['access_token'] ?? '');
}

function meta_list_pages(string $longLivedUserToken, ?string &$error = null): ?array
{
    $data = meta_graph_get('me/accounts', ['access_token' => $longLivedUserToken], $error);

    if ($data === null) {
        return null;
    }

    return $data['data'] ?? [];
}

/**
 * Instagram API with Instagram Login — real OAuth flow. A token minted via the
 * App Dashboard's "generate token for tester" shortcut cannot be exchanged for
 * a long-lived token; only a token obtained through this authorize → code →
 * token flow can.
 */
function meta_instagram_authorize_url(): string
{
    return 'https://api.instagram.com/oauth/authorize?' . http_build_query([
        'client_id' => META_IG_APP_ID,
        'redirect_uri' => META_IG_REDIRECT_URI,
        'response_type' => 'code',
        'scope' => 'instagram_business_basic,instagram_business_content_publish',
    ]);
}

function meta_instagram_exchange_code(string $code, ?string &$error = null): ?array
{
    return meta_http_post('https://api.instagram.com/oauth/access_token', [
        'client_id' => META_IG_APP_ID,
        'client_secret' => META_IG_APP_SECRET,
        'grant_type' => 'authorization_code',
        'redirect_uri' => META_IG_REDIRECT_URI,
        'code' => $code,
    ], $error);
}

function meta_instagram_exchange_long_lived(string $shortLivedToken, ?string &$error = null): ?array
{
    return meta_http_get(meta_ig_graph_url('access_token'), [
        'grant_type' => 'ig_exchange_token',
        'client_secret' => META_IG_APP_SECRET,
        'access_token' => $shortLivedToken,
    ], $error);
}
