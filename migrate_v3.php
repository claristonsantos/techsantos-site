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

function column_exists_v3(PDO $pdo, string $table, string $column): bool
{
    $stmt = $pdo->prepare(
        "SELECT COUNT(*) FROM information_schema.COLUMNS
         WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ?"
    );
    $stmt->execute([$table, $column]);
    return (int)$stmt->fetchColumn() > 0;
}

if (!column_exists_v3($pdo, 'cursos', 'preco_centavos')) {
    $pdo->exec("ALTER TABLE cursos ADD COLUMN preco_centavos INT NULL AFTER vagas_disponiveis");
    $out[] = 'Coluna cursos.preco_centavos criada.';
}

$pdo->exec("CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    email VARCHAR(190) NOT NULL,
    cpf VARCHAR(11) NOT NULL,
    curso_id INT NOT NULL,
    valor_centavos INT NOT NULL,
    status ENUM('pendente','pago','cancelado') NOT NULL DEFAULT 'pendente',
    pagbank_checkout_id VARCHAR(80) NULL,
    aluno_id INT NULL,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    atualizado_em DATETIME NULL,
    CONSTRAINT fk_pedidos_curso FOREIGN KEY (curso_id) REFERENCES cursos(id),
    CONSTRAINT fk_pedidos_aluno FOREIGN KEY (aluno_id) REFERENCES alunos(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
$out[] = 'Tabela pedidos ok.';

$stmt = $pdo->prepare("UPDATE cursos SET preco_centavos = ? WHERE slug = 'power-bi' AND preco_centavos IS NULL");
$stmt->execute([29900]);
if ($stmt->rowCount() > 0) {
    $out[] = 'Preço do curso Power BI definido: R$ 299,00.';
}

header('Content-Type: text/plain; charset=utf-8');
echo "Migração v3 concluída.\n";
foreach ($out as $line) {
    echo "- $line\n";
}

@unlink(__FILE__);
echo "\nmigrate_v3.php removido do servidor.\n";
