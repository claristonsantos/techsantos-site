<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

function start_secure_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    ]);
    session_start();
}

function csrf_token(): string
{
    start_secure_session();
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . htmlspecialchars(csrf_token(), ENT_QUOTES) . '">';
}

function csrf_check(): void
{
    start_secure_session();
    $token = $_POST['csrf'] ?? '';
    if (empty($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $token)) {
        http_response_code(403);
        exit('Sessão expirada. Volte e tente novamente.');
    }
}

function cpf_digits(string $raw): string
{
    return preg_replace('/\D/', '', $raw) ?? '';
}

function cpf_is_valid(string $raw): bool
{
    $cpf = cpf_digits($raw);
    if (strlen($cpf) !== 11 || preg_match('/^(\d)\1{10}$/', $cpf)) {
        return false;
    }
    for ($t = 9; $t < 11; $t++) {
        $sum = 0;
        for ($i = 0; $i < $t; $i++) {
            $sum += (int)$cpf[$i] * (($t + 1) - $i);
        }
        $digit = ((10 * $sum) % 11) % 10;
        if ((int)$cpf[$t] !== $digit) {
            return false;
        }
    }
    return true;
}

function cpf_format(string $raw): string
{
    $cpf = cpf_digits($raw);
    if (strlen($cpf) !== 11) {
        return $raw;
    }
    return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
}

/* ---------------- Aluno ---------------- */

function aluno_attempt_login(string $email, string $senha): bool
{
    $stmt = db()->prepare('SELECT id, senha_hash, ativo FROM alunos WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $row = $stmt->fetch();
    if (!$row || !$row['ativo'] || !password_verify($senha, $row['senha_hash'])) {
        return false;
    }
    start_secure_session();
    session_regenerate_id(true);
    $_SESSION['aluno_id'] = (int)$row['id'];
    return true;
}

function aluno_logged_id(): ?int
{
    start_secure_session();
    return isset($_SESSION['aluno_id']) ? (int)$_SESSION['aluno_id'] : null;
}

function require_aluno(bool $allowTempPassword = false): array
{
    $id = aluno_logged_id();
    if ($id === null) {
        header('Location: /login.php');
        exit;
    }
    $stmt = db()->prepare(
        'SELECT a.id, a.nome, a.email, a.curso_id, a.senha_temporaria, c.nome AS curso_nome, c.slug AS curso_slug
         FROM alunos a JOIN cursos c ON c.id = a.curso_id
         WHERE a.id = ? AND a.ativo = 1 LIMIT 1'
    );
    $stmt->execute([$id]);
    $aluno = $stmt->fetch();
    if (!$aluno) {
        aluno_logout();
        header('Location: /login.php');
        exit;
    }
    if (!$allowTempPassword && $aluno['senha_temporaria']) {
        header('Location: /aluno/trocar-senha.php');
        exit;
    }
    return $aluno;
}

function aluno_logout(): void
{
    start_secure_session();
    unset($_SESSION['aluno_id']);
    session_regenerate_id(true);
}

/* ---------------- Admin ---------------- */

function admin_attempt_login(string $usuario, string $senha): bool
{
    $stmt = db()->prepare('SELECT id, senha_hash FROM admin_users WHERE usuario = ? LIMIT 1');
    $stmt->execute([$usuario]);
    $row = $stmt->fetch();
    if (!$row || !password_verify($senha, $row['senha_hash'])) {
        return false;
    }
    start_secure_session();
    session_regenerate_id(true);
    $_SESSION['admin_id'] = (int)$row['id'];
    $_SESSION['admin_usuario'] = $usuario;
    return true;
}

function require_admin(): void
{
    start_secure_session();
    if (empty($_SESSION['admin_id'])) {
        header('Location: /admin/login.php');
        exit;
    }
}

function admin_logout(): void
{
    start_secure_session();
    unset($_SESSION['admin_id'], $_SESSION['admin_usuario']);
    session_regenerate_id(true);
}
