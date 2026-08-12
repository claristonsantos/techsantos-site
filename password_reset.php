<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';

function ensure_password_resets_table(PDO $pdo): void
{
    $pdo->exec("CREATE TABLE IF NOT EXISTS password_resets (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        token_hash CHAR(64) NOT NULL UNIQUE,
        expira_em DATETIME NOT NULL,
        usado_em DATETIME NULL,
        criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_password_resets_aluno (aluno_id, criado_em),
        INDEX idx_password_resets_expira (expira_em)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
}

function create_password_reset(string $email): ?array
{
    $pdo = db();
    ensure_password_resets_table($pdo);
    $stmt = $pdo->prepare('SELECT id, nome, email FROM alunos WHERE LOWER(email) = LOWER(?) AND ativo = 1 LIMIT 1');
    $stmt->execute([trim($email)]);
    $aluno = $stmt->fetch();
    if (!$aluno) return null;

    $recent = $pdo->prepare('SELECT 1 FROM password_resets WHERE aluno_id = ? AND criado_em >= DATE_SUB(NOW(), INTERVAL 5 MINUTE) LIMIT 1');
    $recent->execute([(int)$aluno['id']]);
    if ($recent->fetchColumn()) return null;

    $token = bin2hex(random_bytes(32));
    $hash = hash('sha256', $token);
    $pdo->prepare('UPDATE password_resets SET usado_em = NOW() WHERE aluno_id = ? AND usado_em IS NULL')->execute([(int)$aluno['id']]);
    $pdo->prepare('INSERT INTO password_resets (aluno_id, token_hash, expira_em) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 30 MINUTE))')
        ->execute([(int)$aluno['id'], $hash]);
    return ['token' => $token, 'nome' => (string)$aluno['nome'], 'email' => (string)$aluno['email']];
}

function reset_password_with_token(string $token, string $password): bool
{
    if (!preg_match('/^[a-f0-9]{64}$/', $token) || strlen($password) < 8) return false;
    $pdo = db();
    ensure_password_resets_table($pdo);
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare('SELECT id, aluno_id FROM password_resets WHERE token_hash = ? AND usado_em IS NULL AND expira_em >= NOW() FOR UPDATE');
        $stmt->execute([hash('sha256', $token)]);
        $reset = $stmt->fetch();
        if (!$reset) { $pdo->rollBack(); return false; }
        $pdo->prepare('UPDATE alunos SET senha_hash = ?, senha_temporaria = 0 WHERE id = ? AND ativo = 1')
            ->execute([password_hash($password, PASSWORD_DEFAULT), (int)$reset['aluno_id']]);
        $pdo->prepare('UPDATE password_resets SET usado_em = NOW() WHERE id = ?')->execute([(int)$reset['id']]);
        $pdo->commit();
        return true;
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        throw $e;
    }
}
