<?php
declare(strict_types=1);
if (php_sapi_name() !== 'cli') { http_response_code(403); exit('CLI only.'); }
require_once __DIR__ . '/db.php';
$pdo = db();
try {
    $pdo->exec("UPDATE alunos SET cpf = NULL WHERE cpf = ''");
    $pdo->exec("ALTER TABLE alunos MODIFY cpf VARCHAR(11) NULL");
    echo "CPF de alunos alterado para nullable; vazios convertidos em NULL.\n";
} catch (Throwable $e) {
    fwrite(STDERR, $e->getMessage() . "\n");
    exit(1);
}
