<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="canonical" href="https://techsantos.com.br/blog/cabecalho-detalhe-tabela-fato-power-bi.php" />
<meta property="og:type" content="article" />
<meta property="og:locale" content="pt_BR" />
<meta property="og:url" content="https://techsantos.com.br/blog/cabecalho-detalhe-tabela-fato-power-bi.php" />
<meta property="og:title" content="Cabeçalho e item de pedido são duas tabelas fato — TECH SANTOS BR" />
<meta property="og:description" content="Pedido (cabeçalho) e item do pedido (detalhe) têm granularidades diferentes e não devem virar uma tabela fato só. Veja como modelar cabeçalho x detalhe no Power BI." />
<meta property="og:image" content="https://techsantos.com.br/assets/img/promo-curso-1.jpg" />
<meta name="twitter:card" content="summary_large_image" />
<title>Cabeçalho e item de pedido são duas tabelas fato — TECH SANTOS BR</title>
<meta name="description" content="Pedido (cabeçalho) e item do pedido (detalhe) têm granularidades diferentes e não devem virar uma tabela fato só. Veja como modelar cabeçalho x detalhe no Power BI." />
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
      "name": "Pedido e item do pedido devem ser a mesma tabela fato no Power BI?",
      "acceptedAnswer": { "@type": "Answer", "text": "Não. Pedido (cabeçalho) tem uma linha por pedido; item do pedido (detalhe) tem várias linhas por pedido. São granularidades diferentes e precisam ser duas tabelas fato relacionadas, não uma única tabela." }
    },
    {
      "@type": "Question",
      "name": "Por que juntar cabeçalho e detalhe numa tabela só dá problema?",
      "acceptedAnswer": { "@type": "Answer", "text": "Um valor do cabeçalho (como frete ou desconto do pedido) repetido em cada linha de item multiplica esse valor pelo número de itens do pedido, inflando qualquer soma que envolva esse campo." }
    },
    {
      "@type": "Question",
      "name": "Como relacionar corretamente pedido e item do pedido?",
      "acceptedAnswer": { "@type": "Answer", "text": "Com um relacionamento um-para-muitos: uma linha de Pedido se relaciona com várias linhas de Item do Pedido através do número do pedido. Cada tabela mantém sua própria granularidade e suas próprias medidas." }
    },
    {
      "@type": "Question",
      "name": "Isso vale só pra pedidos de venda?",
      "acceptedAnswer": { "@type": "Answer", "text": "Não — o mesmo padrão aparece em qualquer dado com cabeçalho e linha de detalhe: nota fiscal e item da nota, fatura e linha da fatura, ordem de produção e etapa da ordem. Sempre que existir granularidade diferente entre o resumo e o detalhe, a modelagem em duas tabelas fato é a certa." }
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
    <div class="blog-meta">Power BI · Modelagem de Dados · Atualizado em 03/08/2026 · 5 min de leitura</div>
    <h1>Cabeçalho e item de pedido são duas tabelas fato, não uma</h1>

    <p>Sua planilha de vendas tem uma linha por pedido com o total e o frete, e outra fonte com uma linha por item vendido dentro de cada pedido. É tentador juntar tudo numa tabela só — mas isso é exatamente o que quebra o relacionamento e infla os números no Power BI.</p>

    <div class="key-takeaways">
      <span class="kt-label">Resumo rápido</span>
      <ul>
        <li>Pedido (cabeçalho) tem 1 linha por pedido; Item do Pedido (detalhe) tem N linhas por pedido.</li>
        <li>Granularidades diferentes não cabem numa tabela fato só.</li>
        <li>A solução é relacionar as duas tabelas em 1:N pelo número do pedido.</li>
        <li>O mesmo padrão vale pra nota fiscal, fatura, ordem de produção — qualquer resumo com detalhe.</li>
      </ul>
    </div>

    <h2>O que acontece quando cabeçalho e detalhe viram uma tabela só</h2>
    <p>Imagine um pedido com frete de R$ 20 e três itens dentro dele. Se você duplica o valor do frete em cada uma das três linhas de item pra "juntar tudo numa tabela", qualquer soma de frete no relatório vai contar R$ 60 em vez de R$ 20 — porque o mesmo valor de cabeçalho foi repetido artificialmente pra caber na granularidade mais fina do detalhe.</p>
    <video controls preload="metadata" playsinline>
          <source src="https://media.techsantos.com.br/reels/dica-novidade8-header-detail.mp4" type="video/mp4">
    </video>

    <h2>Por que a granularidade diferente é o problema real</h2>
    <p>Pedido e Item do Pedido não são a mesma coisa medida duas vezes — são dois níveis de detalhe diferentes da mesma operação. Pedido responde perguntas como "quantos pedidos tivemos" ou "qual foi o frete total". Item do Pedido responde perguntas como "qual produto vendeu mais" ou "qual foi o ticket médio por item". Forçar as duas granularidades numa tabela única não elimina a diferença — só esconde ela até um cálculo dar errado.</p>

    <h2>Como modelar certo: duas tabelas fato relacionadas</h2>
    <p>A solução é manter Pedido e Item do Pedido como duas tabelas separadas, cada uma na sua própria granularidade, relacionadas entre si por um campo em comum — normalmente o número do pedido — num relacionamento um-para-muitos. Uma linha de Pedido se conecta a várias linhas de Item do Pedido, e cada tabela guarda só os campos que fazem sentido no seu próprio nível: frete e desconto no Pedido, quantidade e preço unitário no Item.</p>
    <p>Esse desenho não é uma regra arbitrária de curso — é o mesmo princípio do esquema estrela aplicado a duas tabelas fato distintas em vez de uma dimensão e uma fato: cada tabela fica na sua granularidade certa, e o relacionamento cuida de conectar os dois níveis sem duplicar valor.</p>

    <h2>Onde esse padrão aparece além de pedidos de venda</h2>
    <p>O mesmo problema — e a mesma solução — aparecem em qualquer par cabeçalho/detalhe: nota fiscal e item da nota, fatura e linha da fatura, ordem de produção e etapa da ordem, orçamento e item do orçamento. Sempre que uma fonte de dados tiver um resumo com granularidade grossa e um detalhe com granularidade fina, vale parar e perguntar se elas deveriam ser uma tabela fato só ou duas relacionadas — a resposta quase sempre é duas.</p>

    <div class="blog-cta">
      <h2>Quer aprender modelagem de dados de verdade?</h2>
      <p>O curso completo de Power BI da TECH SANTOS BR cobre modelagem de dados, Power Query e DAX — do zero até dashboards publicados sem número errado.</p>
      <div class="hero-cta">
        <a class="btn btn-primary" href="/aula-gratis.php">Assistir aula grátis</a>
        <a class="btn btn-ghost" href="/curso-power-bi.php">Conhecer o curso completo</a>
      </div>
    </div>

    <h2>Perguntas frequentes</h2>
    <div class="blog-faq-grid">
      <div class="faq-item">
        <h3>Pedido e item do pedido devem ser a mesma tabela fato?</h3>
        <p>Não. Pedido tem 1 linha por pedido; item do pedido tem N linhas por pedido — são granularidades diferentes que precisam de duas tabelas relacionadas.</p>
      </div>
      <div class="faq-item">
        <h3>Por que juntar cabeçalho e detalhe numa tabela só dá problema?</h3>
        <p>Um valor do cabeçalho repetido em cada linha de item multiplica esse valor pelo número de itens do pedido, inflando qualquer soma.</p>
      </div>
      <div class="faq-item">
        <h3>Como relacionar corretamente pedido e item do pedido?</h3>
        <p>Com um relacionamento um-para-muitos pelo número do pedido — cada tabela mantém sua própria granularidade e suas próprias medidas.</p>
      </div>
      <div class="faq-item">
        <h3>Isso vale só pra pedidos de venda?</h3>
        <p>Não — o mesmo padrão aparece em nota fiscal e item, fatura e linha, ordem de produção e etapa. Qualquer resumo com detalhe segue essa lógica.</p>
      </div>
    </div>

    <p style="margin-top:2.5rem; font-size:0.82rem; color:var(--ink-faint);">
      Fontes: <a href="https://learn.microsoft.com/pt-br/power-bi/guidance/star-schema" target="_blank" rel="noopener">Microsoft Learn — Entender o esquema estrela</a>. Consultada em 03/08/2026.
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
