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
        $stmt = $pdo->prepare("SELECT * FROM social_posts WHERE id = ? AND status IN ('pendente','erro','agendado_meta')");
        $stmt->execute([$id]);
        $post = $stmt->fetch();

        if ($post) {
            if ($post['status'] === 'agendado_meta' && $post['meta_post_id']) {
                $apiError = null;
                if (!meta_delete_facebook_post($post['meta_post_id'], $apiError)) {
                    $error = 'Não foi possível cancelar no Facebook: ' . $apiError . ' — post não removido.';
                }
            }
            if (!$error) {
                $pdo->prepare('DELETE FROM social_posts WHERE id = ?')->execute([$id]);
                header('Location: /admin/social_posts.php?msg=' . urlencode('Post removido.'));
                exit;
            }
        }
    }

    if ($action === 'save') {
        $id = (int)($_POST['id'] ?? 0);
        $canal = (string)($_POST['canal'] ?? '');
        $legenda = trim((string)($_POST['legenda'] ?? ''));
        $imagemUrl = trim((string)($_POST['imagem_url'] ?? ''));
        $agendadoPara = (string)($_POST['agendado_para'] ?? '');

        // Facebook nesta rodada continua feed-only (imagem). Tipo/mídia só valem pro Instagram.
        $tipo = $canal === 'instagram' && in_array($_POST['tipo'] ?? '', ['feed', 'story', 'reels'], true) ? (string)$_POST['tipo'] : 'feed';
        $midiaTipo = $tipo === 'reels' ? 'video' : ($tipo === 'story' && ($_POST['midia_tipo'] ?? '') === 'video' ? 'video' : 'imagem');

        if (!in_array($canal, ['facebook', 'instagram'], true) || $legenda === '' || $imagemUrl === '' || $agendadoPara === '') {
            $error = 'Preencha canal, legenda, imagem e data/hora.';
        } elseif (!filter_var($imagemUrl, FILTER_VALIDATE_URL)) {
            $error = 'A imagem precisa ser uma URL pública (ex.: um link de assets/img/ do próprio site).';
        } else {
            // O campo datetime-local é preenchido pelo admin em horário de Brasília (UTC-3, sem horário de verão).
            $scheduledTs = strtotime($agendadoPara . ' -03:00');
            if ($scheduledTs === false || $scheduledTs < time() + 600) {
                $error = 'A data/hora precisa ser pelo menos 10 minutos no futuro.';
            } elseif ($canal === 'facebook' && META_PAGE_TOKEN === '') {
                $error = 'Configure a integração do Facebook primeiro em Configurar Meta.';
            } elseif ($canal === 'instagram' && META_IG_TOKEN === '') {
                $error = 'Configure a integração do Instagram primeiro em Configurar Meta.';
            } else {
                // Editing an existing pendente/erro/agendado_meta row: clear it out first
                // (cancelling the old Meta-side schedule if there was one), then treat as new.
                if ($id > 0) {
                    $old = $pdo->prepare("SELECT * FROM social_posts WHERE id = ? AND status IN ('pendente','erro','agendado_meta')");
                    $old->execute([$id]);
                    $oldPost = $old->fetch();
                    if ($oldPost && $oldPost['status'] === 'agendado_meta' && $oldPost['meta_post_id']) {
                        $apiError = null;
                        meta_delete_facebook_post($oldPost['meta_post_id'], $apiError);
                    }
                    if ($oldPost) {
                        $pdo->prepare('DELETE FROM social_posts WHERE id = ?')->execute([$id]);
                    }
                }

                $ins = $pdo->prepare(
                    'INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, agendado_para, status) VALUES (?, ?, ?, ?, ?, ?, ?)'
                );

                if ($canal === 'facebook') {
                    $apiError = null;
                    $postId = meta_schedule_facebook_post($legenda, $imagemUrl, $scheduledTs, $apiError);
                    if ($postId === null) {
                        $ins->execute(['facebook', $tipo, $midiaTipo, $legenda, $imagemUrl, date('Y-m-d H:i:s', $scheduledTs), 'erro']);
                        $error = 'Falha ao agendar no Facebook: ' . $apiError;
                    } else {
                        $ins->execute(['facebook', $tipo, $midiaTipo, $legenda, $imagemUrl, date('Y-m-d H:i:s', $scheduledTs), 'agendado_meta']);
                        $pdo->prepare('UPDATE social_posts SET meta_post_id = ? WHERE id = ?')->execute([$postId, $pdo->lastInsertId()]);
                    }
                } else {
                    // Instagram has no native scheduling — queued here, published later by social_publish_cron.php
                    $ins->execute(['instagram', $tipo, $midiaTipo, $legenda, $imagemUrl, date('Y-m-d H:i:s', $scheduledTs), 'pendente']);
                }

                if (!$error) {
                    header('Location: /admin/social_posts.php?msg=' . urlencode('Post salvo.'));
                    exit;
                }
            }
        }
    }
}

$editRow = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM social_posts WHERE id = ? AND status IN ('pendente','erro','agendado_meta')");
    $stmt->execute([(int)$_GET['edit']]);
    $editRow = $stmt->fetch();
}

