<?php
declare(strict_types=1);
// Cria o curso de Inglês (A1 → C1) inativo e sem preço, e matricula só a conta
// de aluno do dono do site para pré-visualizar. Protegido por SETUP_KEY e se
// apaga depois de rodar.
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/matriculas.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
matriculas_ensure_schema($pdo);
$pdo->prepare("INSERT IGNORE INTO cursos (nome, slug, carga_horaria, modalidade, descricao, preco_centavos, ativo) VALUES (?, 'ingles', NULL, 'EAD', ?, 0, 0)")
    ->execute(['Inglês do Básico ao Avançado', 'Curso de inglês do nível A1 ao C1, com teoria em português, áudio nativo e prática interativa em todas as aulas.']);
$cursoId = (int)$pdo->query("SELECT id FROM cursos WHERE slug = 'ingles'")->fetchColumn();
echo "curso ingles id={$cursoId}\n";
$stmt = $pdo->prepare("SELECT id FROM alunos WHERE email IN ('claristonsantos@techsantos.com.br','claristonsantos@hotmail.com','claristonbsantos@gmail.com') ORDER BY id LIMIT 1");
$stmt->execute();
$alunoId = (int)$stmt->fetchColumn();
if ($alunoId) { matricular($pdo, $alunoId, $cursoId); echo "matriculado aluno id={$alunoId}\n"; }
else { echo "conta de aluno do dono NAO encontrada\n"; }
foreach ($pdo->query('SELECT id, slug, preco_centavos, ativo FROM cursos ORDER BY id') as $c) {
    echo "{$c['id']} | {$c['slug']} | preco={$c['preco_centavos']} | ativo={$c['ativo']}\n";
}
@unlink(__FILE__);
