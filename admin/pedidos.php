<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../pedidos.php';
require_once __DIR__ . '/_partials.php';
require_admin();
csrf_token();
$mensagem=null; $mensagemOk=false;
if($_SERVER['REQUEST_METHOD']==='POST'){
    csrf_check(); $pedidoId=(int)($_POST['pedido_id']??0);
    try{$mensagemOk=reenviar_acesso_pedido($pedidoId);$mensagem=$mensagemOk?'Acesso reenviado. A senha anterior foi substituída por uma nova senha provisória.':'Não foi possível reenviar o acesso.';}
    catch(Throwable $e){error_log('Reenvio pedido '.$pedidoId.': '.$e->getMessage());$mensagem='Falha no reenvio. Consulte o status e tente novamente.';}
}
$pdo=db();
$pedidos=$pdo->query('SELECT p.*,c.nome AS curso_nome FROM pedidos p JOIN cursos c ON c.id=p.curso_id ORDER BY p.criado_em DESC LIMIT 200')->fetchAll();
admin_head('Pedidos'); admin_topbar('pedidos');
?>
<main class="admin-main">
  <div class="admin-head"><h1>Pedidos</h1></div>
  <?php if($mensagem): ?><div class="alert <?= $mensagemOk?'alert-success':'alert-error' ?>"><?= htmlspecialchars($mensagem,ENT_QUOTES) ?></div><?php endif; ?>
  <div class="table-wrap"><table class="data-table">
    <thead><tr><th>Data</th><th>Nome</th><th>E-mail</th><th>Curso</th><th>Valor</th><th>Pedido</th><th>E-mail de acesso</th><th>Ação</th></tr></thead>
    <tbody>
    <?php if(!$pedidos): ?><tr class="empty-row"><td colspan="8">Nenhum pedido ainda.</td></tr><?php endif; ?>
    <?php foreach($pedidos as $p): ?><tr>
      <td><?= date('d/m/Y H:i',strtotime($p['criado_em'])) ?></td>
      <td><?= htmlspecialchars($p['nome'],ENT_QUOTES) ?></td><td><?= htmlspecialchars($p['email'],ENT_QUOTES) ?></td>
      <td><?= htmlspecialchars($p['curso_nome'],ENT_QUOTES) ?></td><td>R$ <?= number_format($p['valor_centavos']/100,2,',','.') ?></td>
      <td><span class="badge <?= $p['status']==='pago'?'on':'off' ?>"><?= htmlspecialchars($p['status'],ENT_QUOTES) ?></span></td>
      <td><span class="badge <?= ($p['email_status']??'')==='enviado'?'on':'off' ?>"><?= htmlspecialchars($p['email_status']??'pendente',ENT_QUOTES) ?></span><?php if(!empty($p['email_tentativas'])): ?><small> (<?= (int)$p['email_tentativas'] ?> tentativa(s))</small><?php endif; ?></td>
      <td><?php if($p['status']==='pago' && !empty($p['aluno_id'])): ?><form method="post" onsubmit="return confirm('Gerar nova senha provisória e reenviar o acesso? A senha atual deixará de funcionar.');"><?= csrf_field() ?><input type="hidden" name="pedido_id" value="<?= (int)$p['id'] ?>"><button type="submit" class="btn btn-ghost on-light">Reenviar acesso</button></form><?php else: ?>—<?php endif; ?></td>
    </tr><?php endforeach; ?>
    </tbody>
  </table></div>
</main>
<?php admin_foot(); ?>
