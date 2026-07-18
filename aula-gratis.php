<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>3 aulas grátis — Curso Power BI — TECH SANTOS BR</title>
<meta name="description" content="Assista de graça às 3 primeiras aulas do curso completo de Power BI da TECH SANTOS BR, dentro da mesma área do aluno que você usa depois de se matricular." />
<link rel="icon" type="image/png" href="/assets/img/favicon-32.png" />
<link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png" />
<link rel="stylesheet" href="/assets/css/style.css" />
<?php require_once __DIR__ . '/inc/meta-pixel.php'; ?>
<?php require_once __DIR__ . '/inc/google-analytics.php'; ?>
<style>
  body { overflow-x: hidden; }

  .student-topbar {
    position: sticky; top: 0; z-index: 30;
    display: flex; align-items: center; justify-content: space-between; gap: 1rem;
    padding: 0.75rem 1.25rem; border-bottom: 1px solid var(--line);
    background: var(--surface);
  }
  .student-brand { display: flex; align-items: center; gap: 0.6rem; text-decoration: none; color: var(--ink); }
  .student-brand img { width: 31px; height: 24px; object-fit: contain; border-radius: 4px; }
  .student-brand span { font-family: 'Plex Sans', sans-serif; font-weight: 700; font-size: 0.92rem; }
  .student-brand em { font-style: normal; color: var(--green-strong); }
  .topbar-actions { display: flex; align-items: center; gap: 0.9rem; }
  .topbar-actions .who { font-size: 0.85rem; color: var(--ink-soft); }
  .sidebar-toggle {
    display: none; background: none; border: 1px solid var(--line); border-radius: 5px;
    width: 36px; height: 34px; align-items: center; justify-content: center; color: var(--ink); cursor: pointer;
  }

  .app-shell { display: grid; grid-template-columns: 340px 1fr; align-items: start; }
  .app-sidebar { border-right: 1px solid var(--line); background: var(--surface); height: calc(100vh - 53px); position: sticky; top: 53px; overflow-y: auto; }
  .sidebar-progress { padding: 1rem 1.25rem; border-bottom: 1px solid var(--line); }
  .sidebar-progress .label { display: flex; justify-content: space-between; font-size: 0.78rem; color: var(--ink-soft); margin-bottom: 0.5rem; font-weight: 600; }
  .sidebar-progress .label span:last-child { font-family: 'Plex Mono', monospace; color: var(--ink-faint); font-weight: 400; }
  .sidebar-progress .bar { height: 5px; border-radius: 3px; background: var(--surface-2); overflow: hidden; }
  .sidebar-progress .bar > span { display: block; height: 100%; background: var(--green); border-radius: 3px; }

  .sidebar-module { border-bottom: 1px solid var(--line); }
  .sidebar-module-head {
    padding: 0.9rem 1.25rem; font-size: 0.83rem; font-weight: 600; color: var(--ink);
    display: flex; justify-content: space-between; align-items: center; gap: 0.5rem;
    cursor: pointer; background: none; border: none; width: 100%; text-align: left; font-family: 'Plex Sans', sans-serif;
  }
  .sidebar-module-head:hover { background: var(--surface-2); }
  .sidebar-module-head .count { font-family: 'Plex Mono', monospace; font-size: 0.68rem; color: var(--ink-faint); font-weight: 400; white-space: nowrap; }
  .sidebar-module-head .chev { width: 13px; height: 13px; color: var(--ink-faint); flex: none; transition: transform 0.15s ease; }
  .sidebar-module.open .chev { transform: rotate(90deg); }
  .sidebar-module-lessons { display: none; padding-bottom: 0.4rem; }
  .sidebar-module.open .sidebar-module-lessons { display: block; }

  .sidebar-lesson {
    display: flex; align-items: center; gap: 0.6rem; padding: 0.45rem 1.25rem 0.45rem 1.5rem;
    font-size: 0.85rem; color: var(--ink-soft); cursor: pointer; border-left: 2px solid transparent;
    background: none; width: 100%; text-align: left; font-family: 'Plex Sans', sans-serif;
  }
  .sidebar-lesson:hover { background: var(--surface-2); }
  .sidebar-lesson.active { background: var(--green-soft); border-left-color: var(--green); color: var(--ink); font-weight: 600; }
  .sidebar-lesson .check {
    width: 15px; height: 15px; border-radius: 50%; border: 1.5px solid var(--line); flex: none;
    display: flex; align-items: center; justify-content: center; color: transparent;
  }
  .sidebar-lesson .check svg { width: 8px; height: 8px; }
  .sidebar-lesson.free .check { background: var(--green); border-color: var(--green); color: #08210A; }
  .sidebar-lesson .type-icon { width: 12px; height: 12px; color: var(--ink-faint); flex: none; }
  .sidebar-lesson .lbl { flex: 1; line-height: 1.3; }
  .sidebar-lesson.locked { color: var(--ink-faint); }

  .app-main { padding: clamp(1.5rem, 4vw, 3rem) clamp(1.25rem, 4vw, 3.5rem) 5rem; max-width: 760px; }
  .lesson-breadcrumb { font-size: 0.78rem; color: var(--ink-faint); font-weight: 500; }
  .lesson-title { font-size: clamp(1.35rem, 1.2vw + 1rem, 1.85rem); margin: 0.4rem 0 1.5rem; font-family: 'Plex Sans', sans-serif; font-weight: 700; letter-spacing: 0; }

  .player {
    aspect-ratio: 16 / 9; background: #14161A;
    border-radius: 6px;
    position: relative; overflow: hidden; margin-bottom: 1.5rem;
  }
  .player-video { display: none; width: 100%; height: 100%; object-fit: contain; background: #000; }
  .player-placeholder { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; }
  .player-placeholder .play-btn {
    width: 56px; height: 56px; border-radius: 50%; background: rgba(255,255,255,.12);
    border: 1.5px solid rgba(255,255,255,.4); display: flex; align-items: center; justify-content: center; color: #fff;
  }
  .player-placeholder .play-btn svg { width: 18px; height: 18px; margin-left: 3px; }
  .player-placeholder .caption {
    position: absolute; bottom: 0.85rem; left: 1rem; right: 1rem;
    font-size: 0.72rem; color: rgba(255,255,255,.55);
    display: flex; justify-content: space-between; gap: 0.5rem;
  }

  .objectives { background: var(--surface-2); border-radius: 6px; padding: 1.1rem 1.3rem; margin-bottom: 1.5rem; }
  .objectives .kicker { font-size: 0.78rem; font-weight: 700; color: var(--ink); margin-bottom: 0.65rem; }
  .objectives ul { list-style: none; margin: 0; padding: 0; display: grid; gap: 0.45rem; }
  .objectives li { display: flex; align-items: flex-start; gap: 0.55rem; font-size: 0.88rem; color: var(--ink-soft); line-height: 1.4; }
  .objectives li svg { width: 14px; height: 14px; color: var(--green-strong); flex: none; margin-top: 0.18rem; }

  .lesson-body { margin-bottom: 1.5rem; }
  .lesson-body h2 { font-size: 0.95rem; font-weight: 700; font-family: 'Plex Sans', sans-serif; margin-bottom: 0.7rem; }
  .lesson-body p { color: var(--ink-soft); font-size: 0.96rem; line-height: 1.65; margin-bottom: 0.85rem; }

  .lesson-nav { display: flex; justify-content: space-between; align-items: center; gap: 1rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--line); }
  .lesson-nav .side { min-width: 0; }
  .lesson-nav .side.right { text-align: right; }
  .lesson-nav a { display: block; text-decoration: none; }
  .lesson-nav .dir { font-size: 0.7rem; color: var(--ink-faint); font-weight: 500; }
  .lesson-nav .t { font-size: 0.88rem; color: var(--ink); font-weight: 600; margin-top: 0.15rem; }
  .lesson-nav a:hover .t { color: var(--green-strong); }

  .locked-lesson { background: var(--surface-2); border-radius: 8px; padding: 2rem 1.5rem; text-align: center; }
  .locked-lesson svg { width: 32px; height: 32px; color: var(--ink-faint); margin-bottom: 0.9rem; }
  .locked-lesson p { color: var(--ink-soft); font-size: 0.95rem; margin-bottom: 1.25rem; max-width: 42ch; margin-left: auto; margin-right: auto; }

  .preview-cta { background: var(--navy); color: var(--navy-ink); border-radius: 10px; padding: clamp(1.75rem, 5vw, 2.5rem); text-align: center; margin-top: 2.5rem; }
  .preview-cta h2 { color: var(--navy-ink); font-size: 1.3rem; margin-bottom: 0.6rem; }
  .preview-cta p { color: var(--navy-ink-soft); font-size: 0.95rem; margin-bottom: 1.5rem; max-width: 50ch; margin-left: auto; margin-right: auto; }
  .preview-cta .hero-cta { justify-content: center; margin-top: 0; }

  .whats-capture {
    display: flex; align-items: center; gap: 0.9rem; flex-wrap: wrap;
    background: var(--surface-2); border: 1px solid var(--line); border-radius: 8px;
    padding: 0.9rem 1.1rem; margin-bottom: 1.5rem;
  }
  .whats-capture .txt { flex: 1; min-width: 220px; }
  .whats-capture .txt strong { display: block; font-size: 0.9rem; color: var(--ink); margin-bottom: 0.15rem; }
  .whats-capture .txt span { font-size: 0.8rem; color: var(--ink-soft); }
  .whats-capture form { display: flex; gap: 0.5rem; flex-wrap: wrap; }
  .whats-capture input[type="tel"] {
    font-family: 'Plex Sans', sans-serif; font-size: 0.88rem; padding: 0.55rem 0.75rem;
    border: 1px solid var(--line); border-radius: 6px; background: var(--surface); color: var(--ink); width: 170px;
  }
  .whats-capture .dismiss {
    font-size: 0.78rem; color: var(--ink-faint); background: none; border: none; cursor: pointer; text-decoration: underline;
  }
  .whats-capture.done { color: var(--green-strong); font-weight: 600; }

  .sidebar-backdrop { display: none; }
  @media (max-width: 900px) {
    .app-shell { grid-template-columns: 1fr; }
    .app-sidebar {
      position: fixed; top: 53px; bottom: 0; left: 0; width: 320px; max-width: 88vw;
      transform: translateX(-100%); transition: transform 0.22s ease; z-index: 50; height: auto;
    }
    .app-sidebar.open { transform: translateX(0); }
    .sidebar-toggle { display: flex; }
    .sidebar-backdrop.open { display: block; position: fixed; inset: 53px 0 0 0; background: rgba(6,10,20,0.5); z-index: 45; }
  }
</style>
</head>
<body>

<div class="student-topbar">
  <div style="display:flex; align-items:center; gap:0.75rem;">
    <button class="sidebar-toggle" id="sidebarToggle" aria-label="Abrir módulos" aria-expanded="false">
      <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
    </button>
    <a class="student-brand" href="/curso-power-bi.php">
      <img src="/assets/img/logo.jpg" alt="Tech Santos BR" />
      <span>TECH <em>SANTOS BR</em> · Prévia gratuita</span>
    </a>
  </div>
  <div class="topbar-actions">
    <a class="btn btn-ghost on-light" href="/login.php">Já é aluno? Entrar</a>
    <a class="btn btn-primary" href="/comprar.php">Matricule-se</a>
  </div>
</div>

<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

<div class="app-shell">
  <aside class="app-sidebar" id="appSidebar">
    <div class="sidebar-progress">
      <div class="label"><span>Prévia gratuita</span><span id="progressCount">3/46 liberadas</span></div>
      <div class="bar"><span style="width:6.5%"></span></div>
    </div>
    <nav id="sidebarNav"></nav>
  </aside>

  <main class="app-main" id="appMain"></main>
</div>

<script>
const FREE_LESSON_IDS = ['apresentacao-curso', 'introducao', 'normalizacao-desnormalizacao'];
</script>
<script src="/assets/js/course-data.js"></script>
<script>

const flat = [];
COURSE.forEach(m => m.lessons.forEach(l => flat.push({ moduleId: m.id, moduleTitle: m.title, kind: m.kind, ...l })));

let openModule = COURSE[0].id;

const ICON_PLAY = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M10 9l5 3-5 3z" fill="currentColor" stroke="none"/></svg>';
const ICON_CHECK = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12l5 5 11-11"/></svg>';
const ICON_CHEV = '<svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 6l6 6-6 6"/></svg>';
const ICON_LOCK = '<svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 018 0v3"/></svg>';

function isFree(lessonId) { return FREE_LESSON_IDS.includes(lessonId); }

const WHATS_DONE_KEY = 'ts_whats_lead_done';

function whatsCaptureHtml() {
  if (localStorage.getItem(WHATS_DONE_KEY)) return '';
  return `
    <div class="whats-capture" id="whatsCapture">
      <div class="txt">
        <strong>Quer receber mais dicas de Power BI no WhatsApp?</strong>
        <span>Sem spam — só dica curta de vez em quando.</span>
      </div>
      <form id="whatsCaptureForm">
        <input type="tel" id="whatsCaptureInput" placeholder="(DDD) 9xxxx-xxxx" required>
        <button class="btn btn-primary" type="submit" style="font-size:0.85rem;padding:0.55rem 1rem;">Quero receber</button>
        <button class="dismiss" type="button" id="whatsCaptureDismiss">Agora não</button>
      </form>
    </div>
  `;
}

function wireWhatsCapture() {
  const form = document.getElementById('whatsCaptureForm');
  const dismissBtn = document.getElementById('whatsCaptureDismiss');
  const card = document.getElementById('whatsCapture');
  if (!form || !card) return;

  dismissBtn.addEventListener('click', () => {
    localStorage.setItem(WHATS_DONE_KEY, '1');
    card.remove();
  });

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const input = document.getElementById('whatsCaptureInput');
    const telefone = input.value.trim();
    const submitBtn = form.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    try {
      const res = await fetch('/capturar_whatsapp_lead.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ telefone, origem: 'aula-gratis' }),
      });
      if (res.ok) {
        localStorage.setItem(WHATS_DONE_KEY, '1');
        card.classList.add('done');
        card.innerHTML = '<div class="txt"><strong>Combinado! ✓</strong><span>Você vai receber as próximas dicas por lá.</span></div>';
      } else {
        submitBtn.disabled = false;
        input.setCustomValidity('Confere o número e tenta de novo.');
        input.reportValidity();
      }
    } catch {
      submitBtn.disabled = false;
    }
  });
}

