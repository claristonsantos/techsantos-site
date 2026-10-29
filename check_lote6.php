<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único, só leitura: confere o que a seed da lote 6 gravou (posts 30/10–09/11 e regras INGLES/PYTHON).
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$pdo = db();
foreach ($pdo->query("SELECT canal, tipo, status, COUNT(*) n, MIN(agendado_para) de, MAX(agendado_para) ate FROM social_posts
                      WHERE agendado_para >= '2026-10-30 20:00:00' AND agendado_para < '2026-11-10' AND status IN ('pendente','agendado_meta')
                      GROUP BY canal, tipo, status ORDER BY canal, tipo") as $r) echo implode(' | ', $r) . "\n";
echo "== reels lote 6\n";
foreach ($pdo->query("SELECT canal, status, agendado_para, SUBSTRING_INDEX(imagem_url, '/', -1) f FROM social_posts WHERE imagem_url LIKE '%/reels/aula-trecho-%' AND agendado_para >= '2026-11-01' OR imagem_url LIKE '%/reels/novidade-pbi-%' ORDER BY agendado_para, canal") as $r) echo implode(' | ', $r) . "\n";
echo "== regras\n";
foreach ($pdo->query("SELECT id, palavra_chave, ativo FROM social_auto_reply_rules WHERE UPPER(palavra_chave) IN ('INGLES','PYTHON')") as $r) echo implode(' | ', $r) . "\n";
