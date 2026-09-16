<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$stmt = $pdo->prepare("SELECT id, nome, email, status, data_aula, pagamento_link, mercadopago_payment_id FROM aulas_particulares_leads WHERE nome LIKE ? ORDER BY id DESC");
$stmt->execute(['%Brunna%']);
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
    echo "#{$r['id']} {$r['nome']} <{$r['email']}> status={$r['status']} data_aula={$r['data_aula']} pagamento_link={$r['pagamento_link']} mp_payment_id={$r['mercadopago_payment_id']}\n";
}
@unlink(__FILE__);
