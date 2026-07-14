<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$path = __DIR__ . '/webhook_debug.log';
header('Content-Type: text/plain; charset=utf-8');

if (!file_exists($path)) {
    echo "Nenhuma requisição registrada ainda.\n";
    exit;
}

echo file_get_contents($path);
