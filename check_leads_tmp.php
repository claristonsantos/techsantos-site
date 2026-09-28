<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/config.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('forbidden');
}

$pdo = db();
header('Content-Type: text/plain; charset=utf-8');
$mask = fn(string $t): string => substr($t, 0, 4) . str_repeat('*', max(0, strlen($t) - 6)) . substr($t, -2);

echo "=== whatsapp_leads ===\n";
$r = $pdo->query("SELECT COUNT(*) c, MIN(criado_em) primeiro, MAX(criado_em) ultimo FROM whatsapp_leads")->fetch();
echo "total: {$r['c']} | primeiro: {$r['primeiro']} | ultimo: {$r['ultimo']}\n";
foreach ($pdo->query("SELECT origem, COUNT(*) c FROM whatsapp_leads GROUP BY origem ORDER BY c DESC") as $row) {
    echo "  origem {$row['origem']}: {$row['c']}\n";
}
foreach ($pdo->query("SELECT id, telefone, origem, criado_em FROM whatsapp_leads ORDER BY criado_em DESC LIMIT 20") as $row) {
    echo "  #{$row['id']} {$row['criado_em']} UTC | {$row['origem']} | " . $mask((string)$row['telefone']) . "\n";
}

foreach (['lead_pipeline', 'leads_curso', 'leads'] as $t) {
    try {
        $c = $pdo->query("SELECT COUNT(*) FROM `$t`")->fetchColumn();
        echo "\n=== tabela $t: $c linhas ===\n";
        $cols = $pdo->query("SHOW COLUMNS FROM `$t`")->fetchAll(PDO::FETCH_COLUMN);
        echo "  colunas: " . implode(', ', $cols) . "\n";
        foreach (['status', 'etapa', 'estagio'] as $sc) {
            if (in_array($sc, $cols, true)) {
                foreach ($pdo->query("SELECT `$sc` s, COUNT(*) c FROM `$t` GROUP BY `$sc`") as $row) echo "  $sc={$row['s']}: {$row['c']}\n";
            }
        }
    } catch (Throwable $e) { /* tabela não existe */ }
}

echo "\n=== pedidos últimos 30 dias ===\n";
foreach ($pdo->query("SELECT p.id, p.status, p.valor_centavos, p.criado_em, c.slug FROM pedidos p LEFT JOIN cursos c ON c.id = p.curso_id WHERE p.criado_em >= NOW() - INTERVAL 30 DAY ORDER BY p.criado_em DESC") as $row) {
    echo "  #{$row['id']} | {$row['status']} | {$row['slug']} | R$" . number_format($row['valor_centavos']/100, 2, ',', '.') . " | {$row['criado_em']}\n";
}

echo "\n=== alunos novos 30 dias ===\n";
try {
    echo "  " . $pdo->query("SELECT COUNT(*) FROM usuarios WHERE criado_em >= NOW() - INTERVAL 30 DAY")->fetchColumn() . "\n";
} catch (Throwable $e) { echo "  (sem coluna)\n"; }

echo "\ndone\n";
@unlink(__FILE__);
