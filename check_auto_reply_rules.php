<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$rows = $pdo->query('SELECT * FROM social_auto_reply_rules ORDER BY criado_em DESC')->fetchAll();

header('Content-Type: text/plain; charset=utf-8');
if (!$rows) {
    echo "Nenhuma regra cadastrada.\n";
}
foreach ($rows as $r) {
    echo "id={$r['id']} palavra_chave={$r['palavra_chave']} ativo={$r['ativo']} mensagem=\"{$r['mensagem']}\"\n";
}

@unlink(__FILE__);
