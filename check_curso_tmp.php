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
    $stmt = db()->query("SELECT id, nome, slug, preco_centavos FROM cursos WHERE slug = 'power-bi'");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $row ? implode(' | ', $row) . "\n" : "curso power-bi NAO ENCONTRADO\n";
} catch (Throwable $e) {
    echo "ERRO: " . $e->getMessage() . "\n";
}
