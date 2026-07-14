<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();

$msgPreco = "Oi! O curso completo de Power BI custa R\$ 299,00 (à vista ou parcelado em até 12x). Detalhes e matrícula aqui: https://techsantos.com.br/curso-power-bi.php — qualquer dúvida, é só chamar!";
$msgCurso = "Oi! Que bom que você tem interesse no curso de Power BI 🙂 São 12 módulos, do básico ao avançado, 100% EAD e com certificado. Dá uma olhada aqui: https://techsantos.com.br/curso-power-bi.php";
$msgQuero = "Oi! Fico feliz com seu interesse 🙂 Você pode assistir a uma aula grátis pra conhecer o curso, ou já ir direto pra matrícula: https://techsantos.com.br/aula-gratis.php";
$msgDuvida = "Oi! Se quiser tirar dúvidas diretamente, chama a gente no WhatsApp: https://wa.me/5564992905785";

$rules = [
    ['PREÇO', $msgPreco],
    ['PRECO', $msgPreco],
    ['VALOR', $msgPreco],
    ['CURSO', $msgCurso],
    ['QUERO', $msgQuero],
    ['DÚVIDA', $msgDuvida],
    ['DUVIDA', $msgDuvida],
];

$pdo->exec("DELETE FROM social_auto_reply_rules WHERE palavra_chave = 'TESTAUTO'");

$ins = $pdo->prepare('INSERT INTO social_auto_reply_rules (palavra_chave, mensagem, ativo) VALUES (?, ?, 1)');
$out = ["Regra TESTAUTO removida."];
foreach ($rules as [$kw, $msg]) {
    $ins->execute([$kw, $msg]);
    $out[] = "Regra criada: \"{$kw}\" (id " . $pdo->lastInsertId() . ")";
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
