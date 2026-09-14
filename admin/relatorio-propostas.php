<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../inc/cotacao_dolar.php';
require_once __DIR__ . '/../inc/propostas_helpers.php';
require_admin();

$pdo = db();

$fCliente = trim((string)($_GET['f_cliente'] ?? ''));
$fStatus = trim((string)($_GET['f_status'] ?? ''));

$statusLabels = [
    'rascunho' => 'Rascunho',
    'enviada' => 'Enviada',
    'aguardando_pagamento' => 'Aguardando pagamento',
    'pago' => 'Pago',
    'aprovada' => 'Aprovada',
    'recusada' => 'Recusada',
];

$propostas = [];
if ($fCliente !== '') {
    $sql = 'SELECT * FROM propostas WHERE cliente = ?';
    $params = [$fCliente];
    if ($fStatus !== '') {
        $sql .= ' AND status = ?';
        $params[] = $fStatus;
    }
    $sql .= ' ORDER BY created_at ASC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $propostas = $stmt->fetchAll();
    foreach ($propostas as &$p) {
        $p['itens'] = json_decode($p['itens'], true) ?: [];
    }
    unset($p);
}

$temPropostaUsd = false;
foreach ($propostas as $p) {
    if ($p['moeda'] === 'USD') { $temPropostaUsd = true; break; }
}
$cotacao = $temPropostaUsd ? cotacao_dolar_bcb($pdo) : ['valor' => 0.0, 'data' => null];

function fmt_brl(float $v): string { return 'R$ ' . number_format($v, 2, ',', '.'); }

