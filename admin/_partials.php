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
<link rel="stylesheet" href="/assets/css/admin.css?v=20260812-admin4" />
</head>
<body class="admin-body">
    <?php
}

function admin_icon(string $name): string
{
    $paths = [
        'dashboard' => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>',
        'metrics' => '<path d="M4 19V9M10 19V5M16 19v-7M22 19V3"/>',
        'orders' => '<path d="M3 6h18l-2 9H6L3 3H1"/><circle cx="8" cy="20" r="1"/><circle cx="17" cy="20" r="1"/>',
        'lessons' => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 10h18"/><path d="m9 15 2 2 4-4"/>',
        'students' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>',
        'certificate' => '<circle cx="12" cy="8" r="5"/><path d="m8.5 12-1 9 4.5-2 4.5 2-1-9"/>',
        'course' => '<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20V3H6.5A2.5 2.5 0 0 0 4 5.5z"/><path d="M4 5.5v14"/>',
        'assessment' => '<path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>',
        'journey' => '<circle cx="5" cy="6" r="2"/><circle cx="19" cy="18" r="2"/><path d="M7 6h5a4 4 0 0 1 4 4v0a4 4 0 0 1-4 4H9a4 4 0 0 0-4 4v0"/>',
        'social' => '<path d="M18 8a3 3 0 1 0-3-3M6 14a3 3 0 1 0 3 3"/><path d="m8.6 15.5 6.8-4M8.6 8.5l6.8 4"/>',
        'reply' => '<path d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4z"/><path d="M8 9h8M8 13h5"/>',
        'admin' => '<circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/><path d="m18 5 1 1 2-2"/>',
        'logout' => '<path d="M10 17l5-5-5-5M15 12H3"/><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>',
    ];
    $path = $paths[$name] ?? $paths['dashboard'];
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $path . '</svg>';
}

function admin_topbar(string $active): void
{
    $groups = [
        'Visão geral' => [
            'index' => ['/admin/', 'Dashboard', 'dashboard'],
            'metricas' => ['/admin/metricas.php', 'Métricas', 'metrics'],
        ],
        'Vendas e alunos' => [
            'pedidos' => ['/admin/pedidos.php', 'Pedidos', 'orders'],
            'aulas_particulares' => ['/admin/aulas_particulares.php', 'Aulas particulares', 'lessons'],
            'alunos' => ['/admin/alunos.php', 'Alunos', 'students'],
            'certificados' => ['/admin/certificados.php', 'Certificados', 'certificate'],
        ],
        'Curso' => [
            'cursos' => ['/admin/cursos.php', 'Cursos', 'course'],
            'avaliacoes' => ['/admin/avaliacoes.php', 'Avaliações', 'assessment'],
            'jornada' => ['/admin/jornada.php', 'Jornada do aluno', 'journey'],
        ],
        'Marketing' => [
            'social' => ['/admin/social_posts.php', 'Redes sociais', 'social'],
            'social_auto_reply' => ['/admin/social_auto_reply.php', 'Auto-resposta', 'reply'],
        ],
        'Configurações' => [
            'administradores' => ['/admin/administradores.php', 'Administradores', 'admin'],
        ],
    ];
    ?>
<a class="admin-skip-link" href="#adminContent">Pular para o conteúdo</a>
<header class="admin-mobile-header">
  <button class="admin-menu-toggle" id="adminMenuToggle" type="button" aria-label="Abrir menu administrativo" aria-expanded="false" aria-controls="adminSidebar">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
  </button>
  <a class="admin-mobile-brand" href="/admin/"><img src="/assets/img/logo.jpg" alt=""><span>TECH <em>SANTOS BR</em></span></a>
  <span class="admin-mobile-label">Admin</span>
</header>
<div class="admin-sidebar-backdrop" id="adminSidebarBackdrop"></div>
<aside class="admin-sidebar" id="adminSidebar" aria-label="Menu administrativo">
  <a class="admin-brand" href="/admin/">
    <img src="/assets/img/logo.jpg" alt="Tech Santos BR" />
    <span><strong>TECH <em>SANTOS BR</em></strong><small>Painel de gestão</small></span>
  </a>
  <nav class="admin-nav">
    <?php foreach ($groups as $group => $items): ?>
      <div class="admin-nav-group">
        <span class="admin-nav-label"><?= htmlspecialchars($group, ENT_QUOTES) ?></span>
        <?php foreach ($items as $key => [$href, $label, $icon]): ?>
          <a href="<?= $href ?>" <?= $key === $active ? 'aria-current="page"' : '' ?>><?= admin_icon($icon) ?><span><?= htmlspecialchars($label, ENT_QUOTES) ?></span></a>
        <?php endforeach; ?>
      </div>
    <?php endforeach; ?>
  </nav>
  <div class="admin-sidebar-footer"><a href="/admin/logout.php"><?= admin_icon('logout') ?><span>Sair do painel</span></a></div>
</aside>
    <?php
}

function admin_page_url(array $changes = []): string
{
    $query = array_merge($_GET, $changes);
    foreach ($query as $key => $value) {
        if ($value === null || $value === '') unset($query[$key]);
    }
    $path = strtok($_SERVER['REQUEST_URI'] ?? '', '?') ?: ($_SERVER['PHP_SELF'] ?? '/admin/');
    return $path . ($query ? '?' . http_build_query($query) : '');
}

function admin_pagination(int $page, int $pages, int $total): void
{
    if ($pages <= 1) return;
    $start = max(1, $page - 2);
    $end = min($pages, $page + 2);
    ?>
    <nav class="admin-pagination" aria-label="Paginação">
      <span><?= $total ?> registro(s)</span>
      <div>
        <?php if ($page > 1): ?><a href="<?= htmlspecialchars(admin_page_url(['pagina' => $page - 1]), ENT_QUOTES) ?>">Anterior</a><?php endif; ?>
        <?php for ($i = $start; $i <= $end; $i++): ?><a href="<?= htmlspecialchars(admin_page_url(['pagina' => $i]), ENT_QUOTES) ?>" <?= $i === $page ? 'aria-current="page"' : '' ?>><?= $i ?></a><?php endfor; ?>
        <?php if ($page < $pages): ?><a href="<?= htmlspecialchars(admin_page_url(['pagina' => $page + 1]), ENT_QUOTES) ?>">Próxima</a><?php endif; ?>
      </div>
    </nav>
    <?php
}

function admin_foot(): void
{
    ?>
<script src="/assets/js/admin-shell.js?v=20260812-admin4"></script>
</body>
</html>
    <?php
}
