<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: acrescenta a chamada da Black Friday nas legendas dos posts de conteúdo ainda pendentes de 13 a 21/11
// (trechos de aula e carrosséis do lote 7) no Instagram e no Threads. Facebook já agendado na Meta não é editável.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$pdo = db();
$igLinha = "🖤 Black Friday: este curso + Excel, Power BI, Python e Inglês, os 4 por R$ 119,90 (acesso vitalício) até 30/11. Comente BLACK que eu te mando o link.";
$thLinha = "\n\n🖤 Black Friday: os 4 cursos por R$ 119,90 até 30/11: techsantos.com.br/black-friday.php";
$rows = $pdo->query("SELECT id, canal, tipo, legenda FROM social_posts
    WHERE canal IN ('instagram','threads') AND status = 'pendente' AND tipo IN ('reels','carousel')
      AND agendado_para BETWEEN '2026-11-13 00:00:00' AND '2026-11-22 02:59:59'
      AND imagem_url NOT LIKE '%promo-bf%' AND legenda NOT LIKE '%Black Friday%'")->fetchAll();
$up = $pdo->prepare('UPDATE social_posts SET legenda = ? WHERE id = ?');
foreach ($rows as $r) {
    $leg = (string)$r['legenda'];
    if ($r['canal'] === 'instagram') {
        // entra antes das hashtags, para não ficar escondida no fim
        $pos = strrpos($leg, "\n\n#");
        $nova = $pos === false ? $leg . "\n\n" . $igLinha : substr($leg, 0, $pos) . "\n\n" . $igLinha . substr($leg, $pos);
        if (mb_strlen($nova) > 2200) { echo "#{$r['id']} IG longa demais, pulada\n"; continue; }
    } else {
        $nova = $leg . $thLinha;
        if (mb_strlen($nova) > 500) { echo "#{$r['id']} Threads longa demais, pulada\n"; continue; }
    }
    $up->execute([$nova, $r['id']]);
    echo "#{$r['id']} {$r['canal']} {$r['tipo']} OK\n";
}
echo count($rows) . " candidatos\n";
