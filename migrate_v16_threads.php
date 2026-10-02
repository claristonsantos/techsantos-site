<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }

// Adiciona 'threads' ao canal dos posts agendados.
$pdo = db();
$col = $pdo->query("SHOW COLUMNS FROM social_posts LIKE 'canal'")->fetch();
$out = ['antes: ' . ($col['Type'] ?? '?')];
if (!str_contains((string)($col['Type'] ?? ''), "'threads'")) {
    $pdo->exec("ALTER TABLE social_posts MODIFY COLUMN canal ENUM('facebook','instagram','threads') NOT NULL");
}
$col = $pdo->query("SHOW COLUMNS FROM social_posts LIKE 'canal'")->fetch();
$out[] = 'depois: ' . ($col['Type'] ?? '?');
header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";
@unlink(__FILE__);
