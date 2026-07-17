<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
$aluno = require_aluno();
$isPowerBi = $aluno['curso_slug'] === 'power-bi';

$progressoConcluido = [];
$avaliacoesInfo = [];
if ($isPowerBi) {
    $stmt = db()->prepare('SELECT licao_id FROM progresso WHERE aluno_id = ?');
    $stmt->execute([$aluno['id']]);
    $progressoConcluido = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $stmt = db()->prepare(
        'SELECT a.id, a.modulo_id,
            (SELECT MAX(t.aprovado) FROM avaliacao_tentativas t WHERE t.avaliacao_id = a.id AND t.aluno_id = ?) AS aprovado
         FROM avaliacoes a WHERE a.curso_id = ? AND a.ativo = 1'
    );
    $stmt->execute([$aluno['id'], $aluno['curso_id']]);
    foreach ($stmt->fetchAll() as $row) {
        $avaliacoesInfo[$row['modulo_id']] = ['id' => (int)$row['id'], 'aprovado' => (bool)$row['aprovado']];
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="robots" content="noindex, nofollow" />
<title>Área do Aluno — <?= htmlspecialchars($aluno['curso_nome'], ENT_QUOTES) ?> — TECH SANTOS BR</title>
<link rel="icon" type="image/png" href="/assets/img/favicon-32.png" />
<link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png" />
<link rel="stylesheet" href="/assets/css/style.css" />
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
  .sidebar-progress .bar > span { display: block; height: 100%; background: var(--green); border-radius: 3px; transition: width 0.25s ease; }

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
  .sidebar-lesson.done .check { background: var(--green); border-color: var(--green); color: #08210A; }
  .sidebar-lesson .type-icon { width: 12px; height: 12px; color: var(--ink-faint); flex: none; }
  .sidebar-lesson .lbl { flex: 1; line-height: 1.3; }
  .sidebar-lesson.done:not(.active) { color: var(--ink-faint); }
  .sidebar-module.locked .sidebar-module-head { color: var(--ink-faint); }
  .locked-msg { padding: 0.5rem 1.25rem 0.85rem 1.5rem; font-size: 0.8rem; color: var(--ink-faint); line-height: 1.4; margin: 0; }
  .sidebar-eval {
    display: flex; align-items: center; gap: 0.6rem; padding: 0.55rem 1.25rem 0.55rem 1.5rem;
    font-size: 0.85rem; font-weight: 600; text-decoration: none; color: var(--green-strong);
    border-top: 1px dashed var(--line); margin-top: 0.2rem;
  }
  .sidebar-eval:hover { background: var(--surface-2); }
  .sidebar-eval .type-icon { width: 13px; height: 13px; flex: none; }
  .sidebar-eval.passed { color: var(--ink-faint); }

  .app-main { padding: clamp(1.5rem, 4vw, 3rem) clamp(1.25rem, 4vw, 3.5rem) 5rem; max-width: 760px; }
  .lesson-breadcrumb { font-size: 0.78rem; color: var(--ink-faint); font-weight: 500; }
  .lesson-title { font-size: clamp(1.35rem, 1.2vw + 1rem, 1.85rem); margin: 0.4rem 0 1.5rem; font-family: 'Plex Sans', sans-serif; font-weight: 700; letter-spacing: 0; }

  .player {
    aspect-ratio: 16 / 9; background: #14161A;
    border-radius: 6px;
    position: relative; overflow: hidden; margin-bottom: 1.5rem;
  }
  .player-video { display: none; width: 100%; height: 100%; object-fit: contain; background: #000; }
  .player-placeholder {
    position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;
  }
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

  .reading-card h3 { font-size: 1.02rem; font-weight: 700; font-family: 'Plex Sans', sans-serif; margin: 1.5rem 0 0.5rem; }
  .reading-card h3:first-of-type { margin-top: 0; }
  .reading-card p { color: var(--ink-soft); font-size: 0.96rem; line-height: 1.65; margin-bottom: 0.5rem; }
  .reading-card .res-inline { margin: 0.35rem 0 0.9rem; }

  .lab-step { padding: 1.1rem 0; border-bottom: 1px solid var(--line); }
  .lab-step:first-of-type { padding-top: 0; }
  .lab-step:last-of-type { border-bottom: none; }
  .lab-step h3 { margin: 0 0 0.5rem; }
  .lab-step .lab-download { margin-top: 0.4rem; display: inline-flex; }
  .lab-step-img { display: block; max-width: 100%; height: auto; border: 1px solid var(--line); border-radius: 6px; margin: 0.75rem 0; }
  .lab-step.reference { background: var(--surface-2); border-radius: 8px; padding: 1.1rem 1.2rem; margin-top: 0.5rem; }
  .lab-step .ref-badge { display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.03em; text-transform: uppercase; color: var(--green-strong); margin-bottom: 0.5rem; }
  .req-list { list-style: none; margin: 0.75rem 0; padding: 0; display: grid; gap: 0.5rem; }
  .req-list li { display: flex; align-items: flex-start; gap: 0.55rem; font-size: 0.92rem; color: var(--ink); line-height: 1.45; }
  .req-list li svg { width: 15px; height: 15px; color: var(--green-strong); flex: none; margin-top: 0.2rem; }
  .res-body code { display: block; background: var(--navy); color: #d7f5d0; font-family: 'Plex Mono', monospace; font-size: 0.8rem; padding: 0.65rem 0.8rem; border-radius: 5px; white-space: pre-wrap; word-break: break-word; margin-top: 0.3rem; }
  .hint-group { margin: 0.9rem 0 0; }

  .lab-flow { display: flex; flex-wrap: wrap; align-items: center; gap: 0.5rem; margin-bottom: 1.6rem; padding: 1.1rem; background: var(--surface-2); border: 1px solid var(--line); border-radius: 8px; }
  .lab-flow-box { flex: 1 1 120px; min-width: 100px; text-align: center; background: var(--surface); border: 1px solid var(--line); border-radius: 6px; padding: 0.65rem 0.5rem; font-size: 0.78rem; font-weight: 600; color: var(--ink); line-height: 1.3; }
  .lab-flow-box.accent { border-color: var(--green-bright); color: var(--green-strong); }
  .lab-flow-arrow { flex: 0 0 auto; color: var(--ink-faint); font-size: 1rem; }
  .lab-star { display: flex; flex-direction: column; align-items: center; gap: 0.6rem; margin-bottom: 1.6rem; padding: 1.3rem 1.1rem; background: var(--surface-2); border: 1px solid var(--line); border-radius: 8px; }
  .lab-star-fact { background: var(--navy); color: #fff; border-radius: 6px; padding: 0.6rem 1.1rem; font-size: 0.82rem; font-weight: 700; }
  .lab-star-dims { display: flex; flex-wrap: wrap; justify-content: center; gap: 0.6rem; }
  .lab-star-dims span { background: var(--surface); border: 1px solid var(--green-bright); color: var(--green-strong); border-radius: 6px; padding: 0.5rem 0.9rem; font-size: 0.78rem; font-weight: 600; }

  .resources { margin-bottom: 1.5rem; }
  .resources h2 { font-size: 0.95rem; font-weight: 700; font-family: 'Plex Sans', sans-serif; margin-bottom: 0.7rem; }
  .resources ul { list-style: none; margin: 0; padding: 0; display: grid; gap: 0.5rem; }
  .res-card { border: 1px solid var(--line); border-radius: 6px; overflow: hidden; }
  .res-toggle {
    display: flex; align-items: center; gap: 0.6rem; width: 100%; text-align: left;
    background: none; border: none; cursor: pointer; color: var(--ink);
    font-size: 0.9rem; font-family: 'Plex Sans', sans-serif; padding: 0.65rem 0.9rem;
  }
  .res-toggle:hover { color: var(--green-strong); }
  .res-toggle svg.doc { width: 16px; height: 16px; color: var(--green-strong); flex: none; }
  .res-toggle svg.chev { width: 13px; height: 13px; color: var(--ink-faint); flex: none; margin-left: auto; transition: transform 0.15s ease; }
  .res-card.open .res-toggle svg.chev { transform: rotate(90deg); }
  .res-toggle .src { font-family: 'Plex Mono', monospace; font-size: 0.68rem; color: var(--ink-faint); display: block; margin-top: 0.1rem; }
  .res-body { display: none; padding: 0 0.9rem 0.9rem 2.55rem; }
  .res-card.open .res-body { display: block; }
  .res-body p { color: var(--ink-soft); font-size: 0.88rem; line-height: 1.6; margin-bottom: 0.6rem; }
  .res-body a {
    display: inline-flex; align-items: center; gap: 0.35rem; text-decoration: none; color: var(--green-strong);
    font-size: 0.82rem; font-weight: 600;
  }
  .res-body a:hover { text-decoration: underline; }
  .res-body a svg.ext { width: 12px; height: 12px; }

  .lesson-nav { display: flex; justify-content: space-between; align-items: center; gap: 1rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--line); }
  .lesson-nav .side { min-width: 0; }
  .lesson-nav .side.right { text-align: right; }
  .lesson-nav a { display: block; text-decoration: none; }
  .lesson-nav .dir { font-size: 0.7rem; color: var(--ink-faint); font-weight: 500; }
  .lesson-nav .t { font-size: 0.88rem; color: var(--ink); font-weight: 600; margin-top: 0.15rem; }
  .lesson-nav a:hover .t { color: var(--green-strong); }

  .mark-done-btn {
    display: inline-flex; align-items: center; gap: 0.5rem; font-family: 'Plex Sans', sans-serif; font-weight: 600;
    font-size: 0.85rem; padding: 0.55rem 1.1rem; border-radius: 5px; border: 1px solid var(--line); background: var(--surface);
    color: var(--ink); cursor: pointer; margin-bottom: 2rem;
  }
  .mark-done-btn.is-done { background: var(--green-soft); border-color: var(--green); color: var(--green-strong); }
  .mark-done-btn svg { width: 14px; height: 14px; }

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
  .empty-course { max-width: 640px; margin: 3rem auto; padding: 0 1.25rem; text-align: center; }
  .empty-course h1 { font-size: 1.6rem; margin-bottom: 0.75rem; }
  .empty-course p { color: var(--ink-soft); }
</style>
</head>
<body>

<div class="student-topbar">
  <div style="display:flex; align-items:center; gap:0.75rem;">
    <?php if ($isPowerBi): ?>
    <button class="sidebar-toggle" id="sidebarToggle" aria-label="Abrir módulos" aria-expanded="false">
      <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
    </button>
    <?php endif; ?>
    <a class="student-brand" href="/curso-power-bi.php">
      <img src="/assets/img/logo.jpg" alt="Tech Santos BR" />
      <span>TECH <em>SANTOS BR</em> · Área do Aluno</span>
    </a>
  </div>
  <div class="topbar-actions">
    <span class="who">Olá, <?= htmlspecialchars(explode(' ', $aluno['nome'])[0], ENT_QUOTES) ?></span>
    <a class="btn btn-ghost on-light" href="/logout.php">Sair</a>
  </div>
</div>

<?php if (!$isPowerBi): ?>
  <div class="empty-course">
    <h1><?= htmlspecialchars($aluno['curso_nome'], ENT_QUOTES) ?></h1>
    <p>O conteúdo deste curso ainda está sendo preparado. Assim que as aulas forem publicadas, elas aparecem automaticamente aqui — nenhuma ação necessária da sua parte.</p>
  </div>
<?php else: ?>

<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

<div class="app-shell">
  <aside class="app-sidebar" id="appSidebar">
    <div class="sidebar-progress">
      <div class="label"><span>Seu progresso</span><span id="progressCount">0/43</span></div>
      <div class="bar"><span id="progressBar" style="width:0%"></span></div>
    </div>
    <nav id="sidebarNav"></nav>
  </aside>

  <main class="app-main" id="appMain"></main>
</div>

<script>
const ALUNO_ID = <?= (int)$aluno['id'] ?>;
const SERVER_PROGRESS = <?= json_encode($progressoConcluido) ?>;
const AVALIACOES = <?= json_encode($avaliacoesInfo, JSON_UNESCAPED_UNICODE) ?>;
const RESUME_MODULE = <?= json_encode(preg_match('/^[a-z0-9-]+$/', (string)($_GET['modulo'] ?? '')) ? $_GET['modulo'] : null) ?>;
const MSL = 'learn.microsoft.com';
</script>
<script src="/assets/js/course-data.js"></script>
<script>

const flat = [];
COURSE.forEach(m => m.lessons.forEach(l => flat.push({ moduleId: m.id, moduleTitle: m.title, kind: m.kind, ...l })));
const totalLessons = flat.length;

let progress = new Set(SERVER_PROGRESS);
let openModule = COURSE[0].id;

function moduleIndex(moduleId) { return COURSE.findIndex(m => m.id === moduleId); }

function moduleUnlocked(moduleId) {
  const idx = moduleIndex(moduleId);
  if (idx <= 0) return true;
  const prevId = COURSE[idx - 1].id;
  if (!(prevId in AVALIACOES)) return true;
  return !!AVALIACOES[prevId].aprovado;
}

async function syncProgress(licaoId, action) {
  try {
    await fetch('/aluno/progresso.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ licao_id: licaoId, action }),
    });
  } catch (e) { /* best-effort; UI already reflects the change */ }
}

const ICON_PLAY = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M10 9l5 3-5 3z" fill="currentColor" stroke="none"/></svg>';
const ICON_CHECK = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12l5 5 11-11"/></svg>';
const ICON_CHEV = '<svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 6l6 6-6 6"/></svg>';
const ICON_EXT = '<svg class="ext" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17L17 7M9 7h8v8"/></svg>';
const ICON_DOC = '<svg class="doc" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h9l3 3v15H6z"/><circle cx="12" cy="6" r="2.2" fill="currentColor" stroke="none"/></svg>';

function moduleDone(mod) { return mod.lessons.every(l => progress.has(l.id)); }

const ICON_LOCK = '<svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 018 0v3"/></svg>';

function renderSidebar(currentId) {
  const nav = document.getElementById('sidebarNav');
  nav.innerHTML = COURSE.map(mod => {
    const isOpen = mod.id === openModule;
    const doneCount = mod.lessons.filter(l => progress.has(l.id)).length;
    const unlocked = moduleUnlocked(mod.id);
    const aval = AVALIACOES[mod.id];
    return `
    <div class="sidebar-module${isOpen ? ' open' : ''}${unlocked ? '' : ' locked'}" data-module="${mod.id}">
      <button class="sidebar-module-head" data-toggle="${mod.id}">
        <span>${mod.title}</span>
        <span style="display:flex;align-items:center;gap:0.5rem;">
          ${unlocked ? `<span class="count">${doneCount}/${mod.lessons.length}</span>` : ICON_LOCK}
          ${ICON_CHEV}
        </span>
      </button>
      <div class="sidebar-module-lessons">
        ${!unlocked ? `<p class="locked-msg">Conclua a avaliação do módulo anterior para desbloquear.</p>` : mod.lessons.map(l => {
          const done = progress.has(l.id);
          const active = l.id === currentId;
          return `<button class="sidebar-lesson${active ? ' active' : ''}${done ? ' done' : ''}" data-lesson="${l.id}">
            <span class="check">${done ? ICON_CHECK : ''}</span>
            <span class="type-icon">${ICON_PLAY}</span>
            <span class="lbl">${l.title}</span>
          </button>`;
        }).join('')}
        ${unlocked && aval ? `<a class="sidebar-eval${aval.aprovado ? ' passed' : ''}" href="/aluno/avaliacao.php?modulo=${mod.id}">
          <span class="type-icon">${aval.aprovado ? ICON_CHECK : ICON_LOCK}</span>
          <span class="lbl">${aval.aprovado ? 'Avaliação aprovada' : 'Fazer avaliação do módulo'}</span>
        </a>` : ''}
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
  updateProgressBar();
}

function updateProgressBar() {
  const count = flat.filter(l => progress.has(l.id)).length;
  document.getElementById('progressCount').textContent = `${count}/${totalLessons}`;
  document.getElementById('progressBar').style.width = `${Math.round((count / totalLessons) * 100)}%`;
}

const RESOURCE_SUMMARIES = {
  'https://learn.microsoft.com/pt-br/power-bi/collaborate-share/service-create-the-new-workspaces': 'Explica o que é um workspace no serviço Power BI, os papéis disponíveis (Administrador, Membro, Contribuidor, Visualizador) e as permissões de cada um — a base para organizar quem pode editar, publicar ou só visualizar o conteúdo de um projeto.',
  'https://learn.microsoft.com/pt-br/power-bi/collaborate-share/service-create-distribute-apps': 'Guia oficial de Apps do Power BI: como empacotar relatórios e dashboards de um workspace em uma experiência de navegação própria, publicar para um público definido e atualizar essa publicação sem afetar quem já está usando a versão anterior.',
  'https://learn.microsoft.com/pt-br/power-bi/create-reports/desktop-accessibility-creating-reports': 'Guia oficial de acessibilidade para relatórios do Power BI: como adicionar texto alternativo aos visuais, configurar a ordem de tabulação no painel de seleção, escolher paletas de cores com contraste suficiente e testar o relatório com um leitor de tela.',
  'https://learn.microsoft.com/pt-br/power-bi/transform-model/desktop-storage-mode': 'Explica os quatro modos de armazenamento de uma tabela no Power BI Desktop — Import, DirectQuery, Dual e a combinação em um modelo composto — e como cada um afeta desempenho, atualidade dos dados e quais recursos ficam disponíveis no modelo.',
  'https://learn.microsoft.com/pt-br/power-query/query-folding-basics': 'Explica o que é dobra de consultas (query folding): como o Power Query tenta traduzir os passos de uma consulta para a linguagem nativa da fonte de dados (SQL, por exemplo) em vez de processar tudo localmente, quais transformações preservam a dobra e como verificar se ela ainda está ativa em um passo específico.',
  'https://learn.microsoft.com/pt-br/data-integration/gateway/service-gateway-onprem': 'Documentação oficial do gateway de dados local: o que é, quando é necessário (fontes de dados dentro da rede da empresa, não acessíveis diretamente pela nuvem) e como ele viabiliza a atualização automática de conjuntos de dados conectados a essas fontes.',
  'https://learn.microsoft.com/pt-br/dax/allexcept-function-dax': 'ALLEXCEPT remove todos os filtros do modelo, exceto os das colunas explicitamente informadas — o inverso de listar tudo que deve continuar filtrando. É a função usada para unificar tabelas fato desconectadas: combinada com CROSSJOIN, mantém apenas a chave em comum entre duas tabelas e descarta o restante do contexto de filtro que causaria valores incorretos.',
  'https://learn.microsoft.com/pt-br/dax/calculate-function-dax': 'CALCULATE avalia uma expressão dentro de um contexto de filtro modificado — é a função que permite, por exemplo, calcular "vendas do ano anterior" ou "percentual do total" substituindo ou adicionando filtros à consulta atual. Os argumentos extras (depois da expressão principal) funcionam como filtros que sobrescrevem o que já estava selecionado no relatório.',
  'https://learn.microsoft.com/pt-br/dax/dax-function-reference': 'Índice oficial com mais de 250 funções DAX, organizadas por categoria (matemáticas, texto, data/hora, lógicas, estatísticas, de tabela). Cada função tem sua própria página com sintaxe, parâmetros, tipo de retorno e exemplos práticos de uso.',
  'https://learn.microsoft.com/pt-br/dax/dax-glossary': 'Glossário com a definição precisa dos termos usados na documentação de DAX — contexto de filtro, contexto de linha, tabela, medida, coluna calculada e outros — útil como referência rápida quando um termo técnico aparece sem explicação em outro artigo.',
  'https://learn.microsoft.com/pt-br/dax/dax-overview': 'Introdução oficial ao DAX (Data Analysis Expressions): de onde a linguagem veio (Power Pivot, 2010), onde é usada hoje (Power BI, Power Pivot no Excel, SSAS Tabular) e como ela difere de fórmulas de planilha — DAX sempre opera sobre tabelas e colunas de um modelo relacionado, nunca sobre células soltas.',
  'https://learn.microsoft.com/pt-br/fabric/enterprise/powerbi/service-premium-large-models': 'Explica o formato de armazenamento de "modelo semântico grande", necessário quando um modelo Power BI ultrapassa o limite padrão de tamanho em capacidades Premium/Fabric. Precisa ser habilitado antes da primeira atualização do modelo no serviço, não depois.',
  'https://learn.microsoft.com/pt-br/power-bi/collaborate-share/service-endorsement-overview': 'Descreve os dois níveis de "endosso" de conteúdo no Power BI: promoção (qualquer pessoa com permissão de gravação pode marcar um relatório como recomendado) e certificação (reservada a revisores autorizados pelo administrador, sinalizando que o conteúdo atende ao padrão de qualidade da organização).',
  'https://learn.microsoft.com/pt-br/power-bi/connect-data/incremental-refresh-overview': 'Mostra como configurar a atualização incremental, que recarrega apenas o período mais recente dos dados (em vez da tabela inteira) a cada atualização — recomendada para modelos acima de 1 GB ou que levam horas para atualizar por completo, mantendo o histórico já processado intacto.',
  'https://learn.microsoft.com/pt-br/power-bi/connect-data/refresh-data': 'Cobre os diferentes tipos de atualização de dados no Power BI: sob demanda, programada (agendada em horários fixos) e via API. Detalha os limites por tipo de capacidade — até 8 atualizações programadas por dia em capacidade compartilhada, até 48 em Premium/Fabric.',
  'https://learn.microsoft.com/pt-br/power-bi/consumer/end-user-report-filter': 'Explica os tipos de filtro disponíveis para quem consome um relatório: filtros básicos, avançados, de intervalo relativo, por URL e o filtro Top N, que mostra apenas os N maiores ou menores valores de uma medida escolhida.',
  'https://learn.microsoft.com/pt-br/power-bi/create-reports/desktop-bookmarks': 'Um marcador (bookmark) captura o estado completo de uma página de relatório — filtros, segmentações, visuais ocultos, ordenação — e pode ser reativado por um botão depois, permitindo criar navegação por abas ou apresentações guiadas dentro de uma única página.',
  'https://learn.microsoft.com/pt-br/power-bi/create-reports/desktop-drillthrough': 'Drillthrough é a navegação que leva o usuário de um resumo (uma linha de uma tabela, por exemplo) direto para uma página de detalhe já filtrada automaticamente para aquele item específico — muito usado para investigar "por que esse cliente teve esse número".',
  'https://learn.microsoft.com/pt-br/power-bi/create-reports/desktop-visual-tooltips': 'Em vez do tooltip padrão (que só repete valores já visíveis), uma dica de ferramenta personalizada é uma página inteira do relatório exibida em miniatura ao passar o mouse sobre um ponto de dados — permite mostrar contexto extra sem poluir o visual principal.',
  'https://learn.microsoft.com/pt-br/power-bi/create-reports/power-bi-visualization-introduction-to-q-and-a': 'O visual de Perguntas e Respostas (Q&A) interpreta uma pergunta digitada em linguagem natural e monta o gráfico correspondente automaticamente, reconhecendo os nomes de colunas e medidas do próprio modelo de dados.',
  'https://learn.microsoft.com/pt-br/power-bi/create-reports/service-dashboard-pin-live-tile-from-report': 'Fixar uma página inteira de relatório como bloco "ao vivo" (live tile) preserva a interatividade original no dashboard — diferente de fixar um único visual, que vira uma imagem estática congelada no momento em que foi fixada.',
  'https://learn.microsoft.com/pt-br/power-bi/create-reports/service-dashboards': 'Explica a diferença central entre relatório e dashboard: o relatório é multipágina e interativo, pensado para exploração; o dashboard é uma única tela de blocos fixados a partir de um ou mais relatórios, pensada para monitoramento rápido.',
  'https://learn.microsoft.com/pt-br/power-bi/developer/visuals/import-visual': 'Mostra como importar visuais do AppSource (a loja oficial de visuais certificados por Microsoft e parceiros) ou de um arquivo local diretamente no painel de Visualizações do Power BI Desktop, quando os visuais nativos não cobrem uma necessidade específica.',
  'https://learn.microsoft.com/pt-br/power-bi/explore-reports/end-user-alerts': 'Alertas de dados podem ser configurados em blocos de indicador, KPI ou cartão em um dashboard, notificando automaticamente quando um valor ultrapassa um limite definido — por exemplo, um aviso quando o estoque cai abaixo de um número crítico.',
  'https://learn.microsoft.com/pt-br/power-bi/fundamentals/power-bi-overview': 'Visão geral oficial do que é o Power BI: o conjunto de ferramentas (Desktop, serviço online, mobile) para conectar, modelar, visualizar e compartilhar dados, e como essas peças se encaixam no fluxo de trabalho típico de um analista.',
  'https://learn.microsoft.com/pt-br/power-bi/guidance/import-modeling-data-reduction': 'Reúne técnicas para reduzir o tamanho de um modelo em modo de importação: remover colunas não usadas, preferir tipos de dados mais compactos, resumir dados muito granulares e evitar carregar histórico além do necessário para a análise.',
  'https://learn.microsoft.com/pt-br/power-bi/guidance/power-bi-optimization': 'Guia geral de otimização: como monitorar o desempenho do relatório para achar gargalos, priorizando consultas lentas e visuais pesados como os pontos de maior impacto na experiência do usuário final.',
  'https://learn.microsoft.com/pt-br/power-bi/guidance/rls-guidance': 'Segurança em nível de linha (RLS) permite que o mesmo relatório mostre dados diferentes para usuários diferentes, através de papéis de segurança definidos no Desktop e associações de usuário ou grupo configuradas no serviço Power BI.',
  'https://learn.microsoft.com/pt-br/power-bi/guidance/star-schema': 'Artigo de referência da Microsoft sobre por que o esquema estrela (tabelas fato conectadas a tabelas dimensão por chaves simples) é a arquitetura recomendada para modelos Power BI — menos ambiguidade, consultas mais rápidas, relacionamentos mais simples de manter.',
  'https://learn.microsoft.com/pt-br/power-bi/transform-model/desktop-query-overview': 'Explica o painel de consultas do Power BI Desktop: como cada consulta representa uma fonte de dados transformada, como reordenar, duplicar, referenciar e organizar consultas em grupos dentro do mesmo arquivo.',
  'https://learn.microsoft.com/pt-br/power-bi/transform-model/desktop-quickstart-learn-dax-basics': 'Um guia rápido prático para escrever as primeiras medidas DAX no Power BI Desktop, partindo de exemplos simples de soma e contagem até fórmulas com CALCULATE — pensado para quem nunca escreveu DAX antes.',
  'https://learn.microsoft.com/pt-br/power-bi/transform-model/desktop-relationships-understand': 'Detalha como o Power BI Desktop detecta e gerencia relacionamentos entre tabelas: cardinalidade (um-para-muitos, muitos-para-muitos), direção do filtro cruzado e como isso afeta o resultado de uma medida.',
  'https://learn.microsoft.com/pt-br/power-bi/visuals/power-bi-visualization-card': 'O visual de cartão exibe um único número em destaque — o ponto de partida visual de uma página antes do usuário explorar os detalhes nos demais visuais. Pode ser tornado interativo, filtrando os outros visuais ao ser selecionado.',
  'https://learn.microsoft.com/pt-br/power-bi/visuals/power-bi-visualization-decomposition-tree': 'A árvore de decomposição permite quebrar uma métrica em múltiplas dimensões, em qualquer ordem, com um clique — e tem um modo de IA que sugere automaticamente qual dimensão explorar em seguida para explicar uma variação.',
  'https://learn.microsoft.com/pt-br/power-bi/visuals/power-bi-visualization-influencers': 'O visual de Principais Influenciadores testa automaticamente, via IA, quais colunas do modelo mais influenciam o aumento ou a queda de uma métrica escolhida — útil para descobrir causas sem precisar testar cada coluna manualmente.',
  'https://learn.microsoft.com/pt-br/power-bi/visuals/power-bi-visualizations-overview': 'Panorama de todos os tipos de visualização nativos do Power BI, organizados por categoria (comparação, tendência, distribuição, relação, parte-do-todo), com orientação sobre qual visual usar para qual tipo de pergunta.',
  'https://learn.microsoft.com/pt-br/power-query/append-queries': 'Acrescentar consultas empilha os dados de duas ou mais tabelas com a mesma estrutura de colunas, uma embaixo da outra — o equivalente a copiar e colar linhas de várias planilhas em uma só, mas de forma atualizável.',
  'https://learn.microsoft.com/pt-br/power-query/data-profiling-tools': 'Descreve as três ferramentas de perfil de dados do Power Query — qualidade da coluna (barra de válido/erro/vazio), distribuição da coluna (frequência de valores) e perfil da coluna (estatísticas completas) — acessíveis na guia Exibir do editor.',
  'https://learn.microsoft.com/pt-br/power-query/data-types': 'Explica os tipos de dados do Power Query (texto, número inteiro, decimal, data, data/hora, verdadeiro/falso) e por que definir o tipo certo logo no início da consulta evita erros de cálculo e ordenação mais adiante.',
  'https://learn.microsoft.com/pt-br/power-query/fill-values-column': 'A operação de preenchimento propaga o último valor não vazio de uma coluna para baixo (ou para cima) até a célula seguinte com dado — essencial para tratar planilhas de origem com células mescladas ou cabeçalhos hierárquicos.',
  'https://learn.microsoft.com/pt-br/power-query/get-data-experience': 'Visão geral de todos os conectores de dados disponíveis no Power Query — arquivos, pastas, bancos de dados, serviços online — e como a experiência de prévia e seleção funciona antes de carregar os dados na consulta.',
  'https://learn.microsoft.com/pt-br/power-query/group-by': 'Agrupar por resume uma tabela detalhada em uma tabela agregada por uma ou mais colunas, aplicando soma, contagem, média, mínimo ou máximo sobre as demais colunas — o equivalente a um GROUP BY de SQL, feito pela interface.',
  'https://learn.microsoft.com/pt-br/power-query/merge-queries-overview': 'Mesclar consultas combina duas tabelas diferentes com base em uma coluna-chave em comum, de forma parecida com um PROCV avançado ou um JOIN de banco de dados — o artigo detalha os seis tipos de junção disponíveis (interna, externa esquerda, externa direita, etc.).',
  'https://learn.microsoft.com/pt-br/power-query/pivot-columns': 'Dinamizar (pivotar) uma coluna transforma seus valores distintos em novas colunas, usando uma função de agregação para preencher cada célula — o mesmo resultado de uma tabela dinâmica do Excel, mas persistido como parte da consulta.',
  'https://learn.microsoft.com/pt-br/power-query/power-query-ui': 'Tour pela interface do Editor do Power Query: faixa de opções, painel de consultas à esquerda, prévia de dados no centro, painel de configurações à direita com a lista de passos aplicados (a receita de transformação).',
  'https://learn.microsoft.com/pt-br/power-query/power-query-what-is-power-query': 'Explica o que é o Power Query e seu papel de ETL (extrair, transformar, carregar) dentro do Excel, Power BI e outros produtos Microsoft — cada transformação vira um passo registrado, reaplicado automaticamente a cada atualização.',
  'https://learn.microsoft.com/pt-br/power-query/unpivot-column': 'Despivotar converte várias colunas (por exemplo, um mês por coluna) em duas colunas de atributo-valor, deixando a tabela no formato "longo" que modelos de dados relacionam e agregam corretamente.',
  'https://learn.microsoft.com/pt-br/powerquery-m/date-functions': 'Referência de todas as funções de data da linguagem M — incluindo Date.AddDays, Date.From e Date.ToText — usadas para calcular prazos, extrair partes de uma data ou converter texto em data dentro de uma coluna personalizada.',
  'https://learn.microsoft.com/pt-br/powerquery-m/power-query-m-function-reference': 'Índice completo com mais de 700 funções da linguagem M, a linguagem por trás de toda transformação do Power Query — organizado por categoria (texto, número, data, tabela, lista, lógica).',
  'https://learn.microsoft.com/pt-br/powerquery-m/table-splitcolumn': 'Documentação da função Table.SplitColumn, que separa uma coluna em várias com base em um delimitador ou em um número fixo de caracteres — a função por trás da transformação "Dividir coluna" da interface.',
  'https://learn.microsoft.com/pt-br/powerquery-m/text-functions': 'Referência das funções de texto da linguagem M — Text.Upper, Text.Lower, Text.Proper, Text.Middle e outras — usadas para padronizar capitalização, extrair trechos e limpar colunas de texto antes de carregar no modelo.',
  'https://learn.microsoft.com/pt-br/training/modules/dax-power-bi-time-intelligence/': 'Módulo de treinamento oficial sobre funções de inteligência de tempo em DAX — acumulado no ano, mesmo período do ano anterior, média móvel — incluindo a exigência de uma tabela calendário corretamente marcada no modelo.',
  'https://learn.microsoft.com/pt-br/training/modules/optimize-model-power-bi/': 'Módulo de treinamento sobre otimização de modelo: como revisar o desempenho de medidas, relacionamentos e visuais, usar variáveis para simplificar cálculos e reduzir a cardinalidade de colunas para economizar memória.',
};

function resourceItem(r) {
  if (!r) return '';
  const resumo = RESOURCE_SUMMARIES[r.u] || '';
  const rid = 'res-' + Math.random().toString(36).slice(2, 9);
  return `<li class="res-card" data-res-id="${rid}">
    <button class="res-toggle" type="button" data-toggle-res="${rid}">
      ${ICON_DOC}
      <span>${r.t}<span class="src">${MSL}</span></span>
      ${ICON_CHEV}
    </button>
    <div class="res-body">
      ${resumo ? `<p>${resumo}</p>` : ''}
      <a href="${r.u}" target="_blank" rel="noopener">Abrir artigo completo no Microsoft Learn ${ICON_EXT}</a>
    </div>
  </li>`;
}

function hintItem(hint) {
  if (!hint) return '';
  const rid = 'hint-' + Math.random().toString(36).slice(2, 9);
  return `<li class="res-card" data-res-id="${rid}">
    <button class="res-toggle" type="button" data-toggle-res="${rid}">
      ${ICON_DOC}
      <span>${hint.t}<span class="src">DICA · VER FÓRMULA</span></span>
      ${ICON_CHEV}
    </button>
    <div class="res-body">
      <code>${hint.code}</code>
    </div>
  </li>`;
}

function renderLesson(id) {
  let idx = flat.findIndex(l => l.id === id);
  if (idx === -1) idx = 0;
  const lesson = flat[idx];
  const prev = flat[idx - 1];
  const next = flat[idx + 1];
  const done = progress.has(lesson.id);
  const main = document.getElementById('appMain');
  openModule = lesson.moduleId;

  const playerBlock = `
    <div class="player">
      <video class="player-video" controls preload="metadata" playsinline>
        <source src="/video.php?id=${lesson.id}" type="video/mp4">
      </video>
      <div class="player-placeholder">
        <div class="play-btn">${ICON_PLAY.replace('<svg ', '<svg width="18" height="18" ')}</div>
        <div class="caption"><span>${lesson.title}</span><span>Vídeo em preparação</span></div>
      </div>
    </div>
  `;

  let mediaBlock;
  if (lesson.kind === 'video') {
    mediaBlock = `
      ${playerBlock}
      <div class="objectives">
        <div class="kicker">O que você vai aprender</div>
        <ul>${lesson.objetivos.map(o => `<li>${ICON_CHECK}<span>${o}</span></li>`).join('')}</ul>
      </div>
      <div class="lesson-body">
        <h2>Sobre esta aula</h2>
        <p>${lesson.desc}</p>
        <p>${lesson.body}</p>
      </div>
      ${lesson.content ? `
      <div class="reading-card">
        ${lesson.content.map(b => `<h3>${b.h}</h3><p>${b.p}</p>${b.r ? `<div class="res-inline resources"><ul>${resourceItem(b.r)}</ul></div>` : ''}`).join('')}
      </div>` : ''}
      ${lesson.arquivo ? `
      <div class="resources">
        <h2>Arquivo de exercício</h2>
        <a class="btn btn-ghost on-light" href="/exercicio.php?id=${lesson.id}">${ICON_DOC} Baixar ${lesson.arquivo}</a>
      </div>` : ''}
      ${lesson.recursos && lesson.recursos.length ? `
      <div class="resources">
        <h2>Recursos oficiais Microsoft</h2>
        <ul>${lesson.recursos.map(resourceItem).join('')}</ul>
      </div>` : ''}
    `;
  } else if (lesson.steps) {
    mediaBlock = `
      ${lesson.diagram || ''}
      <div class="reading-card">
        ${lesson.steps.map(s => `
          <div class="lab-step${s.reference ? ' reference' : ''}">
            ${s.reference ? `<div class="ref-badge">${ICON_CHECK} Resultado de referência — confira depois de construir o seu</div>` : ''}
            <h3>${s.h}</h3>
            <p>${s.p}</p>
            ${s.checklist ? `<ul class="req-list">${s.checklist.map(item => `<li>${ICON_CHECK}<span>${item}</span></li>`).join('')}</ul>` : ''}
            ${s.hints ? `<div class="hint-group resources"><ul>${s.hints.map(hintItem).join('')}</ul></div>` : ''}
            ${s.img ? `<img class="lab-step-img" src="${s.img}" alt="${s.h}" loading="lazy">` : ''}
            ${s.arquivo ? `<a class="btn btn-ghost on-light lab-download" href="/exercicio.php?id=${s.id}">${ICON_DOC} Baixar ${s.arquivo}</a>` : ''}
          </div>
        `).join('')}
      </div>
    `;
  } else {
    mediaBlock = `
      <div class="reading-card">
        ${lesson.content.map(b => `<h3>${b.h}</h3><p>${b.p}</p>${b.r ? `<div class="res-inline resources"><ul>${resourceItem(b.r)}</ul></div>` : ''}`).join('')}
      </div>
    `;
  }

  main.innerHTML = `
    <p class="lesson-breadcrumb">${lesson.moduleTitle}</p>
    <h1 class="lesson-title">${lesson.title}</h1>
    ${mediaBlock}
    <button class="mark-done-btn${done ? ' is-done' : ''}" id="markDoneBtn">
      ${ICON_CHECK.replace('<svg ', '<svg width="14" height="14" ')}
      <span>${done ? 'Aula concluída' : 'Marcar aula como concluída'}</span>
    </button>
    <div class="lesson-nav">
      <div class="side">${prev ? `<a href="#${prev.id}"><span class="dir">← Anterior</span><span class="t">${prev.title}</span></a>` : ''}</div>
      <div class="side right">${next ? `<a href="#${next.id}"><span class="dir">Próxima →</span><span class="t">${next.title}</span></a>` : ''}</div>
    </div>
  `;

  const videoEl = main.querySelector('.player-video');
  const placeholderEl = main.querySelector('.player-placeholder');
  if (videoEl && placeholderEl) {
    videoEl.addEventListener('loadedmetadata', () => {
      videoEl.style.display = 'block';
      placeholderEl.style.display = 'none';
    });
    videoEl.addEventListener('error', () => {
      videoEl.style.display = 'none';
      placeholderEl.style.display = 'flex';
    }, true);
  }

  document.getElementById('markDoneBtn').addEventListener('click', () => {
    const nowDone = !progress.has(lesson.id);
    if (nowDone) progress.add(lesson.id); else progress.delete(lesson.id);
    syncProgress(lesson.id, nowDone ? 'complete' : 'uncomplete');
    renderLesson(lesson.id);
  });

  renderSidebar(lesson.id);
  document.title = `${lesson.title} — Área do Aluno — TECH SANTOS BR`;
  window.scrollTo({ top: 0, behavior: 'instant' in window ? 'instant' : 'auto' });
}

function currentLessonId() {
  const h = location.hash.replace('#', '');
  const lesson = flat.find(l => l.id === h);
  if (!lesson) {
    if (RESUME_MODULE) {
      const mod = COURSE.find(m => m.id === RESUME_MODULE);
      if (mod && mod.lessons.length && moduleUnlocked(mod.id)) return mod.lessons[0].id;
    }
    return flat[0].id;
  }
  if (!moduleUnlocked(lesson.moduleId)) return flat[0].id;
  return h;
}

window.addEventListener('hashchange', () => renderLesson(currentLessonId()));
renderLesson(currentLessonId());

document.getElementById('appMain').addEventListener('click', (e) => {
  const btn = e.target.closest('[data-toggle-res]');
  if (!btn) return;
  btn.closest('.res-card').classList.toggle('open');
});

const sidebarEl = document.getElementById('appSidebar');
const backdropEl = document.getElementById('sidebarBackdrop');
const toggleBtn = document.getElementById('sidebarToggle');
function openSidebarMobile() { sidebarEl.classList.add('open'); backdropEl.classList.add('open'); toggleBtn.setAttribute('aria-expanded', 'true'); }
function closeSidebarMobile() { sidebarEl.classList.remove('open'); backdropEl.classList.remove('open'); toggleBtn.setAttribute('aria-expanded', 'false'); }
toggleBtn.addEventListener('click', () => sidebarEl.classList.contains('open') ? closeSidebarMobile() : openSidebarMobile());
backdropEl.addEventListener('click', closeSidebarMobile);
</script>
<?php endif; ?>
</body>
</html>
