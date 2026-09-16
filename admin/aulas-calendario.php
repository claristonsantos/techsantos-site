<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/_partials.php';
require_admin();

$pdo = db();
$hoje = date('Y-m-d');
$diasSemana = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
$mesesNomes = [1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril', 5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'];

$view = ($_GET['view'] ?? 'mes') === 'semana' ? 'semana' : 'mes';

$mesParam = (string)($_GET['mes'] ?? date('Y-m'));
if (!preg_match('/^\d{4}-\d{2}$/', $mesParam)) $mesParam = date('Y-m');
$inicioMes = DateTimeImmutable::createFromFormat('Y-m-d', $mesParam . '-01') ?: new DateTimeImmutable('first day of this month');
$fimMes = $inicioMes->modify('last day of this month');
$mesAnterior = $inicioMes->modify('-1 month')->format('Y-m');
$mesProximo = $inicioMes->modify('+1 month')->format('Y-m');

$dataParam = (string)($_GET['data'] ?? date('Y-m-d'));
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dataParam)) $dataParam = date('Y-m-d');
$diaRef = DateTimeImmutable::createFromFormat('Y-m-d', $dataParam) ?: new DateTimeImmutable();
$inicioSemana = $diaRef->modify('-' . (int)$diaRef->format('w') . ' days');
$fimSemana = $inicioSemana->modify('+6 days');
$semanaAnterior = $inicioSemana->modify('-7 days')->format('Y-m-d');
$semanaProxima = $inicioSemana->modify('+7 days')->format('Y-m-d');

$rangeInicio = $view === 'semana' ? $inicioSemana : $inicioMes;
$rangeFim = $view === 'semana' ? $fimSemana : $fimMes;

$statusLabels = ['agendado' => 'Agendado', 'pago' => 'Pago', 'realizado' => 'Realizado'];
$statusTone = ['agendado' => 'neutral', 'pago' => 'success', 'realizado' => 'success'];

$stmt = $pdo->prepare(
    "SELECT id, nome, interesse, status, data_aula, horas, link_reuniao
     FROM aulas_particulares_leads
     WHERE data_aula IS NOT NULL
       AND data_aula BETWEEN ? AND ?
       AND status IN ('agendado','pago','realizado')
     ORDER BY data_aula"
);
$stmt->execute([$rangeInicio->format('Y-m-d') . ' 00:00:00', $rangeFim->format('Y-m-d') . ' 23:59:59']);
$aulas = $stmt->fetchAll();

$socialStatusLabels = ['pendente' => 'Pendente', 'processando' => 'Processando', 'agendado_meta' => 'Agendado', 'publicado' => 'Publicado', 'erro' => 'Erro'];
$socialStatusTone = ['pendente' => 'neutral', 'processando' => 'neutral', 'agendado_meta' => 'success', 'publicado' => 'success', 'erro' => 'danger'];
$canalLabels = ['instagram' => 'IG', 'facebook' => 'FB'];
$tipoLabels = ['feed' => 'Feed', 'story' => 'Story', 'reels' => 'Reels', 'carousel' => 'Carrossel'];

$stmtSocial = $pdo->prepare(
    "SELECT id, canal, tipo, status, agendado_para, legenda
     FROM social_posts
     WHERE agendado_para IS NOT NULL
       AND agendado_para BETWEEN ? AND ?
     ORDER BY agendado_para"
);
$stmtSocial->execute([$rangeInicio->format('Y-m-d') . ' 00:00:00', $rangeFim->format('Y-m-d') . ' 23:59:59']);
$socialPosts = $stmtSocial->fetchAll();

$porDia = [];
foreach ($aulas as $a) {
    $dia = date('Y-m-d', strtotime($a['data_aula']));
    $porDia[$dia][] = ['kind' => 'aula'] + $a;
}
foreach ($socialPosts as $s) {
    $dia = date('Y-m-d', strtotime($s['agendado_para']));
    $porDia[$dia][] = ['kind' => 'social'] + $s;
}
foreach ($porDia as $dia => $eventos) {
    usort($eventos, fn($x, $y) => strcmp($x['kind'] === 'aula' ? $x['data_aula'] : $x['agendado_para'], $y['kind'] === 'aula' ? $y['data_aula'] : $y['agendado_para']));
    $porDia[$dia] = $eventos;
}

