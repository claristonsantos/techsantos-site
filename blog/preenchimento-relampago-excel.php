<?php
declare(strict_types=1);
$article = [
 'slug'=>'preenchimento-relampago-excel','title'=>'Preenchimento Relâmpago no Excel: separe e combine dados com Ctrl+E','description'=>'Aprenda a usar o Preenchimento Relâmpago do Excel com Ctrl+E para separar nomes, combinar textos e padronizar dados sem fórmulas.','minutes'=>4,'video'=>'dica-excel-flashfill.mp4',
 'intro'=>'Separar nome e sobrenome, extrair números ou padronizar códigos não precisa virar uma sequência enorme de fórmulas. Quando existe um padrão claro, o Preenchimento Relâmpago entende o exemplo que você digitou e completa o restante da coluna em segundos.',
 'takeaways'=>['Digite um ou dois exemplos do resultado esperado e pressione Ctrl+E.','O recurso funciona melhor quando os dados de origem seguem um padrão consistente.','Confira algumas linhas antes de aceitar o resultado: o preenchimento reconhece padrões, mas não interpreta intenção.'],
 'sections'=>[
  ['heading'=>'Como usar o Preenchimento Relâmpago passo a passo','paragraphs'=>['Crie uma coluna ao lado dos dados originais e digite manualmente o primeiro resultado. Se a coluna A contém “Maria Santos”, por exemplo, digite “Maria” na coluna B. Selecione a próxima célula e pressione Ctrl+E. O Excel identifica o padrão e preenche as linhas seguintes.','Você também pode acessar Dados > Preenchimento Relâmpago. Se o resultado não aparecer, forneça mais um exemplo para eliminar ambiguidades.']],
  ['heading'=>'Onde esse recurso economiza mais tempo','paragraphs'=>['Use para separar nome e sobrenome, extrair DDD de telefones, retirar prefixos, combinar código e descrição ou uniformizar textos. Ele é especialmente útil na limpeza inicial de listas recebidas de outros sistemas.','O resultado é texto estático. Se a origem mudar depois, a coluna preenchida não será recalculada automaticamente; nesse caso, fórmulas ou Power Query são opções melhores.']],
  ['heading'=>'Como evitar resultados errados','paragraphs'=>['Revise o começo, o meio e o fim da lista. Registros fora do padrão, nomes compostos e campos vazios podem gerar interpretações diferentes. Preserve a coluna original até terminar a conferência.']]],
 'faqs'=>[
  ['question'=>'Qual é o atalho do Preenchimento Relâmpago?','answer'=>'No Excel para Windows, use Ctrl+E depois de digitar um exemplo do resultado desejado.'],
  ['question'=>'O Preenchimento Relâmpago usa fórmula?','answer'=>'Não. Ele grava valores com base no padrão detectado e não se atualiza quando a origem muda.'],
  ['question'=>'Por que o Ctrl+E não funcionou?','answer'=>'O padrão pode estar ambíguo ou o recurso pode estar desativado. Digite mais um exemplo e verifique as opções avançadas do Excel.'],
  ['question'=>'Posso usar em milhares de linhas?','answer'=>'Sim, mas revise amostras da coluna e mantenha uma cópia da base original antes de substituir dados.']],
 'source_url'=>'https://support.microsoft.com/pt-BR/Excel/using-flash-fill-in-excel','source_label'=>'Microsoft Support — Usar o Preenchimento Relâmpago no Excel'];
require __DIR__ . '/_excel-tip-template.php';
