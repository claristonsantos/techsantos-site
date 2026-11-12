<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: troca o Reel de lançamento da Black Friday (13/11) no Instagram e no Threads pela versão
// estilo varejo com a identidade TECH SANTOS e locução mesclada. O Facebook (já agendado na Meta) fica como está.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$pdo = db();
$old = 'https://media.techsantos.com.br/reels/promo-bf-A.mp4';
$new = 'https://media.techsantos.com.br/reels/promo-bf-varejo-mesclada.mp4';
$cap = "ATENÇÃO! Black Friday Tech Santos!\n\nExcel de R$ 97,00. Power BI de R$ 129,90. Python de R$ 59,90. Inglês de R$ 49,90. Separados, R$ 336,70.\n\nNa Black Friday, os 4 cursos completos por R$ 119,90: 64% de desconto, acesso na hora e certificado em cada curso. Só até segunda, 30/11, às 23h59."
    . "\n\nComente BLACK que eu te mando o link no direct.\n\n#BlackFriday #PowerBI #Excel #Python #Ingles #AnaliseDeDados";
$th = "Black Friday Tech Santos: Excel + Power BI + Python + Inglês. Separados, R$ 336,70. Os 4 por R$ 119,90 até 30/11:\nhttps://techsantos.com.br/black-friday.php?utm_source=threads&utm_medium=social&utm_campaign=black-friday-2026";
foreach ([['instagram', $cap], ['threads', $th]] as [$canal, $leg]) {
    $u = $pdo->prepare("UPDATE social_posts SET imagem_url = ?, legenda = ? WHERE canal = ? AND imagem_url = ? AND status = 'pendente'");
    $u->execute([$new, $leg, $canal, $old]);
    echo strtoupper($canal) . " atualizados: " . $u->rowCount() . "\n";
}
foreach ($pdo->query("SELECT id, canal, status, agendado_para, SUBSTRING_INDEX(imagem_url,'/',-1) arq FROM social_posts WHERE imagem_url IN ('$old','$new') ORDER BY canal")->fetchAll() as $r) {
    echo implode(' | ', $r) . "\n";
}
