<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/cursos_catalogo.php';

$curso = curso_a_venda(db(), 'ingles');
$precoCentavos = $curso['preco_centavos'] ?? null;
$precoFormatado = preco_formatado($precoCentavos ? (int)$precoCentavos : null);
$urlCompra = '/comprar.php?curso=ingles';
$whatsMsg = rawurlencode('Olá! Estou vendo a página do curso de Inglês e tenho uma dúvida antes de comprar.');
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="canonical" href="https://techsantos.com.br/curso-ingles.php" />
<script type="application/ld+json">
{"@context": "https://schema.org", "@type": "Course", "name": "Inglês do Básico ao Avançado (A1 ao C1)", "description": "Curso de inglês do básico ao avançado (A1 ao C1) em português: 17 módulos, 66 aulas com videoaulas em formato de conversa com personagens, mais de 800 exercícios interativos estilo Duolingo com áudio nativo e reconhecimento de voz, inglês para o trabalho e para dados, avaliações e certificado.", "provider": {"@type": "Organization", "name": "TECH SANTOS BR", "url": "https://techsantos.com.br/"}, "inLanguage": "pt-BR", "url": "https://techsantos.com.br/curso-ingles.php"}
</script>
<title>Curso de Inglês do Básico ao Avançado (A1 ao C1) | TECH SANTOS BR</title>
<meta name="description" content="Curso de inglês do básico ao avançado (A1 ao C1) em português: 17 módulos, 66 aulas com videoaulas em formato de conversa com personagens, mais de 800 exercícios interativos estilo Duolingo com áudio nativo e reconhecimento de voz, inglês para o trabalho e para dados, avaliações e certificado." />
<meta property="og:type" content="website" />
<meta property="og:locale" content="pt_BR" />
<meta property="og:url" content="https://techsantos.com.br/curso-ingles.php" />
<meta property="og:title" content="Inglês do Básico ao Avançado — conversa, prática interativa e áudio nativo" />
<meta property="og:description" content="17 módulos, 66 aulas do A1 ao C1, videoaulas em conversa, mais de 800 exercícios interativos, avaliações e certificado." />
<meta property="og:image" content="https://techsantos.com.br/assets/img/curso-ingles/capa.jpg" />
<meta name="twitter:card" content="summary_large_image" />
<link rel="icon" type="image/png" href="assets/img/favicon-32.png" />
<link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png" />
<link rel="stylesheet" href="assets/css/style.css" />
<?php require_once __DIR__ . '/inc/meta-pixel.php'; ?>
<?php require_once __DIR__ . '/inc/google-analytics.php'; ?>
<?php if ($precoCentavos): ?>
<script>
fbq('track', 'ViewContent', {content_name: 'Curso de Inglês do Básico ao Avançado', currency: 'BRL', value: <?= json_encode(round($precoCentavos / 100, 2)) ?>});
</script>
<?php endif; ?>
<style>
  .fab-shot { margin: 2rem auto 0; max-width: 900px; border-radius: 12px; overflow: hidden; border: 1px solid rgba(255,255,255,.12); }
  .fab-shot img { display: block; width: 100%; height: auto; }
  .exam-row { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.25rem; }
  @media (max-width: 760px) { .exam-row { grid-template-columns: 1fr; } }
  .exam-card { border: 1px solid var(--line); border-radius: 12px; padding: 1.5rem; background: var(--surface); }
  .exam-card .code { font: 700 1.6rem 'Plex Mono', monospace; color: var(--green-strong); }
  .exam-card h3 { margin: .25rem 0 .75rem; }
  .exam-card ul { margin: 0; padding-left: 1.1rem; color: var(--ink-soft); display: grid; gap: .35rem; }
  .honest-note { max-width: 760px; margin: 1.5rem auto 0; padding: 1rem 1.25rem; border-left: 4px solid var(--green); background: var(--surface); border-radius: 8px; color: var(--ink-soft); font-size: .92rem; }
</style>
</head>
<body>

<header class="site">
  <div class="nav-row">
    <a class="brand" href="/">
      <img src="assets/img/logo.jpg" alt="Tech Santos BR" />
      <span>TECH <em>SANTOS BR</em></span>
    </a>
    <nav class="links">
      <a href="/">Home</a>
      <a href="sobre.html">Sobre</a>
      <a href="servicos.html">Serviços</a>
      <a href="treinamentos.html">Treinamentos</a>
      <a href="/cursos.php">Cursos</a>
      <a href="blog/index.php">Blog</a>
      <a href="contato.html">Contato</a>
      <a href="/login.php">Área do Aluno</a>
    </nav>
    <div class="nav-actions">
      <button class="nav-toggle" aria-label="Abrir menu" aria-expanded="false">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </button>
    </div>
  </div>
