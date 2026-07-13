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
$base = 'https://techsantos.com.br';
$wa = '(64) 99290-5785';

// 1) Facebook posts using promo-curso-*/dica-* images: re-schedule so Meta
// fetches the new image content at the same URL (Meta downloads the photo at
// schedule time, so swapping the file alone doesn't update an already-scheduled post).
$stmt = $pdo->query("SELECT * FROM social_posts WHERE canal = 'facebook' AND status = 'agendado_meta' AND (imagem_url LIKE '%promo-curso-%' OR imagem_url LIKE '%dica-%')");
foreach ($stmt->fetchAll() as $post) {
    $apiError = null;
    if ($post['meta_post_id']) {
        meta_delete_facebook_post($post['meta_post_id'], $apiError);
    }
    $ts = strtotime($post['agendado_para'] . ' UTC');
    $apiError = null;
    $newId = meta_schedule_facebook_post($post['legenda'], $post['imagem_url'], $ts, $apiError);
    if ($newId === null) {
        $pdo->prepare("UPDATE social_posts SET status = 'erro', erro_msg = ? WHERE id = ?")->execute([$apiError, $post['id']]);
        $out[] = "FB #{$post['id']} ({$post['agendado_para']}): FALHOU ao reagendar — {$apiError}";
    } else {
        $pdo->prepare("UPDATE social_posts SET status = 'agendado_meta', meta_post_id = ? WHERE id = ?")->execute([$newId, $post['id']]);
        $out[] = "FB #{$post['id']} ({$post['agendado_para']}): reagendado com imagem nova (id {$newId})";
    }
}

// 2) Cancel/remove the 3 client-screenshot posts (Facebook: cancel on Meta too; Instagram: just delete, container was never created)
$stmt = $pdo->query("SELECT * FROM social_posts WHERE imagem_url LIKE '%goiasa%' OR imagem_url LIKE '%nankarana%' OR imagem_url LIKE '%iapredcare%'");
$slots = []; // remember timestamps grouped, to reuse for the replacement posts
foreach ($stmt->fetchAll() as $post) {
    if ($post['canal'] === 'facebook' && $post['status'] === 'agendado_meta' && $post['meta_post_id']) {
        $apiError = null;
        meta_delete_facebook_post($post['meta_post_id'], $apiError);
    }
    $slots[$post['agendado_para']] = true;
    $pdo->prepare('DELETE FROM social_posts WHERE id = ?')->execute([$post['id']]);
    $out[] = "Removido post com print de cliente: #{$post['id']} ({$post['canal']}, {$post['agendado_para']})";
}
$slotTimes = array_keys($slots);
sort($slotTimes);

// 3) Create the 3 replacement "sobre a empresa" posts at the same time slots
$replacements = [
    [
        'imagem' => $base . '/assets/img/sobre-projetos.jpg',
        'fb' => "Mais de 50 projetos de BI implementados.\n\nConsultoria e sustentação de Data Warehouse em Power BI, com parceria Microsoft Partner Network desde 2021 — do diagnóstico ao painel em produção.\n\nConheça nossos serviços — clique no link abaixo:\n{$base}/servicos.html",
        'ig' => "Mais de 50 projetos de BI implementados.\n\nConsultoria e sustentação de Data Warehouse em Power BI, com parceria Microsoft Partner Network desde 2021.\n\nConheça nossos serviços: link na bio.",
    ],
    [
        'imagem' => $base . '/assets/img/sobre-setores.jpg',
        'fb' => "BI aplicado a diferentes tipos de negócio.\n\nJá implementamos painéis de Power BI em agroindústria, varejo de moda, indústria, serviços contábeis e organizações religiosas — cada um com o próprio conjunto de métricas.\n\nFala com a gente — clique no link abaixo:\nhttps://wa.me/5564992905785",
        'ig' => "BI aplicado a diferentes tipos de negócio.\n\nJá implementamos painéis de Power BI em agroindústria, varejo de moda, indústria, serviços contábeis e organizações religiosas.\n\nFala com a gente: WhatsApp {$wa}.",
    ],
    [
        'imagem' => $base . '/assets/img/sobre-prazo.jpg',
        'fb' => "Prazo médio de ~30 dias pra um projeto de baixa complexidade.\n\nSediados em Itumbiara-GO, com atendimento remoto pra todo o Brasil — do primeiro diagnóstico ao painel em produção.\n\nFala com a gente — clique no link abaixo:\nhttps://wa.me/5564992905785",
        'ig' => "Prazo médio de ~30 dias pra um projeto de baixa complexidade.\n\nSediados em Itumbiara-GO, com atendimento remoto pra todo o Brasil.\n\nFala com a gente: WhatsApp {$wa}.",
    ],
];

$ins = $pdo->prepare('INSERT INTO social_posts (canal, legenda, imagem_url, agendado_para, status, meta_post_id) VALUES (?, ?, ?, ?, ?, ?)');

foreach ($slotTimes as $i => $dataHora) {
    if (!isset($replacements[$i])) {
        continue;
    }
    $r = $replacements[$i];
    $ts = strtotime($dataHora . ' UTC');

    $apiError = null;
    $postId = meta_schedule_facebook_post($r['fb'], $r['imagem'], $ts, $apiError);
    if ($postId === null) {
        $ins->execute(['facebook', $r['fb'], $r['imagem'], $dataHora, 'erro', null]);
        $out[] = "Facebook {$dataHora}: FALHOU — {$apiError}";
    } else {
        $ins->execute(['facebook', $r['fb'], $r['imagem'], $dataHora, 'agendado_meta', $postId]);
        $out[] = "Facebook {$dataHora}: agendado novo (id {$postId})";
    }

    $ins->execute(['instagram', $r['ig'], $r['imagem'], $dataHora, 'pendente', null]);
    $out[] = "Instagram {$dataHora}: enfileirado (pendente)";
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
