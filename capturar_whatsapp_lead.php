<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'method_not_allowed']);
    exit;
}

$raw = file_get_contents('php://input');
$data = json_decode($raw, true) ?? $_POST;

$telefoneRaw = trim((string)($data['telefone'] ?? ''));
$origem = trim((string)($data['origem'] ?? 'aula-gratis'));

// Mantém só dígitos; exige um telefone brasileiro plausível (10-11 dígitos,
// com ou sem DDI 55).
$digits = preg_replace('/\D/', '', $telefoneRaw);
if ($digits === null || strlen($digits) < 10 || strlen($digits) > 13) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'telefone_invalido']);
    exit;
}

$origem = mb_substr($origem !== '' ? $origem : 'aula-gratis', 0, 100);

$pdo = db();
$stmt = $pdo->prepare('INSERT INTO whatsapp_leads (telefone, origem) VALUES (?, ?)');
$stmt->execute([$digits, $origem]);
$leadId = (int)$pdo->lastInsertId();

echo json_encode(['ok' => true]);

// Aviso imediato pro dono: lead de aula grátis esfria rápido, a primeira
// mensagem no WhatsApp precisa sair no mesmo dia. Resposta já foi enviada
// ao navegador antes do SMTP, pra não travar o desbloqueio das aulas.
if (function_exists('fastcgi_finish_request')) fastcgi_finish_request();
try {
    require_once __DIR__ . '/mailer.php';
    $e164 = str_starts_with($digits, '55') ? $digits : '55' . $digits;
    $msg = rawurlencode('Oi! Aqui é o Clariston, da TECH SANTOS BR. Vi que você liberou as aulas grátis do curso de Power BI — conseguiu assistir? Posso te ajudar com alguma dúvida?');
    $wa = 'https://wa.me/' . $e164 . '?text=' . $msg;
    $origemHtml = htmlspecialchars($origem, ENT_QUOTES);
    send_html_email(
        'claristonsantos@techsantos.com.br',
        'Novo lead (aula grátis): ' . $digits,
        '<p>Novo lead #' . $leadId . ' deixou o WhatsApp na aula grátis.</p><p><strong>Telefone:</strong> ' . $digits . '<br><strong>Origem:</strong> ' . $origemHtml . '</p><p><a href="' . $wa . '">Abrir conversa no WhatsApp</a> · <a href="https://techsantos.com.br/admin/leads-curso.php">Pipeline de leads</a></p>',
        "Novo lead #{$leadId}: {$digits} ({$origem})\nWhatsApp: {$wa}"
    );
} catch (Throwable $e) {
    error_log('aviso lead ' . $leadId . ': ' . $e->getMessage());
}
