<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$rows = $pdo->query('SELECT * FROM social_auto_reply_log ORDER BY criado_em DESC')->fetchAll();

header('Content-Type: text/plain; charset=utf-8');
foreach ($rows as $r) {
    echo "[{$r['criado_em']}] {$r['plataforma']} status={$r['status']} autor={$r['autor']} comentario=\"{$r['texto_comentario']}\"\n";
    if ($r['erro_msg']) {
        echo "  erro: {$r['erro_msg']}\n";
    }
}

@unlink(__FILE__);
