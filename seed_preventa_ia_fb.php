<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: agenda a pré-venda Power BI com IA (01–05/12/2026) — Reels no IG/Threads (+ Facebook nos dias úteis) e Stories. Horários UTC. Idempotente.
header('Content-Type: text/plain; charset=utf-8');
set_time_limit(0);
ignore_user_abort(true);
@unlink(__FILE__);
$plan = json_decode(<<<'JSON'
{"reels": [{"file": "preventa-ia-analista.mp4", "day": "2026-12-01", "caption": "Mesma planilha bagunçada, mesmo chefe, mesmo prazo. Um analista entrega no fim do dia, o outro antes do almoço.\n\nA diferença é a IA no Power BI: ela escreve o Power Query, cria a medida DAX e explica os números. Mas ela erra, e quem sabe Power BI percebe o erro antes do chefe.\n\nO minicurso Power BI com IA abre em janeiro. Comente FUNDADOR que eu te mando o link da lista: quem entra agora garante o preço de fundador de R$ 47 (depois R$ 97). Entrar na lista é grátis.\n\n#PowerBI #InteligenciaArtificial #ChatGPT #Copilot #AnaliseDeDados", "th": "Mesma planilha, mesmo chefe: quem usa IA no Power BI entrega antes do almoço. Mas a IA erra, e só quem sabe Power BI percebe.\n\nLista do minicurso Power BI com IA (preço de fundador): techsantos.com.br/power-bi-com-ia.php", "sem_fb": false}, {"file": "preventa-ia-dax.mp4", "day": "2026-12-03", "caption": "Travou numa fórmula DAX? Descreva em português o que você quer e diga os nomes das suas tabelas e colunas (senão a IA inventa).\n\nO Copilot escreve a consulta direto no Power BI, e o ChatGPT e o Claude fazem o mesmo de graça. O passo que quase ninguém faz: teste com um número que você já conhece. Não bateu? A IA errou.\n\nO minicurso Power BI com IA abre em janeiro. Comente FUNDADOR que eu te mando o link da lista: quem entra agora garante o preço de fundador de R$ 47 (depois R$ 97). Entrar na lista é grátis.\n\n#PowerBI #InteligenciaArtificial #ChatGPT #Copilot #AnaliseDeDados", "th": "DAX travou? Descreva a medida em português, diga suas colunas e TESTE com um número que você já conhece. A IA erra.\n\nLista do minicurso Power BI com IA (preço de fundador): techsantos.com.br/power-bi-com-ia.php", "sem_fb": false}, {"file": "preventa-ia-relatorio.mp4", "day": "2026-12-05", "caption": "Reunião daqui a uma hora e o relatório em branco? O Copilot do Power BI cria o rascunho de uma página inteira a partir de um pedido simples.\n\nMas o rascunho não sabe o que o seu chefe vai perguntar. Escolher o gráfico certo e conferir os números continua sendo trabalho seu.\n\nO minicurso Power BI com IA abre em janeiro. Comente FUNDADOR que eu te mando o link da lista: quem entra agora garante o preço de fundador de R$ 47 (depois R$ 97). Entrar na lista é grátis.\n\n#PowerBI #InteligenciaArtificial #ChatGPT #Copilot #AnaliseDeDados", "th": "O Copilot cria o rascunho da página do relatório em 1 minuto. Escolher o gráfico certo e conferir os números continua sendo seu trabalho.\n\nLista do minicurso Power BI com IA (preço de fundador): techsantos.com.br/power-bi-com-ia.php", "sem_fb": true}], "stories": [{"file": "stories/2026-12/1201-3-reel-pbi-ia.jpg", "when": "2026-12-01 15:10:00"}, {"file": "stories/2026-12/1203-3-reel-pbi-ia.jpg", "when": "2026-12-03 15:10:00"}, {"file": "stories/2026-12/1205-3-reel-pbi-ia.jpg", "when": "2026-12-05 15:10:00"}]}
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
$c = $pdo->query("SELECT canal, tipo, agendado_para, COUNT(*) n FROM social_posts WHERE status IN ('pendente','agendado_meta') AND agendado_para BETWEEN '2026-12-01' AND '2026-12-06' GROUP BY canal, tipo, agendado_para HAVING n > 1");
foreach ($c as $r) $out[] = "CONFLITO|{$r['canal']}|{$r['tipo']}|{$r['agendado_para']}|{$r['n']}";
echo implode("\n", $out) . "\n";
