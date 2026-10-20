<?php
declare(strict_types=1);
require_once __DIR__ . '/lead_nutricao.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: checa a sintaxe dos arquivos novos e mostra os assuntos/tamanho dos 3 e-mails (não envia nada).
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
foreach (['lead_nutricao.php', 'descadastrar.php', 'cron_lembrete_carrinho.php', 'capturar_whatsapp_lead.php', 'mailer.php', 'aulas_particulares_automacao.php'] as $f) {
    $out = function_exists('shell_exec') ? shell_exec('php -l ' . escapeshellarg(__DIR__ . '/' . $f) . ' 2>&1') : 'shell_exec indisponível';
    echo $f . ': ' . trim((string)$out) . "\n";
}
$pdo = db(); nutricao_ensure($pdo);
echo "colunas ok: " . implode(',', array_intersect(['email', 'nutricao_etapa', 'nutricao_em', 'nutricao_optout'], array_column($pdo->query('SHOW COLUMNS FROM whatsapp_leads')->fetchAll(), 'Field'))) . "\n";
for ($e = 1; $e <= 3; $e++) { [$a, $h, $t] = nutricao_email($e, 999); echo "etapa $e: $a | html " . strlen($h) . " bytes | descadastro=" . (str_contains($h, 'descadastrar.php?l=999') ? 'ok' : 'FALTA') . "\n"; }
echo "token descadastro valida: " . (hash_equals(nutricao_token(999), nutricao_token(999)) ? 'ok' : 'erro') . "\n";
