<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="canonical" href="https://techsantos.com.br/blog/seguranca-nivel-linha-rls-power-bi.php" />
<meta property="og:type" content="article" />
<meta property="og:locale" content="pt_BR" />
<meta property="og:url" content="https://techsantos.com.br/blog/seguranca-nivel-linha-rls-power-bi.php" />
<meta property="og:title" content="Segurança em nível de linha (RLS) no Power BI: cada vendedor só vê o que é dele — TECH SANTOS BR" />
<meta property="og:description" content="Row-Level Security (RLS) restringe o que cada usuário enxerga no mesmo relatório, sem depender de filtro manual. Veja como funciona e quando aplicar." />
<meta property="og:image" content="https://techsantos.com.br/assets/img/promo-curso-1.jpg" />
<meta name="twitter:card" content="summary_large_image" />
<title>Segurança em nível de linha (RLS) no Power BI: cada vendedor só vê o que é dele — TECH SANTOS BR</title>
<meta name="description" content="Row-Level Security (RLS) restringe o que cada usuário enxerga no mesmo relatório, sem depender de filtro manual. Veja como funciona e quando aplicar." />
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
    <div class="blog-meta">Power BI · Atualizado em 16/09/2026 · 5 min de leitura</div>
    <h1>Segurança em nível de linha (RLS) no Power BI: cada vendedor só vê o que é dele</h1>

    <p>Distribuir o mesmo relatório de vendas pra toda a equipe comercial é prático — até alguém perceber que dá pra ver os números de todos os colegas, não só os próprios. Segurança em Nível de Linha, ou RLS, resolve isso: a mesma versão do relatório mostra dados diferentes dependendo de quem está logado, sem precisar publicar uma cópia por vendedor.</p>

    <div class="key-takeaways">
      <span class="kt-label">Resumo rápido</span>
      <ul>
        <li>RLS restringe as linhas de dados que cada usuário vê, com base em regras definidas no modelo — não em filtros manuais no visual.</li>
        <li>As regras (roles) são criadas no Power BI Desktop e depois usuários ou grupos são atribuídos a elas no serviço do Power BI.</li>
        <li>Um mesmo relatório publicado serve para toda a equipe, cada pessoa vendo só a fatia de dados que a regra permite.</li>
        <li>RLS estática usa uma condição fixa (ex: região = "Sul"); RLS dinâmica usa uma função como USERPRINCIPALNAME() pra filtrar pelo próprio usuário logado.</li>
      </ul>
    </div>

    <h2>RLS estática vs. RLS dinâmica</h2>
    <p>Na RLS estática, você cria uma regra por grupo — por exemplo, uma role "Vendedores Sul" com filtro fixo região = "Sul", e atribui os usuários daquela região a essa role. Funciona bem para poucos grupos fixos. Na RLS dinâmica, a regra usa uma função como USERPRINCIPALNAME() combinada com uma tabela de mapeamento (usuário → vendedor), então uma única regra filtra automaticamente pelo usuário que abriu o relatório — sem precisar criar uma role por pessoa.</p>

    <video controls preload="metadata" playsinline>
          <source src="https://media.techsantos.com.br/reels/dica-powerbi-rls.mp4" type="video/mp4">
    </video>

    <h2>Como configurar uma regra de RLS</h2>
    <p>No Power BI Desktop, em Modelagem > Gerenciar Roles, você cria uma role e define a expressão DAX que filtra a tabela (por exemplo, uma condição na tabela de vendedores ou regiões). Depois de publicar o relatório no serviço, é nas configurações do conjunto de dados que você atribui usuários ou grupos de segurança a cada role — o relatório em si não muda, só quem pode ver o quê.</p>

    <h2>Erros comuns ao aplicar RLS</h2>
    <p>O mais frequente é esquecer que a regra precisa ser aplicada na tabela certa do modelo pra que o relacionamento propague o filtro pras outras tabelas — se a regra estiver numa tabela sem relacionamento direto com os fatos, o filtro simplesmente não funciona. Outro erro comum é testar a regra só como administrador (que costuma ver tudo) e não usar a opção "Exibir como" pra simular a visão de um usuário real antes de publicar.</p>

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
        <h3>RLS impede que um usuário exporte os dados que já vê?</h3>
        <p>Não sozinho — RLS controla o que aparece na tela, mas boas práticas de segurança de exportação também precisam ser configuradas separadamente.</p>
      </div>
      <div class="faq-item">
        <h3>Administradores do workspace também são afetados pelo RLS?</h3>
        <p>Por padrão, quem tem acesso de administrador ao workspace costuma ver os dados sem restrição, então o teste real precisa simular um usuário comum.</p>
      </div>
      <div class="faq-item">
        <h3>Dá para combinar mais de uma regra de RLS no mesmo modelo?</h3>
        <p>Sim, um modelo pode ter várias roles, cada uma com sua própria condição de filtro, atribuídas a grupos diferentes.</p>
      </div>
      <div class="faq-item">
        <h3>RLS dinâmica exige uma tabela extra no modelo?</h3>
        <p>Geralmente sim — uma tabela que relacione o e-mail ou usuário logado ao recorte de dados que ele deve ver (por exemplo, vendedor → região).</p>
      </div>
    </div>

    <p style="margin-top:2.5rem; font-size:0.82rem; color:var(--ink-faint);">
      Fontes: <a href="https://learn.microsoft.com/power-bi/enterprise/service-admin-rls" target="_blank" rel="noopener">Microsoft Learn — Segurança em nível de linha (RLS) no Power BI</a>.
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
