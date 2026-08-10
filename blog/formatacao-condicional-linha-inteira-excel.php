<?php
declare(strict_types=1);
$article = [
 'slug'=>'formatacao-condicional-linha-inteira-excel','title'=>'Como destacar uma linha inteira com Formatação Condicional no Excel','description'=>'Veja como usar uma fórmula na Formatação Condicional do Excel para colorir a linha inteira quando uma condição for atendida.','minutes'=>5,'video'=>'dica-excel-condicional.mp4',
 'intro'=>'Colorir só a célula que contém “Atrasado” ajuda pouco quando você precisa enxergar o registro completo. Com uma regra baseada em fórmula, o Excel pode destacar a linha inteira assim que o status, a data ou qualquer outro critério for atendido.',
 'takeaways'=>['Selecione toda a área que deve receber a cor antes de criar a regra.','Trave apenas a coluna do critério, como em =$D2="Atrasado".','A linha da fórmula deve corresponder à primeira linha do intervalo selecionado.'],
 'sections'=>[
  ['heading'=>'Como criar a regra para a linha inteira','paragraphs'=>['Selecione o intervalo completo da tabela, sem o cabeçalho. Vá em Página Inicial > Formatação Condicional > Nova Regra > Usar uma fórmula para determinar quais células devem ser formatadas.','Se o status está na coluna D e os dados começam na linha 2, use =$D2="Atrasado". Escolha a cor e confirme. O cifrão mantém a verificação na coluna D, enquanto o número da linha varia em cada registro.']],
  ['heading'=>'Referência mista: o detalhe que faz funcionar','paragraphs'=>['Usar $D$2 travaria também a linha e faria todos os registros dependerem apenas de D2. Usar D2 sem travar a coluna pode deslocar o critério conforme a regra é aplicada horizontalmente. Por isso, a referência mista $D2 é a escolha correta nesse cenário.']],
  ['heading'=>'Condições úteis além de texto','paragraphs'=>['Você pode destacar prazos vencidos com =$E2<HOJE(), valores acima da meta com =$F2>10000 ou linhas incompletas com =CONT.VALORES($A2:$F2)<6. Teste a expressão em uma célula: a regra deve retornar VERDADEIRO para receber a formatação.']]],
 'faqs'=>[
  ['question'=>'Por que somente uma célula ficou colorida?','answer'=>'Provavelmente apenas aquela coluna foi selecionada. Selecione toda a tabela antes de criar ou editar a regra.'],
  ['question'=>'Por que usar o cifrão antes da letra?','answer'=>'Ele fixa a coluna usada como critério, mas permite que o Excel avalie cada linha separadamente.'],
  ['question'=>'Posso usar datas na condição?','answer'=>'Sim. Fórmulas com HOJE(), maior, menor e intervalos de datas funcionam normalmente.'],
  ['question'=>'A regra funciona em Tabela do Excel?','answer'=>'Sim. Verifique apenas se o campo “Aplica-se a” cobre todas as linhas da tabela.']],
 'source_url'=>'https://support.microsoft.com/pt-BR/Excel/use-conditional-formatting-to-highlight-information-in-excel','source_label'=>'Microsoft Support — Usar formatação condicional para realçar informações'];
require __DIR__ . '/_excel-tip-template.php';
