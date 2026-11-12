<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/promo_black_friday.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: valida a tabela e o INSERT dos lembretes da Black Friday sem mandar e-mail (grava e apaga um registro de teste).
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$pdo = db();
$email = 'teste-lembrete@techsantos.com.br';
bf_lembrete_salvar($pdo, 'Teste', $email, '64999998888', 'teste');
bf_lembrete_salvar($pdo, '', $email, '', 'teste'); // duplicado: não pode quebrar nem apagar o nome
$r = $pdo->prepare('SELECT nome, whatsapp, origem, enviado_27_em FROM bf_lembretes WHERE email = ?');
$r->execute([$email]);
echo json_encode($r->fetch(), JSON_UNESCAPED_UNICODE) . "\n";
$pdo->prepare('DELETE FROM bf_lembretes WHERE email = ?')->execute([$email]);
echo "total na tabela: " . $pdo->query('SELECT COUNT(*) FROM bf_lembretes')->fetchColumn() . "\n";