function calendario_evento(array $ev, array $statusTone, array $statusLabels, array $socialStatusTone, array $socialStatusLabels, array $canalLabels, array $tipoLabels, int $resumoLen): void
{
    if ($ev['kind'] === 'aula') {
        ?>
        <a class="calendar-event kind-aula status-<?= $statusTone[$ev['status']] ?? 'neutral' ?>" href="/admin/aulas_particulares.php?editar=<?= (int)$ev['id'] ?>">
          <strong><?= date('H:i', strtotime($ev['data_aula'])) ?></strong> <?= htmlspecialchars($ev['nome'], ENT_QUOTES) ?>
          <small><?= htmlspecialchars($ev['interesse'], ENT_QUOTES) ?> · <?= htmlspecialchars($statusLabels[$ev['status']] ?? $ev['status'], ENT_QUOTES) ?></small>
        </a>
        <?php
    } else {
        ?>
        <a class="calendar-event kind-social status-<?= $socialStatusTone[$ev['status']] ?? 'neutral' ?>" href="/admin/social_posts.php?edit=<?= (int)$ev['id'] ?>">
          <strong><?= date('H:i', strtotime($ev['agendado_para'])) ?></strong> <?= htmlspecialchars($canalLabels[$ev['canal']] ?? $ev['canal'], ENT_QUOTES) ?> · <?= htmlspecialchars($tipoLabels[$ev['tipo']] ?? $ev['tipo'], ENT_QUOTES) ?>
          <small><?= htmlspecialchars(mb_strimwidth(trim((string)$ev['legenda']), 0, $resumoLen, '…'), ENT_QUOTES) ?> · <?= htmlspecialchars($socialStatusLabels[$ev['status']] ?? $ev['status'], ENT_QUOTES) ?></small>
        </a>
        <?php
    }
}

admin_head('Calendário');
admin_topbar('aulas_calendario');
?>
<main class="admin-main">
  <div class="admin-head">
    <h1>Calendário</h1>
    <div class="admin-head-actions">
      <div class="view-toggle">
        <a class="view-toggle-btn<?= $view === 'mes' ? ' is-active' : '' ?>" href="?view=mes&mes=<?= $inicioMes->format('Y-m') ?>">Mês</a>
        <a class="view-toggle-btn<?= $view === 'semana' ? ' is-active' : '' ?>" href="?view=semana&data=<?= $hoje ?>">Semana</a>
      </div>
      <?php if ($view === 'mes'): ?>
        <a class="btn btn-ghost on-light" href="?view=mes&mes=<?= $mesAnterior ?>">← Mês anterior</a>
        <a class="btn btn-ghost on-light" href="?view=mes&mes=<?= date('Y-m') ?>">Hoje</a>
        <a class="btn btn-ghost on-light" href="?view=mes&mes=<?= $mesProximo ?>">Próximo mês →</a>
      <?php else: ?>
        <a class="btn btn-ghost on-light" href="?view=semana&data=<?= $semanaAnterior ?>">← Semana anterior</a>
        <a class="btn btn-ghost on-light" href="?view=semana&data=<?= $hoje ?>">Hoje</a>
        <a class="btn btn-ghost on-light" href="?view=semana&data=<?= $semanaProxima ?>">Próxima semana →</a>
      <?php endif; ?>
    </div>
  </div>
  <h2 style="margin-bottom:.5rem;">
    <?php if ($view === 'mes'): ?>
      <?= $mesesNomes[(int)$inicioMes->format('n')] ?> de <?= $inicioMes->format('Y') ?>
    <?php else: ?>
      <?= $inicioSemana->format('d') ?> a <?= $fimSemana->format('d') ?> de <?= $mesesNomes[(int)$fimSemana->format('n')] ?> de <?= $fimSemana->format('Y') ?>
    <?php endif; ?>
    · <?= count($aulas) ?> aula(s) · <?= count($socialPosts) ?> post(s)
  </h2>
  <p style="margin-bottom:1rem;font-size:.78rem;color:var(--ink-faint);">
    <span class="legend-dot dot-aula"></span> Aula particular &nbsp;
    <span class="legend-dot dot-social"></span> Post em mídia social
  </p>

  <?php if ($view === 'mes'):
    $primeiroDiaSemana = (int)$inicioMes->format('w');
    $totalDias = (int)$fimMes->format('j');
  ?>
  <div class="calendar-grid">
    <?php foreach ($diasSemana as $dw): ?><div class="calendar-dow"><?= $dw ?></div><?php endforeach; ?>
    <?php for ($i = 0; $i < $primeiroDiaSemana; $i++): ?><div class="calendar-cell is-empty"></div><?php endfor; ?>
    <?php for ($dia = 1; $dia <= $totalDias; $dia++): ?>
      <?php $dataStr = $inicioMes->format('Y-m-') . str_pad((string)$dia, 2, '0', STR_PAD_LEFT); $eventos = $porDia[$dataStr] ?? []; ?>
      <div class="calendar-cell<?= $dataStr === $hoje ? ' is-today' : '' ?>">
        <span class="calendar-daynum"><?= $dia ?></span>
        <?php foreach ($eventos as $ev) calendario_evento($ev, $statusTone, $statusLabels, $socialStatusTone, $socialStatusLabels, $canalLabels, $tipoLabels, 38); ?>
      </div>
    <?php endfor; ?>
  </div>
  <?php else: ?>
  <div class="calendar-grid calendar-grid-week">
    <?php for ($i = 0; $i < 7; $i++):
      $diaCursor = $inicioSemana->modify("+{$i} days");
      $dataStr = $diaCursor->format('Y-m-d');
      $eventos = $porDia[$dataStr] ?? [];
    ?>
      <div class="calendar-dow calendar-dow-week<?= $dataStr === $hoje ? ' is-today' : '' ?>"><?= $diasSemana[$i] ?><span><?= $diaCursor->format('d/m') ?></span></div>
    <?php endfor; ?>
    <?php for ($i = 0; $i < 7; $i++):
      $diaCursor = $inicioSemana->modify("+{$i} days");
      $dataStr = $diaCursor->format('Y-m-d');
      $eventos = $porDia[$dataStr] ?? [];
    ?>
      <div class="calendar-cell calendar-cell-week<?= $dataStr === $hoje ? ' is-today' : '' ?>">
        <?php if (!$eventos): ?><span class="calendar-cell-empty">—</span><?php endif; ?>
        <?php foreach ($eventos as $ev) calendario_evento($ev, $statusTone, $statusLabels, $socialStatusTone, $socialStatusLabels, $canalLabels, $tipoLabels, 80); ?>
      </div>
    <?php endfor; ?>
  </div>
  <?php endif; ?>
