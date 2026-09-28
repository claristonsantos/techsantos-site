<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }

// Promos dos cursos de Excel e Fabric (2026-09-28). Horários em UTC: 22:00 = 19h de Brasília.
$posts=[
 ['file'=>'promo-excel-j-10porcento.mp4','ig_when'=>'2026-10-06 22:00:00','fb_when'=>'2026-10-06 22:00:00','caption'=>"Você usa só 10% do Excel?\n\nSoma, filtro, copia e cola — e o resto continua um mistério. O curso de Excel da TECH SANTOS BR vai do zero ao avançado: PROCX, tabelas dinâmicas, gráficos, cenários, previsão e macros.\n\n17 módulos · 68 aulas · R$ 97 com acesso vitalício.\n\nComente EXCEL que eu te mando o link.\n\n#Excel #ExcelAvancado #CursoDeExcel #Produtividade"],
 ['file'=>'promo-fabric-l-carreira.mp4','ig_when'=>'2026-10-07 22:00:00','fb_when'=>'2026-10-07 22:00:00','caption'=>"Analista de Power BI: só Power BI já não basta.\n\nLakehouse, Spark, OneLake — as vagas de dados já pedem Microsoft Fabric. O curso cobre a plataforma de ponta a ponta, em português, com as telas oficiais da Microsoft: OneLake, lakehouse, warehouse, pipelines, Spark, tempo real, Direct Lake, DAX e CI/CD.\n\nPreparatório para as certificações DP-600 e DP-700.\n\nComente FABRIC que eu te mando o link.\n\n#MicrosoftFabric #PowerBI #EngenhariaDeDados #DP600"],
 ['file'=>'promo-excel-k-certificacao.mp4','ig_when'=>'2026-10-14 22:00:00','fb_when'=>'2026-10-14 22:00:00','caption'=>"Excel avançado no currículo — mas dá pra provar?\n\nO curso segue, habilidade por habilidade, as certificações Microsoft MO-210 (Excel Associate) e MO-211 (Excel Expert): teoria e áudio em cada aula, avaliação em cada módulo e 2 simulados no estilo da prova. São 208 questões e certificado de conclusão.\n\nComente EXCEL que eu te mando o link.\n\n#Excel #CertificacaoMicrosoft #MO210 #MO211"],
 ['file'=>'promo-fabric-m-dp600-dp700.mp4','ig_when'=>'2026-10-15 22:00:00','fb_when'=>'2026-10-15 22:00:00','caption'=>"DP-600 e DP-700 num curso só.\n\nEm vez de material em inglês, espalhado e sem ordem: cada habilidade cobrada nas provas virou uma aula. São 82 aulas em 15 módulos, cada uma também em áudio, 192 questões e 2 simulados finais.\n\nR$ 129,90 com acesso vitalício.\n\nComente FABRIC que eu te mando o link.\n\n#MicrosoftFabric #DP600 #DP700 #CertificacaoMicrosoft"],
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
 $igExists->execute([$url]); if(!$igExists->fetchColumn()){ $igInsert->execute([$p['caption'],$url,$p['ig_when']]); $out[]="INSTAGRAM|OK|id={$pdo->lastInsertId()}|{$p['file']}";}else{$out[]="INSTAGRAM|IGNORADO|{$p['file']}";}
 $fbExists->execute([$url]); if($fbExists->fetchColumn()){$out[]="FACEBOOK|IGNORADO|{$p['file']}";continue;}
 $error=null; $videoId=meta_schedule_facebook_reel($p['caption'],$url,strtotime($p['fb_when'].' UTC'),$error);
 if($videoId===null){$out[]="FACEBOOK|ERRO|{$p['file']}|{$error}";continue;}
 $fbInsert->execute([$p['caption'],$url,$p['fb_when'],$videoId]); $out[]="FACEBOOK|OK|id={$pdo->lastInsertId()}|video_id={$videoId}|{$p['file']}";
}
header('Content-Type: text/plain; charset=utf-8'); echo implode("\n",$out)."\n"; @unlink(__FILE__);
