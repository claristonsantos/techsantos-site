<?php
declare(strict_types=1);

require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/_partials.php';
require_admin();

$pdo = db();
$tz = new DateTimeZone('America/Sao_Paulo');
$today = new DateTimeImmutable('today', $tz);
$periodStart = $today->modify('-27 days');
$previousStart = $periodStart->modify('-28 days');
$periodEnd = $today->modify('+1 day');

function metrics_table_exists(PDO $pdo, string $table): bool
{
    $stmt = $pdo->prepare(
        'SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?'
    );
    $stmt->execute([$table]);
    return (int)$stmt->fetchColumn() > 0;
}

function metrics_count(PDO $pdo, string $sql, array $params): int
{
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return (int)$stmt->fetchColumn();
}

function metrics_money(int $cents): string
{
    return 'R$ ' . number_format($cents / 100, 2, ',', '.');
}

function metrics_delta(int $current, int $previous): string
{
    if ($previous === 0) {
        return $current === 0 ? 'sem variação' : 'novo no período';
    }

    $value = (($current - $previous) / $previous) * 100;
    return sprintf('%+.1f%% vs. período anterior', $value);
}

function metrics_origin_source(string $origin): string
{
    $parts = explode('|', strtolower($origin));
    $source = $parts[1] ?? 'direct';
    $source = preg_replace('/[^a-z0-9_-]/', '', $source) ?: 'direct';
    return $source;
}

$hasLeads = metrics_table_exists($pdo, 'whatsapp_leads');
$hasOrders = metrics_table_exists($pdo, 'pedidos');
$hasSocial = metrics_table_exists($pdo, 'social_posts');

$currentParams = [$periodStart->format('Y-m-d H:i:s'), $periodEnd->format('Y-m-d H:i:s')];
$previousParams = [$previousStart->format('Y-m-d H:i:s'), $periodStart->format('Y-m-d H:i:s')];

$leads = $hasLeads
    ? metrics_count($pdo, 'SELECT COUNT(*) FROM whatsapp_leads WHERE criado_em >= ? AND criado_em < ?', $currentParams)
    : 0;
$previousLeads = $hasLeads
    ? metrics_count($pdo, 'SELECT COUNT(*) FROM whatsapp_leads WHERE criado_em >= ? AND criado_em < ?', $previousParams)
    : 0;

$orders = $hasOrders
    ? metrics_count($pdo, 'SELECT COUNT(*) FROM pedidos WHERE criado_em >= ? AND criado_em < ?', $currentParams)
    : 0;
$previousOrders = $hasOrders
    ? metrics_count($pdo, 'SELECT COUNT(*) FROM pedidos WHERE criado_em >= ? AND criado_em < ?', $previousParams)
    : 0;
$paidOrders = $hasOrders
    ? metrics_count($pdo, "SELECT COUNT(*) FROM pedidos WHERE status = 'pago' AND criado_em >= ? AND criado_em < ?", $currentParams)
    : 0;
$previousPaidOrders = $hasOrders
    ? metrics_count($pdo, "SELECT COUNT(*) FROM pedidos WHERE status = 'pago' AND criado_em >= ? AND criado_em < ?", $previousParams)
    : 0;

$revenueCents = 0;
if ($hasOrders) {
    $stmt = $pdo->prepare(
        "SELECT COALESCE(SUM(valor_centavos), 0) FROM pedidos WHERE status = 'pago' AND criado_em >= ? AND criado_em < ?"
    );
    $stmt->execute($currentParams);
    $revenueCents = (int)$stmt->fetchColumn();
}

$publishedPosts = $hasSocial
    ? metrics_count($pdo, "SELECT COUNT(*) FROM social_posts WHERE status = 'publicado' AND agendado_para >= ? AND agendado_para < ?", $currentParams)
    : 0;
$scheduledPosts = $hasSocial
    ? metrics_count($pdo, "SELECT COUNT(*) FROM social_posts WHERE status IN ('pendente','processando','agendado_meta') AND agendado_para >= NOW()", [])
    : 0;
$failedPosts = $hasSocial
    ? metrics_count($pdo, "SELECT COUNT(*) FROM social_posts WHERE status = 'erro' AND agendado_para >= ? AND agendado_para < ?", $currentParams)
    : 0;

$leadToSaleRate = $leads > 0 ? ($paidOrders / $leads) * 100 : 0.0;

$daily = [];
for ($offset = 0; $offset < 28; $offset++) {
    $date = $periodStart->modify("+{$offset} days")->format('Y-m-d');
    $daily[$date] = ['leads' => 0, 'sales' => 0];
}

if ($hasLeads) {
    $stmt = $pdo->prepare(
        'SELECT DATE(criado_em) AS dia, COUNT(*) AS total FROM whatsapp_leads WHERE criado_em >= ? AND criado_em < ? GROUP BY DATE(criado_em)'
    );
    $stmt->execute($currentParams);
    foreach ($stmt->fetchAll() as $row) {
        if (isset($daily[$row['dia']])) {
            $daily[$row['dia']]['leads'] = (int)$row['total'];
        }
    }
}

