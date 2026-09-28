<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$out = [];

$cols = $pdo->query("SHOW COLUMNS FROM social_auto_reply_rules LIKE 'prioridade'")->fetchAll();
if (!$cols) {
    $pdo->exec("ALTER TABLE social_auto_reply_rules ADD COLUMN prioridade INT NOT NULL DEFAULT 100 AFTER ativo");
    $out[] = 'Coluna prioridade criada (padrão 100).';
} else {
    $out[] = 'Coluna prioridade já existia.';
}

$regras = [
    ['EXCEL', "Oi! 🙌 Aqui está o curso de Excel do zero ao avançado, preparatório para as certificações Microsoft MO-210 e MO-211: 17 módulos, 68 aulas com áudio, 208 questões e certificado de conclusão.\n\nR$ 97 com acesso vitalício, no cartão em até 12x ou Pix:\nhttps://techsantos.com.br/curso-excel.php?utm_source=social&utm_medium=comentario&utm_campaign=curso_excel\n\nQualquer dúvida, é só responder aqui."],
    ['FABRIC', "Oi! 🙌 Aqui está o curso de Microsoft Fabric, preparatório para as certificações DP-600 e DP-700: 82 aulas em 15 módulos, cada uma também em áudio, 192 questões, 2 simulados e certificado de conclusão.\n\nR$ 129,90 com acesso vitalício, no cartão em até 12x ou Pix:\nhttps://techsantos.com.br/curso-microsoft-fabric.php?utm_source=social&utm_medium=comentario&utm_campaign=curso_fabric\n\nQualquer dúvida, é só responder aqui."],
];
$sel = $pdo->prepare('SELECT id FROM social_auto_reply_rules WHERE UPPER(palavra_chave) = ?');
$ins = $pdo->prepare('INSERT INTO social_auto_reply_rules (palavra_chave, mensagem, ativo, prioridade) VALUES (?, ?, 1, 10)');
$upd = $pdo->prepare('UPDATE social_auto_reply_rules SET mensagem = ?, ativo = 1, prioridade = 10 WHERE id = ?');
foreach ($regras as [$kw, $msg]) {
    $sel->execute([$kw]);
    $id = $sel->fetchColumn();
    if ($id) { $upd->execute([$msg, $id]); $out[] = "ATUALIZADA|{$kw}|id={$id}"; }
    else { $ins->execute([$kw, $msg]); $out[] = "CRIADA|{$kw}|id=" . $pdo->lastInsertId(); }
}

$out[] = '--- ordem de verificação ---';
foreach ($pdo->query('SELECT id, palavra_chave, prioridade, ativo FROM social_auto_reply_rules WHERE ativo = 1 ORDER BY prioridade ASC, id ASC') as $r) {
    $out[] = "#{$r['id']} prioridade={$r['prioridade']} {$r['palavra_chave']}";
}
echo implode("\n", $out) . "\n";
@unlink(__FILE__);
