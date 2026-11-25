<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/mailer.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: diagnóstico do SMTP. (1) teste só para o dono; (2) checa se o servidor aceita o destinatário
// do pedido 2910 (para no RCPT, faz RSET — nada é enviado ao cliente). Não imprime o e-mail do cliente.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$log = sys_get_temp_dir() . '/diag_smtp_' . bin2hex(random_bytes(4)) . '.log';
ini_set('log_errors', '1');
ini_set('error_log', $log);
$ok = send_html_email(OWNER_COPY_EMAIL, '[Teste] diagnóstico SMTP ' . date('d/m H:i'), '<p>Teste do mailer do site.</p>', 'Teste do mailer do site.');
echo "teste_dono=" . ($ok ? 'OK' : 'FALHA') . "\n";
echo "log_teste=" . trim((string)@file_get_contents($log)) . "\n";
$st = db()->prepare('SELECT email FROM pedidos WHERE id = 2910');
$st->execute();
$to = (string)$st->fetchColumn();
echo "email_cliente_formato=" . (filter_var($to, FILTER_VALIDATE_EMAIL) ? 'valido' : 'INVALIDO') . " dominio=" . substr(strrchr($to, '@') ?: '', 1) . "\n";
$sock = @stream_socket_client('ssl://' . SMTP_HOST . ':' . SMTP_PORT, $en, $es, 15);
if (!$sock) exit("connect falhou: $es\n");
$r = [];
$r['greet'] = smtp_command($sock, '');
foreach (['EHLO techsantos.com.br', 'AUTH LOGIN', base64_encode(SMTP_USER), base64_encode(SMTP_PASS), 'MAIL FROM:<' . MAIL_FROM . '>', 'RCPT TO:<' . $to . '>', 'RSET', 'QUIT'] as $i => $c) {
    $resp = smtp_command($sock, $c);
    $label = ['ehlo', 'auth', 'user', 'pass', 'mailfrom', 'rcpt_cliente', 'rset', 'quit'][$i];
    $r[$label] = substr(preg_replace('/\s+/', ' ', $resp), 0, 140);
}
fclose($sock);
foreach ($r as $k => $v) echo "$k=" . str_replace($to, '<cliente>', $v) . "\n";
@unlink($log);
