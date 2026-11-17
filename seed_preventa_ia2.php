<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: agenda a pré-venda Power BI com IA, 2ª leva (07 e 09/12/2026) — Reels no IG/Threads (+ Facebook nos dias úteis) e Stories. Horários UTC. Idempotente.
header('Content-Type: text/plain; charset=utf-8');
set_time_limit(0);
ignore_user_abort(true);
@unlink(__FILE__);
$plan = json_decode(<<<'JSON'
{"reels": [{"file": "preventa-ia-checklist.mp4", "day": "2026-12-07", "caption": "Seu chefe pediu um dashboard de vendas pra hoje? Você descreve em português, e a IA escreve o Power Query, cria as medidas DAX, sugere o layout e explica os números.\n\nMas a IA erra. Teste com um número que você já conhece: conferir continua sendo trabalho seu, e é isso que faz você ser lembrado.\n\nO minicurso Power BI com IA abre em janeiro. Comente FUNDADOR que eu te mando o link da lista: quem entra agora garante o preço de fundador de R$ 47 (depois R$ 97). Entrar na lista é grátis.\n\n#PowerBI #InteligenciaArtificial #ChatGPT #Copilot #AnaliseDeDados", "th": "Você pede em português, a IA faz Power Query, DAX e layout. Mas ela erra: conferir com um número conhecido é trabalho seu.\n\nLista do minicurso Power BI com IA (preço de fundador): techsantos.com.br/power-bi-com-ia.php", "sem_fb": false}, {"file": "preventa-ia-sketch.mp4", "day": "2026-12-09", "caption": "Dashboard com IA em 5 etapas:\n\n1. Você pede em português, com os nomes das suas tabelas e colunas\n2. A IA escreve o Power Query que limpa a planilha\n3. Cria as medidas DAX (vendas vs. ano anterior)\n4. O Copilot monta o rascunho da página\n5. Você confere com um número que já conhece. A IA erra.\n\nO minicurso Power BI com IA abre em janeiro. Comente FUNDADOR que eu te mando o link da lista: quem entra agora garante o preço de fundador de R$ 47 (depois R$ 97). Entrar na lista é grátis.\n\n#PowerBI #InteligenciaArtificial #ChatGPT #Copilot #AnaliseDeDados", "th": "Dashboard com IA em 5 etapas: pedir em português, Power Query, DAX, rascunho da página e (a mais importante) conferir. A IA erra.\n\nLista do minicurso Power BI com IA (preço de fundador): techsantos.com.br/power-bi-com-ia.php", "sem_fb": false}], "stories": [{"file": "stories/2026-12/1207-3-reel-pbi-ia.jpg", "when": "2026-12-07 15:10:00"}, {"file": "stories/2026-12/1209-3-reel-pbi-ia.jpg", "when": "2026-12-09 15:10:00"}]}
JSON, true);
$pdo = db();
$out = [];
$ok = function (string $url): bool { $h = @get_headers($url, true); return is_array($h) && str_contains((string)($h[0] ?? ''), '200'); };
$exists = $pdo->prepare("SELECT id FROM social_posts WHERE canal=? AND imagem_url=? LIMIT 1");
$ins = $pdo->prepare("INSERT INTO social_posts (canal,tipo,midia_tipo,legenda,imagem_url,link_url,carousel_urls,agendado_para,status,meta_post_id) VALUES (?,?,?,?,?,NULL,?,?,?,?)");
foreach ($plan['reels'] as $p) {
    $url = 'https://media.techsantos.com.br/reels/' . $p['file'];
    if (!$ok($url)) { $out[] = "MIDIA|ERRO|{$p['file']}"; continue; }
    $when = $p['day'] . ' 15:00:00';
    $exists->execute(['instagram', $url]);
    if (!$exists->fetchColumn()) { $ins->execute(['instagram', 'reels', 'video', $p['caption'], $url, null, $when, 'pendente', null]); $out[] = "IG|OK|{$p['file']}"; } else $out[] = "IG|IGNORADO|{$p['file']}";
    $exists->execute(['threads', $url]);
    if (!$exists->fetchColumn()) { $ins->execute(['threads', 'reels', 'video', $p['th'], $url, null, $p['day'] . ' 15:30:00', 'pendente', null]); $out[] = "THREADS|OK|{$p['file']}"; } else $out[] = "THREADS|IGNORADO|{$p['file']}";
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
// Conflitos no mesmo horário com posts já pendentes (ex.: campanha Black Friday)
$c = $pdo->query("SELECT canal, tipo, agendado_para, COUNT(*) n FROM social_posts WHERE status IN ('pendente','agendado_meta') AND agendado_para BETWEEN '2026-12-07' AND '2026-12-10' GROUP BY canal, tipo, agendado_para HAVING n > 1");
foreach ($c as $r) $out[] = "CONFLITO|{$r['canal']}|{$r['tipo']}|{$r['agendado_para']}|{$r['n']}";
echo implode("\n", $out) . "\n";
