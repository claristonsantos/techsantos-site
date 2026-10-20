<?php
declare(strict_types=1);
// Descadastro da sequência de e-mails dos leads da aula grátis (link no rodapé de cada e-mail).
require_once __DIR__ . '/lead_nutricao.php';

$id = (int)($_GET['l'] ?? 0);
$token = (string)($_GET['t'] ?? '');
$ok = false;
if ($id > 0 && hash_equals(nutricao_token($id), $token)) {
    $pdo = db(); nutricao_ensure($pdo);
    $pdo->prepare('UPDATE whatsapp_leads SET nutricao_optout = 1 WHERE id = ?')->execute([$id]);
    $ok = true;
}
?><!doctype html>
<html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="robots" content="noindex">
<title>Descadastro — TECH SANTOS BR</title>
<style>body{font-family:Arial,Helvetica,sans-serif;background:#F5F6F1;color:#10192B;margin:0;padding:48px 16px}main{max-width:520px;margin:auto;background:#fff;border:1px solid #DBDECF;border-radius:8px;padding:28px}a{color:#0F2440}</style></head>
<body><main>
<?php if ($ok): ?>
<h1 style="font-size:20px">Pronto, você não vai mais receber esses e-mails.</h1>
<p>Se mudar de ideia, as aulas grátis continuam em <a href="/aula-gratis.php">techsantos.com.br/aula-gratis.php</a>.</p>
<?php else: ?>
<h1 style="font-size:20px">Link inválido</h1>
<p>Não conseguimos identificar o seu cadastro. Responda qualquer e-mail nosso pedindo o descadastro, que fazemos manualmente.</p>
<?php endif; ?>
</main></body></html>
