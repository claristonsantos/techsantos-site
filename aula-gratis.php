<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Aula grátis — Curso Power BI — TECH SANTOS BR</title>
<meta name="description" content="Assista de graça a primeira aula do curso completo de Power BI da TECH SANTOS BR: modelagem de dados, do zero." />
<link rel="icon" type="image/png" href="assets/img/favicon-32.png" />
<link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png" />
<link rel="stylesheet" href="assets/css/style.css" />
<style>
  .preview-shell { max-width: 780px; margin: 0 auto; padding: clamp(1.5rem, 4vw, 3rem) 1.25rem 5rem; }
  .preview-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; }
  .preview-top a.back { font-size: 0.85rem; color: var(--ink-soft); text-decoration: none; }
  .preview-badge { display: inline-flex; align-items: center; gap: 0.4rem; font-family: 'Plex Mono', monospace; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--green-strong); background: var(--green-soft); padding: 0.3rem 0.7rem; border-radius: 999px; margin-bottom: 1rem; }
  .preview-title { font-size: clamp(1.5rem, 2vw + 1rem, 2.1rem); margin-bottom: 0.75rem; }
  .preview-desc { color: var(--ink-soft); font-size: 1rem; line-height: 1.65; margin-bottom: 1.75rem; max-width: 62ch; }
  .player {
    aspect-ratio: 16 / 9; background: #14161A; border-radius: 8px; position: relative; overflow: hidden; margin-bottom: 2rem;
    display: flex; align-items: center; justify-content: center;
  }
  .player .play-btn { width: 60px; height: 60px; border-radius: 50%; background: rgba(255,255,255,.12); border: 1.5px solid rgba(255,255,255,.4); display: flex; align-items: center; justify-content: center; color: #fff; }
  .player .play-btn svg { width: 20px; height: 20px; margin-left: 3px; }
  .player .caption { position: absolute; bottom: 0.9rem; left: 1rem; right: 1rem; font-size: 0.72rem; color: rgba(255,255,255,.55); display: flex; justify-content: space-between; }
  .preview-cta { background: var(--navy); color: var(--navy-ink); border-radius: 10px; padding: clamp(1.75rem, 5vw, 2.5rem); text-align: center; }
  .preview-cta h2 { color: var(--navy-ink); font-size: 1.3rem; margin-bottom: 0.6rem; }
  .preview-cta p { color: var(--navy-ink-soft); font-size: 0.95rem; margin-bottom: 1.5rem; max-width: 50ch; margin-left: auto; margin-right: auto; }
  .preview-cta .hero-cta { justify-content: center; margin-top: 0; }
</style>
</head>
<body>
<div class="preview-shell">
  <div class="preview-top">
    <a class="back" href="/curso-power-bi.php">← Voltar para o curso</a>
    <a class="brand" href="/index.html" style="display:flex;align-items:center;gap:0.5rem;text-decoration:none;color:var(--ink);">
      <img src="assets/img/logo.jpg" alt="Tech Santos BR" style="width:31px;height:24px;object-fit:contain;border-radius:4px;" />
    </a>
  </div>

  <span class="preview-badge">Aula grátis · Módulo 01</span>
  <h1 class="preview-title">Introdução ao curso de Power BI</h1>
  <p class="preview-desc">Apresentação do curso, do instrutor e do caminho que você vai percorrer: da estrutura dos dados até o relatório pronto para o negócio. Esta é a primeira aula do Módulo 01 · Fundamentos de Modelagem de Dados, liberada gratuitamente para você conhecer o formato das aulas antes de se matricular.</p>

  <div class="player">
    <video style="display:none; width:100%; height:100%; object-fit:contain; background:#000;" id="previewVideo" controls preload="metadata" playsinline>
      <source src="/assets/videos-preview/introducao.mp4" type="video/mp4">
    </video>
    <div class="play-btn" id="previewPlaceholder"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M10 9l5 3-5 3z" fill="currentColor" stroke="none"/></svg></div>
    <div class="caption"><span>Introdução ao curso</span><span>Amostra gratuita</span></div>
  </div>

  <div class="preview-cta">
    <h2>Gostou? O curso completo tem mais 42 aulas como essa.</h2>
    <p>9 módulos, do primeiro conceito de modelagem até relatórios publicados — com avaliações por módulo e certificado de conclusão.</p>
    <div class="hero-cta">
      <a class="btn btn-primary" href="/comprar.php">Comprar o curso</a>
      <a class="btn btn-ghost" href="https://wa.me/5564992905785" target="_blank" rel="noopener">Falar no WhatsApp</a>
    </div>
  </div>
</div>
<script>
  const v = document.getElementById('previewVideo');
  const ph = document.getElementById('previewPlaceholder');
  v.addEventListener('loadedmetadata', () => { v.style.display = 'block'; ph.style.display = 'none'; });
</script>
</body>
</html>
