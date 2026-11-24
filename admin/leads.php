<?php
declare(strict_types=1);

/*
 * Todos os leads em um só lugar: curso (aulas grátis/WhatsApp), consultoria/painel (empresas) e aulas particulares.
 * Curso e aulas particulares continuam sendo geridos nas páginas próprias; consultoria tem o pipeline aqui.
 */
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/_partials.php';
require_once __DIR__ . '/../lead_pipeline.php';
require_admin();
csrf_token();

$pdo = db();
lead_pipeline_ensure_schema($pdo);
whatsapp_leads_ensure_email($pdo);
$pdo->exec("CREATE TABLE IF NOT EXISTS consultoria_lead_pipeline (
    lead_id INT NOT NULL PRIMARY KEY,
    status VARCHAR(30) NOT NULL DEFAULT 'novo',
    ultimo_contato_em DATETIME NULL,
    proxima_acao_em DATETIME NULL,
    valor_centavos INT NULL,
    observacoes TEXT NULL,
    atualizado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_consult_pipe_status (status),
    INDEX idx_consult_pipe_proxima (proxima_acao_em)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$hasTable = function (string $t) use ($pdo): bool {
    $s = $pdo->prepare('SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = ?');
    $s->execute([$t]);
    return (int)$s->fetchColumn() > 0;
};
$temConsultoria = $hasTable('consultoria_leads');
$temAulas = $hasTable('aulas_particulares_leads');
$temDataAula = $temAulas && (bool)$pdo->query("SHOW COLUMNS FROM aulas_particulares_leads LIKE 'data_aula'")->fetchColumn();

$tipos = ['curso' => 'Curso', 'consultoria' => 'Consultoria / painel', 'aula' => 'Aula particular'];
$tipoTone = ['curso' => 'neutral', 'consultoria' => 'success', 'aula' => 'warning'];
$consultStatus = [
    'novo' => 'Novo', 'contatado' => 'Contatado', 'reuniao' => 'Reunião marcada',
    'proposta' => 'Proposta enviada', 'ganho' => 'Fechado', 'perdido' => 'Perdido',
];
$allStatus = [
    'novo' => 'Novo', 'contatado' => 'Contatado', 'respondeu' => 'Respondeu', 'interessado' => 'Interessado',
    'reuniao' => 'Reunião marcada', 'proposta' => 'Proposta enviada', 'agendado' => 'Agendado', 'pago' => 'Pago',
    'realizado' => 'Realizado', 'comprou' => 'Comprou', 'ganho' => 'Fechado',
    'sem_interesse' => 'Sem interesse', 'perdido' => 'Perdido', 'cancelado' => 'Cancelado',
];
$statusTone = function (string $s): string {
    if (in_array($s, ['comprou', 'ganho', 'pago', 'realizado', 'interessado'], true)) return 'success';
    if (in_array($s, ['sem_interesse', 'perdido', 'cancelado'], true)) return 'danger';
    if ($s === 'novo') return 'warning';
    return 'neutral';
};

$mensagem = null;
$mensagemOk = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $temConsultoria) {
    csrf_check();
    $leadId = (int)($_POST['lead_id'] ?? 0);
    $novo = (string)($_POST['status'] ?? 'novo');
    $obs = mb_substr(trim((string)($_POST['observacoes'] ?? '')), 0, 4000);
    $proxRaw = trim((string)($_POST['proxima_acao_em'] ?? ''));
    $prox = $proxRaw !== '' ? DateTime::createFromFormat('Y-m-d\TH:i', $proxRaw) : null;
    $valorRaw = preg_replace('/[^\d,\.]/', '', (string)($_POST['valor'] ?? '')) ?? '';
    $valor = $valorRaw !== '' ? (int)round((float)str_replace(',', '.', str_replace('.', '', $valorRaw)) * 100) : null;
    $contato = isset($_POST['registrar_contato']) ? 1 : 0;
    $existe = $pdo->prepare('SELECT COUNT(*) FROM consultoria_leads WHERE id = ?');
    $existe->execute([$leadId]);
    if (!isset($consultStatus[$novo]) || !(int)$existe->fetchColumn() || ($proxRaw !== '' && !$prox)) {
        $mensagem = 'Não foi possível salvar. Confira a etapa e a data da próxima ação.';
    } else {
        $st = $pdo->prepare("INSERT INTO consultoria_lead_pipeline (lead_id,status,ultimo_contato_em,proxima_acao_em,valor_centavos,observacoes)
            VALUES (?,?,IF(?=1,NOW(),NULL),?,?,?)
            ON DUPLICATE KEY UPDATE status=VALUES(status),
              ultimo_contato_em=IF(?=1,NOW(),ultimo_contato_em),
              proxima_acao_em=VALUES(proxima_acao_em), valor_centavos=VALUES(valor_centavos), observacoes=VALUES(observacoes)");
        $st->execute([$leadId, $novo, $contato, $prox ? $prox->format('Y-m-d H:i:00') : null, $valor, $obs ?: null, $contato]);
        $mensagem = 'Pipeline do lead salvo.';
        $mensagemOk = true;
    }
}

$tipo = isset($tipos[$_GET['tipo'] ?? '']) ? (string)$_GET['tipo'] : '';
$busca = trim((string)($_GET['busca'] ?? ''));
$periodo = in_array(($_GET['periodo'] ?? '90'), ['7', '30', '90', 'todos'], true) ? (string)($_GET['periodo'] ?? '90') : '90';
$abertos = isset($_GET['abertos']) ? (string)$_GET['abertos'] === '1' : true;
$pagina = max(1, (int)($_GET['pagina'] ?? 1));
$porPagina = 40;

$parts = [];
$parts[] = "SELECT 'curso' tipo, w.id, NULL nome, w.email, w.telefone, 'Aulas grátis do curso' resumo,
    COALESCE(NULLIF(SUBSTRING_INDEX(SUBSTRING_INDEX(w.origem,'|',2),'|',-1),''), w.origem) origem,
    COALESCE(p.status,'novo') status, p.proxima_acao_em, w.criado_em
  FROM whatsapp_leads w LEFT JOIN whatsapp_lead_pipeline p ON p.lead_id=w.id";
if ($temConsultoria) {
    $parts[] = "SELECT 'consultoria', c.id, c.nome, c.email, c.telefone, CONCAT(c.empresa,' — ',LEFT(c.objetivo,110)),
        COALESCE(NULLIF(c.utm_source,''), c.origem), COALESCE(cp.status,'novo'), cp.proxima_acao_em, c.criado_em
      FROM consultoria_leads c LEFT JOIN consultoria_lead_pipeline cp ON cp.lead_id=c.id";
}
if ($temAulas) {
    $prox = $temDataAula ? 'a.data_aula' : 'NULL';
    $parts[] = "SELECT 'aula', a.id, a.nome, a.email, a.telefone, CONCAT(a.interesse,' — ',LEFT(a.tema,110)),
        COALESCE(NULLIF(a.utm_source,''),'site'), a.status, $prox, a.criado_em
      FROM aulas_particulares_leads a";
}
$union = '(' . implode(' UNION ALL ', $parts) . ') t';

$where = [];
$params = [];
if ($tipo !== '') { $where[] = 't.tipo = ?'; $params[] = $tipo; }
if ($busca !== '') {
    $where[] = '(t.nome LIKE ? OR t.email LIKE ? OR t.telefone LIKE ? OR t.resumo LIKE ? OR t.origem LIKE ?)';
    $like = '%' . $busca . '%';
    array_push($params, $like, $like, $like, $like, $like);
}
if ($periodo !== 'todos') $where[] = 't.criado_em >= DATE_SUB(NOW(), INTERVAL ' . (int)$periodo . ' DAY)';
if ($abertos) $where[] = "t.status NOT IN ('comprou','ganho','realizado','sem_interesse','perdido','cancelado')";
$whereSql = $where ? ' WHERE ' . implode(' AND ', $where) : '';

$c = $pdo->prepare("SELECT COUNT(*) FROM $union $whereSql");
$c->execute($params);
$total = (int)$c->fetchColumn();
$paginas = max(1, (int)ceil($total / $porPagina));
$pagina = min($pagina, $paginas);
$offset = ($pagina - 1) * $porPagina;
$s = $pdo->prepare("SELECT t.* FROM $union $whereSql
    ORDER BY CASE WHEN t.status='novo' THEN 0 WHEN t.proxima_acao_em IS NOT NULL AND t.proxima_acao_em <= NOW() THEN 1 ELSE 2 END, t.criado_em DESC
    LIMIT $porPagina OFFSET $offset");
$s->execute($params);
$leads = $s->fetchAll();

$resumo = $pdo->query("SELECT t.tipo, COUNT(*) total, SUM(t.status='novo') novos FROM $union
    WHERE t.criado_em >= DATE_SUB(NOW(), INTERVAL 30 DAY) GROUP BY t.tipo")->fetchAll(PDO::FETCH_UNIQUE);

$editar = null;
$editarId = max(0, (int)($_GET['editar'] ?? ($_POST['lead_id'] ?? 0)));
if ($editarId > 0 && $temConsultoria) {
    $e = $pdo->prepare("SELECT c.*, COALESCE(cp.status,'novo') pipeline_status, cp.ultimo_contato_em, cp.proxima_acao_em, cp.valor_centavos, cp.observacoes
        FROM consultoria_leads c LEFT JOIN consultoria_lead_pipeline cp ON cp.lead_id=c.id WHERE c.id=?");
    $e->execute([$editarId]);
    $editar = $e->fetch() ?: null;
}

function leads_phone(?string $raw): string
{
    $d = preg_replace('/\D/', '', (string)$raw) ?? '';
    if (str_starts_with($d, '55') && strlen($d) >= 12) $d = substr($d, 2);
    if (strlen($d) === 11) return '(' . substr($d, 0, 2) . ') ' . substr($d, 2, 5) . '-' . substr($d, 7);
    if (strlen($d) === 10) return '(' . substr($d, 0, 2) . ') ' . substr($d, 2, 4) . '-' . substr($d, 6);
    return (string)$raw;
}
function leads_wa(?string $raw, string $tipo, ?string $nome): string
{
    $d = preg_replace('/\D/', '', (string)$raw) ?? '';
    if ($d === '') return '';
    if (!str_starts_with($d, '55')) $d = '55' . $d;
    $primeiro = $nome ? explode(' ', trim($nome))[0] : '';
    $oi = $primeiro !== '' ? "Olá, $primeiro! " : 'Olá! ';
    $m = match ($tipo) {
        'consultoria' => $oi . 'Aqui é o Clariston, da Tech Santos. Recebi seu pedido de painel em Power BI pelo site. Podemos conversar 20 minutos para eu entender o cenário e te passar a proposta?',
        'aula' => $oi . 'Aqui é o Clariston, da Tech Santos. Recebi seu pedido de aula particular de Power BI. Qual o melhor dia e horário para você?',
        default => $oi . 'Aqui é o Clariston, da TECH SANTOS BR. Você pediu para receber conteúdos depois das aulas grátis de Power BI. Ficou alguma dúvida sobre o curso completo?',
    };
    return 'https://wa.me/' . $d . '?text=' . rawurlencode($m);
}
function leads_gerenciar(string $tipo, int $id): string
{
    return match ($tipo) {
        'curso' => '/admin/leads-curso.php?editar=' . $id . '&periodo=todos',
        'aula' => '/admin/aulas_particulares.php?editar=' . $id,
        default => '/admin/leads.php?editar=' . $id,
    };
}

admin_head('Todos os leads'); admin_topbar('leads');
?>
<main class="admin-main" id="adminContent">
  <div class="admin-head"><div><span class="admin-eyebrow">Vendas</span><h1>Todos os leads</h1><p>Curso, consultoria/painel e aulas particulares em uma lista só. Novos e ações vencidas aparecem primeiro.</p></div><div class="admin-head-actions"><a class="btn btn-ghost on-light" href="/admin/propostas.php">Propostas</a><a class="btn btn-ghost on-light" href="/admin/leads-curso.php">Pipeline do curso</a></div></div>
  <?php if ($mensagem): ?><div class="alert <?= $mensagemOk ? 'alert-success' : 'alert-error' ?>" role="<?= $mensagemOk ? 'status' : 'alert' ?>"><?= htmlspecialchars($mensagem, ENT_QUOTES) ?></div><?php endif; ?>

  <div class="table-wrap" style="margin-bottom:1.25rem"><table class="data-table"><thead><tr><th>Últimos 30 dias</th><?php foreach ($tipos as $k => $label): ?><th><?= htmlspecialchars($label, ENT_QUOTES) ?></th><?php endforeach; ?></tr></thead><tbody>
    <tr><td>Leads</td><?php foreach ($tipos as $k => $label): ?><td><strong><?= (int)($resumo[$k]['total'] ?? 0) ?></strong></td><?php endforeach; ?></tr>
    <tr><td>Ainda novos (sem contato)</td><?php foreach ($tipos as $k => $label): ?><td><?= (int)($resumo[$k]['novos'] ?? 0) ?></td><?php endforeach; ?></tr>
  </tbody></table></div>

  <?php if ($editar): ?>
  <section class="admin-form-card" style="margin-bottom:1.5rem">
    <div class="admin-form-section-head"><div><span class="admin-eyebrow">Consultoria · lead #<?= (int)$editar['id'] ?> · <?= date('d/m/Y H:i', strtotime((string)$editar['criado_em'])) ?></span><h2><?= htmlspecialchars((string)$editar['empresa'], ENT_QUOTES) ?> — <?= htmlspecialchars((string)$editar['nome'], ENT_QUOTES) ?></h2></div><a class="btn btn-ghost on-light" href="/admin/leads.php">Fechar</a></div>
    <p><strong>E-mail:</strong> <a href="mailto:<?= htmlspecialchars((string)$editar['email'], ENT_QUOTES) ?>"><?= htmlspecialchars((string)$editar['email'], ENT_QUOTES) ?></a> · <strong>Telefone:</strong> <?= htmlspecialchars(leads_phone((string)$editar['telefone']), ENT_QUOTES) ?> · <strong>Sistemas:</strong> <?= htmlspecialchars((string)($editar['sistemas'] ?? '—'), ENT_QUOTES) ?> · <strong>Usuários:</strong> <?= htmlspecialchars((string)($editar['usuarios'] ?? '—'), ENT_QUOTES) ?></p>
    <p><strong>Origem:</strong> <?= htmlspecialchars((string)($editar['utm_source'] ?: $editar['origem']), ENT_QUOTES) ?><?= $editar['utm_campaign'] ? ' · ' . htmlspecialchars((string)$editar['utm_campaign'], ENT_QUOTES) : '' ?> · <?= htmlspecialchars((string)($editar['landing_page'] ?? ''), ENT_QUOTES) ?></p>
    <details open style="margin:.5rem 0 1rem"><summary><strong>Objetivo / pedido do cliente</strong></summary><div style="white-space:pre-wrap;margin-top:.5rem"><?= htmlspecialchars((string)$editar['objetivo'], ENT_QUOTES) ?></div></details>
    <form method="post">
      <?= csrf_field() ?><input type="hidden" name="lead_id" value="<?= (int)$editar['id'] ?>">
      <div class="form-grid">
        <div class="field"><label for="status_edit">Etapa</label><select id="status_edit" name="status"><?php foreach ($consultStatus as $v => $l): ?><option value="<?= $v ?>" <?= $editar['pipeline_status'] === $v ? 'selected' : '' ?>><?= htmlspecialchars($l, ENT_QUOTES) ?></option><?php endforeach; ?></select></div>
        <div class="field"><label for="proxima_acao_em">Próxima ação</label><input type="datetime-local" id="proxima_acao_em" name="proxima_acao_em" value="<?= $editar['proxima_acao_em'] ? date('Y-m-d\TH:i', strtotime((string)$editar['proxima_acao_em'])) : '' ?>"></div>
        <div class="field"><label for="valor">Valor da proposta (R$)</label><input type="text" id="valor" name="valor" inputmode="decimal" placeholder="1.497,00" value="<?= $editar['valor_centavos'] !== null ? number_format((int)$editar['valor_centavos'] / 100, 2, ',', '.') : '' ?>"></div>
      </div>
      <div class="field"><label for="observacoes">Observações</label><textarea id="observacoes" name="observacoes" rows="4" maxlength="4000" placeholder="Filiais, sistema de origem, decisões da reunião, próximo passo."><?= htmlspecialchars((string)($editar['observacoes'] ?? ''), ENT_QUOTES) ?></textarea></div>
      <label style="display:flex;gap:.55rem;align-items:center;margin-bottom:1rem"><input type="checkbox" name="registrar_contato" value="1"> Registrar contato agora</label>
      <div class="form-actions"><button class="btn btn-primary" type="submit">Salvar pipeline</button><?php $wa = leads_wa((string)$editar['telefone'], 'consultoria', (string)$editar['nome']); if ($wa): ?><a class="btn btn-ghost on-light" href="<?= htmlspecialchars($wa, ENT_QUOTES) ?>" target="_blank" rel="noopener">Abrir WhatsApp</a><?php endif; ?><a class="btn btn-ghost on-light" href="/admin/propostas.php">Criar proposta</a></div>
      <?php if ($editar['ultimo_contato_em']): ?><p class="admin-form-help">Último contato: <?= date('d/m/Y H:i', strtotime((string)$editar['ultimo_contato_em'])) ?></p><?php endif; ?>
    </form>
  </section>
  <?php endif; ?>

  <form class="admin-filter-bar" method="get" aria-label="Filtros de leads">
    <div class="field"><label for="busca">Buscar</label><input type="search" id="busca" name="busca" placeholder="Nome, empresa, e-mail, telefone ou origem" value="<?= htmlspecialchars($busca, ENT_QUOTES) ?>"></div>
    <div class="field"><label for="tipo">Tipo</label><select id="tipo" name="tipo"><option value="">Todos</option><?php foreach ($tipos as $v => $l): ?><option value="<?= $v ?>" <?= $tipo === $v ? 'selected' : '' ?>><?= htmlspecialchars($l, ENT_QUOTES) ?></option><?php endforeach; ?></select></div>
    <div class="field"><label for="periodo">Período</label><select id="periodo" name="periodo"><?php foreach (['7' => '7 dias', '30' => '30 dias', '90' => '90 dias', 'todos' => 'Todo período'] as $v => $l): ?><option value="<?= $v ?>" <?= $periodo === $v ? 'selected' : '' ?>><?= $l ?></option><?php endforeach; ?></select></div>
    <div class="field"><label for="abertos">Mostrar</label><select id="abertos" name="abertos"><option value="1" <?= $abertos ? 'selected' : '' ?>>Só em aberto</option><option value="0" <?= !$abertos ? 'selected' : '' ?>>Todos (inclui fechados)</option></select></div>
    <div class="admin-filter-actions"><button class="btn btn-primary" type="submit">Filtrar</button><a class="btn btn-ghost on-light" href="/admin/leads.php">Limpar</a></div>
  </form>

  <div class="admin-list-head"><div><h2>Leads</h2><span><?= $total ?> resultado(s)</span></div></div>
  <div class="table-wrap"><table class="data-table"><thead><tr><th>Captado em</th><th>Tipo</th><th>Contato</th><th>Interesse</th><th>Origem</th><th>Etapa</th><th>Próxima ação</th><th>Ações</th></tr></thead><tbody>
    <?php if (!$leads): ?><tr class="empty-row"><td colspan="8">Nenhum lead encontrado com estes filtros.</td></tr><?php endif; ?>
    <?php foreach ($leads as $l): $t = (string)$l['tipo']; $st = (string)$l['status']; $wa = leads_wa((string)$l['telefone'], $t, $l['nome'] ? (string)$l['nome'] : null); ?>
      <tr>
        <td><?= date('d/m/Y H:i', strtotime((string)$l['criado_em'])) ?><small>#<?= (int)$l['id'] ?></small></td>
        <td><span class="admin-status status-<?= $tipoTone[$t] ?? 'neutral' ?>"><?= htmlspecialchars($tipos[$t] ?? $t, ENT_QUOTES) ?></span></td>
        <td><strong><?= htmlspecialchars((string)($l['nome'] ?: leads_phone((string)$l['telefone'])), ENT_QUOTES) ?></strong><?php if ($l['nome']): ?><small><?= htmlspecialchars(leads_phone((string)$l['telefone']), ENT_QUOTES) ?></small><?php endif; ?><?php if ($l['email']): ?><small><?= htmlspecialchars((string)$l['email'], ENT_QUOTES) ?></small><?php endif; ?></td>
        <td><?= htmlspecialchars((string)$l['resumo'], ENT_QUOTES) ?></td>
        <td><?= htmlspecialchars((string)($l['origem'] ?: 'direto'), ENT_QUOTES) ?></td>
        <td><span class="admin-status status-<?= $statusTone($st) ?>"><?= htmlspecialchars($allStatus[$st] ?? $st, ENT_QUOTES) ?></span></td>
        <td><?= $l['proxima_acao_em'] ? date('d/m/Y H:i', strtotime((string)$l['proxima_acao_em'])) : '—' ?></td>
        <td class="actions"><a href="<?= htmlspecialchars(leads_gerenciar($t, (int)$l['id']), ENT_QUOTES) ?>">Gerenciar</a><?php if ($wa): ?><a href="<?= htmlspecialchars($wa, ENT_QUOTES) ?>" target="_blank" rel="noopener">WhatsApp</a><?php endif; ?><?php if ($l['email']): ?><a href="mailto:<?= htmlspecialchars((string)$l['email'], ENT_QUOTES) ?>">E-mail</a><?php endif; ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody></table></div>
  <?php admin_pagination($pagina, $paginas, $total); ?>
</main>
<?php admin_foot(); ?>
