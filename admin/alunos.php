<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/_partials.php';
require_once __DIR__ . '/../mailer.php';
require_admin();

$pdo = db();
$error = null;
$success = null;

function fetch_cursos(PDO $pdo): array
{
    return $pdo->query('SELECT id, nome FROM cursos WHERE ativo = 1 ORDER BY nome')->fetchAll();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';

    if ($action === 'delete') {
        csrf_check();
        $id = (int)($_POST['id'] ?? 0);
        $stmt = $pdo->prepare('DELETE FROM alunos WHERE id = ?');
        $stmt->execute([$id]);
        header('Location: /admin/alunos.php?msg=removido');
        exit;
    }

    if ($action === 'save') {
        $id = (int)($_POST['id'] ?? 0);
        $nome = trim((string)($_POST['nome'] ?? ''));
        $email = trim((string)($_POST['email'] ?? ''));
        $cpf = cpf_digits((string)($_POST['cpf'] ?? ''));
        $cursoId = (int)($_POST['curso_id'] ?? 0);
        $senha = (string)($_POST['senha'] ?? '');

        if ($nome === '' || $email === '' || $cpf === '' || $cursoId === 0) {
            $error = 'Preencha nome, e-mail, CPF e selecione um curso.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'E-mail inválido.';
        } elseif (!cpf_is_valid($cpf)) {
            $error = 'CPF inválido.';
        } elseif ($id === 0 && strlen($senha) < 6) {
            $error = 'Defina uma senha com pelo menos 6 caracteres.';
        } elseif ($senha !== '' && strlen($senha) < 6) {
            $error = 'A nova senha precisa ter pelo menos 6 caracteres.';
        } else {
            $dupStmt = $pdo->prepare('SELECT id FROM alunos WHERE (email = ? OR cpf = ?) AND id != ?');
            $dupStmt->execute([$email, $cpf, $id]);
            if ($dupStmt->fetch()) {
                $error = 'Já existe um aluno com este e-mail ou CPF.';
            } else {
                if ($id === 0) {
                    $stmt = $pdo->prepare('INSERT INTO alunos (nome, email, cpf, senha_hash, curso_id) VALUES (?, ?, ?, ?, ?)');
                    $stmt->execute([$nome, $email, $cpf, password_hash($senha, PASSWORD_DEFAULT), $cursoId]);
                    $cursoStmt = $pdo->prepare('SELECT nome FROM cursos WHERE id = ?');
                    $cursoStmt->execute([$cursoId]);
                    $cursoNome = $cursoStmt->fetchColumn() ?: 'Power BI Completo';
                    $emailEnviado = send_enrollment_email($email, $nome, $senha, ['nome' => $cursoNome]);
                    $success = $emailEnviado
                        ? 'Aluno cadastrado com sucesso. E-mail de matrícula enviado.'
                        : 'Aluno cadastrado com sucesso, mas o envio do e-mail de matrícula falhou — confira os dados manualmente com o aluno.';
                } else {
                    if ($senha !== '') {
                        $stmt = $pdo->prepare('UPDATE alunos SET nome=?, email=?, cpf=?, curso_id=?, senha_hash=?, senha_temporaria=1 WHERE id=?');
                        $stmt->execute([$nome, $email, $cpf, $cursoId, password_hash($senha, PASSWORD_DEFAULT), $id]);
                    } else {
                        $stmt = $pdo->prepare('UPDATE alunos SET nome=?, email=?, cpf=?, curso_id=? WHERE id=?');
                        $stmt->execute([$nome, $email, $cpf, $cursoId, $id]);
                    }
                    $success = 'Aluno atualizado com sucesso.';
                }
                header('Location: /admin/alunos.php?msg=' . urlencode($success));
                exit;
            }
        }
    }
}

$editId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$editRow = null;
if ($editId > 0) {
    $stmt = $pdo->prepare('SELECT * FROM alunos WHERE id = ?');
    $stmt->execute([$editId]);
    $editRow = $stmt->fetch();
}

if (isset($_GET['msg']) && !$error) {
    $success = $_GET['msg'] === 'removido' ? 'Aluno removido.' : $_GET['msg'];
}

$cursos = fetch_cursos($pdo);
$alunos = $pdo->query(
    'SELECT a.id, a.nome, a.email, a.cpf, a.ativo, c.nome AS curso_nome
     FROM alunos a JOIN cursos c ON c.id = a.curso_id
     ORDER BY a.created_at DESC'
)->fetchAll();

