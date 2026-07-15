<?php
declare(strict_types=1);

const MAIL_FROM = 'contato@techsantos.com.br';
const MAIL_FROM_NAME = 'TECH SANTOS BR';
const WHATSAPP_LINK = 'https://wa.me/5564992905785';
const WHATSAPP_DISPLAY = '(64) 99290-5785';
const SOCIAL_INSTAGRAM = 'https://www.instagram.com/tech_santos_br/';
const SOCIAL_FACEBOOK = 'https://www.facebook.com/techsantosbr/';
const SOCIAL_LINKEDIN = 'https://br.linkedin.com/company/techsantos-br';

function email_footer_html(): string
{
    $sInsta = SOCIAL_INSTAGRAM;
    $sFace = SOCIAL_FACEBOOK;
    $sLinked = SOCIAL_LINKEDIN;
    return <<<HTML
        <tr><td style="background:#F5F6F1; padding:16px 32px; font-size:12px; color:#7C8798;">
          <p style="margin:0 0 12px;">TECH SANTOS BR Treinamentos e Aulas Particulares · CNPJ 41.135.509/0001-29</p>
          <p style="margin:0;">
            <a href="{$sInsta}" style="display:inline-block; background:#0F2440; color:#ffffff; text-decoration:none; padding:6px 14px; border-radius:14px; font-size:11px; margin:0 6px 6px 0;">Instagram</a>
            <a href="{$sFace}" style="display:inline-block; background:#0F2440; color:#ffffff; text-decoration:none; padding:6px 14px; border-radius:14px; font-size:11px; margin:0 6px 6px 0;">Facebook</a>
            <a href="{$sLinked}" style="display:inline-block; background:#0F2440; color:#ffffff; text-decoration:none; padding:6px 14px; border-radius:14px; font-size:11px; margin:0 6px 6px 0;">LinkedIn</a>
          </p>
        </td></tr>
HTML;
}

function send_html_email(string $toEmail, string $subject, string $html, string $text): bool
{
    $boundary = 'ts_' . bin2hex(random_bytes(16));
    $headers = [
        'MIME-Version: 1.0',
        'Content-Type: multipart/alternative; boundary="' . $boundary . '"',
        'From: ' . MAIL_FROM_NAME . ' <' . MAIL_FROM . '>',
        'Reply-To: ' . MAIL_FROM,
        'X-Mailer: PHP/' . phpversion(),
    ];

    $body = "This is a multi-part message in MIME format.\r\n"
        . "--{$boundary}\r\n"
        . "Content-Type: text/plain; charset=UTF-8\r\n"
        . "Content-Transfer-Encoding: 8bit\r\n\r\n"
        . $text . "\r\n\r\n"
        . "--{$boundary}\r\n"
        . "Content-Type: text/html; charset=UTF-8\r\n"
        . "Content-Transfer-Encoding: 8bit\r\n\r\n"
        . $html . "\r\n\r\n"
        . "--{$boundary}--";

    $encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
    return @mail($toEmail, $encodedSubject, $body, implode("\r\n", $headers), '-f ' . MAIL_FROM);
}

