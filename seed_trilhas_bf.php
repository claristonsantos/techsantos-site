<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: agenda o Reel "Trilhas grátis (Black Friday)" no Instagram em 27/11 13:00 BRT (16:00 UTC). Idempotente.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$p = json_decode(<<<'JSON'
{"url": "https://media.techsantos.com.br/reels/trilhas-gratis-bf-20261127.mp4", "when": "2026-11-27 16:00:00", "caption": "Ficou em dúvida na Black Friday? Teste antes, de graça. 👇\n\nA Tech Santos liberou as TRILHAS dos cursos: desafios curtos, estilo app, de Power BI, DAX, Linguagem M, Excel, VBA, Python e Inglês.\n\n✅ Faça o nivelamento e pule o que você já sabe\n✅ Monte fórmulas peça por peça\n✅ Errou? Aparece o porquê e a aula do curso que explica\n✅ Metade de cada trilha é grátis\n\nAcesse: techsantos.com.br/trilhas (link na bio)\n\nGostou? O combo da Black Friday com os 4 cursos (Power BI, Excel, Python e Inglês) vai só até segunda, 30/11.\n\nCurta ❤️ e siga @tech_santos_br pra mais dicas de dados!\n\n#powerbi #excel #python #dax #analisededados #blackfriday #techsantosbr"}
JSON, true);
$pdo = db();
$h = @get_headers($p['url'], true);
if (!is_array($h) || !str_contains((string)($h[0] ?? ''), '200')) exit("MIDIA|ERRO\n");
$st = $pdo->prepare("SELECT id FROM social_posts WHERE canal='instagram' AND imagem_url=? LIMIT 1");
$st->execute([$p['url']]);
if ($id = $st->fetchColumn()) exit("IG|IGNORADO|$id\n");
$pdo->prepare("INSERT INTO social_posts (canal,tipo,midia_tipo,legenda,imagem_url,link_url,carousel_urls,agendado_para,status,meta_post_id) VALUES ('instagram','reels','video',?,?,NULL,NULL,?,'pendente',NULL)")
    ->execute([$p['caption'], $p['url'], $p['when']]);
echo "IG|OK|" . $pdo->lastInsertId() . "|" . $p['when'] . "\n";
foreach ($pdo->query("SELECT id, canal, tipo, agendado_para, status FROM social_posts WHERE agendado_para BETWEEN '2026-11-27 12:00:00' AND '2026-11-27 20:00:00' ORDER BY agendado_para") as $r) echo implode('|', $r) . "\n";
