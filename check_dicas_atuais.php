<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$stmt = $pdo->query("SELECT id, canal, tipo, midia_tipo, status, agendado_para, imagem_url, legenda FROM social_posts WHERE imagem_url LIKE '%/dica-%' ORDER BY agendado_para");

header('Content-Type: text/plain; charset=utf-8');
foreach ($stmt->fetchAll() as $row) {
    echo "#{$row['id']} [{$row['status']}] {$row['canal']}/{$row['tipo']}/{$row['midia_tipo']} agendado={$row['agendado_para']} arquivo=" . basename($row['imagem_url']) . "\n";
    echo "LEGENDA: " . $row['legenda'] . "\n---\n";
}

@unlink(__FILE__);
