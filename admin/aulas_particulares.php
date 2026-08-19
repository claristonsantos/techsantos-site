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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
    $dataDate = trim((string)($_POST['data_aula_data'] ?? ''));
    $dataHour = trim((string)($_POST['data_aula_hora'] ?? ''));
    $dataRaw = $dataDate !== '' && $dataHour !== '' ? $dataDate . ' ' . $dataHour . ':00' : '';
    $dataAula = null;
    if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $dataDate, $dateParts) && preg_match('/^\d{2}$/', $dataHour)) {
        $year=(int)$dateParts[1]; $month=(int)$dateParts[2]; $dayOfMonth=(int)$dateParts[3]; $hour=(int)$dataHour;
        if (checkdate($month,$dayOfMonth,$year)) {
            $dayOfWeek=(int)date('N',strtotime($dataDate.' 12:00:00'));
            $allowed=($dayOfWeek>=1&&$dayOfWeek<=5&&$hour>=18&&$hour<=21)||($dayOfWeek===6&&$hour>=8&&$hour<=12);
            if($allowed)$dataAula=sprintf('%04d-%02d-%02d %02d:00:00',$year,$month,$dayOfMonth,$hour);
        }
    }
    $observacoes = mb_substr(trim((string)($_POST['observacoes'] ?? '')), 0, 3000);
    $linkReuniao = mb_substr(trim((string)($_POST['link_reuniao'] ?? '')),0,500);
    if ($linkReuniao !== '' && !filter_var($linkReuniao,FILTER_VALIDATE_URL)) $linkReuniao = '';
    if ($id > 0) {
        $action = (string)($_POST['action'] ?? 'save');
        $isSending = $action === 'save_and_send';
        $isSendingPayment = $action === 'send_payment';
        $sendPaymentNow = isset($_POST['send_payment_now']);
        $statusToSave = $isSending ? 'contatado' : $statusUpdate;
        $stmt = $pdo->prepare('UPDATE aulas_particulares_leads SET status=?,data_aula=?,horas=?,valor_centavos=?,observacoes=?,link_reuniao=?,atualizado_em=NOW() WHERE id=?');
        $stmt->execute([$statusToSave,$dataAula,$horas,$valorCentavos,$observacoes ?: null,$linkReuniao ?: null,$id]);
        if ($isSending || $isSendingPayment) {
            $missing=[];
            if($isSending&&!$dataAula)$missing[]='data ou hora';
            if(!$horas)$missing[]='quantidade';
            if(!$valorCentavos)$missing[]='valor';
            if($isSending&&!$linkReuniao)$missing[]='link da reunião';
            if($isSending&&!$observacoes)$missing[]='mensagem do e-mail';
            if($missing){header('Location: /admin/aulas_particulares.php?editar='.$id.'&proposta=dados&faltando='.rawurlencode(implode(', ',$missing)));exit;}
            $stmt=$pdo->prepare('SELECT * FROM aulas_particulares_leads WHERE id=?'); $stmt->execute([$id]); $lead=$stmt->fetch();
            if($isSending&&!$sendPaymentNow){
                if(!aulas_send_scheduled($lead)){
                    $pdo->prepare('UPDATE aulas_particulares_leads SET email_ultimo_erro=? WHERE id=?')->execute(['Falha ao enviar confirmação da aula',$id]);
                    header('Location: /admin/aulas_particulares.php?editar='.$id.'&proposta=email');exit;
                }
                $pdo->prepare("UPDATE aulas_particulares_leads SET agendamento_enviado_em=NOW(),email_ultimo_erro=NULL,status='agendado' WHERE id=?")->execute([$id]);
                header('Location: /admin/aulas_particulares.php?editar='.$id.'&proposta=confirmada');exit;
            }
            $payment = aulas_create_payment($lead);
            if (!$payment) { header('Location: /admin/aulas_particulares.php?editar='.$id.'&proposta=pagamento'); exit; }
            $lead['pagamento_link']=$payment['url'];
            $emailSent=$isSendingPayment?aulas_send_payment_request($lead):aulas_send_proposal($lead);
            if (!$emailSent) {
                $pdo->prepare('UPDATE aulas_particulares_leads SET email_ultimo_erro=? WHERE id=?')->execute([$isSendingPayment?'Falha ao enviar cobrança':'Falha ao enviar proposta',$id]);
                header('Location: /admin/aulas_particulares.php?editar='.$id.'&proposta=email'); exit;
            }
            $timestampColumn=$isSendingPayment?'cobranca_enviada_em':'proposta_enviada_em';
            $statusAfterSend=$isSendingPayment?$statusUpdate:'agendado';
            $pdo->prepare("UPDATE aulas_particulares_leads SET pagamento_link=?,mercadopago_preference_id=?,{$timestampColumn}=NOW(),email_ultimo_erro=NULL,status=? WHERE id=?")->execute([$payment['url'],$payment['id'],$statusAfterSend,$id]);
            header('Location: /admin/aulas_particulares.php?editar='.$id.'&proposta='.($isSendingPayment?'cobranca':'enviada')); exit;
        }
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
$defaultProposalMessage = '';
if ($selected) {
    $firstName = explode(' ', trim((string)$selected['nome']))[0];
    $proposalDate = $selected['data_aula'] ? date('d/m/Y \à\s H\h', strtotime($selected['data_aula'])) : ($selected['disponibilidade'] ?: 'a definir');
    $proposalHours = $selected['horas'] ? number_format((float)$selected['horas'], 1, ',', '.') . ' hora(s)' : 'a definir';
    $proposalValue = $selected['valor_centavos'] ? aulas_money((int)$selected['valor_centavos']) : 'a definir';
    $defaultProposalMessage = "Olá, {$firstName}.\n\nSua proposta de {$selected['interesse']} está pronta.\n\nData e horário: {$proposalDate}\nDuração: {$proposalHours}\nValor: {$proposalValue}\n\nPara reservar a aula, realize o pagamento pelo botão abaixo. Após a aprovação, você receberá a confirmação e o link da reunião por e-mail.";
}

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
  <div class="admin-head"><div><span class="admin-eyebrow">Vendas</span><h1>Aulas particulares</h1><p>Conduza cada solicitação do primeiro contato até a aula realizada.</p></div><div class="admin-head-actions"><a class="btn btn-ghost on-light" href="/aulas-particulares-power-bi.php" target="_blank">Ver página pública</a></div></div>
  <?php if($message): ?><div class="alert <?= $messageOk?'alert-success':'alert-error' ?>" role="status"><?= htmlspecialchars($message,ENT_QUOTES) ?></div><?php endif; ?>
  <?php if(($_GET['proposta']??'')==='enviada'): ?><div class="alert alert-success" role="status">Proposta enviada por e-mail e link de pagamento gerado.</div><?php elseif(($_GET['proposta']??'')==='confirmada'): ?><div class="alert alert-success" role="status">Aula confirmada por e-mail com o link da reunião, sem cobrança.</div><?php elseif(($_GET['proposta']??'')==='cobranca'): ?><div class="alert alert-success" role="status">Cobrança enviada por e-mail com o valor atualizado.</div><?php elseif(($_GET['proposta']??'')==='dados'): ?><div class="alert alert-error" role="alert">Verifique os seguintes campos: <?= htmlspecialchars((string)($_GET['faltando']??'dados da proposta'),ENT_QUOTES) ?>.</div><?php elseif(($_GET['proposta']??'')==='pagamento'): ?><div class="alert alert-error" role="alert">Não foi possível gerar o link de pagamento. Verifique a integração do Mercado Pago.</div><?php elseif(($_GET['proposta']??'')==='email'): ?><div class="alert alert-error" role="alert">Os dados foram preparados, mas o e-mail não pôde ser enviado. Tente novamente.</div><?php endif; ?>
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
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));gap:.8rem;margin:0 0 1.2rem;padding:1rem;background:var(--surface-2);border:1px solid var(--line);border-radius:7px"><div><small style="display:block;color:var(--ink-faint)">HORÁRIO SOLICITADO</small><strong><?= htmlspecialchars($selected['disponibilidade'] ?: 'Não informado',ENT_QUOTES) ?></strong></div><div><small style="display:block;color:var(--ink-faint)">CONTATO</small><strong><?= htmlspecialchars($selected['email'],ENT_QUOTES) ?></strong><br><span><?= htmlspecialchars($selected['telefone'],ENT_QUOTES) ?></span></div></div><?php if(!empty($selected['email_ultimo_erro'])): ?><div class="alert alert-error" role="alert"><strong>Última falha de envio:</strong> <?= htmlspecialchars($selected['email_ultimo_erro'],ENT_QUOTES) ?></div><?php endif; ?>
    <div class="form-actions" style="margin-bottom:1rem"><button class="btn btn-primary" type="button" id="acceptRequestedTime">Aceitar horário solicitado</button><button class="btn btn-ghost on-light" type="button" id="suggestAnotherTime">Sugerir outro horário</button></div><small id="scheduleDecisionHelp" style="display:block;margin:-.5rem 0 1rem;color:var(--ink-soft)">Escolha uma opção, complete a duração e o link da reunião e salve a atualização.</small>
    <form method="post" id="lessonProposalForm"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$selected['id'] ?>"><input type="hidden" name="action" id="proposalAction" value="save">
      <div class="field"><label for="edit_status">Etapa</label><select id="edit_status" name="status"><?php foreach($statusLabels as $key=>$label): ?><option value="<?= $key ?>" <?= $selected['status']===$key?'selected':'' ?>><?= $label ?></option><?php endforeach; ?></select></div>
      <div class="field"><label for="data_aula_data">Data confirmada ou sugerida</label><input id="data_aula_data" name="data_aula_data" type="date" required value="<?= $selected['data_aula']?date('Y-m-d',strtotime($selected['data_aula'])):'' ?>"></div><div class="field"><label for="data_aula_hora">Hora</label><select id="data_aula_hora" name="data_aula_hora" required data-selected="<?= $selected['data_aula']?date('H',strtotime($selected['data_aula'])):'' ?>"><option value="">Escolha a data</option></select><small style="color:var(--ink-soft)">Dias úteis: 18h–21h · sábado: 8h–12h</small></div>
      <div class="field"><label for="horas">Quantidade de horas</label><input id="horas" name="horas" type="number" required min="0.5" max="100" step="0.5" value="<?= $selected['horas']!==null?htmlspecialchars((string)(float)$selected['horas'],ENT_QUOTES):'' ?>"><small id="lessonValue" style="color:var(--green-strong)"><?= $selected['valor_centavos']?'Valor: '.aulas_money((int)$selected['valor_centavos']):($selected['interesse']==='Pacote de aulas'?'Pacote: '.aulas_money((int)$pricing['pacote_centavos']).' por '.number_format((float)$pricing['pacote_horas'],1,',','.').' horas':($selected['interesse']==='Mentoria de projeto'?aulas_money((int)$pricing['mentoria_centavos']).' por hora':aulas_money((int)$pricing['avulsa_centavos']).' por hora')) ?></small></div>
      <div class="field"><label for="link_reuniao">Link da reunião</label><input id="link_reuniao" name="link_reuniao" type="url" required value="<?= htmlspecialchars($selected['link_reuniao']??'',ENT_QUOTES) ?>" placeholder="https://meet.google.com/..."></div><div class="field"><label for="observacoes">Mensagem do e-mail</label><textarea id="observacoes" name="observacoes" rows="9" required><?= htmlspecialchars($selected['observacoes'] ?: $defaultProposalMessage,ENT_QUOTES) ?></textarea><small id="emailMessageHelp" style="color:var(--ink-soft)">Este texto será enviado ao aluno junto com o resumo da aula.</small></div>
      <div class="field" style="padding:1rem;background:var(--surface-2);border:1px solid var(--line);border-radius:7px"><label style="display:flex;align-items:flex-start;gap:.65rem;cursor:pointer"><input id="send_payment_now" name="send_payment_now" type="checkbox" value="1" checked style="width:auto;margin-top:.2rem"><span><strong>Enviar link de pagamento junto com a confirmação</strong><small style="display:block;color:var(--ink-soft);margin-top:.25rem">Desmarque para aluno recorrente: ele receberá agora a confirmação e o link da aula. A cobrança poderá ser enviada depois.</small></span></label></div>
      <div class="lesson-message" id="proposalClientMessage" role="alert"></div><div class="form-actions"><button class="btn btn-ghost on-light" type="submit" formnovalidate>Salvar rascunho</button><button class="btn btn-primary" type="button" id="sendProposalButton">Confirmar aula e enviar e-mail</button><button class="btn btn-ghost on-light" type="button" id="sendPaymentButton">Enviar cobrança separadamente</button><a class="btn btn-ghost on-light" href="<?= htmlspecialchars(lesson_whatsapp($selected,$pricing),ENT_QUOTES) ?>" target="_blank" rel="noopener">Abrir WhatsApp</a></div>
      <?php if(!empty($selected['proposta_enviada_em'])): ?><small style="display:block;margin-top:.7rem">Última proposta enviada: <?= date('d/m/Y H:i',strtotime($selected['proposta_enviada_em'])) ?></small><?php endif; ?><?php if(!empty($selected['agendamento_enviado_em'])): ?><small style="display:block;margin-top:.4rem">Confirmação sem cobrança enviada: <?= date('d/m/Y H:i',strtotime($selected['agendamento_enviado_em'])) ?></small><?php endif; ?><?php if(!empty($selected['cobranca_enviada_em'])): ?><small style="display:block;margin-top:.4rem">Última cobrança enviada: <?= date('d/m/Y H:i',strtotime($selected['cobranca_enviada_em'])) ?></small><?php endif; ?>
    </form>
  </div></section>
  <?php endif; ?>
  <div class="admin-list-head"><div><h2>Solicitações</h2><span><?= count($leads) ?> resultado(s)</span></div></div>
  <div class="table-wrap"><table class="data-table"><thead><tr><th>Recebida</th><th>Aluno</th><th>Interesse</th><th>Horário</th><th>Valor</th><th>Etapa</th><th>Ações</th></tr></thead><tbody>
  <?php if(!$leads): ?><tr class="empty-row"><td colspan="7">Nenhuma solicitação encontrada.</td></tr><?php endif; ?>
  <?php foreach($leads as $lead): ?><tr><td><?= date('d/m/Y H:i',strtotime($lead['criado_em'])) ?></td><td><strong><?= htmlspecialchars($lead['nome'],ENT_QUOTES) ?></strong><small><?= htmlspecialchars($lead['email'],ENT_QUOTES) ?><br><?= htmlspecialchars($lead['telefone'],ENT_QUOTES) ?></small></td><td><?= htmlspecialchars($lead['interesse'],ENT_QUOTES) ?><small><?= htmlspecialchars(mb_strimwidth($lead['tema'],0,95,'…'),ENT_QUOTES) ?></small></td><td><?= htmlspecialchars($lead['disponibilidade'] ?: '—',ENT_QUOTES) ?><?php if($lead['data_aula']): ?><small>Confirmada: <?= date('d/m/Y H\\h',strtotime($lead['data_aula'])) ?></small><?php elseif($lead['horas']): ?><small><?= number_format((float)$lead['horas'],1,',','.') ?> hora(s)</small><?php endif; ?></td><td><?= $lead['valor_centavos']?'R$ '.number_format((int)$lead['valor_centavos']/100,2,',','.'):'—' ?></td><td><span class="admin-status status-<?= $statusTone[$lead['status']]??'neutral' ?>"><?= htmlspecialchars($statusLabels[$lead['status']]??$lead['status'],ENT_QUOTES) ?></span></td><td><div class="admin-table-actions"><a href="?editar=<?= (int)$lead['id'] ?>">Gerenciar solicitação</a></div></td></tr><?php endforeach; ?>
  </tbody></table></div>
