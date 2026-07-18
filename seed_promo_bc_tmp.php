<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/config.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('forbidden');
}

$pdo = db();
header('Content-Type: text/plain; charset=utf-8');

$capB = "O chefe pergunta um número e você trava procurando a planilha certa?\n\nCom Power BI, o número certo aparece na tela, na hora — modelo de dados pronto, medida DAX que responde na hora, dashboard sempre atualizado.\n\nChega de travar na frente de todo mundo. Aprenda no curso completo: link na bio.";
$capC = "Enquanto você só usa o Excel, tem gente do seu lado virando a pessoa de dados do time.\n\nAprenda modelagem de dados, Power Query e DAX — com portfólio real e certificado pra colocar no currículo.\n\nSua próxima promoção começa aqui. Link na bio.";

$rows = [
    ['instagram', 'reels', 'video', 'https://techsantos.com.br/assets/social-video/promo-reels-b.mp4', $capB, '2026-07-18 14:00:00'],
    ['instagram', 'story', 'video', 'https://techsantos.com.br/assets/social-video/promo-reels-b.mp4', $capB, '2026-07-18 14:05:00'],
    ['instagram', 'reels', 'video', 'https://techsantos.com.br/assets/social-video/promo-reels-c.mp4', $capC, '2026-07-18 14:10:00'],
    ['instagram', 'story', 'video', 'https://techsantos.com.br/assets/social-video/promo-reels-c.mp4', $capC, '2026-07-18 14:15:00'],
];

$stmt = $pdo->prepare(
    "INSERT INTO social_posts (canal, tipo, midia_tipo, imagem_url, legenda, agendado_para, status)
     VALUES (?, ?, ?, ?, ?, ?, 'pendente')"
);

foreach ($rows as $r) {
    $stmt->execute($r);
    echo "inserido id=" . $pdo->lastInsertId() . " {$r[0]}/{$r[1]} agendado_para={$r[5]} UTC\n";
}

@unlink(__FILE__);
