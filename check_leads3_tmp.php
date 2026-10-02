<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
foreach (db()->query("SELECT criado_em, plataforma, autor, comment_id, status, erro_msg FROM social_auto_reply_log WHERE criado_em >= '2026-10-01' ORDER BY criado_em") as $l)
    echo "{$l['criado_em']} | {$l['plataforma']} | autor=" . ($l['autor'] ?: '(vazio)') . " | {$l['status']} {$l['erro_msg']}\n";
@unlink(__FILE__);
