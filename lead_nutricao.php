<?php
declare(strict_types=1);
// Sequência de nutrição dos leads da aula grátis que deixaram e-mail (3 e-mails):
//   etapa 1 (na captura): aulas 2 e 3 liberadas · etapa 2 (2 dias): o que você constrói no curso
//   etapa 3 (5 dias): a oferta (combo enquanto valer, depois o curso com a garantia).
// Roda dentro do cron_lembrete_carrinho.php, que já está agendado na hospedagem.
// Cada e-mail tem link de descadastro e vai com cópia separada para o dono (send_html_email com cópia).
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/mailer.php';
require_once __DIR__ . '/lead_pipeline.php';
require_once __DIR__ . '/promo_combo.php';

const NUTRICAO_SITE = 'https://techsantos.com.br';

function nutricao_ensure(PDO $pdo): void
{
    static $done = false;
    if ($done) return;
    $done = true;
    whatsapp_leads_ensure_email($pdo);
    $cols = array_column($pdo->query("SHOW COLUMNS FROM whatsapp_leads")->fetchAll(), 'Field');
    if (!in_array('nutricao_etapa', $cols, true)) $pdo->exec("ALTER TABLE whatsapp_leads ADD COLUMN nutricao_etapa TINYINT NOT NULL DEFAULT 0");
    if (!in_array('nutricao_em', $cols, true)) $pdo->exec("ALTER TABLE whatsapp_leads ADD COLUMN nutricao_em DATETIME NULL");
    if (!in_array('nutricao_optout', $cols, true)) $pdo->exec("ALTER TABLE whatsapp_leads ADD COLUMN nutricao_optout TINYINT NOT NULL DEFAULT 0");
}

function nutricao_token(int $leadId): string
{
    return substr(hash_hmac('sha256', 'descadastro|' . $leadId, SETUP_KEY), 0, 32);
}

function nutricao_frame(int $leadId, string $titulo, string $corpo, string $botao, string $url): string
{
    $sair = NUTRICAO_SITE . '/descadastrar.php?l=' . $leadId . '&t=' . nutricao_token($leadId);
    $footer = email_footer_html();
    return <<<HTML
<!doctype html><html lang="pt-BR"><body style="margin:0;padding:0;background:#F5F6F1;font-family:Arial,Helvetica,sans-serif;color:#10192B;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#F5F6F1;padding:32px 16px;"><tr><td align="center">
<table role="presentation" width="100%" style="max-width:560px;background:#ffffff;border-radius:8px;overflow:hidden;border:1px solid #DBDECF;">
<tr><td style="background:#0F2440;padding:24px 32px;"><span style="color:#ffffff;font-size:18px;font-weight:bold;">TECH <span style="color:#6DC24D;">SANTOS BR</span></span></td></tr>
<tr><td style="padding:32px;font-size:15px;line-height:1.6;color:#48546A;">
<h1 style="font-size:20px;margin:0 0 16px;color:#10192B;">{$titulo}</h1>
{$corpo}
<p style="margin:24px 0;text-align:center;"><a href="{$url}" style="display:inline-block;background:#6DC24D;color:#0F2440;text-decoration:none;padding:13px 28px;border-radius:6px;font-weight:bold;">{$botao}</a></p>
<p style="margin:0;">Qualquer dúvida, é só responder este e-mail.<br>Abraço,<br><strong style="color:#10192B;">Clariston</strong>, Tech Santos BR</p>
</td></tr>
{$footer}
<tr><td style="padding:10px 32px 18px;font-size:11px;color:#9AA3B2;">Você recebeu porque liberou as aulas grátis do curso de Power BI. <a href="{$sair}" style="color:#9AA3B2;">Não quero mais receber</a>.</td></tr>
</table></td></tr></table></body></html>
HTML;
}

