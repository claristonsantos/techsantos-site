<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/_partials.php';
require_admin();

$pdo = db();
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';

    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        $pdo->prepare('DELETE FROM social_auto_reply_rules WHERE id = ?')->execute([$id]);
        header('Location: /admin/social_auto_reply.php?msg=' . urlencode('Regra removida.'));
        exit;
    }

    if ($action === 'move') {
        // Renumera tudo em passos de 10 na ordem atual e troca a regra com a vizinha.
        $id = (int)($_POST['id'] ?? 0);
        $dir = ($_POST['dir'] ?? '') === 'up' ? -1 : 1;
        $ids = $pdo->query('SELECT id FROM social_auto_reply_rules ORDER BY prioridade ASC, id ASC')->fetchAll(PDO::FETCH_COLUMN);
        $pos = array_search($id, array_map('intval', $ids), true);
        if ($pos !== false && isset($ids[$pos + $dir])) {
            [$ids[$pos], $ids[$pos + $dir]] = [$ids[$pos + $dir], $ids[$pos]];
        }
        $upd = $pdo->prepare('UPDATE social_auto_reply_rules SET prioridade = ? WHERE id = ?');
        foreach (array_values($ids) as $i => $ruleId) {
            $upd->execute([($i + 1) * 10, (int)$ruleId]);
        }
        header('Location: /admin/social_auto_reply.php?msg=' . urlencode('Ordem atualizada.'));
        exit;
    }

    if ($action === 'save') {
        $id = (int)($_POST['id'] ?? 0);
        $palavraChave = trim((string)($_POST['palavra_chave'] ?? ''));
        $mensagem = trim((string)($_POST['mensagem'] ?? ''));
        $ativo = isset($_POST['ativo']) ? 1 : 0;
        $prioridade = max(1, min(9999, (int)($_POST['prioridade'] ?? 100)));

        if ($palavraChave === '' || $mensagem === '') {
            $error = 'Preencha a palavra-chave e a mensagem.';
        } elseif ($id === 0) {
            $pdo->prepare('INSERT INTO social_auto_reply_rules (palavra_chave, mensagem, ativo, prioridade) VALUES (?, ?, ?, ?)')
                ->execute([$palavraChave, $mensagem, $ativo, $prioridade]);
            header('Location: /admin/social_auto_reply.php?msg=' . urlencode('Regra criada.'));
            exit;
        } else {
            $pdo->prepare('UPDATE social_auto_reply_rules SET palavra_chave=?, mensagem=?, ativo=?, prioridade=? WHERE id=?')
                ->execute([$palavraChave, $mensagem, $ativo, $prioridade, $id]);
            header('Location: /admin/social_auto_reply.php?msg=' . urlencode('Regra atualizada.'));
            exit;
        }
    }
}

$editRow = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare('SELECT * FROM social_auto_reply_rules WHERE id = ?');
    $stmt->execute([(int)$_GET['edit']]);
    $editRow = $stmt->fetch();
}

if (isset($_GET['msg']) && !$error) {
    $msg = (string)$_GET['msg'];
}

// Mesma ordem em que o webhook verifica as regras (menor prioridade primeiro).
$rules = $pdo->query('SELECT * FROM social_auto_reply_rules ORDER BY prioridade ASC, id ASC')->fetchAll();
$log = $pdo->query('SELECT * FROM social_auto_reply_log ORDER BY criado_em DESC LIMIT 50')->fetchAll();

