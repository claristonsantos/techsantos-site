<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
$aluno = require_aluno();
$isPowerBi = $aluno['curso_slug'] === 'power-bi';

$progressoConcluido = [];
$avaliacoesInfo = [];
if ($isPowerBi) {
    $stmt = db()->prepare('SELECT licao_id FROM progresso WHERE aluno_id = ?');
    $stmt->execute([$aluno['id']]);
    $progressoConcluido = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $stmt = db()->prepare(
        'SELECT a.id, a.modulo_id,
            (SELECT MAX(t.aprovado) FROM avaliacao_tentativas t WHERE t.avaliacao_id = a.id AND t.aluno_id = ?) AS aprovado
         FROM avaliacoes a WHERE a.curso_id = ? AND a.ativo = 1'
    );
    $stmt->execute([$aluno['id'], $aluno['curso_id']]);
    foreach ($stmt->fetchAll() as $row) {
        $avaliacoesInfo[$row['modulo_id']] = ['id' => (int)$row['id'], 'aprovado' => (bool)$row['aprovado']];
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="robots" content="noindex, nofollow" />
<title>Área do Aluno — <?= htmlspecialchars($aluno['curso_nome'], ENT_QUOTES) ?> — TECH SANTOS BR</title>
<link rel="icon" type="image/png" href="/assets/img/favicon-32.png" />
<link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png" />
<link rel="stylesheet" href="/assets/css/style.css" />
<style>
  body { overflow-x: hidden; }

  .student-topbar {
    position: sticky; top: 0; z-index: 30;
    display: flex; align-items: center; justify-content: space-between; gap: 1rem;
    padding: 0.75rem 1.25rem; border-bottom: 1px solid var(--line);
    background: var(--surface);
  }
  .student-brand { display: flex; align-items: center; gap: 0.6rem; text-decoration: none; color: var(--ink); }
  .student-brand img { width: 31px; height: 24px; object-fit: contain; border-radius: 4px; }
  .student-brand span { font-family: 'Plex Sans', sans-serif; font-weight: 700; font-size: 0.92rem; }
  .student-brand em { font-style: normal; color: var(--green-strong); }
  .topbar-actions { display: flex; align-items: center; gap: 0.9rem; }
  .topbar-actions .who { font-size: 0.85rem; color: var(--ink-soft); }
  .sidebar-toggle {
    display: none; background: none; border: 1px solid var(--line); border-radius: 5px;
    width: 36px; height: 34px; align-items: center; justify-content: center; color: var(--ink); cursor: pointer;
  }

  .app-shell { display: grid; grid-template-columns: 340px 1fr; align-items: start; }
  .app-sidebar { border-right: 1px solid var(--line); background: var(--surface); height: calc(100vh - 53px); position: sticky; top: 53px; overflow-y: auto; }
  .sidebar-progress { padding: 1rem 1.25rem; border-bottom: 1px solid var(--line); }
  .sidebar-progress .label { display: flex; justify-content: space-between; font-size: 0.78rem; color: var(--ink-soft); margin-bottom: 0.5rem; font-weight: 600; }
  .sidebar-progress .label span:last-child { font-family: 'Plex Mono', monospace; color: var(--ink-faint); font-weight: 400; }
  .sidebar-progress .bar { height: 5px; border-radius: 3px; background: var(--surface-2); overflow: hidden; }
  .sidebar-progress .bar > span { display: block; height: 100%; background: var(--green); border-radius: 3px; transition: width 0.25s ease; }

  .sidebar-module { border-bottom: 1px solid var(--line); }
  .sidebar-module-head {
    padding: 0.9rem 1.25rem; font-size: 0.83rem; font-weight: 600; color: var(--ink);
    display: flex; justify-content: space-between; align-items: center; gap: 0.5rem;
    cursor: pointer; background: none; border: none; width: 100%; text-align: left; font-family: 'Plex Sans', sans-serif;
  }
  .sidebar-module-head:hover { background: var(--surface-2); }
  .sidebar-module-head .count { font-family: 'Plex Mono', monospace; font-size: 0.68rem; color: var(--ink-faint); font-weight: 400; white-space: nowrap; }
  .sidebar-module-head .chev { width: 13px; height: 13px; color: var(--ink-faint); flex: none; transition: transform 0.15s ease; }
  .sidebar-module.open .chev { transform: rotate(90deg); }
  .sidebar-module-lessons { display: none; padding-bottom: 0.4rem; }
  .sidebar-module.open .sidebar-module-lessons { display: block; }

  .sidebar-lesson {
    display: flex; align-items: center; gap: 0.6rem; padding: 0.45rem 1.25rem 0.45rem 1.5rem;
    font-size: 0.85rem; color: var(--ink-soft); cursor: pointer; border-left: 2px solid transparent;
    background: none; width: 100%; text-align: left; font-family: 'Plex Sans', sans-serif;
  }
  .sidebar-lesson:hover { background: var(--surface-2); }
  .sidebar-lesson.active { background: var(--green-soft); border-left-color: var(--green); color: var(--ink); font-weight: 600; }
  .sidebar-lesson .check {
    width: 15px; height: 15px; border-radius: 50%; border: 1.5px solid var(--line); flex: none;
    display: flex; align-items: center; justify-content: center; color: transparent;
  }
  .sidebar-lesson .check svg { width: 8px; height: 8px; }
  .sidebar-lesson.done .check { background: var(--green); border-color: var(--green); color: #08210A; }
  .sidebar-lesson .type-icon { width: 12px; height: 12px; color: var(--ink-faint); flex: none; }
  .sidebar-lesson .lbl { flex: 1; line-height: 1.3; }
  .sidebar-lesson.done:not(.active) { color: var(--ink-faint); }
  .sidebar-module.locked .sidebar-module-head { color: var(--ink-faint); }
  .locked-msg { padding: 0.5rem 1.25rem 0.85rem 1.5rem; font-size: 0.8rem; color: var(--ink-faint); line-height: 1.4; margin: 0; }
  .sidebar-eval {
    display: flex; align-items: center; gap: 0.6rem; padding: 0.55rem 1.25rem 0.55rem 1.5rem;
    font-size: 0.85rem; font-weight: 600; text-decoration: none; color: var(--green-strong);
    border-top: 1px dashed var(--line); margin-top: 0.2rem;
  }
  .sidebar-eval:hover { background: var(--surface-2); }
  .sidebar-eval .type-icon { width: 13px; height: 13px; flex: none; }
  .sidebar-eval.passed { color: var(--ink-faint); }

  .app-main { padding: clamp(1.5rem, 4vw, 3rem) clamp(1.25rem, 4vw, 3.5rem) 5rem; max-width: 760px; }
  .lesson-breadcrumb { font-size: 0.78rem; color: var(--ink-faint); font-weight: 500; }
  .lesson-title { font-size: clamp(1.35rem, 1.2vw + 1rem, 1.85rem); margin: 0.4rem 0 1.5rem; font-family: 'Plex Sans', sans-serif; font-weight: 700; letter-spacing: 0; }

  .player {
    aspect-ratio: 16 / 9; background: #14161A;
    border-radius: 6px;
    position: relative; overflow: hidden; margin-bottom: 1.5rem;
  }
  .player-video { display: none; width: 100%; height: 100%; object-fit: contain; background: #000; }
  .player-placeholder {
    position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;
  }
  .player-placeholder .play-btn {
    width: 56px; height: 56px; border-radius: 50%; background: rgba(255,255,255,.12);
    border: 1.5px solid rgba(255,255,255,.4); display: flex; align-items: center; justify-content: center; color: #fff;
  }
  .player-placeholder .play-btn svg { width: 18px; height: 18px; margin-left: 3px; }
  .player-placeholder .caption {
    position: absolute; bottom: 0.85rem; left: 1rem; right: 1rem;
    font-size: 0.72rem; color: rgba(255,255,255,.55);
    display: flex; justify-content: space-between; gap: 0.5rem;
  }

  .objectives { background: var(--surface-2); border-radius: 6px; padding: 1.1rem 1.3rem; margin-bottom: 1.5rem; }
  .objectives .kicker { font-size: 0.78rem; font-weight: 700; color: var(--ink); margin-bottom: 0.65rem; }
  .objectives ul { list-style: none; margin: 0; padding: 0; display: grid; gap: 0.45rem; }
  .objectives li { display: flex; align-items: flex-start; gap: 0.55rem; font-size: 0.88rem; color: var(--ink-soft); line-height: 1.4; }
  .objectives li svg { width: 14px; height: 14px; color: var(--green-strong); flex: none; margin-top: 0.18rem; }

  .lesson-body { margin-bottom: 1.5rem; }
  .lesson-body h2 { font-size: 0.95rem; font-weight: 700; font-family: 'Plex Sans', sans-serif; margin-bottom: 0.7rem; }
  .lesson-body p { color: var(--ink-soft); font-size: 0.96rem; line-height: 1.65; margin-bottom: 0.85rem; }

  .reading-card h3 { font-size: 1.02rem; font-weight: 700; font-family: 'Plex Sans', sans-serif; margin: 1.5rem 0 0.5rem; }
  .reading-card h3:first-of-type { margin-top: 0; }
  .reading-card p { color: var(--ink-soft); font-size: 0.96rem; line-height: 1.65; margin-bottom: 0.5rem; }
  .reading-card .res-inline { margin: 0.35rem 0 0.9rem; }

  .lab-step { padding: 1.1rem 0; border-bottom: 1px solid var(--line); }
  .lab-step:first-of-type { padding-top: 0; }
  .lab-step:last-of-type { border-bottom: none; }
  .lab-step h3 { margin: 0 0 0.5rem; }
  .lab-step .lab-download { margin-top: 0.4rem; display: inline-flex; }

  .resources { margin-bottom: 1.5rem; }
  .resources h2 { font-size: 0.95rem; font-weight: 700; font-family: 'Plex Sans', sans-serif; margin-bottom: 0.7rem; }
  .resources ul { list-style: none; margin: 0; padding: 0; display: grid; gap: 0.5rem; }
  .res-card { border: 1px solid var(--line); border-radius: 6px; overflow: hidden; }
  .res-toggle {
    display: flex; align-items: center; gap: 0.6rem; width: 100%; text-align: left;
    background: none; border: none; cursor: pointer; color: var(--ink);
    font-size: 0.9rem; font-family: 'Plex Sans', sans-serif; padding: 0.65rem 0.9rem;
  }
  .res-toggle:hover { color: var(--green-strong); }
  .res-toggle svg.doc { width: 16px; height: 16px; color: var(--green-strong); flex: none; }
  .res-toggle svg.chev { width: 13px; height: 13px; color: var(--ink-faint); flex: none; margin-left: auto; transition: transform 0.15s ease; }
  .res-card.open .res-toggle svg.chev { transform: rotate(90deg); }
  .res-toggle .src { font-family: 'Plex Mono', monospace; font-size: 0.68rem; color: var(--ink-faint); display: block; margin-top: 0.1rem; }
  .res-body { display: none; padding: 0 0.9rem 0.9rem 2.55rem; }
  .res-card.open .res-body { display: block; }
  .res-body p { color: var(--ink-soft); font-size: 0.88rem; line-height: 1.6; margin-bottom: 0.6rem; }
  .res-body a {
    display: inline-flex; align-items: center; gap: 0.35rem; text-decoration: none; color: var(--green-strong);
    font-size: 0.82rem; font-weight: 600;
  }
  .res-body a:hover { text-decoration: underline; }
  .res-body a svg.ext { width: 12px; height: 12px; }

  .lesson-nav { display: flex; justify-content: space-between; align-items: center; gap: 1rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--line); }
  .lesson-nav .side { min-width: 0; }
  .lesson-nav .side.right { text-align: right; }
  .lesson-nav a { display: block; text-decoration: none; }
  .lesson-nav .dir { font-size: 0.7rem; color: var(--ink-faint); font-weight: 500; }
  .lesson-nav .t { font-size: 0.88rem; color: var(--ink); font-weight: 600; margin-top: 0.15rem; }
  .lesson-nav a:hover .t { color: var(--green-strong); }

  .mark-done-btn {
    display: inline-flex; align-items: center; gap: 0.5rem; font-family: 'Plex Sans', sans-serif; font-weight: 600;
    font-size: 0.85rem; padding: 0.55rem 1.1rem; border-radius: 5px; border: 1px solid var(--line); background: var(--surface);
    color: var(--ink); cursor: pointer; margin-bottom: 2rem;
  }
  .mark-done-btn.is-done { background: var(--green-soft); border-color: var(--green); color: var(--green-strong); }
  .mark-done-btn svg { width: 14px; height: 14px; }

  .sidebar-backdrop { display: none; }
  @media (max-width: 900px) {
    .app-shell { grid-template-columns: 1fr; }
    .app-sidebar {
      position: fixed; top: 53px; bottom: 0; left: 0; width: 320px; max-width: 88vw;
      transform: translateX(-100%); transition: transform 0.22s ease; z-index: 50; height: auto;
    }
    .app-sidebar.open { transform: translateX(0); }
    .sidebar-toggle { display: flex; }
    .sidebar-backdrop.open { display: block; position: fixed; inset: 53px 0 0 0; background: rgba(6,10,20,0.5); z-index: 45; }
  }
  .empty-course { max-width: 640px; margin: 3rem auto; padding: 0 1.25rem; text-align: center; }
  .empty-course h1 { font-size: 1.6rem; margin-bottom: 0.75rem; }
  .empty-course p { color: var(--ink-soft); }
</style>
</head>
<body>

<div class="student-topbar">
  <div style="display:flex; align-items:center; gap:0.75rem;">
    <?php if ($isPowerBi): ?>
    <button class="sidebar-toggle" id="sidebarToggle" aria-label="Abrir módulos" aria-expanded="false">
      <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
    </button>
    <?php endif; ?>
    <a class="student-brand" href="/curso-power-bi.php">
      <img src="/assets/img/logo.jpg" alt="Tech Santos BR" />
      <span>TECH <em>SANTOS BR</em> · Área do Aluno</span>
    </a>
  </div>
  <div class="topbar-actions">
    <span class="who">Olá, <?= htmlspecialchars(explode(' ', $aluno['nome'])[0], ENT_QUOTES) ?></span>
    <a class="btn btn-ghost on-light" href="/logout.php">Sair</a>
  </div>
</div>

<?php if (!$isPowerBi): ?>
  <div class="empty-course">
    <h1><?= htmlspecialchars($aluno['curso_nome'], ENT_QUOTES) ?></h1>
    <p>O conteúdo deste curso ainda está sendo preparado. Assim que as aulas forem publicadas, elas aparecem automaticamente aqui — nenhuma ação necessária da sua parte.</p>
  </div>
<?php else: ?>

<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

<div class="app-shell">
  <aside class="app-sidebar" id="appSidebar">
    <div class="sidebar-progress">
      <div class="label"><span>Seu progresso</span><span id="progressCount">0/43</span></div>
      <div class="bar"><span id="progressBar" style="width:0%"></span></div>
    </div>
    <nav id="sidebarNav"></nav>
  </aside>

  <main class="app-main" id="appMain"></main>
</div>

<script>
const ALUNO_ID = <?= (int)$aluno['id'] ?>;
const SERVER_PROGRESS = <?= json_encode($progressoConcluido) ?>;
const AVALIACOES = <?= json_encode($avaliacoesInfo, JSON_UNESCAPED_UNICODE) ?>;
const MSL = 'learn.microsoft.com';
const COURSE = [
  {
    id: 'modelagem', title: 'Módulo 01 · Fundamentos de Modelagem de Dados', kind: 'video',
    lessons: [
      { id: 'introducao', title: 'Introdução ao curso',
        desc: 'Apresentação do curso, do instrutor e do caminho que vamos percorrer: da estrutura dos dados até o relatório pronto para o negócio.',
        objetivos: ['Entender a estrutura do curso e a ordem dos módulos', 'Saber o que esperar como resultado final: um relatório completo em Power BI'],
        body: 'Este curso segue uma progressão prática: primeiro construímos a base (modelagem de dados), depois aprendemos a extrair e limpar dados com Power Query, avançamos para cálculos com DAX e terminamos com visualização e publicação. Cada módulo assume que você já concluiu o anterior.',
        recursos: [{ t: 'Visão geral do Power BI', u: 'https://learn.microsoft.com/pt-br/power-bi/fundamentals/power-bi-overview' }] },
      { id: 'importancia-modelagem', title: 'Por que a modelagem de dados é importante',
        desc: 'Antes de abrir o Power BI, entenda por que identificar padrões nos dados é a principal qualidade de um bom profissional de análise — e por que uma única tabela no Excel tem limite.',
        objetivos: ['Reconhecer os limites de trabalhar com uma única tabela grande', 'Entender por que separar dados em tabelas relacionadas facilita a manutenção'],
        body: 'Uma planilha única, com todas as colunas misturadas, parece simples no início — mas cresce em duplicidade e fica difícil de manter à medida que o negócio muda. Modelar dados é decidir como separar essa informação em tabelas menores e relacionadas, cada uma com uma responsabilidade clara. É a diferença entre um raciocínio que só funciona para um relatório e um modelo que sustenta dezenas de relatórios.',
        recursos: [{ t: 'Como o Power BI Desktop trabalha com relacionamentos', u: 'https://learn.microsoft.com/pt-br/power-bi/transform-model/desktop-relationships-understand' }] },
      { id: 'normalizacao-desnormalizacao', title: 'Normalização e desnormalização',
        desc: 'Normalização organiza colunas e tabelas para reduzir redundância; desnormalização faz o contrário, priorizando o entendimento do modelo. Veremos exemplos práticos dos dois processos.',
        objetivos: ['Diferenciar dados normalizados de desnormalizados', 'Saber quando cada abordagem é preferível em um modelo de BI'],
        body: 'Bancos de dados transacionais (os sistemas que registram vendas, pedidos, notas fiscais) costumam ser altamente normalizados — cada informação existe em um único lugar, para evitar inconsistência na escrita. Modelos de BI fazem o caminho inverso quando faz sentido: desnormalizam parte dos dados para tornar a leitura e o cálculo mais rápidos e mais fáceis de entender por quem consome o relatório.',
        recursos: [{ t: 'Modelo de dados star schema', u: 'https://learn.microsoft.com/pt-br/power-bi/guidance/star-schema' }] },
      { id: 'modelagem-pratica', title: 'Granularidade, entidade de negócio e relacionamento',
        desc: 'Como o modelo de dados vai além de uma tabela: carregar tabelas separadas, relacioná-las por chaves e entender granularidade em um cenário com múltiplas tabelas.',
        objetivos: ['Carregar mais de uma tabela no Power BI e relacioná-las por chave', 'Entender granularidade (o nível de detalhe de cada linha) e entidade de negócio (o que cada tabela representa)'],
        body: 'Granularidade é uma das ideias mais importantes de modelagem: significa saber exatamente o que cada linha de uma tabela representa — um pedido, um item de pedido, um dia, um cliente. Misturar granularidades diferentes na mesma tabela é a causa mais comum de números errados em um relatório. Já entidade de negócio é o conceito do mundo real que uma tabela descreve (Cliente, Produto, Pedido) — nomear e delimitar bem cada entidade é o que torna um relacionamento entre tabelas óbvio, em vez de ambíguo.',
        recursos: [{ t: 'Trabalhar com relacionamentos no Power BI Desktop', u: 'https://learn.microsoft.com/pt-br/power-bi/transform-model/desktop-relationships-understand' }] },
      { id: 'esquema-estrela', title: 'Esquema estrela (Star Schema)',
        desc: 'A abordagem mais usada em data warehouses: separar tabelas fato (o que aconteceu) de tabelas dimensão (os atributos do que aconteceu) para um modelo rápido e sem ambiguidade.',
        objetivos: ['Diferenciar tabela fato de tabela dimensão', 'Montar um esquema estrela simples a partir de uma base de vendas'],
        body: 'No esquema estrela, uma tabela fato central (vendas, por exemplo) se conecta a várias tabelas dimensão (Cliente, Produto, Data, Loja) por chaves simples. É a arquitetura recomendada pela própria Microsoft para modelos Power BI, porque gera relatórios mais rápidos, menos ambíguos e mais fáceis de explicar para quem não construiu o modelo.',
        recursos: [{ t: 'Entenda o star schema e sua importância para o Power BI', u: 'https://learn.microsoft.com/pt-br/power-bi/guidance/star-schema' }] },
    ],
  },
  {
    id: 'perfil-dados', title: 'Módulo 02 · Perfil dos Dados', kind: 'reading',
    lessons: [
      {
        id: 'perfil-dos-dados', title: 'Perfil dos Dados no Power Query',
        content: [
          { h: 'Por que examinar os dados antes de transformar', p: 'Antes de aplicar qualquer transformação, vale a pena parar e examinar a estrutura dos dados: quantas colunas existem, que tipo cada uma tem, e se há valores inesperados. O Power Query tem ferramentas de perfil de dados criadas exatamente para isso — elas ficam na guia Exibir do Editor do Power Query e adicionam pequenos indicadores visuais abaixo de cada coluna.', r: { t: 'Usando as ferramentas de perfil de dados', u: 'https://learn.microsoft.com/pt-br/power-query/data-profiling-tools' } },
          { h: 'Qualidade da coluna e anomalias', p: 'Qualidade da coluna mostra, em uma barra colorida, a proporção de valores Válidos (verde), com Erro (vermelho) e Vazios (cinza) em cada coluna — a forma mais rápida de identificar anomalias sem abrir cada linha manualmente. Por padrão, o Power Query analisa apenas as primeiras 1.000 linhas; para bases maiores, é possível trocar para o perfil completo no aviso no canto inferior esquerdo do editor.' },
          { h: 'Distribuição e estatísticas da coluna', p: 'Distribuição da coluna mostra a frequência de cada valor distinto como um mini-histograma, útil para notar concentrações ou valores repetidos demais para fazerem sentido. Perfil da coluna vai além: exibe estatísticas completas (contagem de valores distintos, valores únicos, mínimo, máximo, desvio padrão) junto com o gráfico de distribuição — a visão mais completa da "saúde" de uma coluna antes dela entrar no modelo.' },
        ],
      },
    ],
  },
  {
    id: 'power-query-conectar', title: 'Módulo 03 · Power Query — Conectando e Importando Dados', kind: 'video',
    lessons: [
      { id: 'intro-power-query', title: 'Introdução ao Power Query',
        desc: 'Power Query é a ferramenta de ETL do Excel e do Power BI: extrai, transforma e carrega dados de quase qualquer fonte, substituindo horas de copiar/colar por um processo que se atualiza com um clique.',
        objetivos: ['Entender o que significa ETL (extrair, transformar, carregar)', 'Reconhecer a interface do Editor poder Query'],
        body: 'Toda transformação feita no Power Query fica registrada como uma sequência de passos — não é uma edição manual e sim uma receita reaplicável. Isso significa que, quando a fonte de dados muda (uma nova linha na planilha, um novo mês de vendas), basta clicar em "Atualizar" para que tudo seja refeito automaticamente, sem repetir o trabalho manual.',
        recursos: [{ t: 'O que é o Power Query?', u: 'https://learn.microsoft.com/pt-br/power-query/power-query-what-is-power-query' }] },
      { id: 'tipos-de-dados', title: 'Tipos de dados',
        desc: 'Cada coluna tem um tipo — texto, número, data — que determina quais transformações e cálculos são possíveis. Aprenda a identificar e corrigir tipos de dados incorretos.',
        objetivos: ['Reconhecer os principais tipos de dados do Power Query', 'Corrigir uma coluna importada com o tipo errado'],
        body: 'Um erro comum é uma coluna de datas ou valores numéricos chegar como texto — o que impede cálculos e ordenações corretas. Definir o tipo certo logo no início da consulta evita erros silenciosos que só aparecem várias etapas depois, quando já é mais difícil rastrear a causa.',
        recursos: [{ t: 'Tipos de dados no Power Query', u: 'https://learn.microsoft.com/pt-br/power-query/data-types' }],
        arquivo: 'Tipos de Dados.xlsx' },
      { id: 'tabela-ou-intervalo', title: 'Dados a partir de uma tabela ou intervalo',
        desc: 'O ponto de partida mais comum: como trazer uma tabela ou intervalo do próprio Excel para dentro do Power Query.',
        objetivos: ['Converter um intervalo de células em tabela do Excel', 'Carregar essa tabela como consulta do Power Query'],
        body: 'Transformar um intervalo em uma Tabela do Excel (Ctrl+T) antes de conectar ao Power Query evita um problema comum: intervalos fixos não crescem sozinhos quando novas linhas são adicionadas, enquanto uma Tabela nomeada se expande automaticamente junto com os dados.',
        recursos: [{ t: 'Visão geral de consultas no Power BI Desktop', u: 'https://learn.microsoft.com/pt-br/power-bi/transform-model/desktop-query-overview' }],
        arquivo: 'Tabela ou Intervalo.xlsx' },
      { id: 'importar-excel', title: 'Importando um arquivo Excel',
        desc: 'Como conectar o Power Query a um arquivo Excel externo e escolher quais planilhas ou tabelas importar.',
        objetivos: ['Conectar a um arquivo .xlsx externo', 'Selecionar a planilha ou tabela correta dentro do arquivo'],
        body: 'Ao importar um arquivo Excel externo, o Power Query mostra uma prévia de cada planilha e tabela nomeada disponível dentro do arquivo antes de carregar — permitindo escolher exatamente qual pedaço dos dados entra no modelo, sem trazer abas desnecessárias.',
        recursos: [{ t: 'Visão geral de obtenção de dados', u: 'https://learn.microsoft.com/pt-br/power-query/get-data-experience' }],
        arquivo: 'Importando um Arquivo Excel.xlsx' },
      { id: 'consulta-pasta', title: 'Consulta de uma pasta',
        desc: 'Em vez de importar arquivo por arquivo, uma consulta de pasta combina automaticamente todos os arquivos de uma pasta em uma única tabela.',
        objetivos: ['Conectar o Power Query a uma pasta inteira', 'Combinar múltiplos arquivos idênticos em uma única tabela'],
        body: 'Esse conector é especialmente útil quando um relatório mensal chega como um novo arquivo Excel a cada mês, sempre com a mesma estrutura: em vez de reimportar manualmente, a consulta de pasta detecta e combina qualquer novo arquivo adicionado, automaticamente.',
        recursos: [{ t: 'Visão geral de obtenção de dados', u: 'https://learn.microsoft.com/pt-br/power-query/get-data-experience' }],
        arquivo: 'Consulta de Pasta (7 arquivos).zip' },
      { id: 'consulta-pasta-sharepoint', title: 'Consulta de uma pasta do SharePoint',
        desc: 'O mesmo conceito de consulta de pasta, agora conectando diretamente a uma biblioteca de documentos do SharePoint.',
        objetivos: ['Conectar o Power Query a uma biblioteca de documentos do SharePoint', 'Entender a diferença entre uma pasta local e uma pasta na nuvem'],
        body: 'Quando os arquivos-fonte vivem em uma biblioteca do SharePoint (em vez de uma pasta local), o Power BI consegue atualizar o relatório automaticamente pelo serviço na nuvem, sem depender de um computador ligado com o arquivo aberto — importante para relatórios compartilhados com uma equipe.',
        recursos: [{ t: 'Obtenção de dados no Power Query', u: 'https://learn.microsoft.com/pt-br/power-query/get-data-experience' }] },
      { id: 'criando-consulta', title: 'Criando uma consulta',
        desc: 'Juntando tudo: como estruturar uma consulta do zero, do conector à primeira transformação.',
        objetivos: ['Criar uma consulta completa, do zero, dentro do Editor do Power Query', 'Nomear e organizar consultas de forma clara'],
        body: 'Esta aula fecha o módulo reunindo os conectores vistos até aqui em um fluxo único: conectar à fonte, revisar a prévia, aplicar o primeiro tipo de dado e nomear a consulta de forma que qualquer pessoa da equipe entenda o que ela representa.',
        recursos: [{ t: 'A interface do usuário do Power Query', u: 'https://learn.microsoft.com/pt-br/power-query/power-query-ui' }] },
    ],
  },
  {
    id: 'power-query-transformar', title: 'Módulo 04 · Power Query — Transformação e Limpeza de Dados', kind: 'video',
    lessons: [
      { id: 'preenchimento-colunas', title: 'Preenchimento de colunas',
        desc: 'Preenche células vazias com o valor da célula anterior (ou seguinte) — essencial para tratar planilhas com células mescladas ou cabeçalhos hierárquicos.',
        objetivos: ['Usar "Preencher para baixo" para eliminar células vazias', 'Reconhecer quando uma planilha "bonita" (com mescla de células) atrapalha a análise'],
        body: 'Planilhas formatadas para leitura humana costumam usar células mescladas — visualmente organizadas, mas tecnicamente vazias para todas as linhas menos a primeira. O preenchimento de colunas resolve isso replicando o último valor visto para baixo (ou para cima), até a estrutura da tabela.',
        recursos: [{ t: 'Preencher valores em uma coluna', u: 'https://learn.microsoft.com/pt-br/power-query/fill-values-column' }],
        arquivo: 'Preenchimento de Colunas.xlsx' },
      { id: 'dividir-colunas', title: 'Dividir colunas',
        desc: 'Separa uma coluna em várias, usando um delimitador (como vírgula ou espaço) ou por número de caracteres.',
        objetivos: ['Dividir uma coluna por delimitador (vírgula, espaço, hífen)', 'Dividir uma coluna por número fixo de caracteres'],
        body: 'É comum receber "Nome Completo" em uma única coluna e precisar separar em nome e sobrenome, ou um código composto como "SP-001" que precisa virar estado e número. Dividir colunas resolve os dois casos, e o Power Query também tenta sugerir o delimitador correto automaticamente.',
        recursos: [{ t: 'Table.SplitColumn (referência M)', u: 'https://learn.microsoft.com/pt-br/powerquery-m/table-splitcolumn' }],
        arquivo: 'Dividir Colunas.xlsx' },
      { id: 'dividir-linhas', title: 'Dividir linhas',
        desc: 'O mesmo princípio da divisão de colunas, mas transformando um valor em múltiplas linhas em vez de múltiplas colunas.',
        objetivos: ['Dividir uma célula com múltiplos valores em várias linhas'],
        body: 'Quando uma célula contém vários itens separados por vírgula (por exemplo, "Camisa, Calça, Boné" em um único pedido), dividir em linhas transforma cada item em sua própria linha, mantendo o restante da linha original replicado — essencial antes de agregações por item.',
        recursos: [{ t: 'Table.SplitColumn (referência M)', u: 'https://learn.microsoft.com/pt-br/powerquery-m/table-splitcolumn' }],
        arquivo: 'Dividir Linhas.xlsx' },
      { id: 'colunas-personalizadas', title: 'Colunas personalizadas',
        desc: 'Cria uma nova coluna a partir de uma fórmula em linguagem M, combinando ou calculando valores de outras colunas.',
        objetivos: ['Escrever uma fórmula M simples para criar uma coluna nova', 'Combinar valores de duas colunas existentes em uma terceira'],
        body: 'Diferente das transformações por clique, colunas personalizadas exigem escrever uma pequena fórmula na linguagem M — por exemplo, multiplicar preço por quantidade para gerar uma coluna de valor total. É o primeiro contato do curso com a linguagem que move o Power Query por trás da interface.',
        recursos: [{ t: 'Referência de funções da linguagem M', u: 'https://learn.microsoft.com/pt-br/powerquery-m/power-query-m-function-reference' }],
        arquivo: 'Colunas Personalizadas.xlsx' },
      { id: 'coluna-exemplo', title: 'Coluna de exemplo',
        desc: 'Mostre ao Power Query o resultado que você quer, e ele tenta descobrir sozinho a transformação necessária a partir dos exemplos.',
        objetivos: ['Usar "Coluna a partir de exemplos" para transformações complexas', 'Entender os limites dessa detecção automática'],
        body: 'Em vez de escrever a fórmula M manualmente, você digita o resultado esperado para algumas linhas e o Power Query infere o padrão. Funciona bem para transformações de texto (capitalizar, extrair trechos), mas vale sempre conferir a fórmula gerada — ela nem sempre generaliza perfeitamente para todos os casos.',
        recursos: [{ t: 'A interface do usuário do Power Query', u: 'https://learn.microsoft.com/pt-br/power-query/power-query-ui' }],
        arquivo: 'Coluna de Exemplo.xlsx' },
      { id: 'mesclar-colunas', title: 'Mesclar colunas',
        desc: 'Combina o conteúdo de duas ou mais colunas em uma só, com um separador à sua escolha.',
        objetivos: ['Mesclar duas ou mais colunas de texto em uma única coluna'],
        body: 'O caminho inverso de "dividir colunas": útil para reconstituir um endereço completo a partir de Rua, Número e Cidade separados, por exemplo, escolhendo o separador (espaço, vírgula, hífen) entre cada parte.',
        recursos: [{ t: 'Visão geral de mesclar consultas', u: 'https://learn.microsoft.com/pt-br/power-query/merge-queries-overview' }],
        arquivo: 'Mesclar Colunas.xlsx' },
      { id: 'classificar-filtrar', title: 'Classificar e filtrar',
        desc: 'Ordena e filtra linhas diretamente na consulta, antes mesmo dos dados chegarem ao modelo.',
        objetivos: ['Ordenar uma tabela por uma ou mais colunas', 'Aplicar filtros de linha dentro do Power Query, não só no relatório'],
        body: 'Filtrar já na consulta (e não apenas visualmente no relatório) reduz o volume de dados que entra no modelo — o que deixa o arquivo mais leve e as atualizações mais rápidas, especialmente quando linhas antigas ou de teste não são necessárias para a análise.',
        recursos: [{ t: 'A interface do usuário do Power Query', u: 'https://learn.microsoft.com/pt-br/power-query/power-query-ui' }],
        arquivo: 'Classificar e Filtrar.xlsx' },
      { id: 'formula-if', title: 'Fórmula IF',
        desc: 'A lógica condicional básica da linguagem M: se uma condição é verdadeira, retorna um valor; senão, retorna outro.',
        objetivos: ['Escrever uma expressão "if...then...else" em M', 'Criar uma coluna de classificação simples (ex.: "Alto" / "Baixo") baseada em uma condição'],
        body: 'A sintaxe M para condicionais é "if condição then valor1 else valor2" — parecida com o SE do Excel, mas escrita por extenso. É a base para qualquer regra de negócio simples aplicada ainda na etapa de preparação dos dados, antes de chegar ao modelo.',
        recursos: [{ t: 'Referência de funções da linguagem M', u: 'https://learn.microsoft.com/pt-br/powerquery-m/power-query-m-function-reference' }],
        arquivo: 'Fórmula IF.xlsx' },
      { id: 'formula-if-and', title: 'Fórmula IF e AND',
        desc: 'Combina múltiplas condições em um único teste lógico, retornando verdadeiro apenas quando todas são atendidas.',
        objetivos: ['Combinar dois ou mais testes lógicos com "and"', 'Diferenciar "and" de "or" em uma condição composta'],
        body: 'Regras de negócio raramente dependem de uma única condição: "cliente ativo E com compra nos últimos 90 dias" precisa que ambos os testes sejam verdadeiros ao mesmo tempo, o que "and" garante dentro da expressão condicional.',
        recursos: [{ t: 'Referência de funções da linguagem M', u: 'https://learn.microsoft.com/pt-br/powerquery-m/power-query-m-function-reference' }],
        arquivo: 'Fórmula IF e AND.xlsx' },
      { id: 'formula-adddays', title: 'Fórmula AddDays',
        desc: 'Soma (ou subtrai) dias a uma data — útil para calcular prazos, vencimentos e janelas de tempo.',
        objetivos: ['Usar Date.AddDays para calcular uma data futura ou passada', 'Calcular um prazo de vencimento a partir de uma data de emissão'],
        body: 'Date.AddDays recebe uma data e um número de dias (positivo ou negativo) e retorna a nova data — a base para calcular vencimentos, prazos de entrega ou janelas de análise como "últimos 30 dias", ainda na etapa de preparação dos dados.',
        recursos: [{ t: 'Funções de data (referência M)', u: 'https://learn.microsoft.com/pt-br/powerquery-m/date-functions' }],
        arquivo: 'Fórmula AddDays.xlsx' },
      { id: 'formulas-texto', title: 'Fórmulas de texto',
        desc: 'Funções para manipular texto: converter maiúsculas/minúsculas, extrair trechos e capitalizar nomes próprios.',
        objetivos: ['Usar Text.Upper, Text.Lower e Text.Proper para padronizar texto', 'Extrair um trecho de uma coluna de texto'],
        body: 'Dados digitados manualmente raramente chegam padronizados — "joão", "JOÃO" e "João" podem representar a mesma pessoa, mas serem tratados como valores diferentes em uma agregação. Funções de texto padronizam capitalização e formato antes que isso vire um problema no relatório.',
        recursos: [{ t: 'Funções de texto (referência M)', u: 'https://learn.microsoft.com/pt-br/powerquery-m/text-functions' }],
        arquivo: 'Fórmulas de Texto.xlsx' },
      { id: 'coluna-dinamica', title: 'Coluna dinâmica (Pivot)',
        desc: 'Transforma valores de uma coluna em novas colunas — o mesmo conceito de uma tabela dinâmica, mas na etapa de preparação dos dados.',
        objetivos: ['Dinamizar (pivotar) uma coluna, transformando valores em cabeçalhos'],
        body: 'Pivotar uma coluna pega valores distintos de uma coluna (por exemplo, os meses do ano) e os transforma em novas colunas, com uma função de agregação definindo o valor de cada célula — o mesmo resultado de uma tabela dinâmica do Excel, mas persistido como parte da consulta.',
        recursos: [{ t: 'Colunas dinâmicas (pivot) no Power Query', u: 'https://learn.microsoft.com/pt-br/power-query/pivot-columns' }],
        arquivo: 'Coluna Dinâmica - Pivot (3 arquivos).zip' },
      { id: 'transformar-colunas-linhas', title: 'Transformar colunas em linhas (Unpivot)',
        desc: 'O processo inverso do pivot: converte várias colunas em pares de atributo-valor, deixando a tabela no formato longo que o modelo de dados prefere.',
        objetivos: ['Despivotar (unpivot) colunas, convertendo-as em linhas', 'Entender por que o formato "longo" é preferível para modelos de BI'],
        body: 'Planilhas de origem costumam ter um mês por coluna (Jan, Fev, Mar...) — ótimo para leitura humana, ruim para um modelo de dados. Despivotar converte essas colunas em duas: uma com o nome do mês, outra com o valor — o formato que o Power BI consegue relacionar e agregar corretamente.',
        recursos: [{ t: 'Despivotar colunas no Power Query', u: 'https://learn.microsoft.com/pt-br/power-query/unpivot-column' }],
        arquivo: 'Transformar Colunas em Linhas - Unpivot.xlsx' },
      { id: 'agrupar-por', title: 'Agrupar por',
        desc: 'Agrega linhas por uma ou mais colunas, calculando soma, contagem, média ou outras operações por grupo.',
        objetivos: ['Agrupar uma tabela por uma coluna, somando ou contando outra', 'Agrupar por múltiplas colunas ao mesmo tempo'],
        body: '"Agrupar por" resume uma tabela detalhada (uma linha por venda) em uma tabela resumida (uma linha por vendedor, por exemplo), aplicando soma, contagem, média, mínimo ou máximo sobre as demais colunas — equivalente a um GROUP BY de SQL, mas via interface.',
        recursos: [{ t: 'Agrupar ou resumir linhas', u: 'https://learn.microsoft.com/pt-br/power-query/group-by' }],
        arquivo: 'Agrupar Por.xlsx' },
      { id: 'acrescentar-consultas-1', title: 'Acrescentar consultas — parte 1',
        desc: 'Empilha duas ou mais consultas com a mesma estrutura, uma embaixo da outra — o equivalente a copiar e colar tabelas, mas atualizável.',
        objetivos: ['Acrescentar (empilhar) duas consultas com colunas iguais'],
        body: 'Quando duas fontes têm exatamente a mesma estrutura de colunas — por exemplo, vendas de duas filiais em arquivos separados — acrescentar consultas empilha as linhas de uma sobre a outra, criando uma única tabela consolidada.',
        recursos: [{ t: 'Acrescentar consultas', u: 'https://learn.microsoft.com/pt-br/power-query/append-queries' }],
        arquivo: 'Acrescentar Consultas - Parte 1 (4 arquivos).zip' },
      { id: 'acrescentar-consultas-2', title: 'Acrescentar consultas — parte 2',
        desc: 'Continuação prática do acréscimo de consultas, agora com múltiplas fontes e ajustes de estrutura.',
        objetivos: ['Acrescentar três ou mais consultas de uma vez', 'Ajustar nomes de colunas divergentes antes de acrescentar'],
        body: 'Na prática, fontes diferentes raramente têm nomes de coluna idênticos — uma pode ter "Cod_Cliente" e outra "CodigoCliente". Esta aula mostra como padronizar os nomes antes de acrescentar, para que o Power Query reconheça as colunas como a mesma informação.',
        recursos: [{ t: 'Acrescentar consultas', u: 'https://learn.microsoft.com/pt-br/power-query/append-queries' }],
        arquivo: 'Acrescentar Consultas - Parte 2 (2 arquivos).zip' },
      { id: 'mesclar-consultas', title: 'Mesclar consultas',
        desc: 'Diferente de mesclar colunas, mesclar consultas une duas tabelas inteiras por uma coluna em comum — o equivalente a um PROCV avançado ou a um JOIN de banco de dados.',
        objetivos: ['Mesclar duas tabelas por uma coluna-chave em comum', 'Escolher o tipo de junção correto (interna, externa esquerda, externa direita, completa)'],
        body: 'Enquanto "mesclar colunas" concatena texto dentro da mesma tabela, "mesclar consultas" combina duas tabelas diferentes com base em uma chave comum — por exemplo, trazer o nome do vendedor para a tabela de vendas a partir de uma tabela de funcionários. O tipo de junção escolhido determina o que acontece com linhas sem correspondência: uma junção externa esquerda mantém todas as linhas da tabela principal mesmo sem par na segunda tabela, enquanto uma junção interna descarta linhas sem correspondência nos dois lados.',
        recursos: [{ t: 'Visão geral de mesclar consultas', u: 'https://learn.microsoft.com/pt-br/power-query/merge-queries-overview' }],
        arquivo: 'Mesclar Consultas (4 arquivos).zip' },
    ],
  },
  {
    id: 'otimizacao', title: 'Módulo 05 · Modelo de Dados & Otimização de Desempenho', kind: 'reading',
    lessons: [
      {
        id: 'otimizar-modelo', title: 'Otimizando o Modelo de Dados',
        content: [
          { h: 'Remover o que não é usado', p: 'O passo mais simples e mais esquecido: remover colunas e linhas que não aparecem em nenhum visual ou cálculo. Cada coluna carregada consome memória e tempo de atualização — um modelo com 40 colunas quando só 15 são usadas nos relatórios é uma escolha cara sem necessidade.', r: { t: 'Técnicas de redução de dados para modelos de importação', u: 'https://learn.microsoft.com/pt-br/power-bi/guidance/import-modeling-data-reduction' } },
          { h: 'Encontrar medidas, relacionamentos e visuais lentos', p: 'O Performance Analyzer do Power BI Desktop grava quanto tempo cada visual, consulta e cálculo DAX levou para renderizar em uma interação — a forma mais direta de descobrir qual medida específica está deixando o relatório lento, em vez de suspeitar do arquivo inteiro.', r: { t: 'Treinamento: otimizar um modelo para desempenho', u: 'https://learn.microsoft.com/pt-br/training/modules/optimize-model-power-bi/' } },
          { h: 'Cardinalidade e tipos de dados', p: 'Cardinalidade é o número de valores distintos em uma coluna. Colunas de alta cardinalidade (como um ID de transação único por linha) custam muito mais memória do que colunas de baixa cardinalidade (como um status com 5 opções possíveis). Trocar uma coluna de texto por um tipo inteiro, ou dividir uma coluna de data e hora em duas colunas separadas, costuma reduzir drasticamente essa cardinalidade.' },
          { h: 'Agregações', p: 'Para modelos muito grandes, criar e gerenciar tabelas de agregação — versões pré-resumidas dos dados em um nível mais alto (por mês em vez de por dia, por exemplo) — permite que a maioria das consultas seja respondida pela tabela pequena e rápida, recorrendo à tabela detalhada apenas quando o usuário realmente precisa do nível mais fino.', r: { t: 'Guia de otimização do Power BI', u: 'https://learn.microsoft.com/pt-br/power-bi/guidance/power-bi-optimization' } },
        ],
      },
    ],
  },
  {
    id: 'dax', title: 'Módulo 06 · Fórmulas DAX', kind: 'reading',
    lessons: [
      {
        id: 'dax-sintaxe-medidas', title: 'Sintaxe, nomenclatura e organização de medidas',
        content: [
          { h: 'O que é DAX', p: 'DAX (Data Analysis Expressions) nasceu com o Power Pivot, em 2010, e é a linguagem usada tanto no Power Pivot quanto no SSAS Tabular e no Power BI. Diferente do Excel, DAX não tem o conceito solto de "linha" e "coluna" — tudo trabalha sobre tabelas e colunas de um modelo de dados relacionado.', r: { t: 'Visão geral do DAX', u: 'https://learn.microsoft.com/pt-br/dax/dax-overview' } },
          { h: 'Definição de nomes e sintaxe', p: 'Toda medida DAX começa com um nome claro (evite "Medida1" — prefira "Total de Vendas") seguido de sinal de igual e uma expressão. Boas práticas de nomenclatura incluem manter nomes de medida sem o nome da tabela na frente (diferente de colunas, que sempre usam Tabela[Coluna]) e agrupar medidas relacionadas com um prefixo em comum.' },
          { h: 'Grupo de medidas, formatação e comentários', p: 'Organizar dezenas de medidas em pastas de exibição (grupos de medidas) evita que o painel de campos vire uma lista impossível de navegar. A formatação de número (moeda, percentual, casas decimais) deve ser definida na própria medida, não no visual, para que ela apareça correta em qualquer lugar do relatório. Comentários — usando // ou /* */ — documentam o raciocínio por trás de uma fórmula complexa para quem for dar manutenção nela depois, incluindo você mesmo, meses depois.' },
          { h: 'Variáveis', p: 'A instrução VAR permite nomear um resultado intermediário e reutilizá-lo dentro da mesma medida, em vez de repetir a mesma sub-expressão várias vezes. Isso deixa a fórmula mais legível e, na maioria dos casos, mais rápida — o mecanismo calcula a variável uma única vez, mesmo que ela seja referenciada várias vezes depois do RETURN.' },
          { h: 'Medidas rápidas', p: 'Para cálculos comuns (percentual do total, variação ano a ano, média móvel), o Power BI oferece "medidas rápidas": você escolhe o cálculo em um menu e o Power BI escreve o DAX por você. É um bom atalho para começar e também uma forma de aprender padrões DAX lendo o código gerado.', r: { t: 'Aprenda os fundamentos de DAX no Power BI Desktop', u: 'https://learn.microsoft.com/pt-br/power-bi/transform-model/desktop-quickstart-learn-dax-basics' } },
        ],
      },
      {
        id: 'dax-contexto-modelo', title: 'O modelo de dados e os contextos do DAX',
        content: [
          { h: 'Por que o modelo de dados importa para o DAX', p: 'Uma medida DAX não existe isolada — o resultado dela depende inteiramente de como as tabelas estão relacionadas no modelo. A mesma fórmula de soma pode retornar números diferentes dependendo da direção e do tipo de filtro cruzado configurado nos relacionamentos entre as tabelas.' },
          { h: 'Contexto de filtro', p: 'O contexto de filtro é o conjunto de filtros ativos no momento em que uma medida é calculada — definido pelas linhas e colunas de uma tabela ou matriz, pelos filtros do relatório, da página e do visual, e pelas segmentações de dados selecionadas. Uma mesma medida "Total de Vendas" retorna um número diferente para cada célula de uma tabela porque cada célula tem seu próprio contexto de filtro.', r: { t: 'Glossário de termos DAX', u: 'https://learn.microsoft.com/pt-br/dax/dax-glossary' } },
          { h: 'Contexto de filtro por agregação', p: 'Quando uma medida usa CALCULATE para adicionar ou substituir um filtro (por exemplo, forçar o cálculo sempre para "Ano Atual", ignorando a seleção do usuário), ela está manipulando o contexto de filtro deliberadamente — a base de praticamente todo cálculo DAX mais avançado, como percentual do total ou comparação com período anterior.' },
          { h: 'Contexto de linha e funções iteradoras', p: 'O contexto de linha existe quando o DAX está avaliando uma expressão linha a linha — automaticamente em colunas calculadas, ou explicitamente quando você usa uma função iteradora como SUMX. SUMX percorre uma tabela linha por linha, calcula uma expressão para cada linha e só então soma o resultado — diferente de SUM, que soma uma coluna já existente diretamente.' },
          { h: 'Operadores DAX', p: 'Os operadores aritméticos (+, -, *, /, ^) funcionam como no Excel. Os operadores de comparação (=, >, <, >=, <=, <>) retornam verdadeiro ou falso. Já os operadores de texto e lógicos (&, &&, ||, IN) concatenam valores e combinam condições — por exemplo, [Estado]="MA" && [Quantidade]>10.' },
        ],
      },
      {
        id: 'dax-colunas-medidas-matematica', title: 'Calculated columns vs. measures & funções matemáticas',
        content: [
          { h: 'Colunas calculadas x medidas', p: 'Uma coluna calculada é avaliada linha a linha e armazenada fisicamente no modelo, ocupando memória — útil quando o resultado precisa ser usado como filtro, eixo de um visual ou lado de um relacionamento. Uma medida é calculada sob demanda, no momento em que o visual é renderizado, respeitando o contexto de filtro atual — a escolha certa para praticamente qualquer agregação (somas, médias, percentuais). Como regra prática: prefira medidas sempre que possível, e reserve colunas calculadas para quando o resultado realmente precisa existir linha a linha.' },
          { h: 'Funções matemáticas e estatísticas essenciais', p: 'SUM, AVERAGE, MIN e MAX operam diretamente sobre uma coluna existente. DIVIDE faz uma divisão seguramente, retornando um valor alternativo (geralmente em branco) em vez de erro quando o denominador é zero — sempre prefira DIVIDE(a,b) a a/b em medidas de produção.', r: { t: 'Referência de funções DAX (mais de 250 funções)', u: 'https://learn.microsoft.com/pt-br/dax/dax-function-reference' } },
          { h: 'Funções de contagem', p: 'COUNT conta valores numéricos em uma coluna; COUNTA conta qualquer valor não vazio, incluindo texto; COUNTROWS conta linhas de uma tabela inteira (mesmo sem escolher uma coluna); DISTINCTCOUNT conta valores únicos; e COUNTBLANK conta especificamente as células vazias — cada uma resolve uma pergunta ligeiramente diferente sobre o mesmo conjunto de dados.' },
          { h: 'Funções iteradoras (X)', p: 'SUMX, AVERAGEX, MINX e MAXX aplicam uma expressão a cada linha de uma tabela antes de agregar o resultado — essenciais quando o cálculo não existe como coluna pronta, como "quantidade × preço unitário" somado por pedido, quando quantidade e preço estão em colunas diferentes.' },
        ],
      },
      {
        id: 'dax-logica-erros-texto', title: 'Combinando funções: lógica, tratamento de erros e texto',
        content: [
          { h: 'Combinar funções', p: 'Fórmulas DAX do mundo real raramente usam uma única função isolada — o padrão mais comum é aninhar funções, como um CALCULATE com um FILTER dentro, ou um SWITCH que decide qual medida usar. Ler uma fórmula complexa de dentro para fora (a função mais interna primeiro) costuma ser o jeito mais fácil de entendê-la.' },
          { h: 'Tratamento de erros', p: 'IFERROR e ISERROR capturam situações como divisão por zero ou uma busca RELATED sem correspondência, permitindo retornar um valor alternativo em vez de quebrar o visual inteiro com uma mensagem de erro visível para o usuário final.' },
          { h: 'Funções lógicas básicas', p: 'IF avalia uma condição e retorna um entre dois valores. AND e OR combinam duas condições lógicas — mas quando há mais de duas condições, SWITCH (ou a variante SWITCH(TRUE(), ...)) costuma ser mais legível do que encadear vários IF aninhados.' },
          { h: 'Funções de texto', p: 'CONCATENATE, LEFT, MID, RIGHT, UPPER, LOWER, PROPER, SUBSTITUTE e SEARCH resolvem em DAX os mesmos problemas de padronização e extração de texto vistos no Power Query — a diferença é que aqui elas rodam dentro de uma medida ou coluna calculada, já no modelo.', r: { t: 'Referência de funções DAX (mais de 250 funções)', u: 'https://learn.microsoft.com/pt-br/dax/dax-function-reference' } },
        ],
      },
      {
        id: 'dax-calculate-filter', title: 'CALCULATE, FILTER, ALL e RELATED',
        content: [
          { h: 'CALCULATE: a função mais importante do DAX', p: 'CALCULATE avalia uma expressão em um contexto de filtro modificado — é a única função DAX capaz de alterar o contexto de filtro diretamente, o que a torna a base de praticamente todo cálculo de negócio não trivial: percentual do total, comparação com o ano anterior, meta versus realizado.', r: { t: 'Função CALCULATE (DAX)', u: 'https://learn.microsoft.com/pt-br/dax/calculate-function-dax' } },
          { h: 'FILTER', p: 'FILTER retorna uma tabela contendo apenas as linhas que atendem a uma condição — não é usada sozinha, mas como argumento de dentro de CALCULATE ou de uma função iteradora, quando o filtro precisa de uma lógica mais complexa do que uma simples comparação de coluna.' },
          { h: 'ALL', p: 'ALL remove os filtros aplicados a uma tabela ou coluna específica — útil para calcular um total geral que ignora a segmentação de dados selecionada pelo usuário, como "percentual do total geral" em vez de "percentual do total filtrado".' },
          { h: 'RELATED', p: 'RELATED busca um valor em uma tabela relacionada a partir do lado "muitos" de um relacionamento — funciona como um PROCV automático entre tabelas do modelo, sem precisar escrever a lógica de busca manualmente.' },
        ],
      },
      {
        id: 'dax-tabelas-tempo', title: 'Funções de tabela, data/tempo e inteligência de tempo',
        content: [
          { h: 'Funções de tabela', p: 'Funções como ALL, VALUES, DISTINCT, SUMMARIZE e ADDCOLUMNS retornam tabelas em vez de valores únicos — usadas como argumento de outras funções ou diretamente em uma medida que precisa iterar sobre um conjunto de linhas construído dinamicamente.' },
          { h: 'Funções de data e tempo', p: 'YEAR, MONTH, DAY, DATEDIFF e EOMONTH extraem e manipulam partes de uma data — a base para qualquer cálculo que dependa de calendário, como idade de um cliente ou dias em atraso.' },
          { h: 'Inteligência de tempo', p: 'DATESYTD, DATEADD, DATESINPERIOD, SAMEPERIODLASTYEAR e PARALLELPERIOD automatizam comparações temporais comuns — acumulado no ano, mesmo período do ano anterior, média móvel — sem precisar reescrever a lógica de datas em cada medida. Essas funções exigem uma tabela calendário marcada corretamente no modelo para funcionar de forma confiável.', r: { t: 'Treinamento: funções de inteligência de tempo em DAX', u: 'https://learn.microsoft.com/pt-br/training/modules/dax-power-bi-time-intelligence/' } },
        ],
      },
    ],
  },
  {
    id: 'relatorios', title: 'Módulo 07 · Criar e Enriquecer Relatórios', kind: 'reading',
    lessons: [
      {
        id: 'construindo-visualizacoes', title: 'Construindo visualizações',
        content: [
          { h: 'Adicionar e escolher o visual certo', p: 'Cada tipo de visual responde melhor a um tipo de pergunta: gráfico de linhas para tendência ao longo do tempo, barras para comparar categorias, mapa para distribuição geográfica, tabela quando o número exato importa mais que o padrão visual. Escolher o visual errado é a causa mais comum de um relatório "bonito, mas difícil de entender".', r: { t: 'Visão geral de visualizações no Power BI', u: 'https://learn.microsoft.com/pt-br/power-bi/visuals/power-bi-visualizations-overview' } },
          { h: 'Formatar e configurar', p: 'O painel de formatação controla desde cores e títulos até eixos, legendas e rótulos de dados — pequenos ajustes aqui (remover bordas desnecessárias, alinhar títulos, esconder eixos redundantes) fazem mais diferença na leitura do relatório do que a escolha do tipo de gráfico em si.' },
          { h: 'Formatação condicional', p: 'Aplicar cor condicional a uma tabela ou a um KPI com base no valor (vermelho abaixo da meta, verde acima) transforma uma tabela de números em algo que comunica o status em menos de um segundo de leitura, sem exigir que o usuário calcule nada mentalmente.' },
          { h: 'Segmentação de dados e filtros', p: 'Segmentações de dados (slicers) e filtros em nível de visual, página ou relatório controlam o que é exibido sem precisar de um novo relatório para cada recorte — a mesma base de dados serve dezenas de perguntas diferentes, dependendo de como o usuário filtra.' },
          { h: 'Visuais personalizados, R e Python', p: 'Quando os visuais nativos não bastam, o AppSource oferece centenas de visuais certificados por Microsoft e parceiros para importar direto no relatório — e, para análises estatísticas mais avançadas, é possível embutir um gráfico gerado em R ou Python diretamente em uma página.', r: { t: 'Importar visuais do Power BI do AppSource ou de um arquivo', u: 'https://learn.microsoft.com/pt-br/power-bi/developer/visuals/import-visual' } },
        ],
      },
      {
        id: 'enriquecendo-relatorios', title: 'Deixando o relatório mais usável',
        content: [
          { h: 'Indicadores (KPIs) e cards', p: 'Um card ou um visual de KPI destaca um único número importante — faturamento do mês, meta atingida — como ponto de partida visual de uma página, antes do usuário mergulhar nos detalhes dos outros visuais.', r: { t: 'Criar um visual de cartão no Power BI', u: 'https://learn.microsoft.com/pt-br/power-bi/visuals/power-bi-visualization-card' } },
          { h: 'Dicas de ferramenta personalizadas', p: 'Em vez do tooltip padrão (que só mostra os valores já visíveis no visual), uma dica de ferramenta personalizada é uma página inteira do relatório, com seus próprios visuais, exibida em miniatura quando o usuário passa o mouse sobre um ponto de dados — útil para mostrar contexto adicional sem poluir o visual principal.', r: { t: 'Criar dicas de ferramenta visuais no Power BI', u: 'https://learn.microsoft.com/pt-br/power-bi/create-reports/desktop-visual-tooltips' } },
          { h: 'Interações entre visuais e painel de seleção', p: 'Por padrão, clicar em um visual filtra e realça automaticamente os demais visuais da página — esse comportamento pode ser ajustado visual a visual. O painel de seleção lista todos os objetos de uma página e permite reordenar camadas, ocultar e renomear elementos, essencial em páginas com muitos visuais sobrepostos.' },
          { h: 'Navegação: bookmarks e botões', p: 'Marcadores (bookmarks) capturam o estado exato de uma página — filtros, segmentações, visuais ocultos — e podem ser reativados por um botão, criando navegação por abas ou histórias guiadas dentro de uma única página de relatório, sem precisar de páginas separadas para cada "vista".', r: { t: 'Criar marcadores de relatório no Power BI', u: 'https://learn.microsoft.com/pt-br/power-bi/create-reports/desktop-bookmarks' } },
          { h: 'Classificação, sincronização de segmentação e drillthrough', p: 'Classificar visuais permite mudar a ordem de exibição sem alterar os dados de origem. Sincronizar segmentações de dados entre páginas evita que o usuário precise refazer o mesmo filtro em cada página. E o drillthrough leva o usuário de um resumo (por exemplo, uma linha em uma tabela de clientes) direto para uma página de detalhe filtrada automaticamente para aquele cliente específico.', r: { t: 'Usar drillthrough em relatórios do Power BI', u: 'https://learn.microsoft.com/pt-br/power-bi/create-reports/desktop-drillthrough' } },
        ],
      },
    ],
  },
  {
    id: 'analise-avancada', title: 'Módulo 08 · Análise Avançada & Insights de IA', kind: 'reading',
    lessons: [
      {
        id: 'explorando-dados', title: 'Explorando dados com filtros e análise estatística',
        content: [
          { h: 'Filtro Top N', p: 'Em vez de mostrar todas as categorias, um filtro Top N exibe apenas as N maiores (ou menores) por uma medida escolhida — "top 10 clientes por faturamento" em vez de uma lista de centenas de clientes onde só os primeiros importam para a decisão em questão.', r: { t: 'Filtrar dados em relatórios do Power BI', u: 'https://learn.microsoft.com/pt-br/power-bi/consumer/end-user-report-filter' } },
          { h: 'Resumo estatístico', p: 'Ao clicar com o botão direito em um ponto de dados e escolher "Analisar", o Power BI oferece um resumo estatístico rápido — média, mediana, quartis — sem precisar montar uma medida DAX específica só para uma checagem pontual durante a análise.' },
          { h: 'Linhas de referência e o painel de análise', p: 'O painel de análise permite adicionar linhas de referência (média, mediana, um valor constante como a meta do trimestre) diretamente sobre um gráfico, dando contexto imediato sobre se um ponto está acima ou abaixo do esperado.' },
          { h: 'Play Axis', p: 'O recurso Play Axis anima um visual ao longo de uma dimensão (tipicamente tempo), mostrando a evolução de categorias quadro a quadro — útil em apresentações para mostrar tendência de forma mais impactante do que um gráfico estático.' },
        ],
      },
      {
        id: 'insights-ia', title: 'Insights automáticos com IA',
        content: [
          { h: 'Q&A: perguntas em linguagem natural', p: 'O visual de Perguntas e Respostas (Q&A) permite digitar uma pergunta em português simples — "qual foi o faturamento por região em 2025" — e o Power BI monta o visual correspondente automaticamente, interpretando nomes de colunas e medidas do modelo.', r: { t: 'Criar um visual de Perguntas e Respostas em um dashboard', u: 'https://learn.microsoft.com/pt-br/power-bi/create-reports/power-bi-visualization-introduction-to-q-and-a' } },
          { h: 'Insights rápidos', p: 'Ao clicar com o botão direito em um valor e escolher "Analisar > Explicar o aumento/a diminuição", o Power BI testa automaticamente outras colunas do modelo em busca de explicações estatisticamente relevantes para a variação — um primeiro diagnóstico automático antes de investigar manualmente.' },
          { h: 'Outliers, agrupamentos e binning', p: 'Identificar outliers (valores muito fora do padrão) evita que eles distorçam médias e conclusões. Agrupamentos (agrupar itens semelhantes manualmente, como unir vários produtos em uma categoria "Outros") e binning (agrupar valores numéricos contínuos em faixas, como faixas etárias) tornam visuais com muitas categorias ou muitos pontos mais fáceis de interpretar.' },
          { h: 'Principais influenciadores', p: 'O visual de Principais Influenciadores usa IA para testar automaticamente quais colunas do modelo mais influenciam o aumento ou a diminuição de uma métrica escolhida — por exemplo, descobrir que "região" e "canal de venda" são os fatores que mais influenciam uma queda em vendas, sem precisar testar cada coluna manualmente.', r: { t: 'Tutorial do visual de principais influenciadores', u: 'https://learn.microsoft.com/pt-br/power-bi/visuals/power-bi-visualization-influencers' } },
          { h: 'Árvore de decomposição', p: 'A árvore de decomposição permite explorar uma métrica quebrando-a em múltiplas dimensões, em qualquer ordem, com um clique — e também tem um modo de IA que sugere automaticamente a próxima dimensão mais relevante para investigar uma variação.', r: { t: 'Criar e exibir visuais de árvore de decomposição', u: 'https://learn.microsoft.com/pt-br/power-bi/visuals/power-bi-visualization-decomposition-tree' } },
        ],
      },
    ],
  },
  {
    id: 'dashboards-governanca', title: 'Módulo 09 · Dashboards, Publicação & Governança', kind: 'reading',
    lessons: [
      {
        id: 'criar-dashboards', title: 'Criar e configurar dashboards',
        content: [
          { h: 'Dashboards x relatórios', p: 'Um relatório é multipágina e interativo (filtros, segmentações, drill down); um dashboard é uma única tela de blocos (tiles) fixados a partir de um ou mais relatórios, pensada para monitoramento rápido, não para exploração profunda.', r: { t: 'Introdução aos dashboards para criadores do Power BI', u: 'https://learn.microsoft.com/pt-br/power-bi/create-reports/service-dashboards' } },
          { h: 'Fixar uma página ao vivo', p: 'Fixar uma página inteira de relatório como um bloco "ao vivo" (live tile) mantém a interatividade original do relatório dentro do dashboard — diferente de fixar um único visual, que vira uma imagem estática dos dados no momento em que foi fixado.', r: { t: 'Fixar uma página de relatório inteira a um dashboard', u: 'https://learn.microsoft.com/pt-br/power-bi/create-reports/service-dashboard-pin-live-tile-from-report' } },
          { h: 'Alertas de dados', p: 'Em blocos do tipo indicador, KPI ou cartão, é possível configurar um alerta que notifica automaticamente quando um valor ultrapassa um limite definido — como um aviso automático quando o estoque de um produto cai abaixo de um número crítico.', r: { t: 'Definir alertas de dados em dashboards do Power BI', u: 'https://learn.microsoft.com/pt-br/power-bi/explore-reports/end-user-alerts' } },
          { h: 'Visão mobile, tema e Q&A no dashboard', p: 'O aplicativo mobile do Power BI reorganiza automaticamente os blocos para telas pequenas, mas vale revisar o layout mobile manualmente para dashboards críticos. Um tema visual consistente (cores, fontes) aplicado ao dashboard reforça a identidade do relatório, e a caixa de Perguntas e Respostas também pode ser adicionada diretamente ao dashboard, não só a relatórios.' },
        ],
      },
      {
        id: 'implantar-manter', title: 'Implantar e manter as entregas',
        content: [
          { h: 'Atualização programada', p: 'Um conjunto de dados publicado no serviço Power BI pode ser configurado para atualizar automaticamente em um horário definido, buscando os dados mais recentes da fonte sem exigir que alguém abra o arquivo manualmente. Capacidades compartilhadas permitem até 8 atualizações por dia; capacidades Premium ou Fabric, até 48.', r: { t: 'Atualização de dados no Power BI', u: 'https://learn.microsoft.com/pt-br/power-bi/connect-data/refresh-data' } },
          { h: 'Segurança em nível de linha (RLS)', p: 'RLS permite que o mesmo relatório mostre dados diferentes para usuários diferentes — um gerente regional só vê os dados da própria região — através de papéis de segurança definidos no Power BI Desktop e de associações de usuário ou grupo de segurança configuradas no serviço.', r: { t: 'Segurança em nível de linha (RLS) no Power BI', u: 'https://learn.microsoft.com/pt-br/power-bi/guidance/rls-guidance' } },
          { h: 'Atualização incremental', p: 'Em vez de recarregar a tabela inteira a cada atualização, a atualização incremental recarrega apenas o período mais recente (por exemplo, os últimos 30 dias), mantendo o histórico já processado intacto — essencial para modelos grandes (acima de 1 GB) ou que levam horas para atualizar por completo.', r: { t: 'Configurar atualização incremental para modelos semânticos', u: 'https://learn.microsoft.com/pt-br/power-bi/connect-data/incremental-refresh-overview' } },
          { h: 'Promover e certificar conjuntos de dados', p: 'Endosso ajuda outros usuários a encontrar conteúdo confiável: qualquer pessoa com permissão de gravação pode "promover" um relatório que considera bom; já a "certificação" é reservada a revisores autorizados pelo administrador do Power BI e sinaliza que aquele conjunto de dados atende ao padrão de qualidade da organização.', r: { t: 'Promover e certificar conteúdo do Power BI', u: 'https://learn.microsoft.com/pt-br/power-bi/collaborate-share/service-endorsement-overview' } },
          { h: 'Dependências e formato de dataset grande', p: 'Antes de alterar ou remover um conjunto de dados compartilhado, é importante identificar quais relatórios e dashboards dependem dele — removê-lo sem verificar quebra tudo que foi construído em cima. Para modelos muito grandes, habilitar o formato de armazenamento de modelo semântico grande antes da primeira atualização no serviço evita atingir o limite padrão de tamanho.', r: { t: 'Modelos semânticos grandes no Power BI Premium', u: 'https://learn.microsoft.com/pt-br/fabric/enterprise/powerbi/service-premium-large-models' } },
        ],
      },
    ],
  },
  {
    id: 'labs-power-query', title: 'Módulo 10 · Laboratórios Práticos de Power Query', kind: 'reading',
    lessons: [
      {
        id: 'lab-01a', title: 'Laboratório 01A · Conectando e Importando Dados',
        steps: [
          { id: 'tipos-de-dados', h: 'Etapa 1 · Tipos de dados', p: 'Abra o arquivo desta etapa e importe a tabela para o Power Query (Dados → Obter Dados → Desta Pasta de Trabalho). No Editor do Power Query, identifique colunas com o tipo detectado incorretamente — datas ou números lidos como texto — e corrija o tipo pelo ícone no cabeçalho da coluna antes de carregar a consulta.', arquivo: 'Tipos de Dados.xlsx' },
          { id: 'tabela-ou-intervalo', h: 'Etapa 2 · Tabela ou intervalo', p: 'Converta o intervalo de dados desta planilha em uma Tabela do Excel com Ctrl+T antes de conectar ao Power Query. Compare o resultado de carregar a consulta a partir do intervalo bruto e a partir da tabela nomeada, e observe como a tabela nomeada se expande automaticamente quando novas linhas são adicionadas.', arquivo: 'Tabela ou Intervalo.xlsx' },
          { id: 'importar-excel', h: 'Etapa 3 · Importando um arquivo Excel', p: 'Use Obter Dados → Excel para conectar a este arquivo como fonte externa. Na janela de navegação, revise a prévia de cada planilha disponível antes de escolher qual carregar, praticando selecionar apenas a tabela necessária, sem trazer abas extras para o modelo.', arquivo: 'Importando um Arquivo Excel.xlsx' },
          { id: 'consulta-pasta', h: 'Etapa 4 · Consulta de uma pasta', p: 'Este pacote traz 7 planilhas com a mesma estrutura de colunas. Salve todas em uma única pasta local e use Obter Dados → Pasta para combiná-las automaticamente em uma única tabela consolidada, sem precisar importar arquivo por arquivo.', arquivo: 'Consulta de Pasta (7 arquivos).zip' },
        ],
      },
      {
        id: 'lab-02a', title: 'Laboratório 02A · Transformação e Limpeza de Dados',
        steps: [
          { id: 'preenchimento-colunas', h: 'Etapa 1 · Preenchimento de colunas', p: 'Localize a coluna com células vazias resultantes de uma planilha com células mescladas. Use Transformar → Preencher → Para Baixo para replicar o último valor visto e eliminar as lacunas antes de qualquer agregação.', arquivo: 'Preenchimento de Colunas.xlsx' },
          { id: 'dividir-colunas', h: 'Etapa 2 · Dividir colunas', p: 'Selecione a coluna indicada e use Transformar → Dividir Coluna → Por Delimitador para separá-la em duas ou mais colunas. Repita o exercício usando Por Número de Caracteres para comparar os dois métodos.', arquivo: 'Dividir Colunas.xlsx' },
          { id: 'dividir-linhas', h: 'Etapa 3 · Dividir linhas', p: 'Nesta planilha, uma coluna traz múltiplos valores separados por vírgula em uma única célula. Use Dividir Coluna → Por Delimitador, mas escolha a opção "Linhas" em vez de "Colunas", e observe como cada valor vira sua própria linha.', arquivo: 'Dividir Linhas.xlsx' },
          { id: 'colunas-personalizadas', h: 'Etapa 4 · Colunas personalizadas', p: 'Crie uma Coluna Personalizada (Adicionar Coluna → Coluna Personalizada) que combine ou calcule valores de duas colunas existentes usando uma fórmula M simples, como multiplicar preço por quantidade.', arquivo: 'Colunas Personalizadas.xlsx' },
          { id: 'coluna-exemplo', h: 'Etapa 5 · Coluna de exemplo', p: 'Use Adicionar Coluna → Coluna a Partir de Exemplos e digite o resultado esperado para as primeiras linhas. Confira a fórmula M que o Power Query gerou automaticamente e valide se ela se aplica corretamente às demais linhas.', arquivo: 'Coluna de Exemplo.xlsx' },
          { id: 'mesclar-colunas', h: 'Etapa 6 · Mesclar colunas', p: 'Selecione duas ou mais colunas de texto e use Transformar → Mesclar Colunas, escolhendo um separador (espaço, vírgula ou hífen) para reconstituir um único campo, como um endereço completo.', arquivo: 'Mesclar Colunas.xlsx' },
          { id: 'classificar-filtrar', h: 'Etapa 7 · Classificar e filtrar', p: 'Ordene a tabela por uma ou mais colunas diretamente no Editor do Power Query e aplique um filtro de linha para remover registros antigos ou de teste antes de carregar a consulta no modelo.', arquivo: 'Classificar e Filtrar.xlsx' },
          { id: 'formula-if', h: 'Etapa 8 · Fórmula IF', p: 'Adicione uma coluna personalizada com uma expressão "if condição then valor1 else valor2" para classificar cada linha (por exemplo, "Alto" ou "Baixo") com base em um valor numérico.', arquivo: 'Fórmula IF.xlsx' },
          { id: 'formula-if-and', h: 'Etapa 9 · Fórmula IF e AND', p: 'Combine dois testes lógicos com "and" dentro da mesma condição, retornando verdadeiro apenas quando ambos os critérios forem atendidos ao mesmo tempo.', arquivo: 'Fórmula IF e AND.xlsx' },
          { id: 'formula-adddays', h: 'Etapa 10 · Fórmula AddDays', p: 'Use Date.AddDays para calcular uma data de vencimento a partir de uma data de emissão, somando um número fixo de dias.', arquivo: 'Fórmula AddDays.xlsx' },
          { id: 'formulas-texto', h: 'Etapa 11 · Fórmulas de texto', p: 'Pratique Text.Upper, Text.Lower e Text.Proper para padronizar a capitalização de uma coluna de texto digitada manualmente, eliminando duplicidades causadas por variações como "joão" e "João".', arquivo: 'Fórmulas de Texto.xlsx' },
          { id: 'coluna-dinamica', h: 'Etapa 12 · Coluna dinâmica (Pivot)', p: 'Este pacote traz 3 planilhas. Use Transformar → Coluna Dinâmica para transformar valores de uma coluna em novos cabeçalhos, testando diferentes funções de agregação (soma, contagem) e observando o efeito da opção "Não agregar".', arquivo: 'Coluna Dinâmica - Pivot (3 arquivos).zip' },
          { id: 'transformar-colunas-linhas', h: 'Etapa 13 · Transformar colunas em linhas (Unpivot)', p: 'Nesta planilha, os meses aparecem um por coluna. Selecione as colunas de mês e use Transformar → Dinamizar Coluna → Transformar Outras Colunas em Linhas para converter a tabela para o formato longo, ideal para um modelo de BI.', arquivo: 'Transformar Colunas em Linhas - Unpivot.xlsx' },
          { id: 'agrupar-por', h: 'Etapa 14 · Agrupar por', p: 'Use Transformar → Agrupar Por para resumir a tabela detalhada em uma tabela por vendedor (ou outra dimensão), aplicando soma, contagem ou média sobre as demais colunas.', arquivo: 'Agrupar Por.xlsx' },
          { id: 'acrescentar-consultas-1', h: 'Etapa 15 · Acrescentar consultas — parte 1', p: 'Este pacote traz um arquivo principal e três planilhas mensais (Jan, Fev, Mar 2008) com a mesma estrutura de colunas. Importe cada uma como consulta separada e use Página Inicial → Acrescentar Consultas para empilhá-las em uma única tabela consolidada.', arquivo: 'Acrescentar Consultas - Parte 1 (4 arquivos).zip' },
          { id: 'acrescentar-consultas-2', h: 'Etapa 16 · Acrescentar consultas — parte 2', p: 'Este pacote traz duas planilhas com nomes de coluna divergentes representando a mesma informação. Renomeie as colunas para que coincidam antes de acrescentar as consultas, e confirme que o Power Query passa a reconhecê-las como equivalentes.', arquivo: 'Acrescentar Consultas - Parte 2 (2 arquivos).zip' },
          { id: 'mesclar-consultas', h: 'Etapa 17 · Mesclar consultas', p: 'Este pacote traz 4 planilhas. Use Página Inicial → Mesclar Consultas para unir duas tabelas por uma coluna-chave em comum, testando os diferentes tipos de junção (interna, externa esquerda, externa direita) e observando o que acontece com linhas sem correspondência em cada caso.', arquivo: 'Mesclar Consultas (4 arquivos).zip' },
        ],
      },
    ],
  },
  {
    id: 'encerramento', title: 'Módulo 11 · Encerramento', kind: 'reading',
    lessons: [
      {
        id: 'conclusao-curso', title: 'Conclusão do curso',
        content: [
          { h: 'Você chegou ao final do conteúdo', p: 'Percorremos o caminho completo: modelagem de dados, Power Query, otimização de modelo, DAX, construção de relatórios, análise avançada com IA, publicação e governança, e os laboratórios práticos aplicando tudo isso direto no Power BI Desktop.' },
          { h: 'Próximo passo: avaliação final', p: 'Para receber seu certificado de conclusão, faça a avaliação final do curso — ela reúne perguntas de todos os módulos. É permitido refazer a avaliação quantas vezes precisar até atingir a nota mínima de aprovação.' },
        ],
      },
    ],
  },
];

const flat = [];
COURSE.forEach(m => m.lessons.forEach(l => flat.push({ moduleId: m.id, moduleTitle: m.title, kind: m.kind, ...l })));
const totalLessons = flat.length;

let progress = new Set(SERVER_PROGRESS);
let openModule = COURSE[0].id;

function moduleIndex(moduleId) { return COURSE.findIndex(m => m.id === moduleId); }

function moduleUnlocked(moduleId) {
  const idx = moduleIndex(moduleId);
  if (idx <= 0) return true;
  const prevId = COURSE[idx - 1].id;
  if (!(prevId in AVALIACOES)) return true;
  return !!AVALIACOES[prevId].aprovado;
}

async function syncProgress(licaoId, action) {
  try {
    await fetch('/aluno/progresso.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ licao_id: licaoId, action }),
    });
  } catch (e) { /* best-effort; UI already reflects the change */ }
}

const ICON_PLAY = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M10 9l5 3-5 3z" fill="currentColor" stroke="none"/></svg>';
const ICON_CHECK = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12l5 5 11-11"/></svg>';
const ICON_CHEV = '<svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 6l6 6-6 6"/></svg>';
const ICON_EXT = '<svg class="ext" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17L17 7M9 7h8v8"/></svg>';
const ICON_DOC = '<svg class="doc" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h9l3 3v15H6z"/><circle cx="12" cy="6" r="2.2" fill="currentColor" stroke="none"/></svg>';

function moduleDone(mod) { return mod.lessons.every(l => progress.has(l.id)); }

const ICON_LOCK = '<svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 018 0v3"/></svg>';

function renderSidebar(currentId) {
  const nav = document.getElementById('sidebarNav');
  nav.innerHTML = COURSE.map(mod => {
    const isOpen = mod.id === openModule;
    const doneCount = mod.lessons.filter(l => progress.has(l.id)).length;
    const unlocked = moduleUnlocked(mod.id);
    const aval = AVALIACOES[mod.id];
    return `
    <div class="sidebar-module${isOpen ? ' open' : ''}${unlocked ? '' : ' locked'}" data-module="${mod.id}">
      <button class="sidebar-module-head" data-toggle="${mod.id}">
        <span>${mod.title}</span>
        <span style="display:flex;align-items:center;gap:0.5rem;">
          ${unlocked ? `<span class="count">${doneCount}/${mod.lessons.length}</span>` : ICON_LOCK}
          ${ICON_CHEV}
        </span>
      </button>
      <div class="sidebar-module-lessons">
        ${!unlocked ? `<p class="locked-msg">Conclua a avaliação do módulo anterior para desbloquear.</p>` : mod.lessons.map(l => {
          const done = progress.has(l.id);
          const active = l.id === currentId;
          return `<button class="sidebar-lesson${active ? ' active' : ''}${done ? ' done' : ''}" data-lesson="${l.id}">
            <span class="check">${done ? ICON_CHECK : ''}</span>
            <span class="type-icon">${ICON_PLAY}</span>
            <span class="lbl">${l.title}</span>
          </button>`;
        }).join('')}
        ${unlocked && aval ? `<a class="sidebar-eval${aval.aprovado ? ' passed' : ''}" href="/aluno/avaliacao.php?modulo=${mod.id}">
          <span class="type-icon">${aval.aprovado ? ICON_CHECK : ICON_LOCK}</span>
          <span class="lbl">${aval.aprovado ? 'Avaliação aprovada' : 'Fazer avaliação do módulo'}</span>
        </a>` : ''}
      </div>
    </div>`;
  }).join('');

  nav.querySelectorAll('.sidebar-lesson').forEach(btn => {
    btn.addEventListener('click', () => { location.hash = btn.dataset.lesson; closeSidebarMobile(); });
  });
  nav.querySelectorAll('[data-toggle]').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.dataset.toggle;
      openModule = openModule === id ? null : id;
      renderSidebar(currentId);
    });
  });
  updateProgressBar();
}

