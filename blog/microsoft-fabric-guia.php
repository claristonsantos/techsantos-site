<?php declare(strict_types=1); ?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Microsoft Fabric: guia para quem já usa Power BI | TECH SANTOS BR</title>
<meta name="description" content="Entenda o que é Microsoft Fabric, OneLake, Lakehouse, Dataflow Gen2, pipelines e como o Power BI se conecta à plataforma." />
<link rel="canonical" href="https://techsantos.com.br/blog/microsoft-fabric-guia.php" />
<meta property="og:type" content="article" />
<meta property="og:locale" content="pt_BR" />
<meta property="og:url" content="https://techsantos.com.br/blog/microsoft-fabric-guia.php" />
<meta property="og:title" content="Microsoft Fabric: guia para quem já usa Power BI" />
<meta property="og:description" content="OneLake, Lakehouse, Dataflow Gen2, pipelines e Power BI explicados em uma arquitetura de ponta a ponta." />
<meta property="og:image" content="https://learn.microsoft.com/pt-br/fabric/fundamentals/media/microsoft-fabric-overview/fabric-architecture.png" />
<meta name="twitter:card" content="summary_large_image" />
<link rel="icon" type="image/png" href="/assets/img/favicon-32.png" />
<link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png" />
<link rel="stylesheet" href="/assets/css/style.css" />
<?php require_once __DIR__ . '/../inc/meta-pixel.php'; ?>
<?php require_once __DIR__ . '/../inc/google-analytics.php'; ?>
<script type="application/ld+json">
{
  "@context":"https://schema.org",
  "@type":"Article",
  "headline":"Microsoft Fabric: guia para quem já usa Power BI",
  "description":"Entenda OneLake, Lakehouse, Dataflow Gen2, pipelines e a integração com Power BI.",
  "datePublished":"2026-08-12",
  "dateModified":"2026-08-12",
  "inLanguage":"pt-BR",
  "author":{"@type":"Person","name":"Clariston Santos"},
  "publisher":{"@type":"Organization","name":"TECH SANTOS BR","url":"https://techsantos.com.br/"},
  "mainEntityOfPage":"https://techsantos.com.br/blog/microsoft-fabric-guia.php"
}
</script>
<script type="application/ld+json">
{
  "@context":"https://schema.org",
  "@type":"FAQPage",
  "mainEntity":[
    {"@type":"Question","name":"Microsoft Fabric substitui o Power BI?","acceptedAnswer":{"@type":"Answer","text":"Não. O Power BI é uma das experiências integradas ao Microsoft Fabric e continua sendo a camada de modelagem semântica, análise e visualização."}},
    {"@type":"Question","name":"Qual é a diferença entre Dataflow Gen2 e pipeline?","acceptedAnswer":{"@type":"Answer","text":"O Dataflow Gen2 transforma dados com Power Query e uma interface de baixo código. O pipeline orquestra atividades, cópias, consultas, notebooks e execuções de dataflows em uma sequência automatizada."}},
    {"@type":"Question","name":"É necessário ter capacidade do Fabric?","acceptedAnswer":{"@type":"Answer","text":"Para usar os recursos do Fabric é necessário um workspace com Fabric habilitado e uma capacidade compatível, que pode incluir uma capacidade de avaliação conforme as regras vigentes da Microsoft."}}
  ]
}
</script>
</head>
<body>
<header class="site">
  <div class="nav-row">
    <a class="brand" href="/"><img src="/assets/img/logo.jpg" alt="Tech Santos BR" /><span>TECH <em>SANTOS BR</em></span></a>
    <nav class="links">
      <a href="/">Home</a><a href="/curso-power-bi.php">Curso</a><a href="/blog/" aria-current="page">Blog</a><a href="/contato.html">Contato</a><a href="/login.php">Área do Aluno</a>
    </nav>
    <div class="nav-actions">
      <a class="btn btn-primary desktop-only" href="https://wa.me/5564992905785" target="_blank" rel="noopener">Falar no WhatsApp</a>
      <button class="nav-toggle" aria-label="Abrir menu" aria-expanded="false"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg></button>
    </div>
  </div>
</header>