admin_head('Auto-resposta de comentários');
admin_topbar('social_auto_reply');
?>
<main class="admin-main">
  <div class="admin-head"><h1>Auto-resposta de comentários</h1></div>
  <p style="color:var(--ink-soft); max-width:70ch; margin-bottom:1.5rem;">
    Quando alguém comenta uma das palavras-chave abaixo num post do Facebook ou Instagram, o site responde automaticamente no privado com a mensagem configurada.
    As regras são verificadas de cima para baixo e só a primeira que casar responde — use as setas para mudar a ordem.
    <strong>Ainda não está no ar de verdade nem no Facebook nem no Instagram.</strong> Confirmado em 14/07/2026: enquanto o app da Meta não for publicado, nenhum evento de comentário real chega no webhook — nem dos próprios administradores/testadores (a Meta só entrega eventos de teste disparados manualmente no painel enquanto o app estiver "Não publicado"). Falta concluir a <strong>Verificação de Empresa</strong> e publicar o app em developers.facebook.com para essa função funcionar de verdade.
  </p>

  <?php if (isset($msg)): ?><div class="alert alert-success"><?= htmlspecialchars($msg, ENT_QUOTES) ?></div><?php endif; ?>
  <?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES) ?></div><?php endif; ?>

  <div class="buy-card" style="max-width:760px; margin-bottom:2rem;">
    <h2 style="font-size:1.05rem; margin-bottom:1rem;"><?= $editRow ? 'Editar regra' : 'Nova regra' ?></h2>
    <form method="post" novalidate>
      <?= csrf_field() ?>
      <input type="hidden" name="action" value="save">
      <input type="hidden" name="id" value="<?= $editRow ? (int)$editRow['id'] : 0 ?>">
      <div class="field">
        <label for="palavra_chave">Palavra-chave (a busca ignora maiúsculas/minúsculas e casa em qualquer parte do comentário)</label>
        <input type="text" id="palavra_chave" name="palavra_chave" required placeholder="QUERO"
               value="<?= $editRow ? htmlspecialchars($editRow['palavra_chave'], ENT_QUOTES) : '' ?>">
      </div>
      <div class="field">
        <label for="mensagem">Mensagem enviada no privado</label>
        <textarea id="mensagem" name="mensagem" rows="4" required><?= $editRow ? htmlspecialchars($editRow['mensagem'], ENT_QUOTES) : '' ?></textarea>
      </div>
      <div class="field">
        <label for="prioridade">Prioridade (menor número é verificado primeiro — quando um comentário tem mais de uma palavra-chave, vale a regra de menor número)</label>
        <input type="number" id="prioridade" name="prioridade" min="1" max="9999" style="max-width:10rem;"
               value="<?= $editRow ? (int)$editRow['prioridade'] : 100 ?>">
      </div>
      <div class="field">
        <label><input type="checkbox" name="ativo" <?= (!$editRow || $editRow['ativo']) ? 'checked' : '' ?>> Regra ativa</label>
      </div>
      <button type="submit" class="btn btn-primary"><?= $editRow ? 'Salvar alterações' : 'Criar regra' ?></button>
      <?php if ($editRow): ?><a class="btn btn-ghost on-light" href="/admin/social_auto_reply.php">Cancelar edição</a><?php endif; ?>
    </form>
  </div>

  <div class="table-wrap" style="margin-bottom:2.5rem;">
    <table class="data-table">
      <thead><tr><th>Ordem</th><th>Palavra-chave</th><th>Mensagem</th><th>Status</th><th></th></tr></thead>
      <tbody>
        <?php if (!$rules): ?>
          <tr class="empty-row"><td colspan="5">Nenhuma regra cadastrada ainda.</td></tr>
        <?php endif; ?>
        <?php foreach ($rules as $i => $r): ?>
          <tr>
            <td style="white-space:nowrap;">
              <span title="Prioridade <?= (int)$r['prioridade'] ?>"><?= $i + 1 ?>º</span>
              <?php foreach (['up' => '↑', 'down' => '↓'] as $dir => $arrow): ?>
                <?php if (($dir === 'up' && $i > 0) || ($dir === 'down' && $i < count($rules) - 1)): ?>
                <form method="post" style="display:inline">
                  <?= csrf_field() ?>
                  <input type="hidden" name="action" value="move">
                  <input type="hidden" name="dir" value="<?= $dir ?>">
                  <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                  <button type="submit" title="<?= $dir === 'up' ? 'Subir' : 'Descer' ?>" aria-label="<?= $dir === 'up' ? 'Subir' : 'Descer' ?> <?= htmlspecialchars($r['palavra_chave'], ENT_QUOTES) ?>"><?= $arrow ?></button>
                </form>
                <?php endif; ?>
              <?php endforeach; ?>
            </td>
            <td><strong><?= htmlspecialchars($r['palavra_chave'], ENT_QUOTES) ?></strong></td>
            <td><?= htmlspecialchars(mb_strimwidth($r['mensagem'], 0, 70, '…'), ENT_QUOTES) ?></td>
            <td><span class="badge <?= $r['ativo'] ? 'on' : 'off' ?>"><?= $r['ativo'] ? 'ativa' : 'inativa' ?></span></td>
            <td class="actions">
              <a href="/admin/social_auto_reply.php?edit=<?= (int)$r['id'] ?>">Editar</a>
              <form method="post" onsubmit="return confirm('Remover esta regra?');" style="display:inline">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                <button type="submit" class="danger">Remover</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <h2 style="font-size:1.05rem; margin-bottom:1rem;">Últimas respostas enviadas</h2>
  <div class="table-wrap">
    <table class="data-table">
      <thead><tr><th>Quando</th><th>Canal</th><th>Autor</th><th>Comentário</th><th>Status</th></tr></thead>
      <tbody>
        <?php if (!$log): ?>
          <tr class="empty-row"><td colspan="5">Nenhuma resposta automática enviada ainda.</td></tr>
        <?php endif; ?>
        <?php foreach ($log as $l): ?>
          <tr>
            <td><?= date('d/m/Y H:i', strtotime($l['criado_em'] . ' UTC') - 10800) ?></td>
            <td><?= htmlspecialchars($l['plataforma'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($l['autor'] ?? '', ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars(mb_strimwidth((string)$l['texto_comentario'], 0, 60, '…'), ENT_QUOTES) ?></td>
            <td>
              <span class="badge <?= $l['status'] === 'enviado' ? 'on' : 'off' ?>"><?= htmlspecialchars($l['status'], ENT_QUOTES) ?></span>
              <?php if ($l['erro_msg']): ?><p style="margin-top:0.3rem; color:#C0392B; font-size:0.78rem;"><?= htmlspecialchars($l['erro_msg'], ENT_QUOTES) ?></p><?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>
<?php admin_foot(); ?>
