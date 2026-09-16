<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$stmt = $pdo->query("SELECT DISTINCT imagem_url FROM social_posts WHERE imagem_url LIKE '%media.techsantos.com.br%' ORDER BY imagem_url");
foreach ($stmt->fetchAll(PDO::FETCH_COLUMN) as $url) {
    echo $url . "\n";
}
@unlink(__FILE__);
