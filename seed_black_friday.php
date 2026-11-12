<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: agenda a campanha Black Friday 2026 (13–30/11) — Reels IG/Threads (+ Facebook em dia útil),
// carrossel com música, Stories, Threads texto com link e a regra de resposta automática BLACK. Horários UTC. Idempotente.
header('Content-Type: text/plain; charset=utf-8');
set_time_limit(0);
ignore_user_abort(true);
@unlink(__FILE__);
$plan = json_decode(<<<'JSON'
{"reels": [{"file": "promo-bf-A.mp4", "day": "2026-11-13", "caption": "Black Friday na Tech Santos: os 4 cursos completos por R$ 119,90.\n\nExcel do zero às macros, Power BI com DAX e dashboards, Python para dados com pandas e Inglês do A1 ao C1. Tudo na mesma conta, com certificado em cada curso e acesso liberado na hora.\n\nSeparados, custariam R$ 336,70.\n\nComente BLACK que eu te mando o link no direct. Oferta válida para pedidos até 30/11 às 23h59.\n\n#BlackFriday #PowerBI #Excel #Python #Ingles #AnaliseDeDados", "th": "Black Friday na Tech Santos: os 4 cursos completos por R$ 119,90.\n\nOs 4 cursos por R$ 119,90 até 30/11: https://techsantos.com.br/black-friday.php?utm_source=threads&utm_medium=social&utm_campaign=black-friday-2026", "sem_fb": false}, {"file": "promo-bf-B.mp4", "day": "2026-11-17", "caption": "Um curso sozinho custa mais do que o combo inteiro.\n\nO curso de Power BI sai por R$ 129,90. Na Black Friday, Excel + Power BI + Python + Inglês saem por R$ 119,90: 235 aulas, avaliação em cada módulo e certificado em cada curso. 64% de desconto.\n\nComente BLACK que eu te mando o link no direct. Oferta válida para pedidos até 30/11 às 23h59.\n\n#BlackFriday #PowerBI #Excel #Python #Ingles #AnaliseDeDados", "th": "Um curso sozinho custa mais do que o combo inteiro.\n\nOs 4 cursos por R$ 119,90 até 30/11: https://techsantos.com.br/black-friday.php?utm_source=threads&utm_medium=social&utm_campaign=black-friday-2026", "sem_fb": false}, {"file": "promo-bf-C.mp4", "day": "2026-11-20", "caption": "Começando a trabalhar com dados? Essa é a ordem que eu seguiria.\n\n1. Excel, porque toda empresa usa.\n2. Power BI, pra transformar planilha em dashboard.\n3. Python, pra automatizar o que é repetitivo.\n4. Inglês, porque as melhores vagas e a documentação estão em inglês.\n\nNa Black Friday, os 4 cursos estão num combo só, por R$ 119,90.\n\nComente BLACK que eu te mando o link no direct. Oferta válida para pedidos até 30/11 às 23h59.\n\n#BlackFriday #PowerBI #Excel #Python #Ingles #AnaliseDeDados", "th": "Começando a trabalhar com dados? Essa é a ordem que eu seguiria.\n\nOs 4 cursos por R$ 119,90 até 30/11: https://techsantos.com.br/black-friday.php?utm_source=threads&utm_medium=social&utm_campaign=black-friday-2026", "sem_fb": false}, {"file": "promo-bf-E.mp4", "day": "2026-11-27", "caption": "Hoje é Black Friday, e o combo está no ar.\n\nExcel, Power BI, Python e Inglês, os 4 cursos completos por R$ 119,90. Separados, custariam R$ 336,70. Acesso na hora, na mesma conta, com certificado em cada curso. Vale até segunda, 30/11.\n\nComente BLACK que eu te mando o link no direct. Oferta válida para pedidos até 30/11 às 23h59.\n\n#BlackFriday #PowerBI #Excel #Python #Ingles #AnaliseDeDados", "th": "Hoje é Black Friday, e o combo está no ar.\n\nOs 4 cursos por R$ 119,90 até 30/11: https://techsantos.com.br/black-friday.php?utm_source=threads&utm_medium=social&utm_campaign=black-friday-2026", "sem_fb": false}, {"file": "promo-bf-D.mp4", "day": "2026-11-29", "caption": "Últimos dias da Black Friday.\n\nSegunda-feira, 30/11, às 23h59, o combo com os 4 cursos (Excel, Power BI, Python e Inglês) por R$ 119,90 sai do ar. Pix gerado até segunda ainda vale. Depois disso, cada curso volta ao preço normal.\n\nComente BLACK que eu te mando o link no direct. Oferta válida para pedidos até 30/11 às 23h59.\n\n#BlackFriday #PowerBI #Excel #Python #Ingles #AnaliseDeDados", "th": "Últimos dias da Black Friday.\n\nOs 4 cursos por R$ 119,90 até 30/11: https://techsantos.com.br/black-friday.php?utm_source=threads&utm_medium=social&utm_campaign=black-friday-2026", "sem_fb": true}], "carrossel": {"slug": "black-friday-4-cursos", "when": "2026-11-24 22:00:00", "urls": ["https://media.techsantos.com.br/carrossel/black-friday-4-cursos/01.mp4", "https://media.techsantos.com.br/carrossel/black-friday-4-cursos/02.mp4", "https://media.techsantos.com.br/carrossel/black-friday-4-cursos/03.mp4", "https://media.techsantos.com.br/carrossel/black-friday-4-cursos/04.mp4", "https://media.techsantos.com.br/carrossel/black-friday-4-cursos/05.mp4", "https://media.techsantos.com.br/carrossel/black-friday-4-cursos/06.mp4", "https://media.techsantos.com.br/carrossel/black-friday-4-cursos/07.mp4", "https://media.techsantos.com.br/carrossel/black-friday-4-cursos/08.mp4"], "jpgs": ["https://media.techsantos.com.br/carrossel/black-friday-4-cursos/01.jpg", "https://media.techsantos.com.br/carrossel/black-friday-4-cursos/02.jpg", "https://media.techsantos.com.br/carrossel/black-friday-4-cursos/03.jpg", "https://media.techsantos.com.br/carrossel/black-friday-4-cursos/04.jpg", "https://media.techsantos.com.br/carrossel/black-friday-4-cursos/05.jpg", "https://media.techsantos.com.br/carrossel/black-friday-4-cursos/06.jpg", "https://media.techsantos.com.br/carrossel/black-friday-4-cursos/07.jpg", "https://media.techsantos.com.br/carrossel/black-friday-4-cursos/08.jpg"], "caption": "O que vem no combo de Black Friday, curso por curso.\n\nExcel do zero às macros (preparatório MO-210 e MO-211), Power BI com modelagem, DAX e dashboards, Python para dados com pandas e automação de planilhas, e Inglês do A1 ao C1 com foco no trabalho. São 235 aulas, avaliação em cada módulo e certificado em cada curso, por R$ 119,90.\n\nComente BLACK que eu te mando o link no direct. Oferta válida para pedidos até 30/11 às 23h59.\n\n#BlackFriday #PowerBI #Excel #Python #Ingles #AnaliseDeDados"}, "stories": [{"file": "stories/2026-11/1113-bf.jpg", "when": "2026-11-13 22:15:00"}, {"file": "stories/2026-11/1115-bf.jpg", "when": "2026-11-15 22:00:00"}, {"file": "stories/2026-11/1117-bf.jpg", "when": "2026-11-17 22:15:00"}, {"file": "stories/2026-11/1119-bf.jpg", "when": "2026-11-19 22:00:00"}, {"file": "stories/2026-11/1121-bf.jpg", "when": "2026-11-21 22:00:00"}, {"file": "stories/2026-11/1123-bf.jpg", "when": "2026-11-23 22:00:00"}, {"file": "stories/2026-11/1125-bf.jpg", "when": "2026-11-25 22:00:00"}, {"file": "stories/2026-11/1127-bf.jpg", "when": "2026-11-27 22:15:00"}, {"file": "stories/2026-11/1128-bf.jpg", "when": "2026-11-28 22:00:00"}, {"file": "stories/2026-11/1129-bf.jpg", "when": "2026-11-29 22:15:00"}, {"file": "stories/2026-11/1130-bf.jpg", "when": "2026-11-30 12:00:00"}], "threads": [{"when": "2026-11-13 23:00:00", "text": "Black Friday na Tech Santos: Excel, Power BI, Python e Inglês, os 4 cursos completos por R$ 119,90 (separados: R$ 336,70).\n\nAcesso na hora, na mesma conta, certificado em cada curso. Até 30/11:\nhttps://techsantos.com.br/black-friday.php?utm_source=threads&utm_medium=social&utm_campaign=black-friday-2026"}, {"when": "2026-11-17 23:00:00", "text": "Conta rápida: o curso de Power BI sozinho custa R$ 129,90. O combo de Black Friday com Excel + Power BI + Python + Inglês sai por R$ 119,90.\n\nhttps://techsantos.com.br/black-friday.php?utm_source=threads&utm_medium=social&utm_campaign=black-friday-2026"}, {"when": "2026-11-20 23:00:00", "text": "Ordem que eu seguiria pra começar em dados:\n\n1. Excel\n2. Power BI\n3. Python\n4. Inglês\n\nNa Black Friday estão os 4 num combo só, por R$ 119,90:\nhttps://techsantos.com.br/black-friday.php?utm_source=threads&utm_medium=social&utm_campaign=black-friday-2026"}, {"when": "2026-11-24 23:00:00", "text": "235 aulas, avaliação em cada módulo e certificado em cada curso. Excel, Power BI, Python e Inglês por R$ 119,90 até 30/11.\n\nhttps://techsantos.com.br/black-friday.php?utm_source=threads&utm_medium=social&utm_campaign=black-friday-2026"}, {"when": "2026-11-27 23:00:00", "text": "Hoje é Black Friday. Os 4 cursos da Tech Santos (Excel, Power BI, Python e Inglês) por R$ 119,90, até segunda, 30/11:\nhttps://techsantos.com.br/black-friday.php?utm_source=threads&utm_medium=social&utm_campaign=black-friday-2026"}, {"when": "2026-11-30 13:00:00", "text": "Último dia: o combo com Excel, Power BI, Python e Inglês por R$ 119,90 sai do ar hoje às 23h59. Pix gerado hoje ainda vale.\n\nhttps://techsantos.com.br/black-friday.php?utm_source=threads&utm_medium=social&utm_campaign=black-friday-2026"}], "auto_reply": "Oi! Aqui está o link da Black Friday da Tech Santos: os 4 cursos (Excel, Power BI, Python e Inglês) por R$ 119,90, com acesso na hora e certificado em cada curso. Vale para pedidos até 30/11 às 23h59: https://techsantos.com.br/black-friday.php?utm_source=instagram&utm_medium=dm&utm_campaign=black-friday-2026"}
JSON, true);
$pdo = db();
$out = [];
$ok = function (string $url): bool { $h = @get_headers($url, true); return is_array($h) && str_contains((string)($h[0] ?? ''), '200'); };
$exists = $pdo->prepare("SELECT id FROM social_posts WHERE canal=? AND imagem_url=? LIMIT 1");
$ins = $pdo->prepare("INSERT INTO social_posts (canal,tipo,midia_tipo,legenda,imagem_url,link_url,carousel_urls,agendado_para,status,meta_post_id) VALUES (?,?,?,?,?,NULL,?,?,?,?)");

