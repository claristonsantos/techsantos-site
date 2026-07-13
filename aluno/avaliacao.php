<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../curso_modulos.php';
$aluno = require_aluno();

$moduloId = (string)($_GET['modulo'] ?? '');
if (!preg_match('/^[a-z0-9-]+$/', $moduloId)) {
    http_response_code(400);
    exit('Módulo inválido.');
}

$pdo = db();
$stmt = $pdo->prepare('SELECT * FROM avaliacoes WHERE curso_id = ? AND modulo_id = ? AND ativo = 1');
$stmt->execute([$aluno['curso_id'], $moduloId]);
$avaliacao = $stmt->fetch();

if (!$avaliacao) {
    http_response_code(404);
    exit('Nenhuma avaliação encontrada para este módulo ainda.');
}

$moduloAnteriorId = modulo_anterior($moduloId);
if ($moduloAnteriorId !== null) {
    $prevAvalStmt = $pdo->prepare('SELECT id FROM avaliacoes WHERE curso_id = ? AND modulo_id = ? AND ativo = 1');
    $prevAvalStmt->execute([$aluno['curso_id'], $moduloAnteriorId]);
    $prevAvaliacaoId = $prevAvalStmt->fetchColumn();

    if ($prevAvaliacaoId) {
        $prevStmt = $pdo->prepare(
            'SELECT 1 FROM avaliacao_tentativas WHERE avaliacao_id = ? AND aluno_id = ? AND aprovado = 1 LIMIT 1'
        );
        $prevStmt->execute([$prevAvaliacaoId, $aluno['id']]);
        if (!$prevStmt->fetchColumn()) {
            http_response_code(403);
            exit('Conclua a avaliação do módulo anterior antes de acessar esta avaliação.');
        }
    }
}

$error = null;
$resultado = null;
$detalhes = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();

    $qStmt = $pdo->prepare('SELECT id FROM avaliacao_questoes WHERE avaliacao_id = ? ORDER BY ordem, id');
    $qStmt->execute([$avaliacao['id']]);
    $questaoIds = $qStmt->fetchAll(PDO::FETCH_COLUMN);

    if (!$questaoIds) {
        $error = 'Esta avaliação ainda não tem perguntas cadastradas.';
    } else {
        $acertos = 0;
        $detalhes = [];
        foreach ($questaoIds as $qid) {
            $respostaId = (int)($_POST['q' . $qid] ?? 0);
            $altStmt = $pdo->prepare('SELECT id, texto, correta FROM avaliacao_alternativas WHERE questao_id = ?');
            $altStmt->execute([$qid]);
            $alternativas = $altStmt->fetchAll();
            $corretaId = null;
            foreach ($alternativas as $a) {
                if ($a['correta']) { $corretaId = (int)$a['id']; break; }
            }
            $acertou = $respostaId > 0 && $respostaId === $corretaId;
            if ($acertou) $acertos++;
            $detalhes[$qid] = ['resposta_id' => $respostaId, 'correta_id' => $corretaId, 'acertou' => $acertou];
        }

        $total = count($questaoIds);
        $nota = $total > 0 ? round(($acertos / $total) * 100, 2) : 0;
        $aprovado = $nota >= $avaliacao['nota_minima'];

        $insStmt = $pdo->prepare('INSERT INTO avaliacao_tentativas (aluno_id, avaliacao_id, nota, aprovado) VALUES (?, ?, ?, ?)');
        $insStmt->execute([$aluno['id'], $avaliacao['id'], $nota, $aprovado ? 1 : 0]);
        $tentativaId = (int)$pdo->lastInsertId();

        $insR = $pdo->prepare('INSERT INTO avaliacao_respostas (tentativa_id, questao_id, alternativa_id) VALUES (?, ?, ?)');
        foreach ($detalhes as $qid => $d) {
            if ($d['resposta_id'] > 0) {
                $insR->execute([$tentativaId, $qid, $d['resposta_id']]);
            }
        }

        $certificadoCodigo = null;
        if ($aprovado && $moduloId === 'encerramento') {
            $cStmt = $pdo->prepare('SELECT codigo FROM certificados WHERE aluno_id = ? AND curso_id = ?');
            $cStmt->execute([$aluno['id'], $aluno['curso_id']]);
            $existente = $cStmt->fetchColumn();
            if ($existente) {
                $certificadoCodigo = $existente;
            } else {
                $certificadoCodigo = 'TS' . strtoupper(bin2hex(random_bytes(4)));
                $insC = $pdo->prepare('INSERT INTO certificados (aluno_id, curso_id, codigo) VALUES (?, ?, ?)');
                $insC->execute([$aluno['id'], $aluno['curso_id'], $certificadoCodigo]);
            }
        }

        $resultado = ['nota' => $nota, 'aprovado' => $aprovado, 'acertos' => $acertos, 'total' => $total, 'detalhes' => $detalhes, 'certificado' => $certificadoCodigo];
    }
}