</main>
<style>
  .view-toggle { display:inline-flex; border:1px solid var(--line); border-radius:7px; overflow:hidden; margin-right:.5rem; }
  .view-toggle-btn { padding:.5rem .9rem; font-size:.78rem; font-weight:600; text-decoration:none; color:var(--ink-soft); background:var(--surface); }
  .view-toggle-btn.is-active { background:var(--green); color:#0f2440; }
  .calendar-grid { display:grid; grid-template-columns:repeat(7,1fr); gap:1px; background:var(--line); border:1px solid var(--line); border-radius:7px; overflow:hidden; }
  .calendar-dow { background:var(--surface-2); padding:.5rem; text-align:center; font:600 .68rem 'Plex Mono',monospace; text-transform:uppercase; letter-spacing:.06em; color:var(--ink-faint); }
  .calendar-dow-week { display:flex; flex-direction:column; gap:.15rem; }
  .calendar-dow-week span { font-size:.72rem; color:var(--ink-soft); letter-spacing:0; }
  .calendar-dow-week.is-today { box-shadow:inset 0 0 0 2px var(--green); }
  .calendar-cell { background:var(--surface); min-height:104px; padding:.4rem; display:flex; flex-direction:column; gap:.25rem; }
  .calendar-cell.is-empty { background:var(--surface-2); }
  .calendar-cell.is-today { box-shadow:inset 0 0 0 2px var(--green); }
  .calendar-cell-week { min-height:420px; gap:.4rem; }
  .calendar-cell-empty { color:var(--ink-faint); font-size:.78rem; text-align:center; margin-top:1rem; }
  .calendar-daynum { font:600 .78rem 'Plex Mono',monospace; color:var(--ink-faint); }
  .calendar-event { display:flex; flex-direction:column; padding:.3rem .4rem; border-radius:5px; font-size:.72rem; line-height:1.3; text-decoration:none; color:var(--ink); background:var(--surface-2); border-left:3px solid var(--ink-faint); }
  .calendar-event strong { font-family:'Plex Mono',monospace; font-size:.7rem; }
  .calendar-event small { color:var(--ink-soft); }
  .calendar-event.status-success { border-left-color:var(--green); background:var(--green-soft); }
  .calendar-event.status-neutral { border-left-color:#6088b4; }
  .calendar-event.status-warning { border-left-color:#d69c25; }
  .calendar-event.status-danger { border-left-color:#c0392b; }
  .calendar-event.kind-social { border-style:dashed; opacity:.92; }
  .legend-dot { display:inline-block; width:.6rem; height:.6rem; border-radius:2px; margin-right:.25rem; vertical-align:middle; }
  .legend-dot.dot-aula { background:var(--green); }
  .legend-dot.dot-social { background:var(--surface-2); border:1px dashed #6088b4; }
  @media(max-width:900px){ .calendar-grid{ grid-template-columns:repeat(7,minmax(0,1fr)); font-size:.7rem; } .calendar-cell{ min-height:70px; } .calendar-event small{ display:none; } .calendar-grid-week{ grid-template-columns:1fr; } .calendar-cell-week{ min-height:auto; } }
</style>
<?php admin_foot(); ?>