</main>
<script>const scheduleDate=document.getElementById('data_aula_data'),scheduleHour=document.getElementById('data_aula_hora'),acceptRequestedTime=document.getElementById('acceptRequestedTime'),suggestAnotherTime=document.getElementById('suggestAnotherTime'),requestedTime=<?= json_encode($selected['disponibilidade']??'',JSON_UNESCAPED_UNICODE) ?>;function fillScheduleHours(){if(!scheduleDate||!scheduleHour)return;const selected=scheduleDate.value?new Date(`${scheduleDate.value}T12:00:00`):null,day=selected?selected.getDay():-1,hours=day>=1&&day<=5?[18,19,20,21]:day===6?[8,9,10,11,12]:[],current=scheduleHour.dataset.selected||scheduleHour.value;scheduleHour.innerHTML='<option value="">Selecione</option>'+hours.map(hour=>`<option value="${String(hour).padStart(2,'0')}">${hour}h</option>`).join('');scheduleHour.disabled=!hours.length;if(hours.map(String).includes(String(parseInt(current,10))))scheduleHour.value=String(parseInt(current,10)).padStart(2,'0');scheduleHour.dataset.selected=''}if(scheduleDate){scheduleDate.addEventListener('change',fillScheduleHours);fillScheduleHours()}function requestedParts(value){const match=value.match(/^(\d{2})\/(\d{2})\/(\d{4}) às (\d{2}):\d{2}$/);return match?{date:`${match[3]}-${match[2]}-${match[1]}`,hour:match[4]}:null}if(acceptRequestedTime&&scheduleDate&&scheduleHour){acceptRequestedTime.addEventListener('click',()=>{const parts=requestedParts(requestedTime);if(parts){scheduleDate.value=parts.date;scheduleHour.dataset.selected=parts.hour;fillScheduleHours();scheduleHour.focus();updateProposalMessage()}})}if(suggestAnotherTime&&scheduleDate&&scheduleHour){suggestAnotherTime.addEventListener('click',()=>{scheduleDate.value='';scheduleHour.innerHTML='<option value="">Escolha a data</option>';scheduleHour.disabled=true;scheduleDate.focus();updateProposalMessage();if(scheduleDate.showPicker)try{scheduleDate.showPicker()}catch(error){}})}const hours=document.getElementById('horas'),value=document.getElementById('lessonValue'),lessonType=<?= json_encode($selected['interesse']??'',JSON_UNESCAPED_UNICODE) ?>,prices=<?= json_encode(['avulsa'=>(int)$pricing['avulsa_centavos']/100,'pacote_horas'=>(float)$pricing['pacote_horas'],'pacote'=>(int)$pricing['pacote_centavos']/100,'mentoria'=>(int)$pricing['mentoria_centavos']/100],JSON_UNESCAPED_UNICODE) ?>;function money(v){return v.toLocaleString('pt-BR',{style:'currency',currency:'BRL'})}function updateLessonValue(){if(!hours||!value)return;if(lessonType==='Pacote de aulas'){hours.value=String(prices.pacote_horas);hours.readOnly=true;value.textContent='Pacote: '+money(prices.pacote)+' por '+prices.pacote_horas+' horas';return}const rate=lessonType==='Mentoria de projeto'?prices.mentoria:prices.avulsa,total=parseFloat(hours.value||'0')*rate;value.textContent=total>0?'Valor: '+money(total):money(rate)+' por hora'}if(hours){hours.addEventListener('input',updateLessonValue);updateLessonValue()}const proposalMessage=document.getElementById('observacoes'),sendPaymentNow=document.getElementById('send_payment_now'),emailMessageHelp=document.getElementById('emailMessageHelp'),studentFirstName=<?= json_encode(explode(' ',trim((string)($selected['nome']??'')))[0],JSON_UNESCAPED_UNICODE) ?>,proposalInterest=<?= json_encode($selected['interesse']??'',JSON_UNESCAPED_UNICODE) ?>;function updateProposalMessage(){if(!proposalMessage||!scheduleDate||!scheduleHour||!hours)return;const dateParts=scheduleDate.value.split('-'),date=dateParts.length===3?`${dateParts[2]}/${dateParts[1]}/${dateParts[0]}`:'a definir',hour=scheduleHour.value?`${parseInt(scheduleHour.value,10)}h`:'a definir',duration=parseFloat(hours.value||'0'),rate=lessonType==='Mentoria de projeto'?prices.mentoria:prices.avulsa,total=lessonType==='Pacote de aulas'?prices.pacote:duration*rate,paymentNow=!sendPaymentNow||sendPaymentNow.checked;proposalMessage.value=paymentNow?`Olá, ${studentFirstName}.\n\nSua proposta de ${proposalInterest} está pronta.\n\nData e horário: ${date} às ${hour}\nDuração: ${duration>0?duration.toLocaleString('pt-BR')+' hora(s)':'a definir'}\nValor: ${total>0?money(total):'a definir'}\n\nPara reservar a aula, realize o pagamento pelo botão abaixo. Após a aprovação, você receberá a confirmação e o link da reunião por e-mail.`:`Olá, ${studentFirstName}.\n\nSua aula de ${proposalInterest} está confirmada.\n\nData e horário: ${date} às ${hour}\n\nVocê receberá o link da reunião neste e-mail. O pagamento será combinado separadamente após a aula.`;if(emailMessageHelp)emailMessageHelp.textContent=paymentNow?'Este texto será enviado com o resumo e o botão de pagamento.':'Este texto será enviado com a confirmação e o link da reunião, sem cobrança.'}if(scheduleDate)scheduleDate.addEventListener('change',updateProposalMessage);if(scheduleHour)scheduleHour.addEventListener('change',updateProposalMessage);if(hours)hours.addEventListener('input',updateProposalMessage);if(sendPaymentNow)sendPaymentNow.addEventListener('change',updateProposalMessage);updateProposalMessage();const proposalForm=document.getElementById('lessonProposalForm'),proposalAction=document.getElementById('proposalAction'),sendProposalButton=document.getElementById('sendProposalButton'),sendPaymentButton=document.getElementById('sendPaymentButton'),proposalClientMessage=document.getElementById('proposalClientMessage');if(sendProposalButton&&proposalForm&&proposalAction){sendProposalButton.addEventListener('click',()=>{proposalAction.value='save_and_send';if(!proposalForm.reportValidity()){proposalClientMessage.textContent='Preencha os campos destacados antes de confirmar a aula.';proposalClientMessage.className='lesson-message show error';return}const withPayment=!sendPaymentNow||sendPaymentNow.checked;proposalClientMessage.textContent=withPayment?'Processando confirmação, pagamento e e-mail...':'Enviando confirmação e link da aula, sem cobrança...';proposalClientMessage.className='lesson-message show ok';sendProposalButton.disabled=true;sendProposalButton.textContent='Processando...';proposalForm.submit()})}if(sendPaymentButton&&proposalForm&&proposalAction){sendPaymentButton.addEventListener('click',()=>{proposalAction.value='send_payment';if(!hours||!parseFloat(hours.value||'0')){proposalClientMessage.textContent='Informe a quantidade de horas antes de enviar a cobrança.';proposalClientMessage.className='lesson-message show error';hours?.focus();return}proposalClientMessage.textContent='Gerando e enviando a cobrança com o valor atualizado...';proposalClientMessage.className='lesson-message show ok';sendPaymentButton.disabled=true;sendPaymentButton.textContent='Enviando cobrança...';proposalForm.submit()})}</script>
<?php admin_foot(); ?>
