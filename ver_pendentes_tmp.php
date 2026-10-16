<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/mercadopago.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Diagnóstico de uso único (somente leitura): pedidos pendentes dos últimos 30 dias + tentativas de pagamento no Mercado Pago.
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$rows = $pdo->query("SELECT p.id, c.slug, p.valor_centavos, p.criado_em, p.status, p.lembrete_enviado, p.nome, p.email, p.utm_source, p.utm_campaign, p.landing_page, p.mercadopago_preference_id, p.webhook_ultimo_erro
  FROM pedidos p JOIN cursos c ON c.id=p.curso_id WHERE p.criado_em >= NOW() - INTERVAL 30 DAY ORDER BY p.id DESC LIMIT 15")->fetchAll();
foreach ($rows as $r) {
    $mask = preg_replace('/(^.).*(@.*$)/', '$1***$2', (string)$r['email']);
    echo "#{$r['id']} {$r['slug']} R$" . ($r['valor_centavos']/100) . " criado={$r['criado_em']}UTC status={$r['status']} lembrete={$r['lembrete_enviado']} nome=" . explode(' ', (string)$r['nome'])[0] . " email=$mask utm={$r['utm_source']}/{$r['utm_campaign']} landing={$r['landing_page']} pref=" . ($r['mercadopago_preference_id'] ? 'sim' : 'nao') . " erro=" . ($r['webhook_ultimo_erro'] ?? '') . "\n";
    if ($r['status'] !== 'pendente') continue;
    $ch = curl_init('https://api.mercadopago.com/v1/payments/search?' . http_build_query(['external_reference' => 'PEDIDO-' . $r['id'], 'sort' => 'date_created', 'criteria' => 'desc']));
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . MERCADOPAGO_ACCESS_TOKEN], CURLOPT_TIMEOUT => 20]);
    $d = json_decode((string)curl_exec($ch), true); curl_close($ch);
    $res = $d['results'] ?? [];
    if (!$res) echo "    MP: nenhuma tentativa de pagamento\n";
    foreach ($res as $pay) echo "    MP: {$pay['date_created']} {$pay['payment_method_id']}/{$pay['payment_type_id']} status={$pay['status']} detalhe={$pay['status_detail']}\n";
}
@unlink(__FILE__);
