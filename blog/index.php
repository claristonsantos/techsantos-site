<?php
declare(strict_types=1);

// Lista de posts publicados — array simples, sem banco. Pra adicionar um
// post novo: cria o arquivo blog/<slug>.php e adiciona uma entrada aqui.
$posts = [
    [
        'slug' => 'multi-moeda-power-bi',
        'eyebrow' => 'Power BI',
        'title' => 'Relatório em dólar não bate? Modelagem multi-moeda no Power BI',
        'excerpt' => 'Não existe uma fórmula universal de conversão de moeda. Veja os 3 cenários de modelagem multi-moeda e qual abordagem usar em cada um.',
        'date' => '2026-08-03',
    ],
    [
        'slug' => 'segmentar-por-faixa-preco-power-bi',
        'eyebrow' => 'Power BI',
        'title' => 'Como agrupar vendas por faixa de preço no Power BI',
        'excerpt' => 'Preço exato não agrupa nada sozinho. Veja como criar uma tabela de faixas de preço e relacionar por intervalo pra segmentar vendas.',
        'date' => '2026-08-03',
    ],
    [
        'slug' => 'dimensao-que-muda-devagar-power-bi',
        'eyebrow' => 'Power BI',
        'title' => 'Gerente mudou e o relatório antigo quebrou? É dimensão que muda devagar',
        'excerpt' => 'Cliente mudou de gerente e o relatório do mês passado ficou errado? Isso tem nome: dimensão que muda devagar (SCD). Veja quando sobrescrever ou guardar histórico.',
        'date' => '2026-08-03',
    ],
    [
        'slug' => 'cabecalho-detalhe-tabela-fato-power-bi',
        'eyebrow' => 'Power BI',
        'title' => 'Cabeçalho e item de pedido são duas tabelas fato, não uma',
        'excerpt' => 'Pedido (cabeçalho) e item do pedido (detalhe) têm granularidades diferentes e não devem virar uma tabela fato só. Veja como modelar certo.',
        'date' => '2026-08-03',
    ],
    [
        'slug' => 'granularidade-power-bi',
        'eyebrow' => 'Power BI',
        'title' => 'Power BI lento? Pode ser granularidade errada, não falta de RAM',
        'excerpt' => 'Linha redundante deixa o modelo pesado à toa. Veja o que é granularidade de uma tabela fato e como pré-agregar sem perder informação.',
        'date' => '2026-08-03',
    ],
    [
        'slug' => 'saldo-nao-soma-power-bi',
        'eyebrow' => 'Power BI',
        'title' => 'Por que somar saldo dá número errado no Power BI',
        'excerpt' => 'Somar o saldo de uma conta mês a mês costuma dar número errado. O motivo é o tipo de fato: instantâneo (snapshot) não soma como evento.',
        'date' => '2026-08-03',
    ],
    [
        'slug' => 'import-ou-directquery-power-bi',
        'eyebrow' => 'Power BI',
        'title' => 'Import ou DirectQuery no Power BI: qual escolher?',
        'excerpt' => 'Import copia os dados pro arquivo — mais rápido, mas precisa de atualização. DirectQuery consulta a fonte em tempo real — mais lento, sempre atual.',
        'date' => '2026-07-19',
    ],
    [
        'slug' => 'tooltip-personalizado-power-bi',
        'eyebrow' => 'Power BI',
        'title' => 'Tooltip personalizado no Power BI: mais detalhe sem poluir o relatório',
        'excerpt' => 'Cansou de lotar o relatório de gráfico só pra mostrar um detalhe a mais? Veja como criar Tooltip Personalizado no Power BI passo a passo.',
        'date' => '2026-07-19',
    ],
    [
        'slug' => 'medidas-rapidas-power-bi',
        'eyebrow' => 'Power BI',
        'title' => 'Medida Rápida no Power BI: como criar DAX sem escrever do zero',
        'excerpt' => 'Travou na hora de escrever uma fórmula DAX? A Medida Rápida monta o cálculo pronto pra você estudar. Veja como usar e quando vale escrever na mão.',
        'date' => '2026-07-19',
    ],
    [
        'slug' => 'relacionamento-power-bi-1-para-n',
        'eyebrow' => 'Power BI',
        'title' => 'Relacionamento no Power BI: por que sempre 1 pra muitos',
        'excerpt' => 'Modelo travando ou contando duplicado no Power BI? Confira o relacionamento: a tabela de dimensão precisa ter valor único, ligada à fato em 1:N.',
        'date' => '2026-07-19',
    ],
    [
        'slug' => 'medida-ou-coluna-calculada-power-bi',
        'eyebrow' => 'Power BI',
        'title' => 'Medida ou coluna calculada no Power BI: qual usar?',
        'excerpt' => 'Coluna calculada ocupa espaço linha por linha; medida calcula na hora, só quando o gráfico pede. Veja quando usar cada uma no Power BI e por quê.',
        'date' => '2026-07-19',
    ],
    [
        'slug' => 'somase-somases-excel',
        'eyebrow' => 'Excel',
        'title' => 'SOMASE e SOMASES no Excel: como somar só o que interessa',
        'excerpt' => 'SOMASE soma um intervalo só na parte que bate com um critério; SOMASES faz o mesmo com várias condições. Veja a sintaxe e exemplos práticos.',
        'date' => '2026-07-19',
    ],
    [
        'slug' => 'validacao-de-dados-excel',
        'eyebrow' => 'Excel',
        'title' => 'Validação de Dados no Excel: como travar o que a pessoa digita',
        'excerpt' => 'Validação de Dados trava a célula numa lista de opções e evita erro de digitação em planilha compartilhada. Veja como configurar passo a passo.',
        'date' => '2026-07-19',
    ],
    [
        'slug' => 'control-t-excel',
        'eyebrow' => 'Excel',
        'title' => 'Control T no Excel: pra que serve e por que usar sempre',
        'excerpt' => 'Control T transforma um intervalo em Tabela do Excel: fórmula copia sozinha, filtro já vem pronto e cabeçalho trava ao rolar. Veja como e quando usar.',
        'date' => '2026-07-19',
    ],
    [
        'slug' => 'tabela-dinamica-excel',
        'eyebrow' => 'Excel',
        'title' => 'Tabela Dinâmica no Excel: como resumir dados sem fórmula',
        'excerpt' => 'A Tabela Dinâmica resume, soma e agrupa milhares de linhas sem fórmula — só arrastando campos. Veja como montar a sua e evitar os erros mais comuns.',
        'date' => '2026-07-19',
    ],
    [
        'slug' => 'procv-ou-procx',
        'eyebrow' => 'Excel',
        'title' => 'PROCV ou PROCX: qual usar no Excel em 2026?',
        'excerpt' => 'PROCX substituiu o PROCV no Excel 2021 e no Microsoft 365 — mas o PROCV ainda é necessário em versões mais antigas. Veja quando usar cada um.',
        'date' => '2026-07-17',
    ],
];
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Blog — Excel e Power BI — TECH SANTOS BR</title>
<meta name="description" content="Artigos práticos de Excel e Power BI: fórmulas, modelagem de dados, DAX e dashboards, direto de quem ensina o curso completo." />
<link rel="icon" type="image/png" href="/assets/img/favicon-32.png" />
<link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png" />
<link rel="stylesheet" href="/assets/css/style.css" />
<?php require_once __DIR__ . '/../inc/meta-pixel.php'; ?>
<?php require_once __DIR__ . '/../inc/google-analytics.php'; ?>
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
      <a href="/blog/" aria-current="page">Blog</a>
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
  <section class="page-hero">
    <div class="page-hero-inner">
      <p class="eyebrow on-dark">Blog</p>
      <h1>Excel e Power BI, direto ao ponto</h1>
      <p class="lead">Artigos práticos respondendo as dúvidas reais de quem trabalha com dados — sem enrolação, direto de quem também ensina o curso completo.</p>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="blog-list">
        <?php foreach ($posts as $p): ?>
        <a class="blog-card" href="/blog/<?= htmlspecialchars($p['slug']) ?>.php">
          <span class="blog-card-eyebrow"><?= htmlspecialchars($p['eyebrow']) ?></span>
          <h3><?= htmlspecialchars($p['title']) ?></h3>
          <p><?= htmlspecialchars($p['excerpt']) ?></p>
          <span class="blog-card-meta"><?= date('d/m/Y', strtotime($p['date'])) ?></span>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="contact-panel">
        <div>
          <p class="eyebrow on-dark">Quer ir além dos artigos?</p>
          <h2>Aprenda Power BI do zero, com certificado</h2>
          <p class="lead">13 módulos, do primeiro conceito de modelagem até dashboards publicados de verdade.</p>
          <div class="hero-cta">
            <a class="btn btn-primary" href="/aula-gratis.php">Assistir aula grátis</a>
            <a class="btn btn-ghost" href="/curso-power-bi.php">Conhecer o curso</a>
          </div>
        </div>
      </div>
    </div>
  </section>
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
        <a href="/blog/">Blog</a>
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
