<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único, somente leitura: histórico dos pedidos Black Friday cancelados (sem e-mail/telefone na saída).
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$pdo = db();
$cols = array_column($pdo->query('SHOW COLUMNS FROM pedidos')->fetchAll(), 'Field');
$extra = array_values(array_intersect(['lembrete_enviado', 'lembrete2_em', 'webhook_ultimo_erro', 'mp_payment_id', 'atualizado_em'], $cols));
$sel = implode(', ', array_map(fn($c) => "p.$c", $extra));
$st = $pdo->query("SELECT p.id, p.criado_em, p.status, SUBSTRING_INDEX(p.nome,' ',1) primeiro_nome,
    (p.telefone IS NOT NULL AND p.telefone<>'') tem_tel, $sel,
    (SELECT COUNT(*) FROM pedidos q WHERE q.email=p.email AND q.status='pago') pagos_mesmo_email,
    (SELECT COUNT(*) FROM alunos a WHERE a.email=p.email) ja_aluno
  FROM pedidos p WHERE p.oferta='black-friday-2026' AND p.email NOT LIKE '%techsantos%' AND p.email NOT LIKE '%claristonsantos%' ORDER BY p.id");
foreach ($st as $r) echo implode(' | ', array_map(fn($k, $v) => "$k=" . mb_substr((string)$v, 0, 90), array_keys($r), $r)) . "\n";
echo "fim\n";
