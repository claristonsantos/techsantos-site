<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/mailer.php';
require_once __DIR__ . '/aulas_particulares_automacao.php';

function lesson_lead_response(bool $ok, string $message, int $status = 200, array $data = []): never
{
    http_response_code($status);
    $json = str_contains(strtolower((string)($_SERVER['HTTP_ACCEPT'] ?? '')), 'application/json')
        || strtolower((string)($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '')) === 'xmlhttprequest';
    if ($json) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => $ok, 'message' => $message] + $data, JSON_UNESCAPED_UNICODE);
    } else {
        header('Location: /aulas-particulares-power-bi.php?' . ($ok ? 'enviado=1' : 'erro=1') . '#agendar');
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    lesson_lead_response(false, 'Método não permitido.', 405);
}

$origin = (string)($_SERVER['HTTP_ORIGIN'] ?? '');
if ($origin !== '') {
    $host = strtolower((string)parse_url($origin, PHP_URL_HOST));
    if (!in_array($host, ['techsantos.com.br', 'www.techsantos.com.br'], true)) {
        lesson_lead_response(false, 'Origem não permitida.', 403);
    }
}

$data = $_POST;
if (str_contains(strtolower((string)($_SERVER['CONTENT_TYPE'] ?? '')), 'application/json')) {
    $decoded = json_decode((string)file_get_contents('php://input'), true);
    if (is_array($decoded)) $data = $decoded;
}

if (trim((string)($data['website'] ?? '')) !== '') {
    lesson_lead_response(true, 'Recebido.');
}

$clean = static fn(string $field, int $limit): string => mb_substr(trim((string)($data[$field] ?? '')), 0, $limit);
$nome = $clean('nome', 120);
$email = strtolower($clean('email', 190));
$telefone = preg_replace('/\D/', '', $clean('telefone', 30)) ?? '';
$nivel = $clean('nivel', 60);
$interesse = $clean('interesse', 80);
$tema = $clean('tema', 1500);
$dataPreferida = $clean('data_preferida', 10);
$horaPreferida = $clean('hora_preferida', 2);
$disponibilidade = $dataPreferida !== '' && $horaPreferida !== '' ? $dataPreferida . 'T' . $horaPreferida . ':00' : '';
$consentimento = (string)($data['consentimento'] ?? '') === '1';

if ($nome === '' || $email === '' || $telefone === '' || $interesse === '' || $tema === '') {
    lesson_lead_response(false, 'Preencha nome, e-mail, telefone, formato e objetivo.', 422);
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    lesson_lead_response(false, 'Informe um e-mail válido.', 422);
}
if (strlen($telefone) < 10 || strlen($telefone) > 13) {
    lesson_lead_response(false, 'Informe um WhatsApp com DDD.', 422);
}
if ($disponibilidade === '') {
    lesson_lead_response(false, 'Escolha uma data e um horário para a aula.', 422);
}
$timezone = new DateTimeZone('America/Sao_Paulo');
$horarioPreferido = DateTimeImmutable::createFromFormat('!Y-m-d\TH:i', $disponibilidade, $timezone);
$horarioValido = $horarioPreferido && $horarioPreferido->format('Y-m-d\TH:i') === $disponibilidade;
if (!$horarioValido || $horarioPreferido <= new DateTimeImmutable('now', $timezone)) {
    lesson_lead_response(false, 'Escolha uma data e um horário futuros.', 422);
}
$diaSemana = (int)$horarioPreferido->format('N');
$minutos = ((int)$horarioPreferido->format('H') * 60) + (int)$horarioPreferido->format('i');
$permitido = ($diaSemana >= 1 && $diaSemana <= 5 && $minutos >= 18 * 60 && $minutos <= 21 * 60 && (int)$horarioPreferido->format('i') === 0)
    || ($diaSemana === 6 && $minutos >= 8 * 60 && $minutos <= 12 * 60 && (int)$horarioPreferido->format('i') === 0);
if (!$permitido) {
    lesson_lead_response(false, 'Escolha de segunda a sexta das 18h às 21h ou sábado das 8h às 12h.', 422);
}
$disponibilidade = $horarioPreferido->format('d/m/Y \à\s H:i');
if (!$consentimento) {
    lesson_lead_response(false, 'Confirme o uso dos dados para receber o retorno.', 422);
}

$attribution = [];
foreach (['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term', 'landing_page'] as $field) {
    $attribution[$field] = $clean($field, $field === 'landing_page' ? 255 : 150);
}

