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

$pdo->exec("CREATE TABLE IF NOT EXISTS social_auto_reply_rules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    palavra_chave VARCHAR(100) NOT NULL,
    mensagem TEXT NOT NULL,
    ativo TINYINT(1) NOT NULL DEFAULT 1,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
$out[] = 'Tabela social_auto_reply_rules ok.';

$pdo->exec("CREATE TABLE IF NOT EXISTS social_auto_reply_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    plataforma ENUM('facebook','instagram') NOT NULL,
    comment_id VARCHAR(100) NOT NULL UNIQUE,
    autor VARCHAR(150) NULL,
    texto_comentario TEXT NULL,
    regra_id INT NULL,
    status ENUM('enviado','falha') NOT NULL,
    erro_msg VARCHAR(500) NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
$out[] = 'Tabela social_auto_reply_log ok.';

$cols = $pdo->query("SHOW COLUMNS FROM social_posts")->fetchAll(PDO::FETCH_COLUMN);

if (!in_array('tipo', $cols, true)) {
    $pdo->exec("ALTER TABLE social_posts ADD COLUMN tipo ENUM('feed','story','reels') NOT NULL DEFAULT 'feed' AFTER canal");
    $out[] = 'Coluna social_posts.tipo adicionada.';
} else {
    $out[] = 'Coluna social_posts.tipo já existia.';
}

if (!in_array('midia_tipo', $cols, true)) {
    $pdo->exec("ALTER TABLE social_posts ADD COLUMN midia_tipo ENUM('imagem','video') NOT NULL DEFAULT 'imagem' AFTER tipo");
    $out[] = 'Coluna social_posts.midia_tipo adicionada.';
} else {
    $out[] = 'Coluna social_posts.midia_tipo já existia.';
}

if (!in_array('meta_container_id', $cols, true)) {
    $pdo->exec("ALTER TABLE social_posts ADD COLUMN meta_container_id VARCHAR(100) NULL AFTER meta_post_id");
    $out[] = 'Coluna social_posts.meta_container_id adicionada.';
} else {
    $out[] = 'Coluna social_posts.meta_container_id já existia.';
}

$pdo->exec("ALTER TABLE social_posts MODIFY COLUMN status ENUM('pendente','processando','agendado_meta','publicado','erro') NOT NULL DEFAULT 'pendente'");
$out[] = "Enum social_posts.status agora inclui 'processando'.";

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
