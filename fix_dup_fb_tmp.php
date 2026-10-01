<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$dup = '1771189691681927'; $postId = META_PAGE_ID . '_' . $dup; // cópia órfã (sem linha no banco) do Reel "linha de meta" de 15/10
$pdo = db();
$st = $pdo->prepare('SELECT COUNT(*) FROM social_posts WHERE meta_post_id = ?'); $st->execute([$dup]);
if ((int)$st->fetchColumn() > 0) { echo "ABORTADO: esse id está no banco\n"; @unlink(__FILE__); exit; }
$ch = curl_init('https://graph.facebook.com/v21.0/' . $postId . '?access_token=' . urlencode(META_PAGE_TOKEN));
curl_setopt_array($ch, [CURLOPT_CUSTOMREQUEST => 'DELETE', CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 60]);
$res = curl_exec($ch); $code = curl_getinfo($ch, CURLINFO_HTTP_CODE); curl_close($ch);
echo "DELETE {$postId}: HTTP {$code} " . preg_replace('/access_token=[^&"\s]+/', 'access_token=***', (string)$res) . "\n";
$url = 'https://graph.facebook.com/v21.0/' . META_PAGE_ID . '/scheduled_posts?fields=id,message&limit=50&access_token=' . urlencode(META_PAGE_TOKEN);
$j = json_decode((string)@file_get_contents($url), true);
$n = 0; foreach ($j['data'] ?? [] as $p) if (str_starts_with((string)($p['message'] ?? ''), 'Linha de meta')) $n++;
echo "agendados 'Linha de meta' restantes: {$n}\n";
@unlink(__FILE__);
