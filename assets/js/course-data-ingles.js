// Curso de Inglês do básico ao avançado (A1 → C1 do Quadro Europeu, CEFR) — TECH SANTOS BR.
// Mesmo formato dos cursos de Excel e Fabric: teoria completa em texto + áudio,
// mais a prática interativa estilo Duolingo de cada aula (campo `pratica`,
// motor em assets/js/pratica.js; tipos de exercício documentados lá).
// Texto e exercícios originais. Frases em inglês marcadas com lang="en" ficam
// clicáveis (o aluno ouve a pronúncia); áudios gerados por tools/ingles_audio.py.
// Ids de aula com prefixo "en-" para não colidir com o progresso dos outros cursos.
const EN = t => `<b lang="en">${t}</b>`;

const COURSE = [
  {
    id: 'en-m01', title: 'Módulo 01 · Primeiros passos: cumprimentos, verbo to be, apresentações e números (A1)', kind: 'video',
    lessons: [
      {
        id: 'en-cumprimentos', title: 'Hello! Cumprimentos e despedidas',
        desc: 'Como cumprimentar, perguntar se a pessoa está bem e se despedir em inglês — no dia a dia e no trabalho.',
        objetivos: [
          'Cumprimentar de acordo com o horário e o grau de formalidade',
          'Perguntar e responder "como você está?" de vários jeitos',
          'Se despedir e responder a um "nice to meet you"'
        ],
        body: 'A primeira frase de qualquer conversa é um cumprimento — e ela já mostra se você soa natural ou "de livro". Nesta aula você aprende as formas que os falantes nativos realmente usam, quando cada uma é formal ou informal, e as respostas certas para cada pergunta. Clique em qualquer palavra destacada para ouvir a pronúncia.',
        content: [
          { h: 'Cumprimentos: do mais informal ao mais formal',
            items: [
              `${EN('Hi!')} e ${EN('Hey!')} — "Oi!". Os mais usados no dia a dia, com amigos e colegas de trabalho.`,
              `${EN('Hello!')} — "Olá!". Serve para qualquer situação, formal ou informal. Na dúvida, use ${EN('Hello')}.`,
              `${EN('Good morning')} — "Bom dia" (até o meio-dia). ${EN('Good afternoon')} — "Boa tarde" (do meio-dia até umas 18h). ${EN('Good evening')} — "Boa noite" ao <strong>chegar</strong> (à noite).`,
              `Atenção: ${EN('Good night')} <strong>não</strong> é cumprimento — é despedida, usada para ir embora à noite ou ir dormir. Chegou numa reunião às 20h? Diga ${EN('Good evening')}.`
            ] },
          { h: 'Como você está? — perguntas e respostas',
            p: `A pergunta clássica é ${EN('How are you?')} ("Como você está?"). Entre amigos aparecem formas mais soltas: ${EN("How's it going?")} ("Como vão as coisas?") e ${EN("What's up?")} ("E aí?").`,
            items: [
              `Respostas comuns: ${EN("I'm fine, thanks.")} · ${EN("I'm good, thank you.")} · ${EN('Great!')} · ${EN('Not bad.')} ("Nada mal.")`,
              `Devolva a pergunta: ${EN('And you?')} ou ${EN('How about you?')} — "E você?". Responder sem devolver soa seco.`,
              `${EN("What's up?")} normalmente se responde com ${EN('Not much.')} ("Nada de mais.") — não com "I'm fine".`
            ] },
          { h: 'Conhecendo alguém',
            items: [
              `${EN('Nice to meet you.')} — "Prazer em conhecer você." Resposta: ${EN('Nice to meet you too.')} ("Igualmente.")`,
              `${EN('Pleased to meet you.')} — versão um pouco mais formal, comum em reuniões de negócio.`,
              `Em inglês não se diz "prazer" sozinho como em português; use a frase inteira.`
            ] },
          { h: 'Despedidas',
            items: [
              `${EN('Goodbye')} / ${EN('Bye!')} — "Tchau". ${EN('Bye')} é o mais comum.`,
              `${EN('See you later!')} / ${EN('See you!')} — "Até mais!". ${EN('See you tomorrow!')} — "Até amanhã!"`,
              `${EN('Have a nice day!')} — "Tenha um bom dia!" — ouvido o tempo todo em lojas e atendimento.`,
              `${EN('Take care!')} — "Se cuida!" — despedida carinhosa entre conhecidos.`
            ] },
          { h: 'Dica de pronúncia',
            p: `O "h" de ${EN('hello')}, ${EN('hi')} e ${EN('how')} é aspirado, como um "r" leve de "rato" no sotaque carioca: "rêlou", "rai", "ráu". E o "th" de ${EN('thanks')} se faz com a ponta da língua entre os dentes, soprando o ar — não é "t" nem "f".` }
        ],
        pratica: [
          { t: 'escolha', q: 'São 9h da manhã e você chega ao escritório. Qual cumprimento usar?', op: ['Good morning!', 'Good night!', 'Good evening!'], a: 0, exp: `Good morning vale até o meio-dia. Good night nunca é cumprimento de chegada.` },
          { t: 'pares', pares: [['Hello', 'Olá'], ['Goodbye', 'Tchau'], ['See you later', 'Até mais'], ['Take care', 'Se cuida'], ['Good afternoon', 'Boa tarde']] },
          { t: 'escolha', ouvir: 'Nice to meet you.', op: ['Nice to meet you.', 'Nice to see you.', 'Have a nice day.'], a: 0 },
          { t: 'montar', pt: 'Como você está?', en: 'How are you?', extra: ['is', 'what'] },
          { t: 'escolha', q: `Alguém te diz ${EN("What's up?")} Qual a resposta mais natural?`, op: ['Not much.', 'Good night.', 'Nice to meet you too.'], a: 0, exp: `What's up? pergunta "o que há de novo?", por isso a resposta natural é Not much (nada de mais).` },
          { t: 'lacuna', frase: "I'm fine, ___. And you?", op: ['thanks', 'bye', 'night'], a: 0, pt: 'Estou bem, obrigado. E você?' },
          { t: 'escolha', q: 'São 20h e você vai embora da festa. O que dizer?', op: ['Good night!', 'Good evening!', 'Good afternoon!'], a: 0, exp: `Good evening é para chegar; Good night é para ir embora ou ir dormir.` },
          { t: 'digitar', ouvir: 'See you tomorrow!', en: 'See you tomorrow' },
          { t: 'montar', pt: 'Prazer em conhecer você também.', en: 'Nice to meet you too', extra: ['see', 'are'] },
          { t: 'digitar', pt: 'Tenha um bom dia!', en: 'Have a nice day', alt: ['Have a good day'] },
          { t: 'falar', en: 'Hello! How are you?' },
          { t: 'falar', en: 'Nice to meet you.' }
        ]
      },
      {
        id: 'en-verbo-to-be', title: 'O verbo to be: ser e estar',
        desc: 'O verbo mais importante do inglês: as formas am, is e are, as contrações, a negativa e as perguntas.',
        objetivos: [
          'Conjugar o verbo to be no presente com todos os pronomes',
          'Usar as contrações (I\'m, you\'re, she\'s...) como os nativos',
          'Montar frases negativas e perguntas com o verbo to be'
        ],
        body: 'Em português temos dois verbos, "ser" e "estar". Em inglês os dois são um só: o verbo to be. "Eu sou professor" e "Eu estou cansado" usam o mesmo verbo. Ele tem só três formas no presente — am, is e are — e quem dominar esta aula já consegue montar centenas de frases.',
        content: [
          { h: 'Os pronomes pessoais',
            items: [
              `${EN('I')} (eu) — sempre com letra maiúscula, mesmo no meio da frase.`,
              `${EN('you')} (você / vocês) — a mesma palavra para singular e plural.`,
              `${EN('he')} (ele) · ${EN('she')} (ela) · ${EN('it')} (ele/ela para coisas, animais, lugares e o tempo).`,
              `${EN('we')} (nós) · ${EN('they')} (eles/elas — pessoas ou coisas).`
            ] },
          { h: 'Afirmativa: am, is, are',
            items: [
              `${EN('I am')} → ${EN("I'm")} — ${EN("I'm a teacher.")} (Eu sou professor.)`,
              `${EN('you are')} → ${EN("you're")} — ${EN("You're late.")} (Você está atrasado.)`,
              `${EN('he is')} → ${EN("he's")} · ${EN('she is')} → ${EN("she's")} · ${EN('it is')} → ${EN("it's")} — ${EN("It's cold.")} (Está frio.)`,
              `${EN('we are')} → ${EN("we're")} · ${EN('they are')} → ${EN("they're")} — ${EN("They're from Brazil.")} (Eles são do Brasil.)`,
              `Regra prática: <strong>am</strong> só com I; <strong>is</strong> com he/she/it (uma pessoa ou coisa); <strong>are</strong> com you/we/they.`
            ] },
          { h: 'Negativa: basta colocar not',
            p: `Coloque ${EN('not')} depois do verbo: ${EN("I am not tired.")} → ${EN("I'm not tired.")} Com is e are há duas contrações possíveis: ${EN("She isn't here")} ou ${EN("She's not here")}; ${EN("They aren't ready")} ou ${EN("They're not ready")}. Com I só existe ${EN("I'm not")} (nunca "I amn't").` },
          { h: 'Perguntas: inverta a ordem',
            p: `Para perguntar, o verbo vem antes do sujeito: ${EN('You are Brazilian.')} → ${EN('Are you Brazilian?')} · ${EN('She is a doctor.')} → ${EN('Is she a doctor?')}`,
            items: [
              `Respostas curtas: ${EN('Yes, I am.')} / ${EN("No, I'm not.")} · ${EN('Yes, she is.')} / ${EN("No, she isn't.")}`,
              `Na resposta curta afirmativa <strong>não</strong> se usa contração: diga ${EN('Yes, I am.')} e nunca "Yes, I'm".`
            ] },
          { h: 'Erros clássicos de brasileiro',
            items: [
              `Esquecer o sujeito: em português dizemos "É bom", mas em inglês a frase precisa de sujeito — ${EN("It's good.")} (nunca só "Is good").`,
              `Idade e sensações usam to be: ${EN("I'm 30 years old.")} ${EN("I'm hungry.")} ${EN("I'm cold.")} — e não "I have 30 years" nem "I have hunger".`
            ] }
        ],
        pratica: [
          { t: 'lacuna', frase: 'I ___ a student.', op: ['am', 'is', 'are'], a: 0, pt: 'Eu sou estudante.' },
          { t: 'lacuna', frase: 'She ___ my sister.', op: ['am', 'is', 'are'], a: 1, pt: 'Ela é minha irmã.' },
          { t: 'lacuna', frase: 'They ___ from Brazil.', op: ['am', 'is', 'are'], a: 2, pt: 'Eles são do Brasil.' },
          { t: 'pares', pares: [["I'm", 'I am'], ["you're", 'you are'], ["she's", 'she is'], ["we're", 'we are'], ["isn't", 'is not']] },
          { t: 'montar', pt: 'Ela não está em casa.', en: "She isn't at home", alt: ["She's not at home", 'She is not at home'], extra: ['are', 'in'] },
          { t: 'escolha', q: 'Qual frase está correta?', op: ["It's cold today.", 'Is cold today.', 'It cold today.'], a: 0, exp: `Frase em inglês sempre tem sujeito. Para tempo e clima o sujeito é it: It's cold.` },
          { t: 'montar', pt: 'Você é brasileiro?', en: 'Are you Brazilian?', extra: ['is', 'do'] },
          { t: 'escolha', q: `Responda: ${EN('Are you tired?')} (sim)`, op: ['Yes, I am.', "Yes, I'm.", 'Yes, I is.'], a: 0, exp: `Parece certo, mas não é: na resposta curta afirmativa o verbo fica no fim da frase e aí não pode ser contraído. "Yes, I'm." soa incompleto para um nativo. A contração só vale com algo depois: "I'm tired." Na negativa pode: "No, I'm not."` },
          { t: 'escolha', q: 'Como se diz "Eu tenho 25 anos"?', op: ["I'm 25 years old.", 'I have 25 years.', 'I have 25 years old.'], a: 0, exp: `Em inglês idade usa o verbo to be (ser/estar), nunca have (ter).` },
          { t: 'digitar', pt: 'Nós estamos prontos.', en: "We're ready", alt: ['We are ready'] },
          { t: 'digitar', ouvir: "He isn't a doctor.", en: "He isn't a doctor", alt: ['He is not a doctor', "He's not a doctor"] },
          { t: 'falar', en: "I'm not tired." },
          { t: 'falar', en: 'Are you ready?' }
        ]
      },
      {
        id: 'en-apresentacoes', title: 'Apresentando-se: nome, origem e profissão',
        desc: 'Como dizer quem você é, de onde vem e o que faz — e como perguntar isso a outra pessoa.',
        objetivos: [
          'Apresentar-se com nome, cidade, país e profissão',
          'Fazer as perguntas "Where are you from?" e "What do you do?"',
          'Usar os artigos a e an antes de profissões'
        ],
        body: 'Com cumprimentos e o verbo to be você já consegue se apresentar. Esta aula junta tudo numa apresentação completa, do jeito que acontece numa reunião online, numa viagem ou numa entrevista.',
        content: [
          { h: 'Nome',
            items: [
              `${EN('My name is Ana.')} ou simplesmente ${EN("I'm Ana.")} — o segundo é mais comum na fala.`,
              `Pergunta: ${EN("What's your name?")} — "Qual é o seu nome?"`,
              `Soletrar: ${EN('How do you spell that?')} — "Como se escreve?" (muito usado ao telefone e em cadastros).`
            ] },
          { h: 'Origem: cidade e país',
            items: [
              `${EN("I'm from Brazil.")} · ${EN("I'm from São Paulo.")} — "Eu sou de...". Use ${EN('from')} para origem.`,
              `Pergunta: ${EN('Where are you from?')} — "De onde você é?"`,
              `Nacionalidade: ${EN("I'm Brazilian.")} Em inglês, países e nacionalidades sempre com letra maiúscula: ${EN('Brazil')}, ${EN('Brazilian')}, ${EN('American')}, ${EN('Portuguese')}.`,
              `Onde mora agora: ${EN('I live in Goiânia.')} — "Eu moro em Goiânia." (cidade usa ${EN('in')}).`
            ] },
          { h: 'Profissão e os artigos a / an',
            p: `Para dizer a profissão use ${EN("I'm a...")} — e aqui está uma diferença importante: em português dizemos "sou professor", sem artigo; em inglês o artigo é obrigatório: ${EN("I'm a teacher.")}`,
            items: [
              `${EN('a')} antes de <strong>som</strong> de consoante: ${EN('a doctor')}, ${EN('a lawyer')}, ${EN('a student')}, ${EN('a university')} (o "u" soa "iú").`,
              `${EN('an')} antes de <strong>som</strong> de vogal: ${EN('an engineer')}, ${EN('an analyst')}, ${EN('an hour')} (o "h" é mudo).`,
              `Pergunta: ${EN('What do you do?')} — literalmente "O que você faz?", significa "Qual é a sua profissão?". Resposta: ${EN("I'm a data analyst.")} ou ${EN('I work in IT.')}`
            ] },
          { h: 'Apresentação completa (modelo)',
            p: `${EN("Hi! I'm Carlos. I'm from Brazil and I live in Goiânia. I'm a data analyst. Nice to meet you!")}` }
        ],
        pratica: [
          { t: 'escolha', q: 'Como perguntar "De onde você é?"', op: ['Where are you from?', 'Where do you live from?', 'Where you are from?'], a: 0 },
          { t: 'lacuna', frase: "I'm ___ engineer.", op: ['a', 'an', 'the'], a: 1, pt: 'Eu sou engenheiro.', exp: `engineer começa com som de vogal, então an.` },
          { t: 'lacuna', frase: "She's ___ doctor.", op: ['a', 'an', '—'], a: 0, pt: 'Ela é médica.' },
          { t: 'lacuna', frase: 'It takes ___ hour.', op: ['a', 'an'], a: 1, pt: 'Leva uma hora.', exp: `O h de hour é mudo: a palavra começa com som de vogal ("áuer"), então an.` },
          { t: 'escolha', q: `O que significa ${EN('What do you do?')}`, op: ['Qual é a sua profissão?', 'O que você está fazendo agora?', 'O que você quer fazer?'], a: 0, opPt: true },
          { t: 'pares', pares: [['teacher', 'professor'], ['lawyer', 'advogado'], ['engineer', 'engenheiro'], ['doctor', 'médico'], ['nurse', 'enfermeiro']] },
          { t: 'montar', pt: 'Eu moro em Goiânia.', en: 'I live in Goiânia', extra: ['on', 'am'] },
          { t: 'montar', pt: 'Eu sou do Brasil.', en: "I'm from Brazil", alt: ['I am from Brazil'], extra: ['in', 'of'] },
          { t: 'escolha', ouvir: "What's your name?", op: ["What's your name?", 'Where are you from?', 'What do you do?'], a: 0 },
          { t: 'digitar', pt: 'Eu sou analista de dados.', en: "I'm a data analyst", alt: ['I am a data analyst'] },
          { t: 'digitar', ouvir: 'How do you spell that?', en: 'How do you spell that' },
          { t: 'falar', en: "Hi! I'm from Brazil." },
          { t: 'falar', en: 'What do you do?' }
        ]
      },
      {
        id: 'en-numeros', title: 'Números, idade e telefone',
        desc: 'Os números de 0 a 100, como dizer a idade, ditar um telefone e não confundir thirteen com thirty.',
        objetivos: [
          'Contar de 0 a 100 e entender números ditos em voz alta',
          'Perguntar e dizer a idade corretamente',
          'Ditar e anotar números de telefone'
        ],
        body: 'Números aparecem em toda conversa real: idade, telefone, preço, horário, endereço. Nesta aula você aprende a formar qualquer número até 100 e as armadilhas de pronúncia que mais confundem quem está começando.',
        content: [
          { h: 'De 0 a 12: decore estes',
            p: `${EN('zero, one, two, three, four, five, six, seven, eight, nine, ten, eleven, twelve')}. Eles não seguem regra — são a base de todos os outros.` },
          { h: 'De 13 a 19: terminação -teen',
            p: `${EN('thirteen, fourteen, fifteen, sixteen, seventeen, eighteen, nineteen')}. Repare em ${EN('thirteen')} (não "threeteen") e ${EN('fifteen')} (não "fiveteen").` },
          { h: 'Dezenas: terminação -ty',
            items: [
              `${EN('twenty, thirty, forty, fifty, sixty, seventy, eighty, ninety')} e ${EN('one hundred')}.`,
              `${EN('forty')} se escreve <strong>sem</strong> o "u" de ${EN('four')} — erro muito comum na escrita.`,
              `Para os números do meio, junte com hífen: ${EN('twenty-one')}, ${EN('thirty-five')}, ${EN('ninety-nine')}.`
            ] },
          { h: 'A armadilha: -teen × -ty',
            p: `${EN('thirteen')} (13) e ${EN('thirty')} (30) soam parecidos. A diferença está na sílaba forte: nos -teen a força vai no final (thir-<strong>TEEN</strong>, som longo "tiin"); nos -ty a força vai no começo (<strong>THIR</strong>-ty, final curto "ri" ou "ti"). Ouça os pares: ${EN('fourteen')} / ${EN('forty')} · ${EN('fifteen')} / ${EN('fifty')}. Na dúvida, confirme: ${EN('One five or five zero?')}` },
          { h: 'Idade',
            items: [
              `Pergunta: ${EN('How old are you?')} — literalmente "Quão velho você é?".`,
              `Resposta: ${EN("I'm 34.")} ou ${EN("I'm 34 years old.")} — sempre com to be. "I have 34 years" é o erro número 1 de brasileiro.`
            ] },
          { h: 'Telefone',
            items: [
              `Pergunta: ${EN("What's your phone number?")}`,
              `Dita-se dígito por dígito: 9 8 1 2... = ${EN('nine, eight, one, two')}. O zero costuma ser dito como "oh": ${EN('oh')}.`,
              `Dígitos repetidos podem usar ${EN('double')}: 55 = ${EN('double five')}.`
            ] }
        ],
        pratica: [
          { t: 'pares', pares: [['thirteen', '13'], ['thirty', '30'], ['fifteen', '15'], ['fifty', '50'], ['eighteen', '18']] },
          { t: 'escolha', ouvir: 'forty', op: ['14', '40', '4'], a: 1 },
          { t: 'escolha', ouvir: 'sixteen', op: ['16', '60', '6'], a: 0 },
          { t: 'escolha', q: 'Como se escreve 40?', op: ['forty', 'fourty', 'fourteen'], a: 0, exp: `four tem "u", mas forty perde o "u". fourteen (14) mantém.` },
          { t: 'escolha', q: 'Como dizer "Eu tenho 28 anos"?', op: ["I'm twenty-eight.", 'I have twenty-eight years.', 'I have twenty-eight.'], a: 0, exp: `Idade usa to be: I'm 28 ou I'm 28 years old.` },
          { t: 'montar', pt: 'Quantos anos você tem?', en: 'How old are you?', extra: ['many', 'have'] },
          { t: 'digitar', pt: 'Escreva por extenso: 21', en: 'twenty-one', alt: ['twenty one'] },
          { t: 'digitar', pt: 'Escreva por extenso: 99', en: 'ninety-nine', alt: ['ninety nine'] },
          { t: 'lacuna', frase: 'My number is nine, ___ five, two...', op: ['double', 'two', 'twice'], a: 0, pt: 'Meu número é 9, 55, 2...' },
          { t: 'digitar', ouvir: "What's your phone number?", en: "What's your phone number", alt: ['What is your phone number'] },
          { t: 'falar', en: "I'm thirty-four years old." },
          { t: 'falar', en: 'thirteen, thirty' }
        ]
      }
    ]
  }
];
