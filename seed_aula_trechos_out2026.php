<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }

// Reels com trechos reais das aulas do curso de Power BI (2026-10-01). Horários em UTC (Brasília = UTC-3).
$posts=[
 ['file'=>'aula-trecho-perfil-dados.mp4','ig_when'=>'2026-10-01 15:00:00','fb_when'=>'2026-10-01 15:00:00','caption'=>"Perfil de dados no Power Query: olhe isto antes de transformar.\n\nMuita gente abre o Power Query e sai clicando em transformação sem olhar o que tem na base. A qualidade da coluna mostra na hora o que é válido (verde), erro (vermelho) e vazio (cinza) — antes do número não bater no relatório.\n\nTrecho real da aula do curso de Power BI. Comente 2026 que eu te mando as 3 primeiras aulas grátis.\n\n#PowerBI #PowerQuery #QualidadeDeDados #AnaliseDeDados"],
 ['file'=>'aula-trecho-total-repetido.mp4','ig_when'=>'2026-10-02 15:00:00','fb_when'=>'2026-10-02 15:00:00','caption'=>"Total repetido em todas as linhas da matriz no Power BI? O problema é o modelo.\n\nCom duas tabelas fato (cabeçalho e detalhe de vendas), o filtro de Produto chega na SalesDetail mas não chega na SalesHeader — e a medida devolve o total da tabela em toda linha. É contexto de filtro.\n\nTrecho real da aula de modelagem do curso de Power BI. Comente 2026 que eu te mando as 3 primeiras aulas grátis.\n\n#PowerBI #ModelagemDeDados #DAX #ContextoDeFiltro"],
 ['file'=>'aula-trecho-pivotar-nao-precisa.mp4','ig_when'=>'2026-10-03 15:00:00','fb_when'=>'2026-10-03 15:00:00','caption'=>"Tabela dinâmica no Power Query? Na maioria das vezes não precisa.\n\nDeixe o dado no formato tabular e monte a visão dinâmica direto no visual de matriz do Power BI: representante nas linhas, dias nas colunas, horas nos valores. Mais limpo e o modelo continua certo.\n\nTrecho real da aula do curso de Power BI. Comente 2026 que eu te mando as 3 primeiras aulas grátis.\n\n#PowerBI #PowerQuery #Matriz #TabelaDinamica"],
 ['file'=>'aula-trecho-preencher-abaixo.mp4','ig_when'=>'2026-10-04 22:00:00','fb_when'=>'2026-10-04 22:00:00','caption'=>"Coluna cheia de null depois de importar a planilha? Use Preencher abaixo no Power Query.\n\nQuando o Excel tem célula mesclada ou o valor aparece só na primeira linha do grupo, o Preenchimento copia o valor para baixo até o próximo — e a tabela fica no formato tabular certo.\n\nTrecho real da aula do curso de Power BI. Comente 2026 que eu te mando as 3 primeiras aulas grátis.\n\n#PowerBI #PowerQuery #Excel #TratamentoDeDados"],
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
