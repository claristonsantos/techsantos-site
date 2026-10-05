<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
foreach (db()->query("SELECT id, canal, tipo, status, agendado_para, meta_post_id, imagem_url FROM social_posts WHERE agendado_para >= NOW() AND status IN ('pendente','agendado_meta') AND canal IN ('instagram','facebook') ORDER BY agendado_para") as $r)
    echo "#{$r['id']}|{$r['canal']}|{$r['tipo']}|{$r['status']}|{$r['agendado_para']}|{$r['meta_post_id']}|" . basename((string)$r['imagem_url']) . "\n";
@unlink(__FILE__);
