<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/_partials.php';
require_once __DIR__ . '/../inc/propostas_helpers.php';
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
        $contatoNome = trim((string)($_POST['contato_nome'] ?? ''));
        $contatoDocumento = trim((string)($_POST['contato_documento'] ?? ''));
        $contatoEmail = trim((string)($_POST['contato_email'] ?? ''));
        $projeto = trim((string)($_POST['projeto'] ?? ''));
        $tipo = ($_POST['tipo'] ?? 'novo') === 'alteracao' ? 'alteracao' : 'novo';
        $formato = trim((string)($_POST['formato'] ?? ''));
        $naturezaPost = (string)($_POST['natureza'] ?? 'orcamento');
        $natureza = in_array($naturezaPost, ['desenvolvimento', 'suporte', 'curso', 'aulas'], true) ? $naturezaPost : 'orcamento';
        $versao = trim((string)($_POST['versao'] ?? '1')) ?: '1';
        $autor = trim((string)($_POST['autor'] ?? '')) ?: 'Clariston Santos';
        $resumo = trim((string)($_POST['resumo'] ?? ''));
        $escopo = trim((string)($_POST['escopo'] ?? ''));
        $objetivo = trim((string)($_POST['objetivo'] ?? ''));
        $premissas = trim((string)($_POST['premissas'] ?? ''));
        $moedaPost = (string)($_POST['moeda'] ?? 'USD');
        $moeda = $moedaPost === 'BRL' ? 'BRL' : 'USD';
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
                    'INSERT INTO propostas (token, cliente, contato_nome, contato_documento, contato_email, projeto, tipo, formato, natureza, versao, autor, resumo, escopo, objetivo, premissas, moeda, itens, status)
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
                );
                $stmt->execute([$token, $cliente, $contatoNome ?: null, $contatoDocumento ?: null, $contatoEmail ?: null, $projeto, $tipo, $formato, $natureza, $versao, $autor, $resumo, $escopo, $objetivo, $premissas, $moeda, $itensJson, $status]);
            } else {
                $stmt = $pdo->prepare(
                    'UPDATE propostas SET cliente=?, contato_nome=?, contato_documento=?, contato_email=?, projeto=?, tipo=?, formato=?, natureza=?, versao=?, autor=?, resumo=?, escopo=?, objetivo=?, premissas=?, moeda=?, itens=?, status=? WHERE id=?'
                );
                $stmt->execute([$cliente, $contatoNome ?: null, $contatoDocumento ?: null, $contatoEmail ?: null, $projeto, $tipo, $formato, $natureza, $versao, $autor, $resumo, $escopo, $objetivo, $premissas, $moeda, $itensJson, $status, $id]);
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

$totalBrlFiltrado = 0.0;
foreach ($propostas as $p) {
    $nativo = proposta_itens_total(json_decode($p['itens'], true) ?: []);
    $totalBrlFiltrado += proposta_total_em_brl($nativo, $p['moeda'], $cotacao['valor']);
}

$clientesLista = $pdo->query('SELECT DISTINCT cliente FROM propostas ORDER BY cliente')->fetchAll(PDO::FETCH_COLUMN);

function admin_table_exists_propostas(PDO $pdo, string $table): bool
{
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?');
    $stmt->execute([$table]);
    return (bool)$stmt->fetchColumn();
}

$contatosAlunos = $pdo->query("SELECT nome, email, cpf AS documento FROM alunos WHERE nome != '' ORDER BY nome")->fetchAll();
$contatosAulas = admin_table_exists_propostas($pdo, 'aulas_particulares_leads')
    ? $pdo->query("SELECT DISTINCT nome, email, '' AS documento FROM aulas_particulares_leads WHERE nome != '' ORDER BY nome")->fetchAll()
    : [];

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

      <div class="field">
        <label for="contatoPicker">Preencher a partir de um cadastro existente (opcional)</label>
        <select id="contatoPicker">
          <option value="">— selecionar —</option>
          <?php if ($contatosAlunos): ?>
          <optgroup label="Alunos (cursos)">
            <?php foreach ($contatosAlunos as $c): ?>
              <option value="<?= htmlspecialchars($c['nome'], ENT_QUOTES) ?>" data-email="<?= htmlspecialchars($c['email'] ?? '', ENT_QUOTES) ?>" data-doc="<?= htmlspecialchars($c['documento'] ?? '', ENT_QUOTES) ?>"><?= htmlspecialchars($c['nome'], ENT_QUOTES) ?></option>
            <?php endforeach; ?>
          </optgroup>
          <?php endif; ?>
          <?php if ($contatosAulas): ?>
          <optgroup label="Aulas particulares">
            <?php foreach ($contatosAulas as $c): ?>
              <option value="<?= htmlspecialchars($c['nome'], ENT_QUOTES) ?>" data-email="<?= htmlspecialchars($c['email'] ?? '', ENT_QUOTES) ?>" data-doc=""><?= htmlspecialchars($c['nome'], ENT_QUOTES) ?></option>
            <?php endforeach; ?>
          </optgroup>
          <?php endif; ?>
        </select>
        <span class="hint">Preenche cliente, nome do contato e e-mail abaixo — pode editar depois.</span>
      </div>

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
          <label for="contato_nome">Nome do contato (opcional)</label>
          <input type="text" id="contato_nome" name="contato_nome" value="<?= htmlspecialchars($editRow['contato_nome'] ?? '', ENT_QUOTES) ?>">
        </div>
        <div class="field">
          <label for="contato_documento">CNPJ ou CPF (opcional)</label>
          <input type="text" id="contato_documento" name="contato_documento" placeholder="00.000.000/0000-00" value="<?= htmlspecialchars($editRow['contato_documento'] ?? '', ENT_QUOTES) ?>">
        </div>
      </div>
      <div class="field">
        <label for="contato_email">E-mail (opcional)</label>
        <input type="email" id="contato_email" name="contato_email" value="<?= htmlspecialchars($editRow['contato_email'] ?? '', ENT_QUOTES) ?>">
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
            <option value="curso" <?= (($editRow['natureza'] ?? '') === 'curso') ? 'selected' : '' ?>>Curso</option>
            <option value="aulas" <?= (($editRow['natureza'] ?? '') === 'aulas') ? 'selected' : '' ?>>Aulas particulares</option>
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
        <label for="moeda">Moeda dos valores</label>
        <select id="moeda" name="moeda">
          <option value="USD" <?= (($editRow['moeda'] ?? 'USD') === 'USD') ? 'selected' : '' ?>>Dólar (US$) — converte pra real na proposta</option>
          <option value="BRL" <?= (($editRow['moeda'] ?? '') === 'BRL') ? 'selected' : '' ?>>Real (R$) — valor já é o final, sem conversão</option>
        </select>
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
        <span class="hint">Valores na moeda escolhida acima. Em dólar, a proposta soma o equivalente em real pela cotação PTAX do Banco Central; em real, o valor sai igual, sem conversão.</span>
        <div class="table-wrap" style="margin:0.5rem 0 0.75rem;">
          <table class="data-table" id="itensTable">
            <thead><tr><th>Descrição</th><th style="width:110px">Horas</th><th style="width:140px">Valor/hora</th><th style="width:44px"></th></tr></thead>
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
    <div class="stat-tile"><div class="num">R$ <?= number_format($totalBrlFiltrado, 2, ',', '.') ?></div><div class="lbl">Total geral (dólar convertido pela cotação do dia + real)</div></div>
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
          <?php $itens = json_decode($p['itens'], true) ?: []; $total = proposta_itens_total($itens); ?>
          <tr>
            <td><?= htmlspecialchars($p['cliente'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($p['projeto'], ENT_QUOTES) ?></td>
            <td><?= proposta_fmt_moeda($total, $p['moeda']) ?><?php if ($p['moeda'] === 'USD' && $cotacao['valor'] > 0): ?><br><small>R$ <?= number_format($total * $cotacao['valor'], 2, ',', '.') ?></small><?php endif; ?></td>
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
document.getElementById('contatoPicker').addEventListener('change', function () {
  var opt = this.selectedOptions[0];
  if (!opt || !opt.value) return;
  document.getElementById('cliente').value = opt.value;
  document.getElementById('contato_nome').value = opt.value;
  document.getElementById('contato_email').value = opt.dataset.email || '';
  if (opt.dataset.doc) document.getElementById('contato_documento').value = opt.dataset.doc;
});
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
