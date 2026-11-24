<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único, somente leitura: últimos pedidos do Hotmart e se o acesso (aluno + matrícula) foi criado.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$pdo = db();
$q = function (string $t, string $sql) use ($pdo) { echo "== $t\n"; try { foreach ($pdo->query($sql) as $r) echo "  " . implode(' | ', array_map(fn($k, $v) => "$k=$v", array_keys($r), $r)) . "\n"; } catch (Throwable $e) { echo "  ERRO " . $e->getMessage() . "\n"; } };
$q('pedidos hotmart', "SELECT p.id, p.criado_em, p.atualizado_em, p.nome, p.email, c.nome curso, p.valor_centavos, p.status, p.hotmart_transaction FROM pedidos p LEFT JOIN cursos c ON c.id=p.curso_id WHERE p.hotmart_transaction IS NOT NULL ORDER BY p.id DESC LIMIT 5");
$q('acesso do comprador', "SELECT a.id aluno_id, a.email, a.ativo, a.criado_em, a.senha_temporaria, a.ultimo_acesso, (SELECT GROUP_CONCAT(c.nome) FROM matriculas m JOIN cursos c ON c.id=m.curso_id WHERE m.aluno_id=a.id) matriculas FROM alunos a WHERE a.email IN (SELECT email FROM (SELECT email FROM pedidos WHERE hotmart_transaction IS NOT NULL ORDER BY id DESC LIMIT 3) x)");
