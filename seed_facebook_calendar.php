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

// Facebook Page organic is basically dormant (6 posts/30d, <50 impressions
// each) while Instagram is mid-fatigue (reach down 89% over 4 days as of
// 22/07) — moving already-produced, unused material to Facebook instead of
// making more Instagram content. Feed posts use Meta's native scheduler
// (published now via meta_schedule_facebook_post, no cron involved).
// Stories queue as 'pendente' for social_publish_cron.php's new Facebook
// Story branch (extended 23/07 to support this — previously that branch
// only existed as an Instagram-Story auto-cross-post trigger).

$ins = $pdo->prepare(
    'INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, agendado_para, status, meta_post_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
);

function schedule_fb_feed(PDO $pdo, PDOStatement $ins, string $legenda, string $imageUrl, string $agendadoParaUtc, array &$out): void
{
    $ts = strtotime($agendadoParaUtc . ' UTC');
    $error = null;
    $postId = meta_schedule_facebook_post($legenda, $imageUrl, $ts, $error);
    if ($postId === null) {
        $ins->execute(['facebook', 'feed', 'imagem', $legenda, $imageUrl, $agendadoParaUtc, 'erro', null]);
        $out[] = "ERRO feed {$imageUrl} — {$error}";
    } else {
        $ins->execute(['facebook', 'feed', 'imagem', $legenda, $imageUrl, $agendadoParaUtc, 'agendado_meta', $postId]);
        $out[] = "Agendado (Meta) feed: {$imageUrl} para {$agendadoParaUtc} UTC (post_id {$postId})";
    }
}

function queue_fb_story(PDOStatement $ins, string $videoUrl, string $agendadoParaUtc, array &$out): void
{
    $ins->execute(['facebook', 'story', 'video', '', $videoUrl, $agendadoParaUtc, 'pendente', null]);
    $out[] = "Enfileirado story: {$videoUrl} para {$agendadoParaUtc} UTC (cron publica na hora)";
}

// 24/07 09h BRT
schedule_fb_feed(
    $pdo, $ins,
    "R\$ 697 mil em faturamento monitorado em tempo real — um dos projetos de BI que já entregamos.\n\nDashboard comercial em Power BI: receita, margem e meta, tudo atualizado sozinho, decisão baseada em dado.\n\nQuer um assim pro seu negócio — clique no link abaixo: https://techsantos.com.br/servicos.html",
    'https://techsantos.com.br/assets/social-feed/resultado-projeto.png',
    '2026-07-24 12:00:00', $out
);

// 25/07 09h BRT
queue_fb_story($ins, 'https://techsantos.com.br/assets/social-video/storytime-mapa-continente.mp4', '2026-07-25 12:00:00', $out);

// 26/07 09h BRT
queue_fb_story($ins, 'https://techsantos.com.br/assets/social-video/storytime-slider-preco.mp4', '2026-07-26 12:00:00', $out);

// 27/07 09h BRT
schedule_fb_feed(
    $pdo, $ins,
    "Quem é a Tech Santos BR.\n\n+50 projetos de BI entregues, parceiro Microsoft desde 2021, atendimento 100% remoto — sede em Itumbiara-GO, mas atende o Brasil inteiro.\n\nConheça nossos projetos — clique no link abaixo: https://techsantos.com.br/projetos.html",
    'https://techsantos.com.br/assets/social-feed/institucional.png',
    '2026-07-27 12:00:00', $out
);

// 28/07 09h BRT
queue_fb_story($ins, 'https://techsantos.com.br/assets/social-video/storytime-numero-duplicado.mp4', '2026-07-28 12:00:00', $out);

// 29/07 09h BRT
schedule_fb_feed(
    $pdo, $ins,
    "Curso Power BI Completo — R\$ 129,90.\n\nAcesso vitalício, certificado ao final, e você assiste a aula grátis antes de decidir se é pra você.\n\nMatricule-se — clique no link abaixo: https://techsantos.com.br/comprar.php",
    'https://techsantos.com.br/assets/social-feed/oferta-curso.png',
    '2026-07-29 12:00:00', $out
);

// 30/07 09h BRT
queue_fb_story($ins, 'https://techsantos.com.br/assets/social-video/storytime-whatif-preco.mp4', '2026-07-30 12:00:00', $out);

// 31/07 09h BRT
schedule_fb_feed(
    $pdo, $ins,
    "+22 mil visualizações no nosso canal do YouTube — tutoriais práticos de Power BI, toda semana.\n\nSe você aprende vendo na prática, o canal é seu próximo passo antes (ou depois) do curso completo.\n\nInscreva-se — clique no link abaixo: https://www.youtube.com/@claristonsantos8129?sub_confirmation=1",
    'https://techsantos.com.br/assets/social-feed/repost-youtube.png',
    '2026-07-31 12:00:00', $out
);

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
