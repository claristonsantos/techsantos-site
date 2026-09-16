<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }

function meta_delete_video_v25(string $videoId, ?string &$error = null): bool
{
    $ch = curl_init('https://graph.facebook.com/v25.0/' . $videoId . '?' . http_build_query(['access_token' => META_PAGE_TOKEN]));
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_CUSTOMREQUEST => 'DELETE', CURLOPT_TIMEOUT => 25]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    $data = $response !== false ? json_decode($response, true) : null;
    if ($httpCode < 200 || $httpCode >= 300 || !is_array($data) || empty($data['success'])) {
        $error = $data['error']['message'] ?? ('HTTP ' . $httpCode . ' | ' . $response);
        return false;
    }
    return true;
}

$ids = [221, 224, 228, 230, 232, 233];
$pdo = db();
$select = $pdo->prepare("SELECT * FROM social_posts WHERE id = ? AND canal='facebook' AND tipo='reels'");
$delete = $pdo->prepare("DELETE FROM social_posts WHERE id = ?");
$insert = $pdo->prepare("INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, link_url, agendado_para, status, meta_post_id) VALUES ('facebook','reels','video',?,?,NULL,?,'agendado_meta',?)");
$out = [];

foreach ($ids as $id) {
    $select->execute([$id]);
    $row = $select->fetch();
    if (!$row) { $out[] = "SKIP|not found|id={$id}"; continue; }

    $error = null;
    if ($row['meta_post_id'] && !meta_delete_video_v25((string)$row['meta_post_id'], $error)) {
        $out[] = "DELETE|ERROR|id={$id}|{$error}";
        continue;
    }
    $delete->execute([$id]);

    $error = null;
    $videoId = meta_schedule_facebook_reel($row['legenda'], $row['imagem_url'], strtotime($row['agendado_para'] . ' UTC'), $error);
    if ($videoId === null) {
        $out[] = "RESCHEDULE|ERROR|id={$id}|{$error}";
        continue;
    }
    $insert->execute([$row['legenda'], $row['imagem_url'], $row['agendado_para'], $videoId]);
    $out[] = "RESCHEDULE|OK|old_id={$id}|new_id={$pdo->lastInsertId()}|meta={$videoId}|{$row['agendado_para']}";
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";
@unlink(__FILE__);
