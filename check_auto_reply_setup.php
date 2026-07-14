<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

header('Content-Type: text/plain; charset=utf-8');

$pdo = db();

echo "=== Regras cadastradas ===\n";
$rules = $pdo->query('SELECT id, palavra_chave, ativo FROM social_auto_reply_rules')->fetchAll();
if (!$rules) {
    echo "Nenhuma regra cadastrada.\n";
} else {
    foreach ($rules as $r) {
        echo "#{$r['id']} \"{$r['palavra_chave']}\" " . ($r['ativo'] ? 'ativa' : 'inativa') . "\n";
    }
}

echo "\n=== Log de respostas ===\n";
$log = $pdo->query('SELECT COUNT(*) c FROM social_auto_reply_log')->fetch();
echo "Total de entradas: {$log['c']}\n";

echo "\n=== Permissões do token da Página (Facebook) ===\n";
$err = null;
$data = meta_graph_get('debug_token', [
    'input_token' => META_PAGE_TOKEN,
    'access_token' => META_APP_ID . '|' . META_APP_SECRET,
], $err);
if ($data === null) {
    echo "Falha ao checar: {$err}\n";
} else {
    $scopes = $data['data']['scopes'] ?? [];
    $valid = $data['data']['is_valid'] ?? false;
    echo "Válido: " . ($valid ? 'sim' : 'não') . "\n";
    echo "Escopos: " . implode(', ', $scopes) . "\n";
    echo "Tem pages_messaging: " . (in_array('pages_messaging', $scopes, true) ? 'SIM' : 'NÃO') . "\n";
    echo "Tem pages_manage_engagement: " . (in_array('pages_manage_engagement', $scopes, true) ? 'SIM' : 'NÃO') . "\n";
}

echo "\n=== Permissões do token do Instagram ===\n";
$err2 = null;
$data2 = meta_graph_get('debug_token', [
    'input_token' => META_IG_TOKEN,
    'access_token' => META_IG_APP_ID . '|' . META_IG_APP_SECRET,
], $err2);
if ($data2 === null) {
    echo "Falha ao checar: {$err2}\n";
} else {
    $scopes2 = $data2['data']['scopes'] ?? [];
    $valid2 = $data2['data']['is_valid'] ?? false;
    echo "Válido: " . ($valid2 ? 'sim' : 'não') . "\n";
    echo "Escopos: " . implode(', ', $scopes2) . "\n";
    echo "Tem instagram_manage_comments: " . (in_array('instagram_manage_comments', $scopes2, true) ? 'SIM' : 'NÃO') . "\n";
    echo "Tem instagram_manage_messages: " . (in_array('instagram_manage_messages', $scopes2, true) ? 'SIM' : 'NÃO') . "\n";
}

echo "\n=== Webhook verify token configurado ===\n";
echo (META_WEBHOOK_VERIFY_TOKEN !== '' ? 'Sim, valor definido em config.php' : 'NÃO configurado') . "\n";

@unlink(__FILE__);
