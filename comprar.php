<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/pagbank.php';

$stmt = db()->prepare("SELECT id, nome, carga_horaria, descricao, modalidade, preco_centavos FROM cursos WHERE slug = 'power-bi'");
$stmt->execute();
$curso = $stmt->fetch();
$nomeCurso = $curso['nome'] ?? 'Power BI Completo';
$precoCentavos = $curso['preco_centavos'] ?? null;
$precoFormatado = $precoCentavos ? number_format($precoCentavos / 100, 2, ',', '.') : null;
$whatsMsg = rawurlencode('Olá! Quero fazer a matrícula no curso ' . $nomeCurso . '.');

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $nome = trim((string)($_POST['nome'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    $cpf = cpf_digits((string)($_POST['cpf'] ?? ''));
    $telefoneDigits = preg_replace('/\D/', '', (string)($_POST['telefone'] ?? '')) ?? '';

    if ($nome === '' || $email === '' || $cpf === '' || $telefoneDigits === '') {
        $error = 'Preencha nome, e-mail, CPF e telefone.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'E-mail inválido.';
    } elseif (!cpf_is_valid($cpf)) {
        $error = 'CPF inválido.';
    } elseif (strlen($telefoneDigits) < 10) {
        $error = 'Telefone inválido. Use DDD + número, ex.: 64999998888.';
    } elseif (!$precoCentavos) {
        $error = 'Este curso ainda não tem um preço configurado para venda online. Fale conosco pelo WhatsApp.';
    } else {
        $ins = db()->prepare('INSERT INTO pedidos (nome, email, cpf, telefone, curso_id, valor_centavos) VALUES (?, ?, ?, ?, ?, ?)');
        $ins->execute([$nome, $email, $cpf, $telefoneDigits, $curso['id'], $precoCentavos]);
        $pedidoId = (int)db()->lastInsertId();

        $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $checkout = pagbank_create_checkout(
            ['id' => $pedidoId, 'nome' => $nome, 'email' => $email, 'cpf' => $cpf, 'telefone_digits' => $telefoneDigits, 'valor_centavos' => $precoCentavos],
            $curso,
            $scheme . '://' . $host . '/pagbank-retorno.php?pedido=' . $pedidoId,
            $scheme . '://' . $host . '/pagbank-webhook.php'
        );

        if ($checkout === null) {
            $error = 'Não foi possível iniciar o pagamento agora. Tente novamente em instantes ou fale conosco pelo WhatsApp.';
        } else {
            db()->prepare('UPDATE pedidos SET pagbank_checkout_id = ? WHERE id = ?')->execute([$checkout['id'], $pedidoId]);
            header('Location: ' . $checkout['pay_url']);
            exit;
        }
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Matricule-se — <?= htmlspecialchars($nomeCurso, ENT_QUOTES) ?> — TECH SANTOS BR</title>
<link rel="icon" type="image/png" href="assets/img/favicon-32.png" />
<link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png" />
<link rel="stylesheet" href="assets/css/style.css" />
<link rel="stylesheet" href="assets/css/admin.css" />
<?php require_once __DIR__ . '/inc/meta-pixel.php'; ?>
<?php if ($precoCentavos): ?>
<script>
fbq('track', 'InitiateCheckout', {value: <?= json_encode(round($precoCentavos / 100, 2)) ?>, currency: 'BRL', content_name: 'Curso Power BI'});
</script>
<?php endif; ?>
<style>
  .buy-shell { max-width: 640px; margin: 0 auto; padding: clamp(2rem, 5vw, 4rem) 1.25rem 5rem; }
  .buy-top a { font-size: 0.85rem; color: var(--ink-soft); text-decoration: none; }
  .buy-card { background: var(--surface); border: 1px solid var(--line); border-radius: 10px; padding: clamp(1.75rem, 5vw, 2.75rem); margin-top: 1.5rem; }
  .buy-card h1 { font-size: 1.5rem; margin-bottom: 0.5rem; }
  .buy-price { font-family: 'Plex Mono', monospace; font-size: 1.8rem; color: var(--green-strong); font-weight: 500; margin-bottom: 1.5rem; }
  .buy-price small { font-family: 'Plex Sans', sans-serif; font-size: 0.85rem; color: var(--ink-faint); font-weight: 400; }
  .buy-includes { list-style: none; padding: 0; margin: 0 0 2rem; display: grid; gap: 0.65rem; }
  .buy-includes li { display: flex; gap: 0.6rem; font-size: 0.92rem; color: var(--ink); }
  .buy-includes svg { width: 16px; height: 16px; color: var(--green-strong); flex: none; margin-top: 0.15rem; }
  .buy-alt { display: flex; gap: 1.5rem; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--line); }
  .buy-alt a { font-size: 0.85rem; color: var(--ink-soft); text-decoration: none; }
  .buy-alt a:hover { color: var(--green-strong); }
  .buy-note { font-size: 0.78rem; color: var(--ink-faint); margin-top: 1rem; }
</style>
</head>
<body>
<div class="buy-shell">
  <div class="buy-top"><a href="/curso-power-bi.php">← Voltar para o curso</a></div>
  <div class="buy-card">
    <h1>Matricule-se no <?= htmlspecialchars($nomeCurso, ENT_QUOTES) ?></h1>
    <?php if ($precoFormatado): ?>
      <p class="buy-price">R$ <?= $precoFormatado ?> <small>à vista, ou parcelado em até 12x no cartão</small></p>
    <?php endif; ?>
    <ul class="buy-includes">
      <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12l5 5 11-11"/></svg><span>13 módulos, 29 videoaulas práticas + apostila com referências oficiais Microsoft</span></li>
      <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12l5 5 11-11"/></svg><span>Avaliações por módulo e avaliação final com certificado de conclusão</span></li>
      <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12l5 5 11-11"/></svg><span>Acesso liberado automaticamente após a confirmação do pagamento</span></li>
    </ul>

    <?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES) ?></div><?php endif; ?>

    <?php if ($precoCentavos): ?>
    <form method="post" novalidate>
      <?= csrf_field() ?>
      <div class="field">
        <label for="nome">Nome completo</label>
        <input type="text" id="nome" name="nome" required value="<?= htmlspecialchars($_POST['nome'] ?? '', ENT_QUOTES) ?>">
      </div>
      <div class="field-row">
        <div class="field">
          <label for="email">E-mail</label>
          <input type="email" id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES) ?>">
        </div>
        <div class="field">
          <label for="cpf">CPF</label>
          <input type="text" id="cpf" name="cpf" required maxlength="14" placeholder="000.000.000-00" value="<?= htmlspecialchars($_POST['cpf'] ?? '', ENT_QUOTES) ?>">
        </div>
      </div>
      <div class="field">
        <label for="telefone">Telefone (com DDD)</label>
        <input type="tel" id="telefone" name="telefone" required maxlength="15" placeholder="(64) 99999-8888" value="<?= htmlspecialchars($_POST['telefone'] ?? '', ENT_QUOTES) ?>">
      </div>
      <button type="submit" class="btn btn-primary btn-block">Ir para o pagamento</button>
      <p class="buy-note">Você será redirecionado ao ambiente seguro do PagBank para concluir com cartão ou Pix. Seu acesso é liberado por e-mail assim que o pagamento for confirmado.</p>
    </form>
    <?php endif; ?>

    <div class="buy-alt">
      <a href="https://wa.me/5564992905785?text=<?= $whatsMsg ?>" target="_blank" rel="noopener">Prefere falar antes? WhatsApp →</a>
      <a href="mailto:contato@techsantos.com.br?subject=Matr%C3%ADcula%20<?= rawurlencode($nomeCurso) ?>">Turma fechada / in company →</a>
    </div>
  </div>
</div>
<script>
  const cpfInput = document.getElementById('cpf');
  if (cpfInput) {
    cpfInput.addEventListener('input', function () {
      let v = this.value.replace(/\D/g, '').slice(0, 11);
      if (v.length > 9) v = v.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
      else if (v.length > 6) v = v.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
      else if (v.length > 3) v = v.replace(/(\d{3})(\d{1,3})/, '$1.$2');
      this.value = v;
    });
  }
</script>
<footer class="site footer-compact">
  <div class="container">
    <div class="footer-social">
      <a href="https://www.instagram.com/tech_santos_br/" target="_blank" rel="noopener" aria-label="TECH SANTOS BR no Instagram">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>
      </a>
      <a href="https://www.facebook.com/techsantosbr/" target="_blank" rel="noopener" aria-label="TECH SANTOS BR no Facebook">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3l-.5 3H13v6.95c5.05-.5 9-4.76 9-9.95z"/></svg>
      </a>
      <a href="https://br.linkedin.com/company/techsantos-br" target="_blank" rel="noopener" aria-label="TECH SANTOS BR no LinkedIn">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor"><path d="M6.94 8.5H3.56V20h3.38V8.5zM5.25 3.5a1.96 1.96 0 100 3.92 1.96 1.96 0 000-3.92zM20.44 20h-3.37v-5.6c0-1.34-.03-3.06-1.87-3.06-1.87 0-2.16 1.46-2.16 2.96V20H9.68V8.5h3.24v1.57h.05c.45-.85 1.55-1.74 3.19-1.74 3.41 0 4.04 2.24 4.04 5.16V20z"/></svg>
      </a>
    </div>
    <div class="footer-bottom">
      <span>© 2026 TECH SANTOS BR Treinamentos e Aulas Particulares · CNPJ 41.135.509/0001-29</span>
    </div>
  </div>
</footer>
</body>
</html>
