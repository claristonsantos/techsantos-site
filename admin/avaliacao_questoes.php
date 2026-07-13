<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/_partials.php';
require_admin();

$pdo = db();
$avaliacaoId = (int)($_GET['id'] ?? 0);
$avStmt = $pdo->prepare('SELECT a.*, c.nome AS curso_nome FROM avaliacoes a JOIN cursos c ON c.id = a.curso_id WHERE a.id = ?');
$avStmt->execute([$avaliacaoId]);
$avaliacao = $avStmt->fetch();
if (!$avaliacao) {
    http_response_code(404);
    exit('Avaliação não encontrada.');
}

$error = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';

    if ($action === 'delete') {
        $qid = (int)($_POST['questao_id'] ?? 0);
        $pdo->prepare('DELETE FROM avaliacao_questoes WHERE id = ? AND avaliacao_id = ?')->execute([$qid, $avaliacaoId]);
        header('Location: /admin/avaliacao_questoes.php?id=' . $avaliacaoId . '&msg=' . urlencode('Questão removida.'));
        exit;
    }

    if ($action === 'save') {
        $questaoId = (int)($_POST['questao_id'] ?? 0);
        $enunciado = trim((string)($_POST['enunciado'] ?? ''));
        $alternativas = $_POST['alternativa'] ?? [];
        $corretaIdx = (int)($_POST['correta'] ?? -1);
        $alternativas = array_map('trim', is_array($alternativas) ? $alternativas : []);
        $preenchidas = array_filter($alternativas, fn($a) => $a !== '');

        if ($enunciado === '' || count($preenchidas) < 2) {
            $error = 'Informe o enunciado e pelo menos 2 alternativas.';
        } elseif ($corretaIdx < 0 || !isset($alternativas[$corretaIdx]) || $alternativas[$corretaIdx] === '') {
            $error = 'Selecione qual alternativa é a correta.';
        } elseif ($questaoId === 0) {
            $pdo->beginTransaction();
            $maxOrdem = (int)$pdo->query("SELECT COALESCE(MAX(ordem), 0) FROM avaliacao_questoes WHERE avaliacao_id = $avaliacaoId")->fetchColumn();
            $ins = $pdo->prepare('INSERT INTO avaliacao_questoes (avaliacao_id, enunciado, ordem) VALUES (?, ?, ?)');
            $ins->execute([$avaliacaoId, $enunciado, $maxOrdem + 1]);
            $novaQuestaoId = (int)$pdo->lastInsertId();
            $insAlt = $pdo->prepare('INSERT INTO avaliacao_alternativas (questao_id, texto, correta, ordem) VALUES (?, ?, ?, ?)');
            foreach ($alternativas as $i => $texto) {
                if ($texto === '') continue;
                $insAlt->execute([$novaQuestaoId, $texto, $i === $corretaIdx ? 1 : 0, $i]);
            }
            $pdo->commit();
            header('Location: /admin/avaliacao_questoes.php?id=' . $avaliacaoId . '&msg=' . urlencode('Questão adicionada.'));
            exit;
        } else {
            $pdo->beginTransaction();
            $upd = $pdo->prepare('UPDATE avaliacao_questoes SET enunciado = ? WHERE id = ? AND avaliacao_id = ?');
            $upd->execute([$enunciado, $questaoId, $avaliacaoId]);
            $pdo->prepare('DELETE FROM avaliacao_alternativas WHERE questao_id = ?')->execute([$questaoId]);
            $insAlt = $pdo->prepare('INSERT INTO avaliacao_alternativas (questao_id, texto, correta, ordem) VALUES (?, ?, ?, ?)');
            foreach ($alternativas as $i => $texto) {
                if ($texto === '') continue;
                $insAlt->execute([$questaoId, $texto, $i === $corretaIdx ? 1 : 0, $i]);
            }
            $pdo->commit();
            header('Location: /admin/avaliacao_questoes.php?id=' . $avaliacaoId . '&msg=' . urlencode('Questão atualizada.'));
            exit;
        }
    }
}

$editQuestaoId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$editQuestao = null;
if ($editQuestaoId > 0) {
    $stmt = $pdo->prepare('SELECT * FROM avaliacao_questoes WHERE id = ? AND avaliacao_id = ?');
    $stmt->execute([$editQuestaoId, $avaliacaoId]);
    $editQuestao = $stmt->fetch();
    if ($editQuestao) {
        $altStmt = $pdo->prepare('SELECT * FROM avaliacao_alternativas WHERE questao_id = ? ORDER BY ordem, id');
        $altStmt->execute([$editQuestaoId]);
        $editQuestao['alternativas'] = $altStmt->fetchAll();
    }
}

if (isset($_GET['msg']) && !$error) {
    $success = $_GET['msg'];
}

$qStmt = $pdo->prepare('SELECT * FROM avaliacao_questoes WHERE avaliacao_id = ? ORDER BY ordem, id');
$qStmt->execute([$avaliacaoId]);
$questoes = $qStmt->fetchAll();
foreach ($questoes as &$q) {
    $altStmt = $pdo->prepare('SELECT * FROM avaliacao_alternativas WHERE questao_id = ? ORDER BY ordem, id');
    $altStmt->execute([$q['id']]);
    $q['alternativas'] = $altStmt->fetchAll();
}
unset($q);

