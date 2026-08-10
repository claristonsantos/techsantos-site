<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="canonical" href="https://techsantos.com.br/blog/granularidade-power-bi.php" />
<title>Power BI lento? Pode ser granularidade errada — TECH SANTOS BR</title>
<meta name="description" content="Modelo pesado e relatório lento no Power BI nem sempre é falta de RAM. Veja o que é granularidade de uma tabela fato e como uma linha redundante pesa o modelo à toa." />
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
      "name": "O que é granularidade numa tabela fato do Power BI?",
      "acceptedAnswer": { "@type": "Answer", "text": "Granularidade é o nível de detalhe de cada linha da tabela — definido pela combinação de dimensões que ela usa (data, produto, loja). Duas linhas com a mesma combinação de chaves são redundantes e indicam granularidade mais fina do que o necessário." }
    },
    {
      "@type": "Question",
      "name": "Por que granularidade errada deixa o Power BI lento?",
      "acceptedAnswer": { "@type": "Answer", "text": "Quanto mais fina a granularidade, mais linhas o modelo precisa guardar e processar em cada cálculo. Se o relatório nunca analisa no nível mais detalhado, essas linhas extras só pesam o modelo sem entregar nenhum valor de análise a mais." }
    },
    {
      "@type": "Question",
      "name": "Como descobrir a granularidade certa pra uma tabela fato?",
      "acceptedAnswer": { "@type": "Answer", "text": "Pergunte qual é o nível de detalhe que os relatórios realmente precisam mostrar. Se a análise mais detalhada é por dia, produto e loja, essa é a granularidade certa — qualquer nível mais fino que isso é redundância." }
    },
    {
      "@type": "Question",
      "name": "Pré-agregar dados faz perder informação?",
      "acceptedAnswer": { "@type": "Answer", "text": "Não, se a granularidade escolhida cobrir tudo que os relatórios precisam mostrar. Pré-agregar elimina linhas repetidas com a mesma chave, mas mantém a mesma informação final — só entrega ela de forma mais enxuta." }
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
    <div class="blog-meta">Power BI · Modelagem de Dados · Atualizado em 03/08/2026 · 5 min de leitura</div>
    <h1>Power BI lento? Pode ser granularidade errada, não falta de RAM</h1>

    <p>Antes de trocar de computador ou reclamar da licença, vale checar uma coisa que custa zero: a granularidade da sua tabela fato. Um modelo com linhas redundantes fica pesado à toa — e o sintoma parece hardware, mas a causa é modelagem.</p>

    <div class="key-takeaways">
      <span class="kt-label">Resumo rápido</span>
      <ul>
        <li>Granularidade é o nível de detalhe de cada linha — definido pelas dimensões que a tabela fato usa.</li>
        <li>Duas linhas com a mesma combinação de chaves (mesma data, produto e loja) são redundantes.</li>
        <li>Pré-agregar pra granularidade certa reduz linhas sem perder informação que o relatório realmente usa.</li>
        <li>Modelo enxuto responde mais rápido — o Power BI processa menos linha por cálculo.</li>
      </ul>
    </div>

    <h2>O que define a granularidade de uma tabela fato</h2>
    <p>A granularidade não é um número escolhido à toa — ela é definida pela combinação das dimensões que a linha carrega. Se cada linha de vendas tem uma Data, um Produto e uma Loja, a granularidade é "uma linha por combinação de data, produto e loja". Toda vez que duas linhas repetem exatamente essa combinação, existe redundância no modelo.</p>
    <video controls preload="metadata" playsinline>
          <source src="https://media.techsantos.com.br/reels/dica-novidade7-granularidade.mp4" type="video/mp4">
    </video>

    <h2>Por que isso deixa o relatório lento</h2>
    <p>Cada cálculo DAX percorre as linhas da tabela fato dentro do contexto de filtro ativo. Quanto mais linhas existirem pra representar a mesma informação, mais trabalho o mecanismo de cálculo precisa fazer — mesmo que o resultado final, depois de somado, seja idêntico ao de um modelo mais enxuto. Isso é especialmente visível em bases grandes, onde a diferença entre granularidade fina e granularidade certa pode ser a diferença entre um relatório instantâneo e um relatório que trava.</p>

    <h2>Como identificar granularidade fina demais</h2>
    <p>O sinal mais claro é perguntar: "existe alguma análise no relatório que realmente precisa desse nível de detalhe?". Se a base tem uma linha por item de carrinho, mas nenhum visual jamais analisa por item individual — só por dia, produto e loja — a granularidade por item é fina demais pro que o relatório entrega.</p>
    <p>Outro sinal prático: abrir a tabela fato e procurar linhas com exatamente a mesma combinação de chaves. Se elas aparecem aos montes, existe espaço real pra pré-agregar sem perder nada que o dashboard mostra hoje.</p>

    <h2>Como corrigir sem perder informação</h2>
    <p>Pré-agregar significa somar as linhas redundantes numa única linha por combinação de chaves, antes de carregar a tabela pro modelo — normalmente resolvido no Power Query, agrupando pelas colunas que definem a granularidade certa. O resultado final da soma continua idêntico; só o número de linhas físicas no modelo diminui, e é exatamente isso que acelera os cálculos.</p>
    <p>A regra prática: a granularidade certa é a mais grossa possível que ainda cobre tudo que os relatórios precisam mostrar hoje. Qualquer nível mais fino que isso é peso que o modelo carrega sem necessidade.</p>

    <div class="blog-cta">
      <h2>Quer aprender a modelar dados de verdade?</h2>
      <p>O curso completo de Power BI da TECH SANTOS BR cobre modelagem de dados, Power Query e DAX — do zero até dashboards rápidos e publicados de verdade.</p>
      <div class="hero-cta">
        <a class="btn btn-primary" href="/aula-gratis.php">Assistir aula grátis</a>
        <a class="btn btn-ghost" href="/curso-power-bi.php">Conhecer o curso completo</a>
      </div>
    </div>

    <h2>Perguntas frequentes</h2>
    <div class="blog-faq-grid">
      <div class="faq-item">
        <h3>O que é granularidade numa tabela fato do Power BI?</h3>
        <p>É o nível de detalhe de cada linha, definido pela combinação de dimensões que ela usa. Duas linhas com a mesma combinação de chaves são redundantes.</p>
      </div>
      <div class="faq-item">
        <h3>Por que granularidade errada deixa o Power BI lento?</h3>
        <p>Quanto mais fina a granularidade, mais linhas o modelo processa em cada cálculo. Se o relatório nunca precisa desse detalhe, essas linhas só pesam à toa.</p>
      </div>
      <div class="faq-item">
        <h3>Como descobrir a granularidade certa pra uma tabela fato?</h3>
        <p>Pergunte qual é o nível de detalhe que os relatórios realmente precisam mostrar — qualquer nível mais fino que isso é redundância.</p>
      </div>
      <div class="faq-item">
        <h3>Pré-agregar dados faz perder informação?</h3>
        <p>Não, se a granularidade escolhida cobrir tudo que os relatórios precisam mostrar. O resultado final continua igual, só com menos linhas.</p>
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
