<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: agenda o lote 8 (22–27/11/2026) — Reels de Power BI no IG/Threads (+ Facebook nos dias úteis) e Stories. Horários UTC. Idempotente.
header('Content-Type: text/plain; charset=utf-8');
set_time_limit(0);
ignore_user_abort(true);
@unlink(__FILE__);
$plan = json_decode(<<<'JSON'
{"reels": [{"file": "novidade-pbi-gantt-nativo.mp4", "day": "2026-11-22", "caption": "O Power BI ganhou gráfico de Gantt nativo na atualização de outubro/2026 (versão prévia).\n\nDuração das tarefas no eixo de tempo, progresso dentro da barra, marcos, cores por categoria e zoom no eixo, sem visual personalizado. Pra testar: Arquivo › Opções e configurações › Opções › Recursos de versão prévia, ative o Gantt e reinicie o Desktop.\n\nResumo completo das novidades de outubro no blog: https://techsantos.com.br/blog/novidades-power-bi-outubro-2026.php\n\nQuer aprender Power BI do zero ao dashboard? Comente 2026 que eu te mando as 3 primeiras aulas grátis do curso.\n\n#PowerBI #DAX #Dashboard #AnaliseDeDados", "th": "Power BI de outubro/2026: Gantt nativo (prévia). Duração, progresso e marcos sem visual da loja.\n\n3 aulas grátis do curso de Power BI: techsantos.com.br/aula-gratis.php", "sem_fb": true}, {"file": "novidade-pbi-segmentacao-suspensa.mp4", "day": "2026-11-23", "caption": "Segmentação ocupando metade da página? A atualização de outubro/2026 trouxe o modo suspenso pra segmentação de lista (versão prévia).\n\nEla fica compacta e só abre quando você clica. As seleções viram etiquetas que saem com um clique, e a opção Mostrar selecionados primeiro coloca os itens ativos no topo da lista.\n\nQuer aprender Power BI do zero ao dashboard? Comente 2026 que eu te mando as 3 primeiras aulas grátis do curso.\n\n#PowerBI #DAX #Dashboard #AnaliseDeDados", "th": "Power BI de outubro/2026: segmentação de lista em modo suspenso + Mostrar selecionados primeiro.\n\n3 aulas grátis do curso de Power BI: techsantos.com.br/aula-gratis.php", "sem_fb": false}, {"file": "dica-pbi-tabela-datas.mp4", "day": "2026-11-24", "caption": "Acumulado do ano dando número estranho? Confira se a sua tabela calendário está marcada como tabela de datas.\n\nBotão direito na tabela › Marcar como tabela de datas › escolha a coluna. Ela precisa ter datas únicas, sem vazios e contínuas. É obrigatório nas funções clássicas de inteligência de tempo, e o Power BI remove a hierarquia automática de datas.\n\nPasso a passo no blog: https://techsantos.com.br/blog/tabela-de-datas-power-bi.php\n\nQuer aprender Power BI do zero ao dashboard? Comente 2026 que eu te mando as 3 primeiras aulas grátis do curso.\n\n#PowerBI #DAX #Dashboard #AnaliseDeDados", "th": "Power BI: botão direito na calendário › Marcar como tabela de datas. Obrigatório na inteligência de tempo clássica.\n\n3 aulas grátis do curso de Power BI: techsantos.com.br/aula-gratis.php", "sem_fb": false}, {"file": "novidade-pbi-pagina-mobile.mp4", "day": "2026-11-25", "caption": "O diretor abriu o relatório no celular e a página estava toda espremida?\n\nNa atualização de outubro/2026, as abas das páginas passaram a mostrar um ícone quando a página tem layout para celular. Dá pra ver no rodapé quais páginas já estão prontas e quais ainda precisam de layout móvel.\n\nQuer aprender Power BI do zero ao dashboard? Comente 2026 que eu te mando as 3 primeiras aulas grátis do curso.\n\n#PowerBI #DAX #Dashboard #AnaliseDeDados", "th": "Power BI de outubro/2026: ícone na aba mostra quais páginas já têm layout para celular.\n\n3 aulas grátis do curso de Power BI: techsantos.com.br/aula-gratis.php", "sem_fb": false}, {"file": "dica-pbi-linha-media.mp4", "day": "2026-11-26", "caption": "Mostrar quem está acima ou abaixo da média sem escrever DAX:\n\nselecione o gráfico, abra o painel Análise (a lupa) e adicione a Linha média. Ainda tem mínimo, máximo, mediana, percentil e linha constante, ótima pra marcar a meta.\n\nPasso a passo no blog: https://techsantos.com.br/blog/linha-de-media-power-bi.php\n\nQuer aprender Power BI do zero ao dashboard? Comente 2026 que eu te mando as 3 primeiras aulas grátis do curso.\n\n#PowerBI #DAX #Dashboard #AnaliseDeDados", "th": "Power BI: painel Análise (lupa) › Linha média. Referência no gráfico sem nenhuma medida.\n\n3 aulas grátis do curso de Power BI: techsantos.com.br/aula-gratis.php", "sem_fb": false}, {"file": "dica-pbi-arvore-decomposicao.mp4", "day": "2026-11-27", "caption": "O chefe pergunta por que a venda caiu e você não sabe por onde começar? Use a árvore de decomposição.\n\nMétrica em Analisar, dimensões em Explicar por (região, produto, vendedor) e vá abrindo nível por nível no +. A divisão por IA escolhe sozinha a dimensão com o maior ou o menor valor.\n\nPasso a passo no blog: https://techsantos.com.br/blog/arvore-de-decomposicao-power-bi.php\n\nQuer aprender Power BI do zero ao dashboard? Comente 2026 que eu te mando as 3 primeiras aulas grátis do curso.\n\n#PowerBI #DAX #Dashboard #AnaliseDeDados", "th": "Power BI: árvore de decomposição. Analisar + Explicar por, e a IA aponta onde está o maior ou o menor valor.\n\n3 aulas grátis do curso de Power BI: techsantos.com.br/aula-gratis.php", "sem_fb": false}], "stories": [{"file": "stories/2026-11/1122-3-reel-pbi.jpg", "when": "2026-11-22 15:10:00"}, {"file": "stories/2026-11/1123-3-reel-pbi.jpg", "when": "2026-11-23 15:10:00"}, {"file": "stories/2026-11/1124-3-reel-pbi.jpg", "when": "2026-11-24 15:10:00"}, {"file": "stories/2026-11/1125-3-reel-pbi.jpg", "when": "2026-11-25 15:10:00"}, {"file": "stories/2026-11/1126-3-reel-pbi.jpg", "when": "2026-11-26 15:10:00"}, {"file": "stories/2026-11/1127-3-reel-pbi.jpg", "when": "2026-11-27 15:10:00"}]}
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
$c = $pdo->query("SELECT canal, tipo, agendado_para, COUNT(*) n FROM social_posts WHERE status IN ('pendente','agendado_meta') AND agendado_para BETWEEN '2026-11-22' AND '2026-11-28' GROUP BY canal, tipo, agendado_para HAVING n > 1");
foreach ($c as $r) $out[] = "CONFLITO|{$r['canal']}|{$r['tipo']}|{$r['agendado_para']}|{$r['n']}";
echo implode("\n", $out) . "\n";
