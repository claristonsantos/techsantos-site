<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$path = __DIR__ . '/webhook_debug.log';
$removed = false;
if (file_exists($path)) {
    $removed = @unlink($path);
}

header('Content-Type: text/plain; charset=utf-8');
echo $removed ? "webhook_debug.log removido.\n" : "Nada para remover.\n";

@unlink(__FILE__);
