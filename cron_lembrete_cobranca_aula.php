<?php
declare(strict_types=1);
if (php_sapi_name() !== 'cli') { http_response_code(403); exit('CLI only.'); }
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/aulas_particulares_automacao.php';

// Mesmo papel do cron_lembrete_carrinho.php (que só cobre `pedidos`): se a
// proposta/cobrança da aula foi enviada e ninguém pagou, reenvia um lembrete
// uma única vez. 2h de carência (tempo real pra desistir do pagamento) e
// janela de 7 dias (não reenviar pra links antigos que não fazem mais
// sentido).
$pdo = db();
$leads = $pdo->query(
    "SELECT * FROM aulas_particulares_leads
     WHERE status IN ('contatado','agendado')
       AND pagamento_link IS NOT NULL
       AND lembrete_cobranca_enviado_em IS NULL
       AND COALESCE(cobranca_enviada_em, proposta_enviada_em) <= DATE_SUB(NOW(), INTERVAL 2 HOUR)
       AND COALESCE(cobranca_enviada_em, proposta_enviada_em) >= DATE_SUB(NOW(), INTERVAL 7 DAY)"
)->fetchAll();

if (!$leads) {
    echo "nada pendente\n";
    exit;
}

foreach ($leads as $lead) {
    if (aulas_send_payment_reminder($lead)) {
        $pdo->prepare('UPDATE aulas_particulares_leads SET lembrete_cobranca_enviado_em=NOW(), email_ultimo_erro=NULL WHERE id=?')->execute([$lead['id']]);
        echo "aula {$lead['id']} ({$lead['email']}): lembrete de cobrança enviado\n";
    } else {
        $pdo->prepare('UPDATE aulas_particulares_leads SET email_ultimo_erro=? WHERE id=?')->execute(['Falha ao enviar lembrete de cobrança', $lead['id']]);
        echo "aula {$lead['id']} ({$lead['email']}): FALHA ao enviar\n";
    }
}
