<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../google_calendar.php';
require_once __DIR__ . '/_partials.php';
require_admin();
csrf_token();

$pdo = db();
google_calendar_ensure($pdo);
$error = null;
$success = null;

if (isset($_GET['code'])) {
    $state = (string)($_GET['state'] ?? '');
    $expectedState = (string)($_SESSION['google_calendar_oauth_state'] ?? '');
    unset($_SESSION['google_calendar_oauth_state']);
    if ($state === '' || $expectedState === '' || !hash_equals($expectedState, $state)) {
        $error = 'A conexão expirou ou o estado de segurança é inválido. Tente novamente.';
    } else {
        $apiError = null;
        if (google_calendar_exchange_code($pdo, (string)$_GET['code'], $apiError)) {
            header('Location: /admin/google_calendar_setup.php?status=connected');
            exit;
        }
        $error = 'Não foi possível concluir a conexão: ' . $apiError;
    }
} elseif (isset($_GET['error'])) {
    $error = 'A autorização do Google foi cancelada ou negada.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = (string)($_POST['action'] ?? 'save');
    if ($action === 'save') {
        $current = google_calendar_config($pdo);
        $clientId = trim((string)($_POST['client_id'] ?? ''));
        $clientSecret = trim((string)($_POST['client_secret'] ?? ''));
        if ($clientId === '') $clientId = $current['client_id'];
        if ($clientSecret === '') $clientSecret = $current['client_secret'];
        $calendarId = trim((string)($_POST['calendar_id'] ?? 'primary')) ?: 'primary';
        if ($clientId === '' || $clientSecret === '') {
            $error = 'Informe o Client ID e o Client Secret da credencial OAuth Web.';
        } else {
            google_calendar_save_credentials($pdo, $clientId, $clientSecret, $calendarId);
            header('Location: /admin/google_calendar_setup.php?status=saved');
            exit;
        }
    } elseif ($action === 'connect') {
        $config = google_calendar_config($pdo);
        if ($config['client_id'] === '' || $config['client_secret'] === '') {
            $error = 'Salve primeiro o Client ID e o Client Secret.';
        } else {
            $state = bin2hex(random_bytes(24));
            $_SESSION['google_calendar_oauth_state'] = $state;
            header('Location: ' . google_calendar_authorize_url($pdo, $state));
            exit;
        }
    } elseif ($action === 'disconnect') {
        $pdo->exec("UPDATE google_calendar_config SET refresh_token=NULL,conectado_em=NULL WHERE id=1");
        header('Location: /admin/google_calendar_setup.php?status=disconnected');
        exit;
    }
}

$config = google_calendar_config($pdo);
$connected = google_calendar_is_connected($pdo);
$status = (string)($_GET['status'] ?? '');
if ($status === 'connected') $success = 'Google Calendar conectado. Os próximos aceites poderão gerar o Meet automaticamente.';
elseif ($status === 'saved') $success = 'Credenciais salvas. Agora conecte a conta Google que será dona das reuniões.';
elseif ($status === 'disconnected') $success = 'Conta Google desconectada.';

admin_head('Google Calendar');
admin_topbar('google_calendar');
?>
<main class="admin-main" id="adminContent" tabindex="-1">
  <div class="admin-head"><div><span class="admin-eyebrow">Configurações</span><h1>Google Calendar e Meet</h1><p>Crie automaticamente o evento e o link da reunião ao confirmar uma aula.</p></div><div class="admin-head-actions"><a class="btn btn-ghost on-light" href="/admin/aulas_particulares.php">Voltar às aulas</a></div></div>
  <?php if($error): ?><div class="alert alert-error" role="alert"><?= htmlspecialchars($error,ENT_QUOTES) ?></div><?php endif; ?>
  <?php if($success): ?><div class="alert alert-success" role="status"><?= htmlspecialchars($success,ENT_QUOTES) ?></div><?php endif; ?>
  <section class="admin-form-section"><div class="form-card" style="max-width:820px">
    <div class="admin-form-section-head"><h2><?= $connected?'Integração conectada':'Configurar integração' ?></h2><span class="admin-status status-<?= $connected?'success':'warning' ?>"><?= $connected?'Conectado':'Pendente' ?></span></div>
    <p style="color:var(--ink-soft);line-height:1.6">No Google Cloud, ative a <strong>Google Calendar API</strong>, crie uma credencial OAuth do tipo <strong>Aplicativo da Web</strong> e cadastre esta URI de redirecionamento autorizada:</p>
    <div style="padding:.9rem 1rem;background:var(--surface-2);border:1px solid var(--line);border-radius:7px;margin:1rem 0;overflow-wrap:anywhere"><code><?= htmlspecialchars(GOOGLE_CALENDAR_REDIRECT_URI,ENT_QUOTES) ?></code></div>
    <form method="post"><?= csrf_field() ?><input type="hidden" name="action" value="save">
      <div class="field"><label for="client_id">Client ID</label><input id="client_id" name="client_id" type="text" autocomplete="off" placeholder="<?= $config['client_id']!==''?'Já configurado — preencha somente para trocar':'...apps.googleusercontent.com' ?>"><small style="color:var(--ink-soft)">Deixe em branco para manter o Client ID já salvo.</small></div>
      <div class="field"><label for="client_secret">Client Secret</label><input id="client_secret" name="client_secret" type="password" autocomplete="new-password" placeholder="<?= $config['client_secret']!==''?'Já configurado — preencha somente para trocar':'GOCSPX-...' ?>"><small style="color:var(--ink-soft)">Deixe em branco para manter o Client Secret já salvo.</small></div>
      <div class="field"><label for="calendar_id">Calendar ID</label><input id="calendar_id" name="calendar_id" type="text" value="<?= htmlspecialchars($config['calendar_id']?:'primary',ENT_QUOTES) ?>"><small style="color:var(--ink-soft)">Use <code>primary</code> para criar no calendário principal da conta conectada.</small></div>
      <button class="btn btn-primary" type="submit">Salvar credenciais</button>
    </form>
    <div style="margin-top:1.5rem;padding-top:1.5rem;border-top:1px solid var(--line)">
      <?php if($connected): ?>
        <p style="color:var(--ink-soft)">Conectado em <?= htmlspecialchars(date('d/m/Y H:i',strtotime((string)$config['conectado_em'])),ENT_QUOTES) ?>.</p>
        <form method="post" style="margin-top:1rem"><?= csrf_field() ?><input type="hidden" name="action" value="disconnect"><button class="btn btn-ghost on-light" type="submit">Desconectar conta</button></form>
      <?php else: ?>
        <form method="post"><?= csrf_field() ?><input type="hidden" name="action" value="connect"><button class="btn btn-primary" type="submit" <?= $config['client_id']===''||$config['client_secret']===''?'disabled':'' ?>>Conectar Google Calendar</button></form>
      <?php endif; ?>
    </div>
  </div></section>
</main>
<?php admin_foot(); ?>