<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }

$posts = [
 ['file'=>'dica-copilot-visuais-ocultos-1080x1920.mp4','ig_when'=>'2026-09-05 23:00:00','fb_when'=>'2026-09-05 14:00:00','caption'=>"Seu gráfico está escondido por um favorito? O Copilot agora consegue enxergá-lo.\n\nEle lê visuais revelados por favoritos de exibição sem mudar o estado do relatório. RLS e OLS continuam valendo.\n\nSalve para revisar seus favoritos.\n\n#PowerBI #Copilot #BusinessIntelligence #MicrosoftFabric"],
 ['file'=>'dica-atualizar-esquema-dados-1080x1920.mp4','ig_when'=>'2026-09-09 13:00:00','fb_when'=>'2026-09-09 14:00:00','caption'=>"Mudou uma coluna na fonte? O Power BI Service agora permite atualizar esquema e dados, somente esquema ou somente dados.\n\nTambém dá para atualizar uma tabela específica. Revise antes: mudanças estruturais podem quebrar medidas e visuais.\n\nCompartilhe com quem mantém seus modelos.\n\n#PowerBI #ModelagemDeDados #Analytics #Dados"],
 ['file'=>'dica-imagens-onelake-powerbi-1080x1920.mp4','ig_when'=>'2026-09-12 23:00:00','fb_when'=>'2026-09-12 14:00:00','caption'=>"A imagem do relatório não precisa ficar pública na internet.\n\nURLs autenticadas do OneLake funcionam em cartões, tabelas, matrizes, segmentações e mapas. Cada leitor precisa de acesso ao arquivo.\n\nSalve para o próximo relatório com fotos ou ícones.\n\n#PowerBI #OneLake #MicrosoftFabric #DataAnalytics"],
 ['file'=>'dica-valor-central-rosca-1080x1920.mp4','ig_when'=>'2026-09-15 13:00:00','fb_when'=>'2026-09-15 14:00:00','caption'=>"Pare de sobrepor um cartão no centro do gráfico de rosca.\n\nAgora existe valor central nativo, com total ou medida personalizada. Ele acompanha filtros, realces e seleção das fatias.\n\nEnvie para quem ainda alinha os dois visuais na mão.\n\n#PowerBI #DataVisualization #Dashboard #BusinessIntelligence"],
 ['file'=>'dica-matriz-expandir-colunas-1080x1920.mp4','ig_when'=>'2026-09-18 23:00:00','fb_when'=>'2026-09-18 14:00:00','caption'=>"A matriz ganhou o sinal de mais também no cabeçalho das colunas.\n\nExpanda ano, trimestre e mês dentro do próprio visual e personalize cor, tamanho e expansão automática.\n\nSalve para testar no próximo relatório.\n\n#PowerBI #Matriz #Dashboard #AnaliseDeDados"],
];
$pdo=db();
$igExists=$pdo->prepare("SELECT id FROM social_posts WHERE canal='instagram' AND tipo='reels' AND imagem_url=? LIMIT 1");
$igInsert=$pdo->prepare("INSERT INTO social_posts (canal,tipo,midia_tipo,legenda,imagem_url,link_url,agendado_para,status) VALUES ('instagram','reels','video',?,?,? ,?,'pendente')");
$fbExists=$pdo->prepare("SELECT id FROM social_posts WHERE canal='facebook' AND tipo='reels' AND imagem_url=? LIMIT 1");
$fbInsert=$pdo->prepare("INSERT INTO social_posts (canal,tipo,midia_tipo,legenda,imagem_url,link_url,agendado_para,status,meta_post_id) VALUES ('facebook','reels','video',?,?,?,?,'agendado_meta',?)");
$out=[];
foreach($posts as $p){
 $url='https://media.techsantos.com.br/reels/'.$p['file'];
 $link='https://techsantos.com.br/blog/novidades-power-bi-agosto-2026.php?utm_source=meta&utm_medium=organic_social&utm_campaign=powerbi_agosto_2026&utm_content='.rawurlencode(pathinfo($p['file'],PATHINFO_FILENAME));
 $headers=@get_headers($url,true); $status=is_array($headers)?(string)($headers[0]??''):''; $type=is_array($headers)?(string)($headers['Content-Type']??$headers['content-type']??''):'';
 if(!str_contains($status,'200')||!str_contains(strtolower($type),'video/mp4')){$out[]="MIDIA|ERRO|{$p['file']}|{$status}|{$type}";continue;}
 $igExists->execute([$url]); if(!$igExists->fetchColumn()){ $igInsert->execute([$p['caption'],$url,$link,$p['ig_when']]); $out[]="INSTAGRAM|OK|id={$pdo->lastInsertId()}|{$p['file']}";}else{$out[]="INSTAGRAM|IGNORADO|{$p['file']}";}
 $fbExists->execute([$url]); if($fbExists->fetchColumn()){$out[]="FACEBOOK|IGNORADO|{$p['file']}";continue;}
 $error=null; $videoId=meta_schedule_facebook_reel($p['caption'],$url,strtotime($p['fb_when'].' UTC'),$error);
 if($videoId===null){$out[]="FACEBOOK|ERRO|{$p['file']}|{$error}";continue;}
 $fbInsert->execute([$p['caption'],$url,$link,$p['fb_when'],$videoId]); $out[]="FACEBOOK|OK|id={$pdo->lastInsertId()}|video_id={$videoId}|{$p['file']}";
}
header('Content-Type: text/plain; charset=utf-8'); echo implode("\n",$out)."\n"; @unlink(__FILE__);
