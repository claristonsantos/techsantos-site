<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../cursos_catalogo.php';
require_once __DIR__ . '/lib.php';

$pdo = db();
start_secure_session();
$usuario = trilhas_usuario($pdo);

// ---------- Sem conta: cadastro rápido (nome, e-mail e WhatsApp) ----------
$erro = null;
if ($usuario === null && $_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $nome = mb_substr(trim((string)($_POST['nome'] ?? '')), 0, 120);
    $email = trim((string)($_POST['email'] ?? ''));
    $telefone = preg_replace('/\D/', '', (string)($_POST['telefone'] ?? '')) ?? '';
    if ((string)($_POST['website'] ?? '') !== '') {
        $erro = 'Não foi possível enviar.'; // honeypot
    } elseif ($nome === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'Preencha seu nome e um e-mail válido.';
    } elseif (strlen($telefone) < 10 || strlen($telefone) > 13) {
        $erro = 'Informe o WhatsApp com DDD, ex.: (64) 99999-8888.';
    } elseif (empty($_POST['consentimento'])) {
        $erro = 'Marque a autorização para continuar.';
    } else {
        $leadId = trilhas_lead_salvar($pdo, $nome, $email, $telefone,
            mb_substr((string)($_POST['utm_source'] ?? ''), 0, 80), mb_substr((string)($_POST['utm_campaign'] ?? ''), 0, 120));
        session_regenerate_id(true);
        $_SESSION['trilha_lead_id'] = $leadId;
        header('Location: /trilhas/?bemvindo=1');
        exit;
    }
}

$versao = static fn($arq) => (int)@filemtime(__DIR__ . '/..' . $arq);
$publicas = trilhas_publicas();

if ($usuario === null):
    $nomes = implode(', ', array_map(static fn($t) => $t['nome'], array_values($publicas)));
    $totalEtapas = array_sum(array_map(static fn($t) => count($t['nos']), $publicas));
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Trilhas grátis de Power BI, Excel, Python e Inglês — TECH SANTOS BR</title>
<meta name="description" content="Teste o que você sabe e aprenda no seu ritmo com desafios curtos estilo app: <?= htmlspecialchars($nomes, ENT_QUOTES) ?>. Grátis." />
<link rel="canonical" href="https://techsantos.com.br/trilhas/" />
<link rel="icon" type="image/png" href="/assets/img/favicon-32.png" />
<link rel="stylesheet" href="/assets/css/style.css" />
<link rel="stylesheet" href="/assets/css/trilhas.css?v=<?= $versao('/assets/css/trilhas.css') ?>" />
<?php require_once __DIR__ . '/../inc/google-analytics.php'; require_once __DIR__ . '/../inc/meta-pixel.php'; ?>
</head>
<body class="trilhas-body">
<header class="tr-topbar">
  <a class="tr-brand" href="/"><img src="/assets/img/logo.jpg" alt="Tech Santos BR" width="31" height="24" /><span>TECH <em>SANTOS BR</em> · Trilhas</span></a>
  <nav class="tr-nav"><a href="/login.php">Já sou aluno</a></nav>
</header>
<main class="tr-app tr-entrada">
  <section class="tr-hero">
    <p class="tr-eyebrow">Grátis · estilo app</p>
    <h1>Descubra o que você já sabe e aprenda o resto em desafios de 2 minutos.</h1>
    <p><?= count($publicas) ?> trilhas (<?= htmlspecialchars($nomes, ENT_QUOTES) ?>) com <?= $totalEtapas ?> etapas. Faça o nivelamento, pule o que já domina e ganhe XP a cada etapa.</p>
  </section>
  <form class="tr-form" method="post" action="/trilhas/" novalidate>
    <?= csrf_field() ?>
    <input type="hidden" name="utm_source"><input type="hidden" name="utm_campaign">
    <div class="tr-hp" aria-hidden="true"><label>Site <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
    <?php if ($erro): ?><div class="tr-alerta"><?= htmlspecialchars($erro, ENT_QUOTES) ?></div><?php endif; ?>
    <label>Seu nome<input type="text" name="nome" autocomplete="name" required maxlength="120" value="<?= htmlspecialchars((string)($_POST['nome'] ?? ''), ENT_QUOTES) ?>"></label>
    <label>E-mail<input type="email" name="email" autocomplete="email" required value="<?= htmlspecialchars((string)($_POST['email'] ?? ''), ENT_QUOTES) ?>"></label>
    <label>WhatsApp com DDD<input type="tel" name="telefone" autocomplete="tel" required placeholder="(64) 99999-8888" value="<?= htmlspecialchars((string)($_POST['telefone'] ?? ''), ENT_QUOTES) ?>"></label>
    <label class="tr-consent"><input type="checkbox" name="consentimento" value="1" required> <span>Autorizo a TECH SANTOS BR a guardar meu progresso e entrar em contato sobre os cursos. <a href="/privacidade.html">Política de Privacidade</a>.</span></label>
    <button class="btn btn-primary tr-cta" type="submit">Começar grátis</button>
    <p class="tr-nota">Metade de cada trilha é grátis. A outra metade faz parte do curso completo.</p>
  </form>
