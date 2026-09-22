<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/mailer.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();

$ids = [29, 626];
$stmt = $pdo->prepare("SELECT p.*, c.nome AS curso_nome FROM pedidos p JOIN cursos c ON c.id=p.curso_id WHERE p.id = ? AND p.status='pendente'");
foreach ($ids as $id) {
    $stmt->execute([$id]);
    $p = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$p) { echo "SKIP|not found or not pendente|id={$id}\n"; continue; }
    $ok = send_abandoned_cart_email(
        $p['email'],
        $p['nome'],
        ['nome' => $p['curso_nome']],
        $p['valor_centavos'] / 100,
        (int)$p['id'],
        (string)($p['mercadopago_preference_id'] ?? '')
    );
    echo ($ok ? "OK" : "FAILED") . "|id={$id}|{$p['nome']}|{$p['email']}\n";
}
@unlink(__FILE__);
