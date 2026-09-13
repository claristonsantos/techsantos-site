<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$ok = php_sapi_name() === 'cli' || hash_equals(SETUP_KEY, $_GET['key'] ?? '');
if (!$ok) { http_response_code(403); exit('Forbidden.'); }
$pdo = db();
$pdo->exec(
    "CREATE TABLE IF NOT EXISTS cotacoes_dolar (
        data DATE NOT NULL PRIMARY KEY,
        valor DECIMAL(10,4) NOT NULL,
        criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
);
echo "Tabela cotacoes_dolar pronta.\n";
