<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

$stmt = db()->prepare("SELECT preco_centavos FROM cursos WHERE slug = 'power-bi'");
$stmt->execute();
$precoCentavos = $stmt->fetchColumn();
$precoFormatado = $precoCentavos ? number_format((int)$precoCentavos / 100, 2, ',', '.') : null;
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Curso Power BI — TECH SANTOS BR</title>
<meta name="description" content="Curso completo de Power BI: modelagem de dados, Power Query, DAX, relatórios, análise avançada e governança. 13 módulos, 46 videoaulas (mais de 7 horas de vídeo), laboratórios práticos guiados e conteúdo com referências oficiais Microsoft, com Clariston Santos." />
<link rel="icon" type="image/png" href="assets/img/favicon-32.png" />
<link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png" />
<link rel="stylesheet" href="assets/css/style.css" />
<?php require_once __DIR__ . '/inc/meta-pixel.php'; ?>
<?php if ($precoCentavos): ?>
<script>
fbq('track', 'ViewContent', {content_name: 'Curso Power BI', currency: 'BRL', value: <?= json_encode(round($precoCentavos / 100, 2)) ?>});
</script>
<?php endif; ?>
</head>
<body>

<header class="site">
  <div class="nav-row">
    <a class="brand" href="index.html">
      <img src="assets/img/logo.jpg" alt="Tech Santos BR" />
      <span>TECH <em>SANTOS BR</em></span>
    </a>
    <nav class="links">
      <a href="index.html">Home</a>
      <a href="sobre.html">Sobre</a>
      <a href="servicos.html">Serviços</a>
      <a href="treinamentos.html">Treinamentos</a>
      <a href="projetos.html">Projetos</a>
      <a href="contato.html">Contato</a>
      <a href="/login.php">Área do Aluno</a>
    </nav>
    <div class="nav-actions">
      <a class="btn btn-primary desktop-only" href="https://wa.me/5564992905785" target="_blank" rel="noopener">Falar no WhatsApp</a>
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
        <span>Curso 100% EAD — <strong>matrícula aberta o ano todo</strong>, acesso imediato após a inscrição. Estude no seu ritmo.</span>
      </div>
      <p class="eyebrow on-dark">Curso completo · Modelagem, Power Query, DAX e Relatórios</p>
      <h1>Power BI, do dado bruto ao <em>indicador de negócio</em> pronto para decisão.</h1>
      <p class="lead">Curso próprio da TECH SANTOS BR, com apostila escrita pelo instrutor, videoaulas práticas gravadas passo a passo e laboratórios guiados — para quem já usa Excel e quer parar de repetir PROCV e começar a construir modelos de dados de verdade.</p>
      <div class="hero-cta">
        <a class="btn btn-primary" href="/comprar.php">Comprar o curso</a>
        <a class="btn btn-ghost" href="/aula-gratis.php">Assistir aula grátis</a>
        <a class="btn btn-ghost" href="#curriculo">Ver o currículo completo</a>
      </div>
      <div class="kpi-row">
        <div class="kpi-tile"><div class="kpi-num">46</div><div class="kpi-label">videoaulas práticas, mais de 7 horas de conteúdo</div></div>
        <div class="kpi-tile"><div class="kpi-num">13</div><div class="kpi-label">módulos, da modelagem aos laboratórios práticos</div></div>
        <div class="kpi-tile"><div class="kpi-num">1</div><div class="kpi-label">apostila própria + laboratórios guiados</div></div>
        <div class="kpi-tile"><div class="kpi-num">MS</div><div class="kpi-label">instrutor certificado pela Microsoft</div></div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="section-head">
        <p class="eyebrow">Avaliações</p>
        <h2>O que dizem os alunos</h2>
      </div>
      <div class="testimonial-stat yt">
        <span>▶️ Canal no YouTube com mais de 22 mil visualizações em tutoriais de Power BI</span>
        <a href="https://www.youtube.com/@claristonsantos8129?sub_confirmation=1" target="_blank" rel="noopener">Inscreva-se no canal →</a>
      </div>
      <div class="testimonial-stat">
        <span class="stars">★★★★★</span>
        <span><span class="num">5.0</span> · 46 avaliações reais · 50+ alunos</span>
        <a href="https://www.superprof.com.br/power-dax-linguagem-criacao-automacao-relatorios-com-integracao-share-point-one-drive-outros-banco.html" target="_blank" rel="noopener">Ver todas as avaliações no Superprof →</a>
      </div>
      <div class="testimonial-grid">
        <div class="testimonial-card">
          <p>"Amei a aula de Power BI do professor Clariston! Ele me ensinou de forma clara e objetiva e demonstrou dominar o assunto, além de ser muito atencioso. Super indico!"</p>
          <span class="who">Thamirys</span>
        </div>
        <div class="testimonial-card">
          <p>"Ótimo professor que realmente entende de Power BI. Aulas conceituais e práticas para a melhor fixação do conteúdo lecionado. Nota 10!"</p>
          <span class="who">Leandro</span>
        </div>
        <div class="testimonial-card">
          <p>"O Clariston é um professor extraordinário, tem conhecimento do assunto, tem didática, ensina quantas vezes for necessário até você aprender! Muito mais que professor, ele é um mestre!"</p>
          <span class="who">Joice</span>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="section-head">
        <p class="eyebrow">Para quem é este curso</p>
        <h2>Para quem já usa Excel e quer dar o próximo passo</h2>
        <p>Feito para profissionais de análise de dados, financeiro, contabilidade e áreas de negócio que precisam estruturar relatórios com mais eficiência — sem depender de PROCV infinito ou macros que só uma pessoa entende. Você vai aprender a identificar padrões nos dados antes de pensar no resultado, que é a principal qualidade de um bom profissional de dados.</p>
      </div>
      <div class="pillar-row">
        <div class="pillar-card">
          <svg class="pillar-icon" width="42" height="42" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="24" cy="24" r="4"/><circle cx="10" cy="10" r="3"/><circle cx="38" cy="10" r="3"/><circle cx="10" cy="38" r="3"/><circle cx="38" cy="38" r="3"/><path d="M13 12l8 9M35 12l-8 9M13 36l8-9M35 36l-8-9"/></svg>
          <h3>Modelagem de Dados</h3>
          <ul>
            <li>Modelagem de dados e granularidade</li>
            <li>Normalização e desnormalização</li>
            <li>Esquema estrela (fato e dimensão)</li>
          </ul>
        </div>
        <div class="pillar-card">
          <svg class="pillar-icon" width="42" height="42" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M8 14a4 4 0 014-4h20l8 8v16a4 4 0 01-4 4H12a4 4 0 01-4-4V14z"/><circle cx="20" cy="26" r="6"/><path d="M32 18l3 3 3-3"/></svg>
          <h3>ETL — Power Query</h3>
          <ul>
            <li>Conectar, importar e tratar dados</li>
            <li>Trabalhar com colunas e fórmulas M</li>
            <li>Consultas: mesclar, acrescentar, agrupar</li>
          </ul>
        </div>
        <div class="pillar-card">
          <svg class="pillar-icon" width="42" height="42" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="7" y="30" width="7" height="11"/><rect x="20.5" y="20" width="7" height="21"/><rect x="34" y="10" width="7" height="31"/></svg>
          <h3>DAX &amp; Relatórios</h3>
          <ul>
            <li>Fórmulas DAX e medidas</li>
            <li>Criação e formatação de relatórios</li>
            <li>Compartilhamento e publicação</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <section style="background: var(--surface-2);">
    <div class="container">
      <div class="section-head">
        <p class="eyebrow">Pra quem é</p>
        <h2>Feito pra quem lida com dados no dia a dia</h2>
        <p>Não importa o cargo — o que importa é precisar transformar planilha em decisão. Veja se algum desses perfis é o seu.</p>
      </div>
      <div class="persona-row">
        <div class="persona-card">
          <span class="persona-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18M8 4v5"/></svg></span>
          <h3>Financeiro &amp; Contábil</h3>
          <p>Fecha planilhas de DRE, fluxo de caixa e conciliação todo mês na mão e quer automatizar o relatório de vez.</p>
        </div>
        <div class="persona-card">
          <span class="persona-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12l9-9 9 9M5 10v10h14V10"/></svg></span>
          <h3>Coordenador de área</h3>
          <p>Precisa consolidar números de vendas, estoque ou operação de vários times num painel só, sem depender de outra pessoa pra atualizar.</p>
        </div>
        <div class="persona-card">
          <span class="persona-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2L4 14h7l-1 8 9-12h-7l1-8z"/></svg></span>
          <h3>Em transição de carreira</h3>
          <p>Quer entrar ou migrar pra análise de dados e precisa de um projeto real pra mostrar no portfólio ou numa entrevista.</p>
        </div>
        <div class="persona-card">
          <span class="persona-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6"/></svg></span>
          <h3>Empreendedor(a)</h3>
          <p>Quer enxergar o próprio negócio em números — vendas, margem, estoque — sem depender de um analista pra montar cada relatório.</p>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="section-head center">
        <p class="eyebrow">Sua jornada no curso</p>
        <h2>Do primeiro conceito ao certificado</h2>
        <p>Cada módulo termina com uma avaliação — 70% de aproveitamento libera o próximo. No final, uma avaliação geral e o seu certificado de conclusão.</p>
      </div>
      <div class="journey">
        <div class="journey-track"></div>
        <div class="journey-step"><span class="n">01</span><span class="t">Modelagem de Dados</span></div>
        <div class="journey-step"><span class="n">02</span><span class="t">Perfil dos Dados</span></div>
        <div class="journey-step"><span class="n">03</span><span class="t">Power Query · Conectar</span></div>
        <div class="journey-step"><span class="n">04</span><span class="t">Power Query · Transformar</span></div>
        <div class="journey-step"><span class="n">05</span><span class="t">Laboratórios Práticos</span></div>
        <div class="journey-step"><span class="n">06</span><span class="t">Otimização de Modelo</span></div>
        <div class="journey-step"><span class="n">07</span><span class="t">Fórmulas DAX</span></div>
        <div class="journey-step"><span class="n">08</span><span class="t">Relatórios</span></div>
        <div class="journey-step"><span class="n">09</span><span class="t">Análise Avançada & IA</span></div>
        <div class="journey-step"><span class="n">10</span><span class="t">Laboratório DAX & DataViz</span></div>
        <div class="journey-step"><span class="n">11</span><span class="t">Dashboards & Governança</span></div>
        <div class="journey-step"><span class="n">12</span><span class="t">Estudo de Caso Final</span></div>
        <div class="journey-step final"><span class="n">🎓</span><span class="t">Encerramento & Avaliação Final</span></div>
      </div>
    </div>
  </section>

  <section style="background: var(--surface-2);">
    <div class="container">
      <div class="section-head">
        <p class="eyebrow">Feito para quem está aprendendo</p>
        <h2>Um curso desenhado para o aluno, do primeiro clique ao certificado</h2>
        <p>Apostila própria escrita pelo instrutor, avaliação a cada módulo para garantir que o conteúdo foi realmente absorvido, e um instrutor certificado pela Microsoft disponível para tirar dúvidas — pensado para quem está aprendendo Power BI do zero.</p>
      </div>
      <div class="proof-row">
        <div class="proof-card">
          <p class="proof-num">100% EAD</p>
          <p class="proof-t">acesso liberado assim que a matrícula é confirmada — estude quando e onde quiser</p>
        </div>
        <div class="proof-card">
          <p class="proof-num">12</p>
          <p class="proof-t">módulos em ordem lógica, do fundamento de modelagem até a avaliação final</p>
        </div>
        <div class="proof-card">
          <p class="proof-num">70%</p>
          <p class="proof-t">nota mínima em cada avaliação de módulo, garantindo que você domina o conteúdo antes de avançar</p>
        </div>
        <div class="proof-card">
          <p class="proof-num">🎓</p>
          <p class="proof-t">certificado de conclusão verificável, emitido ao final do curso</p>
        </div>
      </div>
      <p class="section-foot"><a class="btn btn-ghost on-light" href="/aula-gratis.php">Assistir uma aula grátis antes de decidir →</a></p>
    </div>
  </section>

  <section id="curriculo">
    <div class="container">
      <div class="section-head">
        <p class="eyebrow">Currículo completo</p>
        <h2>13 módulos, currículo completo</h2>
        <p>Estrutura baseada no cronograma oficial do curso, do primeiro conceito de modelagem até os laboratórios práticos guiados. A maior parte do curso é videoaula prática gravada na tela; alguns módulos são conteúdo em texto da apostila com referências à documentação oficial da Microsoft, e três módulos são laboratórios e estudos de caso — você aplica tudo sozinho, direto no Power BI Desktop, e só depois compara com a referência.</p>
      </div>

      <div class="curriculum-modules">
        <details class="module" open>
          <summary>
            <div class="module-title"><span class="module-num">01</span><h3>Fundamentos de Modelagem de Dados</h3></div>
            <div class="module-meta"><span>6 videoaulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <p class="module-desc">Antes de abrir o Power BI, você aprende a enxergar a estrutura por trás dos dados: por que uma única tabela no Excel tem limite, e como granularidade, normalização e o esquema estrela resolvem isso.</p>
            <ul class="lesson-list">
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Apresentação do curso</li>
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Introdução ao curso</li>
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Normalização e desnormalização</li>
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Modelagem de dados na prática</li>
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Esquema estrela (Star Schema)</li>
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Porque a Modelagem de Dados é Útil</li>
            </ul>
          </div>
        </details>

        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">02</span><h3>Perfil dos Dados</h3></div>
            <div class="module-meta"><span>1 videoaula</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <p class="module-desc">Antes de transformar qualquer coluna, você aprende a examinar os dados com as ferramentas de perfil do Power Query — qualidade, distribuição e estatísticas de cada coluna — para saber exatamente o que precisa ser corrigido.</p>
            <ul class="topic-list">
              <li>Identificar anomalias de dados</li>
              <li>Examinar estruturas de dados</li>
              <li>Propriedades da coluna (qualidade e distribuição)</li>
              <li>Estatísticas de dados</li>
            </ul>
          </div>
        </details>

        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">03</span><h3>Power Query — Conectando e Importando Dados</h3></div>
            <div class="module-meta"><span>7 videoaulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <p class="module-desc">O Power Query é a ferramenta de ETL do Excel e do Power BI: extrai, transforma e carrega dados de quase qualquer fonte. Aqui você conecta suas primeiras fontes e cria as primeiras consultas.</p>
            <ul class="lesson-list">
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Criando uma consulta</li>
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Introdução ao Power Query</li>
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Tipos de dados</li>
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Dados a partir de uma tabela ou intervalo</li>
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Importando um arquivo Excel</li>
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Consulta de uma pasta</li>
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Consulta de uma pasta do SharePoint</li>
            </ul>
          </div>
        </details>

        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">04</span><h3>Power Query — Transformação e Limpeza de Dados</h3></div>
            <div class="module-meta"><span>17 videoaulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <p class="module-desc">O módulo mais longo do curso: todas as transformações do dia a dia, coluna por coluna, até consultas mescladas e acrescentadas — a parte que, sem Power Query, você levaria horas fazendo com copiar/colar.</p>
            <ul class="lesson-list">
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Preenchimento de colunas</li>
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Dividir colunas</li>
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Dividir linhas</li>
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Colunas personalizadas</li>
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Coluna de exemplo</li>
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Mesclar colunas</li>
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Classificar e filtrar</li>
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Fórmula IF</li>
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Fórmula IF e AND</li>
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Fórmula AddDays</li>
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Fórmulas de texto</li>
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Coluna dinâmica (Pivot)</li>
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Transformar colunas em linhas (Unpivot)</li>
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Agrupar por</li>
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Acrescentar consultas — parte 1</li>
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Acrescentar consultas — parte 2</li>
              <li><span class="play"><svg viewBox="0 0 8 8" fill="currentColor"><path d="M0 0l8 4-8 4z"/></svg></span>Mesclar consultas</li>
            </ul>
          </div>
        </details>

        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">05</span><h3>Laboratórios Práticos de Power Query</h3></div>
            <div class="module-meta"><span>1 desafio completo</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <p class="module-desc">A prática direta, no formato estudo de caso: você recebe 12 planilhas de vendas de um ano inteiro, bagunçadas do jeito que chegam na vida real, e o que o resultado final precisa satisfazer — nada de passo a passo de clique. Um desafio único que encadeia todas as técnicas de Power Query vistas até aqui, do import de pasta até separar fato e dimensões, pronto pra resolver no seu próprio Power BI Desktop antes da avaliação final.</p>
            <ul class="topic-list">
              <li>Importar e combinar 12 arquivos mensais de uma pasta</li>
              <li>Corrigir tipos de dados e padronizar texto digitado à mão</li>
              <li>Calcular uma coluna nova a partir de outras já existentes</li>
              <li>Separar a base única em 1 tabela fato e 3 tabelas de dimensão</li>
            </ul>
          </div>
        </details>

        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">06</span><h3>Modelo de Dados &amp; Otimização de Desempenho</h3></div>
            <div class="module-meta"><span>2 videoaulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <p class="module-desc">Um modelo tecnicamente correto ainda pode ser lento. Este módulo cobre as técnicas que fazem um relatório carregar rápido mesmo com muitos dados.</p>
            <ul class="topic-list">
              <li>Remover linhas e colunas desnecessárias</li>
              <li>Identificar medidas, relacionamentos e visuais de mau desempenho</li>
              <li>Melhorar cardinalidade alterando tipos de dados</li>
              <li>Criar e gerenciar agregações</li>
              <li>Modos de armazenamento: Import, DirectQuery, Dual e Composite</li>
              <li>Dobra de consultas (query folding)</li>
            </ul>
          </div>
        </details>

        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">07</span><h3>Fórmulas DAX</h3></div>
            <div class="module-meta"><span>6 videoaulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <p class="module-desc">Com os dados já limpos, é hora de relacionar tabelas e escrever fórmulas. DAX (Data Analysis Expressions) é a linguagem por trás de toda medida no Power BI — aqui você aprende a ler e escrever a sua.</p>
            <ul class="topic-list">
              <li>O que é DAX e por que ele existe</li>
              <li>Definição de nomes, sintaxe e grupos de medidas</li>
              <li>Medidas implícitas x explícitas, formatação e medidas rápidas</li>
              <li>Variáveis e comentários em DAX</li>
              <li>Modelo de dados, contexto de filtro e contexto de linha</li>
              <li>Operadores aritméticos, de comparação, texto e lógicos</li>
              <li>Calculated columns x measures</li>
              <li>Funções matemáticas e estatísticas (SUM, AVERAGE, MAX, MIN, DIVIDE)</li>
              <li>Funções de contagem (COUNT, COUNTA, COUNTROWS, DISTINCTCOUNT, COUNTBLANK)</li>
              <li>Funções iteradoras: SUMX, AVERAGEX, MINX, MAXX</li>
              <li>Combinar funções e tratamento de erros (IFERROR)</li>
              <li>Funções lógicas (IF, AND, OR, SWITCH, SWITCH(TRUE()))</li>
              <li>Funções de texto (CONCATENATE, LEFT/MID/RIGHT, SUBSTITUTE, SEARCH)</li>
              <li>CALCULATE, FILTER, ALL e RELATED — o coração do DAX</li>
              <li>Funções de tabela (VALUES, DISTINCT, SUMMARIZE, ADDCOLUMNS)</li>
              <li>Funções de data e hora</li>
              <li>Inteligência de tempo: YTD, período anterior, DATESINPERIOD</li>
            </ul>
          </div>
        </details>

        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">08</span><h3>Criar e Enriquecer Relatórios</h3></div>
            <div class="module-meta"><span>2 videoaulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <p class="module-desc">Com o modelo pronto, é hora de transformá-lo em um relatório que alguém realmente vai usar: os visuais certos, formatados e conectados entre si.</p>
            <ul class="topic-list">
              <li>Adicionar e escolher o tipo de visualização certo</li>
              <li>Formatar e configurar visualizações</li>
              <li>Formatação condicional</li>
              <li>Segmentação de dados e filtros</li>
              <li>Visuais personalizados do AppSource, R e Python</li>
              <li>Indicadores (KPIs) e cards</li>
              <li>Dicas de ferramenta personalizadas (tooltips)</li>
              <li>Interações entre visuais e painel de seleção</li>
              <li>Navegação com marcadores (bookmarks) e botões</li>
              <li>Classificação, sincronização de segmentação e drillthrough</li>
              <li>Acessibilidade: texto alternativo, ordem de tabulação e contraste</li>
            </ul>
          </div>
        </details>

        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">09</span><h3>Análise Avançada &amp; Insights de IA</h3></div>
            <div class="module-meta"><span>2 videoaulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <p class="module-desc">Recursos que vão além do relatório estático, incluindo os visuais de inteligência artificial nativos do Power BI.</p>
            <ul class="topic-list">
              <li>Filtro Top N e resumo estatístico</li>
              <li>Linhas de referência (painel de análise) e Play Axis</li>
              <li>Recurso de Perguntas e Respostas (Q&amp;A)</li>
              <li>Insights rápidos</li>
              <li>Identificação de outliers, agrupamentos e binning</li>
              <li>Principais influenciadores</li>
              <li>Árvore de decomposição</li>
            </ul>
          </div>
        </details>

        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">10</span><h3>Laboratório Prático — DAX e DataViz</h3></div>
            <div class="module-meta"><span>1 laboratório guiado</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <p class="module-desc">Modelagem, Power Query, DAX, construção de relatório e os recursos de análise avançada do módulo anterior, tudo junto num único desafio: você recebe um modelo com as medidas já definidas por requisito (não a fórmula pronta) e reconstrói, página por página, um dashboard comercial completo — com KPIs, comparação ano a ano, mapa, segmentação de clientes e uma página de simulação "e se aumentássemos o preço?" usando parâmetro What-if.</p>
            <ul class="topic-list">
              <li>Modelo em esquema estrela com 5 dimensões + parâmetro What-if</li>
              <li>Grupos de medidas: base, percentuais, comparação ano anterior, acumulado, simulação</li>
              <li>5 páginas de relatório reconstruídas a partir de referência visual real</li>
              <li>Cada visual especificado por seus campos (eixo, valores, legenda, dicas de ferramenta)</li>
            </ul>
          </div>
        </details>

        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">11</span><h3>Dashboards, Publicação &amp; Governança</h3></div>
            <div class="module-meta"><span>3 videoaulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <p class="module-desc">Publicar, monitorar e manter o que foi construído — para que o relatório continue confiável meses depois de pronto.</p>
            <ul class="topic-list">
              <li>Workspaces, papéis de acesso e Apps</li>
              <li>Gateway de dados local</li>
              <li>Criar dashboards e fixar páginas ao vivo</li>
              <li>Visão mobile, tema do painel e alertas de dados</li>
              <li>Gerenciar acessos a dashboards</li>
              <li>Atualização programada de conjuntos de dados</li>
              <li>Segurança em nível de linha (RLS) e grupos de segurança</li>
              <li>Atualização incremental</li>
              <li>Promover e certificar conjuntos de dados</li>
              <li>Dependências de conjunto de dados e formato de dataset grande</li>
            </ul>
          </div>
        </details>

        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">12</span><h3>Estudo de Caso Final — Construa Seu Relatório do Zero</h3></div>
            <div class="module-meta"><span>2 exercícios guiados</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <p class="module-desc">O estudo de caso final da TECH SANTOS BR: dados brutos reais (Access + Excel) e uma lista de perguntas de negócio para responder — sem passo a passo de cliques. Você monta o modelo, as medidas e o relatório do zero, e só depois compara com o relatório de referência da própria empresa.</p>
            <ul class="topic-list">
              <li>Nível Básico — requisitos de modelo e o Relatório Receita</li>
              <li>Nível Final — medidas de comparação anual e mais 3 relatórios (Qtde Vendas, Lucro, Lucro por Segmento)</li>
            </ul>
          </div>
        </details>

      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="section-head">
        <p class="eyebrow">Instrutor</p>
        <h2>Quem ensina</h2>
      </div>
      <div class="instructor-panel">
        <div class="instructor-avatar">CS</div>
        <div>
          <p><strong style="color: var(--ink);">Clariston Santos</strong> é analista de Business Intelligence especializado em Power BI, fundador da TECH SANTOS BR e instrutor certificado pela Microsoft. Escreveu a apostila usada neste curso do zero, pensada para quem nunca usou Power BI, com foco em ensinar cada conceito de forma clara e progressiva até o certificado.</p>
        </div>
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
          <h3>Preciso já saber Power BI ou Excel avançado?</h3>
          <p>Não. O curso começa do zero, em modelagem de dados — só ajuda se você já usa Excel no dia a dia, porque parte das comparações partem daí.</p>
        </div>
        <div class="faq-item">
          <h3>Por quanto tempo tenho acesso ao curso?</h3>
          <p>Acesso vitalício. Depois de matriculado, o conteúdo fica disponível na Área do Aluno sem prazo de expiração.</p>
        </div>
        <div class="faq-item">
          <h3>O certificado tem validade?</h3>
          <p>O certificado de conclusão é emitido pela TECH SANTOS BR ao final do curso, sem data de expiração.</p>
        </div>
        <div class="faq-item">
          <h3>Preciso ter o Power BI instalado?</h3>
          <p>Sim, o Power BI Desktop — é gratuito, baixado direto do site da Microsoft, e funciona em qualquer Windows.</p>
        </div>
        <div class="faq-item">
          <h3>Quais as formas de pagamento?</h3>
          <p>Cartão de crédito (à vista ou parcelado em até 12x) ou Pix, direto pelo checkout do Mercado Pago.</p>
        </div>
        <div class="faq-item">
          <h3>E se eu ficar com dúvida no meio de um módulo?</h3>
          <p>É só chamar no WhatsApp ou mandar e-mail direto pro instrutor — o mesmo que escreveu a apostila e gravou as aulas.</p>
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
          <p class="lead">Acesso liberado automaticamente após a confirmação do pagamento — sem esperar turma fechar.</p>
          <?php if ($precoFormatado): ?>
          <p class="price">R$ <?= $precoFormatado ?><small>à vista ou parcelado em até 12x no cartão · acesso vitalício</small></p>
          <?php endif; ?>
          <div class="hero-cta">
            <a class="btn btn-primary" href="/comprar.php">Garantir minha vaga</a>
            <a class="btn btn-ghost" href="/aula-gratis.php">Assistir aula grátis antes</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="contact-panel">
        <div>
          <p class="eyebrow on-dark">Matrículas</p>
          <h2>Fale sobre a próxima turma</h2>
          <p class="lead">Turmas em grupo fechado, in company ou aulas individuais. Conte seu nível atual em Excel/Power BI e o formato que prefere, e retornamos com data e valores da próxima turma.</p>
          <div class="hero-cta">
            <a class="btn btn-primary" href="https://wa.me/5564992905785" target="_blank" rel="noopener">Chamar no WhatsApp</a>
            <a class="btn btn-ghost" href="mailto:claristonsantos@techsantos.com.br">Enviar e-mail</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<footer class="site footer-wide">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <a class="brand" href="index.html">
          <img src="assets/img/logo.jpg" alt="Tech Santos BR" />
          <span>TECH <em>SANTOS BR</em></span>
        </a>
        <p>Consultoria e treinamento em Power BI e Excel, com mais de 50 projetos de BI implementados. Itumbiara-GO, atendimento para todo o Brasil.</p>
        <div class="footer-social">
          <a href="https://www.instagram.com/tech_santos_br/" target="_blank" rel="noopener" aria-label="TECH SANTOS BR no Instagram">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>
          </a>
          <a href="https://www.facebook.com/techsantosbr/" target="_blank" rel="noopener" aria-label="TECH SANTOS BR no Facebook">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3l-.5 3H13v6.95c5.05-.5 9-4.76 9-9.95z"/></svg>
          </a>
          <a href="https://br.linkedin.com/company/techsantos-br" target="_blank" rel="noopener" aria-label="TECH SANTOS BR no LinkedIn">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor"><path d="M6.94 8.5H3.56V20h3.38V8.5zM5.25 3.5a1.96 1.96 0 100 3.92 1.96 1.96 0 000-3.92zM20.44 20h-3.37v-5.6c0-1.34-.03-3.06-1.87-3.06-1.87 0-2.16 1.46-2.16 2.96V20H9.68V8.5h3.24v1.57h.05c.45-.85 1.55-1.74 3.19-1.74 3.41 0 4.04 2.24 4.04 5.16V20z"/></svg>
          </a>
        </div>
      </div>
      <div class="footer-col">
        <h4>Curso</h4>
        <a href="/curso-power-bi.php">Curso completo de Power BI</a>
        <a href="/aula-gratis.php">Assistir aula grátis</a>
        <a href="/comprar.php">Matricule-se</a>
        <a href="/login.php">Área do Aluno</a>
      </div>
      <div class="footer-col">
        <h4>Empresa</h4>
        <a href="/sobre.html">Sobre</a>
        <a href="/servicos.html">Serviços</a>
        <a href="/treinamentos.html">Treinamentos</a>
        <a href="/projetos.html">Projetos</a>
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
      <a href="/admin/login.php">Login Administrador</a>
    </div>
  </div>
</footer>
<script src="assets/js/nav.js"></script>
</body>
</html>
