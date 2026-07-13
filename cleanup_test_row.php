<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$pdo->prepare("DELETE FROM social_posts WHERE id = 25")->execute();

header('Content-Type: text/plain; charset=utf-8');
echo "Registro do post de teste (id 25) removido do banco. O Story em si expira sozinho em 24h no Instagram.\n";

@unlink(__FILE__);
