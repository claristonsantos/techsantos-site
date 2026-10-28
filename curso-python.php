<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/cursos_catalogo.php';

$curso = curso_a_venda(db(), 'python');
$precoCentavos = $curso['preco_centavos'] ?? null;
$precoFormatado = preco_formatado($precoCentavos ? (int)$precoCentavos : null);
$urlCompra = '/comprar.php?curso=python';
$whatsMsg = rawurlencode('Olá! Estou vendo a página do curso de Python e tenho uma dúvida antes de comprar.');
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="canonical" href="https://techsantos.com.br/curso-python.php" />
<script type="application/ld+json">
{"@context": "https://schema.org", "@type": "Course", "name": "Python para Dados — do Zero ao pandas", "description": "Curso de Python do zero até Python para dados, em português: 14 módulos, 55 aulas com laboratório de código no navegador, 54 desafios em que você escreve o script e o site confere o resultado, pandas, gráficos com matplotlib, automação de planilhas Excel, avaliações e certificado.", "provider": {"@type": "Organization", "name": "TECH SANTOS BR", "url": "https://techsantos.com.br/"}, "inLanguage": "pt-BR", "url": "https://techsantos.com.br/curso-python.php"}
</script>
<title>Curso de Python para Dados — do Zero ao pandas | TECH SANTOS BR</title>
<meta name="description" content="Curso de Python do zero até Python para dados, em português: 14 módulos, 55 aulas com laboratório de código no navegador, 54 desafios práticos corrigidos na hora, pandas, gráficos, automação de planilhas Excel, avaliações e certificado." />
<meta property="og:type" content="website" />
<meta property="og:locale" content="pt_BR" />
<meta property="og:url" content="https://techsantos.com.br/curso-python.php" />
<meta property="og:title" content="Python para Dados — do zero ao pandas, programando de verdade desde a primeira aula" />
<meta property="og:description" content="14 módulos, 55 aulas, laboratório de Python no navegador, 54 desafios corrigidos na hora, pandas, gráficos e automação de Excel, com certificado." />
<meta property="og:image" content="https://techsantos.com.br/assets/img/curso-python/capa.jpg" />
<meta name="twitter:card" content="summary_large_image" />
<link rel="icon" type="image/png" href="assets/img/favicon-32.png" />
<link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png" />
<link rel="stylesheet" href="assets/css/style.css" />
<?php require_once __DIR__ . '/inc/meta-pixel.php'; ?>
<?php require_once __DIR__ . '/inc/google-analytics.php'; ?>
<?php if ($precoCentavos): ?>
<script>
fbq('track', 'ViewContent', {content_name: 'Curso de Python para Dados', currency: 'BRL', value: <?= json_encode(round($precoCentavos / 100, 2)) ?>});
</script>
<?php endif; ?>
<style>
  .fab-shot { margin: 2rem auto 0; max-width: 1000px; border-radius: 12px; overflow: hidden; border: 1px solid rgba(255,255,255,.12); }
  .fab-shot img { display: block; width: 100%; height: auto; }
  .fab-shot figcaption { padding: .6rem 1rem; font-size: .85rem; color: rgba(255,255,255,.75); background: rgba(0,0,0,.25); }
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
        <span>Curso 100% EAD — <strong>acesso imediato</strong> após a confirmação do pagamento. Nada para instalar: o Python roda no seu navegador.</span>
      </div>
      <p class="eyebrow on-dark">Do zero até Python para dados</p>
      <h1>Aprenda <em>Python</em> programando — do primeiro print a um relatório Excel automático.</h1>
      <p class="lead">Em cada aula você escreve código de verdade num laboratório dentro do navegador e resolve um desafio de cenário real: o site roda o seu script e confere o resultado na hora. Explicações em português, do zero ao pandas, gráficos e automação de planilhas.</p>
      <?php if ($precoFormatado): ?>
      <div class="hero-offer" aria-label="Oferta do curso">
        <strong>R$ <?= $precoFormatado ?></strong>
        <span>à vista · cartão em até 12x ou Pix · acesso vitalício</span>
      </div>
      <?php endif; ?>
      <div class="hero-cta">
        <a class="btn btn-primary" href="<?= $urlCompra ?>" data-course-cta="python_hero_buy">Começar agora<?= $precoFormatado ? ' por R$ ' . $precoFormatado : '' ?></a>
        <a class="btn btn-ghost" href="#curriculo" data-course-cta="python_hero_curriculum">Ver o currículo</a>
      </div>
      <p class="hero-assurance">Acesso imediato · suporte direto · garantia de satisfação</p>
      <div class="kpi-row">
        <div class="kpi-tile"><div class="kpi-num">55</div><div class="kpi-label">aulas em 14 módulos, do zero ao Python para dados</div></div>
        <div class="kpi-tile"><div class="kpi-num">54</div><div class="kpi-label">desafios de cenário: você escreve o script e o site confere</div></div>
        <div class="kpi-tile"><div class="kpi-num">350+</div><div class="kpi-label">exercícios interativos: ler código, completar, ordenar linhas</div></div>
        <div class="kpi-tile"><div class="kpi-num">144</div><div class="kpi-label">questões: avaliação em cada módulo e teste final com certificado</div></div>
      </div>
      <figure class="fab-shot"><img src="/assets/img/curso-python/capa.jpg" alt="Laboratório do curso: código Python à esquerda; à direita, o painel com dois gráficos gerado pelo código e os testes do desafio aprovados" loading="lazy"><figcaption>Tela real do laboratório: o aluno escreveu o código, o gráfico foi gerado no navegador e os testes do desafio passaram.</figcaption></figure>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="section-head">
        <p class="eyebrow">Como o curso funciona</p>
        <h2>Assista, programe, resolva e teste</h2>
      </div>
      <div class="proof-row">
        <div class="proof-card">
          <p class="proof-num">🎬</p>
          <p class="proof-t">videoaulas em formato de conversa, com o código no quadro: o conceito explicado em português, passo a passo</p>
        </div>
        <div class="proof-card">
          <p class="proof-num">▶</p>
          <p class="proof-t">laboratório no navegador: todo exemplo da aula tem o botão Executar, e você muda o código para ver o que acontece — sem instalar nada</p>
        </div>
        <div class="proof-card">
          <p class="proof-num">💻</p>
          <p class="proof-t">desafio de cenário em cada aula: um problema de trabalho, você escreve o script e o site confere o resultado, com dicas e solução comentada</p>
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
        <h2>Para quem trabalha com planilhas e quer automatizar o trabalho</h2>
        <p>Você pode começar sem nunca ter programado. Os primeiros 7 módulos constroem a base; a partir do 8º, tudo é sobre dados.</p>
      </div>
      <div class="persona-row">
        <div class="persona-card">
          <span class="persona-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4z"/></svg></span>
          <h3>Iniciante em programação</h3>
          <p>Nunca escreveu uma linha de código. O curso começa no print e explica cada conceito em português, com exemplos de negócio.</p>
        </div>
        <div class="persona-card">
          <span class="persona-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 10h18M9 4v16"/></svg></span>
          <h3>Quem vive no Excel</h3>
          <p>Copia e cola planilhas todo mês, limpa exportação de sistema, monta o mesmo relatório toda semana. O Python faz isso por você.</p>
        </div>
        <div class="persona-card">
          <span class="persona-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="12" width="4" height="8"/><rect x="10" y="7" width="4" height="13"/><rect x="17" y="3" width="4" height="17"/></svg></span>
          <h3>Analista de dados e BI</h3>
          <p>Usa Power BI ou Excel e quer o pandas no repertório: limpeza, cruzamento de tabelas, agrupamentos e gráficos por código.</p>
        </div>
        <div class="persona-card">
          <span class="persona-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v12H4z"/><path d="M8 20h8M12 16v4"/></svg></span>
          <h3>Próximo passo: Microsoft Fabric</h3>
          <p>Os notebooks do Fabric usam Python e pandas. Este curso é a base para trabalhar com eles.</p>
        </div>
      </div>
    </div>
  </section>

  <section id="curriculo">
    <div class="container">
      <div class="section-head">
        <p class="eyebrow">Currículo completo</p>
        <h2>14 módulos, do primeiro print ao relatório automático</h2>
        <p>Cada aula tem teoria com código executável, prática interativa e um desafio de cenário.</p>
      </div>
      <div class="curriculum-modules">
        <details class="module" open>
          <summary>
            <div class="module-title"><span class="module-num">01</span><h3>Primeiros passos: print, variáveis, tipos e operações</h3></div>
            <div class="module-meta"><span>Fundamentos · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>O que é Python e o seu primeiro código</li><li>Variáveis e tipos de dados</li><li>Operações e textos: contas, f-strings e arredondamento</li><li>Seu primeiro script de dados: o fechamento do mês</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">02</span><h3>Textos: strings, métodos, fatias e limpeza</h3></div>
            <div class="module-meta"><span>Fundamentos · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>Strings: o básico dos textos</li><li>Métodos de texto: upper, lower, strip, replace</li><li>split e join: quebrar e juntar textos</li><li>Projeto: limpando uma lista de clientes</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">03</span><h3>Decisões: comparações, if, elif, else e lógica</h3></div>
            <div class="module-meta"><span>Fundamentos · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>Comparações e valores booleanos</li><li>if, elif e else: o programa toma decisões</li><li>and, or e not: combinando condições</li><li>Projeto: classificando clientes</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">04</span><h3>Listas e laços: for, while, range e acumuladores</h3></div>
            <div class="module-meta"><span>Fundamentos · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>Listas: guardando vários valores</li><li>O laço for: repetindo para cada item</li><li>while, break e continue</li><li>List comprehension e o projeto do módulo</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">05</span><h3>Dicionários, tuplas e conjuntos</h3></div>
            <div class="module-meta"><span>Fundamentos · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>Dicionários: chave e valor</li><li>Lista de dicionários: uma tabela em Python</li><li>Tuplas e conjuntos (sets)</li><li>JSON: dados de APIs e sistemas</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">06</span><h3>Funções: organizar e reaproveitar código</h3></div>
            <div class="module-meta"><span>Fundamentos · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>Criando funções com def</li><li>Parâmetros padrão, nomeados e vários retornos</li><li>Módulos e bibliotecas: import</li><li>Projeto: um mini-sistema de pedidos</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">07</span><h3>Erros e depuração: ler, prevenir e tratar</h3></div>
            <div class="module-meta"><span>Fundamentos · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>Lendo mensagens de erro</li><li>try e except: tratando erros</li><li>Depuração: encontrando erros de lógica</li><li>Projeto: validando uma base de cadastros</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">08</span><h3>Arquivos: texto, CSV e JSON</h3></div>
            <div class="module-meta"><span>Arquivos · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>Lendo e gravando arquivos de texto</li><li>Lendo CSV com o módulo csv</li><li>CSV brasileiro e gravando CSV para o Excel</li><li>Projeto: consolidando planilhas mensais</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">09</span><h3>pandas I: tabelas de dados (DataFrame)</h3></div>
            <div class="module-meta"><span>pandas · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>Conhecendo o pandas e o DataFrame</li><li>Selecionando colunas e filtrando linhas</li><li>Colunas calculadas, datas e contagens</li><li>Projeto: relatório de pedidos grandes</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">10</span><h3>pandas II: limpeza e tratamento de dados</h3></div>
            <div class="module-meta"><span>pandas · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>Diagnóstico: vazios e duplicados</li><li>Padronizando textos e convertendo preços</li><li>Datas brasileiras, tipos e regras de preenchimento</li><li>Projeto: a função de limpeza reutilizável</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">11</span><h3>pandas III: agrupar, cruzar e resumir</h3></div>
            <div class="module-meta"><span>pandas · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>groupby: totais por categoria</li><li>merge: cruzando tabelas (o PROCV do pandas)</li><li>pivot_table: a tabela dinâmica</li><li>Projeto: análise de clientes para a diretoria</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">12</span><h3>Gráficos com matplotlib</h3></div>
            <div class="module-meta"><span>Resultado · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>Gráfico de barras: comparando categorias</li><li>Gráfico de linhas: evolução no tempo</li><li>Acabamento profissional e salvando a imagem</li><li>Projeto: painel com dois gráficos</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">13</span><h3>Automação de planilhas Excel</h3></div>
            <div class="module-meta"><span>Resultado · 4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>Lendo e gravando Excel com pandas</li><li>openpyxl: células, linhas e fórmulas</li><li>Formatação: deixando a planilha apresentável</li><li>Projeto: relatório Excel automático</li></ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">14</span><h3>Projeto final e teste do certificado</h3></div>
            <div class="module-meta"><span>🎓 · 3 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list"><li>Projeto final 1: da base suja aos indicadores</li><li>Projeto final 2: o relatório do semestre</li><li>Revisão geral e teste final do certificado</li></ul>
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
          <h3>Preciso saber programar?</h3>
          <p>Não. O primeiro módulo começa pelo print e pelas variáveis, com tudo explicado em português. Se você usa Excel, já tem a lógica de que precisa.</p>
        </div>
        <div class="faq-item">
          <h3>Preciso instalar o Python?</h3>
          <p>Não para fazer o curso: o Python roda dentro do seu navegador, no computador. A última aula mostra como instalar o Python e o VS Code para usar no seu trabalho.</p>
        </div>
        <div class="faq-item">
          <h3>Como funcionam os desafios?</h3>
          <p>Cada aula traz um problema de trabalho — separar os erros de um log, consolidar planilhas mensais, limpar uma exportação suja, montar um relatório Excel. Você escreve o script, clica em Verificar e o site roda testes no seu código. Travou? Há dicas progressivas e, depois de algumas tentativas, a solução comentada.</p>
        </div>
        <div class="faq-item">
          <h3>Funciona no celular?</h3>
          <p>A teoria, as videoaulas e a prática funcionam no celular. Para escrever código nos desafios, recomendamos o computador, pela comodidade do teclado.</p>
        </div>
        <div class="faq-item">
          <h3>O curso dá certificado?</h3>
          <p>Sim. Ao ser aprovado no teste final (70% de acertos, com tentativas ilimitadas), você emite o certificado de conclusão da TECH SANTOS BR, verificável online.</p>
        </div>
        <div class="faq-item">
          <h3>Por quanto tempo tenho acesso?</h3>
          <p>Acesso vitalício, incluindo as atualizações do conteúdo.</p>
        </div>
        <div class="faq-item">
          <h3>Já sou aluno de outro curso. Como compro?</h3>
          <p>Entre na Área do Aluno: o curso de Python aparece em "Outros cursos", com compra direta. Depois do pagamento ele aparece junto do seu curso atual, com o mesmo login.</p>
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
            <a class="btn btn-primary" href="<?= $urlCompra ?>" data-course-cta="python_final_buy">Começar agora</a>
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
        <a href="/curso-python.php">Python para dados</a>
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
