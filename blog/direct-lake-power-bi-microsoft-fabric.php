<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="canonical" href="https://techsantos.com.br/blog/direct-lake-power-bi-microsoft-fabric.php" />
<meta property="og:type" content="article" />
<meta property="og:locale" content="pt_BR" />
<meta property="og:url" content="https://techsantos.com.br/blog/direct-lake-power-bi-microsoft-fabric.php" />
<meta property="og:title" content="Direct Lake no Power BI: o modo de storage que não é Import nem DirectQuery — TECH SANTOS BR" />
<meta property="og:description" content="Direct Lake lê os dados do OneLake direto em memória, sem cópia nem consulta em tempo real na fonte. Entenda quando usar no Microsoft Fabric." />
<meta property="og:image" content="https://techsantos.com.br/assets/img/promo-curso-1.jpg" />
<meta name="twitter:card" content="summary_large_image" />
<title>Direct Lake no Power BI: o modo de storage que não é Import nem DirectQuery — TECH SANTOS BR</title>
<meta name="description" content="Direct Lake lê os dados do OneLake direto em memória, sem cópia nem consulta em tempo real na fonte. Entenda quando usar no Microsoft Fabric." />
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
    <h1>Direct Lake no Power BI: o modo de storage que não é Import nem DirectQuery</h1>

    <p>Durante anos, modelar um relatório no Power BI significou escolher entre dois extremos: Import, que copia os dados pro arquivo e fica rápido mas desatualizado até a próxima atualização; ou DirectQuery, que consulta a fonte em tempo real mas paga o preço em performance. O Microsoft Fabric introduziu um terceiro caminho, pensado especificamente pra quem já guarda dados no OneLake: o Direct Lake.</p>

    <div class="key-takeaways">
      <span class="kt-label">Resumo rápido</span>
      <ul>
        <li>Direct Lake lê os arquivos Parquet do OneLake diretamente para a memória do mecanismo analítico, sem duplicar os dados num modelo importado.</li>
        <li>Diferente do DirectQuery, não gera uma consulta na fonte a cada interação — os dados já estão carregados como colunas em memória.</li>
        <li>Funciona com tabelas de Lakehouse e Warehouse do Fabric; fora desse cenário, o modelo volta a se comportar como Import ou DirectQuery.</li>
        <li>É o modo padrão de itens como o Lakehouse default semantic model no Fabric.</li>
      </ul>
    </div>

    <h2>Por que Import e DirectQuery não bastavam</h2>
    <p>Import serve bem quando o volume cabe na memória e a atualização periódica é aceitável — mas cada atualização reprocessa e duplica dados que já existem em algum lugar. DirectQuery resolve o problema do dado sempre atual, só que troca velocidade por consultas na fonte a cada clique de segmentação, o que castiga relatórios com muitas interações. Quando a fonte já é o próprio OneLake do Fabric, os dois modos ficam redundantes: por que copiar (Import) ou reconsultar (DirectQuery) um arquivo que o mecanismo analítico já pode enxergar direto?</p>

    <video controls preload="metadata" playsinline>
          <source src="https://media.techsantos.com.br/reels/fabric-direct-lake.mp4" type="video/mp4">
    </video>

    <h2>Como o Direct Lake funciona na prática</h2>
    <p>As tabelas de um Lakehouse ou Warehouse do Fabric ficam salvas no OneLake em formato Delta Parquet. O Direct Lake permite que o mecanismo de análise do Power BI carregue essas colunas Parquet diretamente para a memória, sem passar por um pipeline de importação tradicional e sem reescrever os dados num formato proprietário. Na prática, o relatório se comporta com a velocidade de um modelo Import, mas reflete mudanças na tabela de origem muito mais perto do tempo real, porque não existe uma cópia intermediária desatualizando.</p>
    <p>Isso não significa que o Direct Lake seja sempre superior — ele depende de as tabelas estarem no OneLake, dentro do Fabric. Fora desse cenário (uma fonte SQL Server tradicional, por exemplo), a escolha continua sendo entre Import e DirectQuery.</p>

    <h2>Quando faz sentido usar Direct Lake</h2>
    <p>Vale considerar Direct Lake quando o pipeline de dados já termina num Lakehouse ou Warehouse do Fabric e o relatório precisa refletir mudanças com baixa latência, sem pagar o custo de performance do DirectQuery tradicional. É o cenário mais comum de quem já centralizou a engenharia de dados no Fabric e quer que o Power BI consuma esse resultado sem uma etapa extra de importação.</p>

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
        <h3>Direct Lake substitui o Import?</h3>
        <p>Só quando os dados já estão num Lakehouse ou Warehouse do Fabric. Fora desse cenário, Import continua sendo a opção padrão.</p>
      </div>
      <div class="faq-item">
        <h3>Direct Lake é mais lento que Import?</h3>
        <p>Não — os dados também ficam carregados em memória como colunas, então a experiência de navegação é comparável à de um modelo Import.</p>
      </div>
      <div class="faq-item">
        <h3>Preciso reconfigurar atualização de dados com Direct Lake?</h3>
        <p>Não da mesma forma que no Import. O modelo lê a versão mais recente da tabela do OneLake, sem um agendamento de atualização tradicional.</p>
      </div>
      <div class="faq-item">
        <h3>Direct Lake funciona fora do Microsoft Fabric?</h3>
        <p>Não. Depende das tabelas estarem armazenadas no OneLake, dentro de um Lakehouse ou Warehouse do Fabric.</p>
      </div>
    </div>

    <p style="margin-top:2.5rem; font-size:0.82rem; color:var(--ink-faint);">
      Fontes: <a href="https://learn.microsoft.com/power-bi/enterprise/directlake-overview" target="_blank" rel="noopener">Microsoft Learn — Visão geral do Direct Lake</a>.
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
