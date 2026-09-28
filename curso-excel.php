<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/cursos_catalogo.php';

$curso = curso_a_venda(db(), 'excel');
$precoCentavos = $curso['preco_centavos'] ?? null;
$precoFormatado = preco_formatado($precoCentavos ? (int)$precoCentavos : null);
$urlCompra = '/comprar.php?curso=excel';
$whatsMsg = rawurlencode('Olá! Estou vendo a página do curso de Excel e tenho uma dúvida antes de comprar.');
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="canonical" href="https://techsantos.com.br/curso-excel.php" />
<script type="application/ld+json">
{"@context": "https://schema.org", "@type": "Course", "name": "Excel do zero ao avançado — Preparatório MO-210 e MO-211", "description": "Curso completo de Microsoft Excel (Microsoft 365) em português, do zero ao avançado, alinhado às certificações Microsoft Office Specialist Excel Associate (MO-210) e Excel Expert (MO-211): fórmulas, PROCX, tabelas dinâmicas, gráficos, análise de hipóteses e macros.", "provider": {"@type": "Organization", "name": "TECH SANTOS BR", "url": "https://techsantos.com.br/"}, "inLanguage": "pt-BR", "url": "https://techsantos.com.br/curso-excel.php"}
</script>
<title>Curso Excel do zero ao avançado — Preparatório MO-210 e MO-211 | TECH SANTOS BR</title>
<meta name="description" content="Curso completo de Excel em português, do zero ao avançado e mapeado nas provas MO-210 e MO-211: 17 módulos, 68 aulas com teoria, imagens oficiais da Microsoft e áudio em todas as aulas, avaliações, 2 simulados finais e certificado." />
<meta property="og:type" content="website" />
<meta property="og:locale" content="pt_BR" />
<meta property="og:url" content="https://techsantos.com.br/curso-excel.php" />
<meta property="og:title" content="Curso Excel do zero ao avançado — Preparatório MO-210 e MO-211" />
<meta property="og:description" content="17 módulos, 68 aulas com teoria completa, imagens oficiais e áudio, avaliações em todos os módulos, 2 simulados finais e certificado. Com Clariston Santos." />
<meta property="og:image" content="https://techsantos.com.br/assets/img/curso-excel/m09/procx-basico.jpg" />
<meta name="twitter:card" content="summary_large_image" />
<link rel="icon" type="image/png" href="assets/img/favicon-32.png" />
<link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png" />
<link rel="stylesheet" href="assets/css/style.css" />
<?php require_once __DIR__ . '/inc/meta-pixel.php'; ?>
<?php require_once __DIR__ . '/inc/google-analytics.php'; ?>
<?php if ($precoCentavos): ?>
<script>
fbq('track', 'ViewContent', {content_name: 'Curso Excel do zero ao avançado', currency: 'BRL', value: <?= json_encode(round($precoCentavos / 100, 2)) ?>});
</script>
<?php endif; ?>
<style>
  .fab-shot { margin: 2rem auto 0; max-width: 900px; border-radius: 12px; overflow: hidden; border: 1px solid rgba(255,255,255,.12); }
  .fab-shot img { display: block; width: 100%; height: auto; }
  .exam-row { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.25rem; }
  @media (max-width: 760px) { .exam-row { grid-template-columns: 1fr; } }
  .exam-card { border: 1px solid var(--line); border-radius: 12px; padding: 1.5rem; background: var(--surface); }
  .exam-card .code { font: 700 1.6rem 'Plex Mono', monospace; color: var(--green-strong); }
  .exam-card h3 { margin: .25rem 0 .75rem; }
  .exam-card ul { margin: 0; padding-left: 1.1rem; color: var(--ink-soft); display: grid; gap: .35rem; }
  .honest-note { max-width: 760px; margin: 1.5rem auto 0; padding: 1rem 1.25rem; border-left: 4px solid var(--green); background: var(--surface); border-radius: 8px; color: var(--ink-soft); font-size: .92rem; }
</style>
</head>
<body>

