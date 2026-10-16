<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Diagnóstico de uso único (somente leitura): leads recentes de todas as origens, e-mail mascarado.
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$m = fn($e) => preg_replace('/(^.).*(@.*$)/', '$1***$2', (string)$e);
foreach (['aulas_particulares_leads', 'consultoria_leads', 'whatsapp_lead_pipeline', 'whatsapp_leads'] as $t) {
    if (!$pdo->query("SHOW TABLES LIKE '$t'")->fetchColumn()) { echo "== $t (não existe)\n"; continue; }
    $cols = array_column($pdo->query("SHOW COLUMNS FROM $t")->fetchAll(), 'Field');
    echo "== $t cols: " . implode(',', $cols) . "\n";
    $ord = in_array('criado_em', $cols) ? 'criado_em' : 'id';
    foreach ($pdo->query("SELECT * FROM $t ORDER BY $ord DESC LIMIT 8")->fetchAll() as $r) {
        $o = [];
        foreach ($r as $k => $v) {
            if ($v === null || $v === '' || is_int($k)) continue;
            if (stripos($k, 'email') !== false) $v = $m($v);
            elseif (stripos($k, 'telefone') !== false || stripos($k, 'whats') !== false || stripos($k, 'phone') !== false) $v = '***' . substr((string)$v, -4);
            elseif (stripos($k, 'nome') !== false) $v = explode(' ', (string)$v)[0];
            elseif (stripos($k, 'token') !== false || stripos($k, 'link') !== false || stripos($k, 'meet') !== false) $v = '[..]';
            $o[] = "$k=" . mb_substr(str_replace("\n", ' ', (string)$v), 0, 60);
        }
        echo "  " . implode(' | ', $o) . "\n";
    }
}
@unlink(__FILE__);
