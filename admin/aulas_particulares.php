<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../aulas_particulares_config.php';
require_once __DIR__ . '/../aulas_particulares_automacao.php';
require_once __DIR__ . '/_partials.php';
require_admin();
csrf_token();

$pdo = db();
$pricing = aulas_config($pdo);
$tableExists = (bool)$pdo->query("SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'aulas_particulares_leads'")->fetchColumn();
if (!$tableExists) {
    $pdo->exec("CREATE TABLE aulas_particulares_leads (id INT AUTO_INCREMENT PRIMARY KEY,nome VARCHAR(120) NOT NULL,email VARCHAR(190) NOT NULL,telefone VARCHAR(30) NOT NULL,nivel VARCHAR(60) NULL,interesse VARCHAR(80) NOT NULL,tema TEXT NOT NULL,disponibilidade VARCHAR(300) NULL,utm_source VARCHAR(150) NULL,utm_medium VARCHAR(150) NULL,utm_campaign VARCHAR(150) NULL,utm_content VARCHAR(150) NULL,utm_term VARCHAR(150) NULL,landing_page VARCHAR(255) NULL,ip_hash CHAR(64) NULL,status VARCHAR(30) NOT NULL DEFAULT 'novo',criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,INDEX idx_aulas_criado (criado_em),INDEX idx_aulas_status (status)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
}

aulas_automation_ensure($pdo);
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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'send_proposal') {
 csrf_check(); $id=(int)($_POST['id']??0); $stmt=$pdo->prepare('SELECT * FROM aulas_particulares_leads WHERE id=?'); $stmt->execute([$id]); $lead=$stmt->fetch();
 if($lead&&$lead['data_aula']&&$lead['horas']&&$lead['valor_centavos']&&$lead['link_reuniao']){$payment=!empty($lead['pagamento_link'])?['id'=>(string)$lead['mercadopago_preference_id'],'url'=>(string)$lead['pagamento_link']]:aulas_create_payment($lead);if($payment){$lead['pagamento_link']=$payment['url'];if(aulas_send_proposal($lead)){$pdo->prepare("UPDATE aulas_particulares_leads SET pagamento_link=?,mercadopago_preference_id=?,proposta_enviada_em=NOW(),email_ultimo_erro=NULL,status='agendado' WHERE id=?")->execute([$payment['url'],$payment['id'],$id]);header('Location: /admin/aulas_particulares.php?editar='.$id.'&proposta=enviada');exit;}$pdo->prepare('UPDATE aulas_particulares_leads SET email_ultimo_erro=? WHERE id=?')->execute(['Falha ao enviar proposta',$id]);}}
 header('Location: /admin/aulas_particulares.php?editar='.$id.'&proposta=erro');exit;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'save_pricing') {
    csrf_check();
    $avulsaInput = max(1, (float)str_replace(',', '.', (string)($_POST['avulsa'] ?? '0')));
    $pacoteHorasInput = max(0.5, (float)str_replace(',', '.', (string)($_POST['pacote_horas'] ?? '0')));
    $pacoteInput = max(1, (float)str_replace(',', '.', (string)($_POST['pacote_valor'] ?? '0')));
    $mentoriaInput = max(1, (float)str_replace(',', '.', (string)($_POST['mentoria'] ?? '0')));
    $stmt=$pdo->prepare('UPDATE aulas_particulares_config SET avulsa_centavos=?,pacote_horas=?,pacote_centavos=?,mentoria_centavos=? WHERE id=1');
    $stmt->execute([(int)round($avulsaInput*100),$pacoteHorasInput,(int)round($pacoteInput*100),(int)round($mentoriaInput*100)]);
    header('Location: /admin/aulas_particulares.php?precos=salvos'); exit;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $id = (int)($_POST['id'] ?? 0);
    $statusUpdate = (string)($_POST['status'] ?? 'novo');
    $statusUpdate = isset($statusLabels[$statusUpdate]) ? $statusUpdate : 'novo';
    $horasRaw = str_replace(',', '.', trim((string)($_POST['horas'] ?? '')));
    $horas = $horasRaw !== '' ? round((float)$horasRaw, 2) : null;
    if ($horas !== null && ($horas <= 0 || $horas > 100)) $horas = null;
    $interestStmt = $pdo->prepare('SELECT interesse FROM aulas_particulares_leads WHERE id=?');
    $interestStmt->execute([$id]);
    $leadInterest = (string)($interestStmt->fetchColumn() ?: 'Aula avulsa');
    if ($leadInterest === 'Pacote de aulas') { $horas = (float)$pricing['pacote_horas']; $valorCentavos = (int)$pricing['pacote_centavos']; }
    else { $hourRate = $leadInterest === 'Mentoria de projeto' ? (int)$pricing['mentoria_centavos'] : (int)$pricing['avulsa_centavos']; $valorCentavos = $horas !== null ? (int)round($horas * $hourRate) : null; }
    $dataRaw = trim((string)($_POST['data_aula'] ?? ''));
    $dataAula = $dataRaw !== '' ? date('Y-m-d H:i:s', strtotime($dataRaw)) : null;
    $observacoes = mb_substr(trim((string)($_POST['observacoes'] ?? '')), 0, 3000);
    $linkReuniao = mb_substr(trim((string)($_POST['link_reuniao'] ?? '')),0,500);
    if ($linkReuniao !== '' && !filter_var($linkReuniao,FILTER_VALIDATE_URL)) $linkReuniao = '';
    if ($id > 0) {
        $stmt = $pdo->prepare('UPDATE aulas_particulares_leads SET status=?,data_aula=?,horas=?,valor_centavos=?,observacoes=?,link_reuniao=?,atualizado_em=NOW() WHERE id=?');
        $stmt->execute([$statusUpdate,$dataAula,$horas,$valorCentavos,$observacoes ?: null,$linkReuniao ?: null,$id]);
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

function lesson_whatsapp(array $lead, array $pricing): string {
    $phone=preg_replace('/\D/','',(string)$lead['telefone']);
    if(strlen($phone)<=11) $phone='55'.$phone;
    $name=explode(' ',trim((string)$lead['nome']))[0] ?: $lead['nome'];
    if ($lead['interesse'] === 'Pacote de aulas') $priceText = 'O pacote de '.number_format((float)$pricing['pacote_horas'],1,',','.').' horas custa '.aulas_money((int)$pricing['pacote_centavos']).'.';
    elseif ($lead['interesse'] === 'Mentoria de projeto') $priceText = 'A mentoria custa '.aulas_money((int)$pricing['mentoria_centavos']).' por hora.';
    else $priceText = 'A aula avulsa custa '.aulas_money((int)$pricing['avulsa_centavos']).' por hora.';
    $text="Olá, {$name}! Aqui é o Clariston, da TECH SANTOS BR. Recebi sua solicitação sobre {$lead['tema']}. Podemos confirmar seu objetivo e o melhor horário? {$priceText}";
    return 'https://wa.me/'.$phone.'?text='.rawurlencode($text);
}

admin_head('Aulas particulares'); admin_topbar('aulas_particulares');
?>
<main class="admin-main" id="adminContent" tabindex="-1">
  <div class="admin-head"><div><span class="admin-eyebrow">Vendas e alunos</span><h1>Aulas particulares</h1><p>Conduza cada solicitação do primeiro contato até a aula realizada.</p></div><div class="admin-head-actions"><a class="btn btn-ghost on-light" href="/aulas-particulares-power-bi.php" target="_blank">Ver página pública</a></div></div>
  <?php if(isset($_GET['precos'])): ?><div class="alert alert-success" role="status">Valores atualizados na página pública e nos cálculos.</div><?php endif; ?>
  <section class="admin-form-section"><div class="form-card"><div class="admin-form-section-head"><h2>Valores e pacote</h2></div>
    <form method="post"><?= csrf_field() ?><input type="hidden" name="action" value="save_pricing">
      <div class="field"><label for="avulsa">Aula avulsa · valor por hora</label><input id="avulsa" name="avulsa" type="number" min="1" step="0.01" required value="<?= number_format((int)$pricing['avulsa_centavos']/100,2,'.','') ?>"></div>
      <div class="field"><label for="pacote_horas">Pacote · quantidade de horas</label><input id="pacote_horas" name="pacote_horas" type="number" min="0.5" step="0.5" required value="<?= htmlspecialchars((string)(float)$pricing['pacote_horas'],ENT_QUOTES) ?>"></div>
      <div class="field"><label for="pacote_valor">Pacote · valor total</label><input id="pacote_valor" name="pacote_valor" type="number" min="1" step="0.01" required value="<?= number_format((int)$pricing['pacote_centavos']/100,2,'.','') ?>"></div>
      <div class="field"><label for="mentoria">Mentoria · valor por hora</label><input id="mentoria" name="mentoria" type="number" min="1" step="0.01" required value="<?= number_format((int)$pricing['mentoria_centavos']/100,2,'.','') ?>"></div>
      <div class="form-actions"><button class="btn btn-primary" type="submit">Salvar valores</button></div>
    </form>
  </div></section>  <?php if($message): ?><div class="alert <?= $messageOk?'alert-success':'alert-error' ?>" role="status"><?= htmlspecialchars($message,ENT_QUOTES) ?></div><?php endif; ?>
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
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));gap:.8rem;margin:0 0 1.2rem;padding:1rem;background:var(--surface-2);border:1px solid var(--line);border-radius:7px"><div><small style="display:block;color:var(--ink-faint)">HORÁRIO SOLICITADO</small><strong><?= htmlspecialchars($selected['disponibilidade'] ?: 'Não informado',ENT_QUOTES) ?></strong></div><div><small style="display:block;color:var(--ink-faint)">CONTATO</small><strong><?= htmlspecialchars($selected['email'],ENT_QUOTES) ?></strong><br><span><?= htmlspecialchars($selected['telefone'],ENT_QUOTES) ?></span></div></div>
    <div class="form-actions" style="margin-bottom:1rem"><button class="btn btn-primary" type="button" id="acceptRequestedTime">Aceitar horário solicitado</button><button class="btn btn-ghost on-light" type="button" id="suggestAnotherTime">Sugerir outro horário</button></div><small id="scheduleDecisionHelp" style="display:block;margin:-.5rem 0 1rem;color:var(--ink-soft)">Escolha uma opção, complete a duração e o link da reunião e salve a atualização.</small>
    <form method="post"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$selected['id'] ?>">
      <div class="field"><label for="edit_status">Etapa</label><select id="edit_status" name="status"><?php foreach($statusLabels as $key=>$label): ?><option value="<?= $key ?>" <?= $selected['status']===$key?'selected':'' ?>><?= $label ?></option><?php endforeach; ?></select></div>
      <div class="field"><label for="data_aula">Data e hora confirmadas ou sugeridas</label><input id="data_aula" name="data_aula" type="datetime-local" step="3600" value="<?= $selected['data_aula']?date('Y-m-d\TH:i',strtotime($selected['data_aula'])):'' ?>"></div>
      <div class="field"><label for="horas">Quantidade de horas</label><input id="horas" name="horas" type="number" min="0.5" max="100" step="0.5" value="<?= $selected['horas']!==null?htmlspecialchars((string)(float)$selected['horas'],ENT_QUOTES):'' ?>"><small id="lessonValue" style="color:var(--green-strong)"><?= $selected['valor_centavos']?'Valor: '.aulas_money((int)$selected['valor_centavos']):($selected['interesse']==='Pacote de aulas'?'Pacote: '.aulas_money((int)$pricing['pacote_centavos']).' por '.number_format((float)$pricing['pacote_horas'],1,',','.').' horas':($selected['interesse']==='Mentoria de projeto'?aulas_money((int)$pricing['mentoria_centavos']).' por hora':aulas_money((int)$pricing['avulsa_centavos']).' por hora')) ?></small></div>
      <div class="field"><label for="link_reuniao">Link da reunião</label><input id="link_reuniao" name="link_reuniao" type="url" value="<?= htmlspecialchars($selected['link_reuniao']??'',ENT_QUOTES) ?>" placeholder="https://meet.google.com/..."></div><div class="field"><label for="observacoes">Observações internas</label><textarea id="observacoes" name="observacoes" rows="4"><?= htmlspecialchars($selected['observacoes']??'',ENT_QUOTES) ?></textarea></div>
      <div class="form-actions"><button class="btn btn-primary" type="submit">Salvar atualização</button><a class="btn btn-ghost on-light" href="<?= htmlspecialchars(lesson_whatsapp($selected,$pricing),ENT_QUOTES) ?>" target="_blank" rel="noopener">Abrir WhatsApp</a></div>
    </form>
    <form method="post" style="margin-top:12px"><?= csrf_field() ?><input type="hidden" name="action" value="send_proposal"><input type="hidden" name="id" value="<?= (int)$selected['id'] ?>">
      <button class="btn btn-primary" type="submit" <?= (!$selected['data_aula']||!$selected['valor_centavos']||!$selected['link_reuniao'])?'disabled title="Salve primeiro a data, duração, valor e link da reunião"':'' ?>>Enviar proposta e link de pagamento</button>
      <?php if(!empty($selected['proposta_enviada_em'])): ?><small>Última proposta: <?= date('d/m/Y H:i',strtotime($selected['proposta_enviada_em'])) ?></small><?php endif; ?>
    </form>
  </div></section>
  <?php endif; ?>
  <div class="admin-list-head"><div><h2>Solicitações</h2><span><?= count($leads) ?> resultado(s)</span></div></div>
  <div class="table-wrap"><table class="data-table"><thead><tr><th>Recebida</th><th>Aluno</th><th>Interesse</th><th>Horário</th><th>Valor</th><th>Etapa</th><th>Ações</th></tr></thead><tbody>
  <?php if(!$leads): ?><tr class="empty-row"><td colspan="7">Nenhuma solicitação encontrada.</td></tr><?php endif; ?>
  <?php foreach($leads as $lead): ?><tr><td><?= date('d/m/Y H:i',strtotime($lead['criado_em'])) ?></td><td><strong><?= htmlspecialchars($lead['nome'],ENT_QUOTES) ?></strong><small><?= htmlspecialchars($lead['email'],ENT_QUOTES) ?><br><?= htmlspecialchars($lead['telefone'],ENT_QUOTES) ?></small></td><td><?= htmlspecialchars($lead['interesse'],ENT_QUOTES) ?><small><?= htmlspecialchars(mb_strimwidth($lead['tema'],0,95,'…'),ENT_QUOTES) ?></small></td><td><?= htmlspecialchars($lead['disponibilidade'] ?: '—',ENT_QUOTES) ?><?php if($lead['data_aula']): ?><small>Confirmada: <?= date('d/m/Y H:i',strtotime($lead['data_aula'])) ?></small><?php elseif($lead['horas']): ?><small><?= number_format((float)$lead['horas'],1,',','.') ?> hora(s)</small><?php endif; ?></td><td><?= $lead['valor_centavos']?'R$ '.number_format((int)$lead['valor_centavos']/100,2,',','.'):'—' ?></td><td><span class="admin-status status-<?= $statusTone[$lead['status']]??'neutral' ?>"><?= htmlspecialchars($statusLabels[$lead['status']]??$lead['status'],ENT_QUOTES) ?></span></td><td><div class="admin-table-actions"><a href="?editar=<?= (int)$lead['id'] ?>">Gerenciar solicitação</a></div></td></tr><?php endforeach; ?>
  </tbody></table></div>