admin_head('Questões — ' . $avaliacao['titulo']);
admin_topbar('avaliacoes');
?>
<main class="admin-main">
  <div class="admin-head">
    <h1><?= htmlspecialchars($avaliacao['titulo'], ENT_QUOTES) ?></h1>
  </div>
  <p style="margin-bottom:1.5rem;"><a href="/admin/avaliacoes.php" style="color:var(--green-strong); font-size:0.88rem; text-decoration:none;">← Todas as avaliações</a></p>

  <?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES) ?></div><?php endif; ?>
  <?php if ($success): ?><div class="alert alert-success"><?= htmlspecialchars($success, ENT_QUOTES) ?></div><?php endif; ?>

  <div class="form-card" style="max-width:680px;">
    <h2><?= $editQuestao ? 'Editar questão' : 'Adicionar questão' ?></h2>
    <form method="post" novalidate>
      <?= csrf_field() ?>
      <input type="hidden" name="action" value="save">
      <input type="hidden" name="questao_id" value="<?= (int)($editQuestao['id'] ?? 0) ?>">
      <div class="field">
        <label for="enunciado">Enunciado *</label>
        <textarea id="enunciado" name="enunciado" rows="2" required><?= htmlspecialchars($editQuestao['enunciado'] ?? '', ENT_QUOTES) ?></textarea>
      </div>
      <div class="field">
        <label>Alternativas * (marque a correta)</label>
        <?php
          $existentes = $editQuestao['alternativas'] ?? [];
          $corretaExistenteIdx = 0;
          foreach ($existentes as $idx => $alt) { if ($alt['correta']) { $corretaExistenteIdx = $idx; break; } }
        ?>
        <?php for ($i = 0; $i < 4; $i++): ?>
          <div style="display:flex; align-items:center; gap:0.6rem; margin-bottom:0.5rem;">
            <input type="radio" name="correta" value="<?= $i ?>" <?= $i === $corretaExistenteIdx ? 'checked' : '' ?> <?= $i === 0 ? 'required' : '' ?> style="width:auto;">
            <input type="text" name="alternativa[]" placeholder="Alternativa <?= $i + 1 ?><?= $i >= 2 ? ' (opcional)' : '' ?>" value="<?= htmlspecialchars($existentes[$i]['texto'] ?? '', ENT_QUOTES) ?>" style="flex:1; padding:0.5rem 0.7rem; border:1px solid var(--line); border-radius:5px; background:var(--bg); color:var(--ink);">
          </div>
        <?php endfor; ?>
        <p class="hint">A alternativa com o rádio selecionado é a correta.</p>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $editQuestao ? 'Salvar alterações' : 'Adicionar questão' ?></button>
        <?php if ($editQuestao): ?><a class="btn btn-ghost on-light" href="/admin/avaliacao_questoes.php?id=<?= $avaliacaoId ?>">Cancelar</a><?php endif; ?>
      </div>
    </form>
  </div>

  <div class="table-wrap" style="max-width:680px;">
    <?php if (!$questoes): ?>
      <p style="color:var(--ink-faint); font-size:0.9rem;">Nenhuma questão cadastrada ainda.</p>
    <?php endif; ?>
    <?php foreach ($questoes as $i => $q): ?>
      <div class="form-card" style="max-width:none;">
        <h2 style="font-size:0.95rem;">Questão <?= $i + 1 ?></h2>
        <p style="margin-bottom:0.75rem;"><?= htmlspecialchars($q['enunciado'], ENT_QUOTES) ?></p>
        <ul style="list-style:none; padding:0; margin:0 0 1rem; display:grid; gap:0.4rem;">
          <?php foreach ($q['alternativas'] as $a): ?>
            <li style="font-size:0.88rem; padding:0.4rem 0.6rem; border-radius:4px; <?= $a['correta'] ? 'background:var(--green-soft); color:var(--green-strong); font-weight:600;' : 'color:var(--ink-soft);' ?>"><?= htmlspecialchars($a['texto'], ENT_QUOTES) ?><?= $a['correta'] ? ' ✓' : '' ?></li>
          <?php endforeach; ?>
        </ul>
        <div style="display:flex; gap:1rem; align-items:center;">
          <a href="/admin/avaliacao_questoes.php?id=<?= $avaliacaoId ?>&edit=<?= (int)$q['id'] ?>" style="font-size:0.82rem; font-weight:600; color:var(--green-strong); text-decoration:none;">Editar questão</a>
          <form method="post" onsubmit="return confirm('Remover esta questão?');">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="questao_id" value="<?= (int)$q['id'] ?>">
            <button type="submit" class="danger" style="background:none;border:none;color:#C0392B;font-size:0.82rem;font-weight:600;cursor:pointer;padding:0;">Remover questão</button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</main>
<?php admin_foot(); ?>
