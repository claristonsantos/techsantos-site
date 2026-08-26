<?php
declare(strict_types=1);

require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/_partials.php';
require_admin();
csrf_token();

$pdo = db();
$pdo->exec("CREATE TABLE IF NOT EXISTS whatsapp_lead_pipeline (
    lead_id INT NOT NULL PRIMARY KEY,
    status VARCHAR(30) NOT NULL DEFAULT 'novo',
    ultimo_contato_em DATETIME NULL,
    proxima_acao_em DATETIME NULL,
    observacoes TEXT NULL,
    atualizado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_whatsapp_pipeline_status (status),
    INDEX idx_whatsapp_pipeline_proxima (proxima_acao_em)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$statusLabels = [
    'novo' => 'Novo',
    'contatado' => 'Contatado',
    'respondeu' => 'Respondeu',
    'interessado' => 'Interessado',
    'comprou' => 'Comprou',
    'sem_interesse' => 'Sem interesse',
];
$statusTones = ['novo'=>'neutral','contatado'=>'warning','respondeu'=>'neutral','interessado'=>'success','comprou'=>'success','sem_interesse'=>'danger'];
$mensagem = null;
$mensagemOk = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $leadId = (int)($_POST['lead_id'] ?? 0);
    $novoStatus = (string)($_POST['status'] ?? 'novo');
    $observacoes = mb_substr(trim((string)($_POST['observacoes'] ?? '')), 0, 2000);
    $proximaRaw = trim((string)($_POST['proxima_acao_em'] ?? ''));
    $registrarContato = isset($_POST['registrar_contato']) ? 1 : 0;
    $proximaAcao = null;
    if ($proximaRaw !== '') {
        $parsed = DateTimeImmutable::createFromFormat('Y-m-d\TH:i', $proximaRaw, new DateTimeZone('America/Sao_Paulo'));
        if ($parsed && $parsed->format('Y-m-d\TH:i') === $proximaRaw) $proximaAcao = $parsed->format('Y-m-d H:i:s');
    }
    $check = $pdo->prepare('SELECT COUNT(*) FROM whatsapp_leads WHERE id = ?');
    $check->execute([$leadId]);
    $leadExists = (int)$check->fetchColumn() > 0;
    if (!$leadExists || !isset($statusLabels[$novoStatus]) || ($proximaRaw !== '' && $proximaAcao === null)) {
        $mensagem = 'Não foi possível salvar. Confira a etapa e a data da próxima ação.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO whatsapp_lead_pipeline (lead_id,status,ultimo_contato_em,proxima_acao_em,observacoes)
            VALUES (?,?,IF(?=1,NOW(),NULL),?,?)
            ON DUPLICATE KEY UPDATE status=VALUES(status),
                ultimo_contato_em=IF(?=1,NOW(),ultimo_contato_em),
                proxima_acao_em=VALUES(proxima_acao_em), observacoes=VALUES(observacoes)");
        $stmt->execute([$leadId, $novoStatus, $registrarContato, $proximaAcao, $observacoes ?: null, $registrarContato]);
        $mensagem = 'Pipeline atualizado.';
        $mensagemOk = true;
    }
}

$busca = trim((string)($_GET['busca'] ?? ''));
$periodo = in_array(($_GET['periodo'] ?? '30'), ['7','30','90','todos'], true) ? (string)$_GET['periodo'] : '30';
$status = isset($statusLabels[$_GET['status'] ?? '']) ? (string)$_GET['status'] : '';
$pagina = max(1, (int)($_GET['pagina'] ?? 1));
$porPagina = 30;
$where = [];
$params = [];
if ($busca !== '') { $where[] = '(w.telefone LIKE ? OR w.origem LIKE ?)'; $like = '%' . $busca . '%'; $params = [$like,$like]; }
if ($periodo !== 'todos') $where[] = 'w.criado_em >= DATE_SUB(NOW(), INTERVAL ' . (int)$periodo . ' DAY)';
if ($status !== '') { $where[] = "COALESCE(p.status,'novo') = ?"; $params[] = $status; }
$whereSql = $where ? ' WHERE ' . implode(' AND ', $where) : '';
$fromSql = ' FROM whatsapp_leads w LEFT JOIN whatsapp_lead_pipeline p ON p.lead_id=w.id';
$count = $pdo->prepare('SELECT COUNT(*)' . $fromSql . $whereSql); $count->execute($params); $totalLeads = (int)$count->fetchColumn();
$paginas = max(1, (int)ceil($totalLeads / $porPagina)); $pagina = min($pagina, $paginas); $offset = ($pagina - 1) * $porPagina;
$stmt = $pdo->prepare("SELECT w.id,w.telefone,w.origem,w.criado_em,COALESCE(p.status,'novo') AS pipeline_status,p.ultimo_contato_em,p.proxima_acao_em,p.observacoes" . $fromSql . $whereSql . ' ORDER BY CASE WHEN p.proxima_acao_em IS NOT NULL AND p.proxima_acao_em <= NOW() THEN 0 ELSE 1 END, w.criado_em DESC LIMIT ' . $porPagina . ' OFFSET ' . $offset);
$stmt->execute($params); $leads = $stmt->fetchAll();

