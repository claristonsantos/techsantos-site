<?php
declare(strict_types=1);

if (!isset($article) || !is_array($article)) {
    http_response_code(500);
    exit('Artigo não configurado.');
}

$esc = static fn(string $value): string => htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
$faqSchema = [];
foreach ($article['faqs'] as $faq) {
    $faqSchema[] = [
        '@type' => 'Question',
        'name' => $faq['question'],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']],
    ];
}
$articleUrl = 'https://techsantos.com.br/blog/' . $article['slug'] . '.php';
$videoUrl = 'https://media.techsantos.com.br/reels/' . $article['video'];
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?= $esc($article['title']) ?> — TECH SANTOS BR</title>
<meta name="description" content="<?= $esc($article['description']) ?>" />
<link rel="canonical" href="https://techsantos.com.br/blog/<?= $esc($article['slug']) ?>.php" />
<meta property="og:type" content="article" />
<meta property="og:locale" content="pt_BR" />
<meta property="og:url" content="<?= $esc($articleUrl) ?>" />
<meta property="og:title" content="<?= $esc($article['title']) ?>" />
<meta property="og:description" content="<?= $esc($article['description']) ?>" />
<meta property="og:image" content="https://techsantos.com.br/assets/img/promo-curso-1.jpg" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="author" content="Clariston Santos" />
<link rel="icon" type="image/png" href="/assets/img/favicon-32.png" />
<link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png" />
<link rel="stylesheet" href="/assets/css/style.css" />
<?php require_once __DIR__ . '/../inc/meta-pixel.php'; ?>
<?php require_once __DIR__ . '/../inc/google-analytics.php'; ?>
<script type="application/ld+json"><?= json_encode([
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'BlogPosting',
            'headline' => $article['title'],
            'description' => $article['description'],
            'image' => 'https://techsantos.com.br/assets/img/promo-curso-1.jpg',
            'datePublished' => '2026-08-10',
            'dateModified' => '2026-08-10',
            'mainEntityOfPage' => $articleUrl,
            'author' => ['@type' => 'Person', 'name' => 'Clariston Santos'],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'TECH SANTOS BR',
                'logo' => ['@type' => 'ImageObject', 'url' => 'https://techsantos.com.br/assets/img/logo.jpg'],
            ],
        ],
        [
            '@type' => 'VideoObject',
            'name' => $article['title'],
            'description' => $article['description'],
            'thumbnailUrl' => ['https://techsantos.com.br/assets/img/promo-curso-1.jpg'],
            'uploadDate' => '2026-08-10',
            'contentUrl' => $videoUrl,
        ],
        [
            '@type' => 'FAQPage',
            'mainEntity' => $faqSchema,
        ],
    ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
</head>
<body>
<header class="site">
  <div class="nav-row">
    <a class="brand" href="/index.html"><img src="/assets/img/logo.jpg" alt="Tech Santos BR" /><span>TECH <em>SANTOS BR</em></span></a>
    <nav class="links">
      <a href="/index.html">Home</a><a href="/curso-power-bi.php">Curso</a><a href="/blog/" aria-current="page">Blog</a><a href="/contato.html">Contato</a><a href="/login.php">Área do Aluno</a>
    </nav>
    <div class="nav-actions">
      <a class="btn btn-primary desktop-only" href="https://wa.me/5564992905785" target="_blank" rel="noopener">Falar no WhatsApp</a>
      <button class="nav-toggle" aria-label="Abrir menu" aria-expanded="false"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg></button>
    </div>
  </div>
