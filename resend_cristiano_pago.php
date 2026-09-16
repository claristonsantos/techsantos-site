<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/aulas_particulares_automacao.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
$stmt = $pdo->prepare('SELECT * FROM aulas_particulares_leads WHERE id = 6');
$stmt->execute();
$lead = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$lead) { echo "lead not found\n"; @unlink(__FILE__); exit; }
$aulaDt = new DateTimeImmutable((string)$lead['data_aula'], new DateTimeZone('America/Sao_Paulo'));
echo "data_aula (local): {$lead['data_aula']}\n";
echo "data_aula (epoch): {$aulaDt->getTimestamp()} | now: " . time() . " | ja passou: " . ($aulaDt->getTimestamp() < time() ? 'sim' : 'nao') . "\n";
echo "link_reuniao: {$lead['link_reuniao']}\n";
$ok = aulas_send_paid($lead);
echo $ok ? "sent OK\n" : "send FAILED\n";
@unlink(__FILE__);
