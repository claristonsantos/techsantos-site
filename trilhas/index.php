<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../cursos_catalogo.php';
require_once __DIR__ . '/lib.php';
$aluno = require_aluno();

$pdo = db();
$cursosDoAluno = array_map(static fn($m) => $m['slug'], $aluno['matriculas']);

// O vídeo de cada nó é um trecho de uma aula de curso. Quem é aluno do curso
// assiste ali mesmo; quem não é vê o convite pra conhecer o curso.
$trilhas = [];
foreach (trilhas_todas() as $slug => $t) {
    foreach ($t['nos'] as &$no) {
        $v = $no['video'] ?? null;
        if (!$v) continue;
        $publicado = is_file(__DIR__ . '/../../private-videos/' . $v['licao'] . '.mp4');
        $no['video'] = [
            'licao' => $v['licao'],
            'liberado' => $publicado && in_array($v['curso'], $cursosDoAluno, true),
            'publicado' => $publicado,
            'curso_nome' => $v['curso_nome'] ?? 'do curso',
            'curso_pagina' => curso_vitrine($v['curso'])['pagina'],
        ];
    }
    unset($no);
    $trilhas[] = $t;
}

$estado = [
    'trilhas' => $trilhas,
    'progresso' => trilhas_progresso($pdo, (int)$aluno['id']),
    'estatisticas' => trilhas_estatisticas($pdo, (int)$aluno['id']),
    'aprovacao' => TRILHA_APROVACAO,
];
$json = static fn($v) => json_encode($v, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
$versao = static fn($arq) => (int)@filemtime(__DIR__ . '/..' . $arq);
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
<?php require_once __DIR__ . '/../inc/google-analytics.php'; ?>
</head>
<body class="trilhas-body">
<header class="tr-topbar">
  <a class="tr-brand" href="/trilhas/" title="Início das trilhas">
    <img src="/assets/img/logo.jpg" alt="Tech Santos BR" width="31" height="24" />
    <span>TECH <em>SANTOS BR</em> · Trilhas</span>
  </a>
  <div class="tr-stats" id="trStats" aria-live="polite"></div>
  <nav class="tr-nav">
    <a href="/aluno/">Área do Aluno</a>
    <a href="/logout.php">Sair</a>
  </nav>
</header>
<main id="trApp" class="tr-app"></main>
<script>window.TRILHAS = <?= $json($estado) ?>;</script>
<script src="/assets/js/trilhas.js?v=<?= $versao('/assets/js/trilhas.js') ?>"></script>
</body>
</html>
