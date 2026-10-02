<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$error = null;
$me = meta_threads_me(threads_cfg('META_THREADS_TOKEN'), $error);
if ($me === null) { echo "ME FALHOU: {$error}\n"; @unlink(__FILE__); exit; }
echo "conta: @{$me['username']} ({$me['id']}); user_id salvo: " . (threads_cfg('META_THREADS_USER_ID') === (string)$me['id'] ? 'ok' : 'DIFERENTE') . "\n";
$texto = "Oi, Threads! 👋 Aqui é a TECH SANTOS BR.\n\nPor aqui vou compartilhar dicas rápidas de Power BI, Excel e Microsoft Fabric — o que funciona no dia a dia de quem transforma dados em decisão.\n\nQual é a sua maior dúvida com Power BI hoje? Responde aqui embaixo.";
$c = meta_threads_create_container('TEXT', $texto, null, $error);
if (!$c) { echo "CONTAINER FALHOU: {$error}\n"; @unlink(__FILE__); exit; }
if (!meta_threads_wait_finished($c, 60, $error)) { echo "PROCESSAMENTO FALHOU: {$error}\n"; @unlink(__FILE__); exit; }
$id = meta_threads_publish($c, $error);
if (!$id) { echo "PUBLISH FALHOU: {$error}\n"; @unlink(__FILE__); exit; }
db()->prepare("INSERT INTO social_posts (canal,tipo,midia_tipo,legenda,imagem_url,link_url,agendado_para,status,meta_post_id) VALUES ('threads','feed','imagem',?,'',NULL,UTC_TIMESTAMP(),'publicado',?)")->execute([$texto, $id]);
$p = meta_http_get(threads_graph_url($id), ['fields' => 'permalink', 'access_token' => threads_cfg('META_THREADS_TOKEN')], $error);
echo "PUBLICADO id={$id} " . ($p['permalink'] ?? '') . "\n";
@unlink(__FILE__);