</header>

<main>
  <section class="hero page-hero">
    <div class="page-hero-inner">
      <div class="ead-banner">
        <span class="dot"></span>
        <span>Curso 100% EAD — <strong>acesso imediato</strong> após a confirmação do pagamento. Explicações em português, no seu ritmo.</span>
      </div>
      <p class="eyebrow on-dark">Do básico ao avançado · A1 ao C1</p>
      <h1>Aprenda <em>inglês</em> conversando — do primeiro hello a uma reunião de trabalho.</h1>
      <p class="lead">Videoaulas em formato de conversa com personagens, prática interativa estilo Duolingo em todas as aulas e áudio nativo em cada frase. Teoria em português, sem enrolação, do zero à fluência profissional.</p>
      <?php if ($precoFormatado): ?>
      <div class="hero-offer" aria-label="Oferta do curso">
        <strong>R$ <?= $precoFormatado ?></strong>
        <span>à vista · cartão em até 12x ou Pix · acesso vitalício</span>
      </div>
      <?php endif; ?>
      <div class="hero-cta">
        <a class="btn btn-primary" href="<?= $urlCompra ?>" data-course-cta="ingles_hero_buy">Começar agora<?= $precoFormatado ? ' por R$ ' . $precoFormatado : '' ?></a>
        <a class="btn btn-ghost" href="#curriculo" data-course-cta="ingles_hero_curriculum">Ver o currículo</a>
      </div>
      <p class="hero-assurance">Acesso imediato · suporte direto · garantia de satisfação</p>
      <div class="kpi-row">
        <div class="kpi-tile"><div class="kpi-num">66</div><div class="kpi-label">aulas em 17 módulos, do A1 ao C1</div></div>
        <div class="kpi-tile"><div class="kpi-num">800+</div><div class="kpi-label">exercícios interativos: ouvir, montar, ligar, escrever e falar</div></div>
        <div class="kpi-tile"><div class="kpi-num">2.400+</div><div class="kpi-label">frases com áudio em voz nativa, para ouvir quantas vezes quiser</div></div>
        <div class="kpi-tile"><div class="kpi-num">168</div><div class="kpi-label">questões: avaliação em cada módulo e teste final com certificado</div></div>
      </div>
      <div class="fab-shot"><img src="/assets/img/curso-ingles/capa.jpg" alt="Lia, Ben e Ava, os personagens do curso, na sala de aula" loading="lazy"></div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="section-head">
        <p class="eyebrow">Como o curso funciona</p>
        <h2>Assista, pratique, fale e teste</h2>
      </div>
      <div class="proof-row">
        <div class="proof-card">
          <p class="proof-num">🎬</p>
          <p class="proof-t">videoaulas em conversa: a Lia, professora brasileira, explica; a Ava e o Ben, nativos, mostram como se fala de verdade, em cenas no escritório, no café, no aeroporto</p>
        </div>
        <div class="proof-card">
          <p class="proof-num">🧩</p>
          <p class="proof-t">prática interativa em toda aula: múltipla escolha, montar frases, ligar pares, ditado e fala com reconhecimento de voz — errou, a questão volta no fim até você acertar</p>
        </div>
        <div class="proof-card">
          <p class="proof-num">🔊</p>
          <p class="proof-t">áudio nativo em cada frase em inglês, inclusive no texto da aula: clique e ouça, também em velocidade lenta</p>
        </div>
        <div class="proof-card">
          <p class="proof-num">🎓</p>
          <p class="proof-t">avaliação em cada módulo, teste final de 40 questões e certificado de conclusão verificável</p>
        </div>
      </div>
    </div>
  </section>

  <section style="background: var(--surface-2);">
    <div class="container">
      <div class="section-head">
        <p class="eyebrow">Para quem é este curso</p>
        <h2>Para quem quer, enfim, falar inglês — e usar no trabalho</h2>
        <p>Você pode começar do zero. O curso segue os níveis do Quadro Europeu (A1 a C1), na ordem em que as coisas se conectam.</p>
      </div>
      <div class="persona-row">
        <div class="persona-card">
          <span class="persona-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4z"/></svg></span>
          <h3>Iniciante</h3>
          <p>Nunca estudou inglês direito ou travou no básico. Aqui o caminho começa no "hello", com explicação em português.</p>
        </div>
        <div class="persona-card">
          <span class="persona-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg></span>
          <h3>Quem entende mas não fala</h3>
          <p>Lê bem, mas trava na conversa. Os diálogos, o "ouça e repita" e os exercícios de fala treinam o ouvido e a boca.</p>
        </div>
        <div class="persona-card">
          <span class="persona-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 10h18M9 4v16"/></svg></span>
          <h3>Profissional</h3>
          <p>Precisa de inglês para e-mails, reuniões, ligações, entrevistas e negociação. Os módulos 12, 15 e 16 são dedicados a isso.</p>
        </div>
        <div class="persona-card">
          <span class="persona-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="12" width="4" height="8"/><rect x="10" y="7" width="4" height="13"/><rect x="17" y="3" width="4" height="17"/></svg></span>
          <h3>Quem trabalha com dados</h3>
          <p>Excel, Power BI e documentação técnica são em inglês. O módulo 15 ensina o vocabulário, a ler números e a apresentar um dashboard.</p>
        </div>
      </div>
    </div>
  </section>

  <section id="curriculo">
    <div class="container">
      <div class="section-head">
        <p class="eyebrow">Currículo completo</p>
        <h2>17 módulos, do A1 ao C1</h2>
        <p>Cada módulo constrói sobre o anterior, e cada aula tem vídeo, teoria e prática.</p>
      </div>
      <div class="curriculum-modules">
        <details class="module" open>
          <summary>
            <div class="module-title"><span class="module-num">01</span><h3>Primeiros passos: cumprimentos, verbo to be, apresentações e números (A1)</h3></div>
            <div class="module-meta"><span>A1 · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>Hello! Cumprimentos e despedidas</li><li>O verbo to be: ser e estar</li><li>Apresentando-se: nome, origem e profissão</li><li>Números, idade e telefone</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">02</span><h3>Pessoas e família: possessivos, have/has, this/that e descrições (A1)</h3></div>
            <div class="module-meta"><span>A1 · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>My family: a família e os possessivos</li><li>Have e has: falar do que você tem</li><li>This, that, these, those e os plurais</li><li>Descrevendo pessoas: aparência e personalidade</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">03</span><h3>Rotina: presente simples, do/does, frequência, horas e preposições de tempo (A1)</h3></div>
            <div class="module-meta"><span>A1 · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>Presente simples: I work, she works</li><li>Do e does: negativa e perguntas</li><li>Always, never e as horas</li><li>Minha rotina: verbos do dia a dia e in, on, at</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">04</span><h3>Casa, cidade e compras: there is/are, preposições, can e preços (A1)</h3></div>
            <div class="module-meta"><span>A1 · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>There is e there are: o que tem no lugar</li><li>Onde fica? As preposições de lugar</li><li>Can: habilidade, permissão e pedidos</li><li>Shopping: preços, tamanhos e pagamento</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">05</span><h3>O passado: was/were, verbos regulares e irregulares, did (A2)</h3></div>
            <div class="module-meta"><span>A2 · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>Was e were: o verbo to be no passado</li><li>Passado dos verbos regulares: -ed</li><li>Os verbos irregulares mais usados</li><li>Did: negativa e perguntas no passado</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">06</span><h3>Futuro e planos: going to, will, presente contínuo e convites (A2)</h3></div>
            <div class="module-meta"><span>A2 · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>Going to: planos e previsões</li><li>Will: decisões na hora, promessas e opiniões</li><li>Presente contínuo: o que está acontecendo agora</li><li>Combinando planos: compromissos e convites</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">07</span><h3>Comparações e quantidades: comparativos, superlativos, much/many, some/any (A2)</h3></div>
            <div class="module-meta"><span>A2 · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>Comparativos: bigger, more expensive, better</li><li>Superlativos: the biggest, the most beautiful, the best</li><li>Contáveis e incontáveis: much, many, a lot of</li><li>Something, anything, nothing e too / enough</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">08</span><h3>Viagem: aeroporto, hotel, restaurante, conselhos e direções (A2)</h3></div>
            <div class="module-meta"><span>A2 · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>No aeroporto e no hotel</li><li>No restaurante: would like e como pedir</li><li>Should, could e have to: conselhos e obrigações</li><li>Pedindo e dando direções</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">09</span><h3>Present perfect: experiências, for/since, already/yet e a diferença para o passado (B1)</h3></div>
            <div class="module-meta"><span>B1 · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>Present perfect: Have you ever...?</li><li>For e since: desde quando?</li><li>Already, yet e just</li><li>Present perfect ou passado simples?</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">10</span><h3>Conditionals: if, when, unless e hipóteses (B1)</h3></div>
            <div class="module-meta"><span>B1 · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>Zero e first conditional: se acontecer...</li><li>Second conditional: e se...?</li><li>If ou when? E as orações de tempo</li><li>Unless, in case e would rather</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">11</span><h3>Phrasal verbs e verbos com -ing ou to (B1)</h3></div>
            <div class="module-meta"><span>B1 · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>Phrasal verbs: o que são e como funcionam</li><li>Phrasal verbs do trabalho e do dia a dia</li><li>Gerúndio ou infinitivo: enjoy doing, want to do</li><li>Phrasal verbs da conversa: get along, hang out, show up</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">12</span><h3>Inglês no trabalho: e-mails, reuniões, ligações e small talk (B1)</h3></div>
            <div class="module-meta"><span>B1 · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>E-mails profissionais</li><li>Reuniões online</li><li>Ligações e mensagens</li><li>Small talk e cortesia</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">13</span><h3>Estruturas do B2: voz passiva, discurso indireto, orações relativas, third conditional e wish</h3></div>
            <div class="module-meta"><span>B2 · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>Voz passiva: It was built in 1990</li><li>Reported speech: ele disse que...</li><li>Orações relativas: who, which, that, where, whose</li><li>Third conditional e wish: arrependimentos</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">14</span><h3>Escuta e expressões: fala conectada, sotaques, idioms e falsos cognatos (B2)</h3></div>
            <div class="module-meta"><span>B2 · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>Fala conectada: por que o nativo &quot;come&quot; as palavras</li><li>Inglês americano × britânico</li><li>Idioms: as expressões que não se traduzem</li><li>Falsos cognatos: as palavras que enganam</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">15</span><h3>Inglês para dados e tecnologia: Excel, Power BI, números, documentação e apresentações (B2)</h3></div>
            <div class="module-meta"><span>B2 · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>O vocabulário de dados: Excel, Power BI e cia.</li><li>Números e tendências: increase, drop, peak</li><li>Lendo documentação e mensagens de erro</li><li>Apresentando um dashboard em inglês</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">16</span><h3>Fluência profissional: formal e informal, apresentações, entrevista e negociação (C1)</h3></div>
            <div class="module-meta"><span>C1 · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>Formal × informal: o tom certo</li><li>Apresentações: estrutura e sinalização</li><li>Entrevista de emprego em inglês</li><li>Negociação e linguagem diplomática</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">17</span><h3>Revisão geral, teste final e certificado</h3></div>
            <div class="module-meta"><span>🎓 · 2 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>Revisão geral: do A1 ao C1</li><li>Teste final e certificado: como funciona</li></ul>
          </div>
        </details>
      </div>
    </div>
  </section>

  <section style="background: var(--surface-2);">
    <div class="container">
      <div class="section-head">
        <p class="eyebrow">Dúvidas frequentes</p>
        <h2>Perguntas que a gente mais recebe</h2>
      </div>
      <div class="faq-list">
        <div class="faq-item">
          <h3>Preciso saber alguma coisa de inglês?</h3>
          <p>Não. O primeiro módulo começa pelos cumprimentos e pelo verbo to be, com todas as explicações em português. Quem já tem base pode avançar mais rápido pelos primeiros módulos.</p>
        </div>
        <div class="faq-item">
          <h3>Como funcionam as videoaulas?</h3>
          <p>Cada aula é uma conversa animada entre a Lia, professora brasileira, e a Ava, nativa, com o Ben entrando nos diálogos. O quadro mostra as frases com tradução, e no fim tem o "ouça e repita" para você praticar a pronúncia.</p>
        </div>
        <div class="faq-item">
          <h3>Os exercícios de fala funcionam no celular?</h3>
          <p>Funcionam nos navegadores com reconhecimento de voz, como Chrome e Edge, no computador e no celular. Nos outros navegadores você lê a frase em voz alta e segue — nenhum exercício trava o seu avanço.</p>
        </div>
        <div class="faq-item">
          <h3>O curso dá certificado?</h3>
          <p>Sim. Ao ser aprovado no teste final (70% de acertos, com tentativas ilimitadas), você emite o certificado de conclusão da TECH SANTOS BR, verificável online. O curso não substitui provas de proficiência como TOEFL ou IELTS, que são aplicadas por instituições próprias.</p>
        </div>
        <div class="faq-item">
          <h3>É inglês americano ou britânico?</h3>
          <p>A base é o inglês americano, e o módulo 14 mostra as diferenças de pronúncia, vocabulário e escrita do inglês britânico, para você entender os dois.</p>
        </div>
        <div class="faq-item">
          <h3>Por quanto tempo tenho acesso?</h3>
          <p>Acesso vitalício, incluindo as atualizações do conteúdo.</p>
        </div>
        <div class="faq-item">
          <h3>Já sou aluno de outro curso. Como compro?</h3>
          <p>Entre na Área do Aluno: o curso de Inglês aparece em "Outros cursos", com compra direta. Depois do pagamento ele aparece junto do seu curso atual, com o mesmo login.</p>
        </div>
        <div class="faq-item">
          <h3>Quais as formas de pagamento?</h3>
          <p>Cartão de crédito (à vista ou em até 12x) ou Pix, pelo checkout do Mercado Pago.</p>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="pricing-cta">
        <div class="pricing-cta-inner">
          <p class="eyebrow on-dark">Matricule-se agora</p>
          <h2>Comece hoje, no seu ritmo</h2>
          <p class="lead">Acesso liberado automaticamente após a confirmação do pagamento.</p>
          <?php if ($precoFormatado): ?>
          <p class="price">R$ <?= $precoFormatado ?><small>à vista ou parcelado em até 12x no cartão · acesso vitalício</small></p>
          <?php endif; ?>
          <div class="hero-cta">
            <a class="btn btn-primary" href="<?= $urlCompra ?>" data-course-cta="ingles_final_buy">Começar agora</a>
            <a class="btn btn-ghost" href="https://wa.me/5564992905785?text=<?= $whatsMsg ?>" target="_blank" rel="noopener">Tirar dúvida no WhatsApp</a>
          </div>
          <p class="hero-assurance">Garantia: mediante solicitação, se você concluiu menos de 20% do curso e não gostou, devolvemos 100% do valor.</p>
        </div>
      </div>
    </div>
  </section>
