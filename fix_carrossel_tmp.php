<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: o carrossel 454 saiu no Instagram em 22/10 mas ficou preso em 'processando';
// o 455 (Threads) não saiu e volta para a fila.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$pdo = db();
$pdo->prepare("UPDATE social_posts SET status='publicado' WHERE id=454 AND status='processando'")->execute();
$pdo->prepare("UPDATE social_posts SET status='pendente', meta_container_id=NULL WHERE id=455 AND status='processando'")->execute();
foreach ($pdo->query("SELECT id, canal, status, agendado_para FROM social_posts WHERE id IN (454,455,456,457)") as $r) echo implode(' | ', $r), "\n";
