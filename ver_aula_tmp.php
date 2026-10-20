<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Diagnóstico de uso único (somente leitura): últimos pedidos de aula e o status dos e-mails.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$m = fn($e) => preg_replace('/(^.).*(@.*$)/', '$1***$2', (string)$e);
foreach (db()->query("SELECT id, nome, email, status, criado_em, atualizado_em, data_aula, proposta_enviada_em, agendamento_enviado_em, confirmacao_enviada_em, cobranca_enviada_em, email_ultimo_erro FROM aulas_particulares_leads ORDER BY atualizado_em DESC LIMIT 4") as $r) {
    $r['nome'] = explode(' ', (string)$r['nome'])[0]; $r['email'] = $m($r['email']);
    echo implode(' | ', array_map(fn($k, $v) => "$k=" . ($v ?? '-'), array_keys($r), $r)), "\n";
}
