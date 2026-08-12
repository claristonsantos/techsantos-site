<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/mailer.php';

function marcar_pedido_pago(int $pedidoId, ?string $cpfDoPagamento = null, ?string $paymentId = null): array
{
    $pdo = db(); $senhaGerada = null; $pedido = null; $alunoId = null;
    try {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare('SELECT * FROM pedidos WHERE id = ? FOR UPDATE');
        $stmt->execute([$pedidoId]); $pedido = $stmt->fetch();
        if (!$pedido) throw new RuntimeException('Pedido não encontrado: ' . $pedidoId);
        if ($pedido['status'] === 'pago') {
            if ($paymentId !== null && empty($pedido['mercadopago_payment_id'])) {
                $pdo->prepare('UPDATE pedidos SET mercadopago_payment_id = ?, webhook_processado_em = NOW() WHERE id = ?')->execute([$paymentId, $pedidoId]);
            }
            $pdo->commit();
            return ['status'=>'ja_processado','pedido_id'=>$pedidoId,'aluno_id'=>(int)$pedido['aluno_id']];
        }
        $cpf = preg_replace('/\D/', '', (string)($pedido['cpf'] ?: ($cpfDoPagamento ?? ''))) ?: null;
        if ($cpf !== ($pedido['cpf'] ?: null)) $pdo->prepare('UPDATE pedidos SET cpf = ? WHERE id = ?')->execute([$cpf, $pedidoId]);
        $dup = $pdo->prepare("SELECT id FROM alunos WHERE email = ? OR (cpf IS NOT NULL AND cpf != '' AND cpf = ?)");
        $dup->execute([$pedido['email'], $cpf]); $existing = $dup->fetch();
        if ($existing) {
            $alunoId = (int)$existing['id'];
            $pdo->prepare("UPDATE alunos SET curso_id = ?, ativo = 1, cpf = IF(cpf IS NULL OR cpf = '', ?, cpf) WHERE id = ?")->execute([$pedido['curso_id'], $cpf, $alunoId]);
        } else {
            $senhaGerada = bin2hex(random_bytes(5));
            $pdo->prepare('INSERT INTO alunos (nome,email,cpf,senha_hash,curso_id,senha_temporaria) VALUES (?,?,?,?,?,1)')->execute([$pedido['nome'],$pedido['email'],$cpf,password_hash($senhaGerada,PASSWORD_DEFAULT),$pedido['curso_id']]);
            $alunoId = (int)$pdo->lastInsertId();
        }
        $pdo->prepare("UPDATE pedidos SET status='pago', aluno_id=?, mercadopago_payment_id=COALESCE(?,mercadopago_payment_id), webhook_processado_em=NOW(), webhook_ultimo_erro=NULL, atualizado_em=NOW() WHERE id=?")->execute([$alunoId,$paymentId,$pedidoId]);
        $pdo->commit();
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        try { $pdo->prepare('UPDATE pedidos SET webhook_ultimo_erro=?, atualizado_em=NOW() WHERE id=?')->execute([mb_substr($e->getMessage(),0,1000),$pedidoId]); } catch (Throwable $ignored) {}
        throw $e;
    }
    if ($senhaGerada !== null) {
        $cursoStmt=$pdo->prepare('SELECT nome FROM cursos WHERE id=?'); $cursoStmt->execute([$pedido['curso_id']]);
        $cursoNome=$cursoStmt->fetchColumn() ?: 'Power BI Completo';
        $ok=send_enrollment_email($pedido['email'],$pedido['nome'],$senhaGerada,['nome'=>$cursoNome]);
        $pdo->prepare("UPDATE pedidos SET email_status=?, email_tentativas=email_tentativas+1, email_enviado_em=IF(?,NOW(),email_enviado_em), email_ultimo_erro=? WHERE id=?")->execute([$ok?'enviado':'falha',$ok?1:0,$ok?null:'SMTP não confirmou o envio',$pedidoId]);
        return ['status'=>'processado','pedido_id'=>$pedidoId,'aluno_id'=>$alunoId,'email_enviado'=>$ok];
    }
    $pdo->prepare("UPDATE pedidos SET email_status=IF(email_status='pendente','nao_necessario',email_status) WHERE id=?")->execute([$pedidoId]);
    return ['status'=>'processado','pedido_id'=>$pedidoId,'aluno_id'=>$alunoId,'email_enviado'=>null];
}

function reenviar_acesso_pedido(int $pedidoId): bool
{
    $pdo=db(); $stmt=$pdo->prepare("SELECT p.*,c.nome AS curso_nome FROM pedidos p JOIN cursos c ON c.id=p.curso_id WHERE p.id=? AND p.status='pago' LIMIT 1");
    $stmt->execute([$pedidoId]); $pedido=$stmt->fetch();
    if (!$pedido || empty($pedido['aluno_id'])) return false;
    $senha=bin2hex(random_bytes(5));
    $ok=send_enrollment_email($pedido['email'],$pedido['nome'],$senha,['nome'=>$pedido['curso_nome']]);
    if($ok){
        $pdo->prepare('UPDATE alunos SET senha_hash=?, senha_temporaria=1, ativo=1 WHERE id=?')->execute([password_hash($senha,PASSWORD_DEFAULT),$pedido['aluno_id']]);
    }
    $pdo->prepare("UPDATE pedidos SET email_status=?, email_tentativas=email_tentativas+1, email_enviado_em=IF(?,NOW(),email_enviado_em), email_ultimo_erro=? WHERE id=?")->execute([$ok?'enviado':'falha',$ok?1:0,$ok?null:'SMTP não confirmou o reenvio',$pedidoId]);
    return $ok;
}
