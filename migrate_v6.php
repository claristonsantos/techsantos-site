<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$out = [];

$cursoId = (int)$pdo->query("SELECT id FROM cursos WHERE slug = 'power-bi'")->fetchColumn();
if (!$cursoId) {
    exit('Curso power-bi não encontrado.');
}

const QUIZZES = [
    'perfil-dados' => [
        'titulo' => 'Avaliação — Perfil dos Dados',
        'questoes' => [
            ['Qual ferramenta do Power Query mostra, em uma barra colorida, a proporção de valores válidos, com erro e vazios em cada coluna?',
                ['Distribuição da coluna', 'Qualidade da coluna', 'Perfil da coluna', 'Estatísticas da coluna'], 1],
            ['Por padrão, quantas linhas o Power Query analisa para gerar o perfil de dados, antes de você trocar para o perfil completo?',
                ['100', '500', '1.000', '10.000'], 2],
            ['Qual recurso mostra a frequência de cada valor distinto de uma coluna como um mini-histograma?',
                ['Qualidade da coluna', 'Distribuição da coluna', 'Tipo de dado', 'Estatísticas de erro'], 1],
            ['Onde ficam as ferramentas de perfil de dados no Editor do Power Query?',
                ['Guia Página Inicial', 'Guia Transformar', 'Guia Exibir', 'Guia Adicionar Coluna'], 2],
            ['Além da distribuição, o que o "Perfil da coluna" também exibe?',
                ['Apenas o tipo de dado', 'Estatísticas completas: distintos, únicos, mínimo, máximo, desvio padrão', 'Somente a contagem de linhas', 'O histórico de alterações da coluna'], 1],
        ],
    ],
    'power-query-conectar' => [
        'titulo' => 'Avaliação — Power Query: Conectando e Importando Dados',
        'questoes' => [
            ['O que significa a sigla ETL, usada para descrever o trabalho do Power Query?',
                ['Extract, Transform, Load', 'Export, Transfer, Link', 'Evaluate, Test, Launch', 'Edit, Total, List'], 0],
            ['Por que transformar um intervalo do Excel em Tabela (Ctrl+T) antes de conectar ao Power Query é boa prática?',
                ['Deixa o arquivo Excel menor', 'A Tabela se expande automaticamente quando novas linhas/colunas são adicionadas', 'É a única forma de usar o Power Query', 'Remove a necessidade de definir tipos de dados'], 1],
            ['Qual a principal vantagem de uma consulta de pasta em vez de importar arquivo por arquivo manualmente?',
                ['Ela é mais rápida para um único arquivo', 'Novos arquivos adicionados à pasta entram automaticamente na próxima atualização', 'Ela dispensa a necessidade de tipos de dados', 'Funciona apenas com arquivos CSV'], 1],
            ['Ao conectar a uma pasta do SharePoint em vez de uma pasta local, qual vantagem prática é destacada?',
                ['É mais rápido processar os dados', 'O serviço Power BI consegue atualizar automaticamente na nuvem, sem depender de um gateway', 'Permite mais tipos de arquivo', 'Elimina a necessidade de tratar os dados'], 1],
            ['Ao importar dados de um SQL Server, qual a principal vantagem de escolher "Importar" em vez de "DirectQuery"?',
                ['Consome menos espaço em disco', 'Permite tratar os dados no ETL e adicionar colunas antes de carregar no modelo', 'Atualiza os dados em tempo real automaticamente', 'Não precisa de nenhuma configuração de conexão'], 1],
        ],
    ],
    'power-query-transformar' => [
        'titulo' => 'Avaliação — Power Query: Transformação e Limpeza de Dados',
        'questoes' => [
            ['Para preencher células vazias resultantes de uma planilha com células mescladas, qual transformação você usa?',
                ['Substituir Valores', 'Preencher para baixo (ou para cima)', 'Agrupar Por', 'Dividir Coluna'], 1],
            ['Ao dividir uma coluna que mistura letras e números (como "SP001"), qual opção de divisão baseada em padrão você usaria em vez de um delimitador fixo?',
                ['Dividir por posição fixa', 'Dividir de dígito para não dígito (ou o inverso)', 'Dividir por maiúsculas', 'Dividir por espaço'], 1],
            ['Qual a diferença entre "Mesclar Colunas" e "Mesclar Consultas"?',
                ['São a mesma operação com nomes diferentes', 'Mesclar Colunas concatena texto na mesma tabela; Mesclar Consultas une duas tabelas diferentes por uma chave em comum', 'Mesclar Consultas só funciona com números', 'Mesclar Colunas exige que as duas tabelas tenham o mesmo número de linhas'], 1],
            ['Ao usar "Transformar Outras Colunas em Linhas" em vez de selecionar manualmente as colunas a transformar, qual o benefício?',
                ['É mais rápido de configurar visualmente', 'A consulta continua funcionando corretamente mesmo se novas colunas forem adicionadas à fonte', 'Preserva a formatação original das colunas', 'Evita a necessidade de promover cabeçalhos'], 1],
            ['Em uma mesclagem de consultas com junção externa esquerda (Left Outer), o que acontece com as linhas da tabela principal sem correspondência na segunda tabela?',
                ['Elas são descartadas', 'Elas são mantidas, com valores em branco para as colunas da segunda tabela', 'Causam um erro na consulta', 'São duplicadas automaticamente'], 1],
        ],
    ],
    'otimizacao' => [
        'titulo' => 'Avaliação — Modelo de Dados & Otimização de Desempenho',
        'questoes' => [
            ['Qual ferramenta do Power BI Desktop mostra quanto tempo cada visual, consulta e cálculo DAX levou para renderizar?',
                ['Editor do Power Query', 'Performance Analyzer', 'Painel de Campos', 'Gerenciador de Relacionamentos'], 1],
            ['O que é cardinalidade de uma coluna?',
                ['O tipo de dado da coluna', 'O número de valores distintos que a coluna contém', 'A quantidade de linhas de uma tabela', 'O número de relacionamentos que usam essa coluna'], 1],
            ['Qual modo de armazenamento copia os dados para dentro do arquivo .pbix, sendo o mais rápido mas exigindo atualização programada?',
                ['DirectQuery', 'Import', 'Dual', 'Live Connection'], 1],
            ['O que é dobra de consultas (query folding)?',
                ['Compactar o arquivo .pbix para ocupar menos espaço', 'A tradução dos passos do Power Query em uma instrução executada na própria fonte de dados', 'Um tipo de relacionamento entre tabelas', 'A criptografia dos dados durante a atualização'], 1],
            ['Para reduzir drasticamente a cardinalidade de uma coluna de data e hora completa, qual é a estratégia recomendada?',
                ['Excluir a coluna do modelo', 'Dividir em duas colunas separadas (data e hora)', 'Transformá-la em texto', 'Convertê-la em uma medida'], 1],
        ],
    ],
    'labs-power-query' => [
        'titulo' => 'Avaliação — Laboratórios Práticos de Power Query',
        'questoes' => [
            ['No Laboratório 01A, qual transformação foi usada para extrair o primeiro nome de uma coluna de contato completa?',
                ['Dividir Coluna por Delimitador', 'Coluna a Partir de Exemplos', 'Agrupar Por', 'Substituir Valores'], 1],
            ['No Laboratório 02A, qual foi a transformação usada para reorganizar colunas de mês (uma por coluna) no formato longo?',
                ['Dividir Colunas', 'Transformar Outras Colunas em Linhas (Unpivot)', 'Mesclar Consultas', 'Classificar e Filtrar'], 1],
            ['Ao carregar consultas no Excel apenas como "Criar Conexão" com "Adicionar estes dados ao Modelo de Dados" marcada, onde os dados ficam disponíveis?',
                ['Somente para uma tabela dinâmica específica', 'Para o Power Pivot do Excel, sem duplicar os dados em uma planilha', 'Apenas para exportação em CSV', 'Não ficam disponíveis até serem exportados'], 1],
            ['No exercício de "Consulta de uma pasta", por que os arquivos aparecem inicialmente como binário?',
                ['Porque estão corrompidos', 'Porque o Power Query ainda não sabe que tipo de arquivo é até você especificar', 'Porque a pasta está protegida por senha', 'Porque o formato binário é mais rápido de processar'], 1],
            ['No exercício de mesclar consultas com dados de datas e vendas, qual coluna normalmente serve de chave para o relacionamento?',
                ['Uma coluna de texto livre, como observações', 'Uma coluna-chave em comum entre as duas tabelas', 'A primeira coluna da tabela, sempre', 'Não é necessária nenhuma chave'], 1],
        ],
    ],
    'dax' => [
        'titulo' => 'Avaliação — Fórmulas DAX',
        'questoes' => [
            ['Qual instrução permite nomear um resultado intermediário dentro de uma medida DAX e reutilizá-lo, em vez de repetir a mesma sub-expressão várias vezes?',
                ['FILTER', 'VAR', 'RETURN', 'CALCULATE'], 1],
            ['Qual é a diferença fundamental entre uma coluna calculada e uma medida?',
                ['Não há diferença prática', 'A coluna calculada é avaliada linha a linha e armazenada no modelo; a medida é calculada sob demanda, respeitando o contexto de filtro', 'Medidas só funcionam em tabelas fato', 'Colunas calculadas são sempre mais rápidas que medidas'], 1],
            ['Por que a função DIVIDE é preferível a usar a barra "/" diretamente em uma medida de produção?',
                ['DIVIDE é mais rápida de digitar', 'DIVIDE retorna um valor alternativo em vez de erro quando o denominador é zero', 'A barra "/" não existe em DAX', 'DIVIDE sempre arredonda o resultado'], 1],
            ['Qual função é considerada a mais importante do DAX por ser a única capaz de modificar diretamente o contexto de filtro?',
                ['SUM', 'IF', 'CALCULATE', 'RELATED'], 2],
            ['O que o contexto de filtro representa em uma medida DAX?',
                ['O tipo de dado da coluna usada na medida', 'O conjunto de filtros ativos no momento em que a medida é calculada', 'A ordem em que as medidas foram criadas', 'O nome da tabela onde a medida está armazenada'], 1],
        ],
    ],
    'relatorios' => [
        'titulo' => 'Avaliação — Criar e Enriquecer Relatórios',
        'questoes' => [
            ['O que uma dica de ferramenta (tooltip) personalizada permite fazer, diferente do tooltip padrão?',
                ['Mudar a cor do visual principal', 'Exibir uma página inteira do relatório, com seus próprios visuais, em miniatura ao passar o mouse', 'Ocultar visuais automaticamente', 'Substituir a segmentação de dados'], 1],
            ['Para que serve o drillthrough em um relatório?',
                ['Ordenar visuais automaticamente', 'Levar o usuário de um resumo direto para uma página de detalhe, já filtrada para aquele item específico', 'Sincronizar segmentações entre páginas', 'Aplicar formatação condicional'], 1],
            ['O que um marcador (bookmark) captura ao ser criado?',
                ['Somente o título da página', 'O estado exato de uma página: filtros, segmentações e visuais ocultos', 'Apenas as cores dos visuais', 'O histórico de edições do relatório'], 1],
            ['Qual dos ajustes de acessibilidade garante que um leitor de tela consiga anunciar o conteúdo de um visual?',
                ['Ordem de tabulação', 'Texto alternativo (alt text)', 'Contraste de cores', 'Formatação condicional'], 1],
            ['Por que confiar só na cor para diferenciar categorias em um visual é um problema de acessibilidade?',
                ['Cores deixam o arquivo mais pesado', 'Quem não distingue bem as cores perde a informação se não houver também texto, forma ou textura reforçando a diferença', 'O Power BI não permite muitas cores', 'Isso não é um problema real'], 1],
        ],
    ],
    'analise-avancada' => [
        'titulo' => 'Avaliação — Análise Avançada & Insights de IA',
        'questoes' => [
            ['O que o visual de Perguntas e Respostas (Q&A) permite fazer?',
                ['Criar relacionamentos automaticamente', 'Digitar uma pergunta em linguagem natural e o Power BI monta o visual correspondente automaticamente', 'Exportar o relatório para PDF', 'Corrigir erros de digitação nos dados'], 1],
            ['Para que serve o recurso "Explicar o aumento/a diminuição"?',
                ['Corrigir automaticamente dados incorretos', 'Testar outras colunas do modelo em busca de explicações estatisticamente relevantes para uma variação', 'Traduzir o relatório para outro idioma', 'Aumentar a velocidade de carregamento do relatório'], 1],
            ['O que é "binning" em análise de dados?',
                ['Excluir dados duplicados', 'Agrupar valores numéricos contínuos em faixas, como faixas etárias', 'Ordenar uma tabela por múltiplas colunas', 'Combinar duas tabelas fato'], 1],
            ['O visual de Principais Influenciadores usa IA para:',
                ['Prever vendas futuras automaticamente', 'Testar quais colunas do modelo mais influenciam o aumento ou a diminuição de uma métrica escolhida', 'Gerar relatórios automaticamente sem intervenção do usuário', 'Corrigir erros de digitação em colunas de texto'], 1],
            ['O que diferencia a árvore de decomposição de um gráfico de barras tradicional?',
                ['Ela só funciona com dados financeiros', 'Permite quebrar uma métrica em múltiplas dimensões, em qualquer ordem, com sugestão automática da IA', 'Não pode ser usada em dashboards', 'É mais lenta de carregar'], 1],
        ],
    ],
    'dashboards-governanca' => [
        'titulo' => 'Avaliação — Dashboards, Publicação & Governança',
        'questoes' => [
            ['Qual papel de workspace permite publicar e editar conteúdo, mas NÃO gerenciar quem tem acesso ao workspace?',
                ['Administrador', 'Membro', 'Contribuidor', 'Visualizador'], 2],
            ['Qual a função de um App no serviço Power BI?',
                ['Substituir o workspace de edição', 'Empacotar relatórios e dashboards de um workspace em uma experiência de navegação própria para os usuários finais', 'Fazer backup automático dos dados', 'Criar relacionamentos entre tabelas automaticamente'], 1],
            ['Quando é necessário configurar um Gateway de Dados Local?',
                ['Sempre, para qualquer publicação no serviço', 'Quando a fonte de dados está dentro da rede da empresa e não é acessível diretamente pela nuvem', 'Apenas para fontes de dados na nuvem', 'Somente para arquivos Excel'], 1],
            ['O que a Segurança em Nível de Linha (RLS) permite fazer?',
                ['Criptografar o arquivo .pbix inteiro', 'Mostrar dados diferentes para usuários diferentes no mesmo relatório, conforme papéis de segurança configurados', 'Impedir qualquer atualização automática dos dados', 'Bloquear a exportação de dados para Excel'], 1],
            ['Qual a diferença entre fixar um único visual e fixar uma página inteira como "ao vivo" em um dashboard?',
                ['Não há diferença', 'Fixar a página inteira mantém a interatividade do relatório; fixar um único visual gera uma imagem estática', 'Fixar um visual único é sempre mais rápido de atualizar', 'Só é possível fixar páginas inteiras'], 1],
        ],
    ],
    'exercicio-guiado-tsbr' => [
        'titulo' => 'Avaliação — Exercício Guiado TECH SANTOS BR',
        'questoes' => [
            ['No exercício guiado, qual é o relacionamento correto entre a tabela fVendas e a tabela dVendedores?',
                ['Pela coluna DataVenda', 'Pela coluna Chave, ligando à coluna CHAVE de dVendedores', 'Não existe relacionamento direto', 'Pela coluna CidadeBR'], 1],
            ['Qual medida DAX calcula corretamente o Lucro total, com base no modelo do exercício?',
                ['Lucro = COUNTROWS(fVendas)', 'Lucro = SUM(fVendas[VlrLucro])', 'Lucro = AVERAGE(fVendas[VlrVenda])', 'Lucro = DISTINCTCOUNT(fVendas[VlrLucro])'], 1],
            ['No nível final do exercício, qual combinação de funções DAX calcula o lucro do mesmo período no ano anterior?',
                ['CALCULATE com SAMEPERIODLASTYEAR', 'FILTER sozinho', 'RELATED', 'COUNTROWS'], 0],
            ['Por que a coluna CidadeBR foi criada concatenando Estado, Cidade e "BR"?',
                ['Para reduzir o tamanho do arquivo', 'Para uso em visuais de mapa, que precisam de uma referência geográfica completa e reconhecível', 'Porque o Power BI exige esse formato para qualquer coluna de texto', 'Para substituir a tabela de calendário'], 1],
            ['Qual o propósito de automatizar a tabela dCalendario com base no período mínimo e máximo de DataVenda em fVendas?',
                ['Deixar a tabela de calendário fixa em um único ano', 'Fazer a tabela de datas cobrir automaticamente o período real dos dados de vendas, mesmo com novos dados', 'Acelerar a atualização do modelo', 'Substituir a necessidade de relacionamentos'], 1],
        ],
    ],
];

