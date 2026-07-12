<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/_partials.php';
require_admin();

$pdo = db();
$error = null;
$success = null;

function slugify(string $s): string
{
    $s = strtolower(trim($s));
    $s = strtr($s, 'áàâãäéèêëíìîïóòôõöúùûüçñ', 'aaaaaeeeeiiiiooooouuuucn');
    $s = preg_replace('/[^a-z0-9]+/', '-', $s) ?? '';
    return trim($s, '-');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';

    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM alunos WHERE curso_id = ?');
        $stmt->execute([$id]);
        $linked = (int)$stmt->fetchColumn();
        if ($linked > 0) {
            header('Location: /admin/cursos.php?msg=' . urlencode("Não é possível remover: há {$linked} aluno(s) vinculado(s) a este curso."));
            exit;
        }
        $del = $pdo->prepare('DELETE FROM cursos WHERE id = ?');
        $del->execute([$id]);
        header('Location: /admin/cursos.php?msg=' . urlencode('Curso removido.'));
        exit;
    }

    if ($action === 'save') {
        $id = (int)($_POST['id'] ?? 0);
        $nome = trim((string)($_POST['nome'] ?? ''));
        $cargaHoraria = trim((string)($_POST['carga_horaria'] ?? ''));
        $modalidade = trim((string)($_POST['modalidade'] ?? ''));
        $descricao = trim((string)($_POST['descricao'] ?? ''));
        $ativo = isset($_POST['ativo']) ? 1 : 0;
        $slug = slugify($nome);

        if ($nome === '' || $slug === '') {
            $error = 'Informe o nome do curso.';
        } else {
            $dupStmt = $pdo->prepare('SELECT id FROM cursos WHERE slug = ? AND id != ?');
            $dupStmt->execute([$slug, $id]);
            if ($dupStmt->fetch()) {
                $error = 'Já existe um curso com um nome muito parecido.';
            } else {
                if ($id === 0) {
                    $stmt = $pdo->prepare('INSERT INTO cursos (nome, slug, carga_horaria, modalidade, descricao, ativo) VALUES (?, ?, ?, ?, ?, ?)');
                    $stmt->execute([$nome, $slug, $cargaHoraria, $modalidade, $descricao, $ativo]);
                } else {
                    $stmt = $pdo->prepare('UPDATE cursos SET nome=?, slug=?, carga_horaria=?, modalidade=?, descricao=?, ativo=? WHERE id=?');
                    $stmt->execute([$nome, $slug, $cargaHoraria, $modalidade, $descricao, $ativo, $id]);
                }
                header('Location: /admin/cursos.php?msg=' . urlencode('Curso salvo com sucesso.'));
                exit;
            }
        }
    }
}

$editId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$editRow = null;
if ($editId > 0) {
    $stmt = $pdo->prepare('SELECT * FROM cursos WHERE id = ?');
    $stmt->execute([$editId]);
    $editRow = $stmt->fetch();
}

if (isset($_GET['msg']) && !$error) {
    $success = $_GET['msg'];
}

$cursos = $pdo->query(
    'SELECT c.*, (SELECT COUNT(*) FROM alunos a WHERE a.curso_id = c.id) AS total_alunos
     FROM cursos c ORDER BY c.created_at DESC'
)->fetchAll();

admin_head('Cursos');
admin_topbar('cursos');
?>
<main class="admin-main">
  <div class="admin-head"><h1>Cursos</h1></div>

  <?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES) ?></div><?php endif; ?>
  <?php if ($success): ?><div class="alert alert-success"><?= htmlspecialchars($success, ENT_QUOTES) ?></div><?php endif; ?>

  <div class="form-card">
    <h2><?= $editRow ? 'Editar curso' : 'Adicionar curso' ?></h2>
    <form method="post" novalidate>
      <?= csrf_field() ?>
      <input type="hidden" name="action" value="save">
      <input type="hidden" name="id" value="<?= (int)($editRow['id'] ?? 0) ?>">
      <div class="field">
        <label for="nome">Nome do curso *</label>
        <input type="text" id="nome" name="nome" required value="<?= htmlspecialchars($editRow['nome'] ?? '', ENT_QUOTES) ?>">
      </div>
      <div class="field-row">
        <div class="field">
          <label for="carga_horaria">Carga horária</label>
          <input type="text" id="carga_horaria" name="carga_horaria" placeholder="Ex.: 30h" value="<?= htmlspecialchars($editRow['carga_horaria'] ?? '', ENT_QUOTES) ?>">
        </div>
        <div class="field">
          <label for="modalidade">Modalidade</label>
          <input type="text" id="modalidade" name="modalidade" placeholder="Turma fechada / In company / Individual" value="<?= htmlspecialchars($editRow['modalidade'] ?? '', ENT_QUOTES) ?>">
        </div>
      </div>
      <div class="field">
        <label for="descricao">Descrição</label>
        <textarea id="descricao" name="descricao" rows="3"><?= htmlspecialchars($editRow['descricao'] ?? '', ENT_QUOTES) ?></textarea>
      </div>
      <div class="field" style="flex-direction:row; align-items:center; gap:0.5rem;">
        <input type="checkbox" id="ativo" name="ativo" style="width:auto" <?= (!$editRow || $editRow['ativo']) ? 'checked' : '' ?>>
        <label for="ativo" style="margin:0">Curso ativo (visível para seleção ao cadastrar alunos)</label>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $editRow ? 'Salvar alterações' : 'Cadastrar curso' ?></button>
        <?php if ($editRow): ?><a class="btn btn-ghost on-light" href="/admin/cursos.php">Cancelar</a><?php endif; ?>
      </div>
    </form>
  </div>

  <div class="table-wrap">
    <table class="data-table">
      <thead><tr><th>Nome</th><th>Carga horária</th><th>Modalidade</th><th>Alunos</th><th>Status</th><th>Ações</th></tr></thead>
      <tbody>
        <?php if (!$cursos): ?>
          <tr class="empty-row"><td colspan="6">Nenhum curso cadastrado ainda.</td></tr>
        <?php endif; ?>
        <?php foreach ($cursos as $c): ?>
          <tr>
            <td><?= htmlspecialchars($c['nome'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($c['carga_horaria'] ?: '—', ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($c['modalidade'] ?: '—', ENT_QUOTES) ?></td>
            <td><?= (int)$c['total_alunos'] ?></td>
            <td><span class="badge <?= $c['ativo'] ? 'on' : 'off' ?>"><?= $c['ativo'] ? 'Ativo' : 'Inativo' ?></span></td>
            <td class="actions">
              <a href="/admin/cursos.php?edit=<?= (int)$c['id'] ?>">Editar</a>
              <form method="post" onsubmit="return confirm('Remover este curso?');" style="display:inline">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= (int)$c['id'] ?>">
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
