<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
$admin = require_admin(true);

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $senha = (string)($_POST['senha'] ?? '');
    $confirmar = (string)($_POST['confirmar'] ?? '');

    if (strlen($senha) < 8) {
        $error = 'A nova senha precisa ter pelo menos 8 caracteres.';
    } elseif ($senha !== $confirmar) {
        $error = 'As senhas não coincidem.';
    } else {
        $stmt = db()->prepare('UPDATE admin_users SET senha_hash = ?, senha_temporaria = 0 WHERE id = ?');
        $stmt->execute([password_hash($senha, PASSWORD_DEFAULT), $admin['id']]);
        header('Location: /admin/');
        exit;
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="robots" content="noindex, nofollow" />
<link rel="icon" type="image/png" href="/assets/img/favicon-32.png" />
<title>Trocar senha — Painel Administrativo — TECH SANTOS BR</title>
<link rel="stylesheet" href="/assets/css/style.css" />
<link rel="stylesheet" href="/assets/css/admin.css" />
</head>
<body>
<div class="auth-shell">
  <div class="auth-card">
    <a class="auth-brand" href="/index.html">
      <img src="/assets/img/logo.jpg" alt="Tech Santos BR" />
      <span>TECH <em>SANTOS BR</em></span>
    </a>
    <h1>Defina sua senha</h1>
    <p class="sub">Este é seu primeiro acesso ao painel administrativo, <?= htmlspecialchars(explode(' ', $admin['nome'] ?: $admin['usuario'])[0], ENT_QUOTES) ?>. Escolha uma senha nova antes de continuar.</p>
    <?php if ($error): ?>
      <div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES) ?></div>
    <?php endif; ?>
    <form method="post" novalidate>
      <?= csrf_field() ?>
      <div class="field">
        <label for="senha">Nova senha</label>
        <input type="password" id="senha" name="senha" required autocomplete="new-password" minlength="8">
      </div>
      <div class="field">
        <label for="confirmar">Confirmar nova senha</label>
        <input type="password" id="confirmar" name="confirmar" required autocomplete="new-password" minlength="8">
      </div>
      <button type="submit" class="btn btn-primary btn-block">Salvar e continuar</button>
    </form>
  </div>
</div>
</body>
</html>
