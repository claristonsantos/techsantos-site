<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="canonical" href="https://techsantos.com.br/blog/dimensao-que-muda-devagar-power-bi.php" />
<meta property="og:type" content="article" />
<meta property="og:locale" content="pt_BR" />
<meta property="og:url" content="https://techsantos.com.br/blog/dimensao-que-muda-devagar-power-bi.php" />
<meta property="og:title" content="Dimensão que muda devagar (SCD) no Power BI — TECH SANTOS BR" />
<meta property="og:description" content="Cliente mudou de gerente e o relatório do mês passado ficou errado? Isso tem nome: dimensão que muda devagar. Veja como decidir entre sobrescrever ou guardar histórico." />
<meta property="og:image" content="https://techsantos.com.br/assets/img/promo-curso-1.jpg" />
<meta name="twitter:card" content="summary_large_image" />
<title>Dimensão que muda devagar (SCD) no Power BI — TECH SANTOS BR</title>
<meta name="description" content="Cliente mudou de gerente e o relatório do mês passado ficou errado? Isso tem nome: dimensão que muda devagar. Veja como decidir entre sobrescrever ou guardar histórico." />
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
      "name": "O que é uma dimensão que muda devagar (SCD)?",
      "acceptedAnswer": { "@type": "Answer", "text": "É um atributo de uma tabela de dimensão que muda de tempo em tempo, mas não a cada linha — como gerente de um cliente, categoria de um produto ou região de um vendedor. O nome vem do inglês Slowly Changing Dimension." }
    },
    {
      "@type": "Question",
      "name": "Qual a diferença entre sobrescrever e guardar histórico numa dimensão?",
      "acceptedAnswer": { "@type": "Answer", "text": "Sobrescrever atualiza o valor atual e perde o valor anterior — todo relatório passa a mostrar sempre o dado mais recente, mesmo pra períodos passados. Guardar histórico mantém um registro por período, então um relatório de um mês antigo mostra o valor que era válido naquele mês." }
    },
    {
      "@type": "Question",
      "name": "Quando devo guardar histórico em vez de sobrescrever?",
      "acceptedAnswer": { "@type": "Answer", "text": "Quando o relatório precisa refletir fielmente como as coisas eram em cada período passado — por exemplo, avaliar a performance do gerente que realmente atendia o cliente naquele mês. Se só importa o estado atual, sobrescrever é mais simples e suficiente." }
    },
    {
      "@type": "Question",
      "name": "Preciso decidir isso pra tabela inteira ou por atributo?",
      "acceptedAnswer": { "@type": "Answer", "text": "Por atributo. Numa mesma tabela de clientes, o nome pode ser sempre sobrescrito enquanto o gerente responsável guarda histórico — cada coluna pode ter sua própria regra dependendo do que o negócio precisa analisar." }
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
    <h1>Gerente mudou e o relatório antigo quebrou? É dimensão que muda devagar</h1>

    <p>O cliente trocou de gerente de conta em julho, e agora o relatório de janeiro também mostra o gerente novo — mesmo que ele nem estivesse na empresa naquela época. Isso não é erro de fórmula: é uma dimensão que muda devagar sendo tratada como se nunca mudasse.</p>

    <div class="key-takeaways">
      <span class="kt-label">Resumo rápido</span>
      <ul>
        <li>Dimensão que muda devagar (SCD) é um atributo que muda de vez em quando, não a cada linha.</li>
        <li>Sobrescrever atualiza o valor atual, mas apaga o histórico — todo período passa a mostrar o dado mais recente.</li>
        <li>Guardar histórico mantém um valor válido por período, preservando a realidade de cada momento.</li>
        <li>A decisão é atributo por atributo, não pra tabela inteira.</li>
      </ul>
    </div>

    <h2>O que é uma dimensão que muda devagar</h2>
    <p>A maioria dos atributos de uma dimensão parece fixa — nome do cliente, país, categoria do produto — mas alguns mudam de tempo em tempo: gerente responsável por uma conta, faixa de preço de um produto, região de atuação de um vendedor. Esse tipo de atributo tem nome próprio na modelagem de dados: dimensão que muda devagar, ou SCD (Slowly Changing Dimension, do inglês).</p>
    <video controls preload="metadata" playsinline>
          <source src="https://media.techsantos.com.br/reels/dica-novidade9-scd.mp4" type="video/mp4">
    </video>

    <h2>O problema de sobrescrever sem pensar no histórico</h2>
    <p>A forma mais simples de lidar com um atributo que muda é sobrescrever: quando o gerente muda, você atualiza o cadastro do cliente e pronto. O problema aparece na hora de olhar pro passado — se o relatório de janeiro consulta o cadastro atual do cliente, ele vai mostrar o gerente de hoje, mesmo que outra pessoa fosse responsável naquele mês. Isso distorce qualquer análise de performance por gerente, porque o resultado de janeiro fica atribuído a quem nem trabalhava com aquele cliente na época.</p>

    <h2>A alternativa: guardar histórico</h2>
    <p>Guardar histórico significa manter um registro por período de validade, em vez de sobrescrever o valor único. Na prática, isso vira uma linha "gerente João, válido até 30/06" e outra "gerente Maria, válida a partir de 01/07" — e o relatório de janeiro naturalmente busca a linha certa pro período que está analisando, sem precisar de nenhum ajuste manual.</p>
    <p>Esse padrão é conhecido, no jargão clássico de modelagem dimensional, como manter uma nova versão do registro a cada mudança relevante — cada versão vale só para o intervalo de tempo em que era verdade.</p>

    <h2>Como decidir entre as duas abordagens</h2>
    <p>A pergunta certa não é "qual abordagem é melhor", é "o relatório precisa refletir a realidade de cada período passado, ou só importa o estado atual?". Se a análise é sobre performance histórica de gerente, guardar histórico é obrigatório. Se o atributo é só informativo — como o nome de contato mais recente — sobrescrever é mais simples e não perde nada relevante.</p>
    <p>E essa decisão não precisa ser igual pra tabela inteira: numa mesma dimensão de clientes, o telefone pode ser sempre sobrescrito (só importa o atual), enquanto o gerente responsável guarda histórico (importa pra avaliação de performance). Cada atributo tem sua própria regra.</p>

    <div class="blog-cta">
      <h2>Quer aprender modelagem de dados de verdade?</h2>
      <p>O curso completo de Power BI da TECH SANTOS BR cobre modelagem de dados, Power Query e DAX — do zero até dashboards confiáveis pra decisão.</p>
      <div class="hero-cta">
        <a class="btn btn-primary" href="/aula-gratis.php">Assistir aula grátis</a>
        <a class="btn btn-ghost" href="/curso-power-bi.php">Conhecer o curso completo</a>
      </div>
    </div>

    <h2>Perguntas frequentes</h2>
    <div class="blog-faq-grid">
      <div class="faq-item">
        <h3>O que é uma dimensão que muda devagar (SCD)?</h3>
        <p>É um atributo de uma dimensão que muda de tempo em tempo, como gerente de conta ou categoria de produto — não a cada linha.</p>
      </div>
      <div class="faq-item">
        <h3>Qual a diferença entre sobrescrever e guardar histórico?</h3>
        <p>Sobrescrever perde o valor anterior e mostra sempre o dado atual. Guardar histórico mantém um valor válido por período, refletindo a realidade de cada momento.</p>
      </div>
      <div class="faq-item">
        <h3>Quando devo guardar histórico em vez de sobrescrever?</h3>
        <p>Quando o relatório precisa refletir fielmente cada período passado — por exemplo, performance do gerente que realmente atendia naquele mês.</p>
      </div>
      <div class="faq-item">
        <h3>Preciso decidir isso pra tabela inteira ou por atributo?</h3>
        <p>Por atributo — cada coluna pode ter sua própria regra dependendo do que o negócio precisa analisar.</p>
      </div>
    </div>
    <p style="margin-top:2.5rem; font-size:0.82rem; color:var(--ink-faint);">
      Fontes: <a href="https://learn.microsoft.com/pt-br/power-bi/guidance/star-schema" target="_blank" rel="noopener">Microsoft Learn — Entender o esquema estrela (seção Dimensões que Mudam Lentamente)</a>. Consultada em 03/08/2026.
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