<header class="site">
  <div class="nav-row">
    <a class="brand" href="/">
      <img src="assets/img/logo.jpg" alt="Tech Santos BR" />
      <span>TECH <em>SANTOS BR</em></span>
    </a>
    <nav class="links">
      <a href="/">Home</a>
      <a href="sobre.html">Sobre</a>
      <a href="servicos.html">Serviços</a>
      <a href="treinamentos.html">Treinamentos</a>
      <a href="/curso-power-bi.php">Curso Power BI</a>
      <a href="/curso-microsoft-fabric.php">Curso Fabric</a>
      <a href="blog/index.php">Blog</a>
      <a href="contato.html">Contato</a>
      <a href="/login.php">Área do Aluno</a>
    </nav>
    <div class="nav-actions">
      <button class="nav-toggle" aria-label="Abrir menu" aria-expanded="false">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </button>
    </div>
  </div>
</header>

<main>
  <section class="hero page-hero">
    <div class="page-hero-inner">
      <div class="ead-banner">
        <span class="dot"></span>
        <span>Curso 100% EAD — <strong>acesso imediato</strong> após a confirmação do pagamento. Estude no seu ritmo, em português.</span>
      </div>
      <p class="eyebrow on-dark">Do zero ao avançado · Preparatório MO-210 e MO-211</p>
      <h1>Domine o <em>Excel</em> de verdade — e prepare-se para as certificações da Microsoft.</h1>
      <p class="lead">Da primeira planilha às tabelas dinâmicas, PROCX, matrizes dinâmicas, análise de hipóteses e macros, no Excel do Microsoft 365 em português — com o conteúdo mapeado habilidade por habilidade nas provas Excel Associate e Excel Expert.</p>
      <?php if ($precoFormatado): ?>
      <div class="hero-offer" aria-label="Oferta do curso">
        <strong>R$ <?= $precoFormatado ?></strong>
        <span>à vista · cartão em até 12x ou Pix · acesso vitalício</span>
      </div>
      <?php endif; ?>
      <div class="hero-cta">
        <a class="btn btn-primary" href="<?= $urlCompra ?>" data-course-cta="excel_hero_buy">Começar agora<?= $precoFormatado ? ' por R$ ' . $precoFormatado : '' ?></a>
        <a class="btn btn-ghost" href="#curriculo" data-course-cta="excel_hero_curriculum">Ver o currículo</a>
      </div>
      <p class="hero-assurance">Acesso imediato · suporte direto com o instrutor · garantia de satisfação</p>
      <div class="kpi-row">
        <div class="kpi-tile"><div class="kpi-num">68</div><div class="kpi-label">aulas com teoria completa, em 17 módulos</div></div>
        <div class="kpi-tile"><div class="kpi-num">5h30</div><div class="kpi-label">de áudio: cada aula também em modo podcast</div></div>
        <div class="kpi-tile"><div class="kpi-num">208</div><div class="kpi-label">questões: avaliação em cada módulo e 2 simulados finais</div></div>
        <div class="kpi-tile"><div class="kpi-num">120+</div><div class="kpi-label">imagens oficiais da documentação da Microsoft</div></div>
      </div>
      <div class="fab-shot"><img src="/assets/img/curso-excel/m09/procx-basico.jpg" alt="PROCX devolvendo o código de discagem de um país no Excel" loading="lazy"></div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="section-head">
        <p class="eyebrow">As duas certificações</p>
        <h2>Um curso, dois níveis de certificação Microsoft</h2>
        <p>O currículo foi montado a partir das listas oficiais de habilidades das provas Microsoft Office Specialist. Cada habilidade tem pelo menos uma aula, e cada aula termina com a seção “Como isso cai na prova”.</p>
      </div>
      <div class="exam-row">
        <div class="exam-card">
          <span class="code">MO-210</span>
          <h3>Excel Associate (Microsoft 365 Apps)</h3>
          <ul>
            <li>Planilhas e pastas de trabalho: navegação, exibição, impressão e formatos de arquivo</li>
            <li>Células e intervalos: formatação, formatos de número, nomes e formatação condicional</li>
            <li>Tabelas, classificação e filtros</li>
            <li>Fórmulas e funções: referências, SE, contagens e funções de texto</li>
            <li>Gráficos: criação, séries, elementos, estilos e acessibilidade</li>
          </ul>
        </div>
        <div class="exam-card">
          <span class="code">MO-211</span>
          <h3>Excel Expert (Microsoft 365 Apps)</h3>
          <ul>
            <li>Opções da pasta: macros, versões, cálculo e proteção</li>
            <li>Dados: Preenchimento Relâmpago, formatos personalizados, validação e regras condicionais</li>
            <li>Fórmulas avançadas: SES, SOMASES, LET, PROCX, ÍNDICE/CORRESP, datas, FILTRO, análise de hipóteses e auditoria</li>
            <li>Gráficos avançados, tabelas dinâmicas e gráficos dinâmicos</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <section style="background: var(--surface-2);">
    <div class="container">
      <div class="section-head">
        <p class="eyebrow">Para quem é este curso</p>
        <h2>Para quem usa Excel no trabalho — ou quer começar do jeito certo</h2>
        <p>Você não precisa saber nada de Excel. O curso começa pela interface e chega ao nível da prova Expert, na ordem em que as coisas se conectam.</p>
      </div>
      <div class="persona-row">
        <div class="persona-card">
          <span class="persona-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4z"/></svg></span>
          <h3>Iniciante</h3>
          <p>Nunca usou o Excel direito ou aprendeu sozinho, com lacunas. Aqui o caminho é do zero, sem pular etapas.</p>
        </div>
        <div class="persona-card">
          <span class="persona-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 10h18M9 4v16"/></svg></span>
          <h3>Profissional administrativo e financeiro</h3>
          <p>Passa o dia em planilhas e quer ganhar horas com PROCX, tabelas dinâmicas, validação e macros.</p>
        </div>
        <div class="persona-card">
          <span class="persona-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2L4 14h7l-1 8 9-12h-7l1-8z"/></svg></span>
          <h3>Quem busca emprego</h3>
          <p>Excel avançado aparece em quase toda vaga administrativa — e uma certificação Microsoft comprova o que você sabe.</p>
        </div>
        <div class="persona-card">
          <span class="persona-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="12" width="4" height="8"/><rect x="10" y="7" width="4" height="13"/><rect x="17" y="3" width="4" height="17"/></svg></span>
          <h3>Futuro analista de dados</h3>
          <p>O Excel é a base para Power BI e Fabric: Power Query, tabelas, modelagem e gráficos começam aqui.</p>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="section-head">
        <p class="eyebrow">Como o curso funciona</p>
        <h2>Leia, ouça, pratique e teste</h2>
      </div>
      <div class="proof-row">
        <div class="proof-card">
          <p class="proof-num">Texto</p>
          <p class="proof-t">teoria completa em cada aula, com as imagens oficiais da documentação da Microsoft e os nomes das funções em português e em inglês</p>
        </div>
        <div class="proof-card">
          <p class="proof-num">Áudio</p>
          <p class="proof-t">cada aula também em modo podcast, com velocidade ajustável — dá para revisar no trânsito</p>
        </div>
        <div class="proof-card">
          <p class="proof-num">Prática</p>
          <p class="proof-t">exemplos de fórmulas prontos para testar e um projeto final em formato de estudo de caso, com números de controle para conferir</p>
        </div>
        <div class="proof-card">
          <p class="proof-num">🎓</p>
          <p class="proof-t">avaliação em cada módulo, 2 simulados finais (MO-210 e MO-211) e certificado de conclusão verificável</p>
        </div>
      </div>
      <p class="honest-note"><strong>Sobre as videoaulas:</strong> o curso já está completo em texto, imagens e áudio. As videoaulas estão sendo gravadas e entram nas próprias aulas conforme ficam prontas, sem custo adicional para quem já é aluno.</p>
    </div>
  </section>

  <section id="curriculo" style="background: var(--surface-2);">
    <div class="container">
      <div class="section-head">
        <p class="eyebrow">Currículo completo</p>
        <h2>17 módulos + 2 simulados finais</h2>
        <p>Do zero ao nível Expert, com cada módulo construindo sobre o anterior.</p>
      </div>
      <div class="curriculum-modules">
        <details class="module" open>
          <summary>
            <div class="module-title"><span class="module-num">01</span><h3>Primeiros passos: a interface, as planilhas e os arquivos do Excel</h3></div>
            <div class="module-meta"><span>5 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Conhecendo o Excel: pasta de trabalho, planilha e célula</li>
              <li>Navegar e selecionar com rapidez (mouse e teclado)</li>
              <li>Organizar planilhas, linhas e colunas</li>
              <li>Modos de exibição, congelar painéis, janelas e Barra de Acesso Rápido</li>
              <li>Salvar, formatos de arquivo, propriedades e inspeção</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">02</span><h3>Inserir e editar dados com produtividade</h3></div>
            <div class="module-meta"><span>5 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Preenchimento Automático, séries e listas personalizadas</li>
              <li>Preenchimento Relâmpago: o Excel aprende pelo exemplo</li>
              <li>Recortar, copiar, colar e Colar Especial</li>
              <li>Inserir, excluir e mover células, linhas e colunas</li>
              <li>Localizar, Substituir, Ir para Especial e hiperlinks</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">03</span><h3>Formatação de células e planilhas</h3></div>
            <div class="module-meta"><span>4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Fonte, bordas, preenchimento, alinhamento e mesclagem</li>
              <li>Formatos de número: moeda, contábil, porcentagem, data e texto</li>
              <li>Formatos de número personalizados</li>
              <li>Estilos de célula, temas, Pincel de Formatação e Limpar</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">04</span><h3>Importar, limpar e validar dados</h3></div>
            <div class="module-meta"><span>4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Importar arquivos de texto e CSV</li>
              <li>Power Query no Excel: obter, transformar e atualizar</li>
              <li>Texto para Colunas e Remover Duplicatas</li>
              <li>Validação de dados e listas suspensas</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">05</span><h3>Tabelas do Excel, classificação e filtros</h3></div>
            <div class="module-meta"><span>4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Tabelas do Excel: criar, nomear e redimensionar</li>
              <li>Estilos de tabela, opções de estilo e Linha de Totais</li>
              <li>Classificar por várias colunas, por cor e por lista</li>
              <li>Filtros: AutoFiltro, filtros personalizados e Filtro Avançado</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">06</span><h3>Fórmulas, referências e nomes</h3></div>
            <div class="module-meta"><span>5 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Como uma fórmula funciona: operadores e ordem de cálculo</li>
              <li>Referências relativas, absolutas e mistas — e referências a outras planilhas e pastas</li>
              <li>Nomes definidos: dar nome a células, intervalos e constantes</li>
              <li>Referências estruturadas: fórmulas com nomes de tabela e coluna</li>
              <li>Funções essenciais: SOMA, MÉDIA, MÁXIMO, MÍNIMO e as contagens</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">07</span><h3>Funções lógicas e cálculos condicionais</h3></div>
            <div class="module-meta"><span>4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>A função SE e o tratamento de erros com SEERRO</li>
              <li>E, OU, NÃO, SES e PARÂMETRO</li>
              <li>Somar, contar e calcular com critérios: SOMASES, CONT.SES e companhia</li>
              <li>LET: variáveis dentro da fórmula</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">08</span><h3>Funções de texto e de data</h3></div>
            <div class="module-meta"><span>4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Extrair partes de um texto: ESQUERDA, DIREITA, EXT.TEXTO e companhia</li>
              <li>Limpar, padronizar e juntar textos: MAIÚSCULA, ARRUMAR, CONCAT, UNIRTEXTO e TEXTO</li>
              <li>Datas e horas: HOJE, AGORA, DATA, DIA.DA.SEMANA, FIMMÊS e DATADIF</li>
              <li>Dias úteis: DIATRABALHO e DIATRABALHOTOTAL</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">09</span><h3>Funções de procura e matrizes dinâmicas</h3></div>
            <div class="module-meta"><span>5 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>PROCX: a função de procura do Excel moderno</li>
              <li>PROCV e PROCH: ler, corrigir e manter fórmulas antigas</li>
              <li>ÍNDICE, CORRESP e CORRESPX</li>
              <li>Matrizes dinâmicas: FILTRO, CLASSIFICAR, CLASSIFICARPOR e ÚNICO</li>
              <li>SEQUÊNCIA e MATRIZALEATÓRIA</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">10</span><h3>Formatação condicional e minigráficos</h3></div>
            <div class="module-meta"><span>3 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Formatação condicional: as regras prontas</li>
              <li>Regras personalizadas, regras com fórmula e o Gerenciador de Regras</li>
              <li>Minigráficos: tendências dentro da célula</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">11</span><h3>Gráficos</h3></div>
            <div class="module-meta"><span>4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Criar gráficos e escolher o tipo certo</li>
              <li>Os dados do gráfico: séries, Selecionar Dados e Alternar Linha/Coluna</li>
              <li>Elementos, layouts, estilos e texto alternativo</li>
              <li>Gráficos avançados: combinação, eixo duplo, histograma, caixa estreita, cascata, funil, explosão solar e mapa</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">12</span><h3>Tabelas dinâmicas e gráficos dinâmicos</h3></div>
            <div class="module-meta"><span>4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Criar uma tabela dinâmica e organizar os campos</li>
              <li>Valores: resumir, Mostrar Valores Como e campos calculados</li>
              <li>Agrupar, filtrar, segmentar e formatar a tabela dinâmica</li>
              <li>Gráficos dinâmicos: criar, filtrar, estilizar e detalhar</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">13</span><h3>Análise de dados: subtotais, consolidação e análise de hipóteses</h3></div>
            <div class="module-meta"><span>4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Subtotais e estrutura de tópicos: agrupar e desagrupar</li>
              <li>Consolidar dados de várias planilhas</li>
              <li>Análise de hipóteses: Atingir Meta, Cenários, Tabela de Dados e Previsão</li>
              <li>Funções financeiras: PGTO, NPER, VP, VF e TAXA</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">14</span><h3>Auditoria de fórmulas, erros e opções de cálculo</h3></div>
            <div class="module-meta"><span>3 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Rastrear precedentes e dependentes, Janela de Inspeção e Avaliar Fórmula</li>
              <li>Os erros do Excel e a Verificação de Erros</li>
              <li>Opções de cálculo, recálculo manual e referências circulares</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">15</span><h3>Impressão, colaboração e proteção</h3></div>
            <div class="module-meta"><span>4 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Configurar a página: margens, orientação, área de impressão, títulos e escala</li>
              <li>Cabeçalho, rodapé e as configurações de impressão</li>
              <li>Comentários, anotações, coautoria e versões</li>
              <li>Proteger planilhas, intervalos, estrutura e arquivo</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">16</span><h3>Macros: gravar, editar e usar com segurança</h3></div>
            <div class="module-meta"><span>3 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Gravar e executar macros</li>
              <li>Editar macros no Editor do VBA e copiar macros entre pastas</li>
              <li>Segurança de macros: habilitar com critério</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">17</span><h3>Projeto final e guia das provas MOS</h3></div>
            <div class="module-meta"><span>3 aulas</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Projeto final: o relatório comercial da Papelaria Serra Dourada</li>
              <li>Projeto final: resolução comentada</li>
              <li>Guia das provas MO-210 e MO-211: formato, estratégia e revisão final</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">🎓</span><h3>Simulado final · MO-210 (Excel Associate)</h3></div>
            <div class="module-meta"><span>1 aula</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Como fazer o simulado MO-210</li>
            </ul>
          </div>
        </details>
        <details class="module">
          <summary>
            <div class="module-title"><span class="module-num">🎓</span><h3>Simulado final · MO-211 (Excel Expert)</h3></div>
            <div class="module-meta"><span>1 aula</span>
              <svg class="module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </summary>
          <div class="module-body">
            <ul class="topic-list">
              <li>Como fazer o simulado MO-211</li>
            </ul>
          </div>
        </details>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="section-head">
        <p class="eyebrow">Instrutor</p>
        <h2>Quem ensina</h2>
      </div>
      <div class="instructor-panel">
        <div class="instructor-avatar">CS</div>
        <div>
          <p><strong style="color: var(--ink);">Clariston Santos</strong> é analista de Business Intelligence, fundador da TECH SANTOS BR e instrutor certificado pela Microsoft, com mais de 50 projetos de BI implementados. Escreveu este curso a partir da documentação oficial do Excel e das listas de habilidades das provas MO-210 e MO-211.</p>
        </div>
      </div>
    </div>
  </section>

  <section style="background: var(--surface-2);">
    <div class="container">
      <div class="section-head">
        <p class="eyebrow">Dúvidas frequentes</p>
        <h2>Perguntas que a gente mais recebe</h2>
      </div>
      <div class="faq-list">
        <div class="faq-item">
          <h3>Preciso saber alguma coisa de Excel?</h3>
          <p>Não. O primeiro módulo começa pela interface: pasta de trabalho, planilha, célula e navegação. Quem já usa Excel pode avançar mais rápido pelos primeiros módulos.</p>
        </div>
        <div class="faq-item">
          <h3>Qual versão do Excel eu preciso?</h3>
          <p>O curso usa o Excel do Microsoft 365 para Windows, em português, que é a versão cobrada nas provas MO-210 e MO-211. Quase tudo funciona no Excel 2021 e 2024; recursos exclusivos do Microsoft 365 (como matrizes dinâmicas e PROCX, que também existem no 2021) são indicados nas aulas.</p>
        </div>
        <div class="faq-item">
          <h3>O curso tem vídeo?</h3>
          <p>O conteúdo completo está em texto com imagens oficiais e em áudio (modo podcast) em todas as aulas. As videoaulas estão sendo gravadas e entram no curso conforme ficam prontas, sem custo extra para quem já é aluno.</p>
        </div>
        <div class="faq-item">
          <h3>A prova está incluída?</h3>
          <p>Não. As provas Microsoft Office Specialist são agendadas e pagas diretamente pela Certiport, parceira da Microsoft. A MO-210 tem versão em português; a MO-211 é aplicada em inglês — por isso as aulas trazem também o nome de cada função e recurso em inglês. O curso emite o certificado de conclusão da TECH SANTOS BR.</p>
        </div>
        <div class="faq-item">
          <h3>O curso é suficiente para passar nas provas?</h3>
          <p>O conteúdo cobre todas as habilidades das listas oficiais das duas provas, com avaliações e simulados. As provas oficiais são práticas (você executa tarefas no Excel), então recomendamos refazer no Excel as tarefas das seções “Como isso cai na prova” antes de agendar.</p>
        </div>
        <div class="faq-item">
          <h3>Por quanto tempo tenho acesso?</h3>
          <p>Acesso vitalício, incluindo as atualizações do conteúdo e as videoaulas que forem adicionadas.</p>
        </div>
        <div class="faq-item">
          <h3>Já sou aluno de outro curso. Como compro?</h3>
          <p>Entre na Área do Aluno: o curso de Excel aparece em “Outros cursos”, com compra direta. Depois do pagamento ele aparece junto do seu curso atual, com o mesmo login.</p>
        </div>
        <div class="faq-item">
          <h3>Quais as formas de pagamento?</h3>
          <p>Cartão de crédito (à vista ou em até 12x) ou Pix, pelo checkout do Mercado Pago.</p>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="pricing-cta">
        <div class="pricing-cta-inner">
          <p class="eyebrow on-dark">Matricule-se agora</p>
          <h2>Comece hoje, no seu ritmo</h2>
          <p class="lead">Acesso liberado automaticamente após a confirmação do pagamento.</p>
          <?php if ($precoFormatado): ?>
          <p class="price">R$ <?= $precoFormatado ?><small>à vista ou parcelado em até 12x no cartão · acesso vitalício</small></p>
          <?php endif; ?>
          <div class="hero-cta">
            <a class="btn btn-primary" href="<?= $urlCompra ?>" data-course-cta="excel_final_buy">Começar agora</a>
            <a class="btn btn-ghost" href="https://wa.me/5564992905785?text=<?= $whatsMsg ?>" target="_blank" rel="noopener">Tirar dúvida no WhatsApp</a>
          </div>
          <p class="hero-assurance">Garantia: mediante solicitação, se você concluiu menos de 20% do curso e não gostou, devolvemos 100% do valor.</p>
        </div>
      </div>
    </div>
  </section>
