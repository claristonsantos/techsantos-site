<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$stmt = $pdo->prepare(
    "SELECT COUNT(*) FROM information_schema.COLUMNS
     WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'pedidos' AND COLUMN_NAME = 'telefone'"
);
$stmt->execute();
$out = [];
if ((int)$stmt->fetchColumn() === 0) {
    $pdo->exec("ALTER TABLE pedidos ADD COLUMN telefone VARCHAR(20) NULL AFTER cpf");
    $out[] = 'Coluna pedidos.telefone criada.';
}

header('Content-Type: text/plain; charset=utf-8');
echo "Migração v4 concluída.\n";
foreach ($out as $line) {
    echo "- $line\n";
}

@unlink(__FILE__);
echo "\nmigrate_v4.php removido do servidor.\n";
