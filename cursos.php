<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/cursos_catalogo.php';

$cursos = cursos_a_venda_ordenados(db());
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="canonical" href="https://techsantos.com.br/cursos.php" />
<title>Cursos online de Excel, Power BI e Microsoft Fabric | TECH SANTOS BR</title>
<meta name="description" content="Cursos online em português de Excel, Power BI e Microsoft Fabric, com avaliações, simulados, certificado e acesso imediato. Escolha seu curso e comece hoje." />
<meta property="og:type" content="website" />
<meta property="og:locale" content="pt_BR" />
<meta property="og:url" content="https://techsantos.com.br/cursos.php" />
<meta property="og:title" content="Cursos online de Excel, Power BI e Microsoft Fabric" />
<meta property="og:description" content="Do Excel do zero ao Microsoft Fabric: cursos com teoria completa, áudio, avaliações, simulados e certificado. Com Clariston Santos." />
<meta property="og:image" content="https://techsantos.com.br/assets/img/promo-curso-1.jpg" />
<meta name="twitter:card" content="summary_large_image" />
<link rel="icon" type="image/png" href="assets/img/favicon-32.png" />
<link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png" />
<link rel="stylesheet" href="/assets/css/style.css?v=20260927c" />
<?php require_once __DIR__ . '/inc/meta-pixel.php'; ?>
<?php require_once __DIR__ . '/inc/google-analytics.php'; ?>
</head>
<body>

<header class="site">
  <div class="nav-row">
    <a class="brand" href="/">
      <img src="assets/img/logo.jpg" alt="Tech Santos BR" />
      <span>TECH <em>SANTOS BR</em></span>
    </a>
    <nav class="links">
      <a href="/">Home</a>
      <a href="sobre.html">Sobre</a>
      <a href="servicos.html">Serviços</a>
      <a href="treinamentos.html">Treinamentos</a>
      <a href="/cursos.php" aria-current="page">Cursos</a>
      <a href="blog/index.php">Blog</a>
      <a href="contato.html">Contato</a>
      <a href="/login.php">Área do Aluno</a>
    </nav>
    <div class="nav-actions">
      <button class="nav-toggle" aria-label="Abrir menu" aria-expanded="false">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </button>
    </div>
  </div>
</header>

