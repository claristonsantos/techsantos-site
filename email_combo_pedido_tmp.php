<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/mailer.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único (aprovado pelo dono em 16/10/2026): e-mail de recuperação do pedido #2155 (Excel, Pix não pago) oferecendo o combo Power BI + Excel.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__); // apaga antes de enviar: nunca dispara duas vezes
$pdo = db();
$st = $pdo->prepare("SELECT * FROM pedidos WHERE id = 2155"); $st->execute(); $p = $st->fetch();
if (!$p) exit("pedido não encontrado\n");
if ($p['status'] !== 'pendente') exit("pedido já está {$p['status']} — e-mail NÃO enviado\n");
$nome = htmlspecialchars(explode(' ', trim((string)$p['nome']))[0], ENT_QUOTES);
$token = hash_hmac('sha256', $p['id'] . '|' . $p['mercadopago_preference_id'], MERCADOPAGO_ACCESS_TOKEN);
$soExcel = 'https://techsantos.com.br/retomar-pagamento.php?pedido=' . $p['id'] . '&token=' . rawurlencode($token);
$combo = 'https://techsantos.com.br/comprar.php?utm_source=email&utm_medium=recuperacao&utm_campaign=combo_professores';
$wa = WHATSAPP_LINK; $footer = email_footer_html();
$html = <<<HTML
<!doctype html><html lang="pt-BR"><body style="margin:0;padding:0;background:#F5F6F1;font-family:Arial,Helvetica,sans-serif;color:#10192B;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#F5F6F1;padding:32px 16px;"><tr><td align="center">
<table role="presentation" width="100%" style="max-width:560px;background:#ffffff;border-radius:8px;overflow:hidden;border:1px solid #DBDECF;">
<tr><td style="background:#0F2440;padding:24px 32px;"><span style="color:#ffffff;font-size:18px;font-weight:bold;">TECH <span style="color:#6DC24D;">SANTOS BR</span></span></td></tr>
<tr><td style="padding:32px;font-size:15px;line-height:1.6;color:#48546A;">
<p style="margin:0 0 16px;color:#10192B;font-size:17px;"><strong>Oi, {$nome}! Tudo bem?</strong></p>
<p style="margin:0 0 16px;">Aqui é o Clariston, da Tech Santos BR. Vi que ontem você começou a matrícula no curso de Excel e gerou o Pix de R$ 97, mas o pagamento não chegou a ser concluído. O código Pix tem validade; se ele expirou, é só gerar um novo.</p>
<p style="margin:0 0 16px;">Antes de finalizar, uma dica: <strong style="color:#10192B;">neste mês dos professores, quem compra o curso de Power BI leva o curso de Excel completo de presente</strong>. Por R$ 32,90 a mais (R$ 129,90 no total), você leva os dois cursos, liberados na mesma conta, com acesso vitalício. O Excel te dá a base, e o Power BI leva isso para dashboards e relatórios automáticos.</p>
<table role="presentation" width="100%" style="background:#FFF6DA;border:1px solid #F5B301;border-radius:6px;margin:8px 0 16px;"><tr><td style="padding:20px;text-align:center;">
<a href="{$combo}" style="display:inline-block;background:#F5B301;color:#10192B;text-decoration:none;padding:13px 26px;border-radius:6px;font-size:15px;font-weight:bold;">Quero o combo Power BI + Excel — R$ 129,90</a>
<p style="margin:14px 0 0;font-size:14px;"><a href="{$soExcel}" style="color:#0F2440;">Prefiro só o curso de Excel — R$ 97</a></p>
</td></tr></table>
<p style="margin:0 0 16px;">A oferta vale até 31/10. Se tiver qualquer dúvida, é só responder este e-mail ou <a href="{$wa}" style="color:#0F2440;">me chamar no WhatsApp</a>.</p>
<p style="margin:0;">Abraço,<br><strong style="color:#10192B;">Clariston</strong>, Tech Santos BR</p>
</td></tr>
{$footer}
</table></td></tr></table></body></html>
HTML;
$text = "Oi, " . explode(' ', trim((string)$p['nome']))[0] . "! Aqui é o Clariston, da Tech Santos BR. Vi que ontem você começou a matrícula no curso de Excel e gerou o Pix de R$ 97, mas o pagamento não chegou a ser concluído.\n\n"
  . "Neste mês dos professores, quem compra o curso de Power BI leva o curso de Excel completo de presente: R$ 129,90 pelos dois, na mesma conta, acesso vitalício, até 31/10.\n\n"
  . "Quero o combo: {$combo}\nSó o Excel (R$ 97): {$soExcel}\n\nDúvidas: responda este e-mail ou chame no WhatsApp {$wa}\n\nAbraço,\nClariston, Tech Santos BR";
$ok = send_html_email((string)$p['email'], explode(' ', trim((string)$p['nome']))[0] . ', sua matrícula no Excel ficou pendente, e tenho uma proposta melhor', $html, $text, 'claristonsantos@techsantos.com.br');
echo $ok ? "ENVIADO pedido 2155\n" : "FALHA no envio (SMTP não confirmou)\n";
