<?php
declare(strict_types=1);
$article = [
 'slug'=>'remover-duplicados-excel','title'=>'Como remover dados duplicados no Excel sem apagar registros errados','description'=>'Aprenda a localizar e remover duplicados no Excel, escolhendo corretamente as colunas que definem cada registro.','minutes'=>5,'video'=>'dica-excel-duplicados.mp4',
 'intro'=>'O botão Remover Duplicados é rápido, mas a escolha errada das colunas pode excluir registros válidos. O segredo é decidir primeiro qual conjunto de campos realmente identifica uma repetição na sua base.',
 'takeaways'=>['Faça uma cópia da base antes de remover duplicados.','As colunas marcadas formam a chave usada na comparação.','O Excel mantém a primeira ocorrência e remove as seguintes.'],
 'sections'=>[
  ['heading'=>'Como remover duplicados passo a passo','paragraphs'=>['Selecione uma célula da base e acesse Dados > Remover Duplicados. Confirme se a opção “Meus dados contêm cabeçalhos” está correta e marque apenas as colunas que definem uma duplicidade.','Ao confirmar, o Excel informa quantos valores duplicados foram removidos e quantos valores únicos permaneceram. A primeira ocorrência de cada combinação é preservada.']],
  ['heading'=>'Como escolher as colunas certas','paragraphs'=>['Se você marcar apenas CPF, duas linhas com o mesmo CPF serão consideradas duplicadas, mesmo que tenham datas ou compras diferentes. Para identificar uma transação repetida, talvez seja necessário combinar CPF, data e número do pedido.','Colunas não marcadas não participam da comparação, mas a linha inteira correspondente é removida. Por isso, entenda a granularidade da base antes de executar o comando.']],
  ['heading'=>'Localizar antes de excluir','paragraphs'=>['Se ainda houver dúvida, use Formatação Condicional > Regras de Realce das Células > Valores Duplicados. Assim você visualiza os casos, investiga as diferenças e só depois decide o que apagar.']]],
 'faqs'=>[
  ['question'=>'O Excel mantém qual registro duplicado?','answer'=>'Ele mantém a primeira ocorrência encontrada e remove as ocorrências posteriores da mesma combinação.'],
  ['question'=>'Remover Duplicados apaga a linha inteira?','answer'=>'Sim. As colunas marcadas definem a comparação, mas a remoção afeta toda a linha dentro do intervalo.'],
  ['question'=>'Dá para desfazer a remoção?','answer'=>'Logo após a ação, use Ctrl+Z. Ainda assim, mantenha uma cópia da base por segurança.'],
  ['question'=>'Filtrar valores únicos é a mesma coisa?','answer'=>'Não. O filtro apenas oculta duplicados temporariamente; Remover Duplicados exclui ocorrências do intervalo.']],
 'source_url'=>'https://support.microsoft.com/pt-BR/Excel/get-started/filter-for-unique-values-or-remove-duplicate-values','source_label'=>'Microsoft Support — Filtrar valores exclusivos ou remover valores duplicados'];
require __DIR__ . '/_excel-tip-template.php';
