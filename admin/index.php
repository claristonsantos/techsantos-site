<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/_partials.php';
require_admin();

$pdo = db();
function admin_table_exists(PDO $pdo, string $table): bool
{
    static $cache = [];
    if (!array_key_exists($table, $cache)) {
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?');
        $stmt->execute([$table]);
        $cache[$table] = (bool)$stmt->fetchColumn();
    }
    return $cache[$table];
}
function admin_money(int $cents): string
{
    return 'R$ ' . number_format($cents / 100, 2, ',', '.');
}

$totalAlunos = (int)$pdo->query('SELECT COUNT(*) FROM alunos WHERE ativo = 1')->fetchColumn();
$totalCursos = (int)$pdo->query('SELECT COUNT(*) FROM cursos WHERE ativo = 1')->fetchColumn();
$alunosSemCpf = (int)$pdo->query("SELECT COUNT(*) FROM alunos WHERE ativo = 1 AND (cpf IS NULL OR cpf = '')")->fetchColumn();
$receita30 = admin_table_exists($pdo, 'pedidos') ? (int)$pdo->query("SELECT COALESCE(SUM(valor_centavos),0) FROM pedidos WHERE status = 'pago' AND criado_em >= DATE_SUB(NOW(), INTERVAL 30 DAY)")->fetchColumn() : 0;
$vendasHoje = admin_table_exists($pdo, 'pedidos') ? (int)$pdo->query("SELECT COUNT(*) FROM pedidos WHERE status = 'pago' AND DATE(criado_em) = CURDATE()")->fetchColumn() : 0;
$pedidosPendentes = admin_table_exists($pdo, 'pedidos') ? (int)$pdo->query("SELECT COUNT(*) FROM pedidos WHERE status = 'pendente' AND criado_em >= DATE_SUB(NOW(), INTERVAL 7 DAY)")->fetchColumn() : 0;
$emailsFalha = admin_table_exists($pdo, 'pedidos') ? (int)$pdo->query("SELECT COUNT(*) FROM pedidos WHERE status = 'pago' AND email_status = 'falha'")->fetchColumn() : 0;
$postsAgendados = admin_table_exists($pdo, 'social_posts') ? (int)$pdo->query("SELECT COUNT(*) FROM social_posts WHERE status IN ('pendente','processando','agendado_meta') AND agendado_para >= NOW()")->fetchColumn() : 0;
$postsErro = admin_table_exists($pdo, 'social_posts') ? (int)$pdo->query("SELECT COUNT(*) FROM social_posts WHERE status = 'erro'")->fetchColumn() : 0;
$alunosInativos7d = 0;
if (admin_table_exists($pdo, 'aluno_atividade')) {
    $alunosInativos7d = (int)$pdo->query("SELECT COUNT(*) FROM alunos a LEFT JOIN aluno_atividade aa ON aa.aluno_id = a.id WHERE a.ativo = 1 AND COALESCE(aa.ultimo_acesso, a.created_at) < DATE_SUB(NOW(), INTERVAL 7 DAY)")->fetchColumn();
}
$aulasNovas = admin_table_exists($pdo, 'aulas_particulares_leads') ? (int)$pdo->query("SELECT COUNT(*) FROM aulas_particulares_leads WHERE status = 'novo'" )->fetchColumn() : 0;
$aulasNovasAtrasadas = admin_table_exists($pdo, 'aulas_particulares_leads') ? (int)$pdo->query("SELECT COUNT(*) FROM aulas_particulares_leads WHERE status = 'novo' AND criado_em <= DATE_SUB(NOW(), INTERVAL 24 HOUR)")->fetchColumn() : 0;
$ultimosPedidos = admin_table_exists($pdo, 'pedidos') ? $pdo->query("SELECT p.id,p.nome,p.valor_centavos,p.status,p.email_status,p.criado_em,c.nome AS curso_nome FROM pedidos p JOIN cursos c ON c.id=p.curso_id ORDER BY p.criado_em DESC LIMIT 6")->fetchAll() : [];

require_once __DIR__ . '/../inc/cotacao_dolar.php';
require_once __DIR__ . '/../inc/propostas_helpers.php';
$propostasPagasBRL = 0.0;
if (admin_table_exists($pdo, 'propostas')) {
    $propostasPagas = $pdo->query("SELECT itens, moeda FROM propostas WHERE status = 'pago'")->fetchAll();
    $temPagaUsd = false;
    foreach ($propostasPagas as $pp) {
        if ($pp['moeda'] === 'USD') { $temPagaUsd = true; break; }
    }
    $cotacaoDash = $temPagaUsd ? cotacao_dolar_bcb($pdo) : ['valor' => 0.0, 'data' => null];
    foreach ($propostasPagas as $pp) {
        $propostasPagasBRL += proposta_total_em_brl(proposta_itens_total(json_decode((string)$pp['itens'], true) ?: []), $pp['moeda'], $cotacaoDash['valor']);
    }
}

