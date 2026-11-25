<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: (1) troca os reels antigos da Black Friday de 27/11 e 29/11 (IG/Threads, ainda pendentes)
// pelos novos com voz clonada; (2) agenda o "último dia" em 30/11 15:00 UTC (12h BRT) em IG, Threads e FB. Idempotente.
header('Content-Type: text/plain; charset=utf-8');
set_time_limit(0);
ignore_user_abort(true);
@unlink(__FILE__);
$M = 'https://media.techsantos.com.br/reels/';
$fim = "\n\nCurte e segue o perfil pra não perder as próximas dicas 💚\n\n#BlackFriday #PowerBI #Excel #Python #Ingles #CursosOnline";
$utm = "\n\nhttps://techsantos.com.br/black-friday.php?utm_source=threads&utm_medium=social&utm_campaign=bf2026";
$plan = [
    '2026-11-27' => ['file' => 'bf-kairo-hoje.mp4',
        'ig' => "Hoje é Black Friday! 🖤💚\n\n4 cursos completos: Power BI, Excel, Python e Inglês por R$ 119,90. Separados, eles custam R$ 336,70.\n\n✅ Acesso vitalício\n✅ Garantia incondicional de 7 dias\n✅ Pix ou até 12x no cartão\n\nSó até segunda, 30/11.\n\nComente BLACK que eu te mando o link no direct, ou acesse techsantos.com.br/black-friday.php" . $fim,
        'th' => "Hoje é Black Friday! 4 cursos completos (Power BI, Excel, Python e Inglês) por R$ 119,90, com acesso vitalício e garantia de 7 dias. Pix ou até 12x. Só até segunda, 30/11." . $utm],
    '2026-11-29' => ['file' => 'bf-kairo-pagamento.mp4',
        'ig' => "A Black Friday acaba amanhã! ⏳\n\nPra quem me perguntou como pagar:\n⚡ Pix, na hora\n💳 ou parcelado em até 12x no cartão\n\n4 cursos (Power BI, Excel, Python e Inglês) por R$ 119,90, com acesso vitalício e garantia incondicional de 7 dias.\n\nComente BLACK que eu te mando o link no direct." . $fim,
        'th' => "A Black Friday acaba amanhã. Dá pra pagar no Pix, na hora, ou em até 12x no cartão. 4 cursos (Power BI, Excel, Python e Inglês) por R$ 119,90, com garantia de 7 dias." . $utm],
];
$pdo = db();
$out = [];
$ok = function (string $url): bool { $h = @get_headers($url, true); return is_array($h) && str_contains((string)($h[0] ?? ''), '200'); };
$upd = $pdo->prepare("UPDATE social_posts SET imagem_url=?, legenda=? WHERE id=?");
foreach ($plan as $dia => $p) {
    $url = $M . $p['file'];
    if (!$ok($url)) { $out[] = "MIDIA|ERRO|{$p['file']}"; continue; }
    $st = $pdo->prepare("SELECT id, canal, agendado_para, imagem_url FROM social_posts
        WHERE canal IN ('instagram','threads') AND tipo='reels' AND status='pendente' AND DATE(agendado_para)=?
          AND (imagem_url LIKE '%bf%' OR legenda LIKE '%Black Friday%') ORDER BY id");
    $st->execute([$dia]);
    $rows = $st->fetchAll(PDO::FETCH_ASSOC);
    if (!$rows) $out[] = "TROCA|NENHUM|$dia";
    foreach ($rows as $r) {
        if ($r['imagem_url'] === $url) { $out[] = "TROCA|JA|{$r['id']}|{$r['canal']}"; continue; }
        $upd->execute([$url, $r['canal'] === 'threads' ? $p['th'] : $p['ig'], $r['id']]);
        $out[] = "TROCA|OK|{$r['id']}|{$r['canal']}|{$r['agendado_para']}|antes=" . basename((string)$r['imagem_url']);
    }
}
// 30/11 — último dia
$url = $M . 'bf-kairo-ultimo.mp4';
$when = '2026-11-30 15:00:00';
$ig = "ÚLTIMO DIA! ⏰ A Black Friday da Tech Santos termina hoje, às 23:59.\n\n4 cursos completos: Power BI, Excel, Python e Inglês por R$ 119,90.\n\n✅ Acesso vitalício\n✅ Garantia incondicional de 7 dias\n✅ Pix ou até 12x no cartão\n\nDepois de hoje, o preço volta.\n\nComente BLACK que eu te mando o link no direct, ou acesse techsantos.com.br/black-friday.php" . $fim;
$th = "Último dia da Black Friday da Tech Santos: termina hoje às 23:59. 4 cursos (Power BI, Excel, Python e Inglês) por R$ 119,90, acesso vitalício e garantia de 7 dias. Depois de hoje o preço volta." . $utm;
$exists = $pdo->prepare("SELECT id FROM social_posts WHERE canal=? AND imagem_url=? LIMIT 1");
$ins = $pdo->prepare("INSERT INTO social_posts (canal,tipo,midia_tipo,legenda,imagem_url,link_url,carousel_urls,agendado_para,status,meta_post_id) VALUES (?,?,?,?,?,NULL,NULL,?,?,?)");
if (!$ok($url)) { $out[] = 'MIDIA|ERRO|ultimo'; } else {
    $exists->execute(['instagram', $url]);
    if (!$exists->fetchColumn()) { $ins->execute(['instagram', 'reels', 'video', $ig, $url, $when, 'pendente', null]); $out[] = "IG|OK|ultimo|$when"; } else $out[] = 'IG|IGNORADO|ultimo';
    $exists->execute(['threads', $url]);
    if (!$exists->fetchColumn()) { $ins->execute(['threads', 'reels', 'video', $th, $url, '2026-11-30 15:30:00', 'pendente', null]); $out[] = 'THREADS|OK|ultimo'; } else $out[] = 'THREADS|IGNORADO|ultimo';
    $exists->execute(['facebook', $url]);
    if ($exists->fetchColumn()) { $out[] = 'FB|IGNORADO|ultimo'; } else {
        $error = null;
        $vid = meta_schedule_facebook_reel($ig, $url, strtotime($when . ' UTC'), $error);
        if ($vid === null) $out[] = "FB|ERRO|ultimo|$error";
        else { $ins->execute(['facebook', 'reels', 'video', $ig, $url, $when, 'agendado_meta', $vid]); $out[] = "FB|OK|ultimo|$vid"; }
    }
}
$c = $pdo->query("SELECT id, canal, tipo, agendado_para, status, RIGHT(imagem_url,40) m FROM social_posts WHERE agendado_para BETWEEN '2026-11-27' AND '2026-12-01' AND status IN ('pendente','agendado_meta') ORDER BY agendado_para, canal");
foreach ($c as $row) $out[] = "AGENDA|" . implode('|', $row);
echo implode("\n", $out) . "\n";
