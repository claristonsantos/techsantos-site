<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$stmt = $pdo->query("SELECT id, canal, tipo, midia_tipo, status, agendado_para, meta_post_id, meta_container_id, erro_msg, imagem_url FROM social_posts WHERE imagem_url LIKE '%/dica-%' ORDER BY agendado_para");

header('Content-Type: text/plain; charset=utf-8');
echo "Agora (UTC): " . gmdate('Y-m-d H:i:s') . "\n---\n";
foreach ($stmt->fetchAll() as $row) {
    $due = strtotime($row['agendado_para'] . ' UTC') <= time() ? 'VENCIDO' : 'futuro';
    echo "#{$row['id']} [{$row['status']}] ({$due}) {$row['canal']}/{$row['tipo']}/{$row['midia_tipo']} agendado={$row['agendado_para']} UTC meta_post={$row['meta_post_id']} container={$row['meta_container_id']} arquivo=" . basename($row['imagem_url']) . "\n";
    if ($row['erro_msg']) {
        echo "  ERRO: {$row['erro_msg']}\n";
    }
}

@unlink(__FILE__);
