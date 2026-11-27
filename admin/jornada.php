<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../curso_modulos.php';
require_once __DIR__ . '/_partials.php';
require_admin();

require_once __DIR__ . '/../matriculas.php';
require_once __DIR__ . '/../aluno_atividade.php';
require_once __DIR__ . '/../trilhas/lib.php';
$pdo = db();
matriculas_ensure_schema($pdo);

// Uma linha por matrícula (aluno × curso). O UNION cobre alunos antigos cujo
// curso principal ainda não tem linha em matriculas.
$alunos = $pdo->query(
    'SELECT a.id, a.nome, a.email, c.id AS curso_id, c.nome AS curso_nome, c.slug AS curso_slug
     FROM matriculas m JOIN alunos a ON a.id = m.aluno_id JOIN cursos c ON c.id = m.curso_id
     UNION
     SELECT a.id, a.nome, a.email, c.id, c.nome, c.slug
     FROM alunos a JOIN cursos c ON c.id = a.curso_id
     ORDER BY nome, curso_nome'
)->fetchAll();

// Prefixo dos ids de aula de cada curso (o Power BI não tem prefixo).
const PREFIXO_AULAS = ['excel' => 'xl-', 'python' => 'py-', 'ingles' => 'en-', 'microsoft-fabric' => 'fab-'];

/** Etapas feitas / total nas trilhas ligadas ao curso. */
function jornada_trilhas(PDO $pdo, int $alunoId, string $slug): array
{
    $prog = trilhas_progresso($pdo, $alunoId);
    $out = [];
    foreach (trilhas_publicas() as $t) {
        if (($t['curso'] ?? '') !== $slug) continue;
        $out[] = ['nome' => $t['nome'], 'feitas' => count($prog[$t['slug']] ?? []), 'total' => count($t['nos'])];
    }
    return $out;
}

// Exportar CSV: uma linha por matrícula com o resumo da jornada.
if (($_GET['export'] ?? '') === 'csv') {
    ensure_aluno_atividade_tables($pdo);
    $acessos = $pdo->query('SELECT aluno_id, ultimo_acesso FROM aluno_atividade')->fetchAll(PDO::FETCH_KEY_PAIR);
    $aulas = [];
    foreach ($pdo->query('SELECT aluno_id, licao_id FROM progresso') as $r) $aulas[(int)$r['aluno_id']][] = (string)$r['licao_id'];
    $aprov = $pdo->prepare('SELECT COUNT(DISTINCT a.id) FROM avaliacoes a JOIN avaliacao_tentativas t ON t.avaliacao_id = a.id AND t.aluno_id = ? AND t.aprovado = 1 WHERE a.curso_id = ? AND a.ativo = 1');
    $totAval = $pdo->prepare('SELECT COUNT(*) FROM avaliacoes WHERE curso_id = ? AND ativo = 1');
    $cert = $pdo->prepare('SELECT emitido_em FROM certificados WHERE aluno_id = ? AND curso_id = ?');
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="jornada-alunos-' . date('Y-m-d') . '.csv"');
    $f = fopen('php://output', 'w');
    fwrite($f, "\xEF\xBB\xBF"); // BOM pro Excel reconhecer os acentos
    fputcsv($f, ['Aluno', 'E-mail', 'Curso', 'Aulas concluídas', 'Avaliações aprovadas', 'Avaliações do curso', 'Certificado', 'Etapas de trilha', 'Último acesso'], ';');
    foreach ($alunos as $a) {
        $id = (int)$a['id'];
        $slug = (string)$a['curso_slug'];
        $ids = $aulas[$id] ?? [];
        $pref = PREFIXO_AULAS[$slug] ?? null;
        $nAulas = count(array_filter($ids, static function ($l) use ($pref) {
            if ($pref !== null) return str_starts_with($l, $pref);
            foreach (PREFIXO_AULAS as $p) if (str_starts_with($l, $p)) return false;
            return true;
        }));
        $aprov->execute([$id, $a['curso_id']]);
        $totAval->execute([$a['curso_id']]);
        $cert->execute([$id, $a['curso_id']]);
        $c = $cert->fetchColumn();
        $tr = jornada_trilhas($pdo, $id, $slug);
        fputcsv($f, [$a['nome'], $a['email'], $a['curso_nome'], $nAulas, (int)$aprov->fetchColumn(), (int)$totAval->fetchColumn(),
            $c ? date('d/m/Y', strtotime((string)$c)) : 'não', array_sum(array_column($tr, 'feitas')) . '/' . array_sum(array_column($tr, 'total')),
            isset($acessos[$id]) ? date('d/m/Y H:i', strtotime((string)$acessos[$id])) : 'nunca'], ';');
    }
    exit;
}