/** Monta assunto, html e texto de uma etapa. */
function nutricao_email(int $etapa, int $leadId): array
{
    $aula = NUTRICAO_SITE . '/aula-gratis.php?liberado=1&utm_source=email&utm_medium=nutricao&utm_campaign=lead_aula_gratis#introducao';
    $curso = NUTRICAO_SITE . '/curso-power-bi.php?utm_source=email&utm_medium=nutricao&utm_campaign=lead_aula_gratis';
    $comprar = NUTRICAO_SITE . '/comprar.php?utm_source=email&utm_medium=nutricao&utm_campaign=lead_aula_gratis';
    if ($etapa === 1) {
        $c = '<p style="margin:0 0 14px;">Obrigado por assistir à primeira aula do curso de Power BI. As aulas 2 e 3 já estão liberadas para você — neste link elas abrem direto, em qualquer aparelho.</p>'
           . '<p style="margin:0 0 14px;">Na aula 2 você vê como o curso é organizado e o que vai conseguir fazer no final. Na aula 3, a base que separa um relatório que trava de um relatório rápido: normalização de tabelas.</p>';
        return ['Suas aulas 2 e 3 de Power BI estão liberadas', nutricao_frame($leadId, 'Suas aulas 2 e 3 estão liberadas', $c, 'Assistir às aulas 2 e 3', $aula),
                "As aulas 2 e 3 do curso de Power BI estão liberadas: {$aula}"];
    }
    if ($etapa === 2) {
        $c = '<p style="margin:0 0 14px;">Quem chega ao Power BI vindo do Excel quase sempre tem a mesma dor: o relatório de todo mês é montado na mão, com PROCV, copiar e colar, e qualquer mudança vira retrabalho.</p>'
           . '<p style="margin:0 0 14px;">No curso completo você constrói, do zero, dashboards de verdade — comercial, financeiro (DRE) e RH — passando por Power Query, modelagem em esquema estrela, DAX e publicação. Montou uma vez, depois é só atualizar.</p>'
           . '<p style="margin:0 0 14px;">São 13 módulos, com avaliações, base de dados para praticar e certificado no final.</p>';
        return ['O que você vai construir no curso de Power BI', nutricao_frame($leadId, 'Do PROCV ao dashboard que se atualiza sozinho', $c, 'Ver o que tem no curso', $curso),
                "O que você constrói no curso completo de Power BI: {$curso}"];
    }
    $preco = 'R$ 129,90 à vista, ou parcelado em até 12x no cartão';
    $combo = promo_combo_ativa()
        ? '<p style="margin:0 0 14px;background:#FFF6DA;border:1px solid #F5B301;border-radius:6px;padding:10px 14px;"><strong>Mês dos Professores:</strong> comprando o Power BI até 31/10, o <strong>curso de Excel completo vem de presente</strong> (68 videoaulas, do básico às macros), na mesma conta.</p>'
        : '';
    $c = "<p style=\"margin:0 0 14px;\">Se as aulas grátis fizeram sentido para você, este é o momento de seguir. O curso completo de Power BI sai por <strong>{$preco}</strong>, com acesso vitalício e liberação na hora.</p>"
       . $combo
       . '<p style="margin:0 0 14px;"><strong>Garantia:</strong> se você concluiu menos de 20% do curso e não gostou, devolvemos 100% do valor.</p>';
    return [promo_combo_ativa() ? 'Power BI + Excel de presente, só até 31/10' : 'Seu próximo passo no Power BI',
            nutricao_frame($leadId, 'Pronto para o curso completo?', $c, 'Quero o curso de Power BI', $comprar),
            "Curso completo de Power BI: {$preco}. " . (promo_combo_ativa() ? 'Até 31/10 o curso de Excel vem de presente. ' : '') . $comprar];
}

function nutricao_enviar(PDO $pdo, array $lead, int $etapa): bool
{
    [$assunto, $html, $texto] = nutricao_email($etapa, (int)$lead['id']);
    $ok = send_html_email((string)$lead['email'], $assunto, $html, $texto, OWNER_COPY_EMAIL);
    if ($ok) $pdo->prepare('UPDATE whatsapp_leads SET nutricao_etapa = ?, nutricao_em = NOW() WHERE id = ?')->execute([$etapa, $lead['id']]);
    return $ok;
}

/** Chamado pelo cron: envia as etapas 2 e 3 que venceram. Retorna linhas de log. */
function nutricao_processar(PDO $pdo): array
{
    nutricao_ensure($pdo);
    $log = [];
    $regras = [2 => [1, '2 DAY'], 3 => [2, '3 DAY']];  // etapa => [etapa anterior, tempo depois da anterior]
    foreach ($regras as $etapa => [$antes, $espera]) {
        $st = $pdo->query("SELECT w.* FROM whatsapp_leads w LEFT JOIN whatsapp_lead_pipeline p ON p.lead_id = w.id
            WHERE w.email IS NOT NULL AND w.email <> '' AND w.nutricao_optout = 0 AND w.nutricao_etapa = {$antes}
              AND w.nutricao_em <= NOW() - INTERVAL {$espera} AND COALESCE(p.status, 'novo') <> 'comprou' LIMIT 20");
        foreach ($st->fetchAll() as $lead) {
            $log[] = "lead {$lead['id']}: etapa {$etapa} " . (nutricao_enviar($pdo, $lead, $etapa) ? 'enviada' : 'FALHOU');
        }
    }
    return $log;
}
