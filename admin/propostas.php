<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/_partials.php';
require_admin();

$pdo = db();
$error = null;
$success = null;

function proposta_itens_from_post(): array
{
    $descs = $_POST['item_desc'] ?? [];
    $horas = $_POST['item_horas'] ?? [];
    $valores = $_POST['item_valor'] ?? [];
    $itens = [];
    $n = is_array($descs) ? count($descs) : 0;
    for ($i = 0; $i < $n; $i++) {
        $desc = trim((string)($descs[$i] ?? ''));
        if ($desc === '') continue;
        $h = (float)str_replace(',', '.', (string)($horas[$i] ?? '0'));
        $v = (float)str_replace(',', '.', (string)($valores[$i] ?? '0'));
        $itens[] = ['descricao' => $desc, 'horas' => $h, 'valor_hora' => $v];
    }
    return $itens;
}

function proposta_total(array $itens): float
{
    $total = 0.0;
    foreach ($itens as $item) {
        $total += ((float)$item['horas']) * ((float)$item['valor_hora']);
    }
    return $total;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';

    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        $pdo->prepare('DELETE FROM propostas WHERE id = ?')->execute([$id]);
        header('Location: /admin/propostas.php?msg=' . urlencode('Proposta removida.'));
        exit;
    }

    if ($action === 'save') {
        $id = (int)($_POST['id'] ?? 0);
        $cliente = trim((string)($_POST['cliente'] ?? ''));
        $projeto = trim((string)($_POST['projeto'] ?? ''));
        $tipo = ($_POST['tipo'] ?? 'novo') === 'alteracao' ? 'alteracao' : 'novo';
        $formato = trim((string)($_POST['formato'] ?? ''));
        $natureza = ($_POST['natureza'] ?? 'orcamento') === 'desenvolvimento' ? 'desenvolvimento' : 'orcamento';
        $versao = trim((string)($_POST['versao'] ?? '1')) ?: '1';
        $autor = trim((string)($_POST['autor'] ?? '')) ?: 'Clariston Santos';
        $resumo = trim((string)($_POST['resumo'] ?? ''));
        $escopo = trim((string)($_POST['escopo'] ?? ''));
        $objetivo = trim((string)($_POST['objetivo'] ?? ''));
        $premissas = trim((string)($_POST['premissas'] ?? ''));
        $moeda = trim((string)($_POST['moeda'] ?? 'USD')) ?: 'USD';
        $status = trim((string)($_POST['status'] ?? 'rascunho')) ?: 'rascunho';
        $itens = proposta_itens_from_post();

        if ($cliente === '' || $projeto === '') {
            $error = 'Informe cliente e nome do projeto.';
        } elseif (!$itens) {
            $error = 'Adicione pelo menos um item no orçamento.';
        } else {
            $itensJson = json_encode($itens, JSON_UNESCAPED_UNICODE);
            if ($id === 0) {
                $token = bin2hex(random_bytes(16));
                $stmt = $pdo->prepare(
                    'INSERT INTO propostas (token, cliente, projeto, tipo, formato, natureza, versao, autor, resumo, escopo, objetivo, premissas, moeda, itens, status)
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
                );
                $stmt->execute([$token, $cliente, $projeto, $tipo, $formato, $natureza, $versao, $autor, $resumo, $escopo, $objetivo, $premissas, $moeda, $itensJson, $status]);
            } else {
                $stmt = $pdo->prepare(
                    'UPDATE propostas SET cliente=?, projeto=?, tipo=?, formato=?, natureza=?, versao=?, autor=?, resumo=?, escopo=?, objetivo=?, premissas=?, moeda=?, itens=?, status=? WHERE id=?'
                );
                $stmt->execute([$cliente, $projeto, $tipo, $formato, $natureza, $versao, $autor, $resumo, $escopo, $objetivo, $premissas, $moeda, $itensJson, $status, $id]);
            }
            header('Location: /admin/propostas.php?msg=' . urlencode('Proposta salva com sucesso.'));
            exit;
        }
    }
}

$editId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$editRow = null;
if ($editId > 0) {
    $stmt = $pdo->prepare('SELECT * FROM propostas WHERE id = ?');
    $stmt->execute([$editId]);
    $editRow = $stmt->fetch();
    if ($editRow) {
        $editRow['itens'] = json_decode($editRow['itens'], true) ?: [];
    }
}

if (isset($_GET['msg']) && !$error) {
    $success = $_GET['msg'];
}

$propostas = $pdo->query('SELECT * FROM propostas ORDER BY created_at DESC')->fetchAll();