if (!$resultado) {
    $lastStmt = $pdo->prepare(
        'SELECT id, nota FROM avaliacao_tentativas WHERE aluno_id = ? AND avaliacao_id = ? AND aprovado = 1 ORDER BY criada_em DESC LIMIT 1'
    );
    $lastStmt->execute([$aluno['id'], $avaliacao['id']]);
    $lastAprovada = $lastStmt->fetch();

    if ($lastAprovada) {
        $respStmt = $pdo->prepare('SELECT questao_id, alternativa_id FROM avaliacao_respostas WHERE tentativa_id = ?');
        $respStmt->execute([(int)$lastAprovada['id']]);
        $respostasSalvas = [];
        foreach ($respStmt->fetchAll() as $r) {
            $respostasSalvas[(int)$r['questao_id']] = (int)$r['alternativa_id'];
        }

        $qIdsStmt = $pdo->prepare('SELECT id FROM avaliacao_questoes WHERE avaliacao_id = ? ORDER BY ordem, id');
        $qIdsStmt->execute([$avaliacao['id']]);
        $questaoIds = $qIdsStmt->fetchAll(PDO::FETCH_COLUMN);

        $acertos = 0;
        foreach ($questaoIds as $qid) {
            $altStmt = $pdo->prepare('SELECT id, correta FROM avaliacao_alternativas WHERE questao_id = ?');
            $altStmt->execute([$qid]);
            $corretaId = null;
            foreach ($altStmt->fetchAll() as $a) {
                if ($a['correta']) { $corretaId = (int)$a['id']; break; }
            }
            $respostaId = $respostasSalvas[$qid] ?? 0;
            $acertou = $respostaId > 0 && $respostaId === $corretaId;
            if ($acertou) $acertos++;
            $detalhes[$qid] = ['resposta_id' => $respostaId, 'correta_id' => $corretaId, 'acertou' => $acertou];
        }

        $certificadoCodigo = null;
        if ($moduloId === 'encerramento') {
            $cStmt = $pdo->prepare('SELECT codigo FROM certificados WHERE aluno_id = ? AND curso_id = ?');
            $cStmt->execute([$aluno['id'], $aluno['curso_id']]);
            $certificadoCodigo = $cStmt->fetchColumn() ?: null;
        }

        $resultado = [
            'nota' => (float)$lastAprovada['nota'],
            'aprovado' => true,
            'acertos' => $acertos,
            'total' => count($questaoIds),
            'detalhes' => $detalhes,
            'certificado' => $certificadoCodigo,
        ];
    }
}

$qStmt = $pdo->prepare('SELECT * FROM avaliacao_questoes WHERE avaliacao_id = ? ORDER BY ordem, id');
$qStmt->execute([$avaliacao['id']]);
$questoes = $qStmt->fetchAll();
foreach ($questoes as &$q) {
    $altStmt = $pdo->prepare('SELECT id, texto FROM avaliacao_alternativas WHERE questao_id = ? ORDER BY ordem, id');
    $altStmt->execute([$q['id']]);
    $q['alternativas'] = $altStmt->fetchAll();
}
unset($q);
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="robots" content="noindex, nofollow" />
<link rel="icon" type="image/png" href="/assets/img/favicon-32.png" />
<title><?= htmlspecialchars($avaliacao['titulo'], ENT_QUOTES) ?> — Área do Aluno — TECH SANTOS BR</title>
<link rel="stylesheet" href="/assets/css/style.css" />
<link rel="stylesheet" href="/assets/css/admin.css" />
<style>
  .eval-shell { max-width: 720px; margin: 0 auto; padding: clamp(1.5rem, 4vw, 3rem) 1.25rem 5rem; }
  .eval-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; }
  .eval-top a { font-size: 0.85rem; color: var(--ink-soft); text-decoration: none; }
  .eval-head { margin-bottom: 2rem; }
  .eval-head h1 { font-size: 1.5rem; margin-bottom: 0.5rem; }
  .eval-head p { color: var(--ink-soft); font-size: 0.92rem; }
  .q-card { background: var(--surface); border: 1px solid var(--line); border-radius: 8px; padding: 1.4rem 1.5rem; margin-bottom: 1.25rem; }
  .q-card .q-num { font-family: 'Plex Mono', monospace; font-size: 0.72rem; color: var(--green-strong); margin-bottom: 0.5rem; display: block; }
  .q-card .q-text { font-size: 1rem; font-weight: 600; margin-bottom: 1rem; }
  .q-opt { display: flex; align-items: flex-start; gap: 0.65rem; padding: 0.6rem 0.7rem; border-radius: 6px; cursor: pointer; }
  .q-opt:hover { background: var(--surface-2); }
  .q-opt input { margin-top: 0.2rem; }
  .q-opt span { font-size: 0.92rem; color: var(--ink); line-height: 1.4; }
  .q-opt.correct { background: var(--green-soft); }
  .q-opt.wrong { background: rgba(213, 71, 60, 0.1); }
  .result-card { text-align: center; padding: 2.5rem 1.5rem; border-radius: 8px; margin-bottom: 2rem; }
  .result-card.pass { background: var(--green-soft); border: 1px solid var(--green); }
  .result-card.fail { background: var(--surface-2); border: 1px solid var(--line); }
  .result-card .score { font-family: 'Plex Mono', monospace; font-size: 2.5rem; font-weight: 500; margin-bottom: 0.5rem; }
  .result-card.pass .score { color: var(--green-strong); }
  .result-card h2 { font-size: 1.2rem; margin-bottom: 0.5rem; }
  .result-card p { color: var(--ink-soft); font-size: 0.92rem; }
