<?php
declare(strict_types=1);

function admin_head(string $title): void
{
    ?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="robots" content="noindex, nofollow" />
<title><?= htmlspecialchars($title, ENT_QUOTES) ?> — Painel Administrativo — TECH SANTOS BR</title>
<link rel="icon" type="image/png" href="/assets/img/favicon-32.png" />
<link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png" />
<link rel="stylesheet" href="/assets/css/style.css" />
<link rel="stylesheet" href="/assets/css/admin.css" />
</head>
<body>
    <?php
}

function admin_topbar(string $active): void
{
    $items = [
        'index' => ['/admin/', 'Dashboard'],
        'alunos' => ['/admin/alunos.php', 'Alunos'],
        'cursos' => ['/admin/cursos.php', 'Cursos'],
    ];
    ?>
<div class="admin-topbar">
  <a class="auth-brand" style="margin:0" href="/admin/">
    <img src="/assets/img/logo.jpg" alt="Tech Santos BR" />
    <span>TECH <em>SANTOS BR</em> · Admin</span>
  </a>
  <nav class="admin-nav">
    <?php foreach ($items as $key => [$href, $label]): ?>
      <a href="<?= $href ?>" <?= $key === $active ? 'aria-current="page"' : '' ?>><?= $label ?></a>
    <?php endforeach; ?>
    <a href="/admin/logout.php">Sair</a>
  </nav>
</div>
    <?php
}

function admin_foot(): void
{
    ?>
</body>
</html>
    <?php
}
