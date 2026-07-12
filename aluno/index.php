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
    border-radius: 6px; display: flex; align-items: center; justify-content: center;
    position: relative; overflow: hidden; margin-bottom: 1.5rem;
  }
  .player .play-btn {
    width: 56px; height: 56px; border-radius: 50%; background: rgba(255,255,255,.12);
    border: 1.5px solid rgba(255,255,255,.4); display: flex; align-items: center; justify-content: center; color: #fff;
  }
  .player .play-btn svg { width: 18px; height: 18px; margin-left: 3px; }
  .player .caption {
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
      <div class="label"><span>Seu progresso</span><span id="progressCount">0/30</span></div>
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
      { id: 'modelagem-pratica', title: 'Modelagem de dados na prática',
        desc: 'Como o modelo de dados vai além de uma tabela: carregar tabelas separadas, relacioná-las por chaves e entender granularidade em um cenário com múltiplas tabelas.',
        objetivos: ['Carregar mais de uma tabela no Power BI', 'Entender o conceito de granularidade (o nível de detalhe de cada linha)'],
        body: 'Granularidade é uma das ideias mais importantes de modelagem: significa saber exatamente o que cada linha de uma tabela representa — um pedido, um item de pedido, um dia, um cliente. Misturar granularidades diferentes na mesma tabela é a causa mais comum de números errados em um relatório.',
        recursos: [{ t: 'Trabalhar com relacionamentos no Power BI Desktop', u: 'https://learn.microsoft.com/pt-br/power-bi/transform-model/desktop-relationships-understand' }] },
      { id: 'esquema-estrela', title: 'Esquema estrela (Star Schema)',
        desc: 'A abordagem mais usada em data warehouses: separar tabelas fato (o que aconteceu) de tabelas dimensão (os atributos do que aconteceu) para um modelo rápido e sem ambiguidade.',
        objetivos: ['Diferenciar tabela fato de tabela dimensão', 'Montar um esquema estrela simples a partir de uma base de vendas'],
        body: 'No esquema estrela, uma tabela fato central (vendas, por exemplo) se conecta a várias tabelas dimensão (Cliente, Produto, Data, Loja) por chaves simples. É a arquitetura recomendada pela própria Microsoft para modelos Power BI, porque gera relatórios mais rápidos, menos ambíguos e mais fáceis de explicar para quem não construiu o modelo.',
        recursos: [{ t: 'Entenda o star schema e sua importância para o Power BI', u: 'https://learn.microsoft.com/pt-br/power-bi/guidance/star-schema' }] },
    ],
  },
  {
    id: 'power-query-conectar', title: 'Módulo 02 · Power Query — Conectando e Importando Dados', kind: 'video',
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
    id: 'power-query-transformar', title: 'Módulo 03 · Power Query — Transformação e Limpeza de Dados', kind: 'video',
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
    ],
  },
  {
    id: 'dax', title: 'Módulo 04 · Modelo de Dados & Fórmulas DAX', kind: 'reading',
    lessons: [
      {
        id: 'modelo-dados-dax', title: 'Modelo de Dados & Fórmulas DAX',
        content: [
          { h: 'O que é DAX', p: 'DAX (Data Analysis Expressions) nasceu com o Power Pivot, em 2010, e é a linguagem usada tanto no Power Pivot quanto no SSAS Tabular e no Power BI. Diferente do Excel, DAX não tem o conceito solto de "linha" e "coluna" — tudo trabalha sobre tabelas e colunas de um modelo de dados relacionado.', r: { t: 'Visão geral do DAX', u: 'https://learn.microsoft.com/pt-br/dax/dax-overview' } },
          { h: 'Medidas implícitas x explícitas', p: 'Medidas implícitas são os cálculos automáticos que o Power BI sugere ao arrastar um campo numérico para um visual — soma, contagem, média. Medidas explícitas são escritas por você em DAX, como uma métrica de margem de lucro acumulada no ano. Arrastar e soltar é a forma mais fácil de começar; escrever suas próprias medidas é o que compensa no longo prazo.', r: { t: 'Aprenda os fundamentos de DAX no Power BI Desktop', u: 'https://learn.microsoft.com/pt-br/power-bi/transform-model/desktop-quickstart-learn-dax-basics' } },
          { h: 'Contexto de filtro e contexto de linha', p: 'O contexto de filtro é definido pela seleção de linha, coluna, filtros do relatório e segmentações de dados — linhas fora do contexto de filtro não entram no cálculo. O contexto de linha é definido automaticamente em colunas calculadas, ou por funções iteradoras como SUMX e AVERAGEX, que percorrem uma tabela linha a linha.', r: { t: 'Glossário de termos DAX', u: 'https://learn.microsoft.com/pt-br/dax/dax-glossary' } },
          { h: 'Operadores DAX', p: 'Os operadores aritméticos (+, -, *, /, ^) funcionam como no Excel. Os operadores de comparação (=, >, <, >=, <=, <>) retornam verdadeiro ou falso. Já os operadores de texto e lógicos (&, &&, ||, IN) concatenam valores e combinam condições — por exemplo, [Estado]="MA" && [Quantidade]>10.' },
          { h: 'Funções essenciais', p: 'O curso cobre as principais categorias de funções DAX — matemáticas e estatísticas (SUM, AVERAGE, MAX, MIN, DIVIDE), de contagem (COUNT, COUNTA, COUNTROWS, DISTINCTCOUNT), lógicas (IF, AND, OR, SWITCH) e de texto (CONCATENATE, LEFT/MID/RIGHT, UPPER/LOWER/PROPER, SUBSTITUTE, SEARCH).', r: { t: 'Referência de funções DAX (mais de 250 funções)', u: 'https://learn.microsoft.com/pt-br/dax/dax-function-reference' } },
          { h: 'CALCULATE, FILTER, ALL e RELATED', p: 'CALCULATE é a função mais importante do DAX — avalia uma expressão em um novo contexto de filtro. FILTER retorna uma tabela filtrada, geralmente usada dentro de outra função. ALL remove filtros de uma tabela ou coluna, e RELATED busca um valor em uma tabela relacionada, funcionando como um PROCV entre tabelas do modelo.', r: { t: 'Função CALCULATE (DAX)', u: 'https://learn.microsoft.com/pt-br/dax/calculate-function-dax' } },
          { h: 'Funções iteradoras (X) e inteligência de tempo', p: 'Funções como SUMX, COUNTX, AVERAGEX e RANKX percorrem uma tabela linha a linha aplicando uma expressão antes de agregar o resultado. Já as funções de inteligência de tempo — DATESYTD, DATEADD, DATESINPERIOD — calculam automaticamente comparações como acumulado no ano ou período anterior.', r: { t: 'Treinamento: funções de inteligência de tempo em DAX', u: 'https://learn.microsoft.com/pt-br/training/modules/dax-power-bi-time-intelligence/' } },
        ],
      },
    ],
  },
  {
    id: 'visualizacoes', title: 'Módulo 05 · Visualizações, Relatórios & Power BI no Dia a Dia', kind: 'reading',
    lessons: [
      {
        id: 'visualizacoes-relatorios', title: 'Visualizações, Relatórios & Power BI no Dia a Dia',
        content: [
          { h: 'Construindo o relatório', p: 'Depois do modelo pronto, o próximo passo é escolher o tipo de visualização certo para cada pergunta, formatar e configurar cada visual, e aplicar formatação condicional para destacar o que importa — tudo isso com segmentação de dados e filtros interativos.', r: { t: 'Visão geral de visualizações no Power BI', u: 'https://learn.microsoft.com/pt-br/power-bi/visuals/power-bi-visualizations-overview' } },
          { h: 'Indo além do básico', p: 'O Power BI permite importar visuais personalizados da comunidade, adicionar visuais em R ou Python, criar dicas de ferramenta personalizadas e configurar a navegação entre páginas do relatório com botões e painel de seleção.' },
          { h: 'Explorando os dados', p: 'Recursos como drill down, análise Top N, resumo estatístico, identificação de outliers, agrupamentos e binning ajudam a ir além do relatório estático — e os principais influenciadores e a árvore de decomposição usam IA para explicar variações nos números automaticamente.', r: { t: 'Interagir com visuais em relatórios e dashboards', u: 'https://learn.microsoft.com/pt-br/power-bi/explore-reports/end-user-visualizations' } },
          { h: 'Publicando e compartilhando', p: 'Um relatório só gera valor quando chega até quem decide — por isso o curso cobre visão mobile, gerenciamento de acesso a dashboards, alertas de dados e o recurso de Perguntas e Respostas (Q&A) em linguagem natural.', r: { t: 'Segurança em nível de linha (RLS) no Power BI', u: 'https://learn.microsoft.com/pt-br/power-bi/guidance/rls-guidance' } },
          { h: 'Power BI no dia a dia (Teams e SharePoint)', p: 'Compartilhar um relatório ou visual diretamente no Microsoft Teams, pesquisar ativos do Power BI pelo SharePoint Online e até criar um relatório automaticamente a partir de uma lista do SharePoint — a integração com o resto do Office 365 é o que faz o Power BI virar hábito, não só uma ferramenta isolada.' },
          { h: 'Excel ou Power BI?', p: 'Por fim, uma pergunta prática: quando usar Excel (aprendendo, análises pontuais, fórmulas de cubo) e quando usar Power BI (compartilhar com um público consumidor, recursos como RLS e visão mobile). A resposta raramente é "ou" — publique no serviço do Power BI e continue analisando no Excel quando precisar.', r: { t: 'Visão geral do Power BI', u: 'https://learn.microsoft.com/pt-br/power-bi/fundamentals/power-bi-overview' } },
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
const ICON_TEXT = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 4h9l3 3v13H6z"/><path d="M9 10h6M9 14h6M9 18h3"/></svg>';
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
            <span class="type-icon">${mod.kind === 'video' ? ICON_PLAY : ICON_TEXT}</span>
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

  let mediaBlock;
  if (lesson.kind === 'video') {
    mediaBlock = `
      <div class="player">
        <div class="play-btn">${ICON_PLAY.replace('<svg ', '<svg width="18" height="18" ')}</div>
        <div class="caption"><span>${lesson.title}</span><span>Vídeo em preparação</span></div>
      </div>
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
