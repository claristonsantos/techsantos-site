<?php
declare(strict_types=1);
if (php_sapi_name() !== 'cli') { http_response_code(403); exit('CLI only.'); }
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/aulas_particulares_automacao.php';

$pdo = db();
aulas_automation_ensure($pdo);
// data_aula é local (America/Sao_Paulo, UTC-3) sem timezone; NOW() do MySQL roda em UTC nesse
// host. DATE_SUB(NOW(), INTERVAL 3 HOUR) traz "agora" pro mesmo referencial antes de comparar.
$leads = $pdo->query(
    "SELECT * FROM aulas_particulares_leads WHERE status='pago' AND data_aula IS NOT NULL AND data_aula < DATE_SUB(NOW(), INTERVAL 3 HOUR)"
)->fetchAll();

$marcar = $pdo->prepare("UPDATE aulas_particulares_leads SET status='realizado', atualizado_em=NOW() WHERE id=?");
$marcarUpsell = $pdo->prepare("UPDATE aulas_particulares_leads SET upsell_curso_enviado_em=NOW() WHERE id=?");

foreach ($leads as $lead) {
    $marcar->execute([$lead['id']]);
    echo "aula {$lead['id']} ({$lead['email']}): marcada como realizado\n";
    if (empty($lead['upsell_curso_enviado_em'])) {
        if (aulas_send_upsell_curso($lead)) {
            $marcarUpsell->execute([$lead['id']]);
            echo "aula {$lead['id']}: convite pro curso completo enviado\n";
        } else {
            echo "aula {$lead['id']}: FALHA ao enviar convite pro curso\n";
        }
    }
}

if (!$leads) echo date('Y-m-d H:i:s') . " - nada pra marcar\n";