</header>
<main>
  <article class="blog-article">
    <div class="blog-meta">Excel · Atualizado em 10/08/2026 · <?= (int) $article['minutes'] ?> min de leitura</div>
    <h1><?= $esc($article['title']) ?></h1>
    <p><?= $esc($article['intro']) ?></p>
    <div class="key-takeaways">
      <span class="kt-label">Resumo rápido</span>
      <ul><?php foreach ($article['takeaways'] as $item): ?><li><?= $esc($item) ?></li><?php endforeach; ?></ul>
    </div>
    <?php foreach ($article['sections'] as $index => $section): ?>
      <h2><?= $esc($section['heading']) ?></h2>
      <?php foreach ($section['paragraphs'] as $paragraph): ?><p><?= $esc($paragraph) ?></p><?php endforeach; ?>
      <?php if ($index === 0): ?>
      <video controls preload="metadata" playsinline>
        <source src="https://media.techsantos.com.br/reels/<?= $esc($article['video']) ?>" type="video/mp4">
      </video>
      <?php endif; ?>
    <?php endforeach; ?>
    <div class="blog-cta">
      <h2>Quer transformar planilhas em dashboards profissionais?</h2>
      <p>No curso completo de Power BI da TECH SANTOS BR você aprende modelagem, Power Query, DAX e visualização de dados com prática guiada e certificado.</p>
      <div class="hero-cta"><a class="btn btn-primary" href="/aula-gratis.php">Assistir aula grátis</a><a class="btn btn-ghost" href="/curso-power-bi.php">Conhecer o curso completo</a></div>
    </div>
    <h2>Perguntas frequentes</h2>
    <div class="blog-faq-grid">
      <?php foreach ($article['faqs'] as $faq): ?><div class="faq-item"><h3><?= $esc($faq['question']) ?></h3><p><?= $esc($faq['answer']) ?></p></div><?php endforeach; ?>
    </div>
    <p style="margin-top:2.5rem; font-size:0.82rem; color:var(--ink-faint);">Fonte: <a href="<?= $esc($article['source_url']) ?>" target="_blank" rel="noopener"><?= $esc($article['source_label']) ?></a>. Consultada em 10/08/2026.</p>
  </article>
</main>
<footer class="site footer-wide">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <a class="brand" href="/index.html"><img src="/assets/img/logo.jpg" alt="Tech Santos BR" /><span>TECH <em>SANTOS BR</em></span></a>
        <p>Consultoria e treinamento em Power BI e Excel, com mais de 50 projetos de BI implementados. Itumbiara-GO, atendimento para todo o Brasil.</p>
        <div class="footer-social">
          <a href="https://www.instagram.com/tech_santos_br/" target="_blank" rel="noopener" aria-label="TECH SANTOS BR no Instagram"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg></a>
          <a href="https://www.facebook.com/techsantosbr/" target="_blank" rel="noopener" aria-label="TECH SANTOS BR no Facebook"><svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3l-.5 3H13v6.95c5.05-.5 9-4.76 9-9.95z"/></svg></a>
          <a href="https://br.linkedin.com/company/techsantos-br" target="_blank" rel="noopener" aria-label="TECH SANTOS BR no LinkedIn"><svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor"><path d="M6.94 8.5H3.56V20h3.38V8.5zM5.25 3.5a1.96 1.96 0 100 3.92 1.96 1.96 0 000-3.92zM20.44 20h-3.37v-5.6c0-1.34-.03-3.06-1.87-3.06-1.87 0-2.16 1.46-2.16 2.96V20H9.68V8.5h3.24v1.57h.05c.45-.85 1.55-1.74 3.19-1.74 3.41 0 4.04 2.24 4.04 5.16V20z"/></svg></a>
        </div>
      </div>
      <div class="footer-col"><h4>Curso</h4><a href="/curso-power-bi.php">Curso completo de Power BI</a><a href="/aula-gratis.php">Assistir aula grátis</a><a href="/comprar.php">Matricule-se</a><a href="/login.php">Área do Aluno</a></div>
      <div class="footer-col"><h4>Empresa</h4><a href="/sobre.html">Sobre</a><a href="/servicos.html">Serviços</a><a href="/treinamentos.html">Treinamentos</a><a href="/projetos.html">Projetos</a><a href="/blog/">Blog</a></div>
      <div class="footer-col"><h4>Contato</h4><a href="mailto:claristonsantos@techsantos.com.br">claristonsantos@techsantos.com.br</a><a href="https://wa.me/5564992905785" target="_blank" rel="noopener">(64) 99290-5785</a><span>Itumbiara-GO</span></div>
    </div>
    <div class="footer-bottom"><span>© 2026 TECH SANTOS BR Treinamentos e Aulas Particulares · CNPJ 41.135.509/0001-29 · Simples Nacional</span><a href="/admin/login.php">Login Administrador</a></div>
  </div>
</footer>
<script src="/assets/js/nav.js"></script>
</body>
</html>
