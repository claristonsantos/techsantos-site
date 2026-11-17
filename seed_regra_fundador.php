<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: comentar FUNDADOR dispara DM com o link da lista de pré-venda do Power BI com IA. Idempotente.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$pdo = db();
$palavra = 'FUNDADOR';
$msg = "Oi! Recebi seu comentário 🙌 Aqui está a lista do minicurso Power BI com IA, com preço de fundador de R\$ 47 (depois R\$ 97): https://techsantos.com.br/power-bi-com-ia.php?utm_source=instagram&utm_medium=dm&utm_campaign=pre-venda-pbi-ia — entrar na lista é grátis, você só decide se compra no lançamento.";
$st = $pdo->prepare('SELECT id FROM social_auto_reply_rules WHERE palavra_chave = ?');
$st->execute([$palavra]);
if ($id = $st->fetchColumn()) { echo "JA_EXISTE|{$id}\n"; exit; }
$pdo->prepare('INSERT INTO social_auto_reply_rules (palavra_chave, mensagem, ativo) VALUES (?, ?, 1)')->execute([$palavra, $msg]);
echo "OK|" . $pdo->lastInsertId() . "\n";
