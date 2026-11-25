<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/mailer.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único (aprovado pelo dono em 24/11): e-mail pessoal de recuperação para o pedido Black Friday 2910.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$pdo = db();
$st = $pdo->prepare("SELECT id, nome, email, status, oferta FROM pedidos WHERE id = 2910");
$st->execute();
$p = $st->fetch();
if (!$p || $p['oferta'] !== 'black-friday-2026') exit("pedido nao encontrado\n");
$pago = $pdo->prepare("SELECT COUNT(*) FROM pedidos WHERE email = ? AND status = 'pago'");
$pago->execute([$p['email']]);
if ((int)$pago->fetchColumn() > 0) exit("cliente ja tem pedido pago, nao enviado\n");
$primeiro = trim(explode(' ', trim((string)$p['nome']))[0]);
if (stripos($primeiro, 'Maria') !== 0) exit("nome inesperado, nao enviado\n");
$link = 'https://techsantos.com.br/black-friday.php?utm_source=email&utm_medium=recuperacao&utm_campaign=bf2026';
$n = htmlspecialchars($primeiro, ENT_QUOTES);
$html = "<p>Oi, {$n}! Aqui é o Clariston, da Tech Santos.</p>"
    . "<p>Vi que você começou a garantir o combo da Black Friday (Power BI, Excel, Python e Inglês por R$ 119,90), mas o pagamento não foi concluído. Aconteceu algum problema?</p>"
    . "<p>Dá para pagar no Pix, na hora, ou parcelar em até 12x no cartão. A oferta vale até segunda, 30/11, às 23:59:<br>"
    . "<a href=\"{$link}\">techsantos.com.br/black-friday.php</a></p>"
    . "<p>Se tiver qualquer dúvida, é só responder este e-mail.</p><p>Abraço,<br>Clariston</p>" . email_footer_html();
$text = "Oi, {$primeiro}! Aqui é o Clariston, da Tech Santos.\n\nVi que você começou a garantir o combo da Black Friday (Power BI, Excel, Python e Inglês por R$ 119,90), mas o pagamento não foi concluído. Aconteceu algum problema?\n\nDá para pagar no Pix, na hora, ou parcelar em até 12x no cartão. A oferta vale até segunda, 30/11, às 23:59:\n{$link}\n\nSe tiver qualquer dúvida, é só responder este e-mail.\n\nAbraço,\nClariston";
$ok = send_html_email((string)$p['email'], "{$primeiro}, seu pedido da Black Friday não foi concluído", $html, $text, OWNER_COPY_EMAIL);
echo $ok ? "enviado (pedido 2910) com copia ao dono\n" : "FALHA no envio\n";
