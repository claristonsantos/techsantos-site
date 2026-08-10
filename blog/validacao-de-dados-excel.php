<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="canonical" href="https://techsantos.com.br/blog/validacao-de-dados-excel.php" />
<meta property="og:type" content="article" />
<meta property="og:locale" content="pt_BR" />
<meta property="og:url" content="https://techsantos.com.br/blog/validacao-de-dados-excel.php" />
<meta property="og:title" content="Validação de Dados no Excel: como travar o que a pessoa digita — TECH SANTOS BR" />
<meta property="og:description" content="Validação de Dados trava a célula numa lista de opções e evita erro de digitação em planilha compartilhada. Veja como configurar passo a passo." />
<meta property="og:image" content="https://techsantos.com.br/assets/img/promo-curso-1.jpg" />
<meta name="twitter:card" content="summary_large_image" />
<title>Validação de Dados no Excel: como travar o que a pessoa digita — TECH SANTOS BR</title>
<meta name="description" content="Validação de Dados trava a célula numa lista de opções e evita erro de digitação em planilha compartilhada. Veja como configurar passo a passo." />
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
      "name": "Validação de Dados impede colar valor errado na célula?",
      "acceptedAnswer": { "@type": "Answer", "text": "Por padrão, colar (Ctrl+V) pode contornar a regra em versões mais antigas do Excel — o alerta de erro dispara com mais confiabilidade quando a pessoa digita direto na célula. Vale testar o comportamento na versão que sua equipe usa." }
    },
    {
      "@type": "Question",
      "name": "Dá pra criar uma lista suspensa que puxa de outra planilha?",
      "acceptedAnswer": { "@type": "Answer", "text": "Dá. Em vez de digitar as opções separadas por ponto e vírgula, selecione Lista em Permitir e aponte o campo Origem pra um intervalo de células — inclusive de outra aba, transformando o intervalo em Tabela antes pra a lista crescer automaticamente (Microsoft Support)." }
    },
    {
      "@type": "Question",
      "name": "Como faço a mensagem de erro aparecer com texto personalizado?",
      "acceptedAnswer": { "@type": "Answer", "text": "Na caixa de Validação de Dados, abra a guia Alerta de Erro, escolha o Estilo (Parar, Aviso ou Informação) e escreva seu próprio título e mensagem — assim quem digitar errado entende o motivo, em vez de ver só um erro genérico do Excel." }
    },
    {
      "@type": "Question",
      "name": "Consigo remover a Validação de Dados depois de aplicada?",
      "acceptedAnswer": { "@type": "Answer", "text": "Consegue. Selecione as células, abra Dados → Validação de Dados e clique em Limpar Tudo — isso remove a regra sem apagar o conteúdo que já estava digitado nas células." }
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
    <div class="blog-meta">Excel · Atualizado em 19/07/2026 · 4 min de leitura</div>
    <h1>Validação de Dados no Excel: como travar o que a pessoa digita</h1>

    <p>Uma planilha compartilhada com o time inteiro só funciona se todo mundo digitar do mesmo jeito — "SP", "sp" e "São Paulo" na mesma coluna viram três categorias diferentes num relatório depois. A Validação de Dados resolve isso na raiz: trava a célula numa lista de opções, e ninguém mais digita fora do combinado.</p>

    <div class="key-takeaways">
      <span class="kt-label">Resumo rápido</span>
      <ul>
        <li>Validação de Dados restringe o que pode ser digitado numa célula: número inteiro, decimal, data, texto de tamanho limitado ou lista fixa (Microsoft Support).</li>
        <li>O tipo mais usado é Lista, que transforma a célula numa lista suspensa.</li>
        <li>Dá pra personalizar a mensagem de erro que aparece quando alguém digita algo fora da regra.</li>
        <li>A lista pode apontar pra um intervalo de outra aba, inclusive uma Tabela que cresce sozinha.</li>
      </ul>
    </div>

    <h2>O que é Validação de Dados e pra que ela serve?</h2>
    <p>A Validação de Dados restringe o tipo de dado ou os valores que os usuários podem inserir numa célula, e um dos usos mais comuns é criar uma lista suspensa (Microsoft Support). Em vez de confiar que todo mundo vai lembrar de digitar exatamente "Concluído" e não "concluido" ou "OK", você limita as opções disponíveis — o erro de digitação simplesmente deixa de ser possível.</p>
    <video controls preload="metadata" playsinline>
          <source src="https://media.techsantos.com.br/reels/dica-excel-validacao-dados.mp4" type="video/mp4">
    </video>

    <h2>Como criar uma lista suspensa com Validação de Dados</h2>
    <p>Selecione as células onde quer aplicar a regra, vá em Dados → Validação de Dados e, na guia Configurações, em Permitir, escolha Lista. No campo Origem, digite as opções separadas por ponto e vírgula (tipo <code>Sim;Não;Pendente</code>) ou aponte pra um intervalo de células que já contém essas opções (Microsoft Support).</p>
    <p>A segunda forma é mais fácil de manter: se as opções mudam com frequência, apontar pra um intervalo (idealmente formatado como Tabela) significa que adicionar uma opção nova na lista de origem já atualiza a lista suspensa em todas as células, sem editar a regra de novo.</p>

    <h2>Outros tipos de restrição além da lista</h2>
    <p>Além de Lista, a guia Permitir oferece Número Inteiro e Decimal (pra travar valores fora de uma faixa), Data e Hora (pra impedir datas fora de um período válido), Comprimento de Texto (pra limitar quantos caracteres cabem, útil em campos tipo CPF ou código) e Personalizado, pra quem quer validar com uma fórmula própria.</p>
    <p>Vale usar a guia Mensagem de Entrada pra mostrar uma dica assim que a célula é selecionada, antes mesmo da pessoa errar — e a guia Alerta de Erro pra personalizar o que aparece quando ela digita algo fora da regra, escolhendo entre bloquear totalmente (Parar) ou só avisar (Aviso).</p>

    <h2>Erros comuns ao configurar Validação de Dados</h2>
    <p>Um erro frequente é aplicar a regra depois que a planilha já tem dados digitados errado — a Validação de Dados só impede entradas <em>novas</em> fora do padrão, ela não corrige o que já estava lá. Pra achar essas células problemáticas, use Localizar Células com Regras de Validação de Dados, em Localizar e Selecionar.</p>
    <p>Outro ponto de atenção: colar dados (Ctrl+V) por cima de uma célula validada pode, em algumas versões do Excel, contornar a regra — o comportamento mais confiável de bloqueio acontece quando a pessoa digita direto na célula.</p>

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
        <h3>Validação de Dados impede colar valor errado na célula?</h3>
        <p>Por padrão, colar (Ctrl+V) pode contornar a regra em versões mais antigas do Excel — o alerta de erro dispara com mais confiabilidade quando a pessoa digita direto na célula.</p>
      </div>
      <div class="faq-item">
        <h3>Dá pra criar uma lista suspensa que puxa de outra planilha?</h3>
        <p>Dá. Em vez de digitar as opções separadas por ponto e vírgula, selecione Lista em Permitir e aponte o campo Origem pra um intervalo de células — inclusive de outra aba.</p>
      </div>
      <div class="faq-item">
        <h3>Como faço a mensagem de erro aparecer com texto personalizado?</h3>
        <p>Na caixa de Validação de Dados, abra a guia Alerta de Erro, escolha o Estilo e escreva seu próprio título e mensagem — assim quem digitar errado entende o motivo.</p>
      </div>
      <div class="faq-item">
        <h3>Consigo remover a Validação de Dados depois de aplicada?</h3>
        <p>Consegue. Selecione as células, abra Dados → Validação de Dados e clique em Limpar Tudo — isso remove a regra sem apagar o conteúdo já digitado.</p>
      </div>
    </div>

    <p style="margin-top:2.5rem; font-size:0.82rem; color:var(--ink-faint);">
      Fontes: <a href="https://support.microsoft.com/pt-br/office/aplicar-valida%C3%A7%C3%A3o-de-dados-a-c%C3%A9lulas-29fecbcc-d1b9-42c1-9d76-eff3ce5f7249" target="_blank" rel="noopener">Microsoft Support — Aplicar validação de dados a células</a>,
      <a href="https://support.microsoft.com/pt-br/office/criar-uma-lista-suspensa-7693307a-59ef-400a-b769-c5402dce407b" target="_blank" rel="noopener">Microsoft Support — Criar uma lista suspensa</a>. Consultadas em 19/07/2026.
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
