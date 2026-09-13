<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/inc/cotacao_dolar.php';

$token = (string)($_GET['token'] ?? '');
$proposta = null;
if (preg_match('/^[a-f0-9]{32}$/', $token)) {
    $stmt = db()->prepare('SELECT * FROM propostas WHERE token = ?');
    $stmt->execute([$token]);
    $proposta = $stmt->fetch();
    if ($proposta) {
        $proposta['itens'] = json_decode($proposta['itens'], true) ?: [];
    }
}

function fmt_usd(float $v): string
{
    return '$' . number_format($v, 2, ',', '.') . ' USD';
}

function fmt_brl(float $v): string
{
    return 'R$ ' . number_format($v, 2, ',', '.');
}

$total = 0.0;
$cotacao = ['valor' => 0.0, 'data' => null];
if ($proposta) {
    foreach ($proposta['itens'] as $item) {
        $total += ((float)($item['horas'] ?? 0)) * ((float)($item['valor_hora'] ?? 0));
    }
    $cotacao = cotacao_dolar_bcb(db());
}
$temCotacao = $cotacao['valor'] > 0;
$totalBRL = $total * $cotacao['valor'];
$premissasList = $proposta ? array_values(array_filter(array_map('trim', explode("\n", (string)$proposta['premissas'])))) : [];
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="robots" content="noindex, nofollow" />
<link rel="icon" type="image/png" href="/assets/img/favicon-32.png" />
<title><?= $proposta ? 'Proposta Comercial — ' . htmlspecialchars($proposta['cliente'], ENT_QUOTES) : 'Proposta não encontrada' ?> — TECH SANTOS BR</title>
<style>
  :root { --line:#B9BCC2; --head-bg:#D9D9D9; --green:#4E9F3E; --ink:#1B1F27; --ink-soft:#5A6270; }
  * { box-sizing: border-box; }
  body { margin:0; font-family:'Segoe UI', Arial, sans-serif; color:var(--ink); background:#EEF0F2; }
  .doc-actions { max-width:860px; margin:0 auto; padding:1rem 1rem 0; display:flex; justify-content:space-between; align-items:center; }
  .doc-actions a { color:var(--ink-soft); font-size:0.85rem; text-decoration:none; }
  .doc-actions button { min-height:42px; padding:0 1.1rem; border:0; border-radius:6px; background:var(--green); color:#fff; font-weight:700; font-size:0.88rem; cursor:pointer; }
  .sheet { max-width:860px; margin:1rem auto 3rem; background:#fff; padding:2rem 2.2rem 0; box-shadow:0 1px 2px rgba(0,0,0,.06), 0 20px 40px -20px rgba(0,0,0,.25); }
  .sheet-header { display:flex; align-items:center; gap:1rem; border-bottom:3px solid var(--head-bg); padding-bottom:1rem; margin-bottom:1.4rem; }
  .sheet-header img { width:52px; height:41px; object-fit:contain; }
  .sheet-header h1 { flex:1; margin:0; font-size:1.7rem; font-weight:600; color:var(--ink); }
  .page-badge { background:var(--head-bg); color:#666; font-size:0.75rem; padding:0.25rem 0.9rem; border-radius:2px; }
  table.meta { width:100%; border-collapse:collapse; margin-bottom:1.1rem; }
  table.meta th, table.meta td { border:1px solid var(--line); padding:0.5rem 0.7rem; font-size:0.85rem; text-align:left; }
  table.meta th { background:var(--head-bg); font-weight:700; width:16%; }
  .box { border:1px solid var(--line); margin-bottom:1.1rem; }
  .box-head { background:var(--head-bg); font-weight:700; font-size:0.9rem; padding:0.45rem 0.8rem; }
  .box-body { padding:0.9rem 1rem; font-size:0.88rem; line-height:1.55; }
  .box-body p { margin:0 0 0.6rem; }
  .box-body p:last-child { margin-bottom:0; }
  .ctx-grid { display:grid; grid-template-columns:1.4fr 1fr; }
  .ctx-grid .box-body { border-right:1px solid var(--line); }
  .ctx-check { padding:0.9rem 1rem; font-size:0.88rem; line-height:1.9; }
  .ctx-check .opt { display:block; }
  .ctx-check .opt strong { font-weight:700; }
  .resumo-line { text-align:center; font-weight:600; margin-bottom:0.7rem; }
  .premissas-body ol { margin:0; padding-left:1.3rem; }
  .premissas-body li { font-weight:700; margin-bottom:0.4rem; }
  table.orc { width:100%; border-collapse:collapse; }
  table.orc th, table.orc td { border:1px solid var(--line); padding:0.55rem 0.75rem; font-size:0.85rem; text-align:left; }
  table.orc th { background:#F1F2F4; font-weight:700; }
  .total-bar { display:flex; justify-content:space-between; background:var(--head-bg); font-weight:700; padding:0.6rem 0.9rem; margin-bottom:1.6rem; }
  .sheet-footer { border-top:1px solid var(--line); padding:0.9rem 0; text-align:center; }
  .sheet-footer .bar { background:#0F2440; color:#fff; font-weight:700; font-size:0.82rem; padding:0.5rem; letter-spacing:0.02em; }
  .sheet-footer .addr { font-size:0.72rem; color:var(--ink-soft); margin-top:0.5rem; }
  .not-found { max-width:640px; margin:4rem auto; text-align:center; font-family:'Segoe UI',Arial,sans-serif; }
  @media print {
    body { background:#fff; }
    .doc-actions { display:none; }
    .sheet { box-shadow:none; margin:0; max-width:none; padding:0 1cm; }
  }
</style>
</head>
<body>
<?php if ($proposta): ?>
  <div class="doc-actions">
    <a href="/admin/propostas.php">← Painel administrativo</a>
    <button onclick="window.print()">Baixar / Imprimir PDF</button>
  </div>
  <div class="sheet">
    <div class="sheet-header">
      <img src="/assets/img/logo.jpg" alt="Tech Santos BR" />
      <h1>Proposta Comercial</h1>
      <span class="page-badge">1</span>
    </div>

    <table class="meta">
      <thead><tr><th>Data</th><th>Versão</th><th>Descrição</th><th>Autor</th></tr></thead>
      <tbody>
        <tr>
          <td><?= date('d/m/Y', strtotime($proposta['created_at'])) ?></td>
          <td><?= htmlspecialchars($proposta['versao'], ENT_QUOTES) ?></td>
          <td><?= htmlspecialchars($proposta['projeto'], ENT_QUOTES) ?></td>
          <td><?= htmlspecialchars($proposta['autor'], ENT_QUOTES) ?></td>
        </tr>
      </tbody>
    </table>

    <div class="box ctx-grid" style="display:grid;">
      <div class="box-head" style="grid-column:1/-1;">Contextualização</div>
      <div class="box-body">
        <p><strong>Cliente:</strong> <?= htmlspecialchars($proposta['cliente'], ENT_QUOTES) ?></p>
        <p><strong>Nome do Projeto:</strong> <?= htmlspecialchars($proposta['projeto'], ENT_QUOTES) ?></p>
      </div>
      <div class="ctx-check">
        <span class="opt">( <?= $proposta['tipo'] === 'alteracao' ? 'X' : ' ' ?> ) Alteração, ( <?= $proposta['tipo'] === 'novo' ? 'X' : ' ' ?> ) Novo</span>
        <?php if ($proposta['formato'] !== ''): ?>
          <span class="opt">( X ) <?= htmlspecialchars($proposta['formato'], ENT_QUOTES) ?></span>
        <?php endif; ?>
        <span class="opt">( <?= $proposta['natureza'] === 'desenvolvimento' ? 'X' : ' ' ?> ) Desenvolvimento, ( <?= $proposta['natureza'] === 'orcamento' ? 'X' : ' ' ?> ) Orçamento, ( <?= $proposta['natureza'] === 'suporte' ? 'X' : ' ' ?> ) Suporte</span>
      </div>
    </div>

    <?php if ($proposta['resumo'] !== '' || $proposta['escopo'] !== '' || $proposta['objetivo'] !== ''): ?>
    <div class="box">
      <div class="box-head">Descrição da Proposta</div>
      <div class="box-body">
        <?php if ($proposta['resumo'] !== ''): ?><p class="resumo-line"><?= htmlspecialchars($proposta['resumo'], ENT_QUOTES) ?></p><?php endif; ?>
        <?php if ($proposta['escopo'] !== ''): ?><p><strong>Escopo</strong><br><?= nl2br(htmlspecialchars($proposta['escopo'], ENT_QUOTES)) ?></p><?php endif; ?>
        <?php if ($proposta['objetivo'] !== ''): ?><p><strong>Objetivo:</strong> <?= nl2br(htmlspecialchars($proposta['objetivo'], ENT_QUOTES)) ?></p><?php endif; ?>
      </div>
    </div>
    <?php endif; ?>

    <?php if ($premissasList): ?>
    <div class="box">
      <div class="box-head">Premissas</div>
      <div class="box-body premissas-body">
        <ol>
          <?php foreach ($premissasList as $p): ?><li><?= htmlspecialchars($p, ENT_QUOTES) ?></li><?php endforeach; ?>
        </ol>
      </div>
    </div>
    <?php endif; ?>

    <div class="box" style="border-bottom:0;">
      <div class="box-head">Orçamento</div>
    </div>
    <table class="orc">
      <thead><tr><th>Descrição</th><th>Quantidade de Horas</th><th>Valor Hora</th><th>Total (US$)</th><?php if ($temCotacao): ?><th>Total (R$)</th><?php endif; ?></tr></thead>
      <tbody>
        <?php foreach ($proposta['itens'] as $item): $itemTotal = ((float)$item['horas']) * ((float)$item['valor_hora']); ?>
          <tr>
            <td><strong><?= htmlspecialchars($item['descricao'], ENT_QUOTES) ?></strong></td>
            <td><?= htmlspecialchars((string)$item['horas'], ENT_QUOTES) ?></td>
            <td><?= fmt_usd((float)$item['valor_hora']) ?> / hora</td>
            <td><?= fmt_usd($itemTotal) ?></td>
            <?php if ($temCotacao): ?><td><?= fmt_brl($itemTotal * $cotacao['valor']) ?></td><?php endif; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div class="total-bar">
      <span>Total Geral:</span>
      <span><?= fmt_usd($total) ?><?php if ($temCotacao): ?> &nbsp;·&nbsp; <?= fmt_brl($totalBRL) ?><?php endif; ?></span>
    </div>
    <?php if ($temCotacao): ?>
      <p style="font-size:0.72rem; color:var(--ink-soft); margin:-1.2rem 0 1.6rem;">Conversão pela cotação PTAX de venda do Banco Central, referente a <?= date('d/m/Y', strtotime($cotacao['data'])) ?>: US$ 1,00 = R$ <?= number_format($cotacao['valor'], 4, ',', '.') ?>.</p>
    <?php endif; ?>

    <div class="sheet-footer">
      <div class="bar">TECH SANTOS BR – SOLUÇÕES EM BI E AULAS PARTICULARES</div>
      <p class="addr">Rua Ademar Ferrugem n° 1865 Ap 401 b, Catalão GO · Telefone: 64-992905785 · Email: claristonsantos@techsantos.com.br · www.techsantos.com.br</p>
    </div>
  </div>
<?php else: ?>
  <div class="not-found">
    <h1>Proposta não encontrada</h1>
    <p>Verifique o link recebido ou entre em contato com a TECH SANTOS BR.</p>
  </div>
<?php endif; ?>
</body>
</html>
