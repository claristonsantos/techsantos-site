<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>PROCV ou PROCX: qual usar no Excel em 2026? — TECH SANTOS BR</title>
<meta name="description" content="PROCX substituiu o PROCV no Excel 2021 e no Microsoft 365, mas o PROCV ainda é necessário no Excel 2016/2019. Veja quando usar cada um, com exemplos." />
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
      "name": "PROCX substitui o PROCV completamente?",
      "acceptedAnswer": { "@type": "Answer", "text": "Na prática sim, para quem tem Excel 2021 ou Microsoft 365 - o PROCX faz tudo que o PROCV faz e resolve suas principais limitações. Mas o PROCV continua necessário em planilhas que precisam abrir no Excel 2016 ou 2019, onde o PROCX não existe (Microsoft Support)." }
    },
    {
      "@type": "Question",
      "name": "Por que minha fórmula de PROCX não funciona?",
      "acceptedAnswer": { "@type": "Answer", "text": "O motivo mais comum é a versão do Excel: o PROCX só está disponível no Excel 2021, Excel para a web e Microsoft 365. Em versões anteriores, o Excel retorna erro de nome porque a função simplesmente não existe ali." }
    },
    {
      "@type": "Question",
      "name": "PROCX é mais rápido que PROCV?",
      "acceptedAnswer": { "@type": "Answer", "text": "Sim, o PROCX tende a calcular mais rápido em bases grandes, principalmente porque não depende de contar colunas manualmente e lida melhor com correspondência exata por padrão, evitando o erro silencioso de trazer o valor errado." }
    },
    {
      "@type": "Question",
      "name": "Preciso reescrever todas as fórmulas de PROCV que já tenho?",
      "acceptedAnswer": { "@type": "Answer", "text": "Não é obrigatório. O PROCV continua funcionando normalmente nas versões atuais do Excel. Vale migrar aos poucos, começando pelas planilhas que você mais mexe ou que têm mais colunas para contar." }
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
    <div class="blog-meta">Excel · Atualizado em 17/07/2026 · 6 min de leitura</div>
    <h1>PROCV ou PROCX: qual usar no Excel em 2026?</h1>

    <p>Se sua planilha cresceu e o PROCV começou a quebrar toda vez que alguém insere uma coluna no meio da tabela, você já sentiu na pele o motivo pelo qual a Microsoft criou o PROCX. A dúvida de qual função usar hoje é simples de responder, mas a resposta completa depende da versão do Excel que você (e quem recebe sua planilha) realmente usa.</p>

    <div class="key-takeaways">
      <span class="kt-label">Resumo rápido</span>
      <ul>
        <li>O PROCX está disponível no Excel 2021, no Excel para a web e no Microsoft 365 — mas <strong>não existe</strong> no Excel 2016 nem no Excel 2019 (Microsoft Support).</li>
        <li>PROCX busca em qualquer direção (não só da esquerda pra direita) e não exige contar o número da coluna.</li>
        <li>PROCV continua sendo a opção certa quando a planilha precisa abrir em uma versão mais antiga do Excel.</li>
        <li>Migrar não precisa ser tudo de uma vez — dá pra ter as duas funções na mesma pasta de trabalho sem problema.</li>
      </ul>
    </div>

    <h2>PROCV e PROCX fazem a mesma coisa?</h2>
    <p>No fundo, sim: as duas funções procuram um valor em uma coluna e trazem de volta uma informação correspondente em outra coluna da mesma linha. A diferença real está em <em>como</em> cada uma faz essa busca, e é aí que o PROCV mostra suas limitações mais antigas.</p>
    <p>O PROCV sempre busca da esquerda para a direita e exige que você conte manualmente em qual posição está a coluna que quer trazer — se alguém insere uma coluna nova no meio da tabela, esse número muda e a fórmula passa a trazer o dado errado, sem avisar que algo mudou. O PROCX resolve isso referenciando a coluna de destino diretamente, então inserir uma coluna no meio não quebra mais nada.</p>

    <h2>Quais as vantagens reais do PROCX sobre o PROCV?</h2>
    <p>A função XLOOKUP (PROCX na versão em português) pode pesquisar um intervalo e retornar o item correspondente à primeira correspondência que encontrar, inclusive buscando em qualquer direção — para cima, para baixo, para a esquerda ou para a direita (Microsoft Support, página oficial da função XLOOKUP). Isso sozinho já elimina boa parte dos truques que professores de Excel ensinam há anos só pra contornar a limitação direcional do PROCV.</p>
    <p>Outro ganho prático: se não encontrar uma correspondência exata, o PROCX pode retornar a correspondência mais próxima (aproximada) sem precisar de um quarto argumento configurado errado por engano — um erro comum de quem está aprendendo PROCV, que esquece de fixar a busca como exata e acaba trazendo valores incorretos silenciosamente.</p>
    <video controls preload="metadata" playsinline>
      <source src="/assets/social-video/dica-excel-procx.mp4" type="video/mp4">
    </video>

    <h2>Quando ainda preciso usar o PROCV?</h2>
    <p>A resposta mais honesta: quando a planilha precisa abrir em um Excel que não tem PROCX. A própria Microsoft confirma que o XLOOKUP não está disponível no Excel 2016 nem no Excel 2019 — só a partir do Excel 2021, do Excel para a web e das assinaturas do Microsoft 365 (Microsoft Support, "O que há de novo no Excel 2021 para Windows").</p>
    <p>Isso importa de verdade em três cenários: planilhas que vão circular entre empresas diferentes (você não controla a versão de quem vai abrir), modelos herdados de anos atrás que ninguém quer arriscar reescrever inteiro, e treinamentos corporativos onde parte da turma ainda está numa licença perpétua mais antiga. Fora desses casos, não existe motivo forte pra continuar escrevendo PROCV novo.</p>

    <h2>Como converter uma fórmula de PROCV pra PROCX</h2>
    <p>Na prática, a conversão costuma ser direta. Um PROCV como <code>=PROCV(A2;Tabela1;3;FALSO)</code> vira algo como <code>=PROCX(A2;Tabela1[Coluna_busca];Tabela1[Coluna_retorno])</code> — você troca "contar até a terceira coluna" por "apontar direto pra coluna que quer trazer". Isso é exatamente o tipo de detalhe que costuma travar quem está migrando sozinho: sai o número da posição, entra a referência direta à coluna.</p>
    <p>Uma boa prática ao migrar: comece pelas planilhas que você mais edita no dia a dia, não pelas maiores. São nelas que o ganho de não quebrar fórmula ao inserir coluna aparece primeiro — e é onde você vai sentir a diferença antes de decidir migrar o resto.</p>

    <h2>PROCX substitui o PROCV pra sempre?</h2>
    <p>Para quem já está no Microsoft 365 ou no Excel 2021 em diante, o PROCX é a opção recomendada para fórmulas novas — mais simples de ler, mais difícil de quebrar sem querer. Mas o PROCV não vai a lugar nenhum: ele continua funcionando normalmente nas versões atuais, então nenhuma fórmula antiga vai parar de funcionar por causa disso. A escolha entre os dois é sobre o que você vai escrever <em>daqui pra frente</em>, não sobre reescrever tudo que já existe.</p>

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
        <h3>PROCX substitui o PROCV completamente?</h3>
        <p>Na prática sim, para quem tem Excel 2021 ou Microsoft 365 — o PROCX faz tudo que o PROCV faz e resolve suas principais limitações. Mas o PROCV continua necessário em planilhas que precisam abrir no Excel 2016 ou 2019, onde o PROCX não existe.</p>
      </div>
      <div class="faq-item">
        <h3>Por que minha fórmula de PROCX não funciona?</h3>
        <p>O motivo mais comum é a versão do Excel: o PROCX só está disponível no Excel 2021, Excel para a web e Microsoft 365. Em versões anteriores, o Excel retorna erro de nome porque a função simplesmente não existe ali.</p>
      </div>
      <div class="faq-item">
        <h3>PROCX é mais rápido que PROCV?</h3>
        <p>Sim, o PROCX tende a calcular mais rápido em bases grandes, principalmente porque não depende de contar colunas manualmente e lida melhor com correspondência exata por padrão, evitando o erro silencioso de trazer o valor errado.</p>
      </div>
      <div class="faq-item">
        <h3>Preciso reescrever todas as fórmulas de PROCV que já tenho?</h3>
        <p>Não é obrigatório. O PROCV continua funcionando normalmente nas versões atuais do Excel. Vale migrar aos poucos, começando pelas planilhas que você mais mexe ou que têm mais colunas para contar.</p>
      </div>
    </div>

    <p style="margin-top:2.5rem; font-size:0.82rem; color:var(--ink-faint);">
      Fontes: <a href="https://support.microsoft.com/en-us/excel/functions/xlookup-function" target="_blank" rel="noopener">Microsoft Support — Função XLOOKUP</a>,
      <a href="https://support.microsoft.com/en-us/office/what-s-new-in-excel-2021-for-windows-f953fe71-8f85-4423-bef9-8a195c7a1100" target="_blank" rel="noopener">Microsoft Support — O que há de novo no Excel 2021</a>,
      <a href="https://support.microsoft.com/en-us/office/vlookup-function-0bbc8083-26fe-4963-8ab8-93a18ad188a1" target="_blank" rel="noopener">Microsoft Support — Função VLOOKUP</a>. Consultadas em 17/07/2026.
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
