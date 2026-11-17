<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: confere a conta de teste dos revisores da Hotmart (nome Aline). Só leitura, não lê senha.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$pdo = db();
$q = $pdo->query("SELECT id, nome, email, ativo, senha_temporaria, criado_em FROM alunos WHERE nome LIKE '%Aline%' OR email LIKE '%aline%' ORDER BY id DESC LIMIT 10");
foreach ($q as $a) {
    echo json_encode($a, JSON_UNESCAPED_UNICODE) . "\n";
    $m = $pdo->prepare("SELECT c.slug FROM matriculas m JOIN cursos c ON c.id = m.curso_id WHERE m.aluno_id = ?");
    $m->execute([$a['id']]);
    echo "  cursos: " . implode(', ', $m->fetchAll(PDO::FETCH_COLUMN)) . "\n";
}
