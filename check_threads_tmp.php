<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('forbidden');
}
header('Content-Type: text/plain; charset=utf-8');
set_time_limit(200);
@unlink(__FILE__);
$off = array_map('trim', explode(',', (string)ini_get('disable_functions')));
echo 'shell_exec disponível: ' . (function_exists('shell_exec') && !in_array('shell_exec', $off, true) ? 'sim' : 'não') . "\n";
if (function_exists('shell_exec') && !in_array('shell_exec', $off, true)) {
    echo "--- crontab -l\n" . shell_exec('crontab -l 2>&1') . "\n";
    $php = trim((string)shell_exec('command -v php 2>&1'));
    echo "--- php: $php\n";
    echo "--- execução manual do social_publish_cron.php\n";
    echo shell_exec('cd ' . escapeshellarg(__DIR__) . ' && timeout 150 php social_publish_cron.php 2>&1; echo "exit=$?"');
}
echo "\ndone\n";
