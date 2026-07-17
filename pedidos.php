<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/mailer.php';

/**
 * Marks a pedido as paid, provisions/updates the aluno account, and sends the
 * enrollment email on first provisioning. Idempotent: safe to call more than
 * once for the same pedido (e.g. duplicate webhook deliveries).
 */
function marcar_pedido_pago(int $pedidoId, ?string $cpfDoPagamento = null): void
{
    $pdo = db();
    $pdo->beginTransaction();

    $stmt = $pdo->prepare('SELECT * FROM pedidos WHERE id = ? FOR UPDATE');
    $stmt->execute([$pedidoId]);
    $pedido = $stmt->fetch();

    if (!$pedido || $pedido['status'] === 'pago') {
        $pdo->commit();
        return;
    }

    // CPF pode não ter sido coletado no formulário (ver comprar.php) — usa o
    // que veio do Mercado Pago no momento do pagamento, necessário depois
    // para emissão do certificado.
    $cpf = $pedido['cpf'] ?: ($cpfDoPagamento ?? '');
    if ($cpf !== $pedido['cpf']) {
        $pdo->prepare('UPDATE pedidos SET cpf = ? WHERE id = ?')->execute([$cpf, $pedidoId]);
    }

    $alunoId = null;
    $dup = $pdo->prepare('SELECT id FROM alunos WHERE email = ? OR (cpf != \'\' AND cpf = ?)');
    $dup->execute([$pedido['email'], $cpf]);
    $existingAluno = $dup->fetch();

    $senhaGerada = null;
    if ($existingAluno) {
        $alunoId = (int)$existingAluno['id'];
        $pdo->prepare('UPDATE alunos SET curso_id = ?, ativo = 1, cpf = IF(cpf = \'\', ?, cpf) WHERE id = ?')
            ->execute([$pedido['curso_id'], $cpf, $alunoId]);
    } else {
        $senhaGerada = bin2hex(random_bytes(5));
        $insAluno = $pdo->prepare('INSERT INTO alunos (nome, email, cpf, senha_hash, curso_id) VALUES (?, ?, ?, ?, ?)');
        $insAluno->execute([$pedido['nome'], $pedido['email'], $cpf, password_hash($senhaGerada, PASSWORD_DEFAULT), $pedido['curso_id']]);
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
}
