<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/mercadopago.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: diagnóstico do checkout (pedidos x tentativas de pagamento no Mercado Pago). Só leitura.
header('Content-Type: text/plain; charset=utf-8');
set_time_limit(120);
@unlink(__FILE__);
$pdo = db();
echo "MP_ENV=" . MERCADOPAGO_ENV . " MAX_INST=" . MERCADOPAGO_MAX_INSTALLMENTS . "\n";
$teste = "(email LIKE '%example.com' OR email LIKE '%techsantos%' OR email LIKE '%.invalid' OR email LIKE 'clariston%')";
echo "\n== status por mês (sem teste) ==\n";
foreach ($pdo->query("SELECT DATE_FORMAT(criado_em,'%Y-%m') m, status, COUNT(*) n FROM pedidos WHERE NOT $teste AND criado_em >= '2026-07-01' GROUP BY m, status ORDER BY m, status") as $r) echo "{$r['m']} {$r['status']} {$r['n']}\n";
echo "\n== pedidos reais 45 dias + tentativas MP ==\n";
$q = $pdo->query("SELECT p.id, p.nome, p.email, p.status, p.valor_centavos, p.criado_em, p.mercadopago_preference_id pref, p.utm_source, c.slug FROM pedidos p JOIN cursos c ON c.id=p.curso_id WHERE NOT $teste AND p.criado_em >= NOW() - INTERVAL 45 DAY ORDER BY p.id DESC LIMIT 40");
foreach ($q as $r) {
    echo "#{$r['id']} {$r['criado_em']} {$r['slug']} R$" . ($r['valor_centavos'] / 100) . " {$r['status']} | {$r['nome']} <{$r['email']}> src=" . ($r['utm_source'] ?? '-') . " pref=" . ($r['pref'] ? 'sim' : 'NAO') . "\n";
    $url = 'https://api.mercadopago.com/v1/payments/search?' . http_build_query(['external_reference' => 'PEDIDO-' . $r['id'], 'sort' => 'date_created', 'criteria' => 'desc']);
    $ch = curl_init($url); curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . MERCADOPAGO_ACCESS_TOKEN], CURLOPT_TIMEOUT => 20]);
    $resp = curl_exec($ch); $code = curl_getinfo($ch, CURLINFO_HTTP_CODE); curl_close($ch);
    $d = json_decode((string)$resp, true);
    if ($code !== 200) { echo "   MP_SEARCH_HTTP $code\n"; continue; }
    $res = $d['results'] ?? [];
    if (!$res) echo "   (nenhuma tentativa de pagamento no MP)\n";
    foreach ($res as $p) echo "   pay {$p['id']} {$p['date_created']} {$p['payment_method_id']}/{$p['payment_type_id']} {$p['status']} {$p['status_detail']} parc=" . ($p['installments'] ?? '') . "\n";
}
// preferência do pedido mais recente: ainda válida?
$last = $pdo->query("SELECT mercadopago_preference_id FROM pedidos WHERE id=2946")->fetchColumn();
if ($last) {
    $ch = curl_init('https://api.mercadopago.com/checkout/preferences/' . rawurlencode((string)$last)); curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . MERCADOPAGO_ACCESS_TOKEN], CURLOPT_TIMEOUT => 20]);
    $d = json_decode((string)curl_exec($ch), true); curl_close($ch);
    echo "\n== pref #2946 ==\n" . json_encode(['init_point' => isset($d['init_point']), 'expires' => $d['expires'] ?? null, 'exp_to' => $d['expiration_date_to'] ?? null, 'payment_methods' => $d['payment_methods'] ?? null, 'payer_cpf' => isset($d['payer']['identification']['number']) && $d['payer']['identification']['number'] !== '', 'binary_mode' => $d['binary_mode'] ?? null, 'purpose' => $d['purpose'] ?? null], JSON_UNESCAPED_UNICODE) . "\n";
}
