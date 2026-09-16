<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$stmt = $pdo->prepare("SELECT * FROM aulas_particulares_leads WHERE nome LIKE ? ORDER BY id DESC");
$stmt->execute(['%Cristiano%']);
$rows = $stmt->fetchAll();
if (!$rows) { echo "Nenhum lead encontrado com nome contendo 'Cristiano'.\n"; @unlink(__FILE__); exit; }
foreach ($rows as $r) {
    echo "=== #{$r['id']} {$r['nome']} <{$r['email']}> ===\n";
    foreach (['status','interesse','data_aula','horas','valor_centavos','pagamento_link','mercadopago_preference_id','link_reuniao','proposta_enviada_em','agendamento_enviado_em','cobranca_enviada_em','confirmacao_enviada_em','lembrete_cobranca_enviado_em','email_ultimo_erro','criado_em','atualizado_em'] as $col) {
        $v = $r[$col] ?? null;
        echo "  {$col}: " . ($v === null || $v === '' ? '(vazio)' : $v) . "\n";
    }
    echo "\n";
}
@unlink(__FILE__);
