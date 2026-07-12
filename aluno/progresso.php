<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
$aluno = require_aluno();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input') ?: '[]', true) ?: [];
$licaoId = (string)($input['licao_id'] ?? '');
$action = (string)($input['action'] ?? '');

if (!preg_match('/^[a-z0-9-]+$/', $licaoId) || !in_array($action, ['complete', 'uncomplete'], true)) {
    http_response_code(400);
    echo json_encode(['error' => 'invalid input']);
    exit;
}

$pdo = db();
if ($action === 'complete') {
    $stmt = $pdo->prepare('INSERT IGNORE INTO progresso (aluno_id, licao_id) VALUES (?, ?)');
    $stmt->execute([$aluno['id'], $licaoId]);
} else {
    $stmt = $pdo->prepare('DELETE FROM progresso WHERE aluno_id = ? AND licao_id = ?');
    $stmt->execute([$aluno['id'], $licaoId]);
}

echo json_encode(['ok' => true]);
