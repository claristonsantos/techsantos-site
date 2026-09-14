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

    if ($action === 'set_status') {
        $id = (int)($_POST['id'] ?? 0);
        $statusValidos = ['rascunho', 'enviada', 'aguardando_pagamento', 'pago', 'aprovada', 'recusada'];
        $novoStatus = (string)($_POST['status'] ?? '');
        if (in_array($novoStatus, $statusValidos, true)) {
            $pdo->prepare('UPDATE propostas SET status = ? WHERE id = ?')->execute([$novoStatus, $id]);
        }
        header('Location: /admin/propostas.php?' . http_build_query(array_filter(['f_cliente' => $_POST['f_cliente'] ?? '', 'f_status' => $_POST['f_status'] ?? ''])) . '&msg=' . urlencode('Status atualizado.'));
        exit;
    }

    if ($action === 'save') {
        $id = (int)($_POST['id'] ?? 0);
        $cliente = trim((string)($_POST['cliente'] ?? ''));
        $projeto = trim((string)($_POST['projeto'] ?? ''));
        $tipo = ($_POST['tipo'] ?? 'novo') === 'alteracao' ? 'alteracao' : 'novo';
        $formato = trim((string)($_POST['formato'] ?? ''));
        $naturezaPost = (string)($_POST['natureza'] ?? 'orcamento');
        $natureza = in_array($naturezaPost, ['desenvolvimento', 'suporte'], true) ? $naturezaPost : 'orcamento';
        $versao = trim((string)($_POST['versao'] ?? '1')) ?: '1';
        $autor = trim((string)($_POST['autor'] ?? '')) ?: 'Clariston Santos';
        $resumo = trim((string)($_POST['resumo'] ?? ''));
        $escopo = trim((string)($_POST['escopo'] ?? ''));
        $objetivo = trim((string)($_POST['objetivo'] ?? ''));
        $premissas = trim((string)($_POST['premissas'] ?? ''));
        $moeda = 'USD'; // sempre em dólar — a conversão pra real é calculada na hora de exibir a proposta
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

$fCliente = trim((string)($_GET['f_cliente'] ?? ''));
$fStatus = trim((string)($_GET['f_status'] ?? ''));

$sql = 'SELECT * FROM propostas WHERE 1=1';
$params = [];
if ($fCliente !== '') {
    $sql .= ' AND cliente LIKE ?';
    $params[] = '%' . $fCliente . '%';
}
if ($fStatus !== '') {
    $sql .= ' AND status = ?';
    $params[] = $fStatus;
}
$sql .= ' ORDER BY created_at DESC';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$propostas = $stmt->fetchAll();

require_once __DIR__ . '/../inc/cotacao_dolar.php';
$cotacao = $pdo->query('SELECT COUNT(*) FROM propostas')->fetchColumn() > 0 ? cotacao_dolar_bcb($pdo) : ['valor' => 0.0, 'data' => null];

$statusLabels = [
    'rascunho' => 'Rascunho',
    'enviada' => 'Enviada',
    'aguardando_pagamento' => 'Aguardando pagamento',
    'pago' => 'Pago',
    'aprovada' => 'Aprovada',
    'recusada' => 'Recusada',
];
$statusTone = [
    'rascunho' => 'neutral',
    'enviada' => 'neutral',
    'aguardando_pagamento' => 'warning',
    'pago' => 'success',
    'aprovada' => 'success',
    'recusada' => 'danger',
];

$totalUsdFiltrado = 0.0;
foreach ($propostas as $p) {
    $totalUsdFiltrado += proposta_total(json_decode($p['itens'], true) ?: []);
}
$totalBrlFiltrado = $totalUsdFiltrado * $cotacao['valor'];

$clientesLista = $pdo->query('SELECT DISTINCT cliente FROM propostas ORDER BY cliente')->fetchAll(PDO::FETCH_COLUMN);

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
          <input type="text" id="cliente" name="cliente" list="clientesList" required value="<?= htmlspecialchars($editRow['cliente'] ?? '', ENT_QUOTES) ?>">
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
            <option value="suporte" <?= (($editRow['natureza'] ?? '') === 'suporte') ? 'selected' : '' ?>>Suporte</option>
          </select>
        </div>
      </div>

      <div class="field-row">
        <div class="field">
          <label for="formato">Formato / tecnologia</label>
          <input type="text" id="formato" name="formato" placeholder="Ex.: Excel, Power BI, Python" value="<?= htmlspecialchars($editRow['formato'] ?? '', ENT_QUOTES) ?>">
        </div>
        <div class="field">
          <label for="versao">Versão</label>
          <input type="text" id="versao" name="versao" value="<?= htmlspecialchars($editRow['versao'] ?? '1', ENT_QUOTES) ?>">
        </div>
      </div>

      <div class="field">
        <label for="autor">Autor</label>
        <input type="text" id="autor" name="autor" value="<?= htmlspecialchars($editRow['autor'] ?? 'Clariston Santos', ENT_QUOTES) ?>">
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
        <span class="hint">Valores sempre em dólar — a proposta converte pra real automaticamente com a cotação PTAX do Banco Central.</span>
        <div class="table-wrap" style="margin:0.5rem 0 0.75rem;">
          <table class="data-table" id="itensTable">
            <thead><tr><th>Descrição</th><th style="width:110px">Horas</th><th style="width:140px">Valor/hora (US$)</th><th style="width:44px"></th></tr></thead>
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

  <form method="get" class="admin-filter-bar" style="grid-template-columns:2fr 1fr auto;">
    <div class="field">
      <label for="f_cliente">Cliente</label>
      <input type="text" id="f_cliente" name="f_cliente" list="clientesList" placeholder="Buscar por cliente" value="<?= htmlspecialchars($fCliente, ENT_QUOTES) ?>">
      <datalist id="clientesList">
        <?php foreach ($clientesLista as $c): ?><option value="<?= htmlspecialchars($c, ENT_QUOTES) ?>"><?php endforeach; ?>
      </datalist>
    </div>
    <div class="field">
      <label for="f_status">Status</label>
      <select id="f_status" name="f_status">
        <option value="">Todos</option>
        <?php foreach ($statusLabels as $val => $label): ?>
          <option value="<?= $val ?>" <?= $fStatus === $val ? 'selected' : '' ?>><?= $label ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="admin-filter-actions">
      <button type="submit" class="btn btn-primary">Filtrar</button>
      <?php if ($fCliente !== '' || $fStatus !== ''): ?><a class="btn btn-ghost on-light" href="/admin/propostas.php">Limpar</a><?php endif; ?>
    </div>
  </form>

  <?php if ($fCliente !== ''): ?>
    <p style="margin:-0.5rem 0 1.5rem;">
      <a class="btn btn-primary" href="/admin/relatorio-propostas.php?<?= http_build_query(array_filter(['f_cliente' => $fCliente, 'f_status' => $fStatus])) ?>" target="_blank">Gerar PDF do relatório para <?= htmlspecialchars($fCliente, ENT_QUOTES) ?></a>
    </p>
  <?php endif; ?>

  <?php if ($fCliente !== '' || $fStatus !== ''): ?>
  <div class="stat-row" style="margin-bottom:1.25rem;">
    <div class="stat-tile"><div class="num"><?= count($propostas) ?></div><div class="lbl">Proposta(s) no relatório<?= $fCliente !== '' ? ' — cliente "' . htmlspecialchars($fCliente, ENT_QUOTES) . '"' : '' ?><?= $fStatus !== '' ? ' — status "' . htmlspecialchars($statusLabels[$fStatus] ?? $fStatus, ENT_QUOTES) . '"' : '' ?></div></div>
    <div class="stat-tile"><div class="num">$<?= number_format($totalUsdFiltrado, 2, ',', '.') ?></div><div class="lbl">Total em dólar</div></div>
    <div class="stat-tile"><div class="num"><?= $cotacao['valor'] > 0 ? 'R$ ' . number_format($totalBrlFiltrado, 2, ',', '.') : '—' ?></div><div class="lbl">Total convertido em real</div></div>
  </div>
  <?php endif; ?>

  <div class="table-wrap">
    <table class="data-table">
      <thead><tr><th>Cliente</th><th>Projeto</th><th>Total</th><th>Status</th><th>Criada em</th><th>Ações</th></tr></thead>
      <tbody>
        <?php if (!$propostas): ?>
          <tr class="empty-row"><td colspan="6">Nenhuma proposta encontrada.</td></tr>
        <?php endif; ?>
        <?php foreach ($propostas as $p): ?>
          <?php $itens = json_decode($p['itens'], true) ?: []; $total = proposta_total($itens); ?>
          <tr>
            <td><?= htmlspecialchars($p['cliente'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($p['projeto'], ENT_QUOTES) ?></td>
            <td>$<?= number_format($total, 2, ',', '.') ?><?php if ($cotacao['valor'] > 0): ?><br><small>R$ <?= number_format($total * $cotacao['valor'], 2, ',', '.') ?></small><?php endif; ?></td>
            <td>
              <form method="post" style="display:inline">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="set_status">
                <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                <input type="hidden" name="f_cliente" value="<?= htmlspecialchars($fCliente, ENT_QUOTES) ?>">
                <input type="hidden" name="f_status" value="<?= htmlspecialchars($fStatus, ENT_QUOTES) ?>">
                <select name="status" class="admin-status status-<?= $statusTone[$p['status']] ?? 'neutral' ?>" onchange="this.form.submit()" style="border:0; cursor:pointer;">
                  <?php foreach ($statusLabels as $val => $label): ?>
                    <option value="<?= $val ?>" <?= $p['status'] === $val ? 'selected' : '' ?>><?= $label ?></option>
                  <?php endforeach; ?>
                </select>
              </form>
            </td>
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
