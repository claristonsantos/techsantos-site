<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$base = 'https://techsantos.com.br';

$exists = $pdo->query("SELECT id FROM social_posts WHERE id = 29")->fetch();

header('Content-Type: text/plain; charset=utf-8');

if ($exists) {
    echo "Post #29 já existe, nada a fazer.\n";
    @unlink(__FILE__);
    exit;
}

$legenda = "Modelo travando ou com número duplicado no Power BI? Provavelmente é o relacionamento.\n\nA tabela de dimensão (Produto, Cliente, Data) precisa ter só um valor único por linha — ela fica do lado \"1\" do relacionamento. A tabela de fatos (Vendas, Pedidos) fica do lado \"muitos\", repetindo aquele mesmo produto ou cliente em vários registros.\n\nRelacionamento errado (muitos-pra-muitos sem querer) é a causa mais comum de número de venda duplicado num painel — confira a cardinalidade antes de sair procurando erro na fórmula.\n\nMais dicas de Excel e Power BI: {$base}/servicos.html";
$videoUrl = $base . '/assets/social-video/dica-powerbi-relacionamentos.mp4';

$pdo->prepare(
    "INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, agendado_para, status) VALUES ('instagram', 'reels', 'video', ?, ?, '2026-07-19 18:00:00', 'pendente')"
)->execute([$legenda, $videoUrl]);

echo "Post #29 recriado (novo id " . $pdo->lastInsertId() . "), agendado pra 2026-07-19 18:00:00 UTC.\n";

@unlink(__FILE__);