</main>
<script>
(function () {
  try {
    var p = new URLSearchParams(location.search), f = document.querySelector('.tr-form');
    ['utm_source', 'utm_campaign'].forEach(function (k) { if (p.get(k)) f.elements[k].value = p.get(k); });
  } catch (e) {}
})();
</script>
</body>
</html>
<?php
    exit;
endif;

// ---------- Com conta (aluno ou lead) ----------
// O vídeo de cada nó é um trecho de uma aula de curso. Quem é aluno do curso
// assiste ali mesmo; quem não é recebe o convite pra comprar o curso.
$cursos = $usuario['cursos'];
$precos = [];
$trilhas = [];
foreach ($publicas as $slug => $t) {
    $acessoTotal = trilha_acesso_total($t, $cursos);
    $limite = trilha_limite_livre($t);
    foreach ($t['nos'] as &$no) {
        $v = $no['video'] ?? null;
        if (!$v) continue;
        $publicado = is_file(__DIR__ . '/../../private-videos/' . $v['licao'] . '.mp4');
        $no['video'] = [
            'licao' => $v['licao'],
            'liberado' => $publicado && in_array($v['curso'], $cursos, true),
            'publicado' => $publicado,
            'curso_nome' => $v['curso_nome'] ?? 'do curso',
        ];
    }
    unset($no);
    // Nivelamento só pergunta sobre as etapas que a pessoa pode acessar.
    $abertas = array_slice(array_column($t['nos'], 'id'), 0, $acessoTotal ? null : $limite);
    $t['nivelamento'] = array_values(array_filter($t['nivelamento'], static fn($q) => in_array($q['no'], $abertas, true)));
    $curso = $t['curso'] ?? null;
    if ($curso && !isset($precos[$curso])) {
        $c = curso_a_venda($pdo, $curso);
        $precos[$curso] = $c ? (int)$c['preco_centavos'] : 0;
    }
    $t['acesso_total'] = $acessoTotal;
    $t['limite_livre'] = $acessoTotal ? count($t['nos']) : $limite;
    if ($curso) {
        $t['oferta'] = [
            'curso_nome' => $t['nos'][0]['video']['curso_nome'] ?? $t['nome'],
            'comprar' => '/comprar.php?curso=' . rawurlencode($curso) . '&utm_source=trilhas&utm_campaign=' . rawurlencode($slug),
            'pagina' => curso_vitrine($curso)['pagina'],
            'preco' => $precos[$curso] ? 'R$ ' . number_format($precos[$curso] / 100, 2, ',', '.') : '',
        ];
    }
    $trilhas[] = $t;
}

$estado = [
    'trilhas' => $trilhas,
    'usuario' => ['tipo' => $usuario['tipo'], 'nome' => strtok($usuario['nome'], ' ') ?: ''],
    'progresso' => trilhas_progresso($pdo, $usuario['uid']),
    'estatisticas' => trilhas_estatisticas($pdo, $usuario['uid']),
    'aprovacao' => TRILHA_APROVACAO,
];
$json = static fn($v) => json_encode($v, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
$bemvindo = isset($_GET['bemvindo']) && $usuario['tipo'] === 'lead';
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="robots" content="noindex, nofollow" />
<title>Trilhas — TECH SANTOS BR</title>
<link rel="icon" type="image/png" href="/assets/img/favicon-32.png" />
<link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png" />
<link rel="stylesheet" href="/assets/css/style.css" />
<link rel="stylesheet" href="/assets/css/trilhas.css?v=<?= $versao('/assets/css/trilhas.css') ?>" />
<?php require_once __DIR__ . '/../inc/google-analytics.php'; if ($usuario['tipo'] === 'lead') require_once __DIR__ . '/../inc/meta-pixel.php'; ?>
<?php if ($bemvindo): ?>
<script>
if (window.fbq) fbq('track', 'Lead', {content_name: 'Trilhas grátis'});
if (window.gtag) gtag('event', 'generate_lead', {lead_source: 'trilhas'});
if (window.tsTikTok) tsTikTok('Lead', {content_name: 'Trilhas grátis'});
</script>
<?php endif; ?>
</head>
<body class="trilhas-body">
<header class="tr-topbar">
  <a class="tr-brand" href="/trilhas/" title="Início das trilhas">
    <img src="/assets/img/logo.jpg" alt="Tech Santos BR" width="31" height="24" />
    <span>TECH <em>SANTOS BR</em> · Trilhas</span>
  </a>
  <div class="tr-stats" id="trStats" aria-live="polite"></div>
  <nav class="tr-nav">
    <?php if ($usuario['tipo'] === 'aluno'): ?>
    <a href="/aluno/">Área do Aluno</a>
    <a href="/logout.php">Sair</a>
    <?php else: ?>
    <a href="/cursos.php">Cursos</a>
    <a href="/login.php">Já sou aluno</a>
    <?php endif; ?>
  </nav>
</header>
<main id="trApp" class="tr-app"></main>
<div class="tr-modal" id="trModal" hidden></div>
<script>window.TRILHAS = <?= $json($estado) ?>;</script>
<script src="/assets/js/trilhas.js?v=<?= $versao('/assets/js/trilhas.js') ?>"></script>
</body>
</html>