</main>
<script>const scheduleInput=document.getElementById('data_aula'),acceptRequestedTime=document.getElementById('acceptRequestedTime'),suggestAnotherTime=document.getElementById('suggestAnotherTime'),requestedTime=<?= json_encode($selected['disponibilidade']??'',JSON_UNESCAPED_UNICODE) ?>;function requestedToInput(value){const match=value.match(/^(\d{2})\/(\d{2})\/(\d{4}) às (\d{2}):(\d{2})$/);return match?`${match[3]}-${match[2]}-${match[1]}T${match[4]}:`+match[5]:''}if(acceptRequestedTime&&scheduleInput){acceptRequestedTime.addEventListener('click',()=>{const converted=requestedToInput(requestedTime);if(converted){scheduleInput.value=converted;scheduleInput.focus()}})}if(suggestAnotherTime&&scheduleInput){suggestAnotherTime.addEventListener('click',()=>{scheduleInput.value='';scheduleInput.focus();if(scheduleInput.showPicker)try{scheduleInput.showPicker()}catch(error){}})}const hours=document.getElementById('horas'),value=document.getElementById('lessonValue'),lessonType=<?= json_encode($selected['interesse']??'',JSON_UNESCAPED_UNICODE) ?>,prices=<?= json_encode(['avulsa'=>(int)$pricing['avulsa_centavos']/100,'pacote_horas'=>(float)$pricing['pacote_horas'],'pacote'=>(int)$pricing['pacote_centavos']/100,'mentoria'=>(int)$pricing['mentoria_centavos']/100],JSON_UNESCAPED_UNICODE) ?>;function money(v){return v.toLocaleString('pt-BR',{style:'currency',currency:'BRL'})}function updateLessonValue(){if(!hours||!value)return;if(lessonType==='Pacote de aulas'){hours.value=String(prices.pacote_horas);hours.readOnly=true;value.textContent='Pacote: '+money(prices.pacote)+' por '+prices.pacote_horas+' horas';return}const rate=lessonType==='Mentoria de projeto'?prices.mentoria:prices.avulsa,total=parseFloat(hours.value||'0')*rate;value.textContent=total>0?'Valor: '+money(total):money(rate)+' por hora'}if(hours){hours.addEventListener('input',updateLessonValue);updateLessonValue()}</script>
<?php admin_foot(); ?>
