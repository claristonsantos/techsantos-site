<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$video = 'https://techsantos.com.br/assets/social-video/reel-dashboard-gatilho-2026.mp4';
$legenda = "Isso é um dashboard comercial sendo montado ao vivo, dentro do curso.\n\nCard por card, com os números reais aparecendo — sem trabalho manual, só configuração certa.\n\nComente 2026 que eu te mando o link da aula grátis no direct.";
$agendadoPara = '2026-07-21 10:00:00';

$ins = $pdo->prepare(
    "INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, agendado_para, status) VALUES ('instagram', 'reels', 'video', ?, ?, ?, 'pendente')"
);
$ins->execute([$legenda, $video, $agendadoPara]);

header('Content-Type: text/plain; charset=utf-8');
echo "Reels agendado pra {$agendadoPara} BRT (id " . $pdo->lastInsertId() . ")\n";

@unlink(__FILE__);
