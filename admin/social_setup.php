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

require_once __DIR__ . '/../config_writer.php';

$thError = null;
$thResult = null;
$thMsg = null;

// Threads OAuth callback (mesma URL de retorno, identificada por state=threads)
if (isset($_GET['code']) && ($_GET['state'] ?? '') === 'threads') {
    $apiError = null;
    $exchange = meta_threads_exchange_code((string)$_GET['code'], $apiError);
    if ($exchange === null) {
        $thError = 'Falha ao trocar o código do Threads por um token: ' . $apiError;
    } else {
        $long = meta_threads_exchange_long_lived((string)($exchange['access_token'] ?? ''), $apiError);
        if ($long === null) {
            $thError = 'Token curto do Threads obtido, mas falhou ao trocar por um de longa duração: ' . $apiError;
        } else {
            $newToken = (string)($long['access_token'] ?? '');
            $me = meta_threads_me($newToken, $apiError);
            if ($me === null) {
                $thError = 'Token novo do Threads obtido, mas o teste /me falhou: ' . $apiError;
            } elseif (!config_set_define('META_THREADS_TOKEN', $newToken, $apiError)
                || !config_set_define('META_THREADS_USER_ID', (string)($me['id'] ?? ''), $apiError)) {
                $thError = 'Token do Threads válido, mas falhou ao gravar no servidor: ' . $apiError;
            } else {
                $thResult = ['username' => (string)($me['username'] ?? ''), 'id' => (string)($me['id'] ?? ''), 'days' => (int)round(((int)($long['expires_in'] ?? 0)) / 86400)];
            }
        }
    }
} elseif (isset($_GET['error']) && ($_GET['state'] ?? '') === 'threads') {
    $thError = 'Login do Threads cancelado ou negado: ' . (string)($_GET['error_description'] ?? $_GET['error']);
// Instagram OAuth callback (Meta redirects back here with ?code=... or ?error=...)
} elseif (isset($_GET['code'])) {
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
            $newToken = (string)($longLived['access_token'] ?? '');
            $igResult = [
                'expires_in' => (int)($longLived['expires_in'] ?? 0),
                'user_id' => (string)($exchange['user_id'] ?? ''),
                'saved' => false,
                'username' => null,
            ];
            // Confere o token novo antes de gravar — nunca troca um token por um
            // que não funciona.
            $me = meta_http_get(meta_ig_graph_url('me'), ['fields' => 'id,username', 'access_token' => $newToken], $apiError);
            if ($me === null) {
                $igError = 'Token novo obtido, mas o teste /me falhou: ' . $apiError;
                $igResult = null;
            } elseif (!config_set_define('META_IG_TOKEN', $newToken, $apiError)) {
                $igError = 'Token novo válido, mas falhou ao gravar no servidor: ' . $apiError;
                $igResult = null;
            } else {
                $igResult['saved'] = true;
                $igResult['username'] = (string)($me['username'] ?? '');
            }
        }
    }
} elseif (isset($_GET['error'])) {
    $igError = 'Login do Instagram cancelado ou negado: ' . (string)($_GET['error_description'] ?? $_GET['error']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'threads_app') {
    csrf_check();
    $appId = trim((string)($_POST['threads_app_id'] ?? ''));
    $appSecret = trim((string)($_POST['threads_app_secret'] ?? ''));
    $apiError = null;
    if (!preg_match('/^\d{6,25}$/', $appId) || !preg_match('/^[A-Za-z0-9]{16,64}$/', $appSecret)) {
        $thError = 'Confira o ID e a Chave Secreta do app do Threads (ID só números; chave só letras e números).';
    } elseif (!config_set_define('META_THREADS_APP_ID', $appId, $apiError) || !config_set_define('META_THREADS_APP_SECRET', $appSecret, $apiError)) {
        $thError = 'Não consegui gravar no servidor: ' . $apiError;
    } else {
        header('Location: /admin/social_setup.php?threads_app=ok');
        exit;
    }
}
if (isset($_GET['threads_app'])) {
    $thMsg = 'App do Threads salvo no servidor. Agora clique em “Conectar com Threads”.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') !== 'threads_app') {
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

admin_head('Configurar Meta (Facebook/Instagram/Threads)');
admin_topbar('social');
?>
<main class="admin-main">
  <div class="admin-head"><h1>Configurar Meta (Facebook/Instagram/Threads)</h1><a class="btn btn-ghost on-light" href="/admin/social_posts.php">← Fila de posts</a></div>

  <div class="buy-card" style="max-width:760px; margin-bottom:1.5rem;">
    <h2 style="font-size:1.1rem; margin-bottom:0.75rem;">Instagram</h2>
    <p style="color:var(--ink-soft); font-size:0.9rem; margin-bottom:1.25rem;">
      Usa o app filho "Instagram API com Login do Instagram" (ID <code><?= htmlspecialchars(META_IG_APP_ID, ENT_QUOTES) ?></code>). Clique abaixo e autorize com a conta <code>@tech_santos_br</code> — diferente do token gerado manualmente no painel, este fluxo permite renovar por 60 dias.
    </p>

    <?php if ($igError): ?><div class="alert alert-error"><?= htmlspecialchars($igError, ENT_QUOTES) ?></div><?php endif; ?>

    <?php if ($igResult): ?>
      <div style="padding:1rem; background:var(--surface-2); border-radius:6px;">
        <p style="font-weight:700; margin-bottom:0.5rem; color:var(--green-strong);">✓ Instagram reconectado e token salvo no servidor.</p>
        <p style="font-size:0.88rem; color:var(--ink-soft);">Conta confirmada: <strong>@<?= htmlspecialchars((string)$igResult['username'], ENT_QUOTES) ?></strong> · User ID <code><?= htmlspecialchars($igResult['user_id'], ENT_QUOTES) ?></code>. Os posts agendados voltam a publicar no próximo ciclo do cron (até 15 min). Não é preciso copiar nada.</p>
        <p style="font-size:0.8rem; color:var(--ink-faint); margin-top:0.5rem;">Válido por <?= (int)round($igResult['expires_in'] / 86400) ?> dias — depois disso, repita o login clicando no botão abaixo de novo.</p>
      </div>
    <?php else: ?>
      <a class="btn btn-primary" href="<?= htmlspecialchars(meta_instagram_authorize_url(), ENT_QUOTES) ?>">Conectar com Instagram</a>
    <?php endif; ?>
  </div>

  <div class="buy-card" style="max-width:760px; margin-bottom:1.5rem;">
    <h2 style="font-size:1.1rem; margin-bottom:0.75rem;">Threads</h2>
    <p style="color:var(--ink-soft); font-size:0.9rem; margin-bottom:1rem;">
      Usa o caso de uso “Acessar a API do Threads” do app da Meta. URL de retorno a cadastrar no app: <code><?= htmlspecialchars(threads_redirect_uri(), ENT_QUOTES) ?></code>. O token vale 60 dias e é renovado automaticamente todo dia.
    </p>
    <?php if ($thError): ?><div class="alert alert-error"><?= htmlspecialchars($thError, ENT_QUOTES) ?></div><?php endif; ?>
    <?php if ($thMsg): ?><div class="alert alert-success"><?= htmlspecialchars($thMsg, ENT_QUOTES) ?></div><?php endif; ?>
    <?php if ($thResult): ?>
      <div style="padding:1rem; background:var(--surface-2); border-radius:6px;">
        <p style="font-weight:700; margin-bottom:0.5rem; color:var(--green-strong);">✓ Threads conectado e token salvo no servidor.</p>
        <p style="font-size:0.88rem; color:var(--ink-soft);">Conta: <strong>@<?= htmlspecialchars($thResult['username'], ENT_QUOTES) ?></strong> · ID <code><?= htmlspecialchars($thResult['id'], ENT_QUOTES) ?></code> · válido por <?= (int)$thResult['days'] ?> dias (renovação diária automática).</p>
      </div>
    <?php else: ?>
      <form method="post" novalidate style="margin-bottom:1rem;">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="threads_app">
        <div class="field"><label for="threads_app_id">ID do app do Threads <?= threads_cfg('META_THREADS_APP_ID') !== '' ? '(já salvo — preencha só para trocar)' : '' ?></label><input type="text" id="threads_app_id" name="threads_app_id" autocomplete="off"></div>
        <div class="field"><label for="threads_app_secret">Chave secreta do app do Threads</label><input type="password" id="threads_app_secret" name="threads_app_secret" autocomplete="off"></div>
        <button type="submit" class="btn btn-ghost on-light">1. Salvar app do Threads</button>
      </form>
      <?php if (threads_cfg('META_THREADS_APP_ID') !== '' && threads_cfg('META_THREADS_APP_SECRET') !== ''): ?>
        <a class="btn btn-primary" href="<?= htmlspecialchars(meta_threads_authorize_url(), ENT_QUOTES) ?>">2. Conectar com Threads</a>
        <?php if (threads_cfg('META_THREADS_TOKEN') !== ''): ?><p style="font-size:0.82rem; color:var(--ink-faint); margin-top:0.5rem;">Já existe um token salvo. Só reconecte se a publicação parar.</p><?php endif; ?>
      <?php endif; ?>
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
