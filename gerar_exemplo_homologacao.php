<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

header('Content-Type: text/plain; charset=utf-8');

$baseUrl = PAGBANK_ENV === 'production' ? 'https://api.pagseguro.com' : 'https://sandbox.api.pagseguro.com';

$body = [
    'reference_id' => 'PEDIDO-EXEMPLO-HOMOLOGACAO',
    'customer' => [
        'name' => 'Cliente Exemplo',
        'email' => 'cliente.exemplo@email.com',
        'tax_id' => '11144477735',
        'phone' => ['country' => '55', 'area' => '64', 'number' => '999998888'],
    ],
    'customer_modifiable' => false,
    'items' => [
        ['name' => 'Curso Power BI Completo', 'quantity' => 1, 'unit_amount' => 29900],
    ],
    'payment_methods' => [
        ['type' => 'CREDIT_CARD'],
        ['type' => 'DEBIT_CARD'],
        ['type' => 'PIX'],
    ],
    'payment_methods_configs' => [
        ['type' => 'CREDIT_CARD', 'config_options' => [['option' => 'INSTALLMENTS_LIMIT', 'value' => '12']]],
    ],
    'redirect_url' => 'https://techsantos.com.br/pagbank-retorno.php?pedido=123',
    'notification_urls' => ['https://techsantos.com.br/pagbank-webhook.php'],
];

$bodyJson = json_encode($body, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

echo "===== REQUEST =====\n";
echo "POST {$baseUrl}/checkouts\n";
echo "Authorization: Bearer [TOKEN OMITIDO]\n";
echo "Content-Type: application/json\n";
echo "Accept: application/json\n\n";
echo $bodyJson . "\n\n";

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
curl_close($ch);

echo "===== RESPONSE =====\n";
echo "HTTP {$httpCode}\n";
$decoded = json_decode($response, true);
echo $decoded ? json_encode($decoded, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) : $response;
echo "\n";

@unlink(__FILE__);