$alunoId = isset($_GET['aluno']) ? (int)$_GET['aluno'] : 0;
$cursoId = isset($_GET['curso']) ? (int)$_GET['curso'] : 0;
$aluno = null;
$jornada = [];
$certificado = null;

// Seletor de aluno: cada aluno uma vez, com quantos cursos ele tem.
$listaAlunos = [];
$cursosDoAluno = [];
foreach ($alunos as $a) {
    $id = (int)$a['id'];
    $listaAlunos[$id] ??= ['nome' => $a['nome'], 'n' => 0];
    $listaAlunos[$id]['n']++;
    if ($id === $alunoId) $cursosDoAluno[] = $a;
}

if ($alunoId > 0) {
    foreach ($cursosDoAluno as $a) {
        if ($cursoId === 0 || (int)$a['curso_id'] === $cursoId) { $aluno = $a; break; }
    }

    if ($aluno) {
        // Módulos do curso (inclusive os ainda sem avaliação); se o curso não
        // tiver arquivo de conteúdo, usa as avaliações cadastradas.
        $modulos = modulos_do_curso((string)$aluno['curso_slug']);
        if (!$modulos) {
            $modStmt = $pdo->prepare('SELECT modulo_id, titulo FROM avaliacoes WHERE curso_id = ? AND ativo = 1 ORDER BY modulo_id');
            $modStmt->execute([$aluno['curso_id']]);
            $modulos = [];
            foreach ($modStmt->fetchAll() as $m) $modulos[$m['modulo_id']] = $m['titulo'];
        }
        foreach ($modulos as $moduloId => $label) {
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

        // Extras do resumo: aulas concluídas (ids), último acesso e trilhas do curso.
        $progStmt = $pdo->prepare('SELECT licao_id FROM progresso WHERE aluno_id = ?');
        $progStmt->execute([$aluno['id']]);
        $aulasFeitas = $progStmt->fetchAll(PDO::FETCH_COLUMN);
        ensure_aluno_atividade_tables($pdo);
        $acStmt = $pdo->prepare('SELECT ultimo_acesso FROM aluno_atividade WHERE aluno_id = ?');
        $acStmt->execute([$aluno['id']]);
        $ultimoAcesso = $acStmt->fetchColumn() ?: null;
        $trilhasAluno = jornada_trilhas($pdo, (int)$aluno['id'], (string)$aluno['curso_slug']);
        $avalAprovadas = count(array_filter($jornada, static fn($l) => $l['aprovado']));
        $avalTotal = count(array_filter($jornada, static fn($l) => $l['configurada']));
    }
}

admin_head('Jornada do Aluno');
admin_topbar('jornada');
?>
<main class="admin-main">
  <div class="admin-head" style="display:flex; justify-content:space-between; align-items:center; gap:1rem; flex-wrap:wrap;"><h1>Jornada do aluno</h1><a class="btn btn-ghost on-light" href="/admin/jornada.php?export=csv">Exportar CSV (todas as matrículas)</a></div>
  <p style="color:var(--ink-soft); font-size:0.92rem; margin-bottom:1.5rem; max-width:65ch;">Aulas, avaliações e trilhas de cada aluno, módulo a módulo, em cada curso em que ele está matriculado. A exigência de aprovação no módulo anterior é uma opção de cada curso (admin › Cursos).</p>

  <div class="form-card">
    <h2>Selecionar aluno</h2>
    <form method="get" novalidate style="flex-direction:row; align-items:flex-end; gap:0.75rem; flex-wrap:wrap;">
      <div class="field" style="flex:1; min-width:220px;">
        <label for="aluno">Aluno</label>
        <select id="aluno" name="aluno" required onchange="if (this.form.curso) this.form.curso.value=''; this.form.submit()">
          <option value="">Selecione…</option>
          <?php foreach ($listaAlunos as $id => $a): ?>
            <option value="<?= $id ?>" <?= $alunoId === $id ? 'selected' : '' ?>><?= htmlspecialchars($a['nome'], ENT_QUOTES) ?><?= $a['n'] > 1 ? ' (' . $a['n'] . ' cursos)' : '' ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <?php if ($cursosDoAluno): ?>
      <div class="field" style="flex:1; min-width:220px;">
        <label for="curso">Curso</label>
        <select id="curso" name="curso" onchange="this.form.submit()">
          <?php foreach ($cursosDoAluno as $c): ?>
            <option value="<?= (int)$c['curso_id'] ?>" <?= $aluno && (int)$aluno['curso_id'] === (int)$c['curso_id'] ? 'selected' : '' ?>><?= htmlspecialchars($c['curso_nome'], ENT_QUOTES) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <?php endif; ?>
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
      <div class="jr-resumo">
        <div><small>Último acesso</small><b><?= $ultimoAcesso ? date('d/m/Y H:i', strtotime((string)$ultimoAcesso)) : 'nunca' ?></b></div>
        <div><small>Aulas concluídas</small><b id="jrAulasTotal">—</b></div>
        <div><small>Avaliações aprovadas</small><b><?= $avalAprovadas ?>/<?= $avalTotal ?></b></div>
        <?php foreach ($trilhasAluno as $tr): ?>
          <div><small>Trilha <?= htmlspecialchars($tr['nome'], ENT_QUOTES) ?></small><b><?= $tr['feitas'] ?>/<?= $tr['total'] ?> etapas</b></div>
        <?php endforeach; ?>
      </div>
    </div>
    <style>
      .jr-resumo { display:grid; grid-template-columns:repeat(auto-fill, minmax(170px, 1fr)); gap:.75rem; margin-top:1rem; }
      .jr-resumo div { padding:.7rem .9rem; border:1px solid var(--line); border-radius:10px; }
      .jr-resumo small { display:block; color:var(--ink-soft); font-size:.78rem; }
      .jr-resumo b { font-size:1.05rem; }
      .jr-bar { display:inline-block; width:70px; height:6px; border-radius:99px; background:var(--line); vertical-align:middle; margin-left:.4rem; overflow:hidden; }
      .jr-bar span { display:block; height:100%; background:#6DC24D; }
    </style>

    <div class="table-wrap">
      <table class="data-table">
        <thead><tr><th>Módulo</th><th>Aulas</th><th>Status</th><th>Melhor nota</th><th>Tentativas</th><th>Aprovado em</th><th>Última tentativa</th></tr></thead>
        <tbody>
          <?php if (!$jornada): ?><tr class="empty-row"><td colspan="7">Este curso ainda não tem módulos cadastrados.</td></tr><?php endif; ?>
          <?php foreach ($jornada as $linha): ?>
            <tr>
              <td><?= htmlspecialchars($linha['label'], ENT_QUOTES) ?></td>
              <td data-aulas="<?= htmlspecialchars($linha['modulo_id'], ENT_QUOTES) ?>">—</td>
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
    <?php
      // Mesmo conteúdo que a área do aluno usa, para contar as aulas de cada módulo.
      $slugJs = preg_replace('/[^a-z0-9-]/', '', (string)$aluno['curso_slug']);
      $scriptsCurso = $slugJs === 'power-bi'
        ? ['/assets/js/course-data.js', '/assets/js/course-details.js', '/assets/js/course-official-gaps.js']
        : ['/assets/js/course-data-' . $slugJs . '.js'];
    ?>
    <?php foreach ($scriptsCurso as $js): if (!is_file(__DIR__ . '/..' . $js)) continue; ?>
      <script src="<?= $js ?>?v=<?= (int)@filemtime(__DIR__ . '/..' . $js) ?>"></script>
    <?php endforeach; ?>
    <script>
    (function () {
      if (typeof COURSE === 'undefined') return;
      var feitas = new Set(<?= json_encode(array_values($aulasFeitas)) ?>);
      var totalFeitas = 0, totalAulas = 0;
      COURSE.forEach(function (m) {
        var ls = m.lessons || [], n = ls.filter(function (l) { return feitas.has(l.id); }).length;
        totalFeitas += n; totalAulas += ls.length;
        var td = document.querySelector('[data-aulas="' + m.id + '"]');
        if (td && ls.length) {
          var pct = Math.round(n / ls.length * 100);
          td.innerHTML = n + '/' + ls.length + '<span class="jr-bar"><span style="width:' + pct + '%"></span></span>';
        }
      });
      var t = document.getElementById('jrAulasTotal');
      if (t && totalAulas) t.textContent = totalFeitas + '/' + totalAulas + ' (' + Math.round(totalFeitas / totalAulas * 100) + '%)';
    })();
    </script>
  <?php endif; ?>
</main>
<?php admin_foot(); ?>
