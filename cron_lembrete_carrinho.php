<?php
declare(strict_types=1);

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/mailer.php';

$pdo = db();

// Pedidos abandonados: pendentes há mais de 2h (tempo real pra desistir do
// pagamento, não abandono precoce) e criados nos últimos 7 dias (não reenviar
// pra pedidos antigos/de teste que já passaram do prazo de fazer sentido).
$pendentes = $pdo->query(
    "SELECT p.*, c.nome AS curso_nome
     FROM pedidos p
     JOIN cursos c ON c.id = p.curso_id
     WHERE p.status = 'pendente'
       AND p.lembrete_enviado = 0
       AND p.criado_em <= NOW() - INTERVAL 2 HOUR
       AND p.criado_em >= NOW() - INTERVAL 7 DAY"
)->fetchAll();

if (!$pendentes) {
    echo "nada pendente\n";
    exit;
}

foreach ($pendentes as $p) {
    $enviado = send_abandoned_cart_email(
        $p['email'],
        $p['nome'],
        ['nome' => $p['curso_nome']],
        $p['valor_centavos'] / 100
    );

    if ($enviado) {
        $pdo->prepare('UPDATE pedidos SET lembrete_enviado = 1 WHERE id = ?')->execute([$p['id']]);
        echo "pedido {$p['id']} ({$p['email']}): lembrete enviado\n";
    } else {
        echo "pedido {$p['id']} ({$p['email']}): FALHA ao enviar — tenta de novo na próxima execução\n";
    }
}
