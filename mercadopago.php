<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

/**
 * Creates a Mercado Pago Checkout Pro preference.
 * Returns ['id' => string, 'checkout_url' => string] on success, or null on failure.
 */
function mercadopago_create_preference(array $pedido, array $curso, string $backUrl, string $notificationUrl): ?array
{
    $payer = [
        'name' => $pedido['nome'],
        'email' => $pedido['email'],
    ];
    if (!empty($pedido['cpf'])) {
        // CPF é opcional no nosso formulário — se não coletamos, o Mercado
        // Pago pede dentro do próprio checkout dele.
        $payer['identification'] = [
            'type' => 'CPF',
            'number' => $pedido['cpf'],
        ];
    }

    $body = [
        'items' => [
            [
                'title' => $curso['nome'],
                'quantity' => 1,
                'unit_price' => round($pedido['valor_centavos'] / 100, 2),
                'currency_id' => 'BRL',
            ],
        ],
        'payer' => $payer,
        'back_urls' => [
            'success' => $backUrl,
            'failure' => $backUrl,
            'pending' => $backUrl,
        ],
        'auto_return' => 'approved',
        'external_reference' => 'PEDIDO-' . $pedido['id'],
        'notification_url' => $notificationUrl,
        'payment_methods' => [
            'installments' => MERCADOPAGO_MAX_INSTALLMENTS,
        ],
    ];

    $ch = curl_init('https://api.mercadopago.com/checkout/preferences');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($body, JSON_UNESCAPED_UNICODE),
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . MERCADOPAGO_ACCESS_TOKEN,
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
        error_log('MercadoPago create_preference failed: HTTP ' . $httpCode . ' ' . $curlError . ' body=' . (string)$response);
        return null;
    }

    $data = json_decode($response, true);
    if (!is_array($data) || empty($data['id'])) {
        return null;
    }

    // Em modo de teste o checkout precisa do sandbox_init_point; em produção, do init_point.
    $checkoutUrl = MERCADOPAGO_ENV === 'production'
        ? ($data['init_point'] ?? null)
        : ($data['sandbox_init_point'] ?? $data['init_point'] ?? null);

    if (!$checkoutUrl) {
        return null;
    }

    return ['id' => $data['id'], 'checkout_url' => $checkoutUrl];
}

/**
 * Fetches a payment's current state directly from the Mercado Pago API.
 * Webhook notifications only carry an id — the actual status must always be
 * re-confirmed server-to-server against our own token, never trusted from
 * the notification payload alone.
 */
function mercadopago_get_payment(string $paymentId): ?array
{
    $ch = curl_init('https://api.mercadopago.com/v1/payments/' . rawurlencode($paymentId));
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . MERCADOPAGO_ACCESS_TOKEN,
        ],
        CURLOPT_TIMEOUT => 20,
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($response === false || $httpCode < 200 || $httpCode >= 300) {
        return null;
    }
    $data = json_decode($response, true);
    return is_array($data) ? $data : null;
}
