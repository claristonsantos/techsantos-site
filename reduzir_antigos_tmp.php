<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();
// Posts no formato antigo (texto + voz sintética) tirados da fila em 05/10/2026 a pedido do dono.
$igIds = [209, 192, 211, 218, 195, 220, 172, 256, 258];
$fbIds = [257, 259]; // Reels do Facebook já agendados na própria Meta
$sel = $pdo->prepare("SELECT id, status, agendado_para FROM social_posts WHERE id = ?");
$del = $pdo->prepare("DELETE FROM social_posts WHERE id = ? AND status = 'pendente' AND agendado_para > NOW()");
foreach ($igIds as $id) {
    $del->execute([$id]);
    echo "IG #{$id}: " . ($del->rowCount() ? 'removido' : 'NÃO removido (já publicado ou não pendente)') . "\n";
}
foreach ($fbIds as $id) {
    $r = $pdo->query("SELECT meta_post_id, status FROM social_posts WHERE id = " . (int)$id)->fetch();
    if (!$r || $r['status'] !== 'agendado_meta' || !$r['meta_post_id']) { echo "FB #{$id}: pulado\n"; continue; }
    $ch = curl_init('https://graph.facebook.com/v21.0/' . META_PAGE_ID . '_' . $r['meta_post_id'] . '?access_token=' . urlencode(META_PAGE_TOKEN));
    curl_setopt_array($ch, [CURLOPT_CUSTOMREQUEST => 'DELETE', CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 60]);
    $res = (string)curl_exec($ch); curl_close($ch);
    if (str_contains($res, '"success":true')) {
        $pdo->prepare("DELETE FROM social_posts WHERE id = ?")->execute([$id]);
        echo "FB #{$id}: agendamento cancelado na Meta e removido\n";
    } else {
        echo "FB #{$id}: falha ao cancelar — " . substr(preg_replace('/access_token=[^&"]+/', '***', $res), 0, 200) . "\n";
    }
}
@unlink(__FILE__);
