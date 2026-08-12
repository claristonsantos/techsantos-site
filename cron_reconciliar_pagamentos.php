<?php
declare(strict_types=1);
if(php_sapi_name()!=='cli'){http_response_code(403);exit('CLI only.');}
require_once __DIR__.'/db.php'; require_once __DIR__.'/mercadopago.php'; require_once __DIR__.'/pedidos.php';
$pedidos=db()->query("SELECT id FROM pedidos WHERE status='pendente' AND mercadopago_preference_id IS NOT NULL AND criado_em>=DATE_SUB(NOW(),INTERVAL 14 DAY) ORDER BY id LIMIT 100")->fetchAll(PDO::FETCH_COLUMN);
$aprovados=0; $erros=0;
foreach($pedidos as $id){
 try{$payment=mercadopago_search_approved_payment('PEDIDO-'.$id);if(!$payment)continue;marcar_pedido_pago((int)$id,$payment['payer']['identification']['number']??null,(string)$payment['id']);$aprovados++;}
 catch(Throwable $e){$erros++;error_log('Reconciliação pedido '.$id.': '.$e->getMessage());}
}
echo date('Y-m-d H:i:s')." - verificados=".count($pedidos)." aprovados={$aprovados} erros={$erros}\n";
if($erros>0)exit(1);