// Regra de resposta automática BLACK (comentário vira DM com o link).
$r = $pdo->prepare('SELECT id FROM social_auto_reply_rules WHERE palavra_chave = ?');
$r->execute(['BLACK']);
if ($r->fetchColumn()) { $out[] = 'REGRA|IGNORADA|BLACK'; }
else { $pdo->prepare('INSERT INTO social_auto_reply_rules (palavra_chave, mensagem, ativo, prioridade) VALUES (?, ?, 1, 5)')->execute(['BLACK', $plan['auto_reply']]); $out[] = 'REGRA|OK|BLACK'; }

foreach ($plan['reels'] as $p) {
    $url = 'https://media.techsantos.com.br/reels/' . $p['file'];
    if (!$ok($url)) { $out[] = "MIDIA|ERRO|{$p['file']}"; continue; }
    $when = $p['day'] . ' 22:00:00';
    $exists->execute(['instagram', $url]);
    if (!$exists->fetchColumn()) { $ins->execute(['instagram', 'reels', 'video', $p['caption'], $url, null, $when, 'pendente', null]); $out[] = "IG|OK|{$p['file']}"; } else $out[] = "IG|IGNORADO|{$p['file']}";
    $exists->execute(['threads', $url]);
    if (!$exists->fetchColumn()) { $ins->execute(['threads', 'reels', 'video', $p['th'], $url, null, $p['day'] . ' 22:30:00', 'pendente', null]); $out[] = "THREADS|OK|{$p['file']}"; } else $out[] = "THREADS|IGNORADO|{$p['file']}";
    if (!empty($p['sem_fb'])) { $out[] = "FB|FIM_DE_SEMANA|{$p['file']}"; continue; }
    $exists->execute(['facebook', $url]);
    if ($exists->fetchColumn()) { $out[] = "FB|IGNORADO|{$p['file']}"; continue; }
    $error = null;
    $vid = meta_schedule_facebook_reel($p['caption'], $url, strtotime($when . ' UTC'), $error);
    if ($vid === null) { $out[] = "FB|ERRO|{$p['file']}|{$error}"; continue; }
    $ins->execute(['facebook', 'reels', 'video', $p['caption'], $url, null, $when, 'agendado_meta', $vid]);
    $out[] = "FB|OK|{$p['file']}|{$vid}";
}
foreach ($plan['stories'] as $s) {
    $url = 'https://media.techsantos.com.br/' . $s['file'];
    if (!$ok($url)) { $out[] = "STORY|MIDIA_ERRO|{$s['file']}"; continue; }
    $exists->execute(['instagram', $url]);
    if ($exists->fetchColumn()) { $out[] = "STORY|IGNORADO|{$s['file']}"; continue; }
    $ins->execute(['instagram', 'story', 'imagem', '', $url, null, $s['when'], 'pendente', null]); $out[] = "STORY|OK|{$s['when']}|" . basename($s['file']);
}
$thE = $pdo->prepare("SELECT id FROM social_posts WHERE canal='threads' AND agendado_para=? AND legenda=? LIMIT 1");
foreach ($plan['threads'] as $t) {
    $thE->execute([$t['when'], $t['text']]);
    if ($thE->fetchColumn()) { $out[] = "THREADS_TXT|IGNORADO|{$t['when']}"; continue; }
    $ins->execute(['threads', 'feed', 'imagem', $t['text'], '', null, $t['when'], 'pendente', null]); $out[] = "THREADS_TXT|OK|{$t['when']}";
}
$c = $plan['carrossel'];
$cE = $pdo->prepare("SELECT id FROM social_posts WHERE canal=? AND tipo='carousel' AND carousel_urls=? LIMIT 1");
$bad = array_filter(array_merge($c['urls'], $c['jpgs']), fn($u) => !$ok($u));
if ($bad) { $out[] = "CARROSSEL|MIDIA_ERRO|" . count($bad); }
else foreach ([['instagram', $c['when'], $c['urls']], ['threads', gmdate('Y-m-d H:i:s', strtotime($c['when'] . ' UTC') + 1800), $c['jpgs']]] as [$canal, $when, $urls]) {
    $json = json_encode($urls);
    $cE->execute([$canal, $json]);
    if ($cE->fetchColumn()) { $out[] = strtoupper($canal) . "_CARROSSEL|IGNORADO"; continue; }
    $leg = $canal === 'threads' ? mb_substr(explode("\n\n#", $c['caption'])[0], 0, 480) : $c['caption'];
    $ins->execute([$canal, 'carousel', $canal === 'threads' ? 'imagem' : 'video', $leg, $urls[0], $json, $when, 'pendente', null]);
    $out[] = strtoupper($canal) . "_CARROSSEL|OK|{$when}";
}
echo implode("\n", $out) . "\n";
