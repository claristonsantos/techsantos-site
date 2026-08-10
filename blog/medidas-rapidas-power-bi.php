<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Medida Rápida no Power BI: como criar DAX sem escrever do zero — TECH SANTOS BR</title>
<meta name="description" content="Travou na hora de escrever uma fórmula DAX? A Medida Rápida monta o cálculo pronto pra você estudar. Veja como usar e quando vale escrever na mão." />
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
      "name": "Onde encontro a Medida Rápida no Power BI Desktop?",
      "acceptedAnswer": { "@type": "Answer", "text": "Clique com o botão direito (ou selecione as reticências) ao lado de qualquer item no painel de Campos e escolha Nova medida rápida no menu — a janela de Medidas Rápidas abre com os cálculos disponíveis (Microsoft Learn)." }
    },
    {
      "@type": "Question",
      "name": "Dá pra ver a fórmula DAX que a Medida Rápida gerou?",
      "acceptedAnswer": { "@type": "Answer", "text": "Dá — essa é a maior vantagem do recurso. A fórmula DAX que implementa a medida rápida aparece na barra de fórmulas assim que você seleciona a medida no painel de Campos, então dá pra estudar exatamente como o cálculo foi montado (Microsoft Learn)." }
    },
    {
      "@type": "Question",
      "name": "Medida Rápida cobre todo tipo de cálculo em Power BI?",
      "acceptedAnswer": { "@type": "Answer", "text": "Não. Ela cobre os cálculos mais comuns — percentual do total, variação ano contra ano, média móvel, ranking. Cálculos com regra de negócio específica da sua empresa normalmente exigem DAX escrito na mão." }
    },
    {
      "@type": "Question",
      "name": "Preciso saber DAX pra usar Medida Rápida?",
      "acceptedAnswer": { "@type": "Answer", "text": "Não pra criar — você escolhe o cálculo numa lista e arrasta os campos, sem escrever nada. Mas entender DAX ajuda a revisar e ajustar o resultado depois, principalmente se o número não vier do jeito esperado." }
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
    <div class="blog-meta">Power BI · Atualizado em 19/07/2026 · 4 min de leitura</div>
    <h1>Medida Rápida no Power BI: como criar DAX sem escrever do zero</h1>

    <p>Você sabe exatamente o cálculo que precisa — percentual do total, variação em relação ao mês anterior — mas travou na hora de escrever a fórmula DAX do zero. A Medida Rápida existe pra esse momento: você escolhe o cálculo numa lista, e o Power BI monta a fórmula pronta, já pra você estudar como funciona por dentro.</p>

    <div class="key-takeaways">
      <span class="kt-label">Resumo rápido</span>
      <ul>
        <li>Medida Rápida abre uma janela com cálculos prontos: você escolhe o tipo e arrasta os campos, sem escrever DAX (Microsoft Learn).</li>
        <li>A fórmula DAX gerada aparece na barra de fórmulas assim que você seleciona a medida no painel de Campos.</li>
        <li>É a forma mais rápida de estudar DAX na prática: você vê o resultado e a fórmula por trás dele lado a lado.</li>
        <li>Cálculos com regra de negócio muito específica normalmente ainda exigem DAX escrito na mão.</li>
      </ul>
    </div>

    <h2>Como criar uma Medida Rápida no Power BI Desktop</h2>
    <p>Pra criar uma medida rápida no Power BI Desktop, clique com o botão direito ou selecione as reticências ao lado de qualquer item no painel de Campos e escolha Nova medida rápida no menu (Microsoft Learn). Ao selecionar essa opção, a janela de Medidas Rápidas se abre, permitindo escolher o cálculo desejado e os campos sobre os quais ele vai rodar.</p>
    <video controls preload="metadata" playsinline>
          <source src="https://media.techsantos.com.br/reels/dica-powerbi-medidas-rapidas.mp4" type="video/mp4">
    </video>
    <p>A lista de cálculos disponíveis cobre os pedidos mais comuns num relatório: percentual do total, diferença em relação ao período anterior, valor acumulado, média móvel, e outros. Você escolhe o tipo, arrasta o campo de valor e o campo de categoria, e o Power BI monta a medida sozinho.</p>

    <h2>Por que a Medida Rápida é boa pra aprender DAX</h2>
    <p>Uma grande vantagem das medidas rápidas é que elas mostram a fórmula DAX subjacente que implementa a medida — essa fórmula aparece na barra de fórmulas quando você seleciona a medida rápida no painel de Campos (Microsoft Learn). Isso transforma o recurso em uma espécie de exemplo guiado: em vez de copiar uma fórmula pronta de um tutorial sem entender por que ela funciona, você vê o Power BI montar a fórmula em cima do seu próprio dado, com os nomes reais das suas tabelas e colunas.</p>
    <p>Pra quem está começando com DAX, vale o hábito de criar a medida rápida primeiro, estudar a fórmula gerada na barra de fórmulas, e só depois tentar escrever uma parecida do zero pra outro cálculo — é mais fácil aprender lendo uma fórmula funcional do que decorando sintaxe.</p>

    <h2>Quando a Medida Rápida não é suficiente</h2>
    <p>A lista de cálculos prontos cobre padrões genéricos, não regra de negócio específica da sua empresa — tipo "meta batida só se vendas E margem passarem de um limite juntos". Nesses casos, a medida rápida serve como ponto de partida: você gera o cálculo mais próximo do que precisa e edita a fórmula DAX gerada, em vez de escrever tudo do zero.</p>

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
        <h3>Onde encontro a Medida Rápida no Power BI Desktop?</h3>
        <p>Clique com o botão direito ao lado de qualquer item no painel de Campos e escolha Nova medida rápida no menu.</p>
      </div>
      <div class="faq-item">
        <h3>Dá pra ver a fórmula DAX que a Medida Rápida gerou?</h3>
        <p>Dá — a fórmula aparece na barra de fórmulas assim que você seleciona a medida no painel de Campos, então dá pra estudar como o cálculo foi montado.</p>
      </div>
      <div class="faq-item">
        <h3>Medida Rápida cobre todo tipo de cálculo em Power BI?</h3>
        <p>Não. Ela cobre os cálculos mais comuns — percentual do total, variação ano contra ano, média móvel, ranking. Regra de negócio específica normalmente exige DAX na mão.</p>
      </div>
      <div class="faq-item">
        <h3>Preciso saber DAX pra usar Medida Rápida?</h3>
        <p>Não pra criar — você escolhe o cálculo numa lista, sem escrever nada. Mas entender DAX ajuda a revisar o resultado depois.</p>
      </div>
    </div>

    <p style="margin-top:2.5rem; font-size:0.82rem; color:var(--ink-faint);">
      Fontes: <a href="https://learn.microsoft.com/pt-br/power-bi/transform-model/desktop-quick-measures" target="_blank" rel="noopener">Microsoft Learn — Uso de medidas rápidas para cálculos comuns e eficazes</a>. Consultada em 19/07/2026.
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
