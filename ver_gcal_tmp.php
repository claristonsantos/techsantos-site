<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/google_calendar.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Diagnóstico de uso único (somente leitura): a renovação do token do Google Agenda funciona? Não cria evento, não mostra segredo.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$pdo = db(); $c = google_calendar_config($pdo);
echo "conectado_em: " . ($c['conectado_em'] ?? '-') . " | calendar_id: " . ($c['calendar_id'] === 'primary' ? 'primary' : 'outro') . " | refresh_token: " . ($c['refresh_token'] !== '' ? 'presente' : 'vazio') . "\n";
$ch = curl_init('https://oauth2.googleapis.com/token');
curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 25, CURLOPT_POST => true,
  CURLOPT_POSTFIELDS => http_build_query(['client_id' => $c['client_id'], 'client_secret' => $c['client_secret'], 'refresh_token' => $c['refresh_token'], 'grant_type' => 'refresh_token']),
  CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded']]);
$r = curl_exec($ch); $code = curl_getinfo($ch, CURLINFO_HTTP_CODE); curl_close($ch);
$d = json_decode((string)$r, true) ?: [];
echo "token HTTP $code | error=" . ($d['error'] ?? '-') . " | error_description=" . ($d['error_description'] ?? '-') . " | access_token=" . (!empty($d['access_token']) ? 'OK' : 'não') . "\n";
if (!empty($d['access_token'])) {
    $ch = curl_init('https://www.googleapis.com/calendar/v3/calendars/' . rawurlencode($c['calendar_id'] ?: 'primary'));
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 25, CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $d['access_token']]]);
    $r = curl_exec($ch); $code = curl_getinfo($ch, CURLINFO_HTTP_CODE); curl_close($ch);
    $cal = json_decode((string)$r, true) ?: [];
    echo "calendar GET HTTP $code | conferenceTypes=" . implode(',', $cal['conferenceProperties']['allowedConferenceSolutionTypes'] ?? []) . " | erro=" . ($cal['error']['message'] ?? '-') . "\n";
}
