<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$mask = fn(string $t): string => substr($t, 0, 4) . str_repeat('*', max(0, strlen($t) - 6)) . substr($t, -2);
echo "NOW UTC " . $pdo->query("SELECT NOW()")->fetchColumn() . "\n=== whatsapp_leads ===\n";
$r = $pdo->query("SELECT COUNT(*) c, MAX(criado_em) u FROM whatsapp_leads")->fetch();
echo "total {$r['c']} | último {$r['u']}\n";
foreach ($pdo->query("SELECT id, telefone, origem, criado_em FROM whatsapp_leads ORDER BY id DESC LIMIT 20") as $l) echo "  #{$l['id']} {$l['criado_em']} UTC | {$l['origem']} | " . $mask((string)$l['telefone']) . "\n";
echo "\n=== respostas automáticas a comentários (30 dias) ===\n";
foreach ($pdo->query("SELECT l.criado_em, l.plataforma, l.status, r.palavra_chave, LEFT(l.texto_comentario,60) t FROM social_auto_reply_log l LEFT JOIN social_auto_reply_rules r ON r.id=l.regra_id WHERE l.criado_em >= NOW() - INTERVAL 30 DAY ORDER BY l.criado_em DESC") as $l) echo "  {$l['criado_em']} | {$l['plataforma']} | {$l['palavra_chave']} | {$l['status']} | {$l['t']}\n";
echo "\n=== pedidos (14 dias) ===\n";
foreach ($pdo->query("SELECT p.id, p.status, p.valor_centavos, p.criado_em, c.slug FROM pedidos p LEFT JOIN cursos c ON c.id=p.curso_id WHERE p.criado_em >= NOW() - INTERVAL 14 DAY ORDER BY p.criado_em DESC") as $p) echo "  #{$p['id']} {$p['criado_em']} | {$p['status']} | {$p['slug']} | R$" . number_format($p['valor_centavos']/100,2,',','.') . "\n";
@unlink(__FILE__);
