<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
$aluno = require_aluno(true);

$precisaSenha = (bool)$aluno['senha_temporaria'];
$precisaCpf = empty($aluno['cpf']);

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();

    $senha = (string)($_POST['senha'] ?? '');
    $confirmar = (string)($_POST['confirmar'] ?? '');
    $cpfInformado = (string)($_POST['cpf'] ?? '');

    if ($precisaSenha && strlen($senha) < 6) {
        $error = 'A nova senha precisa ter pelo menos 6 caracteres.';
    } elseif ($precisaSenha && $senha !== $confirmar) {
        $error = 'As senhas não coincidem.';
    } elseif ($precisaCpf && !cpf_is_valid($cpfInformado)) {
        $error = 'CPF inválido. Confira os números e tente de novo.';
    } else {
        $cpf = $precisaCpf ? cpf_digits($cpfInformado) : (string)$aluno['cpf'];
        $dupStmt = db()->prepare('SELECT 1 FROM alunos WHERE cpf = ? AND id != ? LIMIT 1');
        $dupStmt->execute([$cpf, $aluno['id']]);
        if ($dupStmt->fetchColumn()) {
            $error = 'Este CPF já está vinculado a outro cadastro. Fale com o suporte para corrigirmos seu acesso.';
        } else {
            $pdo = db();
            $pdo->beginTransaction();
            try {
                if ($precisaSenha) {
                    $pdo->prepare('UPDATE alunos SET senha_hash = ?, senha_temporaria = 0 WHERE id = ?')
                        ->execute([password_hash($senha, PASSWORD_DEFAULT), $aluno['id']]);
                }
                if ($precisaCpf) {
                    $pdo->prepare('UPDATE alunos SET cpf = ? WHERE id = ?')->execute([$cpf, $aluno['id']]);
                }
                $pdo->commit();
                header('Location: /aluno/');
                exit;
            } catch (Throwable $e) {
                if ($pdo->inTransaction()) $pdo->rollBack();
                $error = 'Não foi possível salvar seus dados agora. Tente novamente ou fale com o suporte.';
            }
        }
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
<title><?= $precisaSenha ? 'Trocar senha' : 'Complete seu cadastro' ?> — Área do Aluno — TECH SANTOS BR</title>
<link rel="stylesheet" href="/assets/css/style.css" />
<link rel="stylesheet" href="/assets/css/admin.css" />
</head>
<body>
<div class="auth-shell">
  <div class="auth-card">
    <a class="auth-brand" href="/curso-power-bi.php">
      <img src="/assets/img/logo.jpg" alt="Tech Santos BR" />
      <span>TECH <em>SANTOS BR</em></span>
    </a>
    <h1><?= $precisaSenha ? 'Defina sua senha' : 'Falta só uma coisa' ?></h1>
    <p class="sub">
      <?php if ($precisaSenha && $precisaCpf): ?>
        Este é seu primeiro acesso. Por segurança, escolha uma senha nova e confirme seu CPF (necessário pra emitir seu certificado no final do curso).
      <?php elseif ($precisaSenha): ?>
        Este é seu primeiro acesso. Por segurança, escolha uma senha nova antes de continuar.
      <?php else: ?>
        Precisamos do seu CPF pra emitir seu certificado no final do curso.
      <?php endif; ?>
    </p>
    <?php if ($error): ?>
      <div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES) ?></div>
    <?php endif; ?>
    <form method="post" novalidate>
      <?= csrf_field() ?>
      <?php if ($precisaSenha): ?>
      <div class="field">
        <label for="senha">Nova senha</label>
        <input type="password" id="senha" name="senha" required autocomplete="new-password" minlength="6">
      </div>
      <div class="field">
        <label for="confirmar">Confirmar nova senha</label>
        <input type="password" id="confirmar" name="confirmar" required autocomplete="new-password" minlength="6">
      </div>
      <?php endif; ?>
      <?php if ($precisaCpf): ?>
      <div class="field">
        <label for="cpf">CPF</label>
        <input type="text" id="cpf" name="cpf" required inputmode="numeric" placeholder="000.000.000-00" maxlength="14">
        <span class="hint">Usado só pra emitir seu certificado de conclusão.</span>
      </div>
      <?php endif; ?>
      <button type="submit" class="btn btn-primary btn-block">Salvar e continuar</button>
    </form>
  </div>
</div>
<script>
var cpfInput = document.getElementById('cpf');
if (cpfInput) {
  cpfInput.addEventListener('input', function () {
    var d = this.value.replace(/\D/g, '').slice(0, 11);
    var v = d;
    if (d.length > 9) v = d.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
    else if (d.length > 6) v = d.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
    else if (d.length > 3) v = d.replace(/(\d{3})(\d{1,3})/, '$1.$2');
    this.value = v;
  });
}
</script>
</body>
</html>
