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
];
