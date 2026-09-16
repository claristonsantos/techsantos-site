<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$files = ['fabric-direct-lake.mp4','dica-copilot-dax.mp4','dica-copilot-resumo.mp4','dica-powerbi-rls.mp4','fabric-dataflows-gen2.mp4','dica-powerbi-fieldparams.mp4','dica-excel-lambda.mp4','dica-excel-python.mp4','promo-aula-objecao.mp4','promo-curso-apostila.mp4'];
$stmt = $pdo->prepare("SELECT id, canal, tipo, status, agendado_para, meta_post_id, LEFT(legenda,40) AS legenda_ini FROM social_posts WHERE imagem_url = ? ORDER BY canal");
foreach ($files as $f) {
    $url = 'https://media.techsantos.com.br/reels/' . $f;
    $stmt->execute([$url]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "=== $f (" . count($rows) . " rows) ===\n";
    foreach ($rows as $r) {
        echo "  #{$r['id']} {$r['canal']}/{$r['tipo']} {$r['status']} {$r['agendado_para']} meta={$r['meta_post_id']} | {$r['legenda_ini']}\n";
    }
}
@unlink(__FILE__);