</style>
</head>
<body>
<div class="eval-shell">
  <div class="eval-top">
    <a href="/aluno/">← Voltar para o curso</a>
  </div>

  <?php if ($resultado): ?>
    <div class="result-card <?= $resultado['aprovado'] ? 'pass' : 'fail' ?>">
      <div class="score"><?= number_format($resultado['nota'], 0) ?>%</div>
      <h2><?= $resultado['aprovado'] ? 'Aprovado!' : 'Não foi dessa vez' ?></h2>
      <p><?= $resultado['acertos'] ?> de <?= $resultado['total'] ?> questões corretas · nota mínima <?= (int)$avaliacao['nota_minima'] ?>%</p>
      <?php if ($resultado['aprovado'] && $resultado['certificado']): ?>
        <p style="margin-top:1rem;"><a class="btn btn-primary" href="/certificado.php?codigo=<?= urlencode($resultado['certificado']) ?>">Ver meu certificado</a></p>
      <?php elseif ($resultado['aprovado']): ?>
        <?php $moduloSeguinteId = modulo_seguinte($moduloId); ?>
        <p style="margin-top:1rem;"><a class="btn btn-primary" href="/aluno/<?= $moduloSeguinteId ? '?modulo=' . urlencode($moduloSeguinteId) : '' ?>">Continuar o curso</a></p>
      <?php else: ?>
        <p style="margin-top:1rem;"><a class="btn btn-ghost on-light" href="/aluno/avaliacao.php?modulo=<?= urlencode($moduloId) ?>">Tentar novamente</a></p>
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES) ?></div><?php endif; ?>

  <?php if ($resultado && $resultado['aprovado']): ?>
  <div class="eval-head">
    <h1>Revisão das respostas</h1>
    <p>Confira abaixo o que você acertou e errou nesta tentativa.</p>
  </div>
  <?php foreach ($questoes as $i => $q): $d = $detalhes[$q['id']] ?? null; ?>
    <div class="q-card">
      <span class="q-num">Questão <?= $i + 1 ?> de <?= count($questoes) ?></span>
      <p class="q-text"><?= htmlspecialchars($q['enunciado'], ENT_QUOTES) ?></p>
      <?php foreach ($q['alternativas'] as $a):
        $aid = (int)$a['id'];
        $isCorrect = $d && $aid === $d['correta_id'];
        $isYourWrong = $d && $aid === $d['resposta_id'] && !$isCorrect;
        $cls = $isCorrect ? 'correct' : ($isYourWrong ? 'wrong' : '');
      ?>
        <div class="q-opt <?= $cls ?>">
          <span><?= htmlspecialchars($a['texto'], ENT_QUOTES) ?><?= $isCorrect ? ' ✓' : ($isYourWrong ? ' ✗ (sua resposta)' : '') ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endforeach; ?>
  <?php elseif (!$resultado): ?>
  <div class="eval-head">
    <h1><?= htmlspecialchars($avaliacao['titulo'], ENT_QUOTES) ?></h1>
    <p>Nota mínima para aprovação: <?= (int)$avaliacao['nota_minima'] ?>%. Você pode refazer quantas vezes precisar.</p>
  </div>
  <form method="post" novalidate>
    <?= csrf_field() ?>
    <?php foreach ($questoes as $i => $q): ?>
      <div class="q-card">
        <span class="q-num">Questão <?= $i + 1 ?> de <?= count($questoes) ?></span>
        <p class="q-text"><?= htmlspecialchars($q['enunciado'], ENT_QUOTES) ?></p>
        <?php foreach ($q['alternativas'] as $a): ?>
          <label class="q-opt">
            <input type="radio" name="q<?= (int)$q['id'] ?>" value="<?= (int)$a['id'] ?>" required>
            <span><?= htmlspecialchars($a['texto'], ENT_QUOTES) ?></span>
          </label>
        <?php endforeach; ?>
      </div>
    <?php endforeach; ?>
    <button type="submit" class="btn btn-primary btn-block">Enviar respostas</button>
  </form>
  <?php endif; ?>
</div>
</body>
</html>
