<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }
header('Content-Type: text/plain; charset=utf-8');
$pdo = db();

$map = [
    200 => '2026-10-02 21:00:00',
    207 => '2026-10-03 23:00:00',
    189 => '2026-10-04 13:00:00',
    209 => '2026-10-05 13:00:00',
    238 => '2026-10-06 21:00:00',
    192 => '2026-10-07 13:00:00',
    172 => '2026-10-08 21:00:00',
    239 => '2026-10-09 21:00:00',
    174 => '2026-10-10 21:00:00',
    240 => '2026-10-11 21:00:00',
    211 => '2026-10-12 23:00:00',
    218 => '2026-10-13 13:00:00',
    214 => '2026-10-14 21:00:00',
    215 => '2026-10-15 21:00:00',
    195 => '2026-10-16 13:00:00',
    216 => '2026-10-17 21:00:00',
    220 => '2026-10-18 13:00:00',
];

$select = $pdo->prepare("SELECT id, tipo, status FROM social_posts WHERE id = ? AND canal='instagram'");
$update = $pdo->prepare("UPDATE social_posts SET agendado_para = ?, status = 'pendente', erro_msg = NULL, meta_container_id = NULL, meta_post_id = NULL WHERE id = ?");
$out = [];
foreach ($map as $id => $novaData) {
    $select->execute([$id]);
    $row = $select->fetch();
    if (!$row) { $out[] = "SKIP|not found|id={$id}"; continue; }
    $update->execute([$novaData, $id]);
    $out[] = "OK|id={$id}|{$row['tipo']}|{$row['status']}->pendente|{$novaData}";
}
echo implode("\n", $out) . "\n";
@unlink(__FILE__);
