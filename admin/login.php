<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';

start_secure_session();
if (!empty($_SESSION['admin_id'])) {
    header('Location: /admin/');
    exit;
}

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $usuario = trim((string)($_POST['usuario'] ?? ''));
    $senha = (string)($_POST['senha'] ?? '');
    if ($usuario === '' || $senha === '') {
        $error = 'Preencha usuário e senha.';
    } elseif (admin_attempt_login($usuario, $senha)) {
        header('Location: /admin/');
        exit;
    } else {
        $error = 'Usuário ou senha inválidos.';
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="robots" content="noindex, nofollow" />
<title>Painel Administrativo — TECH SANTOS BR</title>
<link rel="icon" type="image/png" href="/assets/img/favicon-32.png" />
<link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png" />
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
    <h1>Painel Administrativo</h1>
    <p class="sub">Gestão de alunos e cursos.</p>
    <?php if ($error): ?>
      <div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES) ?></div>
    <?php endif; ?>
    <form method="post" novalidate>
      <?= csrf_field() ?>
      <div class="field">
        <label for="usuario">Usuário</label>
        <input type="text" id="usuario" name="usuario" required autocomplete="username" value="<?= htmlspecialchars($_POST['usuario'] ?? '', ENT_QUOTES) ?>">
      </div>
      <div class="field">
        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" required autocomplete="current-password">
      </div>
      <button type="submit" class="btn btn-primary btn-block">Entrar</button>
    </form>
  </div>
</div>
</body>
</html>
