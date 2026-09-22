<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/aulas_particulares_automacao.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
aulas_automation_ensure($pdo);

$leads = $pdo->query("SELECT * FROM aulas_particulares_leads WHERE status='realizado' AND upsell_curso_enviado_em IS NULL")->fetchAll();
$marcar = $pdo->prepare("UPDATE aulas_particulares_leads SET upsell_curso_enviado_em=NOW() WHERE id=?");
foreach ($leads as $lead) {
    if (aulas_send_upsell_curso($lead)) {
        $marcar->execute([$lead['id']]);
        echo "OK|id={$lead['id']}|{$lead['nome']}|{$lead['email']}\n";
    } else {
        echo "FAILED|id={$lead['id']}|{$lead['email']}\n";
    }
}
if (!$leads) echo "nenhuma aula realizada pendente de upsell\n";
@unlink(__FILE__);
