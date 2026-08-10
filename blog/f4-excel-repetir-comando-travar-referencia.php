<?php
declare(strict_types=1);
$article = [
 'slug'=>'f4-excel-repetir-comando-travar-referencia','title'=>'F4 no Excel: repetir a última ação e travar referências em fórmulas','description'=>'Conheça dois usos do F4 no Excel: repetir a última ação e alternar referências relativas, absolutas e mistas nas fórmulas.','minutes'=>4,'video'=>'dica-excel-f4.mp4',
 'intro'=>'A tecla F4 resolve duas tarefas diferentes no Excel. Fora da edição de uma fórmula, ela pode repetir a última ação compatível. Dentro da fórmula, alterna rapidamente entre referências relativas, absolutas e mistas.',
 'takeaways'=>['F4 pode repetir ações simples, como uma formatação ou colagem.','Ao editar uma referência, F4 alterna A1, $A$1, A$1 e $A1.','Em alguns notebooks é necessário pressionar Fn+F4.'],
 'sections'=>[
  ['heading'=>'Uso 1: repetir a última ação','paragraphs'=>['Depois de executar uma ação simples, selecione outra célula ou intervalo e pressione F4. O Excel tenta repetir a operação anterior. Isso ajuda ao aplicar a mesma borda, cor, inserção ou exclusão em pontos separados da planilha.','Nem toda operação pode ser repetida. Quando o comando não for compatível, o Excel não executará a ação. Ctrl+Y também repete várias operações.']],
  ['heading'=>'Uso 2: travar referências em fórmulas','paragraphs'=>['Enquanto edita uma fórmula, posicione o cursor sobre A1 e pressione F4. Cada toque percorre $A$1, A$1, $A1 e volta para A1. Assim você define o que deve permanecer fixo ao copiar a fórmula.','A referência absoluta $A$1 fixa coluna e linha. A$1 fixa apenas a linha; $A1 fixa somente a coluna; A1 permite que ambas mudem.']],
  ['heading'=>'Exemplo prático com uma taxa fixa','paragraphs'=>['Se os valores estão em A2:A20 e a taxa está em D1, use =A2*$D$1. Ao copiar a fórmula para baixo, A2 vira A3, A4 e assim por diante, mas a taxa continua apontando para D1.']]],
 'faqs'=>[
  ['question'=>'Por que F4 alterou a fórmula em vez de repetir?','answer'=>'Porque a célula estava em modo de edição e o cursor estava sobre uma referência. Nesse contexto, F4 alterna os tipos de referência.'],
  ['question'=>'F4 funciona em notebook?','answer'=>'Sim, mas alguns teclados exigem Fn+F4 ou a ativação das teclas de função.'],
  ['question'=>'Qual a diferença entre $A$1 e $A1?','answer'=>'$A$1 fixa coluna e linha; $A1 fixa apenas a coluna e deixa a linha variar.'],
  ['question'=>'F4 repete qualquer comando?','answer'=>'Não. Ele repete muitas ações simples, mas algumas operações e funções não são repetíveis.']],
 'source_url'=>'https://support.microsoft.com/pt-PT/Office/foundations-experiences/undo-redo-or-repeat-an-action','source_label'=>'Microsoft Support — Anular, refazer ou repetir uma ação'];
require __DIR__ . '/_excel-tip-template.php';
