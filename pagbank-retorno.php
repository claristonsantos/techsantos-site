<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

$pedidoId = (int)($_GET['pedido'] ?? 0);
$pedido = null;
if ($pedidoId > 0) {
    $stmt = db()->prepare('SELECT p.*, c.nome AS curso_nome FROM pedidos p JOIN cursos c ON c.id = p.curso_id WHERE p.id = ?');
    $stmt->execute([$pedidoId]);
    $pedido = $stmt->fetch();
}
$pago = $pedido && $pedido['status'] === 'pago';
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Pagamento — TECH SANTOS BR</title>
<link rel="icon" type="image/png" href="assets/img/favicon-32.png" />
<link rel="stylesheet" href="assets/css/style.css" />
<?php require_once __DIR__ . '/inc/meta-pixel.php'; ?>
<?php require_once __DIR__ . '/inc/google-analytics.php'; ?>
<?php if ($pago): ?>
<script>
fbq('track', 'Purchase', {value: <?= json_encode(round($pedido['valor_centavos'] / 100, 2)) ?>, currency: 'BRL', content_name: <?= json_encode($pedido['curso_nome']) ?>}, {eventID: 'pedido_<?= (int)$pedido['id'] ?>'});
</script>
<?php endif; ?>
<style>
  .ret-shell { max-width: 520px; margin: 0 auto; padding: clamp(3rem, 8vw, 6rem) 1.25rem; text-align: center; }
  .ret-icon { width: 56px; height: 56px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; }
  .ret-icon.ok { background: var(--green-soft); color: var(--green-strong); }
  .ret-icon.pending { background: var(--surface-2); color: var(--ink-soft); }
  .ret-shell h1 { font-size: 1.4rem; margin-bottom: 0.75rem; }
  .ret-shell p { color: var(--ink-soft); font-size: 0.96rem; }
</style>
</head>
<body>
<div class="ret-shell">
  <?php if ($pago): ?>
    <div class="ret-icon ok"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12l5 5 11-11"/></svg></div>
    <h1>Pagamento confirmado!</h1>
    <p>Seu acesso ao curso <?= htmlspecialchars($pedido['curso_nome'], ENT_QUOTES) ?> já está liberado. Enviamos um e-mail para <strong><?= htmlspecialchars($pedido['email'], ENT_QUOTES) ?></strong> com seu login e senha provisória.</p>
    <p style="margin-top:1.5rem;"><a class="btn btn-primary" href="/login.php">Acessar a Área do Aluno</a></p>
  <?php else: ?>
    <div class="ret-icon pending"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg></div>
    <h1>Confirmando seu pagamento…</h1>
    <p>Isso pode levar alguns instantes, especialmente no Pix. Assim que confirmarmos, você recebe um e-mail com seu acesso. Se preferir, fale com a gente pelo WhatsApp.</p>
    <p style="margin-top:1.5rem;"><a class="btn btn-ghost on-light" href="https://wa.me/5564992905785" target="_blank" rel="noopener">Falar no WhatsApp</a></p>
  <?php endif; ?>
</div>
</body>
</html>
