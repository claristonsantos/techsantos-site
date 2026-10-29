<?php
declare(strict_types=1);
// Grava a carga horária do curso de Python no mesmo formato dos outros cursos (sem ativar).
// Protegido por SETUP_KEY e se apaga depois de rodar.
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$exemplo = (string)$pdo->query("SELECT carga_horaria FROM cursos WHERE carga_horaria IS NOT NULL AND carga_horaria <> '' ORDER BY id LIMIT 1")->fetchColumn();
$valor = preg_match('/^\d+$/', $exemplo) ? '30' : (preg_match('/^\d+h$/i', $exemplo) ? '30h' : '30 horas');
$pdo->prepare("UPDATE cursos SET carga_horaria = ? WHERE slug = 'python'")->execute([$valor]);
foreach ($pdo->query("SELECT id, slug, carga_horaria, preco_centavos, ativo FROM cursos ORDER BY id") as $c) {
    echo "{$c['id']} | {$c['slug']} | {$c['carga_horaria']} | preco={$c['preco_centavos']} | ativo={$c['ativo']}\n";
}
@unlink(__FILE__);
