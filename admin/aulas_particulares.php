<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/_partials.php';
require_admin();
csrf_token();

$pdo = db();
$tableExists = (bool)$pdo->query("SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'aulas_particulares_leads'")->fetchColumn();
if (!$tableExists) {
    $pdo->exec("CREATE TABLE aulas_particulares_leads (id INT AUTO_INCREMENT PRIMARY KEY,nome VARCHAR(120) NOT NULL,email VARCHAR(190) NOT NULL,telefone VARCHAR(30) NOT NULL,nivel VARCHAR(60) NULL,interesse VARCHAR(80) NOT NULL,tema TEXT NOT NULL,disponibilidade VARCHAR(300) NULL,utm_source VARCHAR(150) NULL,utm_medium VARCHAR(150) NULL,utm_campaign VARCHAR(150) NULL,utm_content VARCHAR(150) NULL,utm_term VARCHAR(150) NULL,landing_page VARCHAR(255) NULL,ip_hash CHAR(64) NULL,status VARCHAR(30) NOT NULL DEFAULT 'novo',criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,INDEX idx_aulas_criado (criado_em),INDEX idx_aulas_status (status)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
}

$columns = [];
foreach ($pdo->query("SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'aulas_particulares_leads'") as $column) $columns[$column['COLUMN_NAME']] = true;
$requiredColumns = [
    'data_aula' => 'DATETIME NULL',
    'horas' => 'DECIMAL(5,2) NULL',
    'valor_centavos' => 'INT NULL',
    'observacoes' => 'TEXT NULL',
    'atualizado_em' => 'DATETIME NULL',
];
foreach ($requiredColumns as $name => $definition) {
    if (!isset($columns[$name])) $pdo->exec("ALTER TABLE aulas_particulares_leads ADD COLUMN {$name} {$definition}");
}

$statusLabels = ['novo'=>'Novo','contatado'=>'Contatado','agendado'=>'Agendado','pago'=>'Pago','realizado'=>'Realizado','cancelado'=>'Cancelado'];
$statusTone = ['novo'=>'warning','contatado'=>'neutral','agendado'=>'neutral','pago'=>'success','realizado'=>'success','cancelado'=>'danger'];
$message = null; $messageOk = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $id = (int)($_POST['id'] ?? 0);
    $statusUpdate = (string)($_POST['status'] ?? 'novo');
    $statusUpdate = isset($statusLabels[$statusUpdate]) ? $statusUpdate : 'novo';
    $horasRaw = str_replace(',', '.', trim((string)($_POST['horas'] ?? '')));
    $horas = $horasRaw !== '' ? round((float)$horasRaw, 2) : null;
    if ($horas !== null && ($horas <= 0 || $horas > 100)) $horas = null;
    $valorCentavos = $horas !== null ? (int)round($horas * 8000) : null;
    $dataRaw = trim((string)($_POST['data_aula'] ?? ''));
    $dataAula = $dataRaw !== '' ? date('Y-m-d H:i:s', strtotime($dataRaw)) : null;
    $observacoes = mb_substr(trim((string)($_POST['observacoes'] ?? '')), 0, 3000);
    if ($id > 0) {
        $stmt = $pdo->prepare('UPDATE aulas_particulares_leads SET status=?,data_aula=?,horas=?,valor_centavos=?,observacoes=?,atualizado_em=NOW() WHERE id=?');
        $stmt->execute([$statusUpdate,$dataAula,$horas,$valorCentavos,$observacoes ?: null,$id]);
        $message = 'Solicitação atualizada.'; $messageOk = true;
    }
}

