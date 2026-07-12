<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/_partials.php';
require_admin();

$totalAlunos = (int)db()->query('SELECT COUNT(*) FROM alunos WHERE ativo = 1')->fetchColumn();
$totalCursos = (int)db()->query('SELECT COUNT(*) FROM cursos WHERE ativo = 1')->fetchColumn();
$totalInativos = (int)db()->query('SELECT COUNT(*) FROM alunos WHERE ativo = 0')->fetchColumn();

admin_head('Dashboard');
admin_topbar('index');
?>
<main class="admin-main">
  <div class="admin-head"><h1>Dashboard</h1></div>
  <div class="stat-row">
    <div class="stat-tile"><div class="num"><?= $totalAlunos ?></div><div class="lbl">Alunos ativos</div></div>
    <div class="stat-tile"><div class="num"><?= $totalCursos ?></div><div class="lbl">Cursos ativos</div></div>
    <div class="stat-tile"><div class="num"><?= $totalInativos ?></div><div class="lbl">Alunos inativos</div></div>
  </div>
  <div class="hero-cta">
    <a class="btn btn-primary" href="/admin/alunos.php">Gerenciar alunos</a>
    <a class="btn btn-ghost on-light" href="/admin/cursos.php">Gerenciar cursos</a>
  </div>
</main>
<?php admin_foot(); ?>
