<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../tiktok_api.php';
require_once __DIR__ . '/_partials.php';
require_admin();

/*
 * Publicação no TikTok pela API oficial (Tech Santos Publisher). Segue as regras de
 * interface da Content Posting API: mostrar a conta conectada (creator_info), privacidade
 * sem valor padrão, interações desmarcadas e travadas quando a conta bloqueia, divulgação
 * de conteúdo comercial, aviso de consentimento e prévia do vídeo antes de publicar.
 */

$h = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES);
$msg = null;
$error = null;
if (!empty($_SESSION['tt_flash'])) {
    [$tipo, $texto] = $_SESSION['tt_flash'];
    unset($_SESSION['tt_flash']);
    if ($tipo === 'ok') $msg = $texto; else $error = $texto;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = (string)($_POST['action'] ?? '');
    if ($action === 'app') {
        $key = trim((string)($_POST['client_key'] ?? ''));
        $secret = trim((string)($_POST['client_secret'] ?? ''));
        if ($key === '' || $secret === '') {
            $error = 'Informe o Client key e o Client secret.';
        } else {
            tt_save_app($key, $secret, (string)($_POST['ambiente'] ?? 'sandbox'));
            $msg = 'Chaves do app salvas. Agora conecte a conta do TikTok.';
        }
    } elseif ($action === 'connect') {
        $state = bin2hex(random_bytes(16));
        $_SESSION['tt_oauth_state'] = $state;
        $url = tt_auth_url($state);
        if ($url) { header('Location: ' . $url); exit; }
        $error = 'Configure as chaves do app primeiro.';
    } elseif ($action === 'disconnect') {
        tt_disconnect();
        $msg = 'Conta do TikTok desconectada.';
    } elseif ($action === 'post') {
        $modo = ($_POST['modo'] ?? 'direct') === 'draft' ? 'draft' : 'direct';
        $videoUrl = trim((string)($_POST['video_url'] ?? ''));
        $legenda = trim((string)($_POST['legenda'] ?? ''));
        $privacy = (string)($_POST['privacy_level'] ?? '');
        $brand = !empty($_POST['commercial']);
        $flags = [
            'disable_comment' => empty($_POST['allow_comment']), 'disable_duet' => empty($_POST['allow_duet']),
            'disable_stitch' => empty($_POST['allow_stitch']),
            'brand_organic' => $brand && !empty($_POST['brand_organic']), 'brand_content' => $brand && !empty($_POST['brand_content']),
        ];
        if ($videoUrl === '') {
            $error = 'Escolha o vídeo.';
        } elseif ($modo === 'direct' && $privacy === '') {
            $error = 'Escolha quem pode ver o vídeo (privacidade).';
        } elseif ($brand && !$flags['brand_organic'] && !$flags['brand_content']) {
            $error = 'Conteúdo comercial ligado: marque "Sua marca" e/ou "Conteúdo de marca".';
        } elseif ($flags['brand_content'] && $privacy === 'SELF_ONLY') {
            $error = 'Conteúdo de marca não pode ser privado (Somente eu).';
        } else {
            $err = null;
            $pid = tt_post_video($modo, $videoUrl, $legenda, $privacy, $flags, $err);
            if ($pid) {
                $msg = $modo === 'draft'
                    ? 'Vídeo enviado para a caixa de rascunhos do TikTok. Abra o app para revisar e publicar.'
                    : 'Publicação enviada. O TikTok pode levar alguns minutos para processar o vídeo e mostrá-lo no perfil.';
            } else {
                $error = 'O TikTok recusou a publicação: ' . $err;
            }
        }
    } elseif ($action === 'status') {
        $err = null;
        $st = tt_post_status((string)($_POST['publish_id'] ?? ''), $err);
        if ($st) {
            $msg = 'Status atualizado: ' . ($st['status'] ?? '?');
        } else {
            $error = 'Falha ao consultar status: ' . $err;
        }
    }
}

$app = tt_app();
$conta = $app ? tt_account() : null;
$creator = null;
$creatorErr = null;
if ($conta) $creator = tt_creator_info($creatorErr);
$videos = null;
$videosErr = null;
if ($conta) $videos = tt_video_list(10, $videosErr);
$posts = db()->query('SELECT * FROM tiktok_posts ORDER BY id DESC LIMIT 10')->fetchAll();

