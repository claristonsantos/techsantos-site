<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$video = 'https://techsantos.com.br/assets/social-video/demo-comercial-dashboard.mp4';
$legenda = "Isso aqui é um Dashboard Comercial completo, rodando ao vivo — receita, lucro e clientes, tudo calculado automático.\n\nO ponto forte: simula um aumento de preço e mostra o impacto na receita e no lucro na hora, categoria por categoria.\n\nAprenda a montar o seu do zero no curso completo. Link na bio.";

$posts = [
    ['tipo' => 'story', 'agendado_para' => '2026-07-17 09:00:00'],
    ['tipo' => 'reels', 'agendado_para' => '2026-07-17 10:00:00'],
];

$ins = $pdo->prepare(
    "INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, agendado_para, status) VALUES ('instagram', ?, 'video', ?, ?, ?, 'pendente')"
);

$out = [];
foreach ($posts as $p) {
    $ins->execute([$p['tipo'], $legenda, $video, $p['agendado_para']]);
    $out[] = "{$p['tipo']} agendado pra {$p['agendado_para']} BRT (id " . $pdo->lastInsertId() . ")";
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
