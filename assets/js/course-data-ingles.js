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
  ,
  {
    id: 'en-m02', title: 'Módulo 02 · Pessoas e família: possessivos, have/has, this/that e descrições (A1)', kind: 'video',
    lessons: [
      {
        id: 'en-familia', title: 'My family: a família e os possessivos',
        desc: 'Os membros da família em inglês e como dizer "meu", "seu", "dele", "dela" — incluindo o \'s, que não existe em português.',
        objetivos: [
          'Nomear os membros da família em inglês',
          'Usar os adjetivos possessivos my, your, his, her, our e their',
          'Indicar posse com \'s (Ana\'s brother = o irmão da Ana)'
        ],
        body: 'Falar da família é um dos assuntos mais comuns numa conversa — e um ótimo treino para os possessivos, que confundem muito quem fala português. Em inglês, "dele" e "dela" são palavras diferentes, e o possessivo vem antes do nome, não depois.',
        content: [
          { h: 'A família',
            items: [
              `${EN('mother')} (mãe) e ${EN('father')} (pai) — no dia a dia: ${EN('mom')} e ${EN('dad')}. Juntos: ${EN('parents')} (pais). Cuidado: ${EN('parents')} são só pai e mãe; "parentes" é ${EN('relatives')}.`,
              `${EN('brother')} (irmão) e ${EN('sister')} (irmã). Não existe uma palavra comum para "irmãos" misturados — diga ${EN('brothers and sisters')}, ou ${EN('siblings')} (mais formal).`,
              `${EN('son')} (filho) e ${EN('daughter')} (filha); juntos: ${EN('children')} ou, informal, ${EN('kids')}.`,
              `${EN('husband')} (marido) e ${EN('wife')} (esposa). ${EN('grandmother')} e ${EN('grandfather')} (avós), ${EN('uncle')} (tio), ${EN('aunt')} (tia), ${EN('cousin')} (primo ou prima — a mesma palavra).`
            ] },
          { h: 'Os possessivos: my, your, his, her...',
            items: [
              `${EN('my')} (meu, minha, meus, minhas) · ${EN('your')} (seu, sua, de vocês) · ${EN('our')} (nosso) · ${EN('their')} (deles, delas).`,
              `${EN('his')} = dele · ${EN('her')} = dela. A escolha depende de <strong>quem é o dono</strong>, não da coisa: ${EN('Ben and his sister')} (o Ben e a irmã dele) · ${EN('Ava and her brother')} (a Ava e o irmão dela).`,
              `${EN('its')} = dele/dela para coisas e animais: ${EN('The dog is in its house.')}`,
              `O possessivo não muda no plural e não leva artigo: ${EN('my brothers')} (meus irmãos) — nunca "the my brothers".`
            ] },
          { h: 'O \'s: o "de" do inglês',
            p: `Para dizer "o irmão da Ana", o inglês inverte a ordem e usa apóstrofo + s: ${EN("Ana's brother")}. Outros exemplos: ${EN("my father's car")} (o carro do meu pai) · ${EN("Ben's wife")} (a esposa do Ben). Se a palavra já termina em s de plural, só o apóstrofo: ${EN("my parents' house")} (a casa dos meus pais).` },
          { h: 'Cuidado: \'s de posse × \'s de "is"',
            p: `${EN("Ben's brother")} = o irmão do Ben (posse). ${EN("Ben's tall")} = o Ben é alto (contração de ${EN('is')}). O contexto mostra qual é: depois do 's de posse vem sempre um substantivo.` }
        ],
        pratica: [
          { t: 'pares', pares: [['mother', 'mãe'], ['brother', 'irmão'], ['daughter', 'filha'], ['wife', 'esposa'], ['cousin', 'primo / prima']] },
          { t: 'lacuna', frase: 'Ben is with ___ sister.', op: ['his', 'her', 'their'], a: 0, pt: 'O Ben está com a irmã dele.', exp: `O dono é o Ben (homem), então his — mesmo a irmã sendo mulher.` },
          { t: 'lacuna', frase: 'Ava and ___ brother are here.', op: ['his', 'her', 'its'], a: 1, pt: 'A Ava e o irmão dela estão aqui.', exp: `O dono é a Ava, então her — o gênero do irmão não importa.` },
          { t: 'escolha', q: 'Como se diz "o carro do meu pai"?', op: ["my father's car", 'the car of my father', "my father car's"], a: 0 },
          { t: 'escolha', q: `O que significa ${EN('parents')}?`, op: ['pai e mãe', 'parentes', 'padrinhos'], a: 0, opPt: true, exp: 'Falso cognato: parents são só pai e mãe. Parentes em geral são relatives.' },
          { t: 'montar', pt: 'Esta é a minha irmã.', en: 'This is my sister', extra: ['her', 'are'] },
          { t: 'montar', pt: 'O irmão da Ana é médico.', en: "Ana's brother is a doctor", extra: ['of', 'the'] },
          { t: 'lacuna', frase: 'They live with ___ parents.', op: ['their', 'they', 'there'], a: 0, pt: 'Eles moram com os pais deles.' },
          { t: 'escolha', ouvir: 'my parents', op: ['my parents', 'my relatives', 'my brothers'], a: 0 },
          { t: 'digitar', pt: 'Meus pais são do Brasil.', en: 'My parents are from Brazil' },
          { t: 'digitar', ouvir: 'Her husband is a teacher.', en: 'Her husband is a teacher' },
          { t: 'falar', en: 'This is my family.' },
          { t: 'falar', en: "My sister's name is Julia." }
        ]
      },
      {
        id: 'en-have-has', title: 'Have e has: falar do que você tem',
        desc: 'O verbo have no presente — I have, she has — com negativa e pergunta, para falar de família, coisas e características.',
        objetivos: [
          'Usar have com I, you, we, they e has com he, she, it',
          'Fazer a negativa com don\'t have e doesn\'t have',
          'Perguntar com Do you have...? e Does she have...?'
        ],
        body: 'Depois do verbo to be, o have é o verbo que mais aparece nas primeiras conversas: "eu tenho dois irmãos", "ela tem um cachorro". Ele tem só duas formas no presente, e a pergunta e a negativa usam um verbo auxiliar — do ou does — que você vai ver muito no próximo módulo.',
        content: [
          { h: 'Afirmativa: have ou has',
            items: [
              `${EN('I have')}, ${EN('you have')}, ${EN('we have')}, ${EN('they have')} — ${EN('I have two brothers.')} (Eu tenho dois irmãos.)`,
              `${EN('he has')}, ${EN('she has')}, ${EN('it has')} — com uma pessoa ou coisa (terceira pessoa do singular) a forma muda: ${EN('She has a dog.')} (Ela tem um cachorro.)`,
              `Regra prática: se no to be seria ${EN('is')}, no have será ${EN('has')}.`
            ] },
          { h: 'Negativa: don\'t have / doesn\'t have',
            items: [
              `${EN("I don't have a car.")} (Eu não tenho carro.) — ${EN("don't")} = ${EN('do not')}.`,
              `${EN("He doesn't have kids.")} (Ele não tem filhos.) — ${EN("doesn't")} = ${EN('does not')}.`,
              `Atenção: depois de ${EN("doesn't")} o verbo volta para ${EN('have')}: ${EN("She doesn't have")} — nunca "doesn't has". O "s" já foi para o auxiliar.`
            ] },
          { h: 'Pergunta: Do you have...? / Does she have...?',
            items: [
              `${EN('Do you have any brothers or sisters?')} (Você tem irmãos?) — resposta curta: ${EN('Yes, I do.')} / ${EN("No, I don't.")}`,
              `${EN('Does she have a car?')} — ${EN('Yes, she does.')} / ${EN("No, she doesn't.")}`,
              `Na resposta curta repete-se o auxiliar, não o have: ${EN('Yes, I do')} (e não "Yes, I have").`
            ] },
          { h: 'Have também serve para características',
            p: `${EN('She has blue eyes.')} (Ela tem olhos azuis.) · ${EN('He has short hair.')} (Ele tem cabelo curto.) Mas lembre da aula de números: idade usa to be — ${EN("I'm 30")}, nunca "I have 30".` }
        ],
        pratica: [
          { t: 'lacuna', frase: 'She ___ two sisters.', op: ['have', 'has', 'is'], a: 1, pt: 'Ela tem duas irmãs.' },
          { t: 'lacuna', frase: 'We ___ a big family.', op: ['have', 'has', 'are'], a: 0, pt: 'Nós temos uma família grande.' },
          { t: 'lacuna', frase: "He doesn't ___ a car.", op: ['have', 'has', 'having'], a: 0, pt: 'Ele não tem carro.', exp: `Depois de doesn't o verbo fica na forma base (have). O "s" já está no doesn't.` },
          { t: 'escolha', q: `Responda: ${EN('Do you have kids?')} (não)`, op: ["No, I don't.", "No, I haven't.", "No, I'm not."], a: 0 },
          { t: 'montar', pt: 'Você tem irmãos?', en: 'Do you have any brothers or sisters?', extra: ['Are', 'has'] },
          { t: 'montar', pt: 'Ela tem olhos azuis.', en: 'She has blue eyes', extra: ['have', 'is'] },
          { t: 'escolha', q: 'Qual frase está correta?', op: ["I'm 25 years old.", 'I have 25 years.', 'I has 25 years.'], a: 0 },
          { t: 'escolha', ouvir: 'Does she have a dog?', op: ['Does she have a dog?', 'Do she has a dog?', 'Is she have a dog?'], a: 0 },
          { t: 'digitar', pt: 'Eu não tenho carro.', en: "I don't have a car", alt: ['I do not have a car'] },
          { t: 'digitar', ouvir: 'He has two kids.', en: 'He has two kids' },
          { t: 'pares', pares: [['I have', 'eu tenho'], ['she has', 'ela tem'], ["I don't have", 'eu não tenho'], ["he doesn't have", 'ele não tem'], ['Yes, I do.', 'Sim, tenho.']] },
          { t: 'falar', en: 'I have one brother.' },
          { t: 'falar', en: 'Do you have any kids?' }
        ]
      },
      {
        id: 'en-this-that-plurais', title: 'This, that, these, those e os plurais',
        desc: 'Como apontar para coisas e pessoas perto ou longe, e como formar o plural em inglês — inclusive os irregulares.',
        objetivos: [
          'Usar this e that (singular) e these e those (plural) conforme a distância',
          'Formar o plural regular com -s, -es e -ies',
          'Reconhecer os plurais irregulares mais comuns: children, people, men, women'
        ],
        body: 'Quando você mostra uma foto da família ou aponta algo numa loja, precisa de "este", "esse" e "aquele". O inglês simplifica: só existe perto e longe. E o plural, na maioria das vezes, é só acrescentar um "s" — com algumas exceções muito usadas.',
        content: [
          { h: 'Perto e longe, singular e plural',
            items: [
              `${EN('this')} — este, esta, isto (perto, singular): ${EN('This is my brother.')}`,
              `${EN('these')} — estes, estas (perto, plural): ${EN('These are my kids.')}`,
              `${EN('that')} — esse, aquele, aquilo (longe, singular): ${EN('That is my car.')}`,
              `${EN('those')} — esses, aqueles (longe, plural): ${EN('Those are my parents.')}`
            ] },
          { h: 'Apresentando pessoas',
            p: `Para apresentar alguém, o inglês usa ${EN('this')}, não "he" ou "she": ${EN('This is Ben. This is my wife, Julia.')} Ao telefone também: ${EN('Hi, this is Ava.')} (Oi, aqui é a Ava.)` },
          { h: 'Plural regular',
            items: [
              `A maioria ganha só -s: ${EN('brother, brothers')} · ${EN('car, cars')}.`,
              `Terminadas em s, sh, ch, x ganham -es: ${EN('bus, buses')} · ${EN('watch, watches')} · ${EN('box, boxes')}.`,
              `Consoante + y vira -ies: ${EN('family, families')} · ${EN('city, cities')}. Mas vogal + y só ganha -s: ${EN('boy, boys')}.`
            ] },
          { h: 'Plurais irregulares que você vai usar sempre',
            items: [
              `${EN('child, children')} (criança, crianças) · ${EN('person, people')} (pessoa, pessoas).`,
              `${EN('man, men')} (homem, homens) · ${EN('woman, women')} (mulher, mulheres) — repare que a pronúncia do "o" em ${EN('women')} muda: "uímen".`,
              `${EN('wife, wives')} · ${EN('foot, feet')} · ${EN('tooth, teeth')}.`,
              `O adjetivo nunca vai para o plural: ${EN('two tall men')} — e não "talls".`
            ] }
        ],
        pratica: [
          { t: 'lacuna', frase: '___ are my parents.', op: ['Those', 'These', 'That'], a: 0, pt: 'Aqueles são os meus pais. (longe, plural)' },
          { t: 'lacuna', frase: '___ is my sister.', op: ['This', 'These', 'Those'], a: 0, pt: 'Esta é a minha irmã. (perto, singular)' },
          { t: 'lacuna', frase: '___ are my kids.', op: ['These', 'This', 'That'], a: 0, pt: 'Estes são os meus filhos. (perto, plural)' },
          { t: 'pares', pares: [['child', 'children'], ['person', 'people'], ['man', 'men'], ['woman', 'women'], ['family', 'families']] },
          { t: 'escolha', q: 'Qual é o plural de "watch" (relógio)?', op: ['watches', 'watchs', 'watchies'], a: 0 },
          { t: 'escolha', q: 'Qual é o plural de "city"?', op: ['cities', 'citys', 'cityes'], a: 0 },
          { t: 'escolha', q: 'Ao telefone, como dizer "Oi, aqui é a Ana"?', op: ['Hi, this is Ana.', "Hi, I'm here Ana.", 'Hi, here is Ana.'], a: 0 },
          { t: 'montar', pt: 'Aqueles homens são altos.', en: 'Those men are tall', extra: ['talls', 'mans'] },
          { t: 'montar', pt: 'Estas são as minhas filhas.', en: 'These are my daughters', extra: ['This', 'is'] },
          { t: 'digitar', pt: 'Escreva o plural de "child".', en: 'children' },
          { t: 'digitar', ouvir: 'Those people are my friends.', en: 'Those people are my friends' },
          { t: 'falar', en: 'This is my brother, Ben.' },
          { t: 'falar', en: 'These are my children.' }
        ]
      },
      {
        id: 'en-descrever-pessoas', title: 'Descrevendo pessoas: aparência e personalidade',
        desc: 'Adjetivos para descrever como alguém é por fora e por dentro, e a posição do adjetivo na frase em inglês.',
        objetivos: [
          'Descrever aparência: altura, idade, cabelo e olhos',
          'Descrever personalidade com adjetivos comuns',
          'Colocar o adjetivo antes do substantivo e usar very e really'
        ],
        body: 'Fechando o módulo, você vai descrever as pessoas da sua vida. A grande diferença para o português é a ordem: em inglês o adjetivo vem antes da coisa — "a tall man", um homem alto — e nunca muda no plural.',
        content: [
          { h: 'Aparência',
            items: [
              `Altura: ${EN('tall')} (alto) · ${EN('short')} (baixo) · ${EN('medium height')} (estatura média).`,
              `Idade: ${EN('young')} (jovem) · ${EN('old')} (velho — use com cuidado) · ${EN('elderly')} (idoso, mais educado) · ${EN('middle-aged')} (de meia-idade).`,
              `Cabelo com have: ${EN('She has long hair.')} · ${EN('He has short, dark hair.')} · ${EN('curly')} (cacheado) · ${EN('straight')} (liso) · ${EN('blond')} (loiro).`,
              `Olhos: ${EN('He has brown eyes.')} · ${EN('blue')}, ${EN('green')}, ${EN('dark')}.`
            ] },
          { h: 'Personalidade',
            items: [
              `${EN('friendly')} (simpático) · ${EN('funny')} (engraçado) · ${EN('kind')} (gentil) · ${EN('smart')} (inteligente).`,
              `${EN('shy')} (tímido) · ${EN('quiet')} (quieto) · ${EN('outgoing')} (extrovertido) · ${EN('hard-working')} (trabalhador).`,
              `Falso cognato: ${EN('sympathetic')} não é "simpático", e sim "compreensivo, solidário". Para "simpático", use ${EN('nice')} ou ${EN('friendly')}.`
            ] },
          { h: 'A ordem: adjetivo antes do substantivo',
            p: `${EN('a tall man')} (um homem alto) · ${EN('a funny story')} (uma história engraçada) · ${EN('my kind grandmother')} (minha avó gentil). Com o verbo to be, o adjetivo fica no fim: ${EN('My grandmother is kind.')} E ele nunca vai para o plural: ${EN('two young women')}.` },
          { h: 'Intensidade: very, really, a bit',
            p: `${EN('very tall')} (muito alto) · ${EN('really funny')} (muito engraçado, mais informal) · ${EN('a bit shy')} (um pouco tímido). Para descrever alguém em uma pergunta: ${EN('What is she like?')} (Como ela é? — personalidade) · ${EN('What does she look like?')} (Como ela é fisicamente?).` }
        ],
        pratica: [
          { t: 'pares', pares: [['tall', 'alto'], ['shy', 'tímido'], ['funny', 'engraçado'], ['kind', 'gentil'], ['curly', 'cacheado']] },
          { t: 'escolha', q: 'Como se diz "um homem alto"?', op: ['a tall man', 'a man tall', 'a talls man'], a: 0 },
          { t: 'escolha', q: 'Como se diz "duas mulheres jovens"?', op: ['two young women', 'two youngs women', 'two women youngs'], a: 0, exp: 'O adjetivo vem antes do substantivo e nunca vai para o plural.' },
          { t: 'escolha', q: `O que pergunta ${EN('What is she like?')}`, op: ['Como ela é (personalidade)?', 'Do que ela gosta?', 'Com quem ela se parece?'], a: 0, opPt: true, exp: `Parece "do que ela gosta", mas like aqui é "como". What is she like? = como ela é. Do que ela gosta seria What does she like?` },
          { t: 'escolha', q: `${EN('sympathetic')} significa:`, op: ['compreensivo', 'simpático', 'sinfônico'], a: 0, opPt: true, exp: 'Falso cognato. Simpático é nice ou friendly.' },
          { t: 'lacuna', frase: 'She ___ long, curly hair.', op: ['has', 'is', 'have'], a: 0, pt: 'Ela tem cabelo longo e cacheado.' },
          { t: 'montar', pt: 'Meu irmão é muito engraçado.', en: 'My brother is very funny', extra: ['much', 'has'] },
          { t: 'montar', pt: 'Ela tem olhos castanhos.', en: 'She has brown eyes', extra: ['is', 'browns'] },
          { t: 'digitar', pt: 'Ele é alto e simpático.', en: 'He is tall and friendly', alt: ["He's tall and friendly", 'He is tall and nice', "He's tall and nice"] },
          { t: 'digitar', ouvir: 'My grandmother is kind.', en: 'My grandmother is kind' },
          { t: 'falar', en: 'My sister is tall and friendly.' },
          { t: 'falar', en: 'He has short, dark hair.' }
        ]
      }
    ]
  }
  ,
  {
    id: 'en-m03', title: 'Módulo 03 · Rotina: presente simples, do/does, frequência, horas e preposições de tempo (A1)', kind: 'video',
    lessons: [
      {
        id: 'en-presente-simples', title: 'Presente simples: I work, she works',
        desc: 'O tempo verbal dos hábitos e das verdades: como se forma, por que ele, ela e it ganham -s, e as regras de escrita.',
        objetivos: [
          'Usar o presente simples para hábitos, rotina e fatos',
          'Acrescentar -s ao verbo com he, she e it',
          'Aplicar as regras de escrita -s, -es e -ies'
        ],
        body: 'O presente simples é o tempo da rotina: o que você faz todo dia, toda semana, sempre. É o tempo mais usado do inglês — e tem uma única armadilha, que pega até quem já fala bem: o -s na terceira pessoa.',
        content: [
          { h: 'Quando usar',
            items: [
              `Hábitos e rotina: ${EN('I work from home.')} (Eu trabalho de casa.) · ${EN('She drinks coffee every morning.')}`,
              `Fatos e verdades: ${EN('Water boils at 100 degrees.')} · ${EN('My brother lives in Recife.')}`,
              `Não é para o que está acontecendo agora — isso é outro tempo, que você verá no módulo 6.`
            ] },
          { h: 'A forma: igual ao verbo puro, menos com he, she e it',
            items: [
              `${EN('I work')} · ${EN('you work')} · ${EN('we work')} · ${EN('they work')} — o verbo fica como está no dicionário.`,
              `${EN('he works')} · ${EN('she works')} · ${EN('it works')} — com uma pessoa ou coisa, o verbo ganha <strong>-s</strong>.`,
              `Vale para nomes também: ${EN('Ana works in a bank.')} · ${EN('My mom lives in São Paulo.')}`
            ] },
          { h: 'Regras de escrita do -s',
            items: [
              `A maioria: só -s — ${EN('works')}, ${EN('plays')}, ${EN('reads')}.`,
              `Terminados em s, sh, ch, x, o: -es — ${EN('watches')}, ${EN('goes')}, ${EN('does')}, ${EN('finishes')}.`,
              `Consoante + y: -ies — ${EN('study, studies')} · ${EN('try, tries')}. Vogal + y só -s: ${EN('play, plays')}.`,
              `Irregular: ${EN('have')} vira ${EN('has')}: ${EN('She has a meeting.')}`
            ] },
          { h: 'Dica de pronúncia',
            p: `O -s final soa de três jeitos: "s" em ${EN('works')}, "z" em ${EN('plays')} e uma sílaba a mais, "iz", em ${EN('watches')} e ${EN('finishes')}. Não precisa decorar — a boca faz sozinha com a prática de ouvir e repetir.` }
        ],
        pratica: [
          { t: 'lacuna', frase: 'She ___ in a bank.', op: ['works', 'work', 'working'], a: 0, pt: 'Ela trabalha num banco.', exp: 'Com she, o verbo do presente simples ganha -s.' },
          { t: 'lacuna', frase: 'They ___ English every day.', op: ['study', 'studies', 'studys'], a: 0, pt: 'Eles estudam inglês todo dia.' },
          { t: 'lacuna', frase: 'My brother ___ to the gym at 7.', op: ['goes', 'gos', 'go'], a: 0, pt: 'Meu irmão vai à academia às 7.' },
          { t: 'escolha', q: 'Qual é a forma com "she" do verbo study?', op: ['studies', 'studys', 'studyes'], a: 0 },
          { t: 'escolha', q: 'Qual é a forma com "he" do verbo watch?', op: ['watches', 'watchs', 'watchies'], a: 0 },
          { t: 'escolha', q: 'Qual frase está correta?', op: ['Ana lives in Recife.', 'Ana live in Recife.', 'Ana is live in Recife.'], a: 0 },
          { t: 'montar', pt: 'Eu trabalho de casa.', en: 'I work from home', extra: ['works', 'in'] },
          { t: 'montar', pt: 'Ela bebe café toda manhã.', en: 'She drinks coffee every morning', extra: ['drink', 'all'] },
          { t: 'pares', pares: [['work', 'works'], ['go', 'goes'], ['study', 'studies'], ['have', 'has'], ['play', 'plays']] },
          { t: 'digitar', pt: 'Meu pai mora em São Paulo.', en: 'My father lives in São Paulo', alt: ['My dad lives in São Paulo', 'My father lives in Sao Paulo', 'My dad lives in Sao Paulo'] },
          { t: 'digitar', ouvir: 'He finishes work at six.', en: 'He finishes work at six', alt: ['He finishes work at 6'] },
          { t: 'falar', en: 'She works from home.' },
          { t: 'falar', en: 'He watches TV every night.' }
        ]
      },
      {
        id: 'en-do-does', title: 'Do e does: negativa e perguntas',
        desc: 'Como negar e perguntar no presente simples com os auxiliares do e does, e as perguntas com what, where e when.',
        objetivos: [
          'Fazer negativas com don\'t e doesn\'t',
          'Fazer perguntas de sim ou não com Do e Does e responder curto',
          'Fazer perguntas com What, Where, When e What time'
        ],
        body: 'Você já viu do e does na aula de have. Eles são os ajudantes do presente simples: aparecem em toda negativa e toda pergunta. A regra de ouro é que o -s sai do verbo e vai para o ajudante.',
        content: [
          { h: 'Negativa',
            items: [
              `${EN("I don't like coffee.")} · ${EN("They don't work on Sundays.")} — com I, you, we, they: ${EN("don't")}.`,
              `${EN("She doesn't like coffee.")} · ${EN("He doesn't work on Sundays.")} — com he, she, it: ${EN("doesn't")}.`,
              `Depois de ${EN("doesn't")} o verbo volta ao normal: ${EN("She doesn't work")} — nunca "doesn't works".`
            ] },
          { h: 'Perguntas de sim ou não',
            items: [
              `${EN('Do you like pizza?')} — ${EN('Yes, I do.')} / ${EN("No, I don't.")}`,
              `${EN('Does he work here?')} — ${EN('Yes, he does.')} / ${EN("No, he doesn't.")}`,
              `Mesma regra: ${EN('Does she live')} — e não "Does she lives".`
            ] },
          { h: 'Perguntas com palavra interrogativa',
            p: `A palavra interrogativa vem na frente, depois o ajudante: ${EN('Where do you live?')} (Onde você mora?) · ${EN('What do you do?')} (Qual é a sua profissão?) · ${EN('When does the class start?')} (Quando a aula começa?) · ${EN('What time do you get up?')} (A que horas você levanta?)` },
          { h: 'Erro clássico',
            p: `Quem fala português tende a perguntar só com entonação: "You like pizza?" Na fala informal até se ouve, mas a forma correta — e a que cai em prova — usa o ajudante: ${EN('Do you like pizza?')}` }
        ],
        pratica: [
          { t: 'lacuna', frase: "She ___ like coffee.", op: ["doesn't", "don't", "isn't"], a: 0, pt: 'Ela não gosta de café.' },
          { t: 'lacuna', frase: "We ___ work on Sundays.", op: ["don't", "doesn't", "aren't"], a: 0, pt: 'Nós não trabalhamos aos domingos.' },
          { t: 'lacuna', frase: '___ he live near here?', op: ['Does', 'Do', 'Is'], a: 0, pt: 'Ele mora perto daqui?' },
          { t: 'escolha', q: 'Qual frase está correta?', op: ["He doesn't work here.", "He doesn't works here.", "He don't work here."], a: 0, exp: `Com he usa doesn't, e depois dele o verbo volta à forma base: work.` },
          { t: 'escolha', q: `Responda: ${EN('Do you like pizza?')} (sim)`, op: ['Yes, I do.', 'Yes, I like.', 'Yes, I am.'], a: 0 },
          { t: 'montar', pt: 'Onde você mora?', en: 'Where do you live?', extra: ['does', 'are'] },
          { t: 'montar', pt: 'A que horas a aula começa?', en: 'What time does the class start?', extra: ['do', 'starts'] },
          { t: 'pares', pares: [['Where', 'Onde'], ['When', 'Quando'], ['What time', 'A que horas'], ['What', 'O que'], ['Who', 'Quem']] },
          { t: 'escolha', ouvir: 'Does she speak English?', op: ['Does she speak English?', 'Do she speaks English?', 'Is she speak English?'], a: 0 },
          { t: 'digitar', pt: 'Eu não gosto de café.', en: "I don't like coffee", alt: ['I do not like coffee'] },
          { t: 'digitar', ouvir: 'What do you do?', en: 'What do you do' },
          { t: 'falar', en: 'Do you work on weekends?' },
          { t: 'falar', en: "She doesn't like coffee." }
        ]
      },
      {
        id: 'en-frequencia-horas', title: 'Always, never e as horas',
        desc: 'Advérbios de frequência, os dias da semana e como perguntar e dizer as horas em inglês.',
        objetivos: [
          'Usar always, usually, often, sometimes e never na posição certa',
          'Dizer os dias da semana com on',
          'Perguntar e dizer as horas, e usar at com horário'
        ],
        body: 'Para falar da rotina você precisa dizer com que frequência faz as coisas e a que horas. Esta aula junta as duas coisas — e mostra duas preposições que confundem muito: on para dias e at para horas.',
        content: [
          { h: 'Advérbios de frequência',
            items: [
              `${EN('always')} (sempre, 100%) · ${EN('usually')} (normalmente) · ${EN('often')} (frequentemente) · ${EN('sometimes')} (às vezes) · ${EN('never')} (nunca, 0%).`,
              `Posição: <strong>antes</strong> do verbo principal — ${EN('I always drink coffee.')} · ${EN('She never works on Sundays.')}`,
              `Mas <strong>depois</strong> do verbo to be — ${EN("I'm always tired on Mondays.")} · ${EN("He's never late.")}`,
              `Pergunta: ${EN('How often do you exercise?')} (Com que frequência você se exercita?)`
            ] },
          { h: 'Dias da semana: sempre com maiúscula e com on',
            p: `${EN('Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday')}. Use ${EN('on')}: ${EN('on Monday')} (na segunda) · ${EN('on Mondays')} (às segundas, toda semana) · ${EN('on the weekend')} (no fim de semana). Atenção à pronúncia de ${EN('Wednesday')}: o "d" do meio não se pronuncia, fica "uénsdei".` },
          { h: 'As horas',
            items: [
              `Pergunta: ${EN('What time is it?')} — resposta com it: ${EN("It's seven o'clock.")} (São sete horas.)`,
              `O jeito mais fácil: hora + minutos — ${EN("It's seven thirty.")} (7h30) · ${EN("It's nine fifteen.")} (9h15) · ${EN("It's ten forty-five.")} (10h45).`,
              `Também se ouve: ${EN('half past seven')} (7h30) · ${EN('quarter past nine')} (9h15) · ${EN('quarter to eleven')} (10h45).`,
              `Manhã e tarde: ${EN('7 a.m.')} (7h) e ${EN('7 p.m.')} (19h) — nos Estados Unidos o relógio de 24 horas é pouco usado no dia a dia.`
            ] },
          { h: 'At + horário',
            p: `Para dizer a que horas algo acontece, use ${EN('at')}: ${EN('I get up at six.')} · ${EN('The meeting is at 3 p.m.')} · ${EN('at noon')} (ao meio-dia) · ${EN('at night')} (à noite).` }
        ],
        pratica: [
          { t: 'pares', pares: [['always', 'sempre'], ['usually', 'normalmente'], ['sometimes', 'às vezes'], ['never', 'nunca'], ['often', 'frequentemente']] },
          { t: 'escolha', q: 'Qual frase está na ordem certa?', op: ['I always drink coffee.', 'I drink always coffee.', 'Always I drink coffee.'], a: 0 },
          { t: 'escolha', q: 'Qual frase está na ordem certa?', op: ["He's never late.", 'He never is late.', 'Never he is late.'], a: 0, exp: 'Com o verbo to be, o advérbio de frequência vem DEPOIS dele.' },
          { t: 'lacuna', frase: "I don't work ___ Sundays.", op: ['on', 'at', 'in'], a: 0, pt: 'Eu não trabalho aos domingos.' },
          { t: 'lacuna', frase: 'The meeting is ___ 3 p.m.', op: ['at', 'on', 'in'], a: 0, pt: 'A reunião é às 15h.' },
          { t: 'escolha', ouvir: "It's seven thirty.", op: ['7:30', '7:13', '3:07'], a: 0 },
          { t: 'escolha', q: 'Como se diz 19h no inglês americano do dia a dia?', op: ['7 p.m.', '7 a.m.', '19 p.m.'], a: 0 },
          { t: 'montar', pt: 'Que horas são?', en: 'What time is it?', extra: ['hours', 'are'] },
          { t: 'montar', pt: 'Eu normalmente levanto às seis.', en: 'I usually get up at six', extra: ['on', 'in'] },
          { t: 'digitar', pt: 'Escreva o dia: quarta-feira', en: 'Wednesday' },
          { t: 'digitar', ouvir: 'How often do you exercise?', en: 'How often do you exercise' },
          { t: 'falar', en: 'What time is it?' },
          { t: 'falar', en: 'I never work on Sundays.' }
        ]
      },
      {
        id: 'en-rotina-in-on-at', title: 'Minha rotina: verbos do dia a dia e in, on, at',
        desc: 'Os verbos da rotina (wake up, have breakfast, go to work...) e a regra de in, on e at para tempo.',
        objetivos: [
          'Descrever a própria rotina do acordar ao dormir',
          'Usar have breakfast, have lunch e have dinner',
          'Escolher entre in, on e at para expressões de tempo'
        ],
        body: 'Fechando o módulo, você vai juntar tudo para contar o seu dia. E vai aprender a regra que resolve o in, on e at de tempo — uma das maiores dúvidas de quem estuda inglês.',
        content: [
          { h: 'Verbos da rotina',
            items: [
              `${EN('wake up')} (acordar) · ${EN('get up')} (levantar) · ${EN('take a shower')} (tomar banho) · ${EN('get dressed')} (se vestir).`,
              `${EN('have breakfast')} (tomar café da manhã) · ${EN('have lunch')} (almoçar) · ${EN('have dinner')} (jantar) — as refeições usam ${EN('have')}, não "take" nem "eat breakfast" (este último também existe, mas é menos comum).`,
              `${EN('go to work')} (ir trabalhar) · ${EN('start work')} · ${EN('finish work')} · ${EN('get home')} (chegar em casa).`,
              `${EN('go to bed')} (ir deitar) · ${EN('fall asleep')} (pegar no sono).`
            ] },
          { h: 'In, on, at: do maior para o menor',
            items: [
              `${EN('in')} para períodos grandes: meses, anos, estações e partes do dia — ${EN('in July')} · ${EN('in 2026')} · ${EN('in the summer')} · ${EN('in the morning')} · ${EN('in the evening')}.`,
              `${EN('on')} para dias e datas — ${EN('on Monday')} · ${EN('on May 5th')} · ${EN('on my birthday')} · ${EN('on the weekend')} (americano).`,
              `${EN('at')} para horas e momentos exatos — ${EN('at 7 a.m.')} · ${EN('at noon')} · ${EN('at night')} · ${EN('at lunchtime')}.`,
              `Exceção que vale decorar: ${EN('in the morning')}, mas ${EN('at night')}.`
            ] },
          { h: 'Sem preposição',
            p: `Com ${EN('every')}, ${EN('this')}, ${EN('next')}, ${EN('last')}, ${EN('today')} e ${EN('tomorrow')} não se usa preposição: ${EN('every day')} · ${EN('this morning')} · ${EN('next Monday')} — nunca "on next Monday".` },
          { h: 'Uma rotina completa (modelo)',
            p: `${EN('I usually wake up at six. I take a shower, have breakfast and go to work at seven thirty. I have lunch at noon, I finish work at six, and I go to bed at eleven.')}` }
        ],
        pratica: [
          { t: 'pares', pares: [['wake up', 'acordar'], ['have lunch', 'almoçar'], ['get home', 'chegar em casa'], ['go to bed', 'ir deitar'], ['take a shower', 'tomar banho']] },
          { t: 'lacuna', frase: 'I have breakfast ___ the morning.', op: ['in', 'on', 'at'], a: 0, pt: 'Eu tomo café da manhã de manhã.' },
          { t: 'lacuna', frase: 'I go to bed ___ night.', op: ['at', 'in', 'on'], a: 0, pt: 'Eu vou deitar à noite.', exp: 'Exceção clássica: in the morning, in the afternoon, in the evening — mas at night.' },
          { t: 'lacuna', frase: 'My birthday is ___ May 5th.', op: ['on', 'in', 'at'], a: 0, pt: 'Meu aniversário é em 5 de maio.' },
          { t: 'lacuna', frase: 'We travel ___ July.', op: ['in', 'on', 'at'], a: 0, pt: 'Nós viajamos em julho.' },
          { t: 'escolha', q: 'Qual frase está correta?', op: ['See you next Monday.', 'See you on next Monday.', 'See you in next Monday.'], a: 0, exp: 'Com next, last, this e every não se usa preposição.' },
          { t: 'escolha', q: 'Como se diz "eu almoço ao meio-dia"?', op: ['I have lunch at noon.', 'I take lunch in noon.', 'I lunch on noon.'], a: 0 },
          { t: 'montar', pt: 'Eu chego em casa às seis.', en: 'I get home at six', extra: ['in', 'arrive'] },
          { t: 'montar', pt: 'Ela toma banho de manhã.', en: 'She takes a shower in the morning', extra: ['at', 'take'] },
          { t: 'digitar', pt: 'Eu janto às oito.', en: 'I have dinner at eight', alt: ['I have dinner at 8'] },
          { t: 'digitar', ouvir: 'I usually wake up at six.', en: 'I usually wake up at six', alt: ['I usually wake up at 6'] },
          { t: 'falar', en: 'I have breakfast at seven.' },
          { t: 'falar', en: 'I go to bed at eleven.' }
        ]
      }
    ]
  }
  ,
  {
    id: 'en-m04', title: 'Módulo 04 · Casa, cidade e compras: there is/are, preposições, can e preços (A1)', kind: 'video',
    lessons: [
      {
        id: 'en-there-is-are', title: 'There is e there are: o que tem no lugar',
        desc: 'Como dizer que existe alguma coisa num lugar — "tem um banco na esquina" — e como perguntar e negar.',
        objetivos: [
          'Usar there is com singular e there are com plural',
          'Negar com there isn\'t e there aren\'t, usando any no plural',
          'Perguntar com Is there...? e Are there...?'
        ],
        body: 'Em português dizemos "tem uma farmácia aqui perto" usando o verbo ter. Em inglês, para falar que algo existe num lugar, usa-se there is e there are — e usar have nesse caso é um dos erros mais comuns de brasileiro.',
        content: [
          { h: 'Singular e plural',
            items: [
              `${EN('There is')} (contração ${EN("there's")}) + singular: ${EN("There's a pharmacy near here.")} (Tem uma farmácia aqui perto.)`,
              `${EN('There are')} + plural: ${EN('There are two banks on this street.')} (Tem dois bancos nesta rua.)`,
              `Erro clássico: "Have a pharmacy here" — em inglês o verbo ter (${EN('have')}) é de posse; para existência é ${EN('there is')}.`
            ] },
          { h: 'Negativa',
            items: [
              `${EN("There isn't a gym in my building.")} (Não tem academia no meu prédio.)`,
              `${EN("There aren't any restaurants here.")} (Não tem nenhum restaurante aqui.) — no plural negativo, use ${EN('any')}.`,
              `Também se diz: ${EN('There are no restaurants here.')} — com ${EN('no')}, o verbo fica afirmativo.`
            ] },
          { h: 'Pergunta',
            items: [
              `${EN('Is there a bathroom here?')} — ${EN('Yes, there is.')} / ${EN("No, there isn't.")}`,
              `${EN('Are there any good restaurants near here?')} — ${EN('Yes, there are.')} / ${EN("No, there aren't.")}`,
              `Quantidade: ${EN('How many rooms are there?')} (Quantos cômodos tem?)`
            ] },
          { h: 'Some e any',
            p: `No plural afirmativo use ${EN('some')} (alguns): ${EN('There are some shops on the corner.')} Em perguntas e negativas, ${EN('any')}: ${EN('Are there any shops?')} · ${EN("There aren't any shops.")}` }
        ],
        pratica: [
          { t: 'lacuna', frase: '___ a pharmacy near here.', op: ["There's", 'There are', 'Have'], a: 0, pt: 'Tem uma farmácia aqui perto.', exp: 'Para existência num lugar, there is (singular). Have é posse.' },
          { t: 'lacuna', frase: '___ two banks on this street.', op: ['There are', "There's", 'Have'], a: 0, pt: 'Tem dois bancos nesta rua.' },
          { t: 'lacuna', frase: "There aren't ___ restaurants here.", op: ['any', 'some', 'a'], a: 0, pt: 'Não tem nenhum restaurante aqui.' },
          { t: 'escolha', q: 'Como perguntar "Tem banheiro aqui?"', op: ['Is there a bathroom here?', 'Have a bathroom here?', 'There is a bathroom here?'], a: 0 },
          { t: 'escolha', q: `Responda: ${EN('Are there any shops?')} (sim)`, op: ['Yes, there are.', 'Yes, there is.', 'Yes, they have.'], a: 0 },
          { t: 'montar', pt: 'Quantos quartos tem?', en: 'How many bedrooms are there?', extra: ['have', 'is'] },
          { t: 'montar', pt: 'Não tem academia no meu prédio.', en: "There isn't a gym in my building", extra: ['have', 'any'] },
          { t: 'escolha', ouvir: "There's a supermarket on the corner.", op: ["There's a supermarket on the corner.", 'There are supermarkets in the corner.', 'Is there a supermarket on the corner?'], a: 0 },
          { t: 'digitar', pt: 'Tem um parque perto da minha casa.', en: "There's a park near my house", alt: ['There is a park near my house'] },
          { t: 'digitar', ouvir: 'Are there any good restaurants here?', en: 'Are there any good restaurants here' },
          { t: 'pares', pares: [['there is', 'tem (1)'], ['there are', 'tem (2+)'], ["there isn't", 'não tem (1)'], ["there aren't any", 'não tem nenhum'], ['Is there...?', 'Tem...?']] },
          { t: 'falar', en: 'Is there a bank near here?' },
          { t: 'falar', en: 'There are two bedrooms.' }
        ]
      },
      {
        id: 'en-preposicoes-lugar', title: 'Onde fica? As preposições de lugar',
        desc: 'In, on, under, next to, between, behind, in front of, near e across from — para dizer onde as coisas estão em casa e na cidade.',
        objetivos: [
          'Usar in, on e under para posição de objetos',
          'Usar next to, between, behind, in front of e near',
          'Localizar lugares na cidade com on the corner e across from'
        ],
        body: 'Onde está a chave? Onde fica o banco? As preposições de lugar respondem a essas perguntas. A maioria tem tradução direta, mas in e on funcionam diferente do "em" do português.',
        content: [
          { h: 'Dentro, sobre, embaixo',
            items: [
              `${EN('in')} — dentro: ${EN('The keys are in my bag.')} (As chaves estão na minha bolsa.)`,
              `${EN('on')} — em cima, apoiado na superfície: ${EN('The phone is on the table.')} (O celular está na mesa.)`,
              `${EN('under')} — embaixo: ${EN('The cat is under the bed.')}`,
              `O "em" do português vira ${EN('in')} ou ${EN('on')}: dentro da caixa é ${EN('in the box')}; na mesa (sobre ela) é ${EN('on the table')}.`
            ] },
          { h: 'Ao lado, entre, atrás, na frente, perto',
            items: [
              `${EN('next to')} (ao lado de): ${EN('The bank is next to the pharmacy.')}`,
              `${EN('between')} (entre): ${EN('The café is between the bank and the school.')}`,
              `${EN('behind')} (atrás de) · ${EN('in front of')} (na frente de): ${EN('The car is in front of the house.')}`,
              `${EN('near')} (perto de) — sem "of": ${EN('near my house')}, nunca "near of".`
            ] },
          { h: 'Na cidade',
            items: [
              `${EN('on the corner')} (na esquina) · ${EN('across from')} (em frente, do outro lado da rua): ${EN('The hotel is across from the station.')}`,
              `Rua: ${EN('on Main Street')} (na Rua Principal) · endereço completo: ${EN('at 25 Main Street')}.`,
              `Pergunta: ${EN('Where is the bank?')} · ${EN("Excuse me, where's the nearest pharmacy?")} (Com licença, onde fica a farmácia mais próxima?)`
            ] },
          { h: 'Cômodos da casa',
            p: `${EN('living room')} (sala) · ${EN('kitchen')} (cozinha) · ${EN('bedroom')} (quarto) · ${EN('bathroom')} (banheiro) · ${EN('garage')} (garagem). Com cômodos use ${EN('in')}: ${EN("She's in the kitchen.")}` }
        ],
        pratica: [
          { t: 'lacuna', frase: 'The phone is ___ the table.', op: ['on', 'in', 'at'], a: 0, pt: 'O celular está na mesa.', exp: 'Apoiado sobre uma superfície: on.' },
          { t: 'lacuna', frase: 'The keys are ___ my bag.', op: ['in', 'on', 'at'], a: 0, pt: 'As chaves estão na minha bolsa.' },
          { t: 'lacuna', frase: 'The café is ___ the bank and the school.', op: ['between', 'next', 'near of'], a: 0, pt: 'O café fica entre o banco e a escola.' },
          { t: 'escolha', q: 'Como se diz "perto da minha casa"?', op: ['near my house', 'near of my house', 'next my house'], a: 0, exp: 'near não leva of. Já next precisa de to: next to my house.' },
          { t: 'pares', pares: [['under', 'embaixo de'], ['behind', 'atrás de'], ['in front of', 'na frente de'], ['next to', 'ao lado de'], ['across from', 'em frente (outro lado)']] },
          { t: 'escolha', q: 'Como dizer "na esquina"?', op: ['on the corner', 'in the corner of the street', 'at corner'], a: 0 },
          { t: 'montar', pt: 'O gato está embaixo da cama.', en: 'The cat is under the bed', extra: ['on', 'of'] },
          { t: 'montar', pt: 'O hotel fica em frente à estação.', en: 'The hotel is across from the station', extra: ['in', 'front'] },
          { t: 'pares', pares: [['kitchen', 'cozinha'], ['bedroom', 'quarto'], ['bathroom', 'banheiro'], ['living room', 'sala'], ['garage', 'garagem']] },
          { t: 'digitar', pt: 'Ela está na cozinha.', en: "She's in the kitchen", alt: ['She is in the kitchen'] },
          { t: 'digitar', ouvir: "Excuse me, where's the nearest pharmacy?", en: "Excuse me, where's the nearest pharmacy", alt: ['Excuse me, where is the nearest pharmacy'] },
          { t: 'falar', en: 'The bank is next to the pharmacy.' },
          { t: 'falar', en: 'Where is the bathroom?' }
        ]
      },
      {
        id: 'en-can', title: 'Can: habilidade, permissão e pedidos',
        desc: 'O verbo can para dizer o que você sabe ou consegue fazer, pedir permissão e fazer pedidos educados.',
        objetivos: [
          'Dizer o que você sabe e não sabe fazer com can e can\'t',
          'Pedir permissão com Can I...?',
          'Fazer pedidos com Can you...? e Could you...?'
        ],
        body: 'Can é um dos verbos mais úteis do inglês: com ele você diz que sabe nadar, pede para sentar, pede ajuda numa loja. E ele é fácil: não muda com he e she e não precisa de do ou does.',
        content: [
          { h: 'Habilidade: saber e conseguir',
            items: [
              `${EN('I can swim.')} (Eu sei nadar.) · ${EN('She can speak three languages.')} (Ela fala três idiomas.)`,
              `Negativa: ${EN("can't")} (ou ${EN('cannot')}): ${EN("I can't cook.")} (Eu não sei cozinhar.)`,
              `Can <strong>não muda</strong>: ${EN('he can')}, ${EN('she can')} — nunca "cans". E o verbo depois dele fica puro: ${EN('She can swim')} — nunca "can swims" nem "can to swim".`
            ] },
          { h: 'Perguntas sem do/does',
            items: [
              `${EN('Can you drive?')} (Você sabe dirigir?) — ${EN('Yes, I can.')} / ${EN("No, I can't.")}`,
              `${EN('What languages can you speak?')}`,
              `Pronúncia: na afirmativa o ${EN('can')} fica fraco, quase "kn": ${EN('I can swim')}. Na negativa ele é forte e o "t" quase some: ${EN("I can't swim")} — preste atenção ao som da vogal, que é aberto.`
            ] },
          { h: 'Permissão e pedidos',
            items: [
              `Permissão: ${EN('Can I sit here?')} (Posso sentar aqui?) · ${EN('Can I pay by card?')} (Posso pagar com cartão?)`,
              `Pedido: ${EN('Can you help me?')} (Você pode me ajudar?)`,
              `Mais educado: ${EN('Could you help me, please?')} — ${EN('could')} soa mais gentil, ideal com desconhecidos e no trabalho.`
            ] },
          { h: 'Respondendo a um pedido',
            p: `${EN('Sure!')} · ${EN('Of course.')} · ${EN('No problem.')} (Claro! / Sem problema.) — e para recusar com educação: ${EN("Sorry, I can't right now.")}` }
        ],
        pratica: [
          { t: 'lacuna', frase: 'She ___ speak three languages.', op: ['can', 'cans', 'can to'], a: 0, pt: 'Ela fala três idiomas.', exp: 'can nunca ganha -s e não leva to.' },
          { t: 'escolha', q: 'Qual frase está correta?', op: ['He can swim.', 'He can swims.', 'He can to swim.'], a: 0 },
          { t: 'escolha', q: `Responda: ${EN('Can you drive?')} (não)`, op: ["No, I can't.", "No, I don't.", "No, I not can."], a: 0 },
          { t: 'escolha', q: 'Qual é o pedido mais educado?', op: ['Could you help me, please?', 'Help me.', 'You help me?'], a: 0 },
          { t: 'montar', pt: 'Posso pagar com cartão?', en: 'Can I pay by card?', extra: ['with', 'do'] },
          { t: 'montar', pt: 'Eu não sei cozinhar.', en: "I can't cook", extra: ["don't", 'to'] },
          { t: 'pares', pares: [['Can I...?', 'Posso...?'], ['Can you...?', 'Você pode...?'], ['Could you...?', 'Você poderia...?'], ["I can't", 'eu não consigo'], ['Sure!', 'Claro!']] },
          { t: 'escolha', ouvir: "I can't swim.", op: ["I can't swim.", 'I can swim.', "I don't swim."], a: 0 },
          { t: 'escolha', ouvir: 'I can swim.', op: ['I can swim.', "I can't swim.", 'I can swing.'], a: 0 },
          { t: 'digitar', pt: 'Você pode me ajudar?', en: 'Can you help me?', alt: ['Could you help me?'] },
          { t: 'digitar', ouvir: 'Can I sit here?', en: 'Can I sit here' },
          { t: 'falar', en: 'Could you help me, please?' },
          { t: 'falar', en: 'Can I pay by card?' }
        ]
      },
      {
        id: 'en-compras', title: 'Shopping: preços, tamanhos e pagamento',
        desc: 'Tudo para fazer compras em inglês: perguntar preço, ler valores em dólar, pedir outro tamanho, provar e pagar.',
        objetivos: [
          'Perguntar e entender preços com How much is / How much are',
          'Dizer valores em dólar e centavos',
          'Pedir tamanho, provar roupa e escolher a forma de pagamento'
        ],
        body: 'Fechando o módulo, você vai à loja. Com poucas frases prontas você resolve qualquer compra — e aprende a ler preços, que em inglês têm uma ordem e uma pontuação diferentes do português.',
        content: [
          { h: 'Quanto custa?',
            items: [
              `Singular: ${EN('How much is this shirt?')} (Quanto custa esta camisa?) — resposta: ${EN("It's twenty dollars.")}`,
              `Plural: ${EN('How much are these shoes?')} — resposta: ${EN("They're fifty dollars.")}`,
              `Para o total: ${EN('How much is it?')} · ${EN("That's thirty-five fifty.")} (São 35,50.)`
            ] },
          { h: 'Lendo preços',
            items: [
              `O símbolo vem antes, mas se fala depois: $20 = ${EN('twenty dollars')}.`,
              `Ponto separa os centavos (no Brasil é vírgula): $4.99 = ${EN('four ninety-nine')} ou ${EN('four dollars and ninety-nine cents')}.`,
              `Vírgula separa os milhares: $1,200 = ${EN('twelve hundred dollars')} ou ${EN('one thousand two hundred dollars')}.`
            ] },
          { h: 'Na loja de roupas',
            items: [
              `${EN("I'm looking for a jacket.")} (Estou procurando uma jaqueta.) · ${EN("I'm just looking, thanks.")} (Só estou olhando, obrigado.)`,
              `${EN('Do you have this in a medium?')} (Tem este no tamanho M?) — tamanhos: ${EN('small')}, ${EN('medium')}, ${EN('large')}.`,
              `${EN('Can I try it on?')} (Posso provar?) — ${EN('The fitting room is over there.')} (O provador é ali.)`,
              `${EN("It's too big.")} (Está grande demais.) · ${EN("It's perfect. I'll take it.")} (Está perfeito. Vou levar.)`
            ] },
          { h: 'Pagando',
            p: `${EN('Cash or card?')} (Dinheiro ou cartão?) — ${EN('Card, please.')} · ${EN('Can I pay by card?')} · ${EN('Do you need a bag?')} (Precisa de sacola?) · ${EN('Can I have the receipt?')} (Pode me dar a nota?) Atenção à pronúncia de ${EN('receipt')}: o "p" é mudo.` }
        ],
        pratica: [
          { t: 'lacuna', frase: 'How much ___ these shoes?', op: ['are', 'is', 'do'], a: 0, pt: 'Quanto custam estes sapatos?' },
          { t: 'lacuna', frase: 'How much ___ this shirt?', op: ['is', 'are', 'does'], a: 0, pt: 'Quanto custa esta camisa?' },
          { t: 'escolha', ouvir: 'four ninety-nine', op: ['$4.99', '$49.90', '$4.19'], a: 0 },
          { t: 'escolha', ouvir: 'twelve hundred dollars', op: ['$1,200', '$12.00', '$120'], a: 0 },
          { t: 'escolha', q: 'O vendedor pergunta se pode ajudar. Você só quer olhar:', op: ["I'm just looking, thanks.", "I'm only seeing.", 'I look only.'], a: 0 },
          { t: 'escolha', q: 'Como perguntar "Posso provar?"', op: ['Can I try it on?', 'Can I prove it?', 'Can I test it?'], a: 0, exp: 'Provar roupa é try on. Prove em inglês é comprovar.' },
          { t: 'montar', pt: 'Vocês têm este no tamanho M?', en: 'Do you have this in a medium?', extra: ['size', 'are'] },
          { t: 'montar', pt: 'Está perfeito. Vou levar.', en: "It's perfect I'll take it", extra: ['buy', 'go'] },
          { t: 'pares', pares: [['cash', 'dinheiro'], ['card', 'cartão'], ['receipt', 'nota fiscal'], ['bag', 'sacola'], ['fitting room', 'provador']] },
          { t: 'digitar', pt: 'Quanto custa?', en: 'How much is it?', alt: ['How much is it', 'How much does it cost?'] },
          { t: 'digitar', ouvir: 'Cash or card?', en: 'Cash or card' },
          { t: 'falar', en: "I'm looking for a jacket." },
          { t: 'falar', en: 'How much are these shoes?' }
        ]
      }
    ]
  }
  ,
  {
    id: 'en-m05', title: 'Módulo 05 · O passado: was/were, verbos regulares e irregulares, did (A2)', kind: 'video',
    lessons: [
      {
        id: 'en-was-were', title: 'Was e were: o verbo to be no passado',
        desc: 'O passado do verbo to be para dizer onde você estava, como foi e quando nasceu — com negativa, pergunta e there was/were.',
        objetivos: [
          'Usar was com I, he, she, it e were com you, we, they',
          'Negar com wasn\'t e weren\'t e perguntar com Was...? e Were...?',
          'Usar there was / there were e dizer quando e onde nasceu'
        ],
        body: 'Começa o nível A2, e com ele o passado. O primeiro passo é o verbo to be — que no presente tinha três formas e no passado tem só duas. Com ele você já conta como foi o fim de semana, onde estava ontem e onde nasceu.',
        content: [
          { h: 'Duas formas só',
            items: [
              `${EN('was')} com I, he, she, it: ${EN('I was at home.')} (Eu estava em casa.) · ${EN('It was great.')} (Foi ótimo.)`,
              `${EN('were')} com you, we, they: ${EN('We were tired.')} (Nós estávamos cansados.) · ${EN('They were at the beach.')}`,
              `Regra prática: onde no presente era ${EN('am')} ou ${EN('is')}, agora é ${EN('was')}; onde era ${EN('are')}, agora é ${EN('were')}.`
            ] },
          { h: 'Negativa e pergunta',
            items: [
              `${EN("I wasn't hungry.")} · ${EN("They weren't at the party.")}`,
              `${EN('Were you at work yesterday?')} — ${EN('Yes, I was.')} / ${EN("No, I wasn't.")}`,
              `${EN('How was your weekend?')} (Como foi o seu fim de semana?) — ${EN('It was amazing!')} · ${EN('It was okay.')} · ${EN('It was terrible.')}`
            ] },
          { h: 'There was / there were',
            p: `O passado do "tem" de existência: ${EN('There was a party.')} (Teve uma festa.) · ${EN('There were a lot of people.')} (Tinha muita gente.) · ${EN("There wasn't any food.")} (Não tinha comida nenhuma.)` },
          { h: 'Nascimento',
            p: `Em inglês "nascer" se diz com ${EN('was born')}: ${EN('I was born in 1990.')} (Eu nasci em 1990.) · ${EN('She was born in Goiânia.')} Pergunta: ${EN('Where were you born?')} — nunca "I born" nem "I borned".` },
          { h: 'Expressões de tempo do passado',
            p: `${EN('yesterday')} (ontem) · ${EN('last night')} (ontem à noite) · ${EN('last week')} (semana passada) · ${EN('two days ago')} (dois dias atrás) · ${EN('in 2020')} (em 2020). Atenção: ${EN('ago')} vem depois do tempo.` }
        ],
        pratica: [
          { t: 'lacuna', frase: 'I ___ at home yesterday.', op: ['was', 'were', 'am'], a: 0, pt: 'Eu estava em casa ontem.' },
          { t: 'lacuna', frase: 'They ___ at the beach last weekend.', op: ['were', 'was', 'are'], a: 0, pt: 'Eles estavam na praia no fim de semana passado.' },
          { t: 'lacuna', frase: '___ you at work yesterday?', op: ['Were', 'Was', 'Did'], a: 0, pt: 'Você estava no trabalho ontem?' },
          { t: 'escolha', q: 'Como se diz "Eu nasci em 1990"?', op: ['I was born in 1990.', 'I born in 1990.', 'I borned in 1990.'], a: 0, exp: 'Nascer em inglês é sempre com was born (ou were born).' },
          { t: 'escolha', q: `Responda: ${EN('Was it good?')} (sim)`, op: ['Yes, it was.', 'Yes, it were.', 'Yes, it did.'], a: 0 },
          { t: 'escolha', q: 'Como se diz "dois dias atrás"?', op: ['two days ago', 'ago two days', 'before two days'], a: 0 },
          { t: 'montar', pt: 'Como foi o seu fim de semana?', en: 'How was your weekend?', extra: ['were', 'did'] },
          { t: 'montar', pt: 'Tinha muita gente na festa.', en: 'There were a lot of people at the party', extra: ['had', 'was'] },
          { t: 'pares', pares: [['yesterday', 'ontem'], ['last night', 'ontem à noite'], ['last week', 'semana passada'], ['ago', 'atrás'], ['was born', 'nasceu']] },
          { t: 'digitar', pt: 'Nós estávamos cansados.', en: 'We were tired' },
          { t: 'digitar', ouvir: 'Where were you born?', en: 'Where were you born' },
          { t: 'falar', en: 'It was amazing!' },
          { t: 'falar', en: 'I was born in Brazil.' }
        ]
      },
      {
        id: 'en-passado-regular', title: 'Passado dos verbos regulares: -ed',
        desc: 'Como formar o passado dos verbos regulares, as regras de escrita do -ed e os três sons que ele pode ter.',
        objetivos: [
          'Formar o passado regular com -ed para todas as pessoas',
          'Aplicar as regras de escrita: -d, -ied e consoante dobrada',
          'Pronunciar o -ed como t, d ou id'
        ],
        body: 'A boa notícia do passado em inglês: a forma é a mesma para todo mundo. I worked, she worked, they worked — nada de -s na terceira pessoa. A maioria dos verbos é regular e ganha -ed; a dificuldade está na pronúncia, que quase nunca é "ed".',
        content: [
          { h: 'A forma: verbo + ed',
            items: [
              `${EN('work → worked')} · ${EN('play → played')} · ${EN('watch → watched')}.`,
              `Igual para todas as pessoas: ${EN('I worked')}, ${EN('she worked')}, ${EN('they worked')} — ${EN('She worked late yesterday.')} (Ela trabalhou até tarde ontem.)`,
              `Uso: ação que começou e terminou num momento do passado — ${EN('I watched a movie last night.')}`
            ] },
          { h: 'Regras de escrita',
            items: [
              `Terminados em -e: só -d — ${EN('live → lived')} · ${EN('like → liked')}.`,
              `Consoante + y: -ied — ${EN('study → studied')} · ${EN('try → tried')}. Vogal + y: só -ed — ${EN('play → played')}.`,
              `Verbo curto terminado em consoante-vogal-consoante dobra a última: ${EN('stop → stopped')} · ${EN('plan → planned')}.`
            ] },
          { h: 'Os três sons do -ed',
            items: [
              `Som de <strong>t</strong> depois de sons surdos (p, k, s, sh, ch, f): ${EN('worked')}, ${EN('watched')}, ${EN('stopped')} — "uórkt", "uótcht".`,
              `Som de <strong>d</strong> depois de sons sonoros e vogais: ${EN('played')}, ${EN('lived')}, ${EN('called')} — "plêid".`,
              `Sílaba extra <strong>id</strong> só depois de t ou d: ${EN('wanted')}, ${EN('needed')}, ${EN('started')} — "uónid".`,
              `O erro mais comum de brasileiro é pronunciar "uórkéd" com sílaba a mais. Na grande maioria dos verbos, o -ed não cria sílaba nova.`
            ] }
        ],
        pratica: [
          { t: 'lacuna', frase: 'She ___ late yesterday.', op: ['worked', 'works', 'work'], a: 0, pt: 'Ela trabalhou até tarde ontem.' },
          { t: 'lacuna', frase: 'I ___ English last night.', op: ['studied', 'studyed', 'studed'], a: 0, pt: 'Eu estudei inglês ontem à noite.' },
          { t: 'lacuna', frase: 'The bus ___ in front of the bank.', op: ['stopped', 'stoped', 'stops'], a: 0, pt: 'O ônibus parou na frente do banco.' },
          { t: 'pares', pares: [['live', 'lived'], ['try', 'tried'], ['plan', 'planned'], ['play', 'played'], ['watch', 'watched']] },
          { t: 'escolha', q: `Em qual verbo o -ed forma uma sílaba a mais ("id")?`, op: ['wanted', 'worked', 'played'], a: 0, exp: 'Só depois de t ou d o -ed vira uma sílaba nova: wanted, needed, started.' },
          { t: 'escolha', q: `Em qual verbo o -ed soa como "t"?`, op: ['watched', 'played', 'needed'], a: 0 },
          { t: 'escolha', ouvir: 'I watched a movie last night.', op: ['I watched a movie last night.', 'I watch a movie every night.', 'I want a movie tonight.'], a: 0 },
          { t: 'montar', pt: 'Nós assistimos a um filme ontem à noite.', en: 'We watched a movie last night', extra: ['watch', 'yesterday'] },
          { t: 'montar', pt: 'Ele morou em Londres em 2020.', en: 'He lived in London in 2020', extra: ['lives', 'on'] },
          { t: 'digitar', pt: 'Eu liguei para a minha mãe ontem.', en: 'I called my mother yesterday', alt: ['I called my mom yesterday'] },
          { t: 'digitar', ouvir: 'They started the meeting at nine.', en: 'They started the meeting at nine', alt: ['They started the meeting at 9'] },
          { t: 'falar', en: 'I worked from home yesterday.' },
          { t: 'falar', en: 'She wanted a new job.' }
        ]
      },
      {
        id: 'en-passado-irregular', title: 'Os verbos irregulares mais usados',
        desc: 'Os 20 verbos irregulares que aparecem em quase toda conversa sobre o passado, agrupados para ficar mais fácil de lembrar.',
        objetivos: [
          'Usar o passado dos verbos irregulares mais frequentes',
          'Contar o que fez no fim de semana',
          'Reconhecer padrões que ajudam a memorizar'
        ],
        body: 'Os verbos irregulares não seguem a regra do -ed — e justamente os mais usados são irregulares: ir, ter, fazer, ver, comer. A boa notícia: com uns 20 verbos você cobre a maior parte das conversas. E a forma continua igual para todas as pessoas.',
        content: [
          { h: 'Os campeões do dia a dia',
            items: [
              `${EN('go → went')} (ir) · ${EN('have → had')} (ter) · ${EN('do → did')} (fazer) · ${EN('get → got')} (conseguir, chegar, receber).`,
              `${EN('see → saw')} (ver) · ${EN('make → made')} (fazer, produzir) · ${EN('come → came')} (vir) · ${EN('take → took')} (pegar, levar).`,
              `${EN('eat → ate')} (comer) · ${EN('drink → drank')} (beber) · ${EN('say → said')} (dizer) · ${EN('give → gave')} (dar).`
            ] },
          { h: 'Grupos que ajudam a lembrar',
            items: [
              `Terminam em -ought/-aught: ${EN('buy → bought')} (comprar) · ${EN('think → thought')} (pensar) · ${EN('bring → brought')} (trazer) · ${EN('teach → taught')} (ensinar).`,
              `Mudam a vogal: ${EN('sing → sang')} · ${EN('swim → swam')} · ${EN('drink → drank')} · ${EN('begin → began')}.`,
              `Iguais nas duas formas: ${EN('put → put')} · ${EN('cut → cut')} · ${EN('cost → cost')}.`,
              `${EN('read → read')}: a escrita é igual, mas o passado se pronuncia "réd".`
            ] },
          { h: 'Na prática: o fim de semana',
            p: `${EN('On Saturday I went to the beach with my family. We had lunch at a great restaurant and I ate fish. In the evening we saw a movie. On Sunday I got up late and did nothing!')}` },
          { h: 'Dica de estudo',
            p: `Não tente decorar listas enormes. Aprenda os irregulares dentro de frases sobre a sua vida — ${EN('Yesterday I went...')}, ${EN('Last week I bought...')} — e repita em voz alta. A memória guarda a frase, não a tabela.` }
        ],
        pratica: [
          { t: 'pares', pares: [['go', 'went'], ['have', 'had'], ['see', 'saw'], ['buy', 'bought'], ['eat', 'ate']] },
          { t: 'pares', pares: [['take', 'took'], ['come', 'came'], ['think', 'thought'], ['make', 'made'], ['get', 'got']] },
          { t: 'lacuna', frase: 'We ___ to the beach on Saturday.', op: ['went', 'goed', 'go'], a: 0, pt: 'Nós fomos à praia no sábado.' },
          { t: 'lacuna', frase: 'I ___ a new phone last week.', op: ['bought', 'buyed', 'brought'], a: 0, pt: 'Eu comprei um celular novo semana passada.', exp: 'buy → bought (comprar). Cuidado: brought é o passado de bring (trazer).' },
          { t: 'lacuna', frase: 'She ___ a great movie last night.', op: ['saw', 'seed', 'sees'], a: 0, pt: 'Ela viu um filme ótimo ontem à noite.' },
          { t: 'escolha', q: 'Qual é o passado de "put"?', op: ['put', 'putted', 'pot'], a: 0 },
          { t: 'escolha', ouvir: 'We had lunch at a great restaurant.', op: ['We had lunch at a great restaurant.', 'We have lunch at a great restaurant.', 'We ate lunch in a great restaurant.'], a: 0 },
          { t: 'montar', pt: 'Eu levantei tarde e não fiz nada.', en: 'I got up late and did nothing', extra: ['get', 'made'] },
          { t: 'montar', pt: 'Ele trouxe um presente para mim.', en: 'He brought a present for me', extra: ['bought', 'bring'] },
          { t: 'digitar', pt: 'Ela me deu um livro.', en: 'She gave me a book' },
          { t: 'digitar', ouvir: 'I took the bus to work.', en: 'I took the bus to work' },
          { t: 'falar', en: 'I went to the beach on Saturday.' },
          { t: 'falar', en: 'We saw a great movie.' }
        ]
      },
      {
        id: 'en-did', title: 'Did: negativa e perguntas no passado',
        desc: 'O auxiliar did para negar e perguntar no passado — com qualquer verbo, regular ou irregular — e as perguntas para conversar sobre o que aconteceu.',
        objetivos: [
          'Negar no passado com didn\'t + verbo na forma base',
          'Perguntar com Did...? e responder curto',
          'Fazer perguntas com What, Where, When e How sobre o passado'
        ],
        body: 'No presente, do e does ajudavam a negar e perguntar. No passado existe um ajudante só, did, para todas as pessoas. E a regra de ouro se repete: o passado vai para o did, e o verbo volta para a forma base — mesmo os irregulares.',
        content: [
          { h: 'Negativa: didn\'t + forma base',
            items: [
              `${EN("I didn't go to the party.")} (Eu não fui à festa.) · ${EN("She didn't call me.")}`,
              `O verbo volta à forma base: ${EN("didn't go")} — nunca "didn't went". O passado já está no ${EN("didn't")}.`,
              `Exceção: com o verbo to be não se usa did — ${EN("I wasn't there.")}, nunca "I didn't was".`
            ] },
          { h: 'Perguntas de sim ou não',
            items: [
              `${EN('Did you see the game?')} (Você viu o jogo?) — ${EN('Yes, I did.')} / ${EN("No, I didn't.")}`,
              `${EN('Did she like the movie?')} — de novo, forma base: ${EN('like')}, não "liked".`
            ] },
          { h: 'Perguntas para puxar conversa',
            items: [
              `${EN('What did you do on the weekend?')} (O que você fez no fim de semana?)`,
              `${EN('Where did you go?')} · ${EN('When did you arrive?')} · ${EN('Who did you see?')}`,
              `${EN('How was it?')} — com o verbo to be, sem did.`,
              `${EN('What happened?')} (O que aconteceu?) — quando a pergunta é sobre o próprio sujeito, não há did.`
            ] },
          { h: 'Dica de conversa',
            p: `Numa segunda-feira no trabalho, a pergunta clássica é ${EN('How was your weekend?')} seguida de ${EN('What did you do?')}. Tenha uma resposta pronta: ${EN('It was great! I went to the beach.')}` }
        ],
        pratica: [
          { t: 'lacuna', frase: "I didn't ___ to the party.", op: ['go', 'went', 'goes'], a: 0, pt: 'Eu não fui à festa.', exp: `Depois de didn't o verbo volta para a forma base: go, não went.` },
          { t: 'lacuna', frase: '___ you see the game last night?', op: ['Did', 'Were', 'Do'], a: 0, pt: 'Você viu o jogo ontem à noite?' },
          { t: 'lacuna', frase: 'Where ___ you go on vacation?', op: ['did', 'were', 'was'], a: 0, pt: 'Para onde você foi nas férias?' },
          { t: 'escolha', q: 'Qual frase está correta?', op: ["She didn't call me.", "She didn't called me.", "She don't called me."], a: 0 },
          { t: 'escolha', q: 'Qual frase está correta?', op: ["I wasn't at home.", "I didn't was at home.", "I didn't be at home."], a: 0, exp: 'Com o verbo to be não se usa did: wasn\'t / weren\'t.' },
          { t: 'escolha', q: `Responda: ${EN('Did you like the movie?')} (sim)`, op: ['Yes, I did.', 'Yes, I liked.', 'Yes, I was.'], a: 0 },
          { t: 'montar', pt: 'O que você fez no fim de semana?', en: 'What did you do on the weekend?', extra: ['made', 'was'] },
          { t: 'montar', pt: 'Eles não compraram o carro.', en: "They didn't buy the car", extra: ['bought', "don't"] },
          { t: 'escolha', ouvir: 'What happened?', op: ['What happened?', 'What did happen?', 'What happens?'], a: 0 },
          { t: 'digitar', pt: 'Quando você chegou?', en: 'When did you arrive?', alt: ['When did you arrive', 'When did you get here?'] },
          { t: 'digitar', ouvir: "I didn't see her yesterday.", en: "I didn't see her yesterday", alt: ['I did not see her yesterday'] },
          { t: 'falar', en: 'What did you do on the weekend?' },
          { t: 'falar', en: "I didn't go to work yesterday." }
        ]
      }
    ]
  }
  ,
  {
    id: 'en-m06', title: 'Módulo 06 · Futuro e planos: going to, will, presente contínuo e convites (A2)', kind: 'video',
    lessons: [
      {
        id: 'en-going-to', title: 'Going to: planos e previsões',
        desc: 'O futuro mais usado na conversa: going to para planos já decididos e para previsões baseadas no que você está vendo.',
        objetivos: [
          'Falar de planos e intenções com am/is/are going to + verbo',
          'Fazer previsões com base em evidências',
          'Negar e perguntar com going to'
        ],
        body: 'Em português dizemos "vou viajar", "vou estudar". O inglês tem uma estrutura quase igual: I\'m going to travel. É o futuro dos planos — coisas que você já decidiu antes de falar.',
        content: [
          { h: 'A forma',
            items: [
              `verbo to be + ${EN('going to')} + verbo: ${EN("I'm going to travel next month.")} (Eu vou viajar mês que vem.)`,
              `${EN("She's going to study medicine.")} · ${EN("We're going to buy a house.")}`,
              `Na fala rápida, ${EN('going to')} vira "gonna": ${EN("I'm gonna call you.")} — ouve-se o tempo todo, mas escreva sempre a forma completa.`
            ] },
          { h: 'Uso 1: planos e intenções',
            p: `Algo que você já decidiu: ${EN("I'm going to learn English this year.")} · ${EN("They're going to get married in May.")} Pergunta típica: ${EN('What are you going to do on the weekend?')} (O que você vai fazer no fim de semana?)` },
          { h: 'Uso 2: previsão com evidência',
            p: `Quando você vê sinais de que algo vai acontecer: ${EN("Look at those clouds. It's going to rain.")} (Olha essas nuvens. Vai chover.) · ${EN("Be careful! You're going to fall!")}` },
          { h: 'Negativa e pergunta',
            items: [
              `${EN("I'm not going to work tomorrow.")} · ${EN("He isn't going to come.")}`,
              `${EN('Are you going to travel?')} — ${EN("Yes, I am.")} / ${EN("No, I'm not.")}`,
              `${EN('When are you going to start?')} · ${EN('Where are they going to live?')}`
            ] },
          { h: 'Expressões de tempo do futuro',
            p: `${EN('tomorrow')} (amanhã) · ${EN('tonight')} (hoje à noite) · ${EN('next week')} (semana que vem) · ${EN('next year')} · ${EN('in two days')} (daqui a dois dias) · ${EN('soon')} (em breve).` }
        ],
        pratica: [
          { t: 'lacuna', frase: "I'm ___ to travel next month.", op: ['going', 'go', 'will'], a: 0, pt: 'Eu vou viajar mês que vem.' },
          { t: 'lacuna', frase: "She ___ going to study medicine.", op: ["'s", "'re", "'m"], a: 0, pt: 'Ela vai estudar medicina.' },
          { t: 'lacuna', frase: '___ you going to work tomorrow?', op: ['Are', 'Do', 'Will'], a: 0, pt: 'Você vai trabalhar amanhã?' },
          { t: 'escolha', q: 'O céu está cheio de nuvens escuras. O que dizer?', op: ["It's going to rain.", 'It rains.', 'It rained.'], a: 0 },
          { t: 'escolha', q: 'Como se diz "daqui a dois dias"?', op: ['in two days', 'two days ago', 'after two days ago'], a: 0, exp: 'in + tempo = daqui a. ago é para o passado (atrás).' },
          { t: 'escolha', ouvir: "I'm gonna call you tonight.", op: ["I'm going to call you tonight.", 'I called you tonight.', 'I call you every night.'], a: 0 },
          { t: 'montar', pt: 'O que você vai fazer no fim de semana?', en: 'What are you going to do on the weekend?', extra: ['will', 'did'] },
          { t: 'montar', pt: 'Nós vamos comprar uma casa.', en: "We're going to buy a house", extra: ['go', 'will'] },
          { t: 'pares', pares: [['tomorrow', 'amanhã'], ['tonight', 'hoje à noite'], ['next week', 'semana que vem'], ['soon', 'em breve'], ['in two days', 'daqui a dois dias']] },
          { t: 'digitar', pt: 'Eu não vou trabalhar amanhã.', en: "I'm not going to work tomorrow", alt: ['I am not going to work tomorrow'] },
          { t: 'digitar', ouvir: "They're going to get married in May.", en: "They're going to get married in May", alt: ['They are going to get married in May'] },
          { t: 'falar', en: "I'm going to learn English this year." },
          { t: 'falar', en: 'What are you going to do tomorrow?' }
        ]
      },
      {
        id: 'en-will', title: 'Will: decisões na hora, promessas e opiniões',
        desc: 'Quando o futuro é decidido no momento da fala: ofertas, promessas, pedidos e previsões de opinião com will e won\'t.',
        objetivos: [
          'Usar will para decisões tomadas na hora e ofertas de ajuda',
          'Fazer promessas e previsões de opinião com I think... will',
          'Usar won\'t e entender a diferença entre will e going to'
        ],
        body: 'O inglês tem dois futuros principais, e a diferença é simples: going to é o plano que já existia; will é a decisão que nasce na hora. "O telefone tocou? I\'ll get it!" — eu atendo, decidi agora.',
        content: [
          { h: 'A forma: will + verbo',
            items: [
              `Igual para todas as pessoas: ${EN('I will')}, ${EN('she will')}, ${EN('they will')} — contração ${EN("I'll")}, ${EN("she'll")}, ${EN("they'll")}.`,
              `Negativa: ${EN("won't")} (= ${EN('will not')}): ${EN("I won't forget.")} (Não vou esquecer.)`,
              `Pergunta: ${EN('Will you help me?')} — ${EN('Yes, I will.')} / ${EN("No, I won't.")}`
            ] },
          { h: 'Quando usar',
            items: [
              `Decisão na hora: ${EN("It's cold. I'll close the window.")} · ${EN("I'll have a coffee, please.")} (pedindo num café).`,
              `Oferta de ajuda: ${EN("I'll help you with that.")} · ${EN('Shall I open the door?')} (Quer que eu abra a porta? — mais britânico).`,
              `Promessa: ${EN("I'll call you tomorrow.")} · ${EN("I won't tell anybody.")}`,
              `Previsão de opinião: ${EN('I think it will rain.')} · ${EN("I don't think she'll come.")} — repare: a negação vai no think.`
            ] },
          { h: 'Will ou going to?',
            items: [
              `Plano já decidido → ${EN('going to')}: ${EN("I'm going to visit my parents on Sunday.")}`,
              `Decisão agora → ${EN('will')}: ${EN("Oh, you're busy? I'll visit them on Saturday, then.")}`,
              `Previsão: com evidência visível → ${EN('going to')}; com opinião → ${EN('will')}.`
            ] },
          { h: 'Pronúncia',
            p: `${EN("I'll")} soa quase como "ál"; ${EN("won't")} tem o som de "ou" — "uônt" — e é diferente de ${EN('want')} (querer, "uónt"). Ouça a diferença: ${EN("I won't go.")} × ${EN('I want to go.')}` }
        ],
        pratica: [
          { t: 'escolha', q: 'O telefone toca. Você decide atender agora:', op: ["I'll get it!", "I'm going to get it!", 'I get it!'], a: 0, exp: 'Decisão tomada no momento da fala: will.' },
          { t: 'escolha', q: 'Você já comprou a passagem para Paris. Qual frase?', op: ["I'm going to travel to Paris.", "I'll travel to Paris.", 'I travel to Paris.'], a: 0, exp: 'Plano decidido antes de falar: going to.' },
          { t: 'lacuna', frase: "I ___ forget, I promise.", op: ["won't", "don't", "wasn't"], a: 0, pt: 'Eu não vou esquecer, prometo.' },
          { t: 'lacuna', frase: "I don't think she ___ come.", op: ['will', "won't", 'is'], a: 0, pt: 'Acho que ela não vem.', exp: `Em inglês a negação vai no think: I don't think she will come.` },
          { t: 'escolha', ouvir: "I won't go.", op: ["I won't go.", 'I want to go.', "I wasn't going."], a: 0 },
          { t: 'escolha', ouvir: 'I want to go.', op: ['I want to go.', "I won't go.", "I'll go."], a: 0 },
          { t: 'montar', pt: 'Eu te ligo amanhã.', en: "I'll call you tomorrow", extra: ['going', 'calling'] },
          { t: 'montar', pt: 'Eu vou querer um café, por favor.', en: "I'll have a coffee please", extra: ['want', 'going'] },
          { t: 'pares', pares: [["I'll", 'I will'], ["won't", 'will not'], ["she'll", 'she will'], ["they'll", 'they will'], ["we'll", 'we will']] },
          { t: 'digitar', pt: 'Eu te ajudo com isso.', en: "I'll help you with that", alt: ['I will help you with that'] },
          { t: 'digitar', ouvir: 'I think it will rain.', en: 'I think it will rain', alt: ["I think it'll rain"] },
          { t: 'falar', en: "I'll call you tomorrow." },
          { t: 'falar', en: "Don't worry, I won't forget." }
        ]
      },
      {
        id: 'en-presente-continuo', title: 'Presente contínuo: o que está acontecendo agora',
        desc: 'Am/is/are + -ing para o que está acontecendo neste momento, as regras de escrita do -ing e a diferença para o presente simples.',
        objetivos: [
          'Formar o presente contínuo com am/is/are + verbo -ing',
          'Aplicar as regras de escrita do -ing',
          'Escolher entre presente simples (rotina) e contínuo (agora)'
        ],
        body: 'No módulo 3 você aprendeu o presente simples, da rotina. Agora vem o presente contínuo, do que está acontecendo neste instante — o nosso "estou fazendo". A estrutura é igualzinha ao português: estar + gerúndio.',
        content: [
          { h: 'A forma: to be + -ing',
            items: [
              `${EN("I'm working.")} (Estou trabalhando.) · ${EN("She's sleeping.")} · ${EN("They're watching TV.")}`,
              `Negativa: ${EN("I'm not working now.")} · ${EN("He isn't listening.")}`,
              `Pergunta: ${EN('Are you working?')} — ${EN('Yes, I am.')} · ${EN('What are you doing?')} (O que você está fazendo?)`
            ] },
          { h: 'Regras de escrita do -ing',
            items: [
              `A maioria: + ing — ${EN('work → working')} · ${EN('play → playing')}.`,
              `Terminados em -e mudo: tira o e — ${EN('make → making')} · ${EN('write → writing')}.`,
              `Consoante-vogal-consoante curto: dobra — ${EN('run → running')} · ${EN('swim → swimming')} · ${EN('sit → sitting')}.`,
              `-ie vira -ying: ${EN('lie → lying')} · ${EN('die → dying')}.`
            ] },
          { h: 'Simples ou contínuo?',
            items: [
              `Rotina, hábito, fato → simples: ${EN('I work from home.')} (todo dia)`,
              `Agora, neste momento, temporário → contínuo: ${EN("I'm working from home this week.")}`,
              `Palavras-pista: ${EN('now')}, ${EN('right now')}, ${EN('at the moment')}, ${EN('Look!')}, ${EN('Listen!')} → contínuo; ${EN('every day')}, ${EN('usually')}, ${EN('always')} → simples.`
            ] },
          { h: 'Verbos que não vão para o -ing',
            p: `Verbos de estado — gostar, saber, querer, precisar, entender — ficam no simples mesmo falando de agora: ${EN('I want a coffee now.')} (não "I\'m wanting") · ${EN('I understand.')} · ${EN('I know.')} · ${EN('I like it.')}` }
        ],
        pratica: [
          { t: 'lacuna', frase: "She's ___ right now.", op: ['sleeping', 'sleep', 'sleeps'], a: 0, pt: 'Ela está dormindo agora.' },
          { t: 'lacuna', frase: 'What ___ you doing?', op: ['are', 'do', 'is'], a: 0, pt: 'O que você está fazendo?' },
          { t: 'pares', pares: [['run', 'running'], ['make', 'making'], ['swim', 'swimming'], ['play', 'playing'], ['lie', 'lying']] },
          { t: 'escolha', q: 'Qual frase fala de ROTINA?', op: ['I work from home.', "I'm working from home.", "I'm work from home."], a: 0 },
          { t: 'escolha', q: 'Qual frase está correta?', op: ['I want a coffee now.', "I'm wanting a coffee now.", 'I wanting a coffee now.'], a: 0, exp: 'want é verbo de estado: não vai para o -ing, mesmo falando de agora.' },
          { t: 'lacuna', frase: 'Look! It ___.', op: ["'s snowing", 'snows', 'snow'], a: 0, pt: 'Olha! Está nevando.' },
          { t: 'escolha', ouvir: "They're watching TV.", op: ["They're watching TV.", 'They watch TV.', 'They watched TV.'], a: 0 },
          { t: 'montar', pt: 'Eu não estou trabalhando agora.', en: "I'm not working now", extra: ["don't", 'work'] },
          { t: 'montar', pt: 'Ele está escrevendo um e-mail.', en: "He's writing an email", extra: ['writeing', 'writes'] },
          { t: 'digitar', pt: 'O que você está fazendo?', en: 'What are you doing?', alt: ['What are you doing'] },
          { t: 'digitar', ouvir: "I'm working from home this week.", en: "I'm working from home this week", alt: ['I am working from home this week'] },
          { t: 'falar', en: "I'm studying English right now." },
          { t: 'falar', en: 'What are you doing?' }
        ]
      },
      {
        id: 'en-planos-convites', title: 'Combinando planos: compromissos e convites',
        desc: 'O presente contínuo para compromissos marcados, e as frases para convidar, aceitar, recusar e sugerir outro dia.',
        objetivos: [
          'Falar de compromissos marcados com o presente contínuo',
          'Convidar com Would you like to...? e sugerir com Let\'s / How about...?',
          'Aceitar, recusar com educação e propor outra data'
        ],
        body: 'Fechando o módulo do futuro: combinar um encontro. Você vai ver que o presente contínuo também fala do futuro — de compromissos já marcados — e aprender as frases educadas para convidar e responder.',
        content: [
          { h: 'Presente contínuo para compromissos marcados',
            items: [
              `Com data, hora, ingresso comprado: ${EN("I'm meeting Ana on Friday.")} (Vou encontrar a Ana na sexta.) · ${EN("We're flying to Lisbon tomorrow.")}`,
              `Pergunta típica: ${EN('What are you doing on Saturday?')} (O que você vai fazer no sábado?)`,
              `Os três futuros juntos: compromisso marcado → contínuo; plano/intenção → going to; decisão agora → will.`
            ] },
          { h: 'Convidar e sugerir',
            items: [
              `${EN('Are you free on Friday?')} (Você está livre na sexta?)`,
              `${EN('Would you like to have dinner with us?')} (Gostaria de jantar com a gente?) — educado e muito usado.`,
              `${EN("Let's go to the movies!")} (Vamos ao cinema!) · ${EN('How about Saturday?')} / ${EN('What about seven?')} (Que tal...?)`,
              `${EN('Do you want to...?')} — mais informal, entre amigos.`
            ] },
          { h: 'Aceitar e recusar',
            items: [
              `Aceitar: ${EN("I'd love to!")} (Adoraria!) · ${EN('Sounds great!')} (Parece ótimo!) · ${EN('Sure, why not?')}`,
              `Recusar com educação: ${EN("I'm sorry, I can't. I'm working on Friday.")} · ${EN("I'd love to, but I'm busy.")}`,
              `Propor outra data: ${EN('Maybe next week?')} · ${EN('How about Sunday instead?')} (Que tal domingo, em vez disso?)`
            ] },
          { h: 'Fechando o combinado',
            p: `${EN('See you on Saturday, then!')} (Até sábado, então!) · ${EN("Let's meet at the café at eight.")} · ${EN("I'll send you the address.")} — repare: uma decisão na hora, com will.` }
        ],
        pratica: [
          { t: 'escolha', q: 'Você já marcou um jantar com a Ana na sexta. Qual frase?', op: ["I'm having dinner with Ana on Friday.", "I'll have dinner with Ana on Friday.", 'I have dinner with Ana on Friday.'], a: 0, exp: 'Compromisso já marcado: presente contínuo.' },
          { t: 'escolha', q: 'Qual é o convite mais educado?', op: ['Would you like to have dinner with us?', 'You want dinner?', 'Come to dinner.'], a: 0 },
          { t: 'escolha', q: 'Como aceitar com entusiasmo?', op: ["I'd love to!", "I'd like it to!", 'I love to!'], a: 0 },
          { t: 'lacuna', frase: "___ go to the movies!", op: ["Let's", 'Lets', 'Let'], a: 0, pt: 'Vamos ao cinema!' },
          { t: 'lacuna', frase: 'How ___ Saturday?', op: ['about', 'for', 'is'], a: 0, pt: 'Que tal sábado?' },
          { t: 'montar', pt: 'O que você vai fazer no sábado?', en: 'What are you doing on Saturday?', extra: ['do', 'will'] },
          { t: 'montar', pt: 'Desculpa, não posso. Vou trabalhar na sexta.', en: "Sorry I can't I'm working on Friday", extra: ['work', 'in'] },
          { t: 'pares', pares: [['Sounds great!', 'Parece ótimo!'], ["I'd love to!", 'Adoraria!'], ['Are you free?', 'Você está livre?'], ['instead', 'em vez disso'], ['busy', 'ocupado']] },
          { t: 'escolha', ouvir: 'How about Sunday instead?', op: ['How about Sunday instead?', 'How was Sunday?', 'Are you free on Sunday?'], a: 0 },
          { t: 'digitar', pt: 'Você está livre na sexta?', en: 'Are you free on Friday?', alt: ['Are you free on Friday'] },
          { t: 'digitar', ouvir: 'See you on Saturday, then!', en: 'See you on Saturday then', alt: ['See you on Saturday, then'] },
          { t: 'falar', en: 'Would you like to have dinner with us?' },
          { t: 'falar', en: "I'd love to, but I'm busy." }
        ]
      }
    ]
  }
  ,
  {
    id: 'en-m07', title: 'Módulo 07 · Comparações e quantidades: comparativos, superlativos, much/many, some/any (A2)', kind: 'video',
    lessons: [
      {
        id: 'en-comparativos', title: 'Comparativos: bigger, more expensive, better',
        desc: 'Como comparar duas coisas em inglês: -er para palavras curtas, more para as longas, os irregulares e o as... as.',
        objetivos: [
          'Formar o comparativo com -er e com more',
          'Usar than para comparar e os irregulares better, worse e farther',
          'Dizer que duas coisas são iguais com as... as e not as... as'
        ],
        body: 'Esta casa é maior, aquele celular é mais caro, o meu inglês está melhor. Comparar é parte de toda decisão — de compras a viagens. Em inglês, a regra depende do tamanho do adjetivo.',
        content: [
          { h: 'Adjetivos curtos: -er + than',
            items: [
              `Uma sílaba: + ${EN('er')} — ${EN('tall → taller')} · ${EN('cheap → cheaper')}: ${EN('My brother is taller than me.')} (Meu irmão é mais alto que eu.)`,
              `Terminados em -e: só ${EN('r')} — ${EN('nice → nicer')} · ${EN('large → larger')}.`,
              `Consoante-vogal-consoante: dobra — ${EN('big → bigger')} · ${EN('hot → hotter')}.`,
              `Terminados em -y: ${EN('ier')} — ${EN('easy → easier')} · ${EN('happy → happier')} · ${EN('busy → busier')}.`
            ] },
          { h: 'Adjetivos longos: more',
            items: [
              `Duas sílabas ou mais (fora os de -y): ${EN('more')} + adjetivo — ${EN('expensive → more expensive')} · ${EN('interesting → more interesting')}.`,
              `${EN('This phone is more expensive than that one.')} (Este celular é mais caro que aquele.)`,
              `O contrário: ${EN('less')} — ${EN('less expensive')} (menos caro).`,
              `Nunca os dois juntos: "more cheaper" está errado.`
            ] },
          { h: 'Os irregulares',
            p: `${EN('good → better')} (melhor) · ${EN('bad → worse')} (pior) · ${EN('far → farther')} (mais longe). ${EN('My English is better now.')} · ${EN('The traffic is worse today.')}` },
          { h: 'Igual e diferente: as... as',
            items: [
              `${EN('as')} + adjetivo + ${EN('as')} = tão... quanto: ${EN("She's as tall as her mother.")}`,
              `Negativa: ${EN("It isn't as expensive as I thought.")} (Não é tão caro quanto eu pensava.)`,
              `Intensificar: ${EN('much bigger')} (bem maior) · ${EN('a little cheaper')} (um pouco mais barato).`
            ] }
        ],
        pratica: [
          { t: 'lacuna', frase: 'My brother is ___ than me.', op: ['taller', 'more tall', 'tallest'], a: 0, pt: 'Meu irmão é mais alto que eu.' },
          { t: 'lacuna', frase: 'This phone is ___ than that one.', op: ['more expensive', 'expensiver', 'most expensive'], a: 0, pt: 'Este celular é mais caro que aquele.' },
          { t: 'lacuna', frase: 'My English is ___ now.', op: ['better', 'gooder', 'more good'], a: 0, pt: 'Meu inglês está melhor agora.' },
          { t: 'pares', pares: [['big', 'bigger'], ['easy', 'easier'], ['good', 'better'], ['bad', 'worse'], ['far', 'farther']] },
          { t: 'escolha', q: 'Qual frase está correta?', op: ['This one is cheaper.', 'This one is more cheaper.', 'This one is more cheap.'], a: 0, exp: 'cheap é curto: cheaper. Nunca use more junto com -er.' },
          { t: 'escolha', q: 'Como se diz "tão alta quanto a mãe"?', op: ['as tall as her mother', 'so tall than her mother', 'tall as her mother'], a: 0 },
          { t: 'escolha', ouvir: "It isn't as expensive as I thought.", op: ["It isn't as expensive as I thought.", "It's more expensive than I thought.", "It isn't expensive at all."], a: 0 },
          { t: 'montar', pt: 'O trânsito está pior hoje.', en: 'The traffic is worse today', extra: ['badder', 'more'] },
          { t: 'montar', pt: 'O Rio é mais quente que São Paulo.', en: 'Rio is hotter than São Paulo', extra: ['more', 'that'] },
          { t: 'digitar', pt: 'Escreva o comparativo de "happy".', en: 'happier' },
          { t: 'digitar', ouvir: 'This hotel is much bigger.', en: 'This hotel is much bigger' },
          { t: 'falar', en: 'My English is better now.' },
          { t: 'falar', en: 'This one is cheaper than that one.' }
        ]
      },
      {
        id: 'en-superlativos', title: 'Superlativos: the biggest, the most beautiful, the best',
        desc: 'Como dizer que algo é o mais — o maior, o mais caro, o melhor — e as preposições que vêm depois.',
        objetivos: [
          'Formar o superlativo com the + -est e com the most',
          'Usar os irregulares the best, the worst e the farthest',
          'Completar com in (lugares e grupos) e of (períodos e quantidades)'
        ],
        body: 'Depois de comparar duas coisas, vem o superlativo: o maior de todos, o melhor do mundo. A lógica é a mesma da aula passada — curto ganha uma terminação, longo ganha uma palavra antes — e sempre com the.',
        content: [
          { h: 'Curtos: the + -est',
            items: [
              `${EN('tall → the tallest')} · ${EN('cheap → the cheapest')}: ${EN("He's the tallest in the family.")}`,
              `Mesmas regras de escrita: ${EN('big → the biggest')} · ${EN('nice → the nicest')} · ${EN('easy → the easiest')}.`
            ] },
          { h: 'Longos: the most',
            items: [
              `${EN('the most expensive')} · ${EN('the most beautiful')} · ${EN('the most interesting')}.`,
              `${EN("It's the most beautiful beach in Brazil.")} (É a praia mais bonita do Brasil.)`,
              `O contrário: ${EN('the least')} — ${EN('the least expensive')} (o menos caro).`
            ] },
          { h: 'Irregulares',
            p: `${EN('good → better → the best')} · ${EN('bad → worse → the worst')} · ${EN('far → farther → the farthest')}. ${EN("It's the best pizza in town!")} · ${EN('That was the worst day of my life.')}` },
          { h: 'In ou of depois do superlativo?',
            items: [
              `${EN('in')} para lugares e grupos: ${EN('the best restaurant in the city')} · ${EN('the tallest in my class')} — nunca "of the city".`,
              `${EN('of')} para períodos e quantidades: ${EN('the best day of my life')} · ${EN('the cheapest of the three')}.`,
              `Com experiência de vida, use ${EN('ever')}: ${EN("It's the best movie I've ever seen.")} (É o melhor filme que eu já vi.) — essa estrutura você vai aprofundar no módulo 9.`
            ] }
        ],
        pratica: [
          { t: 'lacuna', frase: "He's the ___ in the family.", op: ['tallest', 'taller', 'most tall'], a: 0, pt: 'Ele é o mais alto da família.' },
          { t: 'lacuna', frase: "It's the ___ beach in Brazil.", op: ['most beautiful', 'beautifulest', 'more beautiful'], a: 0, pt: 'É a praia mais bonita do Brasil.' },
          { t: 'lacuna', frase: "It's the ___ pizza in town!", op: ['best', 'goodest', 'better'], a: 0, pt: 'É a melhor pizza da cidade!' },
          { t: 'lacuna', frase: 'the best restaurant ___ the city', op: ['in', 'of', 'at'], a: 0, pt: 'o melhor restaurante da cidade', exp: 'Lugares e grupos: in. Mesmo que em português seja "da cidade".' },
          { t: 'lacuna', frase: 'That was the worst day ___ my life.', op: ['of', 'in', 'on'], a: 0, pt: 'Aquele foi o pior dia da minha vida.' },
          { t: 'pares', pares: [['big', 'the biggest'], ['good', 'the best'], ['bad', 'the worst'], ['easy', 'the easiest'], ['far', 'the farthest']] },
          { t: 'escolha', ouvir: "It's the best movie I've ever seen.", op: ["It's the best movie I've ever seen.", "It's a better movie than I saw.", "It's the worst movie I've ever seen."], a: 0 },
          { t: 'montar', pt: 'Este é o hotel mais barato.', en: 'This is the cheapest hotel', extra: ['most', 'cheaper'] },
          { t: 'montar', pt: 'Ela é a mais inteligente da turma.', en: "She's the smartest in the class", extra: ['of', 'more'] },
          { t: 'digitar', pt: 'Escreva o superlativo de "good".', en: 'the best', alt: ['best'] },
          { t: 'digitar', ouvir: 'This is the most expensive car.', en: 'This is the most expensive car' },
          { t: 'falar', en: "It's the best pizza in town!" },
          { t: 'falar', en: 'This is the cheapest of the three.' }
        ]
      },
      {
        id: 'en-contaveis', title: 'Contáveis e incontáveis: much, many, a lot of',
        desc: 'A diferença entre o que se conta e o que não se conta em inglês, e como falar de quantidade: much, many, a lot of, a few e a little.',
        objetivos: [
          'Distinguir substantivos contáveis e incontáveis',
          'Usar many com contáveis e much com incontáveis, e a lot of com os dois',
          'Perguntar How many / How much e usar a few e a little'
        ],
        body: 'Em inglês, algumas palavras não aceitam número nem plural: você não diz "two waters" nem "an advice". Saber o que é contável muda as palavras de quantidade — e evita alguns dos erros mais comuns de brasileiro.',
        content: [
          { h: 'Contável × incontável',
            items: [
              `Contáveis têm plural e aceitam a/an: ${EN('a book, two books')} · ${EN('an apple')} · ${EN('three people')}.`,
              `Incontáveis não têm plural: ${EN('water')}, ${EN('money')}, ${EN('time')}, ${EN('rice')}, ${EN('milk')}, ${EN('traffic')}.`,
              `Pegadinhas — incontáveis em inglês, contáveis em português: ${EN('information')} (informações), ${EN('advice')} (conselhos), ${EN('news')} (notícias), ${EN('furniture')} (móveis), ${EN('homework')}. Diga ${EN('some advice')}, ${EN('a piece of advice')} — nunca "advices".`
            ] },
          { h: 'Many, much, a lot of',
            items: [
              `${EN('many')} + contáveis: ${EN("There aren't many people here.")}`,
              `${EN('much')} + incontáveis: ${EN("I don't have much time.")}`,
              `${EN('a lot of')} serve para os dois e é o mais natural em frases afirmativas: ${EN('I have a lot of friends.')} · ${EN('She drinks a lot of coffee.')}`,
              `Na prática: much e many aparecem mais em perguntas e negativas.`
            ] },
          { h: 'How many? How much?',
            p: `${EN('How many brothers do you have?')} (contável) · ${EN('How much water do you drink?')} (incontável) · ${EN('How much is it?')} — preço também usa ${EN('much')}, porque dinheiro é incontável.` },
          { h: 'Poucos e pouco: a few, a little',
            items: [
              `${EN('a few')} + contáveis: ${EN('I have a few questions.')} (algumas perguntas)`,
              `${EN('a little')} + incontáveis: ${EN('Can I have a little milk?')} (um pouco de leite)`,
              `Sem o ${EN('a')}, o sentido fica negativo: ${EN('few people came')} (pouca gente veio — quase ninguém).`
            ] }
        ],
        pratica: [
          { t: 'lacuna', frase: "I don't have ___ time.", op: ['much', 'many', 'a few'], a: 0, pt: 'Eu não tenho muito tempo.' },
          { t: 'lacuna', frase: "There aren't ___ people here.", op: ['many', 'much', 'a little'], a: 0, pt: 'Não tem muita gente aqui.' },
          { t: 'lacuna', frase: 'How ___ brothers do you have?', op: ['many', 'much', 'lot'], a: 0, pt: 'Quantos irmãos você tem?' },
          { t: 'lacuna', frase: 'I have a ___ questions.', op: ['few', 'little', 'much'], a: 0, pt: 'Eu tenho algumas perguntas.' },
          { t: 'escolha', q: 'Qual frase está correta?', op: ['Can you give me some advice?', 'Can you give me some advices?', 'Can you give me an advice?'], a: 0, exp: 'advice é incontável em inglês: some advice ou a piece of advice.' },
          { t: 'escolha', q: 'Qual frase está correta?', op: ['I need some information.', 'I need some informations.', 'I need an information.'], a: 0 },
          { t: 'pares', pares: [['water', 'incontável'], ['book', 'contável'], ['money', 'incontável'], ['person', 'contável'], ['news', 'incontável']] },
          { t: 'escolha', ouvir: 'How much water do you drink?', op: ['How much water do you drink?', 'How many waters do you drink?', 'How much is the water?'], a: 0 },
          { t: 'montar', pt: 'Ela toma muito café.', en: 'She drinks a lot of coffee', extra: ['many', 'much'] },
          { t: 'montar', pt: 'Posso tomar um pouco de leite?', en: 'Can I have a little milk?', extra: ['few', 'many'] },
          { t: 'digitar', pt: 'Eu não tenho muito dinheiro.', en: "I don't have much money", alt: ["I don't have a lot of money", 'I do not have much money'] },
          { t: 'falar', en: 'How many people are there?' },
          { t: 'falar', en: "I don't have much time." }
        ]
      },
      {
        id: 'en-some-any-too', title: 'Something, anything, nothing e too / enough',
        desc: 'As palavras compostas com some, any e no (alguém, nada, algum lugar) e como dizer "demais" e "suficiente".',
        objetivos: [
          'Usar something, anything, nothing, someone, anyone, nobody, somewhere',
          'Evitar a dupla negação do português',
          'Dizer que algo é demais com too e suficiente com enough'
        ],
        body: 'Fechando o módulo: as palavras para "alguma coisa", "nada", "ninguém" e "algum lugar", e duas palavras que ajudam muito em compras e reclamações — too (demais) e enough (suficiente). Atenção especial à dupla negação, que o português usa e o inglês não.',
        content: [
          { h: 'Some-, any-, no- + thing / one / where',
            items: [
              `Coisas: ${EN('something')} (alguma coisa) · ${EN('anything')} (qualquer coisa / nada, em negativas) · ${EN('nothing')} (nada).`,
              `Pessoas: ${EN('someone')} / ${EN('somebody')} · ${EN('anyone')} / ${EN('anybody')} · ${EN('no one')} / ${EN('nobody')}.`,
              `Lugares: ${EN('somewhere')} · ${EN('anywhere')} · ${EN('nowhere')}.`,
              `Mesma regra de some e any: afirmativa → some-: ${EN("I'd like something to eat.")} · pergunta e negativa → any-: ${EN('Is anybody home?')}`
            ] },
          { h: 'Nada de dupla negação',
            items: [
              `Português: "Eu não vi nada" (duas negações). Inglês: só uma — ${EN("I didn't see anything.")} ou ${EN('I saw nothing.')}`,
              `Nunca "I didn't see nothing" — soa errado (e, em alguns contextos, como fala muito informal ou de música).`,
              `${EN("There's nobody here.")} = ${EN("There isn't anybody here.")}`
            ] },
          { h: 'Too: demais (problema)',
            items: [
              `${EN('too')} + adjetivo = mais do que deveria: ${EN("It's too expensive.")} (É caro demais — não vou comprar.)`,
              `${EN("This shirt is too small.")} · ${EN("It's too late.")}`,
              `Com substantivo: ${EN('too much')} (incontável) e ${EN('too many')} (contável): ${EN('too much sugar')} · ${EN('too many people')}.`
            ] },
          { h: 'Enough: suficiente',
            items: [
              `Depois do adjetivo: ${EN("It isn't big enough.")} (Não é grande o suficiente.)`,
              `Antes do substantivo: ${EN("We don't have enough time.")} · ${EN('Is there enough food?')}`,
              `Pronúncia: ${EN('enough')} soa "ináf".`
            ] }
        ],
        pratica: [
          { t: 'lacuna', frase: "I didn't see ___.", op: ['anything', 'nothing', 'something'], a: 0, pt: 'Eu não vi nada.', exp: `Em inglês só uma negação por frase: didn't + anything. Ou: I saw nothing.` },
          { t: 'lacuna', frase: "I'd like ___ to eat.", op: ['something', 'anything', 'nothing'], a: 0, pt: 'Eu queria alguma coisa para comer.' },
          { t: 'lacuna', frase: 'Is ___ home?', op: ['anybody', 'somebody', 'nobody'], a: 0, pt: 'Tem alguém em casa?' },
          { t: 'escolha', q: 'Qual frase está correta?', op: ["There's nobody here.", "There isn't nobody here.", "There's not nobody here."], a: 0 },
          { t: 'lacuna', frase: "It's ___ expensive. I won't buy it.", op: ['too', 'enough', 'very much'], a: 0, pt: 'É caro demais. Não vou comprar.' },
          { t: 'lacuna', frase: "It isn't big ___.", op: ['enough', 'too', 'much'], a: 0, pt: 'Não é grande o suficiente.', exp: 'enough vem DEPOIS do adjetivo (big enough) e ANTES do substantivo (enough time).' },
          { t: 'lacuna', frase: 'There are too ___ people here.', op: ['many', 'much', 'enough'], a: 0, pt: 'Tem gente demais aqui.' },
          { t: 'pares', pares: [['something', 'alguma coisa'], ['nothing', 'nada'], ['somebody', 'alguém'], ['nobody', 'ninguém'], ['somewhere', 'algum lugar']] },
          { t: 'montar', pt: 'Nós não temos tempo suficiente.', en: "We don't have enough time", extra: ['too', 'much'] },
          { t: 'montar', pt: 'Esta camisa é pequena demais.', en: 'This shirt is too small', extra: ['enough', 'very'] },
          { t: 'digitar', ouvir: "I don't know anybody here.", en: "I don't know anybody here", alt: ["I don't know anyone here"] },
          { t: 'falar', en: "It's too expensive." },
          { t: 'falar', en: "I didn't see anything." }
        ]
      }
    ]
  }
  ,
  {
    id: 'en-m08', title: 'Módulo 08 · Viagem: aeroporto, hotel, restaurante, conselhos e direções (A2)', kind: 'video',
    lessons: [
      {
        id: 'en-aeroporto-hotel', title: 'No aeroporto e no hotel',
        desc: 'O vocabulário e as frases prontas para fazer check-in, passar pela imigração, embarcar e se hospedar num hotel.',
        objetivos: [
          'Entender e usar as palavras do aeroporto: boarding pass, gate, luggage, delayed',
          'Responder às perguntas da imigração',
          'Fazer check-in e check-out no hotel e pedir algo na recepção'
        ],
        body: 'Viajar é a razão número um para aprender inglês — e o aeroporto é o primeiro lugar onde você vai precisar dele. A boa notícia: as conversas de aeroporto e hotel são muito previsíveis. Com as frases desta aula você resolve quase tudo.',
        content: [
          { h: 'No check-in',
            items: [
              `${EN('Can I see your passport, please?')} (Posso ver seu passaporte?) · ${EN('Do you have any bags to check?')} (Vai despachar alguma mala?)`,
              `${EN('luggage')} / ${EN('baggage')} (bagagem — incontável!) · ${EN('carry-on')} (bagagem de mão) · ${EN('checked bag')} (mala despachada).`,
              `${EN('boarding pass')} (cartão de embarque) · ${EN('gate')} (portão) · ${EN('aisle seat')} (corredor) · ${EN('window seat')} (janela).`,
              `${EN('Your flight is delayed.')} (Seu voo está atrasado.) · ${EN('cancelled')} (cancelado) · ${EN('on time')} (no horário) · ${EN('boarding')} (embarque).`
            ] },
          { h: 'Na imigração',
            items: [
              `${EN("What's the purpose of your visit?")} — ${EN("I'm here on vacation.")} / ${EN("I'm here on business.")} (a passeio / a trabalho)`,
              `${EN('How long are you staying?')} — ${EN('For two weeks.')} (Por duas semanas.)`,
              `${EN('Where are you staying?')} — ${EN("At the Plaza Hotel.")} · Responda curto e direto; não precisa explicar demais.`
            ] },
          { h: 'No hotel',
            items: [
              `${EN('I have a reservation under the name Silva.')} (Tenho uma reserva no nome de Silva.)`,
              `${EN("I'd like to check in.")} · ${EN('What time is check-out?')} · ${EN('Is breakfast included?')} (O café da manhã está incluído?)`,
              `Problemas: ${EN("The air conditioning isn't working.")} · ${EN('Could I have another towel?')} · ${EN("What's the Wi-Fi password?")}`
            ] },
          { h: 'Falsos amigos de viagem',
            p: `${EN('lunch')} é almoço, não lanche (lanche é ${EN('snack')}). ${EN('Exit')} é a saída. E nas portas: ${EN('pull')} é puxe e ${EN('push')} é empurre — o contrário do que muita gente imagina!` }
        ],
        pratica: [
          { t: 'pares', pares: [['boarding pass', 'cartão de embarque'], ['gate', 'portão'], ['delayed', 'atrasado'], ['carry-on', 'bagagem de mão'], ['aisle seat', 'assento no corredor']] },
          { t: 'escolha', q: `O oficial pergunta ${EN("What's the purpose of your visit?")} Você vai a passeio:`, op: ["I'm here on vacation.", "I'm here for vacations.", 'I came to visit purpose.'], a: 0 },
          { t: 'escolha', q: `${EN('How long are you staying?')}`, op: ['For two weeks.', 'Two weeks ago.', 'Since two weeks.'], a: 0 },
          { t: 'escolha', q: 'Qual frase está correta?', op: ['I have two bags.', 'I have two luggages.', 'I have two baggages.'], a: 0, exp: 'luggage e baggage são incontáveis. Para contar, use bags ou pieces of luggage.' },
          { t: 'escolha', q: `Numa porta está escrito ${EN('PULL')}. O que fazer?`, op: ['Puxar', 'Empurrar', 'Apertar'], a: 0, opPt: true, exp: 'pull = puxe; push = empurre. Falso amigo clássico.' },
          { t: 'montar', pt: 'Eu tenho uma reserva no nome de Silva.', en: 'I have a reservation under the name Silva', extra: ['in', 'on'] },
          { t: 'montar', pt: 'O café da manhã está incluído?', en: 'Is breakfast included?', extra: ['coffee', 'the'] },
          { t: 'escolha', ouvir: 'Your flight is delayed.', op: ['Your flight is delayed.', 'Your flight is cancelled.', 'Your flight is on time.'], a: 0 },
          { t: 'escolha', ouvir: 'Do you have any bags to check?', op: ['Do you have any bags to check?', 'Can I check your passport?', 'Do you want a window seat?'], a: 0 },
          { t: 'digitar', pt: 'Eu gostaria de fazer o check-in.', en: "I'd like to check in", alt: ['I would like to check in'] },
          { t: 'digitar', ouvir: "What's the Wi-Fi password?", en: "What's the Wi-Fi password", alt: ['What is the Wi-Fi password', "What's the wifi password"] },
          { t: 'falar', en: "I'm here on vacation." },
          { t: 'falar', en: 'What time is check-out?' }
        ]
      },
      {
        id: 'en-restaurante', title: 'No restaurante: would like e como pedir',
        desc: 'Do "mesa para dois" até pedir a conta: as frases do restaurante e o would like, o jeito educado de pedir qualquer coisa.',
        objetivos: [
          'Pedir de forma educada com I\'d like e Could I have...?',
          'Entender as perguntas do garçom',
          'Pedir a conta, perguntar sobre ingredientes e reclamar com educação'
        ],
        body: 'Em restaurante, a diferença entre soar educado e soar grosso está numa palavra. "I want a beer" é direto demais; "I\'d like a beer, please" é o padrão. Esta aula é o roteiro completo de uma refeição, do começo ao fim.',
        content: [
          { h: 'Would like: querer, com educação',
            items: [
              `${EN("I'd like")} = ${EN('I would like')} (eu gostaria): ${EN("I'd like the chicken, please.")}`,
              `${EN('Would you like...?')} (Você gostaria...?) — ${EN('Would you like something to drink?')} — ${EN("Yes, I'd like a juice.")}`,
              `Também educado: ${EN('Could I have the menu?')} · ${EN("I'll have the fish.")} (Vou querer o peixe.)`,
              `Evite ${EN('I want')} com garçom — não é errado, mas soa infantil ou ríspido.`
            ] },
          { h: 'Chegando e pedindo',
            items: [
              `${EN('A table for two, please.')} · ${EN('Do you have a reservation?')}`,
              `${EN('Are you ready to order?')} — ${EN('Not yet. Could we have a few more minutes?')}`,
              `${EN('What do you recommend?')} · ${EN("What's in this dish?")} (O que vai neste prato?)`,
              `${EN('starter')} / ${EN('appetizer')} (entrada) · ${EN('main course')} (prato principal) · ${EN('dessert')} (sobremesa — cuidado: ${EN('desert')} é deserto).`
            ] },
          { h: 'Restrições e problemas',
            items: [
              `${EN("I'm allergic to peanuts.")} · ${EN("I'm vegetarian.")} · ${EN('Does it have gluten?')}`,
              `${EN('Excuse me, this is cold.')} · ${EN("I didn't order this.")} — sempre começando com ${EN('Excuse me')}.`
            ] },
          { h: 'A conta e a gorjeta',
            p: `${EN('Could we have the check, please?')} (EUA) ou ${EN('the bill')} (Reino Unido). ${EN('Can I pay by card?')} Nos Estados Unidos a gorjeta (${EN('tip')}) não vem na conta e costuma ficar entre 15% e 20% — é parte do salário do garçom.` }
        ],
        pratica: [
          { t: 'escolha', q: 'Qual é o jeito educado de pedir?', op: ["I'd like the chicken, please.", 'I want the chicken.', 'Give me the chicken.'], a: 0 },
          { t: 'lacuna', frase: '___ you like something to drink?', op: ['Would', 'Do', 'Are'], a: 0, pt: 'Você gostaria de algo para beber?' },
          { t: 'lacuna', frase: 'A table ___ two, please.', op: ['for', 'to', 'of'], a: 0, pt: 'Uma mesa para dois, por favor.' },
          { t: 'escolha', q: 'Como pedir a conta nos Estados Unidos?', op: ['Could we have the check, please?', 'Could we have the count, please?', 'Give the account.'], a: 0 },
          { t: 'escolha', q: `O que é ${EN('dessert')}?`, op: ['sobremesa', 'deserto', 'entrada'], a: 0, opPt: true, exp: 'dessert (dois s) = sobremesa. desert (um s) = deserto.' },
          { t: 'pares', pares: [['starter', 'entrada'], ['main course', 'prato principal'], ['dessert', 'sobremesa'], ['tip', 'gorjeta'], ['check', 'conta']] },
          { t: 'montar', pt: 'O que você recomenda?', en: 'What do you recommend?', extra: ['are', 'recommends'] },
          { t: 'montar', pt: 'Eu sou alérgico a amendoim.', en: "I'm allergic to peanuts", extra: ['of', 'have'] },
          { t: 'escolha', ouvir: 'Are you ready to order?', op: ['Are you ready to order?', 'Do you have a reservation?', 'Would you like dessert?'], a: 0 },
          { t: 'digitar', pt: 'Vou querer o peixe.', en: "I'll have the fish", alt: ["I'd like the fish", 'I will have the fish'] },
          { t: 'digitar', ouvir: "Excuse me, I didn't order this.", en: "Excuse me, I didn't order this", alt: ['Excuse me, I did not order this'] },
          { t: 'falar', en: "I'd like a coffee, please." },
          { t: 'falar', en: 'Could we have the check, please?' }
        ]
      },
      {
        id: 'en-should-have-to', title: 'Should, could e have to: conselhos e obrigações',
        desc: 'Como dar conselho (should), sugerir opções (could) e falar de obrigação (have to e must) — e a diferença entre don\'t have to e mustn\'t.',
        objetivos: [
          'Dar e pedir conselhos com should e shouldn\'t',
          'Sugerir possibilidades com could',
          'Falar de obrigação com have to e must, e de proibição com mustn\'t'
        ],
        body: 'Numa viagem você vai pedir e receber muitos conselhos: "você devia visitar tal lugar", "você tem que levar o passaporte". O inglês tem um verbo para cada nível de força — e uma armadilha famosa entre don\'t have to e mustn\'t.',
        content: [
          { h: 'Should: conselho',
            items: [
              `${EN('You should visit Central Park.')} (Você deveria visitar o Central Park.) · ${EN("You shouldn't drink tap water there.")}`,
              `Pedir conselho: ${EN('What should I do?')} · ${EN('Should I take a taxi?')}`,
              `Como can e will: igual para todas as pessoas e verbo puro depois — ${EN('she should go')}, nunca "shoulds" nem "should to go".`
            ] },
          { h: 'Could: possibilidade e sugestão',
            p: `Mais suave que should, para dar opções: ${EN('You could take the subway, or you could walk.')} (Você poderia pegar o metrô ou ir a pé.) Lembra que ${EN('could')} também é o pedido educado: ${EN('Could you help me?')}` },
          { h: 'Have to e must: obrigação',
            items: [
              `${EN('have to')}: obrigação que vem de fora, regra — ${EN('You have to show your passport.')} · com he/she: ${EN('She has to work on Saturday.')}`,
              `${EN('must')}: obrigação forte, comum em avisos e regras escritas — ${EN('Passengers must wear seat belts.')}`,
              `No passado só existe ${EN('had to')}: ${EN('I had to wait two hours.')} (Tive que esperar duas horas.)`
            ] },
          { h: 'A armadilha: don\'t have to × mustn\'t',
            items: [
              `${EN("You don't have to pay.")} = não é obrigatório, é grátis — pode pagar se quiser.`,
              `${EN("You mustn't smoke here.")} = é proibido.`,
              `Os sentidos são completamente diferentes, embora em português os dois pareçam "não precisa / não pode".`
            ] }
        ],
        pratica: [
          { t: 'lacuna', frase: 'You ___ visit Central Park. It\'s beautiful!', op: ['should', 'must', 'have'], a: 0, pt: 'Você deveria visitar o Central Park. É lindo!' },
          { t: 'lacuna', frase: 'You ___ show your passport.', op: ['have to', 'should to', 'has to'], a: 0, pt: 'Você tem que mostrar o passaporte.' },
          { t: 'lacuna', frase: 'She ___ to work on Saturday.', op: ['has', 'have', 'must'], a: 0, pt: 'Ela tem que trabalhar no sábado.' },
          { t: 'lacuna', frase: 'I ___ to wait two hours yesterday.', op: ['had', 'have', 'must'], a: 0, pt: 'Eu tive que esperar duas horas ontem.' },
          { t: 'escolha', q: `O que significa ${EN("You don't have to pay.")}`, op: ['Não é obrigatório pagar.', 'É proibido pagar.', 'Você não pode pagar.'], a: 0, opPt: true, exp: `don't have to = não é obrigatório. mustn't = é proibido.` },
          { t: 'escolha', q: `O que significa ${EN("You mustn't smoke here.")}`, op: ['É proibido fumar aqui.', 'Você não precisa fumar aqui.', 'Você deveria fumar aqui.'], a: 0, opPt: true },
          { t: 'escolha', q: 'Qual frase está correta?', op: ['She should go.', 'She shoulds go.', 'She should to go.'], a: 0 },
          { t: 'montar', pt: 'O que eu devo fazer?', en: 'What should I do?', extra: ['must', 'have'] },
          { t: 'montar', pt: 'Você poderia pegar o metrô.', en: 'You could take the subway', extra: ['should', 'to'] },
          { t: 'pares', pares: [['should', 'conselho'], ['could', 'sugestão / possibilidade'], ['have to', 'obrigação'], ["don't have to", 'não é obrigatório'], ["mustn't", 'proibido']] },
          { t: 'digitar', ouvir: "You shouldn't drink tap water.", en: "You shouldn't drink tap water", alt: ['You should not drink tap water'] },
          { t: 'falar', en: 'You should visit the museum.' },
          { t: 'falar', en: 'I had to wait two hours.' }
        ]
      },
      {
        id: 'en-direcoes', title: 'Pedindo e dando direções',
        desc: 'Como perguntar o caminho com educação e entender as respostas: go straight, turn left, take the second right, it\'s on your left.',
        objetivos: [
          'Perguntar o caminho com Excuse me, how do I get to...?',
          'Entender e dar instruções com go straight, turn, take, cross',
          'Descrever onde fica o lugar: on your left, at the end of, past the bank'
        ],
        body: 'Mesmo com GPS no celular, pedir informação na rua continua sendo uma das conversas mais comuns de uma viagem — e uma ótima chance de praticar. As respostas usam sempre as mesmas poucas expressões, e é isso que você vai treinar aqui.',
        content: [
          { h: 'Perguntando',
            items: [
              `${EN('Excuse me, how do I get to the train station?')} (Com licença, como eu chego à estação de trem?)`,
              `${EN('Is there a pharmacy near here?')} · ${EN("Where's the nearest subway station?")}`,
              `${EN('Is it far?')} (É longe?) — ${EN("It's a five-minute walk.")} (Fica a cinco minutos a pé.)`
            ] },
          { h: 'As instruções',
            items: [
              `${EN('Go straight')} / ${EN('Go straight ahead')} (siga em frente) · ${EN('Go down this street')} (desça esta rua).`,
              `${EN('Turn left')} / ${EN('Turn right')} (vire à esquerda / direita) · ${EN('at the corner')} · ${EN('at the traffic lights')} (no semáforo).`,
              `${EN('Take the second right.')} (Pegue a segunda à direita.) · ${EN('Cross the street.')} (Atravesse a rua.)`,
              `${EN('Go past the bank.')} (Passe pelo banco.) · ${EN('until you see a church')} (até ver uma igreja).`
            ] },
          { h: 'Chegando',
            p: `${EN("It's on your left.")} (Fica à sua esquerda.) · ${EN("It's at the end of the street.")} (no fim da rua) · ${EN("It's across from the park.")} · ${EN("You can't miss it!")} (Não tem como errar!)` },
          { h: 'Se não entender',
            p: `${EN('Sorry, could you say that again?')} · ${EN('Could you speak more slowly, please?')} · ${EN('Can you show me on the map?')} — pedir para repetir é normal e educado, ninguém espera que turista entenda tudo de primeira.` }
        ],
        pratica: [
          { t: 'pares', pares: [['turn left', 'virar à esquerda'], ['go straight', 'seguir em frente'], ['cross the street', 'atravessar a rua'], ['traffic lights', 'semáforo'], ['corner', 'esquina']] },
          { t: 'montar', pt: 'Com licença, como eu chego à estação?', en: 'Excuse me how do I get to the station?', extra: ['arrive', 'go'] },
          { t: 'lacuna', frase: 'Take the second ___.', op: ['right', 'rights', 'righter'], a: 0, pt: 'Pegue a segunda à direita.' },
          { t: 'lacuna', frase: "It's ___ your left.", op: ['on', 'in', 'at'], a: 0, pt: 'Fica à sua esquerda.' },
          { t: 'lacuna', frase: "It's at the end ___ the street.", op: ['of', 'in', 'on'], a: 0, pt: 'Fica no fim da rua.' },
          { t: 'escolha', q: `O que significa ${EN("You can't miss it!")}`, op: ['Não tem como errar!', 'Você não pode perder isso!', 'Você não pode ir lá!'], a: 0, opPt: true },
          { t: 'escolha', q: 'Você não entendeu. Como pedir para repetir?', op: ['Sorry, could you say that again?', 'Repeat.', 'What you said?'], a: 0 },
          { t: 'escolha', ouvir: 'Go straight and turn left at the traffic lights.', op: ['Siga em frente e vire à esquerda no semáforo.', 'Vire à direita e siga em frente.', 'Atravesse a rua no semáforo.'], a: 0, opPt: true },
          { t: 'escolha', ouvir: "It's a five-minute walk.", op: ['Fica a cinco minutos a pé.', 'São cinco ruas.', 'Fica a cinco quilômetros.'], a: 0, opPt: true },
          { t: 'digitar', pt: 'É longe?', en: 'Is it far?', alt: ['Is it far'] },
          { t: 'digitar', ouvir: 'Could you speak more slowly, please?', en: 'Could you speak more slowly please', alt: ['Could you speak more slowly, please', 'Could you speak more slowly please?'] },
          { t: 'falar', en: 'Excuse me, how do I get to the station?' },
          { t: 'falar', en: 'Go straight and turn right.' }
        ]
      }
    ]
  }
  ,
  {
    id: 'en-m09', title: 'Módulo 09 · Present perfect: experiências, for/since, already/yet e a diferença para o passado (B1)', kind: 'video',
    lessons: [
      {
        id: 'en-pp-experiencias', title: 'Present perfect: Have you ever...?',
        desc: 'O tempo verbal que não existe igual em português: have/has + particípio para experiências de vida, com ever e never.',
        objetivos: [
          'Formar o present perfect com have/has + particípio passado',
          'Falar de experiências de vida com ever e never',
          'Usar been e gone corretamente'
        ],
        body: 'Começa o nível B1, e com ele o tempo verbal mais temido por brasileiros: o present perfect. Ele não tem equivalente exato em português, mas a ideia é simples. Nesta primeira aula, o uso mais fácil: experiências de vida, sem dizer quando aconteceram.',
        content: [
          { h: 'A forma: have / has + particípio',
            items: [
              `${EN("I've visited Paris.")} (Eu já visitei Paris.) — ${EN("I've")} = ${EN('I have')}.`,
              `${EN("She's seen that movie.")} — com he/she/it: ${EN('has')} (${EN("she's")} aqui é ${EN('she has')}, não ${EN('she is')}).`,
              `Particípio dos regulares: igual ao passado — ${EN('visit → visited')}, ${EN('work → worked')}.`,
              `Irregulares têm uma terceira forma: ${EN('see → saw → seen')} · ${EN('go → went → gone')} · ${EN('eat → ate → eaten')} · ${EN('be → was → been')} · ${EN('do → did → done')}.`
            ] },
          { h: 'Experiências de vida: ever e never',
            items: [
              `${EN('Have you ever been to Japan?')} (Você já foi ao Japão? — em algum momento da vida)`,
              `${EN("Yes, I have.")} / ${EN("No, I haven't.")} · ${EN("I've never eaten sushi.")} (Eu nunca comi sushi.)`,
              `O importante é a experiência, não o momento. Se disser quando, muda de tempo: ${EN('I went to Japan in 2019.')}`,
              `${EN('never')} já é negativo: ${EN("I've never seen it")} — nunca "I haven't never".`
            ] },
          { h: 'Been ou gone?',
            items: [
              `${EN("She's been to London.")} = ela já foi e voltou (experiência).`,
              `${EN("She's gone to London.")} = ela foi e está lá agora.`,
              `Por isso a pergunta de experiência é ${EN('Have you ever been to...?')}`
            ] },
          { h: 'Particípios que você vai usar sempre',
            p: `${EN('been')} (ser/estar/ir) · ${EN('done')} (fazer) · ${EN('seen')} (ver) · ${EN('eaten')} (comer) · ${EN('had')} (ter) · ${EN('made')} (fazer) · ${EN('written')} (escrever) · ${EN('taken')} (pegar) · ${EN('met')} (conhecer pessoa) · ${EN('tried')} (experimentar).` }
        ],
        pratica: [
          { t: 'lacuna', frase: "I've ___ Paris twice.", op: ['visited', 'visit', 'visiting'], a: 0, pt: 'Eu já visitei Paris duas vezes.' },
          { t: 'lacuna', frase: 'She ___ seen that movie.', op: ['has', 'have', 'is'], a: 0, pt: 'Ela já viu esse filme.' },
          { t: 'lacuna', frase: 'Have you ever ___ to Japan?', op: ['been', 'gone', 'went'], a: 0, pt: 'Você já foi ao Japão?', exp: 'Para experiência (foi e voltou), use been.' },
          { t: 'pares', pares: [['see', 'seen'], ['eat', 'eaten'], ['go', 'gone'], ['write', 'written'], ['do', 'done']] },
          { t: 'escolha', q: `Responda: ${EN('Have you ever eaten sushi?')} (não)`, op: ["No, I haven't.", "No, I didn't.", "No, I don't."], a: 0 },
          { t: 'escolha', q: 'Qual frase está correta?', op: ["I've never seen it.", "I haven't never seen it.", "I never have seen it."], a: 0 },
          { t: 'escolha', q: `O que significa ${EN("She's gone to London.")}`, op: ['Ela foi para Londres e está lá.', 'Ela já esteve em Londres.', 'Ela vai para Londres.'], a: 0, opPt: true },
          { t: 'montar', pt: 'Você já experimentou comida brasileira?', en: 'Have you ever tried Brazilian food?', extra: ['Did', 'try'] },
          { t: 'montar', pt: 'Eu nunca andei de avião.', en: "I've never been on a plane", extra: ["haven't", 'went'] },
          { t: 'escolha', ouvir: "I've met her before.", op: ["I've met her before.", 'I met her yesterday.', "I'll meet her later."], a: 0 },
          { t: 'digitar', pt: 'Ela já foi ao Brasil.', en: "She's been to Brazil", alt: ['She has been to Brazil'] },
          { t: 'falar', en: 'Have you ever been to London?' },
          { t: 'falar', en: "I've never eaten sushi." }
        ]
      },
      {
        id: 'en-pp-for-since', title: 'For e since: desde quando?',
        desc: 'O present perfect para algo que começou no passado e continua até agora — e o erro mais comum de brasileiro: "I live here for ten years".',
        objetivos: [
          'Usar o present perfect para situações que continuam até hoje',
          'Escolher entre for (período) e since (ponto de partida)',
          'Perguntar How long have you...?'
        ],
        body: '"Eu moro aqui há dez anos." Em português usamos o presente. Em inglês, quem diz "I live here for ten years" erra: para algo que começou no passado e continua até agora, o inglês usa o present perfect. É o uso mais importante desse tempo verbal.',
        content: [
          { h: 'Do passado até agora',
            items: [
              `${EN("I've lived here for ten years.")} (Eu moro aqui há dez anos — e continuo morando.)`,
              `${EN("She's worked at the bank since 2019.")} (Ela trabalha no banco desde 2019.)`,
              `Erro clássico: "I live here for ten years" ou "I am here since Monday". Com duração até hoje, é present perfect.`
            ] },
          { h: 'For × since',
            items: [
              `${EN('for')} + período (quanto tempo): ${EN('for two years')} · ${EN('for a long time')} · ${EN('for three months')}.`,
              `${EN('since')} + ponto de partida (desde quando): ${EN('since 2019')} · ${EN('since Monday')} · ${EN('since I was a child')}.`,
              `Dica: se dá para dizer "há", é ${EN('for')}; se dá para dizer "desde", é ${EN('since')}.`
            ] },
          { h: 'How long...?',
            p: `${EN('How long have you lived here?')} (Há quanto tempo você mora aqui?) · ${EN('How long have you known her?')} (Há quanto tempo você a conhece?) — ${EN("I've known her since college.")}` },
          { h: 'Com o verbo to be',
            p: `${EN("I've been here since Monday.")} (Estou aqui desde segunda.) · ${EN("We've been married for five years.")} (Somos casados há cinco anos.) · ${EN("How long have you been a teacher?")}` }
        ],
        pratica: [
          { t: 'escolha', q: 'Como se diz "Eu moro aqui há dez anos"?', op: ["I've lived here for ten years.", 'I live here for ten years.', 'I lived here since ten years.'], a: 0, exp: 'Algo que começou no passado e continua: present perfect + for.' },
          { t: 'lacuna', frase: "She's worked here ___ 2019.", op: ['since', 'for', 'ago'], a: 0, pt: 'Ela trabalha aqui desde 2019.' },
          { t: 'lacuna', frase: "We've been married ___ five years.", op: ['for', 'since', 'during'], a: 0, pt: 'Somos casados há cinco anos.' },
          { t: 'lacuna', frase: "I've known her ___ college.", op: ['since', 'for', 'from'], a: 0, pt: 'Eu a conheço desde a faculdade.' },
          { t: 'pares', pares: [['for two years', 'há dois anos'], ['since Monday', 'desde segunda'], ['for a long time', 'há muito tempo'], ['since 2019', 'desde 2019'], ['How long?', 'Há quanto tempo?']] },
          { t: 'escolha', q: 'Qual frase está correta?', op: ["I've been here since Monday.", "I'm here since Monday.", 'I am here for Monday.'], a: 0 },
          { t: 'montar', pt: 'Há quanto tempo você mora aqui?', en: 'How long have you lived here?', extra: ['do', 'live'] },
          { t: 'montar', pt: 'Ele é professor há vinte anos.', en: "He's been a teacher for twenty years", extra: ['since', 'is'] },
          { t: 'escolha', ouvir: "I've studied English for three years.", op: ["I've studied English for three years.", 'I studied English three years ago.', "I'll study English for three years."], a: 0 },
          { t: 'digitar', pt: 'Eu conheço o Ben há muito tempo.', en: "I've known Ben for a long time", alt: ['I have known Ben for a long time'] },
          { t: 'digitar', ouvir: 'How long have you been a teacher?', en: 'How long have you been a teacher' },
          { t: 'falar', en: "I've lived here for ten years." },
          { t: 'falar', en: 'How long have you worked there?' }
        ]
      },
      {
        id: 'en-pp-already-yet-just', title: 'Already, yet e just',
        desc: 'Três palavrinhas que acompanham o present perfect para falar de coisas recentes: já, ainda não e acabei de.',
        objetivos: [
          'Usar already para "já" (antes do esperado)',
          'Usar yet em perguntas ("já?") e negativas ("ainda não")',
          'Usar just para "acabou de"'
        ],
        body: 'No trabalho e no dia a dia, o present perfect aparece o tempo todo com três palavras: "você já mandou o e-mail?", "ainda não", "acabei de mandar". Saber a posição de cada uma é o que faz você soar natural.',
        content: [
          { h: 'Already: já',
            items: [
              `${EN("I've already sent the email.")} (Eu já mandei o e-mail.) — entre ${EN('have')} e o particípio.`,
              `Indica que aconteceu, muitas vezes antes do esperado: ${EN("She's already finished!")} (Ela já terminou!)`
            ] },
          { h: 'Yet: já? / ainda não',
            items: [
              `Em pergunta = já: ${EN('Have you finished the report yet?')} (Você já terminou o relatório?)`,
              `Em negativa = ainda não: ${EN("I haven't finished it yet.")} (Ainda não terminei.)`,
              `${EN('yet')} vai no fim da frase. Resposta curta muito usada: ${EN('Not yet.')} (Ainda não.)`
            ] },
          { h: 'Just: acabou de',
            items: [
              `${EN("I've just arrived.")} (Acabei de chegar.) · ${EN("He's just called.")} (Ele acabou de ligar.)`,
              `Mesma posição de ${EN('already')}: entre ${EN('have')} e o particípio.`
            ] },
          { h: 'E no inglês americano?',
            p: `Nos Estados Unidos é comum ouvir essas palavras com o passado simples: ${EN('Did you eat yet?')} · ${EN('I just arrived.')} Os dois estão certos; o present perfect é o padrão das provas e do inglês britânico, e entendê-lo deixa você preparado para os dois.` }
        ],
        pratica: [
          { t: 'lacuna', frase: "I've ___ sent the email.", op: ['already', 'yet', 'still'], a: 0, pt: 'Eu já mandei o e-mail.' },
          { t: 'lacuna', frase: "I haven't finished it ___.", op: ['yet', 'already', 'just'], a: 0, pt: 'Ainda não terminei.' },
          { t: 'lacuna', frase: 'Have you finished the report ___?', op: ['yet', 'already', 'just'], a: 0, pt: 'Você já terminou o relatório?', exp: 'Em perguntas, "já" no fim da frase é yet.' },
          { t: 'lacuna', frase: "I've ___ arrived.", op: ['just', 'yet', 'ever'], a: 0, pt: 'Acabei de chegar.' },
          { t: 'pares', pares: [['already', 'já'], ['yet (pergunta)', 'já?'], ['not yet', 'ainda não'], ['just', 'acabou de'], ['never', 'nunca']] },
          { t: 'escolha', q: `Responda que ainda não: ${EN('Have you seen the new movie yet?')}`, op: ['Not yet.', 'Already not.', 'Yet no.'], a: 0 },
          { t: 'montar', pt: 'Ele acabou de ligar.', en: "He's just called", extra: ['yet', 'already'] },
          { t: 'montar', pt: 'Você já almoçou?', en: 'Have you had lunch yet?', extra: ['already', 'Did'] },
          { t: 'escolha', ouvir: "She's already finished!", op: ["She's already finished!", "She hasn't finished yet.", "She's just started."], a: 0 },
          { t: 'digitar', pt: 'Eu ainda não terminei.', en: "I haven't finished yet", alt: ['I have not finished yet'] },
          { t: 'digitar', ouvir: "I've just arrived.", en: "I've just arrived", alt: ['I have just arrived'] },
          { t: 'falar', en: "I haven't finished it yet." },
          { t: 'falar', en: "I've already sent the email." }
        ]
      },
      {
        id: 'en-pp-vs-passado', title: 'Present perfect ou passado simples?',
        desc: 'A regra que resolve de vez a dúvida: tempo terminado e definido usa o passado; tempo indefinido ou que continua usa o present perfect.',
        objetivos: [
          'Escolher entre present perfect e passado simples',
          'Reconhecer as palavras que pedem cada tempo',
          'Contar uma experiência: present perfect para introduzir, passado para os detalhes'
        ],
        body: 'Fechando o módulo, a pergunta que todo aluno faz: quando é "I went" e quando é "I\'ve been"? A resposta está numa única pergunta — o momento está definido e terminado? Se sim, passado simples. Se não, present perfect.',
        content: [
          { h: 'A regra de ouro',
            items: [
              `Momento definido e terminado → passado simples: ${EN('I went to Paris in 2019.')} · ${EN('I saw her yesterday.')}`,
              `Momento indefinido, ou período que ainda não acabou → present perfect: ${EN("I've been to Paris.")} · ${EN("I've seen her this week.")}`,
              `Nunca misture: "I've seen her yesterday" está errado — ${EN('yesterday')} é um momento terminado.`
            ] },
          { h: 'Palavras-pista',
            items: [
              `Passado simples: ${EN('yesterday')}, ${EN('last week')}, ${EN('in 2019')}, ${EN('two days ago')}, ${EN('when I was a child')}, ${EN('What time...?')}, ${EN('When...?')}`,
              `Present perfect: ${EN('ever')}, ${EN('never')}, ${EN('already')}, ${EN('yet')}, ${EN('just')}, ${EN('for')}, ${EN('since')}, ${EN('this week')} (ainda não acabou), ${EN('so far')} (até agora).`,
              `Pergunta com ${EN('When')} sempre vai para o passado: ${EN('When did you arrive?')} — nunca "When have you arrived?"`
            ] },
          { h: 'Como as conversas funcionam',
            p: `O present perfect abre o assunto; o passado conta os detalhes: ${EN('— Have you ever been to Rio?')} ${EN("— Yes, I have. I went there last year. It was amazing!")} A pergunta é sobre experiência; a resposta, com quando e como, vai para o passado.` },
          { h: 'Morar, trabalhar: terminou ou não?',
            p: `${EN("I've lived in São Paulo for five years.")} = ainda moro lá. ${EN('I lived in São Paulo for five years.')} = morei, não moro mais. Uma letra muda a história.` }
        ],
        pratica: [
          { t: 'lacuna', frase: 'I ___ to Paris in 2019.', op: ['went', "'ve been", 'have gone'], a: 0, pt: 'Eu fui a Paris em 2019.', exp: 'in 2019 é um momento definido e terminado: passado simples.' },
          { t: 'lacuna', frase: "I ___ to Paris twice.", op: ["'ve been", 'went', 'go'], a: 0, pt: 'Eu já fui a Paris duas vezes.' },
          { t: 'escolha', q: 'Qual frase está correta?', op: ['I saw her yesterday.', "I've seen her yesterday.", 'I have saw her yesterday.'], a: 0 },
          { t: 'escolha', q: 'Qual frase está correta?', op: ['When did you arrive?', 'When have you arrived?', 'When you arrived?'], a: 0, exp: 'Perguntas com When pedem o passado simples.' },
          { t: 'escolha', q: `${EN("I lived in São Paulo for five years.")} significa:`, op: ['Morei em São Paulo, não moro mais.', 'Moro em São Paulo há cinco anos.', 'Vou morar em São Paulo.'], a: 0, opPt: true },
          { t: 'pares', pares: [['yesterday', 'passado simples'], ['ever', 'present perfect'], ['two days ago', 'passado simples'], ['since 2020', 'present perfect'], ['last week', 'passado simples']] },
          { t: 'montar', pt: 'Você já foi ao Rio? Sim, fui no ano passado.', en: 'Have you ever been to Rio? Yes I went there last year', extra: ['Did', 'gone'] },
          { t: 'lacuna', frase: "I ___ three cups of coffee this morning.", op: ['had', "'ve had", 'have'], a: 0, pt: 'Eu tomei três xícaras de café hoje de manhã. (já é tarde, a manhã acabou)', exp: 'Se a manhã já terminou, o período está fechado: passado simples. Ainda de manhã, daria para dizer I\'ve had.' },
          { t: 'escolha', ouvir: "I've worked here since 2020.", op: ['Trabalho aqui desde 2020.', 'Trabalhei aqui em 2020.', 'Vou trabalhar aqui em 2020.'], a: 0, opPt: true },
          { t: 'digitar', pt: 'Eu a vi ontem.', en: 'I saw her yesterday' },
          { t: 'digitar', ouvir: "Have you ever been to Rio?", en: 'Have you ever been to Rio' },
          { t: 'falar', en: 'Yes, I have. I went there last year.' },
          { t: 'falar', en: 'When did you arrive?' }
        ]
      }
    ]
  }
  ,
  {
    id: 'en-m10', title: 'Módulo 10 · Conditionals: if, when, unless e hipóteses (B1)', kind: 'video',
    lessons: [
      {
        id: 'en-condicional-0-1', title: 'Zero e first conditional: se acontecer...',
        desc: 'Frases com "se" para fatos que sempre acontecem e para possibilidades reais no futuro — e a regra de não usar will depois do if.',
        objetivos: [
          'Usar o zero conditional para fatos e regras gerais',
          'Usar o first conditional para possibilidades reais no futuro',
          'Evitar will depois de if'
        ],
        body: 'Toda decisão tem um "se": se chover, eu fico em casa; se você esquentar a água, ela ferve. Em inglês, essas frases têm estruturas fixas — e uma regra que pega quase todo brasileiro: depois do if, nada de will.',
        content: [
          { h: 'Zero conditional: sempre que',
            items: [
              `if + presente, presente — fatos, regras, coisas que sempre acontecem: ${EN('If you heat water to 100 degrees, it boils.')}`,
              `${EN("If I drink coffee at night, I can't sleep.")} (Se eu tomo café à noite, não consigo dormir.)`,
              `Aqui ${EN('if')} quase significa "sempre que" — dá para trocar por ${EN('when')}.`
            ] },
          { h: 'First conditional: possibilidade real',
            items: [
              `if + presente, will + verbo — algo que pode acontecer no futuro: ${EN("If it rains, I'll stay home.")} (Se chover, vou ficar em casa.)`,
              `${EN("If you study, you'll pass the test.")} · ${EN("If she calls, I'll tell you.")}`,
              `A ordem pode inverter, sem vírgula: ${EN("I'll stay home if it rains.")}`
            ] },
          { h: 'A regra de ouro: nada de will depois do if',
            items: [
              `Em português usamos o futuro do subjuntivo: "se chover". Em inglês, depois do ${EN('if')}, vai o presente simples: ${EN('If it rains')} — nunca "If it will rain".`,
              `O ${EN('will')} fica na outra parte da frase, a do resultado.`,
              `No lugar de ${EN('will')} também cabem ${EN('can')}, ${EN('should')}, ${EN('might')} ou um imperativo: ${EN("If you're tired, go to bed.")}`
            ] }
        ],
        pratica: [
          { t: 'lacuna', frase: "If it ___, I'll stay home.", op: ['rains', 'will rain', 'rained'], a: 0, pt: 'Se chover, vou ficar em casa.', exp: 'Depois do if, presente simples — nunca will.' },
          { t: 'lacuna', frase: "If you study, you ___ pass the test.", op: ['will', 'would', 'are'], a: 0, pt: 'Se você estudar, vai passar na prova.' },
          { t: 'lacuna', frase: 'If you heat water to 100 degrees, it ___.', op: ['boils', 'will boil', 'boiled'], a: 0, pt: 'Se você esquentar a água a 100 graus, ela ferve.' },
          { t: 'escolha', q: 'Qual frase está correta?', op: ["If she calls, I'll tell you.", "If she will call, I'll tell you.", 'If she calls, I tell you tomorrow.'], a: 0 },
          { t: 'escolha', q: 'Qual frase é um zero conditional (fato geral)?', op: ["If I drink coffee at night, I can't sleep.", "If I see him, I'll tell him.", 'If I had money, I would travel.'], a: 0 },
          { t: 'montar', pt: 'Se você estiver cansado, vá para a cama.', en: "If you're tired go to bed", extra: ['will', 'are'] },
          { t: 'montar', pt: 'Eu vou ficar em casa se chover.', en: "I'll stay home if it rains", extra: ['will', 'rain'] },
          { t: 'pares', pares: [['If it rains,', "I'll stay home."], ['If you heat ice,', 'it melts.'], ['If you study,', "you'll pass."], ["If you're tired,", 'go to bed.'], ['If she calls,', "I'll tell you."]] },
          { t: 'escolha', ouvir: "If I finish early, I'll call you.", op: ["If I finish early, I'll call you.", 'If I finished early, I would call you.', "When I finish, I called you."], a: 0 },
          { t: 'digitar', pt: 'Se chover, eu vou ficar em casa.', en: "If it rains, I'll stay home", alt: ['If it rains, I will stay home', "If it rains I'll stay home"] },
          { t: 'digitar', ouvir: "If you need help, call me.", en: 'If you need help, call me', alt: ['If you need help call me'] },
          { t: 'falar', en: "If it rains, I'll stay home." },
          { t: 'falar', en: "If you study, you'll pass the test." }
        ]
      },
      {
        id: 'en-condicional-2', title: 'Second conditional: e se...?',
        desc: 'Hipóteses imaginárias e situações irreais: If I had more time, I would... — e o famoso If I were you, para dar conselho.',
        objetivos: [
          'Usar o second conditional para hipóteses improváveis ou imaginárias',
          'Formar a frase com if + passado e would + verbo',
          'Dar conselho com If I were you...'
        ],
        body: '"Se eu ganhasse na loteria, eu viajaria pelo mundo." Para situações imaginárias, que provavelmente não vão acontecer ou não são verdade agora, o inglês usa o passado depois do if — mesmo falando do presente ou do futuro.',
        content: [
          { h: 'A forma: if + passado, would + verbo',
            items: [
              `${EN('If I won the lottery, I would travel around the world.')} (Se eu ganhasse na loteria, viajaria pelo mundo.)`,
              `${EN("If I had more time, I'd learn to play the guitar.")} — ${EN("I'd")} = ${EN('I would')}.`,
              `O passado aqui não fala do passado: indica que a situação é irreal ou improvável.`
            ] },
          { h: 'First ou second?',
            items: [
              `Possível, real → first: ${EN("If I have time tomorrow, I'll call you.")} (pode acontecer)`,
              `Imaginário, improvável → second: ${EN("If I lived in Paris, I'd eat croissants every day.")} (eu não moro em Paris)`,
              `A escolha mostra o que você acha da chance: ${EN("If I get the job, I'll buy a car.")} (acredito) × ${EN('If I got the job, I would buy a car.')} (acho difícil)`
            ] },
          { h: 'If I were you: conselho',
            items: [
              `${EN("If I were you, I'd talk to her.")} (Se eu fosse você, eu falaria com ela.)`,
              `Com ${EN('be')}, o padrão formal usa ${EN('were')} para todas as pessoas: ${EN('If I were rich...')} · ${EN('If she were here...')} Na fala você vai ouvir ${EN('was')} também.`
            ] },
          { h: 'Perguntas imaginárias',
            p: `Ótimas para puxar conversa: ${EN('What would you do if you won a million dollars?')} · ${EN('Where would you live if you could live anywhere?')} Resposta: ${EN("I'd buy a house by the beach.")}` }
        ],
        pratica: [
          { t: 'lacuna', frase: 'If I ___ the lottery, I would travel.', op: ['won', 'win', 'will win'], a: 0, pt: 'Se eu ganhasse na loteria, eu viajaria.' },
          { t: 'lacuna', frase: "If I had more time, I ___ learn the guitar.", op: ['would', 'will', 'am'], a: 0, pt: 'Se eu tivesse mais tempo, aprenderia violão.' },
          { t: 'lacuna', frase: "If I ___ you, I'd talk to her.", op: ['were', 'am', 'will be'], a: 0, pt: 'Se eu fosse você, falaria com ela.' },
          { t: 'escolha', q: 'Você NÃO mora em Paris. Qual frase?', op: ["If I lived in Paris, I'd eat croissants every day.", "If I live in Paris, I'll eat croissants every day.", 'If I lived in Paris, I eat croissants.'], a: 0, exp: 'Situação imaginária (não é verdade agora): second conditional.' },
          { t: 'escolha', q: 'Você acredita que vai conseguir a vaga. Qual frase?', op: ["If I get the job, I'll buy a car.", 'If I got the job, I would buy a car.', 'If I will get the job, I buy a car.'], a: 0 },
          { t: 'montar', pt: 'O que você faria se ganhasse um milhão de dólares?', en: 'What would you do if you won a million dollars?', extra: ['will', 'win'] },
          { t: 'montar', pt: 'Se eu fosse rico, compraria uma casa na praia.', en: "If I were rich I'd buy a house by the beach", extra: ['will', 'am'] },
          { t: 'pares', pares: [["I'd", 'I would'], ['If I were you', 'Se eu fosse você'], ['would + verbo', 'futuro do pretérito'], ['If I had', 'Se eu tivesse'], ['won', 'ganhasse']] },
          { t: 'escolha', ouvir: "If I had a car, I'd drive to work.", op: ["If I had a car, I'd drive to work.", "If I have a car, I'll drive to work.", "I had a car and I drove to work."], a: 0 },
          { t: 'digitar', pt: 'Se eu fosse você, eu falaria com ele.', en: "If I were you, I'd talk to him", alt: ['If I were you, I would talk to him', "If I were you I'd talk to him"] },
          { t: 'digitar', ouvir: 'Where would you live if you could live anywhere?', en: 'Where would you live if you could live anywhere' },
          { t: 'falar', en: "If I were you, I'd take the job." },
          { t: 'falar', en: 'What would you do if you won the lottery?' }
        ]
      },
      {
        id: 'en-if-when', title: 'If ou when? E as orações de tempo',
        desc: 'A diferença entre "se" e "quando" e a regra das orações de tempo: when, as soon as, before e after também pedem presente, mesmo falando do futuro.',
        objetivos: [
          'Escolher entre if (talvez aconteça) e when (vai acontecer)',
          'Usar presente depois de when, as soon as, before, after e until para o futuro',
          'Montar planos encadeados: As soon as I arrive, I\'ll call you'
        ],
        body: '"Quando eu chegar, eu te ligo." Em português, futuro do subjuntivo de novo. Em inglês, a mesma regra do if vale para as palavras de tempo: depois de when, as soon as, before e after, nada de will. E escolher entre if e when muda o sentido da frase.',
        content: [
          { h: 'If × when',
            items: [
              `${EN('if')}: talvez aconteça — ${EN("If I see Ben, I'll tell him.")} (talvez eu o veja)`,
              `${EN('when')}: vai acontecer, é só questão de tempo — ${EN("When I see Ben, I'll tell him.")} (vou vê-lo com certeza)`,
              `${EN("When I get home, I'll call you.")} — você vai chegar em casa, certo? Então é ${EN('when')}, não ${EN('if')}.`
            ] },
          { h: 'Orações de tempo: presente para o futuro',
            items: [
              `${EN("As soon as I arrive, I'll call you.")} (Assim que eu chegar, te ligo.)`,
              `${EN("I'll have dinner before I go out.")} · ${EN("We'll talk after the meeting ends.")}`,
              `${EN("I'll wait until you finish.")} (Vou esperar até você terminar.)`,
              `Nunca "When I will arrive" ou "as soon as I will get" — o futuro fica só na outra parte da frase.`
            ] },
          { h: 'Resumo da regra',
            p: `Depois de ${EN('if')}, ${EN('when')}, ${EN('as soon as')}, ${EN('before')}, ${EN('after')} e ${EN('until')}, use o presente simples — mesmo que a ideia seja futura. É uma das diferenças mais sistemáticas entre o português e o inglês, e dominar isso já coloca você à frente de muita gente.` }
        ],
        pratica: [
          { t: 'lacuna', frase: "___ I get home, I'll call you.", op: ['When', 'If', 'Will'], a: 0, pt: 'Quando eu chegar em casa, te ligo.', exp: 'Você vai chegar em casa (é certo): when.' },
          { t: 'lacuna', frase: "As soon as I ___, I'll call you.", op: ['arrive', 'will arrive', 'arrived'], a: 0, pt: 'Assim que eu chegar, te ligo.' },
          { t: 'lacuna', frase: "I'll wait until you ___.", op: ['finish', 'will finish', 'finished'], a: 0, pt: 'Vou esperar até você terminar.' },
          { t: 'lacuna', frase: "___ it's sunny tomorrow, we'll go to the beach.", op: ['If', 'When', 'As soon as'], a: 0, pt: 'Se fizer sol amanhã, vamos à praia.', exp: 'Não é certo que vai fazer sol: if.' },
          { t: 'escolha', q: 'Qual frase está correta?', op: ["We'll talk after the meeting ends.", "We'll talk after the meeting will end.", 'We talk after the meeting will end.'], a: 0 },
          { t: 'pares', pares: [['as soon as', 'assim que'], ['until', 'até (que)'], ['before', 'antes de'], ['after', 'depois de'], ['when', 'quando']] },
          { t: 'montar', pt: 'Vou jantar antes de sair.', en: "I'll have dinner before I go out", extra: ['will', 'going'] },
          { t: 'montar', pt: 'Quando eu vir o Ben, vou contar para ele.', en: "When I see Ben I'll tell him", extra: ['will', 'If'] },
          { t: 'escolha', ouvir: "As soon as I land, I'll text you.", op: ['Assim que eu pousar, te mando mensagem.', 'Se eu pousar, te ligo.', 'Quando pousei, te mandei mensagem.'], a: 0, opPt: true },
          { t: 'digitar', pt: 'Assim que eu chegar, eu te ligo.', en: "As soon as I arrive, I'll call you", alt: ['As soon as I arrive, I will call you', "As soon as I get there, I'll call you"] },
          { t: 'digitar', ouvir: "I'll wait until you finish.", en: "I'll wait until you finish", alt: ['I will wait until you finish'] },
          { t: 'falar', en: "When I get home, I'll call you." },
          { t: 'falar', en: "As soon as I arrive, I'll text you." }
        ]
      },
      {
        id: 'en-unless-rather', title: 'Unless, in case e would rather',
        desc: 'Três ferramentas para falar de condições e preferências: a menos que, caso, e prefiro.',
        objetivos: [
          'Usar unless com o sentido de "a menos que / se não"',
          'Usar in case para precaução ("caso")',
          'Expressar preferência com would rather e prefer'
        ],
        body: 'Fechando o módulo das condições, três expressões que deixam o seu inglês bem mais natural: unless (a menos que), in case (por precaução) e would rather (eu preferiria). Todas seguem a regra que você já conhece: depois delas, presente para falar do futuro.',
        content: [
          { h: 'Unless: a menos que',
            items: [
              `${EN('unless')} = ${EN('if... not')}: ${EN("I won't go unless you come with me.")} (Não vou, a menos que você venha comigo.)`,
              `= ${EN("I won't go if you don't come with me.")}`,
              `Cuidado: ${EN('unless')} já é negativo. Não diga "unless you don't".`
            ] },
          { h: 'In case: caso, por precaução',
            items: [
              `${EN("Take an umbrella in case it rains.")} (Leve um guarda-chuva caso chova.)`,
              `Diferença: ${EN('if')} = só se acontecer; ${EN('in case')} = já se prepara antes. ${EN("I'll buy more food in case Ben comes.")} (compro agora, por via das dúvidas)`
            ] },
          { h: 'Would rather e prefer',
            items: [
              `${EN("I'd rather")} + verbo puro = eu preferiria: ${EN("I'd rather stay home tonight.")}`,
              `Comparando: ${EN("I'd rather walk than take the bus.")} (Prefiro andar a pegar o ônibus.)`,
              `Pergunta: ${EN('Would you rather have coffee or tea?')}`,
              `${EN('prefer')} para gosto geral: ${EN('I prefer tea to coffee.')} (repare: ${EN('to')}, não "than")`
            ] },
          { h: 'Revisão do módulo',
            p: `Zero: ${EN('If you heat ice, it melts.')} · First: ${EN("If it rains, I'll stay home.")} · Second: ${EN("If I had a car, I'd drive.")} · Tempo: ${EN("When I arrive, I'll call.")} · ${EN('Unless')}, ${EN('in case')}, ${EN('would rather')}. Você agora fala de hipóteses, planos e preferências.` }
        ],
        pratica: [
          { t: 'lacuna', frase: "I won't go ___ you come with me.", op: ['unless', 'if', 'in case'], a: 0, pt: 'Não vou, a menos que você venha comigo.' },
          { t: 'lacuna', frase: 'Take an umbrella ___ it rains.', op: ['in case', 'unless', 'if not'], a: 0, pt: 'Leve um guarda-chuva caso chova.' },
          { t: 'lacuna', frase: "I'd rather ___ home tonight.", op: ['stay', 'to stay', 'staying'], a: 0, pt: 'Eu prefiro ficar em casa hoje à noite.', exp: `would rather + verbo puro, sem to.` },
          { t: 'lacuna', frase: 'I prefer tea ___ coffee.', op: ['to', 'than', 'that'], a: 0, pt: 'Eu prefiro chá a café.' },
          { t: 'escolha', q: 'Qual frase está correta?', op: ["You can't come in unless you have a ticket.", "You can't come in unless you don't have a ticket.", "You can't come in unless you will have a ticket."], a: 0, exp: 'unless já é negativo: não use don\'t junto.' },
          { t: 'escolha', q: `${EN("I'd rather walk than take the bus.")} significa:`, op: ['Prefiro andar a pegar o ônibus.', 'Eu andaria se pegasse o ônibus.', 'Prefiro o ônibus.'], a: 0, opPt: true },
          { t: 'montar', pt: 'Você prefere café ou chá?', en: 'Would you rather have coffee or tea?', extra: ['prefer', 'than'] },
          { t: 'montar', pt: 'Vou comprar mais comida caso o Ben venha.', en: "I'll buy more food in case Ben comes", extra: ['will', 'unless'] },
          { t: 'pares', pares: [['unless', 'a menos que'], ['in case', 'caso, por precaução'], ["I'd rather", 'eu preferiria'], ['prefer A to B', 'preferir A a B'], ['as soon as', 'assim que']] },
          { t: 'escolha', ouvir: "I'll be there unless it rains.", op: ['Estarei lá, a menos que chova.', 'Estarei lá caso chova.', 'Estarei lá se chover.'], a: 0, opPt: true },
          { t: 'digitar', pt: 'Eu prefiro ficar em casa.', en: "I'd rather stay home", alt: ['I would rather stay home', 'I prefer to stay home', "I'd rather stay at home"] },
          { t: 'falar', en: "I'd rather walk than take the bus." },
          { t: 'falar', en: 'Take an umbrella in case it rains.' }
        ]
      }
    ]
  }
  ,
  {
    id: 'en-m11', title: 'Módulo 11 · Phrasal verbs e verbos com -ing ou to (B1)', kind: 'video',
    lessons: [
      {
        id: 'en-phrasal-basico', title: 'Phrasal verbs: o que são e como funcionam',
        desc: 'Verbo + partícula com sentido novo: wake up, turn on, put on, pick up — e onde colocar o objeto (turn it on).',
        objetivos: [
          'Entender o que é um phrasal verb e por que o sentido muda',
          'Usar os phrasal verbs da rotina: wake up, get up, turn on/off, put on, take off',
          'Saber onde vai o objeto: turn on the light / turn it on'
        ],
        body: 'Phrasal verbs são verbos que ganham uma partícula — up, on, off, out — e com ela um sentido novo. "Give" é dar; "give up" é desistir. Eles estão em toda conversa de nativo, e é por isso que muita gente entende o livro mas não entende a série. A boa notícia: os mais usados são poucas dezenas.',
        content: [
          { h: 'Verbo + partícula = sentido novo',
            items: [
              `${EN('look')} (olhar) → ${EN('look for')} (procurar) · ${EN('look after')} (cuidar de)`,
              `${EN('give')} (dar) → ${EN('give up')} (desistir)`,
              `Às vezes o sentido é lógico (${EN('come back')} = voltar), às vezes não (${EN('give up')}). Aprenda cada um como uma palavra nova, dentro de uma frase.`
            ] },
          { h: 'Os da rotina',
            items: [
              `${EN('wake up')} (acordar) · ${EN('get up')} (levantar) · ${EN('get dressed')} (se vestir)`,
              `${EN('turn on')} / ${EN('turn off')} (ligar / desligar aparelho ou luz) — ${EN('Turn off the TV.')}`,
              `${EN('put on')} (vestir, colocar) / ${EN('take off')} (tirar roupa; e também decolar) — ${EN('Put on your jacket.')}`,
              `${EN('pick up')} (pegar, buscar alguém) — ${EN("I'll pick you up at eight.")} (Te busco às oito.)`
            ] },
          { h: 'Onde vai o objeto',
            items: [
              `Com substantivo, pode ir antes ou depois da partícula: ${EN('Turn on the light.')} = ${EN('Turn the light on.')}`,
              `Com pronome (it, them, me, you), ele vai <strong>no meio</strong>: ${EN('Turn it on.')} — nunca "turn on it".`,
              `${EN('Put it on.')} · ${EN('Pick me up.')} · ${EN('Take them off.')}`
            ] },
          { h: 'Inseparáveis',
            p: `Alguns não se separam nunca, mesmo com pronome: ${EN('look after')} → ${EN('I look after my sister.')} / ${EN('I look after her.')} · ${EN('get on the bus')} (entrar no ônibus) / ${EN('get off the bus')} (descer). Na dúvida, a forma com o pronome no fim só é certa nos inseparáveis.` }
        ],
        pratica: [
          { t: 'pares', pares: [['wake up', 'acordar'], ['turn off', 'desligar'], ['put on', 'vestir'], ['take off', 'tirar (roupa)'], ['pick up', 'buscar alguém']] },
          { t: 'lacuna', frase: 'Please turn ___ the TV. I want to sleep.', op: ['off', 'on', 'up'], a: 0, pt: 'Por favor, desligue a TV. Quero dormir.' },
          { t: 'lacuna', frase: "It's cold. Put ___ your jacket.", op: ['on', 'off', 'up'], a: 0, pt: 'Está frio. Vista a jaqueta.' },
          { t: 'escolha', q: 'Qual frase está correta?', op: ['Turn it on.', 'Turn on it.', 'Turn it.'], a: 0, exp: 'Com pronome (it, them, me), ele vai no meio do phrasal verb.' },
          { t: 'escolha', q: 'Qual frase está correta?', op: ["I'll pick you up at eight.", "I'll pick up you at eight.", "I'll up pick you at eight."], a: 0 },
          { t: 'escolha', q: `O que significa ${EN('give up')}?`, op: ['desistir', 'dar para cima', 'devolver'], a: 0, opPt: true },
          { t: 'montar', pt: 'Tire os sapatos, por favor.', en: 'Take off your shoes please', extra: ['out', 'put'] },
          { t: 'montar', pt: 'Eu levanto às sete.', en: 'I get up at seven', extra: ['wake', 'on'] },
          { t: 'escolha', ouvir: 'Can you turn the light off?', op: ['Você pode apagar a luz?', 'Você pode acender a luz?', 'Você pode trocar a luz?'], a: 0, opPt: true },
          { t: 'digitar', pt: 'Ligue o computador.', en: 'Turn on the computer', alt: ['Turn the computer on'] },
          { t: 'digitar', ouvir: 'I look after my little sister.', en: 'I look after my little sister' },
          { t: 'falar', en: 'Turn it off, please.' },
          { t: 'falar', en: "I'll pick you up at eight." }
        ]
      },
      {
        id: 'en-phrasal-trabalho', title: 'Phrasal verbs do trabalho e do dia a dia',
        desc: 'Os phrasal verbs que mais aparecem em e-mails, reuniões e na vida: look for, find out, figure out, give up, run out of, set up, call back e catch up.',
        objetivos: [
          'Usar look for, find out e figure out',
          'Usar give up, run out of e set up',
          'Usar call back e catch up em situações de trabalho'
        ],
        body: 'Numa reunião em inglês, você vai ouvir "let\'s figure it out", "we ran out of time", "I\'ll call you back". Esses phrasal verbs são o vocabulário real do dia a dia profissional, e quase nenhum livro básico ensina. Aqui estão os mais frequentes.',
        content: [
          { h: 'Procurar, descobrir, entender',
            items: [
              `${EN('look for')} = procurar: ${EN("I'm looking for a new job.")}`,
              `${EN('find out')} = descobrir (uma informação): ${EN("I'll find out what time the meeting starts.")}`,
              `${EN('figure out')} = entender, resolver (um problema): ${EN("Let's figure it out together.")} (Vamos resolver juntos.)`
            ] },
          { h: 'Desistir, acabar, montar',
            items: [
              `${EN('give up')} = desistir / largar: ${EN("Don't give up!")} · ${EN('I gave up smoking.')} (Parei de fumar.)`,
              `${EN('run out of')} = ficar sem, acabar: ${EN('We ran out of coffee.')} (Acabou o café.) · ${EN("We're running out of time.")}`,
              `${EN('set up')} = configurar, montar, marcar: ${EN("Let's set up a meeting.")} · ${EN('I set up the new laptop.')}`
            ] },
          { h: 'Telefone e atualização',
            items: [
              `${EN('call back')} = retornar a ligação: ${EN("I'll call you back in five minutes.")}`,
              `${EN('catch up')} = colocar a conversa em dia / se atualizar: ${EN("Let's catch up over coffee.")} · ${EN('I need to catch up on my emails.')}`,
              `${EN('follow up')} = dar seguimento: ${EN("I'm following up on my last email.")} — frase clássica de e-mail profissional.`
            ] },
          { h: 'Dica de estudo',
            p: `Agrupe os phrasal verbs por situação, não por partícula. Decorar "todos com up" confunde; aprender "os do telefone" ou "os da reunião" fica na memória, porque você já imagina onde vai usar.` }
        ],
        pratica: [
          { t: 'pares', pares: [['look for', 'procurar'], ['find out', 'descobrir'], ['give up', 'desistir'], ['run out of', 'ficar sem'], ['call back', 'retornar a ligação']] },
          { t: 'lacuna', frase: "I'm looking ___ a new job.", op: ['for', 'at', 'after'], a: 0, pt: 'Estou procurando um emprego novo.' },
          { t: 'lacuna', frase: 'We ran out ___ coffee.', op: ['of', 'from', 'off'], a: 0, pt: 'Acabou o café.' },
          { t: 'lacuna', frase: "I'll call you ___ in five minutes.", op: ['back', 'up', 'off'], a: 0, pt: 'Te retorno a ligação em cinco minutos.' },
          { t: 'escolha', q: 'Qual o melhor phrasal verb para "Vamos resolver isso juntos"?', op: ["Let's figure it out together.", "Let's find it out together.", "Let's look it for together."], a: 0, exp: 'figure out = entender/resolver um problema. find out = descobrir uma informação.' },
          { t: 'escolha', q: `O que significa ${EN("Let's catch up over coffee.")}`, op: ['Vamos colocar o papo em dia tomando um café.', 'Vamos pegar um café.', 'Vamos correr atrás do café.'], a: 0, opPt: true },
          { t: 'montar', pt: 'Não desista!', en: "Don't give up!", extra: ['out', 'stop'] },
          { t: 'montar', pt: 'Vamos marcar uma reunião.', en: "Let's set up a meeting", extra: ['make', 'on'] },
          { t: 'escolha', ouvir: "We're running out of time.", op: ['Nosso tempo está acabando.', 'Estamos correndo contra o tempo.', 'Estamos atrasados.'], a: 0, opPt: true },
          { t: 'digitar', pt: 'Eu vou descobrir a que horas começa.', en: "I'll find out what time it starts", alt: ['I will find out what time it starts'] },
          { t: 'digitar', ouvir: "I'm following up on my last email.", en: "I'm following up on my last email", alt: ['I am following up on my last email'] },
          { t: 'falar', en: "Let's figure it out together." },
          { t: 'falar', en: "I'll call you back in five minutes." }
        ]
      },
      {
        id: 'en-gerundio-infinitivo', title: 'Gerúndio ou infinitivo: enjoy doing, want to do',
        desc: 'Depois de alguns verbos vem -ing, depois de outros vem to + verbo. As listas essenciais e a regra das preposições.',
        objetivos: [
          'Usar -ing depois de enjoy, finish, avoid, mind e suggest',
          'Usar to + verbo depois de want, need, decide, plan, hope e would like',
          'Usar -ing depois de preposições e com verbos que aceitam os dois'
        ],
        body: 'Por que é "I enjoy cooking" e não "I enjoy to cook"? Por que "I want to travel" e não "I want traveling"? Em inglês, o verbo que vem primeiro decide a forma do segundo. Não há lógica escondida — mas os verbos mais comuns cabem em duas listas curtas.',
        content: [
          { h: 'Verbo + -ing',
            items: [
              `${EN('enjoy')} (gostar de) · ${EN('finish')} (terminar) · ${EN('avoid')} (evitar) · ${EN('mind')} (se importar) · ${EN('suggest')} (sugerir) · ${EN('keep')} (continuar) · ${EN('miss')} (sentir falta)`,
              `${EN('I enjoy cooking.')} · ${EN('I finished working at six.')} · ${EN('Would you mind closing the window?')} (Você se importaria de fechar a janela?)`,
              `${EN('Keep going!')} (Continue!) · ${EN('I miss living by the beach.')}`
            ] },
          { h: 'Verbo + to + verbo',
            items: [
              `${EN('want')} · ${EN('need')} · ${EN('decide')} · ${EN('plan')} · ${EN('hope')} · ${EN('promise')} · ${EN('learn')} · ${EN('would like')}`,
              `${EN('I want to travel.')} · ${EN('She decided to quit.')} · ${EN("I'd like to order.")} · ${EN("I'm learning to drive.")}`
            ] },
          { h: 'Depois de preposição: sempre -ing',
            items: [
              `${EN("I'm interested in learning Spanish.")} · ${EN("She's good at cooking.")}`,
              `${EN('Thanks for helping me.')} · ${EN("I'm thinking about moving.")}`,
              `Atenção: ${EN('look forward to')} termina em preposição, então: ${EN("I'm looking forward to seeing you.")} (Estou ansioso para te ver.) — nunca "to see".`
            ] },
          { h: 'Os que aceitam os dois',
            p: `${EN('like')}, ${EN('love')}, ${EN('hate')}, ${EN('start')}, ${EN('begin')} aceitam as duas formas quase sem mudança: ${EN('I like swimming')} = ${EN('I like to swim')} · ${EN('It started raining')} = ${EN('It started to rain')}. Mas ${EN('stop')} muda o sentido: ${EN('I stopped smoking')} (parei de fumar) × ${EN('I stopped to smoke')} (parei para fumar).` }
        ],
        pratica: [
          { t: 'lacuna', frase: 'I enjoy ___.', op: ['cooking', 'to cook', 'cook'], a: 0, pt: 'Eu gosto de cozinhar.' },
          { t: 'lacuna', frase: 'I want ___ to Japan.', op: ['to travel', 'traveling', 'travel'], a: 0, pt: 'Eu quero viajar para o Japão.' },
          { t: 'lacuna', frase: 'Would you mind ___ the window?', op: ['closing', 'to close', 'close'], a: 0, pt: 'Você se importaria de fechar a janela?' },
          { t: 'lacuna', frase: "I'm looking forward to ___ you.", op: ['seeing', 'see', 'saw'], a: 0, pt: 'Estou ansioso para te ver.', exp: 'look forward to termina em preposição (to), então o verbo depois vai para -ing.' },
          { t: 'lacuna', frase: 'She decided ___ her job.', op: ['to quit', 'quitting', 'quit'], a: 0, pt: 'Ela decidiu largar o emprego.' },
          { t: 'escolha', q: `O que significa ${EN('I stopped smoking.')}`, op: ['Parei de fumar.', 'Parei para fumar.', 'Comecei a fumar.'], a: 0, opPt: true },
          { t: 'pares', pares: [['enjoy', '+ -ing'], ['want', '+ to'], ['finish', '+ -ing'], ['decide', '+ to'], ['avoid', '+ -ing']] },
          { t: 'montar', pt: 'Ela é boa em cozinhar.', en: "She's good at cooking", extra: ['to', 'cook'] },
          { t: 'montar', pt: 'Obrigado por me ajudar.', en: 'Thanks for helping me', extra: ['to', 'help'] },
          { t: 'escolha', ouvir: 'I miss living by the beach.', op: ['Sinto falta de morar na praia.', 'Perdi minha casa na praia.', 'Quero morar na praia.'], a: 0, opPt: true },
          { t: 'digitar', pt: 'Eu gostaria de pedir.', en: "I'd like to order", alt: ['I would like to order'] },
          { t: 'falar', en: "I'm looking forward to seeing you." },
          { t: 'falar', en: 'I enjoy learning English.' }
        ]
      },
      {
        id: 'en-phrasal-conversa', title: 'Phrasal verbs da conversa: get along, hang out, show up',
        desc: 'Os phrasal verbs das relações e da vida social, os que aparecem em séries e conversas entre amigos.',
        objetivos: [
          'Usar get along with, hang out, show up e turn down',
          'Usar put off, come up with e work out',
          'Reconhecer phrasal verbs em conversas rápidas'
        ],
        body: 'Fechando o módulo, os phrasal verbs que aparecem nas conversas entre amigos e em toda série americana. Eles são o que faz a fala de um nativo parecer "rápida demais" — quando você conhece os mais comuns, a série fica bem mais fácil.',
        content: [
          { h: 'Relações',
            items: [
              `${EN('get along with')} = se dar bem com: ${EN('I get along with my boss.')}`,
              `${EN('hang out')} = passar tempo junto, sair: ${EN('We hung out at the mall.')} · ${EN("Let's hang out this weekend.")}`,
              `${EN('break up')} = terminar (namoro): ${EN('They broke up last month.')}`,
              `${EN('make up')} = fazer as pazes: ${EN('They had a fight, but they made up.')}`
            ] },
          { h: 'Compromissos',
            items: [
              `${EN('show up')} = aparecer, comparecer: ${EN("He didn't show up to the meeting.")}`,
              `${EN('put off')} = adiar: ${EN("Don't put it off until tomorrow.")}`,
              `${EN('turn down')} = recusar (convite, oferta): ${EN('She turned down the job offer.')}`,
              `${EN('call off')} = cancelar: ${EN('They called off the party.')}`
            ] },
          { h: 'Ideias e resultados',
            items: [
              `${EN('come up with')} = ter (uma ideia), bolar: ${EN('She came up with a great idea.')}`,
              `${EN('work out')} = dar certo / malhar: ${EN('Everything worked out in the end.')} · ${EN('I work out three times a week.')}`,
              `${EN('end up')} = acabar (fazendo algo): ${EN('We ended up staying home.')}`
            ] },
          { h: 'Revisão do módulo',
            p: `Rotina: ${EN('wake up')}, ${EN('turn off')}, ${EN('pick up')}. Trabalho: ${EN('figure out')}, ${EN('run out of')}, ${EN('call back')}, ${EN('follow up')}. Conversa: ${EN('hang out')}, ${EN('show up')}, ${EN('put off')}, ${EN('come up with')}. E a regra: ${EN('enjoy doing')}, ${EN('want to do')}, preposição + -ing.` }
        ],
        pratica: [
          { t: 'pares', pares: [['get along with', 'se dar bem com'], ['hang out', 'sair, passar tempo junto'], ['show up', 'aparecer'], ['put off', 'adiar'], ['turn down', 'recusar']] },
          { t: 'pares', pares: [['break up', 'terminar namoro'], ['make up', 'fazer as pazes'], ['call off', 'cancelar'], ['come up with', 'ter uma ideia'], ['end up', 'acabar fazendo']] },
          { t: 'lacuna', frase: "He didn't show ___ to the meeting.", op: ['up', 'off', 'out'], a: 0, pt: 'Ele não apareceu na reunião.' },
          { t: 'lacuna', frase: 'She turned ___ the job offer.', op: ['down', 'off', 'up'], a: 0, pt: 'Ela recusou a oferta de emprego.' },
          { t: 'lacuna', frase: 'I get along ___ my boss.', op: ['with', 'to', 'for'], a: 0, pt: 'Eu me dou bem com meu chefe.' },
          { t: 'escolha', q: `${EN('Everything worked out in the end.')} significa:`, op: ['No fim, deu tudo certo.', 'No fim, todo mundo malhou.', 'No fim, tudo acabou.'], a: 0, opPt: true },
          { t: 'escolha', q: `O que significa ${EN('put off')}?`, op: ['adiar', 'desligar', 'colocar fora'], a: 0, opPt: true },
          { t: 'montar', pt: 'Ela teve uma ótima ideia.', en: 'She came up with a great idea', extra: ['had', 'on'] },
          { t: 'montar', pt: 'A gente acabou ficando em casa.', en: 'We ended up staying home', extra: ['stay', 'finished'] },
          { t: 'escolha', ouvir: "Let's hang out this weekend.", op: ['Vamos sair neste fim de semana.', 'Vamos pendurar isso no fim de semana.', 'Vamos esperar o fim de semana.'], a: 0, opPt: true },
          { t: 'digitar', ouvir: 'They called off the party.', en: 'They called off the party', alt: ['They called the party off'] },
          { t: 'falar', en: "Don't put it off until tomorrow." },
          { t: 'falar', en: 'I get along with my boss.' }
        ]
      }
    ]
  }
  ,
  {
    id: 'en-m12', title: 'Módulo 12 · Inglês no trabalho: e-mails, reuniões, ligações e small talk (B1)', kind: 'video',
    lessons: [
      {
        id: 'en-emails', title: 'E-mails profissionais',
        desc: 'A estrutura de um e-mail em inglês, do cumprimento à despedida, com as frases prontas para pedir, anexar, cobrar e agradecer.',
        objetivos: [
          'Abrir e fechar e-mails no tom certo: Hi, Dear, Best regards',
          'Usar frases prontas para o motivo do e-mail, pedidos e anexos',
          'Cobrar uma resposta com educação (follow up)'
        ],
        body: 'Boa parte do inglês no trabalho é escrito. A vantagem: e-mail profissional em inglês é muito padronizado. Com uma dúzia de frases prontas você escreve quase qualquer mensagem com o tom certo — nem frio demais, nem informal demais.',
        content: [
          { h: 'Abertura',
            items: [
              `${EN('Hi Sarah,')} — padrão na maioria das empresas, inclusive com clientes.`,
              `${EN('Dear Mr. Smith,')} — formal, para primeiro contato ou instituições. ${EN('Dear Sir or Madam,')} quando não sabe o nome.`,
              `Primeira frase: ${EN("I hope you're doing well.")} / ${EN('I hope this email finds you well.')}`
            ] },
          { h: 'Motivo e pedidos',
            items: [
              `${EN("I'm writing to ask about...")} · ${EN("I'm writing regarding...")} (Escrevo a respeito de...)`,
              `${EN('Could you please send me the report?')} · ${EN('Would it be possible to meet on Friday?')}`,
              `${EN('Please find attached the proposal.')} / ${EN("I've attached the proposal.")} (Segue em anexo a proposta.)`,
              `${EN('Please let me know if you have any questions.')} (Fico à disposição para dúvidas.)`
            ] },
          { h: 'Cobrando e respondendo',
            items: [
              `${EN("I'm following up on my previous email.")} · ${EN('Just a quick reminder about...')} (Só um lembrete sobre...)`,
              `${EN('Thank you for your quick reply.')} · ${EN('Sorry for the late reply.')} (Desculpe a demora.)`,
              `${EN('As discussed,')} (Conforme conversamos) · ${EN('As requested,')} (Conforme solicitado)`
            ] },
          { h: 'Despedida',
            items: [
              `${EN('Best regards,')} / ${EN('Kind regards,')} — o padrão seguro. ${EN('Best,')} — mais curto e comum entre colegas.`,
              `${EN('Thanks,')} / ${EN('Thanks in advance,')} (Obrigado desde já) — quando o e-mail tem um pedido.`,
              `Evite traduzir "Att." ou "Abraços" ao pé da letra: não existem em inglês nesse uso.`
            ] }
        ],
        pratica: [
          { t: 'escolha', q: 'Qual é a abertura mais comum num e-mail para um colega?', op: ['Hi Sarah,', 'Dear Sarah, how are you, all good?', 'Hello dear friend Sarah,'], a: 0 },
          { t: 'escolha', q: 'Como dizer "Segue em anexo a proposta"?', op: ['Please find attached the proposal.', 'Follows attached the proposal.', 'The proposal is following in the attach.'], a: 0, exp: 'Frase pronta: Please find attached... ou I\'ve attached...' },
          { t: 'escolha', q: 'Qual é a despedida padrão e segura?', op: ['Best regards,', 'Att.,', 'Hugs,'], a: 0 },
          { t: 'lacuna', frase: "I'm writing ___ ask about the invoice.", op: ['to', 'for', 'about'], a: 0, pt: 'Estou escrevendo para perguntar sobre a fatura.' },
          { t: 'lacuna', frase: "I'm following ___ on my previous email.", op: ['up', 'out', 'on'], a: 0, pt: 'Estou dando seguimento ao meu e-mail anterior.' },
          { t: 'pares', pares: [['As discussed', 'Conforme conversamos'], ['As requested', 'Conforme solicitado'], ['Thanks in advance', 'Obrigado desde já'], ['Sorry for the late reply', 'Desculpe a demora'], ['Just a quick reminder', 'Só um lembrete']] },
          { t: 'montar', pt: 'Fico à disposição para dúvidas.', en: 'Please let me know if you have any questions', extra: ['disposition', 'doubts'] },
          { t: 'montar', pt: 'Seria possível nos reunirmos na sexta?', en: 'Would it be possible to meet on Friday?', extra: ['Is', 'in'] },
          { t: 'escolha', ouvir: 'I hope this email finds you well.', op: ['Espero que você esteja bem.', 'Espero que você encontre este e-mail.', 'Espero sua resposta.'], a: 0, opPt: true },
          { t: 'digitar', pt: 'Você poderia me enviar o relatório?', en: 'Could you please send me the report?', alt: ['Could you send me the report?', 'Could you please send me the report'] },
          { t: 'digitar', ouvir: 'Thank you for your quick reply.', en: 'Thank you for your quick reply' },
          { t: 'falar', en: "I'm writing regarding the meeting on Friday." },
          { t: 'falar', en: 'Please let me know if you have any questions.' }
        ]
      },
      {
        id: 'en-reunioes', title: 'Reuniões online',
        desc: 'As frases de toda reunião por vídeo: problemas de áudio, começar e conduzir a pauta, opinar, concordar, discordar com educação e encerrar.',
        objetivos: [
          'Resolver os problemas técnicos clássicos: you\'re on mute, can you hear me?',
          'Abrir, conduzir e encerrar uma reunião',
          'Dar opinião, concordar e discordar com educação'
        ],
        body: 'Reunião online em inglês dá medo em muita gente — mas a maior parte do que se fala é previsível. Se você domina as frases de abertura, de opinião e de encerramento, sobra energia para o que importa: o assunto da reunião.',
        content: [
          { h: 'Problemas técnicos',
            items: [
              `${EN('Can you hear me?')} · ${EN('Can you see my screen?')}`,
              `${EN("You're on mute.")} (Você está no mudo.) · ${EN("Sorry, I was on mute.")}`,
              `${EN('Your connection is breaking up.')} (Sua conexão está falhando.) · ${EN("You froze.")} (Você travou.)`,
              `${EN("I'll share my screen.")} (Vou compartilhar a tela.)`
            ] },
          { h: 'Começar e conduzir',
            items: [
              `${EN("Let's get started.")} (Vamos começar.) · ${EN('Thanks for joining.')}`,
              `${EN("The purpose of today's meeting is...")} · ${EN("Let's move on to the next point.")} (Vamos para o próximo ponto.)`,
              `${EN('Could you repeat that, please?')} · ${EN('Sorry, could you say that again?')}`
            ] },
          { h: 'Opinar, concordar, discordar',
            items: [
              `Opinar: ${EN('I think...')} · ${EN('In my opinion,...')} · ${EN('From my point of view,...')}`,
              `Concordar: ${EN('I agree.')} · ${EN('Exactly.')} · ${EN('That makes sense.')} (Faz sentido.) — atenção: é ${EN('I agree')}, nunca "I am agree".`,
              `Discordar com educação: ${EN('I see your point, but...')} · ${EN("I'm not sure about that.")} · ${EN('I see it a bit differently.')}`
            ] },
          { h: 'Encerrar',
            p: `${EN("Let's wrap up.")} (Vamos encerrar.) · ${EN("So, the next steps are...")} (Os próximos passos são...) · ${EN("I'll send a summary by email.")} · ${EN('Thanks, everyone!')}` }
        ],
        pratica: [
          { t: 'escolha', q: 'Seu colega está falando, mas ninguém ouve. O que dizer?', op: ["You're on mute.", 'You are in silence.', 'You are muted off.'], a: 0 },
          { t: 'escolha', q: 'Qual frase está correta?', op: ['I agree.', 'I am agree.', 'I agreed with.'], a: 0, exp: 'agree já é verbo: I agree. "I am agree" é um erro clássico de brasileiro.' },
          { t: 'escolha', q: 'Qual é a forma mais educada de discordar?', op: ['I see your point, but...', "You're wrong.", 'No, this is bad.'], a: 0 },
          { t: 'lacuna', frase: "Let's move ___ to the next point.", op: ['on', 'up', 'out'], a: 0, pt: 'Vamos para o próximo ponto.' },
          { t: 'lacuna', frase: "Let's wrap ___.", op: ['up', 'off', 'on'], a: 0, pt: 'Vamos encerrar.' },
          { t: 'pares', pares: [["Let's get started.", 'Vamos começar.'], ['That makes sense.', 'Faz sentido.'], ['next steps', 'próximos passos'], ['share my screen', 'compartilhar a tela'], ['You froze.', 'Você travou.']] },
          { t: 'montar', pt: 'Vocês conseguem ver a minha tela?', en: 'Can you see my screen?', extra: ['watch', 'look'] },
          { t: 'montar', pt: 'Na minha opinião, devemos esperar.', en: 'In my opinion we should wait', extra: ['On', 'must'] },
          { t: 'escolha', ouvir: 'Your connection is breaking up.', op: ['Sua conexão está falhando.', 'Sua conexão caiu de vez.', 'Você está desconectando a reunião.'], a: 0, opPt: true },
          { t: 'digitar', pt: 'Você pode repetir, por favor?', en: 'Could you repeat that, please?', alt: ['Could you repeat that please', 'Can you repeat that, please?', 'Could you repeat that, please'] },
          { t: 'digitar', ouvir: "I'll send a summary by email.", en: "I'll send a summary by email", alt: ['I will send a summary by email'] },
          { t: 'falar', en: "Sorry, I was on mute." },
          { t: 'falar', en: 'I see your point, but I see it a bit differently.' }
        ]
      },
      {
        id: 'en-telefone', title: 'Ligações e mensagens',
        desc: 'Atender, se apresentar, pedir para falar com alguém, deixar recado, soletrar e marcar retorno — as frases do telefone.',
        objetivos: [
          'Atender e se apresentar ao telefone com This is...',
          'Pedir para falar com alguém, pedir para esperar e deixar recado',
          'Soletrar nomes e e-mails e confirmar informações'
        ],
        body: 'Telefone é o maior teste de quem aprende inglês: não dá para ler lábios nem ver gestos. Por isso vale ter as frases na ponta da língua — e saber pedir para repetir e soletrar sem constrangimento.',
        content: [
          { h: 'Atendendo e se apresentando',
            items: [
              `Ao telefone, ${EN('This is...')} (e não "I am"): ${EN('Hi, this is Ana from Tech Santos.')}`,
              `Atendendo no trabalho: ${EN('Good morning, Tech Santos, Ana speaking.')} (Ana falando.)`,
              `${EN('May I speak to Mr. Brown, please?')} / ${EN('Could I speak to Mr. Brown?')}`
            ] },
          { h: 'Esperar e transferir',
            items: [
              `${EN('Hold on, please.')} / ${EN('One moment, please.')} (Aguarde um momento.)`,
              `${EN("I'll put you through.")} (Vou transferir.) · ${EN("He's not available right now.")} · ${EN("She's in a meeting.")}`,
              `${EN("Who's calling, please?")} (Quem gostaria?)`
            ] },
          { h: 'Recados',
            items: [
              `${EN('Can I leave a message?')} (Posso deixar recado?) · ${EN('Can I take a message?')} (Quer deixar recado?)`,
              `${EN('Could you ask him to call me back?')} · ${EN('My number is...')}`,
              `${EN("I'll let him know.")} (Vou avisá-lo.)`
            ] },
          { h: 'Soletrar e confirmar',
            items: [
              `${EN('Could you spell that, please?')} — as letras que mais confundem: E (í), I (ái), A (êi), G (dí), J (djêi), R (ár), Y (uái).`,
              `E-mail: ${EN('at')} (@), ${EN('dot')} (.), ${EN('dash')} (-), ${EN('underscore')} (_) — ${EN('ana dot silva at gmail dot com')}`,
              `${EN('Let me read that back to you.')} (Deixa eu confirmar.) · ${EN('Sorry, the line is bad.')} (A ligação está ruim.)`
            ] }
        ],
        pratica: [
          { t: 'escolha', q: 'Ao telefone, como dizer "Oi, aqui é a Ana"?', op: ['Hi, this is Ana.', "Hi, I'm Ana speaking here.", 'Hi, here is Ana.'], a: 0 },
          { t: 'escolha', q: 'Como pedir para a pessoa aguardar?', op: ['Hold on, please.', 'Wait me, please.', 'Stay in the line.'], a: 0 },
          { t: 'escolha', q: `O que significa ${EN("I'll put you through.")}`, op: ['Vou transferir a ligação.', 'Vou desligar.', 'Vou colocar no viva-voz.'], a: 0, opPt: true },
          { t: 'lacuna', frase: 'Can I ___ a message?', op: ['leave', 'let', 'give'], a: 0, pt: 'Posso deixar um recado?' },
          { t: 'lacuna', frase: 'Could you ask him to call me ___?', op: ['back', 'again', 'return'], a: 0, pt: 'Você pode pedir para ele me retornar?' },
          { t: 'pares', pares: [['at', '@ (arroba)'], ['dot', '. (ponto)'], ['dash', '- (hífen)'], ['underscore', '_ (sublinhado)'], ["Who's calling?", 'Quem gostaria?']] },
          { t: 'montar', pt: 'Posso falar com o Sr. Brown, por favor?', en: 'May I speak to Mr Brown please?', extra: ['talk', 'with'] },
          { t: 'montar', pt: 'Ela está em reunião.', en: "She's in a meeting", extra: ['on', 'meeting'] },
          { t: 'escolha', ouvir: 'Could you spell that, please?', op: ['Pode soletrar, por favor?', 'Pode repetir mais alto?', 'Pode falar mais devagar?'], a: 0, opPt: true },
          { t: 'escolha', ouvir: 'ana dot silva at gmail dot com', op: ['ana.silva@gmail.com', 'ana-silva@gmail.com', 'ana_silva@gmail.com'], a: 0 },
          { t: 'digitar', pt: 'Vou avisá-lo.', en: "I'll let him know", alt: ['I will let him know'] },
          { t: 'falar', en: 'Hi, this is Ana from Tech Santos.' },
          { t: 'falar', en: 'Could you ask him to call me back?' }
        ]
      },
      {
        id: 'en-small-talk', title: 'Small talk e cortesia',
        desc: 'A conversa leve antes e depois das reuniões — e as frases que deixam qualquer pedido mais educado em inglês.',
        objetivos: [
          'Puxar e manter small talk: fim de semana, tempo, viagem',
          'Suavizar pedidos com I was wondering if... e Would you mind...',
          'Agradecer, se desculpar e encerrar a conversa com educação'
        ],
        body: 'Nos países de língua inglesa, os primeiros minutos de toda reunião são de conversa leve — o small talk. E os pedidos são sempre "suavizados": quem fala direto demais parece grosso, mesmo sem querer. Esta aula fecha o módulo com essas duas habilidades.',
        content: [
          { h: 'Puxando assunto',
            items: [
              `${EN("How's it going?")} · ${EN('How was your weekend?')} · ${EN('Did you do anything fun?')}`,
              `O tempo é o assunto clássico: ${EN("Nice weather today, isn't it?")} · ${EN("It's freezing out there!")}`,
              `${EN('How was your trip?')} · ${EN('Are you busy these days?')}`,
              `Mantenha a conversa devolvendo a pergunta: ${EN('What about you?')} · ${EN('How about you?')}`
            ] },
          { h: 'Suavizando pedidos',
            items: [
              `Direto demais: "Send me the file." → educado: ${EN('Could you send me the file, please?')}`,
              `Ainda mais suave: ${EN('I was wondering if you could send me the file.')} (Será que você poderia...)`,
              `${EN('Would you mind sending me the file?')} · ${EN("Do you think you could...?")}`,
              `Para recusar: ${EN("I'm afraid I can't.")} (Infelizmente não posso.) — ${EN("I'm afraid")} suaviza notícias ruins.`
            ] },
          { h: 'Agradecer e se desculpar',
            items: [
              `${EN('Thanks a lot.')} · ${EN('I really appreciate it.')} (Agradeço muito.)`,
              `Resposta: ${EN("You're welcome.")} · ${EN('No problem.')} · ${EN('Anytime!')}`,
              `${EN('Sorry for the delay.')} · ${EN('My apologies.')} (mais formal)`
            ] },
          { h: 'Encerrando a conversa',
            p: `${EN('Anyway, I should get back to work.')} (Bom, preciso voltar ao trabalho.) · ${EN('It was nice talking to you.')} · ${EN('Talk to you later!')} · ${EN('Have a good one!')} (Bom dia / boa tarde, informal)` }
        ],
        pratica: [
          { t: 'escolha', q: 'Qual é o pedido mais educado?', op: ['I was wondering if you could send me the file.', 'Send me the file.', 'You send me the file now.'], a: 0 },
          { t: 'escolha', q: `O que significa ${EN("I'm afraid I can't.")}`, op: ['Infelizmente não posso.', 'Tenho medo de não conseguir.', 'Estou com medo.'], a: 0, opPt: true, exp: `I'm afraid aqui não é medo: suaviza uma notícia ruim (infelizmente).` },
          { t: 'escolha', q: `Responda a ${EN('I really appreciate it.')}`, op: ["You're welcome.", "You're welcome too.", 'Of nothing.'], a: 0 },
          { t: 'lacuna', frase: "Nice weather today, ___ it?", op: ["isn't", "is", "doesn't"], a: 0, pt: 'O tempo está bom hoje, né?' },
          { t: 'lacuna', frase: 'Would you mind ___ me the file?', op: ['sending', 'to send', 'send'], a: 0, pt: 'Você se importaria de me mandar o arquivo?' },
          { t: 'pares', pares: [["How's it going?", 'Como vão as coisas?'], ['I really appreciate it.', 'Agradeço muito.'], ['Anytime!', 'Quando precisar!'], ['My apologies.', 'Minhas desculpas.'], ['Have a good one!', 'Tenha um bom dia!']] },
          { t: 'montar', pt: 'Foi bom conversar com você.', en: 'It was nice talking to you', extra: ['talk', 'with'] },
          { t: 'montar', pt: 'Bom, preciso voltar ao trabalho.', en: 'Anyway I should get back to work', extra: ['need', 'return'] },
          { t: 'escolha', ouvir: 'Did you do anything fun?', op: ['Você fez alguma coisa divertida?', 'Você se divertiu muito?', 'Você fez alguma coisa ontem?'], a: 0, opPt: true },
          { t: 'digitar', pt: 'Como foi a sua viagem?', en: 'How was your trip?', alt: ['How was your trip'] },
          { t: 'digitar', ouvir: 'Talk to you later!', en: 'Talk to you later' },
          { t: 'falar', en: 'I was wondering if you could help me.' },
          { t: 'falar', en: 'It was nice talking to you.' }
        ]
      }
    ]
  }
  ,
  {
    id: 'en-m13', title: 'Módulo 13 · Estruturas do B2: voz passiva, discurso indireto, orações relativas, third conditional e wish', kind: 'video',
    lessons: [
      {
        id: 'en-voz-passiva', title: 'Voz passiva: It was built in 1990',
        desc: 'Quando o foco é a ação ou o resultado, e não quem fez: to be + particípio, em todos os tempos, e quando usar by.',
        objetivos: [
          'Formar a voz passiva com to be + particípio',
          'Usar a passiva no presente, passado, present perfect e futuro',
          'Decidir quando mencionar o agente com by'
        ],
        body: 'Começa o nível B2. A voz passiva aparece em notícias, relatórios, manuais e e-mails formais — sempre que o importante é o que aconteceu, e não quem fez. "O relatório foi enviado", "o produto é fabricado na China". A boa notícia: a estrutura é a mesma do português.',
        content: [
          { h: 'A forma: to be + particípio',
            items: [
              `Ativa: ${EN('Someone cleans the office every day.')} → Passiva: ${EN('The office is cleaned every day.')}`,
              `O verbo to be carrega o tempo; o particípio fica sempre igual: ${EN('is made')}, ${EN('was made')}, ${EN('has been made')}, ${EN('will be made')}.`,
              `${EN('English is spoken all over the world.')} (O inglês é falado no mundo todo.)`
            ] },
          { h: 'Nos tempos mais comuns',
            items: [
              `Presente: ${EN('These phones are made in China.')}`,
              `Passado: ${EN('The bridge was built in 1990.')} · ${EN('I was born in Brazil.')} — lembra? É passiva!`,
              `Present perfect: ${EN('The report has been sent.')} (O relatório foi enviado.)`,
              `Futuro: ${EN('The results will be announced tomorrow.')} · com modais: ${EN('It must be done today.')} · ${EN('It can be fixed.')}`
            ] },
          { h: 'By: só quando importa',
            items: [
              `${EN('The book was written by Machado de Assis.')} — o autor é informação relevante.`,
              `${EN('My car was stolen.')} — não se sabe quem, então sem ${EN('by')}.`,
              `Na maioria das passivas o agente não aparece: ou é óbvio, ou desconhecido, ou não importa.`
            ] },
          { h: 'Quando usar',
            p: `Notícias (${EN('Three people were injured.')}), processos (${EN('The data is collected and analyzed.')}), avisos (${EN('Smoking is not allowed.')}) e e-mails formais, para soar menos pessoal: ${EN('A mistake was made.')} em vez de "You made a mistake".` }
        ],
        pratica: [
          { t: 'lacuna', frase: 'These phones ___ made in China.', op: ['are', 'is', 'were be'], a: 0, pt: 'Estes celulares são fabricados na China.' },
          { t: 'lacuna', frase: 'The bridge ___ built in 1990.', op: ['was', 'is', 'has'], a: 0, pt: 'A ponte foi construída em 1990.' },
          { t: 'lacuna', frase: 'The report has ___ sent.', op: ['been', 'be', 'was'], a: 0, pt: 'O relatório foi enviado.' },
          { t: 'lacuna', frase: 'The results will ___ announced tomorrow.', op: ['be', 'been', 'are'], a: 0, pt: 'Os resultados serão anunciados amanhã.' },
          { t: 'escolha', q: 'Qual é a voz passiva de "They speak English here"?', op: ['English is spoken here.', 'English speaks here.', 'English is speaking here.'], a: 0 },
          { t: 'escolha', q: 'Em qual frase o "by" é necessário?', op: ['The book was written by Machado de Assis.', 'My car was stolen by someone.', 'The office is cleaned by people.'], a: 0, exp: 'Use by só quando o agente é informação relevante. "by someone" e "by people" não acrescentam nada.' },
          { t: 'pares', pares: [['is made', 'presente'], ['was made', 'passado'], ['has been made', 'present perfect'], ['will be made', 'futuro'], ['can be made', 'com modal']] },
          { t: 'montar', pt: 'O inglês é falado no mundo todo.', en: 'English is spoken all over the world', extra: ['speaks', 'by'] },
          { t: 'montar', pt: 'Meu carro foi roubado.', en: 'My car was stolen', extra: ['stole', 'by'] },
          { t: 'escolha', ouvir: 'Smoking is not allowed.', op: ['É proibido fumar.', 'Fumar não é saudável.', 'Não é permitido fumar ainda.'], a: 0, opPt: true },
          { t: 'digitar', pt: 'Isso precisa ser feito hoje.', en: 'It must be done today', alt: ['It has to be done today', 'This must be done today', 'It needs to be done today'] },
          { t: 'falar', en: 'The report has been sent.' },
          { t: 'falar', en: 'The bridge was built in 1990.' }
        ]
      },
      {
        id: 'en-reported-speech', title: 'Reported speech: ele disse que...',
        desc: 'Como contar o que outra pessoa disse: said × told, o recuo dos tempos verbais e perguntas indiretas.',
        objetivos: [
          'Contar o que alguém disse com said e told',
          'Fazer o recuo dos tempos verbais (is → was, will → would)',
          'Relatar perguntas e pedidos: She asked if..., He told me to...'
        ],
        body: '"Ela disse que estava cansada." Contar o que os outros disseram é uma das coisas que mais fazemos numa conversa. Em inglês, assim como em português, o verbo costuma "voltar um passo" no tempo — e há uma diferença importante entre say e tell.',
        content: [
          { h: 'Said × told',
            items: [
              `${EN('say')} sem pessoa: ${EN('She said that she was tired.')}`,
              `${EN('tell')} com pessoa: ${EN('She told me that she was tired.')} — nunca "she said me".`,
              `O ${EN('that')} é opcional: ${EN('She said she was tired.')}`
            ] },
          { h: 'O recuo dos tempos',
            items: [
              `${EN('"I am tired."')} → ${EN('She said she was tired.')}`,
              `${EN('"I work here."')} → ${EN('He said he worked there.')}`,
              `${EN('"I will call you."')} → ${EN('He said he would call me.')}`,
              `${EN('"I can help."')} → ${EN('She said she could help.')} · ${EN('"I have finished."')} → ${EN('He said he had finished.')}`,
              `Também mudam pronomes e lugares: ${EN('here')} → ${EN('there')}, ${EN('today')} → ${EN('that day')}, ${EN('tomorrow')} → ${EN('the next day')}.`
            ] },
          { h: 'Perguntas indiretas',
            items: [
              `Sim/não: ${EN('"Are you ready?"')} → ${EN('She asked if I was ready.')}`,
              `Com palavra interrogativa: ${EN('"Where do you live?"')} → ${EN('He asked where I lived.')}`,
              `Na pergunta relatada, a ordem volta a ser de afirmação: ${EN('where I lived')} — nunca "where did I live".`
            ] },
          { h: 'Pedidos e ordens',
            p: `${EN('tell')} / ${EN('ask')} + pessoa + ${EN('to')} + verbo: ${EN('"Please call me."')} → ${EN('She asked me to call her.')} · ${EN('"Don\'t be late."')} → ${EN('He told me not to be late.')}` }
        ],
        pratica: [
          { t: 'lacuna', frase: 'She ___ me that she was tired.', op: ['told', 'said', 'spoke'], a: 0, pt: 'Ela me disse que estava cansada.', exp: 'Com a pessoa logo depois (me), use tell/told. Say não leva pessoa direto.' },
          { t: 'lacuna', frase: 'He ___ he would call me.', op: ['said', 'told', 'asked'], a: 0, pt: 'Ele disse que me ligaria.' },
          { t: 'lacuna', frase: '"I am tired." → She said she ___ tired.', op: ['was', 'is', 'were'], a: 0, pt: 'Ela disse que estava cansada.' },
          { t: 'lacuna', frase: '"I will help." → He said he ___ help.', op: ['would', 'will', 'can'], a: 0, pt: 'Ele disse que ajudaria.' },
          { t: 'escolha', q: '"Where do you live?" → Como relatar?', op: ['He asked where I lived.', 'He asked where did I live.', 'He asked where do I live.'], a: 0, exp: 'Na pergunta indireta, a ordem é de afirmação e sem do/did.' },
          { t: 'escolha', q: '"Are you ready?" → Como relatar?', op: ['She asked if I was ready.', 'She asked was I ready.', 'She said if I am ready.'], a: 0 },
          { t: 'escolha', q: '"Don\'t be late." → Como relatar?', op: ['He told me not to be late.', "He told me don't be late.", 'He said me not be late.'], a: 0 },
          { t: 'pares', pares: [['am / is', 'was'], ['will', 'would'], ['can', 'could'], ['today', 'that day'], ['tomorrow', 'the next day']] },
          { t: 'montar', pt: 'Ela me pediu para ligar para ela.', en: 'She asked me to call her', extra: ['said', 'calling'] },
          { t: 'escolha', ouvir: 'He said he had finished the report.', op: ['Ele disse que tinha terminado o relatório.', 'Ele disse que vai terminar o relatório.', 'Ele perguntou se o relatório acabou.'], a: 0, opPt: true },
          { t: 'digitar', pt: 'Ele disse que estava ocupado.', en: 'He said he was busy', alt: ['He said that he was busy'] },
          { t: 'falar', en: 'She told me she was tired.' },
          { t: 'falar', en: 'He asked where I lived.' }
        ]
      },
      {
        id: 'en-relativas', title: 'Orações relativas: who, which, that, where, whose',
        desc: 'Como juntar duas frases com as palavras que equivalem ao nosso "que", "onde" e "cujo".',
        objetivos: [
          'Usar who para pessoas e which para coisas, e that para os dois',
          'Usar where para lugares e whose para posse',
          'Saber quando o pronome relativo pode ser omitido'
        ],
        body: '"A mulher que trabalha comigo", "o livro que eu comprei", "a cidade onde eu nasci". Em português, quase tudo é "que". Em inglês, a palavra muda conforme o que você está descrevendo — e às vezes ela simplesmente desaparece.',
        content: [
          { h: 'Who, which, that',
            items: [
              `${EN('who')} para pessoas: ${EN('The woman who works with me is from Canada.')}`,
              `${EN('which')} para coisas e animais: ${EN('The book which I bought is great.')}`,
              `${EN('that')} serve para os dois, e é o mais comum na fala: ${EN('The man that called you')} · ${EN('the car that I want')}`
            ] },
          { h: 'Where e whose',
            items: [
              `${EN('where')} para lugares: ${EN('This is the city where I was born.')}`,
              `${EN('whose')} = cujo, de quem: ${EN("That's the guy whose car was stolen.")} (Aquele é o cara cujo carro foi roubado.)`
            ] },
          { h: 'Quando o pronome some',
            items: [
              `Se o pronome é o <strong>objeto</strong> (vem outro sujeito depois), dá para omitir: ${EN('The book (that) I bought')} · ${EN('The people (who) I met')}`,
              `Se é o <strong>sujeito</strong> (vem verbo logo depois), não dá: ${EN('The woman who works with me')} — o ${EN('who')} é obrigatório.`,
              `Por isso nativos dizem tanto ${EN('the movie we saw')} e ${EN('the guy I told you about')}.`
            ] },
          { h: 'Com vírgula: informação extra',
            p: `Entre vírgulas, a oração só acrescenta informação, e aí não se usa ${EN('that')}: ${EN('My brother, who lives in London, is a doctor.')} · ${EN('Rio, which is famous for its beaches, is my favorite city.')}` }
        ],
        pratica: [
          { t: 'lacuna', frase: 'The woman ___ works with me is from Canada.', op: ['who', 'which', 'where'], a: 0, pt: 'A mulher que trabalha comigo é do Canadá.' },
          { t: 'lacuna', frase: 'The book ___ I bought is great.', op: ['which', 'who', 'where'], a: 0, pt: 'O livro que eu comprei é ótimo.' },
          { t: 'lacuna', frase: 'This is the city ___ I was born.', op: ['where', 'which', 'who'], a: 0, pt: 'Esta é a cidade onde eu nasci.' },
          { t: 'lacuna', frase: "That's the guy ___ car was stolen.", op: ['whose', 'who', "who's"], a: 0, pt: 'Aquele é o cara cujo carro foi roubado.' },
          { t: 'escolha', q: 'Em qual frase o pronome relativo pode ser omitido?', op: ['The movie that we saw was great.', 'The woman who works here is nice.', 'The dog that bit me ran away.'], a: 0, exp: 'Só quando ele é objeto (vem outro sujeito depois: we saw).' },
          { t: 'escolha', q: 'Qual frase está correta?', op: ['My brother, who lives in London, is a doctor.', 'My brother, that lives in London, is a doctor.', 'My brother, which lives in London, is a doctor.'], a: 0, exp: 'Entre vírgulas não se usa that; para pessoa, who.' },
          { t: 'pares', pares: [['who', 'pessoas'], ['which', 'coisas'], ['that', 'pessoas e coisas'], ['where', 'lugares'], ['whose', 'posse (cujo)']] },
          { t: 'montar', pt: 'O cara de quem eu te falei.', en: 'The guy I told you about', extra: ['who', 'which'] },
          { t: 'montar', pt: 'Esta é a casa onde eu moro.', en: 'This is the house where I live', extra: ['which', 'who'] },
          { t: 'escolha', ouvir: 'The people I met in Rio were amazing.', op: ['As pessoas que conheci no Rio eram incríveis.', 'Conheci pessoas incríveis no Rio.', 'As pessoas do Rio me conheceram.'], a: 0, opPt: true },
          { t: 'digitar', pt: 'O carro que eu quero é caro.', en: 'The car I want is expensive', alt: ['The car that I want is expensive', 'The car which I want is expensive'] },
          { t: 'falar', en: 'The woman who works with me is from Canada.' },
          { t: 'falar', en: 'This is the city where I was born.' }
        ]
      },
      {
        id: 'en-third-wish', title: 'Third conditional e wish: arrependimentos',
        desc: 'Como falar do passado que não aconteceu — If I had known, I would have... — e expressar desejos com wish.',
        objetivos: [
          'Usar o third conditional para hipóteses sobre o passado',
          'Usar wish + passado para desejos sobre o presente',
          'Usar wish + past perfect para arrependimentos'
        ],
        body: '"Se eu tivesse estudado, teria passado." O third conditional é a ferramenta dos arrependimentos e das histórias que podiam ter sido diferentes. E o wish completa: "quem me dera", "eu queria que...". Fechando o módulo, a gramática mais sofisticada do B2.',
        content: [
          { h: 'Third conditional',
            items: [
              `if + had + particípio, would have + particípio: ${EN('If I had studied, I would have passed.')} (Se eu tivesse estudado, teria passado.)`,
              `Fala de algo que <strong>não</strong> aconteceu: eu não estudei, então não passei.`,
              `${EN("If you had told me, I would have helped you.")} · contrações na fala: ${EN("If I'd known, I'd have come.")}`
            ] },
          { h: 'Os três condicionais lado a lado',
            items: [
              `First (possível): ${EN("If it rains, I'll stay home.")}`,
              `Second (imaginário, agora): ${EN("If I had money, I'd travel.")}`,
              `Third (passado que não aconteceu): ${EN("If I had saved money, I would have traveled.")}`
            ] },
          { h: 'Wish sobre o presente',
            items: [
              `${EN('wish')} + passado = desejo de que o presente fosse diferente: ${EN('I wish I had more time.')} (Queria ter mais tempo.)`,
              `${EN('I wish I spoke French.')} · ${EN('I wish I were taller.')} — mesma lógica do second conditional.`,
              `${EN('If only...')} é a versão mais emotiva: ${EN('If only I knew the answer!')}`
            ] },
          { h: 'Wish sobre o passado: arrependimento',
            p: `${EN('wish')} + had + particípio: ${EN("I wish I had studied more.")} (Queria ter estudado mais.) · ${EN("I wish I hadn't said that.")} (Queria não ter dito aquilo.) — a forma mais natural de expressar arrependimento em inglês.` }
        ],
        pratica: [
          { t: 'lacuna', frase: 'If I had studied, I would have ___.', op: ['passed', 'pass', 'passing'], a: 0, pt: 'Se eu tivesse estudado, teria passado.' },
          { t: 'lacuna', frase: 'If you ___ told me, I would have helped you.', op: ['had', 'have', 'would'], a: 0, pt: 'Se você tivesse me contado, eu teria te ajudado.' },
          { t: 'lacuna', frase: 'I wish I ___ more time.', op: ['had', 'have', 'will have'], a: 0, pt: 'Queria ter mais tempo.' },
          { t: 'lacuna', frase: "I wish I ___ said that.", op: ["hadn't", "didn't", "don't"], a: 0, pt: 'Queria não ter dito aquilo.', exp: 'Arrependimento sobre o passado: wish + had (not) + particípio.' },
          { t: 'escolha', q: 'Qual frase é um third conditional?', op: ['If I had saved money, I would have traveled.', "If I have money, I'll travel.", "If I had money, I'd travel."], a: 0 },
          { t: 'escolha', q: `${EN("If I'd known, I'd have come.")} significa:`, op: ['Se eu soubesse, teria vindo.', 'Se eu souber, eu venho.', 'Eu sabia e vim.'], a: 0, opPt: true },
          { t: 'pares', pares: [["If it rains, I'll stay.", 'possível'], ["If I had money, I'd travel.", 'imaginário (agora)'], ['If I had known, I would have come.', 'passado que não aconteceu'], ['I wish I had more time.', 'desejo (presente)'], ['I wish I had studied.', 'arrependimento']] },
          { t: 'montar', pt: 'Queria falar francês.', en: 'I wish I spoke French', extra: ['speak', 'will'] },
          { t: 'montar', pt: 'Queria ter estudado mais.', en: 'I wish I had studied more', extra: ['have', 'would'] },
          { t: 'escolha', ouvir: 'If you had called me, I would have picked you up.', op: ['Se você tivesse me ligado, eu teria te buscado.', 'Se você me ligar, eu te busco.', 'Você me ligou e eu te busquei.'], a: 0, opPt: true },
          { t: 'digitar', pt: 'Quem me dera eu soubesse a resposta!', en: 'If only I knew the answer!', alt: ['If only I knew the answer', 'I wish I knew the answer!', 'I wish I knew the answer'] },
          { t: 'falar', en: 'I wish I had studied more.' },
          { t: 'falar', en: "If I had known, I would have come." }
        ]
      }
    ]
  }
  ,
  {
    id: 'en-m14', title: 'Módulo 14 · Escuta e expressões: fala conectada, sotaques, idioms e falsos cognatos (B2)', kind: 'video',
    lessons: [
      {
        id: 'en-fala-conectada', title: 'Fala conectada: por que o nativo "come" as palavras',
        desc: 'Gonna, wanna, gotta, as ligações entre palavras e as sílabas fracas — o que faz o inglês real soar diferente do livro.',
        objetivos: [
          'Reconhecer as reduções gonna, wanna, gotta, kinda e lemme',
          'Entender como as palavras se ligam (linking) na fala',
          'Perceber as palavras fracas: to, of, and, can, for'
        ],
        body: 'Você entende o professor, mas a série parece outra língua? A culpa é da fala conectada. Nativos não falam palavra por palavra: eles juntam, encurtam e enfraquecem os sons. Esta aula não é para você falar assim — é para você entender quem fala.',
        content: [
          { h: 'As reduções mais comuns',
            items: [
              `${EN('going to')} → "gonna": ${EN("I'm gonna call you.")}`,
              `${EN('want to')} → "wanna": ${EN('Do you wanna go?')} · ${EN('got to')} → "gotta": ${EN("I've gotta go.")} (Preciso ir.)`,
              `${EN('kind of')} → "kinda" (meio, tipo) · ${EN('let me')} → "lemme" · ${EN('don\'t know')} → "dunno".`,
              `${EN('What do you')} → "whaddaya": ${EN('What do you want?')} soa quase "uádaiá-uónt".`
            ] },
          { h: 'Linking: palavras que se colam',
            items: [
              `Consoante + vogal se juntam: ${EN('turn it off')} soa "tur-ni-tóff" · ${EN('an apple')} soa "a-nápple".`,
              `${EN('Check it out.')} soa "tché-ki-tâut". ${EN('Pick it up.')} soa "pi-ki-tâp".`,
              `O t entre vogais, no inglês americano, vira um som rápido parecido com o nosso r de "caro": ${EN('water')}, ${EN('better')}, ${EN('a lot of')} ("a-ló-ra").`
            ] },
          { h: 'Palavras fracas',
            items: [
              `As palavras gramaticais quase somem: ${EN('to')} vira "tâ", ${EN('of')} vira "â", ${EN('and')} vira "n": ${EN('rock and roll')} → "rock n roll".`,
              `${EN('can')} na afirmativa é fraco ("kn"), ${EN("can't")} é forte — você viu isso no módulo 4.`,
              `O inglês tem ritmo de "batida": as palavras importantes (substantivos, verbos) são fortes, o resto se espreme entre elas.`
            ] },
          { h: 'Como treinar o ouvido',
            p: `Assista a trechos curtos com legenda em inglês, depois sem legenda, e repita junto (a técnica chamada ${EN('shadowing')}). Melhor 5 minutos por dia do que 2 horas no fim de semana. E nos diálogos deste curso, preste atenção em como a Ava e o Ben ligam as palavras.` }
        ],
        pratica: [
          { t: 'pares', pares: [['gonna', 'going to'], ['wanna', 'want to'], ['gotta', 'got to'], ['kinda', 'kind of'], ['lemme', 'let me']] },
          { t: 'escolha', ouvir: "I'm going to call you later.", op: ["I'm going to call you later.", 'I called you later.', 'I want to call you later.'], a: 0 },
          { t: 'escolha', ouvir: 'Do you want to go?', op: ['Do you want to go?', 'Do you have to go?', 'Did you go?'], a: 0 },
          { t: 'escolha', q: `O que significa ${EN("I've gotta go.")}`, op: ['Preciso ir.', 'Eu fui.', 'Eu consegui ir.'], a: 0, opPt: true },
          { t: 'escolha', q: `${EN("It's kinda cold.")} significa:`, op: ['Está meio frio.', 'Está muito frio.', 'Que tipo de frio.'], a: 0, opPt: true },
          { t: 'escolha', ouvir: 'Turn it off.', op: ['Turn it off.', 'Turn on it.', 'Turn of it.'], a: 0 },
          { t: 'escolha', ouvir: 'Check it out.', op: ['Check it out.', 'Check out.', 'Chicken out.'], a: 0 },
          { t: 'escolha', ouvir: 'I need a lot of water.', op: ['I need a lot of water.', 'I need a little water.', 'I need lots water.'], a: 0 },
          { t: 'digitar', ouvir: 'Let me see.', en: 'Let me see' },
          { t: 'digitar', ouvir: "I don't know.", en: "I don't know", alt: ['I do not know'] },
          { t: 'digitar', ouvir: 'What do you want?', en: 'What do you want' },
          { t: 'falar', en: 'Turn it off.' },
          { t: 'falar', en: 'Check it out.' }
        ]
      },
      {
        id: 'en-sotaques', title: 'Inglês americano × britânico',
        desc: 'As diferenças de pronúncia, vocabulário e escrita entre o inglês dos Estados Unidos e do Reino Unido — para você entender os dois.',
        objetivos: [
          'Reconhecer as principais diferenças de pronúncia entre EUA e Reino Unido',
          'Conhecer as palavras que mudam: apartment/flat, elevator/lift',
          'Entender as diferenças de escrita: color/colour, center/centre'
        ],
        body: 'Qual inglês aprender, o americano ou o britânico? Os dois são o mesmo idioma e se entendem perfeitamente. Este curso usa o americano como base, mas você vai ouvir os dois no trabalho, em séries e em viagens. Saber as diferenças evita confusão.',
        content: [
          { h: 'Pronúncia',
            items: [
              `O r depois de vogal: o americano pronuncia (${EN('car')}, ${EN('water')}); o britânico geralmente não ("cá", "uótâ").`,
              `O t entre vogais: americano rápido e suave ("uóra"); britânico mais marcado ("uó-tâ").`,
              `Algumas vogais: ${EN('can\'t')}, ${EN('bath')}, ${EN('dance')} — no britânico, um "a" longo e aberto, como em "cáa-nt".`
            ] },
          { h: 'Vocabulário que muda',
            items: [
              `${EN('apartment')} (EUA) × ${EN('flat')} (UK) — apartamento · ${EN('elevator')} × ${EN('lift')} — elevador.`,
              `${EN('vacation')} × ${EN('holiday')} — férias · ${EN('cookie')} × ${EN('biscuit')} — biscoito.`,
              `${EN('the check')} × ${EN('the bill')} — a conta · ${EN('subway')} × ${EN('underground')} / ${EN('the tube')} — metrô.`,
              `${EN('fall')} × ${EN('autumn')} — outono · ${EN('soccer')} × ${EN('football')} — futebol!`
            ] },
          { h: 'Escrita',
            items: [
              `${EN('color')} × ${EN('colour')} · ${EN('favorite')} × ${EN('favourite')} — o britânico acrescenta u.`,
              `${EN('center')} × ${EN('centre')} · ${EN('theater')} × ${EN('theatre')}.`,
              `${EN('organize')} × ${EN('organise')} · ${EN('traveled')} × ${EN('travelled')}.`,
              `Escolha um padrão e use sempre o mesmo num texto.`
            ] },
          { h: 'Datas',
            p: `Atenção máxima: nos EUA a data vem mês/dia — 03/04 é 4 de março (${EN('March 4th')}). No Reino Unido, como no Brasil, dia/mês — 03/04 é 3 de abril. Em e-mails internacionais, escreva o mês por extenso: ${EN('April 3, 2026')}.` }
        ],
        pratica: [
          { t: 'pares', pares: [['apartment', 'flat'], ['elevator', 'lift'], ['vacation', 'holiday'], ['subway', 'underground'], ['fall', 'autumn']] },
          { t: 'escolha', q: 'Nos EUA, a data 03/04 significa:', op: ['4 de março', '3 de abril', '30 de abril'], a: 0, opPt: true, exp: 'Nos EUA é mês/dia. Em e-mails internacionais, escreva o mês por extenso.' },
          { t: 'escolha', q: `Para um britânico, ${EN('football')} é:`, op: ['futebol', 'futebol americano', 'basquete'], a: 0, opPt: true },
          { t: 'escolha', q: 'Qual é a escrita britânica?', op: ['colour', 'color', 'culor'], a: 0 },
          { t: 'escolha', q: 'Qual é a escrita americana?', op: ['center', 'centre', 'sentre'], a: 0 },
          { t: 'escolha', q: `Num restaurante em Londres, para pedir a conta:`, op: ['Could we have the bill, please?', 'Could we have the check, please?', 'Could we have the count, please?'], a: 0 },
          { t: 'montar', pt: 'Vamos pegar o metrô. (Londres)', en: "Let's take the tube", extra: ['subway', 'metro'] },
          { t: 'montar', pt: 'Meu apartamento fica no terceiro andar. (EUA)', en: 'My apartment is on the third floor', extra: ['flat', 'in'] },
          { t: 'escolha', ouvir: 'My favorite color is blue.', op: ['Minha cor favorita é azul.', 'Meu sabor favorito é blueberry.', 'Minha cor favorita é verde.'], a: 0, opPt: true },
          { t: 'digitar', pt: 'Escreva "férias" em inglês americano.', en: 'vacation', alt: ['vacations'] },
          { t: 'digitar', pt: 'Escreva "elevador" em inglês britânico.', en: 'lift' },
          { t: 'falar', en: "I'm on vacation." },
          { t: 'falar', en: 'Where is the elevator?' }
        ]
      },
      {
        id: 'en-idioms', title: 'Idioms: as expressões que não se traduzem',
        desc: 'Expressões idiomáticas do dia a dia e do trabalho: piece of cake, break the ice, under the weather, on the same page.',
        objetivos: [
          'Entender os idioms mais usados no dia a dia',
          'Usar idioms do trabalho: on the same page, think outside the box',
          'Reconhecer quando a tradução literal não faz sentido'
        ],
        body: 'Se alguém disser que a prova foi "a piece of cake", não espere bolo: foi moleza. Idioms são expressões cujo sentido não sai da soma das palavras. São o tempero do inglês — e aparecem em toda conversa, série e reunião.',
        content: [
          { h: 'Do dia a dia',
            items: [
              `${EN('a piece of cake')} — moleza, muito fácil: ${EN('The test was a piece of cake.')}`,
              `${EN('under the weather')} — meio doente, indisposto: ${EN("I'm feeling a bit under the weather.")}`,
              `${EN('break the ice')} — quebrar o gelo · ${EN('hit the road')} — pegar a estrada, ir embora.`,
              `${EN('call it a day')} — encerrar por hoje: ${EN("Let's call it a day.")}`
            ] },
          { h: 'Do trabalho',
            items: [
              `${EN('on the same page')} — alinhados, de acordo: ${EN('Are we on the same page?')}`,
              `${EN('think outside the box')} — pensar fora da caixa (essa existe igual em português!).`,
              `${EN('get the ball rolling')} — dar o pontapé inicial · ${EN('back to square one')} — voltar à estaca zero.`,
              `${EN('the bottom line')} — o resumo, o que importa no fim: ${EN('The bottom line is: we need more time.')}`
            ] },
          { h: 'Parecidos com o português',
            items: [
              `${EN('kill two birds with one stone')} — matar dois coelhos com uma cajadada (passarinhos em vez de coelhos).`,
              `${EN("It's raining cats and dogs.")} — está chovendo canivete.`,
              `${EN('cost an arm and a leg')} — custar os olhos da cara.`,
              `${EN('once in a blue moon')} — muito raramente (de vez em nunca).`
            ] },
          { h: 'Dica',
            p: `Não force idioms na fala — um idiom no lugar errado soa estranho. Primeiro aprenda a reconhecer. Use os mais seguros no trabalho (${EN('on the same page')}, ${EN('call it a day')}) e guarde os mais coloridos para conversas informais.` }
        ],
        pratica: [
          { t: 'pares', pares: [['a piece of cake', 'moleza'], ['under the weather', 'meio doente'], ['call it a day', 'encerrar por hoje'], ['break the ice', 'quebrar o gelo'], ['once in a blue moon', 'muito raramente']] },
          { t: 'escolha', q: `${EN('The test was a piece of cake.')} significa:`, op: ['A prova foi moleza.', 'A prova teve bolo.', 'A prova foi um pedaço.'], a: 0, opPt: true },
          { t: 'escolha', q: `${EN('Are we on the same page?')} significa:`, op: ['Estamos alinhados?', 'Estamos na mesma página do livro?', 'Estamos no mesmo andar?'], a: 0, opPt: true },
          { t: 'escolha', q: `${EN('It cost an arm and a leg.')} significa:`, op: ['Custou os olhos da cara.', 'Custou um braço e uma perna de verdade.', 'Foi barato.'], a: 0, opPt: true },
          { t: 'escolha', q: 'Qual idiom equivale a "matar dois coelhos com uma cajadada"?', op: ['kill two birds with one stone', 'kill two rabbits with one stick', 'hit two birds'], a: 0 },
          { t: 'escolha', q: `O projeto falhou e vocês precisam recomeçar do zero:`, op: ["We're back to square one.", "We're on the same page.", "It's a piece of cake."], a: 0 },
          { t: 'montar', pt: 'Vamos encerrar por hoje.', en: "Let's call it a day", extra: ['finish', 'night'] },
          { t: 'montar', pt: 'Estou meio indisposto.', en: "I'm feeling a bit under the weather", extra: ['sick', 'over'] },
          { t: 'escolha', ouvir: "It's raining cats and dogs.", op: ['Está chovendo muito.', 'Está chovendo bichos.', 'Os animais estão na chuva.'], a: 0, opPt: true },
          { t: 'digitar', ouvir: "Let's get the ball rolling.", en: "Let's get the ball rolling", alt: ['Let us get the ball rolling'] },
          { t: 'digitar', ouvir: 'The bottom line is we need more time.', en: 'The bottom line is we need more time', alt: ['The bottom line is: we need more time', 'The bottom line is, we need more time'] },
          { t: 'falar', en: 'The test was a piece of cake.' },
          { t: 'falar', en: "Let's call it a day." }
        ]
      },
      {
        id: 'en-falsos-cognatos', title: 'Falsos cognatos: as palavras que enganam',
        desc: 'Palavras parecidas com o português e sentido completamente diferente: actually, pretend, push, college, library, parents.',
        objetivos: [
          'Reconhecer os falsos cognatos mais perigosos',
          'Usar a palavra certa para o que você quer dizer',
          'Evitar os erros que causam mal-entendidos'
        ],
        body: 'Algumas palavras parecem um presente para quem fala português — e são armadilhas. "Actually" não é "atualmente", "pretend" não é "pretender", "push" não é "puxar". Fechando o módulo, os falsos cognatos que mais geram mal-entendidos.',
        content: [
          { h: 'Os mais perigosos',
            items: [
              `${EN('actually')} = na verdade (atualmente é ${EN('currently')} / ${EN('nowadays')}).`,
              `${EN('pretend')} = fingir (pretender é ${EN('intend')} / ${EN('plan')}).`,
              `${EN('push')} = empurrar (puxar é ${EN('pull')}).`,
              `${EN('eventually')} = finalmente, com o tempo (eventualmente é ${EN('occasionally')}).`
            ] },
          { h: 'Lugares e pessoas',
            items: [
              `${EN('library')} = biblioteca (livraria é ${EN('bookstore')}).`,
              `${EN('college')} = faculdade (colégio é ${EN('high school')}).`,
              `${EN('parents')} = pai e mãe (parentes é ${EN('relatives')}).`,
              `${EN('costume')} = fantasia (costume é ${EN('habit')} / ${EN('custom')}).`
            ] },
          { h: 'No trabalho',
            items: [
              `${EN('assist')} = ajudar (assistir é ${EN('watch')}).`,
              `${EN('attend')} = comparecer (atender é ${EN('answer')} o telefone ou ${EN('serve')} o cliente).`,
              `${EN('exquisite')} = requintado, refinado (esquisito é ${EN('weird')} / ${EN('strange')}).`,
              `${EN('resume')} = currículo nos EUA, ou retomar (resumo é ${EN('summary')}).`
            ] },
          { h: 'Revisão do módulo',
            p: `Fala conectada (${EN('gonna')}, ${EN('wanna')}, linking), diferenças entre EUA e Reino Unido, idioms e falsos cognatos: tudo isso é o que separa entender o livro de entender o mundo real. Continue praticando com séries, podcasts e os diálogos deste curso.` }
        ],
        pratica: [
          { t: 'pares', pares: [['actually', 'na verdade'], ['pretend', 'fingir'], ['push', 'empurrar'], ['library', 'biblioteca'], ['college', 'faculdade']] },
          { t: 'pares', pares: [['attend', 'comparecer'], ['assist', 'ajudar'], ['relatives', 'parentes'], ['bookstore', 'livraria'], ['weird', 'esquisito']] },
          { t: 'escolha', q: 'Como se diz "Atualmente eu trabalho em São Paulo"?', op: ['Currently I work in São Paulo.', 'Actually I work in São Paulo.', 'Actual I work in São Paulo.'], a: 0, exp: 'actually = na verdade. Atualmente = currently ou nowadays.' },
          { t: 'escolha', q: 'Como se diz "Eu pretendo viajar"?', op: ['I intend to travel.', 'I pretend to travel.', 'I pretend traveling.'], a: 0, exp: 'pretend = fingir. Pretender = intend ou plan.' },
          { t: 'escolha', q: `${EN('I attended the meeting.')} significa:`, op: ['Eu compareci à reunião.', 'Eu atendi a reunião.', 'Eu esperei a reunião.'], a: 0, opPt: true },
          { t: 'escolha', q: `${EN('The food was exquisite.')} significa:`, op: ['A comida estava requintada.', 'A comida estava esquisita.', 'A comida estava cara.'], a: 0, opPt: true },
          { t: 'escolha', q: 'Como dizer "Vou à livraria comprar um livro"?', op: ["I'm going to the bookstore to buy a book.", "I'm going to the library to buy a book.", "I'm going to the librarian to buy a book."], a: 0 },
          { t: 'montar', pt: 'Na verdade, eu sou do Brasil.', en: "Actually I'm from Brazil", extra: ['Currently', 'Really'] },
          { t: 'montar', pt: 'Meu irmão está na faculdade.', en: 'My brother is in college', extra: ['school', 'high'] },
          { t: 'escolha', ouvir: 'Eventually, we found the hotel.', op: ['Finalmente, encontramos o hotel.', 'Eventualmente, encontramos o hotel.', 'Às vezes encontramos o hotel.'], a: 0, opPt: true },
          { t: 'digitar', pt: 'Pode me mandar o seu currículo? (EUA)', en: 'Can you send me your resume?', alt: ['Could you send me your resume?', 'Can you send me your resume', 'Could you send me your resume'] },
          { t: 'falar', en: "Actually, I'm from Brazil." },
          { t: 'falar', en: 'I attended the meeting yesterday.' }
        ]
      }
    ]
  }
  ,
  {
    id: 'en-m15', title: 'Módulo 15 · Inglês para dados e tecnologia: Excel, Power BI, números, documentação e apresentações (B2)', kind: 'video',
    lessons: [
      {
        id: 'en-vocab-dados', title: 'O vocabulário de dados: Excel, Power BI e cia.',
        desc: 'As palavras que aparecem em toda planilha, relatório e ferramenta de dados em inglês: dataset, row, column, filter, sort, dashboard, KPI.',
        objetivos: [
          'Nomear as partes de uma planilha e de um relatório em inglês',
          'Usar os verbos do trabalho com dados: import, clean, merge, filter, sort',
          'Entender os termos de BI: dashboard, KPI, measure, insight'
        ],
        body: 'Excel, Power BI e praticamente toda ferramenta de dados nasceram em inglês — e a documentação, os tutoriais e as vagas internacionais também. Esta aula é o vocabulário que você precisa para ler, pesquisar e conversar sobre dados em inglês.',
        content: [
          { h: 'Planilha',
            items: [
              `${EN('spreadsheet')} (planilha) · ${EN('workbook')} (pasta de trabalho) · ${EN('worksheet')} / ${EN('sheet')} (aba).`,
              `${EN('row')} (linha) · ${EN('column')} (coluna) · ${EN('cell')} (célula) · ${EN('range')} (intervalo).`,
              `${EN('formula')} · ${EN('function')} · ${EN('header')} (cabeçalho) · ${EN('table')} · ${EN('pivot table')} (tabela dinâmica).`
            ] },
          { h: 'Verbos do trabalho com dados',
            items: [
              `${EN('import')} / ${EN('load')} (carregar) · ${EN('clean')} (limpar) · ${EN('transform')} · ${EN('merge')} (mesclar) · ${EN('append')} (acrescentar).`,
              `${EN('filter')} (filtrar) · ${EN('sort')} (classificar — ${EN('ascending')} / ${EN('descending')}, crescente / decrescente).`,
              `${EN('calculate')} · ${EN('sum')} (somar) · ${EN('count')} · ${EN('average')} (média) · ${EN('round')} (arredondar).`,
              `${EN('remove duplicates')} (remover duplicatas) · ${EN('refresh')} (atualizar os dados).`
            ] },
          { h: 'Business Intelligence',
            items: [
              `${EN('dataset')} (conjunto de dados) · ${EN('data source')} (fonte de dados) · ${EN('data model')} (modelo de dados).`,
              `${EN('dashboard')} (painel) · ${EN('report')} (relatório) · ${EN('chart')} (gráfico) · ${EN('visual')}.`,
              `${EN('KPI')} (indicador-chave de desempenho) · ${EN('measure')} (medida) · ${EN('metric')} (métrica).`,
              `${EN('insight')} (descoberta, percepção valiosa nos dados) · ${EN('trend')} (tendência) · ${EN('outlier')} (ponto fora da curva).`
            ] },
          { h: 'Tipos de gráfico',
            p: `${EN('bar chart')} (barras) · ${EN('column chart')} (colunas) · ${EN('line chart')} (linhas) · ${EN('pie chart')} (pizza) · ${EN('scatter plot')} (dispersão) · ${EN('table')} e ${EN('matrix')}. E as funções do Excel em inglês têm outros nomes: PROCV é ${EN('VLOOKUP')}, SOMA é ${EN('SUM')}, SE é ${EN('IF')}.` }
        ],
        pratica: [
          { t: 'pares', pares: [['spreadsheet', 'planilha'], ['row', 'linha'], ['column', 'coluna'], ['cell', 'célula'], ['header', 'cabeçalho']] },
          { t: 'pares', pares: [['filter', 'filtrar'], ['sort', 'classificar'], ['merge', 'mesclar'], ['refresh', 'atualizar'], ['average', 'média']] },
          { t: 'pares', pares: [['bar chart', 'gráfico de barras'], ['line chart', 'gráfico de linhas'], ['pie chart', 'gráfico de pizza'], ['pivot table', 'tabela dinâmica'], ['dashboard', 'painel']] },
          { t: 'escolha', q: 'Como se chama PROCV no Excel em inglês?', op: ['VLOOKUP', 'PROCV', 'SEARCHV'], a: 0 },
          { t: 'escolha', q: `O que é um ${EN('outlier')}?`, op: ['Um ponto fora da curva', 'Um gráfico externo', 'Um filtro de dados'], a: 0, opPt: true },
          { t: 'escolha', q: `${EN('Sort the data in descending order.')} significa:`, op: ['Classifique os dados em ordem decrescente.', 'Filtre os dados de baixo para cima.', 'Exclua os dados descendentes.'], a: 0, opPt: true },
          { t: 'montar', pt: 'Remova as duplicatas e atualize o relatório.', en: 'Remove the duplicates and refresh the report', extra: ['update', 'delete'] },
          { t: 'montar', pt: 'Este painel mostra os principais KPIs.', en: 'This dashboard shows the main KPIs', extra: ['panel', 'show'] },
          { t: 'escolha', ouvir: 'First, we need to clean the dataset.', op: ['Primeiro, precisamos limpar o conjunto de dados.', 'Primeiro, precisamos criar um painel.', 'Primeiro, precisamos apagar os dados.'], a: 0, opPt: true },
          { t: 'digitar', pt: 'Escreva em inglês: tabela dinâmica', en: 'pivot table' },
          { t: 'digitar', ouvir: 'Filter the table by region.', en: 'Filter the table by region' },
          { t: 'falar', en: 'This dashboard shows our main KPIs.' },
          { t: 'falar', en: 'First, we need to clean the data.' }
        ]
      },
      {
        id: 'en-numeros-tendencias', title: 'Números e tendências: increase, drop, peak',
        desc: 'Como ler e falar de números em inglês — decimais, porcentagens, milhões — e descrever tendências em gráficos.',
        objetivos: [
          'Ler decimais, porcentagens e números grandes corretamente',
          'Descrever tendências: increase, decrease, peak, remain stable',
          'Comparar períodos: compared to, year over year, by e to'
        ],
        body: 'Quem trabalha com dados passa o dia falando de números. Em inglês, a pontuação é invertida (o ponto é a vírgula decimal), e existe um vocabulário rico para descrever o que um gráfico mostra: subiu, caiu, atingiu o pico, ficou estável.',
        content: [
          { h: 'Lendo números',
            items: [
              `Decimais com ${EN('point')}: 2.5 = ${EN('two point five')} · 0.75 = ${EN('zero point seven five')}.`,
              `Porcentagem: 15% = ${EN('fifteen percent')} · ${EN('percentage points')} (pontos percentuais).`,
              `Milhares com vírgula: 1,500 = ${EN('one thousand five hundred')} ou ${EN('fifteen hundred')}.`,
              `${EN('million')} · ${EN('billion')} (bilhão — em inglês, mil milhões) · 2.3M = ${EN('two point three million')}.`
            ] },
          { h: 'Subir e cair',
            items: [
              `Subir: ${EN('increase')} · ${EN('rise')} · ${EN('grow')} · ${EN('go up')} — forte: ${EN('soar')}, ${EN('skyrocket')}.`,
              `Cair: ${EN('decrease')} · ${EN('drop')} · ${EN('fall')} · ${EN('decline')} · ${EN('go down')} — forte: ${EN('plummet')}.`,
              `Estabilidade: ${EN('remain stable')} · ${EN('level off')} (se estabilizar) · ${EN('fluctuate')} (oscilar).`,
              `Extremos: ${EN('reach a peak')} / ${EN('peak')} (atingir o pico) · ${EN('hit a low')} (atingir o ponto mais baixo).`
            ] },
          { h: 'By × to',
            items: [
              `${EN('by')} = a variação: ${EN('Sales increased by 20%.')} (Aumentaram 20%.)`,
              `${EN('to')} = o valor final: ${EN('Sales increased to $2 million.')} (Aumentaram para 2 milhões.)`,
              `Como substantivo: ${EN('a 20% increase in sales')} · ${EN('a sharp drop')} (uma queda forte) · ${EN('a slight rise')} (uma leve alta).`
            ] },
          { h: 'Comparando períodos',
            p: `${EN('compared to last year')} (em comparação com o ano passado) · ${EN('year over year')} (ano contra ano, YoY) · ${EN('month over month')} · ${EN('in Q1')} (no primeiro trimestre — ${EN('quarter')}) · ${EN('on average')} (em média).` }
        ],
        pratica: [
          { t: 'escolha', ouvir: 'two point five', op: ['2.5', '2,5 mil', '25'], a: 0 },
          { t: 'escolha', ouvir: 'two point three million', op: ['2.3M', '2,300', '23M'], a: 0 },
          { t: 'pares', pares: [['increase', 'aumentar'], ['drop', 'cair'], ['peak', 'atingir o pico'], ['level off', 'se estabilizar'], ['fluctuate', 'oscilar']] },
          { t: 'lacuna', frase: 'Sales increased ___ 20%.', op: ['by', 'to', 'in'], a: 0, pt: 'As vendas aumentaram 20%.', exp: 'by = a variação. to = o valor final.' },
          { t: 'lacuna', frase: 'Sales increased ___ $2 million.', op: ['to', 'by', 'at'], a: 0, pt: 'As vendas aumentaram para 2 milhões.' },
          { t: 'escolha', q: `${EN('There was a sharp drop in Q2.')} significa:`, op: ['Houve uma queda forte no segundo trimestre.', 'Houve uma leve alta no segundo trimestre.', 'Houve um pico em fevereiro.'], a: 0, opPt: true },
          { t: 'escolha', q: 'Qual verbo indica uma queda muito forte?', op: ['plummet', 'level off', 'rise'], a: 0 },
          { t: 'montar', pt: 'A receita cresceu 15% em comparação com o ano passado.', en: 'Revenue grew 15% compared to last year', extra: ['than', 'growth'] },
          { t: 'montar', pt: 'As vendas atingiram o pico em dezembro.', en: 'Sales peaked in December', extra: ['on', 'top'] },
          { t: 'escolha', ouvir: 'Costs remained stable in the first quarter.', op: ['Os custos ficaram estáveis no primeiro trimestre.', 'Os custos caíram no primeiro trimestre.', 'Os custos subiram no primeiro mês.'], a: 0, opPt: true },
          { t: 'digitar', ouvir: 'Sales increased by twenty percent.', en: 'Sales increased by twenty percent', alt: ['Sales increased by 20 percent', 'Sales increased by 20%'] },
          { t: 'falar', en: 'Sales increased by twenty percent.' },
          { t: 'falar', en: 'Revenue peaked in December.' }
        ]
      },
      {
        id: 'en-documentacao', title: 'Lendo documentação e mensagens de erro',
        desc: 'Como entender tutoriais, documentação técnica e mensagens de erro em inglês — e como pesquisar e pedir ajuda em fóruns.',
        objetivos: [
          'Entender instruções no imperativo: select, click, enter, drag',
          'Interpretar mensagens de erro e avisos comuns',
          'Pesquisar e pedir ajuda em inglês com clareza'
        ],
        body: 'A melhor documentação de Excel, Power BI, SQL e Python está em inglês — e as mensagens de erro também. A boa notícia: textos técnicos usam um inglês simples e repetitivo, cheio de imperativos e palavras recorrentes. Em pouco tempo você lê sem tradutor.',
        content: [
          { h: 'Instruções: o imperativo',
            items: [
              `${EN('Select the column.')} · ${EN('Click OK.')} · ${EN('Enter the formula.')} · ${EN('Drag the field to the Values area.')}`,
              `${EN('Go to the Home tab.')} (Vá na guia Página Inicial) · ${EN('Right-click the table.')} (Clique com o botão direito).`,
              `Ordem e sequência: ${EN('First,...')} · ${EN('Then,...')} · ${EN('Next,...')} · ${EN('Finally,...')}`
            ] },
          { h: 'Palavras recorrentes da documentação',
            items: [
              `${EN('requires')} (exige) · ${EN('supports')} (suporta) · ${EN('by default')} (por padrão) · ${EN('optional')} / ${EN('required')}.`,
              `${EN('deprecated')} (obsoleto, vai deixar de existir) · ${EN('feature')} (recurso) · ${EN('setting')} (configuração).`,
              `${EN('Note:')} · ${EN('Tip:')} · ${EN('Warning:')} · ${EN('Prerequisites')} (pré-requisitos).`
            ] },
          { h: 'Mensagens de erro',
            items: [
              `${EN('An error occurred.')} (Ocorreu um erro.) · ${EN('Something went wrong.')}`,
              `${EN('File not found.')} · ${EN('Access denied.')} / ${EN('Permission denied.')} · ${EN('Invalid value.')}`,
              `${EN('The connection timed out.')} (A conexão expirou.) · ${EN('Failed to load data.')} (Falha ao carregar os dados.)`,
              `${EN('Are you sure you want to delete...?')} — confirmação antes de ação irreversível. Leia antes de clicar!`
            ] },
          { h: 'Pesquisando e pedindo ajuda',
            p: `Pesquise em inglês: ${EN('power bi measure returns blank')} traz muito mais resultados que em português. Num fórum, descreva: o que você quer, o que tentou e o erro exato. ${EN("I'm trying to... I tried... but I get this error:...")} E agradeça: ${EN('Thanks in advance!')}` }
        ],
        pratica: [
          { t: 'pares', pares: [['deprecated', 'obsoleto'], ['by default', 'por padrão'], ['required', 'obrigatório'], ['feature', 'recurso'], ['setting', 'configuração']] },
          { t: 'escolha', q: `${EN('Right-click the table.')} significa:`, op: ['Clique com o botão direito na tabela.', 'Clique na tabela certa.', 'Corrija a tabela.'], a: 0, opPt: true },
          { t: 'escolha', q: `${EN('The connection timed out.')} significa:`, op: ['A conexão expirou.', 'A conexão foi concluída.', 'A conexão está lenta.'], a: 0, opPt: true },
          { t: 'escolha', q: `${EN('Access denied.')} significa:`, op: ['Acesso negado.', 'Acesso liberado.', 'Acesso pendente.'], a: 0, opPt: true },
          { t: 'escolha', q: `Um recurso está marcado como ${EN('deprecated')}. O que isso indica?`, op: ['Vai deixar de existir; evite usar.', 'É novo e recomendado.', 'Está em promoção.'], a: 0, opPt: true },
          { t: 'escolha', q: 'Qual é a melhor forma de pedir ajuda num fórum?', op: ["I'm trying to sum sales by month. I tried SUMIF, but I get this error: #VALUE!", 'Help me please urgent.', 'Excel not working why?'], a: 0 },
          { t: 'montar', pt: 'Arraste o campo para a área de valores.', en: 'Drag the field to the Values area', extra: ['Pull', 'on'] },
          { t: 'montar', pt: 'Primeiro, selecione a coluna. Depois, clique em OK.', en: 'First select the column Then click OK', extra: ['choose', 'press'] },
          { t: 'escolha', ouvir: 'Failed to load data.', op: ['Falha ao carregar os dados.', 'Os dados foram carregados.', 'Carregue os dados primeiro.'], a: 0, opPt: true },
          { t: 'digitar', pt: 'Ocorreu um erro.', en: 'An error occurred', alt: ['An error has occurred', 'Something went wrong'] },
          { t: 'digitar', ouvir: 'Go to the Home tab.', en: 'Go to the Home tab' },
          { t: 'falar', en: "I'm trying to fix this error." },
          { t: 'falar', en: 'Select the column and click OK.' }
        ]
      },
      {
        id: 'en-apresentar-dashboard', title: 'Apresentando um dashboard em inglês',
        desc: 'A estrutura e as frases para apresentar um relatório ou dashboard: abrir, guiar pelos gráficos, destacar o insight e recomendar.',
        objetivos: [
          'Abrir a apresentação e explicar o objetivo do dashboard',
          'Guiar o público pelos gráficos: As you can see, This chart shows',
          'Destacar insights e fazer recomendações'
        ],
        body: 'Fechando o módulo: você montou o dashboard, agora precisa apresentá-lo em inglês para um gestor ou cliente. Apresentações de dados seguem uma estrutura previsível — objetivo, visão geral, detalhes, insight, recomendação — e cada parte tem suas frases prontas.',
        content: [
          { h: 'Abrindo',
            items: [
              `${EN("Today I'm going to walk you through our sales dashboard.")} (Vou apresentar/guiar vocês pelo nosso painel.)`,
              `${EN('The goal of this report is to...')} · ${EN('This dashboard answers one question:...')}`,
              `${EN('The data covers January to June.')} (Os dados cobrem de janeiro a junho.)`
            ] },
          { h: 'Guiando pelos gráficos',
            items: [
              `${EN('As you can see,...')} · ${EN('This chart shows...')} · ${EN('On the left, you can see...')}`,
              `${EN("Let's take a closer look at...")} (Vamos olhar com mais detalhe...) · ${EN("If we filter by region,...")}`,
              `${EN('The blue line represents...')} · ${EN('Each bar is a product.')}`
            ] },
          { h: 'Destacando o insight',
            items: [
              `${EN('The key takeaway is...')} (A principal conclusão é...) · ${EN('What stands out is...')} (O que chama atenção é...)`,
              `${EN('Interestingly,...')} · ${EN('This is mainly due to...')} (Isso se deve principalmente a...)`,
              `Linguagem cuidadosa com dados: ${EN('This suggests...')} · ${EN('It seems that...')} — evite afirmar causa sem prova.`
            ] },
          { h: 'Recomendando e fechando',
            p: `${EN('Based on this, I recommend...')} · ${EN('Our next step should be...')} · ${EN('To sum up,...')} · ${EN('Any questions?')} — e se não souber responder: ${EN("That's a great question. Let me check the data and get back to you.")}` }
        ],
        pratica: [
          { t: 'pares', pares: [['walk you through', 'guiar vocês por'], ['key takeaway', 'principal conclusão'], ['stands out', 'chama atenção'], ['to sum up', 'resumindo'], ['get back to you', 'te dar um retorno']] },
          { t: 'escolha', q: 'Como abrir a apresentação de um dashboard?', op: ["Today I'm going to walk you through our sales dashboard.", 'Today I will walk on our dashboard.', 'Today the dashboard walks.'], a: 0 },
          { t: 'escolha', q: 'Você não sabe responder uma pergunta. O que dizer?', op: ["That's a great question. Let me check the data and get back to you.", "I don't know.", 'Next question.'], a: 0 },
          { t: 'escolha', q: 'Qual frase evita afirmar uma causa sem prova?', op: ['This suggests that customers prefer online sales.', 'This proves that customers love online sales.', 'Customers obviously prefer online.'], a: 0 },
          { t: 'lacuna', frase: '___ you can see, sales peaked in December.', op: ['As', 'Like', 'How'], a: 0, pt: 'Como vocês podem ver, as vendas atingiram o pico em dezembro.' },
          { t: 'lacuna', frase: "Let's take a closer ___ at the South region.", op: ['look', 'see', 'watch'], a: 0, pt: 'Vamos olhar com mais detalhe a região Sul.' },
          { t: 'montar', pt: 'Este gráfico mostra a receita por mês.', en: 'This chart shows revenue by month', extra: ['graphic', 'per'] },
          { t: 'montar', pt: 'Com base nisso, eu recomendo investir no Sul.', en: 'Based on this I recommend investing in the South', extra: ['invest', 'to'] },
          { t: 'escolha', ouvir: 'The key takeaway is that online sales doubled.', op: ['A principal conclusão é que as vendas online dobraram.', 'A chave é vender online.', 'As vendas online caíram pela metade.'], a: 0, opPt: true },
          { t: 'digitar', pt: 'Resumindo, as vendas cresceram 20%.', en: 'To sum up, sales grew 20%', alt: ['To sum up, sales increased by 20%', 'To sum up sales grew 20%', 'To sum up, sales grew by 20%'] },
          { t: 'digitar', ouvir: 'Any questions?', en: 'Any questions' },
          { t: 'falar', en: "Today I'm going to walk you through our dashboard." },
          { t: 'falar', en: 'The key takeaway is that sales grew twenty percent.' }
        ]
      }
    ]
  }
  ,
  {
    id: 'en-m16', title: 'Módulo 16 · Fluência profissional: formal e informal, apresentações, entrevista e negociação (C1)', kind: 'video',
    lessons: [
      {
        id: 'en-formal-informal', title: 'Formal × informal: o tom certo',
        desc: 'Como a mesma ideia muda de registro conforme a situação — do chat com o colega ao e-mail para o diretor.',
        objetivos: [
          'Reconhecer marcas de linguagem formal e informal',
          'Trocar palavras informais por equivalentes formais (get → receive, ask for → request)',
          'Adaptar o tom ao canal: chat, e-mail, reunião, documento'
        ],
        body: 'No nível avançado, o desafio deixa de ser "estar certo" e passa a ser "soar adequado". A mesma ideia pode ser dita de forma casual ou formal, e escolher errado pode soar frio demais ou íntimo demais. Esta aula ensina a mudar de marcha.',
        content: [
          { h: 'O que muda do informal para o formal',
            items: [
              `Contrações: ${EN("I'm")}, ${EN("can't")} (informal) → ${EN('I am')}, ${EN('cannot')} (formal, especialmente na escrita).`,
              `Phrasal verbs → verbos de uma palavra: ${EN('find out')} → ${EN('discover')} · ${EN('look into')} → ${EN('investigate')} · ${EN('put off')} → ${EN('postpone')}.`,
              `Palavras do dia a dia → mais formais: ${EN('get')} → ${EN('receive')} / ${EN('obtain')} · ${EN('ask for')} → ${EN('request')} · ${EN('help')} → ${EN('assist')} · ${EN('need')} → ${EN('require')}.`
            ] },
          { h: 'A mesma ideia em dois tons',
            items: [
              `Informal: ${EN("Hey, can you send me the file?")} · Formal: ${EN('Could you please send me the file at your earliest convenience?')}`,
              `Informal: ${EN("Sorry, I can't make it.")} · Formal: ${EN('Unfortunately, I will not be able to attend.')}`,
              `Informal: ${EN("Let me know what you think.")} · Formal: ${EN('I would appreciate your feedback.')}`
            ] },
          { h: 'Cada canal, um tom',
            items: [
              `Chat com colegas (Slack, Teams): curto, contraído, informal — ${EN('Sure, will do!')} (Pode deixar!)`,
              `E-mail interno: neutro e cordial — ${EN('Hi team, quick update:...')}`,
              `E-mail para cliente ou diretoria: formal e completo — ${EN('Dear Ms. Lee, I am writing to inform you that...')}`,
              `Documento oficial: formal, impessoal, voz passiva — ${EN('The results were analyzed.')}`
            ] },
          { h: 'O erro mais comum de brasileiro',
            p: `Ser direto demais por tradução literal. "I want the report today" soa como uma ordem rude. Use modais e suavizadores: ${EN('Would it be possible to have the report today?')} — no inglês profissional, a gentileza está na estrutura da frase, não só no "please".` }
        ],
        pratica: [
          { t: 'pares', pares: [['find out', 'discover'], ['put off', 'postpone'], ['ask for', 'request'], ['get', 'receive'], ['need', 'require']] },
          { t: 'escolha', q: 'Qual é a versão formal de "Sorry, I can\'t make it"?', op: ['Unfortunately, I will not be able to attend.', "Sorry, I can't go.", "I won't make it, sorry."], a: 0 },
          { t: 'escolha', q: 'Qual é a versão formal de "Let me know what you think"?', op: ['I would appreciate your feedback.', 'Tell me your opinion.', 'What do you think?'], a: 0 },
          { t: 'escolha', q: 'No chat com um colega, qual resposta soa natural?', op: ['Sure, will do!', 'I hereby confirm that I shall do it.', 'Dear colleague, I will.'], a: 0 },
          { t: 'escolha', q: 'Qual pedido soa adequado para um diretor?', op: ['Would it be possible to have the report today?', 'I want the report today.', 'Give me the report today.'], a: 0, exp: 'Traduzir "eu quero" ao pé da letra soa como ordem. Modais suavizam.' },
          { t: 'lacuna', frase: 'Could you please send me the file at your earliest ___?', op: ['convenience', 'convenient', 'conveniently'], a: 0, pt: 'Você poderia me enviar o arquivo assim que possível?' },
          { t: 'montar', pt: 'Vamos investigar o problema.', en: 'We will investigate the issue', extra: ['look', 'into'] },
          { t: 'montar', pt: 'Infelizmente, não poderei comparecer.', en: 'Unfortunately I will not be able to attend', extra: ["can't", 'go'] },
          { t: 'escolha', ouvir: 'I am writing to inform you that the meeting has been postponed.', op: ['Escrevo para informar que a reunião foi adiada.', 'Escrevo para informar que a reunião foi cancelada.', 'A reunião vai ser hoje.'], a: 0, opPt: true },
          { t: 'digitar', pt: 'Versão formal de "ask for": ', en: 'request' },
          { t: 'digitar', ouvir: 'I would appreciate your feedback.', en: 'I would appreciate your feedback' },
          { t: 'falar', en: 'Would it be possible to have the report today?' },
          { t: 'falar', en: 'Unfortunately, I will not be able to attend.' }
        ]
      },
      {
        id: 'en-apresentacoes-pro', title: 'Apresentações: estrutura e sinalização',
        desc: 'Como estruturar uma apresentação em inglês e guiar o público com frases de transição — e como lidar com perguntas difíceis.',
        objetivos: [
          'Abrir com impacto e apresentar a estrutura',
          'Usar sinalizadores de transição: moving on, to illustrate, in conclusion',
          'Responder perguntas, inclusive as difíceis, com segurança'
        ],
        body: 'Apresentar em inglês intimida até quem fala bem. O segredo dos bons apresentadores não é vocabulário raro: é estrutura clara e frases de transição que mostram ao público onde ele está. Com elas, você soa organizado mesmo com um inglês simples.',
        content: [
          { h: 'Abrindo',
            items: [
              `Gancho: uma pergunta ou dado surpreendente — ${EN('Did you know that 80% of data projects fail?')}`,
              `${EN("Today I'd like to talk about...")} · ${EN("My presentation is divided into three parts.")}`,
              `${EN("First, I'll... Then, I'll... Finally, I'll...")} · ${EN("Feel free to ask questions at the end.")}`
            ] },
          { h: 'Sinalizando as transições',
            items: [
              `Mudar de parte: ${EN('Moving on to...')} · ${EN("Let's turn to...")} · ${EN('This brings me to my next point.')}`,
              `Exemplificar: ${EN('To illustrate this,...')} · ${EN('For example,...')} · ${EN('Let me give you an example.')}`,
              `Enfatizar: ${EN("I'd like to stress that...")} · ${EN('The most important point is...')}`,
              `Voltar: ${EN('As I mentioned earlier,...')} (Como mencionei antes...)`
            ] },
          { h: 'Concluindo',
            p: `${EN('To sum up,...')} · ${EN('In conclusion,...')} · ${EN("So, the three things I'd like you to remember are...")} · ${EN('Thank you for your attention.')} — e termine com uma chamada para ação ou uma pergunta.` },
          { h: 'Perguntas difíceis',
            items: [
              `Ganhar tempo: ${EN("That's a good question.")} · ${EN('Let me think about that for a second.')}`,
              `Confirmar: ${EN('If I understand correctly, you\'re asking...')}`,
              `Não sabe: ${EN("I don't have that information right now, but I'll find out and get back to you.")}`,
              `Fora do tema: ${EN("That's a bit outside the scope of today's presentation, but I'm happy to discuss it later.")}`
            ] }
        ],
        pratica: [
          { t: 'pares', pares: [['Moving on to...', 'Passando para...'], ['To illustrate this...', 'Para ilustrar...'], ['As I mentioned earlier...', 'Como mencionei antes...'], ['In conclusion...', 'Concluindo...'], ['outside the scope', 'fora do escopo']] },
          { t: 'escolha', q: 'Como anunciar a estrutura da apresentação?', op: ['My presentation is divided into three parts.', 'My presentation has three pieces inside.', 'I will divide my presentation in three parties.'], a: 0 },
          { t: 'escolha', q: 'Alguém faz uma pergunta que você não sabe responder:', op: ["I don't have that information right now, but I'll find out and get back to you.", "I don't know. Next.", 'This question is wrong.'], a: 0 },
          { t: 'escolha', q: 'Qual frase serve para mudar de parte?', op: ['This brings me to my next point.', 'Now another thing.', 'Next slide please now.'], a: 0 },
          { t: 'lacuna', frase: "Feel ___ to ask questions at the end.", op: ['free', 'okay', 'able'], a: 0, pt: 'Fiquem à vontade para fazer perguntas no final.' },
          { t: 'lacuna', frase: "I'd like to ___ that this is a pilot project.", op: ['stress', 'press', 'strong'], a: 0, pt: 'Gostaria de enfatizar que este é um projeto piloto.' },
          { t: 'montar', pt: 'Hoje eu gostaria de falar sobre dados.', en: "Today I'd like to talk about data", extra: ['want', 'speak'] },
          { t: 'montar', pt: 'Se eu entendi corretamente, você está perguntando...', en: "If I understand correctly you're asking", extra: ['correct', 'question'] },
          { t: 'escolha', ouvir: 'Let me give you an example.', op: ['Deixa eu dar um exemplo.', 'Me dê um exemplo.', 'Vou dar exemplos depois.'], a: 0, opPt: true },
          { t: 'digitar', pt: 'Obrigado pela atenção.', en: 'Thank you for your attention', alt: ['Thanks for your attention'] },
          { t: 'digitar', ouvir: 'Moving on to the results.', en: 'Moving on to the results' },
          { t: 'falar', en: 'My presentation is divided into three parts.' },
          { t: 'falar', en: "That's a good question. Let me think about that." }
        ]
      },
      {
        id: 'en-entrevista', title: 'Entrevista de emprego em inglês',
        desc: 'As perguntas que sempre aparecem — Tell me about yourself, strengths, weaknesses — e como responder com o método STAR.',
        objetivos: [
          'Responder "Tell me about yourself" com uma narrativa curta',
          'Falar de pontos fortes, fracos e conquistas com o método STAR',
          'Fazer boas perguntas ao entrevistador'
        ],
        body: 'Uma vaga internacional ou numa multinacional quase sempre passa por uma entrevista em inglês. A boa notícia: as perguntas são previsíveis. Quem prepara as respostas com antecedência — e treina em voz alta — chega muito mais confiante.',
        content: [
          { h: 'Tell me about yourself',
            items: [
              `A pergunta de abertura. Não conte a vida inteira: presente, passado, futuro — em uns 90 segundos.`,
              `Presente: ${EN("I'm a data analyst with five years of experience in retail.")}`,
              `Passado: ${EN('Before that, I worked in finance, where I learned...')}`,
              `Futuro: ${EN("Now I'm looking for a role where I can...")}`
            ] },
          { h: 'Pontos fortes e fracos',
            items: [
              `${EN('What are your strengths?')} — ${EN("I'm very detail-oriented.")} (detalhista) · ${EN("I'm a fast learner.")} · ${EN("I work well under pressure.")}`,
              `${EN("What's your biggest weakness?")} — diga um ponto real e o que você faz para melhorar: ${EN("I used to have trouble delegating, so now I...")}`,
              `Nunca responda "I'm a perfectionist" sem exemplo — os recrutadores já ouviram mil vezes.`
            ] },
          { h: 'O método STAR',
            items: [
              `Para perguntas como ${EN('Tell me about a time when you solved a problem.')}`,
              `${EN('Situation')} (o contexto) → ${EN('Task')} (sua responsabilidade) → ${EN('Action')} (o que VOCÊ fez) → ${EN('Result')} (o resultado, com número se possível).`,
              `${EN('Our reports took two days to update. I was asked to fix it. I automated the process with Power Query. As a result, the update now takes ten minutes.')}`
            ] },
          { h: 'Sua vez de perguntar',
            p: `No fim vem ${EN('Do you have any questions for us?')} — sempre tenha duas ou três: ${EN('What does a typical day look like in this role?')} · ${EN('How do you measure success in this position?')} · ${EN('What are the next steps in the process?')}` }
        ],
        pratica: [
          { t: 'pares', pares: [['strengths', 'pontos fortes'], ['weakness', 'ponto fraco'], ['detail-oriented', 'detalhista'], ['fast learner', 'aprende rápido'], ['under pressure', 'sob pressão']] },
          { t: 'pares', pares: [['Situation', 'contexto'], ['Task', 'responsabilidade'], ['Action', 'o que você fez'], ['Result', 'resultado'], ['role', 'cargo, função']] },
          { t: 'escolha', q: `Qual é um bom começo para ${EN('Tell me about yourself')}?`, op: ["I'm a data analyst with five years of experience in retail.", 'I was born in 1990 in a small hospital.', 'I like pizza and soccer.'], a: 0 },
          { t: 'escolha', q: `No método STAR, o que vem em "Action"?`, op: ['O que você fez, pessoalmente.', 'O que a equipe planejava.', 'O resultado final.'], a: 0, opPt: true },
          { t: 'escolha', q: 'Qual é uma boa pergunta para fazer ao entrevistador?', op: ['How do you measure success in this position?', 'How many vacation days do I get?', 'Do I have to work hard?'], a: 0 },
          { t: 'lacuna', frase: 'I work well ___ pressure.', op: ['under', 'with', 'in'], a: 0, pt: 'Eu trabalho bem sob pressão.' },
          { t: 'lacuna', frase: "I'm looking for a ___ where I can grow.", op: ['role', 'roll', 'rule'], a: 0, pt: 'Estou procurando um cargo onde eu possa crescer.' },
          { t: 'montar', pt: 'Como resultado, a atualização agora leva dez minutos.', en: 'As a result the update now takes ten minutes', extra: ['spends', 'lasts'] },
          { t: 'escolha', ouvir: 'What does a typical day look like in this role?', op: ['Como é um dia típico neste cargo?', 'Qual é o salário deste cargo?', 'Quantas horas eu trabalho por dia?'], a: 0, opPt: true },
          { t: 'digitar', pt: 'Quais são os próximos passos do processo?', en: 'What are the next steps in the process?', alt: ['What are the next steps in the process', "What are the next steps?"] },
          { t: 'digitar', ouvir: "I'm a fast learner.", en: "I'm a fast learner", alt: ['I am a fast learner'] },
          { t: 'falar', en: "I'm a data analyst with five years of experience." },
          { t: 'falar', en: 'How do you measure success in this position?' }
        ]
      },
      {
        id: 'en-negociacao', title: 'Negociação e linguagem diplomática',
        desc: 'Como negociar, discordar e dizer não em inglês sem criar atrito — a arte de suavizar com could, might, perhaps e I\'m afraid.',
        objetivos: [
          'Fazer propostas e contrapropostas com linguagem condicional',
          'Suavizar discordâncias e recusas (hedging)',
          'Fechar acordos e confirmar os próximos passos'
        ],
        body: 'O inglês profissional, especialmente o britânico, é cheio de diplomacia: em vez de "não", diz-se "I\'m not sure that would work"; em vez de "está caro", "that\'s a bit above our budget". Fechando o conteúdo do curso, a habilidade mais sofisticada: negociar sem queimar pontes.',
        content: [
          { h: 'Propostas e contrapropostas',
            items: [
              `${EN('What if we...?')} (E se nós...?) · ${EN('How about...?')} · ${EN('Would you consider...?')}`,
              `Condicional para negociar: ${EN('If you could reduce the price, we would sign a two-year contract.')}`,
              `${EN("We'd be willing to...")} (Estaríamos dispostos a...) · ${EN('In return, we would need...')} (Em troca, precisaríamos...)`
            ] },
          { h: 'Suavizando (hedging)',
            items: [
              `Direto: "That's too expensive." → Diplomático: ${EN("That's a bit above our budget.")}`,
              `Direto: "No." → Diplomático: ${EN("I'm not sure that would work for us.")}`,
              `Palavras suavizadoras: ${EN('perhaps')} · ${EN('might')} · ${EN('a bit')} · ${EN('slightly')} · ${EN('I feel that...')} · ${EN('It seems that...')}`,
              `${EN("I'm afraid we can't accept that.")} — recusa firme, mas educada.`
            ] },
          { h: 'Concordar parcialmente',
            items: [
              `${EN('I see where you\'re coming from, but...')} (Entendo seu ponto de vista, mas...)`,
              `${EN('That\'s a fair point. However,...')} · ${EN('I agree to some extent.')} (Concordo em parte.)`,
              `${EN("Let's find a middle ground.")} (Vamos achar um meio-termo.)`
            ] },
          { h: 'Fechando o acordo',
            p: `${EN('I think we have a deal.')} · ${EN("So, just to confirm,...")} (Então, só para confirmar...) · ${EN("I'll send you the agreement in writing.")} · ${EN("It's a pleasure doing business with you.")} — sempre confirme por escrito o que foi combinado.` }
        ],
        pratica: [
          { t: 'escolha', q: 'Qual é a forma diplomática de "Está caro demais"?', op: ["That's a bit above our budget.", "That's too expensive.", 'No way, too much.'], a: 0 },
          { t: 'escolha', q: 'Qual é a forma diplomática de dizer "não"?', op: ["I'm not sure that would work for us.", 'No.', "That's a bad idea."], a: 0 },
          { t: 'escolha', q: `${EN("Let's find a middle ground.")} significa:`, op: ['Vamos achar um meio-termo.', 'Vamos para o meio da sala.', 'Vamos dividir o terreno.'], a: 0, opPt: true },
          { t: 'escolha', q: `${EN('I see where you\'re coming from.')} significa:`, op: ['Entendo seu ponto de vista.', 'Vejo de onde você veio.', 'Sei de onde você é.'], a: 0, opPt: true },
          { t: 'lacuna', frase: 'If you could reduce the price, we ___ sign a two-year contract.', op: ['would', 'will', 'are'], a: 0, pt: 'Se vocês pudessem reduzir o preço, nós assinaríamos um contrato de dois anos.' },
          { t: 'lacuna', frase: "That's a fair point. ___, we need more time.", op: ['However', 'Because', 'So'], a: 0, pt: 'É um argumento justo. No entanto, precisamos de mais tempo.' },
          { t: 'pares', pares: [['perhaps', 'talvez'], ['slightly', 'ligeiramente'], ['willing to', 'disposto a'], ['in return', 'em troca'], ['to some extent', 'em parte']] },
          { t: 'montar', pt: 'Estaríamos dispostos a pagar em duas parcelas.', en: "We'd be willing to pay in two installments", extra: ['will', 'parts'] },
          { t: 'montar', pt: 'Então, só para confirmar: o prazo é maio.', en: 'So just to confirm the deadline is May', extra: ['confirming', 'term'] },
          { t: 'escolha', ouvir: "I'm afraid we can't accept that.", op: ['Infelizmente não podemos aceitar isso.', 'Temos medo de aceitar isso.', 'Talvez possamos aceitar isso.'], a: 0, opPt: true },
          { t: 'digitar', ouvir: 'I think we have a deal.', en: 'I think we have a deal' },
          { t: 'falar', en: "That's a bit above our budget." },
          { t: 'falar', en: "Let's find a middle ground." }
        ]
      }
    ]
  }
  ,
  {
    id: 'en-m17', title: 'Módulo 17 · Revisão geral, teste final e certificado', kind: 'video',
    lessons: [
      {
        id: 'en-revisao-geral', title: 'Revisão geral: do A1 ao C1',
        desc: 'Um mapa de tudo o que você aprendeu no curso, nível por nível, com os pontos que mais caem e mais confundem.',
        objetivos: [
          'Revisar os pontos-chave de cada nível do curso',
          'Identificar os erros mais comuns de quem fala português',
          'Saber como continuar evoluindo depois do curso'
        ],
        body: 'Você chegou ao fim! Antes do teste final, uma revisão de todo o caminho — do primeiro "hello" até uma negociação em inglês. Use esta aula como checklist: se algum ponto parecer fraco, volte à aula correspondente e refaça a prática.',
        content: [
          { h: 'A1 · Primeiros passos, família, rotina e cidade',
            items: [
              `Verbo to be (${EN('I am')}, ${EN('she is')}, ${EN('they are')}) e idade com to be: ${EN("I'm 30 years old.")}`,
              `Possessivos (${EN('his')} × ${EN('her')} pelo dono), ${EN("'s")} de posse e ${EN('have')} / ${EN('has')}.`,
              `Presente simples com -s na terceira pessoa e os ajudantes ${EN('do')} / ${EN('does')}.`,
              `${EN('There is')} / ${EN('there are')} (nunca "have" para existência), preposições de lugar e ${EN('can')}.`
            ] },
          { h: 'A2 · Passado, futuro, comparações e viagem',
            items: [
              `Passado: ${EN('was')} / ${EN('were')}, -ed (com os três sons), irregulares e ${EN("didn't")} + forma base.`,
              `Futuro: ${EN('going to')} (plano), ${EN('will')} (decisão na hora) e presente contínuo (compromisso marcado).`,
              `Comparativos e superlativos, ${EN('much')} / ${EN('many')}, ${EN('too')} / ${EN('enough')} e nada de dupla negação.`,
              `Viagem: aeroporto, restaurante (${EN("I'd like")}), ${EN('should')} / ${EN('have to')} e direções.`
            ] },
          { h: 'B1 e B2 · Present perfect, condicionais, trabalho e estruturas avançadas',
            items: [
              `Present perfect para experiências e para o que continua: ${EN("I've lived here for ten years.")}`,
              `Condicionais: nada de ${EN('will')} depois de ${EN('if')} / ${EN('when')}; second e third conditional; ${EN('wish')}.`,
              `Phrasal verbs, -ing × to, e-mails, reuniões, telefone e small talk.`,
              `Voz passiva, reported speech, orações relativas, idioms e falsos cognatos.`
            ] },
          { h: 'C1 · Fluência profissional e como continuar',
            items: [
              `Registro formal × informal, apresentações, entrevistas e negociação diplomática.`,
              `Continue ouvindo todo dia: séries com legenda em inglês, podcasts e a técnica de ${EN('shadowing')}.`,
              `Fale sempre que puder — erros fazem parte. E volte às práticas deste curso: a fila de revisão é o seu melhor treino.`
            ] }
        ],
        pratica: [
          { t: 'escolha', q: 'Qual frase está correta?', op: ["I'm 30 years old.", 'I have 30 years.', 'I have 30 years old.'], a: 0 },
          { t: 'escolha', q: 'Qual frase está correta?', op: ["She doesn't work on Sundays.", "She doesn't works on Sundays.", "She don't work on Sundays."], a: 0 },
          { t: 'escolha', q: 'Qual frase está correta?', op: ["There's a bank near here.", 'Have a bank near here.', 'It has a bank near here.'], a: 0 },
          { t: 'escolha', q: 'Qual frase está correta?', op: ["I didn't go to work.", "I didn't went to work.", "I don't went to work."], a: 0 },
          { t: 'escolha', q: 'Qual frase está correta?', op: ["I've lived here for ten years.", 'I live here for ten years.', 'I lived here since ten years.'], a: 0 },
          { t: 'escolha', q: 'Qual frase está correta?', op: ["If it rains, I'll stay home.", "If it will rain, I'll stay home.", 'If it rain, I stay home.'], a: 0 },
          { t: 'escolha', q: 'Qual frase está correta?', op: ["I didn't see anything.", "I didn't see nothing.", "I didn't saw nothing."], a: 0 },
          { t: 'escolha', q: 'Qual frase está correta?', op: ['I agree.', 'I am agree.', 'I agreed with.'], a: 0 },
          { t: 'pares', pares: [['actually', 'na verdade'], ['pretend', 'fingir'], ['parents', 'pai e mãe'], ['library', 'biblioteca'], ['attend', 'comparecer']] },
          { t: 'montar', pt: 'Se eu fosse você, eu aceitaria o emprego.', en: "If I were you I'd take the job", extra: ['was', 'will'] },
          { t: 'digitar', ouvir: "I'm looking forward to seeing you.", en: "I'm looking forward to seeing you", alt: ['I am looking forward to seeing you'] },
          { t: 'falar', en: "I've been studying English, and I'm ready for the test." },
          { t: 'falar', en: 'Thank you for everything!' }
        ]
      },
      {
        id: 'en-teste-final-instrucoes', title: 'Teste final e certificado: como funciona',
        desc: 'Como é o teste final de 40 questões, a nota para aprovação e como emitir o seu certificado de conclusão.',
        objetivos: [
          'Entender o formato do teste final',
          'Saber a nota mínima e como refazer',
          'Emitir o certificado de conclusão'
        ],
        body: 'O teste final tem 40 questões de múltipla escolha, cobrindo do A1 ao C1: gramática, vocabulário, situações reais e uma questão de leitura de e-mail. A aprovação é com 70% de acertos, e você pode refazer quantas vezes precisar. Ao ser aprovado, o certificado de conclusão fica disponível na sua área do aluno.',
        content: [
          { h: 'O formato',
            items: [
              `40 questões de múltipla escolha, com 4 alternativas cada.`,
              `Distribuição: níveis A1 e A2 (16 questões), B1 e B2 (16), C1 (4) e leitura de um e-mail profissional (4).`,
              `Sem limite de tempo: faça com calma, num lugar tranquilo.`
            ] },
          { h: 'Aprovação e certificado',
            items: [
              `Nota mínima: 70% (28 acertos).`,
              `Não passou? Revise as aulas indicadas e refaça — não há limite de tentativas.`,
              `Aprovado, o certificado de conclusão fica disponível na área do aluno, com seu nome e a carga do curso.`
            ] },
          { h: 'Dicas para o teste',
            items: [
              `Leia a frase inteira antes de escolher: muitas questões dependem de uma palavra-pista (${EN('yesterday')}, ${EN('since')}, ${EN('if')}).`,
              `Desconfie da alternativa que é tradução literal do português — ela costuma ser a pegadinha.`,
              `Nas questões de leitura, volte ao texto: a resposta está lá.`
            ] },
          { h: 'Parabéns!',
            p: `Você estudou 64 aulas, praticou mais de 800 exercícios e acompanhou a Lia, a Ava e o Ben do primeiro ${EN('hello')} até uma negociação. ${EN('Good luck on the test!')} (Boa sorte no teste!)` }
        ]
      }
    ]
  }
];
