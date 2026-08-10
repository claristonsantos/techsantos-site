<?php
declare(strict_types=1);
$article = [
 'slug'=>'selecionar-linha-coluna-excel-atalho','title'=>'Como selecionar linhas e colunas inteiras no Excel sem usar o mouse','description'=>'Use Ctrl+Espaço e Shift+Espaço para selecionar colunas e linhas inteiras no Excel e trabalhar mais rápido pelo teclado.','minutes'=>3,'video'=>'dica-excel-selecaorapida.mp4',
 'intro'=>'Levar o ponteiro até as letras e números da planilha toda vez quebra o ritmo. Dois atalhos simples selecionam a coluna ou a linha inteira a partir da célula ativa e deixam formatação, inserção e exclusão muito mais rápidas.',
 'takeaways'=>['Ctrl+Espaço seleciona a coluna inteira.','Shift+Espaço seleciona a linha inteira.','Combine os atalhos com Ctrl, Shift e teclas de direção para ampliar seleções.'],
 'sections'=>[
  ['heading'=>'Os dois atalhos essenciais','paragraphs'=>['Clique em qualquer célula e pressione Ctrl+Espaço para selecionar toda a coluna. Pressione Shift+Espaço para selecionar toda a linha. Depois, aplique formatação, copie, oculte ou use o menu de contexto sem tocar no mouse.','Dentro de uma Tabela do Excel, o primeiro Ctrl+Espaço pode selecionar somente os dados da coluna da tabela; pressionar novamente amplia a seleção.']],
  ['heading'=>'Como selecionar blocos grandes de dados','paragraphs'=>['Ctrl+Shift+Seta estende a seleção até a última célula preenchida na direção escolhida, ou até o próximo bloco quando há vazios. Shift+Seta amplia a seleção uma célula por vez.','Para selecionar a região atual ou a planilha inteira, use Ctrl+A; em algumas situações, pressionar novamente expande o alcance.']],
  ['heading'=>'Um cuidado antes de excluir','paragraphs'=>['Ao selecionar uma linha ou coluna inteira, comandos de exclusão e formatação afetam todas as células da planilha naquela direção. Confirme a seleção destacada antes de executar ações irreversíveis.']]],
 'faqs'=>[
  ['question'=>'Qual atalho seleciona uma coluna inteira?','answer'=>'Ctrl+Barra de espaços seleciona a coluna da célula ativa.'],
  ['question'=>'Qual atalho seleciona uma linha inteira?','answer'=>'Shift+Barra de espaços seleciona a linha da célula ativa.'],
  ['question'=>'Como selecionar até o fim dos dados?','answer'=>'Use Ctrl+Shift junto com a tecla de direção desejada.'],
  ['question'=>'Os atalhos funcionam no Excel para Mac?','answer'=>'Há equivalentes no Mac, mas algumas combinações usam Command e podem variar conforme o teclado.']],
 'source_url'=>'https://support.microsoft.com/pt-br/accessibility/excel/keyboard-shortcuts-in-excel','source_label'=>'Microsoft Support — Atalhos de teclado no Excel'];
require __DIR__ . '/_excel-tip-template.php';
