<?php
declare(strict_types=1);
// Coloca o curso Microsoft Fabric à venda: R$ 129,90 e ativo. Mostra o estado
// dos cursos para conferência. Protegido por SETUP_KEY e se apaga depois.
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$n = $pdo->exec("UPDATE cursos SET preco_centavos = 12990, ativo = 1 WHERE slug = 'microsoft-fabric'");
echo "linhas atualizadas: {$n}\n";
foreach ($pdo->query('SELECT id, slug, nome, preco_centavos, ativo FROM cursos ORDER BY id') as $c) {
    echo "{$c['id']} | {$c['slug']} | {$c['nome']} | preco={$c['preco_centavos']} | ativo={$c['ativo']}\n";
}
@unlink(__FILE__);
