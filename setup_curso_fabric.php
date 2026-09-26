<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/matriculas.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
matriculas_ensure_schema($pdo);
// Curso inativo e sem preço: não aparece em página pública nem no checkout.
$pdo->prepare("INSERT IGNORE INTO cursos (nome, slug, carga_horaria, modalidade, descricao, ativo) VALUES (?, 'microsoft-fabric', NULL, 'EAD', ?, 0)")
    ->execute(['Microsoft Fabric — Preparatório DP-600 e DP-700', 'Curso completo de Microsoft Fabric alinhado às certificações DP-600 e DP-700.']);
$cursoId = (int)$pdo->query("SELECT id FROM cursos WHERE slug = 'microsoft-fabric'")->fetchColumn();
echo "curso microsoft-fabric id={$cursoId}\n";
// Só a conta de aluno do dono do site, para pré-visualizar.
$stmt = $pdo->prepare("SELECT id FROM alunos WHERE email IN ('claristonsantos@techsantos.com.br','claristonsantos@hotmail.com','claristonbsantos@gmail.com') ORDER BY id LIMIT 1");
$stmt->execute();
$alunoId = (int)$stmt->fetchColumn();
if ($alunoId) { matricular($pdo, $alunoId, $cursoId); echo "matriculado aluno id={$alunoId}\n"; }
else { echo "conta de aluno do dono NAO encontrada\n"; }
echo "matriculas no fabric: " . $pdo->query("SELECT COUNT(*) FROM matriculas WHERE curso_id={$cursoId}")->fetchColumn() . "\n";
@unlink(__FILE__);
