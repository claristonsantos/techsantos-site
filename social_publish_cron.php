<?php
declare(strict_types=1);

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';

$pdo = db();
$due = $pdo->query(
    "SELECT * FROM social_posts WHERE canal = 'instagram' AND status = 'pendente' AND agendado_para <= NOW()"
)->fetchAll();

foreach ($due as $post) {
    $error = null;
    $containerId = meta_create_instagram_container($post['imagem_url'], $post['legenda'], $error);

    if ($containerId === null) {
        $pdo->prepare("UPDATE social_posts SET status = 'erro', erro_msg = ? WHERE id = ?")
            ->execute([$error, $post['id']]);
        echo "post {$post['id']}: falha ao criar container — {$error}\n";
        continue;
    }

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
}

if (!$due) {
    echo "nada pendente\n";
}
