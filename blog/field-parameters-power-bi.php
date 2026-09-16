<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="canonical" href="https://techsantos.com.br/blog/field-parameters-power-bi.php" />
<meta property="og:type" content="article" />
<meta property="og:locale" content="pt_BR" />
<meta property="og:url" content="https://techsantos.com.br/blog/field-parameters-power-bi.php" />
<meta property="og:title" content="Field parameters no Power BI: um slicer que troca a métrica inteira do gráfico — TECH SANTOS BR" />
<meta property="og:description" content="Field parameters permitem trocar a métrica exibida num visual através de um slicer, sem duplicar gráficos para cada indicador. Veja como criar." />
<meta property="og:image" content="https://techsantos.com.br/assets/img/promo-curso-1.jpg" />
<meta name="twitter:card" content="summary_large_image" />
<title>Field parameters no Power BI: um slicer que troca a métrica inteira do gráfico — TECH SANTOS BR</title>
<meta name="description" content="Field parameters permitem trocar a métrica exibida num visual através de um slicer, sem duplicar gráficos para cada indicador. Veja como criar." />
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
    <div class="blog-meta">Power BI · Atualizado em 16/09/2026 · 4 min de leitura</div>
    <h1>Field parameters no Power BI: um slicer que troca a métrica inteira do gráfico</h1>

    <p>Um dashboard comercial raramente precisa de só uma métrica — receita, margem, ticket médio, quantidade de pedidos. O jeito mais comum de resolver isso é duplicar o mesmo gráfico uma vez pra cada indicador, o que infla o relatório e dificulta manutenção. Field parameters (parâmetros de campo) oferecem uma alternativa: um único visual, e um slicer que troca qual métrica ele está mostrando.</p>

    <div class="key-takeaways">
      <span class="kt-label">Resumo rápido</span>
      <ul>
        <li>Field parameters criam uma tabela especial de campos que pode ser usada como eixo, valor ou legenda de um visual.</li>
        <li>Um slicer ligado ao parâmetro permite que quem vê o relatório escolha qual métrica (ou dimensão) o visual exibe, sem duplicar gráficos.</li>
        <li>São criados em Modelagem > Novo Parâmetro > Campos, escolhendo as colunas ou medidas que entram como opções.</li>
        <li>Reduzem a quantidade de visuais repetidos num dashboard, facilitando manutenção e leitura.</li>
      </ul>
    </div>

    <h2>Como criar um field parameter</h2>
    <p>Em Modelagem > Novo parâmetro > Campos, selecione as medidas ou colunas que você quer deixar intercambiáveis — por exemplo, Receita, Margem e Ticket Médio. O Power BI cria uma tabela nova com essas opções e uma medida auxiliar. Depois, é só usar essa tabela no campo de valor do visual (um gráfico de colunas, por exemplo) e adicionar um slicer ligado à mesma tabela — trocar a seleção no slicer troca a métrica exibida no gráfico.</p>

    <video controls preload="metadata" playsinline>
          <source src="https://media.techsantos.com.br/reels/dica-powerbi-fieldparams.mp4" type="video/mp4">
    </video>

    <h2>Field parameters para eixo, não só pra métrica</h2>
    <p>O mesmo recurso funciona pra trocar a dimensão de um eixo, não só o valor — por exemplo, um slicer que alterna entre "vendas por vendedor", "vendas por produto" e "vendas por região" no mesmo gráfico de barras, sem precisar de três visuais separados fazendo a mesma coisa.</p>

    <h2>Quando vale a pena usar</h2>
    <p>Faz sentido quando várias métricas ou dimensões compartilham o mesmo tipo de visualização e o público do relatório se beneficia de comparar uma de cada vez, sem poluir a tela com vários gráficos simultâneos. Para métricas que precisam aparecer lado a lado o tempo todo, visuais separados continuam sendo a escolha certa.</p>

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
        <h3>Field parameters funcionam com qualquer tipo de visual?</h3>
        <p>Funcionam na maioria dos visuais que aceitam um campo de eixo ou valor, como gráficos de colunas, linhas e barras.</p>
      </div>
      <div class="faq-item">
        <h3>Dá para combinar field parameter de métrica com um de dimensão no mesmo relatório?</h3>
        <p>Sim, são recursos independentes — você pode ter um slicer pra métrica e outro pra dimensão, inclusive no mesmo visual.</p>
      </div>
      <div class="faq-item">
        <h3>Field parameters mudam o modelo de dados original?</h3>
        <p>Criam uma tabela nova no modelo especificamente para funcionar como parâmetro, sem alterar as tabelas de fato existentes.</p>
      </div>
      <div class="faq-item">
        <h3>É possível ordenar as opções do field parameter?</h3>
        <p>Sim, a ordem das opções pode ser ajustada editando a tabela de parâmetro criada, incluindo uma coluna de ordenação.</p>
      </div>
    </div>

    <p style="margin-top:2.5rem; font-size:0.82rem; color:var(--ink-faint);">
      Fontes: <a href="https://learn.microsoft.com/power-bi/create-reports/power-bi-field-parameters" target="_blank" rel="noopener">Microsoft Learn — Field parameters no Power BI</a>.
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
