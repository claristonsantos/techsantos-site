<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

$stmt = db()->prepare("SELECT nome, carga_horaria, descricao, modalidade FROM cursos WHERE slug = 'power-bi'");
$stmt->execute();
$curso = $stmt->fetch();
$nomeCurso = $curso['nome'] ?? 'Power BI Completo';
$whatsMsg = rawurlencode('Olá! Quero fazer a matrícula no curso ' . $nomeCurso . '.');
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Matricule-se — <?= htmlspecialchars($nomeCurso, ENT_QUOTES) ?> — TECH SANTOS BR</title>
<link rel="icon" type="image/png" href="assets/img/favicon-32.png" />
<link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png" />
<link rel="stylesheet" href="assets/css/style.css" />
<style>
  .buy-shell { max-width: 640px; margin: 0 auto; padding: clamp(2rem, 5vw, 4rem) 1.25rem 5rem; }
  .buy-top a { font-size: 0.85rem; color: var(--ink-soft); text-decoration: none; }
  .buy-card { background: var(--surface); border: 1px solid var(--line); border-radius: 10px; padding: clamp(1.75rem, 5vw, 2.75rem); margin-top: 1.5rem; }
  .buy-card h1 { font-size: 1.5rem; margin-bottom: 0.75rem; }
  .buy-card p.lead { color: var(--ink-soft); font-size: 0.96rem; margin-bottom: 1.75rem; }
  .buy-includes { list-style: none; padding: 0; margin: 0 0 2rem; display: grid; gap: 0.65rem; }
  .buy-includes li { display: flex; gap: 0.6rem; font-size: 0.92rem; color: var(--ink); }
  .buy-includes svg { width: 16px; height: 16px; color: var(--green-strong); flex: none; margin-top: 0.15rem; }
  .buy-options { display: grid; gap: 0.9rem; }
  .buy-option {
    display: flex; align-items: center; justify-content: space-between; gap: 1rem;
    border: 1px solid var(--line); border-radius: 8px; padding: 1.1rem 1.3rem; text-decoration: none; color: var(--ink);
    transition: border-color 0.15s ease;
  }
  .buy-option:hover { border-color: var(--green); }
  .buy-option .t { font-weight: 700; font-size: 0.98rem; }
  .buy-option .d { font-size: 0.85rem; color: var(--ink-soft); margin-top: 0.2rem; }
  .buy-note { font-size: 0.82rem; color: var(--ink-faint); margin-top: 1.5rem; text-align: center; }
</style>
</head>
<body>
<div class="buy-shell">
  <div class="buy-top"><a href="/curso-power-bi.php">← Voltar para o curso</a></div>
  <div class="buy-card">
    <h1>Matricule-se no <?= htmlspecialchars($nomeCurso, ENT_QUOTES) ?></h1>
    <p class="lead">Escolha como prefere finalizar sua matrícula. Nossa equipe confirma turma, forma de pagamento e libera seu acesso à Área do Aluno.</p>
    <ul class="buy-includes">
      <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12l5 5 11-11"/></svg><span>9 módulos, 29 videoaulas práticas + apostila com referências oficiais Microsoft</span></li>
      <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12l5 5 11-11"/></svg><span>Avaliações por módulo e avaliação final com certificado de conclusão</span></li>
      <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12l5 5 11-11"/></svg><span>Acesso à Área do Aluno com acompanhamento de progresso</span></li>
      <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12l5 5 11-11"/></svg><span>Turma fechada, in company ou aulas individuais</span></li>
    </ul>
    <div class="buy-options">
      <a class="buy-option" href="https://wa.me/5564999852536?text=<?= $whatsMsg ?>" target="_blank" rel="noopener">
        <div><div class="t">Falar no WhatsApp</div><div class="d">Confirme turma e forma de pagamento diretamente com a gente</div></div>
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 6l6 6-6 6"/></svg>
      </a>
      <a class="buy-option" href="mailto:contato@techsantos.com.br?subject=Matr%C3%ADcula%20<?= rawurlencode($nomeCurso) ?>">
        <div><div class="t">Enviar e-mail</div><div class="d">contato@techsantos.com.br</div></div>
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 6l6 6-6 6"/></svg>
      </a>
    </div>
    <p class="buy-note">Pagamento online por cartão/Pix chegando em breve.</p>
  </div>
</div>
</body>
</html>
