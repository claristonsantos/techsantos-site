<?php
declare(strict_types=1);
if (php_sapi_name() !== 'cli') { http_response_code(403); exit('CLI only.'); }
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/mercadopago.php';
require_once __DIR__ . '/aulas_particulares_automacao.php';

// Rede de segurança pro webhook do Mercado Pago perder a notificação de uma
// aula — mesmo papel do cron_reconciliar_pagamentos.php, que só cobre
// `pedidos` (curso). Sem isso, uma aula com link de pagamento enviado e
// webhook perdido fica travada pra sempre em agendado/contatado.
$pdo = db();
$leads = $pdo->query(
    "SELECT * FROM aulas_particulares_leads
     WHERE status IN ('contatado','agendado')
       AND mercadopago_preference_id IS NOT NULL
       AND criado_em >= DATE_SUB(NOW(), INTERVAL 14 DAY)
     ORDER BY id"
)->fetchAll();

$aprovados = 0;
$erros = 0;
foreach ($leads as $lead) {
    try {
        $payment = mercadopago_search_approved_payment('AULA-' . $lead['id']);
        if (!$payment) continue;
        $pdo->prepare("UPDATE aulas_particulares_leads SET status='pago', mercadopago_payment_id=?, atualizado_em=NOW() WHERE id=?")
            ->execute([(string)$payment['id'], $lead['id']]);
        $lead['status'] = 'pago';
        if (aulas_send_paid($lead)) {
            $pdo->prepare('UPDATE aulas_particulares_leads SET confirmacao_enviada_em=NOW(), email_ultimo_erro=NULL WHERE id=?')->execute([$lead['id']]);
        } else {
            $pdo->prepare('UPDATE aulas_particulares_leads SET email_ultimo_erro=? WHERE id=?')->execute(['Falha ao enviar confirmação de pagamento (reconciliação)', $lead['id']]);
        }
        $aprovados++;
        echo "aula {$lead['id']}: pagamento aprovado reconciliado\n";
    } catch (Throwable $e) {
        $erros++;
        error_log('Reconciliação aula ' . $lead['id'] . ': ' . $e->getMessage());
    }
}
echo date('Y-m-d H:i:s') . " - verificados=" . count($leads) . " aprovados={$aprovados} erros={$erros}\n";
if ($erros > 0) exit(1);
