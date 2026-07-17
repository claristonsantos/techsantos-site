<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();

$updates = [
    54 => '2026-07-16 09:00:00',
    55 => '2026-07-16 12:00:00',
    56 => '2026-07-16 15:00:00',
    57 => '2026-07-16 18:00:00',
];

$sel = $pdo->prepare("SELECT id, status, agendado_para FROM social_posts WHERE id = ?");
$upd = $pdo->prepare("UPDATE social_posts SET agendado_para = ? WHERE id = ? AND status = 'pendente'");

$out = [];
foreach ($updates as $id => $novaData) {
    $sel->execute([$id]);
    $row = $sel->fetch();
    if (!$row) {
        $out[] = "id {$id}: não encontrado";
        continue;
    }
    if ($row['status'] !== 'pendente') {
        $out[] = "id {$id}: status atual '{$row['status']}' — não movido (só reagenda pendente)";
        continue;
    }
    $upd->execute([$novaData, $id]);
    $out[] = "id {$id}: {$row['agendado_para']} -> {$novaData}";
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
