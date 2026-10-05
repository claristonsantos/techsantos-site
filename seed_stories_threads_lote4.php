<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
// Stories (quiz + chamada do Reel) e textos do Threads de 17–21/10/2026. Horários UTC.
$plan = json_decode(<<<'JSON'
{"stories": [{"file": "stories/2026-10/1017-1-quiz.jpg", "when": "2026-10-17 12:00:00"}, {"file": "stories/2026-10/1017-3-reel.jpg", "when": "2026-10-17 15:10:00"}, {"file": "stories/2026-10/1018-1-quiz.jpg", "when": "2026-10-18 12:00:00"}, {"file": "stories/2026-10/1018-3-reel.jpg", "when": "2026-10-18 15:10:00"}, {"file": "stories/2026-10/1019-1-quiz.jpg", "when": "2026-10-19 12:00:00"}, {"file": "stories/2026-10/1019-3-reel.jpg", "when": "2026-10-19 15:10:00"}, {"file": "stories/2026-10/1020-1-quiz.jpg", "when": "2026-10-20 12:00:00"}, {"file": "stories/2026-10/1020-3-reel.jpg", "when": "2026-10-20 15:10:00"}, {"file": "stories/2026-10/1021-1-quiz.jpg", "when": "2026-10-21 12:00:00"}, {"file": "stories/2026-10/1021-3-reel.jpg", "when": "2026-10-21 15:10:00"}], "threads": [{"when": "2026-10-17 12:30:00", "text": "Dica de design pra relatório: no máximo 3 cores — uma de destaque, uma neutra e uma de alerta.\n\nMais que isso e ninguém sabe o que é importante na tela."}, {"when": "2026-10-18 12:30:00", "text": "Tabela calendário não é opcional no Power BI.\n\nSem ela, DATESYTD, DATEADD e comparação com o ano anterior não funcionam direito. Marque como tabela de datas e relacione com a tabela fato."}, {"when": "2026-10-19 12:30:00", "text": "Pergunta: no seu relatório, quem lê sabe em 3 segundos se o resultado foi bom ou ruim?\n\nSe não sabe, falta uma meta, uma seta ou uma cor. 👇"}, {"when": "2026-10-20 12:30:00", "text": "Power Query: Mesclar consultas junta COLUNAS de outra tabela (tipo PROCV). Acrescentar consultas junta LINHAS (tipo empilhar planilhas).\n\nConfundir os dois é erro clássico."}, {"when": "2026-10-21 12:30:00", "text": "Segurança no Power BI tem duas camadas: quem acessa o workspace/app e o que cada pessoa vê dentro do relatório (RLS).\n\nUma não substitui a outra."}]}
JSON, true);
$pdo = db();
$out = [];
$stE = $pdo->prepare("SELECT id FROM social_posts WHERE tipo='story' AND imagem_url=? LIMIT 1");
$stI = $pdo->prepare("INSERT INTO social_posts (canal,tipo,midia_tipo,legenda,imagem_url,link_url,agendado_para,status) VALUES ('instagram','story','imagem','',?,NULL,?,'pendente')");
foreach ($plan['stories'] as $s) {
    $url = 'https://media.techsantos.com.br/' . $s['file'];
    $h = @get_headers($url, true);
    if (!is_array($h) || !str_contains((string)($h[0] ?? ''), '200')) { $out[] = "STORY|MIDIA_ERRO|{$s['file']}"; continue; }
    $stE->execute([$url]); if ($stE->fetchColumn()) { $out[] = "STORY|IGNORADO|{$s['file']}"; continue; }
    $stI->execute([$url, $s['when']]); $out[] = "STORY|OK|{$s['when']}|" . basename($s['file']);
}
$thE = $pdo->prepare("SELECT id FROM social_posts WHERE canal='threads' AND agendado_para=? AND legenda=? LIMIT 1");
$thI = $pdo->prepare("INSERT INTO social_posts (canal,tipo,midia_tipo,legenda,imagem_url,link_url,agendado_para,status) VALUES ('threads','feed','imagem',?,'',NULL,?,'pendente')");
foreach ($plan['threads'] as $t) {
    $thE->execute([$t['when'], $t['text']]); if ($thE->fetchColumn()) { $out[] = "THREADS|IGNORADO|{$t['when']}"; continue; }
    $thI->execute([$t['text'], $t['when']]); $out[] = "THREADS|OK|{$t['when']}";
}
header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";
@unlink(__FILE__);
