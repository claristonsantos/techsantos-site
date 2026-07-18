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
 * Sends a server-side Purchase event to Meta's Conversions API. Uses the
 * same event_id the browser pixel fires in pagbank-retorno.php (pedido_<id>)
 * so Meta deduplicates the two into a single conversion — this is a backup
 * signal for buyers whose browser blocks the client-side pixel (ad blockers,
 * Safari ITP), not a replacement for it.
 */
function meta_capi_send_purchase(int $pedidoId, string $email, string $telefoneDigits, float $valor, string $cursoNome): void
{
    if (META_CAPI_ACCESS_TOKEN === '') {
        return;
    }

    $userData = ['em' => [hash('sha256', strtolower(trim($email)))]];
    if ($telefoneDigits !== '') {
        $telefoneE164 = str_starts_with($telefoneDigits, '55') ? $telefoneDigits : '55' . $telefoneDigits;
        $userData['ph'] = [hash('sha256', $telefoneE164)];
    }

    $body = [
        'data' => [[
            'event_name' => 'Purchase',
            'event_time' => time(),
            'event_id' => 'pedido_' . $pedidoId,
            'action_source' => 'website',
            'event_source_url' => 'https://techsantos.com.br/pagbank-retorno.php?pedido=' . $pedidoId,
            'user_data' => $userData,
            'custom_data' => [
                'value' => $valor,
                'currency' => 'BRL',
                'content_name' => $cursoNome,
            ],
        ]],
        'access_token' => META_CAPI_ACCESS_TOKEN,
    ];

    $ch = curl_init('https://graph.facebook.com/v23.0/' . META_PIXEL_ID . '/events');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($body, JSON_UNESCAPED_UNICODE),
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_TIMEOUT => 10,
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode < 200 || $httpCode >= 300) {
        error_log('Meta CAPI Purchase failed: HTTP ' . $httpCode . ' body=' . (string)$response);
    }
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
