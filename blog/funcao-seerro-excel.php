<?php
declare(strict_types=1);
$article = [
 'slug'=>'funcao-seerro-excel','title'=>'Função SEERRO no Excel: como tratar erros sem esconder problemas','description'=>'Aprenda a sintaxe da função SEERRO no Excel, veja exemplos práticos e entenda quando não é recomendável ocultar erros.','minutes'=>5,'video'=>'dica-excel-seerro.mp4',
 'intro'=>'Erros como #N/D, #DIV/0! e #VALOR! podem deixar um relatório confuso. A função SEERRO permite mostrar uma mensagem, zero ou célula vazia quando uma fórmula falha — mas deve ser usada sem esconder defeitos reais da base.',
 'takeaways'=>['A sintaxe é =SEERRO(valor; valor_se_erro) no Excel em português.','Se a expressão funcionar, SEERRO devolve o resultado normal.','Trate erros esperados; investigue erros que indicam dados ou fórmulas incorretas.'],
 'sections'=>[
  ['heading'=>'Como usar SEERRO na prática','paragraphs'=>['Envolva a fórmula original com SEERRO. Exemplo: =SEERRO(A2/B2;0) devolve zero quando a divisão gera erro. Em uma busca, =SEERRO(PROCV(E2;A:B;2;FALSO);"Não encontrado") troca o erro por uma mensagem mais clara.','O primeiro argumento é o cálculo testado. O segundo é o valor exibido se ocorrer #N/D, #VALOR!, #REF!, #DIV/0!, #NÚM!, #NOME? ou #NULO!.']],
  ['heading'=>'Quando retornar vazio, zero ou texto','paragraphs'=>['Use "" quando a ausência de resultado não deve aparecer visualmente. Use zero somente quando zero é um significado válido no relatório. Para orientar quem usa a planilha, uma mensagem como “Cadastro não encontrado” costuma ser mais informativa.']],
  ['heading'=>'O risco de esconder todo tipo de erro','paragraphs'=>['SEERRO também mascara referências quebradas e nomes digitados incorretamente. Primeiro valide a fórmula e a origem dos dados; depois trate apenas falhas esperadas. Em modelos críticos, prefira mensagens que revelem a causa em vez de apagar o sinal do problema.']]],
 'faqs'=>[
  ['question'=>'Qual é a sintaxe da função SEERRO?','answer'=>'SEERRO(valor; valor_se_erro). O separador pode ser vírgula em instalações configuradas para outro idioma.'],
  ['question'=>'Como deixar a célula vazia quando houver erro?','answer'=>'Use duas aspas no segundo argumento, por exemplo =SEERRO(A2/B2;"").'],
  ['question'=>'SEERRO trata #N/D?','answer'=>'Sim. Ela trata #N/D e vários outros tipos de erro do Excel.'],
  ['question'=>'SEERRO corrige a fórmula?','answer'=>'Não. Ela apenas substitui o resultado de erro; a causa continua existindo e deve ser investigada.']],
 'source_url'=>'https://support.microsoft.com/pt-pt/excel/functions/iferror-function','source_label'=>'Microsoft Support — Função SE.ERRO'];
require __DIR__ . '/_excel-tip-template.php';
