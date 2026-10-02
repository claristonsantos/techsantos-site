<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
// Só cria containers (não publica): confirma que o Threads consegue buscar vídeo e imagens do media host.
$e = null;
$v = meta_threads_create_container('VIDEO', 'teste (não publicado)', 'https://media.techsantos.com.br/reels/aula-trecho-pivotar-nao-precisa.mp4', $e);
echo "video container: " . ($v ?: "FALHOU {$e}") . "\n";
if ($v) { $ok = meta_threads_wait_finished($v, 90, $e); echo "video status: " . ($ok ? 'FINISHED' : "NAO {$e}") . "\n"; }
$e = null;
$i = meta_threads_create_container('IMAGE', '', 'https://media.techsantos.com.br/carrossel/boas-praticas-power-query/01.jpg', $e, true);
echo "item carrossel: " . ($i ?: "FALHOU {$e}") . "\n";
if ($i) { $ok = meta_threads_wait_finished($i, 30, $e); echo "item status: " . ($ok ? 'FINISHED' : "NAO {$e}") . "\n"; }
@unlink(__FILE__);
