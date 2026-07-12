<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../curso_modulos.php';
require_once __DIR__ . '/_partials.php';
require_admin();

$pdo = db();

$alunos = $pdo->query(
    'SELECT a.id, a.nome, a.email, c.id AS curso_id, c.nome AS curso_nome
     FROM alunos a JOIN cursos c ON c.id = a.curso_id
     ORDER BY a.nome'
)->fetchAll();

$alunoId = isset($_GET['aluno']) ? (int)$_GET['aluno'] : 0;
$aluno = null;
$jornada = [];
$certificado = null;

if ($alunoId > 0) {
    foreach ($alunos as $a) {
        if ((int)$a['id'] === $alunoId) { $aluno = $a; break; }
    }

    if ($aluno) {
        foreach (MODULOS_POWER_BI as $moduloId => $label) {
            $avalStmt = $pdo->prepare('SELECT id FROM avaliacoes WHERE curso_id = ? AND modulo_id = ? AND ativo = 1');
            $avalStmt->execute([$aluno['curso_id'], $moduloId]);
            $avaliacaoId = $avalStmt->fetchColumn();

            $linha = [
                'modulo_id' => $moduloId,
                'label' => $label,
                'configurada' => (bool)$avaliacaoId,
                'tentativas' => 0,
                'melhor_nota' => null,
                'aprovado' => false,
                'aprovado_em' => null,
                'ultima_tentativa' => null,
            ];

            if ($avaliacaoId) {
                $statStmt = $pdo->prepare(
                    'SELECT COUNT(*) AS tentativas, MAX(nota) AS melhor_nota, MAX(aprovado) AS aprovado,
                            MIN(CASE WHEN aprovado = 1 THEN criada_em END) AS aprovado_em,
                            MAX(criada_em) AS ultima_tentativa
                     FROM avaliacao_tentativas WHERE avaliacao_id = ? AND aluno_id = ?'
                );
                $statStmt->execute([$avaliacaoId, $aluno['id']]);
                $stats = $statStmt->fetch();
                if ($stats && (int)$stats['tentativas'] > 0) {
                    $linha['tentativas'] = (int)$stats['tentativas'];
                    $linha['melhor_nota'] = $stats['melhor_nota'];
                    $linha['aprovado'] = (bool)$stats['aprovado'];
                    $linha['aprovado_em'] = $stats['aprovado_em'];
                    $linha['ultima_tentativa'] = $stats['ultima_tentativa'];
                }
            }

            $jornada[] = $linha;
        }

        $certStmt = $pdo->prepare('SELECT codigo, emitido_em FROM certificados WHERE aluno_id = ? AND curso_id = ?');
        $certStmt->execute([$aluno['id'], $aluno['curso_id']]);
        $certificado = $certStmt->fetch();
    }
}

admin_head('Jornada do Aluno');
admin_topbar('jornada');
?>
<main class="admin-main">
  <div class="admin-head"><h1>Jornada do aluno</h1></div>
  <p style="color:var(--ink-soft); font-size:0.92rem; margin-bottom:1.5rem; max-width:65ch;">Acompanhamento das avaliações de cada aluno, módulo a módulo, até a avaliação final. Um módulo só é liberado ao aluno depois de aprovação no módulo anterior.</p>

  <div class="form-card">
    <h2>Selecionar aluno</h2>
    <form method="get" novalidate style="flex-direction:row; align-items:flex-end; gap:0.75rem; flex-wrap:wrap;">
      <div class="field" style="flex:1; min-width:220px;">
        <label for="aluno">Aluno</label>
        <select id="aluno" name="aluno" required onchange="this.form.submit()">
          <option value="">Selecione…</option>
          <?php foreach ($alunos as $a): ?>
            <option value="<?= (int)$a['id'] ?>" <?= $alunoId === (int)$a['id'] ? 'selected' : '' ?>><?= htmlspecialchars($a['nome'], ENT_QUOTES) ?> — <?= htmlspecialchars($a['curso_nome'], ENT_QUOTES) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <noscript><button type="submit" class="btn btn-primary">Ver jornada</button></noscript>
    </form>
  </div>

  <?php if ($alunoId > 0 && !$aluno): ?>
    <div class="alert alert-error">Aluno não encontrado.</div>
  <?php endif; ?>

  <?php if ($aluno): ?>
    <div class="form-card">
      <h2><?= htmlspecialchars($aluno['nome'], ENT_QUOTES) ?></h2>
      <p style="color:var(--ink-soft); font-size:0.9rem;">
        <?= htmlspecialchars($aluno['email'], ENT_QUOTES) ?> · <?= htmlspecialchars($aluno['curso_nome'], ENT_QUOTES) ?>
        <?php if ($certificado): ?>
          · <span class="badge on">Certificado emitido em <?= date('d/m/Y', strtotime($certificado['emitido_em'])) ?></span>
          — <a href="/certificado.php?codigo=<?= urlencode($certificado['codigo']) ?>" target="_blank">Ver certificado</a>
        <?php else: ?>
          · <span class="badge off">Curso não concluído</span>
        <?php endif; ?>
      </p>
    </div>

    <div class="table-wrap">
      <table class="data-table">
        <thead><tr><th>Módulo</th><th>Status</th><th>Melhor nota</th><th>Tentativas</th><th>Aprovado em</th><th>Última tentativa</th></tr></thead>
        <tbody>
          <?php foreach ($jornada as $linha): ?>
            <tr>
              <td><?= htmlspecialchars($linha['label'], ENT_QUOTES) ?></td>
              <td>
                <?php if (!$linha['configurada']): ?>
                  <span class="badge off">Sem avaliação</span>
                <?php elseif ($linha['aprovado']): ?>
                  <span class="badge on">Aprovado</span>
                <?php elseif ($linha['tentativas'] > 0): ?>
                  <span class="badge off">Reprovado</span>
                <?php else: ?>
                  <span class="badge off">Não iniciado</span>
                <?php endif; ?>
              </td>
              <td><?= $linha['melhor_nota'] !== null ? number_format((float)$linha['melhor_nota'], 0) . '%' : '—' ?></td>
              <td><?= $linha['tentativas'] ?></td>
              <td><?= $linha['aprovado_em'] ? date('d/m/Y H:i', strtotime($linha['aprovado_em'])) : '—' ?></td>
              <td><?= $linha['ultima_tentativa'] ? date('d/m/Y H:i', strtotime($linha['ultima_tentativa'])) : '—' ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</main>
<?php admin_foot(); ?>