if ($hasOrders) {
    $stmt = $pdo->prepare(
        "SELECT DATE(criado_em) AS dia, COUNT(*) AS total FROM pedidos WHERE status = 'pago' AND criado_em >= ? AND criado_em < ? GROUP BY DATE(criado_em)"
    );
    $stmt->execute($currentParams);
    foreach ($stmt->fetchAll() as $row) {
        if (isset($daily[$row['dia']])) {
            $daily[$row['dia']]['sales'] = (int)$row['total'];
        }
    }
}

$sourceCounts = [];
if ($hasLeads) {
    $stmt = $pdo->prepare('SELECT origem FROM whatsapp_leads WHERE criado_em >= ? AND criado_em < ?');
    $stmt->execute($currentParams);
    foreach ($stmt->fetchAll(PDO::FETCH_COLUMN) as $origin) {
        $source = metrics_origin_source((string)$origin);
        $sourceCounts[$source] = ($sourceCounts[$source] ?? 0) + 1;
    }
    arsort($sourceCounts);
}

$socialByChannel = [];
if ($hasSocial) {
    $stmt = $pdo->prepare(
        "SELECT canal, status, COUNT(*) AS total FROM social_posts WHERE agendado_para >= ? AND agendado_para < ? GROUP BY canal, status ORDER BY canal, status"
    );
    $stmt->execute($currentParams);
    foreach ($stmt->fetchAll() as $row) {
        $channel = (string)$row['canal'];
        $socialByChannel[$channel][$row['status']] = (int)$row['total'];
    }
}

$maxDaily = 1;
foreach ($daily as $values) {
    $maxDaily = max($maxDaily, $values['leads'], $values['sales']);
}

