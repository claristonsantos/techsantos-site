<?php
declare(strict_types=1);
$article = [
 'slug'=>'nomear-intervalos-excel','title'=>'Como nomear intervalos no Excel e deixar fórmulas mais fáceis','description'=>'Veja como criar nomes para células e intervalos no Excel e usar referências legíveis em fórmulas e relatórios.','minutes'=>5,'video'=>'dica-excel-nomearintervalo.mp4',
 'intro'=>'Uma fórmula como =SOMA(C2:C500) funciona, mas não explica o que está somando. Ao nomear o intervalo como Vendas, a expressão vira =SOMA(Vendas): mais fácil de ler, revisar e manter.',
 'takeaways'=>['Selecione o intervalo, digite o nome na Caixa de Nome e pressione Enter.','Nomes não podem conter espaços; use sublinhado ou palavras unidas.','Gerencie referências em Fórmulas > Gerenciador de Nomes.'],
 'sections'=>[
  ['heading'=>'Como criar e usar um nome','paragraphs'=>['Selecione a célula ou o intervalo. Clique na Caixa de Nome, à esquerda da barra de fórmulas, digite um nome como MetaMensal e pressione Enter. Depois, use esse nome em fórmulas: =B2*MetaMensal ou =SOMA(Vendas).','O nome deve começar com letra, sublinhado ou barra invertida. Evite nomes que pareçam referências de célula, como A1, e escolha termos claros para outras pessoas entenderem.']],
  ['heading'=>'Escopo e Gerenciador de Nomes','paragraphs'=>['Um nome pode valer para toda a pasta de trabalho ou somente para uma planilha. No Gerenciador de Nomes você confere o escopo, edita a referência, identifica erros e exclui nomes que não são mais usados.']],
  ['heading'=>'Quando nomes melhoram a planilha','paragraphs'=>['Eles são úteis para taxas, metas, listas de validação e intervalos usados repetidamente. Em bases que crescem, considere transformar os dados em Tabela do Excel, pois as referências estruturadas acompanham novas linhas com mais facilidade.']]],
 'faqs'=>[
  ['question'=>'Nome de intervalo pode ter espaço?','answer'=>'Não. Use sublinhado, ponto ou una as palavras, como Taxa_Anual ou TaxaAnual.'],
  ['question'=>'Como editar um nome criado?','answer'=>'Abra Fórmulas > Gerenciador de Nomes, selecione o item e altere nome, escopo ou referência.'],
  ['question'=>'Posso usar nomes em qualquer fórmula?','answer'=>'Sim. Nomes podem representar células, intervalos, constantes e até fórmulas.'],
  ['question'=>'Nomear intervalo faz ele crescer sozinho?','answer'=>'Um intervalo fixo não cresce automaticamente. Para bases expansíveis, use uma Tabela do Excel ou um nome dinâmico.']],
 'source_url'=>'https://support.microsoft.com/pt-br/excel/get-started/define-and-use-names-in-formulas','source_label'=>'Microsoft Support — Definir e usar nomes em fórmulas'];
require __DIR__ . '/_excel-tip-template.php';