function send_enrollment_email(string $toEmail, string $toName, string $senha, array $curso): bool
{
    $subject = 'Sua vaga no curso ' . $curso['nome'] . ' está garantida — TECH SANTOS BR';

    $modulos = [
        'Módulo 01 — Fundamentos de Modelagem de Dados',
        'Módulo 02 — Perfil dos Dados',
        'Módulo 03 — Power Query: Conectando e Importando Dados',
        'Módulo 04 — Power Query: Transformação e Limpeza de Dados',
        'Módulo 05 — Laboratórios Práticos de Power Query',
        'Módulo 06 — Modelo de Dados & Otimização de Desempenho',
        'Módulo 07 — Fórmulas DAX',
        'Módulo 08 — Criar e Enriquecer Relatórios',
        'Módulo 09 — Laboratório Prático: DAX e DataViz',
        'Módulo 10 — Análise Avançada & Insights de IA',
        'Módulo 11 — Dashboards, Publicação & Governança',
        'Módulo 12 — Exercício Guiado TECH SANTOS BR',
        'Módulo 13 — Encerramento & Avaliação Final',
    ];
    $modulosHtml = '';
    foreach ($modulos as $m) {
        $modulosHtml .= '<li style="margin-bottom:6px;">' . htmlspecialchars($m, ENT_QUOTES) . '</li>';
    }

    $primeiroNome = htmlspecialchars(explode(' ', trim($toName))[0], ENT_QUOTES);
    $emailHtml = htmlspecialchars($toEmail, ENT_QUOTES);
    $senhaHtml = htmlspecialchars($senha, ENT_QUOTES);
    $cursoHtml = htmlspecialchars($curso['nome'], ENT_QUOTES);
    $sInsta = SOCIAL_INSTAGRAM;
    $sFace = SOCIAL_FACEBOOK;
    $sLinked = SOCIAL_LINKEDIN;
    $waLink = WHATSAPP_LINK;
    $waDisplay = WHATSAPP_DISPLAY;
    $footerHtml = email_footer_html();

    $html = <<<HTML
<!doctype html>
<html lang="pt-BR">
<body style="margin:0; padding:0; background:#F5F6F1; font-family: Arial, Helvetica, sans-serif; color:#10192B;">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#F5F6F1; padding:32px 16px;">
    <tr><td align="center">
      <table role="presentation" width="100%" style="max-width:560px; background:#ffffff; border-radius:8px; overflow:hidden; border:1px solid #DBDECF;">
        <tr><td style="background:#0F2440; padding:24px 32px;">
          <span style="color:#ffffff; font-size:18px; font-weight:bold;">TECH <span style="color:#6DC24D;">SANTOS BR</span></span>
        </td></tr>
        <tr><td style="padding:32px;">
          <h1 style="font-size:20px; margin:0 0 16px;">Oi, {$primeiroNome}! Sua vaga já está garantida</h1>
          <p style="font-size:15px; line-height:1.6; color:#48546A; margin:0 0 20px;">Que bom ter você com a gente! Você garantiu sua vaga no curso <strong>{$cursoHtml}</strong>. Abaixo estão seus dados de acesso e tudo o que vem por aí.</p>

          <table role="presentation" width="100%" style="background:#EBEEE3; border-radius:6px; margin-bottom:24px;">
            <tr><td style="padding:16px 20px;">
              <p style="margin:0 0 8px; font-size:13px; color:#48546A;">Acesse em <a href="https://techsantos.com.br/login.php" style="color:#35762A;">techsantos.com.br/login.php</a></p>
              <p style="margin:0 0 4px; font-size:14px;"><strong>Usuário (e-mail):</strong> {$emailHtml}</p>
              <p style="margin:0; font-size:14px;"><strong>Senha provisória:</strong> {$senhaHtml}</p>
            </td></tr>
          </table>

          <p style="font-size:13px; color:#7C8798; margin:0 0 24px;">Por segurança, é só criar uma senha nova assim que você entrar pela primeira vez.</p>

          <h2 style="font-size:16px; margin:0 0 12px;">O que você vai ver no curso</h2>
          <ul style="font-size:14px; color:#48546A; line-height:1.5; padding-left:20px; margin:0 0 24px;">
            {$modulosHtml}
          </ul>

          <p style="font-size:14px; color:#48546A; margin:0;">Qualquer dúvida é só responder este e-mail ou chamar a gente no <a href="{$waLink}" style="color:#35762A;">WhatsApp ({$waDisplay})</a> — estamos por aqui!</p>
        </td></tr>
{$footerHtml}
      </table>
    </td></tr>
  </table>
</body>
</html>
HTML;

    $modulosTexto = implode("\n", array_map(fn($m) => '- ' . $m, $modulos));
    $text = <<<TEXT
Oi, {$primeiroNome}!

Que bom ter você com a gente! Sua vaga no curso {$curso['nome']} já está garantida — aqui vão seus dados de acesso e tudo o que vem por aí.

Acesse em: https://techsantos.com.br/login.php
Usuário (e-mail): {$toEmail}
Senha provisória: {$senha}

Por segurança, é só criar uma senha nova assim que você entrar pela primeira vez.

O que você vai ver no curso:
{$modulosTexto}

Qualquer dúvida é só responder este e-mail ou chamar a gente no WhatsApp {$waDisplay} ({$waLink}) — estamos por aqui!

TECH SANTOS BR Treinamentos e Aulas Particulares · CNPJ 41.135.509/0001-29
Instagram: {$sInsta}
Facebook: {$sFace}
LinkedIn: {$sLinked}
TEXT;

    return send_html_email($toEmail, $subject, $html, $text);
}

