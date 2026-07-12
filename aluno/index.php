<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
$aluno = require_aluno();
$isPowerBi = $aluno['curso_slug'] === 'power-bi';
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="robots" content="noindex, nofollow" />
<title>Área do Aluno — <?= htmlspecialchars($aluno['curso_nome'], ENT_QUOTES) ?> — TECH SANTOS BR</title>
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
  .student-brand img { width: 24px; height: 24px; border-radius: 4px; }
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

  .resources { margin-bottom: 1.5rem; }
  .resources h2 { font-size: 0.95rem; font-weight: 700; font-family: 'Plex Sans', sans-serif; margin-bottom: 0.7rem; }
  .resources ul { list-style: none; margin: 0; padding: 0; display: grid; gap: 0.5rem; }
  .resources a {
    display: flex; align-items: center; gap: 0.6rem; text-decoration: none; color: var(--ink);
    font-size: 0.9rem; padding: 0.65rem 0.9rem; border: 1px solid var(--line); border-radius: 6px;
    transition: border-color 0.15s ease;
  }
  .resources a:hover { border-color: var(--green); color: var(--green-strong); }
  .resources a svg.ext { width: 14px; height: 14px; margin-left: auto; color: var(--ink-faint); flex: none; }
  .resources a svg.doc { width: 16px; height: 16px; color: var(--green-strong); flex: none; }
  .resources .src { font-family: 'Plex Mono', monospace; font-size: 0.68rem; color: var(--ink-faint); display: block; margin-top: 0.1rem; }

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
    <a class="student-brand" href="/curso-power-bi.html">
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
        recursos: [{ t: 'Tipos de dados no Power Query', u: 'https://learn.microsoft.com/pt-br/power-query/data-types' }] },
      { id: 'tabela-ou-intervalo', title: 'Dados a partir de uma tabela ou intervalo',
        desc: 'O ponto de partida mais comum: como trazer uma tabela ou intervalo do próprio Excel para dentro do Power Query.',
        objetivos: ['Converter um intervalo de células em tabela do Excel', 'Carregar essa tabela como consulta do Power Query'],
        body: 'Transformar um intervalo em uma Tabela do Excel (Ctrl+T) antes de conectar ao Power Query evita um problema comum: intervalos fixos não crescem sozinhos quando novas linhas são adicionadas, enquanto uma Tabela nomeada se expande automaticamente junto com os dados.',
        recursos: [{ t: 'Visão geral de consultas no Power BI Desktop', u: 'https://learn.microsoft.com/pt-br/power-bi/transform-model/desktop-query-overview' }] },
      { id: 'importar-excel', title: 'Importando um arquivo Excel',
        desc: 'Como conectar o Power Query a um arquivo Excel externo e escolher quais planilhas ou tabelas importar.',
        objetivos: ['Conectar a um arquivo .xlsx externo', 'Selecionar a planilha ou tabela correta dentro do arquivo'],
        body: 'Ao importar um arquivo Excel externo, o Power Query mostra uma prévia de cada planilha e tabela nomeada disponível dentro do arquivo antes de carregar — permitindo escolher exatamente qual pedaço dos dados entra no modelo, sem trazer abas desnecessárias.',
        recursos: [{ t: 'Visão geral de obtenção de dados', u: 'https://learn.microsoft.com/pt-br/power-query/get-data-experience' }] },
      { id: 'consulta-pasta', title: 'Consulta de uma pasta',
        desc: 'Em vez de importar arquivo por arquivo, uma consulta de pasta combina automaticamente todos os arquivos de uma pasta em uma única tabela.',
        objetivos: ['Conectar o Power Query a uma pasta inteira', 'Combinar múltiplos arquivos idênticos em uma única tabela'],
        body: 'Esse conector é especialmente útil quando um relatório mensal chega como um novo arquivo Excel a cada mês, sempre com a mesma estrutura: em vez de reimportar manualmente, a consulta de pasta detecta e combina qualquer novo arquivo adicionado, automaticamente.',
        recursos: [{ t: 'Visão geral de obtenção de dados', u: 'https://learn.microsoft.com/pt-br/power-query/get-data-experience' }] },
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
        recursos: [{ t: 'Preencher valores em uma coluna', u: 'https://learn.microsoft.com/pt-br/power-query/fill-values-column' }] },
      { id: 'dividir-colunas', title: 'Dividir colunas',
        desc: 'Separa uma coluna em várias, usando um delimitador (como vírgula ou espaço) ou por número de caracteres.',
        objetivos: ['Dividir uma coluna por delimitador (vírgula, espaço, hífen)', 'Dividir uma coluna por número fixo de caracteres'],
        body: 'É comum receber "Nome Completo" em uma única coluna e precisar separar em nome e sobrenome, ou um código composto como "SP-001" que precisa virar estado e número. Dividir colunas resolve os dois casos, e o Power Query também tenta sugerir o delimitador correto automaticamente.',
        recursos: [{ t: 'Table.SplitColumn (referência M)', u: 'https://learn.microsoft.com/pt-br/powerquery-m/table-splitcolumn' }] },
      { id: 'dividir-linhas', title: 'Dividir linhas',
        desc: 'O mesmo princípio da divisão de colunas, mas transformando um valor em múltiplas linhas em vez de múltiplas colunas.',
        objetivos: ['Dividir uma célula com múltiplos valores em várias linhas'],
        body: 'Quando uma célula contém vários itens separados por vírgula (por exemplo, "Camisa, Calça, Boné" em um único pedido), dividir em linhas transforma cada item em sua própria linha, mantendo o restante da linha original replicado — essencial antes de agregações por item.',
        recursos: [{ t: 'Table.SplitColumn (referência M)', u: 'https://learn.microsoft.com/pt-br/powerquery-m/table-splitcolumn' }] },
      { id: 'colunas-personalizadas', title: 'Colunas personalizadas',
        desc: 'Cria uma nova coluna a partir de uma fórmula em linguagem M, combinando ou calculando valores de outras colunas.',
        objetivos: ['Escrever uma fórmula M simples para criar uma coluna nova', 'Combinar valores de duas colunas existentes em uma terceira'],
        body: 'Diferente das transformações por clique, colunas personalizadas exigem escrever uma pequena fórmula na linguagem M — por exemplo, multiplicar preço por quantidade para gerar uma coluna de valor total. É o primeiro contato do curso com a linguagem que move o Power Query por trás da interface.',
        recursos: [{ t: 'Referência de funções da linguagem M', u: 'https://learn.microsoft.com/pt-br/powerquery-m/power-query-m-function-reference' }] },
      { id: 'coluna-exemplo', title: 'Coluna de exemplo',
        desc: 'Mostre ao Power Query o resultado que você quer, e ele tenta descobrir sozinho a transformação necessária a partir dos exemplos.',
        objetivos: ['Usar "Coluna a partir de exemplos" para transformações complexas', 'Entender os limites dessa detecção automática'],
        body: 'Em vez de escrever a fórmula M manualmente, você digita o resultado esperado para algumas linhas e o Power Query infere o padrão. Funciona bem para transformações de texto (capitalizar, extrair trechos), mas vale sempre conferir a fórmula gerada — ela nem sempre generaliza perfeitamente para todos os casos.',
        recursos: [{ t: 'A interface do usuário do Power Query', u: 'https://learn.microsoft.com/pt-br/power-query/power-query-ui' }] },
      { id: 'mesclar-colunas', title: 'Mesclar colunas',
        desc: 'Combina o conteúdo de duas ou mais colunas em uma só, com um separador à sua escolha.',
        objetivos: ['Mesclar duas ou mais colunas de texto em uma única coluna'],
        body: 'O caminho inverso de "dividir colunas": útil para reconstituir um endereço completo a partir de Rua, Número e Cidade separados, por exemplo, escolhendo o separador (espaço, vírgula, hífen) entre cada parte.',
        recursos: [{ t: 'Visão geral de mesclar consultas', u: 'https://learn.microsoft.com/pt-br/power-query/merge-queries-overview' }] },
      { id: 'classificar-filtrar', title: 'Classificar e filtrar',
        desc: 'Ordena e filtra linhas diretamente na consulta, antes mesmo dos dados chegarem ao modelo.',
        objetivos: ['Ordenar uma tabela por uma ou mais colunas', 'Aplicar filtros de linha dentro do Power Query, não só no relatório'],
        body: 'Filtrar já na consulta (e não apenas visualmente no relatório) reduz o volume de dados que entra no modelo — o que deixa o arquivo mais leve e as atualizações mais rápidas, especialmente quando linhas antigas ou de teste não são necessárias para a análise.',
        recursos: [{ t: 'A interface do usuário do Power Query', u: 'https://learn.microsoft.com/pt-br/power-query/power-query-ui' }] },
      { id: 'formula-if', title: 'Fórmula IF',
        desc: 'A lógica condicional básica da linguagem M: se uma condição é verdadeira, retorna um valor; senão, retorna outro.',
        objetivos: ['Escrever uma expressão "if...then...else" em M', 'Criar uma coluna de classificação simples (ex.: "Alto" / "Baixo") baseada em uma condição'],
        body: 'A sintaxe M para condicionais é "if condição then valor1 else valor2" — parecida com o SE do Excel, mas escrita por extenso. É a base para qualquer regra de negócio simples aplicada ainda na etapa de preparação dos dados, antes de chegar ao modelo.',
        recursos: [{ t: 'Referência de funções da linguagem M', u: 'https://learn.microsoft.com/pt-br/powerquery-m/power-query-m-function-reference' }] },
      { id: 'formula-if-and', title: 'Fórmula IF e AND',
        desc: 'Combina múltiplas condições em um único teste lógico, retornando verdadeiro apenas quando todas são atendidas.',
        objetivos: ['Combinar dois ou mais testes lógicos com "and"', 'Diferenciar "and" de "or" em uma condição composta'],
        body: 'Regras de negócio raramente dependem de uma única condição: "cliente ativo E com compra nos últimos 90 dias" precisa que ambos os testes sejam verdadeiros ao mesmo tempo, o que "and" garante dentro da expressão condicional.',
        recursos: [{ t: 'Referência de funções da linguagem M', u: 'https://learn.microsoft.com/pt-br/powerquery-m/power-query-m-function-reference' }] },
      { id: 'formula-adddays', title: 'Fórmula AddDays',
        desc: 'Soma (ou subtrai) dias a uma data — útil para calcular prazos, vencimentos e janelas de tempo.',
        objetivos: ['Usar Date.AddDays para calcular uma data futura ou passada', 'Calcular um prazo de vencimento a partir de uma data de emissão'],
        body: 'Date.AddDays recebe uma data e um número de dias (positivo ou negativo) e retorna a nova data — a base para calcular vencimentos, prazos de entrega ou janelas de análise como "últimos 30 dias", ainda na etapa de preparação dos dados.',
        recursos: [{ t: 'Funções de data (referência M)', u: 'https://learn.microsoft.com/pt-br/powerquery-m/date-functions' }] },
      { id: 'formulas-texto', title: 'Fórmulas de texto',
        desc: 'Funções para manipular texto: converter maiúsculas/minúsculas, extrair trechos e capitalizar nomes próprios.',
        objetivos: ['Usar Text.Upper, Text.Lower e Text.Proper para padronizar texto', 'Extrair um trecho de uma coluna de texto'],
        body: 'Dados digitados manualmente raramente chegam padronizados — "joão", "JOÃO" e "João" podem representar a mesma pessoa, mas serem tratados como valores diferentes em uma agregação. Funções de texto padronizam capitalização e formato antes que isso vire um problema no relatório.',
        recursos: [{ t: 'Funções de texto (referência M)', u: 'https://learn.microsoft.com/pt-br/powerquery-m/text-functions' }] },
      { id: 'coluna-dinamica', title: 'Coluna dinâmica (Pivot)',
        desc: 'Transforma valores de uma coluna em novas colunas — o mesmo conceito de uma tabela dinâmica, mas na etapa de preparação dos dados.',
        objetivos: ['Dinamizar (pivotar) uma coluna, transformando valores em cabeçalhos'],
        body: 'Pivotar uma coluna pega valores distintos de uma coluna (por exemplo, os meses do ano) e os transforma em novas colunas, com uma função de agregação definindo o valor de cada célula — o mesmo resultado de uma tabela dinâmica do Excel, mas persistido como parte da consulta.',
        recursos: [{ t: 'Colunas dinâmicas (pivot) no Power Query', u: 'https://learn.microsoft.com/pt-br/power-query/pivot-columns' }] },
      { id: 'transformar-colunas-linhas', title: 'Transformar colunas em linhas (Unpivot)',
        desc: 'O processo inverso do pivot: converte várias colunas em pares de atributo-valor, deixando a tabela no formato longo que o modelo de dados prefere.',
        objetivos: ['Despivotar (unpivot) colunas, convertendo-as em linhas', 'Entender por que o formato "longo" é preferível para modelos de BI'],
        body: 'Planilhas de origem costumam ter um mês por coluna (Jan, Fev, Mar...) — ótimo para leitura humana, ruim para um modelo de dados. Despivotar converte essas colunas em duas: uma com o nome do mês, outra com o valor — o formato que o Power BI consegue relacionar e agregar corretamente.',
        recursos: [{ t: 'Despivotar colunas no Power Query', u: 'https://learn.microsoft.com/pt-br/power-query/unpivot-column' }] },
      { id: 'agrupar-por', title: 'Agrupar por',
        desc: 'Agrega linhas por uma ou mais colunas, calculando soma, contagem, média ou outras operações por grupo.',
        objetivos: ['Agrupar uma tabela por uma coluna, somando ou contando outra', 'Agrupar por múltiplas colunas ao mesmo tempo'],
        body: '"Agrupar por" resume uma tabela detalhada (uma linha por venda) em uma tabela resumida (uma linha por vendedor, por exemplo), aplicando soma, contagem, média, mínimo ou máximo sobre as demais colunas — equivalente a um GROUP BY de SQL, mas via interface.',
        recursos: [{ t: 'Agrupar ou resumir linhas', u: 'https://learn.microsoft.com/pt-br/power-query/group-by' }] },
      { id: 'acrescentar-consultas-1', title: 'Acrescentar consultas — parte 1',
        desc: 'Empilha duas ou mais consultas com a mesma estrutura, uma embaixo da outra — o equivalente a copiar e colar tabelas, mas atualizável.',
        objetivos: ['Acrescentar (empilhar) duas consultas com colunas iguais'],
        body: 'Quando duas fontes têm exatamente a mesma estrutura de colunas — por exemplo, vendas de duas filiais em arquivos separados — acrescentar consultas empilha as linhas de uma sobre a outra, criando uma única tabela consolidada.',
        recursos: [{ t: 'Acrescentar consultas', u: 'https://learn.microsoft.com/pt-br/power-query/append-queries' }] },
      { id: 'acrescentar-consultas-2', title: 'Acrescentar consultas — parte 2',
        desc: 'Continuação prática do acréscimo de consultas, agora com múltiplas fontes e ajustes de estrutura.',
        objetivos: ['Acrescentar três ou mais consultas de uma vez', 'Ajustar nomes de colunas divergentes antes de acrescentar'],
        body: 'Na prática, fontes diferentes raramente têm nomes de coluna idênticos — uma pode ter "Cod_Cliente" e outra "CodigoCliente". Esta aula mostra como padronizar os nomes antes de acrescentar, para que o Power Query reconheça as colunas como a mesma informação.',
        recursos: [{ t: 'Acrescentar consultas', u: 'https://learn.microsoft.com/pt-br/power-query/append-queries' }] },
      { id: 'mesclar-consultas', title: 'Mesclar consultas',
        desc: 'Diferente de mesclar colunas, mesclar consultas une duas tabelas inteiras por uma coluna em comum — o equivalente a um PROCV avançado ou a um JOIN de banco de dados.',
        objetivos: ['Mesclar duas tabelas por uma coluna-chave em comum', 'Escolher o tipo de junção correto (interna, externa esquerda, externa direita, completa)'],
        body: 'Enquanto "mesclar colunas" concatena texto dentro da mesma tabela, "mesclar consultas" combina duas tabelas diferentes com base em uma chave comum — por exemplo, trazer o nome do vendedor para a tabela de vendas a partir de uma tabela de funcionários. O tipo de junção escolhido determina o que acontece com linhas sem correspondência: uma junção externa esquerda mantém todas as linhas da tabela principal mesmo sem par na segunda tabela, enquanto uma junção interna descarta linhas sem correspondência nos dois lados.',
        recursos: [{ t: 'Visão geral de mesclar consultas', u: 'https://learn.microsoft.com/pt-br/power-query/merge-queries-overview' }] },
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
];

