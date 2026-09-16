<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$row = $pdo->query("SELECT NOW() AS now_local, UTC_TIMESTAMP() AS now_utc, @@session.time_zone AS sess_tz, @@global.time_zone AS glob_tz")->fetch(PDO::FETCH_ASSOC);
foreach ($row as $k => $v) echo "$k: $v\n";
echo "php date() now: " . date('Y-m-d H:i:s') . "\n";
echo "php time(): " . time() . "\n";
@unlink(__FILE__);
