<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Diagnóstico de uso único (somente leitura): fila de posts 16-31/10 e regras de resposta automática.
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
foreach ($pdo->query("SELECT id, canal, tipo, agendado_para, status, LEFT(REPLACE(legenda,'\n',' '),50) l FROM social_posts WHERE agendado_para >= '2026-10-16' AND agendado_para < '2026-11-01' ORDER BY agendado_para") as $r) echo implode(' | ', $r), "\n";
echo "-- falhas recentes\n";
foreach ($pdo->query("SELECT id, canal, agendado_para, LEFT(erro_msg,80) e FROM social_posts WHERE status='erro' AND agendado_para >= '2026-10-10'") as $r) echo implode(' | ', $r), "\n";
echo "-- regras\n";
foreach ($pdo->query("SELECT id, palavra_chave, ativo, prioridade FROM social_auto_reply_rules ORDER BY prioridade") as $r) echo implode(' | ', $r), "\n";
@unlink(__FILE__);
