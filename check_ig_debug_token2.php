<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/meta_social.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');

$appToken = META_APP_ID . '|' . META_APP_SECRET;
for ($i = 1; $i <= 3; $i++) {
    $error = null;
    $debug = meta_http_get(meta_graph_url('debug_token'), ['input_token' => META_IG_TOKEN, 'access_token' => $appToken], $error);
    echo "attempt $i: " . ($debug === null ? "FAILED: $error" : json_encode($debug)) . "\n";
    if ($debug !== null) break;
    sleep(2);
}
@unlink(__FILE__);
