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

$captions = [
    'promo-curso-1.jpg' => [
        'facebook' => "Power BI, do dado bruto ao dashboard pronto pra decisão.\n\n12 módulos — modelagem, Power Query, DAX e relatórios, no seu ritmo.\n\nAssista a uma aula grátis — clique no link abaixo:\n{$base}/aula-gratis.php",
        'instagram' => "Power BI, do dado bruto ao dashboard pronto pra decisão.\n\n12 módulos — modelagem, Power Query, DAX e relatórios, no seu ritmo.\n\nAssista a uma aula grátis: link na bio.",
    ],
    'promo-curso-2.jpg' => [
        'facebook' => "Você ainda repete o mesmo PROCV toda semana?\n\nO curso de Power BI da Tech Santos BR é pra quem trabalha com financeiro, coordena uma área, tá em transição de carreira ou empreende e cansou de planilha manual.\n\nVeja se é pra você — clique no link abaixo:\n{$base}/curso-power-bi.php",
        'instagram' => "Você ainda repete o mesmo PROCV toda semana?\n\nO curso de Power BI da Tech Santos BR é pra quem trabalha com financeiro, coordena uma área, tá em transição de carreira ou empreende e cansou de planilha manual.\n\nVeja se é pra você: link na bio.",
    ],
    'promo-curso-3.jpg' => [
        'facebook' => "12 módulos, do primeiro conceito ao certificado.\n\nModelagem de Dados, Power Query (ETL), Fórmulas DAX, Relatórios & Dashboards, Publicação & Governança.\n\nVeja o currículo completo — clique no link abaixo:\n{$base}/curso-power-bi.php",
        'instagram' => "12 módulos, do primeiro conceito ao certificado.\n\nModelagem de Dados, Power Query (ETL), Fórmulas DAX, Relatórios & Dashboards, Publicação & Governança.\n\nVeja o currículo completo: link na bio.",
    ],
    'dica-excel-procx.jpg' => [
        'facebook' => "PROCV travando quando a planilha cresce?\n\nTroque pelo PROCX (XLOOKUP): busca em qualquer direção, é mais rápido e não quebra quando você insere uma coluna no meio da tabela.\n\nMais dicas como essa — clique no link abaixo:\n{$base}/servicos.html",
        'instagram' => "PROCV travando quando a planilha cresce?\n\nTroque pelo PROCX (XLOOKUP): busca em qualquer direção, é mais rápido e não quebra quando você insere uma coluna no meio da tabela.\n\nMais dicas como essa: link na bio.",
    ],
    'dica-powerbi-import.jpg' => [
        'facebook' => "Import ou DirectQuery: qual escolher?\n\nImport copia os dados pro arquivo — mais rápido, mas precisa de atualização programada. DirectQuery consulta a fonte em tempo real, só que é mais lento e limitado. Na dúvida: comece com Import.\n\nMais dicas como essa — clique no link abaixo:\n{$base}/servicos.html",
        'instagram' => "Import ou DirectQuery: qual escolher?\n\nImport copia os dados pro arquivo — mais rápido, mas precisa de atualização programada. DirectQuery consulta a fonte em tempo real, só que é mais lento e limitado. Na dúvida: comece com Import.\n\nMais dicas como essa: link na bio.",
    ],
    'sobre-projetos.jpg' => [
        'facebook' => "Mais de 50 projetos de BI implementados.\n\nConsultoria e sustentação de Data Warehouse em Power BI, com parceria Microsoft Partner Network desde 2021 — do diagnóstico ao painel em produção.\n\nConheça nossos serviços — clique no link abaixo:\n{$base}/servicos.html",
        'instagram' => "Mais de 50 projetos de BI implementados.\n\nConsultoria e sustentação de Data Warehouse em Power BI, com parceria Microsoft Partner Network desde 2021.\n\nConheça nossos serviços: link na bio.",
    ],
    'sobre-setores.jpg' => [
        'facebook' => "BI aplicado a diferentes tipos de negócio.\n\nJá implementamos painéis de Power BI em agroindústria, varejo de moda, indústria, serviços contábeis e organizações religiosas — cada um com o próprio conjunto de métricas.\n\nConheça nossos projetos — clique no link abaixo:\n{$base}/projetos.html",
        'instagram' => "BI aplicado a diferentes tipos de negócio.\n\nJá implementamos painéis de Power BI em agroindústria, varejo de moda, indústria, serviços contábeis e organizações religiosas.\n\nConheça nossos projetos: link na bio.",
    ],
    'sobre-prazo.jpg' => [
        'facebook' => "Prazo médio de ~30 dias pra um projeto de baixa complexidade.\n\nSediados em Itumbiara-GO, com atendimento remoto pra todo o Brasil — do primeiro diagnóstico ao painel em produção.\n\nFala com a gente — clique no link abaixo:\n{$base}/contato.html",
        'instagram' => "Prazo médio de ~30 dias pra um projeto de baixa complexidade.\n\nSediados em Itumbiara-GO, com atendimento remoto pra todo o Brasil.\n\nFala com a gente: link na bio.",
    ],
];

foreach ($captions as $imgName => $texts) {
    $stmt = $pdo->prepare("SELECT * FROM social_posts WHERE imagem_url LIKE ?");
    $stmt->execute(['%' . $imgName]);
    foreach ($stmt->fetchAll() as $post) {
        $canal = $post['canal'];
        $novaLegenda = $texts[$canal] ?? null;
        if ($novaLegenda === null) {
            continue;
        }

        if ($canal === 'facebook' && $post['status'] === 'agendado_meta' && $post['meta_post_id']) {
            $apiError = null;
            meta_delete_facebook_post($post['meta_post_id'], $apiError);
            $ts = strtotime($post['agendado_para'] . ' UTC');
            $apiError = null;
            $newId = meta_schedule_facebook_post($novaLegenda, $post['imagem_url'], $ts, $apiError);
            if ($newId === null) {
                $pdo->prepare("UPDATE social_posts SET status = 'erro', legenda = ?, erro_msg = ? WHERE id = ?")
                    ->execute([$novaLegenda, $apiError, $post['id']]);
                $out[] = "FB #{$post['id']} ({$imgName}, {$post['agendado_para']}): FALHOU ao reagendar — {$apiError}";
            } else {
                $pdo->prepare("UPDATE social_posts SET legenda = ?, status = 'agendado_meta', meta_post_id = ? WHERE id = ?")
                    ->execute([$novaLegenda, $newId, $post['id']]);
                $out[] = "FB #{$post['id']} ({$imgName}, {$post['agendado_para']}): reagendado com legenda nova (id {$newId})";
            }
        } else {
            $pdo->prepare("UPDATE social_posts SET legenda = ? WHERE id = ?")->execute([$novaLegenda, $post['id']]);
            $out[] = "{$canal} #{$post['id']} ({$imgName}, {$post['agendado_para']}): legenda atualizada";
        }
    }
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
