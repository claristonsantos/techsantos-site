<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/matriculas.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: conta de aluno para os revisores da Hotmart conferirem a área externa.
// Senha aleatória descartada (ninguém conhece); o dono define a real em esqueci-senha.php.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
@unlink(__DIR__ . '/diag_aluna_teste.php'); // consulta interrompida que ficou no servidor
$email = 'claristonbsantos@gmail.com';
$pdo = db();
matriculas_ensure_schema($pdo);
$st = $pdo->prepare('SELECT id, ativo FROM alunos WHERE LOWER(email) = LOWER(?) LIMIT 1');
$st->execute([$email]);
$aluno = $st->fetch();
if ($aluno) {
    $id = (int)$aluno['id'];
    $pdo->prepare('UPDATE alunos SET ativo = 1 WHERE id = ?')->execute([$id]);
    echo "ALUNO|JA_EXISTIA|$id\n";
} else {
    $cursoPbi = (int)$pdo->query("SELECT id FROM cursos WHERE slug = 'power-bi'")->fetchColumn();
    $pdo->prepare('INSERT INTO alunos (nome, email, cpf, senha_hash, curso_id, senha_temporaria) VALUES (?, ?, NULL, ?, ?, 1)')
        ->execute(['Revisor Hotmart', $email, password_hash(bin2hex(random_bytes(24)), PASSWORD_DEFAULT), $cursoPbi]);
    $id = (int)$pdo->lastInsertId();
    echo "ALUNO|CRIADO|$id\n";
}
foreach ($pdo->query("SELECT id, slug FROM cursos WHERE slug IN ('power-bi','excel','python','ingles')") as $c) {
    matricular($pdo, $id, (int)$c['id']);
    echo "MATRICULA|{$c['slug']}\n";
}
$m = $pdo->prepare('SELECT c.slug FROM matriculas m JOIN cursos c ON c.id = m.curso_id WHERE m.aluno_id = ?');
$m->execute([$id]);
echo 'CONFERE|' . implode(',', $m->fetchAll(PDO::FETCH_COLUMN)) . "\n";
echo 'DIAG_REMOVIDO|' . (file_exists(__DIR__ . '/diag_aluna_teste.php') ? 'NAO' : 'SIM') . "\n";