<main>
  <article class="blog-article">
    <div class="blog-meta">Microsoft Fabric · Publicado em 12/08/2026 · 9 min de leitura</div>
    <h1>Microsoft Fabric: o guia de transição para quem já usa Power BI</h1>
    <p>Se você já trata dados no Power Query, cria modelos no Power BI e publica relatórios, o Microsoft Fabric não é um produto completamente separado. Ele amplia esse trabalho para uma plataforma de dados de ponta a ponta: ingestão, transformação, armazenamento, engenharia, análise em tempo real, governança e relatórios no mesmo ambiente.</p>

    <div class="key-takeaways">
      <span class="kt-label">Resumo rápido</span>
      <ul>
        <li>O Fabric é uma plataforma SaaS de análise que reúne diferentes cargas de trabalho sobre o OneLake.</li>
        <li>Dataflow Gen2 usa a experiência do Power Query para transformar e entregar dados a destinos como Lakehouse e Warehouse.</li>
        <li>Pipelines orquestram cópias, consultas, notebooks, procedimentos e dataflows.</li>
        <li>O Power BI permanece na camada de modelo semântico, relatórios e consumo dos indicadores.</li>
      </ul>
    </div>

    <h2>O que é Microsoft Fabric</h2>
    <p>Segundo a documentação oficial, o Microsoft Fabric é uma plataforma de análise para fluxos de dados de ponta a ponta. Experiências como Data Factory, Engenharia de Dados, Data Warehouse, Inteligência em Tempo Real e Power BI compartilham serviços de armazenamento, computação, segurança e governança.</p>
    <p>Na prática, isso reduz a necessidade de montar integrações independentes entre várias ferramentas. Uma solução pode ingerir dados com Data Factory, armazená-los no OneLake, transformá-los em um Lakehouse ou Warehouse e disponibilizá-los para análise no Power BI dentro da mesma plataforma.</p>

    <figure style="margin:2rem 0;">
      <img src="https://learn.microsoft.com/pt-br/fabric/fundamentals/media/microsoft-fabric-overview/fabric-architecture.png" alt="Arquitetura oficial do Microsoft Fabric mostrando as cargas de trabalho sobre OneLake, governança e serviços compartilhados" loading="lazy" style="width:100%;height:auto;border:1px solid var(--line);border-radius:8px;background:#fff;" />
      <figcaption style="font-size:.78rem;color:var(--ink-faint);margin-top:.6rem;">Arquitetura oficial do Microsoft Fabric. Fonte: Microsoft Learn.</figcaption>
    </figure>

    <h2>OneLake: a base compartilhada</h2>
    <p>O OneLake é o data lake lógico central do Fabric. Ele funciona como uma camada de armazenamento comum para que diferentes cargas de trabalho acessem os mesmos dados sem criar cópias desnecessárias. Workspaces organizam os itens, e cada workspace pode conter Lakehouses, Warehouses, modelos semânticos, notebooks, pipelines e outros artefatos.</p>
    <p>Atalhos do OneLake também podem oferecer acesso a dados armazenados em outros locais, inclusive serviços de nuvem compatíveis, sem exigir que toda informação seja fisicamente migrada antes de ser analisada.</p>

    <h2>Lakehouse e Data Warehouse: quando usar cada um</h2>
    <p>O Lakehouse combina a flexibilidade de arquivos de um data lake com recursos de consulta e organização de tabelas. É uma escolha natural quando a solução usa arquivos, tabelas Delta, notebooks, Spark ou processos de engenharia de dados.</p>
    <p>O Warehouse oferece uma experiência mais orientada a SQL, estrutura relacional e desenvolvimento analítico tradicional. A decisão não deve começar pelo nome da ferramenta, mas pelo perfil da equipe, volume, origem dos dados, necessidade de SQL ou Spark e forma de consumo.</p>

    <h2>Dataflow Gen2: Power Query dentro do Fabric</h2>
    <p>O Dataflow Gen2 leva a experiência de transformação do Power Query para o Data Factory no Fabric. Ele permite conectar fontes, limpar, combinar e enriquecer dados em uma interface de baixo código, além de gravar o resultado em destinos como tabelas e arquivos de Lakehouse, Warehouse, bancos SQL e outros destinos compatíveis.</p>
    <p>Para quem vem do Power BI, a linguagem de transformações é familiar. A principal mudança é arquitetural: o fluxo passa a fazer parte de uma solução de dados centralizada, reutilizável e monitorada, em vez de existir apenas dentro de um arquivo de relatório.</p>

    <h2>Pipelines: automação e orquestração</h2>
    <p>Pipeline não é outra forma de escrever Power Query. Ele organiza atividades em uma sequência operacional. Um pipeline pode copiar dados, executar uma consulta SQL, chamar um procedimento armazenado, executar um notebook e disparar um Dataflow Gen2.</p>
    <p>Também pode trabalhar com agendamentos, parâmetros, dependências, condições e repetições. Um exemplo seria: copiar arquivos de vendas, executar o Dataflow Gen2, validar a carga e somente depois atualizar a camada usada pelo relatório.</p>

    <h2>Onde entra o Power BI</h2>
    <p>O Power BI continua responsável por modelos semânticos, medidas DAX, relatórios, dashboards e consumo das análises. A diferença é que ele pode trabalhar sobre uma fundação de dados mais integrada. Em vez de cada relatório repetir ingestão e tratamento, a empresa pode centralizar essas etapas e reutilizar dados preparados.</p>
    <p>Por isso, uma boa base de Power Query, modelagem dimensional, relacionamentos e DAX continua sendo relevante para entrar no Fabric. A plataforma aumenta o alcance do projeto, mas não elimina os fundamentos.</p>

    <h2>Um fluxo de projeto de ponta a ponta</h2>
    <ol>
      <li><strong>Ingestão:</strong> conectar ERP, arquivos, APIs ou bancos com Data Factory.</li>
      <li><strong>Armazenamento:</strong> organizar dados brutos e tratados no OneLake.</li>
      <li><strong>Transformação:</strong> usar Dataflow Gen2, SQL ou notebooks conforme o cenário.</li>
      <li><strong>Orquestração:</strong> automatizar dependências e horários com pipelines.</li>
      <li><strong>Modelagem:</strong> construir um modelo semântico com relacionamentos e medidas.</li>
      <li><strong>Consumo:</strong> publicar relatórios Power BI e aplicar segurança e governança.</li>
    </ol>

    <div class="blog-cta">
      <h2>Quer construir a base antes de avançar para o Fabric?</h2>
      <p>Comece por Power Query, modelagem dimensional, relacionamentos e DAX. As três primeiras aulas do curso Power BI Completo estão disponíveis gratuitamente.</p>
      <div class="hero-cta">
        <a class="btn btn-primary" href="/aula-gratis.php?utm_source=blog&amp;utm_medium=organic&amp;utm_campaign=fabric_pilar">Assistir 3 aulas grátis</a>
        <a class="btn btn-ghost" href="/curso-power-bi.php?utm_source=blog&amp;utm_medium=organic&amp;utm_campaign=fabric_pilar">Conhecer o curso</a>
      </div>
    </div>

    <h2>Perguntas frequentes</h2>
    <div class="blog-faq-grid">
      <div class="faq-item"><h3>Microsoft Fabric substitui o Power BI?</h3><p>Não. O Power BI é uma das experiências integradas ao Fabric e continua sendo usado para modelagem semântica, análise e visualização.</p></div>
      <div class="faq-item"><h3>Qual é a diferença entre Dataflow Gen2 e pipeline?</h3><p>Dataflow Gen2 transforma dados com Power Query. Pipeline coordena a execução de diferentes atividades, inclusive dataflows, cópias, consultas e notebooks.</p></div>
      <div class="faq-item"><h3>Preciso saber programar?</h3><p>Não para começar. Dataflow Gen2 e o designer de pipelines oferecem experiências de baixo código. SQL, Python e Spark tornam-se úteis em cenários mais avançados.</p></div>
      <div class="faq-item"><h3>É necessário ter capacidade do Fabric?</h3><p>Sim. O workspace precisa estar associado a uma capacidade compatível ou avaliação disponível, conforme as regras atuais da Microsoft.</p></div>
    </div>

    <p style="margin-top:2.5rem;font-size:.82rem;color:var(--ink-faint);">
      Fontes oficiais: <a href="https://learn.microsoft.com/pt-br/fabric/fundamentals/microsoft-fabric-overview" target="_blank" rel="noopener">visão geral do Microsoft Fabric</a>,
      <a href="https://learn.microsoft.com/pt-br/fabric/data-engineering/lakehouse-overview" target="_blank" rel="noopener">visão geral do Lakehouse</a>,
      <a href="https://learn.microsoft.com/pt-br/fabric/data-factory/dataflows-gen2-overview" target="_blank" rel="noopener">Dataflow Gen2</a> e
      <a href="https://learn.microsoft.com/pt-br/fabric/data-factory/data-factory-overview" target="_blank" rel="noopener">Data Factory no Fabric</a>. Consultadas em 12/08/2026.
    </p>
  </article>
