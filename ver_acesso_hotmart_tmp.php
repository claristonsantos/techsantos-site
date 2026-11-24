<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único, somente leitura: aluno + matrículas do comprador do pedido Hotmart 3111.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$pdo = db();
$st = $pdo->prepare("SELECT * FROM alunos WHERE email = (SELECT email FROM pedidos WHERE id = 3111)");
$st->execute();
foreach ($st as $r) { unset($r['senha_hash']); foreach ($r as $k => $v) echo "$k=$v\n"; 
  $m = $pdo->prepare("SELECT c.nome FROM matriculas m JOIN cursos c ON c.id=m.curso_id WHERE m.aluno_id=?"); $m->execute([$r['id']]);
  echo "matriculas=" . implode(', ', $m->fetchAll(PDO::FETCH_COLUMN)) . "\n"; }
echo "fim\n";
