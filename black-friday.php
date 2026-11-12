<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/mercadopago.php';
require_once __DIR__ . '/cursos_catalogo.php';
require_once __DIR__ . '/matriculas.php';
require_once __DIR__ . '/promo_black_friday.php';

// Sessão antes de qualquer saída: sem isso o cookie do CSRF se perde (ver comprar.php).
csrf_token();

$pdo = db();
$ativa = bf_ativa();
$cursos = bf_cursos($pdo);
$ancora = null;
foreach ($cursos as $c) if ($c['slug'] === BF_CURSO_ANCORA) $ancora = $c;
$somaCentavos = array_sum(array_map(fn($c) => (int)$c['preco_centavos'], $cursos));
$economiaPct = $somaCentavos > 0 ? (int)round(100 - BF_PRECO_CENTAVOS * 100 / $somaCentavos) : 0;
$fmt = fn(int $c) => number_format($c / 100, 2, ',', '.');
$precoBF = $fmt(BF_PRECO_CENTAVOS);
$whatsMsg = rawurlencode('Olá! Quero o combo Black Friday com os 4 cursos.');

// Aluno logado: preenche os dados e mostra quais cursos ele já tem.
$alunoLogado = null; $jaTem = []; $telefoneAnterior = '';
if ($alunoLogadoId = aluno_logged_id()) {
    $st = $pdo->prepare('SELECT id, nome, email FROM alunos WHERE id = ? AND ativo = 1');
    $st->execute([$alunoLogadoId]);
    $alunoLogado = $st->fetch() ?: null;
    if ($alunoLogado) {
        foreach (matriculas_do_aluno($pdo, (int)$alunoLogado['id']) as $m) $jaTem[(int)$m['id']] = true;
        $st = $pdo->prepare("SELECT telefone FROM pedidos WHERE email = ? AND telefone <> '' ORDER BY id DESC LIMIT 1");
        $st->execute([$alunoLogado['email']]);
        $telefoneAnterior = (string)($st->fetchColumn() ?: '');
    }
}
$temTodos = $alunoLogado && $cursos && count(array_filter($cursos, fn($c) => isset($jaTem[(int)$c['id']]))) === count($cursos);
$valorCampo = static function (string $campo, string $padrao) { return htmlspecialchars((string)($_POST[$campo] ?? $padrao), ENT_QUOTES); };