</main>

<footer class="site footer-wide">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand"><a class="brand" href="/"><img src="/assets/img/logo.jpg" alt="Tech Santos BR" /><span>TECH <em>SANTOS BR</em></span></a><p>Consultoria e treinamento em Power BI, Excel e Microsoft Fabric. Itumbiara-GO, atendimento para todo o Brasil.</p></div>
      <div class="footer-col"><h4>Curso</h4><a href="/curso-power-bi.php">Curso completo de Power BI</a><a href="/aula-gratis.php">Assistir aula grátis</a><a href="/comprar.php">Matricule-se</a></div>
      <div class="footer-col"><h4>Empresa</h4><a href="/sobre.html">Sobre</a><a href="/servicos.html">Serviços</a><a href="/projetos.html">Projetos</a><a href="/blog/">Blog</a></div>
      <div class="footer-col"><h4>Contato</h4><a href="mailto:claristonsantos@techsantos.com.br">claristonsantos@techsantos.com.br</a><a href="https://wa.me/5564992905785" target="_blank" rel="noopener">(64) 99290-5785</a><span>Itumbiara-GO</span></div>
    </div>
    <div class="footer-bottom"><span>© 2026 TECH SANTOS BR · CNPJ 41.135.509/0001-29</span></div>
  </div>
</footer>
<script src="/assets/js/nav.js"></script>
</body>
</html>
