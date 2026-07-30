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
 * POST to Meta's resumable-upload endpoints (rupload.facebook.com), which
 * take the access token via an Authorization header and other parameters
 * (like file_url) as headers too — NOT as POST body fields the way every
 * other Graph API call in this file works. Sending them as body fields
 * fails with a misleading "NotAuthorizedError: User not authorized to
 * perform this request" even though the token itself is valid — confirmed
 * empirically 2026-07-23 while debugging the first real Facebook Story
 * publish attempt.
 */
function meta_http_post_upload(string $url, string $accessToken, array $headers, ?string &$error = null): ?array
{
    $headerLines = ['Authorization: OAuth ' . $accessToken];
    foreach ($headers as $key => $value) {
        $headerLines[] = "{$key}: {$value}";
    }

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => '',
        CURLOPT_HTTPHEADER => $headerLines,
        CURLOPT_TIMEOUT => 60,
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    $data = $response !== false ? json_decode($response, true) : null;

    if ($response === false || $httpCode < 200 || $httpCode >= 300 || !is_array($data)) {
        $error = $curlError ?: ($data['debug_info']['message'] ?? $data['error']['message'] ?? ('HTTP ' . $httpCode));
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
 *
 * When $linkUrl is given, this always posts via /feed with a real `link`
 * field — Meta scrapes that URL's own OG tags to build a clickable preview
 * card (title/description/image), which is what makes the link tappable at
 * all; a plain-text URL inside `message` is never clickable on Facebook.
 * $imageUrl is ignored in that case (a /feed link post can't be paired with
 * a separate custom photo through this simple form — the card's image
 * always comes from the destination page itself).
 */
function meta_schedule_facebook_post(string $message, ?string $imageUrl, int $scheduledUnixTime, ?string &$error = null, ?string $linkUrl = null): ?string
{
    $fields = [
        'access_token' => META_PAGE_TOKEN,
        'published' => 'false',
        'scheduled_publish_time' => (string)$scheduledUnixTime,
    ];

    if ($linkUrl) {
        $fields['message'] = $message;
        $fields['link'] = $linkUrl;
        $data = meta_graph_post(META_PAGE_ID . '/feed', $fields, $error);
    } elseif ($imageUrl) {
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
 * Publishes a Facebook Page Story from a public image or video URL. Two
 * distinct Graph API flows depending on media type — this is a separate
 * feature from meta_schedule_facebook_post() (which only ever targets the
 * Page feed): Stories use their own /photo_stories and /video_stories edges.
 * Facebook Stories have no native scheduling (same as Instagram), so this
 * must be called right when the story should go live, not ahead of time.
 * Returns the story-post id on success, or null (with $error set) on failure.
 */
function meta_publish_facebook_story(string $mediaUrl, bool $isVideo, ?string &$error = null): ?string
{
    if ($isVideo) {
        return meta_publish_facebook_video_story($mediaUrl, $error);
    }
    return meta_publish_facebook_photo_story($mediaUrl, $error);
}

function meta_publish_facebook_photo_story(string $imageUrl, ?string &$error = null): ?string
{
    // Photo Stories need a photo already uploaded (but unpublished to the
    // feed) first, then a second call turns that photo into a story.
    $photo = meta_graph_post(META_PAGE_ID . '/photos', [
        'access_token' => META_PAGE_TOKEN,
        'url' => $imageUrl,
        'published' => 'false',
    ], $error);

    if ($photo === null || empty($photo['id'])) {
        return null;
    }

    $story = meta_graph_post(META_PAGE_ID . '/photo_stories', [
        'access_token' => META_PAGE_TOKEN,
        'photo_id' => (string)$photo['id'],
    ], $error);

    if ($story === null) {
        return null;
    }

    return (string)($story['post_id'] ?? $story['id'] ?? '');
}

function meta_publish_facebook_video_story(string $videoUrl, ?string &$error = null): ?string
{
    $start = meta_graph_post(META_PAGE_ID . '/video_stories', [
        'access_token' => META_PAGE_TOKEN,
        'upload_phase' => 'start',
    ], $error);

    if ($start === null || empty($start['video_id']) || empty($start['upload_url'])) {
        $error = $error ?: 'Resposta de início de upload sem video_id/upload_url.';
        return null;
    }

    $videoId = (string)$start['video_id'];

    // The upload step hands the remote video URL to Meta's upload endpoint —
    // Meta fetches the bytes itself, we never download/re-upload the file.
    // Auth + file_url go via headers here, not POST fields (see
    // meta_http_post_upload's doc comment for why).
    $uploaded = meta_http_post_upload($start['upload_url'], META_PAGE_TOKEN, [
        'file_url' => $videoUrl,
    ], $error);

    if ($uploaded === null) {
        return null;
    }

    $finish = meta_graph_post(META_PAGE_ID . '/video_stories', [
        'access_token' => META_PAGE_TOKEN,
        'upload_phase' => 'finish',
        'video_id' => $videoId,
    ], $error);

    if ($finish === null) {
        return null;
    }

    return (string)($finish['post_id'] ?? $finish['id'] ?? $videoId);
}

/**
 * Publishes an Instagram carousel post (2-10 images, Meta's hard cap — not
 * a limitation of this code). Unlike the single image/video container flow
 * below, this runs synchronously start-to-finish in one call rather than
 * across multiple cron passes: creates every child container, polls each to
 * FINISHED, creates the CAROUSEL parent container referencing all children,
 * polls that, then publishes. Safe to do inline because carousel image
 * children normally reach FINISHED within a couple seconds — nothing like
 * video transcoding time. Returns the published media id, or null (with
 * $error set) on failure.
 */
function meta_publish_instagram_carousel(array $imageUrls, string $caption, ?string &$error = null): ?string
{
    if (count($imageUrls) < 2 || count($imageUrls) > 10) {
        $error = 'Carrossel precisa ter entre 2 e 10 imagens — limite do próprio Instagram.';
        return null;
    }

    $childIds = [];
    foreach ($imageUrls as $url) {
        $data = meta_http_post(meta_ig_graph_url(META_IG_USER_ID . '/media'), [
            'access_token' => META_IG_TOKEN,
            'image_url' => $url,
            'is_carousel_item' => 'true',
        ], $error);
        if ($data === null || empty($data['id'])) {
            return null;
        }
        $childIds[] = (string)$data['id'];
    }

    foreach ($childIds as $childId) {
        if (!meta_wait_instagram_container_finished($childId, $error)) {
            return null;
        }
    }

    $parent = meta_http_post(meta_ig_graph_url(META_IG_USER_ID . '/media'), [
        'access_token' => META_IG_TOKEN,
        'media_type' => 'CAROUSEL',
        'children' => implode(',', $childIds),
        'caption' => $caption,
    ], $error);
    if ($parent === null || empty($parent['id'])) {
        return null;
    }
    $parentId = (string)$parent['id'];

    if (!meta_wait_instagram_container_finished($parentId, $error)) {
        return null;
    }

    return meta_publish_instagram_container($parentId, $error);
}

/**
 * Polls a container (child or parent) until FINISHED, up to 30s. Shared by
 * the carousel flow above — regular single-media containers are polled by
 * social_publish_cron.php across cron ticks instead, since video can take
 * much longer than 30s to process.
 */
function meta_wait_instagram_container_finished(string $containerId, ?string &$error = null): bool
{
    $deadline = microtime(true) + 30;
    while (microtime(true) < $deadline) {
        $status = meta_get_instagram_container_status($containerId, $error);
        if ($status === 'FINISHED') {
            return true;
        }
        if ($status === 'ERROR' || $status === 'EXPIRED') {
            $error = "Container {$containerId}: {$status}";
            return false;
        }
        usleep(800000);
    }
    $error = "Container {$containerId}: timeout aguardando FINISHED";
    return false;
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
