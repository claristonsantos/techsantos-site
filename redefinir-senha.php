<?php
declare(strict_types=1);
require_once __DIR__ . '/password_reset.php';
$token = (string)($_GET['token'] ?? $_POST['token'] ?? '');
$error = null; $done = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $senha = (string)($_POST['senha'] ?? ''); $confirmacao = (string)($_POST['confirmacao'] ?? '');
    if (strlen($senha) < 8) $error = 'Use pelo menos 8 caracteres.';
    elseif ($senha !== $confirmacao) $error = 'As senhas não coincidem.';
    elseif (!reset_password_with_token($token, $senha)) $error = 'Este link é inválido, expirou ou já foi utilizado.';
    else $done = true;
}
?>
<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex,nofollow"><title>Nova senha — TECH SANTOS BR</title><link rel="stylesheet" href="/assets/css/style.css"><link rel="stylesheet" href="/assets/css/admin.css"></head><body><div class="auth-shell"><div class="auth-card"><a class="auth-brand" href="/login.php"><img src="/assets/img/logo.jpg" alt="Tech Santos BR"><span>TECH <em>SANTOS BR</em></span></a><h1>Definir nova senha</h1>
<?php if ($done): ?><div class="alert alert-success">Senha alterada com sucesso.</div><a class="btn btn-primary btn-block" href="/login.php">Entrar no curso</a>
<?php else: ?><?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES) ?></div><?php endif; ?><form method="post"><?= csrf_field() ?><input type="hidden" name="token" value="<?= htmlspecialchars($token, ENT_QUOTES) ?>"><div class="field"><label for="senha">Nova senha</label><input type="password" id="senha" name="senha" required minlength="8" autocomplete="new-password"></div><div class="field"><label for="confirmacao">Confirmar nova senha</label><input type="password" id="confirmacao" name="confirmacao" required minlength="8" autocomplete="new-password"></div><button class="btn btn-primary btn-block" type="submit">Salvar nova senha</button></form><?php endif; ?></div></div></body></html>
