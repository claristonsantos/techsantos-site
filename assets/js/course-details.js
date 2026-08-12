const COURSE_DETAILS = {
  'apresentacao-curso': [
    { h: 'Como estudar para realmente aprender', p: 'Assista a cada vídeo com o Power BI aberto e repita a operação. Depois feche o vídeo e refaça sem ajuda. Marcar uma aula como concluída deve significar que você consegue explicar o conceito e reproduzir o resultado.' },
    { h: 'Rotina recomendada', items: ['Assista ao vídeo completo uma vez.', 'Repita usando o arquivo da aula.', 'Anote dúvidas e termos novos.', 'Faça a atividade sem consultar o vídeo.', 'Confira o resultado e registre o que errou.', 'Realize a avaliação antes de avançar.'] },
    { h: 'Resultado esperado do curso', p: 'Ao final, você deverá conseguir receber uma fonte de dados, tratá-la, construir um esquema estrela, criar medidas DAX, desenvolver páginas analíticas, publicar com segurança e explicar as decisões tomadas.' }
  ],
  'introducao': [
    { h: 'O fluxo completo de um projeto', items: ['Entender a pergunta de negócio.', 'Conectar e inspecionar as fontes.', 'Limpar e padronizar no Power Query.', 'Modelar fatos, dimensões e relacionamentos.', 'Criar medidas DAX.', 'Desenhar os visuais.', 'Validar números.', 'Publicar, proteger e manter.'] },
    { h: 'Por que a ordem importa', p: 'Um visual não corrige um dado mal tratado; DAX complexo não compensa um modelo ruim. Cada etapa cria a base da seguinte. Quando o resultado estiver errado, volte pelo fluxo: fonte, transformação, modelo, medida e visual.' },
    { h: 'Exercício de reflexão', p: 'Escolha um relatório que você já utiliza e descreva: qual decisão ele apoia, quais fontes utiliza, quem é o público e quais três indicadores são indispensáveis.' }
  ],
  'normalizacao-desnormalizacao': [
    { h: 'Normalização na origem', p: 'Em sistemas transacionais, Cliente, Endereço, Pedido e Item costumam ficar separados. Isso reduz repetição e evita atualizar o mesmo endereço em centenas de pedidos. É adequado para registrar operações, mas pode ser complexo para análise.' },
    { h: 'Desnormalização para análise', p: 'Em BI, atributos relacionados podem ser reunidos em uma dimensão mais amigável, como dProduto contendo produto, marca, categoria e departamento. O objetivo não é copiar tudo para uma tabela única, e sim reduzir complexidade sem perder a granularidade.' },
    { h: 'Erros comuns', items: ['Criar uma tabela única com colunas de granularidades diferentes.', 'Levar dezenas de tabelas normalizadas diretamente ao usuário.', 'Duplicar valores de fatos durante mesclas.', 'Desnormalizar sem validar tamanho e cardinalidade.', 'Confundir dimensão larga com tabela fato única.'] }
  ],
  'modelagem-pratica': [
    { h: 'Entidades do cenário de vendas', p: 'Cliente, Produto, Vendedor e Data descrevem o contexto; Venda registra o evento. Cada dimensão possui uma chave única. A fato guarda essas chaves, quantidade, preço, custo e outros valores do evento.' },
    { h: 'Montagem passo a passo', items: ['Declare a granularidade da fato.', 'Crie uma chave única em cada dimensão.', 'Remova duplicidades das dimensões somente após validar a chave.', 'Relacione dimensão 1 com fato muitos.', 'Use filtro em direção única.', 'Oculte chaves técnicas.', 'Teste uma medida simples por cada dimensão.'] },
    { h: 'Validação', p: 'Crie uma tabela com Cliente, Produto e Faturamento. Se os valores repetirem iguais para todas as linhas, o filtro não está chegando à fato. Se o total aumentar após a modelagem, investigue duplicidades e granularidade.' }
  ],
  'esquema-estrela': [
    { h: 'Tabela fato', p: 'Registra eventos mensuráveis em uma granularidade definida: uma linha por item vendido, atendimento ou movimentação. Contém chaves para dimensões e valores como quantidade, receita, custo e duração.' },
    { h: 'Tabela dimensão', p: 'Descreve quem, o quê, quando, onde e como. Possui chave única e atributos usados para filtrar e agrupar, como categoria, região, segmento e calendário.' },
    { h: 'Checklist do esquema estrela', items: ['Fato central com granularidade documentada.', 'Dimensões com chaves únicas.', 'Relacionamentos 1:* da dimensão para a fato.', 'Ausência de relações diretas entre fatos.', 'Medidas criadas sobre valores da fato.', 'Campos técnicos ocultos.', 'Dimensão calendário relacionada à data correta.'] }
  ],
  'importancia-modelagem': [
    { h: 'Modelo ruim, DAX difícil', p: 'Quando dimensões não filtram corretamente a fato, surgem fórmulas com filtros manuais, LOOKUPVALUE, CROSSJOIN ou tratamentos repetidos. Antes de aumentar a complexidade da medida, verifique se o modelo representa corretamente o negócio.' },
    { h: 'Duas tabelas fato', p: 'Compras e Vendas devem normalmente permanecer separadas, compartilhando dimensões Produto, Data e Unidade. Cabeçalho e Itens do mesmo evento podem exigir combinação no Power Query, dependendo da granularidade desejada.' },
    { h: 'Decisão prática', items: ['Mesma entidade e mesma granularidade: considere acrescentar.', 'Mesma entidade em granularidades diferentes: modele separadamente ou transforme conscientemente.', 'Eventos diferentes: mantenha fatos separadas.', 'Nunca ligue fatos diretamente apenas para fazer o filtro funcionar.', 'Use dimensões conformadas para analisar fatos em conjunto.'] }
  ],
  'criando-consulta': [
    { h: 'Conectar não é carregar', p: 'A tela de navegação apresenta uma prévia. Escolher “Transformar Dados” permite conferir entidade, cabeçalhos, tipos e linhas antes de levar a fonte ao modelo. “Carregar” direto deve ser exceção para fontes já controladas.' },
    { h: 'Primeira inspeção', items: ['Confirme arquivo, planilha ou tabela correta.', 'Verifique quantidade de colunas.', 'Localize cabeçalhos e rodapés.', 'Observe tipos sugeridos.', 'Identifique linhas vazias e totais.', 'Confirme a granularidade.', 'Escolha um nome descritivo para a consulta.'] },
    { h: 'Erro comum', p: 'Conectar ao arquivo certo, mas selecionar a planilha errada ou um intervalo usado. Prefira Tabelas do Excel nomeadas quando disponíveis, pois elas expandem com novas linhas.' }
  ],
  'intro-power-query': [
    { h: 'ETL na prática', p: 'Extrair é conectar à fonte; transformar é limpar, combinar e aplicar regras; carregar é entregar o resultado ao modelo ou destino. Cada etapa deve ser reaplicável quando a fonte mudar.' },
    { h: 'Passos aplicados', p: 'O Power Query gera código M para cada ação. A ordem importa: renomear uma coluna e depois referenciar o nome antigo causa erro. Clique em cada etapa para observar como a tabela evolui.' },
    { h: 'Boas perguntas', items: ['Esta regra pertence à fonte, ao Power Query ou ao DAX?', 'A etapa funciona com novos arquivos?', 'O nome da coluna pode mudar?', 'A transformação preserva query folding?', 'O resultado final possui somente as colunas necessárias?'] }
  ],
  'tipos-de-dados': [
    { h: 'Tipos determinam comportamento', p: 'Texto não soma; data permite hierarquia e inteligência de tempo; número decimal pode sofrer arredondamento; decimal fixo é adequado a valores monetários em muitos cenários. Uma chave numérica não deve ser somada apenas por ser número.' },
    { h: 'Localidade', p: 'O texto “01/02/2026” pode significar 1º de fevereiro ou 2 de janeiro. Use “Alterar tipo usando localidade” quando datas e decimais vierem em padrão diferente do computador.' },
    { h: 'Checklist', items: ['Datas realmente convertidas para data.', 'Valores monetários com tipo adequado.', 'Percentuais armazenados como decimal e formatados como percentual.', 'Códigos com zeros à esquerda mantidos como texto.', 'Erros de conversão inspecionados antes de remover.'] }
  ],
  'tabela-ou-intervalo': [
    { h: 'Por que usar Tabela do Excel', p: 'Uma Tabela criada com Ctrl+T possui nome, cabeçalhos e expansão automática. Quando novas linhas são inseridas, a consulta inclui o novo intervalo sem alterar o código.' },
    { h: 'Preparação da fonte', items: ['Uma linha de cabeçalho.', 'Uma coluna para cada atributo.', 'Sem células mescladas.', 'Sem subtotais no meio da base.', 'Sem linhas e colunas vazias decorativas.', 'Nome da tabela representando seu conteúdo.'] },
    { h: 'Teste', p: 'Adicione uma nova linha abaixo da tabela, atualize a consulta e confirme que ela foi carregada. Repita com uma linha fora da tabela para perceber a diferença.' }
  ],
  'importar-excel': [
    { h: 'Arquivos não tabulares', p: 'Relatórios exportados podem ter título, data de emissão, cabeçalhos em várias linhas, totais e notas. Remova estruturas de apresentação até obter uma tabela em que todas as linhas representem a mesma entidade.' },
    { h: 'Sequência de limpeza', items: ['Remover linhas superiores.', 'Promover cabeçalhos corretos.', 'Remover colunas totalmente vazias.', 'Preencher valores de células mescladas.', 'Excluir rodapés e totais.', 'Definir tipos.', 'Renomear a consulta.', 'Validar contagem e soma.'] },
    { h: 'Robustez', p: 'Evite remover “exatamente 3 linhas” se o relatório pode ganhar uma linha de título. Quando possível, filtre por um marcador estável ou trabalhe com uma tabela nomeada na origem.' }
  ],
  'consulta-pasta': [
    { h: 'Quando usar', p: 'Use quando vários arquivos possuem a mesma estrutura, como vendas_2026_01.xlsx, vendas_2026_02.xlsx e vendas_2026_03.xlsx. Um novo arquivo passa a participar na próxima atualização.' },
    { h: 'Cuidados', items: ['Manter apenas extensões esperadas.', 'Excluir arquivos temporários iniciados por ~$.', 'Garantir mesmas colunas e tipos.', 'Preservar o nome do arquivo como coluna de auditoria.', 'Testar arquivo vazio ou diferente.', 'Não colocar arquivos de saída na mesma pasta da entrada.'] },
    { h: 'Consulta de exemplo', p: 'O Power Query cria uma função baseada em um arquivo de amostra. Alterações feitas nessa transformação são aplicadas a cada binário. Se um arquivo tiver estrutura diferente, identifique-o pela coluna Name antes de ocultar erros.' }
  ],
  'consulta-pasta-sharepoint': [
    { h: 'URL correta', p: 'Use a URL do site do SharePoint, não o link de compartilhamento de um arquivo. Depois filtre Folder Path e Name para chegar à biblioteca e pasta desejadas.' },
    { h: 'Diferença para pasta local', p: 'O SharePoint é acessível pelo serviço usando credenciais organizacionais, reduzindo dependência de um computador e, em muitos casos, dispensando gateway para arquivos na nuvem.' },
    { h: 'Erros comuns', items: ['Usar link com parâmetros de compartilhamento.', 'Filtrar somente pelo nome e capturar arquivos de outras pastas.', 'Ignorar arquivos ocultos.', 'Misturar estruturas diferentes.', 'Publicar sem configurar credenciais da fonte no serviço.'] }
  ],
  'preenchimento-colunas': [
    { h: 'Preencher para baixo e para cima', p: 'Preencher para baixo copia o último valor não vazio até encontrar outro valor. Preencher para cima usa o próximo valor. A escolha depende da estrutura visual da planilha de origem.' },
    { h: 'Exemplo', p: 'Em uma planilha, “Sudeste” aparece apenas na primeira linha e as cidades seguintes estão abaixo com Região vazia. Preencher para baixo transforma cada linha em um registro completo.' },
    { h: 'Cuidado', items: ['Ordene somente se a ordem fizer parte da regra.', 'Não preencha vazios que significam “não informado”.', 'Confirme onde cada grupo começa e termina.', 'Valide contagem por grupo depois da operação.'] }
  ],
  'dividir-colunas': [
    { h: 'Métodos disponíveis', p: 'É possível dividir por delimitador, número de caracteres, posições, transição entre letras e dígitos ou mudanças de maiúsculas. Escolha o método que representa uma regra estável da fonte.' },
    { h: 'Exemplo', p: 'O código “GO-00125” pode virar UF e Código usando hífen. Já CPF ou código fixo pode ser dividido por posições. Nome completo raramente deve ser dividido apenas pelo primeiro espaço sem validar nomes compostos.' },
    { h: 'Validação', items: ['Conte delimitadores inesperados.', 'Defina comportamento para delimitadores extras.', 'Remova espaços nas novas colunas.', 'Aplique tipos após dividir.', 'Mantenha a coluna original até validar o resultado.'] }
  ],
  'dividir-linhas': [
    { h: 'Mudança de granularidade', p: 'Dividir uma célula em linhas aumenta a quantidade de registros. Um pedido com três produtos em texto passa a ter três linhas; valores do pedido serão repetidos e não devem ser somados sem ajuste.' },
    { h: 'Exemplo', p: 'A célula “Excel;Power BI;Fabric” pode virar três linhas para contar interesses por tema. Depois remova espaços, padronize maiúsculas e valide a contagem.' },
    { h: 'Checklist', items: ['Registrar linhas antes e depois.', 'Definir delimitador.', 'Tratar valores vazios.', 'Revisar colunas numéricas repetidas.', 'Confirmar a nova granularidade.'] }
  ],
  'colunas-personalizadas': [
    { h: 'Linguagem M', p: 'A coluna personalizada avalia uma expressão para cada linha. Referencie colunas entre colchetes, textos entre aspas e use funções como Text, Date e Number conforme o tipo.' },
    { h: 'Exemplo', p: 'if [Valor] >= 1000 then “Alto” else “Baixo” cria uma classificação. Antes, confirme que Valor é numérico e decida como tratar nulos.' },
    { h: 'Erros comuns', items: ['Nome de coluna digitado incorretamente.', 'Comparar texto com número.', 'Não tratar null.', 'Misturar tipos no then e else.', 'Colocar regra que seria melhor como medida dinâmica em DAX.'] }
  ],
  'coluna-exemplo': [
    { h: 'Como funciona', p: 'Você fornece uma ou mais saídas e o Power Query tenta inferir o padrão. A fórmula gerada deve ser revisada; exemplos insuficientes podem produzir uma regra que funciona apenas nas primeiras linhas.' },
    { h: 'Quando é útil', p: 'Extrair primeiro nome, combinar campos, padronizar códigos e converter formatos simples. Para regra crítica ou complexa, prefira expressão explícita e documentada.' },
    { h: 'Teste do padrão', items: ['Forneça exemplos diferentes.', 'Inclua caso com vazio.', 'Inclua texto curto e longo.', 'Revise a fórmula criada.', 'Filtre resultados inesperados.', 'Confirme comportamento com novos dados.'] }
  ],
  'mesclar-colunas': [
    { h: 'Mesclar é concatenar', p: 'A operação combina valores da mesma linha. Escolha um separador que não gere ambiguidade, como “Estado - Cidade”, e defina como nulos serão tratados.' },
    { h: 'Chaves concatenadas', p: 'Concatenar colunas para criar chave pode ser necessário, mas exige separador e padronização. “1” + “23” e “12” + “3” geram o mesmo texto sem delimitador. Prefira chave da origem quando confiável.' },
    { h: 'Checklist', items: ['Converter tipos para texto.', 'Aplicar Trim e padronização.', 'Escolher delimitador seguro.', 'Verificar nulos.', 'Testar unicidade se o resultado for chave.'] }
  ],
  'classificar-filtrar': [
    { h: 'Filtro como regra de carga', p: 'Filtrar no Power Query remove dados do modelo inteiro. Filtrar no relatório apenas muda a visualização. Use Power Query quando o registro realmente não deve ser carregado.' },
    { h: 'Classificação não garante ordem final', p: 'Ordenar na consulta pode ser necessário para preencher ou remover duplicidades mantendo um registro específico, mas não define automaticamente a ordem dos visuais.' },
    { h: 'Cuidados', items: ['Documentar filtros de status.', 'Evitar datas fixas quando o período deve avançar.', 'Preservar registros necessários para auditoria.', 'Validar quantidade removida.', 'Aproveitar filtros cedo para favorecer query folding.'] }
  ],
  'formula-if': [
    { h: 'Estrutura', p: 'Em M: if condição then resultado else resultado. A expressão deve sempre possuir else e os resultados devem preferencialmente ter o mesmo tipo.' },
    { h: 'Exemplo', p: 'if [Vencimento] < Date.From(DateTime.LocalNow()) and [Pago] = false then “Vencido” else “Regular”. A ordem e o tratamento de null precisam ser definidos.' },
    { h: 'Erros comuns', items: ['Usar IF em maiúsculo como no Excel.', 'Esquecer else.', 'Comparar tipos diferentes.', 'Não tratar nulos.', 'Criar faixas em ordem que captura casos antes da hora.'] }
  ],
  'formula-if-and': [
    { h: 'AND e OR', p: 'and exige que todas as condições sejam verdadeiras; or exige pelo menos uma. Use parênteses para deixar clara a precedência quando combinar várias condições.' },
    { h: 'Exemplo', p: 'if [Valor] >= 1000 and [Margem] >= 0.2 then “Prioritário” else “Normal”. Com or, bastaria atender uma das duas regras.' },
    { h: 'Tabela de decisão', items: ['Liste combinações possíveis.', 'Defina resultado esperado para cada uma.', 'Teste limites exatos.', 'Inclua nulos.', 'Revise se a regra pertence à preparação ou deve responder aos filtros em DAX.'] }
  ],
  'formula-adddays': [
    { h: 'Operações com datas', p: 'Date.AddDays adiciona ou subtrai dias corridos. Para dias úteis, feriados ou calendários específicos, é necessária uma tabela calendário e uma regra mais completa.' },
    { h: 'Exemplo', p: 'Date.AddDays([DataPedido], 7) calcula prazo corrido de sete dias. Se DataPedido puder ser null, trate antes para evitar erro.' },
    { h: 'Validação', items: ['Confirmar tipo date.', 'Testar virada de mês e ano.', 'Decidir dias corridos ou úteis.', 'Tratar datas vazias.', 'Verificar fuso quando usar DateTime.'] }
  ],
  'formulas-texto': [
    { h: 'Limpeza básica', p: 'Text.Trim remove espaços nas extremidades; Text.Clean remove caracteres de controle; Text.Upper/Lower padroniza caixa. Aplique antes de mesclar ou comparar chaves textuais.' },
    { h: 'Exemplo', p: '“ goiânia ”, “GOIÂNIA” e “Goiânia” podem representar a mesma cidade. Padronização reduz categorias duplicadas, mas não corrige automaticamente diferenças de acento ou grafia.' },
    { h: 'Cuidados', items: ['Preservar zeros à esquerda.', 'Não alterar códigos sensíveis à caixa sem confirmar.', 'Tratar null.', 'Padronizar antes de remover duplicidades.', 'Manter valor original quando a limpeza for crítica para auditoria.'] }
  ],
  'coluna-dinamica': [
    { h: 'Pivotar', p: 'Transforma valores de uma coluna em novos cabeçalhos. Outra coluna fornece os valores e uma função de agregação resolve combinações repetidas.' },
    { h: 'Exemplo', p: 'Linhas com Produto, Mês e Valor podem virar uma coluna por mês. Para modelagem analítica, muitas vezes o formato longo original é melhor; pivote somente quando o requisito realmente exigir.' },
    { h: 'Erros comuns', items: ['Escolher “Não agregar” quando existem duplicidades.', 'Criar centenas de colunas.', 'Pivotar categorias que mudam todo mês.', 'Perder granularidade ao usar soma sem revisar.'] }
  ],
  'transformar-colunas-linhas': [
    { h: 'Despivotar', p: 'Converte colunas repetidas de período ou categoria em pares Atributo–Valor. É essencial para transformar Jan, Fev e Mar em uma coluna Mês e outra Valor.' },
    { h: 'Por que melhora o modelo', p: 'Novos meses entram como linhas, não exigem novas colunas ou medidas. Uma única dimensão de data consegue filtrar o histórico.' },
    { h: 'Checklist', items: ['Selecionar colunas identificadoras.', 'Usar “Anular dinamização de outras colunas”.', 'Renomear Atributo e Valor.', 'Converter período para data.', 'Validar soma antes e depois.'] }
  ],
  'agrupar-por': [
    { h: 'Agregação', p: 'Agrupar Por reduz várias linhas a uma linha por combinação de chaves, calculando soma, média, mínimo, máximo, contagem ou todas as linhas.' },
    { h: 'Exemplo', p: 'Uma base diária pode ser agrupada por Produto e Mês para obter faturamento mensal. Isso muda a granularidade; depois não será possível analisar por dia sem retornar à fonte detalhada.' },
    { h: 'Cuidados', items: ['Definir as colunas de grupo.', 'Escolher agregação coerente.', 'Não somar percentuais ou preços médios.', 'Registrar granularidade resultante.', 'Comparar totais antes e depois.'] }
  ],
  'acrescentar-consultas-1': [
    { h: 'Acrescentar empilha linhas', p: 'Use quando tabelas representam a mesma entidade e possuem colunas equivalentes, como vendas de janeiro e fevereiro. É semelhante a UNION ALL: não procura correspondência por chave.' },
    { h: 'Preparação', items: ['Padronizar nomes de colunas.', 'Padronizar tipos.', 'Criar coluna de origem.', 'Confirmar mesma granularidade.', 'Remover totais e cabeçalhos extras.', 'Validar soma individual e consolidada.'] },
    { h: 'Diferença para mesclar', p: 'Acrescentar aumenta linhas. Mesclar aumenta colunas ao localizar uma chave correspondente. Escolher a operação errada é uma das causas mais comuns de duplicidade.' }
  ],
  'acrescentar-consultas-2': [
    { h: 'Colunas ausentes', p: 'Quando uma consulta não possui determinada coluna, o resultado acrescentado recebe null naquele campo. Isso pode ser aceitável, mas precisa ser consciente e monitorado.' },
    { h: 'Consolidação robusta', p: 'Crie uma consulta de função ou staging que entregue o mesmo esquema para cada origem antes de acrescentar. Assim alterações são tratadas em um único lugar.' },
    { h: 'Testes', items: ['Linhas finais iguais à soma das origens.', 'Totais financeiros conciliados.', 'Tipos preservados.', 'Origem identificável.', 'Nenhum arquivo duplicado.', 'Novas colunas avaliadas antes de carregar.'] }
  ],
  'mesclar-consultas': [
    { h: 'Mesclar usa uma chave', p: 'A operação corresponde a JOIN de banco de dados ou a um PROCV mais completo. A chave pode ter uma ou várias colunas e precisa ter mesmo tipo e padronização nos dois lados.' },
    { h: 'Tipos de junção', items: ['Externa esquerda: mantém todas as linhas da primeira tabela.', 'Interna: mantém somente correspondências.', 'Externa direita: mantém todas da segunda.', 'Externa completa: mantém todas de ambos os lados.', 'Anti esquerda: encontra linhas da primeira sem correspondência.', 'Anti direita: encontra linhas da segunda sem correspondência.'] },
    { h: 'Risco de multiplicação', p: 'Se a chave repete nos dois lados, uma linha pode encontrar várias correspondências e multiplicar registros. Conte linhas antes e depois e verifique unicidade na tabela que deveria funcionar como dimensão.' }
  ]
};

for (const modulo of COURSE) {
  for (const aula of modulo.lessons) {
    const detalhes = COURSE_DETAILS[aula.id];
    if (!detalhes) continue;
    aula.content = aula.content || [];
    aula.content.push(...detalhes.filter(novo => !aula.content.some(atual => atual.h === novo.h)));
  }
}