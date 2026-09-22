<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$stmt = $pdo->query("SHOW COLUMNS FROM avaliacoes");
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) echo "{$r['Field']} ({$r['Type']})\n";
echo "\n=== dados ===\n";
$stmt2 = $pdo->query("SELECT * FROM avaliacoes LIMIT 20");
foreach ($stmt2->fetchAll(PDO::FETCH_ASSOC) as $r) echo json_encode($r, JSON_UNESCAPED_UNICODE) . "\n";
echo "\ntotal: " . $pdo->query("SELECT COUNT(*) FROM avaliacoes")->fetchColumn() . "\n";
@unlink(__FILE__);
