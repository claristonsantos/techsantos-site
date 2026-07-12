<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

function pagbank_base_url(): string
{
    return PAGBANK_ENV === 'production'
        ? 'https://api.pagseguro.com'
        : 'https://sandbox.api.pagseguro.com';
}

/**
 * Creates a PagBank hosted checkout session.
 * Returns ['id' => string, 'pay_url' => string] on success, or null on failure.
 */
function pagbank_create_checkout(array $pedido, array $curso, string $redirectUrl, string $notificationUrl): ?array
{
    $body = [
        'reference_id' => 'PEDIDO-' . $pedido['id'],
        'customer' => [
            'name' => $pedido['nome'],
            'email' => $pedido['email'],
            'tax_id' => $pedido['cpf'],
        ],
        'customer_modifiable' => false,
        'items' => [
            [
                'name' => $curso['nome'],
                'quantity' => 1,
                'unit_amount' => (int)$pedido['valor_centavos'],
            ],
        ],
        'payment_methods' => [
            ['type' => 'CREDIT_CARD'],
            ['type' => 'DEBIT_CARD'],
            ['type' => 'PIX'],
        ],
        'redirect_url' => $redirectUrl,
        'notification_urls' => [$notificationUrl],
    ];

    $ch = curl_init(pagbank_base_url() . '/checkouts');
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

    if ($response === false || $httpCode < 200 || $httpCode >= 300) {
        error_log('PagBank create_checkout failed: HTTP ' . $httpCode . ' ' . $curlError . ' body=' . (string)$response);
        return null;
    }

    $data = json_decode($response, true);
    if (!is_array($data) || empty($data['id'])) {
        return null;
    }

    $payUrl = null;
    foreach ($data['links'] ?? [] as $link) {
        if (($link['rel'] ?? '') === 'PAY') {
            $payUrl = $link['href'];
            break;
        }
    }

    if (!$payUrl) {
        return null;
    }

    return ['id' => $data['id'], 'pay_url' => $payUrl];
}

/**
 * Verifies the x-authenticity-token header PagBank sends with webhook notifications.
 * Formula per PagBank docs: SHA-256("{token}-{raw payload body}")
 */
function pagbank_verify_signature(string $rawPayload, string $receivedToken): bool
{
    $expected = hash('sha256', PAGBANK_TOKEN . '-' . $rawPayload);
    return hash_equals($expected, $receivedToken);
}
