<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();

$palavraChave = '2026';
$mensagem = "Oi! Recebi seu comentário 🙌 Aqui está o link da nossa aula de apresentação gratuita do curso completo de Power BI: https://techsantos.com.br/aula-gratis.php — um tour pelos 13 módulos, a apostila e como funciona o certificado, antes de você decidir se matricular.";

$exists = $pdo->prepare('SELECT id FROM social_auto_reply_rules WHERE palavra_chave = ?');
$exists->execute([$palavraChave]);

if ($exists->fetch()) {
    echo "Regra com a palavra-chave '{$palavraChave}' já existe — nada foi alterado.\n";
} else {
    $pdo->prepare('INSERT INTO social_auto_reply_rules (palavra_chave, mensagem, ativo) VALUES (?, ?, 1)')
        ->execute([$palavraChave, $mensagem]);
    header('Content-Type: text/plain; charset=utf-8');
    echo "Regra criada: comentar '{$palavraChave}' dispara DM automático com o link da aula grátis.\n";
}

@unlink(__FILE__);
