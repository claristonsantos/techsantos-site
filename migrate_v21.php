<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$ok = php_sapi_name() === 'cli' || hash_equals(SETUP_KEY, $_GET['key'] ?? '');
if (!$ok) { http_response_code(403); exit('Forbidden.'); }
$pdo = db();
$cols = $pdo->query('SHOW COLUMNS FROM propostas')->fetchAll(PDO::FETCH_COLUMN);
$changes = [
    'contato_nome' => "ADD COLUMN contato_nome VARCHAR(190) NULL AFTER cliente",
    'contato_documento' => "ADD COLUMN contato_documento VARCHAR(30) NULL AFTER contato_nome",
    'contato_email' => "ADD COLUMN contato_email VARCHAR(190) NULL AFTER contato_documento",
];
$out = [];
foreach ($changes as $col => $sql) {
    if (!in_array($col, $cols, true)) {
        $pdo->exec('ALTER TABLE propostas ' . $sql);
        $out[] = "Criada propostas.{$col}";
    }
}
echo ($out ? implode("\n", $out) : 'Migração já aplicada.') . "\n";
