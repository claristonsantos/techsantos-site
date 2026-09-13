<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$ok = php_sapi_name() === 'cli' || hash_equals(SETUP_KEY, $_GET['key'] ?? '');
if (!$ok) { http_response_code(403); exit('Forbidden.'); }
$pdo = db();
$pdo->exec(
    "CREATE TABLE IF NOT EXISTS propostas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        token VARCHAR(40) NOT NULL,
        cliente VARCHAR(255) NOT NULL,
        projeto VARCHAR(255) NOT NULL,
        tipo ENUM('novo','alteracao') NOT NULL DEFAULT 'novo',
        formato VARCHAR(100) NULL,
        natureza ENUM('desenvolvimento','orcamento') NOT NULL DEFAULT 'orcamento',
        versao VARCHAR(20) NOT NULL DEFAULT '1',
        autor VARCHAR(100) NOT NULL DEFAULT 'Clariston Santos',
        resumo VARCHAR(255) NULL,
        escopo TEXT NULL,
        objetivo TEXT NULL,
        premissas TEXT NULL,
        moeda VARCHAR(6) NOT NULL DEFAULT 'USD',
        itens JSON NOT NULL,
        status VARCHAR(20) NOT NULL DEFAULT 'rascunho',
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY uq_propostas_token (token)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
);
echo "Tabela propostas pronta.\n";
