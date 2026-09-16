<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="canonical" href="https://techsantos.com.br/blog/lambda-excel-funcao-personalizada.php" />
<meta property="og:type" content="article" />
<meta property="og:locale" content="pt_BR" />
<meta property="og:url" content="https://techsantos.com.br/blog/lambda-excel-funcao-personalizada.php" />
<meta property="og:title" content="LAMBDA no Excel: crie sua própria função sem abrir o VBA — TECH SANTOS BR" />
<meta property="og:description" content="A função LAMBDA permite nomear e reutilizar uma fórmula complexa como se fosse uma função nativa do Excel, sem escrever macro em VBA." />
<meta property="og:image" content="https://techsantos.com.br/assets/img/promo-curso-1.jpg" />
<meta name="twitter:card" content="summary_large_image" />
<title>LAMBDA no Excel: crie sua própria função sem abrir o VBA — TECH SANTOS BR</title>
<meta name="description" content="A função LAMBDA permite nomear e reutilizar uma fórmula complexa como se fosse uma função nativa do Excel, sem escrever macro em VBA." />
<link rel="icon" type="image/png" href="/assets/img/favicon-32.png" />
<link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png" />
<link rel="stylesheet" href="/assets/css/style.css" />
<?php require_once __DIR__ . '/../inc/meta-pixel.php'; ?>
<?php require_once __DIR__ . '/../inc/google-analytics.php'; ?>
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
    <div class="blog-meta">Excel · Atualizado em 16/09/2026 · 4 min de leitura</div>
    <h1>LAMBDA no Excel: crie sua própria função sem abrir o VBA</h1>

    <p>Toda planilha complexa tem aquela fórmula gigante, repetida em dezenas de células, que ninguém mais lembra exatamente por que foi escrita daquele jeito. A função LAMBDA ataca esse problema de frente: ela deixa você nomear uma fórmula — com seus próprios parâmetros de entrada — e reutilizá-la em qualquer lugar da planilha como se fosse uma função nativa do Excel, sem precisar abrir o editor de VBA.</p>

    <div class="key-takeaways">
      <span class="kt-label">Resumo rápido</span>
      <ul>
        <li>LAMBDA cria uma função personalizada a partir de uma fórmula, com parâmetros de entrada definidos por você.</li>
        <li>A função criada pode ser salva no Gerenciador de Nomes e reutilizada em qualquer célula da pasta de trabalho, com o nome que você escolher.</li>
        <li>Diferente de uma macro em VBA, é uma fórmula nativa — funciona em qualquer célula, sem exigir habilitar macros.</li>
        <li>Costuma ser combinada com funções recursivas ou com LET, para simplificar cálculos que hoje exigem várias colunas auxiliares.</li>
      </ul>
    </div>

    <h2>A sintaxe básica de uma LAMBDA</h2>
    <p>Uma LAMBDA é escrita como =LAMBDA(parâmetro1; parâmetro2; ...; cálculo), onde os parâmetros são os valores de entrada e o cálculo é a fórmula que usa esses parâmetros. Por exemplo, uma função pra converter Celsius em Fahrenheit ficaria =LAMBDA(celsius; celsius*9/5+32). Sozinha, essa fórmula só funciona testada com um valor fixo — pra virar uma função reutilizável, o próximo passo é nomeá-la.</p>

    <video controls preload="metadata" playsinline>
          <source src="https://media.techsantos.com.br/reels/dica-excel-lambda.mp4" type="video/mp4">
    </video>

    <h2>Transformando a LAMBDA numa função com nome</h2>
    <p>No Gerenciador de Nomes (Fórmulas > Gerenciador de Nomes > Novo), você cola a fórmula LAMBDA e dá um nome a ela, por exemplo CELSIUS_PARA_FAHRENHEIT. A partir daí, em qualquer célula da pasta de trabalho, digitar =CELSIUS_PARA_FAHRENHEIT(A1) funciona exatamente como uma função nativa do Excel — com autocompletar e tudo.</p>

    <h2>Por que isso é diferente de uma macro em VBA</h2>
    <p>Uma função criada com LAMBDA é uma fórmula, não um código executado por evento — ela recalcula automaticamente como qualquer outra célula da planilha, funciona em arquivos sem macros habilitadas e pode ser copiada entre pastas de trabalho colando o nome definido. Pra quem nunca programou em VBA, é uma forma de ganhar reuso de lógica sem sair do universo de fórmulas.</p>

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
        <h3>Preciso saber VBA para usar LAMBDA?</h3>
        <p>Não. LAMBDA é uma função de planilha, escrita com a mesma sintaxe de fórmulas comuns do Excel.</p>
      </div>
      <div class="faq-item">
        <h3>Uma função LAMBDA funciona em qualquer versão do Excel?</h3>
        <p>Está disponível no Excel para Microsoft 365 — versões mais antigas do Excel não têm suporte a LAMBDA.</p>
      </div>
      <div class="faq-item">
        <h3>Dá para uma LAMBDA chamar a si mesma (recursão)?</h3>
        <p>Sim, é possível escrever LAMBDAs recursivas, úteis para cálculos que se repetem em etapas, como somas acumuladas customizadas.</p>
      </div>
      <div class="faq-item">
        <h3>A função criada fica salva só naquela planilha?</h3>
        <p>Fica salva na pasta de trabalho onde foi criada; para usar em outro arquivo, é preciso recriar ou copiar a definição do nome.</p>
      </div>
    </div>

    <p style="margin-top:2.5rem; font-size:0.82rem; color:var(--ink-faint);">
      Fontes: <a href="https://learn.microsoft.com/office/client-developer/excel/lambda-function" target="_blank" rel="noopener">Microsoft Learn — Função LAMBDA no Excel</a>.
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
