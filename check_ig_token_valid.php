<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/meta_social.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');

$error = null;
$data = meta_http_get(meta_ig_graph_url('me'), ['fields' => 'id,username', 'access_token' => META_IG_TOKEN], $error);
if ($data === null) {
    echo "FAILED: $error\n";
} else {
    echo "OK: " . json_encode($data) . "\n";
}
@unlink(__FILE__);
