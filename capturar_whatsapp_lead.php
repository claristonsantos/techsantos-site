<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'method_not_allowed']);
    exit;
}

$raw = file_get_contents('php://input');
$data = json_decode($raw, true) ?? $_POST;

$telefoneRaw = trim((string)($data['telefone'] ?? ''));
$origem = trim((string)($data['origem'] ?? 'aula-gratis'));

// Mantém só dígitos; exige um telefone brasileiro plausível (10-11 dígitos,
// com ou sem DDI 55).
$digits = preg_replace('/\D/', '', $telefoneRaw);
if ($digits === null || strlen($digits) < 10 || strlen($digits) > 13) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'telefone_invalido']);
    exit;
}

$pdo = db();
$stmt = $pdo->prepare('INSERT INTO whatsapp_leads (telefone, origem) VALUES (?, ?)');
$stmt->execute([$digits, $origem !== '' ? $origem : 'aula-gratis']);

echo json_encode(['ok' => true]);
