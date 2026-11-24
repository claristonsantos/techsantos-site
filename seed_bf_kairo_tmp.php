<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: agenda os 2 anúncios da Black Friday (voz clonada) no Instagram (Reels), Threads e Facebook. Horários UTC (19h BRT). Idempotente.
header('Content-Type: text/plain; charset=utf-8');
set_time_limit(0);
ignore_user_abort(true);
@unlink(__FILE__);
$plan = json_decode(<<<'JSON'
{"reels": [
 {"file": "bf-kairo-oferta.mp4", "when": "2026-11-25 22:00:00",
  "caption": "Black Friday da Tech Santos 🖤💚\n\n4 cursos completos: Power BI, Excel, Python e Inglês. De R$ 336,70 por R$ 119,90.\n\n✅ Acesso vitalício\n✅ Garantia incondicional de 7 dias\n✅ Parcelado em até 12x\n\nSó até segunda, 30/11.\n\nComente BLACK que eu te mando o link no direct, ou acesse techsantos.com.br/black-friday.php\n\n#BlackFriday #PowerBI #Excel #Python #Ingles #CursosOnline",
  "th": "Black Friday da Tech Santos: 4 cursos completos (Power BI, Excel, Python e Inglês) de R$ 336,70 por R$ 119,90. Acesso vitalício e garantia de 7 dias. Só até segunda, 30/11.\n\nhttps://techsantos.com.br/black-friday.php?utm_source=threads&utm_medium=social&utm_campaign=bf2026"},
 {"file": "bf-kairo-duvidas.mp4", "when": "2026-11-26 22:00:00",
  "caption": "Vale a pena? Respondi as 3 dúvidas que mais recebo sobre a Black Friday:\n\n1️⃣ É vitalício? Sim. Você paga uma vez e estuda pra sempre.\n2️⃣ E se eu não gostar? 7 dias de garantia incondicional, 100% do valor de volta.\n3️⃣ Serve pra iniciante? Serve. Os cursos começam do zero.\n\n4 cursos (Power BI, Excel, Python e Inglês) por R$ 119,90, só até segunda, 30/11.\n\nComente BLACK que eu te mando o link no direct.\n\n#BlackFriday #PowerBI #Excel #Python #Ingles",
  "th": "Vale a pena a Black Friday? 3 dúvidas: é vitalício (sim), e se eu não gostar (7 dias de garantia, 100% de volta), serve pra iniciante (começa do zero). 4 cursos por R$ 119,90 até segunda, 30/11.\n\nhttps://techsantos.com.br/black-friday.php?utm_source=threads&utm_medium=social&utm_campaign=bf2026"}
]}
JSON, true);
$pdo = db();
$out = [];
$ok = function (string $url): bool { $h = @get_headers($url, true); return is_array($h) && str_contains((string)($h[0] ?? ''), '200'); };
$exists = $pdo->prepare("SELECT id FROM social_posts WHERE canal=? AND imagem_url=? LIMIT 1");
$ins = $pdo->prepare("INSERT INTO social_posts (canal,tipo,midia_tipo,legenda,imagem_url,link_url,carousel_urls,agendado_para,status,meta_post_id) VALUES (?,?,?,?,?,NULL,?,?,?,?)");
foreach ($plan['reels'] as $p) {
    $url = 'https://media.techsantos.com.br/reels/' . $p['file'];
    if (!$ok($url)) { $out[] = "MIDIA|ERRO|{$p['file']}"; continue; }
    $when = $p['when'];
    $exists->execute(['instagram', $url]);
    if (!$exists->fetchColumn()) { $ins->execute(['instagram', 'reels', 'video', $p['caption'], $url, null, $when, 'pendente', null]); $out[] = "IG|OK|{$p['file']}|{$when}"; } else $out[] = "IG|IGNORADO|{$p['file']}";
    $exists->execute(['threads', $url]);
    $thWhen = date('Y-m-d H:i:s', strtotime($when . ' UTC') + 1800);
    if (!$exists->fetchColumn()) { $ins->execute(['threads', 'reels', 'video', $p['th'], $url, null, $thWhen, 'pendente', null]); $out[] = "THREADS|OK|{$p['file']}|{$thWhen}"; } else $out[] = "THREADS|IGNORADO|{$p['file']}";
    $exists->execute(['facebook', $url]);
    if ($exists->fetchColumn()) { $out[] = "FB|IGNORADO|{$p['file']}"; continue; }
    $error = null;
    $vid = meta_schedule_facebook_reel($p['caption'], $url, strtotime($when . ' UTC'), $error);
    if ($vid === null) { $out[] = "FB|ERRO|{$p['file']}|{$error}"; continue; }
    $ins->execute(['facebook', 'reels', 'video', $p['caption'], $url, null, $when, 'agendado_meta', $vid]);
    $out[] = "FB|OK|{$p['file']}|{$vid}";
}
try {
    $r = $pdo->query("SELECT id, ativo, palavra_chave FROM social_auto_reply_rules WHERE UPPER(palavra_chave) = 'BLACK'")->fetchAll(PDO::FETCH_ASSOC);
    $out[] = 'REGRA_BLACK|' . json_encode($r, JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) { $out[] = 'REGRA_BLACK|ERRO|' . $e->getMessage(); }
$c = $pdo->query("SELECT canal, tipo, agendado_para, COUNT(*) n FROM social_posts WHERE status IN ('pendente','agendado_meta') AND agendado_para BETWEEN '2026-11-25' AND '2026-11-28' GROUP BY canal, tipo, agendado_para HAVING n > 1");
foreach ($c as $row) $out[] = "CONFLITO|{$row['canal']}|{$row['tipo']}|{$row['agendado_para']}|{$row['n']}";
echo implode("\n", $out) . "\n";
