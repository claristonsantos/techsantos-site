<?php
declare(strict_types=1);
if (php_sapi_name() !== 'cli') { http_response_code(403); exit('CLI only.'); }
require_once __DIR__ . '/db.php';

$pdo = db();
$stmt = $pdo->prepare("UPDATE aulas_particulares_leads SET status='realizado', atualizado_em=NOW() WHERE status='pago' AND data_aula IS NOT NULL AND data_aula < NOW()");
$stmt->execute();
echo date('Y-m-d H:i:s') . " - marcadas como realizado: " . $stmt->rowCount() . "\n";
