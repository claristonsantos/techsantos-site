<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: renomeia o curso de inglês (o slug 'ingles' não muda, porque está fixo no código e nas URLs).
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$pdo = db();
$antes = $pdo->query("SELECT id, nome, slug FROM cursos WHERE slug = 'ingles'")->fetch();
echo 'antes: ' . json_encode($antes, JSON_UNESCAPED_UNICODE) . "\n";
$pdo->prepare("UPDATE cursos SET nome = ? WHERE slug = 'ingles'")->execute(['Inglês para Dados e Tecnologia']);
echo 'depois: ' . json_encode($pdo->query("SELECT id, nome, slug FROM cursos WHERE slug = 'ingles'")->fetch(), JSON_UNESCAPED_UNICODE) . "\n";