admin_head('Métricas');
admin_topbar('metricas');
?>
<style>
.metrics-note { color: var(--ink-soft); font-size: .88rem; max-width: 760px; }
.metrics-grid { display:grid; grid-template-columns:1.35fr .65fr; gap:1.25rem; margin-bottom:2rem; }
.metrics-card { background:var(--surface); border:1px solid var(--line); border-radius:6px; padding:1.25rem; }
.metrics-card h2 { font-size:1.05rem; margin-bottom:.25rem; }
.metrics-card .sub { color:var(--ink-faint); font-size:.8rem; margin-bottom:1rem; }
.metrics-delta { color:var(--ink-faint); font-size:.72rem; margin-top:.35rem; }
.metrics-bars { height:190px; display:flex; align-items:flex-end; gap:4px; padding-top:1rem; border-bottom:1px solid var(--line); }
.metrics-day { flex:1; min-width:4px; height:100%; display:flex; align-items:flex-end; justify-content:center; gap:1px; }
.metrics-bar { width:42%; min-height:2px; border-radius:2px 2px 0 0; }
.metrics-bar.lead { background:var(--green); }
.metrics-bar.sale { background:#14345c; }
.metrics-legend { display:flex; gap:1rem; margin-top:.75rem; color:var(--ink-soft); font-size:.78rem; }
.metrics-legend i { width:9px; height:9px; display:inline-block; margin-right:.3rem; border-radius:2px; }
.metrics-source { display:flex; align-items:center; gap:.65rem; margin:.65rem 0; }
.metrics-source-name { width:90px; font-size:.82rem; }
.metrics-source-track { flex:1; height:8px; background:var(--surface-2); border-radius:8px; overflow:hidden; }
.metrics-source-track span { display:block; height:100%; background:var(--green); }
.metrics-source-value { width:28px; text-align:right; font-family:'Plex Mono', monospace; font-size:.78rem; }
.metrics-actions { margin-top:1rem; display:flex; gap:.75rem; flex-wrap:wrap; }
.metrics-warning { padding:.85rem 1rem; background:#fff8e8; border:1px solid #ead6a4; border-radius:5px; color:#725818; font-size:.82rem; margin-bottom:1.5rem; }
@media (max-width:760px) { .metrics-grid { grid-template-columns:1fr; } .metrics-bars { height:150px; gap:2px; } }
</style>
<main class="admin-main">
  <div class="admin-head">
    <div>
      <h1>Métricas de marketing</h1>
      <p class="metrics-note">Dados próprios dos últimos 28 dias, de <?= $periodStart->format('d/m/Y') ?> a <?= $today->format('d/m/Y') ?>.</p>
    </div>
  </div>

  <?php if (!$hasLeads || !$hasOrders || !$hasSocial): ?>
    <div class="metrics-warning">Parte das tabelas de dados ainda não está disponível. Execute as migrações pendentes antes de usar este painel como referência completa.</div>
  <?php endif; ?>

  <div class="stat-row">
    <div class="stat-tile">
      <div class="num"><?= $leads ?></div>
      <div class="lbl">Leads das aulas grátis</div>
      <div class="metrics-delta"><?= htmlspecialchars(metrics_delta($leads, $previousLeads), ENT_QUOTES) ?></div>
    </div>
    <div class="stat-tile">
      <div class="num"><?= $orders ?></div>
      <div class="lbl">Checkouts iniciados</div>
      <div class="metrics-delta"><?= htmlspecialchars(metrics_delta($orders, $previousOrders), ENT_QUOTES) ?></div>
    </div>
    <div class="stat-tile">
      <div class="num"><?= $paidOrders ?></div>
      <div class="lbl">Compras aprovadas</div>
      <div class="metrics-delta"><?= htmlspecialchars(metrics_delta($paidOrders, $previousPaidOrders), ENT_QUOTES) ?></div>
    </div>
  </div>

  <div class="stat-row">
    <div class="stat-tile"><div class="num"><?= metrics_money($revenueCents) ?></div><div class="lbl">Receita aprovada no período</div></div>
    <div class="stat-tile"><div class="num"><?= number_format($leadToSaleRate, 1, ',', '.') ?>%</div><div class="lbl">Relação direcional entre leads e vendas</div></div>
    <div class="stat-tile"><div class="num"><?= $publishedPosts ?></div><div class="lbl">Publicações concluídas</div><div class="metrics-delta"><?= $scheduledPosts ?> futuras · <?= $failedPosts ?> com erro</div></div>
  </div>

  <div class="metrics-warning">A relação entre leads e vendas é apenas direcional: os pedidos ainda não armazenam a mesma UTM do lead. Não use esse percentual como atribuição por canal.</div>

  <div class="metrics-grid">
    <section class="metrics-card">
      <h2>Leads e vendas por dia</h2>
      <p class="sub">Verde: leads captados · Azul: compras aprovadas</p>
      <div class="metrics-bars" aria-label="Gráfico diário de leads e vendas">
        <?php foreach ($daily as $date => $values): ?>
          <?php
            $leadHeight = max(2, (int)round(($values['leads'] / $maxDaily) * 100));
            $saleHeight = max(2, (int)round(($values['sales'] / $maxDaily) * 100));
            $title = (new DateTimeImmutable($date, $tz))->format('d/m') . ": {$values['leads']} leads, {$values['sales']} vendas";
          ?>
          <div class="metrics-day" title="<?= htmlspecialchars($title, ENT_QUOTES) ?>">
            <span class="metrics-bar lead" style="height:<?= $leadHeight ?>%"></span>
            <span class="metrics-bar sale" style="height:<?= $saleHeight ?>%"></span>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="metrics-legend"><span><i style="background:var(--green)"></i>Leads</span><span><i style="background:#14345c"></i>Vendas</span></div>
    </section>

    <section class="metrics-card">
      <h2>Origem dos leads</h2>
      <p class="sub">Fonte registrada pela UTM na prévia gratuita</p>
      <?php if (!$sourceCounts): ?>
        <p class="metrics-note">Nenhum lead com origem registrado no período.</p>
      <?php else: ?>
        <?php $maxSource = max($sourceCounts); ?>
        <?php foreach ($sourceCounts as $source => $count): ?>
          <div class="metrics-source">
            <span class="metrics-source-name"><?= htmlspecialchars($source, ENT_QUOTES) ?></span>
            <span class="metrics-source-track"><span style="width:<?= max(4, (int)round(($count / $maxSource) * 100)) ?>%"></span></span>
            <span class="metrics-source-value"><?= $count ?></span>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </section>
  </div>

  <section class="metrics-card" style="margin-bottom:2rem">
    <h2>Operação das redes sociais</h2>
    <p class="sub">Situação dos conteúdos agendados no sistema interno durante o período.</p>
    <div class="table-wrap" style="margin-bottom:0">
      <table class="data-table">
        <thead><tr><th>Canal</th><th>Publicados</th><th>Agendados</th><th>Pendentes</th><th>Erros</th></tr></thead>
        <tbody>
          <?php if (!$socialByChannel): ?>
            <tr class="empty-row"><td colspan="5">Nenhuma publicação registrada no período.</td></tr>
          <?php else: ?>
            <?php foreach ($socialByChannel as $channel => $statuses): ?>
              <tr>
                <td><?= htmlspecialchars(ucfirst($channel), ENT_QUOTES) ?></td>
                <td><?= (int)($statuses['publicado'] ?? 0) ?></td>
                <td><?= (int)($statuses['agendado_meta'] ?? 0) ?></td>
                <td><?= (int)(($statuses['pendente'] ?? 0) + ($statuses['processando'] ?? 0)) ?></td>
                <td><?= (int)($statuses['erro'] ?? 0) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </section>

  <section class="metrics-card">
    <h2>Métricas externas a revisar semanalmente</h2>
    <p class="sub">Alcance, retenção, salvamentos e cliques não são armazenados no banco do site.</p>
    <div class="metrics-actions">
      <a class="btn btn-primary" href="https://analytics.google.com/" target="_blank" rel="noopener">Abrir Google Analytics</a>
      <a class="btn btn-ghost on-light" href="https://app.metricool.com/" target="_blank" rel="noopener">Abrir Metricool</a>
      <a class="btn btn-ghost on-light" href="/admin/social_posts.php">Ver publicações</a>
      <a class="btn btn-ghost on-light" href="/admin/pedidos.php">Ver pedidos</a>
    </div>
  </section>
</main>
<?php admin_foot(); ?>
