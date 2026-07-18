<?php
declare(strict_types=1);

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/mailer.php';

const MONITOR_TEST_EMAIL = 'monitor.checkout@techsantos-interno.invalid';
const MONITOR_ALERT_TO = 'claristonsantos@hotmail.com';

/**
 * Simula uma compra real de ponta a ponta (abre comprar.php, extrai o token
 * CSRF, envia o formulário) e confere se o resultado é o esperado: um
 * redirecionamento real pro Mercado Pago. Detecta tanto "a página não
 * carrega" quanto bugs mais sutis como o de hoje (sessão iniciada tarde
 * demais, quebrando o CSRF em todo POST) — algo que só aparece numa compra
 * de verdade, não num simples "a página abre".
 */
function checar_checkout(): array
{
    $jar = tempnam(sys_get_temp_dir(), 'ts_monitor_');
    $baseOpts = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_COOKIEJAR => $jar,
        CURLOPT_COOKIEFILE => $jar,
        CURLOPT_TIMEOUT => 20,
        CURLOPT_HEADER => true,
    ];

    $ch = curl_init('https://techsantos.com.br/comprar.php');
    curl_setopt_array($ch, $baseOpts);
    $getResponse = curl_exec($ch);
    $getError = curl_error($ch);
    curl_close($ch);

    if ($getResponse === false) {
        @unlink($jar);
        return [false, "GET em comprar.php falhou: {$getError}"];
    }

    if (!preg_match('/name="csrf" value="([^"]+)"/', $getResponse, $m)) {
        @unlink($jar);
        return [false, 'Formulário de checkout não apareceu na página (sem campo csrf) — provavelmente o preço/curso não foi encontrado.'];
    }
    $token = $m[1];

    $postFields = http_build_query([
        'csrf' => $token,
        'nome' => 'Monitor Automatico',
        'email' => MONITOR_TEST_EMAIL,
        'telefone' => '64999999999',
    ]);

    $ch = curl_init('https://techsantos.com.br/comprar.php');
    curl_setopt_array($ch, $baseOpts + [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postFields,
        CURLOPT_FOLLOWLOCATION => false,
    ]);
    $postResponse = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $postError = curl_error($ch);
    curl_close($ch);
    @unlink($jar);

    if ($postResponse === false) {
        return [false, "POST em comprar.php falhou: {$postError}"];
    }

    if ($httpCode !== 302 || !preg_match('/Location:\s*(\S+)/i', $postResponse, $loc) || !str_contains($loc[1], 'mercadopago.com.br')) {
        $trecho = strip_tags(substr($postResponse, 0, 500));
        return [false, "Checkout não redirecionou pro Mercado Pago (HTTP {$httpCode}). Resposta: " . trim($trecho)];
    }

    return [true, 'ok'];
}

[$ok, $detalhe] = checar_checkout();

// O teste bem-sucedido cria um pedido real (e chama a API de produção do
// Mercado Pago) — limpa esse rastro de teste a cada execução.
$pdo = db();
$pdo->prepare('DELETE FROM pedidos WHERE email = ?')->execute([MONITOR_TEST_EMAIL]);

if ($ok) {
    echo date('Y-m-d H:i:s') . " - checkout ok\n";
    exit;
}

echo date('Y-m-d H:i:s') . " - FALHA: {$detalhe}\n";

$html = '<p style="font-family:Arial,sans-serif; font-size:15px;">'
    . '<strong>O checkout do curso (comprar.php) parou de funcionar.</strong></p>'
    . '<p style="font-family:Arial,sans-serif; font-size:14px; color:#48546A;">' . htmlspecialchars($detalhe, ENT_QUOTES) . '</p>'
    . '<p style="font-family:Arial,sans-serif; font-size:13px; color:#7C8798;">Detectado automaticamente em ' . date('d/m/Y H:i:s') . '. Enquanto isso, nenhum aluno consegue comprar o curso.</p>';
$text = "O checkout do curso (comprar.php) parou de funcionar.\n\n{$detalhe}\n\nDetectado automaticamente em " . date('d/m/Y H:i:s') . '. Enquanto isso, nenhum aluno consegue comprar o curso.';

send_html_email(MONITOR_ALERT_TO, '[URGENTE] Checkout do curso quebrado — techsantos.com.br', $html, $text);
