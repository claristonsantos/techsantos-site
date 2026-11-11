<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/config.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('forbidden');
}
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
@unlink(__FILE__);
// Reels do Threads de 08 e 09/11: o container venceu enquanto o cron estava travado.
// Voltam para a fila com um container novo, um a cada 30 min a partir de agora.
$st = $pdo->prepare("UPDATE social_posts SET status = 'pendente', meta_container_id = NULL, erro_msg = NULL, agendado_para = UTC_TIMESTAMP() + INTERVAL ? MINUTE WHERE id = ? AND canal = 'threads' AND status = 'erro'");
foreach ([484 => 5, 487 => 35] as $id => $min) {
    $st->execute([$min, $id]);
    echo "#$id recolocado: " . $st->rowCount() . "\n";
}
echo "done\n";
