<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$stmt = $pdo->query("SELECT id, canal, tipo, agendado_para, LEFT(erro_msg,150) erro, LEFT(fb_story_erro,150) fb_story_erro FROM social_posts WHERE status='erro' OR fb_story_status='erro' ORDER BY canal, agendado_para");
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
    echo "#{$r['id']} {$r['canal']}/{$r['tipo']} {$r['agendado_para']}\n  erro={$r['erro']}\n  fb_story_erro={$r['fb_story_erro']}\n";
}
@unlink(__FILE__);
