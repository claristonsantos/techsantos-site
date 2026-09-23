<?php
declare(strict_types=1);
if (php_sapi_name() !== 'cli') { http_response_code(403); exit('CLI only.'); }
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/mailer.php';
require_once __DIR__ . '/lead_pipeline.php';

// Resumo diário (09h Brasília) dos leads da aula grátis que precisam de
// follow-up hoje. Não existe API de WhatsApp aqui — o e-mail traz um link
// wa.me com a mensagem certa da etapa já escrita, e o dono envia com 1 toque.
//
// Cadência pelo dia do lead (D+1, D+3, D+7, contado em dias de calendário de
// Brasília) + qualquer lead com proxima_acao_em vencida marcada à mão no
// admin/leads-curso.php. Leads 'comprou'/'sem_interesse' ficam de fora.
// Como os gatilhos são dias exatos, cada lead aparece no máximo 3 vezes sem
// precisar de coluna de controle.

const FOLLOWUP_OWNER_EMAIL = 'claristonsantos@techsantos.com.br';

$pdo = db();
lead_pipeline_ensure_schema($pdo);
lead_pipeline_backfill_purchases($pdo);

$dryRun = in_array('--dry', $argv ?? [], true);

// criado_em/NOW() estão em UTC nesse host; -3h leva pro calendário de Brasília.
// proxima_acao_em já é gravado em horário de Brasília pelo admin.
$leads = $pdo->query(
    "SELECT w.id, w.telefone, w.origem, w.criado_em,
            COALESCE(p.status,'novo') AS status, p.proxima_acao_em, p.observacoes,
            DATEDIFF(DATE(DATE_SUB(NOW(), INTERVAL 3 HOUR)), DATE(DATE_SUB(w.criado_em, INTERVAL 3 HOUR))) AS dias
     FROM whatsapp_leads w
     LEFT JOIN whatsapp_lead_pipeline p ON p.lead_id = w.id
     WHERE COALESCE(p.status,'novo') NOT IN ('comprou','sem_interesse')
       AND (
         (p.proxima_acao_em IS NOT NULL AND DATE(p.proxima_acao_em) <= DATE(DATE_SUB(NOW(), INTERVAL 3 HOUR)))
         OR (p.proxima_acao_em IS NULL
             AND DATEDIFF(DATE(DATE_SUB(NOW(), INTERVAL 3 HOUR)), DATE(DATE_SUB(w.criado_em, INTERVAL 3 HOUR))) IN (1,3,7))
       )
     ORDER BY w.criado_em"
)->fetchAll();

if ($dryRun) {
    $all = $pdo->query("SELECT w.id, COALESCE(p.status,'novo') st, p.proxima_acao_em pa,
        DATEDIFF(DATE(DATE_SUB(NOW(), INTERVAL 3 HOUR)), DATE(DATE_SUB(w.criado_em, INTERVAL 3 HOUR))) d
        FROM whatsapp_leads w LEFT JOIN whatsapp_lead_pipeline p ON p.lead_id = w.id ORDER BY w.id")->fetchAll();
    foreach ($all as $r) echo "lead {$r['id']}: status={$r['st']} dias={$r['d']} proxima=" . ($r['pa'] ?? '-') . "\n";
}

if (!$leads) {
    echo date('Y-m-d H:i:s') . " - nenhum follow-up hoje\n";
    exit;
}

$precoCentavos = (int)$pdo->query("SELECT preco_centavos FROM cursos WHERE slug = 'power-bi'")->fetchColumn();
$preco = $precoCentavos ? 'R$ ' . number_format($precoCentavos / 100, 2, ',', '.') : '';

function followup_message(int $dias, string $preco): array
{
    if ($dias <= 1) {
        return ['D+1 · primeiro contato',
            'Oi! Aqui é o Clariston, da TECH SANTOS BR. Vi que você liberou as aulas grátis do curso de Power BI. Conseguiu assistir? Se travou em alguma parte ou quiser uma dica de por onde começar, me fala aqui.'];
    }
    if ($dias <= 4) {
        return ['D+3 · valor / dúvida',
            'Oi, tudo bem? Clariston da TECH SANTOS BR de novo. Uma pergunta rápida: hoje você usa mais Excel ou já mexe em Power BI no trabalho? Pergunto pra te indicar a aula do curso que mais vai te ajudar agora.'];
    }
    return ['D+7 · convite',
        'Oi! Passando pra deixar o convite: o curso completo de Power BI tem 46 aulas práticas, certificado e suporte direto comigo' . ($preco ? ", por {$preco} (até 12x)" : '') . '. Se preferir algo sob medida, também faço aula particular ao vivo. Quer que eu te mande o link? https://techsantos.com.br/curso-power-bi.php'];
}

$rowsHtml = '';
$rowsText = '';
$rowsDry = [];
foreach ($leads as $lead) {
    $digits = preg_replace('/\D/', '', (string)$lead['telefone']) ?? '';
    $e164 = str_starts_with($digits, '55') ? $digits : '55' . $digits;
    $agendado = $lead['proxima_acao_em'] !== null;
    [$etapa, $msg] = followup_message((int)$lead['dias'], $preco);
    if ($agendado) $etapa = 'Próxima ação agendada (' . $lead['status'] . ')';
    $wa = 'https://wa.me/' . $e164 . '?text=' . rawurlencode($msg);
    $obs = $lead['observacoes'] ? '<br><small>Obs.: ' . htmlspecialchars(mb_substr((string)$lead['observacoes'], 0, 200), ENT_QUOTES) . '</small>' : '';
    $rowsHtml .= '<tr><td style="padding:8px;border-bottom:1px solid #eee;"><strong>' . htmlspecialchars($digits, ENT_QUOTES) . '</strong><br><small>' . htmlspecialchars((string)$lead['origem'], ENT_QUOTES) . ' · lead há ' . (int)$lead['dias'] . ' dia(s)</small>' . $obs . '</td>'
        . '<td style="padding:8px;border-bottom:1px solid #eee;">' . htmlspecialchars($etapa, ENT_QUOTES) . '</td>'
        . '<td style="padding:8px;border-bottom:1px solid #eee;"><a href="' . $wa . '">Enviar no WhatsApp</a></td></tr>';
    $rowsText .= "- {$digits} ({$etapa}): {$wa}\n";
    $rowsDry[] = "lead {$lead['id']}: {$etapa}";
}

$total = count($leads);
$html = '<p>' . $total . ' lead(s) da aula grátis para chamar hoje. Cada link abre o WhatsApp com a mensagem da etapa já escrita — revise e envie.</p>'
    . '<table style="border-collapse:collapse;width:100%;font-size:14px;"><tr><th align="left">Lead</th><th align="left">Etapa</th><th align="left"></th></tr>' . $rowsHtml . '</table>'
    . '<p>Depois de enviar, registre o contato em <a href="https://techsantos.com.br/admin/leads-curso.php">admin › Leads do curso</a>. Marcar "Comprou" ou "Sem interesse" tira o lead da lista; uma "próxima ação" agendada substitui a cadência automática.</p>';

if ($dryRun) {
    echo "DRY RUN - {$total} lead(s):\n" . implode("\n", $rowsDry) . "\n";
    exit;
}

$ok = send_html_email(FOLLOWUP_OWNER_EMAIL, "Follow-up de leads hoje: {$total}", $html, $rowsText);
echo date('Y-m-d H:i:s') . ' - ' . $total . ' lead(s), e-mail ' . ($ok ? 'enviado' : 'FALHOU') . "\n";
