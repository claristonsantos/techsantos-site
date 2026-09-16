<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }

$posts = [
 ['file'=>'fabric-direct-lake.mp4','ig_when'=>'2026-09-19 13:00:00','fb_when'=>'2026-09-19 14:00:00','caption'=>"Import é rápido mas trava atualização. DirectQuery atualiza mas pode ficar lento. E se desse pra ter os dois?\n\nDirect Lake lê os dados do OneLake direto em memória, sem duplicar nem esperar um DirectQuery tradicional.\n\nSalve pra próxima decisão de modelagem no Fabric.\n\n#MicrosoftFabric #DirectLake #PowerBI #OneLake"],
 ['file'=>'dica-copilot-dax.mp4','ig_when'=>'2026-09-22 13:00:00','fb_when'=>'2026-09-22 14:00:00','caption'=>"Precisa de uma medida DAX e não lembra a sintaxe?\n\nDescreva o que quer em português pro Copilot do Power BI — ele sugere a fórmula DAX pronta, e você revisa antes de aplicar.\n\nComente DAX que eu mostro o prompt que uso.\n\n#PowerBI #Copilot #DAX #InteligenciaArtificial"],
 ['file'=>'dica-copilot-resumo.mp4','ig_when'=>'2026-09-23 13:00:00','fb_when'=>'2026-09-23 14:00:00','caption'=>"Ninguém tem tempo de ler todo relatório antes da reunião.\n\nO Copilot resume as páginas em linguagem natural, destacando tendências e pontos fora do padrão sem você abrir cada visual.\n\nSalve pra sua próxima reunião de resultado.\n\n#PowerBI #Copilot #BusinessIntelligence #Produtividade"],
 ['file'=>'dica-powerbi-rls.mp4','ig_when'=>'2026-09-24 13:00:00','fb_when'=>'2026-09-24 14:00:00','caption'=>"Todo vendedor abre o mesmo relatório e vê os números de todo mundo?\n\nCom Row-Level Security, cada usuário enxerga só a linha que é dele — a regra fica no modelo, não em filtro manual.\n\nSalve pra proteger seu próximo relatório comercial.\n\n#PowerBI #RLS #Seguranca #ModelagemDeDados"],
 ['file'=>'fabric-dataflows-gen2.mp4','ig_when'=>'2026-09-25 13:00:00','fb_when'=>'2026-09-25 14:00:00','caption'=>"Nem todo ETL precisa de código.\n\nCom Dataflows Gen2, você transforma dados no Power Query e envia direto pro destino — Lakehouse, Warehouse ou banco externo — sem escrever pipeline do zero.\n\nEnvie pra quem ainda monta ETL na unha.\n\n#MicrosoftFabric #DataflowsGen2 #ETL #PowerQuery"],
 ['file'=>'dica-powerbi-fieldparams.mp4','ig_when'=>'2026-09-26 13:00:00','fb_when'=>'2026-09-26 14:00:00','caption'=>"Cansado de duplicar o mesmo gráfico só pra trocar a métrica?\n\nField parameters transformam um slicer em botão de troca: o mesmo visual passa de receita pra margem pra ticket médio sem criar nada novo.\n\nSalve pra simplificar seu próximo dashboard.\n\n#PowerBI #FieldParameters #Dashboard #DataVisualization"],
 ['file'=>'dica-excel-lambda.mp4','ig_when'=>'2026-09-28 13:00:00','fb_when'=>'2026-09-28 14:00:00','caption'=>"Fórmula gigante repetida em várias células? Dá pra virar função.\n\nCom LAMBDA você nomeia sua própria fórmula, reutiliza em qualquer lugar da planilha e nem precisa abrir o VBA.\n\nSalve pra próxima planilha complexa.\n\n#Excel #LAMBDA #PowerQuery #Produtividade"],
 ['file'=>'dica-excel-python.mp4','ig_when'=>'2026-09-29 13:00:00','fb_when'=>'2026-09-29 14:00:00','caption'=>"Python agora roda direto dentro da célula do Excel.\n\nSem instalar nada: você escreve o script na própria planilha e o resultado volta pra célula, integrado com fórmulas nativas.\n\nSalve pra testar na sua próxima análise.\n\n#Excel #Python #DataAnalytics #Produtividade"],
 ['file'=>'promo-aula-objecao.mp4','ig_when'=>'2026-09-30 21:00:00','fb_when'=>'2026-09-30 21:00:00','caption'=>"Aula particular parece cara até você comparar com o tempo travado no mesmo erro.\n\nUma aula direcionada resolve o que semanas tentando sozinho não resolveram — no seu modelo, no seu contexto.\n\nComente AULA e eu envio os horários no direct.\n\n#PowerBI #AulaParticular #Excel #DataAnalytics"],
 ['file'=>'promo-curso-apostila.mp4','ig_when'=>'2026-10-01 21:00:00','fb_when'=>'2026-10-01 21:00:00','caption'=>"Por trás do curso tem uma apostila que segue cada aula, exercício por exercício.\n\nNão é só slide — é material pra consultar depois, no seu ritmo, sempre que precisar revisar um conceito.\n\nComente CURSO pra saber mais.\n\n#PowerBI #CursoPowerBI #Excel #DataAnalytics"],
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
