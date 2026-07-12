<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();

$pdo->exec("CREATE TABLE IF NOT EXISTS cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    slug VARCHAR(150) NOT NULL UNIQUE,
    carga_horaria VARCHAR(50) NULL,
    modalidade VARCHAR(50) NULL,
    descricao TEXT NULL,
    ativo TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$pdo->exec("CREATE TABLE IF NOT EXISTS alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    cpf VARCHAR(11) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    curso_id INT NOT NULL,
    ativo TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_alunos_curso FOREIGN KEY (curso_id) REFERENCES cursos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$pdo->exec("CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(100) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$out = [];

$count = (int)$pdo->query('SELECT COUNT(*) FROM cursos')->fetchColumn();
if ($count === 0) {
    $stmt = $pdo->prepare('INSERT INTO cursos (nome, slug, carga_horaria, modalidade, descricao) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([
        'Power BI Completo',
        'power-bi',
        '30h',
        'Turma fechada / In company / Individual',
        'Modelagem de dados, Power Query, DAX e visualizações — do zero até um relatório pronto para o negócio.',
    ]);
    $out[] = 'Curso semente "Power BI Completo" criado.';
}

$count = (int)$pdo->query('SELECT COUNT(*) FROM admin_users')->fetchColumn();
if ($count === 0) {
    $stmt = $pdo->prepare('INSERT INTO admin_users (usuario, senha_hash) VALUES (?, ?)');
    $stmt->execute([ADMIN_SEED_USER, password_hash(ADMIN_SEED_PASSWORD, PASSWORD_DEFAULT)]);
    $out[] = 'Usuário administrador criado: ' . ADMIN_SEED_USER;
}

header('Content-Type: text/plain; charset=utf-8');
echo "Instalação concluída.\n";
foreach ($out as $line) {
    echo "- $line\n";
}

@unlink(__FILE__);
echo "\ninstall.php removido do servidor.\n";
