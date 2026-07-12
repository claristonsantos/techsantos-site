<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

$codigo = (string)($_GET['codigo'] ?? '');
$cert = null;
if (preg_match('/^[A-Z0-9]{4,20}$/', $codigo)) {
    $stmt = db()->prepare(
        'SELECT c.codigo, c.emitido_em, a.nome AS aluno_nome, cu.nome AS curso_nome, cu.carga_horaria
         FROM certificados c
         JOIN alunos a ON a.id = c.aluno_id
         JOIN cursos cu ON cu.id = c.curso_id
         WHERE c.codigo = ?'
    );
    $stmt->execute([$codigo]);
    $cert = $stmt->fetch();
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="icon" type="image/png" href="assets/img/favicon-32.png" />
<title><?= $cert ? 'Certificado de ' . htmlspecialchars($cert['aluno_nome'], ENT_QUOTES) : 'Certificado não encontrado' ?> — TECH SANTOS BR</title>
<link rel="stylesheet" href="assets/css/style.css" />
<style>
  body { background: var(--surface-2); }
  .cert-page { max-width: 900px; margin: 0 auto; padding: clamp(1.5rem, 4vw, 3rem) 1.25rem; }
  .cert-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
  .cert-actions a.back { font-size: 0.85rem; color: var(--ink-soft); text-decoration: none; }
  .cert-sheet {
    background: #fff; color: #10192B; border-radius: 4px; padding: clamp(2rem, 6vw, 4.5rem);
    box-shadow: 0 1px 2px rgba(16,25,43,.06), 0 20px 40px -20px rgba(16,25,43,.35);
    border: 10px solid #0F2440; position: relative; text-align: center;
  }
  .cert-sheet::before {
    content: ''; position: absolute; inset: 12px; border: 1.5px solid #4E9F3E; pointer-events: none;
  }
  .cert-brand { display: flex; align-items: center; justify-content: center; gap: 0.6rem; margin-bottom: 2rem; }
  .cert-brand img { width: 40px; height: 31px; object-fit: contain; }
  .cert-brand span { font-family: 'Plex Cond', sans-serif; font-weight: 700; font-size: 1.1rem; color: #10192B; }
  .cert-brand em { font-style: normal; color: #35762A; }
  .cert-eyebrow { font-family: 'Plex Mono', monospace; font-size: 0.75rem; letter-spacing: 0.14em; text-transform: uppercase; color: #35762A; margin-bottom: 1rem; }
  .cert-name { font-family: 'Plex Cond', sans-serif; font-weight: 700; font-size: clamp(1.8rem, 4vw, 2.6rem); margin-bottom: 1.25rem; color: #10192B; }
  .cert-body { font-size: 1.02rem; color: #48546A; max-width: 60ch; margin: 0 auto 2rem; line-height: 1.7; }
  .cert-body strong { color: #10192B; }
  .cert-meta { display: flex; justify-content: center; gap: 3rem; flex-wrap: wrap; margin-top: 2.5rem; padding-top: 1.5rem; border-top: 1px solid #DBDECF; }
  .cert-meta div .k { font-family: 'Plex Mono', monospace; font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.08em; color: #7C8798; margin-bottom: 0.3rem; }
  .cert-meta div .v { font-size: 0.92rem; color: #10192B; font-weight: 600; }
  .cert-notfound { text-align: center; padding: 4rem 1.5rem; }
  .cert-notfound h1 { font-size: 1.4rem; margin-bottom: 0.75rem; }
  .cert-notfound p { color: var(--ink-soft); }
  @media print {
    body { background: #fff; }
    .cert-actions { display: none; }
    .cert-page { padding: 0; max-width: none; }
    .cert-sheet { box-shadow: none; }
  }
</style>
</head>
<body>
<div class="cert-page">
  <?php if ($cert): ?>
    <div class="cert-actions">
      <a class="back" href="/curso-power-bi.php">← TECH SANTOS BR</a>
      <button class="btn btn-primary" onclick="window.print()">Baixar / Imprimir PDF</button>
    </div>
    <div class="cert-sheet">
      <div class="cert-brand">
        <img src="assets/img/logo.jpg" alt="Tech Santos BR" />
        <span>TECH <em>SANTOS BR</em></span>
      </div>
      <p class="cert-eyebrow">Certificado de Conclusão</p>
      <h1 class="cert-name"><?= htmlspecialchars($cert['aluno_nome'], ENT_QUOTES) ?></h1>
      <p class="cert-body">concluiu com aproveitamento o curso <strong><?= htmlspecialchars($cert['curso_nome'], ENT_QUOTES) ?></strong><?= $cert['carga_horaria'] ? ', com carga horária de <strong>' . htmlspecialchars($cert['carga_horaria'], ENT_QUOTES) . '</strong>,' : '' ?> ministrado pela TECH SANTOS BR, cobrindo modelagem de dados, Power Query, DAX, construção de relatórios e publicação em Power BI.</p>
      <div class="cert-meta">
        <div><div class="k">Emitido em</div><div class="v"><?= date('d/m/Y', strtotime($cert['emitido_em'])) ?></div></div>
        <div><div class="k">Código de verificação</div><div class="v"><?= htmlspecialchars($cert['codigo'], ENT_QUOTES) ?></div></div>
        <div><div class="k">Instrutor</div><div class="v">Clariston Santos</div></div>
      </div>
    </div>
  <?php else: ?>
    <div class="cert-notfound">
      <h1>Certificado não encontrado</h1>
      <p>Verifique o código informado ou entre em contato com a TECH SANTOS BR.</p>
    </div>
  <?php endif; ?>
</div>
</body>
</html>
