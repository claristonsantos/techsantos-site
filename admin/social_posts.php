<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../meta_social.php';
require_once __DIR__ . '/_partials.php';
require_admin();

$pdo = db();
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';

    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        $pdo->prepare("DELETE FROM social_posts WHERE id = ? AND status IN ('pendente','erro')")->execute([$id]);
        header('Location: /admin/social_posts.php?msg=' . urlencode('Post removido.'));
        exit;
    }

    if ($action === 'save') {
        $canal = (string)($_POST['canal'] ?? '');
        $legenda = trim((string)($_POST['legenda'] ?? ''));
        $imagemUrl = trim((string)($_POST['imagem_url'] ?? ''));
        $agendadoPara = (string)($_POST['agendado_para'] ?? '');

        if (!in_array($canal, ['facebook', 'instagram'], true) || $legenda === '' || $imagemUrl === '' || $agendadoPara === '') {
            $error = 'Preencha canal, legenda, imagem e data/hora.';
        } elseif (!filter_var($imagemUrl, FILTER_VALIDATE_URL)) {
            $error = 'A imagem precisa ser uma URL pública (ex.: um link de assets/img/ do próprio site).';
        } else {
            $scheduledTs = strtotime($agendadoPara);
            if ($scheduledTs === false || $scheduledTs < time() + 600) {
                $error = 'A data/hora precisa ser pelo menos 10 minutos no futuro.';
            } elseif ($canal === 'facebook' && META_PAGE_TOKEN === '') {
                $error = 'Configure a integração do Facebook primeiro em Configurar Meta.';
            } elseif ($canal === 'instagram' && META_IG_TOKEN === '') {
                $error = 'Configure a integração do Instagram primeiro em Configurar Meta.';
            } else {
                $ins = $pdo->prepare(
                    'INSERT INTO social_posts (canal, legenda, imagem_url, agendado_para, status) VALUES (?, ?, ?, ?, ?)'
                );

                if ($canal === 'facebook') {
                    $apiError = null;
                    $postId = meta_schedule_facebook_post($legenda, $imagemUrl, $scheduledTs, $apiError);
                    if ($postId === null) {
                        $ins->execute(['facebook', $legenda, $imagemUrl, date('Y-m-d H:i:s', $scheduledTs), 'erro']);
                        $error = 'Falha ao agendar no Facebook: ' . $apiError;
                    } else {
                        $ins->execute(['facebook', $legenda, $imagemUrl, date('Y-m-d H:i:s', $scheduledTs), 'agendado_meta']);
                        $pdo->prepare('UPDATE social_posts SET meta_post_id = ? WHERE id = ?')->execute([$postId, $pdo->lastInsertId()]);
                    }
                } else {
                    // Instagram has no native scheduling — queued here, published later by social_publish_cron.php
                    $ins->execute(['instagram', $legenda, $imagemUrl, date('Y-m-d H:i:s', $scheduledTs), 'pendente']);
                }

                if (!$error) {
                    header('Location: /admin/social_posts.php?msg=' . urlencode('Post salvo.'));
                    exit;
                }
            }
        }
    }
}

if (isset($_GET['msg']) && !$error) {
    $msg = (string)$_GET['msg'];
}

$posts = $pdo->query('SELECT * FROM social_posts ORDER BY agendado_para DESC LIMIT 200')->fetchAll();

admin_head('Redes Sociais');
admin_topbar('social');
?>
<main class="admin-main">
  <div class="admin-head"><h1>Fila de posts — Facebook / Instagram</h1><a class="btn btn-ghost on-light" href="/admin/social_setup.php">Configurar Meta</a></div>

  <?php if (isset($msg)): ?><div class="alert alert-success"><?= htmlspecialchars($msg, ENT_QUOTES) ?></div><?php endif; ?>
  <?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES) ?></div><?php endif; ?>

  <div class="buy-card" style="max-width:760px; margin-bottom:2rem;">
    <form method="post" novalidate>
      <?= csrf_field() ?>
      <input type="hidden" name="action" value="save">
      <div class="field-row">
        <div class="field">
          <label for="canal">Canal</label>
          <select id="canal" name="canal" required>
            <option value="facebook">Facebook</option>
            <option value="instagram">Instagram</option>
          </select>
        </div>
        <div class="field">
          <label for="agendado_para">Data/hora</label>
          <input type="datetime-local" id="agendado_para" name="agendado_para" required>
        </div>
      </div>
      <div class="field">
        <label for="imagem_url">URL da imagem (pública)</label>
        <input type="url" id="imagem_url" name="imagem_url" placeholder="https://techsantos.com.br/assets/img/goiasa.jpg" required>
      </div>
      <div class="field">
        <label for="legenda">Legenda</label>
        <textarea id="legenda" name="legenda" rows="4" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Agendar</button>
    </form>
  </div>

  <div class="table-wrap">
    <table class="data-table">
      <thead><tr><th>Data</th><th>Canal</th><th>Legenda</th><th>Status</th><th></th></tr></thead>
      <tbody>
        <?php if (!$posts): ?>
          <tr class="empty-row"><td colspan="5">Nenhum post na fila ainda.</td></tr>
        <?php endif; ?>
        <?php foreach ($posts as $p): ?>
          <tr>
            <td><?= date('d/m/Y H:i', strtotime($p['agendado_para'])) ?></td>
            <td><?= htmlspecialchars($p['canal'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars(mb_strimwidth($p['legenda'], 0, 60, '…'), ENT_QUOTES) ?></td>
            <td><span class="badge <?= in_array($p['status'], ['publicado', 'agendado_meta'], true) ? 'on' : ($p['status'] === 'erro' ? 'off' : '') ?>"><?= htmlspecialchars($p['status'], ENT_QUOTES) ?></span></td>
            <td class="actions">
              <?php if (in_array($p['status'], ['pendente', 'erro'], true)): ?>
                <form method="post" onsubmit="return confirm('Remover este post?');" style="display:inline">
                  <?= csrf_field() ?>
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                  <button type="submit" class="danger">Remover</button>
                </form>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>
<?php admin_foot(); ?>
