<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../pedidos.php';
require_once __DIR__ . '/_partials.php';
require_admin();
csrf_token();
$mensagem = null; $mensagemOk = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check(); $pedidoId = (int)($_POST['pedido_id'] ?? 0);
    try { $mensagemOk = reenviar_acesso_pedido($pedidoId); $mensagem = $mensagemOk ? 'Acesso reenviado com uma nova senha provisória.' : 'Não foi possível reenviar o acesso.'; }
    catch (Throwable $e) { error_log('Reenvio pedido ' . $pedidoId . ': ' . $e->getMessage()); $mensagem = 'Falha no reenvio. Consulte o status e tente novamente.'; }
}
$pdo = db();
$busca = trim((string)($_GET['busca'] ?? ''));
$status = in_array(($_GET['status'] ?? ''), ['pago','pendente','cancelado'], true) ? (string)$_GET['status'] : '';
$emailStatus = in_array(($_GET['email'] ?? ''), ['enviado','falha','pendente','nao_necessario'], true) ? (string)$_GET['email'] : '';
$periodo = in_array(($_GET['periodo'] ?? '30'), ['7','30','90','todos'], true) ? (string)$_GET['periodo'] : '30';
$pagina = max(1, (int)($_GET['pagina'] ?? 1)); $porPagina = 30;
$where=[]; $params=[];
if($busca!==''){ $where[]='(p.nome LIKE ? OR p.email LIKE ? OR CAST(p.id AS CHAR)=?)'; $like='%'.$busca.'%'; $params=[$like,$like,ltrim($busca,'#')]; }
if($status!==''){ $where[]='p.status=?'; $params[]=$status; }
if($emailStatus!==''){ $where[]='p.email_status=?'; $params[]=$emailStatus; }
if($periodo!=='todos'){ $where[]='p.criado_em >= DATE_SUB(NOW(), INTERVAL '.(int)$periodo.' DAY)'; }
$whereSql=$where?' WHERE '.implode(' AND ',$where):'';
$count=$pdo->prepare('SELECT COUNT(*) FROM pedidos p'.$whereSql); $count->execute($params); $totalPedidos=(int)$count->fetchColumn();
$paginas=max(1,(int)ceil($totalPedidos/$porPagina)); $pagina=min($pagina,$paginas); $offset=($pagina-1)*$porPagina;
$stmt=$pdo->prepare('SELECT p.*,c.nome AS curso_nome FROM pedidos p JOIN cursos c ON c.id=p.curso_id'.$whereSql.' ORDER BY p.criado_em DESC LIMIT '.$porPagina.' OFFSET '.$offset); $stmt->execute($params); $pedidos=$stmt->fetchAll();
admin_head('Pedidos'); admin_topbar('pedidos');
?>
<main class="admin-main">
  <div class="admin-head"><div><span class="admin-eyebrow">Vendas e alunos</span><h1>Pedidos</h1><p>Acompanhe pagamentos e identifique falhas no envio do acesso.</p></div></div>
  <?php if($mensagem): ?><div class="alert <?= $mensagemOk?'alert-success':'alert-error' ?>" role="<?= $mensagemOk?'status':'alert' ?>"><?= htmlspecialchars($mensagem,ENT_QUOTES) ?></div><?php endif; ?>
  <form class="admin-filter-bar" method="get" aria-label="Filtros de pedidos">
    <div class="field"><label for="busca">Buscar</label><input type="search" id="busca" name="busca" placeholder="Nome, e-mail ou número" value="<?= htmlspecialchars($busca,ENT_QUOTES) ?>"></div>
    <div class="field"><label for="status">Pagamento</label><select id="status" name="status"><option value="">Todos</option><?php foreach(['pago'=>'Pago','pendente'=>'Pendente','cancelado'=>'Cancelado'] as $v=>$l): ?><option value="<?= $v ?>" <?= $status===$v?'selected':'' ?>><?= $l ?></option><?php endforeach; ?></select></div>
    <div class="field"><label for="email">Acesso</label><select id="email" name="email"><option value="">Todos</option><?php foreach(['enviado'=>'Enviado','falha'=>'Falha','pendente'=>'Pendente','nao_necessario'=>'Não necessário'] as $v=>$l): ?><option value="<?= $v ?>" <?= $emailStatus===$v?'selected':'' ?>><?= $l ?></option><?php endforeach; ?></select></div>
    <div class="field"><label for="periodo">Período</label><select id="periodo" name="periodo"><option value="7" <?= $periodo==='7'?'selected':'' ?>>7 dias</option><option value="30" <?= $periodo==='30'?'selected':'' ?>>30 dias</option><option value="90" <?= $periodo==='90'?'selected':'' ?>>90 dias</option><option value="todos" <?= $periodo==='todos'?'selected':'' ?>>Todo período</option></select></div>
    <div class="admin-filter-actions"><button class="btn btn-primary" type="submit">Filtrar</button><a class="btn btn-ghost on-light" href="/admin/pedidos.php">Limpar</a></div>
  </form>
  <div class="admin-list-head"><div><h2>Pedidos encontrados</h2><span><?= $totalPedidos ?> resultado(s)</span></div></div>
  <div class="table-wrap"><table class="data-table"><thead><tr><th>Data</th><th>Cliente</th><th>Curso</th><th>Valor</th><th>Pagamento</th><th>Acesso</th><th>Ação</th></tr></thead><tbody>
  <?php if(!$pedidos): ?><tr class="empty-row"><td colspan="7">Nenhum pedido encontrado com estes filtros.</td></tr><?php endif; ?>
  <?php foreach($pedidos as $p): ?><tr><td><?= date('d/m/Y H:i',strtotime($p['criado_em'])) ?></td><td><strong><?= htmlspecialchars($p['nome'],ENT_QUOTES) ?></strong><small><?= htmlspecialchars($p['email'],ENT_QUOTES) ?> · #<?= (int)$p['id'] ?></small></td><td><?= htmlspecialchars($p['curso_nome'],ENT_QUOTES) ?></td><td>R$ <?= number_format($p['valor_centavos']/100,2,',','.') ?></td><td><span class="admin-status status-<?= $p['status']==='pago'?'success':($p['status']==='cancelado'?'danger':'warning') ?>"><?= htmlspecialchars($p['status'],ENT_QUOTES) ?></span></td><td><span class="admin-status status-<?= ($p['email_status']??'')==='enviado'?'success':(($p['email_status']??'')==='falha'?'danger':'neutral') ?>"><?= htmlspecialchars($p['email_status']??'pendente',ENT_QUOTES) ?></span><?php if(!empty($p['email_tentativas'])): ?><small><?= (int)$p['email_tentativas'] ?> tentativa(s)</small><?php endif; ?><?php if(($p['email_status']??'')==='falha' && !empty($p['email_ultimo_erro'])): ?><span class="admin-inline-error"><?= htmlspecialchars(mb_strimwidth((string)$p['email_ultimo_erro'],0,100,'…'),ENT_QUOTES) ?></span><?php endif; ?></td><td><?php if($p['status']==='pago' && !empty($p['aluno_id'])): ?><div class="admin-table-actions"><form method="post" onsubmit="return confirm('Gerar nova senha provisória e reenviar o acesso?');"><?= csrf_field() ?><input type="hidden" name="pedido_id" value="<?= (int)$p['id'] ?>"><button type="submit">Reenviar acesso</button></form></div><?php else: ?>—<?php endif; ?></td></tr><?php endforeach; ?>
  </tbody></table></div>
  <?php admin_pagination($pagina,$paginas,$totalPedidos); ?>
</main>
<?php admin_foot(); ?>
