<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/_partials.php';
require_admin();

$pdo = db();

$mesParam = (string)($_GET['mes'] ?? date('Y-m'));
if (!preg_match('/^\d{4}-\d{2}$/', $mesParam)) $mesParam = date('Y-m');
$inicioMes = DateTimeImmutable::createFromFormat('Y-m-d', $mesParam . '-01') ?: new DateTimeImmutable('first day of this month');
$fimMes = $inicioMes->modify('last day of this month');
$mesAnterior = $inicioMes->modify('-1 month')->format('Y-m');
$mesProximo = $inicioMes->modify('+1 month')->format('Y-m');
$hoje = date('Y-m-d');

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
$stmt->execute([$inicioMes->format('Y-m-d') . ' 00:00:00', $fimMes->format('Y-m-d') . ' 23:59:59']);
$aulas = $stmt->fetchAll();

$porDia = [];
foreach ($aulas as $a) {
    $dia = date('Y-m-d', strtotime($a['data_aula']));
    $porDia[$dia][] = $a;
}

$diasSemana = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
$primeiroDiaSemana = (int)$inicioMes->format('w'); // 0=domingo
$totalDias = (int)$fimMes->format('j');
$mesesNomes = [1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril', 5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'];

admin_head('Calendário de aulas');
admin_topbar('aulas_calendario');
?>
<main class="admin-main">
  <div class="admin-head">
    <h1>Calendário de aulas</h1>
    <div class="admin-head-actions">
      <a class="btn btn-ghost on-light" href="?mes=<?= $mesAnterior ?>">← Mês anterior</a>
      <a class="btn btn-ghost on-light" href="?mes=<?= date('Y-m') ?>">Hoje</a>
      <a class="btn btn-ghost on-light" href="?mes=<?= $mesProximo ?>">Próximo mês →</a>
    </div>
  </div>
  <h2 style="margin-bottom:1rem;"><?= $mesesNomes[(int)$inicioMes->format('n')] ?> de <?= $inicioMes->format('Y') ?> · <?= count($aulas) ?> aula(s)</h2>

  <div class="calendar-grid">
    <?php foreach ($diasSemana as $dw): ?><div class="calendar-dow"><?= $dw ?></div><?php endforeach; ?>
    <?php for ($i = 0; $i < $primeiroDiaSemana; $i++): ?><div class="calendar-cell is-empty"></div><?php endfor; ?>
    <?php for ($dia = 1; $dia <= $totalDias; $dia++): ?>
      <?php $dataStr = $inicioMes->format('Y-m-') . str_pad((string)$dia, 2, '0', STR_PAD_LEFT); $eventos = $porDia[$dataStr] ?? []; ?>
      <div class="calendar-cell<?= $dataStr === $hoje ? ' is-today' : '' ?>">
        <span class="calendar-daynum"><?= $dia ?></span>
        <?php foreach ($eventos as $ev): ?>
          <a class="calendar-event status-<?= $statusTone[$ev['status']] ?? 'neutral' ?>" href="/admin/aulas_particulares.php?editar=<?= (int)$ev['id'] ?>">
            <strong><?= date('H:i', strtotime($ev['data_aula'])) ?></strong> <?= htmlspecialchars($ev['nome'], ENT_QUOTES) ?>
            <small><?= htmlspecialchars($ev['interesse'], ENT_QUOTES) ?> · <?= htmlspecialchars($statusLabels[$ev['status']] ?? $ev['status'], ENT_QUOTES) ?></small>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endfor; ?>
  </div>

  <div class="table-wrap" style="margin-top:2rem;">
    <h2 style="margin-bottom:1rem;">Lista do mês</h2>
    <table class="data-table">
      <thead><tr><th>Data</th><th>Aluno</th><th>Formato</th><th>Duração</th><th>Status</th><th>Reunião</th><th>Ações</th></tr></thead>
      <tbody>
        <?php if (!$aulas): ?><tr class="empty-row"><td colspan="7">Nenhuma aula agendada neste mês.</td></tr><?php endif; ?>
        <?php foreach ($aulas as $a): ?>
          <tr>
            <td><?= date('d/m/Y H:i', strtotime($a['data_aula'])) ?></td>
            <td><strong><?= htmlspecialchars($a['nome'], ENT_QUOTES) ?></strong></td>
            <td><?= htmlspecialchars($a['interesse'], ENT_QUOTES) ?></td>
            <td><?= $a['horas'] ? number_format((float)$a['horas'], 1, ',', '.') . 'h' : '—' ?></td>
            <td><span class="admin-status status-<?= $statusTone[$a['status']] ?? 'neutral' ?>"><?= htmlspecialchars($statusLabels[$a['status']] ?? $a['status'], ENT_QUOTES) ?></span></td>
            <td><?= $a['link_reuniao'] ? '<a href="' . htmlspecialchars($a['link_reuniao'], ENT_QUOTES) . '" target="_blank">Entrar</a>' : '—' ?></td>
            <td class="admin-table-actions"><a href="/admin/aulas_particulares.php?editar=<?= (int)$a['id'] ?>">Gerenciar</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>
<style>
  .calendar-grid { display:grid; grid-template-columns:repeat(7,1fr); gap:1px; background:var(--line); border:1px solid var(--line); border-radius:7px; overflow:hidden; }
  .calendar-dow { background:var(--surface-2); padding:.5rem; text-align:center; font:600 .68rem 'Plex Mono',monospace; text-transform:uppercase; letter-spacing:.06em; color:var(--ink-faint); }
  .calendar-cell { background:var(--surface); min-height:104px; padding:.4rem; display:flex; flex-direction:column; gap:.25rem; }
  .calendar-cell.is-empty { background:var(--surface-2); }
  .calendar-cell.is-today { box-shadow:inset 0 0 0 2px var(--green); }
  .calendar-daynum { font:600 .78rem 'Plex Mono',monospace; color:var(--ink-faint); }
  .calendar-event { display:flex; flex-direction:column; padding:.3rem .4rem; border-radius:5px; font-size:.72rem; line-height:1.3; text-decoration:none; color:var(--ink); background:var(--surface-2); border-left:3px solid var(--ink-faint); }
  .calendar-event strong { font-family:'Plex Mono',monospace; font-size:.7rem; }
  .calendar-event small { color:var(--ink-soft); }
  .calendar-event.status-success { border-left-color:var(--green); background:var(--green-soft); }
  .calendar-event.status-neutral { border-left-color:#6088b4; }
  .calendar-event.status-warning { border-left-color:#d69c25; }
  @media(max-width:900px){ .calendar-grid{ grid-template-columns:repeat(7,minmax(0,1fr)); font-size:.7rem; } .calendar-cell{ min-height:70px; } .calendar-event small{ display:none; } }
</style>
<?php admin_foot(); ?>