if (isset($_GET['msg']) && !$error) {
    $msg = (string)$_GET['msg'];
}

$posts = $pdo->query('SELECT * FROM social_posts ORDER BY agendado_para DESC LIMIT 200')->fetchAll();

admin_head('Redes Sociais');
admin_topbar('social');
?>
<style>
  .post-preview-thumb { border: none; background: none; padding: 0; cursor: pointer; display: block; }
  .post-preview-thumb img { width: 64px; height: 64px; object-fit: cover; border-radius: 4px; display: block; }
  dialog#previewDialog { border: none; border-radius: 10px; padding: 0; max-width: 420px; width: 92vw; }
  dialog#previewDialog::backdrop { background: rgba(10, 21, 36, 0.6); }
  .post-card { background: var(--surface); }
  .post-card-head { display: flex; align-items: center; gap: 0.7rem; padding: 0.9rem 1rem; }
  .post-card-avatar {
    width: 38px; height: 38px; border-radius: 50%; background: var(--navy); color: #fff;
    display: flex; align-items: center; justify-content: center; font-family: 'Plex Cond', sans-serif; font-weight: 700; flex: none;
  }
  .post-card-head .name { font-weight: 700; font-size: 0.92rem; color: var(--ink); }
  .post-card-head .chan { font-size: 0.76rem; color: var(--ink-faint); }
  .post-card img.post-card-img { width: 100%; aspect-ratio: 1 / 1; object-fit: cover; display: block; }
  .post-card-caption { padding: 0.9rem 1rem 1.1rem; font-size: 0.88rem; color: var(--ink); white-space: pre-wrap; line-height: 1.5; }
  .post-card-close { position: absolute; top: 0.6rem; right: 0.7rem; background: rgba(0,0,0,0.45); color: #fff; border: none; border-radius: 50%; width: 28px; height: 28px; cursor: pointer; font-size: 1rem; line-height: 1; }
</style>
<main class="admin-main">
  <div class="admin-head"><h1>Fila de posts — Facebook / Instagram</h1><a class="btn btn-ghost on-light" href="/admin/social_setup.php">Configurar Meta</a></div>

  <?php if (isset($msg)): ?><div class="alert alert-success"><?= htmlspecialchars($msg, ENT_QUOTES) ?></div><?php endif; ?>
  <?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES) ?></div><?php endif; ?>

  <div class="buy-card" style="max-width:760px; margin-bottom:2rem;">
    <h2 style="font-size:1.05rem; margin-bottom:1rem;"><?= $editRow ? 'Editar post' : 'Novo post' ?></h2>
    <form method="post" novalidate>
      <?= csrf_field() ?>
      <input type="hidden" name="action" value="save">
      <input type="hidden" name="id" value="<?= $editRow ? (int)$editRow['id'] : 0 ?>">
      <div class="field-row">
        <div class="field">
          <label for="canal">Canal</label>
          <select id="canal" name="canal" required onchange="toggleTipoField()">
            <option value="facebook" <?= ($editRow['canal'] ?? '') === 'facebook' ? 'selected' : '' ?>>Facebook</option>
            <option value="instagram" <?= ($editRow['canal'] ?? '') === 'instagram' ? 'selected' : '' ?>>Instagram</option>
          </select>
        </div>
        <div class="field">
          <label for="agendado_para">Data/hora (horário de Brasília)</label>
          <input type="datetime-local" id="agendado_para" name="agendado_para" required
                 value="<?= $editRow ? date('Y-m-d\TH:i', strtotime($editRow['agendado_para'] . ' UTC') - 10800) : '' ?>">
        </div>
      </div>
      <div class="field-row" id="tipoFieldRow">
        <div class="field">
          <label for="tipo">Tipo (só Instagram)</label>
          <select id="tipo" name="tipo" onchange="toggleMidiaField()">
            <option value="feed" <?= ($editRow['tipo'] ?? 'feed') === 'feed' ? 'selected' : '' ?>>Feed</option>
            <option value="story" <?= ($editRow['tipo'] ?? '') === 'story' ? 'selected' : '' ?>>Story</option>
            <option value="reels" <?= ($editRow['tipo'] ?? '') === 'reels' ? 'selected' : '' ?>>Reels</option>
          </select>
        </div>
        <div class="field" id="midiaFieldWrap">
          <label for="midia_tipo">Mídia (só Story)</label>
          <select id="midia_tipo" name="midia_tipo">
            <option value="imagem" <?= ($editRow['midia_tipo'] ?? 'imagem') === 'imagem' ? 'selected' : '' ?>>Imagem</option>
            <option value="video" <?= ($editRow['midia_tipo'] ?? '') === 'video' ? 'selected' : '' ?>>Vídeo</option>
          </select>
        </div>
      </div>
      <div class="field">
        <label for="imagem_url">URL da imagem ou vídeo (pública)</label>
        <input type="url" id="imagem_url" name="imagem_url" placeholder="https://techsantos.com.br/assets/img/promo-curso-1.jpg" required
               value="<?= $editRow ? htmlspecialchars($editRow['imagem_url'], ENT_QUOTES) : '' ?>">
      </div>
      <div class="field">
        <label for="legenda">Legenda</label>
        <textarea id="legenda" name="legenda" rows="4" required><?= $editRow ? htmlspecialchars($editRow['legenda'], ENT_QUOTES) : '' ?></textarea>
      </div>
      <button type="submit" class="btn btn-primary"><?= $editRow ? 'Salvar alterações' : 'Agendar' ?></button>
      <?php if ($editRow): ?><a class="btn btn-ghost on-light" href="/admin/social_posts.php">Cancelar edição</a><?php endif; ?>
    </form>
  </div>

  <div class="table-wrap">
    <table class="data-table">
      <thead><tr><th>Prévia</th><th>Data (Brasília)</th><th>Canal</th><th>Tipo</th><th>Legenda</th><th>Status</th><th></th></tr></thead>
      <tbody>
        <?php if (!$posts): ?>
          <tr class="empty-row"><td colspan="7">Nenhum post na fila ainda.</td></tr>
        <?php endif; ?>
        <?php foreach ($posts as $p): ?>
          <tr>
            <td>
              <button type="button" class="post-preview-thumb"
                      data-imagem="<?= htmlspecialchars($p['imagem_url'], ENT_QUOTES) ?>"
                      data-legenda="<?= htmlspecialchars($p['legenda'], ENT_QUOTES) ?>"
                      data-canal="<?= htmlspecialchars($p['canal'], ENT_QUOTES) ?>"
                      onclick="openPostPreview(this)" title="Ver preview do post">
                <img src="<?= htmlspecialchars($p['imagem_url'], ENT_QUOTES) ?>" alt="">
              </button>
            </td>
            <td><?= date('d/m/Y H:i', strtotime($p['agendado_para'] . ' UTC') - 10800) ?></td>
            <td><?= htmlspecialchars($p['canal'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($p['tipo'] ?? 'feed', ENT_QUOTES) ?><?= ($p['midia_tipo'] ?? '') === 'video' ? ' (vídeo)' : '' ?></td>
            <td>
              <?= htmlspecialchars(mb_strimwidth($p['legenda'], 0, 60, '…'), ENT_QUOTES) ?>
              <?php if ($p['status'] === 'erro' && $p['erro_msg']): ?>
                <p style="margin-top:0.3rem; color:#C0392B; font-size:0.78rem;">Erro: <?= htmlspecialchars($p['erro_msg'], ENT_QUOTES) ?></p>
              <?php endif; ?>
            </td>
            <td><span class="badge <?= in_array($p['status'], ['publicado', 'agendado_meta'], true) ? 'on' : ($p['status'] === 'erro' ? 'off' : '') ?>"><?= htmlspecialchars($p['status'], ENT_QUOTES) ?></span></td>
            <td class="actions">
              <?php if (in_array($p['status'], ['pendente', 'erro', 'agendado_meta'], true)): ?>
                <a href="/admin/social_posts.php?edit=<?= (int)$p['id'] ?>">Editar</a>
                <form method="post" onsubmit="return confirm('Remover este post<?= $p['status'] === 'agendado_meta' ? ' (também cancela no Facebook)' : '' ?>?');" style="display:inline">
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

  <dialog id="previewDialog">
    <div class="post-card" style="position:relative;">
      <button type="button" class="post-card-close" onclick="document.getElementById('previewDialog').close()">✕</button>
      <div class="post-card-head">
        <span class="post-card-avatar">TS</span>
        <div>
          <div class="name">TECH SANTOS BR</div>
          <div class="chan" id="previewChan"></div>
        </div>
      </div>
      <img class="post-card-img" id="previewImg" src="" alt="">
      <div class="post-card-caption" id="previewCaption"></div>
    </div>
  </dialog>
  <script>
    function openPostPreview(btn) {
      document.getElementById('previewImg').src = btn.dataset.imagem;
      document.getElementById('previewCaption').textContent = btn.dataset.legenda;
      document.getElementById('previewChan').textContent = btn.dataset.canal === 'facebook' ? 'Facebook' : 'Instagram';
      document.getElementById('previewDialog').showModal();
    }

    function toggleTipoField() {
      var isInstagram = document.getElementById('canal').value === 'instagram';
      document.getElementById('tipoFieldRow').style.display = isInstagram ? '' : 'none';
      if (!isInstagram) {
        document.getElementById('tipo').value = 'feed';
      }
      toggleMidiaField();
    }

    function toggleMidiaField() {
      var isStory = document.getElementById('tipo').value === 'story';
      document.getElementById('midiaFieldWrap').style.display = isStory ? '' : 'none';
      if (document.getElementById('tipo').value === 'reels') {
        document.getElementById('midia_tipo').value = 'video';
      } else if (document.getElementById('tipo').value === 'feed') {
        document.getElementById('midia_tipo').value = 'imagem';
      }
    }

    toggleTipoField();
  </script>
</main>
<?php admin_foot(); ?>
