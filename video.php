<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/config.php';
require_aluno();

$id = (string)($_GET['id'] ?? '');
if (!preg_match('/^[a-z0-9-]+$/', $id)) {
    http_response_code(400);
    exit;
}

$blobName = $id . '.mp4';
$expiry = gmdate('Y-m-d\TH:i:s\Z', time() + 4 * 3600);

$canonicalizedResource = '/blob/' . AZURE_STORAGE_ACCOUNT . '/' . AZURE_VIDEO_CONTAINER . '/' . $blobName;
$stringToSign = implode("\n", [
    'r',                // signedPermissions
    '',                 // signedStart
    $expiry,            // signedExpiry
    $canonicalizedResource,
    '',                 // signedIdentifier
    '',                 // signedIP
    'https',            // signedProtocol
    '2020-12-06',       // signedVersion
    'b',                // signedResource
    '',                 // signedSnapshotTime
    '',                 // signedEncryptionScope
    '',                 // rscc
    '',                 // rscd
    '',                 // rsce
    '',                 // rscl
    '',                 // rsct
]);
$signature = base64_encode(hash_hmac('sha256', $stringToSign, base64_decode(AZURE_STORAGE_KEY), true));

$query = http_build_query([
    'sv' => '2020-12-06',
    'sr' => 'b',
    'sp' => 'r',
    'se' => $expiry,
    'spr' => 'https',
    'sig' => $signature,
]);

$sasUrl = 'https://' . AZURE_STORAGE_ACCOUNT . '.blob.core.windows.net/' . AZURE_VIDEO_CONTAINER . '/' . $blobName . '?' . $query;

header('Cache-Control: private, max-age=0, no-cache');
header('Location: ' . $sasUrl, true, 302);
exit;
