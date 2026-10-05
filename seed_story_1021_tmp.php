<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$url = 'https://media.techsantos.com.br/stories/2026-10/1021-3-reel.jpg';
$h = @get_headers($url, true);
if (!is_array($h) || !str_contains((string)($h[0] ?? ''), '200')) { echo "MIDIA_ERRO " . ($h[0] ?? '') . "\n"; @unlink(__FILE__); exit; }
$pdo = db();
$e = $pdo->prepare("SELECT id FROM social_posts WHERE tipo='story' AND imagem_url=?"); $e->execute([$url]);
if ($e->fetchColumn()) { echo "IGNORADO\n"; } else {
    $pdo->prepare("INSERT INTO social_posts (canal,tipo,midia_tipo,legenda,imagem_url,link_url,agendado_para,status) VALUES ('instagram','story','imagem','',?,NULL,'2026-10-21 15:10:00','pendente')")->execute([$url]);
    echo "OK id=" . $pdo->lastInsertId() . "\n";
}
@unlink(__FILE__);
