<?php
declare(strict_types=1);
// Grava o preço do curso de Python (R$ 59,90), mantendo-o inativo até a aprovação
// do dono. Protegido por SETUP_KEY e se apaga depois de rodar.
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$pdo->exec("UPDATE cursos SET preco_centavos = 5990 WHERE slug = 'python'");
foreach ($pdo->query("SELECT id, slug, nome, carga_horaria, preco_centavos, ativo FROM cursos WHERE slug = 'python'") as $c) {
    echo "{$c['id']} | {$c['slug']} | {$c['nome']} | {$c['carga_horaria']} | preco={$c['preco_centavos']} | ativo={$c['ativo']}\n";
}
@unlink(__FILE__);
