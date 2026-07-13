<?php
declare(strict_types=1);

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';

$pdo = db();

// Phase 1: pending posts whose time has come — create the container. Image
// containers (feed/story) publish immediately, same as before. Video
// containers (reels/story-video) process asynchronously on Meta's side, so we
// just record the container id and move to 'processando'.
$due = $pdo->query(
    "SELECT * FROM social_posts WHERE canal = 'instagram' AND status = 'pendente' AND agendado_para <= NOW()"
)->fetchAll();

foreach ($due as $post) {
    $error = null;
    $isVideo = $post['midia_tipo'] === 'video';
    $mediaType = strtoupper($post['tipo']) === 'FEED' ? 'FEED' : strtoupper($post['tipo']);
    $containerId = meta_create_instagram_container($post['imagem_url'], $post['legenda'], $error, $mediaType, $isVideo);

    if ($containerId === null) {
        $pdo->prepare("UPDATE social_posts SET status = 'erro', erro_msg = ? WHERE id = ?")
            ->execute([$error, $post['id']]);
        echo "post {$post['id']}: falha ao criar container — {$error}\n";
        continue;
    }

    if (!$isVideo) {
        $mediaId = meta_publish_instagram_container($containerId, $error);
        if ($mediaId === null) {
            $pdo->prepare("UPDATE social_posts SET status = 'erro', erro_msg = ? WHERE id = ?")
                ->execute([$error, $post['id']]);
            echo "post {$post['id']}: falha ao publicar — {$error}\n";
            continue;
        }
        $pdo->prepare("UPDATE social_posts SET status = 'publicado', meta_post_id = ? WHERE id = ?")
            ->execute([$mediaId, $post['id']]);
        echo "post {$post['id']}: publicado ({$mediaId})\n";
    } else {
        $pdo->prepare("UPDATE social_posts SET status = 'processando', meta_container_id = ? WHERE id = ?")
            ->execute([$containerId, $post['id']]);
        echo "post {$post['id']}: container de vídeo criado, aguardando processamento ({$containerId})\n";
    }
}

// Phase 2: posts whose video container is still processing — poll and publish
// once Meta finishes.
$processing = $pdo->query(
    "SELECT * FROM social_posts WHERE canal = 'instagram' AND status = 'processando' AND meta_container_id IS NOT NULL"
)->fetchAll();

foreach ($processing as $post) {
    $error = null;
    $statusCode = meta_get_instagram_container_status($post['meta_container_id'], $error);

    if ($statusCode === null) {
        echo "post {$post['id']}: falha ao consultar status do container — {$error}\n";
        continue;
    }

    if ($statusCode === 'FINISHED') {
        $mediaId = meta_publish_instagram_container($post['meta_container_id'], $error);
        if ($mediaId === null) {
            $pdo->prepare("UPDATE social_posts SET status = 'erro', erro_msg = ? WHERE id = ?")
                ->execute([$error, $post['id']]);
            echo "post {$post['id']}: falha ao publicar depois de processado — {$error}\n";
            continue;
        }
        $pdo->prepare("UPDATE social_posts SET status = 'publicado', meta_post_id = ? WHERE id = ?")
            ->execute([$mediaId, $post['id']]);
        echo "post {$post['id']}: publicado ({$mediaId})\n";
    } elseif ($statusCode === 'ERROR' || $statusCode === 'EXPIRED') {
        $pdo->prepare("UPDATE social_posts SET status = 'erro', erro_msg = ? WHERE id = ?")
            ->execute(["Container {$statusCode}", $post['id']]);
        echo "post {$post['id']}: container {$statusCode}\n";
    } else {
        echo "post {$post['id']}: ainda processando ({$statusCode})\n";
    }
}

if (!$due && !$processing) {
    echo "nada pendente\n";
}
