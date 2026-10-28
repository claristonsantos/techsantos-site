// Curso de Python do zero até Python para dados (pandas, gráficos e automação de planilhas) — TECH SANTOS BR.
// Mesmo formato do curso de Inglês: teoria em português, prática interativa (assets/js/pratica.js,
// tipos escolha/lacuna com `codigo`, ordenar e pares) e o laboratório de Python
// (assets/js/python-lab.js): os blocos `code` da aula ganham "▶ Executar" e cada aula
// tem desafios de cenário (`desafios`) em que o aluno escreve o script e o site confere.
// O Python roda no navegador do aluno (Pyodide); nada é executado no servidor.
// Testes dos desafios: código Python executado depois do script do aluno, no mesmo
// escopo (enxerga as variáveis dele), mais `saida` (tudo o que ele imprimiu) e `linhas`.
// Ids de aula com prefixo "py-" para não colidir com o progresso dos outros cursos.
const COURSE = [
  {
    id: 'py-m01', title: 'Módulo 01 · Primeiros passos: print, variáveis, tipos e operações', kind: 'video',
    lessons: [
      {
        id: 'py-primeiro-codigo', title: 'O que é Python e o seu primeiro código',
        desc: 'Por que Python virou a linguagem dos dados, como funciona o laboratório do curso e os primeiros comandos: print e comentários.',
        objetivos: [
          'Entender por que Python é a linguagem mais usada em análise de dados',
          'Executar código no laboratório do curso, direto no navegador',
          'Usar print para mostrar resultados e # para comentar'
        ],
        body: 'Python é a linguagem de programação mais popular do mundo para dados: com ela você lê planilhas gigantes, limpa dados, faz contas que o Excel não aguenta, gera gráficos e automatiza relatórios. E é uma das mais fáceis de aprender, porque o código parece quase inglês. Neste curso você não precisa instalar nada: o Python roda aqui mesmo, no seu navegador.',
        content: [
          { h: 'Por que Python para dados?',
            items: [
              'É gratuito e roda em qualquer computador — e nas ferramentas que você já conhece: o Excel do Microsoft 365 e o Power BI aceitam scripts em Python.',
              'Tem bibliotecas prontas para tudo: <strong>pandas</strong> para tabelas, <strong>matplotlib</strong> para gráficos, <strong>openpyxl</strong> para planilhas Excel.',
              'Automatiza o trabalho repetitivo: juntar 50 planilhas, limpar uma base todo mês, gerar o mesmo relatório toda segunda.'
            ] },
          { h: 'O primeiro comando: print',
            p: 'O <code>print</code> mostra uma informação na tela. O texto vai entre aspas (simples ou duplas). Clique em <strong>▶ Executar</strong> embaixo de cada bloco de código para ver o resultado — e depois mude o texto e execute de novo: é assim que se aprende a programar.',
            code: 'print("Olá, mundo!")\nprint("Estou aprendendo Python")' },
          { h: 'Números não precisam de aspas',
            p: 'Com números o Python faz a conta antes de mostrar. Repare na diferença: com aspas é texto; sem aspas é número.',
            code: 'print(2 + 3)\nprint("2 + 3")' },
          { h: 'Comentários com #',
            p: 'Tudo o que vem depois de <code>#</code> numa linha é ignorado pelo Python. Use comentários para explicar o que o código faz — para os outros e para você daqui a um mês.',
            code: '# Este programa mostra o faturamento do dia\nprint(1500)  # valor em reais' },
          { h: 'Como funciona o laboratório',
            items: [
              'Os blocos de código da aula têm o botão <strong>▶ Executar</strong>: o resultado aparece logo abaixo.',
              'No fim de cada aula há <strong>desafios</strong>: um cenário real, um editor de código e o botão <strong>✓ Verificar</strong>, que confere se o seu script chegou no resultado certo.',
              'Na primeira execução o Python leva alguns segundos para carregar. Depois fica rápido.',
              'Errou? Leia a mensagem de erro: ela diz o tipo do problema e a linha. Errar faz parte — é o jeito mais rápido de aprender.'
            ] }
        ],
        pratica: [
          { t: 'escolha', q: 'Qual comando mostra o texto Olá na tela?', op: ['print("Olá")', 'show("Olá")', 'mostrar(Olá)'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(10 + 5)', op: ['15', '10 + 5', '"15"'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print("10 + 5")', op: ['10 + 5', '15', 'Erro'], a: 0, exp: 'Entre aspas é texto: o Python mostra exatamente o que está escrito, sem fazer a conta.' },
          { t: 'escolha', q: 'Para que serve o # no Python?', op: ['Marcar um comentário, que o Python ignora', 'Fazer uma conta', 'Mostrar um número na tela'], a: 0 },
          { t: 'lacuna', codigo: true, frase: '___("Bom dia")', op: ['print', 'Print', 'echo'], a: 0, pt: 'Mostre "Bom dia" na tela.', exp: 'Python diferencia maiúsculas de minúsculas: é print, tudo minúsculo.' },
          { t: 'pares', pares: [['print', 'mostra na tela'], ['#', 'comentário'], ['"texto"', 'um texto (string)'], ['pandas', 'biblioteca de tabelas'], ['matplotlib', 'biblioteca de gráficos']] },
          { t: 'ordenar', q: 'Monte o programa que mostra o título e depois o valor.', linhas: ['# relatório do dia', 'print("Faturamento")', 'print(1500)'] },
          { t: 'escolha', q: 'O que este código mostra?', codigo: '# print("A")\nprint("B")', op: ['B', 'A e B', 'A'], a: 0 }
        ],
        desafios: [
          { titulo: 'Seu cartão de visita',
            cenario: 'Escreva um programa que mostre, em duas linhas separadas, o texto <code>Meu nome é</code> seguido do seu nome (ex.: <code>Meu nome é Ana</code>) e depois o texto <code>Estou aprendendo Python</code>.',
            inicial: '# Escreva seu código abaixo\n',
            testes: [
              { py: "assert len(linhas) >= 2", msg: 'O programa mostra pelo menos duas linhas' },
              { py: "assert linhas[0].startswith('Meu nome é')", msg: 'A primeira linha começa com "Meu nome é"' },
              { py: "assert 'Estou aprendendo Python' in linhas[1]", msg: 'A segunda linha diz "Estou aprendendo Python"' }
            ],
            dicas: ['Você vai precisar de dois comandos print, um em cada linha.', 'O texto vai entre aspas: print("Meu nome é Ana")'],
            solucao: 'print("Meu nome é Ana")\nprint("Estou aprendendo Python")' }
        ]
      },
      {
        id: 'py-variaveis-tipos', title: 'Variáveis e tipos de dados',
        desc: 'Como guardar valores com nomes (variáveis) e os quatro tipos básicos: int, float, str e bool.',
        objetivos: [
          'Criar variáveis e usá-las em contas',
          'Reconhecer os tipos int, float, str e bool com type()',
          'Dar bons nomes às variáveis'
        ],
        body: 'Uma variável é uma caixinha com nome onde você guarda um valor para usar depois. É o que permite escrever "preço vezes quantidade" em vez de repetir números soltos — e mudar um valor num lugar só. Cada valor tem um tipo, e o tipo decide o que dá para fazer com ele.',
        content: [
          { h: 'Criando variáveis',
            p: 'Use o sinal de <code>=</code> para guardar um valor num nome. O <code>=</code> aqui não é "igual" da matemática: é "guarde isto aqui".',
            code: 'preco = 25.90\nquantidade = 3\ntotal = preco * quantidade\nprint(total)' },
          { h: 'Os quatro tipos básicos',
            items: [
              '<code>int</code> — número inteiro: <code>3</code>, <code>-10</code>, <code>2026</code>.',
              '<code>float</code> — número com casas decimais, sempre com <strong>ponto</strong>: <code>25.90</code> (nunca vírgula).',
              '<code>str</code> — texto (string), entre aspas: <code>"Goiânia"</code>.',
              '<code>bool</code> — verdadeiro ou falso: <code>True</code> e <code>False</code>, com inicial maiúscula.'
            ],
            code: 'cidade = "Goiânia"\nano = 2026\nnota = 9.5\naprovado = True\nprint(type(cidade), type(ano), type(nota), type(aprovado))' },
          { h: 'Variáveis mudam de valor',
            p: 'Uma variável pode receber um novo valor a qualquer momento — inclusive calculado a partir dela mesma.',
            code: 'estoque = 100\nestoque = estoque - 30\nprint(estoque)' },
          { h: 'Boas práticas de nomes',
            items: [
              'Use letras minúsculas e <code>_</code> para separar palavras: <code>valor_total</code>, <code>data_venda</code>.',
              'Nada de espaço, acento é permitido mas evite, e não comece com número: <code>2ano</code> dá erro.',
              'Nomes que explicam: <code>faturamento_mensal</code> é melhor que <code>x</code>.'
            ] }
        ],
        pratica: [
          { t: 'escolha', q: 'Qual é o tipo de 25.90?', op: ['float', 'int', 'str'], a: 0 },
          { t: 'escolha', q: 'Qual é o tipo de "2026"?', op: ['str', 'int', 'float'], a: 0, exp: 'Entre aspas é sempre texto (str), mesmo que pareça número.' },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'preco = 10\nqtd = 3\nprint(preco * qtd)', op: ['30', 'preco * qtd', '103'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'estoque = 50\nestoque = estoque - 20\nprint(estoque)', op: ['30', '50', '20'], a: 0 },
          { t: 'escolha', q: 'Qual nome de variável é válido e bem escrito?', op: ['valor_total', 'valor total', '2valor'], a: 0 },
          { t: 'escolha', q: 'Como escrever dois e meio em Python?', op: ['2.5', '2,5', '"2,5"'], a: 0, exp: 'Em Python o separador decimal é o ponto, como no inglês.' },
          { t: 'lacuna', codigo: true, frase: 'aprovado = ___', op: ['True', 'true', '"Verdadeiro"'], a: 0, pt: 'Guarde o valor verdadeiro na variável.' },
          { t: 'pares', pares: [['int', 'número inteiro'], ['float', 'número decimal'], ['str', 'texto'], ['bool', 'verdadeiro ou falso'], ['type()', 'mostra o tipo']] },
          { t: 'ordenar', q: 'Monte o código que calcula e mostra o total.', linhas: ['preco = 25.90', 'quantidade = 3', 'total = preco * quantidade', 'print(total)'] }
        ],
        desafios: [
          { titulo: 'O pedido da papelaria',
            cenario: 'Um cliente comprou <strong>4 cadernos</strong> de <strong>R$ 18,50</strong> cada. Crie as variáveis <code>preco</code> e <code>quantidade</code>, calcule o valor na variável <code>total</code> e mostre o total com <code>print</code>.',
            inicial: 'preco = \nquantidade = \n',
            testes: [
              { py: 'assert preco == 18.5', msg: 'A variável preco vale 18.5 (com ponto!)' },
              { py: 'assert quantidade == 4', msg: 'A variável quantidade vale 4' },
              { py: 'assert abs(total - 74.0) < 0.001', msg: 'A variável total está correta' }
            ],
            dicas: ['Decimal em Python usa ponto: 18.5', 'O total é preco * quantidade, guardado em uma variável chamada total.'],
            solucao: 'preco = 18.5\nquantidade = 4\ntotal = preco * quantidade\nprint(total)' }
        ]
      },
      {
        id: 'py-operacoes', title: 'Operações e textos: contas, f-strings e arredondamento',
        desc: 'Os operadores matemáticos (incluindo //, % e **), arredondamento com round e como montar textos com f-strings.',
        objetivos: [
          'Usar os operadores + - * / // % **',
          'Arredondar com round',
          'Montar textos com variáveis usando f-strings e formatação de números'
        ],
        body: 'Python é uma calculadora poderosa — e o melhor: ele junta as contas com textos para montar mensagens e relatórios. As f-strings são a forma moderna e mais legível de colocar variáveis dentro de um texto.',
        content: [
          { h: 'Operadores',
            items: [
              '<code>+</code> soma, <code>-</code> subtração, <code>*</code> multiplicação, <code>/</code> divisão (sempre dá float).',
              '<code>//</code> divisão inteira: <code>17 // 5</code> é <code>3</code>.',
              '<code>%</code> resto da divisão: <code>17 % 5</code> é <code>2</code> — útil para saber se um número é par (<code>n % 2 == 0</code>).',
              '<code>**</code> potência: <code>2 ** 3</code> é <code>8</code>.'
            ],
            code: 'print(17 / 5)\nprint(17 // 5)\nprint(17 % 5)\nprint(2 ** 3)' },
          { h: 'Arredondando',
            p: 'Contas com decimais podem gerar muitas casas. Use <code>round(valor, casas)</code>.',
            code: 'media = 47 / 6\nprint(media)\nprint(round(media, 2))' },
          { h: 'f-strings: texto com variáveis',
            p: 'Coloque um <code>f</code> antes das aspas e as variáveis entre chaves <code>{ }</code>. Depois de <code>:</code> dá para formatar: <code>.2f</code> = duas casas decimais; <code>,.2f</code> = com separador de milhar.',
            code: 'cliente = "Ana"\ntotal = 1234.5\nprint(f"Cliente: {cliente}")\nprint(f"Total: R$ {total:.2f}")\nprint(f"Total: R$ {total:,.2f}")' },
          { h: 'Juntando textos',
            p: 'O <code>+</code> também junta textos, mas só texto com texto. Para misturar número e texto, use f-string (ou converta com <code>str()</code>).',
            code: 'nome = "Tech" + " " + "Santos"\nprint(nome)\nano = 2026\nprint("Ano: " + str(ano))' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(17 // 5)', op: ['3', '3.4', '2'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(17 % 5)', op: ['2', '3', '3.4'], a: 0, exp: '% é o resto da divisão: 17 dividido por 5 dá 3 e sobra 2.' },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(2 ** 4)', op: ['16', '8', '6'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'x = 10\nprint(f"Valor: {x}")', op: ['Valor: 10', 'Valor: {x}', 'f"Valor: 10"'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'v = 3.14159\nprint(round(v, 2))', op: ['3.14', '3.1', '3'], a: 0 },
          { t: 'escolha', q: 'Qual linha dá erro?', op: ['print("Ano: " + 2026)', 'print(f"Ano: {2026}")', 'print("Ano: " + str(2026))'], a: 0, exp: 'O + não junta texto com número. Use f-string ou str().' },
          { t: 'lacuna', codigo: true, frase: 'print(f"Total: R$ {total:___}")', op: ['.2f', '2.f', '%2'], a: 0, pt: 'Mostre o total com duas casas decimais.' },
          { t: 'pares', pares: [['//', 'divisão inteira'], ['%', 'resto da divisão'], ['**', 'potência'], ['round()', 'arredondar'], ['f"{x}"', 'variável dentro do texto']] },
          { t: 'ordenar', q: 'Monte o código que calcula a média e mostra com duas casas.', linhas: ['soma = 47', 'media = soma / 6', 'print(f"Média: {media:.2f}")'] }
        ],
        desafios: [
          { titulo: 'O resumo do caixa',
            cenario: 'O caixa da loja vendeu <strong>R$ 2.345,60</strong> em <strong>37 vendas</strong>. Calcule o ticket médio (faturamento dividido pelo número de vendas) na variável <code>ticket</code> e mostre exatamente a linha <code>Ticket médio: R$ 63.39</code> usando uma f-string com duas casas decimais.',
            inicial: 'faturamento = 2345.60\nvendas = 37\n',
            testes: [
              { py: 'assert abs(ticket - 2345.60 / 37) < 0.001', msg: 'A variável ticket está correta' },
              { py: "assert 'Ticket médio: R$ 63.39' in saida", msg: 'O programa mostra "Ticket médio: R$ 63.39"' }
            ],
            dicas: ['ticket = faturamento / vendas', 'Para duas casas numa f-string: {ticket:.2f}'],
            solucao: 'faturamento = 2345.60\nvendas = 37\nticket = faturamento / vendas\nprint(f"Ticket médio: R$ {ticket:.2f}")' }
        ]
      },
      {
        id: 'py-primeiro-script', title: 'Seu primeiro script de dados: o fechamento do mês',
        desc: 'Juntando tudo num script de verdade: variáveis, contas, porcentagens e um relatório formatado.',
        objetivos: [
          'Escrever um script com entrada de dados, cálculo e saída organizada',
          'Calcular variação percentual e margem',
          'Formatar um mini-relatório com f-strings'
        ],
        body: 'Fechando o módulo, você vai escrever o primeiro script com cara de trabalho real: o fechamento do mês de uma empresa. É a mesma lógica de qualquer análise de dados — pegar números, calcular indicadores e apresentar o resultado de forma clara.',
        content: [
          { h: 'A estrutura de um script',
            items: [
              '<strong>Dados</strong>: as variáveis com os valores de entrada.',
              '<strong>Cálculos</strong>: os indicadores, cada um numa variável com nome claro.',
              '<strong>Saída</strong>: o relatório com <code>print</code> e f-strings.'
            ] },
          { h: 'Variação percentual e margem',
            p: 'Variação = (atual − anterior) / anterior × 100. Margem = lucro / receita × 100. Os parênteses garantem a ordem das contas — como na matemática.',
            code: 'receita_atual = 120000\nreceita_anterior = 100000\nvariacao = (receita_atual - receita_anterior) / receita_anterior * 100\nprint(f"Variação: {variacao:.1f}%")' },
          { h: 'O relatório',
            code: 'receita = 120000\ncusto = 84000\nlucro = receita - custo\nmargem = lucro / receita * 100\n\nprint("=== Fechamento de outubro ===")\nprint(f"Receita: R$ {receita:,.2f}")\nprint(f"Custo:   R$ {custo:,.2f}")\nprint(f"Lucro:   R$ {lucro:,.2f}")\nprint(f"Margem:  {margem:.1f}%")' },
          { h: 'E daqui pra frente',
            p: 'Por enquanto os números estão escritos no código. Nos próximos módulos você vai tomar decisões com <code>if</code>, repetir contas com laços, ler arquivos CSV e, a partir do módulo de pandas, trabalhar com milhares de linhas de uma vez — como numa planilha, só que muito mais rápido.' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'atual = 150\nanterior = 100\nprint((atual - anterior) / anterior * 100)', op: ['50.0', '0.5', '150.0'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'receita = 200\nlucro = 50\nprint(f"{lucro / receita * 100:.0f}%")', op: ['25%', '0.25%', '4%'], a: 0 },
          { t: 'escolha', q: 'Por que os parênteses em (atual - anterior) / anterior?', op: ['Para a subtração acontecer antes da divisão', 'Porque Python exige parênteses em toda conta', 'Para transformar o resultado em texto'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'valor = 1234567.891\nprint(f"{valor:,.2f}")', op: ['1,234,567.89', '1.234.567,89', '1234567.89'], a: 0, exp: 'A formatação ,.2f usa o padrão americano: vírgula no milhar e ponto no decimal.' },
          { t: 'ordenar', q: 'Monte o script na ordem lógica: dados, cálculo e saída.', linhas: ['receita = 120000', 'custo = 84000', 'lucro = receita - custo', 'print(f"Lucro: R$ {lucro:,.2f}")'] },
          { t: 'lacuna', codigo: true, frase: 'margem = lucro ___ receita * 100', op: ['/', '//', '%'], a: 0, pt: 'Calcule a margem percentual.' },
          { t: 'pares', pares: [['dados', 'variáveis de entrada'], ['cálculos', 'indicadores'], ['saída', 'print e f-strings'], [':.1f', 'uma casa decimal'], [':,.2f', 'milhar e duas casas']] }
        ],
        desafios: [
          { titulo: 'Fechamento do trimestre',
            cenario: 'A empresa faturou <strong>R$ 380.000</strong> neste trimestre e <strong>R$ 320.000</strong> no trimestre anterior. O custo deste trimestre foi <strong>R$ 247.000</strong>. Calcule nas variáveis <code>lucro</code>, <code>margem</code> (em %) e <code>crescimento</code> (variação % da receita) e mostre um relatório com as três informações.',
            inicial: 'receita = 380000\nreceita_anterior = 320000\ncusto = 247000\n\n# calcule lucro, margem e crescimento\n\n# mostre o relatório\n',
            testes: [
              { py: 'assert lucro == 133000', msg: 'A variável lucro está correta' },
              { py: 'assert abs(margem - 35.0) < 0.01', msg: 'A variável margem (em %) está correta' },
              { py: 'assert abs(crescimento - 18.75) < 0.01', msg: 'A variável crescimento (em %) está correta' },
              { py: "assert len(linhas) >= 3", msg: 'O relatório mostra pelo menos três linhas' }
            ],
            dicas: ['Lucro é receita menos custo.', 'Margem: lucro / receita * 100. Crescimento: (receita - receita_anterior) / receita_anterior * 100 — use parênteses!', 'Para o relatório, três print com f-strings, por exemplo print(f"Margem: {margem:.1f}%")'],
            solucao: 'receita = 380000\nreceita_anterior = 320000\ncusto = 247000\n\nlucro = receita - custo\nmargem = lucro / receita * 100\ncrescimento = (receita - receita_anterior) / receita_anterior * 100\n\nprint(f"Lucro: R$ {lucro:,.2f}")\nprint(f"Margem: {margem:.1f}%")\nprint(f"Crescimento: {crescimento:.2f}%")' }
        ]
      }
    ]
  }
  ,
  {
    id: 'py-m02', title: 'Módulo 02 · Textos: strings, métodos, fatias e limpeza', kind: 'video',
    lessons: [
      {
        id: 'py-strings-basico', title: 'Strings: o básico dos textos',
        desc: 'Como o Python trata textos: aspas, len, índices e fatias para pegar pedaços de um texto.',
        objetivos: [
          'Medir o tamanho de um texto com len',
          'Pegar caracteres por índice, inclusive índices negativos',
          'Recortar pedaços com fatias [inicio:fim]'
        ],
        body: 'Em dados, texto está em todo lugar: nomes de clientes, códigos de produto, e-mails, CPFs. Saber recortar e consultar um texto é o primeiro passo para limpar e organizar essas informações.',
        content: [
          { h: 'Tamanho com len',
            p: '<code>len()</code> conta quantos caracteres um texto tem, incluindo espaços.',
            code: 'produto = "Caderno 10 matérias"\nprint(len(produto))' },
          { h: 'Índices: cada caractere tem uma posição',
            items: [
              'A contagem começa em <strong>0</strong>: o primeiro caractere é <code>texto[0]</code>.',
              'Índices negativos contam do fim: <code>texto[-1]</code> é o último caractere.',
              'Pedir uma posição que não existe dá <code>IndexError</code>.'
            ],
            code: 'codigo = "SP-2026-0042"\nprint(codigo[0])\nprint(codigo[-1])' },
          { h: 'Fatias: [inicio:fim]',
            p: 'A fatia pega do <code>inicio</code> até <strong>antes</strong> do <code>fim</code>. Omitir o início começa do zero; omitir o fim vai até o final.',
            code: 'codigo = "SP-2026-0042"\nprint(codigo[0:2])   # estado\nprint(codigo[3:7])   # ano\nprint(codigo[-4:])   # número do pedido' },
          { h: 'Textos não mudam',
            p: 'Strings são imutáveis: você não altera um caractere, cria um texto novo. Por isso os métodos que você vai ver a seguir sempre <strong>devolvem</strong> um texto novo.' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(len("Python"))', op: ['6', '5', '7'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'p = "Python"\nprint(p[0])', op: ['P', 'y', 'n'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'p = "Python"\nprint(p[-1])', op: ['n', 'P', 'o'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'c = "SP-2026"\nprint(c[3:7])', op: ['2026', '-202', '2026-'], a: 0, exp: 'A fatia vai do índice 3 até antes do 7: posições 3, 4, 5 e 6.' },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'c = "pedido-0042"\nprint(c[-4:])', op: ['0042', '042', 'pedido'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'print(nome[___])  # primeiro caractere', op: ['0', '1', '-0'], a: 0, pt: 'Mostre a primeira letra do nome.' },
          { t: 'pares', pares: [['len(t)', 'tamanho'], ['t[0]', 'primeiro caractere'], ['t[-1]', 'último caractere'], ['t[2:5]', 'fatia'], ['t[:3]', 'três primeiros']] },
          { t: 'ordenar', q: 'Monte o código que separa o ano do código do pedido.', linhas: ['codigo = "SP-2026-0042"', 'ano = codigo[3:7]', 'print(ano)'] }
        ],
        desafios: [
          { titulo: 'Decifrando o código do pedido',
            cenario: 'Os pedidos da loja têm códigos como <code>"GO-2026-10-0587"</code>: estado, ano, mês e número. Usando fatias, crie as variáveis <code>estado</code>, <code>ano</code>, <code>mes</code> e <code>numero</code> (todas como texto) e mostre as quatro.',
            inicial: 'codigo = "GO-2026-10-0587"\n',
            testes: [
              { py: "assert estado == 'GO'", msg: 'estado está correto' },
              { py: "assert ano == '2026'", msg: 'ano está correto' },
              { py: "assert mes == '10'", msg: 'mes está correto' },
              { py: "assert numero == '0587'", msg: 'numero está correto' }
            ],
            dicas: ['Conte as posições: G=0, O=1, -=2, o ano começa no 3.', 'Para o número, uma fatia com índice negativo resolve: codigo[-4:]'],
            solucao: 'codigo = "GO-2026-10-0587"\nestado = codigo[0:2]\nano = codigo[3:7]\nmes = codigo[8:10]\nnumero = codigo[-4:]\nprint(estado, ano, mes, numero)' }
        ]
      },
      {
        id: 'py-strings-metodos', title: 'Métodos de texto: upper, lower, strip, replace',
        desc: 'Os métodos que limpam e padronizam textos — a base da limpeza de dados.',
        objetivos: [
          'Padronizar maiúsculas e minúsculas com upper, lower e title',
          'Tirar espaços extras com strip',
          'Trocar trechos com replace e verificar conteúdo com in, startswith e endswith'
        ],
        body: 'Base de cliente nunca vem limpa: "  maria silva ", "MARIA SILVA", "Maria  Silva". Para o computador, são três clientes diferentes. Os métodos de texto padronizam tudo — e são exatamente o que o Power Query e o pandas fazem por baixo dos panos.',
        content: [
          { h: 'Maiúsculas e minúsculas',
            code: 'nome = "maria DA silva"\nprint(nome.upper())\nprint(nome.lower())\nprint(nome.title())' },
          { h: 'strip: tchau, espaços extras',
            p: '<code>strip()</code> remove espaços (e quebras de linha) do começo e do fim. <code>lstrip</code> e <code>rstrip</code> limpam só um lado.',
            code: 'cidade = "   Goiânia  "\nprint(f"[{cidade}]")\nprint(f"[{cidade.strip()}]")' },
          { h: 'replace: trocar trechos',
            code: 'valor = "R$ 1.234,56"\nlimpo = valor.replace("R$ ", "").replace(".", "").replace(",", ".")\nprint(limpo)\nprint(float(limpo) * 2)' },
          { h: 'Encadeando e verificando',
            items: [
              'Métodos podem ser encadeados: <code>texto.strip().lower()</code>.',
              '<code>"x" in texto</code> verifica se um trecho existe: <code>"@" in email</code>.',
              '<code>startswith</code> e <code>endswith</code> verificam começo e fim: <code>arquivo.endswith(".csv")</code>.',
              '<code>count</code> conta ocorrências: <code>texto.count("a")</code>.'
            ],
            code: 'email = "  Ana@Empresa.com "\nemail = email.strip().lower()\nprint(email)\nprint("@" in email, email.endswith(".com"))' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print("goiás".upper())', op: ['GOIÁS', 'Goiás', 'goiás'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print("maria silva".title())', op: ['Maria Silva', 'MARIA SILVA', 'Maria silva'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 't = "  oi  "\nprint(len(t.strip()))', op: ['2', '6', '4'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print("1,5".replace(",", "."))', op: ['1.5', '1,5', '15'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'arq = "vendas.csv"\nprint(arq.endswith(".csv"))', op: ['True', 'False', '.csv'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print("@" in "ana.empresa.com")', op: ['False', 'True', 'Erro'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'nome = nome.___().lower()', op: ['strip', 'trim', 'clean'], a: 0, pt: 'Tire os espaços e deixe minúsculo.', exp: 'Em Python o método é strip (no Excel é ARRUMAR/TRIM).' },
          { t: 'pares', pares: [['upper()', 'tudo maiúsculo'], ['lower()', 'tudo minúsculo'], ['title()', 'Primeira Maiúscula'], ['strip()', 'tira espaços das pontas'], ['replace(a, b)', 'troca a por b']] },
          { t: 'ordenar', q: 'Monte o código que limpa e padroniza o nome.', linhas: ['nome = "  MARIA silva "', 'nome = nome.strip().title()', 'print(nome)'] }
        ],
        desafios: [
          { titulo: 'Padronizando o cadastro',
            cenario: 'O cadastro veio bagunçado. Padronize: <code>nome</code> sem espaços nas pontas e com iniciais maiúsculas; <code>email</code> sem espaços e todo minúsculo; <code>telefone</code> só com números (tire parênteses, espaço e hífen).',
            inicial: 'nome = "   joão PEREIRA  "\nemail = " Joao.Pereira@Empresa.COM "\ntelefone = "(64) 99290-5785"\n\n# padronize as três variáveis\n',
            testes: [
              { py: "assert nome == 'João Pereira'", msg: 'nome padronizado' },
              { py: "assert email == 'joao.pereira@empresa.com'", msg: 'email padronizado' },
              { py: "assert telefone == '64992905785'", msg: 'telefone só com números' }
            ],
            dicas: ['Reatribua cada variável: nome = nome.strip().title()', 'Para o telefone, encadeie replace: .replace("(", "").replace(")", "") e assim por diante.'],
            solucao: 'nome = "   joão PEREIRA  "\nemail = " Joao.Pereira@Empresa.COM "\ntelefone = "(64) 99290-5785"\n\nnome = nome.strip().title()\nemail = email.strip().lower()\ntelefone = telefone.replace("(", "").replace(")", "").replace(" ", "").replace("-", "")\nprint(nome, email, telefone)' }
        ]
      },
      {
        id: 'py-split-join', title: 'split e join: quebrar e juntar textos',
        desc: 'Como transformar uma linha de texto em partes (split) e juntar partes num texto só (join) — a lógica dos arquivos CSV.',
        objetivos: [
          'Quebrar textos em listas com split',
          'Juntar listas de textos com join',
          'Converter texto em número com int e float'
        ],
        body: 'Uma linha de CSV é só um texto com vírgulas: "Ana;Goiânia;1500". O split quebra essa linha em pedaços, e o join faz o caminho inverso. Com eles você já entende como os dados ficam guardados em arquivos — antes mesmo de usar o pandas.',
        content: [
          { h: 'split: quebrar',
            p: '<code>texto.split(separador)</code> devolve uma lista de pedaços. Sem argumento, quebra nos espaços.',
            code: 'linha = "Ana;Goiânia;1500"\npartes = linha.split(";")\nprint(partes)\nprint(partes[0], partes[2])' },
          { h: 'Texto vira número com int e float',
            p: 'O que vem de um arquivo é sempre texto. Para fazer conta, converta: <code>int("1500")</code> e <code>float("12.5")</code>.',
            code: 'linha = "Ana;Goiânia;1500"\nnome, cidade, valor = linha.split(";")\nprint(int(valor) * 2)' },
          { h: 'join: juntar',
            p: 'O separador vem <strong>antes</strong>: <code>", ".join(lista)</code>.',
            code: 'cidades = ["Goiânia", "Itumbiara", "Rio Verde"]\nprint(", ".join(cidades))\nprint(" | ".join(cidades))' },
          { h: 'Desempacotar',
            p: 'Quando você sabe quantos pedaços vêm, pode guardar cada um numa variável de uma vez: <code>nome, cidade, valor = linha.split(";")</code>. Se o número de variáveis não bater com o de pedaços, dá <code>ValueError</code>.' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print("a;b;c".split(";"))', op: ["['a', 'b', 'c']", 'a b c', "['a;b;c']"], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'p = "Ana Maria Silva".split()\nprint(p[-1])', op: ['Silva', 'Ana', 'Maria'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print("-".join(["2026", "10", "28"]))', op: ['2026-10-28', '2026 10 28', "['2026-10-28']"], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print("10" + "5")', op: ['105', '15', 'Erro'], a: 0, exp: 'Os dois são texto: o + junta os textos. Para somar, converta com int().' },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(int("10") + int("5"))', op: ['15', '105', 'Erro'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'partes = linha.___(";")', op: ['split', 'join', 'cut'], a: 0, pt: 'Quebre a linha nos pontos e vírgulas.' },
          { t: 'pares', pares: [['split', 'texto → lista'], ['join', 'lista → texto'], ['int("7")', '7 (inteiro)'], ['float("2.5")', '2.5 (decimal)'], ['str(10)', '"10" (texto)']] },
          { t: 'ordenar', q: 'Monte o código que lê a linha e dobra o valor.', linhas: ['linha = "Ana;Goiânia;1500"', 'nome, cidade, valor = linha.split(";")', 'print(int(valor) * 2)'] }
        ],
        desafios: [
          { titulo: 'Lendo uma linha do arquivo',
            cenario: 'A linha <code>"2026-10-15;Caneta azul;12;2.50"</code> veio de um arquivo de vendas: data, produto, quantidade e preço unitário. Quebre a linha, converta quantidade e preço para número e calcule o <code>total</code> da venda (quantidade × preço). Depois monte a variável <code>resumo</code> no formato <code>Caneta azul: 12 x R$ 2.50 = R$ 30.00</code>.',
            inicial: 'linha = "2026-10-15;Caneta azul;12;2.50"\n',
            testes: [
              { py: 'assert abs(total - 30.0) < 0.001', msg: 'total está correto (e é um número)' },
              { py: "assert resumo == 'Caneta azul: 12 x R$ 2.50 = R$ 30.00'", msg: 'resumo no formato pedido' }
            ],
            dicas: ['data, produto, qtd, preco = linha.split(";")', 'Converta: int(qtd) e float(preco). No resumo, use f-string com :.2f para os valores em reais.'],
            solucao: 'linha = "2026-10-15;Caneta azul;12;2.50"\ndata, produto, qtd, preco = linha.split(";")\nqtd = int(qtd)\npreco = float(preco)\ntotal = qtd * preco\nresumo = f"{produto}: {qtd} x R$ {preco:.2f} = R$ {total:.2f}"\nprint(resumo)' }
        ]
      },
      {
        id: 'py-texto-projeto', title: 'Projeto: limpando uma lista de clientes',
        desc: 'Aplicando tudo do módulo num caso real: padronizar nomes, validar e-mails e montar um relatório em texto.',
        objetivos: [
          'Combinar métodos de texto para limpar dados',
          'Validar informações simples (e-mail com @ e ponto)',
          'Gerar um relatório organizado com f-strings e alinhamento'
        ],
        body: 'Fechando o módulo, um caso de verdade: uma lista de clientes com nomes bagunçados e e-mails duvidosos. Você vai limpar, validar e montar um relatório — em poucas linhas de Python.',
        content: [
          { h: 'Validação simples de e-mail',
            p: 'Uma validação básica: tem <code>@</code>, tem ponto depois do <code>@</code> e não tem espaço. Não é perfeita, mas pega a maioria dos erros de digitação.',
            code: 'email = "ana@empresa.com"\nvalido = "@" in email and "." in email.split("@")[-1] and " " not in email\nprint(valido)' },
          { h: 'Alinhando colunas no relatório',
            p: 'Nas f-strings, <code>{texto:<20}</code> alinha à esquerda em 20 espaços e <code>{numero:>10}</code> à direita — dá para fazer uma tabela em texto.',
            code: 'print(f"{\'Cliente\':<15}{\'Cidade\':<12}")\nprint(f"{\'Ana Souza\':<15}{\'Goiânia\':<12}")\nprint(f"{\'Bruno Lima\':<15}{\'Itumbiara\':<12}")' },
          { h: 'O que vem a seguir',
            p: 'Aqui você tratou um cliente por vez. No módulo 4, com listas e laços, vai fazer a mesma limpeza em centenas de clientes de uma vez — e no pandas, em milhares, com uma linha só.' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'e = "ana@empresa"\nprint("." in e.split("@")[-1])', op: ['False', 'True', 'empresa'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(f"[{\'Ana\':<6}]")', op: ['[Ana   ]', '[   Ana]', '[Ana]'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(f"[{42:>5}]")', op: ['[   42]', '[42   ]', '[42]'], a: 0 },
          { t: 'escolha', q: 'O que faz este código?', codigo: 'nome = nome.strip().title()', op: ['Tira espaços das pontas e deixa iniciais maiúsculas', 'Apaga o nome', 'Deixa tudo maiúsculo'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'valido = "@" in email ___ " " not in email', op: ['and', 'or', '+'], a: 0, pt: 'Válido se tem @ E não tem espaço.' },
          { t: 'pares', pares: [[':<15', 'alinha à esquerda'], [':>10', 'alinha à direita'], ['in', 'contém'], ['not in', 'não contém'], ['and', 'as duas condições']] },
          { t: 'ordenar', q: 'Monte a validação do e-mail.', linhas: ['email = " Ana@Empresa.com ".strip().lower()', 'valido = "@" in email and " " not in email', 'print(email, valido)'] }
        ],
        desafios: [
          { titulo: 'O cliente da vez',
            cenario: 'Recebemos o cadastro <code>"  CARLOS eduardo ; carlos.edu@@mail.com ;rio verde"</code> (nome; e-mail; cidade). Quebre a linha, limpe cada parte (nome e cidade com iniciais maiúsculas, e-mail minúsculo) e crie as variáveis <code>nome</code>, <code>email</code>, <code>cidade</code> e <code>email_valido</code> (True ou False). Um e-mail é válido se tiver exatamente um <code>@</code> e um ponto depois dele.',
            inicial: 'cadastro = "  CARLOS eduardo ; carlos.edu@@mail.com ;rio verde"\n',
            testes: [
              { py: "assert nome == 'Carlos Eduardo'", msg: 'nome limpo' },
              { py: "assert cidade == 'Rio Verde'", msg: 'cidade limpa' },
              { py: "assert email == 'carlos.edu@@mail.com'", msg: 'email limpo (só espaços e minúsculas)' },
              { py: 'assert email_valido is False', msg: 'email_valido detecta o erro (dois @)' }
            ],
            dicas: ['nome, email, cidade = cadastro.split(";") — depois aplique strip em cada um.', 'Para contar os @: email.count("@") == 1'],
            solucao: 'cadastro = "  CARLOS eduardo ; carlos.edu@@mail.com ;rio verde"\nnome, email, cidade = cadastro.split(";")\nnome = nome.strip().title()\nemail = email.strip().lower()\ncidade = cidade.strip().title()\nemail_valido = email.count("@") == 1 and "." in email.split("@")[-1]\nprint(nome, email, cidade, email_valido)' }
        ]
      }
    ]
  }
  ,
  {
    id: 'py-m03', title: 'Módulo 03 · Decisões: comparações, if, elif, else e lógica', kind: 'video',
    lessons: [
      {
        id: 'py-comparacoes', title: 'Comparações e valores booleanos',
        desc: 'Os operadores que comparam valores (==, !=, >, <, >=, <=) e o resultado True ou False.',
        objetivos: [
          'Comparar números e textos com os operadores relacionais',
          'Diferenciar = (atribuição) de == (comparação)',
          'Entender que toda comparação resulta em True ou False'
        ],
        body: 'Antes de o programa tomar uma decisão, ele precisa fazer uma pergunta: a meta foi batida? O estoque acabou? O cliente é de Goiás? Toda pergunta dessas é uma comparação, e a resposta é sempre True ou False.',
        content: [
          { h: 'Os operadores',
            items: [
              '<code>==</code> igual · <code>!=</code> diferente',
              '<code>&gt;</code> maior · <code>&lt;</code> menor · <code>&gt;=</code> maior ou igual · <code>&lt;=</code> menor ou igual',
              'O resultado é sempre um <code>bool</code>: <code>True</code> ou <code>False</code>.'
            ],
            code: 'vendas = 120000\nmeta = 100000\nprint(vendas > meta)\nprint(vendas == meta)\nprint(vendas != meta)' },
          { h: '= não é ==',
            p: 'Um sinal guarda um valor (<code>x = 5</code>); dois sinais perguntam se é igual (<code>x == 5</code>). Trocar um pelo outro é o erro mais comum de quem começa.',
            code: 'estoque = 0\nprint(estoque == 0)' },
          { h: 'Comparando textos',
            p: 'Textos também se comparam, mas maiúsculas e minúsculas contam: <code>"Goiás" == "goiás"</code> é <code>False</code>. Padronize antes de comparar.',
            code: 'uf = " go "\nprint(uf == "GO")\nprint(uf.strip().upper() == "GO")' },
          { h: 'Guardando o resultado',
            p: 'O resultado de uma comparação pode ir para uma variável — e o nome deve parecer uma pergunta.',
            code: 'meta_batida = 120000 >= 100000\nprint(meta_batida)' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(10 > 5)', op: ['True', 'False', '10'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(5 >= 5)', op: ['True', 'False', 'Erro'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print("GO" == "go")', op: ['False', 'True', 'Erro'], a: 0, exp: 'Maiúsculas e minúsculas contam na comparação de textos.' },
          { t: 'escolha', q: 'Qual linha pergunta se x é igual a 10?', op: ['x == 10', 'x = 10', 'x === 10'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(3 != 3)', op: ['False', 'True', '0'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'esgotado = estoque ___ 0', op: ['==', '=', '=>'], a: 0, pt: 'Verifique se o estoque é igual a zero.' },
          { t: 'pares', pares: [['==', 'igual'], ['!=', 'diferente'], ['>=', 'maior ou igual'], ['<', 'menor'], ['=', 'guardar valor']] },
          { t: 'ordenar', q: 'Monte o código que verifica a meta.', linhas: ['vendas = 120000', 'meta = 100000', 'print(vendas >= meta)'] }
        ],
        desafios: [
          { titulo: 'Checagem rápida',
            cenario: 'Crie três variáveis booleanas: <code>meta_batida</code> (vendas maior ou igual à meta), <code>estoque_baixo</code> (estoque menor que 10) e <code>cliente_goias</code> (a UF do cliente, depois de limpa e em maiúsculas, é igual a <code>"GO"</code>).',
            inicial: 'vendas = 87500\nmeta = 90000\nestoque = 7\nuf_cliente = " go"\n',
            testes: [
              { py: 'assert meta_batida is False', msg: 'meta_batida está correta' },
              { py: 'assert estoque_baixo is True', msg: 'estoque_baixo está correto' },
              { py: 'assert cliente_goias is True', msg: 'cliente_goias está correto' }
            ],
            dicas: ['Cada variável recebe o resultado de uma comparação: meta_batida = vendas >= meta', 'Para a UF: uf_cliente.strip().upper() == "GO"'],
            solucao: 'vendas = 87500\nmeta = 90000\nestoque = 7\nuf_cliente = " go"\n\nmeta_batida = vendas >= meta\nestoque_baixo = estoque < 10\ncliente_goias = uf_cliente.strip().upper() == "GO"\nprint(meta_batida, estoque_baixo, cliente_goias)' }
        ]
      },
      {
        id: 'py-if-else', title: 'if, elif e else: o programa toma decisões',
        desc: 'Como executar um código só quando uma condição é verdadeira, e como escolher entre vários caminhos.',
        objetivos: [
          'Usar if para executar código condicionalmente',
          'Usar else e elif para caminhos alternativos',
          'Entender a indentação como parte da linguagem'
        ],
        body: 'É aqui que o programa começa a pensar: "se a meta foi batida, parabenize; senão, mostre quanto falta". Em Python, o que pertence ao if é marcado pela indentação — os quatro espaços no começo da linha.',
        content: [
          { h: 'if e else',
            p: 'A linha do <code>if</code> termina com dois-pontos, e o bloco de dentro é indentado com 4 espaços.',
            code: 'vendas = 87500\nmeta = 90000\nif vendas >= meta:\n    print("Meta batida! 🎉")\nelse:\n    falta = meta - vendas\n    print(f"Faltam R$ {falta:,.2f}")' },
          { h: 'elif: várias faixas',
            p: 'O <code>elif</code> ("senão, se") testa outra condição. O Python para no primeiro caminho verdadeiro — por isso a ordem importa.',
            code: 'nota = 7.5\nif nota >= 9:\n    conceito = "A"\nelif nota >= 7:\n    conceito = "B"\nelif nota >= 5:\n    conceito = "C"\nelse:\n    conceito = "D"\nprint(conceito)' },
          { h: 'A indentação é obrigatória',
            items: [
              'Esquecer os dois-pontos dá <code>SyntaxError</code>.',
              'Esquecer a indentação dá <code>IndentationError</code>.',
              'No editor do curso, depois de uma linha com <code>:</code>, o Enter já indenta sozinho.'
            ] },
          { h: 'É o SE do Excel',
            p: 'Se você usa <code>SE</code> no Excel, já conhece a lógica: <code>=SE(B2&gt;=90000;"Batida";"Abaixo")</code> é o mesmo que um if/else. A diferença é que em Python cada caminho pode ter várias linhas de código, sem os SE aninhados ilegíveis.' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'x = 5\nif x > 3:\n    print("grande")\nelse:\n    print("pequeno")', op: ['grande', 'pequeno', 'grande pequeno'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'n = 8\nif n >= 9:\n    print("A")\nelif n >= 7:\n    print("B")\nelse:\n    print("C")', op: ['B', 'A', 'C'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'n = 10\nif n >= 5:\n    print("X")\nelif n >= 8:\n    print("Y")', op: ['X', 'Y', 'X Y'], a: 0, exp: 'O Python para no primeiro caminho verdadeiro: 10 >= 5 já é verdade, o elif nem é testado.' },
          { t: 'escolha', q: 'O que está faltando nesta linha?', codigo: 'if vendas > meta\n    print("ok")', op: ['Os dois-pontos no fim do if', 'Parênteses na condição', 'A palavra then'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'if estoque == 0:\n    print("Esgotado")\n___:\n    print("Disponível")', op: ['else', 'elif', 'then'], a: 0, pt: 'Complete o caminho alternativo.' },
          { t: 'ordenar', q: 'Monte o código com a indentação certa.', linhas: ['if vendas >= meta:', '    print("Meta batida")', 'else:', '    print("Abaixo da meta")'] },
          { t: 'pares', pares: [['if', 'se'], ['elif', 'senão, se'], ['else', 'senão'], [':', 'fim da condição'], ['4 espaços', 'indentação do bloco']] }
        ],
        desafios: [
          { titulo: 'A comissão do vendedor',
            cenario: 'A comissão segue faixas: vendas acima de <strong>R$ 100.000</strong> ganham <strong>5%</strong>; acima de <strong>R$ 50.000</strong> (até 100 mil), <strong>3%</strong>; o resto, <strong>1%</strong>. Calcule a variável <code>comissao</code> para o valor de <code>vendas</code> e mostre-a. Teste mudando o valor de vendas!',
            inicial: 'vendas = 78000\n',
            testes: [
              { py: 'assert abs(comissao - 2340.0) < 0.01', msg: 'comissão correta para vendas = 78000' },
              { py: "__ns2 = {}\nexec(compile(__codigo_aluno.replace('vendas = 78000', 'vendas = 150000'), 'x', 'exec'), __ns2)\nassert abs(__ns2['comissao'] - 7500.0) < 0.01", msg: 'funciona também para vendas acima de 100 mil' },
              { py: "__ns3 = {}\nexec(compile(__codigo_aluno.replace('vendas = 78000', 'vendas = 30000'), 'x', 'exec'), __ns3)\nassert abs(__ns3['comissao'] - 300.0) < 0.01", msg: 'funciona também para vendas baixas' }
            ],
            dicas: ['Comece pela faixa mais alta: if vendas > 100000: ... elif vendas > 50000: ... else: ...', 'Dentro de cada caminho: comissao = vendas * 0.05 (ou 0.03, ou 0.01)'],
            solucao: 'vendas = 78000\nif vendas > 100000:\n    comissao = vendas * 0.05\nelif vendas > 50000:\n    comissao = vendas * 0.03\nelse:\n    comissao = vendas * 0.01\nprint(f"Comissão: R$ {comissao:,.2f}")' }
        ]
      },
      {
        id: 'py-and-or-not', title: 'and, or e not: combinando condições',
        desc: 'Como juntar várias condições numa decisão só, e os atalhos que tornam o código mais legível.',
        objetivos: [
          'Combinar condições com and e or',
          'Negar condições com not',
          'Usar in para testar se um valor está numa lista de opções'
        ],
        body: 'Decisões reais quase sempre têm mais de um critério: "cliente de Goiás E com compra acima de R$ 500 ganha frete grátis". Os operadores lógicos juntam essas condições — os mesmos E e OU do Excel.',
        content: [
          { h: 'and e or',
            items: [
              '<code>and</code>: verdadeiro só se <strong>todas</strong> forem verdadeiras.',
              '<code>or</code>: verdadeiro se <strong>pelo menos uma</strong> for verdadeira.',
              'Use parênteses para deixar a intenção clara quando misturar os dois.'
            ],
            code: 'uf = "GO"\ncompra = 650\nfrete_gratis = uf == "GO" and compra > 500\nprint(frete_gratis)\nvip = compra > 1000 or uf == "DF"\nprint(vip)' },
          { h: 'not',
            code: 'cancelado = False\nif not cancelado:\n    print("Pedido segue para entrega")' },
          { h: 'in: está na lista?',
            p: 'Em vez de <code>uf == "GO" or uf == "DF" or uf == "MT"</code>, use <code>in</code> com uma lista de opções.',
            code: 'uf = "MT"\nif uf in ["GO", "DF", "MT", "MS"]:\n    print("Centro-Oeste")' },
          { h: 'Intervalos',
            p: 'Python aceita comparação encadeada: <code>18 &lt;= idade &lt; 60</code> é o mesmo que <code>idade &gt;= 18 and idade &lt; 60</code>.',
            code: 'idade = 35\nprint(18 <= idade < 60)' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(True and False)', op: ['False', 'True', 'Erro'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(True or False)', op: ['True', 'False', 'Erro'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(not True)', op: ['False', 'True', 'not True'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'uf = "DF"\nprint(uf in ["GO", "DF"])', op: ['True', 'False', 'DF'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'x = 15\nprint(10 <= x < 20)', op: ['True', 'False', 'Erro'], a: 0 },
          { t: 'escolha', q: 'Frete grátis para GO E compra acima de 500. Qual condição?', op: ['uf == "GO" and compra > 500', 'uf == "GO" or compra > 500', 'uf == "GO" + compra > 500'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'if uf ___ ["GO", "DF", "MT", "MS"]:', op: ['in', '==', 'and'], a: 0, pt: 'Verifique se a UF é do Centro-Oeste.' },
          { t: 'pares', pares: [['and', 'todas verdadeiras (E)'], ['or', 'pelo menos uma (OU)'], ['not', 'inverte'], ['in', 'está na lista'], ['18 <= x < 60', 'intervalo']] }
        ],
        desafios: [
          { titulo: 'Regra de frete',
            cenario: 'O frete da loja segue as regras: é <strong>grátis</strong> (<code>frete = 0</code>) se o cliente for do Centro-Oeste (GO, DF, MT ou MS) <strong>e</strong> a compra passar de R$ 300, <strong>ou</strong> se a compra passar de R$ 1.000 em qualquer estado. Fora isso, o frete é <strong>R$ 29,90</strong>. Calcule a variável <code>frete</code>.',
            inicial: 'uf = "MT"\ncompra = 450\n',
            testes: [
              { py: 'assert frete == 0', msg: 'frete correto para MT com compra de 450' },
              { py: "__n = {}\nexec(compile(__codigo_aluno.replace('uf = \"MT\"', 'uf = \"SP\"'), 'x', 'exec'), __n)\nassert abs(__n['frete'] - 29.9) < 0.001", msg: 'frete correto para SP com compra de 450' },
              { py: "__n = {}\nexec(compile(__codigo_aluno.replace('uf = \"MT\"', 'uf = \"SP\"').replace('compra = 450', 'compra = 1200'), 'x', 'exec'), __n)\nassert __n['frete'] == 0", msg: 'frete correto para SP com compra de 1200' }
            ],
            dicas: ['Monte a condição em duas partes: (uf in [...] and compra > 300) or compra > 1000', 'Depois: if condição: frete = 0, else: frete = 29.90'],
            solucao: 'uf = "MT"\ncompra = 450\ncentro_oeste = uf in ["GO", "DF", "MT", "MS"]\nif (centro_oeste and compra > 300) or compra > 1000:\n    frete = 0\nelse:\n    frete = 29.90\nprint(f"Frete: R$ {frete:.2f}")' }
        ]
      },
      {
        id: 'py-decisoes-projeto', title: 'Projeto: classificando clientes',
        desc: 'Juntando comparações, if/elif e lógica para classificar clientes por faturamento e recência, como numa análise RFV.',
        objetivos: [
          'Escrever regras de negócio com if/elif/else',
          'Combinar critérios para classificar registros',
          'Testar o código com diferentes valores'
        ],
        body: 'Classificar clientes em faixas — ouro, prata, bronze; ativo ou inativo — é uma das tarefas mais comuns em análise de dados. Aqui você escreve as regras uma vez; no módulo de pandas, vai aplicá-las a milhares de clientes de uma só vez.',
        content: [
          { h: 'Regras de negócio viram código',
            items: [
              'Escreva primeiro as regras em português, como uma lista.',
              'Traduza cada regra para um <code>if</code>/<code>elif</code>, da mais exigente para a menos exigente.',
              'Termine com um <code>else</code> que cubra todo o resto — nenhum cliente fica sem categoria.'
            ],
            code: 'gasto_anual = 8500\ndias_sem_comprar = 40\n\nif dias_sem_comprar > 180:\n    categoria = "Inativo"\nelif gasto_anual >= 10000:\n    categoria = "Ouro"\nelif gasto_anual >= 5000:\n    categoria = "Prata"\nelse:\n    categoria = "Bronze"\nprint(categoria)' },
          { h: 'Teste os limites',
            p: 'Bons programadores testam os valores na fronteira: exatamente 5000, exatamente 180 dias. É ali que <code>&gt;</code> e <code>&gt;=</code> fazem diferença — e onde moram os erros.' },
          { h: 'Próximo passo',
            p: 'Agora o código classifica um cliente. No próximo módulo, com listas e laços, você vai percorrer uma lista inteira de clientes e contar quantos há em cada categoria.' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'g = 5000\nif g > 5000:\n    print("Prata")\nelse:\n    print("Bronze")', op: ['Bronze', 'Prata', 'Erro'], a: 0, exp: '5000 não é MAIOR que 5000. Para incluir o limite, use >=.' },
          { t: 'escolha', q: 'Por que testar "Inativo" antes de "Ouro"?', op: ['Porque um cliente parado há muito tempo deve ser Inativo mesmo tendo gasto muito', 'Porque o Python exige ordem alfabética', 'Não faz diferença'], a: 0, opPt: true },
          { t: 'escolha', q: 'Para que serve o else final na classificação?', op: ['Garantir que todo cliente receba uma categoria', 'Encerrar o programa', 'Repetir o if'], a: 0, opPt: true },
          { t: 'ordenar', q: 'Monte a classificação na ordem certa.', linhas: ['if gasto >= 10000:', '    categoria = "Ouro"', 'elif gasto >= 5000:', '    categoria = "Prata"', 'else:', '    categoria = "Bronze"'] },
          { t: 'lacuna', codigo: true, frase: 'if dias > 180:\n    categoria = "Inativo"\n___ gasto >= 10000:\n    categoria = "Ouro"', op: ['elif', 'else', 'if else'], a: 0, pt: 'Complete o segundo caminho.' },
          { t: 'pares', pares: [['regra de negócio', 'critério da empresa'], ['limite', 'valor de fronteira'], ['>=', 'inclui o limite'], ['>', 'exclui o limite'], ['else', 'todo o resto']] }
        ],
        desafios: [
          { titulo: 'Semáforo do estoque',
            cenario: 'Classifique cada produto na variável <code>status</code>: <code>"Ruptura"</code> se o estoque for 0; <code>"Crítico"</code> se o estoque cobrir menos de 7 dias de venda; <code>"Atenção"</code> se cobrir de 7 a 14 dias (inclusive); <code>"OK"</code> acima disso. Cobertura em dias = estoque ÷ venda média diária.',
            inicial: 'estoque = 120\nvenda_diaria = 10\n',
            testes: [
              { py: "assert status == 'Atenção'", msg: 'status correto para estoque 120 e venda 10/dia' },
              { py: "__n = {}\nexec(compile(__codigo_aluno.replace('estoque = 120', 'estoque = 0'), 'x', 'exec'), __n)\nassert __n['status'] == 'Ruptura'", msg: 'estoque zerado vira Ruptura' },
              { py: "__n = {}\nexec(compile(__codigo_aluno.replace('estoque = 120', 'estoque = 50'), 'x', 'exec'), __n)\nassert __n['status'] == 'Crítico'", msg: 'cobertura baixa vira Crítico' },
              { py: "__n = {}\nexec(compile(__codigo_aluno.replace('estoque = 120', 'estoque = 300'), 'x', 'exec'), __n)\nassert __n['status'] == 'OK'", msg: 'cobertura alta vira OK' },
              { py: "__n = {}\nexec(compile(__codigo_aluno.replace('estoque = 120', 'estoque = 140'), 'x', 'exec'), __n)\nassert __n['status'] == 'Atenção'", msg: 'exatamente 14 dias ainda é Atenção' }
            ],
            dicas: ['Calcule cobertura = estoque / venda_diaria (cuidado: teste a ruptura primeiro).', 'Ordem: estoque == 0, depois cobertura < 7, depois cobertura <= 14, senão OK.'],
            solucao: 'estoque = 120\nvenda_diaria = 10\nif estoque == 0:\n    status = "Ruptura"\nelse:\n    cobertura = estoque / venda_diaria\n    if cobertura < 7:\n        status = "Crítico"\n    elif cobertura <= 14:\n        status = "Atenção"\n    else:\n        status = "OK"\nprint(status)' }
        ]
      }
    ]
  }
  ,
  {
    id: 'py-m04', title: 'Módulo 04 · Listas e laços: for, while, range e acumuladores', kind: 'video',
    lessons: [
      {
        id: 'py-listas', title: 'Listas: guardando vários valores',
        desc: 'Como criar listas, acessar e alterar itens, adicionar e remover, e as funções len, sum, min, max e sorted.',
        objetivos: [
          'Criar listas e acessar itens por índice e fatia',
          'Adicionar, remover e alterar itens',
          'Calcular totais e extremos com sum, min, max e ordenar com sorted'
        ],
        body: 'Uma variável guarda um valor; uma lista guarda vários, em ordem: as vendas do mês, os produtos do pedido, as cidades atendidas. É a primeira estrutura de dados que você vai usar o tempo todo — e a ponte para as colunas do pandas.',
        content: [
          { h: 'Criando e acessando',
            p: 'Lista vai entre colchetes, com itens separados por vírgula. Índices e fatias funcionam como nos textos.',
            code: 'vendas = [1200, 850, 2300, 640]\nprint(vendas[0])\nprint(vendas[-1])\nprint(vendas[1:3])' },
          { h: 'Alterando a lista',
            items: [
              '<code>lista.append(x)</code> adiciona no fim · <code>lista.insert(i, x)</code> insere numa posição.',
              '<code>lista.remove(x)</code> remove pelo valor · <code>lista.pop()</code> remove o último.',
              '<code>lista[i] = novo</code> troca um item. Diferente dos textos, listas <strong>mudam</strong>.'
            ],
            code: 'produtos = ["caneta", "lápis"]\nprodutos.append("borracha")\nprodutos[0] = "caneta azul"\nprint(produtos)' },
          { h: 'Resumindo uma lista',
            code: 'vendas = [1200, 850, 2300, 640]\nprint(len(vendas), sum(vendas), min(vendas), max(vendas))\nprint(sum(vendas) / len(vendas))\nprint(sorted(vendas, reverse=True))' },
          { h: 'Está na lista?',
            p: 'O <code>in</code> funciona com listas também: <code>"GO" in ufs</code>. E <code>lista.count(x)</code> conta quantas vezes um valor aparece.' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'v = [10, 20, 30]\nprint(v[1])', op: ['20', '10', '30'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'v = [10, 20, 30]\nprint(sum(v))', op: ['60', '30', '[10, 20, 30]'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'v = [3, 1, 2]\nv.append(5)\nprint(len(v))', op: ['4', '3', '5'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print(sorted([3, 1, 2]))', op: ['[1, 2, 3]', '[3, 2, 1]', '[3, 1, 2]'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'v = [5, 8, 2]\nprint(max(v) - min(v))', op: ['6', '8', '2'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'produtos.___("borracha")', op: ['append', 'add', 'push'], a: 0, pt: 'Adicione "borracha" no fim da lista.' },
          { t: 'pares', pares: [['append', 'adiciona no fim'], ['remove', 'remove pelo valor'], ['len', 'quantidade de itens'], ['sum', 'soma'], ['sorted', 'ordenada']] },
          { t: 'ordenar', q: 'Monte o código que calcula a média das vendas.', linhas: ['vendas = [1200, 850, 2300]', 'media = sum(vendas) / len(vendas)', 'print(round(media, 2))'] }
        ],
        desafios: [
          { titulo: 'Resumo da semana',
            cenario: 'As vendas diárias da semana estão na lista <code>vendas</code>. Calcule <code>total</code>, <code>media</code> (arredondada em 2 casas), <code>melhor_dia</code> (o maior valor) e <code>top3</code> (lista com os três maiores valores, do maior para o menor).',
            inicial: 'vendas = [1850.0, 2310.5, 1640.0, 2980.0, 3410.75, 4120.0, 1975.25]\n',
            testes: [
              { py: 'assert abs(total - 18286.5) < 0.01', msg: 'total correto' },
              { py: 'assert abs(media - 2612.36) < 0.01', msg: 'média correta (2 casas)' },
              { py: 'assert melhor_dia == 4120.0', msg: 'melhor_dia correto' },
              { py: 'assert top3 == [4120.0, 3410.75, 2980.0]', msg: 'top3 correto' }
            ],
            dicas: ['total = sum(vendas); media = round(total / len(vendas), 2)', 'top3: ordene do maior para o menor com sorted(vendas, reverse=True) e pegue uma fatia [:3].'],
            solucao: 'vendas = [1850.0, 2310.5, 1640.0, 2980.0, 3410.75, 4120.0, 1975.25]\ntotal = sum(vendas)\nmedia = round(total / len(vendas), 2)\nmelhor_dia = max(vendas)\ntop3 = sorted(vendas, reverse=True)[:3]\nprint(total, media, melhor_dia, top3)' }
        ]
      },
      {
        id: 'py-for', title: 'O laço for: repetindo para cada item',
        desc: 'Como percorrer uma lista item por item com for, usar range e enumerate, e acumular resultados.',
        objetivos: [
          'Percorrer listas com for',
          'Gerar sequências com range e numerar com enumerate',
          'Usar acumuladores (somar, contar) dentro do laço'
        ],
        body: 'O laço for é o que faz o computador trabalhar por você: "para cada venda da lista, faça isso". Com ele, a limpeza que você fez num cliente no módulo 2 passa a valer para mil clientes.',
        content: [
          { h: 'for item in lista',
            p: 'A cada volta, a variável recebe o próximo item. O bloco indentado se repete para cada um.',
            code: 'cidades = ["Goiânia", "Itumbiara", "Rio Verde"]\nfor cidade in cidades:\n    print(f"Entregando em {cidade}")' },
          { h: 'Acumuladores',
            p: 'Crie a variável <strong>antes</strong> do laço e atualize dentro dele. É assim que se soma, conta ou monta uma nova lista.',
            code: 'vendas = [1200, 850, 2300, 640]\ntotal = 0\nacima_de_mil = 0\nfor v in vendas:\n    total = total + v\n    if v > 1000:\n        acima_de_mil += 1\nprint(total, acima_de_mil)' },
          { h: 'range: sequências de números',
            items: [
              '<code>range(5)</code> → 0, 1, 2, 3, 4 · <code>range(1, 6)</code> → 1 a 5 · <code>range(0, 10, 2)</code> → de 2 em 2.',
              'Útil para repetir algo N vezes ou gerar meses, anos, parcelas.'
            ],
            code: 'for mes in range(1, 13):\n    print(f"Mês {mes:02d}", end="  ")' },
          { h: 'enumerate: item e posição',
            code: 'produtos = ["caneta", "lápis", "borracha"]\nfor i, p in enumerate(produtos, start=1):\n    print(i, p)' }
        ],
        pratica: [
          { t: 'escolha', q: 'Quantas linhas este código imprime?', codigo: 'for x in [1, 2, 3]:\n    print(x)', op: ['3', '1', '6'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'total = 0\nfor v in [5, 10, 15]:\n    total += v\nprint(total)', op: ['30', '15', '5'], a: 0 },
          { t: 'escolha', q: 'Quais números range(1, 4) gera?', op: ['1, 2, 3', '1, 2, 3, 4', '0, 1, 2, 3'], a: 0, exp: 'O range para ANTES do fim, como a fatia.' },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'c = 0\nfor v in [800, 1200, 950, 3000]:\n    if v > 1000:\n        c += 1\nprint(c)', op: ['2', '4', '1'], a: 0 },
          { t: 'escolha', q: 'Onde deve ficar "total = 0"?', op: ['Antes do for', 'Dentro do for', 'Depois do for'], a: 0, exp: 'Se ficar dentro do for, o total volta a zero a cada volta.' },
          { t: 'lacuna', codigo: true, frase: 'for cidade ___ cidades:\n    print(cidade)', op: ['in', 'of', 'from'], a: 0, pt: 'Percorra a lista de cidades.' },
          { t: 'ordenar', q: 'Monte a soma das vendas com acumulador.', linhas: ['total = 0', 'for v in vendas:', '    total += v', 'print(total)'] },
          { t: 'pares', pares: [['for x in lista', 'para cada item'], ['range(5)', '0 a 4'], ['enumerate', 'posição e item'], ['+= 1', 'contar'], ['total = 0', 'acumulador']] }
        ],
        desafios: [
          { titulo: 'Limpando a lista de clientes',
            cenario: 'A lista <code>clientes</code> veio com espaços e maiúsculas bagunçadas. Usando um laço, crie a lista <code>limpos</code> com cada nome sem espaços nas pontas e com iniciais maiúsculas, e conte na variável <code>de_goias</code> quantos clientes têm <code>"- GO"</code> no fim.',
            inicial: 'clientes = ["  ana souza - GO", "BRUNO LIMA - DF ", "carla dias - GO", " diego alves - SP", "elisa rocha - GO "]\nlimpos = []\nde_goias = 0\n',
            testes: [
              { py: "assert limpos == ['Ana Souza - Go', 'Bruno Lima - Df', 'Carla Dias - Go', 'Diego Alves - Sp', 'Elisa Rocha - Go']", msg: 'limpos tem os 5 nomes padronizados' },
              { py: 'assert de_goias == 3', msg: 'de_goias está correto' }
            ],
            dicas: ['Dentro do for: limpo = c.strip().title() e depois limpos.append(limpo)', 'Para contar Goiás, verifique no texto limpo e original: c.strip().upper().endswith("- GO")'],
            solucao: 'clientes = ["  ana souza - GO", "BRUNO LIMA - DF ", "carla dias - GO", " diego alves - SP", "elisa rocha - GO "]\nlimpos = []\nde_goias = 0\nfor c in clientes:\n    limpos.append(c.strip().title())\n    if c.strip().upper().endswith("- GO"):\n        de_goias += 1\nprint(limpos)\nprint(de_goias)' }
        ]
      },
      {
        id: 'py-while-controle', title: 'while, break e continue',
        desc: 'O laço que repete enquanto uma condição for verdadeira, e como sair ou pular voltas com break e continue.',
        objetivos: [
          'Usar while quando não se sabe quantas voltas serão necessárias',
          'Interromper um laço com break e pular uma volta com continue',
          'Evitar laços infinitos'
        ],
        body: 'O for é para "cada item de uma lista". O while é para "enquanto algo for verdade": enquanto a dívida não for quitada, enquanto o estoque não acabar. Ele é poderoso — e é o único jeito de criar um laço infinito sem querer, então atenção.',
        content: [
          { h: 'while',
            p: 'Repete enquanto a condição for <code>True</code>. Algo dentro do laço precisa mudar a condição, senão ele nunca termina.',
            code: 'saldo = 1000\nmeses = 0\nwhile saldo > 0:\n    saldo -= 300\n    meses += 1\nprint(f"Quitado em {meses} meses")' },
          { h: 'break: sair do laço',
            code: 'pedidos = [120, 340, 0, 560]\nfor p in pedidos:\n    if p == 0:\n        print("Pedido inválido, parando")\n        break\n    print(f"Processando {p}")' },
          { h: 'continue: pular para a próxima volta',
            code: 'valores = [100, -50, 200, -10, 300]\ntotal = 0\nfor v in valores:\n    if v < 0:\n        continue  # ignora devoluções\n    total += v\nprint(total)' },
          { h: 'Cuidado com o laço infinito',
            p: '<code>while True:</code> só termina com um <code>break</code>. Se o seu código travar no laboratório, ele é interrompido em 20 segundos — revise a condição e o que muda a cada volta.' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'n = 0\nwhile n < 3:\n    n += 1\nprint(n)', op: ['3', '2', '0'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'for x in [1, 2, 3, 4]:\n    if x == 3:\n        break\n    print(x, end=" ")', op: ['1 2', '1 2 3', '1 2 4'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'for x in [1, 2, 3, 4]:\n    if x == 3:\n        continue\n    print(x, end=" ")', op: ['1 2 4', '1 2', '3'], a: 0 },
          { t: 'escolha', q: 'Por que este código nunca termina?', codigo: 'x = 10\nwhile x > 0:\n    print(x)', op: ['x nunca muda dentro do laço', 'Falta break no fim', 'print não funciona no while'], a: 0 },
          { t: 'escolha', q: 'Quando usar while em vez de for?', op: ['Quando não se sabe quantas voltas serão necessárias', 'Sempre que houver uma lista', 'Nunca'], a: 0, opPt: true },
          { t: 'lacuna', codigo: true, frase: 'if v < 0:\n    ___  # pula valores negativos', op: ['continue', 'break', 'pass'], a: 0, pt: 'Pule para a próxima volta.' },
          { t: 'pares', pares: [['while', 'enquanto'], ['break', 'sai do laço'], ['continue', 'pula a volta'], ['while True', 'só para com break'], ['saldo -= 300', 'muda a condição']] }
        ],
        desafios: [
          { titulo: 'Quanto tempo para juntar?',
            cenario: 'Você quer juntar <strong>R$ 10.000</strong>. Começa com R$ 0, guarda <strong>R$ 750</strong> por mês e o saldo rende <strong>1% ao mês</strong> (o rendimento entra antes do depósito). Com um <code>while</code>, calcule em quantos <code>meses</code> o saldo chega a pelo menos 10 mil e guarde o saldo final em <code>saldo</code>.',
            inicial: 'objetivo = 10000\ndeposito = 750\ntaxa = 0.01\nsaldo = 0\nmeses = 0\n',
            testes: [
              { py: 'assert meses == 13', msg: 'número de meses correto' },
              { py: 'assert 10000 <= saldo < 10800', msg: 'saldo final correto' }
            ],
            dicas: ['while saldo < objetivo: ... dentro, aplique o rendimento, some o depósito e conte o mês.', 'Rendimento: saldo = saldo * (1 + taxa); depois saldo += deposito; meses += 1'],
            solucao: 'objetivo = 10000\ndeposito = 750\ntaxa = 0.01\nsaldo = 0\nmeses = 0\nwhile saldo < objetivo:\n    saldo = saldo * (1 + taxa)\n    saldo += deposito\n    meses += 1\nprint(f"{meses} meses, saldo R$ {saldo:,.2f}")' }
        ]
      },
      {
        id: 'py-compreensao-projeto', title: 'List comprehension e o projeto do módulo',
        desc: 'A forma compacta de criar listas a partir de outras — e um projeto que junta listas, laços e decisões.',
        objetivos: [
          'Criar listas com list comprehension',
          'Filtrar listas com if dentro da comprehension',
          'Combinar listas e laços para analisar dados'
        ],
        body: 'Muitos laços servem só para criar uma lista nova a partir de outra: aplicar um desconto, filtrar valores. O Python tem uma forma curta e muito usada para isso — e entender essa forma ajuda a ler o código de qualquer projeto de dados.',
        content: [
          { h: 'List comprehension',
            p: '<code>[expressão for item in lista]</code> cria uma lista nova numa linha só.',
            code: 'precos = [10.0, 25.5, 8.9]\ncom_desconto = [p * 0.9 for p in precos]\nprint(com_desconto)' },
          { h: 'Com filtro',
            code: 'vendas = [1200, 850, 2300, 640, 1800]\ngrandes = [v for v in vendas if v > 1000]\nprint(grandes, len(grandes))' },
          { h: 'zip: duas listas lado a lado',
            p: '<code>zip</code> percorre duas listas ao mesmo tempo — como duas colunas de uma planilha.',
            code: 'produtos = ["caneta", "caderno", "mochila"]\nprecos = [2.5, 18.9, 129.0]\nfor produto, preco in zip(produtos, precos):\n    print(f"{produto:<10} R$ {preco:>7.2f}")' },
          { h: 'O caminho até o pandas',
            p: 'Você acabou de trabalhar com "colunas" em listas separadas. O pandas junta essas colunas numa tabela (DataFrame) e faz filtros, somas e médias sem você escrever o laço — mas por baixo é exatamente essa lógica.' }
        ],
        pratica: [
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print([x * 2 for x in [1, 2, 3]])', op: ['[2, 4, 6]', '[1, 2, 3, 1, 2, 3]', '12'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'print([x for x in [5, 12, 8, 20] if x > 10])', op: ['[12, 20]', '[5, 8]', '2'], a: 0 },
          { t: 'escolha', q: 'O que este código mostra?', codigo: 'for a, b in zip(["x", "y"], [1, 2]):\n    print(a, b)', op: ['x 1\ny 2', 'x y\n1 2', "('x', 'y')"], a: 0 },
          { t: 'escolha', q: 'Qual comprehension pega só os nomes que começam com A?', op: ['[n for n in nomes if n.startswith("A")]', '[n if n.startswith("A") for n in nomes]', 'nomes.filter("A")'], a: 0 },
          { t: 'lacuna', codigo: true, frase: 'grandes = [v for v in vendas ___ v > 1000]', op: ['if', 'when', 'where'], a: 0, pt: 'Filtre só as vendas acima de mil.' },
          { t: 'ordenar', q: 'Monte o mesmo resultado com um laço comum.', linhas: ['grandes = []', 'for v in vendas:', '    if v > 1000:', '        grandes.append(v)'] },
          { t: 'pares', pares: [['[x for x in l]', 'nova lista'], ['if no fim', 'filtro'], ['zip', 'duas listas juntas'], ['append', 'adiciona item'], ['DataFrame', 'tabela do pandas']] }
        ],
        desafios: [
          { titulo: 'Relatório de produtos',
            cenario: 'Você tem três listas paralelas: <code>produtos</code>, <code>quantidades</code> vendidas e <code>precos</code>. Crie a lista <code>faturamentos</code> (quantidade × preço de cada produto), descubra o <code>campeao</code> (nome do produto com maior faturamento) e crie a lista <code>sem_venda</code> com os nomes dos produtos com quantidade 0.',
            inicial: 'produtos = ["Caneta", "Caderno", "Mochila", "Estojo", "Régua"]\nquantidades = [320, 85, 12, 0, 140]\nprecos = [2.5, 18.9, 129.0, 24.9, 3.2]\n',
            testes: [
              { py: 'assert [round(f, 2) for f in faturamentos] == [800.0, 1606.5, 1548.0, 0.0, 448.0]', msg: 'faturamentos corretos' },
              { py: "assert campeao == 'Caderno'", msg: 'campeao correto' },
              { py: "assert sem_venda == ['Estojo']", msg: 'sem_venda correto' }
            ],
            dicas: ['faturamentos = [q * p for q, p in zip(quantidades, precos)]', 'O campeão: ache o índice do maior faturamento com faturamentos.index(max(faturamentos)) e use em produtos[...].', 'sem_venda: comprehension com zip(produtos, quantidades) e if q == 0'],
            solucao: 'produtos = ["Caneta", "Caderno", "Mochila", "Estojo", "Régua"]\nquantidades = [320, 85, 12, 0, 140]\nprecos = [2.5, 18.9, 129.0, 24.9, 3.2]\nfaturamentos = [q * p for q, p in zip(quantidades, precos)]\ncampeao = produtos[faturamentos.index(max(faturamentos))]\nsem_venda = [n for n, q in zip(produtos, quantidades) if q == 0]\nprint(faturamentos, campeao, sem_venda)' }
        ]
      }
    ]
  }
];
