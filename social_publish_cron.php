<?php
declare(strict_types=1);

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';

$pdo = db();

// Lâminas do carrossel entre execuções (coluna criada aqui na primeira execução).
$cols = array_column($pdo->query("SHOW COLUMNS FROM social_posts")->fetchAll(), 'Field');
if (!in_array('carousel_children', $cols, true)) $pdo->exec("ALTER TABLE social_posts ADD COLUMN carousel_children TEXT NULL");

// Phase 1: pending posts whose time has come — create the container and move
// to 'processando'. Every container (image or video) is published only in
// Phase 2, after polling confirms Meta's side is actually done with it —
// publishing an image container right away is racy: Meta may not have
// finished fetching image_url yet, which fails with "Media ID is not
// available" even though the container itself was created successfully.
// Facebook Stories are included here too (canal='facebook', tipo='story')
// even though Facebook feed posts never are — feed posts use Meta's own
// native scheduler (see meta_schedule_facebook_post, called directly from
// admin/social_posts.php's save handler, status goes straight to
// 'agendado_meta'). Stories have no such native scheduling on either
// platform, so they queue here as 'pendente' just like Instagram content
// and this cron fires the actual publish at the right time.
$due = $pdo->query(
    "SELECT * FROM social_posts WHERE status = 'pendente' AND agendado_para <= NOW()"
    . " AND (canal = 'instagram' OR canal = 'threads' OR (canal = 'facebook' AND tipo = 'story'))"
)->fetchAll();

