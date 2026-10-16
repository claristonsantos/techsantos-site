<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: cria a regra de resposta automática COMBO (Mês dos Professores) e mostra o status do primeiro post após a reconexão do IG.
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$msg = "Oi! 🎁 O combo do Mês dos Professores está aqui: https://techsantos.com.br/curso-power-bi.php\n\n"
     . "Comprando o curso de Power BI até 31/10, o curso de Excel completo (68 videoaulas, do básico às macros) é liberado junto, na mesma conta, sem pagar nada a mais. São R$ 129,90 pelos dois, com acesso vitalício.\n\n"
     . "Qualquer dúvida, é só responder aqui.";
$ja = $pdo->query("SELECT id FROM social_auto_reply_rules WHERE UPPER(palavra_chave)='COMBO' LIMIT 1")->fetchColumn();
if ($ja) echo "JA_EXISTE|id=$ja\n";
else {
    $pdo->prepare('INSERT INTO social_auto_reply_rules (palavra_chave, mensagem, ativo, prioridade) VALUES (?, ?, 1, 5)')->execute(['COMBO', $msg]);
    echo "CRIADA|id=" . $pdo->lastInsertId() . "\n";
}
foreach ($pdo->query("SELECT id, palavra_chave, ativo, prioridade, LEFT(REPLACE(mensagem,'\n',' '),90) m FROM social_auto_reply_rules WHERE palavra_chave IN ('COMBO','EXCEL') ") as $r) echo implode(' | ', $r), "\n";
foreach ($pdo->query("SELECT id, canal, status, LEFT(COALESCE(erro_msg,''),80) e FROM social_posts WHERE id IN (288,355,390)") as $r) echo implode(' | ', $r), "\n";
@unlink(__FILE__);