$pdo->beginTransaction();
foreach (QUIZZES as $moduloId => $quiz) {
    $dup = $pdo->prepare('SELECT id FROM avaliacoes WHERE curso_id = ? AND modulo_id = ?');
    $dup->execute([$cursoId, $moduloId]);
    if ($dup->fetch()) {
        $out[] = "Módulo {$moduloId}: já existia avaliação, pulado.";
        continue;
    }

    $insAval = $pdo->prepare('INSERT INTO avaliacoes (curso_id, modulo_id, titulo, nota_minima, ativo) VALUES (?, ?, ?, 70, 1)');
    $insAval->execute([$cursoId, $moduloId, $quiz['titulo']]);
    $avaliacaoId = (int)$pdo->lastInsertId();

    $ordemQ = 0;
    foreach ($quiz['questoes'] as [$enunciado, $alternativas, $corretaIdx]) {
        $ordemQ++;
        $insQ = $pdo->prepare('INSERT INTO avaliacao_questoes (avaliacao_id, enunciado, ordem) VALUES (?, ?, ?)');
        $insQ->execute([$avaliacaoId, $enunciado, $ordemQ]);
        $questaoId = (int)$pdo->lastInsertId();

        $insAlt = $pdo->prepare('INSERT INTO avaliacao_alternativas (questao_id, texto, correta, ordem) VALUES (?, ?, ?, ?)');
        foreach ($alternativas as $i => $texto) {
            $insAlt->execute([$questaoId, $texto, $i === $corretaIdx ? 1 : 0, $i]);
        }
    }
    $out[] = "Módulo {$moduloId}: avaliação criada (id {$avaliacaoId}) com " . count($quiz['questoes']) . ' questões.';
}
$pdo->commit();

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
