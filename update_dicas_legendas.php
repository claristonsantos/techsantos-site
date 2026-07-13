<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$base = 'https://techsantos.com.br';

$legendas = [
    26 => "Planilha com milhares de linhas e você só precisa de um resumo rápido?\n\nA Tabela Dinâmica do Excel resume, soma, conta e cruza informação sem escrever uma fórmula sequer — você só arrasta os campos que quer ver.\n\nComo usar: selecione os dados, vá em Inserir → Tabela Dinâmica, e arraste os campos pra Linhas, Colunas e Valores. O resumo aparece na hora e atualiza sozinho quando os dados mudam.\n\nÉ a ferramenta mais usada por quem monta relatório todo mês — e a maioria nunca aprendeu direito.\n\nMais dicas de Excel e Power BI: {$base}/servicos.html",
    27 => "Antes de copiar fórmula linha por linha na sua planilha, aperte Control T.\n\nIsso transforma o intervalo selecionado numa Tabela de verdade: a fórmula copia sozinha pra linha nova, o filtro já vem pronto no cabeçalho, e o nome da coluna trava no topo quando você rola a tela pra baixo.\n\nBônus: uma Tabela nomeada facilita muito na hora de usar PROCX, montar uma Tabela Dinâmica ou levar os dados pro Power BI depois.\n\nMais dicas de Excel e Power BI: {$base}/servicos.html",
    28 => "Medida ou coluna calculada no Power BI? A dúvida mais comum de quem tá começando.\n\nColuna calculada roda linha por linha e fica salva no modelo — ocupa espaço, sempre. Medida calcula na hora, só quando o visual pede, e sempre respeitando o filtro que está ativo na tela.\n\nRegra prática: se o cálculo precisa reagir a filtro ou segmentação (a grande maioria dos casos), use medida. Coluna calculada fica pra quando você precisa do resultado linha por linha, tipo uma categoria ou faixa de valor.\n\nMais dicas de Excel e Power BI: {$base}/servicos.html",
    29 => "Modelo travando ou com número duplicado no Power BI? Provavelmente é o relacionamento.\n\nA tabela de dimensão (Produto, Cliente, Data) precisa ter só um valor único por linha — ela fica do lado \"1\" do relacionamento. A tabela de fatos (Vendas, Pedidos) fica do lado \"muitos\", repetindo aquele mesmo produto ou cliente em vários registros.\n\nRelacionamento errado (muitos-pra-muitos sem querer) é a causa mais comum de número de venda duplicado num painel — confira a cardinalidade antes de sair procurando erro na fórmula.\n\nMais dicas de Excel e Power BI: {$base}/servicos.html",
];

$upd = $pdo->prepare("UPDATE social_posts SET legenda = ? WHERE id = ?");
$out = [];
foreach ($legendas as $id => $legenda) {
    $upd->execute([$legenda, $id]);
    $out[] = "Post #{$id}: legenda atualizada ({$upd->rowCount()} linha afetada).";
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
