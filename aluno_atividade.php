<?php
declare(strict_types=1);

function ensure_aluno_atividade_tables(PDO $pdo): void
{
    $pdo->exec("CREATE TABLE IF NOT EXISTS aluno_atividade (
        aluno_id INT PRIMARY KEY,
        ultimo_acesso DATETIME NOT NULL,
        CONSTRAINT fk_atividade_aluno FOREIGN KEY (aluno_id) REFERENCES alunos(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    $pdo->exec("CREATE TABLE IF NOT EXISTS aluno_reengajamento (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        faixa_dias SMALLINT NOT NULL,
        enviado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY uniq_reengajamento_faixa (aluno_id, faixa_dias),
        CONSTRAINT fk_reengajamento_aluno FOREIGN KEY (aluno_id) REFERENCES alunos(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
}

function registrar_acesso_aluno(int $alunoId): void
{
    $pdo = db();
    ensure_aluno_atividade_tables($pdo);
    $stmt = $pdo->prepare('INSERT INTO aluno_atividade (aluno_id, ultimo_acesso) VALUES (?, NOW()) ON DUPLICATE KEY UPDATE ultimo_acesso = NOW()');
    $stmt->execute([$alunoId]);
}
