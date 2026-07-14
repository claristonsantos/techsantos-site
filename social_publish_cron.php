<?php
declare(strict_types=1);

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';

$pdo = db();

// Phase 1: pending posts whose time has come — create the container and move
// to 'processando'. Every container (image or video) is published only in
// Phase 2, after polling confirms Meta's side is actually done with it —
// publishing an image container right away is racy: Meta may not have
// finished fetching image_url yet, which fails with "Media ID is not
// available" even though the container itself was created successfully.
$due = $pdo->query(
    "SELECT * FROM social_posts WHERE canal = 'instagram' AND status = 'pendente' AND agendado_para <= NOW()"
)->fetchAll();

foreach ($due as $post) {
    $error = null;
    $isVideo = $post['midia_tipo'] === 'video';
    $mediaType = match ($post['tipo']) {
        'story' => 'STORIES',
        'reels' => 'REELS',
        default => 'FEED',
    };
    $containerId = meta_create_instagram_container($post['imagem_url'], $post['legenda'], $error, $mediaType, $isVideo);

    if ($containerId === null) {
        $pdo->prepare("UPDATE social_posts SET status = 'erro', erro_msg = ? WHERE id = ?")
            ->execute([$error, $post['id']]);
        echo "post {$post['id']}: falha ao criar container — {$error}\n";
        continue;
    }

    $pdo->prepare("UPDATE social_posts SET status = 'processando', meta_container_id = ? WHERE id = ?")
        ->execute([$containerId, $post['id']]);
    echo "post {$post['id']}: container criado, aguardando processamento ({$containerId})\n";
}

// Phase 2: posts whose container is still processing — poll and publish once
// Meta finishes (applies to image and video containers alike).
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

// Phase 3: Facebook posts scheduled via Meta's own native scheduler (held and
// auto-published by Meta at scheduled_publish_time, with no action needed on
// our side) — poll to confirm they actually went live, since nothing else
// ever reports that back to us and the row would otherwise stay
// 'agendado_meta' forever even after the post is really published.
$fbScheduled = $pdo->query(
    "SELECT * FROM social_posts WHERE canal = 'facebook' AND status = 'agendado_meta' AND meta_post_id IS NOT NULL AND agendado_para <= NOW()"
)->fetchAll();

foreach ($fbScheduled as $post) {
    $error = null;
    $data = meta_graph_get($post['meta_post_id'], ['fields' => 'is_published', 'access_token' => META_PAGE_TOKEN], $error);

    if ($data === null) {
        echo "post {$post['id']}: falha ao checar status no Facebook — {$error}\n";
        continue;
    }

    if (!empty($data['is_published'])) {
        $pdo->prepare("UPDATE social_posts SET status = 'publicado' WHERE id = ?")->execute([$post['id']]);
        echo "post {$post['id']}: confirmado publicado no Facebook\n";
    } else {
        echo "post {$post['id']}: ainda não publicado no Facebook (aguardando)\n";
    }
}

if (!$due && !$processing && !$fbScheduled) {
    echo "nada pendente\n";
}
