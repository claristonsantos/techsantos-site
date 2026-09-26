<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

/*
 * Matrículas: um aluno pode ter vários cursos (Power BI, Microsoft Fabric...).
 *
 * Antes existia só alunos.curso_id — comprar um segundo curso SOBRESCREVIA o
 * primeiro e o aluno perdia o acesso. alunos.curso_id continua existindo como
 * "curso principal" (é o que as telas antigas do admin mostram), e a tabela
 * matriculas é a fonte de verdade do que o aluno pode acessar.
 */

function matriculas_ensure_schema(PDO $pdo): void
{
    static $done = false;
    if ($done) return;
    $done = true;
    $existe = $pdo->query("SHOW TABLES LIKE 'matriculas'")->fetchColumn();
    if ($existe) return;
    $pdo->exec("CREATE TABLE IF NOT EXISTS matriculas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        curso_id INT NOT NULL,
        criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY uniq_aluno_curso (aluno_id, curso_id),
        INDEX idx_matriculas_curso (curso_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    // Todo aluno que já existe ganha a matrícula do curso que ele tinha.
    $pdo->exec("INSERT IGNORE INTO matriculas (aluno_id, curso_id) SELECT id, curso_id FROM alunos WHERE curso_id IS NOT NULL");
}

function matricular(PDO $pdo, int $alunoId, int $cursoId): void
{
    matriculas_ensure_schema($pdo);
    $pdo->prepare('INSERT IGNORE INTO matriculas (aluno_id, curso_id) VALUES (?, ?)')->execute([$alunoId, $cursoId]);
}

/** @return array<int, array{id:int, nome:string, slug:string}> */
function matriculas_do_aluno(PDO $pdo, int $alunoId): array
{
    matriculas_ensure_schema($pdo);
    $stmt = $pdo->prepare(
        'SELECT c.id, c.nome, c.slug FROM matriculas m JOIN cursos c ON c.id = m.curso_id
         WHERE m.aluno_id = ? ORDER BY m.criado_em, c.id'
    );
    $stmt->execute([$alunoId]);
    return array_map(static fn($r) => ['id' => (int)$r['id'], 'nome' => (string)$r['nome'], 'slug' => (string)$r['slug']], $stmt->fetchAll());
}
