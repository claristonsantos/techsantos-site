<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/mailer.php';

// Pré-venda (validação) do minicurso "Power BI com IA": lista de espera com preço de fundador.
// Sessão antes de qualquer saída: sem isso o cookie do CSRF se perde (ver comprar.php).
csrf_token();

const IA_PRECO_FUNDADOR = '47';
const IA_PRECO_NORMAL = '97';
const IA_LANCAMENTO = 'janeiro de 2027';

function ia_lista_schema(PDO $pdo): void
{
    $pdo->exec("CREATE TABLE IF NOT EXISTS lista_espera (
        id INT AUTO_INCREMENT PRIMARY KEY,
        produto VARCHAR(40) NOT NULL,
        nome VARCHAR(120) NULL,
        email VARCHAR(190) NOT NULL,
        whatsapp VARCHAR(20) NULL,
        uso VARCHAR(60) NULL,
        utm_source VARCHAR(150) NULL,
        utm_campaign VARCHAR(150) NULL,
        criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY uq_produto_email (produto, email)
    ) DEFAULT CHARSET=utf8mb4");
}

$ok = false; $erro = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $nome = mb_substr(trim((string)($_POST['nome'] ?? '')), 0, 120);
    $email = mb_strtolower(trim((string)($_POST['email'] ?? '')));
    $zap = preg_replace('/\D/', '', (string)($_POST['whatsapp'] ?? '')) ?? '';
    $uso = mb_substr(trim((string)($_POST['uso'] ?? '')), 0, 60);
    if (trim((string)($_POST['website'] ?? '')) !== '') {
        $ok = true; // honeypot
    } elseif ($nome === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'Informe seu nome e um e-mail válido.';
    } elseif ($zap !== '' && (strlen($zap) < 10 || strlen($zap) > 13)) {
        $erro = 'WhatsApp inválido. Use DDD + número, ex.: 64999998888.';
    } else {
        $pdo = db();
        ia_lista_schema($pdo);
        $st = $pdo->prepare('INSERT INTO lista_espera (produto, nome, email, whatsapp, uso, utm_source, utm_campaign) VALUES (?,?,?,?,?,?,?)
            ON DUPLICATE KEY UPDATE nome = VALUES(nome), whatsapp = COALESCE(NULLIF(VALUES(whatsapp), \'\'), whatsapp), uso = COALESCE(NULLIF(VALUES(uso), \'\'), uso)');
        $st->execute(['power-bi-ia', $nome, $email, $zap ?: null, $uso ?: null,
            mb_substr((string)($_POST['utm_source'] ?? ''), 0, 150) ?: null, mb_substr((string)($_POST['utm_campaign'] ?? ''), 0, 150) ?: null]);
        $novo = $st->rowCount() === 1;
        if ($novo) {
            $primeiro = htmlspecialchars(explode(' ', $nome)[0], ENT_QUOTES);
            $html = '<table width="100%" cellpadding="0" cellspacing="0" style="font-family:Arial,sans-serif;background:#ffffff;max-width:600px;margin:0 auto;">'
                . '<tr><td style="background:#0F2440;padding:22px 32px;color:#ffffff;font-size:18px;font-weight:bold;">TECH SANTOS BR</td></tr>'
                . '<tr><td style="padding:28px 32px;color:#1F2937;font-size:15px;line-height:1.6;">'
                . "<p>Oi, {$primeiro}! Sua vaga na lista do <strong>Power BI com IA</strong> está garantida.</p>"
                . '<p>Quando o minicurso abrir (previsão: ' . IA_LANCAMENTO . '), você recebe o link antes de todo mundo com o <strong>preço de fundador de R$ ' . IA_PRECO_FUNDADOR . '</strong> (depois ele passa a custar R$ ' . IA_PRECO_NORMAL . ').</p>'
                . '<p>Você não paga nada agora. Responda este e-mail contando qual tarefa do seu trabalho você mais gostaria de acelerar com IA: as respostas vão virar aulas do curso.</p>'
                . '<p>Abraço,<br>Clariston Santos</p></td></tr>' . email_footer_html() . '</table>';
            $text = "Oi, {$nome}! Sua vaga na lista do Power BI com IA está garantida. Quando o minicurso abrir (previsão: " . IA_LANCAMENTO . "), você recebe o link com o preço de fundador de R$ " . IA_PRECO_FUNDADOR . " (depois R$ " . IA_PRECO_NORMAL . "). Você não paga nada agora.";
            send_html_email($email, 'Sua vaga no Power BI com IA está garantida', $html, $text, OWNER_COPY_EMAIL);
        }
        $ok = true;
    }
}
$v = static fn(string $c) => htmlspecialchars((string)($_POST[$c] ?? ''), ENT_QUOTES);
$titulo = 'Power BI com IA: crie dashboards em metade do tempo — TECH SANTOS BR';
$descricao = 'Minicurso prático: use ChatGPT, Claude e Copilot para limpar dados, escrever DAX e montar dashboards no Power BI. Entre na lista e garanta o preço de fundador.';
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?= htmlspecialchars($titulo, ENT_QUOTES) ?></title>
<meta name="description" content="<?= htmlspecialchars($descricao, ENT_QUOTES) ?>" />
<meta property="og:type" content="website" />
<meta property="og:locale" content="pt_BR" />
<meta property="og:url" content="https://techsantos.com.br/power-bi-com-ia.php" />
<meta property="og:title" content="<?= htmlspecialchars($titulo, ENT_QUOTES) ?>" />
<meta property="og:description" content="<?= htmlspecialchars($descricao, ENT_QUOTES) ?>" />
<link rel="canonical" href="https://techsantos.com.br/power-bi-com-ia.php" />
<link rel="icon" type="image/png" href="assets/img/favicon-32.png" />
<link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png" />
<link rel="stylesheet" href="assets/css/style.css?v=20261016" />
<?php require_once __DIR__ . '/inc/meta-pixel.php'; ?>
<?php require_once __DIR__ . '/inc/google-analytics.php'; ?>
<?php if ($ok): ?>
<script>fbq('track', 'Lead', {content_name: 'Lista Power BI com IA'}); if (window.gtag) gtag('event', 'generate_lead', {form: 'lista_power_bi_ia'});</script>
<?php endif; ?>
<style>
  /* Cores explícitas (sem variáveis do tema): no modo escuro elas somem. */
  body.ia { background: radial-gradient(ellipse at 50% 0%, #123B2A 0%, #0F2440 38%, #050B16 78%) fixed; color: #F4F4F5; margin: 0; }
  .ia-shell { max-width: 980px; margin: 0 auto; padding: clamp(1.25rem, 4vw, 3rem) 1rem 4rem; }
  .ia-top { display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; }
  .ia-top a { color: #A1A1AA; text-decoration: none; }
  .ia-top strong { letter-spacing: 0.08em; color: #fff; }
  .ia-top strong span { color: #4ADE80; }
  .ia-hero { text-align: center; padding: clamp(2rem, 6vw, 3.5rem) 0 1.5rem; }
  .ia-tag { display: inline-block; background: #22C55E; color: #052E16; font-weight: 800; letter-spacing: 0.14em; font-size: 0.78rem; padding: 0.4rem 0.9rem; border-radius: 4px; }
  .ia-hero h1 { font-size: clamp(2rem, 6vw, 3.3rem); line-height: 1.07; margin: 1rem 0 0.8rem; color: #fff; font-weight: 800; }
  .ia-hero h1 em { font-style: normal; color: #4ADE80; }
  .ia-hero p { color: #D4D4D8; font-size: clamp(1rem, 2.4vw, 1.18rem); max-width: 660px; margin: 0 auto; line-height: 1.55; }
  .ia-cta { display: inline-block; margin-top: 1.6rem; background: #22C55E; color: #052E16; font-weight: 800; padding: 0.9rem 1.6rem; border-radius: 8px; text-decoration: none; font-size: 1.05rem; }
  .ia-sec { background: rgba(15,36,64,0.6); border: 1px solid #1E3A5F; border-radius: 12px; padding: 1.5rem; margin: 1.25rem 0; }
  .ia-sec h2 { color: #fff; font-size: 1.3rem; margin: 0 0 1rem; }
  .ia-sec p { color: #CBD5E1; line-height: 1.55; margin: 0 0 0.6rem; }
  .ia-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 0.8rem; }
  .ia-grid div { background: #0B1628; border-left: 3px solid #22C55E; border-radius: 8px; padding: 0.9rem 1rem; }
  .ia-grid b { display: block; color: #4ADE80; margin-bottom: 0.3rem; }
  .ia-grid span { color: #CBD5E1; font-size: 0.9rem; line-height: 1.45; }
  .ia-offer { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; align-items: start; margin-top: 1.25rem; }
  @media (max-width: 760px) { .ia-offer { grid-template-columns: 1fr; } }
  .ia-price { background: #18181B; border: 2px solid #22C55E; border-radius: 12px; padding: 1.5rem; text-align: center; }
  .ia-price .de { color: #A1A1AA; } .ia-price .de s { font-family: 'Plex Mono', monospace; }
  .ia-price .por { font-family: 'Plex Mono', monospace; font-size: clamp(2.4rem, 7vw, 3.1rem); color: #4ADE80; font-weight: 700; margin: 0.3rem 0; }
  .ia-price .obs { color: #D4D4D8; font-size: 0.92rem; }
  .ia-price ul { list-style: none; padding: 0; margin: 1.1rem 0 0; text-align: left; display: grid; gap: 0.5rem; font-size: 0.9rem; color: #D4D4D8; }
  .ia-price li::before { content: "✓ "; color: #4ADE80; font-weight: 700; }
  .ia-form { background: #18181B; border: 1px solid #3F3F46; border-radius: 12px; padding: 1.5rem; color: #F4F4F5; }
  .ia-form h2 { font-size: 1.2rem; margin: 0 0 1rem; color: #fff; }
  .ia-form label { display: block; color: #E4E4E7; font-weight: 600; font-size: 0.9rem; margin: 0.8rem 0 0.3rem; }
  .ia-form input, .ia-form select { width: 100%; box-sizing: border-box; background: #0B0B0F; color: #fff; border: 1px solid #52525B; border-radius: 6px; padding: 0.7rem 0.8rem; font-size: 1rem; }
  .ia-form input::placeholder { color: #71717A; }
  .ia-form button { width: 100%; margin-top: 1.1rem; background: #22C55E; color: #052E16; border: 0; border-radius: 8px; padding: 0.9rem; font-weight: 800; font-size: 1.05rem; cursor: pointer; }
  .ia-form .note { color: #A1A1AA; font-size: 0.78rem; margin-top: 0.8rem; }
  .ia-msg { border-radius: 10px; padding: 1.2rem; font-size: 0.98rem; line-height: 1.5; }
  .ia-msg.ok { background: #052E16; border: 1px solid #22C55E; color: #DCFCE7; }
  .ia-msg.err { background: #450A0A; border: 1px solid #F87171; color: #FEE2E2; margin-bottom: 0.8rem; }
  .ia-hp { position: absolute; left: -9999px; }
  .ia-faq { margin-top: 2rem; display: grid; gap: 0.6rem; }
  .ia-faq details { background: #18181B; border: 1px solid #27272A; border-radius: 8px; padding: 0.85rem 1rem; }
  .ia-faq summary { cursor: pointer; font-weight: 600; color: #fff; }
  .ia-faq p { color: #A1A1AA; font-size: 0.9rem; margin: 0.6rem 0 0; }
  footer.ia-foot { text-align: center; color: #71717A; font-size: 0.8rem; padding: 1.5rem 1rem; border-top: 1px solid #1E3A5F; }
</style>
</head>
<body class="ia">
<div class="ia-shell">
  <div class="ia-top"><a href="/"><strong>TECH <span>SANTOS BR</span></strong></a><a href="/cursos.php">Ver todos os cursos →</a></div>

  <section class="ia-hero">
    <span class="ia-tag">PRÉ-VENDA · MINICURSO</span>
    <h1>Power BI com IA: dashboards em <em>metade do tempo</em></h1>
    <p>Use ChatGPT, Claude e Copilot para limpar planilhas, escrever DAX e montar relatórios. E aprenda a perceber quando a IA erra, porque é isso que separa quem é promovido de quem passa vergonha na reunião.</p>
    <a class="ia-cta" href="#lista">Quero o preço de fundador</a>
  </section>

  <section class="ia-sec">
    <h2>O que você vai fazer com IA</h2>
    <div class="ia-grid">
      <div><b>1. Prompts que funcionam</b><span>Como pedir à IA o que você precisa no Power BI, com exemplos prontos para copiar.</span></div>
      <div><b>2. Dados limpos em minutos</b><span>A IA escreve o Power Query (linguagem M) que tratava a planilha bagunçada.</span></div>
      <div><b>3. DAX sem travar</b><span>Medidas de acumulado, comparação com o ano anterior e ranking, conferindo cada resultado.</span></div>
      <div><b>4. Layout que comunica</b><span>A IA sugere visuais e títulos; você aprende a escolher o que o chefe entende em 5 segundos.</span></div>
      <div><b>5. IA montando o modelo</b><span>O diferencial: IA criando tabelas, relações e medidas direto no Power BI Desktop.</span></div>
      <div><b>6. Projeto completo</b><span>Um dashboard do zero ao relatório publicado, com IA em cada etapa.</span></div>
    </div>
  </section>

  <section class="ia-sec">
    <h2>Para quem é</h2>
    <p>Para quem já usa Excel ou Power BI no trabalho e quer entregar análises mais rápido, com mais qualidade, e ganhar destaque na empresa. Funciona com as versões gratuitas do ChatGPT e do Claude; o Copilot do Power BI entra como bônus para quem tem acesso pela empresa.</p>
    <p>Quem dá as aulas: Clariston Santos, trabalha com Power BI desde 2018, nota 5,0 em 46 avaliações de alunos no Superprof.</p>
  </section>

  <div class="ia-offer" id="lista">
    <div class="ia-price">
      <div class="de">Preço no lançamento: <s>R$ <?= IA_PRECO_NORMAL ?></s></div>
      <div class="por">R$ <?= IA_PRECO_FUNDADOR ?></div>
      <div class="obs">preço de fundador, só para quem está na lista</div>
      <ul>
        <li>Você não paga nada agora</li>
        <li>Recebe o link antes de todo mundo (previsão: <?= IA_LANCAMENTO ?>)</li>
        <li>Vídeo-aulas curtas e práticas, com certificado</li>
        <li>Prompts e arquivos dos exercícios para baixar</li>
        <li>7 dias de garantia incondicional depois da compra</li>
      </ul>
    </div>
    <div class="ia-form">
      <?php if ($ok): ?>
        <div class="ia-msg ok"><strong>Pronto, sua vaga está garantida!</strong><br>Mandamos a confirmação para o seu e-mail. Quando o minicurso abrir, você recebe o link com o preço de fundador de R$ <?= IA_PRECO_FUNDADOR ?>.</div>
      <?php else: ?>
        <h2>Entrar na lista (grátis)</h2>
        <?php if ($erro): ?><div class="ia-msg err"><?= htmlspecialchars($erro, ENT_QUOTES) ?></div><?php endif; ?>
        <form method="post" action="#lista">
          <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES) ?>">
          <input type="hidden" name="utm_source"><input type="hidden" name="utm_campaign">
          <div class="ia-hp" aria-hidden="true"><input type="text" name="website" tabindex="-1" autocomplete="off"></div>
          <label for="ia-nome">Nome</label>
          <input id="ia-nome" name="nome" required maxlength="120" value="<?= $v('nome') ?>" autocomplete="name">
          <label for="ia-email">E-mail</label>
          <input id="ia-email" type="email" name="email" required maxlength="190" value="<?= $v('email') ?>" autocomplete="email">
          <label for="ia-zap">WhatsApp (opcional)</label>
          <input id="ia-zap" type="tel" name="whatsapp" maxlength="15" placeholder="64999998888" value="<?= $v('whatsapp') ?>">
          <label for="ia-uso">Você usa Power BI hoje?</label>
          <select id="ia-uso" name="uso">
            <option value="">Selecione</option>
            <option value="nunca">Nunca usei</option>
            <option value="basico">Uso o básico</option>
            <option value="trabalho">Uso no trabalho todo dia</option>
            <option value="excel">Ainda só uso Excel</option>
          </select>
          <button type="submit">Garantir meu preço de fundador</button>
          <p class="note">Sem cobrança agora. Seus dados servem só para avisar do lançamento; dá para sair da lista a qualquer momento.</p>
        </form>
      <?php endif; ?>
    </div>
  </div>

  <section class="ia-faq">
    <details><summary>Preciso pagar alguma coisa agora?</summary><p>Não. A lista é grátis. Quando o minicurso abrir, você decide se compra pelo preço de fundador.</p></details>
    <details><summary>Preciso pagar ChatGPT, Claude ou Copilot?</summary><p>Não. O curso funciona com as versões gratuitas do ChatGPT e do Claude. O Copilot do Power BI é bônus para quem tem acesso pela empresa.</p></details>
    <details><summary>Serve para quem está começando?</summary><p>Sim, mas você aproveita mais se já abriu o Power BI ao menos uma vez. Quem está do zero pode começar pelo <a href="/curso-power-bi.php" style="color:#4ADE80">curso completo de Power BI</a>.</p></details>
    <details><summary>A IA não vai fazer tudo sozinha?</summary><p>Não, e esse é o ponto do curso. A IA acelera, mas erra fórmula, inventa coluna e escolhe gráfico ruim. Você aprende a usar a IA e a conferir o que ela entrega.</p></details>
  </section>
</div>
<footer class="ia-foot">© 2026 TECH SANTOS BR Treinamentos e Aulas Particulares · CNPJ 41.135.509/0001-29</footer>
<script src="/assets/js/analytics-events.js?v=20261117-origem"></script>
<script>
(function(){
  var a=typeof window.techSantosAttribution==='function'?window.techSantosAttribution():{};
  var m={campaign_source:'utm_source',campaign_name:'utm_campaign'};
  Object.keys(m).forEach(function(k){var el=document.querySelector('[name="'+m[k]+'"]');if(el&&a[k])el.value=a[k];});
})();
</script>
</body>
</html>
