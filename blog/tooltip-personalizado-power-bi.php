<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Tooltip personalizado no Power BI: mais detalhe sem poluir o relatório — TECH SANTOS BR</title>
<meta name="description" content="Cansou de lotar o relatório de gráfico só pra mostrar um detalhe a mais? Veja como criar Tooltip Personalizado no Power BI passo a passo." />
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
      "name": "Qual a diferença entre tooltip padrão e tooltip personalizado no Power BI?",
      "acceptedAnswer": { "@type": "Answer", "text": "O tooltip padrão mostra só os campos que você arrasta pra área de Tooltips do visual. O tooltip personalizado (report page tooltip) usa uma página inteira do relatório como o conteúdo que aparece ao passar o mouse — pode ter vários visuais, imagens e formatação (Microsoft Learn)." }
    },
    {
      "@type": "Question",
      "name": "Dá pra colocar um filtro dentro do tooltip personalizado?",
      "acceptedAnswer": { "@type": "Answer", "text": "Não interativamente. Tooltips de relatório não são interativos — o usuário não consegue selecionar segmentações de dados, navegar pelo conteúdo com Tab ou rolar dentro do tooltip, então o ideal é projetar a página pra que tudo fique visível sem precisar interagir (Microsoft Learn)." }
    },
    {
      "@type": "Question",
      "name": "Que tamanho de página devo usar pro tooltip personalizado?",
      "acceptedAnswer": { "@type": "Answer", "text": "No painel Formatar, na seção Configurações de Tela, defina o modelo de tamanho da página como Tooltip — isso ajusta as dimensões da página pro tamanho otimizado que um tooltip costuma ocupar na tela." }
    },
    {
      "@type": "Question",
      "name": "O tooltip personalizado funciona em qualquer tipo de gráfico?",
      "acceptedAnswer": { "@type": "Answer", "text": "Funciona na maioria dos visuais principais do Power BI, desde que você vincule a página de tooltip ao campo correto na área de Tooltips do visual. Alguns visuais customizados de terceiros podem ter suporte limitado." }
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
    <h1>Tooltip personalizado no Power BI: mais detalhe sem poluir o relatório</h1>

    <p>Todo relatório de Power BI chega num ponto em que cabe menos um gráfico na tela do que informação você quer mostrar. A saída mais comum — espremer mais um visual pequeno no canto — só deixa tudo mais difícil de ler. O Tooltip Personalizado resolve isso escondendo o detalhe extra até o momento em que alguém passa o mouse em cima do gráfico principal.</p>

    <div class="key-takeaways">
      <span class="kt-label">Resumo rápido</span>
      <ul>
        <li>Tooltip personalizado (report page tooltip) usa uma página inteira do relatório como conteúdo do tooltip, com vários visuais dentro (Microsoft Learn).</li>
        <li>Pra criar: nova página, marcar como Dica de Ferramenta no formato, montar o mini relatório, vincular ao visual principal.</li>
        <li>Tooltip de relatório não é interativo — nada de segmentação de dados ou navegação por Tab dentro dele.</li>
        <li>O tamanho de página ideal é o modelo Tooltip, disponível nas Configurações de Tela.</li>
      </ul>
    </div>

    <h2>O que é Tooltip Personalizado no Power BI?</h2>
    <p>Você pode criar tooltips de relatório visualmente ricos no Power BI, que aparecem ao passar o mouse sobre visuais, baseados em páginas de relatório que você cria no Power BI Desktop e no serviço do Power BI — permitindo incluir visuais, imagens e outros elementos que fornecem insights detalhados aos usuários (Microsoft Learn). Em vez de um tooltip de texto simples, você projeta uma página de relatório inteira, com o mesmo nível de controle visual de qualquer outra página.</p>
    <video controls preload="metadata" playsinline>
          <source src="https://media.techsantos.com.br/reels/dica-powerbi-tooltip.mp4" type="video/mp4">
    </video>

    <h2>Como criar um tooltip personalizado passo a passo</h2>
    <p>Primeiro, crie uma página nova no relatório. No painel Formatar dessa página, abra Configurações de Tela e defina o modelo de tamanho como Tooltip, que já ajusta as dimensões pra o tamanho certo. Nessa mesma página, marque a opção Permitir Uso como Dica de Ferramenta.</p>
    <p>Monte o mini relatório dentro dessa página — um cartão, um gráfico pequeno, o detalhe que você quer mostrar. Depois, vá até o visual principal (o gráfico que vai receber o tooltip), abra a área de Tooltips no painel de Visualizações e arraste a página de tooltip pra lá. Pronto: passar o mouse sobre um ponto do gráfico principal já mostra a página inteira como tooltip.</p>

    <h2>Limitações do tooltip personalizado</h2>
    <p>Tooltips de relatório não são interativos — usuários não conseguem selecionar segmentações de dados, navegar pelo conteúdo com Tab ou rolar dentro do tooltip, então vale projetar as páginas de tooltip de forma que todo o conteúdo fique visível sem rolagem, evitando adicionar elementos interativos como segmentações ou botões (Microsoft Learn). Isso significa que o tooltip personalizado serve pra mostrar contexto adicional, não pra criar um mini-dashboard clicável dentro do relatório principal.</p>

    <h2>Quando vale a pena usar tooltip em vez de um visual fixo</h2>
    <p>A regra prática: se o detalhe é algo que a maioria das pessoas vai querer ver sempre, deixe fixo na tela. Se é um contexto adicional que só faz sentido pra quem já está olhando um ponto específico do gráfico — tipo a composição de um mês específico num gráfico de tendência anual — esse é o caso certo pro tooltip personalizado.</p>

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
        <h3>Qual a diferença entre tooltip padrão e tooltip personalizado?</h3>
        <p>O padrão mostra só os campos arrastados pra área de Tooltips. O personalizado usa uma página inteira do relatório, com vários visuais, imagens e formatação.</p>
      </div>
      <div class="faq-item">
        <h3>Dá pra colocar um filtro dentro do tooltip personalizado?</h3>
        <p>Não interativamente. Tooltips de relatório não são interativos — nada de segmentação de dados ou navegação por Tab dentro dele.</p>
      </div>
      <div class="faq-item">
        <h3>Que tamanho de página devo usar pro tooltip personalizado?</h3>
        <p>Nas Configurações de Tela, defina o modelo de tamanho da página como Tooltip — ajusta as dimensões pro tamanho otimizado que um tooltip costuma ocupar.</p>
      </div>
      <div class="faq-item">
        <h3>O tooltip personalizado funciona em qualquer tipo de gráfico?</h3>
        <p>Funciona na maioria dos visuais principais, desde que você vincule a página de tooltip ao campo correto na área de Tooltips do visual.</p>
      </div>
    </div>

    <p style="margin-top:2.5rem; font-size:0.82rem; color:var(--ink-faint);">
      Fontes: <a href="https://learn.microsoft.com/pt-br/power-bi/create-reports/desktop-tooltips" target="_blank" rel="noopener">Microsoft Learn — Criar tooltips de relatório no Power BI</a>. Consultada em 19/07/2026.
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
