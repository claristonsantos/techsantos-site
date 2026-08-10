<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="canonical" href="https://techsantos.com.br/blog/medida-ou-coluna-calculada-power-bi.php" />
<title>Medida ou coluna calculada no Power BI: qual usar? — TECH SANTOS BR</title>
<meta name="description" content="Coluna calculada ocupa espaço linha por linha; medida calcula na hora, só quando o gráfico pede. Veja quando usar cada uma no Power BI e por quê." />
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
      "name": "Coluna calculada deixa o arquivo do Power BI mais lento?",
      "acceptedAnswer": { "@type": "Answer", "text": "Pode deixar, principalmente em tabelas grandes. Coluna calculada é processada linha por linha e o resultado fica armazenado no modelo em memória, ocupando espaço permanentemente — diferente da medida, calculada só quando é exibida (Microsoft Learn)." }
    },
    {
      "@type": "Question",
      "name": "Coluna calculada responde a filtro do relatório?",
      "acceptedAnswer": { "@type": "Answer", "text": "Não da mesma forma. O valor de uma coluna calculada é fixado no momento da atualização dos dados e não recalcula sozinho quando você aplica um filtro no relatório — quem recalcula dinamicamente com o contexto do filtro é a medida." }
    },
    {
      "@type": "Question",
      "name": "Quando uma coluna calculada é a escolha certa?",
      "acceptedAnswer": { "@type": "Answer", "text": "Quando o resultado precisa aparecer como um campo pra arrastar em Linhas, Eixo ou Legenda de um visual — coluna calculada vira um campo novo na tabela, enquanto medida só existe dentro da área de Valores (Microsoft Learn)." }
    },
    {
      "@type": "Question",
      "name": "Dá pra converter uma coluna calculada em medida depois?",
      "acceptedAnswer": { "@type": "Answer", "text": "Dá, mas exige reescrever a fórmula: uma medida em contexto de linha se comporta diferente de uma coluna calculada, então o DAX raramente é copiado sem ajuste. Vale revisar cálculo por cálculo, não só recortar e colar." }
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
    <h1>Medida ou coluna calculada no Power BI: qual usar?</h1>

    <p>Seu relatório de Power BI começou rápido e foi ficando cada vez mais pesado a cada cálculo novo que você adicionou. Boa parte das vezes, a causa é simples: cálculo virando coluna calculada quando deveria ser medida. A diferença entre as duas parece sutil no começo, mas muda completamente o tamanho do arquivo e a velocidade do relatório.</p>

    <div class="key-takeaways">
      <span class="kt-label">Resumo rápido</span>
      <ul>
        <li>Coluna calculada é processada linha por linha e fica armazenada no modelo, ocupando memória permanentemente (Microsoft Learn).</li>
        <li>Medida é calculada dinamicamente, só quando um visual pede o valor, respondendo ao contexto de filtro do relatório.</li>
        <li>Coluna calculada vira um campo novo, útil pra usar em Linhas, Eixo ou Legenda de um visual.</li>
        <li>Na dúvida entre as duas, comece com medida — ela é mais leve e sempre atualizada com o filtro da tela.</li>
      </ul>
    </div>

    <h2>Qual a diferença real entre medida e coluna calculada?</h2>
    <p>Quando uma coluna calculada contém uma fórmula DAX válida, os valores são calculados para cada linha assim que a fórmula é inserida e ficam armazenados no modelo de dados em memória — já os valores calculados por uma medida são avaliados dinamicamente sempre que o usuário adiciona a medida a um visual, mudando conforme o contexto que o próprio usuário define (Microsoft Learn). Essa diferença de <em>quando</em> o cálculo acontece é a raiz de tudo que muda entre as duas.</p>
    <video controls preload="metadata" playsinline>
          <source src="https://media.techsantos.com.br/reels/dica-powerbi-medida-coluna.mp4" type="video/mp4">
    </video>

    <h2>Por que coluna calculada deixa o arquivo mais pesado</h2>
    <p>Coluna calculada é usada pra cálculos em nível de linha, onde o resultado fica armazenado no modelo de dados, ocupando memória, e é recalculada quando os dados são carregados ou atualizados (Microsoft Learn). Numa tabela de um milhão de linhas, isso significa um milhão de valores gravados fisicamente no arquivo — mesmo que só uma fração deles apareça em algum visual do relatório.</p>
    <p>Medida não tem esse custo de armazenamento: ela é calculada sob demanda, no momento em que o visual precisa mostrar o número, e some da memória quando não está sendo usada. Isso é o motivo direto pelo qual arquivos com muita coluna calculada abrem mais devagar e ocupam mais espaço em disco.</p>

    <h2>Quando a coluna calculada é a escolha certa</h2>
    <p>Existe um caso onde coluna calculada é insubstituível: quando você precisa do resultado como um <em>campo</em>, pra arrastar em Linhas, Eixo, Legenda ou usar como critério de um relacionamento — medida só funciona dentro da área de Valores de um visual, ela não pode ser usada pra agrupar ou categorizar. Um exemplo clássico: uma coluna que classifica cada venda em faixa de valor ("Baixo", "Médio", "Alto") pra usar como Legenda de um gráfico.</p>
    <p>Fora desse caso específico de precisar de um campo pra categorizar ou agrupar, a resposta quase sempre aponta pra medida.</p>

    <h2>Na dúvida, comece com medida</h2>
    <p>Medida responde ao filtro que o usuário aplica na tela — mudou o filtro de ano, a medida recalcula sozinha; coluna calculada, não, porque o valor dela já foi fixado no momento da atualização dos dados. Isso sozinho já resolve a maioria dos casos de "meu total não bate com o filtro que apliquei", um erro comum de quem usa coluna calculada onde deveria usar medida.</p>

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
        <h3>Coluna calculada deixa o arquivo do Power BI mais lento?</h3>
        <p>Pode deixar, principalmente em tabelas grandes. Coluna calculada é processada linha por linha e fica armazenada no modelo em memória, ocupando espaço permanentemente.</p>
      </div>
      <div class="faq-item">
        <h3>Coluna calculada responde a filtro do relatório?</h3>
        <p>Não da mesma forma. O valor fica fixado no momento da atualização dos dados e não recalcula sozinho com o filtro — quem recalcula dinamicamente é a medida.</p>
      </div>
      <div class="faq-item">
        <h3>Quando uma coluna calculada é a escolha certa?</h3>
        <p>Quando o resultado precisa aparecer como campo pra arrastar em Linhas, Eixo ou Legenda de um visual — medida só existe dentro da área de Valores.</p>
      </div>
      <div class="faq-item">
        <h3>Dá pra converter uma coluna calculada em medida depois?</h3>
        <p>Dá, mas exige reescrever a fórmula: uma medida em contexto de linha se comporta diferente, então o DAX raramente é copiado sem ajuste.</p>
      </div>
    </div>

    <p style="margin-top:2.5rem; font-size:0.82rem; color:var(--ink-faint);">
      Fontes: <a href="https://learn.microsoft.com/pt-br/power-bi/transform-model/desktop-calculated-columns" target="_blank" rel="noopener">Microsoft Learn — Usando colunas calculadas no Power BI Desktop</a>,
      <a href="https://learn.microsoft.com/pt-br/dax/best-practices/dax-column-measure-references" target="_blank" rel="noopener">Microsoft Learn — Referências de coluna e medida no DAX</a>. Consultadas em 19/07/2026.
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
