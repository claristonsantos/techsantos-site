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

$legenda = "Isso aqui é um Dashboard Comercial completo, rodando ao vivo — receita, lucro e clientes, tudo calculado automático.\n\nO ponto forte: simula um aumento de preço e mostra o impacto na receita e no lucro na hora, categoria por categoria.\n\nAprenda a montar o seu do zero no curso completo. https://www.techsantos.com.br/aula-gratis.php";

$stmt = $pdo->prepare(
    "UPDATE social_posts
     SET imagem_url = ?, legenda = ?, status = 'pendente', erro_msg = NULL, meta_container_id = NULL, meta_post_id = NULL
     WHERE id = 79"
);
$stmt->execute([
    'https://techsantos.com.br/assets/social-video/demo-comercial-dashboard-story60s.mp4',
    $legenda,
]);

echo "linhas afetadas: " . $stmt->rowCount() . "\n";

$row = $pdo->query("SELECT id, canal, tipo, status, imagem_url, agendado_para FROM social_posts WHERE id = 79")->fetch();
foreach ($row as $k => $v) echo "$k: $v\n";

@unlink(__FILE__);
