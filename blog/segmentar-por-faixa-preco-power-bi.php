<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="canonical" href="https://techsantos.com.br/blog/segmentar-por-faixa-preco-power-bi.php" />
<title>Agrupar por faixa de preço no Power BI — TECH SANTOS BR</title>
<meta name="description" content="Preço exato não agrupa nada sozinho. Veja como criar uma tabela de faixas de preço e relacionar por intervalo pra segmentar vendas no Power BI." />
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
      "name": "Como agrupar vendas por faixa de preço no Power BI?",
      "acceptedAnswer": { "@type": "Answer", "text": "Criando uma tabela separada com as faixas (por exemplo R$ 0-50, R$ 50-100, R$ 100-200) e relacionando essa tabela ao preço do produto por intervalo, não por valor exato — já que o preço exato normalmente não repete entre produtos." }
    },
    {
      "@type": "Question",
      "name": "Por que não dá pra agrupar direto pelo campo de preço?",
      "acceptedAnswer": { "@type": "Answer", "text": "Porque o preço exato raramente se repete entre produtos diferentes — cada um tem seu próprio valor. Agrupar direto por esse campo cria uma categoria pra cada preço único, o que não é segmentação nenhuma." }
    },
    {
      "@type": "Question",
      "name": "O Power BI tem um recurso pronto pra criar faixas?",
      "acceptedAnswer": { "@type": "Answer", "text": "Sim — o Power BI Desktop tem uma função de agrupamento numérico (binning) que cria faixas automaticamente a partir de uma coluna numérica, útil pra faixas de tamanho fixo. Faixas com tamanhos diferentes ou nomes personalizados costumam precisar de uma tabela própria." }
    },
    {
      "@type": "Question",
      "name": "Esse padrão serve só pra preço?",
      "acceptedAnswer": { "@type": "Answer", "text": "Não — a mesma lógica de tabela de faixas relacionada por intervalo serve pra idade, peso, distância, tempo de resposta ou qualquer métrica contínua que precise virar categoria pra análise." }
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
    <h1>Como agrupar vendas por faixa de preço no Power BI</h1>

    <p>Você quer ver quanto vendeu em produtos de R$ 0 a R$ 50, R$ 50 a R$ 100 e assim por diante — mas a tabela só tem o preço exato de cada produto, e arrastar esse campo direto pro relatório não agrupa nada. Cada produto tem seu próprio valor, então "agrupar" pelo preço exato só cria uma categoria por produto.</p>

    <div class="key-takeaways">
      <span class="kt-label">Resumo rápido</span>
      <ul>
        <li>Preço exato não agrupa sozinho — cada produto tem seu próprio valor único.</li>
        <li>A solução é criar uma tabela separada com as faixas de preço desejadas.</li>
        <li>O relacionamento entre produto e faixa é por intervalo, não por chave igual.</li>
        <li>O mesmo padrão serve pra qualquer métrica contínua: idade, peso, distância, tempo.</li>
      </ul>
    </div>

    <h2>Por que preço exato não serve pra segmentação</h2>
    <p>Segmentar significa juntar itens parecidos numa mesma categoria — mas se cada produto tem um preço diferente (R$ 47, R$ 189, R$ 6, e por aí vai), usar o preço exato como categoria não junta nada: cria uma categoria pra cada produto, o que é o oposto de segmentar. Pra agrupar de verdade, é preciso definir faixas — intervalos de valor que vários produtos diferentes podem cair dentro.</p>
    <video controls preload="metadata" playsinline>
          <source src="https://media.techsantos.com.br/reels/dica-novidade10-segmentacao.mp4" type="video/mp4">
    </video>

    <h2>Criando uma tabela de faixas de preço</h2>
    <p>A forma mais flexível de resolver isso é criar uma tabela nova, separada da tabela de produtos, com uma linha por faixa: "R$ 0-50", "R$ 50-100", "R$ 100-200", e assim por diante — cada uma com seu valor mínimo e máximo. Essa tabela não existe na fonte de dados original; ela é criada especificamente pra dar suporte à análise por faixa.</p>

    <h2>Por que o relacionamento é por intervalo, não por chave igual</h2>
    <p>Um relacionamento comum no Power BI conecta duas tabelas por uma chave idêntica — o mesmo código de produto nas duas pontas, por exemplo. Faixa de preço não funciona assim: o preço de um produto (R$ 47) não é igual a nenhum valor da tabela de faixas, ele está <em>dentro</em> de uma faixa (R$ 0-50). Por isso essa relação normalmente é resolvida em DAX, com uma medida que verifica em qual faixa o preço de cada produto se encaixa, em vez de um relacionamento físico tradicional entre as tabelas.</p>
    <p>O ganho prático de fazer isso numa tabela separada, em vez de calcular a faixa direto na tabela de produtos, é a flexibilidade: mudar os limites das faixas vira uma edição na tabela de faixas, sem tocar na base de produtos original.</p>

    <h2>Quando usar o agrupamento numérico automático do Power BI</h2>
    <p>Pra faixas de tamanho fixo e regular — de 10 em 10, de 100 em 100 — o Power BI Desktop tem um recurso de agrupamento numérico (binning) que cria essas faixas automaticamente a partir da coluna de preço, sem precisar montar a tabela na mão. Vale usar esse atalho quando as faixas não precisam de nomes personalizados nem de tamanhos diferentes entre si; quando precisam, a tabela de faixas manual continua sendo a opção mais flexível.</p>

    <div class="blog-cta">
      <h2>Quer aprender modelagem de dados e DAX de verdade?</h2>
      <p>O curso completo de Power BI da TECH SANTOS BR cobre modelagem de dados, Power Query e DAX — do zero até segmentações e dashboards publicados de verdade.</p>
      <div class="hero-cta">
        <a class="btn btn-primary" href="/aula-gratis.php">Assistir aula grátis</a>
        <a class="btn btn-ghost" href="/curso-power-bi.php">Conhecer o curso completo</a>
      </div>
    </div>

    <h2>Perguntas frequentes</h2>
    <div class="blog-faq-grid">
      <div class="faq-item">
        <h3>Como agrupar vendas por faixa de preço no Power BI?</h3>
        <p>Criando uma tabela separada com as faixas e relacionando ao preço do produto por intervalo, não por valor exato.</p>
      </div>
      <div class="faq-item">
        <h3>Por que não dá pra agrupar direto pelo campo de preço?</h3>
        <p>Porque o preço exato raramente se repete entre produtos — agrupar por ele cria uma categoria por produto, não uma segmentação real.</p>
      </div>
      <div class="faq-item">
        <h3>O Power BI tem um recurso pronto pra criar faixas?</h3>
        <p>Sim, o agrupamento numérico (binning) do Power BI Desktop cria faixas automáticas de tamanho fixo. Faixas personalizadas costumam precisar de uma tabela própria.</p>
      </div>
      <div class="faq-item">
        <h3>Esse padrão serve só pra preço?</h3>
        <p>Não — serve pra idade, peso, distância, tempo de resposta ou qualquer métrica contínua que precise virar categoria.</p>
      </div>
    </div>

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
