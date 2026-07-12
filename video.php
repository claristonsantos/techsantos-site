<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_aluno();

$id = (string)($_GET['id'] ?? '');
if (!preg_match('/^[a-z0-9-]+$/', $id)) {
    http_response_code(400);
    exit;
}

$path = __DIR__ . '/private-videos/' . $id . '.mp4';
if (!is_file($path)) {
    http_response_code(404);
    exit;
}

$size = filesize($path);
$start = 0;
$end = $size - 1;

header('Content-Type: video/mp4');
header('Accept-Ranges: bytes');
header('Cache-Control: private, max-age=0, no-cache');

if (isset($_SERVER['HTTP_RANGE']) && preg_match('/bytes=(\d*)-(\d*)/', $_SERVER['HTTP_RANGE'], $m)) {
    if ($m[1] !== '') {
        $start = (int)$m[1];
    }
    if ($m[2] !== '') {
        $end = min((int)$m[2], $size - 1);
    }
    http_response_code(206);
    header("Content-Range: bytes $start-$end/$size");
}

$length = $end - $start + 1;
header('Content-Length: ' . (string)$length);

$fp = fopen($path, 'rb');
fseek($fp, $start);
$bytesSent = 0;
$bufferSize = 8192;
while (!feof($fp) && $bytesSent < $length) {
    $readSize = min($bufferSize, $length - $bytesSent);
    echo fread($fp, $readSize);
    $bytesSent += $readSize;
    flush();
}
fclose($fp);
