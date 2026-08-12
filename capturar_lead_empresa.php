<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/mailer.php';

function business_lead_response(bool $ok, string $message, int $status = 200): never
{
    http_response_code($status);
    $accept = strtolower((string)($_SERVER['HTTP_ACCEPT'] ?? ''));
    if (str_contains($accept, 'application/json') || strtolower((string)($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '')) === 'xmlhttprequest') {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => $ok, 'message' => $message], JSON_UNESCAPED_UNICODE);
    } else {
        header('Location: /consultoria-power-bi.php?' . ($ok ? 'enviado=1' : 'erro=1') . '#diagnostico');
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    business_lead_response(false, 'Método não permitido.', 405);
}

$origin = (string)($_SERVER['HTTP_ORIGIN'] ?? '');
if ($origin !== '') {
    $originHost = strtolower((string)parse_url($origin, PHP_URL_HOST));
    if (!in_array($originHost, ['techsantos.com.br', 'www.techsantos.com.br'], true)) {
        business_lead_response(false, 'Origem não permitida.', 403);
    }
}

$data = $_POST;
if (str_contains(strtolower((string)($_SERVER['CONTENT_TYPE'] ?? '')), 'application/json')) {
    $decoded = json_decode((string)file_get_contents('php://input'), true);
    if (is_array($decoded)) {
        $data = $decoded;
    }
}

// Honeypot: bots costumam preencher este campo, pessoas não o veem.
if (trim((string)($data['website'] ?? '')) !== '') {
    business_lead_response(true, 'Recebido.');
}

$clean = static fn(string $field, int $limit): string => mb_substr(trim((string)($data[$field] ?? '')), 0, $limit);
$nome = $clean('nome', 120);
$empresa = $clean('empresa', 160);
$email = strtolower($clean('email', 190));
$telefone = preg_replace('/\D/', '', $clean('telefone', 30)) ?? '';
$sistemas = $clean('sistemas', 200);
$usuarios = $clean('usuarios', 60);
$objetivo = $clean('objetivo', 1500);
$origem = $clean('origem', 120) ?: 'consultoria-power-bi';
$consentimento = (string)($data['consentimento'] ?? '') === '1';

if ($nome === '' || $empresa === '' || $email === '' || $telefone === '' || $objetivo === '') {
    business_lead_response(false, 'Preencha nome, empresa, e-mail, telefone e objetivo.', 422);
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    business_lead_response(false, 'Informe um e-mail válido.', 422);
}
if (strlen($telefone) < 10 || strlen($telefone) > 13) {
    business_lead_response(false, 'Informe um telefone com DDD.', 422);
}
if (!$consentimento) {
    business_lead_response(false, 'Confirme o uso dos dados para receber o retorno.', 422);
}

$utm = [];
foreach (['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term', 'landing_page'] as $field) {
    $utm[$field] = $clean($field, $field === 'landing_page' ? 255 : 150);
}

$pdo = db();
$pdo->exec(<<<SQL
CREATE TABLE IF NOT EXISTS consultoria_leads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    empresa VARCHAR(160) NOT NULL,
    email VARCHAR(190) NOT NULL,
    telefone VARCHAR(30) NOT NULL,
    sistemas VARCHAR(200) NULL,
    usuarios VARCHAR(60) NULL,
    objetivo TEXT NOT NULL,
    origem VARCHAR(120) NOT NULL DEFAULT 'consultoria-power-bi',
    utm_source VARCHAR(150) NULL,
    utm_medium VARCHAR(150) NULL,
    utm_campaign VARCHAR(150) NULL,
    utm_content VARCHAR(150) NULL,
    utm_term VARCHAR(150) NULL,
    landing_page VARCHAR(255) NULL,
    ip_hash CHAR(64) NULL,
    status VARCHAR(30) NOT NULL DEFAULT 'novo',
    criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_consultoria_criado (criado_em),
    INDEX idx_consultoria_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
SQL);

$ipHash = hash('sha256', (string)($_SERVER['REMOTE_ADDR'] ?? '') . '|techsantos-consultoria');
$rate = $pdo->prepare('SELECT COUNT(*) FROM consultoria_leads WHERE ip_hash = ? AND criado_em >= DATE_SUB(NOW(), INTERVAL 1 HOUR)');
$rate->execute([$ipHash]);
if ((int)$rate->fetchColumn() >= 5) {
    business_lead_response(false, 'Limite de solicitações atingido. Fale conosco pelo WhatsApp.', 429);
}

$stmt = $pdo->prepare('INSERT INTO consultoria_leads (nome,empresa,email,telefone,sistemas,usuarios,objetivo,origem,utm_source,utm_medium,utm_campaign,utm_content,utm_term,landing_page,ip_hash) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
$stmt->execute([
    $nome, $empresa, $email, $telefone, $sistemas ?: null, $usuarios ?: null, $objetivo, $origem,
    $utm['utm_source'] ?: null, $utm['utm_medium'] ?: null, $utm['utm_campaign'] ?: null,
    $utm['utm_content'] ?: null, $utm['utm_term'] ?: null, $utm['landing_page'] ?: null, $ipHash,
]);
$leadId = (int)$pdo->lastInsertId();

$safe = static fn(string $value): string => htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
$subject = 'Novo diagnóstico empresarial #' . $leadId . ' — ' . $empresa;
$html = '<h1 style="font-size:20px">Nova solicitação de diagnóstico</h1>'
    . '<p><strong>Nome:</strong> ' . $safe($nome) . '</p>'
    . '<p><strong>Empresa:</strong> ' . $safe($empresa) . '</p>'
    . '<p><strong>E-mail:</strong> ' . $safe($email) . '</p>'
    . '<p><strong>Telefone:</strong> ' . $safe($telefone) . '</p>'
    . '<p><strong>Sistemas:</strong> ' . $safe($sistemas ?: 'Não informado') . '</p>'
    . '<p><strong>Usuários:</strong> ' . $safe($usuarios ?: 'Não informado') . '</p>'
    . '<p><strong>Objetivo:</strong><br>' . nl2br($safe($objetivo)) . '</p>'
    . '<p><strong>Origem:</strong> ' . $safe($origem) . '</p>';
$text = "Nova solicitação de diagnóstico #{$leadId}\nNome: {$nome}\nEmpresa: {$empresa}\nE-mail: {$email}\nTelefone: {$telefone}\nSistemas: {$sistemas}\nUsuários: {$usuarios}\nObjetivo: {$objetivo}\nOrigem: {$origem}";

try {
    send_html_email(MAIL_FROM, $subject, $html, $text);
} catch (Throwable $e) {
    error_log('Aviso de lead empresarial #' . $leadId . ': ' . $e->getMessage());
}

business_lead_response(true, 'Solicitação recebida. Vamos analisar o cenário e entrar em contato.');
