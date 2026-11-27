<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/curso_modulos.php';
require_once __DIR__ . '/matriculas.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único, somente leitura: testa as consultas novas do admin (sem dados pessoais na saída).
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$pdo = db(); matriculas_ensure_schema($pdo);
foreach (['power-bi','excel','python','ingles','microsoft-fabric'] as $s) echo "modulos $s: " . count(modulos_do_curso($s)) . "\n";
$c2 = "(SELECT GROUP_CONCAT(DISTINCT c2.nome ORDER BY c2.nome SEPARATOR ', ') FROM cursos c2 WHERE c2.id = a.curso_id OR c2.id IN (SELECT m.curso_id FROM matriculas m WHERE m.aluno_id = a.id))";
try { $r = $pdo->query("SELECT COUNT(*) n, SUM($c2 LIKE '%,%') multi FROM alunos a")->fetch(); echo "alunos: {$r['n']} total, {$r['multi']} com mais de um curso\n"; } catch (Throwable $e) { echo "ERRO alunos: " . $e->getMessage() . "\n"; }
try { foreach ($pdo->query("SELECT c.slug, (SELECT COUNT(DISTINCT a.id) FROM alunos a WHERE a.curso_id = c.id OR EXISTS (SELECT 1 FROM matriculas m WHERE m.aluno_id = a.id AND m.curso_id = c.id)) t, (SELECT COUNT(*) FROM alunos a WHERE a.curso_id=c.id) antigo FROM cursos c") as $r) echo "curso {$r['slug']}: {$r['t']} alunos (antes {$r['antigo']})\n"; } catch (Throwable $e) { echo "ERRO cursos: " . $e->getMessage() . "\n"; }
try { $n = $pdo->query("SELECT COUNT(*) FROM (SELECT a.id, c.id cid FROM matriculas m JOIN alunos a ON a.id = m.aluno_id JOIN cursos c ON c.id = m.curso_id UNION SELECT a.id, c.id FROM alunos a JOIN cursos c ON c.id = a.curso_id) x")->fetchColumn(); echo "jornada: $n matriculas\n"; } catch (Throwable $e) { echo "ERRO jornada: " . $e->getMessage() . "\n"; }
foreach ($pdo->query("SELECT c.slug, a.modulo_id FROM avaliacoes a JOIN cursos c ON c.id=a.curso_id WHERE a.ativo=1") as $r) {
    if (!isset(modulos_do_curso((string)$r['slug'])[$r['modulo_id']])) echo "AVALIACAO SEM MODULO: {$r['slug']} / {$r['modulo_id']}\n";
}
echo "avaliacoes por curso: "; foreach ($pdo->query("SELECT c.slug, COUNT(*) n FROM avaliacoes a JOIN cursos c ON c.id=a.curso_id WHERE a.ativo=1 GROUP BY c.slug") as $r) echo "{$r['slug']}={$r['n']} "; echo "\n";
