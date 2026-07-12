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

function column_exists_v5(PDO $pdo, string $table, string $column): bool
{
    $stmt = $pdo->prepare(
        "SELECT COUNT(*) FROM information_schema.COLUMNS
         WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ?"
    );
    $stmt->execute([$table, $column]);
    return (int)$stmt->fetchColumn() > 0;
}

if (!column_exists_v5($pdo, 'admin_users', 'nome')) {
    $pdo->exec("ALTER TABLE admin_users ADD COLUMN nome VARCHAR(150) NOT NULL DEFAULT '' AFTER usuario");
    $out[] = 'Coluna admin_users.nome criada.';
}
if (!column_exists_v5($pdo, 'admin_users', 'email')) {
    $pdo->exec("ALTER TABLE admin_users ADD COLUMN email VARCHAR(190) NULL AFTER nome");
    $out[] = 'Coluna admin_users.email criada.';
}
if (!column_exists_v5($pdo, 'admin_users', 'senha_temporaria')) {
    $pdo->exec("ALTER TABLE admin_users ADD COLUMN senha_temporaria TINYINT(1) NOT NULL DEFAULT 0 AFTER senha_hash");
    $out[] = 'Coluna admin_users.senha_temporaria criada.';
}
if (!column_exists_v5($pdo, 'admin_users', 'ativo')) {
    $pdo->exec("ALTER TABLE admin_users ADD COLUMN ativo TINYINT(1) NOT NULL DEFAULT 1 AFTER senha_temporaria");
    $out[] = 'Coluna admin_users.ativo criada.';
}

$upd = $pdo->prepare("UPDATE admin_users SET nome = ? WHERE usuario = ? AND nome = ''");
$upd->execute(['Clariston Santos', 'clariston']);

header('Content-Type: text/plain; charset=utf-8');
echo "Migração v5 concluída.\n";
foreach ($out as $line) {
    echo "- $line\n";
}

@unlink(__FILE__);
echo "\nmigrate_v5.php removido do servidor.\n";
