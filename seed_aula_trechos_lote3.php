<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }

// Lote 3 de Reels com trechos reais das aulas. 15:00 UTC = 12h de Brasília.
$cta = "\n\nTrecho real da aula do curso de Power BI. Comente 2026 que eu te mando as 3 primeiras aulas grátis.\n\n";
$posts=[
 ['file'=>'aula-trecho-nao-bate-com-excel.mp4','when'=>'2026-10-12 15:00:00','caption'=>"“Esse número do Power BI não bate com o meu Excel!” — quase sempre é contexto de filtro.\n\nA mesma medida muda de valor conforme os filtros ativos: segmentação, filtro do visual, da página e do painel de filtros. E o filtro do painel nem sempre fica visível para quem lê o relatório.".$cta."#PowerBI #DAX #ContextoDeFiltro #Excel"],
 ['file'=>'aula-trecho-agrupar-por.mp4','when'=>'2026-10-13 15:00:00','caption'=>"Resumo por data e canal no Power Query com o Agrupar por.\n\nNo modo Avançado você agrupa por mais de uma coluna e cria várias saídas de uma vez: contar linhas e somar o total, sem tabela dinâmica e sem fórmula.".$cta."#PowerBI #PowerQuery #Excel #AnaliseDeDados"],
 ['file'=>'aula-trecho-divide.mp4','when'=>'2026-10-14 15:00:00','caption'=>"Erro de divisão por zero no DAX? Use DIVIDE em vez da barra.\n\nO DIVIDE divide com segurança e aceita um resultado alternativo para quando o denominador é zero ou vazio — ideal para margem e percentuais.".$cta."#PowerBI #DAX #DIVIDE #Medidas"],
 ['file'=>'aula-trecho-linha-de-meta.mp4','when'=>'2026-10-15 15:00:00','caption'=>"Linha de meta no gráfico do Power BI em poucos cliques.\n\nNo painel de formato do visual, a linha de referência constante no eixo Y marca a meta — e você ainda pode sombrear a área abaixo dela.".$cta."#PowerBI #DataViz #Dashboard #Metas"],
 ['file'=>'aula-trecho-dividir-coluna.mp4','when'=>'2026-10-16 15:00:00','caption'=>"Dividir coluna pela última vírgula no Power Query.\n\nEm Dividir coluna por delimitador, escolha a extremidade direita: ele separa só na última ocorrência e não quebra o texto que também tem vírgula no meio.".$cta."#PowerBI #PowerQuery #TratamentoDeDados #Excel"],
];
$pdo=db();
$igExists=$pdo->prepare("SELECT id FROM social_posts WHERE canal='instagram' AND tipo='reels' AND imagem_url=? LIMIT 1");
$igInsert=$pdo->prepare("INSERT INTO social_posts (canal,tipo,midia_tipo,legenda,imagem_url,link_url,agendado_para,status) VALUES ('instagram','reels','video',?,?,NULL,?,'pendente')");
$fbExists=$pdo->prepare("SELECT id FROM social_posts WHERE canal='facebook' AND tipo='reels' AND imagem_url=? LIMIT 1");
$fbInsert=$pdo->prepare("INSERT INTO social_posts (canal,tipo,midia_tipo,legenda,imagem_url,link_url,agendado_para,status,meta_post_id) VALUES ('facebook','reels','video',?,?,NULL,?,'agendado_meta',?)");
$out=[];
foreach($posts as $p){
 $url='https://media.techsantos.com.br/reels/'.$p['file'];
 $headers=@get_headers($url,true); $status=is_array($headers)?(string)($headers[0]??''):''; $type=is_array($headers)?(string)($headers['Content-Type']??$headers['content-type']??''):'';
 if(!str_contains($status,'200')||!str_contains(strtolower($type),'video/mp4')){$out[]="MIDIA|ERRO|{$p['file']}|{$status}|{$type}";continue;}
 $igExists->execute([$url]); if(!$igExists->fetchColumn()){ $igInsert->execute([$p['caption'],$url,$p['when']]); $out[]="INSTAGRAM|OK|id={$pdo->lastInsertId()}|{$p['file']}";}else{$out[]="INSTAGRAM|IGNORADO|{$p['file']}";}
 $fbExists->execute([$url]); if($fbExists->fetchColumn()){$out[]="FACEBOOK|IGNORADO|{$p['file']}";continue;}
 $error=null; $videoId=meta_schedule_facebook_reel($p['caption'],$url,strtotime($p['when'].' UTC'),$error);
 if($videoId===null){$out[]="FACEBOOK|ERRO|{$p['file']}|{$error}";continue;}
 $fbInsert->execute([$p['caption'],$url,$p['when'],$videoId]); $out[]="FACEBOOK|OK|id={$pdo->lastInsertId()}|video_id={$videoId}|{$p['file']}";
 sleep(8); // evita o 429 do servidor de mídia nos uploads seguidos do Facebook
}
header('Content-Type: text/plain; charset=utf-8'); echo implode("\n",$out)."\n"; @unlink(__FILE__);