const STORAGE_KEY = 'ts_curso_powerbi_progress_v1_aluno_' + ALUNO_ID;
const flat = [];
COURSE.forEach(m => m.lessons.forEach(l => flat.push({ moduleId: m.id, moduleTitle: m.title, kind: m.kind, ...l })));
const totalLessons = flat.length;

function loadProgress() {
  try { return new Set(JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]')); }
  catch (e) { return new Set(); }
}
function saveProgress(set) { localStorage.setItem(STORAGE_KEY, JSON.stringify([...set])); }
let progress = loadProgress();
let openModule = COURSE[0].id;

const ICON_PLAY = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M10 9l5 3-5 3z" fill="currentColor" stroke="none"/></svg>';
const ICON_CHECK = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12l5 5 11-11"/></svg>';
const ICON_CHEV = '<svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 6l6 6-6 6"/></svg>';
const ICON_EXT = '<svg class="ext" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17L17 7M9 7h8v8"/></svg>';
const ICON_DOC = '<svg class="doc" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h9l3 3v15H6z"/><circle cx="12" cy="6" r="2.2" fill="currentColor" stroke="none"/></svg>';

function moduleDone(mod) { return mod.lessons.every(l => progress.has(l.id)); }

function renderSidebar(currentId) {
  const nav = document.getElementById('sidebarNav');
  nav.innerHTML = COURSE.map(mod => {
    const isOpen = mod.id === openModule;
    const doneCount = mod.lessons.filter(l => progress.has(l.id)).length;
    return `
    <div class="sidebar-module${isOpen ? ' open' : ''}" data-module="${mod.id}">
      <button class="sidebar-module-head" data-toggle="${mod.id}">
        <span>${mod.title}</span>
        <span style="display:flex;align-items:center;gap:0.5rem;">
          <span class="count">${doneCount}/${mod.lessons.length}</span>
          ${ICON_CHEV}
        </span>
      </button>
      <div class="sidebar-module-lessons">
        ${mod.lessons.map(l => {
          const done = progress.has(l.id);
          const active = l.id === currentId;
          return `<button class="sidebar-lesson${active ? ' active' : ''}${done ? ' done' : ''}" data-lesson="${l.id}">
            <span class="check">${done ? ICON_CHECK : ''}</span>
            <span class="type-icon">${ICON_PLAY}</span>
            <span class="lbl">${l.title}</span>
          </button>`;
        }).join('')}
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

function resourceItem(r) {
  if (!r) return '';
  return `<li><a href="${r.u}" target="_blank" rel="noopener">${ICON_DOC}<span>${r.t}<span class="src">${MSL}</span></span>${ICON_EXT}</a></li>`;
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
      ${lesson.recursos && lesson.recursos.length ? `
      <div class="resources">
        <h2>Recursos oficiais Microsoft</h2>
        <ul>${lesson.recursos.map(resourceItem).join('')}</ul>
      </div>` : ''}
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
    if (progress.has(lesson.id)) progress.delete(lesson.id); else progress.add(lesson.id);
    saveProgress(progress);
    renderLesson(lesson.id);
  });

  renderSidebar(lesson.id);
  document.title = `${lesson.title} — Área do Aluno — TECH SANTOS BR`;
  window.scrollTo({ top: 0, behavior: 'instant' in window ? 'instant' : 'auto' });
}

function currentLessonId() {
  const h = location.hash.replace('#', '');
  return flat.some(l => l.id === h) ? h : flat[0].id;
}

window.addEventListener('hashchange', () => renderLesson(currentLessonId()));
renderLesson(currentLessonId());

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
