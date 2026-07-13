<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../meta_social.php';
require_once __DIR__ . '/_partials.php';
require_admin();

$error = null;
$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $shortToken = trim((string)($_POST['short_token'] ?? ''));

    if ($shortToken === '') {
        $error = 'Cole o token de curta duração copiado do Graph API Explorer.';
    } elseif (META_APP_ID === '' || META_APP_SECRET === '') {
        $error = 'Preencha META_APP_ID e META_APP_SECRET em config.php antes (veja o ID e a Chave Secreta do App em developers.facebook.com).';
    } else {
        $apiError = null;
        $longToken = meta_exchange_long_lived_token($shortToken, $apiError);

        if ($longToken === null) {
            $error = 'Falha ao trocar o token: ' . $apiError;
        } else {
            $pages = meta_list_pages($longToken, $apiError);
            if ($pages === null) {
                $error = 'Token trocado, mas falhou ao listar páginas: ' . $apiError;
            } elseif (!$pages) {
                $error = 'Token trocado, mas nenhuma Página foi encontrada para esta conta.';
            } else {
                $result = ['long_token' => $longToken, 'pages' => []];
                foreach ($pages as $page) {
                    $pageId = (string)$page['id'];
                    $pageToken = (string)$page['access_token'];
                    $igId = meta_get_instagram_business_id($pageId, $pageToken, $apiError);
                    $result['pages'][] = [
                        'name' => $page['name'] ?? '(sem nome)',
                        'id' => $pageId,
                        'token' => $pageToken,
                        'ig_id' => $igId,
                    ];
                }
            }
        }
    }
}

admin_head('Configurar Meta (Facebook/Instagram)');
admin_topbar('social');
?>
<main class="admin-main">
  <div class="admin-head"><h1>Configurar Meta (Facebook/Instagram)</h1></div>

  <div class="buy-card" style="max-width:760px;">
    <p style="color:var(--ink-soft); font-size:0.92rem; margin-bottom:1.25rem;">
      Passo a passo: crie um app em <a href="https://developers.facebook.com/apps" target="_blank" rel="noopener">developers.facebook.com/apps</a> (tipo "Negócios"), copie o <strong>ID do Aplicativo</strong> e a <strong>Chave Secreta</strong> pra <code>config.php</code> (<code>META_APP_ID</code>/<code>META_APP_SECRET</code>). Depois abra o
      <a href="https://developers.facebook.com/tools/explorer/" target="_blank" rel="noopener">Graph API Explorer</a>, selecione esse app, peça as permissões
      <code>pages_manage_posts</code>, <code>pages_read_engagement</code>, <code>pages_show_list</code>, <code>instagram_basic</code>, <code>instagram_content_publish</code> e <code>business_management</code>, gere o token e cole abaixo.
    </p>

    <?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES) ?></div><?php endif; ?>

    <form method="post" novalidate>
      <?= csrf_field() ?>
      <div class="field">
        <label for="short_token">Token de curta duração (Graph API Explorer)</label>
        <input type="text" id="short_token" name="short_token" required>
      </div>
      <button type="submit" class="btn btn-primary">Trocar e buscar Páginas</button>
    </form>

    <?php if ($result): ?>
      <div style="margin-top:2rem; padding-top:1.5rem; border-top:1px solid var(--line);">
        <p style="font-weight:700; margin-bottom:0.75rem;">Cole em config.php:</p>
        <pre style="background:var(--surface-2); padding:1rem; border-radius:6px; overflow-x:auto; font-size:0.82rem;">define('META_PAGE_TOKEN', '<?= htmlspecialchars($result['pages'][0]['token'] ?? '', ENT_QUOTES) ?>');</pre>

        <?php foreach ($result['pages'] as $page): ?>
          <div style="margin-top:1rem; padding:1rem; background:var(--surface-2); border-radius:6px;">
            <p><strong><?= htmlspecialchars($page['name'], ENT_QUOTES) ?></strong></p>
            <p style="font-size:0.85rem; color:var(--ink-soft);">META_PAGE_ID: <code><?= htmlspecialchars($page['id'], ENT_QUOTES) ?></code></p>
            <p style="font-size:0.85rem; color:var(--ink-soft);">META_IG_USER_ID: <code><?= htmlspecialchars($page['ig_id'] ?? '(nenhuma conta Instagram vinculada a esta Página)', ENT_QUOTES) ?></code></p>
          </div>
        <?php endforeach; ?>

        <p style="font-size:0.8rem; color:var(--ink-faint); margin-top:1rem;">O token da Página herdado do token de usuário de longa duração continua válido enquanto esse token de usuário não expirar (60 dias) e você continuar como admin da Página — vale repetir esse processo periodicamente.</p>
      </div>
    <?php endif; ?>
  </div>
</main>
<?php admin_foot(); ?>
