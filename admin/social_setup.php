<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../meta_social.php';
require_once __DIR__ . '/_partials.php';
require_admin();

$error = null;
$result = null;
$igError = null;
$igResult = null;

// Instagram OAuth callback (Meta redirects back here with ?code=... or ?error=...)
if (isset($_GET['code'])) {
    $apiError = null;
    $exchange = meta_instagram_exchange_code((string)$_GET['code'], $apiError);

    if ($exchange === null) {
        $igError = 'Falha ao trocar o código por um token: ' . $apiError;
    } else {
        $shortToken = (string)($exchange['access_token'] ?? '');
        $longLived = meta_instagram_exchange_long_lived($shortToken, $apiError);

        if ($longLived === null) {
            $igError = 'Token curto obtido, mas falhou ao trocar por um de longa duração: ' . $apiError;
        } else {
            $igResult = [
                'token' => (string)($longLived['access_token'] ?? ''),
                'expires_in' => (int)($longLived['expires_in'] ?? 0),
                'user_id' => (string)($exchange['user_id'] ?? ''),
            ];
        }
    }
} elseif (isset($_GET['error'])) {
    $igError = 'Login do Instagram cancelado ou negado: ' . (string)($_GET['error_description'] ?? $_GET['error']);
}

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
                    $result['pages'][] = [
                        'name' => $page['name'] ?? '(sem nome)',
                        'id' => (string)$page['id'],
                        'token' => (string)$page['access_token'],
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
  <div class="admin-head"><h1>Configurar Meta (Facebook/Instagram)</h1><a class="btn btn-ghost on-light" href="/admin/social_posts.php">← Fila de posts</a></div>

  <div class="buy-card" style="max-width:760px; margin-bottom:1.5rem;">
    <h2 style="font-size:1.1rem; margin-bottom:0.75rem;">Instagram</h2>
    <p style="color:var(--ink-soft); font-size:0.9rem; margin-bottom:1.25rem;">
      Usa o app filho "Instagram API com Login do Instagram" (ID <code><?= htmlspecialchars(META_IG_APP_ID, ENT_QUOTES) ?></code>). Clique abaixo e autorize com a conta <code>@tech_santos_br</code> — diferente do token gerado manualmente no painel, este fluxo permite renovar por 60 dias.
    </p>

    <?php if ($igError): ?><div class="alert alert-error"><?= htmlspecialchars($igError, ENT_QUOTES) ?></div><?php endif; ?>

    <?php if ($igResult): ?>
      <div style="padding:1rem; background:var(--surface-2); border-radius:6px;">
        <p style="font-weight:700; margin-bottom:0.5rem;">Cole em config.php:</p>
        <pre style="background:var(--surface); padding:1rem; border-radius:6px; overflow-x:auto; font-size:0.82rem;">define('META_IG_TOKEN', '<?= htmlspecialchars($igResult['token'], ENT_QUOTES) ?>');</pre>
        <p style="font-size:0.82rem; color:var(--ink-soft);">Instagram User ID confirmado: <code><?= htmlspecialchars($igResult['user_id'], ENT_QUOTES) ?></code></p>
        <p style="font-size:0.8rem; color:var(--ink-faint); margin-top:0.5rem;">Válido por <?= (int)round($igResult['expires_in'] / 86400) ?> dias — depois disso, repita o login clicando no botão abaixo de novo.</p>
      </div>
    <?php else: ?>
      <a class="btn btn-primary" href="<?= htmlspecialchars(meta_instagram_authorize_url(), ENT_QUOTES) ?>">Conectar com Instagram</a>
    <?php endif; ?>
  </div>

  <div class="buy-card" style="max-width:760px;">
    <h2 style="font-size:1.1rem; margin-bottom:0.75rem;">Facebook</h2>
    <p style="color:var(--ink-soft); font-size:0.92rem; margin-bottom:1.25rem;">
      Abra o <a href="https://developers.facebook.com/tools/explorer/" target="_blank" rel="noopener">Graph API Explorer</a>, selecione o app "TECH SANTOS BR - Redes Sociais", gere um <strong>Token de Acesso do Usuário</strong> com as permissões <code>pages_manage_posts</code>, <code>pages_read_engagement</code>, <code>pages_show_list</code> e <code>business_management</code>, e cole abaixo.
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
        <?php foreach ($result['pages'] as $page): ?>
          <div style="margin-top:1rem; padding:1rem; background:var(--surface-2); border-radius:6px;">
            <p><strong><?= htmlspecialchars($page['name'], ENT_QUOTES) ?></strong></p>
            <pre style="background:var(--surface); padding:1rem; border-radius:6px; overflow-x:auto; font-size:0.82rem;">define('META_PAGE_ID', '<?= htmlspecialchars($page['id'], ENT_QUOTES) ?>');
define('META_PAGE_TOKEN', '<?= htmlspecialchars($page['token'], ENT_QUOTES) ?>');</pre>
          </div>
        <?php endforeach; ?>
        <p style="font-size:0.8rem; color:var(--ink-faint); margin-top:1rem;">O token da Página herdado do token de usuário de longa duração continua válido enquanto esse token de usuário não expirar (60 dias) e você continuar como admin da Página — vale repetir esse processo periodicamente.</p>
      </div>
    <?php endif; ?>
  </div>
</main>
<?php admin_foot(); ?>
