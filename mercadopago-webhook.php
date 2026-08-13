<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/mercadopago.php';
require_once __DIR__ . '/pedidos.php';
require_once __DIR__ . '/aulas_particulares_automacao.php';
ignore_user_abort(true);
set_time_limit(90);

try {
    $data=json_decode(file_get_contents('php://input') ?: '',true);
    $paymentId=null;
    if(is_array($data) && (($data['type']??'')==='payment' || in_array($data['action']??'', ['payment.updated','payment.created'],true))) $paymentId=$data['data']['id']??null;
    if(!$paymentId && (($_GET['type']??'')==='payment' || ($_GET['topic']??'')==='payment')) $paymentId=$_GET['data_id']??$_GET['id']??null;
    if(!$paymentId){http_response_code(200);exit('ignored');}
    $payment=mercadopago_get_payment((string)$paymentId);
    if(!$payment){http_response_code(503);exit('payment unavailable');}
    $reference=(string)($payment['external_reference']??'');
    if(preg_match('/^AULA-(\d+)$/',$reference,$m)){
        if(($payment['status']??'')!=='approved'){http_response_code(200);exit('not approved yet');}
        $aulaId=(int)$m[1]; aulas_automation_ensure(db());
        $stmt=db()->prepare('SELECT * FROM aulas_particulares_leads WHERE id=?');$stmt->execute([$aulaId]);$lead=$stmt->fetch();
        if(!$lead){http_response_code(200);exit('aula not found');}
        $wasPaid=in_array((string)$lead['status'],['pago','realizado'],true);
        db()->prepare("UPDATE aulas_particulares_leads SET status='pago',mercadopago_payment_id=?,atualizado_em=NOW() WHERE id=?")->execute([(string)$paymentId,$aulaId]);
        if(!$wasPaid){try{meta_capi_send_lesson_event('Purchase',$aulaId,(string)$lead['email'],(string)$lead['telefone'],(string)$lead['interesse'],((int)$lead['valor_centavos'])/100);}catch(Throwable $e){error_log('Meta CAPI purchase aula '.$aulaId.': '.$e->getMessage());}}
        $lead['status']='pago';$lead['mercadopago_payment_id']=(string)$paymentId;
        if(empty($lead['confirmacao_enviada_em'])){
            if(aulas_send_paid($lead))db()->prepare('UPDATE aulas_particulares_leads SET confirmacao_enviada_em=NOW(),email_ultimo_erro=NULL WHERE id=?')->execute([$aulaId]);
            else db()->prepare('UPDATE aulas_particulares_leads SET email_ultimo_erro=? WHERE id=?')->execute(['Falha ao enviar confirmação de pagamento',$aulaId]);
        }
        http_response_code(200);echo 'ok';exit;
    }
    if(!preg_match('/^PEDIDO-(\d+)$/',$reference,$m)){http_response_code(200);exit('ignored');}
    if(($payment['status']??'')!=='approved'){http_response_code(200);exit('not approved yet');}
    $pedidoId=(int)$m[1];
    marcar_pedido_pago($pedidoId,$payment['payer']['identification']['number']??null,(string)$paymentId);
    $stmt=db()->prepare('SELECT p.email,p.telefone,p.valor_centavos,p.ga4_client_id,c.nome AS curso_nome FROM pedidos p JOIN cursos c ON c.id=p.curso_id WHERE p.id=?');
    $stmt->execute([$pedidoId]);
    if($pedido=$stmt->fetch()){
        try{meta_capi_send_purchase($pedidoId,$pedido['email'],$pedido['telefone'],$pedido['valor_centavos']/100,$pedido['curso_nome']);}catch(Throwable $e){error_log('Meta CAPI pedido '.$pedidoId.': '.$e->getMessage());}
        try{ga4_send_purchase($pedidoId,$pedido['ga4_client_id'],$pedido['valor_centavos']/100,$pedido['curso_nome']);}catch(Throwable $e){error_log('GA4 pedido '.$pedidoId.': '.$e->getMessage());}
    }
    http_response_code(200); echo 'ok';
} catch(Throwable $e) {
    error_log('Mercado Pago webhook: '.$e->getMessage());
    http_response_code(500); echo 'processing failed';
}