function renderSidebar(currentId) {
  const nav = document.getElementById('sidebarNav');
  nav.innerHTML = COURSE.map(mod => {
    const isOpen = mod.id === openModule;
    const freeCount = mod.lessons.filter(l => isFree(l.id)).length;
    return `
    <div class="sidebar-module${isOpen ? ' open' : ''}" data-module="${mod.id}">
      <button class="sidebar-module-head" data-toggle="${mod.id}">
        <span>${mod.title}</span>
        <span style="display:flex;align-items:center;gap:0.5rem;">
          ${freeCount ? `<span class="count">${freeCount} grátis</span>` : ''}
          ${ICON_CHEV}
        </span>
      </button>
      <div class="sidebar-module-lessons">
        ${mod.lessons.map(l => {
          const free = isFree(l.id);
          const active = l.id === currentId;
          return `<button class="sidebar-lesson${active ? ' active' : ''}${free ? ' free' : ' locked'}" data-lesson="${l.id}">
            <span class="check">${free ? ICON_CHECK : ICON_LOCK}</span>
            <span class="type-icon">${ICON_PLAY}</span>
            <span class="lbl">${l.title}</span>
          </button>`;
        }).join('')}
      </div>
    </div>`;
  }).join('');

  nav.querySelectorAll('.sidebar-lesson').forEach(btn => {
    btn.addEventListener('click', () => { location.hash = btn.dataset.lesson; closeSidebarMobile(); });
  });
  nav.querySelectorAll('[data-toggle]').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.dataset.toggle;
      openModule = openModule === id ? null : id;
      renderSidebar(currentId);
    });
  });
}

