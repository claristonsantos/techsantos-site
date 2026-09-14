<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$ok = php_sapi_name() === 'cli' || hash_equals(SETUP_KEY, $_GET['key'] ?? '');
if (!$ok) { http_response_code(403); exit('Forbidden.'); }
$pdo = db();
$pdo->exec("ALTER TABLE propostas MODIFY natureza ENUM('desenvolvimento','orcamento','suporte','curso','aulas') NOT NULL DEFAULT 'orcamento'");
echo "propostas.natureza agora aceita 'curso' e 'aulas'.\n";
