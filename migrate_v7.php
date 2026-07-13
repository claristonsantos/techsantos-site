<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$out = [];

$pdo->exec("CREATE TABLE IF NOT EXISTS avaliacao_respostas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tentativa_id INT NOT NULL,
    questao_id INT NOT NULL,
    alternativa_id INT NOT NULL,
    CONSTRAINT fk_respostas_tentativa FOREIGN KEY (tentativa_id) REFERENCES avaliacao_tentativas(id) ON DELETE CASCADE,
    CONSTRAINT fk_respostas_questao FOREIGN KEY (questao_id) REFERENCES avaliacao_questoes(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
$out[] = 'Tabela avaliacao_respostas ok.';

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
