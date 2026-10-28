<?php
declare(strict_types=1);
// Cria o curso de Python (do zero a Python para dados) inativo e sem preço, e
// matricula só a conta de aluno do dono do site para pré-visualizar. Protegido por
// SETUP_KEY e se apaga depois de rodar.
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/matriculas.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
matriculas_ensure_schema($pdo);
$pdo->prepare("INSERT IGNORE INTO cursos (nome, slug, carga_horaria, modalidade, descricao, preco_centavos, ativo) VALUES (?, 'python', NULL, 'EAD', ?, 0, 0)")
    ->execute(['Python para Dados — do Zero ao pandas', 'Curso de Python do zero até análise de dados com pandas, gráficos e automação de planilhas, com laboratório interativo no navegador.']);
$cursoId = (int)$pdo->query("SELECT id FROM cursos WHERE slug = 'python'")->fetchColumn();
echo "curso python id={$cursoId}\n";
$stmt = $pdo->prepare("SELECT id FROM alunos WHERE email IN ('claristonsantos@techsantos.com.br','claristonsantos@hotmail.com','claristonbsantos@gmail.com') ORDER BY id LIMIT 1");
$stmt->execute();
$alunoId = (int)$stmt->fetchColumn();
if ($alunoId) { matricular($pdo, $alunoId, $cursoId); echo "matriculado aluno id={$alunoId}\n"; }
else { echo "conta de aluno do dono NAO encontrada\n"; }
@unlink(__FILE__);
