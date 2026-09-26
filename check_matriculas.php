<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/matriculas.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
matriculas_ensure_schema($pdo);
echo "alunos com curso: " . $pdo->query('SELECT COUNT(*) FROM alunos WHERE curso_id IS NOT NULL')->fetchColumn() . "\n";
echo "matriculas: " . $pdo->query('SELECT COUNT(*) FROM matriculas')->fetchColumn() . "\n";
echo "alunos SEM matricula do proprio curso: " . $pdo->query('SELECT COUNT(*) FROM alunos a LEFT JOIN matriculas m ON m.aluno_id=a.id AND m.curso_id=a.curso_id WHERE a.curso_id IS NOT NULL AND m.id IS NULL')->fetchColumn() . "\n";
foreach ($pdo->query('SELECT id, nome, slug, ativo FROM cursos ORDER BY id')->fetchAll() as $c) echo "curso #{$c['id']} {$c['slug']} ativo={$c['ativo']} | {$c['nome']}\n";
@unlink(__FILE__);
