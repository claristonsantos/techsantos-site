<?php
declare(strict_types=1);
$article = [
 'slug'=>'quebrar-linha-celula-excel-alt-enter','title'=>'Como pular linha no Excel na mesma célula (Alt+Enter)','description'=>'Para pular linha na mesma célula do Excel, aperte Alt+Enter (no Mac, Control+Option+Return). Veja também como quebrar linha com fórmula e por que a segunda linha às vezes não aparece.','minutes'=>3,'video'=>'dica-excel-altenter.mp4',
 'intro'=>'Pressionar Enter normalmente confirma o conteúdo e leva a seleção para outra célula. Quando você precisa organizar endereço, observação ou descrição em várias linhas dentro da mesma célula, o atalho certo é Alt+Enter.',
 'takeaways'=>['Alt+Enter inicia uma nova linha na mesma célula no Excel para Windows.','Entre no modo de edição e posicione o cursor no ponto exato da quebra.','Ative Quebrar Texto Automaticamente se a altura da linha não se ajustar.'],
 'sections'=>[
  ['heading'=>'Como inserir a quebra de linha','paragraphs'=>['Dê dois cliques na célula ou pressione F2 para editar. Posicione o cursor onde a segunda linha deve começar e pressione Alt+Enter. Repita o atalho se quiser criar outras linhas e pressione Enter para concluir a edição.','O conteúdo continua pertencendo a uma única célula. Isso é útil para endereços, instruções curtas e rótulos que precisam ocupar menos largura.']],
  ['heading'=>'Quando o texto não aparece corretamente','paragraphs'=>['Na guia Página Inicial, ative Quebrar Texto Automaticamente. Ajuste também a altura da linha, especialmente se ela tiver sido definida manualmente. Células mescladas podem impedir o ajuste automático esperado.']],
  ['heading'=>'No Mac e com fórmula','paragraphs'=>['No Excel para Mac, o atalho é Control+Option+Return: entre na edição da célula, posicione o cursor e pressione as três teclas juntas.','Para montar a quebra com fórmula, use CARACT(10), que é o caractere de nova linha. Exemplo: =A2&CARACT(10)&B2 junta o conteúdo de A2 e B2 em linhas diferentes da mesma célula. Ative Quebrar Texto Automaticamente na célula da fórmula, senão as duas partes aparecem coladas.']],
  ['heading'=>'Quebra manual ou automática?','paragraphs'=>['Alt+Enter define exatamente onde a linha muda. Quebrar Texto Automaticamente distribui o texto conforme a largura da coluna. Use a quebra manual quando a separação tiver significado; use a automática quando quiser apenas adaptar a exibição.']]],
 'faqs'=>[
  ['question'=>'Qual atalho pula linha dentro da célula?','answer'=>'No Excel para Windows, entre na edição da célula e pressione Alt+Enter.'],
  ['question'=>'A quebra cria outra célula?','answer'=>'Não. As linhas permanecem como parte do conteúdo da mesma célula.'],
  ['question'=>'Por que a segunda linha não aparece?','answer'=>'Ative Quebrar Texto Automaticamente e ajuste a altura da linha.'],
  ['question'=>'Qual o atalho para pular linha na célula no Mac?','answer'=>'No Excel para Mac, use Control+Option+Return durante a edição da célula.'],
  ['question'=>'Dá para pular linha dentro de uma fórmula?','answer'=>'Sim. Use CARACT(10) para inserir a quebra, por exemplo =A2&CARACT(10)&B2, e ative Quebrar Texto Automaticamente.'],
  ['question'=>'Alt+Enter funciona na barra de fórmulas?','answer'=>'Sim. Durante a edição, posicione o cursor no ponto desejado e use o atalho.']],
 'source_url'=>'https://support.microsoft.com/pt-br/accessibility/excel/keyboard-shortcuts-in-excel','source_label'=>'Microsoft Support — Atalhos de teclado no Excel'];
require __DIR__ . '/_excel-tip-template.php';
