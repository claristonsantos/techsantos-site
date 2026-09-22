<?php
declare(strict_types=1);
$key = $_GET['key'] ?? '';
require_once __DIR__ . '/config.php';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');

$newToken = "IGAGIxFkLnBDlBZAFpjZA1dycFVzLVRnbnp3bHpvTTY2N3JkcVZAUaXkwWW5mZAHRxOW1hcl9DTTR3cm5EdDA3bDRCSV9ab1BxcDZAiVFItRlJWY094M3JqVG9xcXhGeFo5UXlhZA3JnQVFvZA3JKOHNIUVZArN1dR";

$path = __DIR__ . '/config.php';
$content = file_get_contents($path);
if ($content === false) { echo "FAILED to read config.php\n"; @unlink(__FILE__); exit; }

$pattern = "/define\('META_IG_TOKEN',\s*'[^']*'\);/";
if (!preg_match($pattern, $content)) {
    echo "PATTERN NOT FOUND — META_IG_TOKEN define line not matched, no changes made.\n";
    @unlink(__FILE__);
    exit;
}

$newLine = "define('META_IG_TOKEN', '" . $newToken . "');";
$updated = preg_replace($pattern, $newLine, $content, 1);

if ($updated === $content) {
    echo "WARNING: replacement produced identical content (token may already match).\n";
}

$ok = file_put_contents($path, $updated);
echo $ok !== false ? "OK — META_IG_TOKEN updated (" . $ok . " bytes written)\n" : "FAILED to write config.php\n";

@unlink(__FILE__);
