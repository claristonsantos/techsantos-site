<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: acerta os carrosséis presos em 'processando' pelo cron antigo (síncrono) e
// mostra o pedido pendente do Excel (só dados mínimos). Horários UTC.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$pdo = db();
$cols = array_column($pdo->query("SHOW COLUMNS FROM social_posts")->fetchAll(), 'Field');
if (!in_array('carousel_children', $cols, true)) $pdo->exec("ALTER TABLE social_posts ADD COLUMN carousel_children TEXT NULL");

// 27 e 29/10 saíram no Instagram (conferido na conta), só o status ficou preso
$pdo->exec("UPDATE social_posts SET status = 'publicado' WHERE id IN (458, 460) AND status = 'processando'");
// 24/10 (Instagram) e os 4 do Threads não saíram: voltam para a fila em dias da semana que vem
$reagenda = [456 => '2026-11-01 13:00:00', 455 => '2026-11-01 13:30:00', 457 => '2026-11-02 13:30:00', 459 => '2026-11-04 13:30:00', 461 => '2026-11-05 13:30:00'];
$up = $pdo->prepare("UPDATE social_posts SET status = 'pendente', agendado_para = ?, meta_container_id = NULL, carousel_children = NULL, erro_msg = NULL WHERE id = ? AND status = 'processando'");
foreach ($reagenda as $id => $when) { $up->execute([$when, $id]); echo "post $id -> $when (" . $up->rowCount() . ")\n"; }
foreach ($pdo->query("SELECT id, canal, status, agendado_para FROM social_posts WHERE tipo = 'carousel' AND id BETWEEN 454 AND 461 ORDER BY id") as $r) echo implode(' | ', $r) . "\n";

echo "== pedidos pendentes (30 dias)\n";
foreach ($pdo->query("SELECT p.id, p.criado_em, c.slug, p.valor_centavos, p.lembrete_enviado, p.lembrete2_em, SUBSTRING_INDEX(TRIM(p.nome), ' ', 1) AS primeiro_nome,
                             LENGTH(REGEXP_REPLACE(COALESCE(p.telefone, ''), '[^0-9]', '')) >= 10 AS tem_fone
                      FROM pedidos p JOIN cursos c ON c.id = p.curso_id
                      WHERE p.status = 'pendente' AND p.criado_em >= NOW() - INTERVAL 30 DAY
                        AND p.email NOT LIKE '%techsantos%' AND p.email NOT LIKE '%.invalid'") as $r) {
    echo implode(' | ', array_map(fn($k, $v) => "$k=$v", array_keys($r), $r)) . "\n";
}
echo "== fila futura\n";
foreach ($pdo->query("SELECT canal, tipo, COUNT(*) n, MIN(agendado_para) de, MAX(agendado_para) ate FROM social_posts WHERE status IN ('pendente','agendado_meta') AND agendado_para > NOW() GROUP BY canal, tipo") as $r) echo implode(' | ', $r) . "\n";
