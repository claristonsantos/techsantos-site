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

$updates = [
    1784116800 => "Power BI, do dado bruto ao dashboard pronto pra decisão.\n\nNosso curso completo tem 12 módulos — modelagem de dados, Power Query, DAX e relatórios — pensado pra quem já usa Excel e quer parar de repetir o mesmo PROCV toda semana.\n\nAssista a uma aula grátis antes de decidir — clique no link abaixo:\n{$base}/aula-gratis.php",
    1784203200 => "Você ainda repete o mesmo PROCV toda semana?\n\nSe você é do financeiro, contábil, coordena uma área, está em transição de carreira ou toca o próprio negócio, o curso de Power BI da TECH SANTOS BR foi pensado pra parar esse ciclo.\n\nVeja se o curso é pra você — clique no link abaixo:\n{$base}/curso-power-bi.php",
    1784289600 => "12 módulos, do primeiro conceito ao certificado.\n\nModelagem de Dados, Power Query, Fórmulas DAX, Relatórios & Dashboards, Publicação & Governança — tudo num curso só, no seu ritmo, com certificado ao final.\n\nCurrículo completo — clique no link abaixo:\n{$base}/curso-power-bi.php#curriculo",
];

$find = $pdo->prepare("SELECT * FROM social_posts WHERE canal = 'facebook' AND status = 'agendado_meta' AND agendado_para = ?");
$updStmt = $pdo->prepare('UPDATE social_posts SET legenda = ?, meta_post_id = ?, status = ? WHERE id = ?');

foreach ($updates as $ts => $novaLegenda) {
    $dataHora = date('Y-m-d H:i:s', $ts);
    $find->execute([$dataHora]);
    $post = $find->fetch();

    if (!$post) {
        $out[] = "{$dataHora}: post não encontrado, pulado.";
        continue;
    }

    $apiError = null;
    if ($post['meta_post_id']) {
        meta_delete_facebook_post($post['meta_post_id'], $apiError);
    }

    $apiError = null;
    $newId = meta_schedule_facebook_post($novaLegenda, $post['imagem_url'], $ts, $apiError);

    if ($newId === null) {
        $updStmt->execute([$novaLegenda, null, 'erro', $post['id']]);
        $out[] = "{$dataHora}: FALHOU ao reagendar — {$apiError}";
    } else {
        $updStmt->execute([$novaLegenda, $newId, 'agendado_meta', $post['id']]);
        $out[] = "{$dataHora}: legenda atualizada, reagendado (id {$newId})";
    }
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
