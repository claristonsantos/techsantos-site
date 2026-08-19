<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/config.php';

const GOOGLE_CALENDAR_REDIRECT_URI = 'https://techsantos.com.br/admin/google_calendar_setup.php';
const GOOGLE_CALENDAR_SCOPE = 'https://www.googleapis.com/auth/calendar.events';

function google_calendar_ensure(PDO $pdo): void
{
    $pdo->exec("CREATE TABLE IF NOT EXISTS google_calendar_config (
        id TINYINT PRIMARY KEY,
        client_id TEXT NULL,
        client_secret TEXT NULL,
        refresh_token TEXT NULL,
        calendar_id VARCHAR(190) NOT NULL DEFAULT 'primary',
        conectado_em DATETIME NULL,
        atualizado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    $pdo->exec("INSERT IGNORE INTO google_calendar_config (id,calendar_id) VALUES (1,'primary')");
}

function google_calendar_crypto_key(): string
{
    return hash('sha256', SETUP_KEY, true);
}

function google_calendar_encrypt(string $value): string
{
    if ($value === '') return '';
    $iv = random_bytes(12);
    $tag = '';
    $cipher = openssl_encrypt($value, 'aes-256-gcm', google_calendar_crypto_key(), OPENSSL_RAW_DATA, $iv, $tag);
    if ($cipher === false) throw new RuntimeException('Não foi possível proteger a credencial Google.');
    return base64_encode($iv . $tag . $cipher);
}

function google_calendar_decrypt(?string $value): string
{
    if (!$value) return '';
    $raw = base64_decode($value, true);
    if ($raw === false || strlen($raw) < 29) return '';
    $plain = openssl_decrypt(substr($raw, 28), 'aes-256-gcm', google_calendar_crypto_key(), OPENSSL_RAW_DATA, substr($raw, 0, 12), substr($raw, 12, 16));
    return $plain === false ? '' : $plain;
}

function google_calendar_config(PDO $pdo): array
{
    google_calendar_ensure($pdo);
    $row = $pdo->query('SELECT * FROM google_calendar_config WHERE id=1')->fetch() ?: [];
    return [
        'client_id' => google_calendar_decrypt($row['client_id'] ?? ''),
        'client_secret' => google_calendar_decrypt($row['client_secret'] ?? ''),
        'refresh_token' => google_calendar_decrypt($row['refresh_token'] ?? ''),
        'calendar_id' => (string)($row['calendar_id'] ?? 'primary'),
        'conectado_em' => $row['conectado_em'] ?? null,
    ];
}

function google_calendar_save_credentials(PDO $pdo, string $clientId, string $clientSecret, string $calendarId = 'primary'): void
{
    google_calendar_ensure($pdo);
    $current = google_calendar_config($pdo);
    $refreshToken = ($current['client_id'] === $clientId && $current['client_secret'] === $clientSecret) ? $current['refresh_token'] : '';
    $connectedAt = $refreshToken !== '' ? $current['conectado_em'] : null;
    $stmt = $pdo->prepare('UPDATE google_calendar_config SET client_id=?,client_secret=?,refresh_token=?,calendar_id=?,conectado_em=? WHERE id=1');
    $stmt->execute([google_calendar_encrypt($clientId), google_calendar_encrypt($clientSecret), google_calendar_encrypt($refreshToken), $calendarId ?: 'primary', $connectedAt]);
}

function google_calendar_is_connected(PDO $pdo): bool
{
    $config = google_calendar_config($pdo);
    return $config['client_id'] !== '' && $config['client_secret'] !== '' && $config['refresh_token'] !== '';
}

function google_calendar_authorize_url(PDO $pdo, string $state): string
{
    $config = google_calendar_config($pdo);
    return 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query([
        'client_id' => $config['client_id'],
        'redirect_uri' => GOOGLE_CALENDAR_REDIRECT_URI,
        'response_type' => 'code',
        'scope' => GOOGLE_CALENDAR_SCOPE,
        'access_type' => 'offline',
        'prompt' => 'consent',
        'include_granted_scopes' => 'true',
        'state' => $state,
    ]);
}

function google_calendar_http(string $url, array $options, ?string &$error = null): ?array
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 25] + $options);
    $response = curl_exec($ch);
    $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);
    $data = is_string($response) ? json_decode($response, true) : null;
    if ($response === false || $code < 200 || $code >= 300 || !is_array($data)) {
        $error = $data['error']['message'] ?? $data['error_description'] ?? $curlError ?: ('Google HTTP ' . $code);
        return null;
    }
    return $data;
}