$atividades = [];
foreach ($ultimosPedidos as $pedido) {
    $atividades[] = [
        'data' => $pedido['criado_em'],
        'tipo' => 'Curso',
        'cliente' => $pedido['nome'],
        'detalhe' => $pedido['curso_nome'],
        'valor' => admin_money((int)$pedido['valor_centavos']),
        'status_label' => $pedido['status'],
        'tone' => $pedido['status'] === 'pago' ? 'success' : ($pedido['status'] === 'cancelado' ? 'danger' : 'warning'),
        'href' => '/admin/pedidos.php',
    ];
}
if (admin_table_exists($pdo, 'aulas_particulares_leads')) {
    $aulaStatusLabels = ['novo' => 'Novo', 'contatado' => 'Contatado', 'agendado' => 'Agendado', 'pago' => 'Pago', 'realizado' => 'Realizado', 'cancelado' => 'Cancelado'];
    $aulaStatusTone = ['novo' => 'warning', 'contatado' => 'neutral', 'agendado' => 'neutral', 'pago' => 'success', 'realizado' => 'success', 'cancelado' => 'danger'];
    $ultimasAulas = $pdo->query("SELECT id, nome, interesse, status, valor_centavos, criado_em FROM aulas_particulares_leads ORDER BY criado_em DESC LIMIT 6")->fetchAll();
    foreach ($ultimasAulas as $aula) {
        $atividades[] = [
            'data' => $aula['criado_em'],
            'tipo' => 'Aula',
            'cliente' => $aula['nome'],
            'detalhe' => $aula['interesse'],
            'valor' => $aula['valor_centavos'] ? admin_money((int)$aula['valor_centavos']) : '—',
            'status_label' => $aulaStatusLabels[$aula['status']] ?? $aula['status'],
            'tone' => $aulaStatusTone[$aula['status']] ?? 'neutral',
            'href' => '/admin/aulas_particulares.php',
        ];
    }
}
if (admin_table_exists($pdo, 'propostas')) {
    $propStatusLabels = ['rascunho' => 'Rascunho', 'enviada' => 'Enviada', 'aguardando_pagamento' => 'Aguardando pagamento', 'pago' => 'Pago', 'aprovada' => 'Aprovada', 'recusada' => 'Recusada'];
    $propStatusTone = ['rascunho' => 'neutral', 'enviada' => 'neutral', 'aguardando_pagamento' => 'warning', 'pago' => 'success', 'aprovada' => 'success', 'recusada' => 'danger'];
    $ultimasPropostas = $pdo->query("SELECT id, cliente, projeto, status, itens, moeda, created_at FROM propostas ORDER BY created_at DESC LIMIT 6")->fetchAll();
    foreach ($ultimasPropostas as $prop) {
        $nativo = proposta_itens_total(json_decode((string)$prop['itens'], true) ?: []);
        $atividades[] = [
            'data' => $prop['created_at'],
            'tipo' => 'Proposta',
            'cliente' => $prop['cliente'],
            'detalhe' => $prop['projeto'],
            'valor' => proposta_fmt_moeda($nativo, $prop['moeda']),
            'status_label' => $propStatusLabels[$prop['status']] ?? $prop['status'],
            'tone' => $propStatusTone[$prop['status']] ?? 'neutral',
            'href' => '/admin/propostas.php',
        ];
    }
}
usort($atividades, fn($a, $b) => strtotime($b['data']) <=> strtotime($a['data']));
$atividades = array_slice($atividades, 0, 8);

$pendencias = [
    ['label' => 'E-mails de acesso com falha', 'count' => $emailsFalha, 'href' => '/admin/pedidos.php', 'tone' => 'danger'],
    ['label' => 'Posts com erro', 'count' => $postsErro, 'href' => '/admin/social_posts.php', 'tone' => 'danger'],
    ['label' => 'Pedidos pendentes há até 7 dias', 'count' => $pedidosPendentes, 'href' => '/admin/pedidos.php', 'tone' => 'warning'],
    ['label' => 'Solicitações de aula sem retorno há +24h', 'count' => $aulasNovasAtrasadas, 'href' => '/admin/aulas_particulares.php?status=novo', 'tone' => 'danger'],
    ['label' => 'Novas solicitações de aula (últimas 24h)', 'count' => $aulasNovas - $aulasNovasAtrasadas, 'href' => '/admin/aulas_particulares.php?status=novo', 'tone' => 'warning'],
    ['label' => 'Alunos ativos sem CPF', 'count' => $alunosSemCpf, 'href' => '/admin/alunos.php', 'tone' => 'warning'],
    ['label' => 'Alunos sem acesso há 7 dias', 'count' => $alunosInativos7d, 'href' => '/admin/jornada.php', 'tone' => 'neutral'],
];
$totalPendencias = array_sum(array_column($pendencias, 'count'));