</main>

<footer class="site footer-wide">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <a class="brand" href="/">
          <img src="assets/img/logo.jpg" alt="Tech Santos BR" />
          <span>TECH <em>SANTOS BR</em></span>
        </a>
        <p>Consultoria e treinamento em Power BI, Microsoft Fabric e Excel, com mais de 50 projetos de BI implementados. Itumbiara-GO, atendimento para todo o Brasil.</p>
      </div>
      <div class="footer-col">
        <h4>Cursos</h4>
        <a href="/cursos.php">Todos os cursos</a>
        <a href="/curso-excel.php">Excel do zero ao avançado (MO-210 e MO-211)</a>
        <a href="/curso-microsoft-fabric.php">Microsoft Fabric (DP-600 e DP-700)</a>
        <a href="/curso-power-bi.php">Curso completo de Power BI</a>
        <a href="/curso-ingles.php">Inglês do básico ao avançado</a>
        <a href="/login.php">Área do Aluno</a>
      </div>
      <div class="footer-col">
        <h4>Empresa</h4>
        <a href="/sobre.html">Sobre</a>
        <a href="/servicos.html">Serviços</a>
        <a href="/treinamentos.html">Treinamentos</a>
        <a href="/blog/">Blog</a>
      </div>
      <div class="footer-col">
        <h4>Contato</h4>
        <a href="mailto:claristonsantos@techsantos.com.br">claristonsantos@techsantos.com.br</a>
        <a href="https://wa.me/5564992905785" target="_blank" rel="noopener">(64) 99290-5785</a>
        <span>Itumbiara-GO</span>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© 2026 TECH SANTOS BR Treinamentos e Aulas Particulares · CNPJ 41.135.509/0001-29 · Simples Nacional</span>
    </div>
  </div>
</footer>
<script src="assets/js/nav.js"></script>
</body>
</html>
