<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$stmt = $pdo->query("SELECT id, canal, tipo, imagem_url, agendado_para, status, DAYNAME(agendado_para) AS dia FROM social_posts WHERE agendado_para IS NOT NULL ORDER BY agendado_para DESC LIMIT 40");
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
    $file = basename((string)$r['imagem_url']);
    echo "#{$r['id']} {$r['canal']}/{$r['tipo']} {$r['status']} {$r['agendado_para']} ({$r['dia']}) $file\n";
}
@unlink(__FILE__);
