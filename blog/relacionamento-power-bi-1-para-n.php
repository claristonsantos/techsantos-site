<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="canonical" href="https://techsantos.com.br/blog/relacionamento-power-bi-1-para-n.php" />
<title>Relacionamento no Power BI: por que sempre 1 pra muitos — TECH SANTOS BR</title>
<meta name="description" content="Modelo travando ou contando duplicado no Power BI? Confira o relacionamento: a tabela de dimensão precisa ter valor único, ligada à fato em 1:N." />
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
      "name": "Por que meu total está duplicado no Power BI?",
      "acceptedAnswer": { "@type": "Answer", "text": "O motivo mais comum é um relacionamento onde os dois lados têm valores repetidos (muitos-para-muitos) em vez de um lado único — isso multiplica as linhas na hora do cálculo e infla o total. Verifique se o lado \"um\" da relação realmente tem um valor por linha." }
    },
    {
      "@type": "Question",
      "name": "O que é tabela de dimensão e tabela de fato?",
      "acceptedAnswer": { "@type": "Answer", "text": "Dimensão é a tabela com um valor único por linha (produto, cliente, data), sempre no lado \"um\" da relação. Fato é a tabela de eventos que se repete (vendas, pedidos), sempre no lado \"muitos\" — esse desenho chama-se esquema estrela (Microsoft Learn)." }
    },
    {
      "@type": "Question",
      "name": "Preciso configurar a cardinalidade manualmente?",
      "acceptedAnswer": { "@type": "Answer", "text": "Normalmente não. O Power BI Desktop detecta e define automaticamente o tipo de cardinalidade ao criar o relacionamento, consultando quais colunas contêm valores únicos no modelo (Microsoft Learn). Vale conferir manualmente quando o resultado de um cálculo parecer estranho." }
    },
    {
      "@type": "Question",
      "name": "Relacionamento muitos-para-muitos nunca deve ser usado?",
      "acceptedAnswer": { "@type": "Answer", "text": "Existem casos legítimos, mas exigem mais cuidado com o filtro e o desempenho — a orientação da própria Microsoft é usar muitos-para-muitos só quando um relacionamento 1:N não resolve o cenário, não como primeira opção." }
    }
  ]
}
</script>
</head>
<body>

