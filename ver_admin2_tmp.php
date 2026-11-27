<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/curso_modulos.php';
require_once __DIR__ . '/aluno_atividade.php';
require_once __DIR__ . '/trilhas/lib.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$pdo = db();
try { cursos_ordem_schema($pdo); foreach ($pdo->query('SELECT id, slug, exige_ordem_avaliacoes FROM cursos') as $r) echo "curso {$r['slug']}: ordem=" . $r['exige_ordem_avaliacoes'] . " exige=" . (curso_exige_ordem($pdo, (int)$r['id']) ? 's' : 'n') . "\n"; } catch (Throwable $e) { echo "ERRO ordem: " . $e->getMessage() . "\n"; }
try { echo "modulo_anterior xl-m02=" . var_export(modulo_anterior('xl-m02', 'excel'), true) . " pbi perfil-dados=" . var_export(modulo_anterior('perfil-dados'), true) . "\n"; } catch (Throwable $e) { echo "ERRO ant: " . $e->getMessage() . "\n"; }
try { ensure_aluno_atividade_tables($pdo); echo "atividade: " . $pdo->query('SELECT COUNT(*) FROM aluno_atividade')->fetchColumn() . " | progresso: " . $pdo->query('SELECT COUNT(*) FROM progresso')->fetchColumn() . "\n"; } catch (Throwable $e) { echo "ERRO ativ: " . $e->getMessage() . "\n"; }
try { $q = $pdo->prepare('SELECT COUNT(DISTINCT a.id) FROM avaliacoes a JOIN avaliacao_tentativas t ON t.avaliacao_id = a.id AND t.aluno_id = ? AND t.aprovado = 1 WHERE a.curso_id = ? AND a.ativo = 1'); $q->execute([1, 1]); echo "aprov ok: " . $q->fetchColumn() . "\n"; } catch (Throwable $e) { echo "ERRO aprov: " . $e->getMessage() . "\n"; }
try { $tp = trilhas_progresso($pdo, 1); $n = 0; foreach (trilhas_publicas() as $t) if (($t['curso'] ?? '') === 'excel') $n++; echo "trilhas excel: $n | progresso keys: " . count($tp) . "\n"; } catch (Throwable $e) { echo "ERRO trilhas: " . $e->getMessage() . "\n"; }
try { $c = $pdo->query('SELECT emitido_em FROM certificados LIMIT 1')->fetchColumn(); echo "cert ok\n"; } catch (Throwable $e) { echo "ERRO cert: " . $e->getMessage() . "\n"; }