$error = null; $lembreteOk = false; $lembreteErro = null;
// "Me avise antes de acabar": guarda o contato e o cron social manda o lembrete em 27/11 e 30/11.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'lembrete') {
    csrf_check();
    $lNome = mb_substr(trim((string)($_POST['l_nome'] ?? '')), 0, 120);
    $lEmail = trim((string)($_POST['l_email'] ?? ''));
    $lZap = preg_replace('/\D/', '', (string)($_POST['l_whatsapp'] ?? '')) ?? '';
    if (!$ativa) {
        $lembreteErro = 'A oferta de Black Friday foi encerrada.';
    } elseif (!filter_var($lEmail, FILTER_VALIDATE_EMAIL)) {
        $lembreteErro = 'Informe um e-mail válido.';
    } else {
        bf_lembrete_salvar($pdo, $lNome, $lEmail, $lZap, mb_substr((string)($_POST['utm_source'] ?? ''), 0, 80));
        $lembreteOk = true;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $nome = trim((string)($_POST['nome'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    $telefoneDigits = preg_replace('/\D/', '', (string)($_POST['telefone'] ?? '')) ?? '';

    if (!$ativa) {
        $error = 'A oferta de Black Friday foi encerrada.';
    } elseif (!$ancora || count($cursos) !== count(BF_CURSOS)) {
        $error = 'O combo está indisponível no momento. Fale conosco pelo WhatsApp.';
    } elseif ($nome === '' || $email === '' || $telefoneDigits === '') {
        $error = 'Preencha nome, e-mail e telefone.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'E-mail inválido.';
    } elseif (strlen($telefoneDigits) < 10) {
        $error = 'Telefone inválido. Use DDD + número, ex.: 64999998888.';
    } else {
        bf_ensure_schema($pdo);
        $ga4ClientId = null;
        if (isset($_COOKIE['_ga']) && preg_match('/^GA\d\.\d\.(\d+\.\d+)$/', $_COOKIE['_ga'], $mGa)) $ga4ClientId = $mGa[1];
        $utm = [];
        foreach (['utm_source','utm_medium','utm_campaign','utm_content','utm_term','landing_page'] as $field) {
            $utm[$field] = mb_substr(trim((string)($_POST[$field] ?? '')), 0, $field === 'landing_page' ? 255 : 150);
        }
        $ins = $pdo->prepare('INSERT INTO pedidos (nome,email,cpf,telefone,curso_id,valor_centavos,oferta,ga4_client_id,utm_source,utm_medium,utm_campaign,utm_content,utm_term,landing_page) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $ins->execute([$nome,$email,'',$telefoneDigits,$ancora['id'],BF_PRECO_CENTAVOS,BF_OFERTA,$ga4ClientId,$utm['utm_source'] ?: null,$utm['utm_medium'] ?: null,$utm['utm_campaign'] ?: 'black-friday-2026',$utm['utm_content'] ?: null,$utm['utm_term'] ?: null,$utm['landing_page'] ?: null]);
        $pedidoId = (int)$pdo->lastInsertId();

        $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $checkout = mercadopago_create_preference(
            ['id' => $pedidoId, 'nome' => $nome, 'email' => $email, 'cpf' => '', 'telefone_digits' => $telefoneDigits, 'valor_centavos' => BF_PRECO_CENTAVOS],
            ['id' => $ancora['id'], 'nome' => BF_NOME, 'slug' => 'combo-black-friday'],
            $scheme . '://' . $host . '/pagbank-retorno.php?pedido=' . $pedidoId,
            $scheme . '://' . $host . '/mercadopago-webhook.php'
        );
        if ($checkout === null) {
            $error = 'Não foi possível iniciar o pagamento agora. Tente novamente em instantes ou fale conosco pelo WhatsApp.';
        } else {
            $pdo->prepare('UPDATE pedidos SET mercadopago_preference_id = ? WHERE id = ?')->execute([$checkout['id'], $pedidoId]);
            header('Location: ' . $checkout['checkout_url']);
            exit;
        }
    }
}
$titulo = 'Black Friday: 4 cursos por R$ ' . $precoBF . ' — TECH SANTOS BR';
$descricao = 'Excel, Inglês, Power BI e Python completos, com certificado, por R$ ' . $precoBF . ' à vista ou parcelado no cartão. Oferta válida até ' . BF_FIM_TEXTO . '.';
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
<meta property="og:url" content="https://techsantos.com.br/black-friday.php" />
<meta property="og:title" content="<?= htmlspecialchars($titulo, ENT_QUOTES) ?>" />
<meta property="og:description" content="<?= htmlspecialchars($descricao, ENT_QUOTES) ?>" />
<meta property="og:image" content="https://techsantos.com.br/assets/img/black-friday-og.jpg" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<meta name="twitter:card" content="summary_large_image" />
<link rel="canonical" href="https://techsantos.com.br/black-friday.php" />
<link rel="icon" type="image/png" href="assets/img/favicon-32.png" />
<link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png" />
<link rel="stylesheet" href="assets/css/style.css?v=20261016" />
<link rel="stylesheet" href="assets/css/admin.css" />
<?php require_once __DIR__ . '/inc/meta-pixel.php'; ?>
<?php require_once __DIR__ . '/inc/google-analytics.php'; ?>
<?php if ($ativa): ?>
<script>
fbq('track', 'InitiateCheckout', {value: <?= json_encode(BF_PRECO_CENTAVOS / 100) ?>, currency: 'BRL', content_name: <?= json_encode(BF_NOME, JSON_UNESCAPED_UNICODE) ?>});
</script>
<?php endif; ?>
<style>
  body.bf { background: radial-gradient(ellipse at 50% 0%, #14532D 0%, #0F2440 35%, #050B16 75%) fixed; color: #F4F4F5; }
  .bf-shell { max-width: 980px; margin: 0 auto; padding: clamp(1.25rem, 4vw, 3rem) 1rem 4rem; }
  .bf-top { display: flex; justify-content: space-between; align-items: center; gap: 1rem; font-size: 0.85rem; }
  .bf-top a { color: #A1A1AA; text-decoration: none; }
  .bf-top strong { letter-spacing: 0.08em; }
  .bf-top strong span { color: #4ADE80; }
  .bf-hero { text-align: center; padding: clamp(2rem, 6vw, 3.5rem) 0 1.5rem; }
  .bf-tag { display: inline-block; background: #7ED956; color: #0F2440; font-weight: 800; letter-spacing: 0.14em; font-size: 0.8rem; padding: 0.4rem 0.9rem; border-radius: 4px; }
  .bf-hero h1 { font-size: clamp(2rem, 6vw, 3.4rem); line-height: 1.05; margin: 1rem 0 0.75rem; color: #fff; font-weight: 800; }
  .bf-hero h1 em { font-style: normal; color: #7ED956; }
  .bf-hero p { color: #D4D4D8; font-size: clamp(1rem, 2.4vw, 1.2rem); max-width: 640px; margin: 0 auto; }
  .bf-timer { display: flex; justify-content: center; gap: 0.6rem; margin-top: 1.5rem; }
  .bf-timer div { background: #18181B; border: 1px solid #27272A; border-radius: 8px; padding: 0.55rem 0.8rem; min-width: 64px; }
  .bf-timer b { display: block; font-family: 'Plex Mono', monospace; font-size: 1.5rem; color: #7ED956; }
  .bf-timer small { color: #A1A1AA; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.08em; }
  .bf-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 0.9rem; margin: 2rem 0; }
  .bf-card { background: #18181B; border: 1px solid #27272A; border-radius: 10px; overflow: hidden; display: flex; flex-direction: column; }
  .bf-card img { width: 100%; height: 120px; object-fit: cover; display: block; }
  .bf-card div { padding: 0.9rem 1rem 1rem; display: flex; flex-direction: column; gap: 0.35rem; flex: 1; }
  .bf-card h3 { font-size: 1rem; color: #fff; margin: 0; }
  .bf-card p { font-size: 0.82rem; color: #A1A1AA; margin: 0; line-height: 1.45; flex: 1; }
  .bf-card s { font-family: 'Plex Mono', monospace; color: #71717A; font-size: 0.85rem; }
  .bf-card .tem { color: #4ADE80; font-size: 0.78rem; font-weight: 600; }
  .bf-offer { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; align-items: start; }
  @media (max-width: 760px) { .bf-offer { grid-template-columns: 1fr; } }
  .bf-price { background: #18181B; border: 2px solid #7ED956; border-radius: 12px; padding: 1.5rem; text-align: center; }
  .bf-price .de { color: #A1A1AA; font-size: 1rem; }
  .bf-price .de s { font-family: 'Plex Mono', monospace; }
  .bf-price .por { font-family: 'Plex Mono', monospace; font-size: clamp(2.4rem, 7vw, 3.2rem); color: #7ED956; font-weight: 700; line-height: 1.1; margin: 0.35rem 0; }
  .bf-price .parc { color: #D4D4D8; font-size: 0.95rem; }
  .bf-price .eco { display: inline-block; margin-top: 0.8rem; background: #14532D; color: #4ADE80; font-weight: 700; font-size: 0.85rem; padding: 0.3rem 0.7rem; border-radius: 999px; }
  .bf-price ul { list-style: none; padding: 0; margin: 1.2rem 0 0; text-align: left; display: grid; gap: 0.5rem; font-size: 0.88rem; color: #D4D4D8; }
  .bf-price li::before { content: "✓ "; color: #4ADE80; font-weight: 700; }
  /* Cores explícitas: as variáveis do tema mudam no modo escuro e deixavam rótulo branco em fundo branco. */
  .bf-form { background: #18181B; color: #F4F4F5; border: 1px solid #3F3F46; border-radius: 12px; padding: 1.5rem; }
  .bf-form h2 { font-size: 1.2rem; margin: 0 0 1rem; color: #fff; }
  .bf-form label { color: #E4E4E7; font-weight: 600; }
  .bf-form input { background: #0B0B0F; color: #fff; border: 1px solid #52525B; }
  .bf-form input::placeholder { color: #71717A; }
  .bf-form input:focus { border-color: #7ED956; outline: 2px solid rgba(126, 217, 86, 0.35); outline-offset: 0; }
  .bf-form input[readonly] { color: #A1A1AA; }
  .bf-form .bf-note { color: #A1A1AA; }
  .bf-form .bf-note strong { color: #F4F4F5; }
  .bf-form .btn-primary { background: #7ED956; border-color: #7ED956; color: #0B0B0F; font-weight: 800; font-size: 1.05rem; }
  .bf-form .btn-primary:hover { background: #6DC24D; border-color: #6DC24D; }
  .bf-note { font-size: 0.78rem; color: #52525B; margin-top: 0.8rem; }
  .bf-guarantee { display: flex; gap: 0.75rem; margin-top: 1.5rem; font-size: 0.88rem; color: #D4D4D8; background: #18181B; border: 1px solid #27272A; border-radius: 10px; padding: 1rem 1.2rem; }
  .bf-guarantee svg { width: 22px; height: 22px; color: #4ADE80; flex: none; }
  .bf-faq { margin-top: 2.5rem; display: grid; gap: 0.6rem; }
  .bf-faq details { background: #18181B; border: 1px solid #27272A; border-radius: 8px; padding: 0.85rem 1rem; }
  .bf-faq summary { cursor: pointer; font-weight: 600; color: #fff; }
  .bf-faq p { color: #A1A1AA; font-size: 0.9rem; margin: 0.6rem 0 0; }
  .bf-alt { text-align: center; margin-top: 2rem; font-size: 0.88rem; }
  .bf-alt a { color: #A1A1AA; }
  .bf-closed { text-align: center; background: #18181B; border: 1px solid #27272A; border-radius: 12px; padding: 2rem; margin-top: 1.5rem; }
  .bf-closed a { color: #7ED956; }
  .bf-sec { background: rgba(15,36,64,0.6); border: 1px solid #1E3A5F; border-radius: 12px; padding: 1.5rem; margin: 1.25rem 0; }
  .bf-sec h2 { color: #fff; font-size: 1.3rem; margin: 0 0 1rem; }
  .bf-res { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 0.8rem; }
  .bf-res div { background: #0B1628; border-left: 3px solid #7ED956; border-radius: 8px; padding: 0.85rem 1rem; }
  .bf-res b { display: block; color: #7ED956; margin-bottom: 0.3rem; }
  .bf-res span { color: #CBD5E1; font-size: 0.88rem; line-height: 1.45; }
  .bf-nums { display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.6rem; margin-top: 1rem; text-align: center; }
  @media (max-width: 560px) { .bf-nums { grid-template-columns: repeat(2, 1fr); } }
  .bf-nums b { display: block; color: #fff; font-size: 1.35rem; }
  .bf-nums span { color: #94A3B8; font-size: 0.78rem; }
  .bf-stars { color: #E2E8F0; font-size: 0.92rem; margin-bottom: 1rem; }
  .bf-stars span { color: #E3A008; letter-spacing: 2px; }
  .bf-depo { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 0.8rem; }
  .bf-depo blockquote { margin: 0; background: #0B1628; border-radius: 8px; padding: 1rem; color: #CBD5E1; font-size: 0.88rem; line-height: 1.5; }
  .bf-depo cite { display: block; margin-top: 0.5rem; color: #7ED956; font-style: normal; font-weight: 700; }
  .bf-link { display: inline-block; margin-top: 0.9rem; color: #7ED956; font-size: 0.88rem; }
  .bf-quem { display: flex; gap: 1.1rem; align-items: flex-start; }
  .bf-quem img { border-radius: 10px; border: 3px solid #fff; flex: none; }
  .bf-quem p { color: #CBD5E1; font-size: 0.92rem; line-height: 1.55; margin: 0; }
  .bf-lembrete p { color: #CBD5E1; font-size: 0.92rem; margin: 0 0 0.9rem; }
  .bf-lform { display: grid; grid-template-columns: 1fr 1.3fr 1fr auto; gap: 0.5rem; }
  @media (max-width: 720px) { .bf-lform { grid-template-columns: 1fr; } }
  .bf-lform input { background: #0B1628; color: #fff; border: 1px solid #334155; border-radius: 8px; padding: 0.7rem 0.8rem; font-size: 0.95rem; }
  .bf-lform input::placeholder { color: #64748B; }
  .bf-lform button { background: #7ED956; color: #0F2440; border: 0; border-radius: 8px; padding: 0.7rem 1.2rem; font-weight: 800; cursor: pointer; }
  footer.site { background: #050B16; border-top: 1px solid #1E3A5F; }
</style>
</head>
<body class="bf">
<div class="bf-shell">
  <div class="bf-top">
    <strong style="display:flex;align-items:center;gap:.5rem"><img src="/assets/img/logo.jpg" alt="" width="34" height="27" style="border-radius:4px;border:2px solid #fff">TECH <span>SANTOS</span> BR</strong>
    <a href="<?= $alunoLogado ? '/aluno/' : '/cursos.php' ?>"><?= $alunoLogado ? '← Área do Aluno' : 'Ver todos os cursos →' ?></a>
  </div>

  <section class="bf-hero">
    <span class="bf-tag">BLACK FRIDAY</span>
    <h1>A trilha completa para trabalhar com dados por <em>R$ <?= $precoBF ?></em></h1>
    <p>Excel, Power BI, Python e Inglês: os 4 cursos completos, com <strong>acesso vitalício</strong>, certificado em cada curso e garantia incondicional de 7 dias. Menos do que um curso sozinho.</p>
    <?php if ($ativa): ?>
    <div class="bf-timer" id="bf-timer" data-fim="<?= htmlspecialchars(str_replace(' ', 'T', BF_FIM_UTC) . 'Z', ENT_QUOTES) ?>" aria-label="Tempo até o fim da oferta">
      <div><b data-u="d">--</b><small>dias</small></div>
      <div><b data-u="h">--</b><small>horas</small></div>
      <div><b data-u="m">--</b><small>min</small></div>
      <div><b data-u="s">--</b><small>seg</small></div>
    </div>
    <?php endif; ?>
  </section>

  <div class="bf-grid">
    <?php foreach ($cursos as $c): $v = curso_vitrine($c['slug']); ?>
    <article class="bf-card">
      <img src="<?= htmlspecialchars($v['imagem'], ENT_QUOTES) ?>" alt="" loading="lazy" width="400" height="120">
      <div>
        <h3><?= htmlspecialchars($c['nome'], ENT_QUOTES) ?></h3>
        <p><?= htmlspecialchars($v['etiqueta'], ENT_QUOTES) ?></p>
        <?php if (isset($jaTem[(int)$c['id']])): ?><span class="tem">Você já tem este curso</span><?php endif; ?>
        <s>R$ <?= $fmt((int)$c['preco_centavos']) ?></s>
      </div>
    </article>
    <?php endforeach; ?>
  </div>

  <section class="bf-sec">
    <h2>O que você sai sabendo fazer</h2>
    <div class="bf-res">
      <div><b>Excel</b><span>Fórmulas, PROCX, tabelas dinâmicas, gráficos e macros, preparatório para as provas Microsoft MO-210 e MO-211.</span></div>
      <div><b>Power BI</b><span>Power Query, modelagem, DAX e dashboards prontos para apresentar, do zero ao projeto de portfólio.</span></div>
      <div><b>Python</b><span>pandas para limpar e cruzar dados, gráficos e relatórios Excel automáticos, com 54 desafios de cenário real.</span></div>
      <div><b>Inglês</b><span>Do A1 ao C1 com foco no trabalho: e-mails, reuniões, apresentações e entrevista de emprego.</span></div>
    </div>
    <div class="bf-nums">
      <div><b>235</b><span>videoaulas</span></div>
      <div><b>4</b><span>certificados</span></div>
      <div><b>Vitalício</b><span>acesso sem prazo</span></div>
      <div><b>7 dias</b><span>garantia incondicional</span></div>
    </div>
  </section>

  <section class="bf-sec">
    <h2>Quem já estudou com o professor</h2>
    <div class="bf-stars"><span>★★★★★</span> 5.0 · 46 avaliações reais de alunos no Superprof · canal no YouTube com mais de 22 mil visualizações</div>
    <div class="bf-depo">
      <blockquote>“Amei a aula de Power BI do professor Clariston! Ele me ensinou de forma clara e objetiva e demonstrou dominar o assunto, além de ser muito atencioso. Super indico!”<cite>Thamirys</cite></blockquote>
      <blockquote>“Ótimo professor que realmente entende de Power BI. Aulas conceituais e práticas para a melhor fixação do conteúdo lecionado. Nota 10!”<cite>Leandro</cite></blockquote>
      <blockquote>“O Clariston é um professor extraordinário, tem conhecimento do assunto, tem didática, ensina quantas vezes for necessário até você aprender!”<cite>Joice</cite></blockquote>
    </div>
    <a class="bf-link" href="https://www.superprof.com.br/power-dax-linguagem-criacao-automacao-relatorios-com-integracao-share-point-one-drive-outros-banco.html" target="_blank" rel="noopener">Ver todas as avaliações no Superprof →</a>
  </section>

  <section class="bf-sec bf-quem">
    <img src="/assets/img/logo.jpg" alt="Logo TECH SANTOS BR" width="96" height="75">
    <div>
      <h2>Quem ensina</h2>
      <p><strong>Clariston Santos</strong>, fundador da TECH SANTOS BR. Trabalha com Business Intelligence e Power BI desde 2018, é parceiro Microsoft (Microsoft Partner Network) desde 2021 e já entregou dashboards para empresas de agronegócio, varejo, contabilidade e gestão de pessoas. Os cursos ensinam o que ele usa no dia a dia de projetos reais.</p>
    </div>
  </section>

  <?php if (!$ativa): ?>
  <div class="bf-closed">
    <h2>A oferta de Black Friday foi encerrada.</h2>
    <p>Os cursos continuam à venda separadamente. <a href="/cursos.php">Ver os cursos →</a></p>
  </div>
  <?php else: ?>
  <div class="bf-offer">
    <div class="bf-price">
      <div class="de">De <s>R$ <?= $fmt($somaCentavos) ?></s> por</div>
      <div class="por">R$ <?= $precoBF ?></div>
      <div class="parc">à vista no Pix, ou parcelado em até 12x no cartão</div>
      <?php if ($economiaPct > 0): ?><span class="eco">Economia de <?= $economiaPct ?>%</span><?php endif; ?>
      <ul>
        <li>Os 4 cursos completos, com todas as videoaulas e exercícios</li>
        <li><strong>Acesso vitalício</strong>: sem prazo para terminar</li>
        <li>Certificado de conclusão em cada curso</li>
        <li>Acesso liberado na hora, no mesmo login, assim que o pagamento é confirmado</li>
        <li>Oferta válida para pedidos feitos até <?= BF_FIM_TEXTO ?></li>
      </ul>
    </div>

    <div class="bf-form">
      <h2>Garanta o combo</h2>
      <?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES) ?></div><?php endif; ?>
      <?php if ($temTodos): ?>
      <div class="alert alert-success">Você já tem os 4 cursos. <a href="/aluno/">Ir para a Área do Aluno →</a></div>
      <?php else: ?>
      <?php if ($alunoLogado): ?><p class="bf-note" style="margin:0 0 1rem;">Comprando como <strong><?= htmlspecialchars($alunoLogado['email'], ENT_QUOTES) ?></strong>: os cursos novos aparecem na sua Área do Aluno com o mesmo login.</p><?php endif; ?>
      <form method="post" novalidate>
        <?= csrf_field() ?>
        <input type="hidden" name="utm_source"><input type="hidden" name="utm_medium">
        <input type="hidden" name="utm_campaign"><input type="hidden" name="utm_content">
        <input type="hidden" name="utm_term"><input type="hidden" name="landing_page">
        <div class="field">
          <label for="nome">Nome completo</label>
          <input type="text" id="nome" name="nome" required value="<?= $valorCampo('nome', (string)($alunoLogado['nome'] ?? '')) ?>">
        </div>
        <div class="field">
          <label for="email">E-mail</label>
          <input type="email" id="email" name="email" required value="<?= $valorCampo('email', (string)($alunoLogado['email'] ?? '')) ?>"<?= $alunoLogado ? ' readonly' : '' ?>>
        </div>
        <div class="field">
          <label for="telefone">Telefone (com DDD)</label>
          <input type="tel" id="telefone" name="telefone" required maxlength="15" placeholder="(64) 99999-8888" value="<?= $valorCampo('telefone', $telefoneAnterior) ?>">
        </div>
        <button type="submit" class="btn btn-primary btn-block">Quero os 4 cursos por R$ <?= $precoBF ?></button>
        <p class="bf-note">Você vai para o ambiente seguro do Mercado Pago para pagar com Pix ou cartão. O acesso chega por e-mail assim que o pagamento é confirmado.</p>
      </form>
      <?php endif; ?>
    </div>
  </div>

  <div class="bf-guarantee">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l8 4v6c0 5-3.5 8.5-8 10-4.5-1.5-8-5-8-10V6l8-4z"/><path d="M9 12l2 2 4-4"/></svg>
    <span><strong>Garantia incondicional de 7 dias:</strong> se em até 7 dias você achar que não é para você, é só pedir pelo WhatsApp ou e-mail e devolvemos 100% do valor, sem perguntas.</span>
  </div>

  <section class="bf-sec bf-lembrete" id="lembrete">
    <h2>Ainda não é a hora? Eu te aviso antes de acabar.</h2>
    <p>Deixe seu e-mail e eu mando um lembrete no dia da Black Friday (27/11) e no último dia (30/11).</p>
    <?php if ($lembreteOk): ?>
    <div class="alert alert-success">Combinado! Você recebe o aviso em 27/11 e em 30/11.</div>
    <?php else: ?>
    <?php if ($lembreteErro): ?><div class="alert alert-error"><?= htmlspecialchars($lembreteErro, ENT_QUOTES) ?></div><?php endif; ?>
    <form method="post" action="#lembrete" class="bf-lform" novalidate>
      <?= csrf_field() ?>
      <input type="hidden" name="acao" value="lembrete"><input type="hidden" name="utm_source">
      <input type="text" name="l_nome" placeholder="Seu nome" maxlength="120" aria-label="Seu nome">
      <input type="email" name="l_email" placeholder="Seu melhor e-mail" required aria-label="Seu e-mail">
      <input type="tel" name="l_whatsapp" placeholder="WhatsApp (opcional)" maxlength="15" aria-label="WhatsApp">
      <button type="submit">Me avise</button>
    </form>
    <?php endif; ?>
  </section>
  <?php endif; ?>

  <section class="bf-faq">
    <details><summary>Os 4 cursos ficam na mesma conta?</summary><p>Sim. Depois da confirmação do pagamento, os 4 aparecem juntos na sua Área do Aluno, com o mesmo login e senha.</p></details>
    <details><summary>Já tenho um dos cursos. Posso comprar o combo?</summary><p>Pode. O curso que você já tem continua como está e os outros são liberados na mesma conta.</p></details>
    <details><summary>O acesso tem prazo?</summary><p>Não. O acesso é vitalício: você faz no seu ritmo, e cada curso tem avaliações e certificado de conclusão.</p></details>
    <details><summary>E se eu não gostar?</summary><p>Você tem 7 dias de garantia incondicional. É só pedir pelo WhatsApp ou e-mail dentro desse prazo e devolvemos 100% do valor.</p></details>
    <details><summary>Até quando vale a oferta?</summary><p>Para pedidos feitos até <?= BF_FIM_TEXTO ?> (horário de Brasília). Pix gerado dentro do prazo e pago depois também vale.</p></details>
  </section>

  <div class="bf-alt"><a href="https://wa.me/5564992905785?text=<?= $whatsMsg ?>" target="_blank" rel="noopener">Ficou com dúvida? Fale no WhatsApp →</a></div>
</div>
<footer class="site footer-compact">
  <div class="container">
    <div class="footer-bottom">
      <span>© 2026 TECH SANTOS BR Treinamentos e Aulas Particulares · CNPJ 41.135.509/0001-29</span>
    </div>
  </div>
</footer>
<script src="/assets/js/analytics-events.js"></script>
<script>
(function(){
  var a=typeof window.techSantosAttribution==='function'?window.techSantosAttribution():{};
  var map={campaign_source:'utm_source',campaign_medium:'utm_medium',campaign_name:'utm_campaign',campaign_content:'utm_content',campaign_term:'utm_term',campaign_landing_page:'landing_page'};
  Object.keys(map).forEach(function(k){var el=document.querySelector('[name="'+map[k]+'"]');if(el&&a[k])el.value=a[k];});
  var t=document.getElementById('bf-timer'); if(!t) return;
  var fim=new Date(t.getAttribute('data-fim')).getTime();
  function pad(n){return (n<10?'0':'')+n;}
  function tick(){
    var s=Math.max(0,Math.floor((fim-Date.now())/1000));
    var v={d:Math.floor(s/86400),h:Math.floor(s%86400/3600),m:Math.floor(s%3600/60),s:s%60};
    Object.keys(v).forEach(function(k){var el=t.querySelector('[data-u="'+k+'"]');if(el)el.textContent=pad(v[k]);});
    if(s===0) clearInterval(iv);
  }
  var iv=setInterval(tick,1000); tick();
})();
</script>
</body>
</html>
