// Curso Excel do zero ao avançado — alinhado às certificações Microsoft Office
// Specialist: Excel Associate (MO-200/MO-210) e Excel Expert (MO-211), versão
// Microsoft 365 (TECH SANTOS BR).
// Texto original; imagens oficiais do Suporte/Learn da Microsoft com crédito na
// legenda (origem de cada arquivo em /assets/img/curso-excel/FONTES.md).
// Regra do curso: o texto sozinho precisa bastar para a prova — o vídeo é
// complemento. Mapa habilidade → aula em docs/curso-excel/.
// Nomes de função em português (PROCX, SOMASES...) com o nome em inglês entre
// parênteses, porque o aluno usa o Excel em português.
// Ids de aula com prefixo "xl-" para não colidir com o progresso dos outros cursos.
const XL_IMG = '/assets/img/curso-excel';
const SUP = 'https://support.microsoft.com/pt-br';

const COURSE = [
  {
    id: 'xl-m01', title: 'Módulo 01 · Primeiros passos: a interface, as planilhas e os arquivos do Excel', kind: 'video',
    lessons: [
      {
        id: 'xl-conhecendo-excel', title: 'Conhecendo o Excel: pasta de trabalho, planilha e célula',
        desc: 'O vocabulário básico do Excel e cada parte da tela: faixa de opções, barra de fórmulas, Caixa de Nome, guias de planilha e barra de status.',
        objetivos: [
          'Diferenciar pasta de trabalho, planilha, célula e intervalo',
          'Localizar na tela a faixa de opções, a barra de fórmulas, a Caixa de Nome e a barra de status',
          'Criar uma pasta de trabalho em branco ou a partir de um modelo e digitar os primeiros dados'
        ],
        body: 'O Excel é um programa de planilhas eletrônicas: uma grade enorme de linhas e colunas onde você guarda dados, faz contas que se atualizam sozinhas e transforma números em tabelas, gráficos e relatórios. Antes de qualquer fórmula, vale dominar o vocabulário — a prova da Microsoft usa esses nomes o tempo todo, e confundir "pasta de trabalho" com "planilha" é o erro mais comum de quem está começando.',
        content: [
          { h: 'Pasta de trabalho, planilha, célula e intervalo',
            items: [
              '<strong>Pasta de trabalho</strong> (workbook) — é o arquivo do Excel, aquele que você salva com a extensão .xlsx. Uma pasta de trabalho contém uma ou mais planilhas.',
              '<strong>Planilha</strong> (worksheet) — cada "folha" dentro da pasta de trabalho, identificada por uma guia na parte de baixo da tela (Planilha1, Planilha2...). Uma planilha tem 1.048.576 linhas e 16.384 colunas.',
              '<strong>Linhas e colunas</strong> — as linhas são numeradas (1, 2, 3...) e as colunas recebem letras (A, B, C... Z, AA, AB... até XFD).',
              '<strong>Célula</strong> — o encontro de uma coluna com uma linha. O nome da célula é a letra da coluna seguida do número da linha: <code>B3</code> é a célula da coluna B, linha 3. Esse nome se chama <strong>referência</strong> da célula.',
              '<strong>Célula ativa</strong> — a célula selecionada no momento, com a borda destacada. É nela que o que você digitar vai entrar.',
              '<strong>Intervalo</strong> — um bloco retangular de células, escrito com dois-pontos entre a primeira e a última: <code>A1:C10</code> vai da célula A1 até a C10 (3 colunas por 10 linhas).'
            ] },
          { h: 'As partes da tela',
            p: 'Ao abrir o Excel você encontra sempre os mesmos elementos. Vale memorizar os nomes, porque as instruções da prova (e deste curso) dizem "na guia Página Inicial, grupo Número..." e esperam que você saiba onde isso fica.',
            items: [
              '<strong>Faixa de Opções</strong> (ribbon) — a barra de comandos no alto, organizada em <strong>guias</strong> (Arquivo, Página Inicial, Inserir, Layout da Página, Fórmulas, Dados, Revisão, Exibir...). Cada guia é dividida em <strong>grupos</strong> — por exemplo, o grupo Fonte da guia Página Inicial. Alguns grupos têm, no canto inferior direito, uma setinha (o iniciador de caixa de diálogo) que abre todas as opções daquele grupo.',
              '<strong>Guias contextuais</strong> — aparecem só quando você seleciona certos objetos: ao clicar num gráfico surgem as guias de gráfico; ao clicar numa tabela, a guia Design da Tabela.',
              '<strong>Guia Arquivo</strong> — abre o modo Backstage, com Novo, Abrir, Informações, Salvar, Salvar Como, Imprimir, Compartilhar e Opções. É onde ficam os comandos que tratam do arquivo inteiro, e não do conteúdo.',
              '<strong>Caixa de Nome</strong> — à esquerda da barra de fórmulas; mostra a referência da célula ativa (ex.: B3). Você também pode digitar nela uma referência ou um nome e pressionar Enter para ir direto até lá.',
              '<strong>Barra de fórmulas</strong> — mostra o conteúdo real da célula ativa. Se a célula exibe 150 mas contém <code>=A1*3</code>, é na barra de fórmulas que você vê a fórmula.',
              '<strong>Guias de planilha</strong> — na parte de baixo, uma para cada planilha, com o botão <strong>+</strong> (Nova planilha) ao lado.',
              '<strong>Barra de status</strong> — a faixa no rodapé. Ao selecionar várias células com números ela mostra, sem fórmula nenhuma, a Média, a Contagem e a Soma da seleção. À direita ficam os botões de modo de exibição (Normal, Layout da Página, Visualização da Quebra de Página) e o controle de zoom.'
            ] },
          { h: 'Criar uma pasta de trabalho',
            p: 'Em Arquivo > Novo você escolhe entre a Pasta de trabalho em branco e dezenas de modelos prontos (orçamento, calendário, controle de estoque). Um modelo é só uma pasta de trabalho já formatada que serve de ponto de partida — o arquivo novo nasce como cópia, e o modelo original fica intacto.',
            img: { src: `${XL_IMG}/m01/criar-pasta-de-trabalho.png`, alt: 'Tela Novo do Excel com a opção Pasta de trabalho em branco', caption: 'Arquivo > Novo: pasta de trabalho em branco ou a partir de um modelo.', source: `${SUP}/excel/get-started/what-is-excel` } },
          { h: 'Digitar e editar dados',
            p: 'Clique numa célula, digite e pressione Enter (desce para a célula de baixo) ou Tab (vai para a da direita). Para corrigir, você tem três caminhos: digitar por cima (substitui tudo), dar duplo clique na célula ou pressionar F2 (edita dentro da célula, mantendo o que já estava), ou clicar na barra de fórmulas. Esc cancela a digitação antes de confirmar; Delete apaga o conteúdo das células selecionadas, mas mantém a formatação delas.',
            img: { src: `${XL_IMG}/m01/inserir-dados.png`, alt: 'Dados sendo digitados em células de uma planilha', caption: 'Cada valor vai numa célula; texto alinha à esquerda e número à direita por padrão.', source: `${SUP}/excel/get-started/what-is-excel` } },
          { h: 'Texto, número e data: como o Excel entende o que você digita',
            p: 'O Excel decide sozinho o tipo de cada valor. Números e datas ficam alinhados à direita; texto, à esquerda. Isso é um ótimo diagnóstico: se você digitou 1.500 e ele ficou encostado à esquerda, o Excel entendeu como texto, e esse valor não vai entrar nas somas. No Excel configurado em português do Brasil, a vírgula é o separador decimal (12,5) e o ponto separa milhares; datas são digitadas como 27/09/2026. Um texto que comece com sinal de igual (=) é tratado como fórmula — veremos isso a partir do Módulo 06.' },
          { h: 'Excel no computador, na Web e no celular',
            p: 'Este curso usa o Excel para Microsoft 365 no Windows (o aplicativo da área de trabalho), que é a versão cobrada nas provas MO-210 e MO-211. O Excel para a Web, aberto pelo navegador em office.com, faz a maior parte das tarefas do dia a dia, mas não tem tudo (por exemplo, o editor de macros VBA). Quando algum recurso for exclusivo do aplicativo da área de trabalho, a aula avisa.' },
          { h: 'Como isso cai na prova',
            items: [
              'As provas MOS são práticas: você recebe um arquivo aberto e uma lista de tarefas ("Na planilha Vendas, ..."). Saber o nome exato de guias, grupos e caixas de diálogo economiza tempo, porque a tarefa não diz onde o comando fica.',
              'A tarefa sempre indica a planilha pelo nome da guia — confira a guia ativa antes de começar a mexer.',
              'Use a Caixa de Nome para ir direto a uma célula ou intervalo citado no enunciado.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Criar uma nova pasta de trabalho', u: `${SUP}/excel/get-started/what-is-excel` },
          { t: 'Microsoft Suporte — Atalhos de teclado no Excel', u: `${SUP}/accessibility/excel/keyboard-shortcuts-in-excel` }
        ]
      },
      {
        id: 'xl-navegar-selecionar', title: 'Navegar e selecionar com rapidez (mouse e teclado)',
        desc: 'Ir de uma ponta a outra da planilha em um toque, selecionar linhas, colunas e intervalos não adjacentes, e os atalhos que mudam no Excel em português.',
        objetivos: [
          'Navegar com Ctrl+setas, Ctrl+Home, Ctrl+End, a Caixa de Nome e a caixa Ir para',
          'Selecionar intervalos, linhas, colunas, a planilha inteira e seleções não adjacentes',
          'Saber quais atalhos de letra mudam entre o Excel em português e em inglês'
        ],
        body: 'Quem usa só o mouse passa boa parte do tempo arrastando barra de rolagem. Com meia dúzia de atalhos você chega ao fim de uma base de 100 mil linhas em um toque e seleciona uma coluna inteira de dados sem arrastar nada. Nesta aula ficam os comandos de navegação e seleção que você vai usar em todos os módulos seguintes.',
        content: [
          { h: 'Movimentar-se pela planilha',
            items: [
              '<strong>Setas</strong> — uma célula por vez. <strong>Enter</strong> desce, <strong>Tab</strong> vai para a direita (Shift+Enter e Shift+Tab fazem o caminho inverso).',
              '<strong>Ctrl + seta</strong> — pula até a borda do bloco de dados na direção da seta: se você está no meio de uma coluna preenchida, Ctrl+↓ vai até a última célula preenchida antes de um vazio.',
              '<strong>Ctrl+Home</strong> — volta para a célula A1. <strong>Ctrl+End</strong> vai para a última célula usada da planilha (a linha usada mais abaixo, na coluna usada mais à direita).',
              '<strong>Page Down / Page Up</strong> — rola uma tela para baixo ou para cima. <strong>Ctrl+Page Down / Ctrl+Page Up</strong> passam para a próxima planilha ou para a anterior.',
              '<strong>Caixa de Nome</strong> — digite <code>D250</code> e Enter para ir direto a essa célula; digite um intervalo como <code>A1:A500</code> para selecioná-lo.',
              '<strong>Ir para</strong> (F5 ou Ctrl+G) — abre a caixa Ir para; digite a referência ou escolha um nome definido. O botão <strong>Especial</strong> dessa caixa seleciona tipos de célula: em branco, com fórmulas, com constantes, só as visíveis...'
            ] },
          { h: 'Selecionar células, linhas e colunas',
            img: { src: `${XL_IMG}/m01/titulos-linha-coluna.gif`, alt: 'Planilha com o título de linha e o título de coluna indicados', caption: 'Clicar no título da linha (1) ou da coluna (2) seleciona a linha ou a coluna inteira.', source: `${SUP}/excel/get-started/select-cell-contents-in-excel` },
            items: [
              '<strong>Intervalo</strong> — clique na primeira célula e arraste até a última; ou segure Shift e use as setas. Para um intervalo grande, clique na primeira célula e dê Shift+clique na última.',
              '<strong>F8</strong> — liga o modo "estender seleção": as setas passam a aumentar a seleção sem precisar segurar Shift. F8 de novo desliga.',
              '<strong>Ctrl+Shift+seta</strong> — seleciona da célula ativa até a borda do bloco de dados. É o jeito mais rápido de selecionar uma coluna de dados inteira, sem pegar as células vazias abaixo.',
              '<strong>Linha ou coluna inteira</strong> — clique no número da linha ou na letra da coluna. Pelo teclado: <strong>Shift+Barra de espaços</strong> seleciona a linha e <strong>Ctrl+Barra de espaços</strong> seleciona a coluna da célula ativa.',
              '<strong>Não adjacentes</strong> — selecione o primeiro bloco e segure Ctrl enquanto seleciona os demais (ou use Shift+F8 para ir adicionando). Não é possível tirar uma célula de uma seleção não adjacente sem desfazer a seleção toda.',
              '<strong>Planilha inteira</strong> — o botão <strong>Selecionar Tudo</strong>, no canto superior esquerdo onde os títulos de linha e coluna se encontram.'
            ] },
          { h: 'O botão Selecionar Tudo e o "Ctrl+T"',
            p: 'No Excel em português, o atalho de selecionar tudo é Ctrl+T. Com a célula ativa dentro de um bloco de dados, o primeiro Ctrl+T seleciona só a região atual (o bloco contínuo de dados); pressionando de novo, seleciona a planilha inteira. Dentro de uma tabela do Excel o comportamento é parecido: o primeiro toque seleciona os dados da tabela.',
            img: { src: `${XL_IMG}/m01/selecionar-tudo.gif`, alt: 'Botão Selecionar Tudo no canto superior esquerdo da planilha', caption: 'O botão Selecionar Tudo fica no cruzamento dos títulos de linha e de coluna.', source: `${SUP}/excel/get-started/select-cell-contents-in-excel` } },
          { h: 'Atalhos que mudam no Excel em português',
            p: 'Os atalhos de letra seguem o idioma do Office. Isso confunde quem aprende em tutoriais em inglês: no Excel em português, Ctrl+N não cria pasta nova — aplica negrito. Os mais usados:',
            items: [
              '<strong>Abrir</strong>: Ctrl+A no Excel em português (Ctrl+O em inglês).',
              '<strong>Salvar</strong>: Ctrl+B (Ctrl+S em inglês). F12 abre o Salvar Como nos dois idiomas.',
              '<strong>Nova pasta de trabalho</strong>: Ctrl+O (Ctrl+N em inglês).',
              '<strong>Negrito, itálico e sublinhado</strong>: Ctrl+N, Ctrl+I e Ctrl+S (em inglês, Ctrl+B, Ctrl+I e Ctrl+U). Ctrl+2, Ctrl+3 e Ctrl+4 fazem o mesmo em qualquer idioma.',
              '<strong>Selecionar tudo</strong>: Ctrl+T (Ctrl+A em inglês).',
              '<strong>Iguais nos dois idiomas</strong>: Ctrl+C (copiar), Ctrl+X (recortar), Ctrl+V (colar), Ctrl+Z (desfazer), Ctrl+Y (refazer), Ctrl+W (fechar a pasta), Ctrl+1 (Formatar Células), F2 (editar a célula), F5/Ctrl+G (Ir para), Ctrl+9 (ocultar linhas) e Ctrl+0 (ocultar colunas).'
            ] },
          { h: 'Dicas de Tecla (Alt)',
            p: 'Pressione Alt e solte: letrinhas aparecem sobre cada guia da faixa de opções. Digite a letra da guia e depois as letras dos comandos. É uma forma de chegar a qualquer comando sem mouse, e as letras aparecem na tela, então não é preciso decorar nada. Esc volta um nível.' },
          { h: 'Como isso cai na prova',
            items: [
              'Tarefas do tipo "selecione o intervalo e..." ficam mais rápidas com a Caixa de Nome: digite o intervalo do enunciado e pressione Enter.',
              'Ir para > Especial é o caminho para selecionar só células em branco ou só fórmulas — útil em tarefas de preenchimento e de auditoria.',
              'Na prova você usa o Excel no idioma do exame: com a MO-200 em português, os atalhos de letra são os da versão em português.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Selecionar o conteúdo das células', u: `${SUP}/excel/get-started/select-cell-contents-in-excel` },
          { t: 'Microsoft Suporte — Atalhos de teclado no Excel', u: `${SUP}/accessibility/excel/keyboard-shortcuts-in-excel` }
        ]
      },
      {
        id: 'xl-planilhas-linhas-colunas', title: 'Organizar planilhas, linhas e colunas',
        desc: 'Inserir, renomear, mover, copiar, colorir e ocultar planilhas; inserir, ocultar e redimensionar linhas e colunas, com os tamanhos padrão e máximos.',
        objetivos: [
          'Inserir, excluir, renomear, mover, copiar e ocultar planilhas',
          'Ocultar e reexibir linhas e colunas',
          'Ajustar largura de coluna e altura de linha com valor exato, com o mouse e com AutoAjuste'
        ],
        body: 'Uma pasta de trabalho bem organizada tem planilhas com nomes que dizem o que há nelas, na ordem em que fazem sentido, e colunas com largura suficiente para ler os dados. Tudo isso é cobrado na prova Associate, na parte de "gerenciar planilhas e pastas de trabalho".',
        content: [
          { h: 'Inserir e excluir planilhas',
            items: [
              '<strong>Inserir</strong> — clique no <strong>+</strong> ao lado das guias, pressione <strong>Shift+F11</strong> ou use Página Inicial > Inserir > Inserir Planilha. A planilha nova entra antes da planilha ativa quando criada pelo menu ou pelo Shift+F11, e logo depois (à direita) da planilha ativa quando criada pelo +.',
              '<strong>Excluir</strong> — clique com o botão direito na guia e escolha Excluir, ou Página Inicial > Excluir > Excluir Planilha. Excluir planilha não pode ser desfeito com Ctrl+Z; se ela tiver dados, o Excel pede confirmação.'
            ],
            img: { src: `${XL_IMG}/m01/excluir-planilha.png`, alt: 'Menu Excluir do Excel com a opção Excluir Planilha selecionada', caption: 'Página Inicial > Excluir > Excluir Planilha.', source: `${SUP}/excel/get-started/insert-or-delete-a-worksheet` } },
          { h: 'Renomear, colorir, mover e copiar',
            items: [
              '<strong>Renomear</strong> — dê duplo clique na guia (ou botão direito > Renomear), digite e Enter. O nome aceita até 31 caracteres e não pode conter <code>/ \\ ? * : [ ]</code>.',
              '<strong>Cor da guia</strong> — botão direito na guia > Cor da Guia. Ajuda a agrupar visualmente planilhas do mesmo assunto.',
              '<strong>Mover</strong> — arraste a guia pela linha de guias até a posição desejada.',
              '<strong>Copiar</strong> — segure Ctrl enquanto arrasta a guia; ou botão direito > <strong>Mover ou Copiar</strong>, escolha a posição em "Antes da planilha" e marque <strong>Criar uma cópia</strong>. Sem essa caixa marcada, o comando move.',
              '<strong>Para outra pasta de trabalho</strong> — na mesma caixa Mover ou Copiar, escolha outra pasta aberta na lista "Para pasta" (ou "(novo livro)" para criar uma pasta nova com essa planilha).',
              '<strong>Cuidado</strong> — ao mover uma planilha para outra pasta, fórmulas e gráficos que apontavam para ela podem passar a apontar para o arquivo de origem ou dar erro. Confira os cálculos depois.'
            ] },
          { h: 'Ocultar e reexibir planilhas',
            p: 'Botão direito na guia > Ocultar esconde a planilha (ela continua existindo e as fórmulas continuam lendo seus dados). Para trazer de volta: botão direito em qualquer guia > Reexibir e escolha a planilha na lista. Ocultar não é segurança — qualquer pessoa reexibe em dois cliques, a menos que a estrutura da pasta de trabalho esteja protegida (Módulo 15).' },
          { h: 'Inserir, excluir e ocultar linhas e colunas',
            items: [
              '<strong>Inserir</strong> — selecione a linha (ou coluna) e clique com o botão direito > Inserir. A linha nova entra acima da selecionada; a coluna nova, à esquerda. Selecionando 3 linhas antes de inserir, o Excel insere 3 de uma vez.',
              '<strong>Excluir</strong> — selecione e clique com o botão direito > Excluir. Diferente de apagar o conteúdo (Delete): excluir remove a linha e puxa as de baixo para cima.',
              '<strong>Ocultar</strong> — selecione e clique com o botão direito > Ocultar, ou Ctrl+9 (linhas) e Ctrl+0 (colunas). Uma linha dupla entre os títulos indica que há algo oculto ali.',
              '<strong>Reexibir</strong> — selecione as linhas ou colunas vizinhas da parte oculta (as duas dos lados) e clique com o botão direito > Reexibir, ou dê duplo clique na linha dupla.'
            ] },
          { h: 'Largura das colunas e altura das linhas',
            p: 'A largura da coluna é medida em caracteres — quantos caracteres da fonte padrão cabem na célula — e a altura da linha, em pontos. O padrão de uma pasta nova é 8,43 de largura e 15 pontos de altura. O máximo é 255 para largura e 409 pontos para altura; zero significa oculta.',
            img: { src: `${XL_IMG}/m01/formatar-tamanho-celula.png`, alt: 'Botão Formatar no grupo Células da guia Página Inicial', caption: 'Página Inicial > Células > Formatar reúne as opções de Tamanho da Célula.', source: `${SUP}/excel/change-the-column-width-and-row-height` } },
          { h: 'As formas de ajustar',
            items: [
              '<strong>Valor exato</strong> — selecione as colunas e vá em Página Inicial > Formatar > <strong>Largura da Coluna</strong> (ou <strong>Altura da Linha</strong>) e digite o valor. Atalho: botão direito no título da coluna > Largura da Coluna.',
              '<strong>AutoAjuste</strong> — Formatar > <strong>AutoAjuste da Largura da Coluna</strong> deixa a coluna do tamanho do maior conteúdo. Com o mouse: duplo clique na divisa à direita do título da coluna.',
              '<strong>Arrastando</strong> — arraste a divisa à direita do título da coluna (ou abaixo do número da linha). Com várias selecionadas, todas ficam com o mesmo tamanho.',
              '<strong>Tudo de uma vez</strong> — clique em Selecionar Tudo e dê duplo clique em qualquer divisa entre títulos de coluna para AutoAjustar a planilha toda.',
              '<strong>Copiar a largura de outra coluna</strong> — copie uma célula da coluna modelo e, na coluna de destino, use Colar Especial > <strong>Manter Larguras da Coluna de Origem</strong> (ou a opção Larguras da coluna na caixa Colar Especial).',
              '<strong>Largura Padrão</strong> — Formatar > Largura Padrão muda a largura de todas as colunas que ainda não foram ajustadas manualmente na planilha.'
            ] },
          { h: 'Quando a coluna é estreita demais',
            p: 'Se um número não cabe, o Excel mostra <code>####</code> em vez de cortá-lo — o valor está certo, só falta espaço; alargue a coluna. Um texto que não cabe invade a célula vizinha se ela estiver vazia, ou fica cortado se a vizinha tiver conteúdo.' },
          { h: 'Como isso cai na prova',
            items: [
              'Tarefas pedem valores exatos ("defina a largura da coluna C como 18") — use a caixa Largura da Coluna, não o mouse, para acertar o número.',
              '"AutoAjuste" é o termo usado pela prova para ajustar ao conteúdo.',
              'Ao copiar planilha, a pegadinha é esquecer a caixa Criar uma cópia e acabar movendo.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Inserir ou excluir uma planilha', u: `${SUP}/excel/get-started/insert-or-delete-a-worksheet` },
          { t: 'Microsoft Suporte — Mover ou copiar planilhas', u: `${SUP}/excel/get-started/move-or-copy-worksheets-or-worksheet-data` },
          { t: 'Microsoft Suporte — Ocultar ou mostrar linhas ou colunas', u: `${SUP}/excel/get-started/hide-or-show-rows-or-columns` },
          { t: 'Microsoft Suporte — Alterar a largura da coluna e a altura da linha', u: `${SUP}/excel/change-the-column-width-and-row-height` }
        ]
      },
      {
        id: 'xl-exibicao-janelas', title: 'Modos de exibição, congelar painéis, janelas e Barra de Acesso Rápido',
        desc: 'Modos Normal, Layout da Página e Visualização da Quebra de Página; congelar e dividir; várias janelas; mostrar fórmulas; personalizar a Barra de Ferramentas de Acesso Rápido.',
        objetivos: [
          'Alternar entre os modos de exibição e saber para que serve cada um',
          'Congelar linhas e colunas de título e dividir a janela',
          'Abrir uma segunda janela da mesma pasta, organizar janelas e exibir fórmulas',
          'Personalizar a Barra de Ferramentas de Acesso Rápido'
        ],
        body: 'Numa planilha de verdade, com centenas de linhas, o cabeçalho some logo que você rola a tela. A guia Exibir resolve isso e mais: mostra como a página vai sair impressa, deixa você ver duas partes distantes da mesma planilha ao mesmo tempo e revela todas as fórmulas de uma vez. Todos esses comandos estão na lista de habilidades da prova Associate.',
        content: [
          { h: 'Os três modos de exibição',
            items: [
              '<strong>Normal</strong> — o modo padrão de trabalho, sem margens nem páginas.',
              '<strong>Layout da Página</strong> — mostra a planilha como páginas, com margens, réguas e a área de cabeçalho e rodapé, que você edita clicando nela. Nesse modo, largura e altura podem ser digitadas em centímetros.',
              '<strong>Visualização da Quebra de Página</strong> — mostra onde cada página impressa começa e termina; você arrasta as linhas azuis para mudar as quebras.'
            ],
            p: 'Os três ficam em Exibir > Modos de Exibição de Pasta de Trabalho e também nos botões à direita da barra de status.',
            img: { src: `${XL_IMG}/m01/botao-visualizacao-quebra.png`, alt: 'Guia Exibir com o botão Visualização da Quebra de Página', caption: 'Exibir > Modos de Exibição de Pasta de Trabalho.', source: `${SUP}/excel/insert-move-or-delete-page-breaks-in-a-worksheet` } },
          { h: 'Quebras de página automáticas e manuais',
            p: 'O Excel quebra as páginas sozinho, conforme o tamanho do papel, as margens e a escala. Na Visualização da Quebra de Página, as quebras automáticas aparecem tracejadas e as que você inseriu aparecem como linha contínua. Para inserir uma quebra manual, selecione a linha abaixo (ou a coluna à direita) de onde a página deve terminar e use Layout da Página > Quebras > Inserir Quebra de Página. Arrastar uma quebra automática a transforma em manual. Layout da Página > Quebras > Redefinir Todas as Quebras de Página remove as manuais. Se as quebras manuais forem ignoradas, confira se a escala está em "Ajustar para" um número de páginas — esse modo tem prioridade.',
            img: { src: `${XL_IMG}/m01/quebras-de-pagina.jpg`, alt: 'Planilha na Visualização da Quebra de Página com quebras automáticas e manuais', caption: 'Quebra automática tracejada; quebra manual em linha contínua.', source: `${SUP}/excel/insert-move-or-delete-page-breaks-in-a-worksheet` } },
          { h: 'Congelar painéis',
            p: 'Exibir > Congelar Painéis tem três opções. <strong>Congelar Linha Superior</strong> mantém a linha 1 visível ao rolar para baixo. <strong>Congelar Primeira Coluna</strong> mantém a coluna A visível ao rolar para a direita. <strong>Congelar Painéis</strong> congela ao mesmo tempo as linhas acima e as colunas à esquerda da célula selecionada: para travar as linhas 1 e 2 e a coluna A, selecione B3 antes. Para soltar, o mesmo botão vira Descongelar Painéis.',
            img: { src: `${XL_IMG}/m01/congelar-paineis.png`, alt: 'Menu Congelar Painéis com a opção Descongelar Painéis', caption: 'Exibir > Congelar Painéis: as três opções de congelamento e Descongelar.', source: `${SUP}/excel/get-started/freeze-panes-to-lock-rows-and-columns` } },
          { h: 'Dividir, Nova Janela e Organizar Tudo',
            items: [
              '<strong>Dividir</strong> (Exibir > Janela > Dividir) — parte a janela em até quatro painéis com barras de rolagem independentes, a partir da célula selecionada. Serve para comparar o início e o fim da mesma planilha. Clique de novo em Dividir para desfazer. Congelar e Dividir não funcionam ao mesmo tempo.',
              '<strong>Nova Janela</strong> — abre uma segunda janela da mesma pasta de trabalho (o título ganha ":1" e ":2"). Cada janela pode mostrar uma planilha diferente, e tudo que você altera numa aparece na outra, porque é o mesmo arquivo.',
              '<strong>Organizar Tudo</strong> — distribui as janelas abertas na tela: lado a lado, horizontal, vertical ou em cascata.',
              '<strong>Exibir Lado a Lado</strong> e <strong>Rolagem Sincronizada</strong> — comparam duas janelas rolando juntas, linha a linha.',
              '<strong>Alternar Janelas</strong> — lista as janelas abertas para trocar entre elas.'
            ] },
          { h: 'Zoom e o que aparece na tela',
            p: 'O grupo Zoom da guia Exibir tem Zoom (percentual livre), 100% e Zoom na Seleção, que ajusta a tela exatamente ao intervalo selecionado. No grupo Mostrar você liga e desliga a Régua, as Linhas de Grade, a Barra de Fórmulas e os Títulos (letras e números de linhas e colunas). Desligar as linhas de grade só muda a tela — não altera a impressão, que tem opção própria em Layout da Página.' },
          { h: 'Mostrar fórmulas',
            p: 'Fórmulas > Auditoria de Fórmulas > <strong>Mostrar Fórmulas</strong> (ou Ctrl+`, a tecla do acento grave) exibe em cada célula a fórmula em vez do resultado, e alarga as colunas para caber. É o modo de conferir de uma vez onde há fórmula e onde há valor digitado. Clique de novo para voltar. Isso é diferente de ocultar fórmulas: para esconder a fórmula da barra de fórmulas de outras pessoas, marca-se a opção Oculto em Formatar Células > Proteção e depois protege-se a planilha (Módulo 15).' },
          { h: 'Barra de Ferramentas de Acesso Rápido',
            p: 'É uma barra pequena com os comandos que você mais usa, visível em qualquer guia. Pode ficar acima da faixa de opções (padrão) ou abaixo dela. Para adicionar um comando: clique com o botão direito em qualquer botão da faixa de opções > Adicionar à Barra de Ferramentas de Acesso Rápido; ou use a setinha Personalizar Barra de Ferramentas de Acesso Rápido e marque os comandos da lista. Para comandos que não estão na faixa de opções, use Mais Comandos (ou Arquivo > Opções > Barra de Ferramentas de Acesso Rápido), escolha "Comandos Fora da Faixa de Opções" e clique em Adicionar. As setas dessa tela mudam a ordem; Redefinir volta ao padrão. Se a barra não aparecer, clique com o botão direito na faixa de opções > Mostrar Barra de Ferramentas de Acesso Rápido.',
            img: { src: `${XL_IMG}/m01/barra-acesso-rapido-adicionar.png`, alt: 'Lista suspensa Personalizar Barra de Ferramentas de Acesso Rápido', caption: 'A setinha da barra lista os comandos mais comuns para marcar e desmarcar.', source: `${SUP}/office/customize-the-quick-access-toolbar` } },
          { h: 'Barra acima ou abaixo da faixa',
            img: { src: `${XL_IMG}/m01/barra-acesso-rapido-abaixo.png`, alt: 'Barra de Ferramentas de Acesso Rápido posicionada abaixo da faixa de opções', caption: 'Na posição abaixo da faixa de opções é possível mostrar também os rótulos dos comandos.', source: `${SUP}/office/customize-the-quick-access-toolbar` } },
          { h: 'Como isso cai na prova',
            items: [
              '"Configure a planilha para que as linhas 1 a 3 permaneçam visíveis ao rolar" — selecione A4 e use Congelar Painéis (Congelar Linha Superior só trava a linha 1).',
              '"Adicione o comando X à Barra de Ferramentas de Acesso Rápido" — confira se a tarefa pede a barra da pasta atual ou de todos os documentos; a lista no topo da tela de Opções tem as duas escolhas.',
              '"Exiba as fórmulas" pede Mostrar Fórmulas, não editar célula por célula.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Congelar painéis para bloquear linhas e colunas', u: `${SUP}/excel/get-started/freeze-panes-to-lock-rows-and-columns` },
          { t: 'Microsoft Suporte — Inserir, mover ou excluir quebras de página', u: `${SUP}/excel/insert-move-or-delete-page-breaks-in-a-worksheet` },
          { t: 'Microsoft Suporte — Exibir ou ocultar fórmulas', u: `${SUP}/excel/display-or-hide-formulas` },
          { t: 'Microsoft Suporte — Personalizar a Barra de Ferramentas de Acesso Rápido', u: `${SUP}/office/customize-the-quick-access-toolbar` }
        ]
      },
      {
        id: 'xl-salvar-formatos', title: 'Salvar, formatos de arquivo, propriedades e inspeção',
        desc: 'Salvar e Salvar Como, OneDrive e AutoSalvamento, os formatos .xlsx, .xlsm, .xlsb, .xltx, .xls, CSV e PDF, Modo de Compatibilidade, propriedades e o Inspetor de Documentos.',
        objetivos: [
          'Salvar no computador ou no OneDrive e entender o AutoSalvamento',
          'Escolher o formato de arquivo certo e saber o que se perde em cada um',
          'Editar as propriedades da pasta de trabalho e inspecioná-la antes de compartilhar'
        ],
        body: 'Salvar parece trivial até alguém perder um dia de trabalho, mandar uma planilha com macro num formato que apaga a macro ou enviar a um cliente um arquivo com comentários internos escondidos. Esta aula fecha o módulo com o ciclo de vida do arquivo — e quase tudo aqui aparece como tarefa na prova Associate.',
        content: [
          { h: 'Salvar e Salvar Como',
            p: '<strong>Salvar</strong> (Ctrl+B no Excel em português) grava por cima do arquivo atual; na primeira vez, abre a tela de salvar. <strong>Salvar Como</strong> (F12, ou Arquivo > Salvar Como) cria um arquivo novo, com outro nome, outro local ou outro formato, e o original fica como estava. Em Arquivo > Salvar Como você escolhe o local (OneDrive, Este PC ou Procurar), o nome e, na lista <strong>Tipo</strong>, o formato.' },
          { h: 'OneDrive e AutoSalvamento',
            p: 'Salvando no OneDrive (pessoal ou da empresa), o arquivo fica acessível em qualquer dispositivo, pode ser compartilhado e editado por várias pessoas ao mesmo tempo e ganha histórico de versões. Com o arquivo na nuvem, a chave <strong>AutoSalvamento</strong>, no canto superior esquerdo, grava cada alteração em segundos — e por isso o comando da guia Arquivo passa a se chamar Salvar uma Cópia. Com o AutoSalvamento ligado, use Salvar uma Cópia antes de fazer testes que você não quer gravar no original.' },
          { h: 'Os formatos mais importantes',
            items: [
              '<strong>.xlsx</strong> — Pasta de Trabalho do Excel, o padrão. Não guarda macros VBA: se você salvar um arquivo com macro como .xlsx, o Excel avisa que o código será removido.',
              '<strong>.xlsm</strong> — Pasta de Trabalho Habilitada para Macro. Use sempre que o arquivo tiver macros (Módulo 16).',
              '<strong>.xlsb</strong> — Pasta de Trabalho Binária. Guarda tudo, inclusive macros, num formato binário que abre e salva mais rápido e ocupa menos espaço em arquivos muito grandes.',
              '<strong>.xltx / .xltm</strong> — Modelo do Excel (sem e com macro). Abrir um modelo cria uma pasta nova baseada nele, sem alterar o modelo.',
              '<strong>.xls</strong> — formato do Excel 97-2003, para quem ainda usa versões antigas. Recursos novos se perdem ao salvar nele.',
              '<strong>.csv</strong> — texto separado por vírgula (no Excel em português, o separador costuma ser ponto e vírgula, conforme as configurações regionais do Windows). Só a planilha ativa é salva, e só os valores: fórmulas, formatação, gráficos e as demais planilhas se perdem. Também existe CSV UTF-8, que preserva acentos quando o arquivo vai para outros sistemas.',
              '<strong>.txt</strong> — texto separado por tabulação; também salva só a planilha ativa.',
              '<strong>.pdf / .xps</strong> — documento fixo para enviar ou imprimir; ninguém edita os dados. Em Opções, na tela de salvar, você escolhe se vai a seleção, a planilha ativa ou a pasta inteira.'
            ] },
          { h: 'Modo de Compatibilidade e Converter',
            p: 'Ao abrir um arquivo .xls, o Excel mostra "Modo de Compatibilidade" na barra de título: recursos novos ficam limitados para que o arquivo continue abrindo nas versões antigas. Para trazer o arquivo para o formato atual, use Arquivo > Informações > <strong>Converter</strong> — o Excel salva uma versão .xlsx e reabre nela. Antes de salvar um arquivo moderno no formato antigo, Arquivo > Informações > Verificar Problemas > <strong>Verificar Compatibilidade</strong> lista o que vai se perder.' },
          { h: 'Propriedades da pasta de trabalho',
            p: 'Propriedades (metadados) são dados sobre o arquivo: título, assunto, autor, marcas, categoria, comentários. Elas ajudam a encontrar o arquivo numa pesquisa e a identificar quem o criou. Ficam em Arquivo > Informações, no painel da direita — clique no campo (Título, Marcas...) e digite. O link <strong>Mostrar Todas as Propriedades</strong> revela o resto; o menu <strong>Propriedades > Propriedades Avançadas</strong> abre a caixa completa, com a guia Resumo e a guia Personalizar, onde você cria propriedades próprias (texto, data, número ou sim/não). Tamanho, data de criação e data de modificação são atualizados automaticamente e não podem ser editados.',
            img: { src: `${XL_IMG}/m01/propriedades-avancadas.png`, alt: 'Menu Propriedades com a opção Propriedades Avançadas', caption: 'Arquivo > Informações > Propriedades > Propriedades Avançadas.', source: `${SUP}/office/collab-files/view-or-change-the-properties-for-an-office-file` } },
          { h: 'Inspecionar antes de compartilhar',
            p: 'Arquivo > Informações > Verificar Problemas reúne três verificações que a prova cobra pelo nome:',
            items: [
              '<strong>Inspecionar Documento</strong> — procura conteúdo oculto e informações pessoais: comentários, propriedades do documento e nome do autor, linhas, colunas e planilhas ocultas, cabeçalhos e rodapés, dados XML personalizados. Você marca o que verificar, clica em Inspecionar e usa Remover Tudo em cada categoria encontrada. Atenção: algumas remoções não podem ser desfeitas — inspecione uma cópia.',
              '<strong>Verificar Acessibilidade</strong> — aponta o que dificulta a leitura por pessoas com deficiência, como imagens sem texto alternativo ou cores com pouco contraste (Módulo 11).',
              '<strong>Verificar Compatibilidade</strong> — lista os recursos que não funcionam em versões anteriores do Excel.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              '"Salve a pasta de trabalho como ..." — Salvar Como, com o nome e o tipo pedidos, na pasta indicada.',
              '"Remova as propriedades do documento e as informações pessoais" — é o Inspetor de Documentos, não apagar campo por campo.',
              '"Adicione a marca Vendas" ou "defina o título" — Arquivo > Informações, painel Propriedades.',
              'Guarde as consequências: CSV e TXT salvam só a planilha ativa e só valores; .xlsx descarta macros.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Salvar uma pasta de trabalho em outro formato', u: `${SUP}/excel/save-a-workbook-in-another-file-format` },
          { t: 'Microsoft Suporte — Formatos de arquivo com suporte no Excel', u: `${SUP}/excel/file-formats-that-are-supported-in-excel` },
          { t: 'Microsoft Suporte — Salvar a pasta de trabalho no OneDrive', u: `${SUP}/excel/get-started-with-excel/save-your-workbook-to-onedrive-in-excel` },
          { t: 'Microsoft Suporte — Exibir ou alterar as propriedades de um arquivo do Office', u: `${SUP}/office/collab-files/view-or-change-the-properties-for-an-office-file` },
          { t: 'Microsoft Suporte — Remover dados ocultos e informações pessoais inspecionando pastas de trabalho', u: `${SUP}/office/collab-files/remove-hidden-data-and-personal-information-by-inspecting-documents-presentations-or-workbooks` }
        ]
      }
    ]
  },
  {
    id: 'xl-m02', title: 'Módulo 02 · Inserir e editar dados com produtividade', kind: 'video',
    lessons: [
      {
        id: 'xl-preenchimento-series', title: 'Preenchimento Automático, séries e listas personalizadas',
        desc: 'A alça de preenchimento, as Opções de Preenchimento Automático, a caixa Série (linear, crescimento, datas, incremento e limite) e as listas personalizadas.',
        objetivos: [
          'Preencher sequências de números, datas, dias e meses com a alça de preenchimento',
          'Usar a caixa Série para controlar tipo, incremento e limite',
          'Criar uma lista personalizada e usá-la no preenchimento'
        ],
        body: 'Digitar 1, 2, 3 até 500, ou os doze meses do ano, é trabalho que o Excel faz sozinho. O Preenchimento Automático reconhece o padrão das primeiras células e continua a sequência para você. Esta é uma habilidade da prova Associate ("preencher células usando o Preenchimento Automático"), e a caixa Série com opções avançadas aparece na Expert.',
        content: [
          { h: 'A alça de preenchimento',
            p: 'Toda seleção tem, no canto inferior direito, um quadradinho: a alça de preenchimento. Quando o ponteiro passa sobre ela, vira uma cruz fina preta. Arraste a alça para baixo ou para a direita e o Excel preenche as células seguindo o padrão da seleção; enquanto você arrasta, uma dica mostra o valor que vai entrar na última célula. Arrastar para cima ou para a esquerda produz a sequência em ordem decrescente.',
            items: [
              '<strong>Um número só</strong> (ex.: 2) — arrastar copia o valor: 2, 2, 2, 2.',
              '<strong>Dois números</strong> (1 e 2, ou 2 e 4) — selecione os dois e arraste: o Excel usa a diferença entre eles como passo (1, 2, 3, 4... ou 2, 4, 6, 8...).',
              '<strong>Datas</strong> — uma data só já basta: arrastar avança um dia por célula.',
              '<strong>Dias da semana e meses</strong> — digite "segunda-feira", "jan" ou "janeiro" e arraste; o Excel já conhece essas listas internas, abreviadas e por extenso.',
              '<strong>Texto com número</strong> — "Trimestre 1", "Loja 1" viram Trimestre 2, 3, 4...',
              '<strong>Duplo clique na alça</strong> — preenche para baixo até a última linha da coluna vizinha que tem dados. É o jeito mais rápido de estender uma fórmula por uma tabela de 10 mil linhas.',
              '<strong>Ctrl+D</strong> — Preencher Abaixo: copia o conteúdo e o formato da primeira célula da seleção para as células de baixo.'
            ],
            img: { src: `${XL_IMG}/m02/datas-sequenciais.png`, alt: 'Alça de preenchimento sendo arrastada para criar datas sequenciais', caption: 'Uma data e um arraste: a lista de datas sequenciais sai pronta.', source: `${SUP}/excel/get-started/create-a-list-of-sequential-dates` } },
          { h: 'Opções de Preenchimento Automático',
            p: 'Ao soltar a alça, aparece um botão no canto do intervalo preenchido: as Opções de Preenchimento Automático. Ali você corrige o que o Excel fez: <strong>Copiar Células</strong> (repete em vez de continuar a série), <strong>Preencher Série</strong>, <strong>Preencher Somente Formatação</strong>, <strong>Preencher sem Formatação</strong> e, para datas, <strong>Preencher Dias</strong>, <strong>Preencher Dias da Semana</strong> (pula sábados e domingos), <strong>Preencher Meses</strong> e <strong>Preencher Anos</strong>. A opção Preenchimento Relâmpago também aparece nessa lista. Arrastar a alça com o botão direito do mouse abre as mesmas opções assim que você solta.' },
          { h: 'A caixa Série: controle total',
            p: 'Para uma sequência exata, digite o valor inicial, selecione o intervalo a preencher (ou só a primeira célula) e vá em Página Inicial > Edição > Preencher > <strong>Série</strong>. A caixa tem:',
            items: [
              '<strong>Série em</strong> — Linhas ou Colunas.',
              '<strong>Tipo: Linear</strong> — soma o incremento a cada passo (10, 15, 20, 25 com incremento 5).',
              '<strong>Tipo: Crescimento</strong> — multiplica pelo incremento (2, 4, 8, 16 com incremento 2). Útil para simular crescimento percentual: incremento 1,1 é crescimento de 10% ao passo.',
              '<strong>Tipo: Data</strong> — ativa a <strong>Unidade de data</strong>: Dia, Dia da semana, Mês ou Ano. Com Mês e incremento 3, sai uma data por trimestre.',
              '<strong>Tipo: AutoPreenchimento</strong> — o mesmo comportamento da alça.',
              '<strong>Incremento</strong> — o passo (pode ser negativo, para contar para trás).',
              '<strong>Limite</strong> — o valor em que a série para. Com limite, basta selecionar a primeira célula: o Excel preenche até chegar a ele, sem você precisar calcular quantas células selecionar.',
              '<strong>Tendência</strong> — calcula uma progressão (linear ou de crescimento) de melhor ajuste a partir dos valores já selecionados, ignorando o incremento digitado.'
            ] },
          { h: 'Listas personalizadas',
            p: 'Além das listas internas (dias e meses), você pode ensinar ao Excel suas próprias sequências: nomes de filiais, regiões ("Norte, Sul, Leste, Oeste"), níveis ("Alto, Médio, Baixo"). Vá em Arquivo > Opções > Avançado > seção Geral > <strong>Editar Listas Personalizadas</strong>. Digite os itens em Entradas da lista (um por linha) e clique em Adicionar — ou selecione um intervalo que já tem os itens e use <strong>Importar</strong>. A partir daí, digitar o primeiro item e arrastar a alça preenche a lista inteira, e a mesma lista pode ser usada como ordem de classificação (Módulo 05). As listas internas não podem ser editadas nem excluídas; as suas, sim. Uma lista personalizada guarda texto (ou texto com números) — não formatos como cor ou ícone.',
            img: { src: `${XL_IMG}/m02/listas-personalizadas.png`, alt: 'Caixa de diálogo Listas Personalizadas', caption: 'Arquivo > Opções > Avançado > Geral > Editar Listas Personalizadas.', source: `${SUP}/excel/create-or-delete-a-custom-list-for-sorting-and-filling-data` } },
          { h: 'Numeração que não se desfaz',
            p: 'Números preenchidos com a alça são valores fixos: se você excluir ou inserir linhas no meio, a numeração fica com buracos e precisa ser preenchida de novo. Numeração que se ajusta sozinha usa fórmula — por exemplo, a função LIN (ROW), que devolve o número da linha — ou a função SEQUÊNCIA (SEQUENCE), que veremos no módulo de matrizes dinâmicas. Transformar o intervalo em tabela do Excel (Módulo 05) faz a fórmula se estender sozinha às linhas novas.' },
          { h: 'Como isso cai na prova',
            items: [
              '"Preencha o intervalo com os meses..." ou "...com a série de datas somente em dias úteis" — alça + Preencher Dias da Semana, ou caixa Série com Unidade de data = Dia da semana.',
              '"Preencha com valores de 5 em 5 até 200" — caixa Série: Linear, incremento 5, limite 200.',
              'A tarefa pode pedir para preencher "sem alterar a formatação" — escolha Preencher sem Formatação nas opções.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Preencher dados automaticamente nas células', u: `${SUP}/excel/get-started/fill-data-automatically-in-worksheet-cells` },
          { t: 'Microsoft Suporte — Criar uma lista de datas sequenciais', u: `${SUP}/excel/get-started/create-a-list-of-sequential-dates` },
          { t: 'Microsoft Suporte — Numerar linhas automaticamente', u: `${SUP}/excel/get-started/automatically-number-rows-in-excel` },
          { t: 'Microsoft Suporte — Criar ou excluir uma lista personalizada', u: `${SUP}/excel/create-or-delete-a-custom-list-for-sorting-and-filling-data` }
        ]
      },
      {
        id: 'xl-preenchimento-relampago', title: 'Preenchimento Relâmpago: o Excel aprende pelo exemplo',
        desc: 'Separar, juntar e reformatar texto digitando só um ou dois exemplos, com Ctrl+E — e quando é melhor usar fórmula.',
        objetivos: [
          'Usar o Preenchimento Relâmpago para separar e combinar dados de texto',
          'Acionar o recurso por Ctrl+E ou pela guia Dados e ativá-lo nas opções',
          'Reconhecer as limitações: o resultado é estático'
        ],
        body: 'Uma coluna com "Silva, Maria" que precisa virar "Maria Silva"; CPFs sem pontuação que precisam de pontos e traço; e-mails de onde se quer só o nome do usuário. Antes você precisaria de fórmulas de texto. O Preenchimento Relâmpago (Flash Fill) resolve pelo exemplo: você digita o resultado esperado em uma ou duas linhas e ele deduz a regra para o resto. É uma habilidade cobrada na prova Expert.',
        content: [
          { h: 'Como funciona',
            items: [
              'Coloque a coluna do resultado imediatamente ao lado dos dados de origem (o recurso lê as colunas vizinhas).',
              'Na primeira linha, digite o resultado que você quer — por exemplo, o nome completo a partir das colunas Nome e Sobrenome — e pressione Enter.',
              'Comece a digitar o segundo exemplo: o Excel mostra, em cinza, uma prévia do restante da coluna. Pressione Enter para aceitar.',
              'Se a prévia não aparecer, use <strong>Dados > Ferramentas de Dados > Preenchimento Relâmpago</strong> ou <strong>Ctrl+E</strong> com a célula de baixo do exemplo selecionada.',
              'Se o padrão sair errado em alguma linha, corrija essa linha à mão: o Excel refaz as demais levando a correção em conta.'
            ],
            img: { src: `${XL_IMG}/m02/preenchimento-relampago.png`, alt: 'Coluna Nome Completo sendo preenchida pelo Preenchimento Relâmpago a partir de Nome e Sobrenome', caption: 'Depois de um exemplo, a prévia em cinza propõe o resto da coluna (imagem original em inglês).', source: `${SUP}/excel/using-flash-fill-in-excel` } },
          { h: 'Exemplos típicos',
            items: [
              'Separar nome e sobrenome de uma coluna "Nome completo".',
              'Juntar dados de duas colunas com um separador ("São Paulo - SP").',
              'Extrair parte de um código: "BR-2026-0045" vira "0045".',
              'Padronizar maiúsculas: "maria silva" vira "Maria Silva".',
              'Formatar números digitados sem máscara: "12345678901" vira "123.456.789-01".'
            ] },
          { h: 'Ativar ou desativar',
            p: 'A prévia automática depende da opção <strong>Preenchimento Relâmpago Automático</strong>, em Arquivo > Opções > Avançado > Opções de edição. Mesmo com ela desligada, Ctrl+E e o botão da guia Dados continuam funcionando.' },
          { h: 'Limitação importante: o resultado é fixo',
            p: 'O Preenchimento Relâmpago escreve valores, não fórmulas. Se a coluna de origem mudar, a coluna preenchida não acompanha — é preciso rodar de novo. Por isso ele é ótimo para limpar dados uma vez, e as fórmulas de texto (Módulo 08) são melhores quando os dados chegam atualizados toda semana. Para separar por um delimitador fixo (vírgula, ponto e vírgula), o comando Texto para Colunas (Módulo 04) também é uma opção.' },
          { h: 'Como isso cai na prova',
            items: [
              '"Use o Preenchimento Relâmpago para preencher a coluna..." — digite o primeiro exemplo exatamente como pedido e use Ctrl+E; confira algumas linhas no fim.',
              'Se a tarefa exigir que o resultado se atualize sozinho, o que se pede é uma fórmula, não o Preenchimento Relâmpago.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Usar o Preenchimento Relâmpago no Excel', u: `${SUP}/excel/using-flash-fill-in-excel` }
        ]
      },
      {
        id: 'xl-copiar-colar-especial', title: 'Recortar, copiar, colar e Colar Especial',
        desc: 'O que Ctrl+V cola de verdade, as opções do menu Colar, a caixa Colar Especial com operações, Transpor e Colar Vínculo, e a Área de Transferência do Office.',
        objetivos: [
          'Escolher entre colar tudo, só valores, só fórmulas ou só formatação',
          'Usar Colar Especial para operações, transpor, ignorar em branco e colar vínculo',
          'Usar a Área de Transferência do Office para colar itens copiados antes'
        ],
        body: 'Copiar e colar é a primeira coisa que todo mundo aprende — e a fonte de muitos estragos: a fórmula que chega quebrada, a formatação da origem que bagunça a planilha de destino, o relatório que continua ligado à base. A prova Associate cobra "colar dados usando as opções especiais de colagem", e nesta aula você vê cada uma delas.',
        content: [
          { h: 'Recortar x copiar',
            items: [
              '<strong>Copiar</strong> (Ctrl+C) — a origem fica como está; uma borda tracejada animada marca o que foi copiado. Esc cancela a borda.',
              '<strong>Recortar</strong> (Ctrl+X) — a origem é movida para onde você colar. Fórmulas recortadas mantêm as referências originais; fórmulas copiadas ajustam as referências relativas à nova posição (detalhes no Módulo 06).',
              '<strong>Colar</strong> (Ctrl+V) — cola tudo: valores, fórmulas, formatação, validação e comentários.'
            ] },
          { h: 'O menu Colar',
            p: 'A seta embaixo do botão Colar (Página Inicial > Área de Transferência) — ou o botão Opções de Colagem que aparece depois de colar — oferece ícones para as situações mais comuns:',
            items: [
              '<strong>Colar</strong> — tudo.',
              '<strong>Fórmulas</strong> — só as fórmulas, sem formatação.',
              '<strong>Valores</strong> — só os resultados, como aparecem na célula. É a opção para "congelar" um cálculo ou para levar dados a outro arquivo sem vínculo com fórmulas.',
              '<strong>Formatação</strong> — só o formato (cores, bordas, formato de número), sem conteúdo.',
              '<strong>Valores e Formatação da Origem</strong> — resultados com a aparência original.',
              '<strong>Manter Larguras da Coluna de Origem</strong> — tudo, mais a largura das colunas.',
              '<strong>Transpor</strong> — o que estava em linhas vai para colunas e vice-versa.',
              '<strong>Colar Vínculo</strong> — cria fórmulas que apontam para as células de origem (<code>=Plan1!B4</code>); mudou a origem, muda o destino.',
              '<strong>Imagem</strong> e <strong>Imagem Vinculada</strong> — uma figura das células; a vinculada se atualiza quando as células de origem mudam.'
            ] },
          { h: 'A caixa Colar Especial',
            p: 'Página Inicial > Colar > <strong>Colar Especial</strong> (atalho Ctrl+Alt+V) abre a caixa completa. Em <strong>Colar</strong> você escolhe um atributo: Tudo, Fórmulas, Valores, Formatos, Comentários e Notas, Validação, Tudo usando tema da origem, Tudo exceto bordas, Larguras da coluna, Fórmulas e formatos de número, Valores e formatos de número, Todos mesclando formatos condicionais. Abaixo ficam as <strong>Operações</strong> e as caixas <strong>Ignorar em branco</strong> e <strong>Transpor</strong>, além do botão <strong>Colar vínculo</strong>. Algumas opções ficam acinzentadas conforme o que foi copiado.' },
          { h: 'Operações: calcular ao colar',
            p: 'As operações Adicionar, Subtrair, Multiplicar e Dividir combinam o que você copiou com o que já está no destino. Exemplo clássico: reajustar 300 preços em 10% sem criar coluna auxiliar. Digite 1,1 numa célula vazia, copie, selecione os preços, abra Colar Especial, marque Valores e Multiplicar e dê OK — todos os preços são multiplicados por 1,1. Depois apague o 1,1. O mesmo truque converte números armazenados como texto: copie uma célula com 1 e cole com Multiplicar.' },
          { h: 'Ignorar em branco e Transpor',
            p: '<strong>Ignorar em branco</strong> impede que células vazias da origem apaguem valores que já existem no destino — útil para atualizar só alguns itens de uma lista. <strong>Transpor</strong> gira o intervalo: cabeçalhos que estavam na coluna A passam para a linha 1. O intervalo tem de ser copiado (Transpor não funciona com Recortar), e o destino não pode se sobrepor à origem. Dentro de uma tabela do Excel a opção não fica disponível — converta em intervalo ou use a função TRANSPOR (TRANSPOSE).',
            img: { src: `${XL_IMG}/m02/transpor-antes.jpg`, alt: 'Dados de vendas com regiões nas colunas e trimestres nas linhas', caption: 'Antes: regiões nos títulos das colunas, trimestres nas linhas.', source: `${SUP}/excel/transpose-rotate-data-from-rows-to-columns-or-vice-versa` } },
          { h: 'Depois de transpor',
            img: { src: `${XL_IMG}/m02/transpor-depois.jpg`, alt: 'Os mesmos dados com trimestres nas colunas e regiões nas linhas', caption: 'Depois de Colar > Transpor: trimestres viram colunas e regiões viram linhas.', source: `${SUP}/excel/transpose-rotate-data-from-rows-to-columns-or-vice-versa` } },
          { h: 'Área de Transferência do Office',
            p: 'A setinha do grupo Área de Transferência (Página Inicial) abre um painel que guarda os últimos itens copiados — até 24 — de qualquer programa do Office. Clique num item para colá-lo, ou em Colar Tudo. É útil para juntar trechos de vários lugares sem ficar indo e voltando.' },
          { h: 'Pincel de Formatação',
            p: 'Para copiar só o formato de uma célula para outras, o caminho mais rápido é o <strong>Pincel de Formatação</strong> (Página Inicial > Área de Transferência): clique na célula modelo, clique no pincel e depois arraste sobre o destino. Duplo clique no pincel mantém a ferramenta ativa para vários destinos, até você pressionar Esc. Voltaremos a ele no Módulo 03.' },
          { h: 'Como isso cai na prova',
            items: [
              '"Cole somente os valores" / "cole a formatação" / "transponha os dados para..." — são opções do menu Colar ou da caixa Colar Especial; a prova confere o conteúdo e o formato da célula de destino.',
              '"Aumente todos os valores em 5% sem usar fórmulas" — Colar Especial com a operação Multiplicar.',
              'Cuidado com Colar comum quando a tarefa pede "sem a formatação da origem".'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Opções de Colagem', u: `${SUP}/excel/paste-options` },
          { t: 'Microsoft Suporte — Transpor (girar) dados de linhas para colunas', u: `${SUP}/excel/transpose-rotate-data-from-rows-to-columns-or-vice-versa` },
          { t: 'Microsoft Suporte — Mover ou copiar células, linhas e colunas', u: `${SUP}/excel/move-or-copy-cells-rows-and-columns` }
        ]
      },
      {
        id: 'xl-inserir-mover-celulas', title: 'Inserir, excluir e mover células, linhas e colunas',
        desc: 'Inserir e excluir células deslocando as vizinhas, inserir várias linhas de uma vez, o botão Opções de Inserção e mover ou copiar arrastando com Ctrl e Shift.',
        objetivos: [
          'Inserir e excluir várias linhas, colunas e células, escolhendo o deslocamento',
          'Controlar a formatação das linhas inseridas',
          'Mover e copiar dados arrastando, com e sem inserir'
        ],
        body: 'Reorganizar uma planilha pronta — abrir espaço para um produto novo, tirar uma coluna que sobrou, trocar a ordem de duas colunas — sem estragar o que já está lá exige conhecer as variações de inserir, excluir e mover. A prova Associate cobra "inserir e excluir várias colunas ou linhas" e "inserir e excluir células".',
        content: [
          { h: 'Várias linhas ou colunas de uma vez',
            items: [
              'Selecione tantas linhas quantas quiser inserir (ex.: 5 linhas, arrastando pelos números) e clique com o botão direito > Inserir: entram 5 linhas novas acima da seleção. Com colunas, as novas entram à esquerda.',
              'Pelo menu: Página Inicial > Células > Inserir > Inserir Linhas na Planilha / Inserir Colunas na Planilha (com qualquer célula da linha ou coluna selecionada).',
              'Excluir: selecione as linhas ou colunas e clique com o botão direito > Excluir, ou Página Inicial > Excluir > Excluir Linhas na Planilha. As de baixo sobem (ou as da direita vêm para a esquerda).',
              'Atalhos: <strong>Ctrl++</strong> (Ctrl e o sinal de mais) insere e <strong>Ctrl+-</strong> (Ctrl e o sinal de menos) exclui; com uma linha ou coluna inteira selecionada, agem direto sobre ela.'
            ] },
          { h: 'Opções de Inserção: a formatação da linha nova',
            p: 'A linha inserida herda a formatação da linha de cima (e a coluna, a da esquerda). Logo depois de inserir aparece o botão <strong>Opções de Inserção</strong>, com Formatar Igual à de Cima, Formatar Igual à de Baixo e Limpar Formatação. Se o botão não aparecer, ele é ativado em Arquivo > Opções > Avançado > Recortar, copiar e colar > Mostrar botões de Opções de Inserção.',
            img: { src: `${XL_IMG}/m02/opcoes-insercao.jpg`, alt: 'Botão Opções de Inserção exibido após inserir linhas', caption: 'Opções de Inserção: escolha de onde a nova linha herda a formatação.', source: `${SUP}/excel/get-started/insert-or-delete-rows-and-columns-in-excel` } },
          { h: 'Inserir e excluir só células',
            p: 'Às vezes você não quer a linha inteira — só abrir espaço em um bloco. Selecione as células e clique com o botão direito > Inserir: a caixa pergunta como abrir espaço — <strong>Deslocar células para a direita</strong>, <strong>Deslocar células para baixo</strong>, <strong>Linha inteira</strong> ou <strong>Coluna inteira</strong>. Excluir células faz a pergunta inversa: <strong>Deslocar células para a esquerda</strong> ou <strong>para cima</strong>. Cuidado: deslocar só um pedaço da planilha desalinha os dados que estão ao lado — se a linha 5 tem cliente e valor em colunas diferentes, deslocar só a coluna do valor coloca cada valor na linha do cliente errado.' },
          { h: 'Mover e copiar arrastando',
            p: 'Selecione o intervalo e aponte para a borda da seleção até o ponteiro virar uma seta de quatro pontas. Então:',
            items: [
              '<strong>Arrastar</strong> — move e substitui o que houver no destino (o Excel avisa antes de substituir dados).',
              '<strong>Ctrl + arrastar</strong> — copia (aparece um sinal de + no ponteiro) e substitui o destino.',
              '<strong>Shift + arrastar</strong> — move inserindo: os dados entram entre as linhas ou colunas, sem apagar nada. É a forma mais rápida de trocar a ordem de duas colunas.',
              '<strong>Ctrl+Shift + arrastar</strong> — copia inserindo.',
              'Solte o botão do mouse antes de soltar Ctrl ou Shift; se soltar a tecla antes, a operação vira um movimento comum.'
            ] },
          { h: 'Inserir Células Recortadas e Inserir Células Copiadas',
            p: 'O mesmo "inserir em vez de substituir" funciona pelo teclado: recorte (ou copie) o intervalo, clique com o botão direito na célula de destino e escolha <strong>Inserir Células Recortadas</strong> (ou Inserir Células Copiadas). O Excel abre espaço e empurra os dados existentes.' },
          { h: 'Como isso cai na prova',
            items: [
              '"Insira três linhas acima da linha 8" — selecione as linhas 8 a 10 e insira de uma vez.',
              '"Exclua as células B4:B6 deslocando as demais para cima" — é excluir células (não linhas inteiras) com a opção de deslocamento pedida.',
              '"Mova a coluna Total para depois da coluna Janeiro" — recorte e Inserir Células Recortadas, ou Shift + arrastar.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Inserir ou excluir linhas e colunas', u: `${SUP}/excel/get-started/insert-or-delete-rows-and-columns-in-excel` },
          { t: 'Microsoft Suporte — Mover ou copiar células, linhas e colunas', u: `${SUP}/excel/move-or-copy-cells-rows-and-columns` }
        ]
      },
      {
        id: 'xl-localizar-substituir-links', title: 'Localizar, Substituir, Ir para Especial e hiperlinks',
        desc: 'Pesquisar na planilha ou na pasta toda com curingas e formatos, substituir em massa, selecionar tipos de célula com Ir para Especial e criar, editar e remover hiperlinks.',
        objetivos: [
          'Localizar e substituir com as opções Em, Pesquisar, Examinar, maiúsculas e conteúdo inteiro',
          'Usar curingas (*, ? e ~) e pesquisar por formato',
          'Selecionar células em branco, fórmulas, constantes e células visíveis com Ir para Especial',
          'Inserir, editar e remover hiperlinks para páginas, locais da pasta, arquivos e e-mail'
        ],
        body: 'Em uma planilha com milhares de linhas, achar "aquele cliente" ou trocar o nome de um produto em todos os lugares não se faz no olho. Esta aula reúne as ferramentas de busca e as de navegação por link — todas na lista de habilidades da prova Associate ("pesquisar dados em uma pasta de trabalho" e "inserir e remover hiperlinks").',
        content: [
          { h: 'Localizar',
            p: 'Página Inicial > Edição > Localizar e Selecionar > <strong>Localizar</strong> (ou Shift+F5; no Excel em português também Ctrl+L). Digite o que procura e clique em <strong>Localizar Próxima</strong> (vai de uma em uma) ou <strong>Localizar Tudo</strong> (lista todas as ocorrências embaixo da caixa; clicar numa linha da lista seleciona a célula; com Shift+clique na última linha da lista, todas as encontradas ficam selecionadas). O botão <strong>Opções >></strong> revela os refinamentos:',
            items: [
              '<strong>Em</strong> — Planilha (só a ativa) ou Pasta de trabalho (todas as planilhas).',
              '<strong>Pesquisar</strong> — Por linhas (padrão) ou Por colunas: a ordem em que Localizar Próxima percorre as células.',
              '<strong>Examinar</strong> — Fórmulas, Valores, Notas ou Comentários. A diferença importa: se C2 contém <code>=A2*B2</code> e mostra 150, procurar "150" em Fórmulas não acha nada; em Valores, acha.',
              '<strong>Diferenciar maiúsculas e minúsculas</strong> — "SP" não casa com "sp".',
              '<strong>Coincidir conteúdo da célula inteira</strong> — procurar "Rio" não acha "Rio Verde".',
              '<strong>Formatar</strong> — procura por formato (ex.: todas as células com preenchimento amarelo), com ou sem texto; Escolher Formato da Célula copia o formato de uma célula de exemplo.'
            ],
            img: { src: `${XL_IMG}/m02/localizar.jpg`, alt: 'Caixa Localizar e Substituir com as opções expandidas', caption: 'Localizar com as Opções expandidas: Em, Pesquisar, Examinar e as caixas de correspondência (imagem original em inglês).', source: `${SUP}/excel/get-started/find-or-replace-text-and-numbers-on-a-worksheet` } },
          { h: 'Curingas',
            items: [
              '<strong>?</strong> (ponto de interrogação) — um caractere qualquer: "s?l" acha "sal" e "sol".',
              '<strong>*</strong> (asterisco) — qualquer quantidade de caracteres: "*ltda" acha todas as empresas que terminam em "ltda".',
              '<strong>~</strong> (til) — trata o próximo caractere como literal: "~*" procura um asterisco de verdade; "~?" procura um ponto de interrogação.'
            ] },
          { h: 'Substituir',
            p: 'A guia <strong>Substituir</strong> da mesma caixa (Página Inicial > Localizar e Selecionar > Substituir) acrescenta a caixa <strong>Substituir por</strong>. <strong>Substituir</strong> troca a ocorrência atual e vai para a próxima; <strong>Substituir Tudo</strong> troca todas de uma vez e informa quantas foram. Aqui a opção Examinar só oferece Fórmulas. Três cuidados: (1) antes de Substituir Tudo, use Localizar Tudo para ver o que vai ser atingido; (2) sem "Coincidir conteúdo da célula inteira", trocar "SP" por "São Paulo" também altera "SPA" e "ESPORTE"; (3) Substituir Tudo pode ser desfeito com Ctrl+Z logo em seguida. Também é possível substituir formatos: deixe as caixas de texto vazias e use os botões Formatar de cada lado.' },
          { h: 'Ir para Especial',
            p: 'Localizar e Selecionar > <strong>Ir para Especial</strong> (ou F5 > Especial) seleciona células por tipo, em vez de por conteúdo. Com um intervalo selecionado, age só nele; com uma célula só, na planilha inteira. As opções mais usadas:',
            items: [
              '<strong>Em branco</strong> — seleciona as vazias. Truque clássico para preencher buracos: selecione, digite o valor (ou uma fórmula) e pressione Ctrl+Enter para enviar a todas as selecionadas de uma vez.',
              '<strong>Constantes</strong> e <strong>Fórmulas</strong> — separam o que foi digitado do que é calculado (com caixas para números, texto, lógicos e erros).',
              '<strong>Somente células visíveis</strong> — com linhas ocultas ou filtradas, copiar só as visíveis (atalho Alt+; — Alt e ponto e vírgula).',
              '<strong>Região atual</strong>, <strong>Última célula</strong>, <strong>Objetos</strong>, <strong>Diferenças de linha/coluna</strong>, <strong>Precedentes/Dependentes</strong>, <strong>Formatos condicionais</strong> e <strong>Validação de dados</strong>.'
            ] },
          { h: 'Hiperlinks',
            p: 'Um hiperlink torna uma célula (ou uma forma, imagem ou elemento de gráfico) clicável. Selecione a célula e use Inserir > <strong>Link</strong> (ou Ctrl+K, ou botão direito > Link). Em <strong>Vincular a</strong>, escolha o destino:',
            items: [
              '<strong>Arquivo ou Página da Web Existente</strong> — digite o endereço (URL) ou escolha um arquivo.',
              '<strong>Colocar neste Documento</strong> — uma planilha e referência de célula da própria pasta, ou um nome definido. Ótimo para criar um "índice" clicável na primeira planilha.',
              '<strong>Criar Novo Documento</strong> — cria um arquivo novo e o vincula.',
              '<strong>Endereço de Email</strong> — abre uma mensagem nova no programa de e-mail, com destinatário e assunto preenchidos.',
              '<strong>Texto para exibição</strong> — o que aparece na célula (em vez do endereço cru); <strong>Dica de Tela</strong> — o texto que aparece ao passar o mouse.'
            ] },
          { h: 'Editar e remover hiperlinks',
            p: 'Para selecionar uma célula com link sem abri-lo, clique e segure até o ponteiro virar uma cruz, ou use as setas do teclado. Botão direito > <strong>Editar Link</strong> abre a mesma caixa para mudar destino, texto ou dica. Botão direito > <strong>Remover Link</strong> tira o link e mantém o texto (para vários de uma vez: selecione o intervalo e escolha Remover Hiperlinks no mesmo menu). Digitar um endereço como www.exemplo.com.br ou um e-mail numa célula já cria o link automaticamente; Ctrl+Z logo após desfaz só a conversão em link. Links também podem ser criados por fórmula com a função HIPERLINK (HYPERLINK).' },
          { h: 'Como isso cai na prova',
            items: [
              '"Localize a célula que contém..." costuma ser o primeiro passo de uma tarefa maior — use Localizar com Em: Pasta de trabalho quando a planilha não é informada.',
              '"Substitua todas as ocorrências de..." — confira Coincidir conteúdo da célula inteira e maiúsculas, conforme o enunciado.',
              '"Insira um hiperlink na célula A1 que leve à célula B10 da planilha Resumo, com o texto de exibição Voltar" — Colocar neste Documento, referência B10, Texto para exibição "Voltar".',
              '"Remova o hiperlink, mantendo o texto" — Remover Link (não apague a célula).'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Localizar ou substituir texto e números', u: `${SUP}/excel/get-started/find-or-replace-text-and-numbers-on-a-worksheet` },
          { t: 'Microsoft Suporte — Localizar e selecionar células que atendem a condições específicas', u: `${SUP}/excel/find-and-select-cells-that-meet-specific-conditions-in-excel` },
          { t: 'Microsoft Suporte — Trabalhar com links no Excel', u: `${SUP}/excel/work-with-links-in-excel` }
        ]
      }
    ]
  }
];
