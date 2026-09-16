<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="canonical" href="https://techsantos.com.br/blog/dataflows-gen2-fabric-etl-sem-codigo.php" />
<meta property="og:type" content="article" />
<meta property="og:locale" content="pt_BR" />
<meta property="og:url" content="https://techsantos.com.br/blog/dataflows-gen2-fabric-etl-sem-codigo.php" />
<meta property="og:title" content="Dataflows Gen2 no Microsoft Fabric: ETL sem escrever pipeline do zero — TECH SANTOS BR" />
<meta property="og:description" content="Dataflows Gen2 usa o Power Query pra transformar dados e envia direto pro Lakehouse, Warehouse ou outro destino, sem escrever um pipeline de ETL na mão." />
<meta property="og:image" content="https://techsantos.com.br/assets/img/promo-curso-1.jpg" />
<meta name="twitter:card" content="summary_large_image" />
<title>Dataflows Gen2 no Microsoft Fabric: ETL sem escrever pipeline do zero — TECH SANTOS BR</title>
<meta name="description" content="Dataflows Gen2 usa o Power Query pra transformar dados e envia direto pro Lakehouse, Warehouse ou outro destino, sem escrever um pipeline de ETL na mão." />
<link rel="icon" type="image/png" href="/assets/img/favicon-32.png" />
<link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png" />
<link rel="stylesheet" href="/assets/css/style.css" />
<?php require_once __DIR__ . '/../inc/meta-pixel.php'; ?>
<?php require_once __DIR__ . '/../inc/google-analytics.php'; ?>
</head>
<body>

<header class="site">
  <div class="nav-row">
    <a class="brand" href="/">
      <img src="/assets/img/logo.jpg" alt="Tech Santos BR" />
      <span>TECH <em>SANTOS BR</em></span>
    </a>
    <nav class="links">
      <a href="/">Home</a>
      <a href="/curso-power-bi.php">Curso</a>
      <a href="/blog/index.php" aria-current="page">Blog</a>
      <a href="/contato.html">Contato</a>
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
  <article class="blog-article">
    <div class="blog-meta">Microsoft Fabric · Atualizado em 16/09/2026 · 5 min de leitura</div>
    <h1>Dataflows Gen2 no Microsoft Fabric: ETL sem escrever pipeline do zero</h1>

    <p>Quem já usa Power Query no Excel ou no Power BI Desktop conhece a lógica: conectar na fonte, aplicar passos de limpeza, carregar o resultado. O Dataflows Gen2, no Microsoft Fabric, pega essa mesma lógica visual e escala pra um cenário de engenharia de dados — com a vantagem de escrever o resultado direto num destino, sem precisar montar um pipeline de código à parte.</p>

    <div class="key-takeaways">
      <span class="kt-label">Resumo rápido</span>
      <ul>
        <li>Dataflows Gen2 usa o mesmo mecanismo do Power Query (Editor de Consultas) para transformar dados via interface visual.</li>
        <li>Depois de transformado, o resultado pode ser enviado direto para um Lakehouse, Warehouse, Azure SQL Database ou outros destinos suportados.</li>
        <li>É útil para quem faz ETL recorrente sem escrever código de pipeline, mantendo a lógica de transformação legível e reutilizável.</li>
        <li>Pode ser orquestrado dentro de um Pipeline de Dados do Fabric, combinado com outras atividades.</li>
      </ul>
    </div>

    <h2>O que muda em relação ao Power Query tradicional</h2>
    <p>No Power BI Desktop, o Power Query carrega o resultado só pro modelo semântico do próprio relatório. No Dataflows Gen2, a transformação vira um item independente do workspace, com destino configurável — você decide se o resultado limpo vai para uma tabela de Lakehouse, para um Warehouse ou para outro banco compatível. Isso separa a etapa de preparação de dados da etapa de modelagem do relatório, permitindo reaproveitar a mesma consulta transformada em vários relatórios diferentes.</p>

    <video controls preload="metadata" playsinline>
          <source src="https://media.techsantos.com.br/reels/fabric-dataflows-gen2.mp4" type="video/mp4">
    </video>

    <h2>Quando vale a pena usar Dataflows Gen2</h2>
    <p>Faz sentido quando a transformação é repetitiva (a mesma limpeza de dados alimentando mais de um relatório ou processo), quando o time prefere interface visual a escrever código de pipeline, ou quando o destino final não é o próprio relatório, mas uma tabela compartilhada que outras equipes também vão consumir. Para uma transformação pontual, usada só dentro de um relatório específico, o Power Query direto no Power BI Desktop continua sendo suficiente.</p>

    <h2>Como o Dataflows Gen2 se encaixa num pipeline maior</h2>
    <p>Um Dataflow Gen2 pode ser uma das atividades de um Pipeline de Dados do Fabric, ao lado de cópias de dados, notebooks e outras etapas. Isso permite orquestrar: primeiro copiar dados brutos, depois rodar o Dataflow Gen2 pra limpar e padronizar, e só então liberar a tabela final pro consumo dos relatórios — tudo dentro do mesmo workspace do Fabric.</p>

    <div class="blog-cta">
      <h2>Quer aprender isso (e muito mais) com prática guiada?</h2>
      <p>O curso completo de Power BI da TECH SANTOS BR cobre Excel aplicado, modelagem de dados, Power Query e DAX — do zero até dashboards publicados de verdade.</p>
      <div class="hero-cta">
        <a class="btn btn-primary" href="/aula-gratis.php">Assistir aula grátis</a>
        <a class="btn btn-ghost" href="/curso-power-bi.php">Conhecer o curso completo</a>
      </div>
    </div>

    <h2>Perguntas frequentes</h2>
    <div class="blog-faq-grid">
      <div class="faq-item">
        <h3>Dataflows Gen2 substitui o Power Query do Power BI Desktop?</h3>
        <p>Não necessariamente — são complementares. O Dataflow Gen2 vale quando a transformação precisa virar um item compartilhado com destino próprio, fora do relatório.</p>
      </div>
      <div class="faq-item">
        <h3>Preciso saber programar para usar Dataflows Gen2?</h3>
        <p>Não. A transformação é feita pela mesma interface visual do Power Query (Editor poder de consulta), sem exigir código.</p>
      </div>
      <div class="faq-item">
        <h3>Para onde o Dataflows Gen2 pode enviar o resultado?</h3>
        <p>Para destinos como Lakehouse, Warehouse e Azure SQL Database, entre outros suportados pelo Fabric.</p>
      </div>
      <div class="faq-item">
        <h3>Dataflows Gen2 roda automaticamente ou preciso atualizar manualmente?</h3>
        <p>Pode ser agendado como qualquer outro item do Fabric, ou disparado como parte de um Pipeline de Dados.</p>
      </div>
    </div>

    <p style="margin-top:2.5rem; font-size:0.82rem; color:var(--ink-faint);">
      Fontes: <a href="https://learn.microsoft.com/fabric/data-factory/dataflows-gen2-overview" target="_blank" rel="noopener">Microsoft Learn — Visão geral do Dataflow Gen2</a>.
    </p>
  </article>
</main>

<footer class="site footer-wide">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <a class="brand" href="/">
          <img src="/assets/img/logo.jpg" alt="Tech Santos BR" />
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
        <a href="/blog/index.php">Blog</a>
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
<script src="/assets/js/nav.js"></script>
</body>
</html>
