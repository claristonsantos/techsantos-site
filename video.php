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

// Fora do public_html de propósito: todo deploy do site é wipe+replace
// total dessa pasta, então os vídeos ficariam apagados a cada deploy se
// estivessem dentro dela.
$path = __DIR__ . '/../private-videos/' . $id . '.mp4';
if (!is_file($path)) {
    http_response_code(404);
    exit;
}

// Só o player da área do aluno pode pedir o arquivo: o navegador marca
// requisições do <video> com Sec-Fetch-Dest: video. Abrir a URL direto na aba
// ("document") ou baixar por link/fetch ("empty") é recusado. Navegador que
// não manda o cabeçalho passa (sessão de aluno continua obrigatória).
$dest = (string)($_SERVER['HTTP_SEC_FETCH_DEST'] ?? '');
if ($dest !== '' && $dest !== 'video') {
    http_response_code(403);
    exit;
}

$size = filesize($path);
$start = 0;
$end = $size - 1;

header('Content-Type: video/mp4');
header('Accept-Ranges: bytes');
header('Content-Disposition: inline');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: private, max-age=0, no-cache');

// Suporte a Range é obrigatório aqui: sem ele, o player não consegue
// avançar/retroceder no vídeo (o navegador pede um trecho específico de
// bytes ao arrastar a barra, não o arquivo inteiro de novo).
$range = $_SERVER['HTTP_RANGE'] ?? '';
if ($range !== '' && preg_match('/bytes=(\d*)-(\d*)/', $range, $m)) {
    if ($m[1] !== '') {
        $start = (int)$m[1];
    }
    if ($m[2] !== '') {
        $end = min((int)$m[2], $size - 1);
    }
    if ($start > $end || $start >= $size) {
        http_response_code(416);
        header("Content-Range: bytes */{$size}");
        exit;
    }
    http_response_code(206);
    header("Content-Range: bytes {$start}-{$end}/{$size}");
} else {
    http_response_code(200);
}

$length = $end - $start + 1;
header("Content-Length: {$length}");

$fh = fopen($path, 'rb');
if ($fh === false) {
    http_response_code(500);
    exit;
}
fseek($fh, $start);
$remaining = $length;
$chunk = 8192;
while ($remaining > 0 && !feof($fh)) {
    $read = (int)min($chunk, $remaining);
    echo fread($fh, $read);
    flush();
    $remaining -= $read;
}
fclose($fh);
