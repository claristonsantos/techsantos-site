<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$ok = php_sapi_name()==='cli' || hash_equals(SETUP_KEY, $_GET['key'] ?? '');
if (!$ok) { http_response_code(403); exit('Forbidden.'); }
$pdo=db(); $cols=$pdo->query('SHOW COLUMNS FROM pedidos')->fetchAll(PDO::FETCH_COLUMN);
$changes=[
'mercadopago_payment_id'=>'ADD COLUMN mercadopago_payment_id VARCHAR(64) NULL AFTER mercadopago_preference_id',
'email_status'=>"ADD COLUMN email_status VARCHAR(20) NOT NULL DEFAULT 'pendente' AFTER ga4_client_id",
'email_tentativas'=>'ADD COLUMN email_tentativas INT NOT NULL DEFAULT 0 AFTER email_status',
'email_enviado_em'=>'ADD COLUMN email_enviado_em DATETIME NULL AFTER email_tentativas',
'email_ultimo_erro'=>'ADD COLUMN email_ultimo_erro VARCHAR(1000) NULL AFTER email_enviado_em',
'webhook_processado_em'=>'ADD COLUMN webhook_processado_em DATETIME NULL AFTER email_ultimo_erro',
'webhook_ultimo_erro'=>'ADD COLUMN webhook_ultimo_erro VARCHAR(1000) NULL AFTER webhook_processado_em',
'utm_source'=>'ADD COLUMN utm_source VARCHAR(100) NULL AFTER webhook_ultimo_erro',
'utm_medium'=>'ADD COLUMN utm_medium VARCHAR(100) NULL AFTER utm_source',
'utm_campaign'=>'ADD COLUMN utm_campaign VARCHAR(150) NULL AFTER utm_medium',
'utm_content'=>'ADD COLUMN utm_content VARCHAR(150) NULL AFTER utm_campaign',
'utm_term'=>'ADD COLUMN utm_term VARCHAR(150) NULL AFTER utm_content',
'landing_page'=>'ADD COLUMN landing_page VARCHAR(255) NULL AFTER utm_term'];
$out=[]; foreach($changes as $col=>$sql){if(!in_array($col,$cols,true)){$pdo->exec('ALTER TABLE pedidos '.$sql);$out[]='Criada pedidos.'.$col;}}
echo ($out?implode("\n",$out):'Migração já aplicada.')."\n";
