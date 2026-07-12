<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/_partials.php';
require_admin();

$pdo = db();
$pedidos = $pdo->query(
    'SELECT p.*, c.nome AS curso_nome FROM pedidos p JOIN cursos c ON c.id = p.curso_id ORDER BY p.criado_em DESC LIMIT 200'
)->fetchAll();

admin_head('Pedidos');
admin_topbar('pedidos');
?>
<main class="admin-main">
  <div class="admin-head"><h1>Pedidos</h1></div>
  <div class="table-wrap">
    <table class="data-table">
      <thead><tr><th>Data</th><th>Nome</th><th>E-mail</th><th>Curso</th><th>Valor</th><th>Status</th></tr></thead>
      <tbody>
        <?php if (!$pedidos): ?>
          <tr class="empty-row"><td colspan="6">Nenhum pedido ainda.</td></tr>
        <?php endif; ?>
        <?php foreach ($pedidos as $p): ?>
          <tr>
            <td><?= date('d/m/Y H:i', strtotime($p['criado_em'])) ?></td>
            <td><?= htmlspecialchars($p['nome'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($p['email'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($p['curso_nome'], ENT_QUOTES) ?></td>
            <td>R$ <?= number_format($p['valor_centavos'] / 100, 2, ',', '.') ?></td>
            <td><span class="badge <?= $p['status'] === 'pago' ? 'on' : 'off' ?>"><?= htmlspecialchars($p['status'], ENT_QUOTES) ?></span></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>
<?php admin_foot(); ?>
