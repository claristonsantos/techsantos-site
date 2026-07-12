<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/_partials.php';
require_admin();

$pdo = db();
$error = null;
$success = null;

const MODULOS_POWER_BI = [
    'modelagem' => 'Módulo 01 · Fundamentos de Modelagem de Dados',
    'perfil-dados' => 'Módulo 02 · Perfil dos Dados',
    'power-query-conectar' => 'Módulo 03 · Power Query — Conectando e Importando Dados',
    'power-query-transformar' => 'Módulo 04 · Power Query — Transformação e Limpeza de Dados',
    'otimizacao' => 'Módulo 05 · Modelo de Dados & Otimização de Desempenho',
    'dax' => 'Módulo 06 · Fórmulas DAX',
    'relatorios' => 'Módulo 07 · Criar e Enriquecer Relatórios',
    'analise-avancada' => 'Módulo 08 · Análise Avançada & Insights de IA',
    'dashboards-governanca' => 'Módulo 09 · Dashboards, Publicação & Governança',
    'encerramento' => 'Avaliação final (Módulo 10 · Encerramento)',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';

    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        $pdo->prepare('DELETE FROM avaliacoes WHERE id = ?')->execute([$id]);
        header('Location: /admin/avaliacoes.php?msg=' . urlencode('Avaliação removida.'));
        exit;
    }

    if ($action === 'save') {
        $cursoId = (int)($_POST['curso_id'] ?? 0);
        $moduloId = (string)($_POST['modulo_id'] ?? '');
        $titulo = trim((string)($_POST['titulo'] ?? ''));
        $notaMinima = max(0, min(100, (int)($_POST['nota_minima'] ?? 70)));

        if ($cursoId === 0 || !isset(MODULOS_POWER_BI[$moduloId]) || $titulo === '') {
            $error = 'Selecione o curso, o módulo e informe um título.';
        } else {
            $dup = $pdo->prepare('SELECT id FROM avaliacoes WHERE curso_id = ? AND modulo_id = ?');
            $dup->execute([$cursoId, $moduloId]);
            if ($dup->fetch()) {
                $error = 'Já existe uma avaliação para este módulo neste curso.';
            } else {
                $ins = $pdo->prepare('INSERT INTO avaliacoes (curso_id, modulo_id, titulo, nota_minima) VALUES (?, ?, ?, ?)');
                $ins->execute([$cursoId, $moduloId, $titulo, $notaMinima]);
                header('Location: /admin/avaliacoes.php?msg=' . urlencode('Avaliação criada. Agora adicione as questões.'));
                exit;
            }
        }
    }
}

if (isset($_GET['msg']) && !$error) {
    $success = $_GET['msg'];
}

$cursos = $pdo->query('SELECT id, nome FROM cursos ORDER BY nome')->fetchAll();
$avaliacoes = $pdo->query(
    'SELECT a.*, c.nome AS curso_nome, (SELECT COUNT(*) FROM avaliacao_questoes q WHERE q.avaliacao_id = a.id) AS total_questoes
     FROM avaliacoes a JOIN cursos c ON c.id = a.curso_id ORDER BY a.curso_id, a.modulo_id'
)->fetchAll();

admin_head('Avaliações');
admin_topbar('avaliacoes');
?>
<main class="admin-main">
  <div class="admin-head"><h1>Avaliações por módulo</h1></div>
  <p style="color:var(--ink-soft); font-size:0.92rem; margin-bottom:1.5rem; max-width:60ch;">O aluno precisa atingir a nota mínima em cada avaliação para desbloquear o próximo módulo. A avaliação do módulo "Encerramento" é a prova final — ao ser aprovado nela, o certificado é emitido automaticamente.</p>

  <?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES) ?></div><?php endif; ?>
  <?php if ($success): ?><div class="alert alert-success"><?= htmlspecialchars($success, ENT_QUOTES) ?></div><?php endif; ?>

  <div class="form-card">
    <h2>Criar avaliação</h2>
    <form method="post" novalidate>
      <?= csrf_field() ?>
      <input type="hidden" name="action" value="save">
      <div class="field">
        <label for="curso_id">Curso *</label>
        <select id="curso_id" name="curso_id" required>
          <option value="">Selecione…</option>
          <?php foreach ($cursos as $c): ?>
            <option value="<?= (int)$c['id'] ?>"><?= htmlspecialchars($c['nome'], ENT_QUOTES) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="field">
        <label for="modulo_id">Módulo *</label>
        <select id="modulo_id" name="modulo_id" required>
          <option value="">Selecione…</option>
          <?php foreach (MODULOS_POWER_BI as $id => $label): ?>
            <option value="<?= htmlspecialchars($id, ENT_QUOTES) ?>"><?= htmlspecialchars($label, ENT_QUOTES) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="field">
        <label for="titulo">Título da avaliação *</label>
        <input type="text" id="titulo" name="titulo" required placeholder="Ex.: Avaliação — Fundamentos de Modelagem de Dados">
      </div>
      <div class="field">
        <label for="nota_minima">Nota mínima para aprovação (%)</label>
        <input type="number" id="nota_minima" name="nota_minima" min="0" max="100" value="70">
      </div>
      <button type="submit" class="btn btn-primary">Criar avaliação</button>
    </form>
  </div>

  <div class="table-wrap">
    <table class="data-table">
      <thead><tr><th>Curso</th><th>Módulo</th><th>Título</th><th>Nota mín.</th><th>Questões</th><th>Ações</th></tr></thead>
      <tbody>
        <?php if (!$avaliacoes): ?>
          <tr class="empty-row"><td colspan="6">Nenhuma avaliação cadastrada ainda.</td></tr>
        <?php endif; ?>
        <?php foreach ($avaliacoes as $a): ?>
          <tr>
            <td><?= htmlspecialchars($a['curso_nome'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars(MODULOS_POWER_BI[$a['modulo_id']] ?? $a['modulo_id'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($a['titulo'], ENT_QUOTES) ?></td>
            <td><?= (int)$a['nota_minima'] ?>%</td>
            <td><?= (int)$a['total_questoes'] ?></td>
            <td class="actions">
              <a href="/admin/avaliacao_questoes.php?id=<?= (int)$a['id'] ?>">Questões</a>
              <form method="post" onsubmit="return confirm('Remover esta avaliação e todas as suas questões?');" style="display:inline">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= (int)$a['id'] ?>">
                <button type="submit" class="danger">Remover</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>
<?php admin_foot(); ?>
