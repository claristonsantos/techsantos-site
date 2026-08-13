<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(403); exit('CLI only'); }
require_once __DIR__ . '/aulas_particulares_automacao.php';

$pdo = db();
aulas_automation_ensure($pdo);
$pdo->beginTransaction();
$lead = $pdo->query("SELECT * FROM aulas_particulares_leads ORDER BY id DESC LIMIT 1 FOR UPDATE")->fetch();
if (!$lead) { $pdo->rollBack(); exit("NO_LEAD\n"); }
if (!empty($lead['proposta_enviada_em']) || str_starts_with((string)($lead['email_ultimo_erro'] ?? ''), 'DIAGNOSTICO_')) {
    $pdo->rollBack(); exit("ALREADY_EXECUTED id={$lead['id']}\n");
}
$pdo->prepare("UPDATE aulas_particulares_leads SET status='contatado',email_ultimo_erro='DIAGNOSTICO_EM_EXECUCAO' WHERE id=?")->execute([$lead['id']]);
$pdo->commit();

$payment = aulas_create_payment($lead);
if (!$payment) {
    $pdo->prepare("UPDATE aulas_particulares_leads SET email_ultimo_erro='DIAGNOSTICO_PAGAMENTO_FALHOU' WHERE id=?")->execute([$lead['id']]);
    exit("PAYMENT_FAILED id={$lead['id']}\n");
}
$lead['pagamento_link'] = $payment['url'];
$pdo->prepare('UPDATE aulas_particulares_leads SET pagamento_link=?,mercadopago_preference_id=? WHERE id=?')->execute([$payment['url'],$payment['id'],$lead['id']]);
if (!aulas_send_proposal($lead)) {
    $pdo->prepare("UPDATE aulas_particulares_leads SET email_ultimo_erro='DIAGNOSTICO_SMTP_FALHOU' WHERE id=?")->execute([$lead['id']]);
    exit("SMTP_FAILED id={$lead['id']}\n");
}
$pdo->prepare("UPDATE aulas_particulares_leads SET status='agendado',proposta_enviada_em=NOW(),email_ultimo_erro=NULL WHERE id=?")->execute([$lead['id']]);
echo "SUCCESS id={$lead['id']} recipient={$lead['email']}\n";