$statusLabels = ['rascunho' => 'Rascunho', 'enviada' => 'Enviada', 'aprovada' => 'Aprovada', 'recusada' => 'Recusada'];

admin_head('Propostas');
admin_topbar('propostas');
?>
<main class="admin-main">
  <div class="admin-head"><h1>Propostas comerciais</h1></div>

  <?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES) ?></div><?php endif; ?>
  <?php if ($success): ?><div class="alert alert-success"><?= htmlspecialchars($success, ENT_QUOTES) ?></div><?php endif; ?>

  <div class="form-card" style="max-width:760px;">
    <h2><?= $editRow ? 'Editar proposta' : 'Nova proposta' ?></h2>
    <form method="post" novalidate>
      <?= csrf_field() ?>
      <input type="hidden" name="action" value="save">
      <input type="hidden" name="id" value="<?= (int)($editRow['id'] ?? 0) ?>">

      <div class="field-row">
        <div class="field">
          <label for="cliente">Cliente *</label>
          <input type="text" id="cliente" name="cliente" required value="<?= htmlspecialchars($editRow['cliente'] ?? '', ENT_QUOTES) ?>">
        </div>
        <div class="field">
          <label for="projeto">Nome do projeto *</label>
          <input type="text" id="projeto" name="projeto" required value="<?= htmlspecialchars($editRow['projeto'] ?? '', ENT_QUOTES) ?>">
        </div>
      </div>

      <div class="field-row">
        <div class="field">
          <label for="tipo">Tipo</label>
          <select id="tipo" name="tipo">
            <option value="novo" <?= (($editRow['tipo'] ?? 'novo') === 'novo') ? 'selected' : '' ?>>Novo</option>
            <option value="alteracao" <?= (($editRow['tipo'] ?? '') === 'alteracao') ? 'selected' : '' ?>>Alteração</option>
          </select>
        </div>
        <div class="field">
          <label for="natureza">Natureza</label>
          <select id="natureza" name="natureza">
            <option value="orcamento" <?= (($editRow['natureza'] ?? 'orcamento') === 'orcamento') ? 'selected' : '' ?>>Orçamento</option>
            <option value="desenvolvimento" <?= (($editRow['natureza'] ?? '') === 'desenvolvimento') ? 'selected' : '' ?>>Desenvolvimento</option>
          </select>
        </div>
      </div>

      <div class="field-row">
        <div class="field">
          <label for="formato">Formato / tecnologia</label>
          <input type="text" id="formato" name="formato" placeholder="Ex.: Excel, Power BI, Python" value="<?= htmlspecialchars($editRow['formato'] ?? '', ENT_QUOTES) ?>">
        </div>
        <div class="field">
          <label for="moeda">Moeda</label>
          <select id="moeda" name="moeda">
            <?php foreach (['USD', 'BRL', 'EUR', 'AOA'] as $m): ?>
              <option value="<?= $m ?>" <?= (($editRow['moeda'] ?? 'USD') === $m) ? 'selected' : '' ?>><?= $m ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="field-row">
        <div class="field">
          <label for="versao">Versão</label>
          <input type="text" id="versao" name="versao" value="<?= htmlspecialchars($editRow['versao'] ?? '1', ENT_QUOTES) ?>">
        </div>
        <div class="field">
          <label for="autor">Autor</label>
          <input type="text" id="autor" name="autor" value="<?= htmlspecialchars($editRow['autor'] ?? 'Clariston Santos', ENT_QUOTES) ?>">
        </div>
      </div>

      <div class="field">
        <label for="resumo">Resumo (linha de destaque, opcional)</label>
        <input type="text" id="resumo" name="resumo" placeholder="Ex.: Escopo pesquisa de preços" value="<?= htmlspecialchars($editRow['resumo'] ?? '', ENT_QUOTES) ?>">
      </div>
      <div class="field">
        <label for="escopo">Escopo</label>
        <textarea id="escopo" name="escopo" rows="3"><?= htmlspecialchars($editRow['escopo'] ?? '', ENT_QUOTES) ?></textarea>
      </div>
      <div class="field">
        <label for="objetivo">Objetivo</label>
        <textarea id="objetivo" name="objetivo" rows="2"><?= htmlspecialchars($editRow['objetivo'] ?? '', ENT_QUOTES) ?></textarea>
      </div>
      <div class="field">
        <label for="premissas">Premissas (uma por linha)</label>
        <textarea id="premissas" name="premissas" rows="3" placeholder="Banco de dados contendo as informações e diretrizes"><?= htmlspecialchars($editRow['premissas'] ?? '', ENT_QUOTES) ?></textarea>
      </div>

      <div class="field">
        <label>Itens do orçamento</label>
        <div class="table-wrap" style="margin-bottom:0.75rem;">
          <table class="data-table" id="itensTable">
            <thead><tr><th>Descrição</th><th style="width:110px">Horas</th><th style="width:130px">Valor/hora</th><th style="width:44px"></th></tr></thead>
            <tbody>
              <?php
              $itensIniciais = $editRow['itens'] ?? [['descricao' => '', 'horas' => '', 'valor_hora' => '']];
              if (!$itensIniciais) $itensIniciais = [['descricao' => '', 'horas' => '', 'valor_hora' => '']];
              foreach ($itensIniciais as $item): ?>
                <tr>
                  <td><input type="text" name="item_desc[]" value="<?= htmlspecialchars((string)($item['descricao'] ?? ''), ENT_QUOTES) ?>" placeholder="Ex.: ETL - tratamento dos dados"></td>
                  <td><input type="text" name="item_horas[]" value="<?= htmlspecialchars((string)($item['horas'] ?? ''), ENT_QUOTES) ?>" inputmode="decimal"></td>
                  <td><input type="text" name="item_valor[]" value="<?= htmlspecialchars((string)($item['valor_hora'] ?? ''), ENT_QUOTES) ?>" inputmode="decimal"></td>
                  <td><button type="button" class="danger" onclick="this.closest('tr').remove()">×</button></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <button type="button" class="btn btn-ghost on-light" id="addItemBtn">+ adicionar item</button>
      </div>

      <div class="field" style="margin-top:1rem;">
        <label for="status">Status</label>
        <select id="status" name="status">
          <?php foreach ($statusLabels as $val => $label): ?>
            <option value="<?= $val ?>" <?= (($editRow['status'] ?? 'rascunho') === $val) ? 'selected' : '' ?>><?= $label ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $editRow ? 'Salvar alterações' : 'Criar proposta' ?></button>
        <?php if ($editRow): ?><a class="btn btn-ghost on-light" href="/admin/propostas.php">Cancelar</a><?php endif; ?>
      </div>
    </form>
  </div>

  <div class="table-wrap">
    <table class="data-table">
      <thead><tr><th>Cliente</th><th>Projeto</th><th>Total</th><th>Status</th><th>Criada em</th><th>Ações</th></tr></thead>
      <tbody>
        <?php if (!$propostas): ?>
          <tr class="empty-row"><td colspan="6">Nenhuma proposta cadastrada ainda.</td></tr>
        <?php endif; ?>
        <?php foreach ($propostas as $p): ?>
          <?php $itens = json_decode($p['itens'], true) ?: []; $total = proposta_total($itens); ?>
          <tr>
            <td><?= htmlspecialchars($p['cliente'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($p['projeto'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($p['moeda'], ENT_QUOTES) ?> <?= number_format($total, 2, ',', '.') ?></td>
            <td><span class="admin-status status-<?= $p['status'] === 'aprovada' ? 'success' : ($p['status'] === 'recusada' ? 'danger' : 'neutral') ?>"><?= htmlspecialchars($statusLabels[$p['status']] ?? $p['status'], ENT_QUOTES) ?></span></td>
            <td><?= date('d/m/Y', strtotime($p['created_at'])) ?></td>
            <td class="admin-table-actions">
              <a href="/admin/propostas.php?edit=<?= (int)$p['id'] ?>">Editar</a>
              <a href="/proposta.php?token=<?= htmlspecialchars($p['token'], ENT_QUOTES) ?>" target="_blank">Ver PDF</a>
              <form method="post" onsubmit="return confirm('Remover esta proposta?');" style="display:inline">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                <button type="submit" class="danger">Remover</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>
<script>
document.getElementById('addItemBtn').addEventListener('click', function () {
  var tbody = document.querySelector('#itensTable tbody');
  var tr = document.createElement('tr');
  tr.innerHTML = '<td><input type="text" name="item_desc[]" placeholder="Ex.: ETL - tratamento dos dados"></td>'
    + '<td><input type="text" name="item_horas[]" inputmode="decimal"></td>'
    + '<td><input type="text" name="item_valor[]" inputmode="decimal"></td>'
    + '<td><button type="button" class="danger" onclick="this.closest(\'tr\').remove()">×</button></td>';
  tbody.appendChild(tr);
});
</script>
<?php admin_foot(); ?>
