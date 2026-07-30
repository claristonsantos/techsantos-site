<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();

$urls = [
    'https://techsantos.com.br/assets/social-feed/carrossel-modulos/01.png',
    'https://techsantos.com.br/assets/social-feed/carrossel-modulos/02.png',
    'https://techsantos.com.br/assets/social-feed/carrossel-modulos/03.png',
    'https://techsantos.com.br/assets/social-feed/carrossel-modulos/04.png',
    'https://techsantos.com.br/assets/social-feed/carrossel-modulos/05.png',
    'https://techsantos.com.br/assets/social-feed/carrossel-modulos/06.png',
    'https://techsantos.com.br/assets/social-feed/carrossel-modulos/07.png',
    'https://techsantos.com.br/assets/social-feed/carrossel-modulos/08.png',
    'https://techsantos.com.br/assets/social-feed/carrossel-modulos/09.png',
    'https://techsantos.com.br/assets/social-feed/carrossel-modulos/10.png',
];

$legenda = "Do dado bruto ao dashboard pronto — os 13 módulos do curso completo de Power BI, um por um.\n\n"
    . "Modelagem, Power Query, DAX, relatórios, publicação e governança. Sem pular etapa, sem decorar fórmula sem entender o porquê.\n\n"
    . "Assista a aula grátis e veja o currículo completo: https://techsantos.com.br/aula-gratis.php";

$ins = $pdo->prepare(
    'INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, carousel_urls, agendado_para, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
);
$ins->execute([
    'instagram',
    'carousel',
    'imagem',
    $legenda,
    $urls[0], // cover, used for the admin panel thumbnail
    json_encode($urls, JSON_UNESCAPED_SLASHES),
    gmdate('Y-m-d H:i:s'), // now (UTC) -- picked up by the next cron tick
    'pendente',
]);

header('Content-Type: text/plain; charset=utf-8');
echo "Carrossel agendado (id " . $pdo->lastInsertId() . "), agendado_para = " . gmdate('Y-m-d H:i:s') . " UTC\n";
echo "O cron de 15 em 15 min publica na próxima passada.\n";

@unlink(__FILE__);
