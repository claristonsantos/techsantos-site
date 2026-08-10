<?php
declare(strict_types=1);
$article = [
 'slug'=>'congelar-paineis-excel','title'=>'Como congelar linhas e colunas no Excel do jeito certo','description'=>'Aprenda a usar Congelar Painéis no Excel para manter cabeçalhos e colunas visíveis enquanto navega por planilhas grandes.','minutes'=>4,'video'=>'dica-excel-congelarpaineis.mp4',
 'intro'=>'Em uma planilha grande, perder o cabeçalho enquanto rola os dados aumenta o risco de interpretar a coluna errada. Congelar Painéis mantém linhas e colunas importantes visíveis durante a navegação.',
 'takeaways'=>['O Excel congela as linhas acima e as colunas à esquerda da célula selecionada.','Para manter a primeira linha e a primeira coluna, selecione B2.','Use Exibir > Congelar Painéis > Descongelar Painéis para voltar ao normal.'],
 'sections'=>[
  ['heading'=>'Como congelar linha e coluna ao mesmo tempo','paragraphs'=>['Selecione a célula que fica abaixo das linhas e à direita das colunas que deseja manter. Para congelar a linha 1 e a coluna A, selecione B2. Depois acesse Exibir > Congelar Painéis > Congelar Painéis.','Para manter duas linhas e três colunas, selecione D3: tudo que estiver acima e à esquerda dessa célula permanecerá visível.']],
  ['heading'=>'Linha superior e primeira coluna','paragraphs'=>['O menu também oferece Congelar Linha Superior e Congelar Primeira Coluna. Essas opções são rápidas quando você precisa fixar somente um dos lados, sem calcular a célula de referência.']],
  ['heading'=>'Por que o painel congelou no lugar errado','paragraphs'=>['O comando considera a célula ativa no momento da execução. Descongele, selecione a célula correta e aplique novamente. Linhas ou colunas ocultas também podem tornar o resultado visualmente confuso, então revise a estrutura antes.']]],
 'faqs'=>[
  ['question'=>'Como congelar a primeira linha e a primeira coluna?','answer'=>'Selecione B2 e use Exibir > Congelar Painéis > Congelar Painéis.'],
  ['question'=>'Como congelar duas linhas?','answer'=>'Selecione uma célula na terceira linha e aplique Congelar Painéis.'],
  ['question'=>'Por que a opção está desativada?','answer'=>'Verifique o modo de exibição e se a pasta está em uma condição que restringe o comando.'],
  ['question'=>'Como desfazer o congelamento?','answer'=>'Vá em Exibir > Congelar Painéis > Descongelar Painéis.']],
 'source_url'=>'https://support.microsoft.com/pt-BR/Excel/get-started/freeze-panes-to-lock-rows-and-columns','source_label'=>'Microsoft Support — Congelar painéis para bloquear linhas e colunas'];
require __DIR__ . '/_excel-tip-template.php';
