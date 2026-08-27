<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$out = [];
$duplicateIds = [188, 193, 196];
$select = $pdo->prepare("SELECT id, meta_post_id FROM social_posts WHERE id = ? AND canal = 'facebook' AND status = 'agendado_meta'");
$delete = $pdo->prepare("DELETE FROM social_posts WHERE id = ?");

foreach ($duplicateIds as $id) {
    $select->execute([$id]);
    $row = $select->fetch();
    if (!$row) {
        $out[] = "DUPLICATE|IGNORED|id={$id}";
        continue;
    }
    $error = null;
    if (!meta_delete_facebook_post((string)$row['meta_post_id'], $error)) {
        $out[] = "DUPLICATE|ERROR|id={$id}|{$error}";
        continue;
    }
    $delete->execute([$id]);
    $out[] = "DUPLICATE|REMOVED|id={$id}|meta={$row['meta_post_id']}";
}

$url = 'https://media.techsantos.com.br/reels/fabric/fabric-sql-database.mp4';
$exists = $pdo->prepare("SELECT id FROM social_posts WHERE canal = 'facebook' AND tipo = 'reels' AND imagem_url LIKE '%fabric-sql-database.mp4' LIMIT 1");
$exists->execute();
if ($exists->fetchColumn()) {
    $out[] = 'SQL_DATABASE|IGNORED|already exists';
} else {
    $caption = "SQL Database ou Warehouse no Microsoft Fabric?\n\nSQL Database atende aplicações e cargas transacionais. Warehouse é voltado à análise em escala. A escolha começa pela natureza da carga.\n\nEnvie para quem trabalha com arquitetura de dados.\n\n#MicrosoftFabric #SQLDatabase #DataWarehouse #TSQL";
    $when = '2026-09-21 13:00:00';
    $error = null;
    $videoId = meta_schedule_facebook_reel($caption, $url, strtotime($when . ' UTC'), $error);
    if ($videoId === null) {
        $out[] = "SQL_DATABASE|ERROR|{$error}";
    } else {
        $insert = $pdo->prepare("INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, link_url, agendado_para, status, meta_post_id) VALUES ('facebook', 'reels', 'video', ?, ?, NULL, ?, 'agendado_meta', ?)");
        $insert->execute([$caption, $url, $when, $videoId]);
        $out[] = "SQL_DATABASE|OK|id={$pdo->lastInsertId()}|meta={$videoId}";
    }
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";
@unlink(__FILE__);
