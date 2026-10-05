<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
echo "NOW UTC " . $pdo->query("SELECT NOW()")->fetchColumn() . "\n=== fila desde 01/10 (status por canal/tipo) ===\n";
foreach ($pdo->query("SELECT canal, tipo, status, COUNT(*) c FROM social_posts WHERE agendado_para >= '2026-10-01' AND agendado_para <= NOW() GROUP BY canal, tipo, status ORDER BY canal, tipo, status") as $r) echo "  {$r['canal']} {$r['tipo']} {$r['status']}: {$r['c']}\n";
echo "=== erros ===\n";
foreach ($pdo->query("SELECT id, canal, tipo, agendado_para, LEFT(erro_msg,160) e, imagem_url FROM social_posts WHERE agendado_para >= '2026-10-01' AND status='erro' ORDER BY agendado_para") as $r) echo "  #{$r['id']} {$r['canal']} {$r['tipo']} {$r['agendado_para']} " . basename((string)$r['imagem_url']) . " | {$r['e']}\n";
echo "=== presos (pendente/processando já vencidos > 30 min) ===\n";
foreach ($pdo->query("SELECT id, canal, tipo, status, agendado_para FROM social_posts WHERE status IN ('pendente','processando') AND agendado_para < NOW() - INTERVAL 30 MINUTE ORDER BY agendado_para") as $r) echo "  #{$r['id']} {$r['canal']} {$r['tipo']} {$r['status']} {$r['agendado_para']}\n";
echo "=== threads publicados (id) ===\n";
foreach ($pdo->query("SELECT id, tipo, agendado_para, meta_post_id, LEFT(legenda,50) l FROM social_posts WHERE canal='threads' AND status='publicado' ORDER BY agendado_para") as $r) echo "  {$r['agendado_para']} {$r['tipo']} {$r['meta_post_id']} | {$r['l']}\n";
echo "=== leads whatsapp ===\n";
foreach ($pdo->query("SELECT id, origem, criado_em FROM whatsapp_leads ORDER BY id DESC LIMIT 10") as $r) echo "  #{$r['id']} {$r['criado_em']} {$r['origem']}\n";
echo "=== respostas automáticas desde 01/10 ===\n";
foreach ($pdo->query("SELECT l.criado_em, l.plataforma, l.autor, r.palavra_chave, l.status FROM social_auto_reply_log l LEFT JOIN social_auto_reply_rules r ON r.id=l.regra_id WHERE l.criado_em >= '2026-10-01' ORDER BY l.criado_em") as $r) echo "  {$r['criado_em']} {$r['plataforma']} @{$r['autor']} {$r['palavra_chave']} {$r['status']}\n";
echo "=== pedidos desde 01/10 ===\n";
foreach ($pdo->query("SELECT p.id, p.status, p.valor_centavos, p.criado_em, c.slug FROM pedidos p LEFT JOIN cursos c ON c.id=p.curso_id WHERE p.criado_em >= '2026-10-01' ORDER BY p.criado_em") as $r) echo "  #{$r['id']} {$r['criado_em']} {$r['status']} {$r['slug']} R$" . number_format($r['valor_centavos']/100,2,',','.') . "\n";
echo "=== aulas particulares agendadas desde 01/10 ===\n";
try { foreach ($pdo->query("SELECT id, status, criado_em FROM aulas_particulares WHERE criado_em >= '2026-10-01'") as $r) echo "  #{$r['id']} {$r['criado_em']} {$r['status']}\n"; } catch (Throwable $e) { echo "  (tabela n/d)\n"; }
echo "=== alunos novos desde 01/10 ===\n";
try { echo "  " . $pdo->query("SELECT COUNT(*) FROM matriculas WHERE criado_em >= '2026-10-01'")->fetchColumn() . " matrículas\n"; } catch (Throwable $e) { echo "  (n/d)\n"; }
@unlink(__FILE__);
