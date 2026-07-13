<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$mediaId = '18108998515982271';
$error = null;

$ch = curl_init(meta_ig_graph_url($mediaId) . '?' . http_build_query(['access_token' => META_IG_TOKEN]));
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => 'DELETE',
    CURLOPT_TIMEOUT => 25,
]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$pdo = db();
if ($httpCode >= 200 && $httpCode < 300) {
    $pdo->prepare("DELETE FROM social_posts WHERE id = 25")->execute();
    echo "Story de teste apagado do Instagram e removido do banco.\n";
} else {
    echo "Falha ao apagar (HTTP {$httpCode}): {$response}\n";
}

@unlink(__FILE__);
