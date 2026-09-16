<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/google_calendar.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$connected = google_calendar_is_connected($pdo);
$config = google_calendar_config($pdo);
echo 'google_calendar_is_connected(): ' . ($connected ? 'true' : 'false') . "\n";
echo 'calendar_id: ' . ($config['calendar_id'] ?: '(vazio)') . "\n";
echo 'conectado_em: ' . ($config['conectado_em'] ?: '(nunca)') . "\n";

if ($connected) {
    $error = null;
    $token = google_calendar_access_token($pdo, $error);
    echo 'refresh_token ainda funciona (consegue trocar por access_token): ' . ($token ? 'SIM' : 'NAO') . "\n";
    if (!$token) {
        echo 'erro: ' . $error . "\n";
    } else {
        echo 'access_token obtido, primeiros 12 chars: ' . substr($token, 0, 12) . "...\n";
    }
} else {
    echo "Nao ha client_id/client_secret/refresh_token salvos - integracao nunca foi conectada ou foi desconectada.\n";
}

echo "\n=== aulas_particulares_leads com link_reuniao vazio e status agendado/pago ===\n";
$stmt = $pdo->query("SELECT id, nome, status, data_aula, link_reuniao, google_calendar_event_id FROM aulas_particulares_leads WHERE status IN ('agendado','pago') ORDER BY data_aula DESC LIMIT 20");
foreach ($stmt->fetchAll() as $row) {
    echo "#{$row['id']} {$row['nome']} | status={$row['status']} | data_aula=" . ($row['data_aula'] ?: '-') . ' | link=' . ($row['link_reuniao'] ? 'OK' : 'FALTANDO') . ' | meet_event_id=' . ($row['google_calendar_event_id'] ?: '-') . "\n";
}

@unlink(__FILE__);
