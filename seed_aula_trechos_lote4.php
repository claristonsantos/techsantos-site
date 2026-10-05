<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }

// Lote 4 de trechos de aula (17–21/10/2026). Instagram/Facebook 15:00 UTC (12h Brasília), Threads 15:30 UTC.
$cta = "\n\nTrecho real da aula do curso de Power BI. Comente 2026 que eu te mando as 3 primeiras aulas grátis.\n\n";
$posts = [
 ['file'=>'aula-trecho-conta-gotas.mp4','day'=>'2026-10-17','caption'=>"Não sabe o código da cor do layout no Power BI? Use o conta-gotas do PowerPoint.\n\nAbra o layout no PowerPoint, pegue a cor com o conta-gotas e veja o código em Mais cores — aí é só usar a mesma cor nos cartões e textos do relatório.".$cta."#PowerBI #Design #Dashboard #PowerPoint", 'th'=>"Não sabe o código da cor do layout? Conta-gotas do PowerPoint › Mais cores › usa a mesma cor no Power BI."],
 ['file'=>'aula-trecho-dax-ytd.mp4','day'=>'2026-10-18','caption'=>"Acumulado do ano (YTD) no DAX com DATESYTD.\n\nA medida vai somando mês a mês dentro do ano — e toda medida de inteligência de tempo precisa de uma tabela calendário no modelo.".$cta."#PowerBI #DAX #YTD #InteligenciaDeTempo", 'th'=>"Acumulado do ano (YTD) no DAX: DATESYTD vai somando mês a mês. E toda medida de tempo precisa de tabela calendário."],
 ['file'=>'aula-trecho-seta-condicional.mp4','day'=>'2026-10-19','caption'=>"Seta verde e vermelha no Power BI com formatação condicional por ícones.\n\nCrie regras no valor (por exemplo, o Year over Year): abaixo do alvo, seta vermelha; acima, seta verde. Quem lê entende o resultado em um segundo.".$cta."#PowerBI #FormatacaoCondicional #Dashboard #DataViz", 'th'=>"Seta verde e vermelha no Power BI: formatação condicional por ícones, com regras no valor."],
 ['file'=>'aula-trecho-mesclar-consultas.mp4','day'=>'2026-10-20','caption'=>"Mesclar consultas: o PROCV do Power Query.\n\nDuas tabelas com uma chave em comum viram uma só. E o left join mantém todas as linhas da primeira tabela e traz o que corresponde da segunda.".$cta."#PowerBI #PowerQuery #PROCV #Excel", 'th'=>"Mesclar consultas é o PROCV do Power Query. Left join: todas as linhas da 1ª tabela + o que corresponde da 2ª."],
 ['file'=>'aula-trecho-rls.mp4','day'=>'2026-10-21','caption'=>"Cada gestor vê só os dados da sua loja: RLS no Power BI.\n\nRow Level Security filtra as linhas pelo usuário que abriu o relatório. Você cria as funções em Modelagem › Gerenciar funções.".$cta."#PowerBI #RLS #Seguranca #ModelagemDeDados", 'th'=>"RLS no Power BI: cada gestor vê só os dados da sua loja. Funções em Modelagem › Gerenciar funções."],
];
$pdo = db();
$igExists = $pdo->prepare("SELECT id FROM social_posts WHERE canal=? AND imagem_url=? LIMIT 1");
$ins = $pdo->prepare("INSERT INTO social_posts (canal,tipo,midia_tipo,legenda,imagem_url,link_url,agendado_para,status,meta_post_id) VALUES (?,'reels','video',?,?,NULL,?,?,?)");
$out = [];
foreach ($posts as $p) {
    $url = 'https://media.techsantos.com.br/reels/' . $p['file'];
    $h = @get_headers($url, true);
    if (!is_array($h) || !str_contains((string)($h[0] ?? ''), '200')) { $out[] = "MIDIA|ERRO|{$p['file']}"; continue; }
    $when = $p['day'] . ' 15:00:00';
    $igExists->execute(['instagram', $url]);
    if (!$igExists->fetchColumn()) { $ins->execute(['instagram', $p['caption'], $url, $when, 'pendente', null]); $out[] = "IG|OK|{$p['file']}"; } else { $out[] = "IG|IGNORADO|{$p['file']}"; }
    $th = $p['th'] . "\n\nTrecho real da aula do curso de Power BI. 3 aulas grátis: techsantos.com.br/aula-gratis.php";
    $igExists->execute(['threads', $url]);
    if (!$igExists->fetchColumn()) { $ins->execute(['threads', $th, $url, $p['day'] . ' 15:30:00', 'pendente', null]); $out[] = "THREADS|OK|{$p['file']}"; } else { $out[] = "THREADS|IGNORADO|{$p['file']}"; }
    $igExists->execute(['facebook', $url]);
    if ($igExists->fetchColumn()) { $out[] = "FB|IGNORADO|{$p['file']}"; continue; }
    $error = null;
    $vid = meta_schedule_facebook_reel($p['caption'], $url, strtotime($when . ' UTC'), $error);
    if ($vid === null) { $out[] = "FB|ERRO|{$p['file']}|{$error}"; continue; }
    $ins->execute(['facebook', $p['caption'], $url, $when, 'agendado_meta', $vid]);
    $out[] = "FB|OK|{$p['file']}|{$vid}";
}
header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";
@unlink(__FILE__);