<main>
  <section class="hero page-hero">
    <div class="page-hero-inner">
      <div class="ead-banner">
        <span class="dot"></span>
        <span>Cursos 100% EAD — <strong>acesso imediato</strong> após a confirmação do pagamento, com o mesmo login para todos os cursos.</span>
      </div>
      <p class="eyebrow on-dark">Cursos online TECH SANTOS BR</p>
      <h1>Escolha seu curso e comece <em>hoje</em>.</h1>
      <p class="lead">Excel, Power BI e Microsoft Fabric em português, com teoria completa, áudio em todas as aulas, avaliações, simulados e certificado de conclusão. Uma trilha do primeiro contato com planilhas até a engenharia de dados.</p>
      <div class="hero-cta">
        <a class="btn btn-primary" href="#catalogo">Ver os cursos</a>
        <a class="btn btn-ghost" href="/login.php">Já sou aluno</a>
      </div>
    </div>
  </section>

  <section id="catalogo">
    <div class="container">
      <div class="section-head">
        <p class="eyebrow">Cursos disponíveis</p>
        <h2>Uma trilha completa de dados</h2>
        <p>Comece pelo Excel, avance para o Power BI e chegue ao Microsoft Fabric — ou vá direto ao curso que você precisa agora.</p>
      </div>
      <div class="course-grid">
        <?php foreach ($cursos as $c): $v = curso_vitrine($c['slug']); $preco = preco_formatado((int)$c['preco_centavos']); ?>
        <article class="course-card">
          <a class="course-card-img" href="<?= htmlspecialchars($v['pagina'], ENT_QUOTES) ?>"><img src="<?= htmlspecialchars($v['imagem'], ENT_QUOTES) ?>" alt="<?= htmlspecialchars($c['nome'], ENT_QUOTES) ?>" loading="lazy"></a>
          <div class="course-card-body">
            <?php if (!empty($v['etiqueta'])): ?><span class="course-card-tag"><?= htmlspecialchars($v['etiqueta'], ENT_QUOTES) ?></span><?php endif; ?>
            <h3><?= htmlspecialchars($c['nome'], ENT_QUOTES) ?></h3>
            <p><?= htmlspecialchars($v['resumo'], ENT_QUOTES) ?></p>
            <?php if ($v['itens']): ?>
            <ul>
              <?php foreach ($v['itens'] as $item): ?><li><?= htmlspecialchars($item, ENT_QUOTES) ?></li><?php endforeach; ?>
            </ul>
            <?php endif; ?>
            <?php if ($preco): ?><p class="course-card-price">R$ <?= $preco ?><small>à vista · cartão em até 12x ou Pix · acesso vitalício</small></p><?php endif; ?>
            <div class="course-card-actions">
              <a class="btn btn-primary" href="/comprar.php?curso=<?= urlencode($c['slug']) ?>" data-course-cta="catalogo_buy_<?= htmlspecialchars($c['slug'], ENT_QUOTES) ?>">Comprar agora</a>
              <a class="btn btn-ghost on-light" href="<?= htmlspecialchars($v['pagina'], ENT_QUOTES) ?>" data-course-cta="catalogo_details_<?= htmlspecialchars($c['slug'], ENT_QUOTES) ?>">Ver detalhes</a>
            </div>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
      <p class="course-path-note">Já é aluno de um curso? Compre o próximo pela sua Área do Aluno — ele aparece junto do atual, com o mesmo login.</p>
    </div>
  </section>

  <section style="background: var(--surface-2);">
    <div class="container">
      <div class="section-head">
        <p class="eyebrow">Outras formas de aprender</p>
        <h2>Prefere começar de outro jeito?</h2>
      </div>
      <div class="proof-row">
        <div class="proof-card">
          <p class="proof-num">Grátis</p>
          <p class="proof-t">Assista a 3 aulas do curso de Power BI antes de decidir. <a href="/aula-gratis.php">Assistir às aulas grátis →</a></p>
        </div>
        <div class="proof-card">
          <p class="proof-num">1 a 1</p>
          <p class="proof-t">Aulas particulares ao vivo, no seu ritmo e com os seus próprios dados. <a href="/aulas-particulares-power-bi.php">Ver aulas particulares →</a></p>
        </div>
        <div class="proof-card">
          <p class="proof-num">Empresas</p>
          <p class="proof-t">Treinamento para equipes e implementação de Power BI na sua empresa. <a href="/treinamentos.html">Ver treinamentos →</a></p>
        </div>
      </div>
    </div>
  </section>
</main>

<footer class="site footer-wide">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <a class="brand" href="/">
          <img src="assets/img/logo.jpg" alt="Tech Santos BR" />
          <span>TECH <em>SANTOS BR</em></span>
        </a>
        <p>Consultoria e treinamento em Power BI, Microsoft Fabric e Excel, com mais de 50 projetos de BI implementados. Itumbiara-GO, atendimento para todo o Brasil.</p>
      </div>
      <div class="footer-col">
        <h4>Cursos</h4>
        <a href="/cursos.php">Todos os cursos</a>
        <a href="/curso-excel.php">Excel do zero ao avançado (MO-210 e MO-211)</a>
        <a href="/curso-microsoft-fabric.php">Microsoft Fabric (DP-600 e DP-700)</a>
        <a href="/curso-power-bi.php">Curso completo de Power BI</a>
        <a href="/login.php">Área do Aluno</a>
      </div>
      <div class="footer-col">
        <h4>Empresa</h4>
        <a href="/sobre.html">Sobre</a>
        <a href="/servicos.html">Serviços</a>
        <a href="/treinamentos.html">Treinamentos</a>
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
    </div>
  </div>
</footer>
<script src="assets/js/nav.js"></script>
</body>
</html>
