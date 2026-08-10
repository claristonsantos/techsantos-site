<?php
declare(strict_types=1);
$article = [
 'slug'=>'transpor-linhas-colunas-excel','title'=>'Como transpor linhas e colunas no Excel sem redigitar dados','description'=>'Aprenda a transformar linhas em colunas no Excel usando Colar Transpor e conheça a diferença para a função TRANSPOR.','minutes'=>5,'video'=>'dica-excel-transpor.mp4',
 'intro'=>'Quando uma tabela foi montada na orientação errada, não é preciso copiar célula por célula. O recurso Transpor gira os dados: linhas viram colunas e colunas viram linhas em poucos passos.',
 'takeaways'=>['Copie o intervalo com Ctrl+C; o comando não funciona com Recortar.','Escolha uma área vazia que não se sobreponha à origem.','Colar Transpor cria uma cópia estática; a função TRANSPOR pode manter vínculo com a origem.'],
 'sections'=>[
  ['heading'=>'Como usar Colar Transpor','paragraphs'=>['Selecione todo o intervalo, incluindo rótulos, e pressione Ctrl+C. Clique na célula superior esquerda do destino e escolha Página Inicial > Colar > Transpor, ou abra Colar Especial e marque Transpor.','Garanta espaço suficiente no destino. A área colada substitui dados existentes, e origem e destino não podem se sobrepor.']],
  ['heading'=>'Colar Transpor ou função TRANSPOR?','paragraphs'=>['A colagem cria uma fotografia independente. Se a origem mudar, a cópia não acompanha. Já =TRANSPOR(A1:B4) devolve uma matriz ligada ao intervalo original e, nas versões atuais do Microsoft 365, se expande automaticamente a partir da célula inicial.']],
  ['heading'=>'Cuidados com fórmulas e Tabelas','paragraphs'=>['Ao transpor células com fórmulas, o Excel pode ajustar referências relativas. Revise os resultados ou fixe referências com F4 antes da operação. Se os dados estiverem em uma Tabela do Excel, talvez seja necessário convertê-la em intervalo antes de usar a colagem transposta.']]],
 'faqs'=>[
  ['question'=>'É possível transpor usando Ctrl+X?','answer'=>'Não. Para usar a opção Transpor, copie o intervalo com Ctrl+C.'],
  ['question'=>'A cópia transposta atualiza quando a origem muda?','answer'=>'Não. Para manter vínculo, use a função TRANSPOR em vez de Colar Transpor.'],
  ['question'=>'Posso transpor fórmulas?','answer'=>'Sim, mas referências relativas podem mudar conforme a nova posição; revise o resultado.'],
  ['question'=>'O que a função TRANSPOR faz?','answer'=>'Ela retorna um intervalo vertical como horizontal, ou um intervalo horizontal como vertical.']],
 'source_url'=>'https://support.microsoft.com/pt-br/excel/transpose-rotate-data-from-rows-to-columns-or-vice-versa','source_label'=>'Microsoft Support — Transpor dados de linhas para colunas ou vice-versa'];
require __DIR__ . '/_excel-tip-template.php';
