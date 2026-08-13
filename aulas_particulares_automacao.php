<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/mailer.php';
require_once __DIR__ . '/mercadopago.php';
require_once __DIR__ . '/aulas_particulares_config.php';

function aulas_automation_ensure(PDO $pdo): void
{
    $existing=[];
    foreach($pdo->query("SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='aulas_particulares_leads'") as $row)$existing[$row['COLUMN_NAME']]=true;
    $columns=[
        'link_reuniao'=>'VARCHAR(500) NULL','pagamento_link'=>'TEXT NULL','mercadopago_preference_id'=>'VARCHAR(190) NULL','mercadopago_payment_id'=>'VARCHAR(190) NULL',
        'proposta_enviada_em'=>'DATETIME NULL','confirmacao_enviada_em'=>'DATETIME NULL','lembrete_24h_em'=>'DATETIME NULL','lembrete_1h_em'=>'DATETIME NULL','email_ultimo_erro'=>'TEXT NULL'
    ];
    foreach($columns as $name=>$definition)if(!isset($existing[$name]))$pdo->exec("ALTER TABLE aulas_particulares_leads ADD COLUMN {$name} {$definition}");
}

function aulas_email_frame(string $title,string $content,string $buttonLabel='',string $buttonUrl=''): string
{
    $button=$buttonUrl!==''?'<p style="margin:24px 0"><a href="'.htmlspecialchars($buttonUrl,ENT_QUOTES).'" style="display:inline-block;background:#65c84a;color:#0f2440;text-decoration:none;font-weight:700;padding:13px 20px;border-radius:6px">'.htmlspecialchars($buttonLabel,ENT_QUOTES).'</a></p>':'';
    return '<div style="background:#f5f6f1;padding:28px 14px;font-family:Arial,sans-serif;color:#10192b"><div style="max-width:620px;margin:auto;background:#fff;border:1px solid #dbdecf;border-radius:9px;overflow:hidden"><div style="background:#0f2440;color:#fff;padding:22px 28px"><strong>TECH <span style="color:#65c84a">SANTOS BR</span></strong></div><div style="padding:28px"><h1 style="font-size:23px;margin:0 0 18px">'.$title.'</h1>'.$content.$button.'<p style="margin-top:28px;color:#7c8798;font-size:12px">Dúvidas? Responda este e-mail ou fale pelo WhatsApp (64) 99290-5785.</p></div></div></div>';
}

function aulas_send_received(array $lead): bool
{
    $first=htmlspecialchars(explode(' ',trim($lead['nome']))[0],ENT_QUOTES);$interest=htmlspecialchars($lead['interesse'],ENT_QUOTES);$topic=nl2br(htmlspecialchars($lead['tema'],ENT_QUOTES));
    $html=aulas_email_frame('Recebemos sua solicitação',"<p>Olá, {$first}.</p><p>Recebemos seu pedido de <strong>{$interest}</strong> e vamos avaliar o objetivo informado:</p><div style=\"background:#f5f6f1;padding:14px;border-radius:6px\">{$topic}</div><p>O próximo e-mail trará a proposta com horário, duração, valor e pagamento.</p>");
    return send_html_email($lead['email'],'Recebemos sua solicitação de aula — TECH SANTOS BR',$html,"Recebemos sua solicitação de {$lead['interesse']}. O próximo e-mail trará horário, duração, valor e pagamento.");
}