function send_admin_credentials_email(string $toEmail, string $toName, string $usuario, string $senha): bool
{
    $subject = 'Seu acesso ao Painel Administrativo — TECH SANTOS BR';
    $primeiroNome = htmlspecialchars(explode(' ', trim($toName))[0], ENT_QUOTES);
    $usuarioHtml = htmlspecialchars($usuario, ENT_QUOTES);
    $senhaHtml = htmlspecialchars($senha, ENT_QUOTES);
    $sInsta = SOCIAL_INSTAGRAM;
    $sFace = SOCIAL_FACEBOOK;
    $sLinked = SOCIAL_LINKEDIN;
    $footerHtml = email_footer_html();

    $html = <<<HTML
<!doctype html>
<html lang="pt-BR">
<body style="margin:0; padding:0; background:#F5F6F1; font-family: Arial, Helvetica, sans-serif; color:#10192B;">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#F5F6F1; padding:32px 16px;">
    <tr><td align="center">
      <table role="presentation" width="100%" style="max-width:560px; background:#ffffff; border-radius:8px; overflow:hidden; border:1px solid #DBDECF;">
        <tr><td style="background:#0F2440; padding:24px 32px;">
          <span style="color:#ffffff; font-size:18px; font-weight:bold;">TECH <span style="color:#6DC24D;">SANTOS BR</span></span>
        </td></tr>
        <tr><td style="padding:32px;">
          <h1 style="font-size:20px; margin:0 0 16px;">Olá, {$primeiroNome}! Você tem acesso ao Painel Administrativo.</h1>
          <p style="font-size:15px; line-height:1.6; color:#48546A; margin:0 0 20px;">Um administrador criou uma conta para você gerenciar alunos, cursos, avaliações e pedidos da TECH SANTOS BR.</p>

          <table role="presentation" width="100%" style="background:#EBEEE3; border-radius:6px; margin-bottom:24px;">
            <tr><td style="padding:16px 20px;">
              <p style="margin:0 0 8px; font-size:13px; color:#48546A;">Acesse em <a href="https://techsantos.com.br/admin/login.php" style="color:#35762A;">techsantos.com.br/admin/login.php</a></p>
              <p style="margin:0 0 4px; font-size:14px;"><strong>Usuário:</strong> {$usuarioHtml}</p>
              <p style="margin:0; font-size:14px;"><strong>Senha provisória:</strong> {$senhaHtml}</p>
            </td></tr>
          </table>

          <p style="font-size:13px; color:#7C8798; margin:0;">Por segurança, você vai precisar definir uma nova senha no seu primeiro acesso.</p>
        </td></tr>
{$footerHtml}
      </table>
    </td></tr>
  </table>
</body>
</html>
HTML;

    $text = <<<TEXT
Olá, {$primeiroNome}!

Um administrador criou uma conta para você gerenciar alunos, cursos, avaliações e pedidos da TECH SANTOS BR.

Acesse em: https://techsantos.com.br/admin/login.php
Usuário: {$usuario}
Senha provisória: {$senha}

Por segurança, você vai precisar definir uma nova senha no seu primeiro acesso.

TECH SANTOS BR Treinamentos e Aulas Particulares · CNPJ 41.135.509/0001-29
Instagram: {$sInsta}
Facebook: {$sFace}
LinkedIn: {$sLinked}
TEXT;

    return send_html_email($toEmail, $subject, $html, $text);
}
