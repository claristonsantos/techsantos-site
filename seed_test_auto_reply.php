<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$pdo->prepare('INSERT INTO social_auto_reply_rules (palavra_chave, mensagem, ativo) VALUES (?, ?, 1)')
    ->execute(['TESTAUTO', 'Mensagem de teste da regra de auto-resposta.']);

header('Content-Type: text/plain; charset=utf-8');
echo "Regra de teste criada, id " . $pdo->lastInsertId() . "\n";

@unlink(__FILE__);
