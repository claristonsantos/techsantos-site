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
        $allowedTypes = $canal === 'facebook' ? ['feed', 'reels'] : ['feed', 'story', 'reels'];
        $requestedType = (string)($_POST['tipo'] ?? 'feed');
        $tipo = in_array($requestedType, $allowedTypes, true) ? $requestedType : 'feed';
        $linkUrl = $canal === 'facebook' && $tipo === 'feed' ? trim((string)($_POST['link_url'] ?? '')) : '';
        $agendadoPara = (string)($_POST['agendado_para'] ?? '');
        $midiaTipo = $tipo === 'reels' ? 'video' : ($tipo === 'story' && ($_POST['midia_tipo'] ?? '') === 'video' ? 'video' : 'imagem');

        // Com link preenchido, o Facebook usa a própria página de destino como
        // preview (card clicável) — a imagem enviada por nós fica dispensável
        // só nesse caso específico (ver meta_schedule_facebook_post()).
        $imagemDispensavel = $canal === 'facebook' && $tipo === 'feed' && $linkUrl !== '';

        if (!in_array($canal, ['facebook', 'instagram'], true) || $legenda === '' || (!$imagemDispensavel && $imagemUrl === '') || $agendadoPara === '') {
            $error = 'Preencha canal, legenda, imagem (ou link, no Facebook) e data/hora.';
        } elseif ($imagemUrl !== '' && !filter_var($imagemUrl, FILTER_VALIDATE_URL)) {
            $error = 'A imagem precisa ser uma URL pública (ex.: um link de assets/img/ do próprio site).';
        } elseif ($linkUrl !== '' && !filter_var($linkUrl, FILTER_VALIDATE_URL)) {
            $error = 'O link precisa ser uma URL pública válida.';
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
                    'INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, link_url, agendado_para, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
                );
                $linkUrlOrNull = $linkUrl !== '' ? $linkUrl : null;

                if ($canal === 'facebook') {
                    $apiError = null;
                    $postId = $tipo === 'reels'
                        ? meta_schedule_facebook_reel($legenda, $imagemUrl, $scheduledTs, $apiError)
                        : meta_schedule_facebook_post($legenda, $imagemUrl ?: null, $scheduledTs, $apiError, $linkUrlOrNull);
                    if ($postId === null) {
                        $ins->execute(['facebook', $tipo, $midiaTipo, $legenda, $imagemUrl, $linkUrlOrNull, date('Y-m-d H:i:s', $scheduledTs), 'erro']);
                        $error = 'Falha ao agendar no Facebook: ' . $apiError;
                    } else {
                        $ins->execute(['facebook', $tipo, $midiaTipo, $legenda, $imagemUrl, $linkUrlOrNull, date('Y-m-d H:i:s', $scheduledTs), 'agendado_meta']);
                        $pdo->prepare('UPDATE social_posts SET meta_post_id = ? WHERE id = ?')->execute([$postId, $pdo->lastInsertId()]);
                    }
                } else {
                    // Instagram has no native scheduling — queued here, published later by social_publish_cron.php
                    $ins->execute(['instagram', $tipo, $midiaTipo, $legenda, $imagemUrl, null, date('Y-m-d H:i:s', $scheduledTs), 'pendente']);
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

$busca = trim((string)($_GET['busca'] ?? ''));
$canalFiltro = in_array(($_GET['canal_filtro'] ?? ''), ['facebook','instagram'], true) ? (string)$_GET['canal_filtro'] : '';
$statusFiltro = in_array(($_GET['status_filtro'] ?? ''), ['pendente','processando','agendado_meta','publicado','erro'], true) ? (string)$_GET['status_filtro'] : '';
$tipoFiltro = in_array(($_GET['tipo_filtro'] ?? ''), ['feed','story','reels'], true) ? (string)$_GET['tipo_filtro'] : '';
$pagina = max(1, (int)($_GET['pagina'] ?? 1)); $porPagina = 25;
$where=[]; $params=[];
if($busca!==''){ $where[]='legenda LIKE ?'; $params[]='%'.$busca.'%'; }
if($canalFiltro!==''){ $where[]='canal=?'; $params[]=$canalFiltro; }
if($statusFiltro!==''){ $where[]='status=?'; $params[]=$statusFiltro; }
if($tipoFiltro!==''){ $where[]='tipo=?'; $params[]=$tipoFiltro; }
$whereSql=$where?' WHERE '.implode(' AND ',$where):'';
$count=$pdo->prepare('SELECT COUNT(*) FROM social_posts'.$whereSql); $count->execute($params); $totalPosts=(int)$count->fetchColumn();
$paginas=max(1,(int)ceil($totalPosts/$porPagina)); $pagina=min($pagina,$paginas); $offset=($pagina-1)*$porPagina;
$stmt=$pdo->prepare('SELECT * FROM social_posts'.$whereSql.' ORDER BY agendado_para DESC LIMIT '.$porPagina.' OFFSET '.$offset); $stmt->execute($params); $posts=$stmt->fetchAll();
$showForm = $editRow || isset($_GET['novo']) || $error;

admin_head('Redes Sociais');
admin_topbar('social');
?>
<style>
  .post-preview-thumb { border: none; background: none; padding: 0; cursor: pointer; display: block; }
  .post-preview-thumb img, .post-preview-thumb video { width: 64px; height: 64px; object-fit: cover; border-radius: 4px; display: block; background: var(--navy); }
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
  .post-card img.post-card-img, .post-card video.post-card-img { width: 100%; aspect-ratio: 1 / 1; object-fit: cover; display: block; background: var(--navy); }
  .post-card-caption { padding: 0.9rem 1rem 1.1rem; font-size: 0.88rem; color: var(--ink); white-space: pre-wrap; line-height: 1.5; }
  .post-card-close { position:absolute; top:.6rem; right:.7rem; width:44px; height:44px; display:flex; align-items:center; justify-content:center; background:rgba(0,0,0,.55); color:#fff; border:0; border-radius:50%; cursor:pointer; }
  .post-card-close svg { width:18px; height:18px; fill:none; stroke:currentColor; stroke-width:2; stroke-linecap:round; }
</style>
<main class="admin-main">
  <div class="admin-head"><div><span class="admin-eyebrow">Marketing</span><h1>Fila de publicações</h1><p>Agende e acompanhe Facebook e Instagram em um só lugar.</p></div><div class="admin-head-actions"><?php if (!$showForm): ?><a class="btn btn-primary" href="/admin/social_posts.php?novo=1">Agendar post</a><?php endif; ?><a class="btn btn-ghost on-light" href="/admin/social_setup.php">Configurar Meta</a></div></div>

  <?php if (isset($msg)): ?><div class="alert alert-success" role="status"><?= htmlspecialchars($msg, ENT_QUOTES) ?></div><?php endif; ?>
  <?php if ($error): ?><div class="alert alert-error" role="alert"><?= htmlspecialchars($error, ENT_QUOTES) ?></div><?php endif; ?>

  <?php if ($showForm): ?><section class="admin-form-section"><div class="admin-form-section-head"><h2><?= $editRow ? 'Editar post' : 'Agendar novo post' ?></h2><a href="/admin/social_posts.php">Fechar formulário</a></div>
  <div class="buy-card" style="max-width:760px; margin-bottom:2rem;">
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
          <label for="tipo">Tipo</label>
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
      <div class="field" id="linkFieldWrap">
        <label for="link_url">Link (só Facebook Feed — gera card clicável, substitui a imagem no preview)</label>
        <input type="url" id="link_url" name="link_url" placeholder="https://techsantos.com.br/curso-power-bi.php" oninput="toggleImagemRequired()"
               value="<?= $editRow ? htmlspecialchars($editRow['link_url'] ?? '', ENT_QUOTES) : '' ?>">
      </div>
      <div class="field">
        <label for="legenda">Legenda</label>
        <textarea id="legenda" name="legenda" rows="4" required><?= $editRow ? htmlspecialchars($editRow['legenda'], ENT_QUOTES) : '' ?></textarea>
      </div>
      <button type="submit" class="btn btn-primary"><?= $editRow ? 'Salvar alterações' : 'Agendar' ?></button>
      <?php if ($editRow): ?><a class="btn btn-ghost on-light" href="/admin/social_posts.php">Cancelar edição</a><?php endif; ?>
    </form>
  </div></section><?php endif; ?>

  <form class="admin-filter-bar" method="get" aria-label="Filtros de publicações">
    <div class="field"><label for="busca">Buscar na legenda</label><input type="search" id="busca" name="busca" placeholder="Palavra ou campanha" value="<?= htmlspecialchars($busca, ENT_QUOTES) ?>"></div>
    <div class="field"><label for="canal_filtro">Canal</label><select id="canal_filtro" name="canal_filtro"><option value="">Todos</option><option value="facebook" <?= $canalFiltro==='facebook'?'selected':'' ?>>Facebook</option><option value="instagram" <?= $canalFiltro==='instagram'?'selected':'' ?>>Instagram</option></select></div>
    <div class="field"><label for="tipo_filtro">Tipo</label><select id="tipo_filtro" name="tipo_filtro"><option value="">Todos</option><?php foreach(['feed'=>'Feed','story'=>'Story','reels'=>'Reels'] as $v=>$l): ?><option value="<?= $v ?>" <?= $tipoFiltro===$v?'selected':'' ?>><?= $l ?></option><?php endforeach; ?></select></div>
    <div class="field"><label for="status_filtro">Status</label><select id="status_filtro" name="status_filtro"><option value="">Todos</option><?php foreach(['pendente'=>'Pendente','processando'=>'Processando','agendado_meta'=>'Agendado','publicado'=>'Publicado','erro'=>'Erro'] as $v=>$l): ?><option value="<?= $v ?>" <?= $statusFiltro===$v?'selected':'' ?>><?= $l ?></option><?php endforeach; ?></select></div>
    <div class="admin-filter-actions"><button class="btn btn-primary" type="submit">Filtrar</button><a class="btn btn-ghost on-light" href="/admin/social_posts.php">Limpar</a></div>
  </form>
  <div class="admin-list-head"><div><h2>Publicações</h2><span><?= $totalPosts ?> resultado(s)</span></div></div>

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
                      data-midia="<?= htmlspecialchars($p['midia_tipo'] ?? 'imagem', ENT_QUOTES) ?>"
                      onclick="openPostPreview(this)" title="Ver preview do post">
                <?php if (($p['midia_tipo'] ?? 'imagem') === 'video'): ?>
                  <video src="<?= htmlspecialchars($p['imagem_url'], ENT_QUOTES) ?>" muted preload="metadata"></video>
                <?php else: ?>
                  <img src="<?= htmlspecialchars($p['imagem_url'], ENT_QUOTES) ?>" alt="Prévia da publicação" loading="lazy">
                <?php endif; ?>
              </button>
            </td>
            <td><?= date('d/m/Y H:i', strtotime($p['agendado_para'] . ' UTC') - 10800) ?></td>
            <td><?= htmlspecialchars($p['canal'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($p['tipo'] ?? 'feed', ENT_QUOTES) ?><?= ($p['midia_tipo'] ?? '') === 'video' ? ' (vídeo)' : '' ?></td>
            <td>
              <?= htmlspecialchars(mb_strimwidth($p['legenda'], 0, 60, '…'), ENT_QUOTES) ?>
              <?php if (!empty($p['link_url'])): ?>
                <p style="margin-top:0.3rem; font-size:0.78rem; color:var(--ink-faint);">Link: <?= htmlspecialchars(mb_strimwidth($p['link_url'], 0, 50, '…'), ENT_QUOTES) ?></p>
              <?php endif; ?>
              <?php if ($p['status'] === 'erro' && $p['erro_msg']): ?>
                <p style="margin-top:0.3rem; color:#C0392B; font-size:0.78rem;">Erro: <?= htmlspecialchars($p['erro_msg'], ENT_QUOTES) ?></p>
              <?php endif; ?>
            </td>
            <td>
              <span class="admin-status status-<?= $p['status'] === 'publicado' ? 'success' : ($p['status'] === 'erro' ? 'danger' : ($p['status'] === 'processando' ? 'warning' : 'neutral')) ?>"><?= htmlspecialchars($p['status'], ENT_QUOTES) ?></span>
              <?php if (($p['tipo'] ?? '') === 'story' && ($p['fb_story_status'] ?? 'nenhum') !== 'nenhum'): ?>
                <p style="margin-top:0.3rem; font-size:0.76rem; color:<?= $p['fb_story_status'] === 'publicado' ? 'var(--ink-faint)' : '#C0392B' ?>;">
                  FB Story: <?= $p['fb_story_status'] === 'publicado' ? 'replicado ✓' : 'falhou' ?>
                  <?php if ($p['fb_story_status'] === 'erro' && $p['fb_story_erro']): ?> — <?= htmlspecialchars($p['fb_story_erro'], ENT_QUOTES) ?><?php endif; ?>
                </p>
              <?php endif; ?>
            </td>
            <td><div class="admin-table-actions">
              <?php if (in_array($p['status'], ['pendente', 'erro', 'agendado_meta'], true)): ?>
                <a href="/admin/social_posts.php?edit=<?= (int)$p['id'] ?>">Editar</a>
                <form method="post" onsubmit="return confirm('Remover este post<?= $p['status'] === 'agendado_meta' ? ' (também cancela no Facebook)' : '' ?>?');" style="display:inline">
                  <?= csrf_field() ?>
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                  <button type="submit" class="danger">Remover</button>
                </form>
              <?php endif; ?>
            </div></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php admin_pagination($pagina,$paginas,$totalPosts); ?>

  <dialog id="previewDialog">
    <div class="post-card" style="position:relative;">
      <button type="button" class="post-card-close" aria-label="Fechar prévia" onclick="document.getElementById('previewVideo').pause(); document.getElementById('previewDialog').close()"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg></button>
      <div class="post-card-head">
        <span class="post-card-avatar">TS</span>
        <div>
          <div class="name">TECH SANTOS BR</div>
          <div class="chan" id="previewChan"></div>
        </div>
      </div>
      <img class="post-card-img" id="previewImg" src="" alt="">
      <video class="post-card-img" id="previewVideo" controls style="display:none"></video>
      <div class="post-card-caption" id="previewCaption"></div>
    </div>
  </dialog>
  <script>
    function openPostPreview(btn) {
      var isVideo = btn.dataset.midia === 'video';
      var img = document.getElementById('previewImg');
      var video = document.getElementById('previewVideo');

      if (isVideo) {
        video.src = btn.dataset.imagem;
        video.style.display = '';
        img.style.display = 'none';
        img.src = '';
      } else {
        video.pause();
        video.src = '';
        video.style.display = 'none';
        img.style.display = '';
        img.src = btn.dataset.imagem;
      }

      document.getElementById('previewCaption').textContent = btn.dataset.legenda;
      document.getElementById('previewChan').textContent = btn.dataset.canal === 'facebook' ? 'Facebook' : 'Instagram';
      document.getElementById('previewDialog').showModal();
    }

    function toggleTipoField() {
      var isInstagram = document.getElementById('canal').value === 'instagram';
      var tipo = document.getElementById('tipo');
      var storyOption = tipo.querySelector('option[value="story"]');
      storyOption.hidden = !isInstagram;
      if (!isInstagram && tipo.value === 'story') {
        tipo.value = 'feed';
      }
      document.getElementById('tipoFieldRow').style.display = '';
      document.getElementById('linkFieldWrap').style.display = !isInstagram && tipo.value === 'feed' ? '' : 'none';
      if (isInstagram || tipo.value !== 'feed') {
        document.getElementById('link_url').value = '';
      }
      toggleMidiaField();
      toggleImagemRequired();
    }

    function toggleImagemRequired() {
      var isFacebookFeed = document.getElementById('canal').value === 'facebook' && document.getElementById('tipo').value === 'feed';
      var hasLink = document.getElementById('link_url').value.trim() !== '';
      document.getElementById('imagem_url').required = !(isFacebookFeed && hasLink);
    }

    function toggleMidiaField() {
      var isStory = document.getElementById('tipo').value === 'story';
      var isFacebookFeed = document.getElementById('canal').value === 'facebook' && document.getElementById('tipo').value === 'feed';
      document.getElementById('midiaFieldWrap').style.display = isStory ? '' : 'none';
      document.getElementById('linkFieldWrap').style.display = isFacebookFeed ? '' : 'none';
      if (document.getElementById('tipo').value === 'reels') {
        document.getElementById('midia_tipo').value = 'video';
      } else if (document.getElementById('tipo').value === 'feed') {
        document.getElementById('midia_tipo').value = 'imagem';
      }
      if (!isFacebookFeed) {
        document.getElementById('link_url').value = '';
      }
      toggleImagemRequired();
    }

    if (document.getElementById('canal')) toggleTipoField();
  </script>
</main>
<?php admin_foot(); ?>
