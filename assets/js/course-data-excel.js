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
  },
  {
    id: 'xl-m03', title: 'Módulo 03 · Formatação de células e planilhas', kind: 'video',
    lessons: [
      {
        id: 'xl-fonte-alinhamento', title: 'Fonte, bordas, preenchimento, alinhamento e mesclagem',
        desc: 'A caixa Formatar Células e seus atalhos na faixa de opções: fonte, bordas e cores, alinhamento horizontal e vertical, recuo, orientação, quebra de texto e as quatro opções de mesclar.',
        objetivos: [
          'Aplicar fonte, bordas e preenchimento pela faixa de opções e pela caixa Formatar Células',
          'Alinhar, recuar, girar e quebrar texto dentro da célula',
          'Mesclar e desfazer mesclagem sabendo o que se perde — e conhecer a alternativa Centralizar Seleção'
        ],
        body: 'Formatação não muda o valor de nenhuma célula, mas decide se a planilha vai ser lida em dez segundos ou ignorada. Neste módulo você vê as ferramentas de formatação que a prova Associate lista uma a uma: mesclar, alinhamento, orientação, recuo, quebra de texto, Pincel de Formatação, formatos de número, estilos de célula e limpar formatação.',
        content: [
          { h: 'A caixa Formatar Células (Ctrl+1)',
            p: 'Os grupos Fonte, Alinhamento e Número da guia Página Inicial têm os comandos mais usados; a caixa <strong>Formatar Células</strong> tem todos. Abra com <strong>Ctrl+1</strong>, com botão direito > Formatar Células, ou pela setinha no canto dos grupos. Ela tem seis guias: <strong>Número</strong>, <strong>Alinhamento</strong>, <strong>Fonte</strong>, <strong>Borda</strong>, <strong>Preenchimento</strong> e <strong>Proteção</strong>. Quando uma tarefa pede algo que não está na faixa de opções — um ângulo exato de rotação, um estilo de borda diagonal, um efeito de preenchimento em gradiente — o caminho é essa caixa.' },
          { h: 'Fonte, bordas e preenchimento',
            items: [
              '<strong>Fonte</strong> — tipo, tamanho, negrito, itálico, sublinhado, cor da fonte. Aumentar Tamanho da Fonte e Diminuir Tamanho da Fonte ajustam de um em um degrau.',
              '<strong>Bordas</strong> — a seta do botão Bordas oferece as combinações comuns (Todas as Bordas, Borda Externa, Borda Inferior Dupla...). Em Mais Bordas (a guia Borda da caixa Formatar Células) você escolhe estilo de linha e cor primeiro e depois clica onde aplicar — contorno, interna ou cada lado. Sem Borda remove.',
              '<strong>Cor de Preenchimento</strong> — o fundo da célula. A guia Preenchimento também oferece padrões e efeitos de preenchimento (gradiente).',
              'As cores das paletas seguem o <strong>tema</strong> da pasta de trabalho (Layout da Página > Temas). Trocar o tema troca as cores de tema de uma vez; as "Cores Padrão" da paleta não mudam com o tema.'
            ] },
          { h: 'Alinhamento horizontal, vertical e recuo',
            p: 'No grupo Alinhamento ficam Alinhar em Cima, Alinhar no Meio e Alinhar Embaixo (vertical) e Alinhar à Esquerda, Centralizar e Alinhar à Direita (horizontal). <strong>Aumentar Recuo</strong> e <strong>Diminuir Recuo</strong> afastam o conteúdo da borda da célula — útil para mostrar hierarquia (subcontas recuadas sob a conta principal). A guia Alinhamento da caixa Formatar Células tem ainda Justificar, Distribuído, Preencher e <strong>Centralizar seleção</strong>.' },
          { h: 'Orientação: girar o texto',
            p: 'O botão <strong>Orientação</strong> (o "ab" inclinado no grupo Alinhamento) gira o texto: Girar Texto para Cima, para Baixo, no Sentido Anti-Horário, no Sentido Horário, ou Texto Vertical (letras empilhadas). Para um ângulo exato, use Orientação > <strong>Formatar Alinhamento da Célula</strong> e digite os graus, de -90 a 90: positivos giram para cima, negativos para baixo. É o recurso para cabeçalhos de colunas estreitas.',
            img: { src: `${XL_IMG}/m03/texto-girado.png`, alt: 'Texto girado em diferentes ângulos', caption: 'O mesmo texto em vários ângulos de orientação.', source: `${SUP}/excel/get-started/align-or-rotate-text-in-a-cell` } },
          { h: 'Quebrar texto e quebra de linha manual',
            p: '<strong>Quebrar Texto Automaticamente</strong> faz o conteúdo ocupar várias linhas dentro da célula, conforme a largura da coluna — se a coluna mudar de largura, a quebra se ajusta. Se o texto quebrado não aparecer inteiro, a linha provavelmente tem altura fixa: use Formatar > AutoAjuste da Altura da Linha. Para quebrar num ponto escolhido, edite a célula (F2), posicione o cursor e pressione <strong>Alt+Enter</strong>: é uma quebra de linha manual, que liga automaticamente a opção Quebrar Texto.',
            img: { src: `${XL_IMG}/m03/quebrar-texto.png`, alt: 'Botão Quebrar Texto Automaticamente no grupo Alinhamento', caption: 'Página Inicial > Alinhamento > Quebrar Texto Automaticamente.', source: `${SUP}/excel/wrap-text-in-a-cell-in-excel` } },
          { h: 'Mesclar células',
            p: 'A seta de <strong>Mesclar e Centralizar</strong> tem quatro opções:',
            items: [
              '<strong>Mesclar e Centralizar</strong> — junta as células selecionadas em uma só e centraliza o conteúdo (o clássico título sobre várias colunas).',
              '<strong>Mesclar através</strong> — com várias linhas selecionadas, mescla cada linha separadamente.',
              '<strong>Mesclar Células</strong> — junta sem centralizar.',
              '<strong>Desmesclar Células</strong> — desfaz a mesclagem, devolvendo células separadas.'
            ],
            img: { src: `${XL_IMG}/m03/mesclar-celulas.jpg`, alt: 'Título mesclado sobre várias colunas', caption: 'A1:C1 mescladas formam o rótulo que descreve as colunas abaixo.', source: `${SUP}/excel/get-started/merge-and-unmerge-cells-in-excel` } },
          { h: 'Cuidados com a mesclagem',
            p: 'Ao mesclar, só o conteúdo da célula superior esquerda sobrevive — os valores das outras células são apagados (o Excel avisa). Células mescladas também atrapalham: impedem classificar, filtrar e copiar colunas normalmente, e não existem dentro de tabelas do Excel (o botão fica desabilitado). Para títulos sobre várias colunas sem esses efeitos colaterais, prefira <strong>Centralizar seleção</strong> (Formatar Células > Alinhamento > Horizontal): o texto aparece centralizado sobre as colunas, mas cada célula continua independente. Não é possível dividir uma célula que nunca foi mesclada; para separar conteúdo de uma célula em várias colunas, o recurso é Texto para Colunas (Módulo 04).' },
          { h: 'Como isso cai na prova',
            items: [
              '"Mescle e centralize A1:F1" — atenção à seleção exata do enunciado.',
              '"Gire o texto das células B3:M3 para 45 graus" — Formatar Alinhamento da Célula, Graus = 45.',
              '"Quebre o texto na célula" e "aplique recuo de 2" — o recuo exato é digitado na guia Alinhamento (campo Recuo).',
              'A prova verifica o formato da célula, não a aparência: centralizar com espaços digitados não conta.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Mesclar e desfazer mesclagem de células', u: `${SUP}/excel/get-started/merge-and-unmerge-cells-in-excel` },
          { t: 'Microsoft Suporte — Alinhar ou girar texto em uma célula', u: `${SUP}/excel/get-started/align-or-rotate-text-in-a-cell` },
          { t: 'Microsoft Suporte — Quebrar texto automaticamente em uma célula', u: `${SUP}/excel/wrap-text-in-a-cell-in-excel` },
          { t: 'Microsoft Suporte — Aplicar ou remover bordas de célula', u: `${SUP}/excel/apply-or-remove-cell-borders-on-a-worksheet` }
        ]
      },
      {
        id: 'xl-formatos-numero', title: 'Formatos de número: moeda, contábil, porcentagem, data e texto',
        desc: 'O que cada formato interno faz, a diferença entre valor e exibição, como o Excel guarda datas e horas, números armazenados como texto e os truques para o Excel não transformar o que você digita.',
        objetivos: [
          'Aplicar os formatos internos e ajustar casas decimais',
          'Entender que o formato muda só a exibição, nunca o valor',
          'Saber como datas e horas são guardadas e evitar conversões indesejadas'
        ],
        body: 'O mesmo número 0,25 pode aparecer como 0,25, 25%, R$ 0,25, 1/4 ou 06:00 — tudo depende do formato de número. Entender que o formato é só uma "máscara" sobre o valor evita metade dos erros de relatório: o total que "não bate" porque os centavos estão escondidos, a data que vira número, o CEP que perde o zero da frente.',
        content: [
          { h: 'Onde ficam os formatos',
            p: 'Na guia Página Inicial, grupo Número: a caixa de lista Formato de Número (Geral, Número, Moeda, Contábil, Data Abreviada, Data Completa, Hora, Porcentagem, Fração, Científico, Texto) e botões rápidos — Formato de Número de Contabilização, Estilo de Porcentagem, Separador de Milhares, <strong>Aumentar Casas Decimais</strong> e <strong>Diminuir Casas Decimais</strong>. A lista completa, com todas as opções de cada formato, está em Ctrl+1 > guia Número.',
            img: { src: `${XL_IMG}/m03/formatos-de-numero.png`, alt: 'Lista de formatos de número da guia Página Inicial', caption: 'Página Inicial > Número > Formato de Número.', source: `${SUP}/excel/get-started/available-number-formats-in-excel` } },
          { h: 'Os formatos internos',
            items: [
              '<strong>Geral</strong> — o padrão: mostra o número como digitado; se não couber, arredonda decimais, e números com 12 dígitos ou mais aparecem em notação científica.',
              '<strong>Número</strong> — escolha de casas decimais, separador de milhar e forma dos negativos (com sinal, em vermelho, entre parênteses).',
              '<strong>Moeda</strong> — símbolo da moeda colado ao número (R$ 1.250,00).',
              '<strong>Contábil</strong> — também monetário, mas alinha o símbolo na borda esquerda da célula e as vírgulas decimais na coluna; zero aparece como um traço. É o formato de demonstrativos financeiros.',
              '<strong>Data</strong> e <strong>Hora</strong> — vários estilos; os que começam com asterisco na lista acompanham as configurações regionais do Windows.',
              '<strong>Porcentagem</strong> — multiplica o valor por 100 na exibição e acrescenta %: 0,08 aparece como 8%. Digitar 8% numa célula grava 0,08.',
              '<strong>Fração</strong> — 0,25 aparece como 1/4. <strong>Científico</strong> — 12345678901 aparece como 1,23E+10.',
              '<strong>Texto</strong> — trata o que for digitado como texto, exatamente como está (inclusive zeros à esquerda).',
              '<strong>Especial</strong> — máscaras regionais prontas, como CEP e telefone. <strong>Personalizado</strong> — seus próprios códigos (próxima aula).'
            ] },
          { h: 'Formato é máscara; o valor não muda',
            p: 'Se A1 contém 2,4567 e você diminui para uma casa decimal, a célula mostra 2,5 — mas a barra de fórmulas continua mostrando 2,4567 e os cálculos usam 2,4567. Por isso uma coluna de valores "com duas casas" pode somar um total que parece não bater: os centavos escondidos entram na conta. Se o valor precisa realmente ser arredondado, use a função ARRED (ROUND), vista no Módulo 06.',
            img: { src: `${XL_IMG}/m03/numero-vs-geral.png`, alt: 'Os mesmos números exibidos nos formatos Geral e Número', caption: 'Mesmos valores, formatos diferentes: só a exibição muda.', source: `${SUP}/excel/get-started/available-number-formats-in-excel` } },
          { h: 'Como o Excel guarda datas e horas',
            p: 'Para o Excel, data é um número: a quantidade de dias desde 1º de janeiro de 1900 (que vale 1). A data 27/09/2026 é o número 46292 formatado como data. Hora é fração de dia: 12:00 vale 0,5 e 06:00 vale 0,25. É por isso que dá para subtrair uma data de outra e obter o número de dias, e é por isso que, se você aplicar o formato Geral numa data, aparece um número de cinco dígitos — a data não "estragou", só perdeu a máscara.' },
          { h: 'Quando o Excel converte sem você pedir',
            p: 'O Excel tenta adivinhar: 12/2 vira data (12 de fevereiro), 1-5 também, 1/2 vira 1º de fevereiro, 1e9 vira 1,00E+09 e 00123 perde os zeros. Não há como desligar esse comportamento, mas há três saídas:',
            items: [
              'Formatar as células como <strong>Texto</strong> antes de digitar (Ctrl+1 > Texto) — o ideal para colunas de códigos, CEP, CPF e telefone.',
              'Começar a digitação com um <strong>apóstrofo</strong>: \'00123 fica 00123 como texto; o apóstrofo não aparece na célula.',
              'Para frações, digitar zero e espaço antes: "0 1/2" grava meio, com formato Fração.'
            ] },
          { h: 'Números armazenados como texto',
            p: 'Um número guardado como texto (vindo de sistemas, ou digitado com apóstrofo) aparece alinhado à esquerda e ganha um triângulo verde no canto da célula. Somas ignoram esses valores. Clique no ícone de aviso ao lado e escolha <strong>Converter em Número</strong>, ou use o truque do Colar Especial com Multiplicar por 1 (Módulo 02). Já códigos que nunca serão somados — CEP, CPF, matrícula — devem mesmo ficar como texto: marque Ignorar Erro para o triângulo sumir.' },
          { h: 'Como isso cai na prova',
            items: [
              '"Aplique o formato Contábil com zero casas decimais" — Ctrl+1 > Contábil, Casas decimais = 0 (o botão de contabilização sozinho aplica 2 casas).',
              '"Formate como porcentagem com uma casa decimal" — Estilo de Porcentagem + Aumentar Casas Decimais, ou Ctrl+1.',
              '"Aplique o formato Data Abreviada" — nome exato da lista Formato de Número.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Formatos de número disponíveis no Excel', u: `${SUP}/excel/get-started/available-number-formats-in-excel` },
          { t: 'Microsoft Suporte — Parar de transformar números em datas', u: `${SUP}/excel/stop-automatically-changing-numbers-to-dates` },
          { t: 'Microsoft Suporte — Formatar números como texto', u: `${SUP}/excel/format-numbers-as-text` }
        ]
      },
      {
        id: 'xl-formatos-personalizados', title: 'Formatos de número personalizados',
        desc: 'Os códigos por trás de cada formato: as quatro seções, os marcadores de dígito, texto fixo e arroba, cores, condições, datas e horas, escala por milhar e máscaras brasileiras como CPF e CEP.',
        objetivos: [
          'Ler e escrever um código de formato com até quatro seções',
          'Usar marcadores de dígito, texto fixo, cores e condições',
          'Montar formatos de data, hora acumulada, escala em milhares e máscaras de documentos'
        ],
        body: 'Quando nenhum formato interno serve — mostrar "12,5 mi" em vez de 12.500.000, negativos em vermelho com a palavra "Déficit", horas trabalhadas passando de 24, CPF com pontos e traço — você escreve o seu. Formatos personalizados são habilidade da prova Expert, e a boa notícia é que a "linguagem" tem poucas peças.',
        content: [
          { h: 'Onde criar',
            p: 'Selecione as células, Ctrl+1 > guia Número > categoria <strong>Personalizado</strong>. Escolha na lista o formato mais parecido com o que você quer e edite o código na caixa <strong>Tipo</strong>; a Amostra mostra o resultado. O formato novo fica salvo na pasta de trabalho e aparece no fim da lista. Para apagar um formato personalizado, selecione-o nessa lista e clique em Excluir (os internos não podem ser excluídos).' },
          { h: 'As quatro seções',
            p: 'Um código tem até quatro seções separadas por ponto e vírgula, nesta ordem: <strong>positivos ; negativos ; zero ; texto</strong>. Com uma seção só, ela vale para todos os números; com duas, a primeira vale para positivos e zero e a segunda para negativos. Para pular uma seção, mantenha o ponto e vírgula dela. Exemplo:',
            code: '#.##0,00;[Vermelho]-#.##0,00;"–";@' },
          { h: 'Marcadores de dígito',
            items: [
              '<strong>0</strong> (zero) — dígito obrigatório: completa com zeros. Com duas casas obrigatórias (0,00), 8,9 aparece como 8,90; com cinco zeros (00000), 45 aparece como 00045.',
              '<strong>#</strong> (cerquilha) — dígito opcional: não mostra zeros insignificantes. Com duas cerquilhas depois da vírgula, 8,9 continua aparecendo como 8,9.',
              '<strong>?</strong> (ponto de interrogação) — como o zero, mas coloca um espaço no lugar do zero insignificante, alinhando vírgulas decimais numa coluna.',
              '<strong>Separadores</strong> — no Excel em português, a vírgula é o decimal e o ponto é o milhar. Se houver mais decimais no número do que marcadores no formato, a exibição é arredondada.',
              '<strong>Escala por milhar</strong> — um ponto de milhar no fim do código divide a exibição por mil; dois pontos, por um milhão. O formato abaixo mostra 12.500.000 como 12,5 mi:'
            ],
            code: '#.##0,0.. "mi"' },
          { h: 'Texto, espaços e caracteres literais',
            items: [
              'Texto fixo vai entre aspas duplas: <code>0 "unid."</code> mostra 25 como "25 unid.". Um único caractere pode vir precedido de barra invertida.',
              'Alguns caracteres aparecem sem aspas: R$, sinais + e -, parênteses, dois-pontos, barra, espaço.',
              '<strong>@</strong> (arroba) na seção de texto representa o texto digitado: o formato <code>"Cliente: "@</code> transforma "ACME" em "Cliente: ACME". Se a seção de texto não tiver a arroba, o texto digitado não aparece.',
              '<strong>_</strong> (sublinhado) seguido de um caractere reserva um espaço da largura desse caractere — por exemplo, sublinhado e parêntese alinham positivos com negativos entre parênteses.',
              '<strong>*</strong> (asterisco) seguido de um caractere repete esse caractere até preencher a célula.'
            ] },
          { h: 'Cores e condições',
            p: 'Uma cor entre colchetes, no início da seção, pinta aquela seção: [Preto], [Azul], [Ciano], [Verde], [Magenta], [Vermelho], [Branco], [Amarelo]. Condições entre colchetes substituem a regra positivo/negativo, com um operador e um valor. O código abaixo mostra valores até 100 em vermelho e acima de 100 em azul. Para regras mais ricas (ícones, barras, fórmulas), o recurso é a Formatação Condicional (Módulo 10).',
            code: '[Vermelho][<=100]0;[Azul][>100]0' },
          { h: 'Datas e horas',
            items: [
              '<strong>d</strong> e <strong>dd</strong> (uma ou duas letras d) — dia sem e com zero à esquerda; <strong>ddd</strong> (três letras d) — dia da semana abreviado (seg); <strong>dddd</strong> (quatro letras d) — por extenso (segunda-feira).',
              '<strong>m</strong> e <strong>mm</strong> (uma ou duas letras m) — mês em número; <strong>mmm</strong> (três) — abreviado (set); <strong>mmmm</strong> (quatro) — por extenso (setembro); <strong>mmmmm</strong> (cinco) — só a inicial.',
              '<strong>aa</strong> e <strong>aaaa</strong> (duas ou quatro letras a) — ano com 2 ou 4 dígitos (no Excel em português o código do ano é "a").',
              '<strong>h</strong> ou <strong>hh</strong>, <strong>mm</strong> e <strong>ss</strong> (letras h, m e s) — horas, minutos e segundos. O "m" logo após "h" ou antes de "ss" é minuto; em outro lugar, é mês.',
              '<strong>[h]</strong> (h entre colchetes) — horas acumuladas: sem colchetes, 26 horas aparecem como 02:00 (o relógio "vira"); com <code>[h]:mm</code>, aparecem 26:00. Essencial para somar banco de horas.'
            ],
            code: 'dddd", "dd" de "mmmm" de "aaaa   →   domingo, 27 de setembro de 2026' },
          { h: 'Máscaras úteis no Brasil',
            p: 'CPF, CNPJ e CEP guardados como número perdem os zeros à esquerda; com um formato personalizado, o número ganha a máscara e os zeros voltam. Como o ponto é o separador de milhar no código, ele precisa de barra invertida para aparecer literalmente. Se o documento puder começar com zero e vier de outro sistema, guardá-lo como texto continua sendo a opção mais segura.',
            code: 'CPF:  000\\.000\\.000-00\nCNPJ: 00\\.000\\.000"/"0000-00\nCEP:  00000-000' },
          { h: 'Como isso cai na prova',
            items: [
              'A tarefa costuma dar o resultado esperado ("exiba os valores em milhares, com o sufixo K") e você escreve o código — teste na Amostra antes de confirmar.',
              'Lembre-se da ordem das seções e de que a prova Expert é em inglês: lá o decimal é ponto, o milhar é vírgula e o ano usa a letra y (ípsilon) — a lógica é a mesma.',
              'Não confunda formato personalizado (muda a exibição) com arredondamento (muda o valor).'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Criar um formato de número personalizado', u: `${SUP}/excel/get-started/create-a-custom-number-format` },
          { t: 'Microsoft Suporte — Diretrizes para personalizar um formato de número', u: `${SUP}/excel/review-guidelines-for-customizing-a-number-format` },
          { t: 'Microsoft Suporte — Exibir números como CEP, telefone ou documentos', u: `${SUP}/excel/display-numbers-as-postal-codes-social-security-numbers-or-phone-numbers` }
        ]
      },
      {
        id: 'xl-estilos-pincel-limpar', title: 'Estilos de célula, temas, Pincel de Formatação e Limpar',
        desc: 'Formatação consistente com estilos de célula e temas, copiar formatos com o Pincel e remover conteúdo, formatos, comentários ou links com o comando Limpar.',
        objetivos: [
          'Aplicar, criar, modificar e duplicar estilos de célula',
          'Trocar tema, cores e fontes da pasta de trabalho',
          'Copiar formatação com o Pincel e limpar só o que é necessário'
        ],
        body: 'Formatar célula por célula dá trabalho e sai inconsistente: um título em 14 pontos, outro em 13, um azul um pouco diferente. Estilos de célula e temas resolvem com um clique e mantêm o padrão em toda a pasta. Para fechar, o Pincel de Formatação e o comando Limpar — dois itens que a prova Associate cita pelo nome.',
        content: [
          { h: 'Estilos de célula',
            p: 'Página Inicial > Estilos > <strong>Estilos de Célula</strong> abre uma galeria de combinações prontas de fonte, borda, preenchimento e formato de número: Bom, Ruim e Neutro; Dados e Modelo (Cálculo, Célula de Verificação, Entrada, Saída, Nota...); Títulos e Cabeçalhos (Título, Título 1 a 4, Total); estilos temáticos com Ênfase; e Formato de Número (Moeda, Porcentagem, Vírgula). Selecione as células e clique no estilo. O estilo <strong>Normal</strong> é o padrão de todas as células — aplicar Normal devolve a célula à formatação padrão.',
            img: { src: `${XL_IMG}/m03/estilos-de-celula.png`, alt: 'Galeria de estilos de célula do Excel', caption: 'Página Inicial > Estilos de Célula.', source: `${SUP}/excel/apply-create-or-remove-a-cell-style` } },
          { h: 'Criar, modificar e duplicar',
            items: [
              '<strong>Novo Estilo de Célula</strong> (no fim da galeria) — dê um nome, clique em Formatar, defina a formatação e, em "O estilo inclui", desmarque o que o estilo não deve controlar (por exemplo, deixar o formato de número livre).',
              '<strong>Modificar</strong> — botão direito num estilo > Modificar: todas as células que usam aquele estilo mudam juntas. É a grande vantagem sobre formatar à mão.',
              '<strong>Duplicar</strong> — cria uma cópia editável de um estilo existente.',
              '<strong>Excluir</strong> — botão direito > Excluir; as células voltam ao estilo Normal.',
              '<strong>Mesclar Estilos</strong> — traz os estilos personalizados de outra pasta de trabalho aberta.'
            ] },
          { h: 'Temas',
            p: 'Em Layout da Página > <strong>Temas</strong>, o tema define o conjunto de cores, fontes (uma para títulos, outra para corpo) e efeitos de gráficos e formas da pasta inteira. Trocar o tema atualiza, de uma vez, tudo o que usa cores e fontes de tema — inclusive os estilos de célula, que são baseados no tema. Os botões Cores, Fontes e Efeitos, ao lado, trocam só uma parte; Salvar Tema Atual guarda sua combinação para reutilizar.' },
          { h: 'Pincel de Formatação',
            p: 'Para copiar só a formatação: selecione a célula modelo, clique em <strong>Pincel de Formatação</strong> (Página Inicial > Área de Transferência) e clique ou arraste sobre o destino. Um clique no pincel vale para uma aplicação; <strong>duplo clique</strong> mantém o pincel ativo para vários destinos, até você pressionar Esc ou clicar no pincel de novo. O pincel copia formato de número, fonte, alinhamento, bordas, preenchimento e formatação condicional — nunca o conteúdo. Funciona também com linhas e colunas inteiras (copia larguras e alturas).' },
          { h: 'Limpar: o que exatamente remover',
            p: 'A tecla Delete apaga só o conteúdo e mantém a formatação. Para mais controle, Página Inicial > Edição > <strong>Limpar</strong>:',
            items: [
              '<strong>Limpar Tudo</strong> — conteúdo, formatos, comentários e anotações.',
              '<strong>Limpar Formatos</strong> — remove só a formatação (a célula volta ao estilo Normal), mantendo os valores. É o "limpar formatação" da prova.',
              '<strong>Limpar Conteúdo</strong> — o mesmo que Delete.',
              '<strong>Limpar Comentários e Anotações</strong>.',
              '<strong>Limpar Hiperlinks</strong> e <strong>Remover Hiperlinks</strong> — o primeiro tira o link e mantém a formatação de link; o segundo tira o link e a formatação.'
            ] },
          { h: 'Limpar não é excluir',
            p: 'Limpar esvazia as células e deixa o lugar delas; excluir remove as células e desloca as vizinhas (Módulo 02). Uma fórmula que apontava para uma célula limpa passa a enxergar zero; uma fórmula que apontava para uma célula excluída passa a mostrar o erro #REF!.' },
          { h: 'Como isso cai na prova',
            items: [
              '"Aplique o estilo de célula Título 1 a A1" — nome exato da galeria.',
              '"Copie a formatação de A3 para A4:A20" — Pincel de Formatação.',
              '"Remova a formatação de B2:B30 sem remover os valores" — Limpar Formatos.',
              '"Aplique o tema Íon" ou "altere as cores do tema para Azul" — Layout da Página > Temas / Cores.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Aplicar, criar ou remover um estilo de célula', u: `${SUP}/excel/apply-create-or-remove-a-cell-style` },
          { t: 'Microsoft Suporte — Copiar a formatação de células', u: `${SUP}/excel/get-started/copy-cell-formatting` },
          { t: 'Microsoft Suporte — Limpar células de conteúdo ou formatos', u: `${SUP}/excel/clear-cells-of-contents-or-formats` }
        ]
      }
    ]
  },
  {
    id: 'xl-m04', title: 'Módulo 04 · Importar, limpar e validar dados', kind: 'video',
    lessons: [
      {
        id: 'xl-importar-txt-csv', title: 'Importar arquivos de texto e CSV',
        desc: 'Abrir um CSV diretamente x importar com Dados > De Texto/CSV: codificação, delimitador, tipos de dados, Carregar, Carregar Para e Transformar Dados — e o Assistente de Importação de Texto.',
        objetivos: [
          'Diferenciar abrir um arquivo de texto de importá-lo para uma planilha',
          'Importar .txt e .csv escolhendo codificação, delimitador e destino',
          'Preservar zeros à esquerda e datas no formato certo na importação'
        ],
        body: 'Quase todo sistema — ERP, banco, e-commerce, planilha do governo — exporta dados em texto: .csv ou .txt. Trazer esse arquivo para o Excel do jeito certo é a diferença entre uma coluna de CEPs intacta e uma coluna de números sem o zero da frente, ou entre "São Paulo" e "SÃ£o Paulo". Importar .txt e .csv é a primeira habilidade da lista da prova Associate.',
        content: [
          { h: 'Dois caminhos: abrir ou importar',
            items: [
              '<strong>Abrir</strong> (Arquivo > Abrir, escolhendo o arquivo .csv) — o Excel abre o texto como se fosse uma pasta de trabalho, usando as configurações regionais do computador para interpretar cada coluna. É rápido, mas você não controla nada: zeros à esquerda somem, datas em outro padrão podem virar texto ou datas trocadas, e o arquivo continua sendo .csv (salvar grava de volta em texto, perdendo formatação).',
              '<strong>Importar</strong> (Dados > Obter e Transformar Dados > <strong>De Texto/CSV</strong>) — traz os dados para dentro de uma pasta de trabalho do Excel como uma consulta do Power Query, com uma janela de visualização em que você confere e ajusta tudo antes de carregar. É o caminho recomendado e o que a prova espera.'
            ] },
          { h: 'A janela de importação',
            p: 'Depois de escolher o arquivo, o Excel mostra uma prévia com três controles no alto:',
            items: [
              '<strong>Origem do Arquivo</strong> — a codificação dos caracteres. Se os acentos aparecerem quebrados ("SÃ£o Paulo"), troque para <strong>65001: Unicode (UTF-8)</strong>; arquivos antigos do Windows costumam ser 1252: Europeu Ocidental.',
              '<strong>Delimitador</strong> — vírgula, ponto e vírgula, tabulação, espaço ou personalizado. CSVs gerados no Brasil costumam usar ponto e vírgula.',
              '<strong>Detecção de Tipo de Dados</strong> — com base nas primeiras 200 linhas, em todo o conjunto de dados ou não detectar (tudo vira texto).'
            ] },
          { h: 'Carregar, Carregar Para ou Transformar Dados',
            items: [
              '<strong>Carregar</strong> — cria uma planilha nova com os dados em formato de tabela do Excel.',
              '<strong>Carregar Para</strong> — abre a caixa Importar Dados, onde você escolhe como exibir (Tabela, Relatório de Tabela Dinâmica, Gráfico Dinâmico ou Apenas Criar Conexão), onde colocar (planilha existente, a partir de uma célula, ou nova planilha) e se adiciona ao Modelo de Dados.',
              '<strong>Transformar Dados</strong> — abre o Editor do Power Query para limpar antes de carregar (próxima aula).'
            ] },
          { h: 'Zeros à esquerda e datas',
            p: 'Para uma coluna de códigos (CEP, CPF, matrícula) manter os zeros, ela precisa chegar como texto: em Transformar Dados, clique no ícone de tipo no cabeçalho da coluna e escolha Texto — ou, na prévia, use "Não detectar tipos de dados". Para datas em padrão estrangeiro (mês/dia/ano), no Editor use botão direito no cabeçalho > Alterar Tipo > <strong>Usando a Localidade</strong> e escolha Data com a localidade de origem (Inglês – Estados Unidos, por exemplo). Assim 03/08/2026 vira 8 de março, e não 3 de agosto.' },
          { h: 'O Assistente de Importação de Texto (herdado)',
            p: 'O assistente clássico continua disponível para compatibilidade: ele aparece ao abrir um .txt por Arquivo > Abrir, e pode ser ligado em Arquivo > Opções > Dados > Mostrar assistentes herdados de importação de dados (fica em Dados > Obter Dados > Assistentes Herdados). São três etapas:',
            items: [
              '<strong>Etapa 1</strong> — Delimitado (campos separados por um caractere) ou <strong>Largura fixa</strong> (cada campo ocupa sempre as mesmas posições); linha em que começa a importação; Origem do arquivo (codificação).',
              '<strong>Etapa 2</strong> — delimitadores; <strong>Considerar delimitadores consecutivos como um só</strong>; <strong>Qualificador de texto</strong> (normalmente aspas duplas: "Goiânia, GO" entre aspas fica numa célula só, mesmo contendo a vírgula). Em largura fixa, você clica na régua para marcar onde cada coluna começa.',
              '<strong>Etapa 3</strong> — o formato de cada coluna: Geral, Texto, Data (com a ordem DMA, MDA etc.) ou Não importar coluna. O botão Avançado define os separadores decimal e de milhar usados no arquivo.'
            ] },
          { h: 'Exportar para texto',
            p: 'O caminho inverso é Arquivo > Salvar Como com o tipo CSV UTF-8, CSV (separado por vírgulas) ou Texto (separado por tabulações). Lembre-se: só a planilha ativa é salva e só os valores (Módulo 01). O Excel avisa as duas coisas antes de salvar.' },
          { h: 'Como isso cai na prova',
            items: [
              '"Importe o arquivo Vendas.csv a partir da célula A1 da planilha Dados" — De Texto/CSV > Carregar Para > Planilha existente, célula A1.',
              '"Importe o arquivo delimitado por tabulação mantendo a primeira linha como cabeçalho" — confira na prévia se o cabeçalho foi reconhecido.',
              'Não abra o arquivo por Arquivo > Abrir quando a tarefa pede para importar para a pasta de trabalho atual.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Importar ou exportar arquivos de texto (.txt ou .csv)', u: `${SUP}/excel/get-started/import-or-export-text-txt-or-csv-files` },
          { t: 'Microsoft Suporte — Assistente de Importação de Texto', u: `${SUP}/excel/text-import-wizard` }
        ]
      },
      {
        id: 'xl-power-query-basico', title: 'Power Query no Excel: obter, transformar e atualizar',
        desc: 'As quatro fases do Power Query, fontes de dados (texto, pasta, Web, tabela), o Editor com Etapas Aplicadas, os destinos de carga e as opções de atualização.',
        objetivos: [
          'Explicar as fases conectar, transformar, combinar e carregar',
          'Fazer limpezas básicas no Editor do Power Query e entender as Etapas Aplicadas',
          'Escolher o destino da carga e configurar a atualização dos dados'
        ],
        body: 'O Power Query (no Excel também chamado de Obter e Transformar) é o motor de importação e limpeza de dados do Excel — o mesmo do Power BI. A grande ideia: você ensina a limpeza uma vez e, no mês seguinte, quando chega o arquivo novo, basta clicar em Atualizar. A prova Associate cobra a importação; esta aula dá a base para usar o Power Query no trabalho e nos módulos de análise.',
        content: [
          { h: 'As quatro fases',
            img: { src: `${XL_IMG}/m04/power-query-fluxo.png`, alt: 'Conectar, Transformar, Combinar e Carregar', caption: 'Conectar à fonte, transformar, combinar consultas e carregar no Excel.', source: `${SUP}/excel/about-power-query-in-excel` },
            items: [
              '<strong>Conectar</strong> — a um arquivo, pasta, página da Web, banco de dados, serviço na nuvem ou a uma tabela da própria pasta de trabalho.',
              '<strong>Transformar</strong> — remover colunas, filtrar linhas, trocar tipos de dados, dividir colunas, substituir valores. A fonte original nunca é alterada.',
              '<strong>Combinar</strong> — <strong>Acrescentar</strong> consultas (empilhar tabelas com as mesmas colunas, como janeiro + fevereiro) ou <strong>Mesclar</strong> consultas (juntar colunas de outra tabela por uma chave, como um PROCV).',
              '<strong>Carregar</strong> — levar o resultado para uma planilha ou para o Modelo de Dados, e atualizar sempre que a fonte mudar.'
            ] },
          { h: 'Fontes de dados mais comuns',
            p: 'Todas ficam na guia Dados, grupo Obter e Transformar Dados, e no menu <strong>Obter Dados</strong>:',
            items: [
              '<strong>De Texto/CSV</strong> — arquivos de texto (aula anterior).',
              '<strong>Da Web</strong> — cole o endereço de uma página; o Navegador lista as tabelas encontradas nela para você escolher.',
              '<strong>De Tabela/Intervalo</strong> — usa dados da própria planilha (o intervalo vira tabela do Excel).',
              '<strong>Obter Dados > De Arquivo > Da Pasta</strong> — junta todos os arquivos de uma pasta (os doze CSVs mensais, por exemplo) numa consulta só; arquivo novo na pasta entra na próxima atualização.',
              '<strong>Da Pasta de Trabalho do Excel</strong>, bancos de dados (SQL Server, Access), SharePoint, OneDrive e outros serviços.'
            ],
            img: { src: `${XL_IMG}/m04/obter-dados-comandos.png`, alt: 'Menu Obter Dados com as categorias de fontes', caption: 'Dados > Obter Dados: fontes organizadas por categoria.', source: `${SUP}/excel/about-power-query-in-excel` } },
          { h: 'O Editor do Power Query',
            p: 'Em Transformar Dados (ou Dados > Obter Dados > Iniciar Editor do Power Query) abre o Editor. Cada ação que você faz pela faixa de opções ou clicando com o botão direito no cabeçalho de uma coluna vira uma etapa no painel <strong>Configurações de Consulta</strong>, em <strong>Etapas Aplicadas</strong>. As etapas são reexecutadas, na ordem, a cada atualização. Clicar numa etapa mostra os dados naquele ponto; o X ao lado exclui a etapa.',
            img: { src: `${XL_IMG}/m04/editor-power-query.png`, alt: 'Editor do Power Query com a lista de consultas, a visualização dos dados e as Etapas Aplicadas', caption: 'O Editor do Power Query: consultas à esquerda, dados no centro e Etapas Aplicadas à direita.', source: `${SUP}/excel/create-load-or-edit-a-query-in-excel-power-query` } },
          { h: 'Limpezas que resolvem 80% dos casos',
            items: [
              '<strong>Usar a Primeira Linha como Cabeçalho</strong> — quando os títulos vieram como a primeira linha de dados.',
              '<strong>Remover Colunas</strong> e <strong>Remover Outras Colunas</strong> (fica só com as selecionadas).',
              '<strong>Remover Linhas</strong> — linhas superiores (cabeçalhos de relatório), linhas em branco, duplicatas, erros.',
              '<strong>Tipo de dados</strong> — o ícone no cabeçalho da coluna (texto, número inteiro, decimal, data, moeda).',
              '<strong>Dividir Coluna</strong> — por delimitador ou por número de caracteres.',
              '<strong>Substituir Valores</strong>, <strong>Aparar</strong> (tira espaços do começo e do fim) e <strong>Colocar Cada Palavra em Maiúscula</strong>.',
              '<strong>Filtrar</strong> — a seta do cabeçalho funciona como o filtro do Excel, mas vira etapa permanente da consulta.'
            ] },
          { h: 'Onde carregar',
            p: '<strong>Fechar e Carregar</strong> leva o resultado para uma planilha nova como tabela. <strong>Fechar e Carregar Para</strong> abre a caixa Importar Dados: Tabela, Relatório de Tabela Dinâmica, Gráfico Dinâmico ou <strong>Apenas Criar Conexão</strong> (a consulta existe, mas não ocupa planilha — útil para consultas intermediárias), além da caixa <strong>Adicionar estes dados ao Modelo de Dados</strong>, que leva os dados ao Power Pivot para tabelas dinâmicas com várias tabelas relacionadas. O painel <strong>Consultas e Conexões</strong> (Dados > Consultas e Conexões) lista todas as consultas; botão direito numa delas oferece Editar, Carregar Para, Duplicar, Referenciar e Excluir.' },
          { h: 'Atualizar os dados',
            items: [
              '<strong>Atualizar</strong> — botão direito na tabela carregada > Atualizar, ou guia Consulta > Atualizar.',
              '<strong>Atualizar Tudo</strong> (Dados > Consultas e Conexões > Atualizar Tudo, ou Ctrl+Alt+F5) — todas as consultas e tabelas dinâmicas da pasta.',
              '<strong>Propriedades da conexão</strong> (seta de Atualizar Tudo > Propriedades da Conexão): <strong>Atualizar a cada</strong> N minutos, <strong>Atualizar dados ao abrir o arquivo</strong> e <strong>Habilitar atualização em segundo plano</strong> (você continua trabalhando enquanto atualiza).'
            ],
            img: { src: `${XL_IMG}/m04/atualizar-tudo.png`, alt: 'Botão Atualizar Tudo na guia Dados', caption: 'Dados > Atualizar Tudo.', source: `${SUP}/excel/refresh-an-external-data-connection-in-excel` } },
          { h: 'Como isso cai na prova',
            items: [
              'A MO-210 pede importar .txt e .csv; a MO-211 pede consultar dados de outras pastas de trabalho — os dois caminhos passam por Obter Dados.',
              '"Configure a conexão para atualizar ao abrir o arquivo" — Propriedades da Conexão, guia Uso.',
              'Quando a tarefa diz "sem criar uma planilha nova", use Carregar Para > Apenas Criar Conexão ou Planilha existente.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Sobre o Power Query no Excel', u: `${SUP}/excel/about-power-query-in-excel` },
          { t: 'Microsoft Suporte — Criar, carregar ou editar uma consulta', u: `${SUP}/excel/create-load-or-edit-a-query-in-excel-power-query` },
          { t: 'Microsoft Suporte — Importar dados da Web', u: `${SUP}/excel/get-started/import-data-from-the-web` },
          { t: 'Microsoft Suporte — Importar dados de uma pasta com vários arquivos', u: `${SUP}/excel/import-data-from-a-folder-with-multiple-files-power-query` },
          { t: 'Microsoft Suporte — Atualizar uma conexão de dados externa', u: `${SUP}/excel/refresh-an-external-data-connection-in-excel` }
        ]
      },
      {
        id: 'xl-texto-colunas-duplicatas', title: 'Texto para Colunas e Remover Duplicatas',
        desc: 'Dividir uma coluna em várias por delimitador ou largura fixa, remover linhas duplicadas escolhendo as colunas-chave e filtrar valores exclusivos sem apagar nada.',
        objetivos: [
          'Dividir dados com o Assistente para Conversão de Texto em Colunas',
          'Remover duplicatas entendendo o que é uma linha duplicada para o Excel',
          'Obter valores exclusivos com o Filtro Avançado, sem excluir dados'
        ],
        body: 'Dois problemas aparecem em quase toda base de dados que chega de fora: informações grudadas numa coluna só ("Goiânia - GO") e linhas repetidas (o mesmo cliente cadastrado três vezes). O Excel tem um comando pronto para cada um, os dois na guia Dados, grupo Ferramentas de Dados. Remover duplicatas é habilidade da prova Expert.',
        content: [
          { h: 'Texto para Colunas',
            p: 'Selecione a coluna (uma só) e vá em Dados > <strong>Texto para Colunas</strong>. Garanta colunas vazias à direita: o resultado ocupa as colunas seguintes e substitui o que houver nelas. O assistente tem três etapas:',
            items: [
              '<strong>Delimitado</strong> ou <strong>Largura fixa</strong>.',
              'Os delimitadores (Tabulação, Ponto e vírgula, Vírgula, Espaço, Outros) e a opção Considerar delimitadores consecutivos como um só — com a Visualização dos dados embaixo.',
              'O formato de cada coluna resultante (Geral, Texto, Data ou Não importar coluna) e o <strong>Destino</strong> — a célula onde a primeira coluna vai começar (para não sobrescrever a original, aponte para outra coluna).'
            ] },
          { h: 'Um truque: converter texto em data ou número',
            p: 'Texto para Colunas também conserta colunas "presas" como texto. Selecione a coluna de datas que o Excel não reconhece, abra o assistente, avance direto até a etapa 3, escolha Data com a ordem certa (DMA) e conclua: o texto é reinterpretado como data real. O mesmo vale para números que chegaram como texto, escolhendo Geral.' },
          { h: 'Remover Duplicatas',
            p: 'Com uma célula dentro dos dados, Dados > <strong>Remover Duplicatas</strong>. Na caixa, marque <strong>Meus dados contêm cabeçalhos</strong> (se for o caso) e escolha as colunas que definem o que é "igual":',
            items: [
              'Com todas as colunas marcadas, só saem linhas idênticas em tudo.',
              'Com só a coluna CPF marcada, saem todas as linhas com CPF repetido — mesmo que o telefone seja diferente. A linha inteira é excluída, não só a célula.',
              'A primeira ocorrência de cada valor fica; as seguintes saem. Classifique antes (por data, por exemplo) se quiser controlar qual registro fica.',
              'Ao final, o Excel informa quantas duplicatas foram removidas e quantos valores exclusivos permanecem. Ctrl+Z desfaz.',
              'A comparação usa o valor exibido: a mesma data com formatos diferentes conta como valores diferentes. Espaços sobrando também tornam valores "diferentes" — limpe antes (função ARRUMAR/TRIM, Módulo 08, ou Aparar no Power Query).'
            ],
            img: { src: `${XL_IMG}/m04/remover-duplicatas.png`, alt: 'Botão Remover Duplicatas no grupo Ferramentas de Dados', caption: 'Dados > Ferramentas de Dados > Remover Duplicatas.', source: `${SUP}/excel/get-started/filter-for-unique-values-or-remove-duplicate-values` } },
          { h: 'Valores exclusivos sem apagar nada',
            p: 'Remover Duplicatas exclui dados permanentemente — faça uma cópia antes. Para só ver ou extrair os valores exclusivos, use Dados > Classificar e Filtrar > <strong>Avançado</strong>: escolha Filtrar a lista no local ou Copiar para outro local (informando a célula em Copiar para) e marque <strong>Somente registros exclusivos</strong>. No Microsoft 365, a função ÚNICO (UNIQUE) faz o mesmo com fórmula e se atualiza sozinha (Módulo 09). E a formatação condicional Realçar Regras das Células > Valores Duplicados mostra as repetições antes de você decidir (Módulo 10).',
            img: { src: `${XL_IMG}/m04/filtro-avancado.png`, alt: 'Botão Avançado no grupo Classificar e Filtrar', caption: 'Dados > Classificar e Filtrar > Avançado.', source: `${SUP}/excel/get-started/filter-for-unique-values-or-remove-duplicate-values` } },
          { h: 'Como isso cai na prova',
            items: [
              '"Remova os registros duplicados com base apenas nas colunas Nome e Email" — desmarque as outras colunas na caixa Remover Duplicatas.',
              '"Separe a coluna A em Nome e Sobrenome" — Texto para Colunas com delimitador Espaço (ou Preenchimento Relâmpago, se a tarefa pedir).',
              'Não remova duplicatas de dados com subtotais ou estrutura de tópicos: o comando não funciona; remova os subtotais antes.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Dividir texto em colunas com o Assistente', u: `${SUP}/excel/get-started/split-text-into-different-columns-with-the-convert-text-to-columns-wizard` },
          { t: 'Microsoft Suporte — Filtrar por valores exclusivos ou remover duplicados', u: `${SUP}/excel/get-started/filter-for-unique-values-or-remove-duplicate-values` }
        ]
      },
      {
        id: 'xl-validacao-dados', title: 'Validação de dados e listas suspensas',
        desc: 'Restringir o que pode ser digitado (números, datas, tamanho de texto, listas, fórmula), mensagens de entrada, os três estilos de alerta de erro e como encontrar dados inválidos.',
        objetivos: [
          'Criar regras de validação para números, datas, texto e listas',
          'Montar listas suspensas a partir de valores digitados ou de uma tabela',
          'Configurar mensagem de entrada e alerta de erro (Parar, Aviso, Informações)'
        ],
        body: 'Planilha que várias pessoas preenchem sem validação vira bagunça: "SP", "sp", "São Paulo" e "Sao Paulo" na mesma coluna; quantidade negativa; data de 2062. A Validação de Dados impede a entrada errada na origem, e a lista suspensa é a forma mais prática de padronizar. Configurar validação é habilidade da prova Expert.',
        content: [
          { h: 'Criar uma regra',
            p: 'Selecione as células e vá em Dados > Ferramentas de Dados > <strong>Validação de Dados</strong>. Na guia <strong>Configurações</strong>, a caixa <strong>Permitir</strong> define o tipo:',
            items: [
              '<strong>Qualquer valor</strong> — sem restrição (é assim que se "desliga" a regra).',
              '<strong>Número inteiro</strong> e <strong>Decimal</strong> — com a condição em <strong>Dados</strong>: está entre, não está entre, igual a, diferente de, maior do que, menor do que, maior ou igual a, menor ou igual a. Ex.: quantidade inteira maior ou igual a 1.',
              '<strong>Lista</strong> — só aceita itens de uma lista (lista suspensa).',
              '<strong>Data</strong> e <strong>Hora</strong> — ex.: data entre 01/01/2026 e 31/12/2026. Os limites podem ser fórmulas, como HOJE().',
              '<strong>Comprimento do texto</strong> — ex.: exatamente 8 caracteres para CEP sem traço.',
              '<strong>Personalizado</strong> — uma fórmula que precisa dar VERDADEIRO. Ex.: impedir código repetido com uma fórmula CONT.SE (Módulo 07).'
            ],
            img: { src: `${XL_IMG}/m04/validacao-dados.png`, alt: 'Botão Validação de Dados na guia Dados', caption: 'Dados > Ferramentas de Dados > Validação de Dados.', source: `${SUP}/excel/get-started/apply-data-validation-to-cells` } },
          { h: 'Listas suspensas',
            p: 'Em Permitir escolha <strong>Lista</strong>, mantenha marcada a caixa <strong>Menu suspenso na célula</strong> e preencha a <strong>Fonte</strong> de um destes jeitos:',
            items: [
              'Itens digitados direto, separados por ponto e vírgula no Excel em português (Alta;Média;Baixa). No Excel em inglês o separador é a vírgula.',
              'Um intervalo da planilha com os itens, sem incluir o cabeçalho.',
              'Melhor ainda: os itens numa <strong>tabela do Excel</strong> (Módulo 05). Aí, ao acrescentar um item na tabela, todas as listas baseadas nela passam a mostrá-lo sem você mexer na validação. Para apontar para a coluna da tabela, use um nome definido ou a função INDIRETO.',
              '<strong>Ignorar em branco</strong> permite deixar a célula vazia.'
            ],
            img: { src: `${XL_IMG}/m04/lista-suspensa-origem.png`, alt: 'Configurações de validação com Permitir Lista e a caixa Fonte', caption: 'Lista, Menu suspenso na célula e a Fonte com o intervalo dos itens.', source: `${SUP}/excel/get-started/create-a-drop-down-list` } },
          { h: 'Mensagem de entrada',
            p: 'Na guia <strong>Mensagem de entrada</strong>, marque Mostrar mensagem de entrada ao selecionar a célula e escreva um Título e a Mensagem. Ela aparece como uma nota amarela quando a célula é selecionada — é o lugar para explicar o que deve ser digitado ("Informe a data da venda, no ano de 2026").' },
          { h: 'Alerta de erro: Parar, Aviso e Informações',
            p: 'Na guia <strong>Alerta de erro</strong>, o <strong>Estilo</strong> muda o comportamento quando alguém digita algo inválido:',
            items: [
              '<strong>Parar</strong> — impede a entrada; só dá para Repetir ou Cancelar. É o padrão.',
              '<strong>Aviso</strong> — pergunta "Deseja continuar?"; Sim aceita o valor inválido.',
              '<strong>Informações</strong> — só informa; OK aceita o valor.',
              'Título e Mensagem de erro personalizados deixam claro o que está errado. Se o alerta estiver desmarcado, qualquer valor é aceito.'
            ],
            img: { src: `${XL_IMG}/m04/alerta-de-erro.png`, alt: 'Guia Alerta de erro da caixa Validação de Dados', caption: 'Alerta de erro: estilo, título e mensagem.', source: `${SUP}/excel/get-started/create-a-drop-down-list` } },
          { h: 'Limites da validação e como achar dados inválidos',
            items: [
              'A validação só age na digitação: dados colados por cima ou que já estavam na célula não são barrados (colar substitui inclusive a própria regra).',
              '<strong>Circular Dados Inválidos</strong> (seta de Validação de Dados) desenha um círculo vermelho nas células que desobedecem à regra; Limpar Círculos de Validação remove.',
              'Para encontrar todas as células com validação: Localizar e Selecionar > Validação de Dados, ou Ir para Especial > Validação de dados.',
              'Para remover a regra: selecione as células > Validação de Dados > <strong>Limpar Tudo</strong>. <strong>Aplicar alterações a todas as células com as mesmas configurações</strong> atualiza a regra em todas as células que a compartilham.',
              'Com a planilha protegida, a validação não pode ser alterada.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              '"Configure C2:C100 para aceitar apenas números inteiros entre 1 e 500, com o alerta de estilo Aviso e o título Atenção" — cada detalhe da tarefa corresponde a um campo das três guias.',
              '"Crie uma lista suspensa com os valores da coluna A da planilha Listas" — Lista, com Fonte apontando para o intervalo (sem o cabeçalho).',
              'Leia o estilo pedido: Parar, Aviso e Informações são corrigidos separadamente.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Aplicar validação de dados às células', u: `${SUP}/excel/get-started/apply-data-validation-to-cells` },
          { t: 'Microsoft Suporte — Criar uma lista suspensa', u: `${SUP}/excel/get-started/create-a-drop-down-list` }
        ]
      }
    ]
  },
  {
    id: 'xl-m05', title: 'Módulo 05 · Tabelas do Excel, classificação e filtros', kind: 'video',
    lessons: [
      {
        id: 'xl-tabelas-criar', title: 'Tabelas do Excel: criar, nomear e redimensionar',
        desc: 'O que muda quando um intervalo vira tabela, como criar, nomear, acrescentar linhas e colunas, usar colunas calculadas e converter de volta em intervalo.',
        objetivos: [
          'Criar uma tabela a partir de um intervalo, com ou sem cabeçalhos',
          'Nomear a tabela seguindo as regras de nomes do Excel',
          'Adicionar e remover linhas e colunas, redimensionar e converter em intervalo'
        ],
        body: 'Transformar uma lista de dados em tabela do Excel é, provavelmente, o hábito que mais melhora uma planilha. A tabela cresce sozinha quando você acrescenta dados, leva as fórmulas para as linhas novas, mantém os filtros no cabeçalho e dá um nome que as fórmulas, os gráficos e as tabelas dinâmicas podem usar. A prova Associate tem uma seção inteira sobre tabelas (15 a 20% da nota).',
        content: [
          { h: 'Criar uma tabela',
            items: [
              'Clique em qualquer célula dos dados e use <strong>Inserir > Tabela</strong> (ou Página Inicial > <strong>Formatar como Tabela</strong>, que já pede um estilo).',
              'A caixa Criar Tabela sugere o intervalo — confira se pegou todas as linhas e colunas — e pergunta se <strong>Minha tabela tem cabeçalhos</strong>. Sem cabeçalhos, o Excel cria títulos Coluna1, Coluna2...',
              'Antes de criar: uma linha de títulos, sem linhas ou colunas totalmente vazias no meio, sem células mescladas, e um tipo de dado por coluna.'
            ],
            img: { src: `${XL_IMG}/m05/tabela-visao-geral.png`, alt: 'Dados formatados como tabela do Excel', caption: 'Uma tabela do Excel: cabeçalho com setas de filtro, linhas em tiras e alça de redimensionamento no canto.', source: `${SUP}/excel/overview-of-excel-tables` } },
          { h: 'O que a tabela ganha',
            items: [
              '<strong>Setas de filtro e classificação</strong> em cada cabeçalho.',
              '<strong>Cabeçalho que fica visível</strong> — ao rolar, os títulos da tabela substituem as letras das colunas.',
              '<strong>Expansão automática</strong> — digitar logo abaixo da última linha (ou à direita da última coluna) incorpora os dados à tabela, com a mesma formatação.',
              '<strong>Colunas calculadas</strong> — digite uma fórmula numa célula de uma coluna e ela é preenchida em toda a coluna; linhas novas recebem a fórmula automaticamente.',
              '<strong>Nome próprio</strong> e referências estruturadas nas fórmulas (Módulo 06).',
              '<strong>Guia Design da Tabela</strong>, que aparece sempre que a célula ativa está dentro da tabela.'
            ],
            img: { src: `${XL_IMG}/m05/coluna-calculada.png`, alt: 'Fórmula digitada numa célula preenchendo a coluna inteira da tabela', caption: 'Coluna calculada: uma fórmula, a coluna inteira preenchida.', source: `${SUP}/excel/overview-of-excel-tables` } },
          { h: 'Nomear a tabela',
            p: 'Cada tabela nasce como Tabela1, Tabela2... Troque em Design da Tabela > Propriedades > <strong>Nome da Tabela</strong>. Regras: começar com letra, sublinhado ou barra invertida; sem espaços (use sublinhado ou maiúsculas: Vendas_2026, tbVendas); não pode parecer uma referência de célula (como A1 ou R1C1), nem ser só "C" ou "R"; até 255 caracteres; único na pasta (maiúsculas e minúsculas não diferenciam). Todas as tabelas aparecem na lista da Caixa de Nome — escolher uma leva até ela, mesmo em outra planilha.',
            img: { src: `${XL_IMG}/m05/nome-da-tabela.png`, alt: 'Campo Nome da Tabela no grupo Propriedades', caption: 'Design da Tabela > Propriedades > Nome da Tabela.', source: `${SUP}/excel/rename-an-excel-table` } },
          { h: 'Acrescentar e remover linhas e colunas',
            items: [
              '<strong>Digitando ou colando</strong> logo abaixo ou à direita — a tabela se expande. Se os dados colados tiverem mais colunas que a tabela, as colunas extras ficam de fora.',
              '<strong>Tab na última célula</strong> da tabela cria uma linha nova.',
              '<strong>Inserir</strong> — botão direito numa célula > Inserir > Linhas da Tabela Acima ou Colunas da Tabela à Esquerda. Só a tabela abre espaço; o resto da planilha não se mexe.',
              '<strong>Excluir</strong> — botão direito > Excluir > Linhas da Tabela ou Colunas da Tabela.',
              '<strong>Redimensionar Tabela</strong> (Design da Tabela > Propriedades) — informe o novo intervalo; ele precisa manter a mesma linha de cabeçalho. Ou arraste a alça no canto inferior direito da tabela.'
            ],
            img: { src: `${XL_IMG}/m05/redimensionar-tabela.png`, alt: 'Comando Redimensionar Tabela', caption: 'Design da Tabela > Redimensionar Tabela.', source: `${SUP}/excel/resize-a-table-by-adding-or-removing-rows-and-columns-in-excel` } },
          { h: 'Converter em intervalo',
            p: 'Para voltar a um intervalo comum mantendo a aparência: Design da Tabela > Ferramentas > <strong>Converter em Intervalo</strong> (ou botão direito > Tabela > Converter em Intervalo) e confirme. As setas de filtro somem, a guia Design da Tabela deixa de aparecer e as referências estruturadas nas fórmulas viram referências comuns (como A2:A50). Recursos que não funcionam dentro de tabela — mesclar células, subtotais automáticos (Módulo 13) — exigem a conversão.' },
          { h: 'Como isso cai na prova',
            items: [
              '"Crie uma tabela a partir de A3:F120 com cabeçalhos" — confira o intervalo sugerido; muitas tarefas têm título acima dos dados.',
              '"Nomeie a tabela como Estoque" — Nome da Tabela, sem espaços.',
              '"Adicione uma coluna Total à tabela" / "Remova a coluna Obs." — insira ou exclua colunas da tabela, não da planilha.',
              '"Converta a tabela em um intervalo" — Converter em Intervalo; não confunda com Limpar formatação.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Visão geral das tabelas do Excel', u: `${SUP}/excel/overview-of-excel-tables` },
          { t: 'Microsoft Suporte — Criar e formatar tabelas', u: `${SUP}/excel/get-started/create-and-format-tables` },
          { t: 'Microsoft Suporte — Redimensionar uma tabela', u: `${SUP}/excel/resize-a-table-by-adding-or-removing-rows-and-columns-in-excel` },
          { t: 'Microsoft Suporte — Renomear uma tabela do Excel', u: `${SUP}/excel/rename-an-excel-table` },
          { t: 'Microsoft Suporte — Converter uma tabela em intervalo', u: `${SUP}/excel/convert-an-excel-table-to-a-range-of-data` }
        ]
      },
      {
        id: 'xl-tabelas-estilos-totais', title: 'Estilos de tabela, opções de estilo e Linha de Totais',
        desc: 'Aplicar e criar estilos de tabela, ligar e desligar elementos (cabeçalho, totais, tiras, primeira e última coluna, botão de filtro) e totalizar com a Linha de Totais.',
        objetivos: [
          'Aplicar, criar e limpar estilos de tabela',
          'Configurar as Opções de Estilo de Tabela',
          'Inserir a Linha de Totais e escolher a função de cada coluna'
        ],
        body: 'A aparência de uma tabela é controlada por duas coisas: o estilo (as cores e bordas) e as opções de estilo (quais partes da tabela recebem destaque). E a Linha de Totais dá, em dois cliques, somas, médias e contagens que respeitam o filtro aplicado. Tudo isso está na seção de tabelas da prova Associate.',
        content: [
          { h: 'Estilos de tabela',
            p: 'A galeria <strong>Estilos de Tabela</strong> (Design da Tabela, ou Página Inicial > Formatar como Tabela) é dividida em Claro, Médio e Escuro. Passar o mouse pré-visualiza; clicar aplica. <strong>Limpar</strong>, no fim da galeria, remove o estilo sem desfazer a tabela. <strong>Novo Estilo de Tabela</strong> cria um estilo seu: dê um nome, escolha cada Elemento de Tabela (Tabela Inteira, Linha de Cabeçalho, Linha de Totais, Primeira Faixa de Linha...) e clique em Formatar. Estilos personalizados ficam na seção Personalizado da galeria e valem só para a pasta em que foram criados; a opção "Definir como estilo de tabela padrão deste documento" faz dele o estilo das tabelas novas.',
            img: { src: `${XL_IMG}/m05/estilos-de-tabela.png`, alt: 'Galeria de estilos de tabela', caption: 'Galeria de estilos: Claro, Médio e Escuro.', source: `${SUP}/excel/format-an-excel-table` } },
          { h: 'Opções de Estilo de Tabela',
            p: 'No grupo Opções de Estilo de Tabela (guia Design da Tabela) ficam as caixas que ligam e desligam partes da tabela:',
            items: [
              '<strong>Linha de Cabeçalho</strong> — mostra ou oculta os títulos (os nomes das colunas continuam existindo para as fórmulas).',
              '<strong>Linha de Totais</strong> — acrescenta a linha de totais no fim.',
              '<strong>Linhas em Tiras</strong> e <strong>Colunas em Tiras</strong> — sombreamento alternado de linhas ou de colunas.',
              '<strong>Primeira Coluna</strong> e <strong>Última Coluna</strong> — destacam (em negrito, conforme o estilo) a primeira ou a última coluna.',
              '<strong>Botão de Filtro</strong> — mostra ou esconde as setas de filtro do cabeçalho.'
            ] },
          { h: 'Linha de Totais',
            p: 'Marque <strong>Linha de Totais</strong>. Na última linha aparece uma célula com lista suspensa em cada coluna: Nenhum, Média, Contagem, Contar Números, Máx, Mín, Soma, DesvPad, Var e Mais Funções. O Excel escreve uma fórmula SUBTOTAL com o código da função (109 para soma) e o nome da coluna, e essa fórmula ignora as linhas ocultas pelo filtro — filtrou só a região Sul, o total mostra só o Sul. A primeira célula da linha costuma trazer o rótulo "Total", que você pode editar. Desmarcar e marcar a Linha de Totais de novo preserva as funções escolhidas.',
            img: { src: `${XL_IMG}/m05/linha-de-totais.png`, alt: 'Lista suspensa da Linha de Totais com as funções disponíveis', caption: 'Linha de Totais: escolha a função de cada coluna na lista.', source: `${SUP}/excel/get-started/total-the-data-in-an-excel-table` } },
          { h: 'Segmentação de dados em tabelas',
            p: 'Com a célula ativa na tabela, Design da Tabela > <strong>Inserir Segmentação de Dados</strong> cria botões de filtro visuais para as colunas que você escolher — o mesmo recurso das tabelas dinâmicas (Módulo 12). Clicar num botão filtra a tabela; Ctrl+clique seleciona vários; o ícone no canto da segmentação limpa o filtro.',
            img: { src: `${XL_IMG}/m05/segmentacao-elementos.jpg`, alt: 'Elementos de uma segmentação de dados', caption: 'Segmentação: cabeçalho, botões de filtro, seleção múltipla e Limpar Filtro.', source: `${SUP}/excel/get-started/use-slicers-to-filter-data` } },
          { h: 'Como isso cai na prova',
            items: [
              '"Aplique o estilo Laranja, Estilo de Tabela Médio 3" — o nome aparece ao passar o mouse na galeria; confira antes de clicar.',
              '"Configure a tabela para destacar a primeira coluna e remover as linhas em tiras" — duas caixas de Opções de Estilo de Tabela.',
              '"Adicione uma linha de totais que mostre a média da coluna Preço" — Linha de Totais e Média na lista da coluna certa (a padrão é a da última coluna).'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Formatar uma tabela do Excel', u: `${SUP}/excel/format-an-excel-table` },
          { t: 'Microsoft Suporte — Totalizar os dados em uma tabela do Excel', u: `${SUP}/excel/get-started/total-the-data-in-an-excel-table` },
          { t: 'Microsoft Suporte — Usar segmentações de dados para filtrar dados', u: `${SUP}/excel/get-started/use-slicers-to-filter-data` }
        ]
      },
      {
        id: 'xl-classificar', title: 'Classificar por várias colunas, por cor e por lista',
        desc: 'Classificação rápida, a caixa Classificar com vários níveis, classificar por cor da célula, cor da fonte ou ícone, por lista personalizada e da esquerda para a direita.',
        objetivos: [
          'Classificar por uma coluna em ordem crescente ou decrescente',
          'Montar uma classificação com vários níveis na caixa Classificar',
          'Classificar por cor, por ícone, por lista personalizada e por colunas'
        ],
        body: 'Classificar parece simples até a lista precisar ficar por região, dentro da região por vendedor e, para cada vendedor, da maior venda para a menor. A caixa Classificar resolve isso com níveis. "Classificar dados por várias colunas" é habilidade da prova Associate.',
        content: [
          { h: 'Classificação rápida',
            p: 'Clique numa célula da coluna (não selecione a coluna inteira) e use os botões da guia Dados > Classificar e Filtrar, ou as setas do cabeçalho da tabela. O nome dos botões muda conforme o tipo da coluna: <strong>Classificar de A a Z</strong> e de Z a A para texto; <strong>do Menor para o Maior</strong> e do Maior para o Menor para números; <strong>do Mais Antigo para o Mais Novo</strong> e o inverso para datas. O Excel reconhece a região dos dados e move as linhas inteiras, mantendo cada registro junto.' },
          { h: 'Cuidados antes de classificar',
            items: [
              'Nunca classifique uma coluna selecionada sozinha quando há dados ao lado: o Excel pergunta se deve Expandir a seleção — escolha expandir; do contrário, só aquela coluna muda de ordem e os registros se desmontam.',
              'Números guardados como texto são classificados antes dos números; espaços no começo do texto também atrapalham. Limpe antes (Módulos 03 e 08).',
              'Linhas ou colunas ocultas não se movem na classificação — reexiba antes.',
              'Linhas totalmente vazias interrompem a região; o Excel pode classificar só um pedaço da lista.'
            ] },
          { h: 'Vários níveis na caixa Classificar',
            p: 'Dados > <strong>Classificar</strong> abre a caixa com a linha "Classificar por". Para cada nível escolha a <strong>Coluna</strong>, o <strong>Classificar em</strong> (Valores da Célula, Cor da Célula, Cor da Fonte ou Ícone de Formatação Condicional) e a <strong>Ordem</strong>. <strong>Adicionar Nível</strong> cria "E depois por"; Excluir Nível e Copiar Nível ajustam a lista, e as setas mudam a prioridade. A caixa <strong>Meus dados contêm cabeçalhos</strong> impede que a linha de títulos seja classificada junto.',
            img: { src: `${XL_IMG}/m05/classificar-adicionar-nivel.jpg`, alt: 'Caixa Classificar com dois níveis', caption: 'Classificar por, E depois por: cada nível com coluna, critério e ordem.', source: `${SUP}/excel/sort-data-in-a-range-or-table-in-excel` } },
          { h: 'Por cor, por ícone e por lista personalizada',
            items: [
              '<strong>Classificar em: Cor da Célula</strong> (ou Cor da Fonte, ou Ícone de Formatação Condicional) — escolha a cor e se ela vai No Topo ou Na Parte Inferior. Para ordenar várias cores, crie um nível por cor.',
              '<strong>Ordem: Lista Personalizada</strong> — use uma lista pronta (dias da semana, meses) ou crie uma (Alta, Média, Baixa) para classificar numa ordem que não é alfabética (Módulo 02).'
            ],
            img: { src: `${XL_IMG}/m05/classificar-em.jpg`, alt: 'Opções de Classificar em', caption: 'Classificar em: valores, cor da célula, cor da fonte ou ícone.', source: `${SUP}/excel/sort-data-in-a-range-or-table-in-excel` } },
          { h: 'Opções: maiúsculas e da esquerda para a direita',
            p: 'O botão <strong>Opções</strong> da caixa Classificar tem <strong>Diferenciar maiúsculas de minúsculas</strong> e a orientação: <strong>De cima para baixo</strong> (padrão, reorganiza linhas) ou <strong>Da esquerda para a direita</strong> (reorganiza colunas, usando uma linha como critério — útil para pôr meses em ordem num relatório que cresce para o lado).' },
          { h: 'Como isso cai na prova',
            items: [
              '"Classifique a tabela por Departamento de A a Z e depois por Salário do maior para o menor" — dois níveis na caixa Classificar, na ordem do enunciado.',
              '"Classifique para que as células com preenchimento vermelho fiquem no topo" — Classificar em: Cor da Célula.',
              'No Microsoft 365, CLASSIFICAR (SORT) e CLASSIFICARPOR (SORTBY) fazem isso por fórmula, sem mexer nos dados originais (Módulo 09).'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Classificar dados em um intervalo ou tabela', u: `${SUP}/excel/sort-data-in-a-range-or-table-in-excel` }
        ]
      },
      {
        id: 'xl-filtrar', title: 'Filtros: AutoFiltro, filtros personalizados e Filtro Avançado',
        desc: 'Filtrar por lista de valores, por texto, número e data, por cor, os 10 primeiros, limpar e reaplicar, e o Filtro Avançado com intervalo de critérios E/OU.',
        objetivos: [
          'Filtrar registros por valores, condições, cor e posição (10 primeiros)',
          'Combinar filtros em várias colunas, limpar e reaplicar',
          'Montar um Filtro Avançado com critérios E e OU e copiar o resultado para outro lugar'
        ],
        body: 'Filtrar é mostrar só as linhas que interessam e esconder o resto temporariamente — nada é apagado. É o recurso mais usado para responder perguntas rápidas sobre uma base ("quais pedidos do Sul acima de R$ 5 mil em setembro?"). "Filtrar registros" está na seção de tabelas da prova Associate.',
        content: [
          { h: 'Ligar o filtro',
            p: 'Em tabelas, as setas já estão no cabeçalho. Num intervalo comum, clique numa célula dos dados e use Dados > <strong>Filtro</strong> (ou Ctrl+Shift+L, que liga e desliga). A seta da coluna abre o menu de filtro: classificação no alto, a caixa de <strong>Pesquisa</strong>, a lista de valores com (Selecionar Tudo) e os filtros por tipo de dado. Quando uma coluna está filtrada, a seta vira um ícone de funil e os números das linhas ficam azuis; a barra de status informa quantos registros foram encontrados.' },
          { h: 'Tipos de filtro',
            items: [
              '<strong>Por lista de valores</strong> — desmarque (Selecionar Tudo) e marque os que quer ver. Em datas, a lista vem agrupada por ano, mês e dia.',
              '<strong>Pesquisa</strong> — digite parte do texto e o Excel marca os valores que contêm aquilo.',
              '<strong>Filtros de Texto</strong> — É Igual a, Começa Com, Termina Com, Contém, Não Contém.',
              '<strong>Filtros de Número</strong> — Maior do que, Menor do que, Entre, <strong>10 Primeiros</strong> (primeiros ou últimos N itens ou N por cento), Acima da Média, Abaixo da Média.',
              '<strong>Filtros de Data</strong> — Amanhã, Hoje, Ontem, Esta Semana, Mês Passado, Próximo Trimestre, Ano até a Data, Todas as Datas no Período...',
              '<strong>Filtrar por Cor</strong> — por cor da célula, cor da fonte ou ícone.',
              '<strong>Filtro Personalizado</strong> — a caixa Personalizar AutoFiltro combina duas condições com <strong>E</strong> ou <strong>Ou</strong>, e aceita os curingas asterisco e interrogação.'
            ],
            img: { src: `${XL_IMG}/m05/filtros-numero.jpg`, alt: 'Menu Filtros de Número com a opção Entre', caption: 'O menu muda conforme o tipo da coluna: aqui, Filtros de Número.', source: `${SUP}/excel/get-started/filter-data-in-a-range-or-table-in-excel` } },
          { h: 'Várias colunas, limpar e reaplicar',
            items: [
              'Filtros em colunas diferentes se somam (E): Região = Sul <em>e</em> Mês = setembro.',
              'Numa mesma coluna, use a lista de valores ou o filtro personalizado — um tipo de cada vez (lista ou condição, não os dois).',
              '<strong>Limpar Filtro de "Coluna"</strong> (no menu da seta) limpa uma coluna; Dados > <strong>Limpar</strong> limpa todas.',
              'Dados > <strong>Reaplicar</strong> — depois de alterar ou incluir dados, reavalia o filtro (linhas que passaram a atender ou deixaram de atender o critério).',
              'Copiar e colar um intervalo filtrado leva só as linhas visíveis; já preencher ou excluir exige cuidado — selecione só as células visíveis (Módulo 02).'
            ],
            img: { src: `${XL_IMG}/m05/personalizar-autofiltro.jpg`, alt: 'Caixa Personalizar AutoFiltro', caption: 'Personalizar AutoFiltro: duas condições ligadas por E ou Ou.', source: `${SUP}/excel/get-started/filter-data-in-a-range-or-table-in-excel` } },
          { h: 'Filtro Avançado: critérios na planilha',
            p: 'Quando a lógica é complexa, o <strong>Filtro Avançado</strong> (Dados > Classificar e Filtrar > Avançado) usa um <strong>intervalo de critérios</strong> montado na própria planilha, acima ou ao lado dos dados: uma linha com os mesmos títulos das colunas e, abaixo, as condições.',
            items: [
              'Condições <strong>na mesma linha</strong> se combinam com <strong>E</strong>: Região = Sul e Vendas maior que 5000.',
              'Condições <strong>em linhas diferentes</strong> se combinam com <strong>OU</strong>: Vendedor = Ana numa linha, Vendedor = Bruno na outra.',
              'Operadores de comparação vão junto do valor, como "maior que 5000" escrito com o sinal de maior; texto sem operador significa "começa com".',
              'Na caixa, informe o <strong>Intervalo da lista</strong> (os dados, com cabeçalhos) e o <strong>Intervalo de critérios</strong> (com os títulos), e escolha <strong>Filtrar a lista no local</strong> ou <strong>Copiar para outro local</strong> — aí o resultado sai numa área separada, e os dados originais ficam intactos. <strong>Somente registros exclusivos</strong> elimina repetições no resultado.'
            ],
            img: { src: `${XL_IMG}/m05/criterios-filtro-avancado.png`, alt: 'Intervalo de critérios acima do intervalo da lista', caption: 'Intervalo de critérios (em cima) e intervalo da lista (embaixo) — imagem original em inglês.', source: `${SUP}/excel/filter-by-using-advanced-criteria` } },
          { h: 'Como isso cai na prova',
            items: [
              '"Filtre a tabela para mostrar apenas os pedidos de Goiás com valor maior que 1.000" — dois filtros em colunas diferentes.',
              '"Mostre os 5 produtos com maior estoque" — Filtros de Número > 10 Primeiros, trocando 10 por 5.',
              '"Remova todos os filtros" — Dados > Limpar (não desligue o Filtro se a tarefa pede só limpar).',
              'No Microsoft 365, a função FILTRO (FILTER) devolve o resultado filtrado por fórmula (Módulo 09).'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Filtrar dados em um intervalo ou tabela', u: `${SUP}/excel/get-started/filter-data-in-a-range-or-table-in-excel` },
          { t: 'Microsoft Suporte — Filtrar usando critérios avançados', u: `${SUP}/excel/filter-by-using-advanced-criteria` }
        ]
      }
    ]
  },
  {
    id: 'xl-m06', title: 'Módulo 06 · Fórmulas, referências e nomes', kind: 'video',
    lessons: [
      {
        id: 'xl-formulas-basico', title: 'Como uma fórmula funciona: operadores e ordem de cálculo',
        desc: 'As partes de uma fórmula, os operadores aritméticos, de comparação, de texto e de referência, a ordem de precedência e o separador de argumentos do Excel em português.',
        objetivos: [
          'Montar fórmulas com constantes, referências, operadores e funções',
          'Aplicar a ordem de precedência e usar parênteses para mudá-la',
          'Usar o ponto e vírgula como separador de argumentos no Excel em português'
        ],
        body: 'Fórmula é o que transforma o Excel de uma tabela bonita numa calculadora que se atualiza sozinha. Toda fórmula começa com o sinal de igual e combina valores, referências a células, operadores e funções. Entender como o Excel lê a fórmula — e em que ordem calcula — evita os erros mais silenciosos, aqueles em que o resultado aparece, mas está errado.',
        content: [
          { h: 'As partes de uma fórmula',
            p: 'Na fórmula do exemplo, que calcula a área de um círculo, aparecem as quatro peças possíveis: uma <strong>função</strong> (PI, que devolve 3,14159...), uma <strong>referência</strong> (A2, o valor que está nessa célula), uma <strong>constante</strong> (o número 2, digitado direto) e <strong>operadores</strong> (o asterisco multiplica e o acento circunflexo eleva à potência). Quando o valor de A2 muda, o resultado se recalcula sozinho — é por isso que se usa referência em vez de digitar o número.',
            code: '=PI()*A2^2',
            img: { src: `${XL_IMG}/m06/partes-da-formula.gif`, alt: 'Fórmula com função, referência, constante e operador numerados', caption: '1 função, 2 referência, 3 constante, 4 operadores.', source: `${SUP}/excel/get-started/overview-of-formulas-in-excel` } },
          { h: 'Digitar e editar',
            items: [
              'Clique na célula, digite o sinal de igual e monte a fórmula. Em vez de digitar referências, clique nas células: o Excel escreve a referência e colore cada uma, na fórmula e na planilha.',
              'Enter confirma; Esc cancela. <strong>Ctrl+Enter</strong> confirma e mantém a célula selecionada — ou, com várias células selecionadas, lança a mesma fórmula em todas.',
              'Para editar, F2 ou a barra de fórmulas. Enquanto edita, F2 alterna entre os modos Editar e Apontar (no modo Apontar, as setas escolhem células em vez de mover o cursor no texto).',
              'Uma fórmula pode ter até 8.192 caracteres; a barra de fórmulas pode ser expandida pela setinha à direita (Ctrl+Shift+U).'
            ] },
          { h: 'Operadores aritméticos',
            items: [
              'Adição (sinal de mais), subtração ou negação (sinal de menos), multiplicação (asterisco), divisão (barra), porcentagem (sinal de por cento: 20% vale 0,2) e exponenciação (acento circunflexo: dois elevado a três dá 8).'
            ] },
          { h: 'Operadores de comparação e de texto',
            p: 'Comparações devolvem VERDADEIRO ou FALSO: igual, maior que, menor que, maior ou igual, menor ou igual e diferente (os sinais de menor e maior juntos). São a base da função SE (Módulo 07). O operador de texto é o <strong>e comercial</strong>, que junta textos: nome, um espaço e sobrenome viram "Maria Silva".',
            code: '=A1>=B1        → VERDADEIRO ou FALSO\n=A1<>B1        → diferente de\n=A2&" "&B2     → junta nome e sobrenome com um espaço' },
          { h: 'Operadores de referência e o ponto e vírgula',
            items: [
              '<strong>Dois-pontos</strong> — intervalo: de B5 até B15.',
              '<strong>Ponto e vírgula</strong> — no Excel em português, separa os argumentos de uma função e também une referências: somar B5 a B15 e D5 a D15. No Excel em inglês esse papel é da vírgula — por isso fórmulas copiadas de sites em inglês dão erro até você trocar vírgula por ponto e vírgula. A vírgula, aqui, é o separador decimal.',
              '<strong>Espaço</strong> — interseção: as células comuns a dois intervalos.'
            ],
            code: '=SOMA(B5:B15)\n=SOMA(B5:B15;D5:D15)\n=SOMA(B7:D7 C6:C8)   → só C7, a interseção' },
          { h: 'A ordem de cálculo',
            p: 'O Excel não calcula simplesmente da esquerda para a direita. A precedência é: operadores de referência; negação (o sinal de menos na frente de um número); porcentagem; exponenciação; multiplicação e divisão; adição e subtração; o e comercial; e por último as comparações. Operadores do mesmo nível são calculados da esquerda para a direita. Parênteses mudam a ordem — o que está dentro deles é calculado primeiro.',
            code: '=5+2*3      → 11 (multiplica antes)\n=(5+2)*3    → 21\n=-2^2       → 4  (a negação vem antes da potência)\n=-(2^2)     → -4' },
          { h: 'Como isso cai na prova',
            items: [
              'A prova pede fórmulas que produzam um resultado específico; a verificação é pelo valor e, muitas vezes, pela presença da referência (e não do número digitado). Clique nas células em vez de digitar os valores.',
              'Em cálculos com percentual, use parênteses: o preço com desconto de 10% é o preço vezes, entre parênteses, um menos o desconto.',
              'Lembre-se: a MO-211 é em inglês, onde o separador de argumentos é a vírgula.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Visão geral de fórmulas no Excel', u: `${SUP}/excel/get-started/overview-of-formulas-in-excel` },
          { t: 'Microsoft Suporte — Operadores de cálculo e precedência', u: `${SUP}/excel/calculation-operators-and-precedence-in-excel` },
          { t: 'Microsoft Suporte — Criar uma fórmula simples', u: `${SUP}/excel/create-a-simple-formula-in-excel` }
        ]
      },
      {
        id: 'xl-referencias', title: 'Referências relativas, absolutas e mistas — e referências a outras planilhas e pastas',
        desc: 'O que acontece com cada tipo de referência ao copiar a fórmula, a tecla F4, referências a outras planilhas, referências 3D e links para outras pastas de trabalho.',
        objetivos: [
          'Prever como uma referência muda ao copiar a fórmula',
          'Travar linha, coluna ou ambas com o cifrão e a tecla F4',
          'Referenciar outras planilhas, várias planilhas (3D) e outras pastas de trabalho'
        ],
        body: 'Você escreve uma fórmula na primeira linha e arrasta para baixo: em 90% das vezes funciona; nos outros 10%, aparece zero, erro ou um valor absurdo. A causa quase sempre é o tipo de referência. Este é o conceito mais importante de todo o módulo de fórmulas — e está explicitamente na prova Associate ("inserir referências relativas, absolutas e mistas").',
        content: [
          { h: 'Referência relativa (o padrão)',
            p: 'Uma referência comum, como B4, é relativa: o Excel a guarda como "a célula duas colunas à esquerda, na mesma linha". Ao copiar a fórmula uma linha para baixo, ela passa a apontar para B5; uma coluna para a direita, para C4. É isso que permite escrever o cálculo uma vez e estendê-lo para mil linhas.',
            img: { src: `${XL_IMG}/m06/ref-relativa.gif`, alt: 'Fórmula com referência relativa copiada', caption: 'Relativa: a referência acompanha o deslocamento da fórmula.', source: `${SUP}/excel/get-started/overview-of-formulas-in-excel` } },
          { h: 'Referência absoluta',
            p: 'Com o cifrão antes da coluna e antes da linha, a referência fica travada: copie para onde quiser e ela continua apontando para a mesma célula. É o caso típico de um valor fixo usado por muitas linhas — a taxa de câmbio, a alíquota, a meta.',
            code: 'D2:  =C2*$G$1     (preço em reais × cotação em G1)\nD3:  =C3*$G$1     ← ao copiar, C muda; G1 fica',
            img: { src: `${XL_IMG}/m06/ref-absoluta.gif`, alt: 'Fórmula com referência absoluta copiada', caption: 'Absoluta: a referência não muda ao copiar.', source: `${SUP}/excel/get-started/overview-of-formulas-in-excel` } },
          { h: 'Referência mista',
            p: 'Trava só uma das partes: cifrão antes da coluna (a coluna fica, a linha muda) ou antes da linha (a linha fica, a coluna muda). É o recurso para tabelas de duas entradas, como uma tabuada ou uma tabela de preço × quantidade, em que a mesma fórmula é copiada para baixo e para o lado.',
            code: 'B2:  =$A2*B$1     → copiada para toda a tabela, cada célula\n                    multiplica o valor da coluna A da sua linha\n                    pelo valor da linha 1 da sua coluna',
            img: { src: `${XL_IMG}/m06/ref-mista.gif`, alt: 'Fórmula com referência mista copiada', caption: 'Mista: só a parte com cifrão fica travada.', source: `${SUP}/excel/get-started/overview-of-formulas-in-excel` } },
          { h: 'A tecla F4',
            p: 'Com o cursor sobre uma referência na barra de fórmulas (ou logo depois de clicar na célula ao montar a fórmula), cada toque em F4 alterna entre os quatro tipos: absoluta (cifrão na coluna e na linha), linha travada, coluna travada e relativa de novo. A tabela oficial resume o efeito de copiar a fórmula duas linhas para baixo e duas colunas para a direita:',
            items: [
              'Absoluta, com cifrão nos dois: continua exatamente igual.',
              'Linha travada (cifrão antes do 1): a coluna anda duas letras e a linha fica — A1 vira C1.',
              'Coluna travada (cifrão antes do A): a coluna fica e a linha anda duas — vira A3.',
              'Relativa: as duas andam — vira C3.'
            ],
            img: { src: `${XL_IMG}/m06/copiar-formula.gif`, alt: 'Fórmula copiada de A1 para duas linhas abaixo e duas colunas à direita', caption: 'O deslocamento usado na tabela: duas linhas para baixo e duas colunas para a direita.', source: `${SUP}/excel/switch-between-relative-absolute-and-mixed-references` } },
          { h: 'Copiar x recortar uma fórmula',
            p: 'Copiar (e colar ou arrastar a alça) ajusta as referências relativas. Recortar e colar move a fórmula sem alterar nenhuma referência. Para copiar a fórmula "exatamente como está", sem ajuste, copie o texto da barra de fórmulas (não a célula).' },
          { h: 'Referência a outra planilha',
            p: 'O nome da planilha vem antes da referência, separado por um ponto de exclamação. Se o nome tiver espaços ou acentos, fica entre apóstrofos. O jeito mais fácil é não digitar: comece a fórmula, clique na guia da outra planilha, selecione as células e pressione Enter.',
            code: '=Vendas!B4\n=SOMA(\'Vendas 2026\'!B2:B200)\n=MÉDIA(Marketing!B1:B10)',
            img: { src: `${XL_IMG}/m06/ref-outra-planilha.gif`, alt: 'Fórmula com referência a outra planilha', caption: '1 nome da planilha, 2 intervalo, 3 o ponto de exclamação que separa os dois (imagem original em inglês, com a função AVERAGE, que é a MÉDIA).', source: `${SUP}/excel/get-started/overview-of-formulas-in-excel` } },
          { h: 'Referência 3D: a mesma célula em várias planilhas',
            p: 'Quando várias planilhas têm o mesmo layout (uma por mês, uma por filial), uma referência 3D soma a mesma célula em todas as planilhas entre a primeira e a última citadas: o intervalo de planilhas usa dois-pontos. Planilhas inseridas entre as duas pontas passam a entrar no cálculo; planilhas movidas para fora saem.',
            code: '=SOMA(Janeiro:Dezembro!B5)     → B5 de todas as planilhas de Janeiro a Dezembro' },
          { h: 'Links para outras pastas de trabalho',
            p: 'Um link de pasta de trabalho (antes chamado de referência externa) traz valores de outro arquivo. Com as duas pastas abertas, comece a fórmula, alterne para a outra pasta (Exibir > Alternar Janelas), clique na célula e pressione Enter. O nome do arquivo aparece entre colchetes, antes do nome da planilha, e a referência vem absoluta (retire os cifrões se for copiar). Com o arquivo de origem fechado, o Excel mostra o caminho completo. Também dá para criar o link com Copiar e Colar > Colar Vínculo.',
            code: "=[Orcamento.xlsx]Plan1!$B$4\n='C:\\Relatorios\\[Orcamento.xlsx]Plan1'!$B$4     ← com o arquivo fechado" },
          { h: 'Gerenciar os links',
            items: [
              'Ao abrir um arquivo com links, o Excel mostra um aviso de segurança; clique em <strong>Habilitar Conteúdo</strong> para permitir a atualização.',
              'Dados > Consultas e Conexões > <strong>Links de Pasta de Trabalho</strong> abre o painel que lista as origens, com Atualizar, Alterar origem, Abrir e <strong>Quebrar link</strong> (substitui as fórmulas pelos valores atuais — não pode ser desfeito).',
              'Renomear ou mover o arquivo de origem quebra o link; use Alterar origem para apontar o novo local.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              '"Na célula D2, calcule o valor em dólar usando a cotação de G1 e copie até D50" — a prova confere se todas as linhas estão certas: G1 precisa estar absoluta.',
              '"Some o valor de B5 das planilhas Jan a Dez" — referência 3D.',
              'A MO-211 cobra "referenciar dados em outras pastas de trabalho": link por fórmula ou Colar Vínculo.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Alternar entre referências relativas, absolutas e mistas', u: `${SUP}/excel/switch-between-relative-absolute-and-mixed-references` },
          { t: 'Microsoft Suporte — Mover ou copiar uma fórmula', u: `${SUP}/excel/move-or-copy-a-formula-in-excel` },
          { t: 'Microsoft Suporte — Referência à mesma célula em várias planilhas (3D)', u: `${SUP}/excel/create-a-reference-to-the-same-cell-range-on-multiple-worksheets` },
          { t: 'Microsoft Suporte — Criar links de pasta de trabalho', u: `${SUP}/excel/create-workbook-links` },
          { t: 'Microsoft Suporte — Gerenciar links de pasta de trabalho', u: `${SUP}/excel/manage-workbook-links` }
        ]
      },
      {
        id: 'xl-nomes-definidos', title: 'Nomes definidos: dar nome a células, intervalos e constantes',
        desc: 'Criar nomes pela Caixa de Nome, por Definir Nome e por Criar a partir da Seleção, usar nomes em fórmulas, escopo e o Gerenciador de Nomes.',
        objetivos: [
          'Definir nomes para células, intervalos e constantes',
          'Usar nomes em fórmulas e para navegar',
          'Editar, excluir e filtrar nomes no Gerenciador de Nomes, entendendo o escopo'
        ],
        body: 'Qual fórmula é mais fácil de entender: uma que multiplica C2 pela célula G1 com cifrões, ou uma que multiplica o Preço pela Cotação? Nomes deixam fórmulas legíveis, funcionam como referências absolutas e servem de atalho de navegação. A prova Associate pede "definir um intervalo nomeado" e "referenciar intervalos nomeados em fórmulas".',
        content: [
          { h: 'Três formas de criar um nome',
            items: [
              '<strong>Caixa de Nome</strong> — selecione a célula ou o intervalo, clique na Caixa de Nome (à esquerda da barra de fórmulas), digite o nome e pressione Enter. É o jeito mais rápido; o Enter é obrigatório.',
              '<strong>Definir Nome</strong> — Fórmulas > Nomes Definidos > Definir Nome: além do nome, você escolhe o <strong>Escopo</strong>, escreve um <strong>Comentário</strong> e ajusta o campo <strong>Refere-se a</strong>, que pode ser um intervalo, uma constante ou uma fórmula.',
              '<strong>Criar a partir da Seleção</strong> — selecione a tabela inteira, incluindo os títulos, e em Fórmulas > Criar a partir da Seleção indique onde estão os rótulos (Linha superior, Coluna esquerda, Linha inferior, Coluna direita). O Excel cria de uma vez um nome para cada coluna ou linha, usando o título (espaços viram sublinhado).'
            ] },
          { h: 'Regras para nomes',
            items: [
              'Começar com letra, sublinhado ou barra invertida; o resto pode ter letras, números, pontos e sublinhados.',
              'Sem espaços; não pode ser igual a uma referência (como A1, R1C1 ou uma coluna tipo XFD1), nem ser só as letras C ou R.',
              'Até 255 caracteres; maiúsculas e minúsculas não se diferenciam (Vendas e VENDAS são o mesmo nome).'
            ] },
          { h: 'Nomes para constantes',
            p: 'Um nome não precisa apontar para uma célula. Em Definir Nome, escreva no Refere-se a um valor, como 0,18 para Aliquota_ICMS. As fórmulas passam a usar o nome, e ninguém altera a alíquota por engano numa célula — mudar o valor exige ir ao Gerenciador de Nomes.' },
          { h: 'Usar nomes nas fórmulas e para navegar',
            items: [
              'Digite as primeiras letras do nome dentro da fórmula e escolha na lista do AutoCompletar (Tab confirma).',
              'Fórmulas > <strong>Usar em Fórmula</strong> lista os nomes; F3 abre a caixa Colar Nome.',
              'Nomes são referências absolutas: copiar a fórmula não os desloca.',
              'Para ir a um intervalo nomeado, escolha o nome na seta da Caixa de Nome ou em F5 (Ir para) — essa é a habilidade "navegar para elementos nomeados" da prova.',
              'Criou nomes depois das fórmulas? Fórmulas > Definir Nome > <strong>Aplicar Nomes</strong> troca as referências existentes pelos nomes correspondentes.'
            ],
            code: '=Preco*Cotacao\n=SOMA(Vendas_Jan)\n=Valor*Aliquota_ICMS' },
          { h: 'Gerenciador de Nomes (Ctrl+F3)',
            p: 'Fórmulas > <strong>Gerenciador de Nomes</strong> lista todos os nomes definidos e nomes de tabela, com Valor, Refere-se a, Escopo e Comentário. Ali você cria (Novo), edita, exclui e usa o botão <strong>Filtro</strong> para ver só nomes com escopo de planilha, com escopo de pasta, nomes com erros (útil para limpar nomes que apontam para células excluídas, que mostram o erro de referência), nomes definidos ou nomes de tabela.',
            img: { src: `${XL_IMG}/m06/gerenciador-de-nomes.png`, alt: 'Caixa de diálogo Gerenciador de Nomes', caption: 'Gerenciador de Nomes: todos os nomes da pasta, com valor, referência e escopo.', source: `${SUP}/excel/use-the-name-manager-in-excel` } },
          { h: 'Escopo: pasta de trabalho ou planilha',
            p: 'O escopo define onde o nome é reconhecido. O padrão é <strong>Pasta de Trabalho</strong>: o nome vale em todas as planilhas e precisa ser único na pasta. Com escopo de uma <strong>planilha</strong>, o nome só é reconhecido nela — o que permite ter um nome "Total" diferente em cada planilha. O escopo é escolhido ao criar o nome e não pode ser alterado depois pela edição (é preciso recriar).' },
          { h: 'Como isso cai na prova',
            items: [
              '"Defina o nome Comissao para a célula H2" — Caixa de Nome ou Definir Nome; atenção à grafia exata e ao escopo, se a tarefa informar.',
              '"Crie nomes para as colunas usando os títulos" — Criar a partir da Seleção, Linha superior.',
              '"Na célula B20, some o intervalo nomeado Receitas" — use o nome, não o endereço.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Definir e usar nomes em fórmulas', u: `${SUP}/excel/get-started/define-and-use-names-in-formulas` },
          { t: 'Microsoft Suporte — Usar o Gerenciador de Nomes', u: `${SUP}/excel/use-the-name-manager-in-excel` }
        ]
      },
      {
        id: 'xl-referencias-estruturadas', title: 'Referências estruturadas: fórmulas com nomes de tabela e coluna',
        desc: 'Como o Excel escreve fórmulas que apontam para tabelas, o que significam a arroba e os especificadores Tudo, Dados, Cabeçalhos e Totais, e por que elas se ajustam sozinhas.',
        objetivos: [
          'Ler e escrever referências a tabela, coluna e linha atual',
          'Usar os especificadores especiais de uma tabela',
          'Entender como as referências estruturadas reagem a mudanças na tabela'
        ],
        body: 'Quando você clica numa célula de tabela ao montar uma fórmula, o Excel não escreve C2 — escreve o nome da coluna. Isso se chama referência estruturada. A fórmula fica legível ("preço vezes quantidade") e se ajusta sozinha quando a tabela cresce, quando uma coluna muda de nome ou é movida. A prova Associate pede "referenciar tabelas nomeadas em fórmulas".',
        content: [
          { h: 'A sintaxe',
            items: [
              '<strong>Coluna inteira</strong> — o nome da tabela seguido do nome da coluna entre colchetes. Fora da tabela, o nome da tabela é obrigatório; dentro dela, pode ser omitido.',
              '<strong>Linha atual</strong> — a arroba antes do nome da coluna significa "o valor desta coluna na mesma linha da fórmula". É o que aparece nas colunas calculadas.',
              '<strong>Várias colunas</strong> — as duas colunas entre colchetes, separadas por dois-pontos: de Janeiro a Dezembro.',
              '<strong>Nomes com espaços ou caracteres especiais</strong> ganham um par extra de colchetes.'
            ],
            code: '=SOMA(tbVendas[Valor])                  → soma a coluna Valor da tabela tbVendas\n=[@Preco]*[@Qtd]                         → coluna calculada: preço × quantidade da linha\n=SOMA(tbVendas[@[Janeiro]:[Dezembro]])   → soma de janeiro a dezembro na linha\n=MÉDIA(tbVendas[[#Totais];[Valor]])      → a célula da linha de totais da coluna Valor' },
          { h: 'Especificadores de item',
            items: [
              '<strong>#Tudo</strong> — a tabela inteira: cabeçalho, dados e totais.',
              '<strong>#Dados</strong> — só as linhas de dados (é o que se usa quando nada é especificado).',
              '<strong>#Cabeçalhos</strong> — a linha de cabeçalho.',
              '<strong>#Totais</strong> — a linha de totais (se não existir, o resultado é vazio).',
              '<strong>Arroba</strong> — a linha atual (antigamente escrita como Esta Linha).'
            ] },
          { h: 'Por que usar',
            items: [
              '<strong>Expansão automática</strong> — a soma da coluna Valor passa a incluir as linhas novas sem mexer na fórmula; uma referência como B2:B500 não faria isso.',
              '<strong>Renomear coluna</strong> — todas as fórmulas que usam aquele título são atualizadas.',
              '<strong>Legibilidade</strong> — a fórmula diz o que calcula.',
              '<strong>Validação e gráficos</strong> — gráficos e tabelas dinâmicas baseados na tabela também crescem com ela.'
            ] },
          { h: 'Cuidados',
            items: [
              'Arrastar a alça para o lado com uma referência de coluna inteira desloca a coluna (como uma referência relativa); copiar e colar não desloca. Para fixar, use a forma de intervalo de coluna, repetindo o nome: a coluna Valor até a coluna Valor.',
              'Ao converter a tabela em intervalo, as referências estruturadas viram referências comuns de célula.',
              'Se preferir referências comuns ao clicar em tabelas, desligue em Arquivo > Opções > Fórmulas > "Usar nomes de tabela em fórmulas".'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              '"Na célula H2, some a coluna Receita da tabela Vendas2026" — clique na coluna ao montar a fórmula ou escreva a referência estruturada.',
              '"Crie uma coluna calculada Total que multiplique Qtd por Preço" — digite numa célula da coluna nova, clicando nas células da mesma linha: o Excel gera a forma com arroba e preenche a coluna.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Usar referências estruturadas com tabelas do Excel', u: `${SUP}/excel/using-structured-references-with-excel-tables` }
        ]
      },
      {
        id: 'xl-funcoes-basicas', title: 'Funções essenciais: SOMA, MÉDIA, MÁXIMO, MÍNIMO e as contagens',
        desc: 'Inserir funções pela AutoSoma, pelo botão Inserir Função e digitando; SOMA, MÉDIA, MÁXIMO, MÍNIMO, CONT.NÚM, CONT.VALORES, CONTAR.VAZIO e ARRED.',
        objetivos: [
          'Inserir funções pela AutoSoma, pela caixa Inserir Função e pela digitação',
          'Usar SOMA, MÉDIA, MÁXIMO e MÍNIMO sabendo o que cada uma ignora',
          'Diferenciar CONT.NÚM, CONT.VALORES e CONTAR.VAZIO, e arredondar com ARRED'
        ],
        body: 'Funções são fórmulas prontas: em vez de somar célula a célula, você diz "some este intervalo". Nesta aula ficam as sete funções que a prova Associate lista nominalmente para cálculos e contagens — e o detalhe que mais cai: o que cada uma considera ou ignora (texto, células vazias, zeros).',
        content: [
          { h: 'Três formas de inserir uma função',
            items: [
              '<strong>AutoSoma</strong> (Página Inicial > Edição, ou Fórmulas > Biblioteca de Funções; atalho Alt+=) — selecione a célula logo abaixo de uma coluna de números (ou à direita de uma linha), clique em AutoSoma e confira o intervalo sugerido antes do Enter. A seta do botão oferece Soma, Média, Contar Números, Máx e Mín.',
              '<strong>Inserir Função</strong> (o botão fx ao lado da barra de fórmulas, ou Shift+F3) — procura a função por descrição e abre a caixa <strong>Argumentos da Função</strong>, que explica cada argumento e mostra o resultado parcial.',
              '<strong>Digitando</strong> — após o sinal de igual e as primeiras letras, o AutoCompletar lista as funções; Tab insere a escolhida e abre o parêntese. Uma dica flutuante mostra os argumentos, com o atual em negrito; argumentos entre colchetes são opcionais.'
            ],
            img: { src: `${XL_IMG}/m06/autosoma-formula.jpg`, alt: 'AutoSoma criando a fórmula SOMA com o intervalo destacado', caption: 'AutoSoma: o Excel propõe o intervalo; confira antes de confirmar.', source: `${SUP}/excel/use-autosum-to-sum-numbers-in-excel` } },
          { h: 'SOMA, MÉDIA, MÁXIMO e MÍNIMO',
            items: [
              '<strong>SOMA</strong> (SUM) — soma números de intervalos e valores, até 255 argumentos. Texto e células vazias no intervalo são ignorados.',
              '<strong>MÉDIA</strong> (AVERAGE) — média aritmética. Ignora texto, valores lógicos e células vazias, mas <strong>conta os zeros</strong>: uma venda zero puxa a média para baixo; uma célula vazia, não.',
              '<strong>MÁXIMO</strong> (MAX) e <strong>MÍNIMO</strong> (MIN) — o maior e o menor número do intervalo, ignorando texto e vazios.'
            ],
            code: '=SOMA(B2:B13)\n=MÉDIA(B2:B13)\n=MÁXIMO(B2:B13)\n=MÍNIMO(B2:B13;D2:D13)' },
          { h: 'As três contagens',
            items: [
              '<strong>CONT.NÚM</strong> (COUNT) — conta só as células com <strong>números</strong> (datas contam, porque são números).',
              '<strong>CONT.VALORES</strong> (COUNTA) — conta as células <strong>não vazias</strong>: números, texto, valores lógicos, erros e até um texto vazio gerado por fórmula.',
              '<strong>CONTAR.VAZIO</strong> (COUNTBLANK) — conta as células <strong>vazias</strong> do intervalo; células com fórmula que devolve texto vazio também contam como vazias. Zero não é vazio.'
            ],
            code: 'Intervalo com: 10, "ok", (vazia), 0, 25/09/2026\n=CONT.NÚM(A1:A5)      → 3  (10, 0 e a data)\n=CONT.VALORES(A1:A5)  → 4\n=CONTAR.VAZIO(A1:A5)  → 1' },
          { h: 'Arredondar de verdade: ARRED',
            p: 'Formatar com menos casas decimais só esconde (Módulo 03). Para mudar o valor, use <strong>ARRED</strong> (ROUND) com o número e a quantidade de casas: duas casas para centavos, zero para inteiros, e números negativos arredondam à esquerda da vírgula (menos dois arredonda para a centena). ARREDONDAR.PARA.CIMA e ARREDONDAR.PARA.BAIXO forçam a direção.',
            code: '=ARRED(2,4567;2)     → 2,46\n=ARRED(1234;-2)      → 1200\n=ARRED(B2*C2;2)      → o cálculo já arredondado para centavos' },
          { h: 'A barra de status como calculadora',
            p: 'Para uma conferência rápida, selecione as células: a barra de status mostra Média, Contagem e Soma. Clique com o botão direito nela para exibir também Contagem Numérica, Mínimo e Máximo. Nada é gravado na planilha.' },
          { h: 'Como isso cai na prova',
            items: [
              '"Em B15, calcule a média de B2:B14" — MÉDIA; confira se o intervalo da AutoSoma não pegou o título ou o total.',
              '"Conte quantos clientes não informaram o telefone" — CONTAR.VAZIO na coluna do telefone.',
              '"Conte quantos pedidos existem" numa coluna de códigos em texto — CONT.VALORES (CONT.NÚM daria zero).'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Usar a AutoSoma para somar números', u: `${SUP}/excel/use-autosum-to-sum-numbers-in-excel` },
          { t: 'Microsoft Suporte — Função SOMA', u: `${SUP}/excel/functions/sum-function` },
          { t: 'Microsoft Suporte — Função MÉDIA', u: `${SUP}/excel/functions/average-function` },
          { t: 'Microsoft Suporte — Função CONT.NÚM', u: `${SUP}/excel/functions/count-function` },
          { t: 'Microsoft Suporte — Função CONT.VALORES', u: `${SUP}/excel/functions/counta-function` },
          { t: 'Microsoft Suporte — Função CONTAR.VAZIO', u: `${SUP}/excel/functions/countblank-function` },
          { t: 'Microsoft Suporte — Função ARRED', u: `${SUP}/excel/functions/round-function` }
        ]
      }
    ]
  },
  {
    id: 'xl-m07', title: 'Módulo 07 · Funções lógicas e cálculos condicionais', kind: 'video',
    lessons: [
      {
        id: 'xl-funcao-se', title: 'A função SE e o tratamento de erros com SEERRO',
        desc: 'Testar uma condição e devolver um resultado para verdadeiro e outro para falso, aninhar SEs, e trocar erros por mensagens com SEERRO e SENÃODISP.',
        objetivos: [
          'Escrever testes lógicos com os operadores de comparação',
          'Usar SE com texto, números e cálculos nos resultados, e aninhar SEs',
          'Tratar erros com SEERRO e SENÃODISP'
        ],
        body: 'SE é a função que dá "inteligência" à planilha: "se a venda passou da meta, pague comissão; senão, zero". Ela aparece em quase toda planilha de verdade e é a única função lógica cobrada nominalmente na prova Associate ("executar operações condicionais usando a função SE"). Na Expert, o foco são os SEs aninhados e as combinações com E, OU e NÃO.',
        content: [
          { h: 'A sintaxe',
            p: 'SE recebe três argumentos, separados por ponto e vírgula: o <strong>teste lógico</strong> (algo que resulta em VERDADEIRO ou FALSO), o <strong>valor se verdadeiro</strong> e o <strong>valor se falso</strong> (opcional — se omitido e o teste falhar, a função devolve FALSO).',
            code: 'SE(teste_lógico; valor_se_verdadeiro; [valor_se_falso])\n\n=SE(C2>B2;"Acima do orçamento";"Dentro do orçamento")\n=SE(C2="Sim";1;2)\n=SE(B2>=Meta;B2*5%;0)',
            img: { src: `${XL_IMG}/m07/se-orcamento.png`, alt: 'Exemplo de SE comparando gasto real com orçamento', caption: 'SE devolvendo um texto para cada situação.', source: `${SUP}/excel/functions/if-function` } },
          { h: 'Regras práticas',
            items: [
              'Texto no resultado ou no teste vai entre aspas duplas; números, referências e fórmulas vão sem aspas.',
              'Os resultados podem ser cálculos: pagar 5% de comissão se bateu a meta, ou zero.',
              'Para deixar a célula "vazia" quando o teste falha, use duas aspas duplas seguidas (texto vazio) — cuidado: CONT.VALORES conta essa célula.',
              'Comparação de texto não diferencia maiúsculas: "sim" e "SIM" são iguais para o SE.',
              'O teste pode ser a própria função lógica: um teste que já devolve VERDADEIRO ou FALSO não precisa de "igual a VERDADEIRO".'
            ] },
          { h: 'SEs aninhados',
            p: 'Para mais de duas saídas, coloca-se um SE dentro do argumento de falso do outro. O Excel avalia na ordem e para no primeiro teste verdadeiro — por isso a ordem dos testes importa: do maior para o menor, ou do mais específico para o mais geral. O Excel permite até 64 níveis, mas passar de três ou quatro deixa a fórmula difícil de manter; nesses casos use SES (próxima aula) ou uma tabela de faixas com PROCX (Módulo 09).',
            code: '=SE(A2>=90;"A";SE(A2>=80;"B";SE(A2>=70;"C";"D")))' },
          { h: 'SEERRO e SENÃODISP',
            items: [
              '<strong>SEERRO</strong> (IFERROR) — devolve o valor normalmente, mas se ele for qualquer erro (divisão por zero, valor não disponível, referência inválida...) devolve o que você indicar: zero, texto vazio ou uma mensagem.',
              '<strong>SENÃODISP</strong> (IFNA) — trata só o erro de valor não disponível (o famoso N/D das funções de procura), deixando os outros erros aparecerem. É mais seguro: não esconde erros de fórmula de verdade.',
              'Não use SEERRO para "limpar" planilhas por hábito: um erro escondido vira um número errado silencioso.'
            ],
            code: '=SEERRO(B2/C2;0)                      → zero em vez de erro de divisão por zero\n=SENÃODISP(PROCV(A2;Tabela;2;0);"Não encontrado")' },
          { h: 'Como isso cai na prova',
            items: [
              '"Na coluna Situação, exiba Aprovado quando a nota for maior ou igual a 7 e Reprovado caso contrário" — SE com os textos exatamente como no enunciado (maiúsculas e acentos contam na conferência visual).',
              '"Calcule o bônus de 10% para quem ultrapassou a meta em H1" — SE com cálculo e referência absoluta à meta.',
              'Verifique a borda do teste: "maior que" é diferente de "maior ou igual".'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Função SE', u: `${SUP}/excel/functions/if-function` },
          { t: 'Microsoft Suporte — Função SEERRO', u: `${SUP}/excel/functions/iferror-function` },
          { t: 'Microsoft Suporte — Função SENÃODISP', u: `${SUP}/excel/functions/ifna-function` }
        ]
      },
      {
        id: 'xl-e-ou-ses-parametro', title: 'E, OU, NÃO, SES e PARÂMETRO',
        desc: 'Combinar condições com E, OU e NÃO dentro do SE, substituir SEs aninhados por SES e escolher resultados por correspondência exata com PARÂMETRO.',
        objetivos: [
          'Combinar várias condições com E, OU e NÃO',
          'Reescrever SEs aninhados com SES, incluindo um resultado padrão',
          'Usar PARÂMETRO para mapear valores em resultados'
        ],
        body: 'Regras de negócio raramente têm uma condição só: "bônus para quem bateu a meta de vendas E a de clientes", "frete grátis se o pedido passar de R$ 300 OU o cliente for VIP". As funções E, OU e NÃO montam essas regras; SES e PARÂMETRO deixam fórmulas com muitas saídas legíveis. Todas estão na lista da prova Expert.',
        content: [
          { h: 'E, OU e NÃO',
            items: [
              '<strong>E</strong> (AND) — VERDADEIRO só se <strong>todas</strong> as condições forem verdadeiras.',
              '<strong>OU</strong> (OR) — VERDADEIRO se <strong>pelo menos uma</strong> for verdadeira.',
              '<strong>NÃO</strong> (NOT) — inverte: VERDADEIRO vira FALSO e vice-versa.',
              'E e OU aceitam até 255 condições. Sozinhas, só devolvem VERDADEIRO ou FALSO; o uso comum é como teste lógico do SE.'
            ],
            code: '=E(B2>=8500;C2>=5)                      → bateu as duas metas?\n=SE(E(B2>=$B$7;C2>=$B$5);B2*$B$8;0)    → bônus só com as duas metas\n=SE(OU(D2>300;E2="VIP");"Frete grátis";"Frete pago")\n=SE(NÃO(F2="Cancelado");G2;0)',
            img: { src: `${XL_IMG}/m07/se-e-bonus.png`, alt: 'Cálculo de bônus com SE e E', caption: 'Comissão com OU (basta uma meta) e bônus com E (as duas metas) — imagem original em inglês.', source: `${SUP}/excel/functions/and-function` } },
          { h: 'SES: vários testes sem aninhar',
            p: '<strong>SES</strong> (IFS) recebe pares de teste e resultado e devolve o resultado do <strong>primeiro teste verdadeiro</strong>. São até 127 pares. Se nenhum teste for verdadeiro, o resultado é o erro de valor não disponível — por isso, para ter um "senão", o último teste é simplesmente VERDADEIRO.',
            code: 'SES(teste1; resultado1; [teste2; resultado2]; ...)\n\n=SES(A2>89;"A";A2>79;"B";A2>69;"C";A2>59;"D";VERDADEIRO;"F")',
            img: { src: `${XL_IMG}/m07/ses-notas.png`, alt: 'Exemplo de SES convertendo notas em conceitos', caption: 'SES: notas viram conceitos; VERDADEIRO no fim funciona como "senão".', source: `${SUP}/excel/functions/ifs-function` } },
          { h: 'PARÂMETRO: correspondência exata',
            p: '<strong>PARÂMETRO</strong> (SWITCH) compara uma expressão com uma lista de valores e devolve o resultado do primeiro valor igual. Um último argumento sem par funciona como padrão; sem padrão e sem correspondência, o resultado é o erro de valor não disponível. É ideal para códigos: 1 vira Domingo, 2 vira Segunda-feira. Diferença para SES: PARÂMETRO só testa igualdade com uma expressão; SES aceita qualquer teste (maior que, entre faixas, condições combinadas).',
            code: 'PARÂMETRO(expressão; valor1; resultado1; [valor2; resultado2]; ...; [padrão])\n\n=PARÂMETRO(DIA.DA.SEMANA(A2);1;"Domingo";7;"Sábado";"Dia útil")',
            img: { src: `${XL_IMG}/m07/parametro-argumentos.png`, alt: 'Os argumentos da função PARÂMETRO numerados', caption: '1 a expressão, 2 o valor procurado, 3 o resultado, 4 o padrão.', source: `${SUP}/excel/functions/switch-function` } },
          { h: 'Qual usar',
            items: [
              'Duas saídas: SE.',
              'Várias faixas ou condições diferentes: SES (ou SEs aninhados).',
              'Um código com vários valores exatos: PARÂMETRO.',
              'Condições combinadas: E / OU dentro do teste do SE ou do SES.',
              'Muitas faixas que mudam com o tempo (tabela de comissão, faixas do imposto de renda): uma tabela auxiliar com PROCX aproximado é mais fácil de manter que qualquer fórmula lógica (Módulo 09).'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              'A MO-211 pede "operações lógicas usando funções aninhadas, incluindo SE, SES, PARÂMETRO, E, OU e NÃO" — espere tarefas como "exiba Premium quando o valor for maior que 1000 e o cliente for da região Sul".',
              'Em SES, confira a ordem dos testes: o primeiro verdadeiro vence.',
              'A prova Expert é em inglês: IF, IFS, SWITCH, AND, OR, NOT, com vírgula como separador.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Função E', u: `${SUP}/excel/functions/and-function` },
          { t: 'Microsoft Suporte — Função OU', u: `${SUP}/excel/functions/or-function` },
          { t: 'Microsoft Suporte — Função NÃO', u: `${SUP}/excel/functions/not-function` },
          { t: 'Microsoft Suporte — Função SES', u: `${SUP}/excel/functions/ifs-function` },
          { t: 'Microsoft Suporte — Função PARÂMETRO', u: `${SUP}/excel/functions/switch-function` }
        ]
      },
      {
        id: 'xl-agregacoes-condicionais', title: 'Somar, contar e calcular com critérios: SOMASES, CONT.SES e companhia',
        desc: 'CONT.SE, SOMASE e MÉDIASE com um critério; CONT.SES, SOMASES, MÉDIASES, MÁXIMOSES e MÍNIMOSES com vários; como escrever critérios com operadores, curingas, datas e referências.',
        objetivos: [
          'Escrever critérios com texto, números, operadores, curingas e referências a células',
          'Usar as versões de um critério e de vários critérios sem confundir a ordem dos argumentos',
          'Montar um quadro-resumo com agregações condicionais'
        ],
        body: '"Quanto o vendedor Diogo vendeu de maçãs?" "Quantos pedidos do Sul passaram de R$ 5 mil em setembro?" "Qual foi a maior venda da loja 3?" Essas perguntas se respondem com as funções condicionais de agregação, que somam, contam, calculam média, máximo ou mínimo só das linhas que atendem aos critérios. Todas estão na lista da prova Expert — e são, junto com PROCX, as funções mais usadas em relatórios reais.',
        content: [
          { h: 'Como se escreve um critério',
            items: [
              '<strong>Igualdade</strong> — o valor sozinho: "Sul", 32, ou uma referência a uma célula que contém o valor.',
              '<strong>Comparação</strong> — operador e valor entre aspas: "maior que 5000" se escreve com o sinal de maior e o número, tudo entre aspas; "diferente de Cancelado", com os sinais de menor e maior juntos.',
              '<strong>Operador com referência</strong> — o operador fica entre aspas e é unido à célula com o e comercial. Esse é o erro mais comum: colocar a referência dentro das aspas faz o Excel procurar o texto "E1", e não o valor da célula.',
              '<strong>Curingas</strong> — asterisco (qualquer sequência) e interrogação (um caractere): "começa com A", "contém Ltda".',
              '<strong>Datas</strong> — como números: "maior ou igual a" unido à célula com a data inicial, ou à função DATA.',
              'Critérios de texto não diferenciam maiúsculas e minúsculas.'
            ],
            code: '">5000"          "<>Cancelado"         ">="&E1\n"A*"             "*Ltda*"              ">="&DATA(2026;9;1)' },
          { h: 'Um critério: CONT.SE, SOMASE e MÉDIASE',
            p: 'Atenção à ordem: nas funções de um critério, o <strong>intervalo a somar vem por último</strong> (e é opcional — se omitido, soma o próprio intervalo testado).',
            code: 'CONT.SE(intervalo; critério)\nSOMASE(intervalo; critério; [intervalo_soma])\nMÉDIASE(intervalo; critério; [intervalo_média])\n\n=CONT.SE(C2:C500;"Sul")                 → quantos pedidos do Sul\n=SOMASE(C2:C500;"Sul";F2:F500)           → valor vendido no Sul\n=SOMASE(F2:F500;">5000")                 → soma dos pedidos acima de 5000\n=MÉDIASE(B2:B500;"Diogo";F2:F500)        → ticket médio do Diogo' },
          { h: 'Vários critérios: CONT.SES, SOMASES, MÉDIASES, MÁXIMOSES, MÍNIMOSES',
            p: 'Nas versões com vários critérios, o <strong>intervalo a calcular vem primeiro</strong>, seguido de pares intervalo de critério e critério (até 127 pares). Todos os critérios precisam ser atendidos ao mesmo tempo (lógica E). Os intervalos precisam ter o mesmo tamanho. CONT.SES não tem intervalo a calcular — só pares.',
            code: 'SOMASES(intervalo_soma; intervalo_crit1; crit1; [intervalo_crit2; crit2]; ...)\nCONT.SES(intervalo_crit1; crit1; [intervalo_crit2; crit2]; ...)\nMÉDIASES(intervalo_média; intervalo_crit1; crit1; ...)\nMÁXIMOSES(intervalo_máximo; intervalo_crit1; crit1; ...)\nMÍNIMOSES(intervalo_mínimo; intervalo_crit1; crit1; ...)\n\n=SOMASES(A2:A9;B2:B9;"A*";C2:C9;"Diogo")          → produtos que começam com A vendidos pelo Diogo\n=CONT.SES(C2:C500;"Sul";F2:F500;">5000")\n=MÁXIMOSES(F2:F500;D2:D500;3)                      → maior venda da loja 3\n=SOMASES(F2:F500;A2:A500;">="&H1;A2:A500;"<="&H2) → vendas entre as datas de H1 e H2' },
          { h: 'Lógica OU com essas funções',
            p: 'Os critérios das funções com SES são sempre E. Para "Sul OU Norte", some duas fórmulas: a soma do Sul mais a soma do Norte. Com mais valores, a forma compacta é passar uma lista entre chaves como critério e envolver tudo em SOMA — o Microsoft 365 calcula cada item e SOMA junta os resultados.',
            code: '=SOMASE(C2:C500;"Sul";F2:F500)+SOMASE(C2:C500;"Norte";F2:F500)\n=SOMA(SOMASES(F2:F500;C2:C500;{"Sul";"Norte"}))' },
          { h: 'Quadro-resumo: o uso de verdade',
            p: 'O padrão profissional é um quadro com os critérios nas bordas — regiões nas linhas, meses nas colunas — e uma única fórmula SOMASES copiada para todo o quadro, com referências mistas (Módulo 06) apontando para o título da linha e o da coluna. Com os dados numa tabela do Excel, as referências estruturadas fazem o quadro acompanhar a base conforme ela cresce.',
            code: 'B5: =SOMASES(tbVendas[Valor];tbVendas[Região];$A5;tbVendas[Mês];B$4)' },
          { h: 'Como isso cai na prova',
            items: [
              'A MO-211 lista SOMASE, MÉDIASE, CONT.SE, SOMASES, MÉDIASES, CONT.SES, MÁXIMOSES e MÍNIMOSES. A pegadinha clássica é a ordem dos argumentos: intervalo de soma por último em SOMASE, primeiro em SOMASES.',
              '"Calcule o total vendido pela região informada em J2" — use a referência J2 como critério, não o texto digitado.',
              'Em inglês: COUNTIF, SUMIF, AVERAGEIF, COUNTIFS, SUMIFS, AVERAGEIFS, MAXIFS, MINIFS.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Função CONT.SE', u: `${SUP}/excel/get-started/use-the-countif-function-in-microsoft-excel` },
          { t: 'Microsoft Suporte — Função SOMASE', u: `${SUP}/excel/functions/sumif-function` },
          { t: 'Microsoft Suporte — Função SOMASES', u: `${SUP}/excel/functions/sumifs-function` },
          { t: 'Microsoft Suporte — Função CONT.SES', u: `${SUP}/excel/functions/countifs-function` },
          { t: 'Microsoft Suporte — Função MÉDIASE', u: `${SUP}/excel/functions/averageif-function` },
          { t: 'Microsoft Suporte — Função MÉDIASES', u: `${SUP}/excel/functions/averageifs-function` },
          { t: 'Microsoft Suporte — Função MÁXIMOSES', u: `${SUP}/excel/functions/maxifs-function` },
          { t: 'Microsoft Suporte — Função MÍNIMOSES', u: `${SUP}/excel/functions/minifs-function` }
        ]
      },
      {
        id: 'xl-funcao-let', title: 'LET: variáveis dentro da fórmula',
        desc: 'Dar nomes a cálculos intermediários dentro de uma fórmula para ela ficar legível e mais rápida.',
        objetivos: [
          'Escrever uma fórmula LET com um ou mais pares nome e valor',
          'Reescrever uma fórmula repetitiva usando LET',
          'Conhecer as regras de nomes das variáveis'
        ],
        body: 'Fórmulas longas costumam repetir o mesmo pedaço várias vezes — e o Excel calcula esse pedaço em cada repetição. A função LET permite dar um nome a um cálculo dentro da própria fórmula, como uma variável: fica mais fácil de ler, de corrigir e mais rápida. LET faz parte da lista de funções aninhadas da prova Expert.',
        content: [
          { h: 'A sintaxe',
            p: 'LET recebe pares de <strong>nome</strong> e <strong>valor</strong> e, por último, o <strong>cálculo</strong> que usa esses nomes. O último argumento é sempre o resultado. São até 126 pares.',
            code: 'LET(nome1; valor1; [nome2; valor2; ...]; cálculo)\n\n=LET(x;1;x+1)                        → 2' },
          { h: 'Antes e depois',
            p: 'Sem LET, a mesma soma condicional aparece duas vezes (uma no teste, outra no resultado) e é calculada duas vezes. Com LET, ela é calculada uma vez e a regra de negócio fica legível.',
            code: 'Antes:\n=SE(SOMASES(F:F;B:B;H2)>Meta;SOMASES(F:F;B:B;H2)*5%;0)\n\nDepois:\n=LET(vendas;SOMASES(F:F;B:B;H2);\n     SE(vendas>Meta;vendas*5%;0))' },
          { h: 'Regras dos nomes',
            items: [
              'Começam com letra; seguem as mesmas regras dos nomes definidos (sem espaços, não podem parecer referência de célula; "c" e "r" sozinhos não valem).',
              'Valem só dentro daquela fórmula — não aparecem no Gerenciador de Nomes nem conflitam com os nomes da pasta.',
              'Um nome pode usar os nomes definidos antes dele: preço, depois imposto calculado sobre o preço, depois o total.',
              'Para escrever LETs longos, Alt+Enter quebra linhas dentro da barra de fórmulas e deixa cada variável numa linha.'
            ],
            code: '=LET(preco;B2; imposto;preco*18%; total;preco+imposto; ARRED(total;2))' },
          { h: 'Como isso cai na prova',
            items: [
              'Tarefas com LET costumam pedir para "definir a variável X como ... e retornar ..." — siga os nomes do enunciado.',
              'Lembre-se de que o último argumento precisa ser um cálculo; terminar com um par nome e valor gera erro.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Função LET', u: `${SUP}/excel/functions/let-function` }
        ]
      }
    ]
  },
  {
    id: 'xl-m08', title: 'Módulo 08 · Funções de texto e de data', kind: 'video',
    lessons: [
      {
        id: 'xl-texto-extrair', title: 'Extrair partes de um texto: ESQUERDA, DIREITA, EXT.TEXTO e companhia',
        desc: 'Pegar caracteres do início, do fim ou do meio de um texto, medir o tamanho, localizar a posição de um caractere e as funções modernas TEXTOANTES, TEXTODEPOIS e DIVIDIRTEXTO.',
        objetivos: [
          'Usar ESQUERDA, DIREITA, EXT.TEXTO e NÚM.CARACT',
          'Encontrar posições com LOCALIZAR e PROCURAR para extrair partes de tamanho variável',
          'Separar textos por delimitador com TEXTOANTES, TEXTODEPOIS e DIVIDIRTEXTO'
        ],
        body: 'Códigos de produto com a categoria nos primeiros caracteres, CPFs de onde se quer só os dígitos finais, e-mails dos quais se quer o domínio: extrair pedaços de texto é tarefa diária. As funções ESQUERDA, DIREITA, EXT.TEXTO e NÚM.CARACT são cobradas nominalmente na prova Associate; as funções modernas desta aula resolvem os mesmos problemas com menos esforço.',
        content: [
          { h: 'As quatro básicas',
            items: [
              '<strong>ESQUERDA</strong> (LEFT) — os primeiros caracteres do texto. O número de caracteres é opcional; sem ele, devolve só o primeiro.',
              '<strong>DIREITA</strong> (RIGHT) — os últimos caracteres.',
              '<strong>EXT.TEXTO</strong> (MID) — um pedaço do meio: o texto, a posição inicial e quantos caracteres pegar.',
              '<strong>NÚM.CARACT</strong> (LEN) — o tamanho do texto, contando espaços, pontuação e números.',
              'O resultado dessas funções é sempre texto, mesmo quando só tem dígitos. Para usar como número, converta com VALOR (próxima aula) ou multiplique por 1.'
            ],
            code: 'Em A2: "BR-2026-0045"\n=ESQUERDA(A2;2)          → "BR"\n=DIREITA(A2;4)           → "0045"\n=EXT.TEXTO(A2;4;4)       → "2026"\n=NÚM.CARACT(A2)          → 12' },
          { h: 'Quando o tamanho varia: LOCALIZAR e PROCURAR',
            p: 'Nem todo texto tem posições fixas: "Maria Silva" e "Ana Paula Souza" têm o espaço em lugares diferentes. <strong>LOCALIZAR</strong> (SEARCH) e <strong>PROCURAR</strong> (FIND) devolvem a posição de um texto dentro de outro. A diferença: PROCURAR diferencia maiúsculas e minúsculas e não aceita curingas; LOCALIZAR não diferencia e aceita. Se não encontrar, as duas devolvem o erro de valor. Combinadas com ESQUERDA e EXT.TEXTO, extraem partes de tamanho variável.',
            code: 'Em A2: "maria.silva@empresa.com.br"\n=LOCALIZAR("@";A2)                          → 12\n=ESQUERDA(A2;LOCALIZAR("@";A2)-1)           → "maria.silva"\n=EXT.TEXTO(A2;LOCALIZAR("@";A2)+1;100)      → "empresa.com.br"' },
          { h: 'As funções modernas (Microsoft 365)',
            items: [
              '<strong>TEXTOANTES</strong> (TEXTBEFORE) — o texto antes de um delimitador. Um argumento opcional escolhe qual ocorrência (a segunda, a última usando número negativo).',
              '<strong>TEXTODEPOIS</strong> (TEXTAFTER) — o texto depois do delimitador.',
              '<strong>DIVIDIRTEXTO</strong> (TEXTSPLIT) — separa o texto em várias células pelo delimitador, espalhando o resultado para a direita (ou para baixo, com o delimitador de linha). É uma fórmula de matriz dinâmica (Módulo 09) — o equivalente em fórmula do Texto para Colunas, que se atualiza sozinho.'
            ],
            code: '=TEXTOANTES(A2;"@")           → "maria.silva"\n=TEXTODEPOIS(A2;"@")          → "empresa.com.br"\n=TEXTODEPOIS(A2;".";-1)       → "br"  (depois do último ponto)\n=DIVIDIRTEXTO(B2;" ")         → cada palavra numa coluna',
            img: { src: `${XL_IMG}/m08/dividirtexto.png`, alt: 'DIVIDIRTEXTO separando um nome e uma frase pelo espaço', caption: 'DIVIDIRTEXTO: uma fórmula, o resultado espalhado pelas colunas.', source: `${SUP}/excel/functions/textsplit-function` } },
          { h: 'Como isso cai na prova',
            items: [
              'A MO-200/MO-210 cobra "formatar e modificar texto usando DIREITA, ESQUERDA e EXT.TEXTO" e "usando NÚM.CARACT" — espere tarefas como "na coluna Estado, extraia as duas últimas letras do código".',
              'Confira se a tarefa quer o resultado como texto ou número (códigos com zeros à esquerda devem ficar como texto).',
              'Nomes em inglês: LEFT, RIGHT, MID, LEN, SEARCH, FIND.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Função ESQUERDA', u: `${SUP}/excel/functions/left-function` },
          { t: 'Microsoft Suporte — Função DIREITA', u: `${SUP}/excel/functions/right-function` },
          { t: 'Microsoft Suporte — Função EXT.TEXTO', u: `${SUP}/excel/functions/mid-function` },
          { t: 'Microsoft Suporte — Função NÚM.CARACT', u: `${SUP}/excel/functions/len-function` },
          { t: 'Microsoft Suporte — Função LOCALIZAR', u: `${SUP}/excel/functions/search-function` },
          { t: 'Microsoft Suporte — Função TEXTOANTES', u: `${SUP}/excel/functions/textbefore-function` },
          { t: 'Microsoft Suporte — Função TEXTODEPOIS', u: `${SUP}/excel/functions/textafter-function` },
          { t: 'Microsoft Suporte — Função DIVIDIRTEXTO', u: `${SUP}/excel/functions/textsplit-function` }
        ]
      },
      {
        id: 'xl-texto-limpar-juntar', title: 'Limpar, padronizar e juntar textos: MAIÚSCULA, ARRUMAR, CONCAT, UNIRTEXTO e TEXTO',
        desc: 'Padronizar maiúsculas, remover espaços, substituir trechos, juntar textos com e sem separador e converter entre número e texto com TEXTO e VALOR.',
        objetivos: [
          'Padronizar com MAIÚSCULA, MINÚSCULA, PRI.MAIÚSCULA e ARRUMAR',
          'Trocar trechos com SUBSTITUIR',
          'Juntar textos com o e comercial, CONCAT e UNIRTEXTO',
          'Formatar números dentro de textos com TEXTO e converter texto em número com VALOR'
        ],
        body: 'Base de clientes com "SÃO PAULO", "são paulo" e "  São Paulo " na mesma coluna não agrupa, não filtra e não bate no PROCX. Esta aula reúne as funções de limpeza e as de junção — MAIÚSCULA, MINÚSCULA, NÚM.CARACT, CONCAT e UNIRTEXTO estão na lista da prova Associate.',
        content: [
          { h: 'Maiúsculas e minúsculas',
            items: [
              '<strong>MAIÚSCULA</strong> (UPPER) — tudo em maiúsculas: "são paulo" vira "SÃO PAULO".',
              '<strong>MINÚSCULA</strong> (LOWER) — tudo em minúsculas; útil para padronizar e-mails.',
              '<strong>PRI.MAIÚSCULA</strong> (PROPER) — primeira letra de cada palavra em maiúscula: "maria DA silva" vira "Maria Da Silva" (note que preposições também sobem).'
            ] },
          { h: 'Espaços e substituições',
            items: [
              '<strong>ARRUMAR</strong> (TRIM) — remove espaços do início e do fim e reduz espaços repetidos entre palavras a um só. Não remove o espaço "incondicional" (código 160) que vem de páginas da Web — para ele, combine com SUBSTITUIR trocando o CARACT(160) por espaço comum.',
              '<strong>SUBSTITUIR</strong> (SUBSTITUTE) — troca um trecho por outro: o texto, o texto antigo, o novo e, opcionalmente, qual ocorrência trocar (sem ele, troca todas). Diferencia maiúsculas e minúsculas.',
              'Funções se aninham: primeiro limpa, depois padroniza.'
            ],
            code: '=ARRUMAR("   São   Paulo  ")               → "São Paulo"\n=SUBSTITUIR(A2;".";"")                     → tira todos os pontos de um CPF\n=SUBSTITUIR(A2;"-";"/";2)                  → troca só o segundo hífen\n=PRI.MAIÚSCULA(ARRUMAR(A2))                → limpa e padroniza nomes' },
          { h: 'Juntar textos',
            items: [
              '<strong>E comercial</strong> — o operador de junção: nome, um espaço entre aspas e sobrenome.',
              '<strong>CONCAT</strong> — junta vários textos ou intervalos inteiros, sem separador. Substitui a antiga CONCATENAR, que continua existindo por compatibilidade mas não aceita intervalos.',
              '<strong>UNIRTEXTO</strong> (TEXTJOIN) — junta com um <strong>delimitador</strong> entre cada item e com a opção de <strong>ignorar vazios</strong>: o delimitador, VERDADEIRO ou FALSO para ignorar células vazias, e os textos ou intervalos. É a forma de transformar uma coluna numa lista separada por vírgulas.'
            ],
            code: '=A2&" "&B2                             → "Maria Silva"\n=CONCAT(A2:C2)                         → junta as três células sem separador\n=UNIRTEXTO(", ";VERDADEIRO;A2:A10)     → "Norte, Sul, Leste" (pula os vazios)' },
          { h: 'Números dentro de textos: TEXTO',
            p: 'Juntar um número com texto perde a formatação: o valor 1250,5 aparece como "Total: 1250,5". A função <strong>TEXTO</strong> converte o número em texto já formatado, usando os mesmos códigos dos formatos personalizados (Módulo 03), entre aspas. Também serve para padronizar códigos com zeros à esquerda.',
            code: '="Total: "&TEXTO(B2;"R$ #.##0,00")      → "Total: R$ 1.250,50"\n="Vencimento: "&TEXTO(C2;"dd/mm/aaaa")\n=TEXTO(A2;"dddd")                        → "segunda-feira"\n=TEXTO(B4;"00000")                       → "00123"',
            img: { src: `${XL_IMG}/m08/texto-zeros.png`, alt: 'TEXTO devolvendo códigos com zeros à esquerda', caption: 'TEXTO com o código de cinco zeros recompõe os zeros à esquerda.', source: `${SUP}/excel/functions/text-function` } },
          { h: 'Texto que devia ser número: VALOR',
            p: '<strong>VALOR</strong> (VALUE) converte um texto que representa número ou data ("1.250,50", "27/09/2026") em número de verdade, que soma e classifica corretamente. Útil depois de ESQUERDA/DIREITA/EXT.TEXTO, que sempre devolvem texto. Um texto que não pareça número resulta em erro de valor.' },
          { h: 'Como isso cai na prova',
            items: [
              '"Na coluna Código, junte as iniciais do estado e o número do pedido separados por hífen" — e comercial ou CONCAT.',
              '"Crie uma lista dos produtos separados por ponto e vírgula, ignorando células vazias" — UNIRTEXTO com VERDADEIRO.',
              '"Converta os nomes para maiúsculas" — MAIÚSCULA numa coluna nova (a prova indica a célula de destino).',
              'Em inglês: UPPER, LOWER, PROPER, TRIM, SUBSTITUTE, CONCAT, TEXTJOIN, TEXT, VALUE.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Função MAIÚSCULA', u: `${SUP}/excel/functions/upper-function` },
          { t: 'Microsoft Suporte — Função MINÚSCULA', u: `${SUP}/excel/functions/lower-function` },
          { t: 'Microsoft Suporte — Função PRI.MAIÚSCULA', u: `${SUP}/excel/functions/proper-function` },
          { t: 'Microsoft Suporte — Função ARRUMAR', u: `${SUP}/excel/functions/trim-function` },
          { t: 'Microsoft Suporte — Função SUBSTITUIR', u: `${SUP}/excel/functions/substitute-function` },
          { t: 'Microsoft Suporte — Função CONCAT', u: `${SUP}/excel/functions/concat-function` },
          { t: 'Microsoft Suporte — Função UNIRTEXTO', u: `${SUP}/excel/functions/textjoin-function` },
          { t: 'Microsoft Suporte — Função TEXTO', u: `${SUP}/excel/functions/text-function` },
          { t: 'Microsoft Suporte — Função VALOR', u: `${SUP}/excel/functions/value-function` }
        ]
      },
      {
        id: 'xl-funcoes-data', title: 'Datas e horas: HOJE, AGORA, DATA, DIA.DA.SEMANA, FIMMÊS e DATADIF',
        desc: 'Datas que se atualizam sozinhas, montar e desmontar datas, descobrir o dia da semana, somar meses, achar o último dia do mês e calcular idades e prazos.',
        objetivos: [
          'Usar HOJE e AGORA sabendo que são voláteis, e inserir data e hora fixas pelo teclado',
          'Montar e desmontar datas com DATA, ANO, MÊS e DIA',
          'Calcular dia da semana, meses à frente, fim do mês e diferença entre datas'
        ],
        body: 'Como o Excel guarda datas como números (Módulo 03), dá para somar dias, subtrair datas e comparar prazos com fórmulas simples. As funções de data completam o quadro: vencimentos, idade, dias em atraso, primeiro e último dia do mês. AGORA, HOJE e DIA.DA.SEMANA estão na lista da prova Expert.',
        content: [
          { h: 'HOJE e AGORA',
            items: [
              '<strong>HOJE</strong> (TODAY) — a data atual, sem argumentos. <strong>AGORA</strong> (NOW) — data e hora atuais.',
              'São funções <strong>voláteis</strong>: recalculam sempre que a planilha recalcula (ao abrir, ao editar qualquer célula, ou com F9). Amanhã, a mesma célula mostra outra data.',
              'Para registrar uma data <strong>fixa</strong> (a data de um pedido), não use fórmula: <strong>Ctrl+;</strong> (Ctrl e ponto e vírgula) insere a data atual e <strong>Ctrl+Shift+:</strong> (dois-pontos) insere a hora atual, como valores.'
            ],
            code: '=HOJE()-B2                     → dias desde a data em B2\n=SE(C2<HOJE();"Vencido";"No prazo")' },
          { h: 'Montar e desmontar datas',
            items: [
              '<strong>DATA</strong> (DATE) — monta uma data a partir de ano, mês e dia. Ela "corrige" valores fora da faixa: mês 13 vira janeiro do ano seguinte; dia zero vira o último dia do mês anterior.',
              '<strong>ANO</strong>, <strong>MÊS</strong> e <strong>DIA</strong> (YEAR, MONTH, DAY) — extraem cada parte de uma data.',
              'Juntas, calculam aniversários e datas relativas: cinco anos depois da data de início, ou o primeiro dia do mês de uma data qualquer.'
            ],
            code: '=DATA(2026;9;27)\n=DATA(ANO(C2)+5;MÊS(C2);DIA(C2))      → mesma data, cinco anos depois\n=DATA(ANO(A2);MÊS(A2);1)              → primeiro dia do mês de A2\n=DATA(ESQUERDA(A2;4);EXT.TEXTO(A2;5;2);DIREITA(A2;2))  → "20260927" vira data',
            img: { src: `${XL_IMG}/m08/data-calcular.png`, alt: 'DATA com ANO, MÊS e DIA calculando o quinto aniversário', caption: 'DATA(ANO+5; MÊS; DIA): a mesma data cinco anos depois.', source: `${SUP}/excel/functions/date-function` } },
          { h: 'DIA.DA.SEMANA',
            p: '<strong>DIA.DA.SEMANA</strong> (WEEKDAY) devolve o dia da semana como número. O segundo argumento, o tipo de retorno, define a numeração: <strong>1</strong> (padrão) — domingo = 1 até sábado = 7; <strong>2</strong> — segunda = 1 até domingo = 7; <strong>3</strong> — segunda = 0 até domingo = 6. Com o tipo 2, "é fim de semana?" vira "o resultado é maior que 5". Para o nome do dia, use TEXTO com quatro letras d.',
            code: '=DIA.DA.SEMANA(A2;2)\n=SE(DIA.DA.SEMANA(A2;2)>5;"Fim de semana";"Dia útil")\n=TEXTO(A2;"dddd")' },
          { h: 'Somar meses e achar o fim do mês',
            items: [
              '<strong>DATAM</strong> (EDATE) — a data N meses antes ou depois, mantendo o dia (ajustando para o fim do mês quando o dia não existe: 31/01 mais um mês dá 28 ou 29/02). Ideal para vencimentos mensais.',
              '<strong>FIMMÊS</strong> (EOMONTH) — o último dia do mês, N meses antes ou depois. Com zero, o fim do mês da própria data; com menos um, somado a 1, o primeiro dia do mês.'
            ],
            code: '=DATAM(A2;3)          → três meses depois\n=FIMMÊS(A2;0)         → último dia do mês de A2\n=FIMMÊS(A2;-1)+1      → primeiro dia do mês de A2' },
          { h: 'Diferença entre datas: subtração e DATADIF',
            p: 'Dias corridos entre duas datas é só subtrair. Para anos ou meses completos (idade, tempo de casa), use <strong>DATADIF</strong> — uma função antiga, que não aparece na lista do Inserir Função nem no AutoCompletar, mas funciona. Unidades: "Y" anos completos, "M" meses completos, "D" dias, "YM" meses que sobram além dos anos, "YD" dias ignorando os anos. A própria Microsoft desaconselha a unidade "MD", que pode dar resultados errados. A data inicial precisa ser menor que a final, senão o resultado é erro.',
            code: '=DATADIF(B2;HOJE();"Y")                           → idade em anos\n=DATADIF(B2;HOJE();"Y")&" anos e "&DATADIF(B2;HOJE();"YM")&" meses"' },
          { h: 'Como isso cai na prova',
            items: [
              'A MO-211 pede "referenciar data e hora usando AGORA e HOJE" e "calcular datas usando DIA.DA.SEMANA e DIATRABALHO" (próxima aula).',
              'Se o resultado aparecer como número de cinco dígitos, é só aplicar formato de data à célula.',
              'Em inglês: TODAY, NOW, DATE, YEAR, MONTH, DAY, WEEKDAY, EDATE, EOMONTH, DATEDIF.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Função HOJE', u: `${SUP}/excel/functions/today-function` },
          { t: 'Microsoft Suporte — Função AGORA', u: `${SUP}/excel/functions/now-function` },
          { t: 'Microsoft Suporte — Função DATA', u: `${SUP}/excel/functions/date-function` },
          { t: 'Microsoft Suporte — Função DIA.DA.SEMANA', u: `${SUP}/excel/functions/weekday-function` },
          { t: 'Microsoft Suporte — Função DATAM', u: `${SUP}/excel/functions/edate-function` },
          { t: 'Microsoft Suporte — Função FIMMÊS', u: `${SUP}/excel/functions/eomonth-function` },
          { t: 'Microsoft Suporte — Função DATADIF', u: `${SUP}/excel/functions/datedif-function` }
        ]
      },
      {
        id: 'xl-dias-uteis', title: 'Dias úteis: DIATRABALHO e DIATRABALHOTOTAL',
        desc: 'Calcular prazos em dias úteis e contar dias úteis entre duas datas, descontando fins de semana e uma lista de feriados — e as versões .INTL para escalas diferentes.',
        objetivos: [
          'Calcular a data de entrega N dias úteis depois de uma data com DIATRABALHO',
          'Contar dias úteis entre duas datas com DIATRABALHOTOTAL',
          'Usar uma tabela de feriados e conhecer as versões .INTL'
        ],
        body: 'Prazo de entrega de "10 dias úteis", SLA de atendimento, dias trabalhados no mês para calcular vale-transporte: tudo isso precisa pular sábados, domingos e feriados. É o trabalho de DIATRABALHO e DIATRABALHOTOTAL — a primeira está na lista da prova Expert.',
        content: [
          { h: 'DIATRABALHO: a data depois de N dias úteis',
            p: '<strong>DIATRABALHO</strong> (WORKDAY) recebe a data inicial, o número de dias úteis (negativo para voltar no tempo) e, opcionalmente, uma lista de feriados. O resultado é o número da data — formate a célula como data.',
            code: 'DIATRABALHO(data_inicial; dias; [feriados])\n\n=DIATRABALHO(A2;10)                      → 10 dias úteis depois de A2\n=DIATRABALHO(A2;10;Feriados)             → pulando também os feriados\n=DIATRABALHO(A2;-5;Feriados)             → 5 dias úteis antes' },
          { h: 'DIATRABALHOTOTAL: quantos dias úteis entre duas datas',
            p: '<strong>DIATRABALHOTOTAL</strong> (NETWORKDAYS) conta os dias úteis entre a data inicial e a final, <strong>incluindo as duas</strong> se forem dias úteis, descontando fins de semana e feriados.',
            code: 'DIATRABALHOTOTAL(data_inicial; data_final; [feriados])\n\n=DIATRABALHOTOTAL(DATA(2026;9;1);DATA(2026;9;30);Feriados)\n=DIATRABALHOTOTAL(B2;HOJE())             → dias úteis em aberto' },
          { h: 'A tabela de feriados',
            items: [
              'Liste os feriados (nacionais, estaduais e municipais que valem para a empresa) numa coluna, como datas de verdade.',
              'Transforme em tabela do Excel ou dê um nome ao intervalo (Feriados) — assim todas as fórmulas apontam para a mesma lista e um feriado novo entra em todas de uma vez.',
              'Feriados móveis (Carnaval, Sexta-feira Santa, Corpus Christi) mudam de data todo ano; atualize a lista anualmente.'
            ] },
          { h: 'Escalas diferentes: as versões .INTL',
            p: 'Para quem trabalha de segunda a sábado, ou folga em outro dia, existem <strong>DIATRABALHO.INTL</strong> e <strong>DIATRABALHOTOTAL.INTL</strong>, com um argumento de fim de semana: um número (1 = sábado e domingo, 11 = só domingo, e assim por diante) ou um texto de sete dígitos de segunda a domingo, em que 1 é folga e 0 é dia trabalhado.',
            code: '=DIATRABALHO.INTL(A2;10;11;Feriados)           → só domingo é folga\n=DIATRABALHOTOTAL.INTL(A2;B2;"0000011";Feriados) → folga sábado e domingo' },
          { h: 'Como isso cai na prova',
            items: [
              '"Calcule a data de entrega 15 dias úteis após a data do pedido, desconsiderando os feriados da planilha Feriados" — DIATRABALHO com o intervalo de feriados (referência absoluta ou nome, para copiar a fórmula).',
              'Em inglês: WORKDAY, NETWORKDAYS, WORKDAY.INTL, NETWORKDAYS.INTL.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Função DIATRABALHO', u: `${SUP}/excel/functions/workday-function` },
          { t: 'Microsoft Suporte — Função DIATRABALHOTOTAL', u: `${SUP}/excel/functions/networkdays-function` }
        ]
      }
    ]
  },
  {
    id: 'xl-m09', title: 'Módulo 09 · Funções de procura e matrizes dinâmicas', kind: 'video',
    lessons: [
      {
        id: 'xl-procx', title: 'PROCX: a função de procura do Excel moderno',
        desc: 'Procurar um valor e trazer o dado correspondente de outra coluna, com mensagem para não encontrado, correspondência aproximada para faixas, busca de trás para frente e retorno de várias colunas.',
        objetivos: [
          'Escrever PROCX com os três argumentos obrigatórios',
          'Usar se_não_encontrada, modo de correspondência e modo de pesquisa',
          'Resolver faixas (tabela de comissão, alíquotas) e procuras em duas direções'
        ],
        body: 'Procurar é a operação mais comum em planilhas de trabalho: o preço do produto pelo código, o nome do cliente pelo CPF, a alíquota pela faixa de receita. PROCX (XLOOKUP) é a função moderna para isso — mais simples e mais segura que PROCV. Está na lista da prova Expert, ao lado de PROCV, PROCH, CORRESP e ÍNDICE.',
        content: [
          { h: 'Os três argumentos obrigatórios',
            p: 'PROCX pede: <strong>o que procurar</strong> (pesquisa_valor), <strong>onde procurar</strong> (a coluna com as chaves, pesquisa_matriz) e <strong>o que devolver</strong> (a coluna com a resposta, matriz_retorno). As duas matrizes precisam ter o mesmo tamanho. Por padrão a correspondência é <strong>exata</strong>; se não achar, devolve o erro de valor não disponível.',
            code: 'PROCX(pesquisa_valor; pesquisa_matriz; matriz_retorno; [se_não_encontrada]; [modo_correspondência]; [modo_pesquisa])\n\n=PROCX(F2;B2:B11;D2:D11)              → o prefixo do país digitado em F2',
            img: { src: `${XL_IMG}/m09/procx-basico.jpg`, alt: 'PROCX devolvendo o código de discagem do país', caption: 'PROCX: procura "Brasil" na coluna B e devolve o valor da mesma linha na coluna D.', source: `${SUP}/excel/functions/xlookup-function` } },
          { h: 'Por que PROCX é melhor que PROCV',
            items: [
              'A coluna de resposta pode estar à esquerda da coluna de procura.',
              'Não há "número da coluna" para contar — e inserir colunas no meio não quebra a fórmula.',
              'O padrão é correspondência exata (no PROCV, o padrão é aproximada, fonte de erros silenciosos).',
              'Tem mensagem própria para não encontrado, sem precisar de SEERRO.',
              'Pode devolver várias colunas de uma vez e procurar do fim para o começo.'
            ] },
          { h: 'Os argumentos opcionais',
            items: [
              '<strong>se_não_encontrada</strong> — o que mostrar quando não houver correspondência: um texto ("Não cadastrado"), zero ou texto vazio.',
              '<strong>modo_correspondência</strong> — <strong>0</strong> exata (padrão); <strong>-1</strong> exata ou o próximo <strong>menor</strong>; <strong>1</strong> exata ou o próximo <strong>maior</strong>; <strong>2</strong> curingas (asterisco, interrogação e til têm significado especial).',
              '<strong>modo_pesquisa</strong> — <strong>1</strong> do primeiro para o último (padrão); <strong>-1</strong> do último para o primeiro (para achar a ocorrência mais recente); 2 e -2 são pesquisas binárias, só para dados já classificados.'
            ] },
          { h: 'Faixas: correspondência aproximada',
            p: 'Tabelas de faixas (comissão por volume, alíquota por receita, frete por peso) não precisam de SEs aninhados. Na tabela oficial abaixo, cada alíquota tem sua receita máxima; o modo 1 procura a receita exata ou a próxima maior — 46.523 cai na faixa de até 84.200, alíquota de 24%. Com a tabela montada pelo "valor mínimo" de cada faixa, o modo seria -1 (exata ou próxima menor). Diferente do PROCV aproximado, a tabela não precisa estar classificada.',
            code: '=PROCX(E2;C2:C7;B2:B7;0;1)',
            img: { src: `${XL_IMG}/m09/procx-aproximado.jpg`, alt: 'PROCX com correspondência aproximada devolvendo alíquota', caption: 'Modo de correspondência 1: exata ou a próxima maior.', source: `${SUP}/excel/functions/xlookup-function` } },
          { h: 'Várias colunas, duas direções e última ocorrência',
            code: '=PROCX(H2;tbFunc[Matrícula];tbFunc[[Nome]:[Depto]])        → devolve Nome e Depto de uma vez (despeja 2 colunas)\n=PROCX(H2;tbPedidos[Cliente];tbPedidos[Data];"";0;-1)      → data do pedido MAIS RECENTE do cliente\n=PROCX(J2;B3:B20;PROCX(K2;C2:N2;C3:N20))                     → cruzamento: linha pelo produto, coluna pelo mês' },
          { h: 'Como isso cai na prova',
            items: [
              '"Na célula C5, retorne o preço do produto informado em B5 a partir da tabela Produtos" — PROCX com as colunas certas da tabela.',
              '"Exiba Não encontrado quando o código não existir" — quarto argumento.',
              'Em inglês a função se chama XLOOKUP, com os mesmos argumentos na mesma ordem.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Função PROCX', u: `${SUP}/excel/functions/xlookup-function` }
        ]
      },
      {
        id: 'xl-procv-proch', title: 'PROCV e PROCH: ler, corrigir e manter fórmulas antigas',
        desc: 'Como PROCV e PROCH funcionam, o argumento de correspondência que causa erros silenciosos, as limitações que levaram ao PROCX e como migrar.',
        objetivos: [
          'Escrever PROCV e PROCH com correspondência exata',
          'Reconhecer os erros típicos: FALSO esquecido, coluna errada, procura à esquerda',
          'Converter um PROCV em PROCX'
        ],
        body: 'Milhões de planilhas no mundo foram construídas com PROCV (VLOOKUP), e você vai encontrá-lo em quase todo arquivo que receber. A prova Expert cobra PROCV e PROCH nominalmente. Saber lê-los, corrigi-los e substituí-los é tão importante quanto usar o PROCX.',
        content: [
          { h: 'A sintaxe do PROCV',
            p: 'PROCV procura o valor na <strong>primeira coluna</strong> de uma tabela e devolve o dado da coluna de número indicado, na mesma linha. O quarto argumento define o tipo de correspondência: <strong>FALSO</strong> (ou 0) para exata; VERDADEIRO (ou 1), ou omitido, para aproximada.',
            code: 'PROCV(valor_procurado; matriz_tabela; núm_índice_coluna; [procurar_intervalo])\n\n=PROCV(B3;B2:E7;2;FALSO)       → procura B3 na coluna B e devolve a 2ª coluna (C)',
            img: { src: `${XL_IMG}/m09/procv-exemplo.png`, alt: 'Exemplo de PROCV com correspondência exata', caption: 'PROCV: a procura sempre na primeira coluna do intervalo; o número diz qual coluna devolver.', source: `${SUP}/excel/functions/vlookup-function` } },
          { h: 'Os erros clássicos',
            items: [
              '<strong>Esquecer o FALSO</strong> — sem o quarto argumento, PROCV faz correspondência aproximada e, se a coluna não estiver classificada, devolve um valor errado <strong>sem mostrar erro</strong>. Em procura por código, cliente ou produto, use sempre FALSO.',
              '<strong>Número de coluna fixo</strong> — inserir ou excluir uma coluna no meio da tabela muda a posição do dado, mas o número na fórmula continua o mesmo.',
              '<strong>Procurar à esquerda</strong> — PROCV não devolve colunas à esquerda da coluna de procura.',
              '<strong>Intervalo relativo</strong> — ao copiar a fórmula, a matriz_tabela desliza para baixo; use referência absoluta, nome ou tabela do Excel.',
              '<strong>Tipos diferentes</strong> — o código 123 como número não encontra "123" como texto (erro de valor não disponível mesmo com o dado "lá").'
            ] },
          { h: 'Quando o aproximado é o certo',
            p: 'PROCV com VERDADEIRO serve para faixas, desde que a primeira coluna tenha o <strong>limite inferior</strong> de cada faixa em <strong>ordem crescente</strong>: ele devolve a linha do maior valor menor ou igual ao procurado.',
            code: 'Tabela de comissão em G2:H5:  0 → 1%   |  10000 → 2%  |  50000 → 3%  |  100000 → 4%\n=PROCV(B2;$G$2:$H$5;2;VERDADEIRO)     → 37000 cai na faixa de 10000 → 2%' },
          { h: 'PROCH: a mesma ideia na horizontal',
            p: '<strong>PROCH</strong> (HLOOKUP) procura na <strong>primeira linha</strong> e devolve o valor da linha de número indicado, na mesma coluna. Serve para tabelas com os códigos no cabeçalho (meses nas colunas, por exemplo). As mesmas regras valem: FALSO para exata, limitações idênticas. PROCX substitui as duas, porque aceita matrizes horizontais ou verticais.',
            code: 'PROCH(valor_procurado; matriz_tabela; núm_índice_linha; [procurar_intervalo])\n\n=PROCH("Mar";B1:M4;3;FALSO)    → o valor da 3ª linha na coluna de março' },
          { h: 'Migrar para PROCX',
            code: 'Antes:  =PROCV(A2;Produtos!$A$2:$F$500;4;FALSO)\nDepois: =PROCX(A2;Produtos!$A$2:$A$500;Produtos!$D$2:$D$500;"Não cadastrado")' },
          { h: 'Como isso cai na prova',
            items: [
              'A prova Expert pode pedir explicitamente PROCV ou PROCH — use a função pedida, mesmo que PROCX fosse mais simples.',
              'Correspondência exata sempre que o enunciado falar em "o código", "o produto", "o funcionário".',
              'Em inglês: VLOOKUP e HLOOKUP, com os mesmos argumentos.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Função PROCV', u: `${SUP}/excel/functions/vlookup-function` },
          { t: 'Microsoft Suporte — Função PROCH', u: `${SUP}/excel/functions/hlookup-function` }
        ]
      },
      {
        id: 'xl-indice-corresp', title: 'ÍNDICE, CORRESP e CORRESPX',
        desc: 'Devolver o valor de uma posição com ÍNDICE, descobrir a posição de um valor com CORRESP e CORRESPX, e a combinação clássica que procura em qualquer direção.',
        objetivos: [
          'Usar ÍNDICE para pegar o valor de uma linha e coluna',
          'Usar CORRESP e CORRESPX com os tipos de correspondência',
          'Combinar ÍNDICE com CORRESP para procuras flexíveis e em duas dimensões'
        ],
        body: 'Antes do PROCX, a dupla ÍNDICE + CORRESP era a forma "profissional" de procurar: funciona em qualquer direção e não quebra com colunas inseridas. Ela continua importante — está na lista da prova Expert, aparece em muitos modelos financeiros e é a base de fórmulas de duas dimensões.',
        content: [
          { h: 'ÍNDICE: o valor de uma posição',
            p: '<strong>ÍNDICE</strong> (INDEX) recebe um intervalo, o número da linha e, opcionalmente, o número da coluna, e devolve o valor dessa posição <strong>dentro do intervalo</strong> (não da planilha).',
            code: 'ÍNDICE(matriz; núm_linha; [núm_coluna])\n\n=ÍNDICE(B2:D11;5;3)       → 5ª linha, 3ª coluna do intervalo B2:D11 (a célula D6)\n=ÍNDICE(D2:D11;5)         → 5º item da coluna' },
          { h: 'CORRESP: a posição de um valor',
            p: '<strong>CORRESP</strong> (MATCH) devolve a <strong>posição</strong> do valor dentro de uma linha ou coluna. O terceiro argumento, o tipo de correspondência: <strong>0</strong> exata (o que você quer quase sempre); <strong>1</strong> (padrão!) o maior valor menor ou igual, com dados em ordem crescente; <strong>-1</strong> o menor valor maior ou igual, com dados em ordem decrescente. Como no PROCV, esquecer o 0 é o erro clássico.',
            code: 'CORRESP(valor_procurado; matriz_procurada; [tipo_correspondência])\n\n=CORRESP("Brasil";B2:B11;0)     → 5 (Brasil é o 5º item)' },
          { h: 'A combinação: ÍNDICE com CORRESP',
            p: 'CORRESP descobre a linha; ÍNDICE busca o valor nessa linha, na coluna de resposta. Como as colunas de procura e de resposta são independentes, a resposta pode estar à esquerda, e inserir colunas não quebra a fórmula.',
            code: '=ÍNDICE(D2:D11;CORRESP(F2;B2:B11;0))                     → equivale ao PROCX(F2;B2:B11;D2:D11)\n=ÍNDICE(C3:N20;CORRESP(J2;B3:B20;0);CORRESP(K2;C2:N2;0))  → cruzamento produto × mês' },
          { h: 'CORRESPX',
            p: '<strong>CORRESPX</strong> (XMATCH) é a versão moderna do CORRESP, com os mesmos modos do PROCX: correspondência <strong>0 exata por padrão</strong>, -1 exata ou próxima menor, 1 exata ou próxima maior, 2 curingas; e modo de pesquisa 1 (do início), -1 (do fim) e binárias. Os dados não precisam estar classificados para as aproximadas.',
            code: 'CORRESPX(pesquisa_valor; pesquisa_matriz; [modo_correspondência]; [modo_pesquisa])\n\n=CORRESPX("Brasil";B2:B11)          → 5 (exata por padrão)' },
          { h: 'Qual usar',
            items: [
              'Procura simples, retorno de uma ou várias colunas: PROCX.',
              'Precisa da posição (para usar em ÍNDICE, DESLOC, validação): CORRESPX ou CORRESP.',
              'Arquivo que será aberto em versões antigas do Excel (2016 ou anterior): ÍNDICE + CORRESP ou PROCV, que existem em todas.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              '"Use ÍNDICE e CORRESP para retornar o salário do funcionário de H2" — as duas funções aninhadas, CORRESP com 0.',
              'Em inglês: INDEX, MATCH e XMATCH.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Função ÍNDICE', u: `${SUP}/excel/functions/index-function` },
          { t: 'Microsoft Suporte — Função CORRESP', u: `${SUP}/excel/functions/match-function` },
          { t: 'Microsoft Suporte — Função CORRESPX', u: `${SUP}/excel/functions/xmatch-function` }
        ]
      },
      {
        id: 'xl-matrizes-dinamicas', title: 'Matrizes dinâmicas: FILTRO, CLASSIFICAR, CLASSIFICARPOR e ÚNICO',
        desc: 'Fórmulas que despejam o resultado em várias células, o erro de despejo, a referência ao intervalo despejado e as funções que filtram, ordenam e deduplicam por fórmula.',
        objetivos: [
          'Entender o despejo, o erro #DESPEJAR! e a referência ao intervalo despejado',
          'Filtrar com FILTRO usando um ou vários critérios (E e OU)',
          'Ordenar com CLASSIFICAR e CLASSIFICARPOR e extrair valores únicos com ÚNICO'
        ],
        body: 'No Microsoft 365, uma única fórmula pode devolver uma tabela inteira: você escreve numa célula e o resultado "despeja" nas vizinhas. Com isso, filtrar, ordenar e tirar duplicatas viram fórmulas que se atualizam sozinhas quando a base muda — sem clicar em nada. FILTRO, CLASSIFICARPOR e as funções de matriz dinâmica fazem parte da prova Expert na versão Microsoft 365.',
        content: [
          { h: 'Despejo',
            items: [
              'A fórmula fica só na primeira célula; as demais mostram o resultado em cinza na barra de fórmulas. Uma borda azul marca o <strong>intervalo despejado</strong>.',
              'Se houver qualquer conteúdo no caminho, a fórmula mostra o erro <strong>#DESPEJAR!</strong> (SPILL) — limpe as células e o resultado aparece.',
              'Para referenciar o resultado inteiro, use a célula da fórmula seguida de uma <strong>cerquilha</strong>: o intervalo despejado de F2, qualquer que seja o tamanho, acompanhando quando ele cresce ou encolhe.',
              'Matrizes dinâmicas não funcionam dentro de tabelas do Excel (as tabelas não despejam); coloque a fórmula fora da tabela.',
              'Fórmulas antigas que agora despejariam aparecem com uma arroba na frente (interseção implícita), que força um único valor.'
            ],
            code: '=SOMA(F2#)             → soma todo o resultado despejado a partir de F2\n=CONT.VALORES(F2#)     → quantos itens o FILTRO devolveu' },
          { h: 'FILTRO',
            p: '<strong>FILTRO</strong> (FILTER) recebe o intervalo, uma condição (uma coluna comparada com um critério, que resulta em VERDADEIRO ou FALSO para cada linha) e, opcionalmente, o que mostrar se nada for encontrado. Sem esse terceiro argumento, um filtro vazio resulta em erro de cálculo (#CALC!). Para vários critérios, cada condição vai entre parênteses: <strong>multiplicar</strong> as condições é E; <strong>somar</strong> é OU.',
            code: 'FILTRO(matriz; incluir; [se_vazio])\n\n=FILTRO(A5:D20;C5:C20=H2;"Nada encontrado")\n=FILTRO(A5:D20;(C5:C20=H1)*(A5:A20=H2))         → produto E região\n=FILTRO(A5:D20;(C5:C20="Maçã")+(A5:A20="Leste")) → produto OU região\n=FILTRO(tbVendas;tbVendas[Valor]>5000)' },
          { h: 'CLASSIFICAR e CLASSIFICARPOR',
            items: [
              '<strong>CLASSIFICAR</strong> (SORT) — ordena um intervalo por uma de suas colunas: o intervalo, o índice da coluna (padrão 1), a ordem (1 crescente, -1 decrescente) e, opcionalmente, VERDADEIRO para ordenar por colunas.',
              '<strong>CLASSIFICARPOR</strong> (SORTBY) — ordena um intervalo por <strong>outros</strong> intervalos, em vários níveis: pares de intervalo de ordenação e ordem. O intervalo de ordenação não precisa aparecer no resultado.',
              'Aninhadas com FILTRO, dão relatórios prontos: os pedidos do Sul, do maior para o menor.'
            ],
            code: '=CLASSIFICAR(A2:C50;3;-1)                         → pela 3ª coluna, decrescente\n=CLASSIFICARPOR(A2:B20;C2:C20;1;D2:D20;-1)         → por região (C) crescente, depois idade (D) decrescente\n=CLASSIFICAR(FILTRO(A2:D200;B2:B200="Sul");4;-1)',
            img: { src: `${XL_IMG}/m09/classificarpor-dois-niveis.png`, alt: 'CLASSIFICARPOR ordenando por região e depois por idade', caption: 'CLASSIFICARPOR com dois níveis de ordenação.', source: `${SUP}/excel/functions/sortby-function` } },
          { h: 'ÚNICO',
            p: '<strong>ÚNICO</strong> (UNIQUE) devolve a lista sem repetições. Argumentos opcionais: comparar por colunas em vez de linhas e <strong>exatamente_uma_vez</strong> — com VERDADEIRO, devolve só os valores que aparecem uma única vez (útil para achar cadastros sem duplicata). Combinado com CLASSIFICAR, gera listas ordenadas para validação de dados ou quadros-resumo; com CONT.VALORES, conta itens distintos.',
            code: '=ÚNICO(B2:B500)\n=CLASSIFICAR(ÚNICO(B2:B500))\n=CONT.VALORES(ÚNICO(B2:B500))          → quantos clientes distintos\n=ÚNICO(B2:B500;;VERDADEIRO)            → quem aparece uma vez só',
            img: { src: `${XL_IMG}/m09/unico-classificar.jpg`, alt: 'ÚNICO dentro de CLASSIFICAR gerando lista ordenada de nomes', caption: 'CLASSIFICAR(ÚNICO(...)): lista sem repetições, em ordem.', source: `${SUP}/excel/functions/unique-function` } },
          { h: 'Juntando tudo',
            p: 'Um quadro-resumo dinâmico inteiro com duas fórmulas: a lista de vendedores com ÚNICO e, ao lado, a soma de cada um com SOMASES apontando para o intervalo despejado. Quando entra um vendedor novo na base, ele aparece no quadro sozinho.',
            code: 'F2: =CLASSIFICAR(ÚNICO(tbVendas[Vendedor]))\nG2: =SOMASES(tbVendas[Valor];tbVendas[Vendedor];F2#)',
            img: { src: `${XL_IMG}/m09/filtro-e-classificar.png`, alt: 'FILTRO e CLASSIFICAR combinados', caption: 'FILTRO e CLASSIFICAR juntos, com critério OU.', source: `${SUP}/excel/functions/filter-function` } },
          { h: 'Como isso cai na prova',
            items: [
              'A MO-211 (Microsoft 365) pede "resumir dados usando FILTRO e CLASSIFICARPOR"; ÚNICO, CLASSIFICAR e SEQUÊNCIA aparecem nos mesmos cenários.',
              'Confira se há espaço livre para o despejo antes de confirmar a fórmula.',
              'Em inglês: FILTER, SORT, SORTBY, UNIQUE; o erro é #SPILL!.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Função FILTRO', u: `${SUP}/excel/functions/filter-function` },
          { t: 'Microsoft Suporte — Função CLASSIFICAR', u: `${SUP}/excel/functions/sort-function` },
          { t: 'Microsoft Suporte — Função CLASSIFICARPOR', u: `${SUP}/excel/functions/sortby-function` },
          { t: 'Microsoft Suporte — Função ÚNICO', u: `${SUP}/excel/functions/unique-function` }
        ]
      },
      {
        id: 'xl-sequencia-aleatoria', title: 'SEQUÊNCIA e MATRIZALEATÓRIA',
        desc: 'Gerar sequências de números e datas com uma fórmula e preencher células com números aleatórios para testes e simulações.',
        objetivos: [
          'Criar sequências de números e datas com SEQUÊNCIA',
          'Gerar números aleatórios com MATRIZALEATÓRIA, inteiros ou decimais, dentro de uma faixa',
          'Congelar resultados aleatórios quando necessário'
        ],
        body: 'Duas funções de matriz dinâmica que preenchem células: SEQUÊNCIA gera listas numeradas (1 a 100, os dias do mês, os 12 meses do ano) e MATRIZALEATÓRIA gera números aleatórios, úteis para testar fórmulas e simular cenários. "Preencher células usando a função MATRIZALEATÓRIA" está na lista da prova Expert.',
        content: [
          { h: 'SEQUÊNCIA',
            p: '<strong>SEQUÊNCIA</strong> (SEQUENCE) recebe o número de linhas e, opcionalmente, de colunas, o valor inicial e o passo (padrão 1 para os dois). O resultado despeja; preenche linha por linha.',
            code: 'SEQUÊNCIA(linhas; [colunas]; [início]; [etapa])\n\n=SEQUÊNCIA(10)                    → 1 a 10 numa coluna\n=SEQUÊNCIA(4;5)                   → 1 a 20 em 4 linhas × 5 colunas\n=SEQUÊNCIA(5;1;100;-10)           → 100, 90, 80, 70, 60\n=SEQUÊNCIA(30;1;DATA(2026;9;1))   → os 30 dias de setembro (formate como data)\n=SEQUÊNCIA(1;12;1)                → 1 a 12 na horizontal (meses)',
            img: { src: `${XL_IMG}/m09/sequencia-4x5.png`, alt: 'SEQUÊNCIA gerando uma matriz de 4 linhas por 5 colunas', caption: 'SEQUÊNCIA(4;5): números de 1 a 20 preenchidos por linha.', source: `${SUP}/excel/functions/sequence-function` } },
          { h: 'MATRIZALEATÓRIA',
            p: '<strong>MATRIZALEATÓRIA</strong> (RANDARRAY) gera uma matriz de números aleatórios. Todos os argumentos são opcionais: linhas, colunas, mínimo, máximo e <strong>número_inteiro</strong> (VERDADEIRO para inteiros, FALSO — o padrão — para decimais). Sem argumentos, devolve um único decimal entre 0 e 1.',
            code: 'MATRIZALEATÓRIA([linhas]; [colunas]; [mín]; [máx]; [número_inteiro])\n\n=MATRIZALEATÓRIA(5;3)                       → 5 × 3 decimais entre 0 e 1\n=MATRIZALEATÓRIA(10;1;1;100;VERDADEIRO)     → 10 inteiros de 1 a 100\n=MATRIZALEATÓRIA(12;1;5000;20000)           → 12 valores de venda simulados' },
          { h: 'Volátil: os números mudam',
            items: [
              'MATRIZALEATÓRIA (como ALEATÓRIO e ALEATÓRIOENTRE) recalcula a cada alteração na planilha e a cada F9 — os números mudam o tempo todo.',
              'Para fixar os valores: selecione o resultado, copie e use Colar Especial > Valores (Módulo 02).',
              'Para sortear itens de uma lista sem repetição, combine: CLASSIFICARPOR da lista por uma MATRIZALEATÓRIA do mesmo tamanho embaralha a lista; os primeiros itens da lista embaralhada são o sorteio.'
            ],
            code: '=CLASSIFICARPOR(A2:A50;MATRIZALEATÓRIA(CONT.VALORES(A2:A50)))    → lista embaralhada' },
          { h: 'Como isso cai na prova',
            items: [
              '"Preencha A2:A21 com 20 números inteiros aleatórios entre 1 e 500" — uma fórmula em A2 com linhas 20, colunas 1, mínimo 1, máximo 500 e VERDADEIRO.',
              'Em inglês: SEQUENCE e RANDARRAY, com os mesmos argumentos.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Função SEQUÊNCIA', u: `${SUP}/excel/functions/sequence-function` },
          { t: 'Microsoft Suporte — Função MATRIZALEATÓRIA', u: `${SUP}/excel/functions/randarray-function` }
        ]
      }
    ]
  },
  {
    id: 'xl-m10', title: 'Módulo 10 · Formatação condicional e minigráficos', kind: 'video',
    lessons: [
      {
        id: 'xl-formatacao-condicional', title: 'Formatação condicional: as regras prontas',
        desc: 'Realçar células por valor, texto, data e duplicatas; primeiros e últimos, acima da média; barras de dados, escalas de cor e conjuntos de ícones; Análise Rápida e como limpar regras.',
        objetivos: [
          'Aplicar as regras de Realçar Regras das Células e de Primeiros/Últimos',
          'Usar barras de dados, escalas de cor e conjuntos de ícones',
          'Remover formatação condicional de células ou da planilha inteira'
        ],
        body: 'Formatação condicional pinta as células automaticamente de acordo com o valor: estoque abaixo do mínimo em vermelho, as dez maiores vendas em verde, uma barra proporcional ao faturamento de cada loja. Quando o valor muda, a cor muda junto. Aplicar e remover as regras prontas é habilidade da prova Associate.',
        content: [
          { h: 'Onde fica',
            p: 'Selecione as células e use Página Inicial > Estilos > <strong>Formatação Condicional</strong>. O menu tem cinco grupos de regras prontas, além de Nova Regra, Limpar Regras e Gerenciar Regras. Passar o mouse sobre uma opção já mostra a prévia na planilha.',
            img: { src: `${XL_IMG}/m10/exemplo-formatacao-condicional.png`, alt: 'Planilha com formatação condicional aplicada', caption: 'A cor acompanha o valor: se o número mudar, a formatação muda junto.', source: `${SUP}/excel/use-conditional-formatting-to-highlight-information-in-excel` } },
          { h: 'Realçar Regras das Células',
            items: [
              '<strong>É Maior do que</strong>, <strong>É Menor do que</strong>, <strong>Está Entre</strong>, <strong>É Igual a</strong> — compare com um valor digitado ou com uma célula (clique nela; a referência pode ser absoluta).',
              '<strong>Texto que Contém</strong> — pinta células com um trecho de texto ("Ltda", "Atrasado").',
              '<strong>Uma Data que Ocorre</strong> — Ontem, Hoje, Amanhã, Nos Últimos 7 Dias, Semana Passada, Este Mês, Próximo Mês... (se atualiza a cada dia).',
              '<strong>Valores Duplicados</strong> — Duplicados ou Exclusivos; ótimo para achar cadastros repetidos antes de usar Remover Duplicatas.',
              'Em cada caixa você escolhe um formato pronto (Preenchimento Vermelho Claro e Texto Vermelho Escuro...) ou Formato Personalizado.'
            ] },
          { h: 'Regras de Primeiros/Últimos',
            p: '<strong>10 Primeiros Itens</strong>, <strong>10% Primeiros</strong>, <strong>10 Últimos Itens</strong>, <strong>10% Últimos</strong> (o número 10 pode ser trocado), <strong>Acima da Média</strong> e <strong>Abaixo da Média</strong>. A regra se recalcula sozinha: se os dados mudarem, outras células passam a ser as dez maiores.' },
          { h: 'Barras de dados, escalas de cor e conjuntos de ícones',
            items: [
              '<strong>Barras de Dados</strong> — uma barra dentro da célula, proporcional ao valor, com preenchimento gradual ou sólido. Valores negativos ganham barra para o outro lado, em outra cor.',
              '<strong>Escalas de Cor</strong> — um gradiente de duas ou três cores (verde para os maiores, vermelho para os menores, por exemplo), como um mapa de calor.',
              '<strong>Conjuntos de Ícones</strong> — setas, sinais de trânsito, bandeiras, estrelas: cada ícone representa uma faixa de valores (por padrão, terços do intervalo para três ícones).'
            ],
            img: { src: `${XL_IMG}/m10/conjuntos-de-icones.jpg`, alt: 'O mesmo conjunto de dados com diferentes conjuntos de ícones', caption: 'Conjuntos de ícones: cada ícone marca uma faixa de valores.', source: `${SUP}/excel/use-conditional-formatting-to-highlight-information-in-excel` } },
          { h: 'Escala de duas cores',
            img: { src: `${XL_IMG}/m10/escala-duas-cores.jpg`, alt: 'Escala de duas cores aplicada a um intervalo', caption: 'Escala de duas cores: o tom indica a posição do valor entre o menor e o maior.', source: `${SUP}/excel/use-conditional-formatting-to-highlight-information-in-excel` } },
          { h: 'Barras de dados com valores negativos',
            img: { src: `${XL_IMG}/m10/barras-positivo-negativo.jpg`, alt: 'Barras de dados com valores positivos e negativos', caption: 'Barras de dados: positivos para um lado, negativos para o outro.', source: `${SUP}/excel/use-conditional-formatting-to-highlight-information-in-excel` } },
          { h: 'Análise Rápida (Ctrl+Q)',
            p: 'Ao selecionar um intervalo de dados, aparece no canto inferior direito o botão <strong>Análise Rápida</strong> (ou pressione Ctrl+Q). A guia Formatação oferece barras, escalas, ícones, Maior que e 10% Primeiros com prévia instantânea — é o caminho mais rápido para as regras mais comuns.',
            img: { src: `${XL_IMG}/m10/analise-rapida-formatacao.jpg`, alt: 'Guia Formatação da Análise Rápida', caption: 'Análise Rápida > Formatação.', source: `${SUP}/excel/use-conditional-formatting-to-highlight-information-in-excel` } },
          { h: 'Remover formatação condicional',
            items: [
              'Formatação Condicional > <strong>Limpar Regras</strong> > <strong>Limpar Regras das Células Selecionadas</strong> ou <strong>Limpar Regras da Planilha Inteira</strong> (também há opções para a tabela e a tabela dinâmica selecionadas).',
              'Limpar Formatos (Módulo 03) também remove, junto com toda a outra formatação.',
              'Para remover só uma regra entre várias, use o Gerenciador de Regras (próxima aula).'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              '"Aplique formatação condicional às células D2:D50 para exibir valores maiores que 1000 com Preenchimento Verde e Texto Verde Escuro" — Realçar Regras > É Maior do que, com o formato exato.',
              '"Remova a formatação condicional da planilha Vendas" — Limpar Regras da Planilha Inteira (com a planilha certa ativa).',
              'A MO-200/MO-210 cobra aplicar e remover regras internas; a MO-211 cobra regras personalizadas e com fórmula.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Usar formatação condicional para realçar informações', u: `${SUP}/excel/use-conditional-formatting-to-highlight-information-in-excel` },
          { t: 'Microsoft Suporte — Barras de dados, escalas de cor e conjuntos de ícones', u: `${SUP}/excel/use-data-bars-color-scales-and-icon-sets-to-highlight-data` }
        ]
      },
      {
        id: 'xl-formatacao-condicional-regras', title: 'Regras personalizadas, regras com fórmula e o Gerenciador de Regras',
        desc: 'Criar e editar regras na caixa Nova Regra, pintar a linha inteira com uma fórmula, controlar a ordem e o Parar se Verdadeiro no Gerenciador de Regras.',
        objetivos: [
          'Criar regras personalizadas e ajustar barras e ícones em Editar Regra',
          'Escrever regras com fórmula, incluindo a que pinta a linha inteira',
          'Gerenciar precedência, intervalo de aplicação e Parar se Verdadeiro'
        ],
        body: 'As regras prontas resolvem o básico; o resto — pintar a linha inteira do pedido atrasado, destacar clientes de uma região escolhida numa célula, faixas próprias para os ícones — sai da caixa Nova Regra, principalmente do tipo "usar uma fórmula". Criar regras personalizadas, regras com fórmula e gerenciá-las são três habilidades da prova Expert.',
        content: [
          { h: 'A caixa Nova Regra',
            p: 'Formatação Condicional > <strong>Nova Regra</strong> oferece seis tipos: Formatar todas as células com base em seus valores (escalas, barras, ícones com controle total); Formatar apenas células que contenham; Formatar apenas os primeiros ou últimos valores; Formatar apenas valores acima ou abaixo da média; Formatar apenas valores exclusivos ou duplicados; e <strong>Usar uma fórmula para determinar quais células devem ser formatadas</strong>.' },
          { h: 'Ajustar barras e ícones',
            items: [
              'Nas barras de dados e escalas, defina o que é o mínimo e o máximo: Menor/Maior Valor, Número, Porcentagem, Fórmula ou Percentil. Com Número, a barra de 100% fica fixa num valor-meta.',
              'Nos ícones, cada faixa tem um valor e um tipo (Número, Porcentagem, Fórmula, Percentil). Troque para Número para usar limites reais: seta verde para 100% da meta ou mais, amarela para 80% ou mais, vermelha para o resto.',
              '<strong>Ordem Inversa de Ícones</strong> e <strong>Mostrar Somente Ícone</strong> (ou Mostrar Somente Barra, nas barras) — o segundo esconde o número e deixa só o indicador.'
            ] },
          { h: 'Regras com fórmula',
            p: 'A fórmula deve resultar em VERDADEIRO ou FALSO, e é escrita <strong>para a primeira célula do intervalo selecionado</strong> (a célula ativa): o Excel a "copia" para as outras, ajustando as referências relativas. Por isso o tipo de referência é tudo:',
            items: [
              'Para pintar a <strong>linha inteira</strong> conforme uma coluna, selecione a tabela a partir da linha 2 e trave só a coluna: cifrão antes da letra da coluna de status, linha livre.',
              'Para comparar com uma célula de parâmetro (a meta, a região escolhida), trave a célula inteira.',
              'Qualquer função vale: HOJE para vencimentos, CONT.SE para duplicatas, E e OU para condições combinadas, MOD e LIN para linhas alternadas.'
            ],
            code: 'Seleção A2:F200, célula ativa A2:\n=$F2="Atrasado"                      → pinta a linha inteira dos pedidos atrasados\n=$C2=$J$1                            → linhas da região escolhida em J1\n=E($D2>=2000000;$E2>0)                → duas condições\n=$G2<HOJE()                          → vencidos\n=MOD(LIN();2)=0                      → linhas alternadas',
            img: { src: `${XL_IMG}/m10/linhas-alternadas.jpg`, alt: 'Linhas alternadas sombreadas com regra de fórmula', caption: 'Regra com fórmula: uma linha sim, outra não.', source: `${SUP}/excel/use-conditional-formatting-to-highlight-information-in-excel` } },
          { h: 'O Gerenciador de Regras',
            p: 'Formatação Condicional > <strong>Gerenciar Regras</strong> lista as regras, com a coluna Formato, o <strong>Aplica-se a</strong> e o <strong>Parar se Verdadeiro</strong>. Na lista <strong>Mostrar regras de formatação para</strong>, troque de Seleção Atual para Esta Planilha (ou outra planilha, tabela ou tabela dinâmica) para ver todas. Ali você cria (Nova Regra), edita, exclui, muda a ordem com as setas e ajusta o intervalo de cada regra no Aplica-se a.',
            img: { src: `${XL_IMG}/m10/gerenciador-de-regras.png`, alt: 'Gerenciador de Regras de Formatação Condicional', caption: 'O Gerenciador: regras na ordem de avaliação, intervalo e Parar se Verdadeiro.', source: `${SUP}/excel/use-conditional-formatting-to-highlight-information-in-excel` } },
          { h: 'Precedência e conflitos',
            items: [
              'As regras são avaliadas de cima para baixo. Se duas regras verdadeiras <strong>conflitarem</strong> (fonte vermelha x fonte verde), vale a de cima.',
              'Se <strong>não conflitarem</strong> (uma põe negrito, outra cor), as duas se aplicam.',
              '<strong>Parar se Verdadeiro</strong> — quando a regra marcada é verdadeira, as regras abaixo dela não são avaliadas para aquela célula — útil para impedir que uma barra ou um ícone apareça nas células que já receberam um destaque mais importante.',
              'Formatação condicional tem prioridade sobre a formatação manual quando as duas definem a mesma propriedade; a formatação manual não aparece no Gerenciador.',
              'Copiar e colar células (ou usar o Pincel) cria regras novas para o destino — é comum acumular regras repetidas; revise o Gerenciador de vez em quando.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              '"Crie uma regra que formate em vermelho as linhas cujo status seja Cancelado" — Nova Regra com fórmula, coluna travada.',
              '"Altere a regra existente para aplicar-se a B2:B100" — Gerenciar Regras > Aplica-se a.',
              '"Altere a ordem das regras para que a regra X seja avaliada primeiro" — setas do Gerenciador.',
              '"Configure os ícones para mostrar seta verde para valores maiores ou iguais a 500" — Editar Regra, tipo Número.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Usar formatação condicional para realçar informações', u: `${SUP}/excel/use-conditional-formatting-to-highlight-information-in-excel` }
        ]
      },
      {
        id: 'xl-minigraficos', title: 'Minigráficos: tendências dentro da célula',
        desc: 'Inserir minigráficos de Linha, Coluna e Ganhos/Perdas, destacar pontos, formatar, ajustar o eixo, agrupar e remover.',
        objetivos: [
          'Inserir minigráficos para uma ou várias linhas de dados',
          'Destacar ponto alto, baixo, negativos, primeiro e último, e formatar cores e estilo',
          'Ajustar eixos, tratar células vazias, agrupar, desagrupar e limpar'
        ],
        body: 'Um minigráfico é um gráfico do tamanho de uma célula, colocado ao lado dos números que ele representa. Numa tabela de vendas mensais por loja, uma coluna de minigráficos mostra de relance quem está crescendo e quem está caindo — sem ocupar espaço de um gráfico inteiro. "Inserir minigráficos" é habilidade da prova Associate.',
        content: [
          { h: 'Os três tipos',
            items: [
              '<strong>Linha</strong> — a tendência ao longo do tempo.',
              '<strong>Coluna</strong> — compara a altura de cada período.',
              '<strong>Ganhos/Perdas</strong> — só indica positivo (para cima) ou negativo (para baixo), sem proporção: bom para meses acima ou abaixo da meta.'
            ] },
          { h: 'Inserir',
            items: [
              'Selecione a célula (ou a coluna de células) onde os minigráficos vão ficar e use <strong>Inserir > Minigráficos</strong> > Linha, Coluna ou Ganhos/Perdas.',
              'Na caixa Criar Minigráficos, informe o <strong>Intervalo de dados</strong> (os valores) e confira o <strong>Intervalo de locais</strong> (onde desenhar). Selecionando várias linhas de dados e várias células de local de uma vez, o Excel cria um minigráfico por linha, já agrupados.',
              'Também dá para criar um e arrastar a alça de preenchimento para as linhas de baixo.',
              'Os minigráficos ficam no fundo da célula: dá para digitar texto por cima, e aumentar a linha ou a coluna aumenta o gráfico.'
            ] },
          { h: 'A guia Minigráfico',
            p: 'Com um minigráfico selecionado, a guia <strong>Minigráfico</strong> oferece:',
            items: [
              '<strong>Editar Dados</strong> — mudar os intervalos do grupo ou de um minigráfico só; e <strong>Células Ocultas e Vazias</strong> — mostrar vazios como lacunas, zero ou ligar os pontos com linha, e se dados em linhas ou colunas ocultas entram.',
              '<strong>Tipo</strong> — trocar entre Linha, Coluna e Ganhos/Perdas.',
              '<strong>Mostrar</strong> — Ponto Alto, Ponto Baixo, Pontos Negativos, Primeiro Ponto, Último Ponto e Marcadores (todos os pontos, só no tipo Linha).',
              '<strong>Estilo</strong>, <strong>Cor do Minigráfico</strong> (e espessura da linha) e <strong>Cor do Marcador</strong> para cada tipo de ponto.',
              '<strong>Eixo</strong> — por padrão, cada minigráfico usa o próprio mínimo e máximo, o que faz uma loja pequena parecer tão grande quanto uma grande. Escolha <strong>Mesmo para Todos os Minigráficos</strong> nos valores mínimo e máximo do eixo vertical para compará-los de verdade; Mostrar Eixo desenha a linha do zero quando há negativos.',
              '<strong>Agrupar</strong> e <strong>Desagrupar</strong> — minigráficos agrupados compartilham formatação; desagrupe para formatar um diferente.',
              '<strong>Limpar</strong> — remove os minigráficos selecionados ou o grupo (a tecla Delete não os apaga).'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              '"Insira minigráficos de linha em N2:N10 que mostrem os dados de B2:M10" — Inserir > Minigráficos > Linha, com os dois intervalos.',
              '"Exiba o ponto alto dos minigráficos" / "altere para colunas" — guia Minigráfico.',
              '"Remova os minigráficos" — Limpar, não Delete.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Usar minigráficos para mostrar tendências', u: `${SUP}/excel/get-started/use-sparklines-to-show-data-trends` }
        ]
      }
    ]
  },
  {
    id: 'xl-m11', title: 'Módulo 11 · Gráficos', kind: 'video',
    lessons: [
      {
        id: 'xl-graficos-criar', title: 'Criar gráficos e escolher o tipo certo',
        desc: 'Os principais tipos de gráfico e quando usar cada um, Gráficos Recomendados, criação rápida com Alt+F1 e F11, planilhas de gráfico e como mover e redimensionar.',
        objetivos: [
          'Escolher o tipo de gráfico adequado à pergunta que ele deve responder',
          'Criar gráficos por Gráficos Recomendados, pela galeria e por atalho',
          'Criar planilhas de gráfico e mover gráficos entre planilhas'
        ],
        body: 'Um gráfico bom responde a uma pergunta em três segundos: qual loja vendeu mais, como a receita evoluiu no ano, quanto cada categoria pesa no total. A escolha do tipo é metade do trabalho. A seção de gráficos vale de 20 a 25% da prova Associate — a mesma importância das fórmulas.',
        content: [
          { h: 'Qual tipo para qual pergunta',
            items: [
              '<strong>Colunas</strong> — comparar valores entre categorias (vendas por loja) ou poucos períodos. Colunas empilhadas mostram a composição de cada total.',
              '<strong>Barras</strong> — o mesmo que colunas, na horizontal; melhor quando os nomes das categorias são longos ou há muitas categorias (um ranking).',
              '<strong>Linhas</strong> — evolução ao longo do tempo, principalmente com muitos pontos (12 meses, 52 semanas).',
              '<strong>Pizza e Rosca</strong> — partes de um todo, com poucas fatias (até cinco ou seis); a soma precisa ser 100% de algo que faça sentido.',
              '<strong>Dispersão (XY)</strong> — relação entre duas variáveis numéricas (investimento em anúncio × vendas).',
              '<strong>Área</strong> — evolução com ênfase no volume acumulado.',
              'Tipos especiais — combinação, histograma, caixa estreita, cascata, funil, explosão solar, mapa — na aula de gráficos avançados.'
            ] },
          { h: 'Criar um gráfico',
            items: [
              'Selecione os dados, incluindo os títulos das colunas e os rótulos das linhas (sem totais, que distorcem a escala).',
              '<strong>Inserir > Gráficos Recomendados</strong> mostra sugestões com prévia; a guia <strong>Todos os Gráficos</strong> tem todos os tipos e subtipos.',
              'Ou escolha direto nos botões do grupo Gráficos da guia Inserir (Colunas, Linhas, Pizza, Barras...).',
              '<strong>Alt+F1</strong> cria na hora um gráfico do tipo padrão (colunas agrupadas) na própria planilha.',
              '<strong>F11</strong> cria o gráfico padrão numa <strong>planilha de gráfico</strong> nova.',
              'A Análise Rápida (Ctrl+Q) também tem uma guia Gráficos.'
            ] },
          { h: 'Gráfico incorporado x planilha de gráfico',
            p: 'Um gráfico <strong>incorporado</strong> flutua sobre as células de uma planilha comum. Uma <strong>planilha de gráfico</strong> é uma guia que contém só o gráfico, ocupando a janela inteira — boa para apresentar. Para converter, use Design do Gráfico > Local > <strong>Mover Gráfico</strong>: escolha <strong>Nova planilha</strong> (e dê um nome) ou <strong>Objeto em</strong> outra planilha existente. É o mesmo comando para levar um gráfico de uma planilha para outra.' },
          { h: 'Mover e redimensionar',
            items: [
              'Arraste pela borda (área do gráfico) para mover; arraste as alças dos cantos para redimensionar.',
              'Segure Alt ao arrastar para alinhar com as bordas das células; Shift mantém a proporção ao redimensionar.',
              'Para medidas exatas, use Formatar > Tamanho (altura e largura).',
              'Em Formatar Área do Gráfico > Propriedades, escolha se o gráfico se move e se redimensiona com as células (importa ao inserir linhas ou filtrar).'
            ] },
          { h: 'Os elementos de um gráfico',
            p: 'O vocabulário que as tarefas da prova usam: 1 título do gráfico, 2 área de plotagem, 3 legenda, 4 títulos dos eixos, 5 rótulos do eixo, 6 marcas de escala, 7 linhas de grade. Todos aparecem, somem e são formatados pelo botão de mais (Elementos do Gráfico) ao lado do gráfico ou por Design do Gráfico > Adicionar Elemento de Gráfico (aula 3).',
            img: { src: `${XL_IMG}/m11/elementos-do-grafico.gif`, alt: 'Gráfico de colunas com os elementos numerados', caption: '1 título, 2 área de plotagem, 3 legenda, 4 títulos dos eixos, 5 rótulos do eixo, 6 marcas de escala, 7 linhas de grade.', source: `${SUP}/excel/get-started/create-a-chart-from-start-to-finish` } },
          { h: 'Como isso cai na prova',
            items: [
              '"Crie um gráfico de colunas agrupadas com os dados de A3:D9" — Inserir > Colunas > Colunas Agrupadas; confira se o gráfico pegou títulos e rótulos.',
              '"Mova o gráfico para uma nova planilha chamada Resumo" — Mover Gráfico > Nova planilha.',
              '"Crie uma planilha de gráfico" — F11 ou Mover Gráfico.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Criar um gráfico do início ao fim', u: `${SUP}/excel/get-started/create-a-chart-from-start-to-finish` },
          { t: 'Microsoft Suporte — Tipos de gráficos disponíveis', u: `${SUP}/excel/available-chart-types-in-office` },
          { t: 'Microsoft Suporte — Mover ou redimensionar um gráfico', u: `${SUP}/excel/move-or-resize-a-chart` }
        ]
      },
      {
        id: 'xl-graficos-dados', title: 'Os dados do gráfico: séries, Selecionar Dados e Alternar Linha/Coluna',
        desc: 'Adicionar, editar e remover séries, mudar os rótulos do eixo, alternar linhas e colunas, trocar o tipo do gráfico e tratar células ocultas e vazias.',
        objetivos: [
          'Adicionar e remover séries de dados',
          'Usar a caixa Selecionar Fonte de Dados e o Alternar Linha/Coluna',
          'Alterar o tipo de gráfico e controlar células ocultas e vazias'
        ],
        body: 'Depois de criado, o gráfico continua ligado às células: mudou o número, mudou o gráfico. Mas incluir o mês novo, tirar uma série, trocar o que vai no eixo e o que vai na legenda exige saber como o Excel organiza os dados de um gráfico. "Adicionar séries de dados" e "alternar entre linhas e colunas" estão na prova Associate.',
        content: [
          { h: 'Séries e categorias',
            p: 'Um gráfico tem <strong>séries</strong> (cada conjunto de valores com a mesma cor, listado na legenda — Violinos, Violoncelos, Tubas) e <strong>categorias</strong> (os rótulos do eixo horizontal — Jan, Fev, Mar). Ao selecionar o gráfico, o Excel contorna na planilha as áreas usadas: os nomes das séries, os rótulos das categorias e os valores plotados.',
            img: { src: `${XL_IMG}/m11/areas-dos-dados.png`, alt: 'Intervalo de dados com as áreas do gráfico destacadas', caption: 'Ao selecionar o gráfico, a planilha destaca rótulos das categorias, nomes das séries e valores; arraste as alças para incluir mais dados.', source: `${SUP}/excel/get-started/update-the-data-in-an-existing-chart` } },
          { h: 'Incluir e excluir dados',
            items: [
              '<strong>Arrastando</strong> — com o gráfico selecionado, arraste a alça do canto dos intervalos destacados na planilha para incluir linhas ou colunas novas.',
              '<strong>Copiando e colando</strong> — copie o intervalo da nova série (com o título) e cole sobre o gráfico: vira uma série nova.',
              '<strong>Tabela do Excel como origem</strong> — linhas novas na tabela entram no gráfico automaticamente.',
              '<strong>Filtros do gráfico</strong> — o botão de funil ao lado do gráfico esconde séries ou categorias sem excluí-las dos dados.'
            ] },
          { h: 'A caixa Selecionar Fonte de Dados',
            p: 'Design do Gráfico > <strong>Selecionar Dados</strong> (ou botão direito no gráfico) abre a caixa com o controle total:',
            items: [
              '<strong>Intervalo de dados do gráfico</strong> — o intervalo inteiro, que pode ser redefinido de uma vez.',
              '<strong>Entradas de Legenda (Série)</strong> — Adicionar (informando o nome e os valores da série), Editar, Remover e as setas que mudam a ordem das séries.',
              '<strong>Rótulos do Eixo Horizontal (Categoria)</strong> — Editar para escolher outro intervalo de rótulos; as caixas de seleção ocultam categorias.',
              '<strong>Alternar Linha/Coluna</strong> — o mesmo botão da faixa de opções.',
              '<strong>Células Ocultas e Vazias</strong> — mostrar células vazias como lacunas, zero ou (em linhas) ligar os pontos; e se os dados de linhas e colunas ocultas aparecem no gráfico (por padrão, não aparecem — por isso um filtro na tabela muda o gráfico).'
            ] },
          { h: 'Alternar Linha/Coluna',
            p: 'O Excel decide sozinho o que vira série e o que vira categoria (em geral, o lado com mais itens vai para o eixo). Design do Gráfico > <strong>Alternar Linha/Coluna</strong> inverte: em vez de meses no eixo e instrumentos na legenda (vendas por mês), instrumentos no eixo e meses na legenda (vendas por instrumento). Escolha a versão que responde à pergunta do gráfico.' },
          { h: 'Alterar o tipo do gráfico',
            p: 'Design do Gráfico > <strong>Alterar Tipo de Gráfico</strong> troca o tipo mantendo dados e boa parte da formatação. Na categoria Combinação, cada série pode ter um tipo diferente (aula de gráficos avançados).' },
          { h: 'Como isso cai na prova',
            items: [
              '"Adicione a série Abril (E3:E9) ao gráfico" — Selecionar Dados > Adicionar, ou arraste a alça do intervalo.',
              '"Altere o gráfico para que os produtos apareçam no eixo horizontal" — Alternar Linha/Coluna.',
              '"Remova a série Total do gráfico" — Selecionar Dados > Remover (não apague os dados da planilha).'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Atualizar os dados de um gráfico existente', u: `${SUP}/excel/get-started/update-the-data-in-an-existing-chart` },
          { t: 'Microsoft Suporte — Alterar o tipo de gráfico de um gráfico existente', u: `${SUP}/excel/change-the-chart-type-of-an-existing-chart` }
        ]
      },
      {
        id: 'xl-graficos-elementos', title: 'Elementos, layouts, estilos e texto alternativo',
        desc: 'Adicionar e formatar título, eixos, legenda, rótulos de dados, linhas de grade e linha de tendência; Layout Rápido, estilos e cores; o painel Formatar; texto alternativo para acessibilidade.',
        objetivos: [
          'Adicionar, remover e posicionar elementos do gráfico',
          'Aplicar layouts rápidos, estilos e cores, e formatar eixos e séries no painel Formatar',
          'Adicionar texto alternativo a gráficos'
        ],
        body: 'Um gráfico recém-criado quase sempre precisa de ajustes: título que diga a conclusão, rótulos nos valores importantes, eixo começando no lugar certo, legenda onde não atrapalhe. A prova Associate cobra "adicionar e modificar elementos do gráfico", "aplicar layouts e estilos" e "adicionar texto alternativo para acessibilidade".',
        content: [
          { h: 'Adicionar e remover elementos',
            p: 'Com o gráfico selecionado, use o botão <strong>Elementos do Gráfico</strong> (o sinal de mais ao lado do gráfico) ou Design do Gráfico > <strong>Adicionar Elemento de Gráfico</strong>. Cada elemento tem suas posições:',
            items: [
              '<strong>Título do Gráfico</strong> — Acima do Gráfico ou Sobreposição Centralizada; clique no título para editar ou, na barra de fórmulas, digite o sinal de igual e clique numa célula para o título acompanhar o conteúdo dela.',
              '<strong>Títulos dos Eixos</strong> — horizontal e vertical (primário e secundário).',
              '<strong>Legenda</strong> — à direita, acima, à esquerda, abaixo ou nenhuma.',
              '<strong>Rótulos de Dados</strong> — o valor sobre cada coluna ou ponto; em Mais Opções, mostrar o nome da categoria, a porcentagem (pizza) ou um valor de células.',
              '<strong>Tabela de Dados</strong> — os números embaixo do gráfico; <strong>Linhas de Grade</strong>; <strong>Barras de Erros</strong>.',
              '<strong>Linha de Tendência</strong> — Linear, Exponencial, Previsão Linear, Média Móvel; nas opções, prever períodos à frente e exibir a equação e o R².',
              'Para remover um elemento, selecione-o no gráfico e pressione Delete.'
            ] },
          { h: 'Layout Rápido, estilos e cores',
            items: [
              'Design do Gráfico > <strong>Layout Rápido</strong> — combinações prontas de elementos (Layout 1 a 11, conforme o tipo).',
              '<strong>Estilos de Gráfico</strong> — a galeria da guia Design do Gráfico (ou o pincel ao lado do gráfico) muda cores, fundos e efeitos de uma vez.',
              '<strong>Alterar Cores</strong> — paletas coloridas ou monocromáticas, baseadas no tema da pasta (Módulo 03).'
            ] },
          { h: 'O painel Formatar',
            p: 'Duplo clique (ou Ctrl+1) em qualquer elemento abre o painel <strong>Formatar</strong> daquele elemento. Os mais usados:',
            items: [
              '<strong>Formatar Eixo</strong> — limites Mínimo e Máximo, Unidades principais, formato de número do eixo, Unidades de exibição (Milhares, Milhões), escala logarítmica, categorias em ordem inversa (útil em gráficos de barras de ranking).',
              '<strong>Formatar Série de Dados</strong> — Largura do Espaçamento entre colunas, Sobreposição de Séries, eixo principal ou secundário, cores e marcadores.',
              '<strong>Formatar Ponto de Dados</strong> — clique duas vezes, com uma pausa, numa coluna para selecionar só ela e destacar com outra cor.',
              'A guia <strong>Formatar</strong> tem Estilos de Forma, Preenchimento, Contorno, Efeitos e WordArt para qualquer elemento selecionado.'
            ] },
          { h: 'Texto alternativo',
            p: 'Leitores de tela não enxergam o gráfico; o texto alternativo diz a quem não vê o que ele mostra. Clique com o botão direito na borda do gráfico (na área do gráfico, não num elemento) e escolha <strong>Exibir Texto Alternativo</strong> (ou Formatar > Texto Alt). No painel, escreva uma ou duas frases com a conclusão e os números principais ("Vendas cresceram de R$ 120 mil em janeiro para R$ 180 mil em junho; junho foi o melhor mês"). Objetos puramente decorativos podem ser marcados como <strong>Decorativo</strong>. O Verificador de Acessibilidade (Revisão > Verificar Acessibilidade) aponta gráficos e imagens sem texto alternativo.' },
          { h: 'Como isso cai na prova',
            items: [
              '"Adicione rótulos de dados na extremidade externa" — Adicionar Elemento > Rótulos de Dados > Extremidade Externa.',
              '"Aplique o Layout 5 e o Estilo 8" — Layout Rápido e Estilos de Gráfico, pelos nomes que aparecem ao passar o mouse.',
              '"Adicione o texto alternativo Vendas por região ao gráfico" — Exibir Texto Alternativo, com o texto exato do enunciado.',
              '"Altere o título do gráfico para ..." — edite o título, sem criar uma caixa de texto por cima.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Alterar o layout ou o estilo de um gráfico', u: `${SUP}/powerpoint/change-the-layout-or-style-of-a-chart` },
          { t: 'Microsoft Suporte — Formatar elementos de um gráfico', u: `${SUP}/office/format-elements-of-a-chart` },
          { t: 'Microsoft Suporte — Adicionar uma legenda a um gráfico', u: `${SUP}/excel/add-a-legend-to-a-chart` },
          { t: 'Microsoft Suporte — Adicionar texto alternativo a uma forma, imagem ou gráfico', u: `${SUP}/accessibility/office-accessibility/add-alternative-text-to-a-shape-picture-chart-smartart-graphic-or-other-object` }
        ]
      },
      {
        id: 'xl-graficos-avancados', title: 'Gráficos avançados: combinação, eixo duplo, histograma, caixa estreita, cascata, funil, explosão solar e mapa',
        desc: 'Os gráficos da prova Expert: quando usar cada um, como criar e as opções que fazem diferença.',
        objetivos: [
          'Criar gráficos de combinação com eixo secundário',
          'Criar e configurar histograma, caixa estreita, cascata, funil, explosão solar e mapa',
          'Escolher o gráfico avançado adequado a cada análise'
        ],
        body: 'A prova Expert cobra um conjunto de gráficos especializados: eixo duplo, combinação, caixa estreita, funil, histograma, explosão solar, cascata e mapa. Cada um responde a um tipo de pergunta que os gráficos comuns respondem mal — distribuição, composição hierárquica, ponte entre dois totais, etapas de um processo, geografia.',
        content: [
          { h: 'Combinação e eixo secundário',
            p: 'Quando as séries têm escalas muito diferentes (vendas em milhares e preço médio em reais) ou naturezas diferentes (valor e percentual), a série menor fica achatada. A solução é o <strong>gráfico de combinação</strong> com <strong>eixo secundário</strong>: Design do Gráfico > Alterar Tipo de Gráfico > <strong>Combinação</strong> — para cada série, escolha o tipo (Colunas Agrupadas, Linha...) e marque <strong>Eixo Secundário</strong> para a série da outra escala. A escala secundária aparece à direita; dê títulos aos dois eixos para ninguém ler errado.',
            img: { src: `${XL_IMG}/m11/combinacao-eixo-secundario.jpg`, alt: 'Gráfico de combinação com vendas em colunas e preço médio em linha no eixo secundário', caption: 'Combinação: vendas em colunas (eixo principal, à esquerda) e preço médio em linha (eixo secundário, à direita).', source: `${SUP}/office/excelexp/add-or-remove-a-secondary-axis-in-a-chart-in-excel` } },
          { h: 'Histograma',
            p: 'Mostra a <strong>distribuição</strong> de uma variável: quantos pedidos ficaram entre 0 e 100 reais, entre 100 e 200, e assim por diante. Selecione uma coluna de números e use Inserir > Gráfico Estatístico > <strong>Histograma</strong>. Em Formatar Eixo (eixo horizontal), configure os <strong>compartimentos</strong>: Automático, Por categoria (texto), <strong>Largura do compartimento</strong>, <strong>Número de compartimentos</strong>, e os compartimentos de <strong>estouro</strong> (tudo acima de um valor) e <strong>estouro negativo</strong> (tudo abaixo). No mesmo menu fica o <strong>Pareto</strong>: colunas em ordem decrescente com a linha do percentual acumulado.',
            img: { src: `${XL_IMG}/m11/histograma-eixo.png`, alt: 'Painel Formatar Eixo com as opções de compartimento do histograma', caption: 'Formatar Eixo do histograma: largura, número e compartimentos de estouro.', source: `${SUP}/excel/create-a-histogram` } },
          { h: 'Caixa estreita (caixa e bigodes)',
            p: 'Mostra a distribuição em <strong>quartis</strong>: a caixa vai do primeiro ao terceiro quartil, a linha dentro dela é a mediana, o X é a média, os "bigodes" mostram a variação fora da caixa e pontos isolados são valores atípicos (exceções). Ótimo para comparar grupos (tempo de entrega por transportadora, notas por turma). Inserir > Gráfico Estatístico > <strong>Caixa e Caixa Estreita</strong>; em Formatar Série de Dados você mostra ou oculta pontos internos, pontos de exceção, marcadores de média e linha de média, e escolhe o cálculo do quartil (mediana inclusiva ou exclusiva).',
            img: { src: `${XL_IMG}/m11/caixa-estreita.png`, alt: 'Gráfico de caixa estreita comparando grupos', caption: 'Caixa estreita: quartis, mediana, média e exceções de cada grupo.', source: `${SUP}/excel/create-a-box-and-whisker-chart` } },
          { h: 'Cascata',
            p: 'A <strong>cascata</strong> (ou gráfico de ponte) mostra como um valor inicial chega a um final pelos aumentos e reduções intermediários: receita bruta, menos impostos, menos custos, mais outras receitas, igual a lucro. Inserir > <strong>Inserir Gráfico de Cascata, Funil, Ações, Superfície ou Radar</strong> > Cascata. Os totais e subtotais precisam "encostar" no eixo: clique duas vezes, com pausa, na coluna do total e marque <strong>Definir como total</strong> (também no menu de atalho). Mostrar linhas de conexão liga cada coluna à seguinte.',
            img: { src: `${XL_IMG}/m11/cascata.png`, alt: 'Gráfico de cascata com aumentos, reduções e totais', caption: 'Cascata: aumentos e reduções flutuam; totais partem do eixo.', source: `${SUP}/excel/create-a-waterfall-chart` } },
          { h: 'Funil',
            p: 'Mostra valores em <strong>etapas sucessivas</strong> de um processo que vai afunilando: visitantes, leads, propostas, vendas. Uma coluna com as etapas, outra com os valores, e Inserir > Cascata, Funil... > <strong>Funil</strong>. As barras ficam centralizadas e decrescentes.',
            img: { src: `${XL_IMG}/m11/funil.png`, alt: 'Gráfico de funil de um pipeline de vendas', caption: 'Funil: cada etapa do pipeline de vendas.', source: `${SUP}/excel/create-a-funnel-chart-based-on-excel-data` } },
          { h: 'Explosão solar',
            p: 'Para <strong>dados hierárquicos</strong> (categoria > subcategoria > produto; região > estado > cidade): cada nível é um anel, o mais interno é o topo da hierarquia, e o tamanho de cada fatia é proporcional ao valor. As colunas da planilha ficam em ordem de nível, da esquerda para a direita, com o valor na última. Inserir > <strong>Inserir Gráfico de Hierarquia</strong> > Explosão Solar. O mapa de árvore, no mesmo menu, compara tamanhos com retângulos.',
            img: { src: `${XL_IMG}/m11/explosao-solar.png`, alt: 'Gráfico de explosão solar com três níveis', caption: 'Explosão solar: cada anel é um nível da hierarquia.', source: `${SUP}/excel/create-a-sunburst-chart-in-office` } },
          { h: 'Mapa',
            p: 'O <strong>gráfico de mapa</strong> colore países, estados, municípios ou CEPs por valor (gradiente) ou categoria (cores diferentes). Uma coluna com os locais — escritos de forma inequívoca; inclua uma coluna de país ou estado se houver nomes repetidos — e outra com os valores; Inserir > <strong>Mapas</strong> > Mapa Preenchido. Os locais são reconhecidos pelo serviço online do Bing, então é preciso estar conectado.',
            img: { src: `${XL_IMG}/m11/mapa-valores.png`, alt: 'Gráfico de mapa colorindo países por valor', caption: 'Mapa preenchido: a cor de cada país acompanha o valor.', source: `${SUP}/excel/create-a-map-chart-in-excel` } },
          { h: 'Como isso cai na prova',
            items: [
              '"Altere o gráfico para que a série Margem seja uma linha no eixo secundário" — Alterar Tipo de Gráfico > Combinação.',
              '"Crie um histograma com largura de compartimento de 50" — Formatar Eixo.',
              '"Defina a coluna Lucro Líquido como total" — Definir como total no ponto de dados da cascata.',
              'Em inglês: Combo, Secondary Axis, Histogram, Box and Whisker, Waterfall, Funnel, Sunburst, Filled Map.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Adicionar ou remover um eixo secundário', u: `${SUP}/office/excelexp/add-or-remove-a-secondary-axis-in-a-chart-in-excel` },
          { t: 'Microsoft Suporte — Criar um histograma', u: `${SUP}/excel/create-a-histogram` },
          { t: 'Microsoft Suporte — Criar um gráfico de caixa estreita', u: `${SUP}/excel/create-a-box-and-whisker-chart` },
          { t: 'Microsoft Suporte — Criar um gráfico de cascata', u: `${SUP}/excel/create-a-waterfall-chart` },
          { t: 'Microsoft Suporte — Criar um gráfico de funil', u: `${SUP}/excel/create-a-funnel-chart-based-on-excel-data` },
          { t: 'Microsoft Suporte — Criar um gráfico de explosão solar', u: `${SUP}/excel/create-a-sunburst-chart-in-office` },
          { t: 'Microsoft Suporte — Criar um gráfico de mapa', u: `${SUP}/excel/create-a-map-chart-in-excel` }
        ]
      }
    ]
  },
  {
    id: 'xl-m12', title: 'Módulo 12 · Tabelas dinâmicas e gráficos dinâmicos', kind: 'video',
    lessons: [
      {
        id: 'xl-tabela-dinamica-criar', title: 'Criar uma tabela dinâmica e organizar os campos',
        desc: 'Preparar os dados, inserir a tabela dinâmica, o painel Campos da Tabela Dinâmica e suas quatro áreas, atualizar e alterar a fonte de dados.',
        objetivos: [
          'Preparar uma base e criar uma tabela dinâmica a partir de tabela ou intervalo',
          'Montar o relatório arrastando campos para Linhas, Colunas, Valores e Filtros',
          'Atualizar a tabela dinâmica e alterar a fonte de dados'
        ],
        body: 'Tabela dinâmica é a ferramenta que resume milhares de linhas em segundos: vendas por região e mês, quantidade por produto, ticket médio por vendedor — tudo arrastando campos, sem uma fórmula. É o recurso mais pedido em vagas que exigem Excel e uma parte grande da seção "gráficos e tabelas avançados" da prova Expert (25 a 30%).',
        content: [
          { h: 'Antes de criar: a base certa',
            items: [
              'Dados em formato de lista: <strong>uma linha de cabeçalho</strong>, um registro por linha, um tipo de dado por coluna.',
              'Sem linhas ou colunas totalmente vazias, sem células mescladas, sem subtotais no meio dos dados.',
              'Datas como datas e números como números (Módulos 03 e 04).',
              'Transforme a base em <strong>tabela do Excel</strong> (Módulo 05): as linhas novas passam a entrar na tabela dinâmica bastando atualizar, sem mudar a fonte.'
            ] },
          { h: 'Inserir a tabela dinâmica',
            items: [
              'Clique numa célula da base e use <strong>Inserir > Tabela Dinâmica</strong> (Da Tabela/Intervalo). Confira a tabela ou o intervalo sugerido.',
              'Escolha o local: <strong>Nova Planilha</strong> (o mais comum) ou <strong>Planilha Existente</strong>, indicando a célula.',
              '<strong>Adicionar estes dados ao Modelo de Dados</strong> — necessário para relacionar várias tabelas e para a opção Contagem Distinta.',
              'A seta do botão oferece outras fontes: dados externos, o Modelo de Dados da pasta e conjuntos de dados do Power BI.',
              '<strong>Tabelas Dinâmicas Recomendadas</strong> (Inserir) sugere resumos prontos, com prévia.'
            ],
            img: { src: `${XL_IMG}/m12/criar-tabela-dinamica.png`, alt: 'Caixa para criar tabela dinâmica a partir de tabela ou intervalo', caption: 'Inserir > Tabela Dinâmica: a origem e o local do relatório.', source: `${SUP}/excel/get-started/create-a-pivottable-to-analyze-worksheet-data` } },
          { h: 'O painel Campos da Tabela Dinâmica',
            p: 'À direita aparece o painel com a lista de campos (as colunas da base) e quatro áreas. Marcar a caixa de um campo coloca texto em <strong>Linhas</strong> e números em <strong>Valores</strong>; arrastar dá controle total:',
            items: [
              '<strong>Linhas</strong> — os itens que aparecem um embaixo do outro (regiões, vendedores).',
              '<strong>Colunas</strong> — os itens que viram colunas (meses, anos).',
              '<strong>Valores</strong> — o que é calculado (soma das vendas, contagem de pedidos).',
              '<strong>Filtros</strong> — um filtro acima do relatório que vale para a tabela inteira.',
              'Vários campos na mesma área criam níveis (Região e, dentro dela, Vendedor); a ordem na área define a hierarquia.',
              'Para remover, desmarque o campo ou arraste-o para fora do painel. Se o painel sumir, clique na tabela dinâmica ou use Análise de Tabela Dinâmica > Lista de Campos.'
            ],
            img: { src: `${XL_IMG}/m12/painel-campos.png`, alt: 'Painel Campos da Tabela Dinâmica com as quatro áreas', caption: 'O painel de campos e as áreas Filtros, Colunas, Linhas e Valores (imagem original em inglês).', source: `${SUP}/excel/get-started/use-the-field-list-to-arrange-fields-in-a-pivottable` } },
          { h: 'Atualizar e alterar a fonte',
            items: [
              'A tabela dinâmica <strong>não</strong> se atualiza sozinha quando a base muda. Clique com o botão direito nela > <strong>Atualizar</strong> (Alt+F5), ou Análise de Tabela Dinâmica > Atualizar > <strong>Atualizar Tudo</strong> (Ctrl+Alt+F5) para todas.',
              'Em Opções da Tabela Dinâmica > Dados, marque <strong>Atualizar dados ao abrir o arquivo</strong>.',
              'Se a base não for tabela do Excel e crescer, use Análise de Tabela Dinâmica > <strong>Alterar Fonte de Dados</strong> e informe o novo intervalo.',
              'Para mover ou excluir o relatório: Análise de Tabela Dinâmica > Ações > Mover Tabela Dinâmica, ou selecionar a tabela inteira (Selecionar > Tabela Dinâmica Inteira) e pressionar Delete.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              '"Crie uma tabela dinâmica na célula A3 de uma nova planilha que mostre o total de vendas por região e produto" — Nova Planilha; Região e Produto em Linhas; Vendas em Valores.',
              '"Atualize a tabela dinâmica para refletir os novos dados" — Atualizar; se a fonte não cresceu sozinha, Alterar Fonte de Dados.',
              'A MO-211 cobra "criar tabelas dinâmicas" e "modificar seleções de campos e opções".'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Criar uma Tabela Dinâmica', u: `${SUP}/excel/get-started/create-a-pivottable-to-analyze-worksheet-data` },
          { t: 'Microsoft Suporte — Usar a Lista de Campos', u: `${SUP}/excel/get-started/use-the-field-list-to-arrange-fields-in-a-pivottable` },
          { t: 'Microsoft Suporte — Atualizar dados da Tabela Dinâmica', u: `${SUP}/excel/refresh-pivottable-data` },
          { t: 'Microsoft Suporte — Alterar a fonte de dados de uma Tabela Dinâmica', u: `${SUP}/excel/change-the-source-data-for-a-pivottable` }
        ]
      },
      {
        id: 'xl-tabela-dinamica-valores', title: 'Valores: resumir, Mostrar Valores Como e campos calculados',
        desc: 'Trocar a função de resumo, formatar números, mostrar percentuais, diferenças e acumulados, criar campos calculados e ver os registros por trás de um número.',
        objetivos: [
          'Alterar a função de resumo e o formato nas Configurações do Campo de Valor',
          'Usar Mostrar Valores Como para percentuais, diferenças, acumulados e classificação',
          'Criar campos calculados e detalhar um valor'
        ],
        body: 'A soma é só o começo. A mesma tabela dinâmica mostra a média do pedido, a quantidade de pedidos, a participação de cada região no total, o crescimento sobre o mês anterior e o acumulado do ano — e ainda calcula campos que não existem na base, como margem. "Formatar dados" (as configurações do campo de valor) e "adicionar campos calculados" são habilidades da prova Expert.',
        content: [
          { h: 'Configurações do Campo de Valor',
            p: 'Clique com o botão direito num número da tabela dinâmica > <strong>Configurações do Campo de Valor</strong> (ou na seta do campo, na área Valores). A caixa tem:',
            items: [
              '<strong>Nome Personalizado</strong> — troque "Soma de Vendas" por "Vendas" (não pode ser idêntico ao nome do campo; um espaço no fim resolve).',
              '<strong>Resumir valores por</strong> — Soma (padrão para números), Contagem (padrão para texto), Média, Máx, Mín, Produto, Contar Números, DesvPad, Var... e <strong>Contagem Distinta</strong> quando os dados estão no Modelo de Dados.',
              '<strong>Mostrar Valores Como</strong> — a outra guia (abaixo).',
              '<strong>Formato do Número</strong> — o formato definido aqui fica no campo e sobrevive às atualizações (formatar as células diretamente pode se perder).'
            ],
            img: { src: `${XL_IMG}/m12/configuracoes-campo-valor.png`, alt: 'Caixa Configurações do Campo de Valor', caption: 'Configurações do Campo de Valor: nome, função de resumo e Formato do Número.', source: `${SUP}/excel/get-started/create-a-pivottable-to-analyze-worksheet-data` } },
          { h: 'Mostrar Valores Como',
            p: 'Botão direito no valor > <strong>Mostrar Valores Como</strong>. As opções mais úteis:',
            items: [
              '<strong>% do Total Geral</strong>, <strong>% do Total da Coluna</strong>, <strong>% do Total da Linha</strong> — participação de cada item.',
              '<strong>% do Total de Linhas Pai</strong> — a participação dentro do grupo (cada vendedor dentro da sua região).',
              '<strong>% de</strong> e <strong>Diferença de</strong> / <strong>% Diferença de</strong> — comparação com um item base: com o campo Mês e o item base (anterior), mostra o crescimento mês a mês.',
              '<strong>Total Acumulado em</strong> e <strong>% Total Acumulado em</strong> — o acumulado ao longo de um campo (acumulado do ano).',
              '<strong>Classificar do Menor para o Maior</strong> e <strong>do Maior para o Menor</strong> — a posição de cada item (ranking).',
              '<strong>Índice</strong> — a importância relativa de cada célula.'
            ],
            img: { src: `${XL_IMG}/m12/mostrar-valores-como.png`, alt: 'Menu Mostrar Valores Como', caption: 'Mostrar Valores Como: percentuais, diferenças, acumulados e classificação.', source: `${SUP}/excel/show-different-calculations-in-pivottable-value-fields` } },
          { h: 'O mesmo campo duas vezes',
            p: 'Arraste o mesmo campo para Valores duas vezes: um mostra o valor, o outro a porcentagem do total (ou o acumulado). Renomeie os dois para o cabeçalho ficar claro.',
            img: { src: `${XL_IMG}/m12/mesmo-campo-valor-e-percentual.png`, alt: 'Tabela dinâmica com o mesmo campo como valor e como porcentagem', caption: 'Um campo, duas visões: valor e porcentagem.', source: `${SUP}/excel/show-different-calculations-in-pivottable-value-fields` } },
          { h: 'Campos calculados',
            p: 'Análise de Tabela Dinâmica > Cálculos > <strong>Campos, Itens e Conjuntos</strong> > <strong>Campo Calculado</strong>. Dê um nome e escreva a fórmula usando os campos da lista (Inserir Campo). O campo novo aparece na lista e vai para Valores. Atenção: a fórmula opera sobre as <strong>somas</strong> dos campos, não linha a linha — margem como lucro dividido por receita funciona bem (a razão das somas é a margem certa), mas preço vezes quantidade dá errado (a soma dos preços vezes a soma das quantidades); para esses casos, crie a coluna na base e use o campo resultante. O <strong>Item Calculado</strong>, no mesmo menu, cria um item novo dentro de um campo (como "Sul + Sudeste").',
            code: 'Nome: Margem\nFórmula: =Lucro/Receita\n\nNome: Comissão\nFórmula: =Vendas*3%',
            img: { src: `${XL_IMG}/m12/campos-itens-conjuntos.jpg`, alt: 'Menu Campos, Itens e Conjuntos com a opção Campo Calculado', caption: 'Campos, Itens e Conjuntos > Campo Calculado.', source: `${SUP}/excel/calculate-values-in-a-pivottable` } },
          { h: 'Ver os registros por trás de um número',
            p: 'Dê duplo clique num valor da tabela dinâmica (ou botão direito > <strong>Mostrar Detalhes</strong>): o Excel cria uma planilha nova com todas as linhas da base que compõem aquele número. É o jeito de auditar um total estranho. A planilha criada é uma cópia — pode ser excluída depois.' },
          { h: 'Como isso cai na prova',
            items: [
              '"Altere o campo para mostrar a média em vez da soma e formate como moeda sem casas decimais" — Configurações do Campo de Valor.',
              '"Exiba as vendas como porcentagem do total da coluna" — Mostrar Valores Como.',
              '"Adicione um campo calculado chamado Bonus que calcule 5% das vendas" — Campo Calculado, com o nome exato.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Mostrar cálculos diferentes em campos de valor', u: `${SUP}/excel/show-different-calculations-in-pivottable-value-fields` },
          { t: 'Microsoft Suporte — Calcular valores em uma Tabela Dinâmica', u: `${SUP}/excel/calculate-values-in-a-pivottable` }
        ]
      },
      {
        id: 'xl-tabela-dinamica-organizar', title: 'Agrupar, filtrar, segmentar e formatar a tabela dinâmica',
        desc: 'Agrupar datas e números, filtros de rótulo, de valor e 10 primeiros, segmentações e linha do tempo, classificação, layouts de relatório, subtotais, totais e estilos.',
        objetivos: [
          'Agrupar datas por mês, trimestre e ano, e números por faixas',
          'Filtrar com filtros de rótulo e de valor, segmentação de dados e linha do tempo',
          'Escolher o layout do relatório e configurar subtotais, totais e estilos'
        ],
        body: 'Com os campos no lugar, o trabalho passa a ser de apresentação: vendas por trimestre em vez de por dia, só os dez maiores clientes, botões para o gerente filtrar sozinho, um layout que dê para copiar para outro lugar. Agrupar dados, criar segmentações e modificar opções da tabela dinâmica estão na lista da prova Expert.',
        content: [
          { h: 'Agrupar datas',
            p: 'Ao colocar um campo de data em Linhas ou Colunas, o Excel agrupa automaticamente em anos, trimestres e meses. Para mudar, clique com o botão direito numa data > <strong>Agrupar</strong> e escolha em <strong>Por</strong>: Segundos, Minutos, Horas, Dias, Meses, Trimestres, Anos (vários ao mesmo tempo), com Começar em e Terminar em. <strong>Desagrupar</strong> volta às datas individuais.',
            img: { src: `${XL_IMG}/m12/datas-agrupadas.jpg`, alt: 'Tabela dinâmica com datas agrupadas por meses e trimestres', caption: 'Datas agrupadas por trimestre e mês.', source: `${SUP}/excel/get-started/group-or-ungroup-data-in-a-pivottable` } },
          { h: 'Agrupar números e itens',
            items: [
              '<strong>Números</strong> — botão direito > Agrupar, com Começar em, Terminar em e Por (o tamanho da faixa): idades de 10 em 10, pedidos de 500 em 500 reais.',
              '<strong>Itens escolhidos</strong> — selecione itens com Ctrl, clique com o botão direito > Agrupar: nasce um grupo ("Grupo1") que você renomeia digitando na célula; o campo ganha uma versão agrupada ("Região2").'
            ] },
          { h: 'Filtrar',
            items: [
              '<strong>A seta de Rótulos de Linha</strong> — marcar e desmarcar itens, <strong>Filtros de Rótulo</strong> (começa com, contém) e <strong>Filtros de Valor</strong> (vendas maiores que 10 mil; <strong>10 Primeiros</strong> — primeiros ou últimos N itens, por cento ou soma).',
              '<strong>Área Filtros</strong> — o filtro acima do relatório; a opção Mostrar Páginas do Filtro de Relatório cria uma planilha para cada item.',
              '<strong>Segmentação de Dados</strong> (Análise de Tabela Dinâmica > Inserir Segmentação de Dados) — botões visuais por campo; Ctrl+clique para vários; o botão de seleção múltipla; Limpar Filtro no canto. Em <strong>Conexões de Relatório</strong>, uma segmentação passa a filtrar várias tabelas dinâmicas da mesma fonte ao mesmo tempo.',
              '<strong>Linha do Tempo</strong> (Inserir Linha do Tempo) — uma segmentação especial para datas: arraste para escolher um período, por dias, meses, trimestres ou anos.'
            ] },
          { h: 'Classificar',
            p: 'Clique com o botão direito num valor > Classificar > do Maior para o Menor para ordenar os itens pelo resultado (o ranking de vendedores). Pela seta de Rótulos de Linha, Mais Opções de Classificação permite classificar por outro campo de valor. Itens podem ser arrastados manualmente para outra posição.' },
          { h: 'Layout e estilo',
            items: [
              'Design > <strong>Layout do Relatório</strong>: <strong>Formato Compacto</strong> (padrão; todos os campos de linha numa coluna, recuados), <strong>Formato de Estrutura de Tópicos</strong> e <strong>Formato de Tabela</strong> (cada campo em sua coluna — o melhor para copiar e reutilizar os dados). <strong>Repetir Todos os Rótulos de Itens</strong> preenche os rótulos em todas as linhas.',
              '<strong>Subtotais</strong> — não mostrar, mostrar no início ou no final do grupo. <strong>Totais Gerais</strong> — desativados, para linhas e colunas, só linhas ou só colunas.',
              '<strong>Linhas em Branco</strong> — inserir uma linha vazia depois de cada item.',
              '<strong>Estilos de Tabela Dinâmica</strong> e as <strong>Opções de Estilo</strong> (Cabeçalhos de Linha, Cabeçalhos de Coluna, Linhas e Colunas em Tiras).',
              '<strong>Opções da Tabela Dinâmica</strong> (botão direito): Para células vazias, mostrar (zero, por exemplo); Para valores de erro, mostrar; Ajustar automaticamente a largura das colunas ao atualizar; Preservar a formatação da célula ao atualizar.'
            ],
            img: { src: `${XL_IMG}/m12/formato-tabela.jpg`, alt: 'Tabela dinâmica no formato de tabela', caption: 'Formato de Tabela: cada campo de linha em sua própria coluna.', source: `${SUP}/excel/design-the-layout-and-format-of-a-pivottable` } },
          { h: 'Formato compacto',
            img: { src: `${XL_IMG}/m12/formato-compacto.jpg`, alt: 'Tabela dinâmica no formato compacto', caption: 'Formato Compacto (padrão): os campos de linha recuados numa única coluna.', source: `${SUP}/excel/design-the-layout-and-format-of-a-pivottable` } },
          { h: 'Como isso cai na prova',
            items: [
              '"Agrupe as datas por trimestre e ano" — Agrupar, com os dois marcados.',
              '"Insira uma segmentação para o campo Categoria e conecte-a às duas tabelas dinâmicas" — Inserir Segmentação de Dados + Conexões de Relatório.',
              '"Exiba a tabela dinâmica em formato de tabela sem subtotais" — Layout do Relatório + Subtotais.',
              '"Mostre os 5 produtos com mais vendas" — Filtros de Valor > 10 Primeiros, trocando por 5.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Agrupar ou desagrupar dados em uma Tabela Dinâmica', u: `${SUP}/excel/get-started/group-or-ungroup-data-in-a-pivottable` },
          { t: 'Microsoft Suporte — Filtrar dados em uma Tabela Dinâmica', u: `${SUP}/excel/get-started/filter-data-in-a-pivottable` },
          { t: 'Microsoft Suporte — Usar segmentações de dados para filtrar dados', u: `${SUP}/excel/get-started/use-slicers-to-filter-data` },
          { t: 'Microsoft Suporte — Classificar dados em uma Tabela Dinâmica', u: `${SUP}/excel/sort-data-in-a-pivottable-or-pivotchart` },
          { t: 'Microsoft Suporte — Criar o layout e o formato de uma Tabela Dinâmica', u: `${SUP}/excel/design-the-layout-and-format-of-a-pivottable` }
        ]
      },
      {
        id: 'xl-grafico-dinamico', title: 'Gráficos dinâmicos: criar, filtrar, estilizar e detalhar',
        desc: 'Criar gráficos dinâmicos a partir da base ou de uma tabela dinâmica, usar os botões de campo, formatar, e fazer drill down com Exploração Rápida e expandir/recolher.',
        objetivos: [
          'Criar gráficos dinâmicos e entender a ligação com a tabela dinâmica',
          'Filtrar e reorganizar pelo próprio gráfico, e aplicar estilos',
          'Detalhar (drill down) e resumir (drill up) os dados de um gráfico dinâmico'
        ],
        body: 'O gráfico dinâmico é o gráfico de uma tabela dinâmica: mudou o campo, filtrou, agrupou — o gráfico acompanha. Combinado com segmentações, vira um painel interativo simples. Criar gráficos dinâmicos, manipular suas opções, aplicar estilos e detalhar dados são as quatro habilidades de gráficos dinâmicos da prova Expert.',
        content: [
          { h: 'Criar',
            items: [
              'A partir de uma tabela dinâmica: clique nela e use Análise de Tabela Dinâmica > <strong>Gráfico Dinâmico</strong> (ou Inserir > Gráfico Dinâmico) e escolha o tipo.',
              'Direto da base: Inserir > <strong>Gráfico Dinâmico</strong> cria a tabela dinâmica e o gráfico juntos.',
              'Os campos em Linhas viram o <strong>eixo</strong> (categorias); os campos em Colunas viram a <strong>legenda</strong> (séries); Valores são os números plotados. No painel, as áreas passam a se chamar Eixo e Legenda.',
              'Nem todo tipo de gráfico é aceito: histograma, caixa estreita, cascata, funil, explosão solar, mapa de árvore e mapa não funcionam como gráfico dinâmico.'
            ] },
          { h: 'Manipular pelo gráfico',
            items: [
              'Os <strong>botões de campo</strong> sobre o gráfico filtram e classificam como as setas da tabela dinâmica. Para esconder na apresentação: Análise de Gráfico Dinâmico > <strong>Botões de Campo</strong> (ou botão direito num botão > Ocultar Todos os Botões de Campo no Gráfico).',
              'Filtrar ou mudar campos no gráfico muda a tabela dinâmica, e vice-versa — os dois estão sempre em sincronia.',
              'Segmentações e linhas do tempo inseridas pelo gráfico filtram o gráfico e a tabela.',
              'Alterar Tipo de Gráfico, Alternar Linha/Coluna, elementos, <strong>Layout Rápido</strong> e <strong>Estilos</strong> funcionam como em qualquer gráfico (Módulo 11) — pela guia Design.'
            ] },
          { h: 'Detalhar: drill down e drill up',
            items: [
              'Com vários campos no eixo (Ano > Trimestre > Mês, ou Categoria > Produto), use os botões <strong>Expandir Campo Inteiro</strong> e <strong>Recolher Campo Inteiro</strong> (sinal de mais e de menos no canto do gráfico, ou Análise de Gráfico Dinâmico) para descer ou subir um nível de detalhe.',
              'Botão direito num item do gráfico > <strong>Expandir/Recolher</strong> > Expandir / Recolher / Expandir para o campo seguinte.',
              'Em tabelas dinâmicas baseadas no Modelo de Dados, a <strong>Exploração Rápida</strong> (a lupa que aparece ao selecionar um item) detalha o item escolhido pelo campo que você indicar — Fazer Busca Detalhada desce, e o botão de busca acima volta.',
              'Dê duplo clique num valor da tabela dinâmica ligada para ver os registros de origem (Mostrar Detalhes).'
            ],
            img: { src: `${XL_IMG}/m12/exploracao-rapida.png`, alt: 'Galeria de Exploração Rápida', caption: 'Exploração Rápida: escolha o campo pelo qual detalhar o item selecionado.', source: `${SUP}/excel/drill-into-pivottable-data` } },
          { h: 'Como isso cai na prova',
            items: [
              '"Crie um gráfico dinâmico de colunas empilhadas a partir da tabela dinâmica Vendas" — Gráfico Dinâmico com o subtipo exato.',
              '"Oculte os botões de campo do gráfico" — Botões de Campo.',
              '"Detalhe o gráfico para mostrar os trimestres de 2026" — Expandir o item 2026 ou Expandir Campo Inteiro.',
              '"Aplique o Estilo 6 ao gráfico dinâmico" — Design > Estilos de Gráfico.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Criar um Gráfico Dinâmico', u: `${SUP}/excel/get-started/create-a-pivotchart` },
          { t: 'Microsoft Suporte — Detalhar dados da Tabela Dinâmica', u: `${SUP}/excel/drill-into-pivottable-data` }
        ]
      }
    ]
  },
  {
    id: 'xl-m13', title: 'Módulo 13 · Análise de dados: subtotais, consolidação e análise de hipóteses', kind: 'video',
    lessons: [
      {
        id: 'xl-subtotais-estrutura', title: 'Subtotais e estrutura de tópicos: agrupar e desagrupar',
        desc: 'O comando Subtotal, a função SUBTOTAL, agrupar linhas e colunas manualmente e por AutoTópicos, e os níveis de estrutura de tópicos.',
        objetivos: [
          'Inserir subtotais automáticos por grupo com o comando Subtotal',
          'Agrupar e desagrupar linhas e colunas e usar os botões de nível',
          'Entender a função SUBTOTAL e por que ela ignora outros subtotais'
        ],
        body: 'Antes das tabelas dinâmicas, relatórios com total por grupo eram feitos com o comando Subtotal — e ele continua útil quando o resultado precisa ficar na própria lista, com os detalhes a um clique de distância. A estrutura de tópicos (os botões 1, 2, 3 e os sinais de mais e menos na margem) também serve para esconder colunas de detalhe num orçamento. "Agrupar e desagrupar dados" e "calcular dados inserindo subtotais e totais" estão na prova Expert.',
        content: [
          { h: 'O comando Subtotal',
            items: [
              '<strong>Classifique primeiro</strong> pela coluna que define os grupos (Região, Esporte): o Subtotal cria um total a cada mudança de valor, então itens espalhados geram subtotais repetidos.',
              'Com uma célula na lista, use Dados > Estrutura de Tópicos > <strong>Subtotal</strong>.',
              '<strong>A cada alteração em</strong> — a coluna dos grupos. <strong>Usar função</strong> — Soma, Contagem, Média, Máx, Mín... <strong>Adicionar subtotal a</strong> — as colunas numéricas a totalizar.',
              '<strong>Substituir subtotais atuais</strong> — desmarque para acrescentar um segundo nível (subtotais por Região e, dentro, por Vendedor — classifique pelas duas colunas antes) ou uma segunda função.',
              '<strong>Quebra de página entre grupos</strong> e <strong>Resumir abaixo dos dados</strong> (total embaixo de cada grupo).',
              '<strong>Remover Todos</strong>, na mesma caixa, tira os subtotais e a estrutura.',
              'O comando não funciona dentro de tabelas do Excel — converta em intervalo antes (Módulo 05), ou use tabela dinâmica.'
            ],
            img: { src: `${XL_IMG}/m13/subtotais-esporte.gif`, alt: 'Lista com subtotais por esporte e total geral', caption: 'Um subtotal a cada mudança na coluna Esporte, mais o total geral.', source: `${SUP}/excel/insert-subtotals-in-a-list-of-data-in-a-worksheet` } },
          { h: 'A função SUBTOTAL',
            p: 'O comando escreve fórmulas <strong>SUBTOTAL</strong>, cujo primeiro argumento é o código da função: 1 a 11 (9 é soma, 1 média, 2 contar números, 3 contar valores, 4 máximo, 5 mínimo) consideram linhas ocultas manualmente; 101 a 111 ignoram as linhas ocultas. As duas famílias ignoram as linhas escondidas por filtro e ignoram outras fórmulas SUBTOTAL do intervalo — por isso o total geral não soma os subtotais duas vezes. É a mesma função da Linha de Totais das tabelas (Módulo 05) e a melhor escolha para totais que devem respeitar filtros.',
            code: '=SUBTOTAL(9;D2:D200)      → soma só as linhas visíveis após o filtro\n=SUBTOTAL(109;D2:D200)    → soma ignorando também as linhas ocultas à mão' },
          { h: 'Os controles de estrutura de tópicos',
            items: [
              'Os <strong>botões de nível</strong> (1, 2, 3...) no canto superior esquerdo: 1 mostra só o total geral, 2 os subtotais, 3 tudo.',
              'Os sinais de <strong>menos</strong> e <strong>mais</strong> na margem recolhem e expandem cada grupo.',
              'Dados > <strong>Ocultar Detalhe</strong> e <strong>Mostrar Detalhe</strong> fazem o mesmo para o grupo da célula ativa.'
            ],
            img: { src: `${XL_IMG}/m13/estrutura-tres-niveis.png`, alt: 'Dados com estrutura de tópicos de três níveis', caption: 'Estrutura de tópicos: botões de nível e sinais de mais e menos na margem.', source: `${SUP}/excel/outline-group-data-in-a-worksheet` } },
          { h: 'Agrupar e desagrupar manualmente',
            items: [
              'Selecione as linhas (ou colunas) de detalhe — sem a linha de total — e use Dados > <strong>Agrupar</strong> (atalho Shift+Alt+seta para a direita); <strong>Desagrupar</strong> com Shift+Alt+seta para a esquerda.',
              'Grupos dentro de grupos criam níveis (até oito).',
              'Agrupar colunas é o jeito limpo de esconder os meses e deixar só os trimestres num orçamento — melhor que ocultar, porque o leitor vê que há algo recolhido e expande com um clique.',
              'Agrupar > <strong>AutoTópicos</strong> cria a estrutura sozinho quando há linhas ou colunas de fórmulas de resumo ao lado dos detalhes.',
              'Desagrupar > <strong>Limpar Tópicos</strong> remove toda a estrutura sem apagar dados.',
              'O iniciador do grupo Estrutura de Tópicos define se as linhas de resumo ficam abaixo e as colunas de resumo à direita do detalhe.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              '"Insira subtotais que somem a coluna Valor a cada mudança de Região" — classifique por Região e use Subtotal.',
              '"Agrupe as colunas B a M" / "Desagrupe as linhas 5 a 10" — Agrupar e Desagrupar na guia Dados.',
              '"Recolha a estrutura para mostrar apenas os subtotais" — botão de nível 2.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Inserir subtotais em uma lista de dados', u: `${SUP}/excel/insert-subtotals-in-a-list-of-data-in-a-worksheet` },
          { t: 'Microsoft Suporte — Estrutura de tópicos (agrupar) dados', u: `${SUP}/excel/outline-group-data-in-a-worksheet` },
          { t: 'Microsoft Suporte — Função SUBTOTAL', u: `${SUP}/excel/functions/subtotal-function` }
        ]
      },
      {
        id: 'xl-consolidar', title: 'Consolidar dados de várias planilhas',
        desc: 'Resumir dados de várias planilhas ou pastas com o comando Consolidar, por posição ou por categoria, com e sem vínculos com a origem.',
        objetivos: [
          'Consolidar por posição e por categoria',
          'Usar rótulos da linha superior e da coluna esquerda',
          'Escolher entre Consolidar, referência 3D e Power Query'
        ],
        body: 'Cada filial manda sua planilha de vendas, cada departamento seu orçamento — e alguém precisa do total da empresa. O comando Consolidar junta e resume vários intervalos, de planilhas ou pastas diferentes, numa tabela só. "Consolidar dados" está na lista da prova Expert.',
        content: [
          { h: 'Por posição',
            p: 'Quando todas as planilhas têm <strong>exatamente o mesmo layout</strong> (produtos nas mesmas linhas, meses nas mesmas colunas). Na planilha de destino, clique na célula onde o resultado começa e use Dados > Ferramentas de Dados > <strong>Consolidar</strong>. Escolha a <strong>Função</strong> (Soma, Média, Contagem, Máx...), selecione cada intervalo em <strong>Referência</strong> e clique em <strong>Adicionar</strong> — os intervalos vão para Todas as referências. OK gera o resultado. Aqui, vale só a posição: a primeira célula de cada intervalo é somada com a primeira das outras.' },
          { h: 'Por categoria',
            p: 'Quando os rótulos são os mesmos, mas <strong>a ordem ou a quantidade de itens muda</strong> entre as planilhas (uma filial vende produtos que a outra não vende). Faça igual, mas selecione os intervalos com os rótulos e marque, em <strong>Usar rótulos na</strong>, <strong>Linha superior</strong> e/ou <strong>Coluna esquerda</strong>. O Excel casa os itens pelo nome; um rótulo que só existe numa planilha entra mesmo assim, como linha ou coluna nova. Rótulos precisam ser idênticos — "Média" e "Méd." são itens diferentes.' },
          { h: 'Vínculos com a origem',
            p: 'Com <strong>Criar vínculos com dados de origem</strong> marcado, o resultado vira fórmulas ligadas às planilhas de origem e ganha uma estrutura de tópicos com os detalhes de cada fonte recolhidos embaixo de cada total; alterou uma filial, o consolidado muda. Sem a opção, o resultado são valores fixos — para atualizar, é preciso consolidar de novo (a caixa lembra as referências). Não é possível ligar vínculos quando a origem e o destino estão na mesma planilha.' },
          { h: 'Alternativas',
            items: [
              '<strong>Referência 3D</strong> (Módulo 06) — para planilhas idênticas numa mesma pasta, uma fórmula de soma com o intervalo de planilhas faz a consolidação por posição e se atualiza sozinha.',
              '<strong>Power Query</strong> (Módulo 04) — para empilhar listas de vários arquivos ou planilhas (Acrescentar consultas ou Obter Dados de Pasta) e depois resumir com tabela dinâmica. É a solução mais robusta quando os dados chegam todo mês.',
              '<strong>Tabela dinâmica</strong> — depois de empilhar tudo numa lista só.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              '"Consolide os dados das planilhas Norte, Sul e Leste na célula A1 da planilha Total, somando os valores e usando os rótulos da linha superior e da coluna esquerda" — Consolidar, três referências, duas caixas de rótulo.',
              'Se a tarefa pedir que o resultado se atualize com as origens, marque Criar vínculos com dados de origem.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Combinar dados de várias planilhas', u: `${SUP}/excel/combine-data-from-multiple-sheets` }
        ]
      },
      {
        id: 'xl-analise-hipoteses', title: 'Análise de hipóteses: Atingir Meta, Cenários, Tabela de Dados e Previsão',
        desc: 'Descobrir o valor de entrada que produz um resultado, salvar e comparar conjuntos de valores com o Gerenciador de Cenários, testar muitas combinações com Tabela de Dados e projetar com a Planilha de Previsão.',
        objetivos: [
          'Usar Atingir Meta para encontrar o valor de entrada necessário',
          'Criar, mostrar e resumir cenários',
          'Montar tabelas de dados de uma e duas variáveis e criar uma planilha de previsão'
        ],
        body: '"Quanto preciso vender para lucrar 50 mil?" "E se o custo subir 10% e o preço cair 5%?" "Qual taxa de juros deixa a parcela em 900 reais?" A análise de hipóteses do Excel responde perguntas assim sem refazer a planilha. Atingir Meta e o Gerenciador de Cenários estão nominalmente na prova Expert.',
        content: [
          { h: 'Os três recursos',
            p: 'Ficam em Dados > Previsão > <strong>Teste de Hipóteses</strong>. <strong>Cenários</strong> e <strong>Tabela de Dados</strong> partem de valores de entrada e mostram os resultados possíveis. <strong>Atingir Meta</strong> faz o caminho inverso: parte do resultado desejado e descobre a entrada. Todos exigem que o resultado seja uma <strong>fórmula</strong> que dependa das células de entrada.' },
          { h: 'Atingir Meta',
            items: [
              '<strong>Definir célula</strong> — a célula com a fórmula do resultado (a parcela, o lucro).',
              '<strong>Para valor</strong> — o resultado desejado (menos 900, se a parcela é negativa como no PGTO; 50000 de lucro).',
              '<strong>Alternando célula</strong> — a única célula de entrada que o Excel pode mudar (a taxa, o volume de vendas). Ela precisa conter um valor, não uma fórmula.',
              'O Excel testa valores até chegar ao resultado e pergunta se você quer manter a solução (OK) ou voltar ao valor original (Cancelar).',
              'Só uma célula variável. Para várias variáveis e restrições (orçamento máximo, quantidades inteiras), use o suplemento <strong>Solver</strong> (ativado em Arquivo > Opções > Suplementos).'
            ],
            code: 'B1: 100000  (valor do empréstimo)\nB2: 180     (meses)\nB3: vazio   (taxa anual — é o que queremos descobrir)\nB4: =PGTO(B3/12;B2;B1)\n\nAtingir Meta: Definir célula B4 · Para valor -900 · Alternando célula B3\n→ B3 recebe a taxa anual que resulta numa parcela de 900' },
          { h: 'Gerenciador de Cenários',
            items: [
              'Um cenário é um conjunto salvo de valores para as <strong>células variáveis</strong> (até 32 por cenário): Pior caso, Caso provável, Melhor caso.',
              'Teste de Hipóteses > <strong>Gerenciador de Cenários</strong> > <strong>Adicionar</strong>: dê um nome, informe as células variáveis e, na tela seguinte, os valores do cenário. Repita para cada cenário.',
              '<strong>Mostrar</strong> — substitui os valores na planilha pelos do cenário escolhido (a planilha passa a mostrar aquele caso).',
              '<strong>Resumir</strong> — cria uma planilha de relatório com todos os cenários lado a lado, informando as <strong>células de resultado</strong> que você quer comparar. Com nomes definidos nas células, o relatório fica legível (mostra "Receita" em vez de B2).',
              '<strong>Mesclar</strong> traz cenários de outras pastas de trabalho (cada gerente cria o seu). Editar e Excluir ajustam os existentes.'
            ],
            img: { src: `${XL_IMG}/m13/gerenciador-cenarios.png`, alt: 'Caixa Gerenciador de Cenários', caption: 'Gerenciador de Cenários: adicionar, mostrar, mesclar e resumir.', source: `${SUP}/excel/switch-between-various-sets-of-values-by-using-scenarios` } },
          { h: 'O relatório de resumo',
            img: { src: `${XL_IMG}/m13/resumo-cenario.png`, alt: 'Relatório Resumo do Cenário comparando pior e melhor caso', caption: 'Resumo do cenário: valores das células variáveis e do resultado em cada caso.', source: `${SUP}/excel/switch-between-various-sets-of-values-by-using-scenarios` } },
          { h: 'Tabela de Dados',
            p: 'Para testar muitos valores de uma ou duas entradas de uma vez. <strong>Uma variável</strong>: liste os valores de entrada numa coluna, coloque a fórmula do resultado na célula acima e à direita da lista, selecione o bloco e use Teste de Hipóteses > <strong>Tabela de Dados</strong>, informando a <strong>Célula de entrada da coluna</strong>. <strong>Duas variáveis</strong>: valores de uma entrada na coluna, da outra na linha, a fórmula no canto onde elas se cruzam; informe as duas células de entrada. O resultado é uma fórmula de matriz especial (TABELA) que se recalcula sozinha; não dá para editar uma célula isolada dela.',
            img: { src: `${XL_IMG}/m13/tabela-dados-uma-variavel.gif`, alt: 'Tabela de dados de uma variável', caption: 'Tabela de dados de uma variável: cada linha testa um valor de entrada.', source: `${SUP}/excel/calculate-multiple-results-by-using-a-data-table` } },
          { h: 'Planilha de Previsão',
            p: 'Com uma série histórica (datas em intervalos regulares e valores), Dados > Previsão > <strong>Planilha de Previsão</strong> cria uma planilha nova com a projeção, os limites de confiança e um gráfico. Escolha o <strong>Fim da Previsão</strong>; em Opções, o intervalo de confiança, a sazonalidade e como tratar pontos faltantes. Por trás está a função PREVISÃO.ETS (suavização exponencial).',
            img: { src: `${XL_IMG}/m13/planilha-previsao.png`, alt: 'Caixa Criar Planilha de Previsão com o gráfico da projeção', caption: 'Planilha de Previsão: histórico, projeção e limites de confiança (tela da versão em português de Portugal).', source: `${SUP}/excel/create-a-forecast-in-excel-for-windows` } },
          { h: 'Como isso cai na prova',
            items: [
              '"Use Atingir Meta para que a célula D10 seja 25000 alterando a célula B4" — os três campos, na ordem da caixa.',
              '"Crie um cenário chamado Otimista que altere B2 e B3 para 12000 e 0,15" e "crie um relatório de resumo de cenário com a célula de resultado B10".',
              'Mostrar um cenário altera a planilha — a prova confere os valores das células depois da tarefa.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Introdução à análise de hipóteses', u: `${SUP}/excel/introduction-to-what-if-analysis` },
          { t: 'Microsoft Suporte — Usar Atingir Meta', u: `${SUP}/excel/use-goal-seek-to-find-the-result-you-want-by-adjusting-an-input-value` },
          { t: 'Microsoft Suporte — Alternar entre conjuntos de valores com cenários', u: `${SUP}/excel/switch-between-various-sets-of-values-by-using-scenarios` },
          { t: 'Microsoft Suporte — Calcular vários resultados com uma tabela de dados', u: `${SUP}/excel/calculate-multiple-results-by-using-a-data-table` },
          { t: 'Microsoft Suporte — Criar uma previsão no Excel', u: `${SUP}/excel/create-a-forecast-in-excel-for-windows` }
        ]
      },
      {
        id: 'xl-funcoes-financeiras', title: 'Funções financeiras: PGTO, NPER, VP, VF e TAXA',
        desc: 'Calcular parcela, número de períodos, valor presente, valor futuro e taxa de financiamentos e investimentos — e a convenção de sinais que confunde todo mundo.',
        objetivos: [
          'Calcular parcelas com PGTO e prazos com NPER',
          'Usar VP, VF e TAXA e a convenção de sinais de entrada e saída de dinheiro',
          'Combinar funções financeiras com SE e E em projeções'
        ],
        body: 'Financiamento de carro, empréstimo para capital de giro, meta de investimento: as funções financeiras respondem quanto pagar por mês, em quantos meses se quita uma dívida e quanto um aporte mensal vira no futuro. A prova Expert pede "calcular dados usando a função PGTO" e "prever dados usando as funções E, SE e NPER".',
        content: [
          { h: 'Os cinco elementos',
            p: 'Todas as funções giram em torno de cinco valores; você informa quatro e a função calcula o quinto:',
            items: [
              '<strong>taxa</strong> — a taxa de juros <strong>por período</strong>. Juros anuais com parcelas mensais: taxa anual dividida por 12.',
              '<strong>nper</strong> — o número total de períodos (anos vezes 12, para parcelas mensais).',
              '<strong>pgto</strong> — o pagamento de cada período.',
              '<strong>vp</strong> — o valor presente (o valor financiado, o capital inicial).',
              '<strong>vf</strong> — o valor futuro (o saldo desejado ao final; zero, para quitar a dívida — é o padrão).',
              '<strong>tipo</strong> (opcional) — 0 para pagamento no fim do período (padrão), 1 para pagamento no início.'
            ] },
          { h: 'A convenção de sinais',
            p: 'O Excel trata dinheiro que sai do seu bolso como negativo e dinheiro que entra como positivo. Ao financiar 30 mil (entram 30 mil, positivo), a parcela sai negativa. Se preferir ver a parcela positiva, coloque um sinal de menos antes da função ou informe o valor presente como negativo. Misturar os sinais errados faz NPER e TAXA darem erro (não há solução).' },
          { h: 'PGTO e NPER',
            code: 'PGTO(taxa; nper; vp; [vf]; [tipo])\nNPER(taxa; pgto; vp; [vf]; [tipo])\n\n=PGTO(1,5%;48;30000)             → cerca de -881,25 (parcela de um financiamento de 30 mil em 48 meses a 1,5% ao mês)\n=PGTO(12%/12;60;0;100000)        → cerca de -1.224,44: aporte mensal para juntar 100 mil em 5 anos a 12% ao ano\n=NPER(1,5%;-1000;30000)          → quantos meses pagando 1.000 por mês para quitar 30 mil (cerca de 40,2)' },
          { h: 'VP, VF e TAXA',
            items: [
              '<strong>VP</strong> (PV) — quanto dá para financiar hoje com uma parcela que cabe no orçamento.',
              '<strong>VF</strong> (FV) — quanto um investimento vai valer: aportes mensais durante N meses a uma taxa.',
              '<strong>TAXA</strong> (RATE) — a taxa implícita de uma operação: quem vende a prazo "sem juros" com desconto à vista está cobrando juros; TAXA revela quanto.'
            ],
            code: 'VP(taxa; nper; pgto; [vf]; [tipo])\nVF(taxa; nper; pgto; [vp]; [tipo])\nTAXA(nper; pgto; vp; [vf]; [tipo]; [estimativa])\n\n=VP(1,5%;48;-900)                 → quanto dá para financiar pagando 900 por mês\n=VF(1%;120;-500)                  → 500 por mês durante 10 anos a 1% ao mês (cerca de 115 mil)\n=TAXA(10;-100;900)                → 10 × 100 contra 900 à vista: cerca de 1,96% ao mês' },
          { h: 'Previsão com E, SE e NPER',
            p: 'Combinando funções lógicas e financeiras, a planilha decide sozinha: o financiamento cabe no orçamento e no prazo máximo da política da empresa?',
            code: 'B1: 30000 (valor)   B2: 1,5% (taxa ao mês)   B3: 1000 (parcela possível)   B4: 36 (prazo máximo)\n\n=SE(E(B3>B1*B2;NPER(B2;-B3;B1)<=B4);\n    "Aprovado em "&ARREDONDAR.PARA.CIMA(NPER(B2;-B3;B1);0)&" meses";\n    "Fora da política")',
            items: [
              'O primeiro teste (a parcela precisa ser maior que os juros do mês) evita o erro de NPER quando a parcela nunca quitaria a dívida.',
              'ARREDONDAR.PARA.CIMA transforma 40,2 meses em 41 parcelas.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              '"Em B5, calcule o pagamento mensal de um empréstimo com taxa anual em B2, prazo em anos em B3 e valor em B1" — PGTO com a taxa dividida por 12 e o prazo multiplicado por 12: converta taxa e prazo para meses.',
              '"Em C8, exiba Sim se o número de períodos for menor que 60 e o valor for maior que 10000" — E, SE e NPER.',
              'Em inglês: PMT, NPER, PV, FV, RATE.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Função PGTO', u: `${SUP}/excel/functions/pmt-function` },
          { t: 'Microsoft Suporte — Função NPER', u: `${SUP}/excel/functions/nper-function` },
          { t: 'Microsoft Suporte — Função VP', u: `${SUP}/excel/functions/pv-function` },
          { t: 'Microsoft Suporte — Função VF', u: `${SUP}/excel/functions/fv-function` },
          { t: 'Microsoft Suporte — Função TAXA', u: `${SUP}/excel/functions/rate-function` }
        ]
      }
    ]
  },
  {
    id: 'xl-m14', title: 'Módulo 14 · Auditoria de fórmulas, erros e opções de cálculo', kind: 'video',
    lessons: [
      {
        id: 'xl-auditoria', title: 'Rastrear precedentes e dependentes, Janela de Inspeção e Avaliar Fórmula',
        desc: 'Descobrir de onde vem e para onde vai cada valor, acompanhar células distantes enquanto edita e executar uma fórmula aninhada passo a passo.',
        objetivos: [
          'Rastrear precedentes e dependentes e remover as setas',
          'Monitorar células com a Janela de Inspeção',
          'Depurar fórmulas com Avaliar Fórmula'
        ],
        body: 'Planilhas herdadas de outra pessoa costumam ter fórmulas que dependem de fórmulas que dependem de fórmulas. Antes de mudar qualquer coisa, é preciso saber o que alimenta aquele total e o que ele alimenta. As ferramentas do grupo Fórmulas > Auditoria de Fórmulas fazem esse mapeamento — rastrear precedentes e dependentes, Janela de Inspeção e Avaliar Fórmula são três habilidades da prova Expert.',
        content: [
          { h: 'Rastrear Precedentes e Rastrear Dependentes',
            items: [
              '<strong>Precedentes</strong> são as células das quais a fórmula depende. Selecione a fórmula e clique em <strong>Rastrear Precedentes</strong>: setas azuis partem das células usadas até a fórmula (intervalos aparecem contornados). Clique de novo para o nível anterior — os precedentes dos precedentes.',
              '<strong>Dependentes</strong> são as fórmulas que usam a célula selecionada. <strong>Rastrear Dependentes</strong> desenha setas da célula para cada fórmula que a utiliza — essencial antes de apagar ou alterar um valor.',
              'Setas <strong>vermelhas</strong> indicam células que causam erro. Uma seta <strong>preta pontilhada</strong> com um ícone de planilha indica ligação com outra planilha ou pasta; dê duplo clique nela para abrir a lista de destinos em Ir para.',
              'Duplo clique numa seta azul leva à célula da outra ponta.',
              '<strong>Remover Setas</strong> tira todas; a seta ao lado do botão remove só as de precedentes ou só as de dependentes, um nível por vez.',
              'Qualquer edição (alterar a fórmula, inserir linhas) apaga as setas — rastreie de novo depois.'
            ] },
          { h: 'Janela de Inspeção',
            p: 'Em planilhas grandes, a célula que você quer acompanhar está longe de onde você está editando. Fórmulas > <strong>Janela de Inspeção</strong> > <strong>Adicionar Inspeção</strong> e selecione as células: a janela mostra, para cada uma, a Pasta, a Planilha, o Nome, a Célula, o Valor e a Fórmula, atualizados em tempo real enquanto você altera outras partes (até de outras planilhas). A janela pode ser encaixada embaixo da tela. <strong>Excluir Inspeção</strong> remove a célula da lista.',
            img: { src: `${XL_IMG}/m14/janela-inspecao.png`, alt: 'Janela de Inspeção acompanhando uma célula', caption: 'Janela de Inspeção: pasta, planilha, célula, valor e fórmula de cada item (imagem original em inglês).', source: `${SUP}/excel/watch-a-formula-and-its-result-by-using-the-watch-window` } },
          { h: 'Avaliar Fórmula',
            p: 'Selecione a célula com a fórmula e use Fórmulas > <strong>Avaliar Fórmula</strong>. A caixa mostra a fórmula com a próxima parte a ser calculada <strong>sublinhada</strong>; cada clique em <strong>Avaliar</strong> substitui essa parte pelo resultado (em itálico), na ordem em que o Excel calcula. <strong>Etapa Interna</strong> mostra a fórmula de uma célula referenciada, e <strong>Etapa Externa</strong> volta. <strong>Reiniciar</strong> começa de novo. É a forma de encontrar em qual pedaço de um SE aninhado o cálculo desanda.',
            code: '=SE(MÉDIA(F2:F5)>50;SOMA(G2:G5);0)\n→ =SE(40>50;SOMA(G2:G5);0)\n→ =SE(FALSO;SOMA(G2:G5);0)\n→ 0' },
          { h: 'Um truque rápido: F9 dentro da fórmula',
            p: 'Editando uma fórmula na barra de fórmulas, selecione um trecho (uma função inteira, por exemplo) e pressione F9: o Excel mostra o resultado daquele trecho. Pressione <strong>Esc</strong> para sair sem gravar — se pressionar Enter, o trecho vira um valor fixo na fórmula.' },
          { h: 'Como isso cai na prova',
            items: [
              '"Mostre as células que dependem de B5" — Rastrear Dependentes com B5 selecionada (a prova confere as setas).',
              '"Adicione a célula H20 da planilha Resumo à Janela de Inspeção" — Adicionar Inspeção.',
              '"Remova as setas de rastreamento" — Remover Setas.',
              'Avaliar Fórmula é ferramenta de diagnóstico; nas tarefas, o que costuma ser pedido é corrigir a fórmula que ela revela.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Exibir as relações entre fórmulas e células', u: `${SUP}/excel/display-the-relationships-between-formulas-and-cells` },
          { t: 'Microsoft Suporte — Janela de Inspeção', u: `${SUP}/excel/watch-a-formula-and-its-result-by-using-the-watch-window` },
          { t: 'Microsoft Suporte — Avaliar uma fórmula aninhada uma etapa de cada vez', u: `${SUP}/excel/evaluate-a-nested-formula-one-step-at-a-time` }
        ]
      },
      {
        id: 'xl-erros-formulas', title: 'Os erros do Excel e a Verificação de Erros',
        desc: 'O que significa cada valor de erro e como corrigir, o triângulo verde, as regras de verificação e a caixa Verificação de Erros.',
        objetivos: [
          'Identificar a causa de cada valor de erro',
          'Usar a Verificação de Erros e o botão de aviso da célula',
          'Configurar as regras de verificação e redefinir erros ignorados'
        ],
        body: 'Todo erro do Excel começa com uma cerquilha e diz, com poucas letras, o que deu errado. Saber ler esses códigos transforma uma planilha "quebrada" num problema de cinco minutos. A verificação de erros é habilidade da prova Expert, e os próprios erros aparecem em qualquer tarefa com fórmula.',
        content: [
          { h: 'Os valores de erro',
            items: [
              '<strong>#DIV/0!</strong> — divisão por zero ou por célula vazia. Trate a entrada (SE o divisor for zero...) ou use SEERRO.',
              '<strong>#N/D</strong> — valor não disponível: a procura (PROCX, PROCV, CORRESP) não encontrou o valor. Confira grafia, espaços sobrando (ARRUMAR) e tipos (número x texto). SENÃODISP ou o argumento se_não_encontrada do PROCX tratam o caso legítimo.',
              '<strong>#NOME?</strong> — o Excel não reconhece um nome: função digitada errada, nome definido inexistente, texto sem aspas, ou função em inglês no Excel em português.',
              '<strong>#REF!</strong> — referência inválida: a célula usada pela fórmula foi excluída (linha, coluna ou planilha apagada, ou colagem por cima). Desfaça, ou refaça a referência. PROCV pedindo uma coluna maior que o intervalo também dá #REF!.',
              '<strong>#VALOR!</strong> — tipo errado: somar texto com número, uma data digitada como texto, argumentos incompatíveis, intervalos de tamanhos diferentes.',
              '<strong>#NÚM!</strong> — número impossível ou grande demais: raiz de negativo, TAXA ou NPER sem solução, resultado fora dos limites do Excel.',
              '<strong>#NULO!</strong> — interseção vazia: um espaço entre dois intervalos que não se cruzam (em geral, faltou o ponto e vírgula ou os dois-pontos).',
              '<strong>#DESPEJAR!</strong> e <strong>#CALC!</strong> — de matrizes dinâmicas: área de despejo ocupada, ou matriz vazia (Módulo 09).',
              '<strong>####</strong> — não é erro de fórmula: a coluna é estreita demais para o número ou a data (ou a data/hora é negativa).'
            ],
            img: { src: `${XL_IMG}/m14/ref-coluna-excluida.png`, alt: 'Erro #REF! causado pela exclusão de uma coluna', caption: 'Excluir uma coluna usada na fórmula transforma a referência em #REF!.', source: `${SUP}/excel/how-to-correct-a-ref-error` } },
          { h: 'O triângulo verde e o botão de aviso',
            p: 'Com a verificação em segundo plano ligada, células suspeitas ganham um <strong>triângulo verde</strong> no canto superior esquerdo. Selecione a célula e clique no ícone de aviso ao lado: a primeira linha descreve o problema e as opções corrigem (Converter em Número, Copiar Fórmula de Cima, Atualizar Fórmula para Incluir Células), explicam (Ajuda sobre este Erro), mostram as etapas (Mostrar Etapas de Cálculo, que abre Avaliar Fórmula) ou <strong>Ignorar Erro</strong>.',
            img: { src: `${XL_IMG}/m14/formula-inconsistente.png`, alt: 'Aviso de fórmula inconsistente com as vizinhas', caption: 'Fórmula inconsistente: a única diferente das vizinhas recebe o aviso.', source: `${SUP}/excel/detect-formula-errors-in-excel` } },
          { h: 'As regras de verificação',
            p: 'Em Arquivo > Opções > Fórmulas, seção <strong>Verificação de Erros</strong>, ficam a caixa Habilitar verificação de erros em segundo plano, a cor do indicador e o botão <strong>Redefinir Erros Ignorados</strong>; em <strong>Regras de verificação do Excel</strong>, cada regra pode ser ligada ou desligada. As principais:',
            items: [
              'Células que contêm fórmulas que resultam em erro.',
              '<strong>Fórmulas inconsistentes</strong> com outras fórmulas da região (a da linha 4 soma a linha 10, enquanto as vizinhas somam a própria linha).',
              '<strong>Fórmulas que omitem células</strong> numa região (o total não inclui a linha que você acrescentou logo acima).',
              '<strong>Números formatados como texto</strong> ou precedidos de apóstrofo.',
              'Fórmulas que se referem a células vazias; células desbloqueadas que contêm fórmulas; dados inválidos segundo a validação.'
            ] },
          { h: 'A caixa Verificação de Erros',
            p: 'Fórmulas > <strong>Verificação de Erros</strong> percorre a planilha de erro em erro, mostrando a célula, a fórmula e o tipo de problema, com botões para ajuda, Mostrar Etapas de Cálculo, Ignorar Erro, <strong>Editar na Barra de Fórmulas</strong> e Anterior/Próximo. A seta do botão tem ainda <strong>Rastrear Erro</strong> (setas até a origem do erro) e <strong>Referências Circulares</strong> (próxima aula).',
            img: { src: `${XL_IMG}/m14/verificacao-erros.png`, alt: 'Caixa Verificação de Erros', caption: 'Verificação de Erros: percorra os erros da planilha um a um.', source: `${SUP}/excel/detect-formula-errors-in-excel` } },
          { h: 'Como isso cai na prova',
            items: [
              '"Use a verificação de erros para localizar e corrigir o erro na planilha Vendas" — a caixa Verificação de Erros, e depois a correção que ela sugere.',
              '"Configure o Excel para não sinalizar números armazenados como texto" — Opções > Fórmulas > desmarque a regra.',
              'Em inglês os erros são #DIV/0!, #N/A, #NAME?, #REF!, #VALUE!, #NUM!, #NULL!, #SPILL! e #CALC!.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Detectar erros de fórmula', u: `${SUP}/excel/detect-formula-errors-in-excel` },
          { t: 'Microsoft Suporte — Corrigir o erro #DIV/0!', u: `${SUP}/excel/how-to-correct-a-div-0-error` },
          { t: 'Microsoft Suporte — Corrigir o erro #N/D', u: `${SUP}/excel/how-to-correct-a-n-a-error` },
          { t: 'Microsoft Suporte — Corrigir o erro #NOME?', u: `${SUP}/excel/how-to-correct-a-name-error` },
          { t: 'Microsoft Suporte — Corrigir o erro #REF!', u: `${SUP}/excel/how-to-correct-a-ref-error` },
          { t: 'Microsoft Suporte — Corrigir o erro #VALOR!', u: `${SUP}/excel/how-to-correct-a-value-error` },
          { t: 'Microsoft Suporte — Corrigir o erro #NÚM!', u: `${SUP}/excel/how-to-correct-a-num-error` }
        ]
      },
      {
        id: 'xl-calculo-circular', title: 'Opções de cálculo, recálculo manual e referências circulares',
        desc: 'Cálculo automático, automático exceto tabelas de dados e manual; F9 e seus atalhos; referências circulares acidentais e intencionais; cálculo iterativo e precisão.',
        objetivos: [
          'Configurar as opções de cálculo da pasta de trabalho',
          'Recalcular manualmente com F9, Shift+F9 e Ctrl+Alt+F9',
          'Encontrar referências circulares e habilitar o cálculo iterativo quando elas forem intencionais'
        ],
        body: 'Por padrão, o Excel recalcula tudo a cada alteração. Em pastas pesadas, isso trava o trabalho — e às vezes alguém deixa o cálculo manual ligado, e a planilha passa a mostrar resultados velhos sem avisar. Entender as opções de cálculo evita as duas situações. "Configurar opções de cálculo de fórmulas" é habilidade da prova Expert, na parte de opções da pasta de trabalho.',
        content: [
          { h: 'As opções de cálculo',
            p: 'Fórmulas > Cálculo > <strong>Opções de Cálculo</strong> (ou Arquivo > Opções > Fórmulas):',
            items: [
              '<strong>Automático</strong> — o padrão: toda alteração recalcula as fórmulas dependentes.',
              '<strong>Automático, exceto para tabelas de dados</strong> — as tabelas de dados de análise de hipóteses (Módulo 13), que são pesadas, só recalculam com F9.',
              '<strong>Manual</strong> — nada recalcula até você mandar. A barra de status mostra <strong>Calcular</strong> quando há fórmulas desatualizadas. Na tela de Opções, <strong>Recalcular pasta de trabalho antes de salvar</strong> fica disponível.',
              'Atenção: a opção vale para o aplicativo, e a primeira pasta aberta na sessão define o modo — abrir um arquivo salvo em Manual pode deixar as outras pastas em Manual também.'
            ],
            img: { src: `${XL_IMG}/m14/grupo-calculo.png`, alt: 'Grupo Cálculo da guia Fórmulas', caption: 'Fórmulas > Cálculo: Opções de Cálculo, Calcular Agora e Calcular Planilha.', source: `${SUP}/excel/change-formula-recalculation-iteration-or-precision-in-excel` } },
          { h: 'Recalcular à mão',
            items: [
              '<strong>F9</strong> (Calcular Agora) — recalcula o que mudou em todas as pastas abertas.',
              '<strong>Shift+F9</strong> (Calcular Planilha) — só a planilha ativa.',
              '<strong>Ctrl+Alt+F9</strong> — recalcula todas as fórmulas de todas as pastas abertas, tenham mudado ou não.',
              '<strong>Ctrl+Shift+Alt+F9</strong> — reconstrói a árvore de dependências e recalcula tudo (último recurso quando algo parece não atualizar).'
            ] },
          { h: 'Referências circulares',
            p: 'Uma referência circular acontece quando uma fórmula depende, direta ou indiretamente, do próprio resultado — a soma de B1 a B10 digitada em B10, por exemplo. O Excel mostra um aviso na primeira vez e a barra de status passa a exibir <strong>Referências Circulares</strong> com o endereço de uma delas. Para achar todas: Fórmulas > seta de Verificação de Erros > <strong>Referências Circulares</strong>, que lista as células; corrija uma de cada vez (Rastrear Precedentes ajuda a ver o ciclo) até a barra de status parar de mostrá-las.',
            img: { src: `${XL_IMG}/m14/referencia-circular.jpg`, alt: 'Fórmula que causa referência circular', caption: 'A fórmula inclui a própria célula: referência circular.', source: `${SUP}/excel/remove-or-allow-a-circular-reference-in-excel` } },
          { h: 'Cálculo iterativo: quando a circularidade é de propósito',
            p: 'Alguns modelos financeiros são circulares de propósito (juros que dependem do saldo que depende dos juros). Em Arquivo > Opções > Fórmulas, marque <strong>Habilitar cálculo iterativo</strong>: o Excel recalcula o ciclo repetidamente até parar em <strong>Máximo de Iterações</strong> (padrão 100) ou quando a diferença entre duas rodadas for menor que o <strong>Número Máximo de Alterações</strong> (padrão 0,001). Ligue só quando souber que o ciclo converge — senão, erros reais de circularidade passam despercebidos.' },
          { h: 'Precisão conforme exibido',
            p: 'O Excel calcula com até 15 dígitos significativos, independentemente do formato. A opção <strong>Definir precisão conforme exibido</strong> (Arquivo > Opções > Avançado, seção Ao calcular esta pasta de trabalho) faz o Excel <strong>gravar</strong> os valores como estão exibidos — e os decimais escondidos se perdem para sempre. Prefira ARRED nas fórmulas (Módulo 06).' },
          { h: 'Como isso cai na prova',
            items: [
              '"Configure a pasta de trabalho para que as fórmulas sejam recalculadas apenas manualmente" — Opções de Cálculo > Manual.',
              '"Habilite o cálculo iterativo com no máximo 50 iterações" — Opções > Fórmulas.',
              '"Localize e corrija a referência circular" — Verificação de Erros > Referências Circulares.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Alterar o recálculo, a iteração ou a precisão', u: `${SUP}/excel/change-formula-recalculation-iteration-or-precision-in-excel` },
          { t: 'Microsoft Suporte — Remover ou permitir uma referência circular', u: `${SUP}/excel/remove-or-allow-a-circular-reference-in-excel` }
        ]
      }
    ]
  },
  {
    id: 'xl-m15', title: 'Módulo 15 · Impressão, colaboração e proteção', kind: 'video',
    lessons: [
      {
        id: 'xl-configurar-pagina', title: 'Configurar a página: margens, orientação, área de impressão, títulos e escala',
        desc: 'Preparar a planilha para o papel ou PDF: margens, orientação, tamanho, área de impressão, linhas de título repetidas, ajuste de escala, linhas de grade e a caixa Configurar Página.',
        objetivos: [
          'Definir margens, orientação, tamanho do papel e centralização',
          'Definir, adicionar e limpar a área de impressão',
          'Repetir linhas de título em cada página e ajustar a escala para caber'
        ],
        body: 'Uma planilha que fica ótima na tela pode sair em 14 páginas com a última coluna sozinha numa folha. Configurar a página resolve: o que imprimir, em que orientação, com os títulos repetidos em cada folha e numa escala que caiba. "Modificar a configuração de página", "definir área de impressão" e "configurar definições de impressão" estão na prova Associate.',
        content: [
          { h: 'A guia Layout da Página',
            items: [
              '<strong>Margens</strong> — Normal, Larga, Estreita ou <strong>Margens Personalizadas</strong> (que abre a guia Margens da caixa Configurar Página, com topo, base, esquerda, direita, cabeçalho, rodapé e as caixas <strong>Centralizar na página: Horizontalmente / Verticalmente</strong>).',
              '<strong>Orientação</strong> — Retrato ou Paisagem. Tabelas largas quase sempre ficam melhor em paisagem.',
              '<strong>Tamanho</strong> — A4, Carta, Ofício...',
              '<strong>Quebras</strong> — Inserir, Remover e Redefinir quebras de página (Módulo 01).',
              '<strong>Plano de Fundo</strong> — uma imagem atrás das células, só na tela (não é impressa).'
            ] },
          { h: 'Área de impressão',
            p: 'Por padrão, o Excel imprime tudo o que tem conteúdo. Para imprimir só uma parte, selecione o intervalo e use Layout da Página > <strong>Área de Impressão</strong> > <strong>Definir Área de Impressão</strong>. Com uma área já definida, selecione outro intervalo e use <strong>Adicionar à Área de Impressão</strong> (intervalos separados saem em páginas separadas). <strong>Limpar Área de Impressão</strong> volta ao padrão. A área fica salva com a planilha e aparece como um nome definido (Área de impressão, com sublinhados no lugar dos espaços) no Gerenciador de Nomes.',
            img: { src: `${XL_IMG}/m15/definir-area-impressao.jpg`, alt: 'Menu Área de Impressão com Definir Área de Impressão', caption: 'Layout da Página > Área de Impressão > Definir Área de Impressão.', source: `${SUP}/excel/set-or-clear-a-print-area-on-a-worksheet` } },
          { h: 'Imprimir Títulos',
            p: 'Numa lista de 500 linhas, só a primeira página teria o cabeçalho. Layout da Página > <strong>Imprimir Títulos</strong> abre a guia Planilha da caixa Configurar Página: em <strong>Linhas a repetir na parte superior</strong>, selecione a linha (ou linhas) de cabeçalho; em <strong>Colunas a repetir à esquerda</strong>, as colunas de identificação (em tabelas largas). Elas passam a sair em todas as páginas. Não confunda com a opção Títulos em Opções de Planilha, que imprime as letras das colunas e os números das linhas.',
            img: { src: `${XL_IMG}/m15/imprimir-titulos.png`, alt: 'Botão Imprimir Títulos no grupo Configurar Página', caption: 'Layout da Página > Configurar Página > Imprimir Títulos.', source: `${SUP}/excel/print-rows-with-column-headers-on-top-of-every-page` } },
          { h: 'Dimensionar para Ajustar',
            p: 'No grupo <strong>Dimensionar para Ajustar</strong>, <strong>Largura</strong> e <strong>Altura</strong> dizem em quantas páginas o conteúdo deve caber: Largura 1 página e Altura Automático é a configuração clássica — todas as colunas numa folha de largura, quantas folhas forem necessárias para baixo. <strong>Escala</strong> define um percentual fixo (só editável com Largura e Altura em Automático). Na caixa Configurar Página, guia Página, as mesmas opções aparecem como Ajustar para e Ajustar para X página(s) de largura por Y de altura. Lembre: com Ajustar para páginas, as quebras manuais são ignoradas.',
            img: { src: `${XL_IMG}/m15/dimensionar-ajustar.png`, alt: 'Grupo Dimensionar para Ajustar', caption: 'Largura, Altura e Escala.', source: `${SUP}/excel/scale-a-worksheet` } },
          { h: 'Opções de Planilha e a guia Planilha',
            items: [
              '<strong>Linhas de Grade: Imprimir</strong> — por padrão, as linhas de grade não são impressas; marque para imprimir (ou aplique bordas).',
              '<strong>Títulos: Imprimir</strong> — imprime letras de colunas e números de linhas (útil para revisar fórmulas no papel).',
              'Na guia Planilha da caixa Configurar Página: <strong>Comentários e anotações</strong> (Nenhum, No final da planilha, Como exibido), <strong>Erros de célula como</strong> (exibido, em branco, traços ou N/D), <strong>Qualidade de rascunho</strong>, <strong>Preto e branco</strong> e a <strong>Ordem da página</strong> (Abaixo e depois acima ou Acima e depois abaixo).'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              '"Configure a planilha para imprimir em paisagem, em uma página de largura" — Orientação + Largura 1 página.',
              '"Defina a área de impressão como A1:H40" / "Repita a linha 3 no topo de cada página impressa".',
              '"Centralize horizontalmente na página" — Margens Personalizadas.',
              'Tarefas de configuração de página valem para a planilha ativa; se pedirem para várias planilhas, agrupe as guias (Ctrl+clique) antes — e desagrupe depois.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Definir ou limpar uma área de impressão', u: `${SUP}/excel/set-or-clear-a-print-area-on-a-worksheet` },
          { t: 'Microsoft Suporte — Imprimir linhas com cabeçalhos em todas as páginas', u: `${SUP}/excel/print-rows-with-column-headers-on-top-of-every-page` },
          { t: 'Microsoft Suporte — Dimensionar uma planilha', u: `${SUP}/excel/scale-a-worksheet` },
          { t: 'Microsoft Suporte — Definir margens da página', u: `${SUP}/excel/set-page-margins-before-printing-a-worksheet` },
          { t: 'Microsoft Suporte — Imprimir linhas de grade', u: `${SUP}/excel/print-gridlines-in-a-worksheet` }
        ]
      },
      {
        id: 'xl-cabecalho-imprimir', title: 'Cabeçalho, rodapé e as configurações de impressão',
        desc: 'Cabeçalhos e rodapés prontos e personalizados com número de página, data, nome do arquivo e da planilha; primeira página diferente; a tela Imprimir e suas opções.',
        objetivos: [
          'Inserir e personalizar cabeçalhos e rodapés com elementos automáticos',
          'Usar primeira página diferente e páginas pares e ímpares diferentes',
          'Configurar a impressão: o que imprimir, páginas, cópias e dimensionamento'
        ],
        body: 'Página 3 de 12, o nome do relatório, a data de emissão: é o cabeçalho e o rodapé que tornam um impresso ou PDF profissional — e evitam folhas soltas sem identificação. "Personalizar cabeçalhos e rodapés" é habilidade da prova Associate.',
        content: [
          { h: 'Inserir cabeçalho e rodapé',
            items: [
              'Inserir > Texto > <strong>Cabeçalho e Rodapé</strong> muda para o modo Layout da Página e posiciona o cursor no cabeçalho, que tem três seções: esquerda, centro e direita. Clique numa seção e digite.',
              'A guia <strong>Cabeçalho e Rodapé</strong> (contextual) oferece cabeçalhos e rodapés prontos e os <strong>elementos</strong>: Número de Página, Número de Páginas, Data Atual, Hora Atual, Caminho do Arquivo, Nome do Arquivo, Nome da Planilha e Imagem (um logotipo, com Formatar Imagem para ajustar).',
              'Os elementos são códigos que se atualizam na impressão — não digite o número da página à mão.',
              'Ir para Rodapé / Ir para Cabeçalho alternam entre os dois. Para sair, clique numa célula e volte ao modo Normal.',
              'Também dá para editar pela caixa Configurar Página, guia Cabeçalho/Rodapé, com Personalizar Cabeçalho e Personalizar Rodapé — a forma usada para planilhas de gráfico.'
            ],
            code: 'Rodapé centro:  Página &[Página] de &[Páginas]\nCabeçalho esquerda:  &[Guia]          (nome da planilha)\nCabeçalho direita:  &[Data]',
            img: { src: `${XL_IMG}/m15/guia-cabecalho-rodape.png`, alt: 'Guia Cabeçalho e Rodapé com os elementos', caption: 'A guia contextual Cabeçalho e Rodapé e seus elementos.', source: `${SUP}/excel/headers-and-footers-in-a-worksheet` } },
          { h: 'Opções de cabeçalho e rodapé',
            items: [
              '<strong>Primeira Página Diferente</strong> — a capa do relatório sem cabeçalho, ou com outro cabeçalho.',
              '<strong>Diferentes em Páginas Pares e Ímpares</strong> — números de página alternando à direita e à esquerda para impressão frente e verso.',
              '<strong>Dimensionar com Documento</strong> — o cabeçalho acompanha a escala de impressão da planilha.',
              '<strong>Alinhar com Margens da Página</strong> — as seções esquerda e direita alinham com as margens.'
            ],
            img: { src: `${XL_IMG}/m15/cabecalho-personalizado.png`, alt: 'Caixa Cabeçalho personalizado com as três seções', caption: 'Cabeçalho personalizado: seções esquerda, central e direita, com botões para cada elemento.', source: `${SUP}/excel/headers-and-footers-in-a-worksheet` } },
          { h: 'A tela Imprimir',
            p: 'Arquivo > <strong>Imprimir</strong> reúne a visualização e as configurações:',
            items: [
              '<strong>O que imprimir</strong> — Imprimir Planilhas Ativas (as selecionadas; Ctrl+clique nas guias para várias), Imprimir Pasta de Trabalho Inteira ou <strong>Imprimir Seleção</strong>. Com uma tabela selecionada, aparece Imprimir Tabela Selecionada. A opção <strong>Ignorar Área de Impressão</strong> imprime tudo mesmo com área definida.',
              '<strong>Páginas</strong> de/até, número de <strong>Cópias</strong>, <strong>Agrupado</strong> (1,2,3 1,2,3) ou desagrupado, e frente e verso (se a impressora aceitar).',
              'Orientação, tamanho do papel, margens e <strong>dimensionamento</strong> (Sem Dimensionamento, Ajustar Planilha em Uma Página, Ajustar Todas as Colunas em Uma Página, Ajustar Todas as Linhas em Uma Página) — os mesmos da guia Layout da Página.',
              '<strong>Configurar Página</strong>, no fim da lista, abre a caixa completa. O botão Mostrar Margens, na visualização, permite arrastar as margens.',
              'Para PDF, escolha a impressora Microsoft Print to PDF ou use Salvar Como > PDF (Módulo 01).'
            ],
            img: { src: `${XL_IMG}/m15/configuracoes-impressao.png`, alt: 'Configurações da tela Imprimir', caption: 'Arquivo > Imprimir > Configurações: planilhas ativas, pasta inteira ou seleção.', source: `${SUP}/excel/get-started/print-a-worksheet-or-workbook` } },
          { h: 'Como isso cai na prova',
            items: [
              '"Adicione um rodapé com o nome do arquivo à esquerda e o número da página à direita" — elementos Nome do Arquivo e Número de Página nas seções certas.',
              '"Configure para que o cabeçalho não apareça na primeira página" — Primeira Página Diferente.',
              '"Configure a impressão para imprimir a pasta de trabalho inteira" — a prova confere a configuração, não o papel.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Cabeçalhos e rodapés em uma planilha', u: `${SUP}/excel/headers-and-footers-in-a-worksheet` },
          { t: 'Microsoft Suporte — Imprimir uma planilha ou pasta de trabalho', u: `${SUP}/excel/get-started/print-a-worksheet-or-workbook` }
        ]
      },
      {
        id: 'xl-colaboracao-versoes', title: 'Comentários, anotações, coautoria e versões',
        desc: 'Comentários encadeados e anotações, compartilhar e editar ao mesmo tempo, histórico de versões, AutoRecuperação e recuperar pastas não salvas.',
        objetivos: [
          'Usar comentários encadeados e anotações, com menções e resolução',
          'Compartilhar uma pasta de trabalho e trabalhar em coautoria',
          'Gerenciar versões: histórico, AutoRecuperação e pastas não salvas'
        ],
        body: 'Planilhas raramente são obra de uma pessoa só. O Excel do Microsoft 365 permite conversar dentro das células, editar a mesma pasta ao mesmo tempo que os colegas e voltar para uma versão de ontem quando algo dá errado. "Gerenciar versões de pastas de trabalho" está na prova Expert; comentários e compartilhamento completam o trabalho colaborativo.',
        content: [
          { h: 'Comentários x anotações',
            items: [
              '<strong>Comentário</strong> (encadeado) — uma conversa: botão direito > <strong>Novo Comentário</strong> (ou Revisão > Novo Comentário). Os outros respondem no mesmo fio. Digite a arroba e o nome de alguém para <strong>mencioná-lo</strong>: a pessoa recebe um e-mail. Quando o assunto termina, <strong>Resolver thread</strong> encerra a conversa (ela continua visível e pode ser reaberta).',
              '<strong>Anotação</strong> — o antigo "comentário": um bilhete amarelo, sem respostas, para explicar uma célula. Botão direito > <strong>Nova Anotação</strong> ou <strong>Shift+F2</strong>. Em Revisão > Anotações: Mostrar/Ocultar, Mostrar Todas as Anotações e Converter em Comentários.',
              'Células com comentário têm um marcador roxo no canto; com anotação, um triângulo vermelho.',
              'Revisão > <strong>Mostrar Comentários</strong> abre o painel com todos os fios da planilha. Excluir fica no mesmo grupo (ou botão direito > Excluir Comentário).'
            ],
            img: { src: `${XL_IMG}/m15/comentario-encadeado.png`, alt: 'Célula com um comentário encadeado e resposta', caption: 'Comentário encadeado: conversa com respostas dentro da célula.', source: `${SUP}/excel/the-difference-between-threaded-comments-and-notes` } },
          { h: 'A anotação',
            img: { src: `${XL_IMG}/m15/anotacao.png`, alt: 'Célula com uma anotação', caption: 'Anotação: um bilhete sem respostas.', source: `${SUP}/excel/the-difference-between-threaded-comments-and-notes` } },
          { h: 'Compartilhar e coautoria',
            items: [
              'Salve a pasta no <strong>OneDrive</strong> ou no <strong>SharePoint</strong> e use o botão <strong>Compartilhar</strong> (canto superior direito): convide pessoas por e-mail ou copie um link, escolhendo se podem <strong>editar</strong> ou só <strong>exibir</strong>.',
              'Com o arquivo na nuvem, várias pessoas editam ao mesmo tempo (<strong>coautoria</strong>): as iniciais de quem está no arquivo aparecem no alto, e a célula que cada um está editando fica destacada com a cor da pessoa. O AutoSalvamento precisa estar ligado.',
              'Recursos antigos, como a "pasta de trabalho compartilhada" dos Excel antigos, foram substituídos pela coautoria.',
              '<strong>Modos de exibição de planilha</strong> (Exibir > Modos de Exibição de Planilha) deixam cada pessoa filtrar e classificar sem atrapalhar a tela dos outros.'
            ] },
          { h: 'Versões',
            items: [
              '<strong>Histórico de Versões</strong> — para arquivos no OneDrive ou SharePoint: clique no nome do arquivo na barra de título (ou Arquivo > Informações > Histórico de Versões). Abra uma versão antiga em outra janela para comparar e use <strong>Restaurar</strong> para voltar a ela.',
              '<strong>AutoRecuperação</strong> — para arquivos locais: em Arquivo > Opções > Salvar, <strong>Salvar informações de AutoRecuperação a cada X minutos</strong> e <strong>Manter a última versão AutoRecuperada se eu fechar sem salvar</strong>. Se o Excel travar, o painel Recuperação de Documentos aparece ao reabrir.',
              '<strong>Gerenciar Pasta de Trabalho</strong> (Arquivo > Informações) — lista versões salvas automaticamente, incluindo a rotulada "quando fechei sem salvar", e oferece <strong>Recuperar Pastas de Trabalho Não Salvas</strong>.'
            ] },
          { h: 'Como isso cai na prova',
            items: [
              '"Adicione a anotação Conferir com o financeiro à célula D8" — Nova Anotação (não Novo Comentário, a menos que a tarefa diga comentário).',
              '"Responda ao comentário da célula B4" / "Resolva o comentário".',
              '"Configure o Excel para salvar informações de AutoRecuperação a cada 5 minutos" — Opções > Salvar.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Comentários encadeados e anotações', u: `${SUP}/excel/the-difference-between-threaded-comments-and-notes` },
          { t: 'Microsoft Suporte — Inserir comentários e anotações', u: `${SUP}/excel/insert-comments-and-notes-in-excel` },
          { t: 'Microsoft Suporte — Coautoria em pastas de trabalho', u: `${SUP}/excel/get-started/collaborate-on-excel-workbooks-at-the-same-time-with-co-authoring` },
          { t: 'Microsoft Suporte — Compartilhar a pasta de trabalho', u: `${SUP}/excel/get-started/share-your-excel-workbook-with-others` },
          { t: 'Microsoft Suporte — Exibir versões anteriores de arquivos do Office', u: `${SUP}/office/collab-files/view-previous-versions-of-office-files` },
          { t: 'Microsoft Suporte — Recuperar uma versão anterior de um arquivo do Office', u: `${SUP}/office/collab-files/recover-an-earlier-version-of-an-office-file` }
        ]
      },
      {
        id: 'xl-proteger', title: 'Proteger planilhas, intervalos, estrutura e arquivo',
        desc: 'Bloquear e desbloquear células, proteger a planilha escolhendo o que os usuários podem fazer, permitir edição de intervalos, proteger a estrutura, criptografar com senha, senha de gravação e Marcar como Final.',
        objetivos: [
          'Proteger uma planilha deixando só as células de entrada editáveis, e ocultar fórmulas',
          'Permitir edição de intervalos e proteger a estrutura da pasta de trabalho',
          'Diferenciar proteção de planilha, de pasta e de arquivo'
        ],
        body: 'Proteção no Excel tem três camadas, e confundir uma com a outra é o erro mais comum: proteger a planilha impede alterar células; proteger a pasta impede mexer nas planilhas (inserir, excluir, reexibir); proteger o arquivo impede abrir. "Restringir edição", "proteger planilhas e intervalos" e "proteger a estrutura da pasta de trabalho" são habilidades da prova Expert.',
        content: [
          { h: 'Bloqueado e Oculto',
            p: 'Toda célula nasce com a propriedade <strong>Bloqueado</strong> marcada (Formatar Células > guia <strong>Proteção</strong>), mas isso só vale quando a planilha é protegida. Por isso a proteção é em duas etapas: primeiro <strong>desmarque Bloqueado</strong> nas células de entrada (onde os usuários vão digitar); depois proteja a planilha. A caixa <strong>Oculto</strong> na mesma guia esconde a fórmula da barra de fórmulas quando a planilha estiver protegida (o resultado continua visível).',
            img: { src: `${XL_IMG}/m15/protecao-formatar-celulas.png`, alt: 'Guia Proteção da caixa Formatar Células', caption: 'Formatar Células > Proteção: Bloqueado e Oculto.', source: `${SUP}/excel/protect-a-worksheet` } },
          { h: 'Proteger Planilha',
            p: 'Revisão > <strong>Proteger Planilha</strong>. A senha é opcional (sem ela, qualquer um desprotege). A lista <strong>Permitir que todos os usuários desta planilha possam</strong> define exceções: selecionar células bloqueadas e desbloqueadas (marcadas por padrão), formatar células, colunas e linhas, inserir e excluir colunas e linhas, inserir hiperlinks, classificar, usar AutoFiltro, usar tabela e gráfico dinâmicos, editar objetos e cenários. Em planilha protegida, Tab pula de uma célula desbloqueada para a próxima — um formulário improvisado. <strong>Desproteger Planilha</strong> pede a senha.',
            img: { src: `${XL_IMG}/m15/proteger-planilha-caixa.png`, alt: 'Caixa Proteger Planilha com a lista de permissões', caption: 'Proteger Planilha: senha opcional e o que os usuários ainda podem fazer (imagem original em inglês).', source: `${SUP}/excel/protect-a-worksheet` } },
          { h: 'Permitir Edição de Intervalos',
            p: 'Para liberar intervalos diferentes para pessoas diferentes numa planilha protegida: Revisão > <strong>Permitir Edição de Intervalos</strong> (com a planilha desprotegida) > <strong>Novo</strong>: dê um título, informe o intervalo e, opcionalmente, uma <strong>senha do intervalo</strong> (quem souber edita aquele trecho) ou permissões de usuários do Windows/domínio. Depois proteja a planilha — o botão Proteger Planilha está na mesma caixa.' },
          { h: 'Proteger Pasta de Trabalho (estrutura)',
            p: 'Revisão > <strong>Proteger Pasta de Trabalho</strong>, com a caixa <strong>Estrutura</strong> marcada e senha opcional: ninguém insere, exclui, renomeia, move, copia, oculta ou reexibe planilhas. É a forma de uma planilha oculta ficar realmente oculta (Módulo 01). O conteúdo das células continua editável — para isso, proteja também as planilhas.' },
          { h: 'Proteger o arquivo',
            items: [
              '<strong>Criptografar com Senha</strong> — Arquivo > Informações > Proteger Pasta de Trabalho > Criptografar com Senha: sem a senha, o arquivo não abre. É a única das camadas que é segurança de verdade. Se a senha for perdida, a Microsoft não recupera.',
              '<strong>Senha de gravação</strong> — Salvar Como > Mais opções > <strong>Ferramentas</strong> > <strong>Opções Gerais</strong>: Senha de proteção (para abrir), <strong>Senha de gravação</strong> (sem ela, o arquivo abre só como leitura) e <strong>Recomendável somente leitura</strong> (o Excel sugere abrir como leitura, mas a pessoa pode recusar).',
              '<strong>Marcar como Final</strong> — Proteger Pasta de Trabalho > Marcar como Final: o arquivo abre como somente leitura com uma barra avisando que é a versão final. Qualquer um clica em Editar Mesmo Assim; é um aviso, não uma trava.',
              '<strong>Sempre Abrir Somente Leitura</strong>, no mesmo menu, tem efeito parecido.'
            ] },
          { h: 'Proteção não é segurança',
            p: 'Proteger planilha e estrutura evita alterações acidentais e organiza o uso, mas senhas de planilha são fracas e existem ferramentas que as removem. Dados confidenciais pedem arquivo criptografado e permissões de acesso no OneDrive/SharePoint, não só proteção de planilha.' },
          { h: 'Como isso cai na prova',
            items: [
              '"Proteja a planilha permitindo que os usuários editem apenas B2:B20 e usem o AutoFiltro" — desbloqueie B2:B20, proteja e marque Usar AutoFiltro.',
              '"Oculte as fórmulas da coluna F" — Oculto na guia Proteção + proteger a planilha.',
              '"Impeça que os usuários adicionem ou excluam planilhas" — Proteger Pasta de Trabalho (estrutura).',
              '"Marque a pasta de trabalho como final" / "Exija senha para modificar o arquivo" — Informações e Opções Gerais.'
            ] }
        ],
        recursos: [
          { t: 'Microsoft Suporte — Proteger uma planilha', u: `${SUP}/excel/protect-a-worksheet` },
          { t: 'Microsoft Suporte — Bloquear ou desbloquear áreas de uma planilha protegida', u: `${SUP}/excel/get-started/lock-or-unlock-specific-areas-of-a-protected-worksheet` },
          { t: 'Microsoft Suporte — Proteger uma pasta de trabalho', u: `${SUP}/excel/protect-a-workbook` },
          { t: 'Microsoft Suporte — Proteger um arquivo do Excel', u: `${SUP}/excel/get-started/protect-an-excel-file` },
          { t: 'Microsoft Suporte — Restringir alterações a arquivos no Excel', u: `${SUP}/excel/restrict-changes-to-files-in-excel` },
          { t: 'Microsoft Suporte — Evitar alterações na versão final de um arquivo', u: `${SUP}/office/collab-files/help-prevent-changes-to-a-final-version-of-a-file` }
        ]
      }
    ]
  }
];
