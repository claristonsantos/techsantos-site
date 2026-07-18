<?php
declare(strict_types=1);

// Diagnóstico temporário: só grava o payload bruto que a Hotmart mandar,
// pra confirmarmos os nomes de campo reais antes de escrever a lógica final
// (criar pedido + liberar aluno + Purchase no Meta). Sem efeito nenhum em
// banco de dados. Apagar depois que confirmarmos o formato.

$raw = file_get_contents('php://input') ?: '';
$headers = function_exists('getallheaders') ? getallheaders() : [];
$linha = sprintf(
    "[%s] GET=%s HEADERS=%s BODY=%s\n\n",
    date('Y-m-d H:i:s'),
    json_encode($_GET, JSON_UNESCAPED_UNICODE),
    json_encode($headers, JSON_UNESCAPED_UNICODE),
    $raw
);
file_put_contents(__DIR__ . '/hotmart-webhook-log.txt', $linha, FILE_APPEND | LOCK_EX);

http_response_code(200);
echo 'ok';
