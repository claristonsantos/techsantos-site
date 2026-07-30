<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/config.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

header('Content-Type: text/plain; charset=utf-8');

function raw_post(string $url, array $fields): void
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
    curl_close($ch);
    echo "HTTP {$httpCode}\n{$response}\n\n";
}

// Step 1: start (known-good, tested separately)
$ch = curl_init('https://graph.facebook.com/v21.0/' . META_PAGE_ID . '/video_stories');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query(['access_token' => META_PAGE_TOKEN, 'upload_phase' => 'start']),
    CURLOPT_TIMEOUT => 25,
]);
$startResp = curl_exec($ch);
curl_close($ch);
$start = json_decode($startResp, true);
echo "START: {$startResp}\n\n";

if (!empty($start['upload_url'])) {
    // rupload.facebook.com wants the token via Authorization header, not
    // as a POST field -- that's why the plain meta_http_post() call failed
    // with NotAuthorizedError even though the token itself is valid.
    $ch = curl_init($start['upload_url']);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: OAuth ' . META_PAGE_TOKEN,
            'file_url: https://techsantos.com.br/assets/social-video/storytime-mapa-continente.mp4',
        ],
        CURLOPT_POSTFIELDS => '',
        CURLOPT_TIMEOUT => 60,
    ]);
    $resp = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    echo "UPLOAD (header auth): HTTP {$code}\n{$resp}\n\n";
}

@unlink(__FILE__);
