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

    if ($action === 'save') {
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
            $dup = $pdo->prepare('SELECT id FROM admin_users WHERE usuario = ? OR email = ?');
            $dup->execute([$usuario, $email]);
            if ($dup->fetch()) {
                $error = 'Já existe um administrador com este usuário ou e-mail.';
            } else {
                $senhaGerada = bin2hex(random_bytes(6));
                $ins = $pdo->prepare('INSERT INTO admin_users (usuario, nome, email, senha_hash, senha_temporaria) VALUES (?, ?, ?, ?, 1)');
                $ins->execute([$usuario, $nome, $email, password_hash($senhaGerada, PASSWORD_DEFAULT)]);
                $emailEnviado = send_admin_credentials_email($email, $nome, $usuario, $senhaGerada);
                $success = $emailEnviado
                    ? 'Administrador cadastrado. Credenciais enviadas por e-mail.'
                    : "Administrador cadastrado, mas o envio do e-mail falhou. Usuário: {$usuario} · Senha provisória: {$senhaGerada}";
                header('Location: /admin/administradores.php?msg=' . urlencode($success));
                exit;
            }
        }
    }
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
    <h2>Cadastrar administrador</h2>
    <form method="post" novalidate>
      <?= csrf_field() ?>
      <input type="hidden" name="action" value="save">
      <div class="field">
        <label for="nome">Nome completo *</label>
        <input type="text" id="nome" name="nome" required>
      </div>
      <div class="field-row">
        <div class="field">
          <label for="email">E-mail *</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="field">
          <label for="usuario">Usuário de login *</label>
          <input type="text" id="usuario" name="usuario" required placeholder="ex.: joao.silva">
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Cadastrar administrador</button>
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
              <form method="post" onsubmit="return confirm('<?= $a['ativo'] ? 'Desativar' : 'Reativar' ?> este administrador?');">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="toggle">
                <input type="hidden" name="id" value="<?= (int)$a['id'] ?>">
                <button type="submit" class="<?= $a['ativo'] ? 'danger' : '' ?>"><?= $a['ativo'] ? 'Desativar' : 'Reativar' ?></button>
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
