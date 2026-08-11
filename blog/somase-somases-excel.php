<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="canonical" href="https://techsantos.com.br/blog/somase-somases-excel.php" />
<meta property="og:type" content="article" />
<meta property="og:locale" content="pt_BR" />
<meta property="og:url" content="https://techsantos.com.br/blog/somase-somases-excel.php" />
<meta property="og:title" content="SOMASE e SOMASES no Excel: como somar só o que interessa — TECH SANTOS BR" />
<meta property="og:description" content="SOMASE soma um intervalo só na parte que bate com um critério; SOMASES faz o mesmo com várias condições. Veja a sintaxe e exemplos práticos." />
<meta property="og:image" content="https://techsantos.com.br/assets/img/promo-curso-1.jpg" />
<meta name="twitter:card" content="summary_large_image" />
<title>SOMASE e SOMASES no Excel: como somar só o que interessa — TECH SANTOS BR</title>
<meta name="description" content="SOMASE soma um intervalo só na parte que bate com um critério; SOMASES faz o mesmo com várias condições. Veja a sintaxe e exemplos práticos." />
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
      "name": "Qual a diferença entre SOMASE e SOMASES?",
      "acceptedAnswer": { "@type": "Answer", "text": "SOMASE soma um intervalo com base em uma única condição. SOMASES faz o mesmo cálculo, mas aceita várias condições ao mesmo tempo — todas precisam ser verdadeiras pra linha entrar na soma (Microsoft Support)." }
    },
    {
      "@type": "Question",
      "name": "Por que minha SOMASE está retornando zero?",
      "acceptedAnswer": { "@type": "Answer", "text": "A causa mais comum é o critério não bater com o texto exato da coluna de comparação — diferença de espaço, acento ou maiúscula/minúscula gerada por dado importado costuma quebrar a correspondência silenciosamente." }
    },
    {
      "@type": "Question",
      "name": "Dá pra usar SOMASE com data, tipo 'depois de tal dia'?",
      "acceptedAnswer": { "@type": "Answer", "text": "Dá, usando operadores de comparação dentro do critério entre aspas, como \">01/01/2026\". A célula com a data de referência também pode ser concatenada ao operador dentro da fórmula." }
    },
    {
      "@type": "Question",
      "name": "SOMASES aceita mais de duas condições?",
      "acceptedAnswer": { "@type": "Answer", "text": "Aceita várias — a função soma um intervalo que atenda a múltiplos critérios ao mesmo tempo, e cada par de intervalo-critério adicional é só mais um argumento na mesma fórmula (Microsoft Support)." }
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
    <div class="blog-meta">Excel · Atualizado em 19/07/2026 · 4 min de leitura</div>
    <h1>SOMASE e SOMASES no Excel: como somar só o que interessa</h1>

    <p>Somar linha por linha no dedo pra saber o total de uma região ou de um vendedor específico funciona até a planilha chegar em algumas centenas de linhas — depois disso, vira risco de erro e perda de tempo. SOMASE e SOMASES resolvem isso numa fórmula só: somam um intervalo, mas só a parte que bate com o critério que você definir.</p>

    <div class="key-takeaways">
      <span class="kt-label">Resumo rápido</span>
      <ul>
        <li>SOMASE soma um intervalo com base em uma única condição; SOMASES aceita várias condições ao mesmo tempo (Microsoft Support).</li>
        <li>A sintaxe muda de ordem entre as duas: SOMASE pede o critério antes do intervalo de soma, SOMASES pede o intervalo de soma primeiro.</li>
        <li>Critério com texto precisa vir entre aspas; critério com referência de célula, não.</li>
        <li>Zero como resultado quase sempre indica que o critério não bate exatamente com o texto da coluna comparada.</li>
      </ul>
    </div>

    <h2>Como funciona a função SOMASE</h2>
    <p>SOMASE soma valores em um intervalo que atende a critérios especificados — por exemplo, a fórmula <code>=SOMASE(B2:B5;"Pedro";C2:C5)</code> soma só os valores em C2:C5 onde a célula correspondente em B2:B5 é igual a "Pedro" (Microsoft Support). Repare na ordem dos argumentos: primeiro o intervalo que vai ser comparado ao critério, depois o critério em si, e só por último o intervalo que efetivamente vai ser somado.</p>
    <video controls preload="metadata" playsinline>
          <source src="https://media.techsantos.com.br/reels/dica-excel-somase.mp4" type="video/mp4">
    </video>
    <p>Esse terceiro argumento é opcional: se você omitir, o Excel soma o próprio intervalo do critério. Na prática, quase sempre vale escrever os três argumentos explicitamente — deixa a fórmula mais fácil de revisar meses depois.</p>

    <h2>Quando usar SOMASES em vez de SOMASE</h2>
    <p>Assim que você precisa de duas condições ou mais — "só a região Sul" e "só produto Carne", ao mesmo tempo — SOMASE não dá conta sozinha. SOMASES adiciona todos os argumentos que atendem a múltiplos critérios, com um exemplo oficial como <code>=SOMASES(D2:D11;A2:A11;"Sul";C2:C11;"Carne")</code> (Microsoft Support). Note que aqui o intervalo de soma vem primeiro, ao contrário da ordem usada em SOMASE — essa inversão é a fonte mais comum de erro de quem migra de uma função pra outra.</p>
    <p>Cada condição extra na SOMASES é só mais um par intervalo-critério adicionado na mesma fórmula: quantas combinações forem precisas, todas precisam ser verdadeiras na mesma linha pra ela entrar na soma.</p>

    <h2>Por que a fórmula está dando zero ou está errada</h2>
    <p>O motivo mais comum é o critério não bater exatamente com o texto da coluna comparada — um espaço extra vindo de um sistema exportado, uma diferença de maiúscula/minúscula, ou um acento faltando fazem a comparação falhar silenciosamente, sem erro visível. Vale conferir com <code>=EXATO()</code> se o texto realmente é idêntico.</p>
    <p>Outro erro comum: os intervalos de critério e de soma com tamanhos diferentes. Se o intervalo do critério tem 50 linhas e o de soma tem 45, o Excel recusa a fórmula porque não consegue alinhar linha a linha entre os dois intervalos.</p>

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
        <h3>Qual a diferença entre SOMASE e SOMASES?</h3>
        <p>SOMASE soma um intervalo com base em uma única condição. SOMASES faz o mesmo cálculo, mas aceita várias condições ao mesmo tempo — todas precisam ser verdadeiras pra linha entrar na soma.</p>
      </div>
      <div class="faq-item">
        <h3>Por que minha SOMASE está retornando zero?</h3>
        <p>A causa mais comum é o critério não bater com o texto exato da coluna de comparação — diferença de espaço, acento ou maiúscula/minúscula costuma quebrar a correspondência silenciosamente.</p>
      </div>
      <div class="faq-item">
        <h3>Dá pra usar SOMASE com data, tipo "depois de tal dia"?</h3>
        <p>Dá, usando operadores de comparação dentro do critério entre aspas, como ">01/01/2026". A célula com a data de referência também pode ser concatenada ao operador dentro da fórmula.</p>
      </div>
      <div class="faq-item">
        <h3>SOMASES aceita mais de duas condições?</h3>
        <p>Aceita várias — cada par de intervalo-critério adicional é só mais um argumento na mesma fórmula.</p>
      </div>
    </div>

    <p style="margin-top:2.5rem; font-size:0.82rem; color:var(--ink-faint);">
      Fontes: <a href="https://support.microsoft.com/pt-br/excel/functions/sumif-function" target="_blank" rel="noopener">Microsoft Support — Função SOMASE</a>,
      <a href="https://support.microsoft.com/pt-br/office/fun%C3%A7%C3%A3o-somases-c9e748f5-7ea7-455d-9406-611cebce642b" target="_blank" rel="noopener">Microsoft Support — Função SOMASES</a>. Consultadas em 19/07/2026.
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
