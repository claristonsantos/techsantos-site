<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Diagnóstico de uso único (somente leitura): fila de posts sociais e aulas particulares.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$pdo = db();
$q = function (string $titulo, string $sql) use ($pdo) { echo "== $titulo\n"; foreach ($pdo->query($sql) as $r) echo "  " . implode(' | ', array_map(fn($k, $v) => "$k=$v", array_keys($r), $r)) . "\n"; };
$q('posts com aula particular (qualquer data)', "SELECT id, canal, status, agendado_para, LEFT(REPLACE(legenda,'\n',' '),70) leg, SUBSTRING_INDEX(imagem_url,'/',-1) arq FROM social_posts WHERE legenda LIKE '%particular%' OR legenda LIKE '%individual%' OR imagem_url LIKE '%c0%' ORDER BY agendado_para");
$q('fila futura', "SELECT id, canal, status, agendado_para, LEFT(REPLACE(legenda,'\n',' '),50) leg, SUBSTRING_INDEX(imagem_url,'/',-1) arq FROM social_posts WHERE agendado_para >= NOW() - INTERVAL 1 DAY ORDER BY agendado_para");
$q('colunas social_posts', "SHOW COLUMNS FROM social_posts");
