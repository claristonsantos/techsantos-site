<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }

// Lote 2 de Reels com trechos reais das aulas (um por módulo). 15:00 UTC = 12h de Brasília.
$cta = "\n\nTrecho real da aula do curso de Power BI. Comente 2026 que eu te mando as 3 primeiras aulas grátis.\n\n";
$posts=[
 ['file'=>'aula-trecho-consulta-pasta.mp4','when'=>'2026-10-05 15:00:00','caption'=>"Um Excel por mês? Junte tudo numa tabela só com a consulta de pasta do Power Query.\n\nRelatórios mensais com as mesmas colunas não precisam de PROCV entre arquivos: coloque todos numa pasta, conecte o Power BI na pasta e transforme numa tabela única.".$cta."#PowerBI #PowerQuery #Excel #Automacao"],
 ['file'=>'aula-trecho-performance-analyzer.mp4','when'=>'2026-10-06 15:00:00','caption'=>"Relatório do Power BI lento? Descubra qual visual está pesando.\n\nNa guia Otimizar, o Performance Analyzer grava a atualização e mostra o tempo de resposta de cada visual — e a consulta DAX por trás dele.".$cta."#PowerBI #Performance #DAX #Otimizacao"],
 ['file'=>'aula-trecho-dax-allselected.mp4','when'=>'2026-10-08 15:00:00','caption'=>"Percentual que não dá 100% quando você usa a segmentação? ALL x ALLSELECTED no DAX.\n\nO ALL ignora todos os filtros e calcula em cima da tabela inteira. O ALLSELECTED respeita a seleção da segmentação — e o total volta a dar 100%.".$cta."#PowerBI #DAX #ALLSELECTED #CALCULATE"],
 ['file'=>'aula-trecho-editar-interacoes.mp4','when'=>'2026-10-09 15:00:00','caption'=>"Filtrar o mês sem mudar o gráfico do ano inteiro no Power BI.\n\nEm Formato > Editar interações você escolhe quais visuais a segmentação filtra. O gráfico histórico fica fixo enquanto os cartões mudam com o mês.".$cta."#PowerBI #Dashboard #DataViz #Relatorios"],
 ['file'=>'aula-trecho-influenciadores.mp4','when'=>'2026-10-10 15:00:00','caption'=>"O Power BI te diz o que mais influencia o seu resultado.\n\nO visual Principais Influenciadores (Inserir > visuais de IA) analisa os campos que você escolher e mostra o que mais aumenta ou diminui a métrica.".$cta."#PowerBI #InteligenciaArtificial #AnaliseDeDados #Insights"],
 ['file'=>'aula-trecho-assinatura-email.mp4','when'=>'2026-10-11 15:00:00','caption'=>"Dashboard chegando sozinho no e-mail todo dia com o Power BI.\n\nNo Power BI Service, a assinatura (Subscribe) envia o dashboard por e-mail na frequência e no horário que você definir — para você ou para o gestor.".$cta."#PowerBI #PowerBIService #Dashboard #Automacao"],
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
}
header('Content-Type: text/plain; charset=utf-8'); echo implode("\n",$out)."\n"; @unlink(__FILE__);
