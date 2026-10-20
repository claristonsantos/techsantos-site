<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Diagnóstico de uso único (somente leitura, agregado, sem dados pessoais): pedidos, alunos, leads e aulas.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$pdo = db();
$q = function (string $titulo, string $sql) use ($pdo) { echo "== $titulo\n"; foreach ($pdo->query($sql) as $r) echo "  " . implode(' | ', array_map(fn($k, $v) => "$k=$v", array_keys($r), $r)) . "\n"; };
$q('pedidos 90d por curso e status', "SELECT c.slug, p.status, COUNT(*) n, ROUND(SUM(p.valor_centavos)/100,2) valor FROM pedidos p JOIN cursos c ON c.id=p.curso_id WHERE p.criado_em >= NOW() - INTERVAL 90 DAY GROUP BY c.slug, p.status ORDER BY c.slug, p.status");
$q('pedidos por mes', "SELECT DATE_FORMAT(criado_em,'%Y-%m') mes, status, COUNT(*) n FROM pedidos GROUP BY mes, status ORDER BY mes DESC LIMIT 12");
$q('pedidos pendentes 30d (emails distintos, sem teste)', "SELECT COUNT(DISTINCT email) emails, COUNT(*) pedidos FROM pedidos WHERE status='pendente' AND criado_em >= NOW() - INTERVAL 30 DAY AND email NOT LIKE '%techsantos%' AND email NOT LIKE '%claris%'");
$q('pagos (reais, excluindo valores de teste)', "SELECT c.slug, COUNT(*) n, ROUND(SUM(p.valor_centavos)/100,2) receita FROM pedidos p JOIN cursos c ON c.id=p.curso_id WHERE p.status='pago' AND p.valor_centavos >= 5000 AND p.email NOT LIKE '%claris%' GROUP BY c.slug");
$q('matriculas por curso', "SELECT c.slug, COUNT(*) n FROM matriculas m JOIN cursos c ON c.id=m.curso_id GROUP BY c.slug");
$q('alunos ativos (login 30d)', "SELECT COUNT(*) total, SUM(ultimo_acesso >= NOW() - INTERVAL 30 DAY) ativos30 FROM alunos");
$q('whatsapp leads por mes', "SELECT DATE_FORMAT(criado_em,'%Y-%m') mes, COUNT(*) n FROM whatsapp_leads GROUP BY mes ORDER BY mes DESC");
$q('aulas particulares', "SELECT status, COUNT(*) n, ROUND(SUM(valor_centavos)/100,2) valor FROM aulas_particulares_leads GROUP BY status");
$q('precos', "SELECT slug, preco_centavos/100 preco FROM cursos");