$totalGeralBRL = 0.0;
foreach ($propostas as $p) {
    $totalGeralBRL += proposta_total_em_brl(proposta_itens_total($p['itens']), $p['moeda'], $cotacao['valor']);
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="robots" content="noindex, nofollow" />
<link rel="icon" type="image/png" href="/assets/img/favicon-32.png" />
<title>Relatório de propostas<?= $fCliente !== '' ? ' — ' . htmlspecialchars($fCliente, ENT_QUOTES) : '' ?> — TECH SANTOS BR</title>
<style>
  :root { --line:#B9BCC2; --head-bg:#D9D9D9; --green:#4E9F3E; --ink:#1B1F27; --ink-soft:#5A6270; }
  * { box-sizing: border-box; }
  body { margin:0; font-family:'Segoe UI', Arial, sans-serif; color:var(--ink); background:#EEF0F2; }
  .doc-actions { max-width:900px; margin:0 auto; padding:1rem 1rem 0; display:flex; justify-content:space-between; align-items:center; }
  .doc-actions a { color:var(--ink-soft); font-size:0.85rem; text-decoration:none; }
  .doc-actions button { min-height:42px; padding:0 1.1rem; border:0; border-radius:6px; background:var(--green); color:#fff; font-weight:700; font-size:0.88rem; cursor:pointer; }
  .sheet { max-width:900px; margin:1rem auto 3rem; background:#fff; padding:2rem 2.2rem 0; box-shadow:0 1px 2px rgba(0,0,0,.06), 0 20px 40px -20px rgba(0,0,0,.25); }
  .sheet-header { display:flex; align-items:center; gap:1rem; border-bottom:3px solid var(--head-bg); padding-bottom:1rem; margin-bottom:1.4rem; }
  .sheet-header img { width:52px; height:41px; object-fit:contain; }
  .sheet-header h1 { flex:1; margin:0; font-size:1.5rem; font-weight:600; color:var(--ink); }
  .sheet-sub { color:var(--ink-soft); font-size:0.9rem; margin:-0.8rem 0 1.4rem; }
  .pedido { border:1px solid var(--line); margin-bottom:1.1rem; page-break-inside:avoid; }
  .pedido-head { display:flex; justify-content:space-between; align-items:center; gap:1rem; background:var(--head-bg); padding:0.55rem 0.9rem; font-weight:700; font-size:0.92rem; }
  .pedido-head span.status { font-weight:600; font-size:0.76rem; color:var(--ink-soft); text-transform:uppercase; letter-spacing:.03em; }
  .pedido-resumo { margin:0; padding:0.55rem 0.9rem; border-top:1px solid var(--line); font-weight:600; font-size:0.85rem; text-align:center; }
  table.itens { width:100%; border-collapse:collapse; }
  table.itens th, table.itens td { border-top:1px solid var(--line); padding:0.5rem 0.9rem; font-size:0.85rem; text-align:left; }
  table.itens th { background:#F5F6F7; font-weight:700; font-size:0.76rem; text-transform:uppercase; letter-spacing:.03em; color:var(--ink-soft); }
  table.itens tfoot td { border-top:1px solid var(--line); font-weight:700; background:#FAFAFA; }
  .total-bar { display:flex; justify-content:space-between; background:var(--head-bg); font-weight:700; padding:0.7rem 0.9rem; margin:1.4rem 0 1.6rem; font-size:1rem; }
  .pix-box { border:2px solid var(--green); border-radius:6px; padding:1rem 1.2rem; margin-bottom:1.8rem; }
  .pix-box h2 { margin:0 0 0.6rem; font-size:0.95rem; color:var(--green); }
  .pix-box p { margin:0.2rem 0; font-size:0.88rem; }
  .pix-box .chave { font-family:'Consolas', monospace; font-size:1.05rem; font-weight:700; letter-spacing:.03em; }
  .sheet-footer { border-top:1px solid var(--line); padding:0.9rem 0; text-align:center; }
  .sheet-footer .bar { background:#0F2440; color:#fff; font-weight:700; font-size:0.82rem; padding:0.5rem; letter-spacing:0.02em; }
  .sheet-footer .addr { font-size:0.72rem; color:var(--ink-soft); margin-top:0.5rem; }
  .empty { text-align:center; padding:3rem 1rem; color:var(--ink-soft); }
  @media print {
    body { background:#fff; }
    .doc-actions { display:none; }
    .sheet { box-shadow:none; margin:0; max-width:none; padding:0 1cm; }
  }
</style>
</head>
<body>
  <div class="doc-actions">
    <a href="/admin/propostas.php">← Painel administrativo</a>
    <button onclick="window.print()">Baixar / Imprimir PDF</button>
  </div>
  <div class="sheet">
    <div class="sheet-header">
      <img src="/assets/img/logo.jpg" alt="Tech Santos BR" />
      <h1>Relatório de Propostas</h1>
    </div>

    <?php if ($fCliente === ''): ?>
      <div class="empty">Selecione um cliente no filtro da tela de propostas antes de gerar o relatório.</div>
    <?php elseif (!$propostas): ?>
      <div class="empty">Nenhuma proposta encontrada para <strong><?= htmlspecialchars($fCliente, ENT_QUOTES) ?></strong><?= $fStatus !== '' ? ' com status "' . htmlspecialchars($statusLabels[$fStatus] ?? $fStatus, ENT_QUOTES) . '"' : '' ?>.</div>
    <?php else: ?>
      <p class="sheet-sub">Cliente: <strong><?= htmlspecialchars($fCliente, ENT_QUOTES) ?></strong> · <?= count($propostas) ?> proposta(s)<?= $fStatus !== '' ? ' · status "' . htmlspecialchars($statusLabels[$fStatus] ?? $fStatus, ENT_QUOTES) . '"' : '' ?> · emitido em <?= date('d/m/Y') ?></p>

      <?php foreach ($propostas as $p): ?>
        <?php
        $pedidoTotal = proposta_itens_total($p['itens']);
        $pedidoUsd = $p['moeda'] === 'USD';
        $pedidoMostraConversao = $pedidoUsd && $cotacao['valor'] > 0;
        ?>
        <div class="pedido">
          <div class="pedido-head">
            <span><?= htmlspecialchars($p['projeto'], ENT_QUOTES) ?> — <?= date('d/m/Y', strtotime($p['created_at'])) ?></span>
            <span class="status"><?= htmlspecialchars($statusLabels[$p['status']] ?? $p['status'], ENT_QUOTES) ?></span>
          </div>
          <?php if (trim((string)$p['resumo']) !== ''): ?>
            <p class="pedido-resumo"><?= htmlspecialchars($p['resumo'], ENT_QUOTES) ?></p>
          <?php endif; ?>
          <table class="itens">
            <thead><tr><th>Serviço</th><th>Horas</th><th>Valor/hora</th><th>Total</th></tr></thead>
            <tbody>
              <?php foreach ($p['itens'] as $item): $itemTotal = proposta_item_total($item); ?>
                <tr>
                  <td><?= htmlspecialchars($item['descricao'], ENT_QUOTES) ?></td>
                  <td><?= htmlspecialchars((string)$item['horas'], ENT_QUOTES) ?></td>
                  <td><?= proposta_fmt_moeda((float)$item['valor_hora'], $p['moeda']) ?></td>
                  <td><?= proposta_fmt_moeda($itemTotal, $p['moeda']) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="3">Subtotal do pedido</td>
                <td><?= proposta_fmt_moeda($pedidoTotal, $p['moeda']) ?><?php if ($pedidoMostraConversao): ?><br><small><?= fmt_brl($pedidoTotal * $cotacao['valor']) ?></small><?php endif; ?></td>
              </tr>
            </tfoot>
          </table>
        </div>
      <?php endforeach; ?>

      <div class="total-bar">
        <span>Total Geral (<?= count($propostas) ?> pedido<?= count($propostas) === 1 ? '' : 's' ?>):</span>
        <span><?= fmt_brl($totalGeralBRL) ?></span>
      </div>
      <?php if ($temPropostaUsd && $cotacao['valor'] > 0): ?>
        <p style="font-size:0.72rem; color:var(--ink-soft); margin:-1.2rem 0 1.6rem;">Pedidos em dólar convertidos pela cotação PTAX de venda do Banco Central, referente a <?= date('d/m/Y', strtotime($cotacao['data'])) ?>: US$ 1,00 = R$ <?= number_format($cotacao['valor'], 4, ',', '.') ?>.</p>
      <?php endif; ?>

      <div class="pix-box">
        <h2>Dados para pagamento</h2>
        <p>Chave PIX (CNPJ): <span class="chave">41.135.509/0001-29</span></p>
        <p>CNPJ: 41.135.509/0001-29</p>
        <p>Banco: 0260 — Nu Pagamentos S.A. — Instituição de Pagamento</p>
        <p>Agência: 0001 · Conta: 49862002-8</p>
        <p>Favorecido: TECH SANTOS BR — Clariston Santos</p>
      </div>
    <?php endif; ?>

    <div class="sheet-footer">
      <div class="bar">TECH SANTOS BR – SOLUÇÕES EM BI E AULAS PARTICULARES</div>
      <p class="addr">Rua Carlos Eduardo de Souza Machado, 410 — Jardim Morumbi, Itumbiara-GO, CEP 75524-710 · Telefone: (64) 99290-5785 · Email: claristonsantos@techsantos.com.br · www.techsantos.com.br</p>
    </div>
  </div>
</body>
</html>
