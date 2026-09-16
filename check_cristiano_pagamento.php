<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$stmt = $pdo->prepare('SELECT * FROM aulas_particulares_leads WHERE id = 6');
$stmt->execute();
$lead = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$lead) { echo "lead not found\n"; @unlink(__FILE__); exit; }
foreach ($lead as $k => $v) {
    echo "$k: $v\n";
}
@unlink(__FILE__);