function google_calendar_exchange_code(PDO $pdo, string $code, ?string &$error = null): bool
{
    $config = google_calendar_config($pdo);
    $data = google_calendar_http('https://oauth2.googleapis.com/token', [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query([
            'code' => $code,
            'client_id' => $config['client_id'],
            'client_secret' => $config['client_secret'],
            'redirect_uri' => GOOGLE_CALENDAR_REDIRECT_URI,
            'grant_type' => 'authorization_code',
        ]),
        CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
    ], $error);
    if (!$data || empty($data['refresh_token'])) {
        $error = $error ?: 'O Google não retornou um token permanente. Tente conectar novamente.';
        return false;
    }
    $stmt = $pdo->prepare('UPDATE google_calendar_config SET refresh_token=?,conectado_em=NOW() WHERE id=1');
    $stmt->execute([google_calendar_encrypt((string)$data['refresh_token'])]);
    return true;
}

function google_calendar_access_token(PDO $pdo, ?string &$error = null): ?string
{
    $config = google_calendar_config($pdo);
    if ($config['client_id'] === '' || $config['client_secret'] === '' || $config['refresh_token'] === '') {
        $error = 'Google Calendar não conectado.';
        return null;
    }
    $data = google_calendar_http('https://oauth2.googleapis.com/token', [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query([
            'client_id' => $config['client_id'],
            'client_secret' => $config['client_secret'],
            'refresh_token' => $config['refresh_token'],
            'grant_type' => 'refresh_token',
        ]),
        CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
    ], $error);
    return $data && !empty($data['access_token']) ? (string)$data['access_token'] : null;
}

function google_calendar_meet_link(array $event): string
{
    if (!empty($event['hangoutLink'])) return (string)$event['hangoutLink'];
    foreach (($event['conferenceData']['entryPoints'] ?? []) as $entry) {
        if (($entry['entryPointType'] ?? '') === 'video' && !empty($entry['uri'])) return (string)$entry['uri'];
    }
    return '';
}

function google_calendar_create_lesson(PDO $pdo, array $lead, ?string &$error = null): ?array
{
    if (empty($lead['data_aula']) || empty($lead['horas'])) {
        $error = 'Informe data, horário e duração antes de criar o Google Meet.';
        return null;
    }
    $accessToken = google_calendar_access_token($pdo, $error);
    if (!$accessToken) return null;
    $config = google_calendar_config($pdo);
    $start = new DateTimeImmutable((string)$lead['data_aula'], new DateTimeZone('America/Sao_Paulo'));
    $durationSeconds = max(1800, (int)round((float)$lead['horas'] * 3600));
    $end = $start->modify('+' . $durationSeconds . ' seconds');
    $event = [
        'summary' => 'Aula particular — ' . (string)$lead['nome'],
        'description' => "Aula da TECH SANTOS BR\nFormato: " . (string)$lead['interesse'] . "\nObjetivo: " . (string)$lead['tema'],
        'start' => ['dateTime' => $start->format(DATE_RFC3339), 'timeZone' => 'America/Sao_Paulo'],
        'end' => ['dateTime' => $end->format(DATE_RFC3339), 'timeZone' => 'America/Sao_Paulo'],
        'conferenceData' => ['createRequest' => [
            'requestId' => 'aula-' . (int)$lead['id'] . '-' . bin2hex(random_bytes(6)),
            'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
        ]],
    ];
    $calendarId = rawurlencode($config['calendar_id'] ?: 'primary');
    $data = google_calendar_http('https://www.googleapis.com/calendar/v3/calendars/' . $calendarId . '/events?conferenceDataVersion=1&sendUpdates=none', [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($event, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $accessToken, 'Content-Type: application/json'],
    ], $error);
    if (!$data || empty($data['id'])) return null;
    $meetLink = google_calendar_meet_link($data);
    for ($attempt = 0; $meetLink === '' && $attempt < 3; $attempt++) {
        usleep(250000);
        $data = google_calendar_http('https://www.googleapis.com/calendar/v3/calendars/' . $calendarId . '/events/' . rawurlencode((string)$data['id']) . '?conferenceDataVersion=1', [
            CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $accessToken],
        ], $error) ?: $data;
        $meetLink = google_calendar_meet_link($data);
    }
    if ($meetLink === '') {
        $error = 'O evento foi criado, mas o Google Meet ainda não ficou disponível. Abra o evento no Calendar e tente novamente.';
        return null;
    }
    return ['event_id' => (string)$data['id'], 'meet_link' => $meetLink];
}