$pdo = db();
$pdo->exec(<<<SQL
CREATE TABLE IF NOT EXISTS aulas_particulares_leads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    email VARCHAR(190) NOT NULL,
    telefone VARCHAR(30) NOT NULL,
    nivel VARCHAR(60) NULL,
    interesse VARCHAR(80) NOT NULL,
    tema TEXT NOT NULL,
    disponibilidade VARCHAR(300) NULL,
    utm_source VARCHAR(150) NULL,
    utm_medium VARCHAR(150) NULL,
    utm_campaign VARCHAR(150) NULL,
    utm_content VARCHAR(150) NULL,
    utm_term VARCHAR(150) NULL,
    landing_page VARCHAR(255) NULL,
    ip_hash CHAR(64) NULL,
    status VARCHAR(30) NOT NULL DEFAULT 'novo',
    criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_aulas_criado (criado_em),
    INDEX idx_aulas_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
SQL);

$ipHash = hash('sha256', (string)($_SERVER['REMOTE_ADDR'] ?? '') . '|techsantos-aulas');
$rate = $pdo->prepare('SELECT COUNT(*) FROM aulas_particulares_leads WHERE ip_hash = ? AND criado_em >= DATE_SUB(NOW(), INTERVAL 1 HOUR)');
$rate->execute([$ipHash]);
if ((int)$rate->fetchColumn() >= 5) {
    lesson_lead_response(false, 'Limite de solicitações atingido. Fale conosco pelo WhatsApp.', 429);
}

$stmt = $pdo->prepare('INSERT INTO aulas_particulares_leads (nome,email,telefone,nivel,interesse,tema,disponibilidade,utm_source,utm_medium,utm_campaign,utm_content,utm_term,landing_page,ip_hash) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
$stmt->execute([$nome, $email, $telefone, $nivel ?: null, $interesse, $tema, $disponibilidade ?: null,
    $attribution['utm_source'] ?: null, $attribution['utm_medium'] ?: null, $attribution['utm_campaign'] ?: null,
    $attribution['utm_content'] ?: null, $attribution['utm_term'] ?: null, $attribution['landing_page'] ?: null, $ipHash]);
$leadId = (int)$pdo->lastInsertId();

$safe = static fn(string $value): string => htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
$subject = 'Novo interesse em aula particular #' . $leadId . ' — ' . $nome;
$html = '<h1 style="font-size:20px">Novo interesse em aula particular</h1>'
    . '<p><strong>Nome:</strong> ' . $safe($nome) . '</p><p><strong>E-mail:</strong> ' . $safe($email) . '</p>'
    . '<p><strong>Telefone:</strong> ' . $safe($telefone) . '</p><p><strong>Nível:</strong> ' . $safe($nivel ?: 'Não informado') . '</p>'
    . '<p><strong>Formato:</strong> ' . $safe($interesse) . '</p><p><strong>Objetivo:</strong><br>' . nl2br($safe($tema)) . '</p>'
    . '<p><strong>Disponibilidade:</strong> ' . $safe($disponibilidade ?: 'Não informada') . '</p>';
$text = "Novo interesse em aula particular #{$leadId}\nNome: {$nome}\nE-mail: {$email}\nTelefone: {$telefone}\nNível: {$nivel}\nFormato: {$interesse}\nObjetivo: {$tema}\nDisponibilidade: {$disponibilidade}";

try {
    if (!aulas_send_received(['nome'=>$nome,'email'=>$email,'interesse'=>$interesse,'tema'=>$tema])) {
        error_log('Falha ao confirmar recebimento da aula #' . $leadId);
    }
    if (!send_html_email(MAIL_FROM, $subject, $html, $text)) {
        error_log('Falha SMTP ao avisar sobre lead de aula #' . $leadId);
    }
} catch (Throwable $e) {
    error_log('Aviso de lead de aula #' . $leadId . ': ' . $e->getMessage());
}

$eventId = 'aula_lead_' . $leadId;
try {
    meta_capi_send_lesson_event('Lead',$leadId,$email,$telefone,$interesse,null,[
        'fbp'=>(string)($_COOKIE['_fbp']??''),'fbc'=>(string)($_COOKIE['_fbc']??''),
        'client_ip_address'=>(string)($_SERVER['REMOTE_ADDR']??''),'client_user_agent'=>(string)($_SERVER['HTTP_USER_AGENT']??''),
    ]);
} catch (Throwable $e) { error_log('Meta CAPI lead aula '.$leadId.': '.$e->getMessage()); }
lesson_lead_response(true, 'Solicitação recebida. Vamos avaliar seu objetivo e retornar com a melhor opção.', 200, ['lead_id'=>$leadId,'event_id'=>$eventId]);

