<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }

$stories = [
 ['file'=>'storytime-mapa-continente.mp4','when'=>'2026-09-16 21:00:00','caption'=>'Storytime: o mapa que trocou o continente sozinho.'],
 ['file'=>'storytime-numero-duplicado.mp4','when'=>'2026-09-17 21:00:00','caption'=>'Storytime: o número que aparecia em dobro no relatório.'],
 ['file'=>'storytime-slider-preco.mp4','when'=>'2026-09-18 21:00:00','caption'=>'Storytime: o slider de preço que ninguém sabia configurar.'],
 ['file'=>'promo-reels-b.mp4','when'=>'2026-09-23 21:00:00','caption'=>'Curso completo de Power BI — do zero ao dashboard publicado.'],
 ['file'=>'promo-reels-c.mp4','when'=>'2026-09-24 21:00:00','caption'=>'Aula grátis disponível — assista antes de decidir.'],
 ['file'=>'promo-reels-d.mp4','when'=>'2026-09-25 21:00:00','caption'=>'Power BI, Excel e Fabric num só curso.'],
 ['file'=>'promo-reels-e.mp4','when'=>'2026-09-26 21:00:00','caption'=>'Matrícula aberta — link na bio.'],
 ['file'=>'dica-powerbi-arquivo-lento.mp4','when'=>'2026-09-27 21:00:00','caption'=>'Power BI lento? Veja o que costuma causar isso.'],
 ['file'=>'dica-powerbi-total-duplicado.mp4','when'=>'2026-09-28 21:00:00','caption'=>'Total duplicado no cartão? O motivo é mais simples do que parece.'],
 ['file'=>'novidade-jun2026-copilot.mp4','when'=>'2026-09-29 21:00:00','caption'=>'Novidade Power BI: Copilot ficou mais rápido.'],
 ['file'=>'novidade-jun2026-data-relativa.mp4','when'=>'2026-09-30 21:00:00','caption'=>'Novidade Power BI: filtro de data relativa.'],
 ['file'=>'novidade-jun2026-datepicker.mp4','when'=>'2026-10-01 21:00:00','caption'=>'Novidade Power BI: seletor de data no relatório.'],
];
$pdo=db();
$exists=$pdo->prepare("SELECT id FROM social_posts WHERE canal='instagram' AND tipo='story' AND imagem_url=? LIMIT 1");
$insert=$pdo->prepare("INSERT INTO social_posts (canal,tipo,midia_tipo,legenda,imagem_url,link_url,agendado_para,status) VALUES ('instagram','story','video',?,?,NULL,?,'pendente')");
$out=[];
foreach($stories as $s){
 $url='https://media.techsantos.com.br/reels/'.$s['file'];
 $headers=@get_headers($url,true); $status=is_array($headers)?(string)($headers[0]??''):''; $type=is_array($headers)?(string)($headers['Content-Type']??$headers['content-type']??''):'';
 if(!str_contains($status,'200')||!str_contains(strtolower($type),'video/mp4')){$out[]="MIDIA|ERRO|{$s['file']}|{$status}|{$type}";continue;}
 $exists->execute([$url]); if($exists->fetchColumn()){$out[]="STORY|IGNORADO|{$s['file']}";continue;}
 $insert->execute([$s['caption'],$url,$s['when']]); $out[]="STORY|OK|id={$pdo->lastInsertId()}|{$s['when']}|{$s['file']}";
}
header('Content-Type: text/plain; charset=utf-8'); echo implode("\n",$out)."\n"; @unlink(__FILE__);
