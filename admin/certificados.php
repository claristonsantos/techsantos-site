<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/_partials.php';
require_admin();

$pdo = db();
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';

    if ($action === 'revoke') {
        $id = (int)($_POST['id'] ?? 0);
        $pdo->prepare('DELETE FROM certificados WHERE id = ?')->execute([$id]);
        header('Location: /admin/certificados.php?msg=' . urlencode('Certificado revogado.'));
        exit;
    }

    if ($action === 'emitir') {
        $alunoId = (int)($_POST['aluno_id'] ?? 0);
        $stmt = $pdo->prepare('SELECT curso_id FROM alunos WHERE id = ?');
        $stmt->execute([$alunoId]);
        $cursoId = $stmt->fetchColumn();
        if ($cursoId) {
            $dup = $pdo->prepare('SELECT id FROM certificados WHERE aluno_id = ? AND curso_id = ?');
            $dup->execute([$alunoId, $cursoId]);
            if (!$dup->fetch()) {
                $codigo = 'TS' . strtoupper(bin2hex(random_bytes(4)));
                $pdo->prepare('INSERT INTO certificados (aluno_id, curso_id, codigo) VALUES (?, ?, ?)')->execute([$alunoId, $cursoId, $codigo]);
            }
        }
        header('Location: /admin/certificados.php?msg=' . urlencode('Certificado emitido manualmente.'));
        exit;
    }
}

if (isset($_GET['msg'])) {
    $success = $_GET['msg'];
}

$certificados = $pdo->query(
    'SELECT c.*, a.nome AS aluno_nome, a.email AS aluno_email, cu.nome AS curso_nome
     FROM certificados c JOIN alunos a ON a.id = c.aluno_id JOIN cursos cu ON cu.id = c.curso_id
     ORDER BY c.emitido_em DESC'
)->fetchAll();

$alunos = $pdo->query('SELECT id, nome FROM alunos WHERE ativo = 1 ORDER BY nome')->fetchAll();

admin_head('Certificados');
admin_topbar('certificados');
?>
<main class="admin-main">
  <div class="admin-head"><h1>Certificados emitidos</h1></div>
  <p style="color:var(--ink-soft); font-size:0.92rem; margin-bottom:1.5rem; max-width:60ch;">Certificados são emitidos automaticamente quando o aluno é aprovado na avaliação final. Use a emissão manual apenas em casos excepcionais.</p>

  <?php if ($success): ?><div class="alert alert-success"><?= htmlspecialchars($success, ENT_QUOTES) ?></div><?php endif; ?>

  <div class="form-card">
    <h2>Emitir manualmente</h2>
    <form method="post" novalidate>
      <?= csrf_field() ?>
      <input type="hidden" name="action" value="emitir">
      <div class="field">
        <label for="aluno_id">Aluno</label>
        <select id="aluno_id" name="aluno_id" required>
          <option value="">Selecione…</option>
          <?php foreach ($alunos as $a): ?>
            <option value="<?= (int)$a['id'] ?>"><?= htmlspecialchars($a['nome'], ENT_QUOTES) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Emitir certificado</button>
    </form>
  </div>

  <div class="table-wrap">
    <table class="data-table">
      <thead><tr><th>Aluno</th><th>Curso</th><th>Código</th><th>Emitido em</th><th>Ações</th></tr></thead>
      <tbody>
        <?php if (!$certificados): ?>
          <tr class="empty-row"><td colspan="5">Nenhum certificado emitido ainda.</td></tr>
        <?php endif; ?>
        <?php foreach ($certificados as $c): ?>
          <tr>
            <td><?= htmlspecialchars($c['aluno_nome'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($c['curso_nome'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($c['codigo'], ENT_QUOTES) ?></td>
            <td><?= date('d/m/Y', strtotime($c['emitido_em'])) ?></td>
            <td class="actions">
              <a href="/certificado.php?codigo=<?= urlencode($c['codigo']) ?>" target="_blank">Ver</a>
              <form method="post" onsubmit="return confirm('Revogar este certificado?');" style="display:inline">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="revoke">
                <input type="hidden" name="id" value="<?= (int)$c['id'] ?>">
                <button type="submit" class="danger">Revogar</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>
<?php admin_foot(); ?>
