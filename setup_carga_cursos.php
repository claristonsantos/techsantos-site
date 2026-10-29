<?php
declare(strict_types=1);
// Grava a carga horária de Inglês (30h), Excel (30h) e Microsoft Fabric (40h), aprovada pelo dono
// em 2026-10-29, no mesmo formato do Power BI. Protegido por SETUP_KEY e se apaga depois de rodar.
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$upd = $pdo->prepare('UPDATE cursos SET carga_horaria = ? WHERE slug = ?');
foreach (['ingles' => '30h', 'excel' => '30h', 'microsoft-fabric' => '40h'] as $slug => $h) $upd->execute([$h, $slug]);
foreach ($pdo->query("SELECT id, slug, carga_horaria, preco_centavos, ativo FROM cursos ORDER BY id") as $c) {
    echo "{$c['id']} | {$c['slug']} | {$c['carga_horaria']} | preco={$c['preco_centavos']} | ativo={$c['ativo']}\n";
}
@unlink(__FILE__);
