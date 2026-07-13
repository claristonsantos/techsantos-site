<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

const META_GRAPH_VERSION = 'v21.0';

function meta_graph_url(string $path): string
{
    return 'https://graph.facebook.com/' . META_GRAPH_VERSION . '/' . ltrim($path, '/');
}

/**
 * Low-level POST to the Graph API. Returns the decoded JSON body on success,
 * or null on failure (with $error filled in by reference).
 */
function meta_graph_post(string $path, array $fields, ?string &$error = null): ?array
{
    $ch = curl_init(meta_graph_url($path));
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
 * Low-level GET to the Graph API.
 */
function meta_graph_get(string $path, array $query, ?string &$error = null): ?array
{
    $ch = curl_init(meta_graph_url($path) . '?' . http_build_query($query));
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
 * Step 1 of Instagram publishing: creates a media container. Must be followed
 * by meta_publish_instagram_container() to actually make it go live — Instagram
 * has no native scheduling, so this pair must run at the intended publish time.
 */
function meta_create_instagram_container(string $imageUrl, string $caption, ?string &$error = null): ?string
{
    $data = meta_graph_post(META_IG_USER_ID . '/media', [
        'access_token' => META_PAGE_TOKEN,
        'image_url' => $imageUrl,
        'caption' => $caption,
    ], $error);

    if ($data === null) {
        return null;
    }

    return (string)($data['id'] ?? '');
}

function meta_publish_instagram_container(string $containerId, ?string &$error = null): ?string
{
    $data = meta_graph_post(META_IG_USER_ID . '/media_publish', [
        'access_token' => META_PAGE_TOKEN,
        'creation_id' => $containerId,
    ], $error);

    if ($data === null) {
        return null;
    }

    return (string)($data['id'] ?? '');
}

/**
 * One-time setup helper: exchanges a short-lived user token (from the Graph
 * API Explorer) for a long-lived one, then resolves the Page access token and
 * the linked Instagram Business Account id. Used only by admin/social_setup.php.
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

function meta_get_instagram_business_id(string $pageId, string $pageAccessToken, ?string &$error = null): ?string
{
    $data = meta_graph_get($pageId, [
        'fields' => 'instagram_business_account',
        'access_token' => $pageAccessToken,
    ], $error);

    if ($data === null) {
        return null;
    }

    return $data['instagram_business_account']['id'] ?? null;
}