// Carrossel é lento (lâminas em vídeo levam minutos para processar). Um por execução:
// em 22/10 o carrossel do Instagram e o do Threads caíram na mesma execução, o servidor
// encerrou o cron no meio e os dois ficaram presos em 'processando'. O próximo sai no minuto seguinte.
$carrosselFeito = false;
foreach ($due as $post) {
    $error = null;
    if ($post['tipo'] === 'carousel') {
        if ($carrosselFeito) continue;
        $carrosselFeito = true;
    }

    // Atomic claim BEFORE any Meta API call — closes a real race that
    // caused triple-duplicate carousel posts on 2026-07-22: the carousel
    // branch below is slow (synchronous, can run well past one cron tick),
    // and this row stayed 'pendente' the whole time, so an overlapping
    // cron run picked up the same row and republished it from scratch.
    // The UPDATE only succeeds if still 'pendente'; if another process
    // already claimed it, rowCount() is 0 and we skip.
    $claim = $pdo->prepare("UPDATE social_posts SET status = 'processando' WHERE id = ? AND status = 'pendente'");
    $claim->execute([$post['id']]);
    if ($claim->rowCount() === 0) {
        echo "post {$post['id']}: já reivindicado por outra execução do cron, pulando\n";
        continue;
    }

    // Threads em duas etapas: aqui só cria o container e marca 'processando';
    // a Fase 3 (no fim deste arquivo) publica quando ele estiver FINISHED.
    // Antes era tudo síncrono e o cron era interrompido pelo limite de tempo
    // do servidor esperando o vídeo processar — o post saía, mas o status
    // ficava preso em 'processando' (posts 327 e 329, 03-04/10/2026).
    if ($post['canal'] === 'threads') {
        $text = (string)$post['legenda'];
        $containerId = null;
        if ($post['tipo'] === 'carousel') {
            // Lâminas do Threads levam ~3,5 s cada; criar 8 de uma vez estourava o tempo
            // do cron e o post ficava preso em 'processando' sem nenhuma lâmina salva
            // (todos os carrosséis de 07/10 a 09/11/2026). Aqui só marca a lista vazia;
            // a fase "carrossel: lâminas" cria algumas por execução e salva a cada uma.
            $urls = json_decode((string)$post['carousel_urls'], true);
            if (is_array($urls) && count($urls) >= 2) {
                $pdo->prepare("UPDATE social_posts SET carousel_children = '[]' WHERE id = ?")->execute([$post['id']]);
                echo "post {$post['id']}: carrossel do Threads na fila, lâminas saem nas próximas execuções\n";
            } else {
                $pdo->prepare("UPDATE social_posts SET status = 'erro', erro_msg = ? WHERE id = ?")
                    ->execute(['Threads: carrossel do Threads precisa de 2 a 10 itens', $post['id']]);
                echo "post {$post['id']}: carrossel do Threads sem itens suficientes\n";
            }
            continue;
        } elseif ((string)$post['imagem_url'] === '') {
            $containerId = meta_threads_create_container('TEXT', $text, null, $error);
        } else {
            $containerId = meta_threads_create_container($post['midia_tipo'] === 'video' ? 'VIDEO' : 'IMAGE', $text, (string)$post['imagem_url'], $error);
        }
        if ($containerId === null || $containerId === '') {
            $pdo->prepare("UPDATE social_posts SET status = 'erro', erro_msg = ? WHERE id = ?")
                ->execute([mb_substr('Threads: ' . ($error ?? 'falha ao criar container'), 0, 500), $post['id']]);
            echo "post {$post['id']}: falha ao criar container no Threads — {$error}\n";
        } else {
            $pdo->prepare("UPDATE social_posts SET meta_container_id = ? WHERE id = ?")->execute([$containerId, $post['id']]);
            echo "post {$post['id']}: container do Threads criado ({$containerId}), publica na próxima etapa\n";
        }
        continue;
    }

    // Facebook Story: single synchronous call, no multi-container dance —
    // same low risk as a normal API request, not the carousel's failure mode.
    if ($post['canal'] === 'facebook' && $post['tipo'] === 'story') {
        $isVideo = $post['midia_tipo'] === 'video';
        $fbStoryId = meta_publish_facebook_story($post['imagem_url'], $isVideo, $error);
        if ($fbStoryId === null) {
            $pdo->prepare("UPDATE social_posts SET status = 'erro', erro_msg = ? WHERE id = ?")
                ->execute([$error, $post['id']]);
            echo "post {$post['id']}: falha ao publicar story do Facebook — {$error}\n";
        } else {
            $pdo->prepare("UPDATE social_posts SET status = 'publicado', meta_post_id = ? WHERE id = ?")
                ->execute([$fbStoryId, $post['id']]);
            echo "post {$post['id']}: story do Facebook publicado ({$fbStoryId})\n";
        }
        continue;
    }

    // Carrossel em várias execuções: aqui só cria as lâminas. Antes era tudo de uma vez,
    // esperando até 180 s por lâmina de vídeo; o servidor encerrava o cron no meio e o
    // post ficava preso em 'processando' (publicado ou não: 24, 27 e 29/10/2026).
    if ($post['tipo'] === 'carousel') {
        $urls = json_decode((string)$post['carousel_urls'], true);
        $children = is_array($urls) && count($urls) >= 2 ? meta_create_instagram_carousel_children($urls, $error) : null;
        if ($children === null) {
            $pdo->prepare("UPDATE social_posts SET status = 'erro', erro_msg = ? WHERE id = ?")
                ->execute([$error ?? 'carousel_urls inválido ou com menos de 2 itens', $post['id']]);
            echo "post {$post['id']}: falha ao criar lâminas do carrossel — {$error}\n";
        } else {
            $pdo->prepare("UPDATE social_posts SET carousel_children = ? WHERE id = ?")->execute([json_encode($children), $post['id']]);
            echo "post {$post['id']}: " . count($children) . " lâminas criadas, carrossel monta quando ficarem prontas\n";
        }
        continue;
    }

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

// Carrossel: lâminas. Confere as lâminas criadas na fase 1 (uma consulta rápida por
// lâmina, sem esperar) e, quando todas estão prontas, cria o carrossel e grava o
// container em meta_container_id: a partir daí a fase 2 (Instagram) ou a fase do
// Threads publica como qualquer outro post.
$montando = $pdo->query(
    "SELECT * FROM social_posts WHERE tipo = 'carousel' AND status = 'processando'"
    . " AND meta_container_id IS NULL AND carousel_children IS NOT NULL"
)->fetchAll();
foreach ($montando as $post) {
    $error = null;
    $children = json_decode((string)$post['carousel_children'], true) ?: [];
    $threads = $post['canal'] === 'threads';
    if ($threads) {
        $urls = array_slice(json_decode((string)$post['carousel_urls'], true) ?: [], 0, 10);
        if (count($children) < count($urls)) {
            // No máximo 4 lâminas por execução, salvando cada uma: se o cron for
            // interrompido, a próxima execução continua de onde parou.
            foreach (array_slice($urls, count($children), 4) as $u) {
                $isVid = (bool)preg_match('/\.(mp4|mov)(\?|$)/i', (string)$u);
                $child = meta_threads_create_container($isVid ? 'VIDEO' : 'IMAGE', '', (string)$u, $error, true);
                if ($child === null || $child === '') {
                    $pdo->prepare("UPDATE social_posts SET status = 'erro', erro_msg = ? WHERE id = ?")
                        ->execute([mb_substr('Threads: lâmina ' . (count($children) + 1) . ' — ' . ($error ?? 'falha ao criar'), 0, 500), $post['id']]);
                    echo "post {$post['id']}: falha ao criar lâmina no Threads — {$error}\n";
                    continue 2;
                }
                $children[] = $child;
                $pdo->prepare("UPDATE social_posts SET carousel_children = ? WHERE id = ?")->execute([json_encode($children), $post['id']]);
            }
            echo "post {$post['id']}: " . count($children) . '/' . count($urls) . " lâminas criadas no Threads\n";
            if (count($children) < count($urls)) continue;
        }
    }
    $pendente = false;
    foreach ($children as $child) {
        $st = $threads ? meta_threads_container_status($child, $error) : meta_get_instagram_container_status($child, $error);
        if ($st === 'ERROR' || $st === 'EXPIRED') {
            $pdo->prepare("UPDATE social_posts SET status = 'erro', erro_msg = ? WHERE id = ?")
                ->execute([mb_substr("lâmina {$child} com {$st}" . ($error ? " — {$error}" : ''), 0, 500), $post['id']]);
            echo "post {$post['id']}: lâmina com {$st}\n";
            continue 2;
        }
        if ($st !== 'FINISHED') { $pendente = true; break; }
    }
    if ($pendente) {
        // lâminas de vídeo levam alguns minutos; depois de 2 h, desiste e avisa no painel
        if (strtotime((string)$post['agendado_para']) < time() - 7200) {
            $pdo->prepare("UPDATE social_posts SET status = 'erro', erro_msg = ? WHERE id = ?")
                ->execute(['lâminas do carrossel não ficaram prontas em 2 h', $post['id']]);
            echo "post {$post['id']}: lâminas não ficaram prontas em 2 h\n";
        } else {
            echo "post {$post['id']}: lâminas ainda processando\n";
        }
        continue;
    }
    $parent = $threads
        ? meta_threads_create_container('CAROUSEL', (string)$post['legenda'], null, $error, false, $children)
        : meta_create_instagram_carousel_parent($children, (string)$post['legenda'], $error);
    if ($parent === null || $parent === '') {
        $pdo->prepare("UPDATE social_posts SET status = 'erro', erro_msg = ? WHERE id = ?")
            ->execute([mb_substr('carrossel: ' . ($error ?? 'falha ao criar o carrossel'), 0, 500), $post['id']]);
        echo "post {$post['id']}: falha ao criar o carrossel — {$error}\n";
        continue;
    }
    $pdo->prepare("UPDATE social_posts SET meta_container_id = ? WHERE id = ?")->execute([$parent, $post['id']]);
    echo "post {$post['id']}: carrossel montado ({$parent}), publica quando o container ficar pronto\n";
}

// Threads — publica containers criados na Fase 1 assim que ficarem
// FINISHED (texto e imagem costumam ficar prontos na hora; vídeo em segundos
// ou minutos). Nada de esperar aqui dentro: se ainda processa, tenta na
// próxima rodada do cron. Vem antes da Fase 2 e da conferência do Facebook:
// em 08-09/11/2026 a conferência de 93 posts antigos do Facebook gastava o
// tempo do cron e esta etapa, que ficava no fim do arquivo, nunca rodava.
$threadsProcessing = $pdo->query(
    "SELECT * FROM social_posts WHERE canal = 'threads' AND status = 'processando' AND meta_container_id IS NOT NULL"
)->fetchAll();
foreach ($threadsProcessing as $post) {
    $error = null;
    $status = meta_threads_container_status($post['meta_container_id'], $error);
    if ($status === 'FINISHED') {
        $publishedId = meta_threads_publish($post['meta_container_id'], $error);
        if ($publishedId === null || $publishedId === '') {
            $pdo->prepare("UPDATE social_posts SET status = 'erro', erro_msg = ? WHERE id = ?")
                ->execute([mb_substr('Threads: ' . ($error ?? 'falha ao publicar'), 0, 500), $post['id']]);
            echo "post {$post['id']}: falha ao publicar no Threads — {$error}\n";
        } else {
            $pdo->prepare("UPDATE social_posts SET status = 'publicado', meta_post_id = ? WHERE id = ?")
                ->execute([$publishedId, $post['id']]);
            echo "post {$post['id']}: publicado no Threads ({$publishedId})\n";
        }
    } elseif ($status === 'ERROR' || $status === 'EXPIRED') {
        $pdo->prepare("UPDATE social_posts SET status = 'erro', erro_msg = ? WHERE id = ?")
            ->execute([mb_substr('Threads: ' . ($error ?: $status), 0, 500), $post['id']]);
        echo "post {$post['id']}: container do Threads com {$status}\n";
    } else {
        echo "post {$post['id']}: Threads ainda processando ({$status})\n";
    }
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

        // Story auto cross-post: same media also goes out as a Facebook Page
        // Story right after the Instagram one succeeds. Best-effort — a
        // failure here never rolls back or retries the Instagram side.
        if ($post['tipo'] === 'story') {
            $fbError = null;
            $fbIsVideo = $post['midia_tipo'] === 'video';
            $fbStoryId = meta_publish_facebook_story($post['imagem_url'], $fbIsVideo, $fbError);
            if ($fbStoryId === null) {
                $pdo->prepare("UPDATE social_posts SET fb_story_status = 'erro', fb_story_erro = ? WHERE id = ?")
                    ->execute([$fbError, $post['id']]);
                echo "post {$post['id']}: falha ao replicar story pro Facebook — {$fbError}\n";
            } else {
                $pdo->prepare("UPDATE social_posts SET fb_story_status = 'publicado', fb_story_id = ? WHERE id = ?")
                    ->execute([$fbStoryId, $post['id']]);
                echo "post {$post['id']}: story replicado pro Facebook ({$fbStoryId})\n";
            }
        }
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
    "SELECT * FROM social_posts WHERE canal = 'facebook' AND status = 'agendado_meta' AND meta_post_id IS NOT NULL"
    . " AND agendado_para <= NOW() AND agendado_para >= NOW() - INTERVAL 3 DAY ORDER BY agendado_para LIMIT 10"
)->fetchAll();
// Só os últimos 3 dias, no máximo 10 por execução: os ids guardados dos Reels do
// Facebook não aceitam mais consulta ("singular statuses API is deprecated") e as
// 93 linhas que nunca confirmavam eram consultadas a cada minuto, para sempre.

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

// Renovação diária do token do Threads (o cron próprio, cron_threads_token.php,
// nunca foi registrado na Hostinger). Fica por último porque aquele arquivo
// termina com exit. A marca fica fora do public_html, que o deploy substitui.
$marcaThreads = dirname(__DIR__) . '/.threads_token_renovado';
if (!is_file($marcaThreads) || filemtime($marcaThreads) < time() - 20 * 3600) {
    @touch($marcaThreads);
    require __DIR__ . '/cron_threads_token.php';
}