<header class="site">
  <div class="nav-row">
    <a class="brand" href="/index.html">
      <img src="/assets/img/logo.jpg" alt="Tech Santos BR" />
      <span>TECH <em>SANTOS BR</em></span>
    </a>
    <nav class="links">
      <a href="/index.html">Home</a>
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
    <h1>Relacionamento no Power BI: por que sempre 1 pra muitos</h1>

    <p>O modelo trava, o cartão de total mostra um número maior do que devia, e você não sabe por onde começar a procurar o erro. Nove em cada dez vezes, o problema está no relacionamento entre as tabelas — especificamente, em qual lado da relação tem valor repetido e qual tem valor único.</p>

    <div class="key-takeaways">
      <span class="kt-label">Resumo rápido</span>
      <ul>
        <li>Num relacionamento 1:N, a coluna de um lado tem só uma instância de cada valor, e o outro lado pode ter várias (Microsoft Learn).</li>
        <li>Tabela de dimensão (produto, cliente, data) fica no lado "um"; tabela de fato (vendas, pedidos) fica no lado "muitos" — esse desenho é o esquema estrela.</li>
        <li>O Power BI detecta a cardinalidade automaticamente, mas vale conferir manualmente quando um total parecer errado.</li>
        <li>Relacionamento muitos-para-muitos costuma ser a causa raiz de contagem duplicada.</li>
      </ul>
    </div>

    <h2>Por que o Power BI trava com relacionamento errado?</h2>
    <p>As opções de cardinalidade um-para-muitos e muitos-para-um são essencialmente a mesma coisa e também as mais comuns — numa relação um-para-muitos, a coluna de uma tabela tem só uma instância de determinado valor, enquanto a tabela relacionada pode ter mais de uma instância do mesmo valor (Microsoft Learn). Quando essa regra não é respeitada — os dois lados têm valor repetido — o Power BI ainda deixa você criar o relacionamento, mas o resultado dos cálculos passa a multiplicar linhas sem avisar.</p>
    <video controls preload="metadata" playsinline>
          <source src="https://media.techsantos.com.br/reels/dica-powerbi-relacionamentos.mp4" type="video/mp4">
    </video>

    <h2>O que é esquema estrela e por que ele evita o problema</h2>
    <p>Uma cardinalidade de relacionamento comum é um-para-muitos, ou sua inversa muitos-para-um; o lado "um" é sempre uma tabela de dimensão, e o lado "muitos" é sempre uma tabela de fato (Microsoft Learn). Dimensão é o cadastro — produto, cliente, vendedor, data — onde cada linha representa um item único. Fato é o registro de evento que se repete — cada linha de venda, cada linha de pedido.</p>
    <p>Montar o modelo assim (uma tabela de dimensão pequena e única, ligada a uma tabela de fato grande e repetitiva) é o que os profissionais de dados chamam de esquema estrela, e é o desenho que evita a maioria dos problemas de duplicação e lentidão no Power BI.</p>

    <h2>Como o Power BI decide a cardinalidade sozinho</h2>
    <p>Ao criar um relacionamento no Power BI Desktop, o mecanismo de design detecta e define automaticamente o tipo de cardinalidade, consultando o modelo pra saber quais colunas contêm valores únicos — em modelos Import, usando estatísticas internas de armazenamento; em modelos DirectQuery, enviando consultas de perfil pra fonte de dados (Microsoft Learn). Isso funciona bem na maioria dos casos, mas não é infalível: se os dados de origem tiverem duplicidade inesperada num campo que deveria ser único, a detecção automática pode acertar a cardinalidade errada.</p>

    <h2>Como corrigir um total duplicado no Power BI</h2>
    <p>Primeiro, identifique o relacionamento suspeito no Modelo (ícone de diagrama na barra lateral) e confira a cardinalidade mostrada na linha que conecta as duas tabelas. Se aparecer "muitos-para-muitos" onde você esperava "um-para-muitos", investigue a coluna que deveria ser única — normalmente sobra um valor duplicado escondido nela, e é aí que mora o total inflado.</p>

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
        <h3>Por que meu total está duplicado no Power BI?</h3>
        <p>O motivo mais comum é um relacionamento onde os dois lados têm valores repetidos (muitos-para-muitos) em vez de um lado único — isso multiplica as linhas na hora do cálculo.</p>
      </div>
      <div class="faq-item">
        <h3>O que é tabela de dimensão e tabela de fato?</h3>
        <p>Dimensão é a tabela com um valor único por linha (produto, cliente, data), sempre no lado "um". Fato é a tabela de eventos que se repete (vendas, pedidos), sempre no lado "muitos".</p>
      </div>
      <div class="faq-item">
        <h3>Preciso configurar a cardinalidade manualmente?</h3>
        <p>Normalmente não — o Power BI detecta e define automaticamente. Vale conferir manualmente quando o resultado de um cálculo parecer estranho.</p>
      </div>
      <div class="faq-item">
        <h3>Relacionamento muitos-para-muitos nunca deve ser usado?</h3>
        <p>Existem casos legítimos, mas exigem mais cuidado com filtro e desempenho — use só quando um relacionamento 1:N não resolve o cenário.</p>
      </div>
    </div>

    <p style="margin-top:2.5rem; font-size:0.82rem; color:var(--ink-faint);">
      Fontes: <a href="https://learn.microsoft.com/pt-br/power-bi/transform-model/desktop-relationships-understand" target="_blank" rel="noopener">Microsoft Learn — Relacionamentos de modelo no Power BI Desktop</a>,
      <a href="https://learn.microsoft.com/pt-br/power-bi/guidance/star-schema" target="_blank" rel="noopener">Microsoft Learn — Entender o esquema estrela</a>. Consultadas em 19/07/2026.
    </p>
  </article>
</main>

<footer class="site footer-wide">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <a class="brand" href="/index.html">
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
