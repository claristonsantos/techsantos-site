<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/_partials.php';
require_once __DIR__ . '/../mailer.php';
$meAdmin = require_admin();

$pdo = db();
$error = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';

    if ($action === 'toggle') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id === (int)$meAdmin['id']) {
            $error = 'Você não pode desativar sua própria conta.';
        } else {
            $stmt = $pdo->prepare('UPDATE admin_users SET ativo = NOT ativo WHERE id = ?');
            $stmt->execute([$id]);
            header('Location: /admin/administradores.php?msg=' . urlencode('Status atualizado.'));
            exit;
        }
    }

    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id === (int)$meAdmin['id']) {
            $error = 'Você não pode remover sua própria conta.';
        } else {
            $totalAtivos = (int)$pdo->query('SELECT COUNT(*) FROM admin_users WHERE ativo = 1')->fetchColumn();
            $stmt = $pdo->prepare('SELECT ativo FROM admin_users WHERE id = ?');
            $stmt->execute([$id]);
            $alvo = $stmt->fetch();
            if ($alvo && (int)$alvo['ativo'] === 1 && $totalAtivos <= 1) {
                $error = 'Não é possível remover o único administrador ativo.';
            } else {
                $pdo->prepare('DELETE FROM admin_users WHERE id = ?')->execute([$id]);
                header('Location: /admin/administradores.php?msg=' . urlencode('Administrador removido.'));
                exit;
            }
        }
    }

    if ($action === 'save') {
        $id = (int)($_POST['id'] ?? 0);
        $nome = trim((string)($_POST['nome'] ?? ''));
        $email = trim((string)($_POST['email'] ?? ''));
        $usuario = trim((string)($_POST['usuario'] ?? ''));

        if ($nome === '' || $email === '' || $usuario === '') {
            $error = 'Preencha nome, e-mail e usuário.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'E-mail inválido.';
        } elseif (!preg_match('/^[a-z0-9._-]{3,60}$/', $usuario)) {
            $error = 'Usuário deve ter 3-60 caracteres: letras minúsculas, números, ponto, hífen ou underline.';
        } else {
            $dup = $pdo->prepare('SELECT id FROM admin_users WHERE (usuario = ? OR email = ?) AND id != ?');
            $dup->execute([$usuario, $email, $id]);
            if ($dup->fetch()) {
                $error = 'Já existe um administrador com este usuário ou e-mail.';
            } elseif ($id === 0) {
                $senhaGerada = bin2hex(random_bytes(6));
                $ins = $pdo->prepare('INSERT INTO admin_users (usuario, nome, email, senha_hash, senha_temporaria) VALUES (?, ?, ?, ?, 1)');
                $ins->execute([$usuario, $nome, $email, password_hash($senhaGerada, PASSWORD_DEFAULT)]);
                $emailEnviado = send_admin_credentials_email($email, $nome, $usuario, $senhaGerada);
                $success = $emailEnviado
                    ? 'Administrador cadastrado. Credenciais enviadas por e-mail.'
                    : "Administrador cadastrado, mas o envio do e-mail falhou. Usuário: {$usuario} · Senha provisória: {$senhaGerada}";
                header('Location: /admin/administradores.php?msg=' . urlencode($success));
                exit;
            } else {
                $upd = $pdo->prepare('UPDATE admin_users SET usuario = ?, nome = ?, email = ? WHERE id = ?');
                $upd->execute([$usuario, $nome, $email, $id]);
                header('Location: /admin/administradores.php?msg=' . urlencode('Administrador atualizado.'));
                exit;
            }
        }
    }
}

$editId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$editRow = null;
if ($editId > 0) {
    $stmt = $pdo->prepare('SELECT * FROM admin_users WHERE id = ?');
    $stmt->execute([$editId]);
    $editRow = $stmt->fetch();
}

if (isset($_GET['msg']) && !$error) {
    $success = $_GET['msg'];
}

$admins = $pdo->query('SELECT * FROM admin_users ORDER BY created_at ASC, id ASC')->fetchAll();

admin_head('Administradores');
admin_topbar('administradores');
?>
<main class="admin-main">
  <div class="admin-head"><h1>Administradores</h1></div>
  <p style="color:var(--ink-soft); font-size:0.92rem; margin-bottom:1.5rem; max-width:60ch;">Apenas administradores já autenticados podem cadastrar outros. Ao cadastrar, uma senha provisória é gerada e enviada por e-mail — a troca é obrigatória no primeiro acesso.</p>

  <?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES) ?></div><?php endif; ?>
  <?php if ($success): ?><div class="alert alert-success"><?= htmlspecialchars($success, ENT_QUOTES) ?></div><?php endif; ?>

  <div class="form-card">
    <h2><?= $editRow ? 'Editar administrador' : 'Cadastrar administrador' ?></h2>
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
          <label for="usuario">Usuário de login *</label>
          <input type="text" id="usuario" name="usuario" required placeholder="ex.: joao.silva" value="<?= htmlspecialchars($editRow['usuario'] ?? '', ENT_QUOTES) ?>">
        </div>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $editRow ? 'Salvar alterações' : 'Cadastrar administrador' ?></button>
        <?php if ($editRow): ?><a class="btn btn-ghost on-light" href="/admin/administradores.php">Cancelar</a><?php endif; ?>
      </div>
    </form>
  </div>

  <div class="table-wrap">
    <table class="data-table">
      <thead><tr><th>Nome</th><th>Usuário</th><th>E-mail</th><th>Status</th><th>Ações</th></tr></thead>
      <tbody>
        <?php foreach ($admins as $a): ?>
          <tr>
            <td><?= htmlspecialchars($a['nome'] ?: '—', ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($a['usuario'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($a['email'] ?: '—', ENT_QUOTES) ?></td>
            <td><span class="badge <?= $a['ativo'] ? 'on' : 'off' ?>"><?= $a['ativo'] ? 'Ativo' : 'Inativo' ?></span></td>
            <td class="actions">
              <?php if ((int)$a['id'] !== (int)$meAdmin['id']): ?>
              <a href="/admin/administradores.php?edit=<?= (int)$a['id'] ?>">Editar</a>
              <form method="post" onsubmit="return confirm('<?= $a['ativo'] ? 'Desativar' : 'Reativar' ?> este administrador?');" style="display:inline">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="toggle">
                <input type="hidden" name="id" value="<?= (int)$a['id'] ?>">
                <button type="submit" class="<?= $a['ativo'] ? 'danger' : '' ?>"><?= $a['ativo'] ? 'Desativar' : 'Reativar' ?></button>
              </form>
              <form method="post" onsubmit="return confirm('Remover permanentemente este administrador? Esta ação não pode ser desfeita.');" style="display:inline">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= (int)$a['id'] ?>">
                <button type="submit" class="danger">Remover</button>
              </form>
              <?php else: ?>
                <span style="color:var(--ink-faint); font-size:0.82rem;">Você</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>
<?php admin_foot(); ?>
