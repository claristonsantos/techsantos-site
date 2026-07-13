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

$posts = [
    [
        'ts' => 1784116800, // qua 15/07 09:00 BRT
        'imagem' => $base . '/assets/img/promo-curso-1.jpg',
        'fb' => "Power BI, do dado bruto ao dashboard pronto pra decisão.\n\nNosso curso completo tem 12 módulos — modelagem de dados, Power Query, DAX e relatórios — pensado pra quem já usa Excel e quer parar de repetir o mesmo PROCV toda semana.\n\nAssista a uma aula grátis antes de decidir: {$base}/aula-gratis.php",
        'ig' => "Power BI, do dado bruto ao dashboard pronto pra decisão.\n\n12 módulos — modelagem de dados, Power Query, DAX e relatórios — pra quem já usa Excel e quer parar de repetir o mesmo PROCV toda semana.\n\nAula grátis no link da bio.",
    ],
    [
        'ts' => 1784203200, // qui 16/07 09:00 BRT
        'imagem' => $base . '/assets/img/promo-curso-2.jpg',
        'fb' => "Você ainda repete o mesmo PROCV toda semana?\n\nSe você é do financeiro, contábil, coordena uma área, está em transição de carreira ou toca o próprio negócio, o curso de Power BI da TECH SANTOS BR foi pensado pra parar esse ciclo.\n\nVeja se o curso é pra você: {$base}/curso-power-bi.php",
        'ig' => "Você ainda repete o mesmo PROCV toda semana?\n\nFinanceiro, contábil, coordenador de área, transição de carreira ou dono do próprio negócio — se você lida com dados no dia a dia, o curso foi pensado pra você.\n\nMais no link da bio.",
    ],
    [
        'ts' => 1784289600, // sex 17/07 09:00 BRT
        'imagem' => $base . '/assets/img/promo-curso-3.jpg',
        'fb' => "12 módulos, do primeiro conceito ao certificado.\n\nModelagem de Dados, Power Query, Fórmulas DAX, Relatórios & Dashboards, Publicação & Governança — tudo num curso só, no seu ritmo, com certificado ao final.\n\nCurrículo completo: {$base}/curso-power-bi.php#curriculo",
        'ig' => "12 módulos, do primeiro conceito ao certificado.\n\nModelagem de Dados, Power Query, DAX, Relatórios & Dashboards, Publicação & Governança — tudo num curso só, no seu ritmo.\n\nCurrículo completo no link da bio.",
    ],
];

$ins = $pdo->prepare('INSERT INTO social_posts (canal, legenda, imagem_url, agendado_para, status, meta_post_id) VALUES (?, ?, ?, ?, ?, ?)');

foreach ($posts as $p) {
    $dataHora = date('Y-m-d H:i:s', $p['ts']);

    // Facebook: schedule natively now
    $apiError = null;
    $postId = meta_schedule_facebook_post($p['fb'], $p['imagem'], $p['ts'], $apiError);
    if ($postId === null) {
        $ins->execute(['facebook', $p['fb'], $p['imagem'], $dataHora, 'erro', null]);
        $out[] = "Facebook {$dataHora}: FALHOU — {$apiError}";
    } else {
        $ins->execute(['facebook', $p['fb'], $p['imagem'], $dataHora, 'agendado_meta', $postId]);
        $out[] = "Facebook {$dataHora}: agendado (id {$postId})";
    }

    // Instagram: queue for the cron to pick up at the scheduled time
    $ins->execute(['instagram', $p['ig'], $p['imagem'], $dataHora, 'pendente', null]);
    $out[] = "Instagram {$dataHora}: enfileirado (pendente)";
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
