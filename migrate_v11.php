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

$stmt = $pdo->query("SHOW TABLES LIKE 'whatsapp_leads'");
if ($stmt->rowCount() === 0) {
    $pdo->exec("
        CREATE TABLE whatsapp_leads (
            id INT AUTO_INCREMENT PRIMARY KEY,
            telefone VARCHAR(30) NOT NULL,
            origem VARCHAR(100) NOT NULL DEFAULT 'aula-gratis',
            criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ");
    $out[] = 'Tabela whatsapp_leads criada.';
} else {
    $out[] = 'Tabela whatsapp_leads já existia — nada a fazer.';
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