function renderLesson(id) {
  let idx = flat.findIndex(l => l.id === id);
  if (idx === -1) idx = 0;
  const lesson = flat[idx];
  const prev = flat[idx - 1];
  const next = flat[idx + 1];
  const main = document.getElementById('appMain');
  openModule = lesson.moduleId;

  let mediaBlock;
  if (isFree(lesson.id)) {
    mediaBlock = `
      ${whatsCaptureHtml()}
      <div class="player">
        <video class="player-video" controls preload="metadata" playsinline>
          <source src="/assets/videos-preview/${lesson.id}.mp4" type="video/mp4">
        </video>
        <div class="player-placeholder">
          <div class="play-btn">${ICON_PLAY.replace('<svg ', '<svg width="18" height="18" ')}</div>
          <div class="caption"><span>${lesson.title}</span><span>Amostra gratuita</span></div>
        </div>
      </div>
      ${lesson.objetivos ? `
      <div class="objectives">
        <div class="kicker">O que você vai aprender</div>
        <ul>${lesson.objetivos.map(o => `<li>${ICON_CHECK}<span>${o}</span></li>`).join('')}</ul>
      </div>` : ''}
      <div class="lesson-body">
        <h2>Sobre esta aula</h2>
        <p>${lesson.desc}</p>
        ${lesson.body ? `<p>${lesson.body}</p>` : ''}
      </div>
    `;
  } else {
    mediaBlock = `
      <div class="locked-lesson">
        ${ICON_LOCK.replace('width="13" height="13"', 'width="32" height="32"')}
        <p><strong>${lesson.title}</strong><br>${lesson.desc || 'Esta aula é exclusiva para quem já se matriculou.'}</p>
        <a class="btn btn-primary" href="/comprar.php">Matricule-se pra desbloquear</a>
      </div>
    `;
  }

  main.innerHTML = `
    <p class="lesson-breadcrumb">${lesson.moduleTitle}</p>
    <h1 class="lesson-title">${lesson.title}</h1>
    ${mediaBlock}
    <div class="lesson-nav">
      <div class="side">${prev ? `<a href="#${prev.id}"><span class="dir">← Anterior</span><span class="t">${prev.title}</span></a>` : ''}</div>
      <div class="side right">${next ? `<a href="#${next.id}"><span class="dir">Próxima →</span><span class="t">${next.title}</span></a>` : ''}</div>
    </div>
    <div class="preview-cta">
      <h2>Gostou? O curso completo tem mais 43 aulas como essas.</h2>
      <p>13 módulos, do primeiro conceito de modelagem até relatórios publicados — com avaliações por módulo e certificado de conclusão.</p>
      <div class="hero-cta">
        <a class="btn btn-primary" href="/comprar.php">Comprar o curso</a>
        <a class="btn btn-ghost" href="https://wa.me/5564992905785?text=${encodeURIComponent('Olá! Assisti a aula grátis do curso de Power BI e tenho uma dúvida antes de comprar.')}" target="_blank" rel="noopener">Falar no WhatsApp</a>
      </div>
    </div>
  `;

  const videoEl = main.querySelector('.player-video');
  const placeholderEl = main.querySelector('.player-placeholder');
  if (videoEl && placeholderEl) {
    videoEl.addEventListener('loadedmetadata', () => {
      videoEl.style.display = 'block';
      placeholderEl.style.display = 'none';
    });
  }
  wireWhatsCapture();

  renderSidebar(lesson.id);
  document.title = `${lesson.title} — Prévia gratuita — TECH SANTOS BR`;
  window.scrollTo({ top: 0, behavior: 'instant' in window ? 'instant' : 'auto' });
}

function currentLessonId() {
  const h = location.hash.replace('#', '');
  const lesson = flat.find(l => l.id === h);
  return lesson ? h : FREE_LESSON_IDS[0];
}

window.addEventListener('hashchange', () => renderLesson(currentLessonId()));
renderLesson(currentLessonId());

const sidebarEl = document.getElementById('appSidebar');
const backdropEl = document.getElementById('sidebarBackdrop');
const toggleBtn = document.getElementById('sidebarToggle');
function openSidebarMobile() { sidebarEl.classList.add('open'); backdropEl.classList.add('open'); toggleBtn.setAttribute('aria-expanded', 'true'); }
function closeSidebarMobile() { sidebarEl.classList.remove('open'); backdropEl.classList.remove('open'); toggleBtn.setAttribute('aria-expanded', 'false'); }
toggleBtn.addEventListener('click', () => sidebarEl.classList.contains('open') ? closeSidebarMobile() : openSidebarMobile());
backdropEl.addEventListener('click', closeSidebarMobile);
</script>
</body>
</html>
