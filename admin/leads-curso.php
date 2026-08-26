<?php
declare(strict_types=1);

require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/_partials.php';
require_admin();

$pdo = db();
$busca = trim((string)($_GET['busca'] ?? ''));
$periodo = in_array(($_GET['periodo'] ?? '30'), ['7', '30', '90', 'todos'], true) ? (string)$_GET['periodo'] : '30';
$pagina = max(1, (int)($_GET['pagina'] ?? 1));
$porPagina = 30;
$where = [];
$params = [];
if ($busca !== '') {
    $where[] = '(telefone LIKE ? OR origem LIKE ?)';
    $like = '%' . $busca . '%';
    $params = [$like, $like];
}
if ($periodo !== 'todos') {
    $where[] = 'criado_em >= DATE_SUB(NOW(), INTERVAL ' . (int)$periodo . ' DAY)';
}
$whereSql = $where ? ' WHERE ' . implode(' AND ', $where) : '';
$count = $pdo->prepare('SELECT COUNT(*) FROM whatsapp_leads' . $whereSql);
$count->execute($params);
$totalLeads = (int)$count->fetchColumn();
$paginas = max(1, (int)ceil($totalLeads / $porPagina));
$pagina = min($pagina, $paginas);
$offset = ($pagina - 1) * $porPagina;
$stmt = $pdo->prepare('SELECT id, telefone, origem, criado_em FROM whatsapp_leads' . $whereSql . ' ORDER BY criado_em DESC LIMIT ' . $porPagina . ' OFFSET ' . $offset);
$stmt->execute($params);
$leads = $stmt->fetchAll();

function course_lead_origin(string $origin): array
{
    $parts = array_pad(explode('|', strtolower($origin)), 5, '');
    return [
        'source' => $parts[1] ?: 'direct',
        'medium' => $parts[2] ?: 'none',
        'campaign' => $parts[3] ?: 'none',
        'content' => $parts[4] ?: 'none',
    ];
}

function course_lead_phone(string $raw): string
{
    $digits = preg_replace('/\D/', '', $raw) ?? '';
    if (str_starts_with($digits, '55') && strlen($digits) >= 12) $digits = substr($digits, 2);
    if (strlen($digits) === 11) return '(' . substr($digits, 0, 2) . ') ' . substr($digits, 2, 5) . '-' . substr($digits, 7);
    if (strlen($digits) === 10) return '(' . substr($digits, 0, 2) . ') ' . substr($digits, 2, 4) . '-' . substr($digits, 6);
    return $raw;
}

function course_lead_whatsapp_url(string $raw): string
{
    $digits = preg_replace('/\D/', '', $raw) ?? '';
    if (!str_starts_with($digits, '55')) $digits = '55' . $digits;
    $message = 'Olá! Aqui é o Clariston, da TECH SANTOS BR. Você pediu para receber conteúdos depois de assistir às aulas grátis de Power BI. Ficou alguma dúvida sobre o curso completo ou sobre como ele pode ajudar no seu trabalho?';
    return 'https://wa.me/' . $digits . '?text=' . rawurlencode($message);
}

admin_head('Leads do curso');
admin_topbar('leads_curso');
?>
<main class="admin-main" id="adminContent">
  <div class="admin-head">
    <div><span class="admin-eyebrow">Vendas</span><h1>Leads das aulas grátis</h1><p>Priorize os contatos mais recentes e abra uma conversa contextual no WhatsApp. Nenhuma mensagem é enviada automaticamente.</p></div>
    <div class="admin-head-actions"><a class="btn btn-ghost on-light" href="/admin/metricas.php">Ver funil</a><a class="btn btn-ghost on-light" href="/aula-gratis.php" target="_blank" rel="noopener">Ver aulas grátis</a></div>
  </div>

  <form class="admin-filter-bar" method="get" aria-label="Filtros de leads">
    <div class="field"><label for="busca">Buscar</label><input type="search" id="busca" name="busca" placeholder="Telefone, origem ou campanha" value="<?= htmlspecialchars($busca, ENT_QUOTES) ?>"></div>
    <div class="field"><label for="periodo">Período</label><select id="periodo" name="periodo"><option value="7" <?= $periodo === '7' ? 'selected' : '' ?>>7 dias</option><option value="30" <?= $periodo === '30' ? 'selected' : '' ?>>30 dias</option><option value="90" <?= $periodo === '90' ? 'selected' : '' ?>>90 dias</option><option value="todos" <?= $periodo === 'todos' ? 'selected' : '' ?>>Todo período</option></select></div>
    <div class="admin-filter-actions"><button class="btn btn-primary" type="submit">Filtrar</button><a class="btn btn-ghost on-light" href="/admin/leads-curso.php">Limpar</a></div>
  </form>

  <div class="admin-list-head"><div><h2>Contatos encontrados</h2><span><?= $totalLeads ?> resultado(s), do mais recente para o mais antigo</span></div></div>
  <div class="table-wrap">
    <table class="data-table">
      <thead><tr><th>Captado em</th><th>WhatsApp</th><th>Origem</th><th>Campanha</th><th>Ação</th></tr></thead>
      <tbody>
        <?php if (!$leads): ?><tr class="empty-row"><td colspan="5">Nenhum lead encontrado com estes filtros.</td></tr><?php endif; ?>
        <?php foreach ($leads as $lead): ?>
          <?php $origin = course_lead_origin((string)$lead['origem']); ?>
          <tr>
            <td><?= date('d/m/Y H:i', strtotime((string)$lead['criado_em'])) ?><small>#<?= (int)$lead['id'] ?></small></td>
            <td><strong><?= htmlspecialchars(course_lead_phone((string)$lead['telefone']), ENT_QUOTES) ?></strong></td>
            <td><span class="admin-status status-neutral"><?= htmlspecialchars($origin['source'], ENT_QUOTES) ?></span><small><?= htmlspecialchars($origin['medium'], ENT_QUOTES) ?></small></td>
            <td><?= htmlspecialchars($origin['campaign'], ENT_QUOTES) ?><small><?= htmlspecialchars($origin['content'], ENT_QUOTES) ?></small></td>
            <td class="actions"><a href="<?= htmlspecialchars(course_lead_whatsapp_url((string)$lead['telefone']), ENT_QUOTES) ?>" target="_blank" rel="noopener">Abrir conversa</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php admin_pagination($pagina, $paginas, $totalLeads); ?>
</main>
<?php admin_foot(); ?>