<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

header('Content-Type: text/plain; charset=utf-8');

$before = db()->query("SELECT id, nome, slug, preco_centavos FROM cursos WHERE id = 1")->fetch(PDO::FETCH_ASSOC);
echo "antes: " . implode(' | ', $before) . "\n";

$n = db()->exec("UPDATE cursos SET slug = 'power-bi' WHERE id = 1 AND slug = 'power-bi-completo'");
echo "linhas atualizadas: $n\n";

$after = db()->query("SELECT id, nome, slug, preco_centavos FROM cursos WHERE id = 1")->fetch(PDO::FETCH_ASSOC);
echo "depois: " . implode(' | ', $after) . "\n";

@unlink(__FILE__);
