<?php
declare(strict_types=1);
// Grava o preço do curso de Inglês (R$ 49,90), mantendo-o inativo até o
// conteúdo ficar completo. Protegido por SETUP_KEY e se apaga depois de rodar.
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$pdo->exec("UPDATE cursos SET preco_centavos = 4990 WHERE slug = 'ingles'");
foreach ($pdo->query("SELECT id, slug, preco_centavos, ativo FROM cursos WHERE slug = 'ingles'") as $c) {
    echo "{$c['id']} | {$c['slug']} | preco={$c['preco_centavos']} | ativo={$c['ativo']}\n";
}
@unlink(__FILE__);
