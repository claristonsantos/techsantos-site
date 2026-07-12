<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';

if (aluno_logged_id() !== null) {
    header('Location: /aluno/');
    exit;
}

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $email = trim((string)($_POST['email'] ?? ''));
    $senha = (string)($_POST['senha'] ?? '');
    if ($email === '' || $senha === '') {
        $error = 'Preencha e-mail e senha.';
    } elseif (aluno_attempt_login($email, $senha)) {
        header('Location: /aluno/');
        exit;
    } else {
        $error = 'E-mail ou senha inválidos.';
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="robots" content="noindex, nofollow" />
<title>Entrar — Área do Aluno — TECH SANTOS BR</title>
<link rel="icon" type="image/png" href="/assets/img/favicon-32.png" />
<link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png" />
<link rel="stylesheet" href="/assets/css/style.css" />
<link rel="stylesheet" href="/assets/css/admin.css" />
</head>
<body>
<div class="auth-shell">
  <div class="auth-card">
    <a class="auth-brand" href="/curso-power-bi.html">
      <img src="/assets/img/logo.jpg" alt="Tech Santos BR" />
      <span>TECH <em>SANTOS BR</em></span>
    </a>
    <h1>Área do Aluno</h1>
    <p class="sub">Entre com o e-mail e a senha que você recebeu para acessar o curso.</p>
    <?php if ($error): ?>
      <div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES) ?></div>
    <?php endif; ?>
    <form method="post" novalidate>
      <?= csrf_field() ?>
      <div class="field">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" required autocomplete="username" value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES) ?>">
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