// Vídeos do nosso servidor de mídia (os mesmos agendados para Instagram/Threads).
$midias = db()->query("SELECT imagem_url, MAX(LEFT(legenda, 300)) AS legenda, MAX(agendado_para) AS quando FROM social_posts
                       WHERE midia_tipo = 'video' AND imagem_url LIKE 'https://media.techsantos.com.br/%'
                       GROUP BY imagem_url ORDER BY quando DESC LIMIT 40")->fetchAll();

$privLabels = ['PUBLIC_TO_EVERYONE' => 'Todos (Everyone)', 'MUTUAL_FOLLOW_FRIENDS' => 'Amigos (Friends)',
               'FOLLOWER_OF_CREATOR' => 'Seguidores (Followers)', 'SELF_ONLY' => 'Somente eu (Only me)'];

admin_head('TikTok');
admin_topbar('tiktok');
?>
<main class="admin-main">
  <div class="admin-head"><h1>TikTok · publicar vídeos</h1></div>
  <p style="color:var(--ink-soft); max-width:72ch; margin-bottom:1.5rem;">
    Publica os nossos vídeos na nossa conta do TikTok pela API oficial (app <strong>Tech Santos Publisher</strong>).
    Os vídeos vêm do nosso servidor de mídia (media.techsantos.com.br). Só a nossa própria conta é usada.
  </p>

  <?php if ($msg): ?><div class="alert alert-success"><?= $h($msg) ?></div><?php endif; ?>
  <?php if ($error): ?><div class="alert alert-error"><?= $h($error) ?></div><?php endif; ?>

  <?php if (!$app): ?>
  <div class="buy-card" style="max-width:760px; margin-bottom:2rem;">
    <h2 style="font-size:1.05rem; margin-bottom:.6rem;">1. Chaves do app</h2>
    <p style="color:var(--ink-soft); font-size:.92rem;">Copie o <em>Client key</em> e o <em>Client secret</em> em developers.tiktok.com → Tech Santos Publisher (Sandbox ou Production). Ficam guardados no banco do site.</p>
    <form method="post" autocomplete="off">
      <?= csrf_field() ?>
      <input type="hidden" name="action" value="app">
      <div class="field"><label for="ck">Client key</label><input type="text" id="ck" name="client_key" required></div>
      <div class="field"><label for="cs">Client secret</label><input type="password" id="cs" name="client_secret" required></div>
      <div class="field"><label for="amb">Ambiente</label>
        <select id="amb" name="ambiente"><option value="sandbox">Sandbox (testes)</option><option value="producao">Production</option></select></div>
      <button type="submit" class="btn btn-primary">Salvar chaves</button>
    </form>
  </div>
  <?php elseif (!$conta): ?>
  <div class="buy-card" style="max-width:760px; margin-bottom:2rem;">
    <h2 style="font-size:1.05rem; margin-bottom:.6rem;">2. Conectar a conta</h2>
    <p style="color:var(--ink-soft); font-size:.92rem;">App configurado (<?= $h($app['ambiente']) ?>). Entre com a conta do TikTok que vai publicar os vídeos.</p>
    <form method="post"><?= csrf_field() ?><input type="hidden" name="action" value="connect">
      <button type="submit" class="btn btn-primary">Continue with TikTok · Conectar TikTok</button></form>
  </div>
  <?php else: ?>
  <div class="buy-card" style="max-width:760px; margin-bottom:1.5rem; display:flex; gap:1rem; align-items:center;">
    <?php if (!empty($creator['creator_avatar_url']) || !empty($conta['avatar_url'])): ?>
      <img src="<?= $h($creator['creator_avatar_url'] ?? $conta['avatar_url']) ?>" alt="" style="width:56px;height:56px;border-radius:50%;">
    <?php endif; ?>
    <div style="flex:1">
      <strong>Conectado como <?= $h($creator['creator_nickname'] ?? $conta['display_name'] ?? '') ?></strong>
      <?php if (!empty($creator['creator_username'])): ?><span style="color:var(--ink-soft)"> @<?= $h($creator['creator_username']) ?></span><?php endif; ?>
      <div style="color:var(--ink-faint); font-size:.85rem;">Ambiente: <?= $h($app['ambiente']) ?> · token renova sozinho até <?= $h($conta['refresh_expira_em']) ?></div>
    </div>
    <form method="post"><?= csrf_field() ?><input type="hidden" name="action" value="disconnect"><button class="btn btn-ghost on-light">Desconectar</button></form>
  </div>

  <?php if ($creatorErr): ?><div class="alert alert-error">Não foi possível ler as configurações da conta (creator_info): <?= $h($creatorErr) ?></div><?php endif; ?>

  <?php if ($creator): ?>
  <div class="buy-card" style="max-width:760px; margin-bottom:2rem;">
    <h2 style="font-size:1.05rem; margin-bottom:1rem;">Novo post</h2>
    <form method="post" id="ttForm">
      <?= csrf_field() ?>
      <input type="hidden" name="action" value="post">
      <div class="field"><label for="video_url">Vídeo (do nosso servidor de mídia)</label>
        <select id="video_url" name="video_url" required>
          <option value="">Escolha um vídeo…</option>
          <?php foreach ($midias as $m): ?>
            <option value="<?= $h($m['imagem_url']) ?>" data-legenda="<?= $h($m['legenda']) ?>"><?= $h(basename((string)$m['imagem_url'])) ?></option>
          <?php endforeach; ?>
        </select></div>
      <video id="preview" controls playsinline style="display:none; width:220px; border-radius:12px; margin:.2rem 0 1rem; background:#000;"></video>
      <div class="field"><label for="legenda">Legenda (title)</label>
        <textarea id="legenda" name="legenda" rows="4" maxlength="2200"></textarea></div>

      <div class="field"><label>Modo</label>
        <label><input type="radio" name="modo" value="direct" checked> Publicar direto no perfil (Direct Post)</label><br>
        <label><input type="radio" name="modo" value="draft"> Enviar como rascunho para revisar no app (Upload as draft)</label></div>

      <div class="field" id="privBox"><label for="privacy_level">Quem pode ver este vídeo (Who can view this video)</label>
        <select id="privacy_level" name="privacy_level">
          <option value="" selected disabled>Selecione…</option>
          <?php foreach ((array)($creator['privacy_level_options'] ?? []) as $opt): ?>
            <option value="<?= $h($opt) ?>"><?= $h($privLabels[$opt] ?? $opt) ?></option>
          <?php endforeach; ?>
        </select></div>

      <div class="field" id="interBox"><label>Permitir que os usuários (Allow users to)</label>
        <label><input type="checkbox" name="allow_comment" <?= !empty($creator['comment_disabled']) ? 'disabled' : '' ?>> Comentar (Comment)</label>
        <label style="margin-left:1rem"><input type="checkbox" name="allow_duet" <?= !empty($creator['duet_disabled']) ? 'disabled' : '' ?>> Dueto (Duet)</label>
        <label style="margin-left:1rem"><input type="checkbox" name="allow_stitch" <?= !empty($creator['stitch_disabled']) ? 'disabled' : '' ?>> Costura (Stitch)</label></div>

      <div class="field" id="comBox"><label><input type="checkbox" name="commercial" id="commercial"> Divulgar conteúdo comercial (Disclose video content)</label>
        <div id="comOpts" style="display:none; margin:.4rem 0 0 1.4rem;">
          <label><input type="checkbox" name="brand_organic" id="brand_organic"> Sua marca (Your brand) — rótulo "Conteúdo promocional"</label><br>
          <label><input type="checkbox" name="brand_content" id="brand_content"> Conteúdo de marca (Branded content) — rótulo "Parceria paga"</label>
        </div></div>

      <p id="consent" style="color:var(--ink-soft); font-size:.85rem;">Ao publicar, você concorda com a
        <a href="https://www.tiktok.com/legal/page/global/music-usage-confirmation/en" target="_blank" rel="noopener">Music Usage Confirmation</a> do TikTok<span id="bcPolicy" style="display:none"> e com a
        <a href="https://www.tiktok.com/legal/page/global/bc-policy/en" target="_blank" rel="noopener">Branded Content Policy</a></span>.</p>
      <p style="color:var(--ink-faint); font-size:.8rem;">Duração máxima permitida pela conta: <?= (int)($creator['max_video_post_duration_sec'] ?? 0) ?> s. Depois de publicar, o TikTok pode levar alguns minutos para processar o vídeo.</p>
      <button type="submit" class="btn btn-primary" id="postBtn">Publicar no TikTok</button>
    </form>
  </div>
  <?php endif; ?>

  <h2 style="font-size:1.05rem; margin:1.5rem 0 .8rem;">Envios por esta página</h2>
  <table class="admin-table"><thead><tr><th>Quando</th><th>Modo</th><th>Vídeo</th><th>Status</th><th></th></tr></thead><tbody>
  <?php foreach ($posts as $p): ?>
    <tr><td><?= $h($p['criado_em']) ?></td><td><?= $h($p['modo']) ?></td><td><?= $h(basename((string)$p['video_url'])) ?></td>
      <td><?= $h($p['status']) ?><?= $p['detalhe'] ? ' · ' . $h($p['detalhe']) : '' ?></td>
      <td><form method="post"><?= csrf_field() ?><input type="hidden" name="action" value="status"><input type="hidden" name="publish_id" value="<?= $h($p['publish_id']) ?>"><button class="btn btn-ghost on-light">Atualizar status</button></form></td></tr>
  <?php endforeach; ?>
  <?php if (!$posts): ?><tr><td colspan="5" style="color:var(--ink-faint)">Nenhum envio ainda.</td></tr><?php endif; ?>
  </tbody></table>

  <h2 style="font-size:1.05rem; margin:2rem 0 .8rem;">Nossos vídeos no TikTok (video.list)</h2>
  <?php if ($videosErr): ?><div class="alert alert-error"><?= $h($videosErr) ?></div><?php endif; ?>
  <table class="admin-table"><thead><tr><th></th><th>Vídeo</th><th>Visualizações</th><th>Curtidas</th><th>Comentários</th></tr></thead><tbody>
  <?php foreach ((array)$videos as $v): ?>
    <tr><td><?php if (!empty($v['cover_image_url'])): ?><img src="<?= $h($v['cover_image_url']) ?>" alt="" style="width:44px;border-radius:6px"><?php endif; ?></td>
      <td><a href="<?= $h($v['share_url'] ?? '#') ?>" target="_blank" rel="noopener"><?= $h(mb_substr((string)($v['title'] ?? $v['video_description'] ?? ''), 0, 70)) ?></a>
        <div style="color:var(--ink-faint);font-size:.8rem"><?= !empty($v['create_time']) ? date('d/m/Y H:i', (int)$v['create_time']) : '' ?></div></td>
      <td><?= (int)($v['view_count'] ?? 0) ?></td><td><?= (int)($v['like_count'] ?? 0) ?></td><td><?= (int)($v['comment_count'] ?? 0) ?></td></tr>
  <?php endforeach; ?>
  </tbody></table>
  <?php endif; ?>
</main>
<script>
(function(){
  var sel=document.getElementById('video_url'); if(!sel) return;
  var prev=document.getElementById('preview'), leg=document.getElementById('legenda');
  sel.addEventListener('change',function(){ var o=sel.options[sel.selectedIndex]; if(sel.value){prev.src=sel.value;prev.style.display='block';} else {prev.style.display='none';}
    if(o && o.dataset.legenda && !leg.value) leg.value=o.dataset.legenda; });
  var com=document.getElementById('commercial'), opts=document.getElementById('comOpts'), bc=document.getElementById('brand_content'),
      bo=document.getElementById('brand_organic'), pol=document.getElementById('bcPolicy'), priv=document.getElementById('privacy_level'),
      btn=document.getElementById('postBtn');
  function sync(){ opts.style.display=com.checked?'block':'none'; pol.style.display=(com.checked&&bc.checked)?'inline':'none';
    var self=[].find.call(priv.options,function(o){return o.value==='SELF_ONLY'}); if(self){ self.disabled=com.checked&&bc.checked; if(self.disabled&&priv.value==='SELF_ONLY') priv.value=''; }
    btn.disabled = com.checked && !bc.checked && !bo.checked; }
  [com,bc,bo].forEach(function(e){e.addEventListener('change',sync)}); sync();
  document.querySelectorAll('input[name=modo]').forEach(function(r){ r.addEventListener('change',function(){ var d=document.querySelector('input[name=modo]:checked').value==='draft';
    ['privBox','interBox','comBox'].forEach(function(id){document.getElementById(id).style.display=d?'none':'block'}); btn.textContent=d?'Enviar rascunho':'Publicar no TikTok'; }); });
})();
</script>
<?php admin_foot(); ?>