function aulas_create_payment(array $lead): ?array
{
    $body=['items'=>[['title'=>$lead['interesse'].' — TECH SANTOS BR','quantity'=>1,'unit_price'=>round($lead['valor_centavos']/100,2),'currency_id'=>'BRL']],
        'payer'=>['name'=>$lead['nome'],'email'=>$lead['email']],
        'back_urls'=>['success'=>'https://techsantos.com.br/aula-pagamento-retorno.php?id='.$lead['id'],'failure'=>'https://techsantos.com.br/aula-pagamento-retorno.php?id='.$lead['id'],'pending'=>'https://techsantos.com.br/aula-pagamento-retorno.php?id='.$lead['id']],
        'auto_return'=>'approved','external_reference'=>'AULA-'.$lead['id'],'notification_url'=>'https://techsantos.com.br/mercadopago-webhook.php','payment_methods'=>['installments'=>MERCADOPAGO_MAX_INSTALLMENTS]];
    $ch=curl_init('https://api.mercadopago.com/checkout/preferences');curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER=>true,CURLOPT_POST=>true,CURLOPT_POSTFIELDS=>json_encode($body,JSON_UNESCAPED_UNICODE),CURLOPT_HTTPHEADER=>['Authorization: Bearer '.MERCADOPAGO_ACCESS_TOKEN,'Content-Type: application/json'],CURLOPT_TIMEOUT=>20]);
    $response=curl_exec($ch);$code=curl_getinfo($ch,CURLINFO_HTTP_CODE);curl_close($ch);if($response===false||$code<200||$code>=300){error_log('MP aula preference HTTP '.$code);return null;}$data=json_decode($response,true);$url=MERCADOPAGO_ENV==='production'?($data['init_point']??null):($data['sandbox_init_point']??$data['init_point']??null);return !empty($data['id'])&&$url?['id'=>$data['id'],'url'=>$url]:null;
}

function aulas_send_proposal(array $lead): bool
{
    $date=$lead['data_aula']?date('d/m/Y \à\s H\h',strtotime($lead['data_aula'])):'A combinar';$hours=number_format((float)$lead['horas'],1,',','.');$value=aulas_money((int)$lead['valor_centavos']);$first=htmlspecialchars(explode(' ',trim($lead['nome']))[0],ENT_QUOTES);
    $custom=trim((string)($lead['observacoes']??''));$intro=$custom!==''?'<div style="line-height:1.65">'.nl2br(htmlspecialchars($custom,ENT_QUOTES)).'</div>':"<p>Olá, {$first}.</p><p>Sua proposta está pronta.</p>";$content=$intro."<hr style=\"border:0;border-top:1px solid #dbdecf;margin:22px 0\"><ul><li><strong>Formato:</strong> ".htmlspecialchars($lead['interesse'],ENT_QUOTES)."</li><li><strong>Data:</strong> {$date}</li><li><strong>Duração:</strong> {$hours} hora(s)</li><li><strong>Valor:</strong> {$value}</li></ul><p>A reserva será confirmada automaticamente após a aprovação do pagamento.</p>";
    $html=aulas_email_frame('Proposta e reserva da aula',$content,'Realizar pagamento',(string)$lead['pagamento_link']);
    return send_html_email($lead['email'],'Proposta da sua aula — TECH SANTOS BR',$html,"Proposta: {$lead['interesse']}; data {$date}; duração {$hours}h; valor {$value}. Pagamento: {$lead['pagamento_link']}");
}

function aulas_send_paid(array $lead): bool
{
    $date=$lead['data_aula']?date('d/m/Y \à\s H\h',strtotime($lead['data_aula'])):'a combinar';$meeting=$lead['link_reuniao']?:'';$content='<p>Olá, '.htmlspecialchars(explode(' ',trim($lead['nome']))[0],ENT_QUOTES).'.</p><p>Pagamento aprovado e aula confirmada para <strong>'.$date.'</strong>.</p>';
    if($meeting!=='')$content.='<p>Use o botão abaixo no horário combinado para entrar na aula.</p>';
    $html=aulas_email_frame('Pagamento aprovado. Aula confirmada.',$content,$meeting!==''?'Entrar na aula':'',$meeting);
    return send_html_email($lead['email'],'Aula confirmada — TECH SANTOS BR',$html,"Pagamento aprovado. Aula confirmada para {$date}.".($meeting!==''?" Link: {$meeting}":''));
}

function aulas_send_reminder(array $lead,string $window): bool
{
    $date=date('d/m/Y \à\s H\h',strtotime($lead['data_aula']));$label=$window==='24h'?'amanhã':'em aproximadamente 1 hora';$meeting=$lead['link_reuniao']?:'';$html=aulas_email_frame('Lembrete da sua aula','<p>Sua aula será <strong>'.$label.'</strong>, em '.$date.'.</p><p>Separe seus arquivos e dúvidas para aproveitarmos o encontro.</p>',$meeting!==''?'Entrar na aula':'',$meeting);
    return send_html_email($lead['email'],'Lembrete da aula — TECH SANTOS BR',$html,"Sua aula será {$label}, em {$date}.".($meeting!==''?" Link: {$meeting}":''));
}