function updateProgressBar() {
  const count = flat.filter(l => progress.has(l.id)).length;
  document.getElementById('progressCount').textContent = `${count}/${totalLessons}`;
  document.getElementById('progressBar').style.width = `${Math.round((count / totalLessons) * 100)}%`;
}

const RESOURCE_SUMMARIES = {
  'https://learn.microsoft.com/pt-br/dax/calculate-function-dax': 'CALCULATE avalia uma expressão dentro de um contexto de filtro modificado — é a função que permite, por exemplo, calcular "vendas do ano anterior" ou "percentual do total" substituindo ou adicionando filtros à consulta atual. Os argumentos extras (depois da expressão principal) funcionam como filtros que sobrescrevem o que já estava selecionado no relatório.',
  'https://learn.microsoft.com/pt-br/dax/dax-function-reference': 'Índice oficial com mais de 250 funções DAX, organizadas por categoria (matemáticas, texto, data/hora, lógicas, estatísticas, de tabela). Cada função tem sua própria página com sintaxe, parâmetros, tipo de retorno e exemplos práticos de uso.',
  'https://learn.microsoft.com/pt-br/dax/dax-glossary': 'Glossário com a definição precisa dos termos usados na documentação de DAX — contexto de filtro, contexto de linha, tabela, medida, coluna calculada e outros — útil como referência rápida quando um termo técnico aparece sem explicação em outro artigo.',
  'https://learn.microsoft.com/pt-br/dax/dax-overview': 'Introdução oficial ao DAX (Data Analysis Expressions): de onde a linguagem veio (Power Pivot, 2010), onde é usada hoje (Power BI, Power Pivot no Excel, SSAS Tabular) e como ela difere de fórmulas de planilha — DAX sempre opera sobre tabelas e colunas de um modelo relacionado, nunca sobre células soltas.',
  'https://learn.microsoft.com/pt-br/fabric/enterprise/powerbi/service-premium-large-models': 'Explica o formato de armazenamento de "modelo semântico grande", necessário quando um modelo Power BI ultrapassa o limite padrão de tamanho em capacidades Premium/Fabric. Precisa ser habilitado antes da primeira atualização do modelo no serviço, não depois.',
  'https://learn.microsoft.com/pt-br/power-bi/collaborate-share/service-endorsement-overview': 'Descreve os dois níveis de "endosso" de conteúdo no Power BI: promoção (qualquer pessoa com permissão de gravação pode marcar um relatório como recomendado) e certificação (reservada a revisores autorizados pelo administrador, sinalizando que o conteúdo atende ao padrão de qualidade da organização).',
  'https://learn.microsoft.com/pt-br/power-bi/connect-data/incremental-refresh-overview': 'Mostra como configurar a atualização incremental, que recarrega apenas o período mais recente dos dados (em vez da tabela inteira) a cada atualização — recomendada para modelos acima de 1 GB ou que levam horas para atualizar por completo, mantendo o histórico já processado intacto.',
  'https://learn.microsoft.com/pt-br/power-bi/connect-data/refresh-data': 'Cobre os diferentes tipos de atualização de dados no Power BI: sob demanda, programada (agendada em horários fixos) e via API. Detalha os limites por tipo de capacidade — até 8 atualizações programadas por dia em capacidade compartilhada, até 48 em Premium/Fabric.',
  'https://learn.microsoft.com/pt-br/power-bi/consumer/end-user-report-filter': 'Explica os tipos de filtro disponíveis para quem consome um relatório: filtros básicos, avançados, de intervalo relativo, por URL e o filtro Top N, que mostra apenas os N maiores ou menores valores de uma medida escolhida.',
  'https://learn.microsoft.com/pt-br/power-bi/create-reports/desktop-bookmarks': 'Um marcador (bookmark) captura o estado completo de uma página de relatório — filtros, segmentações, visuais ocultos, ordenação — e pode ser reativado por um botão depois, permitindo criar navegação por abas ou apresentações guiadas dentro de uma única página.',
  'https://learn.microsoft.com/pt-br/power-bi/create-reports/desktop-drillthrough': 'Drillthrough é a navegação que leva o usuário de um resumo (uma linha de uma tabela, por exemplo) direto para uma página de detalhe já filtrada automaticamente para aquele item específico — muito usado para investigar "por que esse cliente teve esse número".',
  'https://learn.microsoft.com/pt-br/power-bi/create-reports/desktop-visual-tooltips': 'Em vez do tooltip padrão (que só repete valores já visíveis), uma dica de ferramenta personalizada é uma página inteira do relatório exibida em miniatura ao passar o mouse sobre um ponto de dados — permite mostrar contexto extra sem poluir o visual principal.',
  'https://learn.microsoft.com/pt-br/power-bi/create-reports/power-bi-visualization-introduction-to-q-and-a': 'O visual de Perguntas e Respostas (Q&A) interpreta uma pergunta digitada em linguagem natural e monta o gráfico correspondente automaticamente, reconhecendo os nomes de colunas e medidas do próprio modelo de dados.',
  'https://learn.microsoft.com/pt-br/power-bi/create-reports/service-dashboard-pin-live-tile-from-report': 'Fixar uma página inteira de relatório como bloco "ao vivo" (live tile) preserva a interatividade original no dashboard — diferente de fixar um único visual, que vira uma imagem estática congelada no momento em que foi fixada.',
  'https://learn.microsoft.com/pt-br/power-bi/create-reports/service-dashboards': 'Explica a diferença central entre relatório e dashboard: o relatório é multipágina e interativo, pensado para exploração; o dashboard é uma única tela de blocos fixados a partir de um ou mais relatórios, pensada para monitoramento rápido.',
  'https://learn.microsoft.com/pt-br/power-bi/developer/visuals/import-visual': 'Mostra como importar visuais do AppSource (a loja oficial de visuais certificados por Microsoft e parceiros) ou de um arquivo local diretamente no painel de Visualizações do Power BI Desktop, quando os visuais nativos não cobrem uma necessidade específica.',
  'https://learn.microsoft.com/pt-br/power-bi/explore-reports/end-user-alerts': 'Alertas de dados podem ser configurados em blocos de indicador, KPI ou cartão em um dashboard, notificando automaticamente quando um valor ultrapassa um limite definido — por exemplo, um aviso quando o estoque cai abaixo de um número crítico.',
  'https://learn.microsoft.com/pt-br/power-bi/fundamentals/power-bi-overview': 'Visão geral oficial do que é o Power BI: o conjunto de ferramentas (Desktop, serviço online, mobile) para conectar, modelar, visualizar e compartilhar dados, e como essas peças se encaixam no fluxo de trabalho típico de um analista.',
  'https://learn.microsoft.com/pt-br/power-bi/guidance/import-modeling-data-reduction': 'Reúne técnicas para reduzir o tamanho de um modelo em modo de importação: remover colunas não usadas, preferir tipos de dados mais compactos, resumir dados muito granulares e evitar carregar histórico além do necessário para a análise.',
  'https://learn.microsoft.com/pt-br/power-bi/guidance/power-bi-optimization': 'Guia geral de otimização: como monitorar o desempenho do relatório para achar gargalos, priorizando consultas lentas e visuais pesados como os pontos de maior impacto na experiência do usuário final.',
  'https://learn.microsoft.com/pt-br/power-bi/guidance/rls-guidance': 'Segurança em nível de linha (RLS) permite que o mesmo relatório mostre dados diferentes para usuários diferentes, através de papéis de segurança definidos no Desktop e associações de usuário ou grupo configuradas no serviço Power BI.',
  'https://learn.microsoft.com/pt-br/power-bi/guidance/star-schema': 'Artigo de referência da Microsoft sobre por que o esquema estrela (tabelas fato conectadas a tabelas dimensão por chaves simples) é a arquitetura recomendada para modelos Power BI — menos ambiguidade, consultas mais rápidas, relacionamentos mais simples de manter.',
  'https://learn.microsoft.com/pt-br/power-bi/transform-model/desktop-query-overview': 'Explica o painel de consultas do Power BI Desktop: como cada consulta representa uma fonte de dados transformada, como reordenar, duplicar, referenciar e organizar consultas em grupos dentro do mesmo arquivo.',
  'https://learn.microsoft.com/pt-br/power-bi/transform-model/desktop-quickstart-learn-dax-basics': 'Um guia rápido prático para escrever as primeiras medidas DAX no Power BI Desktop, partindo de exemplos simples de soma e contagem até fórmulas com CALCULATE — pensado para quem nunca escreveu DAX antes.',
  'https://learn.microsoft.com/pt-br/power-bi/transform-model/desktop-relationships-understand': 'Detalha como o Power BI Desktop detecta e gerencia relacionamentos entre tabelas: cardinalidade (um-para-muitos, muitos-para-muitos), direção do filtro cruzado e como isso afeta o resultado de uma medida.',
  'https://learn.microsoft.com/pt-br/power-bi/visuals/power-bi-visualization-card': 'O visual de cartão exibe um único número em destaque — o ponto de partida visual de uma página antes do usuário explorar os detalhes nos demais visuais. Pode ser tornado interativo, filtrando os outros visuais ao ser selecionado.',
  'https://learn.microsoft.com/pt-br/power-bi/visuals/power-bi-visualization-decomposition-tree': 'A árvore de decomposição permite quebrar uma métrica em múltiplas dimensões, em qualquer ordem, com um clique — e tem um modo de IA que sugere automaticamente qual dimensão explorar em seguida para explicar uma variação.',
  'https://learn.microsoft.com/pt-br/power-bi/visuals/power-bi-visualization-influencers': 'O visual de Principais Influenciadores testa automaticamente, via IA, quais colunas do modelo mais influenciam o aumento ou a queda de uma métrica escolhida — útil para descobrir causas sem precisar testar cada coluna manualmente.',
  'https://learn.microsoft.com/pt-br/power-bi/visuals/power-bi-visualizations-overview': 'Panorama de todos os tipos de visualização nativos do Power BI, organizados por categoria (comparação, tendência, distribuição, relação, parte-do-todo), com orientação sobre qual visual usar para qual tipo de pergunta.',
  'https://learn.microsoft.com/pt-br/power-query/append-queries': 'Acrescentar consultas empilha os dados de duas ou mais tabelas com a mesma estrutura de colunas, uma embaixo da outra — o equivalente a copiar e colar linhas de várias planilhas em uma só, mas de forma atualizável.',
  'https://learn.microsoft.com/pt-br/power-query/data-profiling-tools': 'Descreve as três ferramentas de perfil de dados do Power Query — qualidade da coluna (barra de válido/erro/vazio), distribuição da coluna (frequência de valores) e perfil da coluna (estatísticas completas) — acessíveis na guia Exibir do editor.',
  'https://learn.microsoft.com/pt-br/power-query/data-types': 'Explica os tipos de dados do Power Query (texto, número inteiro, decimal, data, data/hora, verdadeiro/falso) e por que definir o tipo certo logo no início da consulta evita erros de cálculo e ordenação mais adiante.',
  'https://learn.microsoft.com/pt-br/power-query/fill-values-column': 'A operação de preenchimento propaga o último valor não vazio de uma coluna para baixo (ou para cima) até a célula seguinte com dado — essencial para tratar planilhas de origem com células mescladas ou cabeçalhos hierárquicos.',
  'https://learn.microsoft.com/pt-br/power-query/get-data-experience': 'Visão geral de todos os conectores de dados disponíveis no Power Query — arquivos, pastas, bancos de dados, serviços online — e como a experiência de prévia e seleção funciona antes de carregar os dados na consulta.',
  'https://learn.microsoft.com/pt-br/power-query/group-by': 'Agrupar por resume uma tabela detalhada em uma tabela agregada por uma ou mais colunas, aplicando soma, contagem, média, mínimo ou máximo sobre as demais colunas — o equivalente a um GROUP BY de SQL, feito pela interface.',
  'https://learn.microsoft.com/pt-br/power-query/merge-queries-overview': 'Mesclar consultas combina duas tabelas diferentes com base em uma coluna-chave em comum, de forma parecida com um PROCV avançado ou um JOIN de banco de dados — o artigo detalha os seis tipos de junção disponíveis (interna, externa esquerda, externa direita, etc.).',
  'https://learn.microsoft.com/pt-br/power-query/pivot-columns': 'Dinamizar (pivotar) uma coluna transforma seus valores distintos em novas colunas, usando uma função de agregação para preencher cada célula — o mesmo resultado de uma tabela dinâmica do Excel, mas persistido como parte da consulta.',
  'https://learn.microsoft.com/pt-br/power-query/power-query-ui': 'Tour pela interface do Editor do Power Query: faixa de opções, painel de consultas à esquerda, prévia de dados no centro, painel de configurações à direita com a lista de passos aplicados (a receita de transformação).',
  'https://learn.microsoft.com/pt-br/power-query/power-query-what-is-power-query': 'Explica o que é o Power Query e seu papel de ETL (extrair, transformar, carregar) dentro do Excel, Power BI e outros produtos Microsoft — cada transformação vira um passo registrado, reaplicado automaticamente a cada atualização.',
  'https://learn.microsoft.com/pt-br/power-query/unpivot-column': 'Despivotar converte várias colunas (por exemplo, um mês por coluna) em duas colunas de atributo-valor, deixando a tabela no formato "longo" que modelos de dados relacionam e agregam corretamente.',
  'https://learn.microsoft.com/pt-br/powerquery-m/date-functions': 'Referência de todas as funções de data da linguagem M — incluindo Date.AddDays, Date.From e Date.ToText — usadas para calcular prazos, extrair partes de uma data ou converter texto em data dentro de uma coluna personalizada.',
  'https://learn.microsoft.com/pt-br/powerquery-m/power-query-m-function-reference': 'Índice completo com mais de 700 funções da linguagem M, a linguagem por trás de toda transformação do Power Query — organizado por categoria (texto, número, data, tabela, lista, lógica).',
  'https://learn.microsoft.com/pt-br/powerquery-m/table-splitcolumn': 'Documentação da função Table.SplitColumn, que separa uma coluna em várias com base em um delimitador ou em um número fixo de caracteres — a função por trás da transformação "Dividir coluna" da interface.',
  'https://learn.microsoft.com/pt-br/powerquery-m/text-functions': 'Referência das funções de texto da linguagem M — Text.Upper, Text.Lower, Text.Proper, Text.Middle e outras — usadas para padronizar capitalização, extrair trechos e limpar colunas de texto antes de carregar no modelo.',
  'https://learn.microsoft.com/pt-br/training/modules/dax-power-bi-time-intelligence/': 'Módulo de treinamento oficial sobre funções de inteligência de tempo em DAX — acumulado no ano, mesmo período do ano anterior, média móvel — incluindo a exigência de uma tabela calendário corretamente marcada no modelo.',
  'https://learn.microsoft.com/pt-br/training/modules/optimize-model-power-bi/': 'Módulo de treinamento sobre otimização de modelo: como revisar o desempenho de medidas, relacionamentos e visuais, usar variáveis para simplificar cálculos e reduzir a cardinalidade de colunas para economizar memória.',
};