admin_head('Alunos');
admin_topbar('alunos');
?>
<main class="admin-main">
  <div class="admin-head"><h1>Alunos</h1></div>

  <?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES) ?></div><?php endif; ?>
  <?php if ($success): ?><div class="alert alert-success"><?= htmlspecialchars($success, ENT_QUOTES) ?></div><?php endif; ?>

  <div class="form-card">
    <h2><?= $editRow ? 'Editar aluno' : 'Adicionar aluno' ?></h2>
    <form method="post" novalidate>
      <?= csrf_field() ?>
      <input type="hidden" name="action" value="save">
      <input type="hidden" name="id" value="<?= (int)($editRow['id'] ?? 0) ?>">
      <div class="field">
        <label for="nome">Nome completo *</label>
        <input type="text" id="nome" name="nome" required value="<?= htmlspecialchars($editRow['nome'] ?? '', ENT_QUOTES) ?>">
      </div>
      <div class="field-row">
        <div class="field">
          <label for="email">E-mail *</label>
          <input type="email" id="email" name="email" required value="<?= htmlspecialchars($editRow['email'] ?? '', ENT_QUOTES) ?>">
        </div>
        <div class="field">
          <label for="cpf">CPF *</label>
          <input type="text" id="cpf" name="cpf" required maxlength="14" placeholder="000.000.000-00" value="<?= htmlspecialchars($editRow ? cpf_format($editRow['cpf']) : '', ENT_QUOTES) ?>">
        </div>
      </div>
      <div class="field">
        <label for="curso_id">Curso *</label>
        <select id="curso_id" name="curso_id" required>
          <option value="">Selecione…</option>
          <?php foreach ($cursos as $c): ?>
            <option value="<?= (int)$c['id'] ?>" <?= ($editRow && (int)$editRow['curso_id'] === (int)$c['id']) ? 'selected' : '' ?>><?= htmlspecialchars($c['nome'], ENT_QUOTES) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="field">
        <label for="senha"><?= $editRow ? 'Nova senha (deixe em branco para manter)' : 'Senha *' ?></label>
        <input type="text" id="senha" name="senha" autocomplete="new-password" <?= $editRow ? '' : 'required' ?>>
        <button type="button" class="gen-pw-btn" id="genPw">Gerar senha aleatória</button>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $editRow ? 'Salvar alterações' : 'Cadastrar aluno' ?></button>
        <?php if ($editRow): ?><a class="btn btn-ghost on-light" href="/admin/alunos.php">Cancelar</a><?php endif; ?>
      </div>
    </form>
  </div>

  <div class="table-wrap">
    <table class="data-table">
      <thead><tr><th>Nome</th><th>E-mail</th><th>CPF</th><th>Curso</th><th>Status</th><th>Ações</th></tr></thead>
      <tbody>
        <?php if (!$alunos): ?>
          <tr class="empty-row"><td colspan="6">Nenhum aluno cadastrado ainda.</td></tr>
        <?php endif; ?>
        <?php foreach ($alunos as $a): ?>
          <tr>
            <td><?= htmlspecialchars($a['nome'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($a['email'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars(cpf_format($a['cpf']), ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($a['curso_nome'], ENT_QUOTES) ?></td>
            <td><span class="badge <?= $a['ativo'] ? 'on' : 'off' ?>"><?= $a['ativo'] ? 'Ativo' : 'Inativo' ?></span></td>
            <td class="actions">
              <a href="/admin/alunos.php?edit=<?= (int)$a['id'] ?>">Editar</a>
              <a href="/admin/jornada.php?aluno=<?= (int)$a['id'] ?>">Jornada</a>
              <form method="post" onsubmit="return confirm('Remover este aluno? Esta ação não pode ser desfeita.');" style="display:inline">
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
<script>
document.getElementById('cpf').addEventListener('input', function () {
  let v = this.value.replace(/\D/g, '').slice(0, 11);
  if (v.length > 9) v = v.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
  else if (v.length > 6) v = v.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
  else if (v.length > 3) v = v.replace(/(\d{3})(\d{1,3})/, '$1.$2');
  this.value = v;
});
document.getElementById('genPw').addEventListener('click', function () {
  const chars = 'ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
  let pw = '';
  const arr = new Uint32Array(10);
  crypto.getRandomValues(arr);
  for (let i = 0; i < 10; i++) pw += chars[arr[i] % chars.length];
  const field = document.getElementById('senha');
  field.type = 'text';
  field.value = pw;
});
</script>
<?php admin_foot(); ?>
