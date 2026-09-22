<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$stmt = $pdo->prepare("DELETE FROM whatsapp_leads WHERE telefone = '64999990000' AND origem = 'teste-diagnostico'");
$stmt->execute();
echo "removidas: " . $stmt->rowCount() . "\n";
@unlink(__FILE__);
