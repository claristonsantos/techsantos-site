<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$videoUrl = 'https://techsantos.com.br/assets/social-video/promo-curso-1.mp4';
$agendadoPara = gmdate('Y-m-d H:i:s', time() + 60);

$pdo->prepare(
    "INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, agendado_para, status) VALUES ('instagram', 'story', 'video', ?, ?, ?, 'pendente')"
)->execute(['Teste de publicação de Story em vídeo — remover depois de confirmar.', $videoUrl, $agendadoPara]);

header('Content-Type: text/plain; charset=utf-8');
echo "Post de teste criado, id " . $pdo->lastInsertId() . ", agendado para {$agendadoPara} UTC\n";

@unlink(__FILE__);
