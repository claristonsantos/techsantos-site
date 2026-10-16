<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Diagnóstico de uso único (somente leitura): leads do WhatsApp (aula grátis) e o pipeline, dados pessoais mascarados.
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
foreach (['whatsapp_leads', 'whatsapp_lead_pipeline'] as $t) {
    if (!$pdo->query("SHOW TABLES LIKE '$t'")->fetchColumn()) { echo "== $t (não existe)\n"; continue; }
    $cols = array_column($pdo->query("SHOW COLUMNS FROM $t")->fetchAll(), 'Field');
    echo "== $t cols: " . implode(',', $cols) . "\n";
    $ord = $cols[0];
    foreach ($pdo->query("SELECT * FROM $t ORDER BY `$ord` DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC) as $r) {
        $o = [];
        foreach ($r as $k => $v) {
            if ($v === null || $v === '') continue;
            if (stripos($k, 'email') !== false) $v = preg_replace('/(^.).*(@.*$)/', '$1***$2', (string)$v);
            elseif (preg_match('/telefone|whats|phone|ip/i', $k)) $v = '***' . substr((string)$v, -4);
            elseif (stripos($k, 'nome') !== false) $v = explode(' ', (string)$v)[0];
            $o[] = "$k=" . mb_substr(str_replace("\n", ' ', (string)$v), 0, 50);
        }
        echo "  " . implode(' | ', $o) . "\n";
    }
}
@unlink(__FILE__);
