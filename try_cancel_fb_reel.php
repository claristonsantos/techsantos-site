<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');

$videoId = '1755043359963227'; // dica-copilot-resumo, id 232 — test subject only

function try_post(string $videoId, array $body, string $label): void {
    $ch = curl_init('https://graph.facebook.com/v21.0/' . $videoId);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($body + ['access_token' => META_PAGE_TOKEN]),
        CURLOPT_TIMEOUT => 20,
    ]);
    $response = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    echo "$label | HTTP $code | $response\n";
}

try_post($videoId, ['video_state' => 'DRAFT'], 'set video_state=DRAFT');
try_post($videoId, ['is_published' => 'false'], 'set is_published=false');

@unlink(__FILE__);
