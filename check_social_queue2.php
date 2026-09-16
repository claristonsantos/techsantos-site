<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$stmt = $pdo->query("SELECT id, canal, tipo, status, agendado_para, imagem_url FROM social_posts WHERE (imagem_url LIKE '%kpi-sem-definicao%' OR imagem_url LIKE '%cliente-angola%' OR imagem_url LIKE '%angola%') ORDER BY id");
foreach ($stmt->fetchAll() as $row) {
    echo "#{$row['id']} [{$row['canal']}/{$row['tipo']}] {$row['status']} agendado={$row['agendado_para']} midia={$row['imagem_url']}\n";
}
echo "---FIM---\n";
@unlink(__FILE__);
