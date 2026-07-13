<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/mailer.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$to = (string)($_GET['to'] ?? '');
if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    exit('Informe um e-mail válido em ?to=');
}

$ok = send_enrollment_email($to, 'Teste de Entrega', 'SenhaTeste123', ['nome' => 'Power BI Completo (teste de e-mail)']);

header('Content-Type: text/plain; charset=utf-8');
echo $ok ? "Enviado (mail() retornou true) para {$to}\n" : "Falhou (mail() retornou false)\n";

@unlink(__FILE__);
