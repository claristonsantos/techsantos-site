<?php
declare(strict_types=1);
// Receptor temporário de vídeos das aulas: grava em pedaços em ../private-videos/<id>.mp4
// (fora do public_html), confere tamanho e SHA-256 no fim. Apaga a si mesmo com acao=fim.
require_once __DIR__ . '/config.php';
header('Content-Type: text/plain; charset=utf-8');
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }

$PERMITIDOS = ['fab-o-que-e-fabric', 'fab-licencas-capacidades', 'fab-tenant-workspace-itens'];
$dir = dirname(__DIR__) . '/private-videos';
$acao = $_GET['acao'] ?? '';

if ($acao === 'fim') { @unlink(__FILE__); exit("REMOVIDO\n"); }

$id = $_GET['id'] ?? '';
if (!in_array($id, $PERMITIDOS, true)) { http_response_code(400); exit('id invalido'); }
if (!is_dir($dir)) { http_response_code(500); exit('sem private-videos'); }
$part = "$dir/$id.mp4.part";
$final = "$dir/$id.mp4";

if ($acao === 'chunk') {
    $offset = (int)($_GET['offset'] ?? -1);
    $atual = is_file($part) ? filesize($part) : 0;
    if ($offset === 0 && $atual > 0) { unlink($part); $atual = 0; }
    if ($offset !== $atual) { http_response_code(409); exit("offset $atual"); }
    $in = fopen('php://input', 'rb'); $out = fopen($part, 'ab');
    $n = stream_copy_to_stream($in, $out); fclose($in); fclose($out);
    clearstatcache();
    exit('OK ' . filesize($part) . " (+$n)\n");
}
if ($acao === 'concluir') {
    $tam = (int)($_GET['tamanho'] ?? -1); $sha = strtolower((string)($_GET['sha256'] ?? ''));
    if (!is_file($part)) { http_response_code(404); exit('sem parte'); }
    clearstatcache();
    if (filesize($part) !== $tam) { http_response_code(409); exit('tamanho ' . filesize($part)); }
    if (hash_file('sha256', $part) !== $sha) { http_response_code(409); exit('sha diferente'); }
    rename($part, $final);
    exit("PUBLICADO $id " . filesize($final) . "\n");
}
if ($acao === 'listar') {
    foreach ($PERMITIDOS as $p) echo $p, ' ', is_file("$dir/$p.mp4") ? filesize("$dir/$p.mp4") : '-', "\n";
    exit;
}
http_response_code(400); echo 'acao?';
