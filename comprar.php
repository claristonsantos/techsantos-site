<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/mercadopago.php';

// Precisa iniciar a sessão AQUI, antes de qualquer saída de HTML — o
// formulário só chama csrf_field() lá embaixo, no meio do body, e a essa
// altura os headers HTTP já foram enviados, então o Set-Cookie da sessão
// seria descartado silenciosamente (sem erro nenhum, só sem cookie no
// navegador) e todo POST cairia em "Sessão expirada".
csrf_token();

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
    $cpf = '';
    $telefoneDigits = preg_replace('/\D/', '', (string)($_POST['telefone'] ?? '')) ?? '';

    if ($nome === '' || $email === '' || $telefoneDigits === '') {
        $error = 'Preencha nome, e-mail e telefone.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'E-mail inválido.';
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
        $checkout = mercadopago_create_preference(
            ['id' => $pedidoId, 'nome' => $nome, 'email' => $email, 'cpf' => $cpf, 'telefone_digits' => $telefoneDigits, 'valor_centavos' => $precoCentavos],
            $curso,
            $scheme . '://' . $host . '/pagbank-retorno.php?pedido=' . $pedidoId,
            $scheme . '://' . $host . '/mercadopago-webhook.php'
        );

        if ($checkout === null) {
            $error = 'Não foi possível iniciar o pagamento agora. Tente novamente em instantes ou fale conosco pelo WhatsApp.';
        } else {
            db()->prepare('UPDATE pedidos SET mercadopago_preference_id = ? WHERE id = ?')->execute([$checkout['id'], $pedidoId]);
            header('Location: ' . $checkout['checkout_url']);
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
<?php require_once __DIR__ . '/inc/google-analytics.php'; ?>
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
  .buy-guarantee { display: flex; gap: 0.75rem; align-items: flex-start; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--line); font-size: 0.85rem; color: var(--ink-soft); }
  .buy-guarantee svg { width: 22px; height: 22px; color: var(--green-strong); flex: none; margin-top: 0.1rem; }

  .buy-social { background: var(--surface-2); border-radius: 8px; padding: 1.1rem 1.3rem; margin-bottom: 1.75rem; }
  .buy-social-stat { display: flex; align-items: center; gap: 0.6rem; font-size: 0.88rem; font-weight: 600; color: var(--ink); margin-bottom: 0.5rem; flex-wrap: wrap; }
  .buy-social-stat.yt { margin-bottom: 0.9rem; padding-bottom: 0.9rem; border-bottom: 1px solid var(--line); }
  .buy-social-stat .stars { color: #E3A008; letter-spacing: 1px; font-size: 0.95rem; }
  .buy-social-stat a { font-weight: 500; color: var(--green-strong); text-decoration: none; font-size: 0.78rem; margin-left: auto; }
  .buy-social-stat a:hover { text-decoration: underline; }
  .buy-testimonials { display: grid; gap: 0.8rem; }
  .buy-testimonial { font-size: 0.86rem; color: var(--ink-soft); line-height: 1.5; }
  .buy-testimonial strong { color: var(--ink); font-weight: 600; }
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
      <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12l5 5 11-11"/></svg><span>13 módulos, 46 videoaulas práticas (mais de 7 horas) + apostila com referências oficiais Microsoft</span></li>
      <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12l5 5 11-11"/></svg><span>Avaliações por módulo e avaliação final com certificado de conclusão</span></li>
      <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12l5 5 11-11"/></svg><span>Acesso liberado automaticamente após a confirmação do pagamento</span></li>
    </ul>

    <div class="buy-social">
      <div class="buy-social-stat yt">
        <span>▶️ Canal no YouTube com mais de 22 mil visualizações em tutoriais de Power BI</span>
        <a href="https://www.youtube.com/@claristonsantos8129?sub_confirmation=1" target="_blank" rel="noopener">Inscreva-se no canal →</a>
      </div>
      <div class="buy-social-stat">
        <span class="stars">★★★★★</span>
        <span>5.0 · 46 avaliações reais de alunos · 50+ alunos</span>
        <a href="https://www.superprof.com.br/power-dax-linguagem-criacao-automacao-relatorios-com-integracao-share-point-one-drive-outros-banco.html" target="_blank" rel="noopener">Ver todas no Superprof →</a>
      </div>
      <div class="buy-testimonials">
        <p class="buy-testimonial">"Amei a aula de Power BI do professor Clariston! Ele me ensinou de forma clara e objetiva e demonstrou dominar o assunto, além de ser muito atencioso. Super indico!" <strong>— Thamirys</strong></p>
        <p class="buy-testimonial">"Ótimo professor que realmente entende de Power BI. Aulas conceituais e práticas para a melhor fixação do conteúdo lecionado. Nota 10!" <strong>— Leandro</strong></p>
        <p class="buy-testimonial">"O Clariston é um professor extraordinário, tem conhecimento do assunto, tem didática, ensina quantas vezes for necessário até você aprender! Se você realmente deseja aprender, o Clariston é o professor certo!" <strong>— Joice</strong></p>
      </div>
    </div>

    <?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES) ?></div><?php endif; ?>

    <?php if ($precoCentavos): ?>
    <form method="post" novalidate>
      <?= csrf_field() ?>
      <div class="field">
        <label for="nome">Nome completo</label>
        <input type="text" id="nome" name="nome" required value="<?= htmlspecialchars($_POST['nome'] ?? '', ENT_QUOTES) ?>">
      </div>
      <div class="field">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES) ?>">
      </div>
      <div class="field">
        <label for="telefone">Telefone (com DDD)</label>
        <input type="tel" id="telefone" name="telefone" required maxlength="15" placeholder="(64) 99999-8888" value="<?= htmlspecialchars($_POST['telefone'] ?? '', ENT_QUOTES) ?>">
      </div>
      <button type="submit" class="btn btn-primary btn-block">Ir para o pagamento</button>
      <p class="buy-note">Você será redirecionado ao ambiente seguro do Mercado Pago para concluir com cartão ou Pix (o CPF é pedido lá, na hora do pagamento). Seu acesso é liberado por e-mail assim que o pagamento for confirmado.</p>
    </form>
    <?php endif; ?>

    <div class="buy-guarantee">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l8 4v6c0 5-3.5 8.5-8 10-4.5-1.5-8-5-8-10V6l8-4z"/><path d="M9 12l2 2 4-4"/></svg>
      <span><strong>Garantia:</strong> mediante solicitação, se você assistiu menos de 20% do curso e não gostou, devolvemos 100% do valor.</span>
    </div>

    <div class="buy-alt">
      <a href="https://wa.me/5564992905785?text=<?= $whatsMsg ?>" target="_blank" rel="noopener">Prefere falar antes? WhatsApp →</a>
      <a href="mailto:contato@techsantos.com.br?subject=Matr%C3%ADcula%20<?= rawurlencode($nomeCurso) ?>">Turma fechada / in company →</a>
    </div>
  </div>
</div>
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
