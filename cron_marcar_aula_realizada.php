<?php
declare(strict_types=1);
if (php_sapi_name() !== 'cli') { http_response_code(403); exit('CLI only.'); }
require_once __DIR__ . '/db.php';

$pdo = db();
// data_aula é local (America/Sao_Paulo, UTC-3) sem timezone; NOW() do MySQL roda em UTC nesse
// host. DATE_SUB(NOW(), INTERVAL 3 HOUR) traz "agora" pro mesmo referencial antes de comparar.
$stmt = $pdo->prepare("UPDATE aulas_particulares_leads SET status='realizado', atualizado_em=NOW() WHERE status='pago' AND data_aula IS NOT NULL AND data_aula < DATE_SUB(NOW(), INTERVAL 3 HOUR)");
$stmt->execute();
echo date('Y-m-d H:i:s') . " - marcadas como realizado: " . $stmt->rowCount() . "\n";
