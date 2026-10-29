<?php
declare(strict_types=1);
// Ativa o curso de Python (aprovado pelo dono em 2026-10-29). Protegido por SETUP_KEY e se apaga depois de rodar.
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$pdo->exec("UPDATE cursos SET ativo = 1 WHERE slug IN ('python', 'ingles')");
foreach ($pdo->query("SELECT id, slug, carga_horaria, preco_centavos, ativo FROM cursos ORDER BY id") as $c) {
    echo "{$c['id']} | {$c['slug']} | {$c['carga_horaria']} | preco={$c['preco_centavos']} | ativo={$c['ativo']}\n";
}
@unlink(__FILE__);
