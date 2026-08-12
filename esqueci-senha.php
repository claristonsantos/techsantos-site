<?php
declare(strict_types=1);
require_once __DIR__ . '/password_reset.php';
require_once __DIR__ . '/mailer.php';
$sent = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $email = trim((string)($_POST['email'] ?? ''));
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $reset = create_password_reset($email);
        if ($reset) send_password_reset_email($reset['email'], $reset['nome'], $reset['token']);
    }
    $sent = true;
}
?>
<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex,nofollow"><title>Recuperar senha — TECH SANTOS BR</title><link rel="stylesheet" href="/assets/css/style.css"><link rel="stylesheet" href="/assets/css/admin.css"></head><body><div class="auth-shell"><div class="auth-card"><a class="auth-brand" href="/login.php"><img src="/assets/img/logo.jpg" alt="Tech Santos BR"><span>TECH <em>SANTOS BR</em></span></a><h1>Recuperar senha</h1>
<?php if ($sent): ?><div class="alert alert-success">Se o e-mail estiver cadastrado, você receberá um link válido por 30 minutos.</div><p><a class="btn btn-primary btn-block" href="/login.php">Voltar ao login</a></p>
<?php else: ?><p class="sub">Informe o e-mail usado na compra do curso.</p><form method="post"><?= csrf_field() ?><div class="field"><label for="email">E-mail</label><input type="email" id="email" name="email" required autocomplete="email"></div><button class="btn btn-primary btn-block" type="submit">Enviar link seguro</button></form><?php endif; ?></div></div></body></html>
