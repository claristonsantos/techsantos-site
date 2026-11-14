<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único, somente leitura: investigar pedidos recentes suspeitos.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$pdo = db();
$mask = function ($k, $v) { if ($v === null) return 'NULL'; if ($k === 'cpf' && strlen((string)$v) >= 6) return substr($v, 0, 3) . '*****' . substr($v, -2); return mb_substr((string)$v, 0, 80); };
echo "== ultimos 12 pedidos (todas as colunas)\n";
foreach ($pdo->query("SELECT p.*, c.slug FROM pedidos p JOIN cursos c ON c.id=p.curso_id ORDER BY p.id DESC LIMIT 12") as $r) {
    echo "-- \n"; foreach ($r as $k => $v) if (!is_int($k)) echo "  $k=" . $mask($k, $v) . "\n";
}
echo "== alunos criados desde 10/11\n";
foreach ($pdo->query("SELECT id, nome, email, criado_em FROM alunos WHERE criado_em >= '2026-11-10' ORDER BY id DESC") as $r) echo '  ' . implode(' | ', array_filter($r, 'is_string', ARRAY_FILTER_USE_KEY)) . "\n";
echo "== bf_lembretes recentes\n";
try { foreach ($pdo->query("SELECT * FROM bf_lembretes ORDER BY id DESC LIMIT 5") as $r) echo '  ' . implode(' | ', array_map(fn($k, $v) => "$k=$v", array_keys(array_filter($r, 'is_string', ARRAY_FILTER_USE_KEY)), array_filter($r, 'is_string', ARRAY_FILTER_USE_KEY))) . "\n"; } catch (Throwable $e) { echo '  ERRO ' . $e->getMessage() . "\n"; }