$editarId = max(0, (int)($_GET['editar'] ?? ($_POST['lead_id'] ?? 0)));
$leadEditar = null;
if ($editarId > 0) {
    $stmt = $pdo->prepare("SELECT w.id,w.telefone,w.origem,w.criado_em,COALESCE(p.status,'novo') AS pipeline_status,p.ultimo_contato_em,p.proxima_acao_em,p.observacoes FROM whatsapp_leads w LEFT JOIN whatsapp_lead_pipeline p ON p.lead_id=w.id WHERE w.id=?");
    $stmt->execute([$editarId]); $leadEditar = $stmt->fetch() ?: null;
}

function course_lead_origin(string $origin): array { $parts=array_pad(explode('|',strtolower($origin)),5,''); return ['source'=>$parts[1]?:'direct','medium'=>$parts[2]?:'none','campaign'=>$parts[3]?:'none','content'=>$parts[4]?:'none']; }
function course_lead_phone(string $raw): string { $d=preg_replace('/\D/','',$raw)??''; if(str_starts_with($d,'55')&&strlen($d)>=12)$d=substr($d,2); if(strlen($d)===11)return '('.substr($d,0,2).') '.substr($d,2,5).'-'.substr($d,7); if(strlen($d)===10)return '('.substr($d,0,2).') '.substr($d,2,4).'-'.substr($d,6); return $raw; }
function course_lead_whatsapp_url(string $raw): string { $d=preg_replace('/\D/','',$raw)??''; if(!str_starts_with($d,'55'))$d='55'.$d; $m='Olá! Aqui é o Clariston, da TECH SANTOS BR. Você pediu para receber conteúdos depois de assistir às aulas grátis de Power BI. Ficou alguma dúvida sobre o curso completo ou sobre como ele pode ajudar no seu trabalho?'; return 'https://wa.me/'.$d.'?text='.rawurlencode($m); }

