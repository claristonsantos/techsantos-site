<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

header('Content-Type: text/plain; charset=utf-8');
try {
    $stmt = db()->query("SELECT id, nome, slug, preco_centavos FROM cursos");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$rows) {
        echo "TABELA cursos VAZIA\n";
    }
    foreach ($rows as $row) {
        echo implode(' | ', $row) . "\n";
    }
} catch (Throwable $e) {
    echo "ERRO: " . $e->getMessage() . "\n";
}
