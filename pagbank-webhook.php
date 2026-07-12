<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/pagbank.php';
require_once __DIR__ . '/mailer.php';

$rawPayload = file_get_contents('php://input') ?: '';
$receivedToken = $_SERVER['HTTP_X_AUTHENTICITY_TOKEN'] ?? '';

if ($receivedToken === '' || !pagbank_verify_signature($rawPayload, $receivedToken)) {
    http_response_code(401);
    exit('invalid signature');
}

$data = json_decode($rawPayload, true);
if (!is_array($data)) {
    http_response_code(400);
    exit('bad payload');
}

$referenceId = (string)($data['reference_id'] ?? '');
if (!preg_match('/^PEDIDO-(\d+)$/', $referenceId, $m)) {
    http_response_code(200); // acknowledge, nothing we recognize
    exit('ignored');
}
$pedidoId = (int)$m[1];

$paid = false;
foreach ($data['charges'] ?? [] as $charge) {
    if (($charge['status'] ?? '') === 'PAID') {
        $paid = true;
        break;
    }
}

if (!$paid) {
    http_response_code(200);
    exit('no paid charge yet');
}

$pdo = db();
$pdo->beginTransaction();

$stmt = $pdo->prepare('SELECT * FROM pedidos WHERE id = ? FOR UPDATE');
$stmt->execute([$pedidoId]);
$pedido = $stmt->fetch();

if (!$pedido || $pedido['status'] === 'pago') {
    $pdo->commit();
    http_response_code(200);
    exit('already processed or not found');
}

$alunoId = null;
$dup = $pdo->prepare('SELECT id FROM alunos WHERE email = ? OR cpf = ?');
$dup->execute([$pedido['email'], $pedido['cpf']]);
$existingAluno = $dup->fetch();

$senhaGerada = null;
if ($existingAluno) {
    $alunoId = (int)$existingAluno['id'];
    $pdo->prepare('UPDATE alunos SET curso_id = ?, ativo = 1 WHERE id = ?')->execute([$pedido['curso_id'], $alunoId]);
} else {
    $senhaGerada = bin2hex(random_bytes(5));
    $insAluno = $pdo->prepare('INSERT INTO alunos (nome, email, cpf, senha_hash, curso_id) VALUES (?, ?, ?, ?, ?)');
    $insAluno->execute([$pedido['nome'], $pedido['email'], $pedido['cpf'], password_hash($senhaGerada, PASSWORD_DEFAULT), $pedido['curso_id']]);
    $alunoId = (int)$pdo->lastInsertId();
}

$pdo->prepare('UPDATE pedidos SET status = ?, aluno_id = ?, atualizado_em = NOW() WHERE id = ?')
    ->execute(['pago', $alunoId, $pedidoId]);

$pdo->commit();

if ($senhaGerada !== null) {
    $cursoStmt = $pdo->prepare('SELECT nome FROM cursos WHERE id = ?');
    $cursoStmt->execute([$pedido['curso_id']]);
    $cursoNome = $cursoStmt->fetchColumn() ?: 'Power BI Completo';
    send_enrollment_email($pedido['email'], $pedido['nome'], $senhaGerada, ['nome' => $cursoNome]);
}

http_response_code(200);
echo 'ok';