admin_head('Leads do curso'); admin_topbar('leads_curso');
?>
<main class="admin-main" id="adminContent">
  <div class="admin-head"><div><span class="admin-eyebrow">Vendas</span><h1>Pipeline dos leads do curso</h1><p>Conduza os contatos das aulas grátis até a compra, com próxima ação e histórico de contato.</p></div><div class="admin-head-actions"><a class="btn btn-ghost on-light" href="/admin/metricas.php">Ver funil</a><a class="btn btn-ghost on-light" href="/aula-gratis.php" target="_blank" rel="noopener">Ver aulas grátis</a></div></div>
  <?php if($mensagem): ?><div class="alert <?= $mensagemOk?'alert-success':'alert-error' ?>" role="<?= $mensagemOk?'status':'alert' ?>"><?= htmlspecialchars($mensagem,ENT_QUOTES) ?></div><?php endif; ?>

  <?php if($leadEditar): ?>
  <section class="admin-form-card" style="margin-bottom:1.5rem">
    <div class="admin-form-section-head"><div><span class="admin-eyebrow">Lead #<?= (int)$leadEditar['id'] ?></span><h2><?= htmlspecialchars(course_lead_phone((string)$leadEditar['telefone']),ENT_QUOTES) ?></h2></div><a class="btn btn-ghost on-light" href="/admin/leads-curso.php">Fechar</a></div>
    <form method="post">
      <?= csrf_field() ?><input type="hidden" name="lead_id" value="<?= (int)$leadEditar['id'] ?>">
      <div class="form-grid">
        <div class="field"><label for="status_edit">Etapa</label><select id="status_edit" name="status"><?php foreach($statusLabels as $value=>$label): ?><option value="<?= $value ?>" <?= $leadEditar['pipeline_status']===$value?'selected':'' ?>><?= htmlspecialchars($label,ENT_QUOTES) ?></option><?php endforeach; ?></select></div>
        <div class="field"><label for="proxima_acao_em">Próxima ação</label><input type="datetime-local" id="proxima_acao_em" name="proxima_acao_em" value="<?= $leadEditar['proxima_acao_em']?date('Y-m-d\TH:i',strtotime((string)$leadEditar['proxima_acao_em'])):'' ?>"></div>
      </div>
      <div class="field"><label for="observacoes">Observações</label><textarea id="observacoes" name="observacoes" rows="4" maxlength="2000" placeholder="Dúvidas, objetivo do lead e próximo passo combinado."><?= htmlspecialchars((string)($leadEditar['observacoes']??''),ENT_QUOTES) ?></textarea></div>
      <label style="display:flex;gap:.55rem;align-items:center;margin-bottom:1rem"><input type="checkbox" name="registrar_contato" value="1"> Registrar contato agora</label>
      <div class="form-actions"><button class="btn btn-primary" type="submit">Salvar pipeline</button><a class="btn btn-ghost on-light" href="<?= htmlspecialchars(course_lead_whatsapp_url((string)$leadEditar['telefone']),ENT_QUOTES) ?>" target="_blank" rel="noopener">Abrir WhatsApp</a></div>
      <?php if($leadEditar['ultimo_contato_em']): ?><p class="admin-form-help">Último contato: <?= date('d/m/Y H:i',strtotime((string)$leadEditar['ultimo_contato_em'])) ?></p><?php endif; ?>
    </form>
  </section>
  <?php endif; ?>

  <form class="admin-filter-bar" method="get" aria-label="Filtros de leads">
    <div class="field"><label for="busca">Buscar</label><input type="search" id="busca" name="busca" placeholder="Telefone, origem ou campanha" value="<?= htmlspecialchars($busca,ENT_QUOTES) ?>"></div>
    <div class="field"><label for="status">Etapa</label><select id="status" name="status"><option value="">Todas</option><?php foreach($statusLabels as $value=>$label): ?><option value="<?= $value ?>" <?= $status===$value?'selected':'' ?>><?= htmlspecialchars($label,ENT_QUOTES) ?></option><?php endforeach; ?></select></div>
    <div class="field"><label for="periodo">Período</label><select id="periodo" name="periodo"><?php foreach(['7'=>'7 dias','30'=>'30 dias','90'=>'90 dias','todos'=>'Todo período'] as $value=>$label): ?><option value="<?= $value ?>" <?= $periodo===$value?'selected':'' ?>><?= $label ?></option><?php endforeach; ?></select></div>
    <div class="admin-filter-actions"><button class="btn btn-primary" type="submit">Filtrar</button><a class="btn btn-ghost on-light" href="/admin/leads-curso.php">Limpar</a></div>
  </form>

  <div class="admin-list-head"><div><h2>Contatos encontrados</h2><span><?= $totalLeads ?> resultado(s) · ações vencidas aparecem primeiro</span></div></div>
  <div class="table-wrap"><table class="data-table"><thead><tr><th>Captado em</th><th>WhatsApp</th><th>Origem</th><th>Etapa</th><th>Próxima ação</th><th>Ações</th></tr></thead><tbody>
    <?php if(!$leads): ?><tr class="empty-row"><td colspan="6">Nenhum lead encontrado com estes filtros.</td></tr><?php endif; ?>
    <?php foreach($leads as $lead): ?><?php $origin=course_lead_origin((string)$lead['origem']); ?>
      <tr><td><?= date('d/m/Y H:i',strtotime((string)$lead['criado_em'])) ?><small>#<?= (int)$lead['id'] ?></small></td><td><strong><?= htmlspecialchars(course_lead_phone((string)$lead['telefone']),ENT_QUOTES) ?></strong></td><td><?= htmlspecialchars($origin['source'],ENT_QUOTES) ?><small><?= htmlspecialchars($origin['campaign'],ENT_QUOTES) ?></small></td><td><span class="admin-status status-<?= $statusTones[$lead['pipeline_status']]??'neutral' ?>"><?= htmlspecialchars($statusLabels[$lead['pipeline_status']]??$lead['pipeline_status'],ENT_QUOTES) ?></span><?php if($lead['ultimo_contato_em']): ?><small>Contato: <?= date('d/m H:i',strtotime((string)$lead['ultimo_contato_em'])) ?></small><?php endif; ?></td><td><?= $lead['proxima_acao_em']?date('d/m/Y H:i',strtotime((string)$lead['proxima_acao_em'])):'—' ?></td><td class="actions"><a href="?editar=<?= (int)$lead['id'] ?>">Gerenciar</a><a href="<?= htmlspecialchars(course_lead_whatsapp_url((string)$lead['telefone']),ENT_QUOTES) ?>" target="_blank" rel="noopener">WhatsApp</a></td></tr>
    <?php endforeach; ?>
  </tbody></table></div>
  <?php admin_pagination($pagina,$paginas,$totalLeads); ?>
</main>
<?php admin_foot(); ?>