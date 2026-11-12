<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: aponta os Stories da Black Friday de 13, 25 e 30/11 para as versões verdes (identidade TECH SANTOS).
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$pdo = db();
$base = 'https://media.techsantos.com.br/stories/2026-11/';
$u = $pdo->prepare("UPDATE social_posts SET imagem_url = ? WHERE canal = 'instagram' AND tipo = 'story' AND imagem_url = ? AND status = 'pendente'");
foreach (['1113-bf', '1125-bf', '1130-bf'] as $n) {
    $u->execute([$base . $n . '-verde.jpg', $base . $n . '.jpg']);
    echo "$n: " . $u->rowCount() . "\n";
}
foreach ($pdo->query("SELECT id, status, agendado_para, SUBSTRING_INDEX(imagem_url,'/',-1) arq FROM social_posts WHERE imagem_url LIKE '%-bf%.jpg' ORDER BY agendado_para")->fetchAll() as $r) echo implode(' | ', $r) . "\n";
