<?php
declare(strict_types=1);

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/mailer.php';
require_once __DIR__ . '/lead_nutricao.php';

$pdo = db();

// Segundo lembrete (24h depois do primeiro): coluna criada aqui na primeira execução.
$cols = array_column($pdo->query("SHOW COLUMNS FROM pedidos")->fetchAll(), 'Field');
if (!in_array('lembrete2_em', $cols, true)) $pdo->exec("ALTER TABLE pedidos ADD COLUMN lembrete2_em DATETIME NULL");

/** Aviso para o dono com o botão do WhatsApp pronto: contato pessoal recupera mais do que e-mail. */
function avisar_dono_pedido(array $p): void
{
    $fone = preg_replace('/\D/', '', (string)$p['telefone']);
    if (strlen($fone) < 10) return;
    $e164 = str_starts_with($fone, '55') ? $fone : '55' . $fone;
    $nome = explode(' ', trim((string)$p['nome']))[0];
    $msg = "Oi, {$nome}! Aqui é o Clariston, da Tech Santos BR. Vi que você começou a matrícula no {$p['curso_nome']} e não concluiu o pagamento. Ficou alguma dúvida? Posso te ajudar por aqui.";
    $wa = 'https://wa.me/' . $e164 . '?text=' . rawurlencode($msg);
    $valor = number_format($p['valor_centavos'] / 100, 2, ',', '.');
    $html = '<p>Pedido <strong>#' . (int)$p['id'] . '</strong> pendente há mais de 2h: ' . htmlspecialchars((string)$p['nome'], ENT_QUOTES) . ' · '
          . htmlspecialchars((string)$p['curso_nome'], ENT_QUOTES) . ' · R$ ' . $valor . '.</p><p>O cliente já recebeu o lembrete automático por e-mail. '
          . 'Uma mensagem sua no WhatsApp costuma converter mais:</p><p><a href="' . $wa . '" style="display:inline-block;background:#25D366;color:#fff;padding:10px 18px;border-radius:6px;text-decoration:none;font-weight:bold">Chamar no WhatsApp</a></p>';
    send_html_email(OWNER_COPY_EMAIL, "Pedido pendente #{$p['id']}: chame {$nome} no WhatsApp", $html, "Pedido pendente #{$p['id']} ({$p['curso_nome']}). WhatsApp: {$wa}");
}

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

foreach ($pendentes as $p) {
    $enviado = send_abandoned_cart_email(
        $p['email'],
        $p['nome'],
        ['nome' => $p['curso_nome']],
        $p['valor_centavos'] / 100,
        (int)$p['id'],
        (string)($p['mercadopago_preference_id'] ?? '')
    );

    if ($enviado) {
        $pdo->prepare('UPDATE pedidos SET lembrete_enviado = 1 WHERE id = ?')->execute([$p['id']]);
        avisar_dono_pedido($p);
        echo "pedido {$p['id']} ({$p['email']}): lembrete enviado\n";
    } else {
        echo "pedido {$p['id']} ({$p['email']}): FALHA ao enviar — tenta de novo na próxima execução\n";
    }
}

// Segundo e último lembrete, 24h depois: o mesmo e-mail de retomada (que já fala do parcelamento e do Pix).
$segundo = $pdo->query(
    "SELECT p.*, c.nome AS curso_nome
     FROM pedidos p
     JOIN cursos c ON c.id = p.curso_id
     WHERE p.status = 'pendente'
       AND p.lembrete_enviado = 1
       AND p.lembrete2_em IS NULL
       AND p.criado_em <= NOW() - INTERVAL 26 HOUR
       AND p.criado_em >= NOW() - INTERVAL 7 DAY"
)->fetchAll();
foreach ($segundo as $p) {
    if (send_abandoned_cart_email($p['email'], $p['nome'], ['nome' => $p['curso_nome']], $p['valor_centavos'] / 100, (int)$p['id'], (string)($p['mercadopago_preference_id'] ?? ''))) {
        $pdo->prepare('UPDATE pedidos SET lembrete2_em = NOW() WHERE id = ?')->execute([$p['id']]);
        echo "pedido {$p['id']}: segundo lembrete enviado\n";
    }
}

// Sequência de e-mails dos leads da aula grátis (etapas 2 e 3).
foreach (nutricao_processar($pdo) as $linha) echo $linha, "\n";

if (!$pendentes && !$segundo) echo "nenhum pedido pendente\n";
