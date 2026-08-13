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
 * Sends Lead and Purchase events for private lessons to Meta CAPI.
 * Email and phone are normalized and SHA-256 hashed before transmission.
 */
function meta_capi_send_lesson_event(string $eventName, int $leadId, string $email, string $telefone, string $interesse, ?float $valor = null, array $requestContext = []): bool
{
    if (META_CAPI_ACCESS_TOKEN === '') return false;
    $emailNormalized = strtolower(trim($email));
    $phoneDigits = preg_replace('/\D/', '', $telefone) ?? '';
    if ($phoneDigits !== '' && !str_starts_with($phoneDigits, '55')) $phoneDigits = '55' . $phoneDigits;
    $userData = ['em' => [hash('sha256', $emailNormalized)]];
    if ($phoneDigits !== '') $userData['ph'] = [hash('sha256', $phoneDigits)];
    foreach (['fbp','fbc','client_ip_address','client_user_agent'] as $key) {
        if (!empty($requestContext[$key])) $userData[$key] = (string)$requestContext[$key];
    }
    $eventKey = $eventName === 'Purchase' ? 'purchase' : 'lead';
    $customData = ['content_name'=>$interesse,'content_category'=>'Aulas particulares'];
    if ($valor !== null) $customData += ['value'=>$valor,'currency'=>'BRL'];
    $body = ['data'=>[[]],'access_token'=>META_CAPI_ACCESS_TOKEN];
    $body['data'][0] = [
        'event_name'=>$eventName,'event_time'=>time(),'event_id'=>'aula_'.$eventKey.'_'.$leadId,
        'action_source'=>'website','event_source_url'=>'https://techsantos.com.br/aulas-particulares-power-bi.php',
        'user_data'=>$userData,'custom_data'=>$customData,
    ];
    $ch=curl_init('https://graph.facebook.com/v23.0/'.META_PIXEL_ID.'/events');
    curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER=>true,CURLOPT_POST=>true,CURLOPT_POSTFIELDS=>json_encode($body,JSON_UNESCAPED_UNICODE),CURLOPT_HTTPHEADER=>['Content-Type: application/json'],CURLOPT_TIMEOUT=>10]);
    $response=curl_exec($ch);$httpCode=curl_getinfo($ch,CURLINFO_HTTP_CODE);curl_close($ch);
    if($httpCode<200||$httpCode>=300){error_log('Meta CAPI aula '.$eventName.' failed: HTTP '.$httpCode.' body='.(string)$response);return false;}
    return true;
}
/**
 * Sends a server-side "purchase" event to GA4 via the Measurement Protocol.
 * GA4 has no client-side purchase event anywhere on the site — without this,
 * every sale is invisible in GA4 regardless of channel, making blended ROAS
 * impossible to compute. $ga4ClientId should be the real visitor's _ga cookie
 * id (captured at checkout, see comprar.php) so the sale attributes back to
 * the session/channel that drove it; when unavailable (e.g. Hotmart's own
 * checkout, outside our domain) a random id is used as a fallback — the
 * purchase still counts, but shows up unattributed ("(not set)") in GA4.
 */
function ga4_send_purchase(int $pedidoId, ?string $ga4ClientId, float $valor, string $cursoNome): void
{
    if (GA4_API_SECRET === '') {
        return;
    }

    $clientId = $ga4ClientId !== null && $ga4ClientId !== '' ? $ga4ClientId : bin2hex(random_bytes(8)) . '.' . time();

    $body = [
        'client_id' => $clientId,
        'events' => [[
            'name' => 'purchase',
            'params' => [
                'transaction_id' => 'pedido_' . $pedidoId,
                'value' => $valor,
                'currency' => 'BRL',
                'items' => [[
                    'item_name' => $cursoNome,
                    'price' => $valor,
                    'quantity' => 1,
                ]],
            ],
        ]],
    ];

    $url = 'https://www.google-analytics.com/mp/collect?measurement_id=' . GA4_MEASUREMENT_ID . '&api_secret=' . GA4_API_SECRET;
    $ch = curl_init($url);
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

    // GA4 Measurement Protocol returns 204 with an empty body even for most
    // malformed events — it does not fail loudly. Log unexpected codes only.
    if ($httpCode < 200 || $httpCode >= 300) {
        error_log('GA4 Measurement Protocol purchase failed: HTTP ' . $httpCode . ' body=' . (string)$response);
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

/** Localiza um pagamento aprovado pela referência interna do pedido. */
function mercadopago_search_approved_payment(string $externalReference): ?array
{
    $url='https://api.mercadopago.com/v1/payments/search?'.http_build_query(['external_reference'=>$externalReference,'sort'=>'date_created','criteria'=>'desc']);
    $ch=curl_init($url); curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER=>true,CURLOPT_HTTPHEADER=>['Authorization: Bearer '.MERCADOPAGO_ACCESS_TOKEN],CURLOPT_TIMEOUT=>20]);
    $response=curl_exec($ch); $code=curl_getinfo($ch,CURLINFO_HTTP_CODE); curl_close($ch);
    if($response===false || $code<200 || $code>=300)return null;
    $data=json_decode($response,true);
    foreach(($data['results']??[]) as $payment){if(($payment['status']??'')==='approved')return $payment;}
    return null;
}