admin_head('Dashboard');
admin_topbar('index');
?>
<main class="admin-main admin-dashboard" id="adminContent" tabindex="-1">
  <div class="admin-head admin-dashboard-head">
    <div><span class="admin-eyebrow">Visão geral</span><h1>Central de operação</h1><p>Acompanhe vendas, alunos e publicações que precisam de atenção.</p></div>
    <div class="admin-head-actions"><a class="btn btn-primary" href="/admin/alunos.php">Adicionar aluno</a><a class="btn btn-ghost on-light" href="/admin/social_posts.php">Agendar post</a></div>
  </div>

  <section class="admin-kpi-grid" aria-label="Indicadores principais">
    <a class="admin-kpi-card is-featured" href="/admin/metricas.php"><span class="admin-kpi-label">Receita · 30 dias</span><strong><?= admin_money($receita30) ?></strong><small>Ver métricas completas</small></a>
    <a class="admin-kpi-card" href="/admin/pedidos.php"><span class="admin-kpi-label">Vendas hoje</span><strong><?= $vendasHoje ?></strong><small>Pedidos aprovados</small></a>
    <a class="admin-kpi-card" href="/admin/alunos.php"><span class="admin-kpi-label">Alunos ativos</span><strong><?= $totalAlunos ?></strong><small><?= $totalCursos ?> curso(s) ativo(s)</small></a>
    <a class="admin-kpi-card" href="/admin/social_posts.php"><span class="admin-kpi-label">Posts agendados</span><strong><?= $postsAgendados ?></strong><small>Próximas publicações</small></a>
    <a class="admin-kpi-card" href="/admin/propostas.php?f_status=pago"><span class="admin-kpi-label">Propostas pagas</span><strong>R$ <?= number_format($propostasPagasBRL, 2, ',', '.') ?></strong><small>Consultoria, cursos e aulas sob proposta</small></a>
  </section>

  <div class="admin-dashboard-grid">
    <section class="admin-panel admin-attention-panel">
      <div class="admin-panel-head"><div><span class="admin-panel-kicker">Prioridades</span><h2>Precisam de atenção</h2></div><span class="admin-count-badge<?= $totalPendencias ? ' has-items' : '' ?>"><?= $totalPendencias ?></span></div>
      <div class="admin-attention-list">
        <?php foreach ($pendencias as $item): ?>
          <a href="<?= $item['href'] ?>" class="admin-attention-item tone-<?= $item['tone'] ?>"><span class="admin-status-dot" aria-hidden="true"></span><span><?= htmlspecialchars($item['label'], ENT_QUOTES) ?></span><strong><?= (int)$item['count'] ?></strong><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg></a>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="admin-panel admin-shortcuts-panel">
      <div class="admin-panel-head"><div><span class="admin-panel-kicker">Acesso rápido</span><h2>Ações frequentes</h2></div></div>
      <div class="admin-shortcut-grid">
        <a href="/admin/aulas_particulares.php"><?= admin_icon('lessons') ?><span><strong>Aulas particulares</strong><small>Leads, agenda e valores</small></span></a>
        <a href="/admin/pedidos.php"><?= admin_icon('orders') ?><span><strong>Conferir pedidos</strong><small>Pagamentos e acessos</small></span></a>
        <a href="/admin/jornada.php"><?= admin_icon('journey') ?><span><strong>Ver jornada</strong><small>Progresso dos alunos</small></span></a>
        <a href="/admin/avaliacoes.php"><?= admin_icon('assessment') ?><span><strong>Avaliações</strong><small>Questões e resultados</small></span></a>
        <a href="/admin/metricas.php"><?= admin_icon('metrics') ?><span><strong>Analisar métricas</strong><small>Funil e marketing</small></span></a>
      </div>
    </section>
  </div>

  <section class="admin-panel admin-recent-panel">
    <div class="admin-panel-head"><div><span class="admin-panel-kicker">Atividade recente</span><h2>Cursos, aulas e propostas</h2></div></div>
    <?php if ($atividades): ?>
      <div class="table-wrap admin-table-compact"><table class="data-table"><thead><tr><th>Data</th><th>Tipo</th><th>Cliente</th><th>Detalhe</th><th>Valor</th><th>Status</th></tr></thead><tbody>
      <?php foreach ($atividades as $item): ?>
        <tr>
          <td><?= date('d/m H:i', strtotime($item['data'])) ?></td>
          <td><a href="<?= $item['href'] ?>"><?= htmlspecialchars($item['tipo'], ENT_QUOTES) ?></a></td>
          <td><strong><?= htmlspecialchars($item['cliente'], ENT_QUOTES) ?></strong></td>
          <td><?= htmlspecialchars($item['detalhe'], ENT_QUOTES) ?></td>
          <td><?= htmlspecialchars($item['valor'], ENT_QUOTES) ?></td>
          <td><span class="admin-status status-<?= $item['tone'] ?>"><?= htmlspecialchars($item['status_label'], ENT_QUOTES) ?></span></td>
        </tr>
      <?php endforeach; ?>
      </tbody></table></div>
    <?php else: ?><div class="admin-empty-state"><strong>Nenhuma atividade registrada</strong><span>Pedidos, aulas e propostas aparecerão aqui.</span></div><?php endif; ?>
  </section>
</main>
<?php admin_foot(); ?>
