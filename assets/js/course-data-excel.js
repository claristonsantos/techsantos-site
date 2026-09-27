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
  }
];
