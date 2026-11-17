<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: testa o hotmart-webhook.php (sem token, produto desconhecido, evento ignorado). Não cria pedido nem aluno.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$post = function (array $headers, array $body): string {
    $ch = curl_init('https://techsantos.com.br/hotmart-webhook.php');
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_POST => true, CURLOPT_POSTFIELDS => json_encode($body), CURLOPT_HTTPHEADER => array_merge(['Content-Type: application/json'], $headers), CURLOPT_TIMEOUT => 20]);
    $r = curl_exec($ch); $c = curl_getinfo($ch, CURLINFO_HTTP_CODE); curl_close($ch);
    return "$c " . trim((string)$r);
};
$ok = ['X-Hotmart-Hottok: ' . HOTMART_HOTTOK];
echo "sem_token: " . $post([], ['event' => 'PURCHASE_APPROVED']) . "\n";
echo "evento_outro: " . $post($ok, ['event' => 'PURCHASE_CANCELED']) . "\n";
echo "produto_desconhecido: " . $post($ok, ['event' => 'PURCHASE_APPROVED', 'data' => ['product' => ['id' => 1], 'purchase' => ['status' => 'APPROVED', 'transaction' => 'TESTE-DIAG-' . time(), 'price' => ['value' => 1]], 'buyer' => ['email' => 'diag@techsantos-interno.invalid', 'name' => 'Diag']]]) . "\n";
