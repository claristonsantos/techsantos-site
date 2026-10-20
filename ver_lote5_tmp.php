<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único, somente leitura: confere o que a lote 5 agendou.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$pdo = db();
foreach ($pdo->query("SELECT canal, tipo, status, COUNT(*) n FROM social_posts WHERE agendado_para >= '2026-10-22' AND agendado_para < '2026-11-01' GROUP BY canal, tipo, status ORDER BY canal, tipo") as $r) echo implode(' | ', $r), "\n";
foreach ($pdo->query("SELECT id, canal, tipo, agendado_para, SUBSTRING_INDEX(imagem_url,'/',-1) arq, LEFT(COALESCE(erro_msg,''),80) e FROM social_posts WHERE agendado_para >= '2026-10-22' AND agendado_para < '2026-11-01' AND tipo IN ('reels','carousel') ORDER BY agendado_para") as $r) echo implode(' | ', $r), "\n";
foreach ($pdo->query("SELECT id, palavra_chave, ativo FROM social_auto_reply_rules WHERE UPPER(palavra_chave)='FABRIC'") as $r) echo 'REGRA ', implode(' | ', $r), "\n";
