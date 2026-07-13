<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$out = [];

$pdo->exec("CREATE TABLE IF NOT EXISTS social_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    canal ENUM('facebook','instagram') NOT NULL,
    legenda TEXT NOT NULL,
    imagem_url VARCHAR(500) NOT NULL,
    agendado_para DATETIME NOT NULL,
    status ENUM('pendente','agendado_meta','publicado','erro') NOT NULL DEFAULT 'pendente',
    meta_post_id VARCHAR(100) NULL,
    erro_msg VARCHAR(500) NULL,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
$out[] = 'Tabela social_posts ok.';

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