function resourceItem(r) {
  if (!r) return '';
  const resumo = RESOURCE_SUMMARIES[r.u] || '';
  const rid = 'res-' + Math.random().toString(36).slice(2, 9);
  return `<li class="res-card" data-res-id="${rid}">
    <button class="res-toggle" type="button" data-toggle-res="${rid}">
      ${ICON_DOC}
      <span>${r.t}<span class="src">${MSL}</span></span>
      ${ICON_CHEV}
    </button>
    <div class="res-body">
      ${resumo ? `<p>${resumo}</p>` : ''}
      <a href="${r.u}" target="_blank" rel="noopener">Abrir artigo completo no Microsoft Learn ${ICON_EXT}</a>
    </div>
  </li>`;
}

function renderLesson(id) {
  let idx = flat.findIndex(l => l.id === id);
  if (idx === -1) idx = 0;
  const lesson = flat[idx];
  const prev = flat[idx - 1];
  const next = flat[idx + 1];
  const done = progress.has(lesson.id);
  const main = document.getElementById('appMain');
  openModule = lesson.moduleId;

  const playerBlock = `
    <div class="player">
      <video class="player-video" controls preload="metadata" playsinline>
        <source src="/video.php?id=${lesson.id}" type="video/mp4">
      </video>
      <div class="player-placeholder">
        <div class="play-btn">${ICON_PLAY.replace('<svg ', '<svg width="18" height="18" ')}</div>
        <div class="caption"><span>${lesson.title}</span><span>Vídeo em preparação</span></div>
      </div>
    </div>
  `;

  let mediaBlock;
  if (lesson.kind === 'video') {
    mediaBlock = `
      ${playerBlock}
      <div class="objectives">
        <div class="kicker">O que você vai aprender</div>
        <ul>${lesson.objetivos.map(o => `<li>${ICON_CHECK}<span>${o}</span></li>`).join('')}</ul>
      </div>
      <div class="lesson-body">
        <h2>Sobre esta aula</h2>
        <p>${lesson.desc}</p>
        <p>${lesson.body}</p>
      </div>
      ${lesson.arquivo ? `
      <div class="resources">
        <h2>Arquivo de exercício</h2>
        <a class="btn btn-ghost on-light" href="/exercicio.php?id=${lesson.id}">${ICON_DOC} Baixar ${lesson.arquivo}</a>
      </div>` : ''}
      ${lesson.recursos && lesson.recursos.length ? `
      <div class="resources">
        <h2>Recursos oficiais Microsoft</h2>
        <ul>${lesson.recursos.map(resourceItem).join('')}</ul>
      </div>` : ''}
    `;
  } else if (lesson.steps) {
    mediaBlock = `
      ${playerBlock}
      <div class="reading-card">
        ${lesson.steps.map(s => `
          <div class="lab-step">
            <h3>${s.h}</h3>
            <p>${s.p}</p>
            ${s.arquivo ? `<a class="btn btn-ghost on-light lab-download" href="/exercicio.php?id=${s.id}">${ICON_DOC} Baixar ${s.arquivo}</a>` : ''}
          </div>
        `).join('')}
      </div>
    `;
  } else {
    mediaBlock = `
      ${playerBlock}
      <div class="reading-card">
        ${lesson.content.map(b => `<h3>${b.h}</h3><p>${b.p}</p>${b.r ? `<div class="res-inline resources"><ul>${resourceItem(b.r)}</ul></div>` : ''}`).join('')}
      </div>
    `;
  }

  main.innerHTML = `
    <p class="lesson-breadcrumb">${lesson.moduleTitle}</p>
    <h1 class="lesson-title">${lesson.title}</h1>
    ${mediaBlock}
    <button class="mark-done-btn${done ? ' is-done' : ''}" id="markDoneBtn">
      ${ICON_CHECK.replace('<svg ', '<svg width="14" height="14" ')}
      <span>${done ? 'Aula concluída' : 'Marcar aula como concluída'}</span>
    </button>
    <div class="lesson-nav">
      <div class="side">${prev ? `<a href="#${prev.id}"><span class="dir">← Anterior</span><span class="t">${prev.title}</span></a>` : ''}</div>
      <div class="side right">${next ? `<a href="#${next.id}"><span class="dir">Próxima →</span><span class="t">${next.title}</span></a>` : ''}</div>
    </div>
  `;

  const videoEl = main.querySelector('.player-video');
  const placeholderEl = main.querySelector('.player-placeholder');
  videoEl.addEventListener('loadedmetadata', () => {
    videoEl.style.display = 'block';
    placeholderEl.style.display = 'none';
  });
  videoEl.addEventListener('error', () => {
    videoEl.style.display = 'none';
    placeholderEl.style.display = 'flex';
  }, true);

  document.getElementById('markDoneBtn').addEventListener('click', () => {
    const nowDone = !progress.has(lesson.id);
    if (nowDone) progress.add(lesson.id); else progress.delete(lesson.id);
    syncProgress(lesson.id, nowDone ? 'complete' : 'uncomplete');
    renderLesson(lesson.id);
  });

  renderSidebar(lesson.id);
  document.title = `${lesson.title} — Área do Aluno — TECH SANTOS BR`;
  window.scrollTo({ top: 0, behavior: 'instant' in window ? 'instant' : 'auto' });
}

