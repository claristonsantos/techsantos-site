<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/cursos_catalogo.php';

$curso = curso_a_venda(db(), 'microsoft-fabric');
$precoCentavos = $curso['preco_centavos'] ?? null;
$precoFormatado = preco_formatado($precoCentavos ? (int)$precoCentavos : null);
$urlCompra = '/comprar.php?curso=microsoft-fabric';
$whatsMsg = rawurlencode('Olá! Estou vendo a página do curso de Microsoft Fabric e tenho uma dúvida antes de comprar.');
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="canonical" href="https://techsantos.com.br/curso-microsoft-fabric.php" />
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"Course","name":"Microsoft Fabric — Preparatório DP-600 e DP-700","description":"Curso completo de Microsoft Fabric alinhado às certificações DP-600 (Fabric Analytics Engineer) e DP-700 (Fabric Data Engineer): OneLake, lakehouse, warehouse, Data Factory, Spark, Real-Time Intelligence, modelos semânticos, DAX, Direct Lake, segurança e ciclo de vida.","provider":{"@type":"Organization","name":"TECH SANTOS BR","url":"https://techsantos.com.br/"},"inLanguage":"pt-BR","url":"https://techsantos.com.br/curso-microsoft-fabric.php"}
</script>
<title>Curso Microsoft Fabric — Preparatório DP-600 e DP-700 | TECH SANTOS BR</title>
<meta name="description" content="Curso completo de Microsoft Fabric em português, mapeado nas provas DP-600 e DP-700: 15 módulos, 82 aulas com teoria, imagens oficiais da Microsoft e áudio em todas as aulas, avaliações, 2 simulados finais e certificado." />
<meta property="og:type" content="website" />
<meta property="og:locale" content="pt_BR" />
<meta property="og:url" content="https://techsantos.com.br/curso-microsoft-fabric.php" />
<meta property="og:title" content="Curso Microsoft Fabric — Preparatório DP-600 e DP-700" />
<meta property="og:description" content="15 módulos, 82 aulas com teoria completa, imagens oficiais e áudio, avaliações em todos os módulos, 2 simulados finais e certificado. Com Clariston Santos." />
<meta property="og:image" content="https://techsantos.com.br/assets/img/curso-fabric/m01/arquitetura-fabric.png" />
<meta name="twitter:card" content="summary_large_image" />
<link rel="icon" type="image/png" href="assets/img/favicon-32.png" />
<link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png" />
<link rel="stylesheet" href="assets/css/style.css" />
<?php require_once __DIR__ . '/inc/meta-pixel.php'; ?>
<?php require_once __DIR__ . '/inc/google-analytics.php'; ?>
<?php if ($precoCentavos): ?>
<script>
fbq('track', 'ViewContent', {content_name: 'Curso Microsoft Fabric', currency: 'BRL', value: <?= json_encode(round($precoCentavos / 100, 2)) ?>});
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
      <a href="/curso-power-bi.php">Curso Power BI</a>
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
        <span>Curso 100% EAD — <strong>acesso imediato</strong> após a confirmação do pagamento. Estude no seu ritmo, em português.</span>
      </div>
      <p class="eyebrow on-dark">Preparatório DP-600 e DP-700 · Microsoft Fabric de ponta a ponta</p>
      <h1>Domine o <em>Microsoft Fabric</em> e prepare-se para as certificações DP-600 e DP-700.</h1>
      <p class="lead">Do OneLake ao Direct Lake: lakehouse, warehouse, pipelines, Spark, tempo real, modelos semânticos, DAX, segurança e CI/CD — com o conteúdo mapeado habilidade por habilidade nas listas oficiais das duas provas.</p>
      <?php if ($precoFormatado): ?>
      <div class="hero-offer" aria-label="Oferta do curso">
        <strong>R$ <?= $precoFormatado ?></strong>
        <span>à vista · cartão em até 12x ou Pix · acesso vitalício</span>
      </div>
      <?php endif; ?>
      <div class="hero-cta">
        <a class="btn btn-primary" href="<?= $urlCompra ?>" data-course-cta="fabric_hero_buy">Começar agora<?= $precoFormatado ? ' por R$ ' . $precoFormatado : '' ?></a>
        <a class="btn btn-ghost" href="#curriculo" data-course-cta="fabric_hero_curriculum">Ver o currículo</a>
      </div>
      <p class="hero-assurance">Acesso imediato · suporte direto com o instrutor · garantia de satisfação</p>
      <div class="kpi-row">
        <div class="kpi-tile"><div class="kpi-num">82</div><div class="kpi-label">aulas com teoria completa, em 15 módulos</div></div>
        <div class="kpi-tile"><div class="kpi-num">6h</div><div class="kpi-label">de áudio: cada aula também em modo podcast</div></div>
        <div class="kpi-tile"><div class="kpi-num">192</div><div class="kpi-label">questões: avaliação em cada módulo e 2 simulados finais</div></div>
        <div class="kpi-tile"><div class="kpi-num">160+</div><div class="kpi-label">imagens oficiais da documentação da Microsoft</div></div>
      </div>
      <div class="fab-shot"><img src="/assets/img/curso-fabric/m01/arquitetura-fabric.png" alt="Visão geral da plataforma Microsoft Fabric" loading="lazy"></div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="section-head">
        <p class="eyebrow">As duas certificações</p>
        <h2>Um curso, duas provas da Microsoft</h2>
        <p>O currículo foi montado a partir das listas oficiais de habilidades cobradas nas provas. Cada habilidade tem pelo menos uma aula, e cada aula termina com a seção “Como isso cai na prova”.</p>
      </div>
      <div class="exam-row">
        <div class="exam-card">
          <span class="code">DP-600</span>
          <h3>Fabric Analytics Engineer Associate</h3>
          <ul>
            <li>Manter uma solução de análise: segurança, governança e ciclo de vida</li>
            <li>Preparar dados: obter, transformar e consultar com SQL, KQL e DAX</li>
            <li>Modelos semânticos: design, DAX, Direct Lake e otimização</li>
          </ul>
        </div>
        <div class="exam-card">
          <span class="code">DP-700</span>
          <h3>Fabric Data Engineer Associate</h3>
          <ul>
            <li>Implementar e gerenciar a solução: workspaces, segurança, orquestração e CI/CD</li>
            <li>Ingerir e transformar dados em lote e em streaming</li>
            <li>Monitorar, resolver erros e otimizar</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <section style="background: var(--surface-2);">
    <div class="container">
      <div class="section-head">
        <p class="eyebrow">Para quem é este curso</p>
        <h2>Para quem trabalha com dados e quer dar o próximo passo</h2>
        <p>Você não precisa conhecer o Fabric. Ajuda já ter usado Power BI, Excel avançado ou SQL — o curso parte dos fundamentos da plataforma e vai até o nível das provas.</p>
      </div>
      <div class="persona-row">
        <div class="persona-card">
          <span class="persona-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="12" width="4" height="8"/><rect x="10" y="7" width="4" height="13"/><rect x="17" y="3" width="4" height="17"/></svg></span>
          <h3>Analista de Power BI</h3>
          <p>Já domina relatórios e quer entender lakehouse, Direct Lake e o resto da plataforma — e ter a DP-600 no currículo.</p>
        </div>
        <div class="persona-card">
          <span class="persona-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><ellipse cx="12" cy="6" rx="8" ry="3"/><path d="M4 6v12c0 1.7 3.6 3 8 3s8-1.3 8-3V6"/></svg></span>
          <h3>Engenheiro ou analista de dados</h3>
          <p>Trabalha com SQL, Azure ou Databricks e precisa de pipelines, Spark e tempo real no Fabric — rumo à DP-700.</p>
        </div>
        <div class="persona-card">
          <span class="persona-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2L4 14h7l-1 8 9-12h-7l1-8z"/></svg></span>
          <h3>Em transição de carreira</h3>
          <p>Quer uma certificação Microsoft reconhecida para entrar na área de dados, com um projeto final para mostrar.</p>
        </div>
        <div class="persona-card">
          <span class="persona-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6"/></svg></span>
          <h3>Líder de BI e dados</h3>
          <p>Vai adotar o Fabric na empresa e precisa decidir arquitetura, capacidade, segurança e governança com segurança.</p>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="section-head">
        <p class="eyebrow">Como o curso funciona</p>
        <h2>Leia, ouça, pratique e teste</h2>
      </div>
      <div class="proof-row">
        <div class="proof-card">
          <p class="proof-num">Texto</p>
          <p class="proof-t">teoria completa em cada aula, com as imagens oficiais da documentação da Microsoft e os links para o Microsoft Learn</p>
        </div>
        <div class="proof-card">
          <p class="proof-num">Áudio</p>
          <p class="proof-t">cada aula também em modo podcast, com velocidade ajustável — dá para estudar no trânsito</p>
        </div>
        <div class="proof-card">
          <p class="proof-num">Prática</p>
          <p class="proof-t">exemplos de código em PySpark, T-SQL, KQL e DAX e um projeto final em formato de estudo de caso</p>
        </div>
        <div class="proof-card">
          <p class="proof-num">🎓</p>
          <p class="proof-t">avaliação em cada módulo, 2 simulados finais no estilo das provas e certificado de conclusão verificável</p>
        </div>
      </div>
      <p class="honest-note"><strong>Sobre as videoaulas:</strong> o curso já está completo em texto, imagens e áudio. As videoaulas estão sendo gravadas e entram nas próprias aulas conforme ficam prontas, sem custo adicional para quem já é aluno.</p>
    </div>
  </section>

  <section id="curriculo" style="background: var(--surface-2);">
    <div class="container">
      <div class="section-head">
        <p class="eyebrow">Currículo completo</p>
        <h2>15 módulos + 2 simulados finais</h2>
        <p>Do básico da plataforma ao nível das provas, na ordem em que as coisas se conectam no dia a dia.</p>
      </div>
      <div class="curriculum-modules">
        <details class="module" open>
          <summary>
            <div class="module-title"><span class="module-num">01</span><h3>Fundamentos do Microsoft Fabric e configuração do ambiente</h3></div>
            <div class="module-meta"><span>7 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>O que é o Microsoft Fabric</li>
              <li>Licenças e capacidades</li>
              <li>Tenant, capacidade, workspace e itens</li>
              <li>Domínios e subdomínios</li>
              <li>Configurações do workspace: Spark, OneLake e Apache Airflow</li>
              <li>Descobrir dados: catálogo do OneLake e hub Real-Time</li>
              <li>Escolher o armazenamento certo</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">02</span><h3>OneLake: o data lake único do Fabric</h3></div>
            <div class="module-meta"><span>6 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>OneLake: um lago para toda a empresa</li>
              <li>Tabelas Delta, arquivos Parquet e a pasta Tables × Files</li>
              <li>Atalhos (shortcuts) do OneLake</li>
              <li>Espelhamento (mirroring)</li>
              <li>Segurança do OneLake</li>
              <li>Integração do OneLake com Eventhouse e modelos semânticos</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">03</span><h3>Lakehouse, arquitetura medalhão e modelagem dimensional</h3></div>
            <div class="module-meta"><span>7 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>O lakehouse: criação, estrutura e esquemas</li>
              <li>Formas de carregar dados no lakehouse</li>
              <li>O ponto de extremidade de análise SQL</li>
              <li>Arquitetura medalhão: bronze, prata e ouro</li>
              <li>Modelagem dimensional: fatos, dimensões e SCD</li>
              <li>Preparar e carregar um modelo dimensional</li>
              <li>Manutenção e otimização de tabelas Delta</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">04</span><h3>Data Factory: pipelines, orquestração e cargas</h3></div>
            <div class="module-meta"><span>7 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Data Factory no Fabric: itens, conexões e gateways</li>
              <li>Pipelines: atividades, dependências e tratamento de erros</li>
              <li>Atividade Copiar e trabalho de cópia</li>
              <li>Parâmetros, variáveis e expressões dinâmicas</li>
              <li>Executar, agendar, disparar por evento e monitorar</li>
              <li>Cargas completas e incrementais</li>
              <li>Escolher entre pipeline, Dataflow Gen2, notebook e trabalho de cópia</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">05</span><h3>Dataflows Gen2 e o editor de consultas visuais</h3></div>
            <div class="module-meta"><span>7 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Dataflow Gen2: o Power Query dentro do Fabric</li>
              <li>Transformações essenciais: filtrar, combinar, agrupar e remodelar</li>
              <li>Qualidade de dados: duplicados, ausentes, nulos e erros</li>
              <li>Destinos de dados e preparo (staging)</li>
              <li>Desempenho: dobragem de consultas, cópia rápida, atualização incremental e parâmetros</li>
              <li>Editor de consultas visuais no warehouse</li>
              <li>Monitorar e resolver erros do Dataflow Gen2</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">06</span><h3>Notebooks, Spark e streaming estruturado</h3></div>
            <div class="module-meta"><span>6 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Spark no Fabric e o notebook</li>
              <li>Transformar dados com PySpark e Spark SQL</li>
              <li>Funções de janela, duplicados, nulos e MERGE no Spark</li>
              <li>Orquestrar notebooks: notebookutils, ambientes e definições de trabalho do Spark</li>
              <li>Streaming estruturado do Spark</li>
              <li>Monitorar, depurar e otimizar o Spark</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">07</span><h3>Data Warehouse e T-SQL</h3></div>
            <div class="module-meta"><span>6 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>O warehouse do Fabric: tabelas, tipos e limitações</li>
              <li>Carregar dados no warehouse: COPY INTO, CTAS, INSERT e OPENROWSET</li>
              <li>Selecionar, filtrar e agregar dados com T-SQL</li>
              <li>Exibições, funções, procedimentos, MERGE e transações</li>
              <li>Viagem no tempo, clones e restauração</li>
              <li>Desempenho, monitoramento e erros do warehouse</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">08</span><h3>Real-Time Intelligence: Eventstream, Eventhouse e KQL</h3></div>
            <div class="module-meta"><span>6 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Real-Time Intelligence: componentes e escolha do mecanismo de streaming</li>
              <li>Eventstream: fontes, transformações e destinos</li>
              <li>Eventhouse e banco de dados KQL: políticas, OneLake e atalhos</li>
              <li>KQL: selecionar, filtrar, agregar e janelas</li>
              <li>Transformar dados no eventhouse: funções, políticas de atualização e exibições materializadas</li>
              <li>Painéis em tempo real, Activator, monitoramento e otimização</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">09</span><h3>Modelos semânticos: design</h3></div>
            <div class="module-meta"><span>5 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Modelos semânticos no Fabric e modos de armazenamento</li>
              <li>Esquema estrela no modelo semântico</li>
              <li>Relacionamentos: cardinalidade, direção, ponte e muitos-para-muitos</li>
              <li>Grupos de cálculo, formato dinâmico e parâmetros de campo</li>
              <li>Modelos compostos, agregações e formato de modelo grande</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">10</span><h3>DAX para a prova</h3></div>
            <div class="module-meta"><span>5 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Fundamentos: medidas, contextos, CALCULATE e variáveis</li>
              <li>Funções de filtragem de tabela</li>
              <li>Iteradores, inteligência de tempo e funções de janela</li>
              <li>Funções de informação e tratamento de brancos</li>
              <li>Consultas DAX: selecionar, filtrar e agregar</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">11</span><h3>Direct Lake e otimização de modelos</h3></div>
            <div class="module-meta"><span>4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Direct Lake: como funciona e as duas variantes</li>
              <li>Fallback para DirectQuery e desempenho do Direct Lake</li>
              <li>Atualização incremental em modelos semânticos</li>
              <li>Otimizar consultas, visuais e DAX</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">12</span><h3>Segurança e governança</h3></div>
            <div class="module-meta"><span>4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Acesso no workspace e no item</li>
              <li>Segurança granular no warehouse: GRANT, RLS, CLS e máscara dinâmica</li>
              <li>Segurança no modelo semântico e no OneLake</li>
              <li>Governança: rótulos de confidencialidade, endosso e auditoria</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">13</span><h3>Ciclo de vida: Git, .pbip, pipelines de implantação e XMLA</h3></div>
            <div class="module-meta"><span>4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Controle de versão: integração do workspace com o Git</li>
              <li>Pipelines de implantação</li>
              <li>Projetos do Power BI (.pbip) e projetos de banco de dados</li>
              <li>Ponto de extremidade XMLA, ativos reutilizáveis e análise de impacto</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">14</span><h3>Monitoramento, erros e otimização</h3></div>
            <div class="module-meta"><span>4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Monitorar: hub de monitoramento, monitoramento do workspace e alertas</li>
              <li>Monitorar a atualização de modelos semânticos</li>
              <li>Capacidade: consumo, suavização, limitação e o aplicativo Capacity Metrics</li>
              <li>Guia de erros e de otimização por item</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">15</span><h3>Projeto final e preparação para as provas</h3></div>
            <div class="module-meta"><span>2 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Projeto final: plataforma de dados da Distribuidora Araguaia</li>
              <li>Guia das provas DP-600 e DP-700 e plano de estudo</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">🎓</span><h3>Simulado final · DP-600</h3></div>
            <div class="module-meta"><span>1 aula</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Como fazer o simulado DP-600</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">🎓</span><h3>Simulado final · DP-700</h3></div>
            <div class="module-meta"><span>1 aula</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Como fazer o simulado DP-700</li>
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
          <p><strong style="color: var(--ink);">Clariston Santos</strong> é analista de Business Intelligence, fundador da TECH SANTOS BR e instrutor certificado pela Microsoft, com mais de 50 projetos de BI implementados. Escreveu este curso a partir da documentação oficial do Microsoft Fabric e das listas de habilidades das provas DP-600 e DP-700.</p>
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
          <h3>O curso tem vídeo?</h3>
          <p>O conteúdo completo está em texto com imagens oficiais e em áudio (modo podcast) em todas as aulas. As videoaulas estão sendo gravadas e entram no curso conforme ficam prontas, sem custo extra para quem já é aluno.</p>
        </div>
        <div class="faq-item">
          <h3>O curso é suficiente para passar nas provas?</h3>
          <p>O conteúdo cobre todas as habilidades das listas oficiais da DP-600 e da DP-700, com avaliações e simulados no estilo das provas. A aprovação depende do seu estudo; recomendamos passar com folga nos simulados e fazer também as avaliações práticas gratuitas do Microsoft Learn antes de agendar.</p>
        </div>
        <div class="faq-item">
          <h3>A prova está incluída?</h3>
          <p>Não. A prova é agendada e paga diretamente na Microsoft (Pearson VUE). O curso prepara para as duas provas e emite o certificado de conclusão da TECH SANTOS BR.</p>
        </div>
        <div class="faq-item">
          <h3>Preciso ter o Microsoft Fabric para praticar?</h3>
          <p>A Microsoft oferece uma avaliação gratuita do Fabric; o primeiro módulo mostra como ativar e usar para os exercícios.</p>
        </div>
        <div class="faq-item">
          <h3>Por quanto tempo tenho acesso?</h3>
          <p>Acesso vitalício, incluindo as atualizações do conteúdo e as videoaulas que forem adicionadas.</p>
        </div>
        <div class="faq-item">
          <h3>Já sou aluno do curso de Power BI. Como compro?</h3>
          <p>Entre na Área do Aluno: o curso de Fabric aparece em “Outros cursos”, com compra direta. Depois do pagamento ele aparece junto do seu curso atual, com o mesmo login.</p>
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
            <a class="btn btn-primary" href="<?= $urlCompra ?>" data-course-cta="fabric_final_buy">Começar agora</a>
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
        <a href="/curso-microsoft-fabric.php">Microsoft Fabric (DP-600 e DP-700)</a>
        <a href="/curso-excel.php">Excel do zero ao avançado (MO-210 e MO-211)</a>
        <a href="/curso-power-bi.php">Curso completo de Power BI</a>
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
