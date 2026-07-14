<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

header('Content-Type: text/plain; charset=utf-8');

echo "PAGBANK_ENV = " . PAGBANK_ENV . "\n";
$baseUrl = PAGBANK_ENV === 'production' ? 'https://api.pagseguro.com' : 'https://sandbox.api.pagseguro.com';
echo "URL = {$baseUrl}/checkouts\n";
echo "Token (primeiros/últimos 8 chars) = " . substr(PAGBANK_TOKEN, 0, 8) . "..." . substr(PAGBANK_TOKEN, -8) . " (tamanho " . strlen(PAGBANK_TOKEN) . ")\n\n";

$body = [
    'reference_id' => 'TESTE-DIAGNOSTICO-' . time(),
    'customer' => [
        'name' => 'Teste Diagnostico',
        'email' => 'teste-diagnostico@techsantos.com.br',
        'tax_id' => '11144477735',
        'phone' => ['country' => '55', 'area' => '64', 'number' => '999990000'],
    ],
    'customer_modifiable' => false,
    'items' => [
        ['name' => 'Teste', 'quantity' => 1, 'unit_amount' => 100],
    ],
    'payment_methods' => [['type' => 'CREDIT_CARD'], ['type' => 'PIX']],
    'redirect_url' => 'https://techsantos.com.br/pagbank-retorno.php?pedido=0',
    'notification_urls' => ['https://techsantos.com.br/pagbank-webhook.php'],
];

$ch = curl_init($baseUrl . '/checkouts');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($body, JSON_UNESCAPED_UNICODE),
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . PAGBANK_TOKEN,
        'Content-Type: application/json',
        'Accept: application/json',
    ],
    CURLOPT_TIMEOUT => 20,
]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

echo "HTTP status: {$httpCode}\n";
echo "curl error: " . ($curlError ?: '(nenhum)') . "\n";
echo "Corpo da resposta:\n{$response}\n";

@unlink(__FILE__);