</main>

<footer class="site footer-wide">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <a class="brand" href="/">
          <img src="assets/img/logo.jpg" alt="Tech Santos BR" />
          <span>TECH <em>SANTOS BR</em></span>
        </a>
        <p>Consultoria e treinamento em Power BI, Microsoft Fabric e Excel, com mais de 50 projetos de BI implementados. Itumbiara-GO, atendimento para todo o Brasil.</p>
      </div>
      <div class="footer-col">
        <h4>Cursos</h4>
        <a href="/curso-excel.php">Excel do zero ao avançado (MO-210 e MO-211)</a>
        <a href="/curso-microsoft-fabric.php">Microsoft Fabric (DP-600 e DP-700)</a>
        <a href="/curso-power-bi.php">Curso completo de Power BI</a>
        <a href="/login.php">Área do Aluno</a>
      </div>
      <div class="footer-col">
        <h4>Empresa</h4>
        <a href="/sobre.html">Sobre</a>
        <a href="/servicos.html">Serviços</a>
        <a href="/treinamentos.html">Treinamentos</a>
        <a href="/blog/">Blog</a>
      </div>
      <div class="footer-col">
        <h4>Contato</h4>
        <a href="mailto:claristonsantos@techsantos.com.br">claristonsantos@techsantos.com.br</a>
        <a href="https://wa.me/5564992905785" target="_blank" rel="noopener">(64) 99290-5785</a>
        <span>Itumbiara-GO</span>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© 2026 TECH SANTOS BR Treinamentos e Aulas Particulares · CNPJ 41.135.509/0001-29 · Simples Nacional</span>
    </div>
  </div>
</footer>
<script src="assets/js/nav.js"></script>
</body>
</html>