function currentLessonId() {
  const h = location.hash.replace('#', '');
  const lesson = flat.find(l => l.id === h);
  if (!lesson) return flat[0].id;
  if (!moduleUnlocked(lesson.moduleId)) return flat[0].id;
  return h;
}

window.addEventListener('hashchange', () => renderLesson(currentLessonId()));
renderLesson(currentLessonId());

document.getElementById('appMain').addEventListener('click', (e) => {
  const btn = e.target.closest('[data-toggle-res]');
  if (!btn) return;
  btn.closest('.res-card').classList.toggle('open');
});

const sidebarEl = document.getElementById('appSidebar');
const backdropEl = document.getElementById('sidebarBackdrop');
const toggleBtn = document.getElementById('sidebarToggle');
function openSidebarMobile() { sidebarEl.classList.add('open'); backdropEl.classList.add('open'); toggleBtn.setAttribute('aria-expanded', 'true'); }
function closeSidebarMobile() { sidebarEl.classList.remove('open'); backdropEl.classList.remove('open'); toggleBtn.setAttribute('aria-expanded', 'false'); }
toggleBtn.addEventListener('click', () => sidebarEl.classList.contains('open') ? closeSidebarMobile() : openSidebarMobile());
backdropEl.addEventListener('click', closeSidebarMobile);
</script>
<?php endif; ?>
</body>
</html>