$status = isset($statusLabels[$_GET['status'] ?? '']) ? (string)$_GET['status'] : '';
$search = trim((string)($_GET['busca'] ?? ''));
$selectedId = max(0, (int)($_GET['editar'] ?? 0));
$where=[]; $params=[];
if ($status !== '') { $where[]='status=?'; $params[]=$status; }
if ($search !== '') { $where[]='(nome LIKE ? OR email LIKE ? OR telefone LIKE ? OR tema LIKE ?)'; $like='%'.$search.'%'; array_push($params,$like,$like,$like,$like); }
$whereSql = $where ? ' WHERE '.implode(' AND ',$where) : '';
$stmt=$pdo->prepare('SELECT * FROM aulas_particulares_leads'.$whereSql.' ORDER BY criado_em DESC LIMIT 200'); $stmt->execute($params); $leads=$stmt->fetchAll();
$counts=array_fill_keys(array_keys($statusLabels),0);
foreach($pdo->query('SELECT status,COUNT(*) total FROM aulas_particulares_leads GROUP BY status') as $row) if(isset($counts[$row['status']])) $counts[$row['status']]=(int)$row['total'];
$selected=null;
if($selectedId){$stmt=$pdo->prepare('SELECT * FROM aulas_particulares_leads WHERE id=?');$stmt->execute([$selectedId]);$selected=$stmt->fetch();}

function lesson_whatsapp(array $lead): string {
    $phone=preg_replace('/\D/','',(string)$lead['telefone']);
    if(strlen($phone)<=11) $phone='55'.$phone;
    $name=explode(' ',trim((string)$lead['nome']))[0] ?: $lead['nome'];
    $text="Olá, {$name}! Aqui é o Clariston, da TECH SANTOS BR. Recebi sua solicitação de aula particular sobre {$lead['tema']}. Podemos confirmar seu objetivo e o melhor horário? O investimento é de R$ 80 por hora.";
    return 'https://wa.me/'.$phone.'?text='.rawurlencode($text);
}

