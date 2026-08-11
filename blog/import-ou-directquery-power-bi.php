<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="canonical" href="https://techsantos.com.br/blog/import-ou-directquery-power-bi.php" />
<meta property="og:type" content="article" />
<meta property="og:locale" content="pt_BR" />
<meta property="og:url" content="https://techsantos.com.br/blog/import-ou-directquery-power-bi.php" />
<meta property="og:title" content="Import ou DirectQuery no Power BI: qual escolher? — TECH SANTOS BR" />
<meta property="og:description" content="Import copia os dados pro arquivo — mais rápido, mas precisa de atualização. DirectQuery consulta a fonte em tempo real — mais lento, sempre atual." />
<meta property="og:image" content="https://techsantos.com.br/assets/img/promo-curso-1.jpg" />
<meta name="twitter:card" content="summary_large_image" />
<title>Import ou DirectQuery no Power BI: qual escolher? — TECH SANTOS BR</title>
<meta name="description" content="Import copia os dados pro arquivo — mais rápido, mas precisa de atualização. DirectQuery consulta a fonte em tempo real — mais lento, sempre atual." />
<link rel="icon" type="image/png" href="/assets/img/favicon-32.png" />
<link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png" />
<link rel="stylesheet" href="/assets/css/style.css" />
<?php require_once __DIR__ . '/../inc/meta-pixel.php'; ?>
<?php require_once __DIR__ . '/../inc/google-analytics.php'; ?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "Por que meu relatório em DirectQuery está lento?",
      "acceptedAnswer": { "@type": "Answer", "text": "Porque toda interação — trocar um filtro, abrir um visual — dispara uma consulta nova direto na fonte de dados, então a velocidade do relatório fica limitada pela velocidade do banco de dados de origem, não pelo Power BI (Microsoft Learn)." }
    },
    {
      "@type": "Question",
      "name": "Import serve pra dados que mudam o tempo todo?",
      "acceptedAnswer": { "@type": "Answer", "text": "Serve, mas com uma ressalva: os dados só atualizam quando você programa uma atualização (agendada ou manual) — não existe atualização automática em tempo real no modo Import puro, diferente do DirectQuery." }
    },
    {
      "@type": "Question",
      "name": "Dá pra misturar Import e DirectQuery no mesmo relatório?",
      "acceptedAnswer": { "@type": "Answer", "text": "Dá, chama-se modelo composto: algumas tabelas ficam em modo Import e outras em DirectQuery dentro do mesmo modelo, combinando velocidade com dados atualizados onde faz mais sentido (Microsoft Learn)." }
    },
    {
      "@type": "Question",
      "name": "Existe uma terceira opção além de Import e DirectQuery?",
      "acceptedAnswer": { "@type": "Answer", "text": "Existe o modo Dual, que se comporta como Import ou DirectQuery dependendo da consulta, e o Direct Lake, mais recente, voltado pra arquitetura do Microsoft Fabric — mas pra a grande maioria dos relatórios, a escolha prática segue sendo entre Import e DirectQuery." }
    }
  ]
}
</script>
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
    <div class="blog-meta">Power BI · Atualizado em 19/07/2026 · 5 min de leitura</div>
    <h1>Import ou DirectQuery no Power BI: qual escolher?</h1>

    <p>Antes de conectar a primeira fonte de dados num novo relatório de Power BI, existe uma decisão que afeta tudo que vem depois: como o modelo vai armazenar os dados. Import e DirectQuery resolvem o mesmo problema — trazer dados de uma fonte pro relatório — de jeitos opostos, e escolher errado custa desempenho ou dado desatualizado.</p>

    <div class="key-takeaways">
      <span class="kt-label">Resumo rápido</span>
      <ul>
        <li>Import copia os dados pro arquivo do Power BI — consultas rápidas, mas precisa de atualização programada pra refletir mudanças na fonte (Microsoft Learn).</li>
        <li>DirectQuery consulta a fonte de dados em tempo real a cada interação — sempre atual, mas mais lento e mais limitado.</li>
        <li>Modelo composto combina os dois: parte das tabelas em Import, parte em DirectQuery, no mesmo relatório.</li>
        <li>Na dúvida, comece com Import — é o modo padrão e cobre a maioria dos cenários.</li>
      </ul>
    </div>

    <h2>O que muda entre Import e DirectQuery na prática?</h2>
    <p>Em modo Import, o Power BI Desktop importa dados de uma fonte de dados de origem pra dentro do próprio Power BI Desktop — esse é o modo de conectividade padrão pra a maioria das fontes de dados no Power BI Desktop (Microsoft Learn). Já em DirectQuery, em vez de consultar dados importados que compõem um modelo semântico, o Power BI consulta diretamente a fonte de dados subjacente pra qualquer campo de dados usado no relatório (Microsoft Learn). Ou seja: Import faz uma cópia local; DirectQuery nunca copia nada, sempre pergunta pra fonte.</p>
    <video controls preload="metadata" playsinline>
          <source src="https://media.techsantos.com.br/reels/dica-powerbi-import.mp4" type="video/mp4">
    </video>

    <h2>Vantagens e limitações do modo Import</h2>
    <p>Por trazer os dados pro arquivo, o modo Import responde às interações do relatório (filtro, segmentação, drill-down) usando o motor de análise em memória do Power BI, que é rápido mesmo com volumes grandes de dados. A limitação é a atualização: os dados no relatório ficam parados no momento em que foram importados, então é preciso configurar uma atualização — agendada, sob demanda, ou via atualização incremental — pra trazer as mudanças da fonte original.</p>
    <p>Import também tem limite de tamanho de modelo, dependendo da licença do Power BI usada, o que importa em bases muito grandes.</p>

    <h2>Vantagens e limitações do DirectQuery</h2>
    <p>DirectQuery garante que o relatório sempre mostra o dado mais atual da fonte, sem precisar de atualização manual — a consulta acontece na hora. O custo real vem de desempenho: como cada interação do usuário dispara uma consulta nova na fonte de dados, a velocidade do relatório passa a depender diretamente da velocidade e da carga do banco de dados de origem, não só do Power BI (Microsoft Learn).</p>
    <p>DirectQuery também tem restrições de funcionalidade — algumas transformações do Power Query e alguns cálculos DAX se comportam diferente ou não são suportados nesse modo, então vale revisar a documentação de orientação de modelo DirectQuery antes de decidir.</p>

    <h2>Como decidir: Import, DirectQuery ou os dois juntos?</h2>
    <p>Na dúvida, comece com Import — é o modo padrão, cobre a maioria dos cenários e entrega o melhor desempenho pra a maioria dos relatórios. DirectQuery faz sentido quando os dados mudam com muita frequência (segundo a segundo) e o negócio realmente precisa desse tempo real, ou quando a base é grande demais pra caber num modelo Import dentro do limite da licença.</p>
    <p>Existe ainda o modelo composto, que combina Import e DirectQuery na mesma solução, permitindo definir o modo de armazenamento tabela por tabela dentro de um único modelo (Microsoft Learn) — uma forma de ter dados históricos rápidos em Import e uma tabela específica sempre atual em DirectQuery, sem escolher só um dos dois pro relatório inteiro.</p>

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
        <h3>Por que meu relatório em DirectQuery está lento?</h3>
        <p>Porque toda interação dispara uma consulta nova direto na fonte de dados, então a velocidade fica limitada pela velocidade do banco de dados de origem, não pelo Power BI.</p>
      </div>
      <div class="faq-item">
        <h3>Import serve pra dados que mudam o tempo todo?</h3>
        <p>Serve, mas com ressalva: os dados só atualizam quando você programa uma atualização — não existe atualização automática em tempo real no modo Import puro.</p>
      </div>
      <div class="faq-item">
        <h3>Dá pra misturar Import e DirectQuery no mesmo relatório?</h3>
        <p>Dá, chama-se modelo composto: algumas tabelas ficam em Import e outras em DirectQuery dentro do mesmo modelo.</p>
      </div>
      <div class="faq-item">
        <h3>Existe uma terceira opção além de Import e DirectQuery?</h3>
        <p>Existe o modo Dual e o Direct Lake, mais recente e voltado pro Microsoft Fabric — mas pra a maioria dos relatórios, a escolha prática segue entre Import e DirectQuery.</p>
      </div>
    </div>

    <p style="margin-top:2.5rem; font-size:0.82rem; color:var(--ink-faint);">
      Fontes: <a href="https://learn.microsoft.com/pt-br/power-bi/connect-data/desktop-directquery-about" target="_blank" rel="noopener">Microsoft Learn — DirectQuery no Power BI: quando usar, limitações, alternativas</a>,
      <a href="https://learn.microsoft.com/pt-br/power-bi/transform-model/desktop-storage-mode" target="_blank" rel="noopener">Microsoft Learn — Modo de armazenamento de tabela em modelos semânticos do Power BI</a>. Consultadas em 19/07/2026.
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
