<?php
declare(strict_types=1);
require_once __DIR__ . '/lib.php';
header('Content-Type: text/plain; charset=utf-8');
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
@unlink(__FILE__);
$pdo = db(); precos_ensure_schema($pdo);
print_r($pdo->query('SELECT (SELECT COUNT(*) FROM precos_usuarios) u,(SELECT COUNT(*) FROM precos_notas) n,(SELECT COUNT(*) FROM precos_itens) i,(SELECT COUNT(*) FROM precos_lojas) l,(SELECT COUNT(*) FROM precos_falhas) f')->fetch());
foreach ($pdo->query('SELECT n.uf, n.itens, n.total_centavos, n.emitida_em, l.nome, l.endereco FROM precos_notas n JOIN precos_lojas l ON l.id=n.loja_id ORDER BY n.id DESC LIMIT 5') as $r) echo implode(' | ', $r), "\n";
foreach ($pdo->query('SELECT descricao, codigo, quantidade, unidade, preco_unit_centavos, chave_produto FROM precos_itens ORDER BY id DESC LIMIT 8') as $r) echo implode(' | ', $r), "\n";
foreach ($pdo->query('SELECT id, host, motivo, LENGTH(html) tam, criado_em FROM precos_falhas ORDER BY id DESC LIMIT 5') as $r) echo 'FALHA ', implode(' | ', $r), "\n";
