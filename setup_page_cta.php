<?php
declare(strict_types=1);

require_once __DIR__ . '/meta_social.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$perms = meta_graph_get('me/permissions', ['access_token' => META_PAGE_TOKEN], $permError);

$error = null;
$ok = meta_set_page_cta('LEARN_MORE', 'https://techsantos.com.br/aula-gratis.php', $error);

header('Content-Type: text/plain; charset=utf-8');
echo "Permissões do token atual:\n";
if ($perms) {
    foreach ($perms['data'] ?? [] as $p) {
        echo "  - {$p['permission']}: {$p['status']}\n";
    }
} else {
    echo "  (falhou ao consultar: {$permError})\n";
}
echo "\n";
echo $ok ? "CTA configurado com sucesso.\n" : "FALHOU ao configurar o CTA: {$error}\n";

if ($ok) {
    @unlink(__FILE__);
}
