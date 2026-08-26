<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$stmt = db()->query("SELECT id, canal, status, agendado_para, meta_post_id, imagem_url, erro_msg FROM social_posts WHERE imagem_url LIKE '%/assets/social-video/fabric/fabric-%' AND agendado_para >= '2026-08-28 00:00:00' ORDER BY agendado_para, canal");
header('Content-Type: text/plain; charset=utf-8');
foreach ($stmt->fetchAll() as $row) {
    echo implode('|', [
        $row['id'], $row['canal'], $row['status'], $row['agendado_para'],
        $row['meta_post_id'] ?? '', basename($row['imagem_url']), $row['erro_msg'] ?? ''
    ]) . "\n";
}
@unlink(__FILE__);
