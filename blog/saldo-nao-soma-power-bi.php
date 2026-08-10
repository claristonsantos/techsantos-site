<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="canonical" href="https://techsantos.com.br/blog/saldo-nao-soma-power-bi.php" />
<title>Por que somar saldo dá número errado no Power BI — TECH SANTOS BR</title>
<meta name="description" content="Somar o saldo de uma conta mês a mês costuma dar número errado no Power BI. O motivo é o tipo de fato: instantâneo (snapshot) não soma como evento. Veja a diferença." />
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
      "name": "Por que o Power BI soma errado o saldo de uma conta?",
      "acceptedAnswer": { "@type": "Answer", "text": "Porque saldo é um fato do tipo instantâneo (snapshot): cada linha é uma fotografia de um valor num momento, não um evento novo. Somar instantâneos ao longo do tempo conta o mesmo dinheiro várias vezes." }
    },
    {
      "@type": "Question",
      "name": "Qual a diferença entre fato de evento e fato instantâneo?",
      "acceptedAnswer": { "@type": "Answer", "text": "Fato de evento (transacional) registra algo que aconteceu uma vez — uma venda, um pedido — e pode ser somado livremente. Fato instantâneo registra um valor medido em um ponto no tempo — saldo, estoque, temperatura — e normalmente precisa da medida certa (último valor, média) em vez de soma direta." }
    },
    {
      "@type": "Question",
      "name": "Como calcular o saldo certo por período no Power BI?",
      "acceptedAnswer": { "@type": "Answer", "text": "Em vez de somar, use uma medida que traga o último valor do período (LASTDATE/LASTNONBLANK em DAX) ou, quando fizer sentido, a média. A ideia é sempre pegar o valor representativo do momento, não empilhar valores que já se repetem." }
    },
    {
      "@type": "Question",
      "name": "Todo dado numérico no Power BI é fato de evento?",
      "acceptedAnswer": { "@type": "Answer", "text": "Não. Qualquer métrica que representa um estado (saldo, nível de estoque, temperatura, posição) é instantânea. Qualquer métrica que representa algo que aconteceu (venda, clique, pedido) é evento. Identificar qual é qual antes de modelar evita boa parte dos erros de dashboard." }
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
    <h1>Por que somar saldo dá número errado no Power BI</h1>

    <p>Você soma o saldo de uma conta em janeiro e fevereiro e o Power BI mostra o dobro do que deveria. Não é bug do relatório — é o tipo de dado sendo tratado do jeito errado. Saldo é o mesmo dinheiro parado, mês após mês; somar linhas repetidas do mesmo valor nunca vai dar o número certo.</p>

    <div class="key-takeaways">
      <span class="kt-label">Resumo rápido</span>
      <ul>
        <li>Existem dois tipos de fato numa tabela: <strong>evento</strong> (venda, pedido) e <strong>instantâneo/snapshot</strong> (saldo, estoque).</li>
        <li>Evento pode ser somado ao longo do tempo — cada linha é dinheiro novo.</li>
        <li>Instantâneo não pode ser somado — é o mesmo valor medido de novo, mês a mês.</li>
        <li>A medida certa pra instantâneo normalmente é "último valor do período", não SUM.</li>
      </ul>
    </div>

    <h2>O que diferencia um fato de evento de um fato instantâneo</h2>
    <p>Uma tabela de vendas registra algo que aconteceu: cada linha é uma venda nova, dinheiro que entrou naquele momento e não vai se repetir. Por isso somar todas as linhas de janeiro e fevereiro dá o total real do período — são eventos distintos.</p>
    <p>Uma tabela de saldo de conta funciona diferente: a linha de janeiro mostra R$ 5.000 e a de fevereiro também mostra R$ 5.000 porque é o mesmo dinheiro que continua parado na conta, não um novo depósito. Somar as duas linhas dá R$ 10.000 — um número que não existe em lugar nenhum da realidade.</p>
    <video controls preload="metadata" playsinline>
          <source src="https://media.techsantos.com.br/reels/dica-novidade5-snapshot.mp4" type="video/mp4">
    </video>

    <h2>Onde esse erro aparece na prática</h2>
    <p>Saldo bancário é o exemplo mais direto, mas o mesmo problema aparece em qualquer métrica que representa um <em>estado</em> em vez de um <em>acontecimento</em>: nível de estoque, número de funcionários ativos, temperatura de um sensor, posição de um veículo. Todos esses valores são medidos repetidamente ao longo do tempo, e nenhum deles deveria ser somado direto num cartão de total.</p>
    <p>É comum esse erro passar despercebido justamente porque o Power BI não avisa nada — a soma acontece sem erro, sem aviso, só com o número errado. Quem não conhece a diferença entre os dois tipos de fato normalmente só percebe quando alguém de fora questiona o dashboard.</p>

    <h2>Como calcular o valor certo pra um instantâneo</h2>
    <p>A saída não é abandonar a soma pra sempre — é trocar a medida pela pergunta certa. Para saldo, a pergunta certa costuma ser "qual foi o último valor registrado no período", não "quanto deu somando tudo". Em DAX, isso normalmente é resolvido com funções como <code>LASTNONBLANK</code> ou <code>CALCULATE</code> combinado com o máximo de data dentro do contexto de filtro.</p>
    <p>Para outras métricas de estado, a resposta certa pode ser a média em vez do último valor — depende do que o número precisa representar. O ponto em comum é sempre o mesmo: parar antes de arrastar SOMA pra cima de um campo e perguntar se aquele valor é um evento novo ou uma fotografia repetida.</p>

    <h2>Como evitar esse erro desde a modelagem</h2>
    <p>O jeito mais confiável de nunca cair nessa armadilha é decidir o tipo de cada tabela fato antes de montar qualquer medida — não depois que o número já saiu errado. Ao trazer uma tabela nova pro modelo, pergunte: cada linha aqui é algo que aconteceu uma vez, ou é uma leitura repetida de um valor que muda devagar? A resposta dessa pergunta define se SOMA é segura ou se você precisa de uma medida diferente.</p>

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
        <h3>Por que o Power BI soma errado o saldo de uma conta?</h3>
        <p>Porque saldo é um fato instantâneo: cada linha é uma fotografia de um valor num momento, não um evento novo. Somar instantâneos ao longo do tempo conta o mesmo dinheiro várias vezes.</p>
      </div>
      <div class="faq-item">
        <h3>Qual a diferença entre fato de evento e fato instantâneo?</h3>
        <p>Evento registra algo que aconteceu uma vez e pode ser somado livremente. Instantâneo registra um valor medido num ponto no tempo e normalmente precisa da medida certa em vez de soma direta.</p>
      </div>
      <div class="faq-item">
        <h3>Como calcular o saldo certo por período no Power BI?</h3>
        <p>Use uma medida que traga o último valor do período (LASTNONBLANK em DAX) em vez de somar — o objetivo é pegar o valor representativo do momento, não empilhar valores repetidos.</p>
      </div>
      <div class="faq-item">
        <h3>Todo dado numérico no Power BI é fato de evento?</h3>
        <p>Não. Métricas que representam um estado (saldo, estoque, temperatura) são instantâneas. Métricas que representam algo que aconteceu (venda, pedido) são eventos.</p>
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
