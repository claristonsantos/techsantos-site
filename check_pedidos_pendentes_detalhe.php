<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$stmt = $pdo->query("SELECT p.id, p.nome, p.email, p.valor_centavos, p.criado_em, p.mercadopago_preference_id, p.lembrete_enviado, c.nome AS curso_nome FROM pedidos p JOIN cursos c ON c.id=p.curso_id WHERE p.status='pendente' ORDER BY p.criado_em");
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
    echo "#{$r['id']} {$r['nome']} <{$r['email']}> R$" . number_format($r['valor_centavos']/100,2,',','.') . " curso={$r['curso_nome']} criado={$r['criado_em']} lembrete_enviado={$r['lembrete_enviado']} pref={$r['mercadopago_preference_id']}\n";
}
@unlink(__FILE__);