admin_head('Aulas particulares'); admin_topbar('aulas_particulares');
?>
<main class="admin-main" id="adminContent" tabindex="-1">
  <div class="admin-head"><div><span class="admin-eyebrow">Vendas e alunos</span><h1>Aulas particulares</h1><p>Conduza cada solicitação do primeiro contato até a aula realizada.</p></div><div class="admin-head-actions"><a class="btn btn-ghost on-light" href="/aulas-particulares-power-bi.php" target="_blank">Ver página pública</a></div></div>
  <?php if($message): ?><div class="alert <?= $messageOk?'alert-success':'alert-error' ?>" role="status"><?= htmlspecialchars($message,ENT_QUOTES) ?></div><?php endif; ?>
  <section class="admin-kpi-grid" aria-label="Solicitações por etapa">
    <?php foreach(['novo','contatado','agendado','pago'] as $key): ?><a class="admin-kpi-card<?= $key==='novo'&&$counts[$key]?' is-featured':'' ?>" href="?status=<?= $key ?>"><span class="admin-kpi-label"><?= $statusLabels[$key] ?></span><strong><?= $counts[$key] ?></strong><small>Ver solicitações</small></a><?php endforeach; ?>
  </section>
  <form class="admin-filter-bar" method="get" aria-label="Filtros de aulas">
    <div class="field"><label for="busca">Buscar</label><input id="busca" name="busca" type="search" placeholder="Nome, telefone, e-mail ou objetivo" value="<?= htmlspecialchars($search,ENT_QUOTES) ?>"></div>
    <div class="field"><label for="status">Etapa</label><select id="status" name="status"><option value="">Todas</option><?php foreach($statusLabels as $key=>$label): ?><option value="<?= $key ?>" <?= $status===$key?'selected':'' ?>><?= $label ?></option><?php endforeach; ?></select></div>
    <div class="admin-filter-actions"><button class="btn btn-primary" type="submit">Filtrar</button><a class="btn btn-ghost on-light" href="/admin/aulas_particulares.php">Limpar</a></div>
  </form>
  <?php if($selected): ?>
  <section class="admin-form-section"><div class="form-card"><div class="admin-form-section-head"><h2>Atualizar solicitação #<?= (int)$selected['id'] ?></h2><a href="/admin/aulas_particulares.php">Fechar</a></div>
    <p><strong><?= htmlspecialchars($selected['nome'],ENT_QUOTES) ?></strong><br><span style="color:var(--ink-soft)"><?= htmlspecialchars($selected['interesse'],ENT_QUOTES) ?> · <?= htmlspecialchars($selected['nivel'] ?: 'Nível não informado',ENT_QUOTES) ?></span></p>
    <p style="margin:.8rem 0 1.2rem;color:var(--ink-soft)"><?= nl2br(htmlspecialchars($selected['tema'],ENT_QUOTES)) ?></p>
    <form method="post"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$selected['id'] ?>">
      <div class="field"><label for="edit_status">Etapa</label><select id="edit_status" name="status"><?php foreach($statusLabels as $key=>$label): ?><option value="<?= $key ?>" <?= $selected['status']===$key?'selected':'' ?>><?= $label ?></option><?php endforeach; ?></select></div>
      <div class="field"><label for="data_aula">Data e hora</label><input id="data_aula" name="data_aula" type="datetime-local" value="<?= $selected['data_aula']?date('Y-m-d\TH:i',strtotime($selected['data_aula'])):'' ?>"></div>
      <div class="field"><label for="horas">Quantidade de horas</label><input id="horas" name="horas" type="number" min="0.5" max="100" step="0.5" value="<?= $selected['horas']!==null?htmlspecialchars((string)(float)$selected['horas'],ENT_QUOTES):'' ?>"><small id="lessonValue" style="color:var(--green-strong)"><?= $selected['valor_centavos']?'Valor: R$ '.number_format((int)$selected['valor_centavos']/100,2,',','.'):'R$ 80 por hora' ?></small></div>
      <div class="field"><label for="observacoes">Observações internas</label><textarea id="observacoes" name="observacoes" rows="4"><?= htmlspecialchars($selected['observacoes']??'',ENT_QUOTES) ?></textarea></div>
      <div class="form-actions"><button class="btn btn-primary" type="submit">Salvar atualização</button><a class="btn btn-ghost on-light" href="<?= htmlspecialchars(lesson_whatsapp($selected),ENT_QUOTES) ?>" target="_blank" rel="noopener">Abrir WhatsApp</a></div>
    </form>
  </div></section>
  <?php endif; ?>
  <div class="admin-list-head"><div><h2>Solicitações</h2><span><?= count($leads) ?> resultado(s)</span></div></div>
  <div class="table-wrap"><table class="data-table"><thead><tr><th>Recebida</th><th>Aluno</th><th>Interesse</th><th>Aula</th><th>Valor</th><th>Etapa</th><th>Ações</th></tr></thead><tbody>
  <?php if(!$leads): ?><tr class="empty-row"><td colspan="7">Nenhuma solicitação encontrada.</td></tr><?php endif; ?>
  <?php foreach($leads as $lead): ?><tr><td><?= date('d/m/Y H:i',strtotime($lead['criado_em'])) ?></td><td><strong><?= htmlspecialchars($lead['nome'],ENT_QUOTES) ?></strong><small><?= htmlspecialchars($lead['email'],ENT_QUOTES) ?><br><?= htmlspecialchars($lead['telefone'],ENT_QUOTES) ?></small></td><td><?= htmlspecialchars($lead['interesse'],ENT_QUOTES) ?><small><?= htmlspecialchars(mb_strimwidth($lead['tema'],0,95,'…'),ENT_QUOTES) ?></small></td><td><?= $lead['data_aula']?date('d/m/Y H:i',strtotime($lead['data_aula'])):'—' ?><?php if($lead['horas']): ?><small><?= number_format((float)$lead['horas'],1,',','.') ?> hora(s)</small><?php endif; ?></td><td><?= $lead['valor_centavos']?'R$ '.number_format((int)$lead['valor_centavos']/100,2,',','.'):'—' ?></td><td><span class="admin-status status-<?= $statusTone[$lead['status']]??'neutral' ?>"><?= htmlspecialchars($statusLabels[$lead['status']]??$lead['status'],ENT_QUOTES) ?></span></td><td><div class="admin-table-actions"><a href="?editar=<?= (int)$lead['id'] ?>">Editar</a><a href="<?= htmlspecialchars(lesson_whatsapp($lead),ENT_QUOTES) ?>" target="_blank" rel="noopener">WhatsApp</a></div></td></tr><?php endforeach; ?>
  </tbody></table></div>
</main>
<script>const hours=document.getElementById('horas'),value=document.getElementById('lessonValue');if(hours&&value)hours.addEventListener('input',()=>{const total=(parseFloat(hours.value||'0')*80);value.textContent=total>0?'Valor: '+total.toLocaleString('pt-BR',{style:'currency',currency:'BRL'}):'R$ 80 por hora'});</script>
<?php admin_foot(); ?>
