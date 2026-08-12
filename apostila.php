<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_aluno();

$path = __DIR__ . '/exercicios/apostila-power-bi-completo-2026.pdf';
if (!is_file($path)) {
    http_response_code(404);
    exit('Apostila não encontrada.');
}

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="Apostila-Power-BI-Completo-TECH-SANTOS-BR-2026.pdf"');
header('Content-Length: ' . (string)filesize($path));
header('Cache-Control: private, max-age=0, no-cache');
header('X-Content-Type-Options: nosniff');
readfile($path);
