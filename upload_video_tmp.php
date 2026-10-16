<?php
declare(strict_types=1);
// Receptor temporário de vídeos das aulas: grava em pedaços em ../private-videos/<id>.mp4
// (fora do public_html), confere tamanho e SHA-256 no fim. Apaga a si mesmo com acao=fim.
require_once __DIR__ . '/config.php';
header('Content-Type: text/plain; charset=utf-8');
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }

$PERMITIDOS = ['fab-o-que-e-fabric', 'fab-licencas-capacidades', 'fab-tenant-workspace-itens', 'fab-dominios', 'fab-config-workspace', 'fab-descobrir-dados', 'fab-escolher-armazenamento', 'fab-onelake', 'fab-delta-parquet', 'fab-atalhos', 'fab-espelhamento', 'fab-onelake-seguranca', 'fab-onelake-integracoes', 'fab-lakehouse', 'fab-carregar-lakehouse', 'fab-endpoint-sql', 'fab-medalhao', 'fab-modelo-dimensional', 'fab-carga-dimensional', 'fab-manutencao-delta', 'fab-data-factory-visao', 'fab-pipeline-atividades', 'fab-copy', 'fab-parametros-expressoes', 'fab-agendas-gatilhos', 'fab-carga-incremental', 'fab-escolher-ferramenta', 'fab-dataflow-gen2', 'fab-dataflow-transformacoes', 'fab-dataflow-qualidade', 'fab-dataflow-destinos', 'fab-dataflow-desempenho', 'fab-editor-consultas-visuais', 'fab-dataflow-monitorar-erros', 'fab-spark-notebooks', 'fab-pyspark-transformar', 'fab-spark-qualidade-merge', 'fab-spark-orquestrar', 'fab-streaming-estruturado', 'fab-spark-monitorar-otimizar', 'fab-warehouse-visao', 'fab-warehouse-ingestao', 'fab-tsql-consultas', 'fab-tsql-objetos', 'fab-warehouse-recuperacao', 'fab-warehouse-desempenho', 'fab-rti-visao', 'fab-eventstream', 'fab-eventhouse', 'fab-kql-consultas', 'fab-kql-transformar', 'fab-rti-acoes-monitorar', 'fab-modelo-semantico-visao', 'fab-modelo-estrela', 'fab-modelo-relacoes', 'fab-modelo-grupos-calculo', 'fab-modelo-composto-grande', 'fab-dax-contextos', 'fab-dax-filtros', 'fab-dax-iteradores-janelas', 'fab-dax-informacao', 'fab-dax-consultas', 'fab-direct-lake', 'fab-direct-lake-fallback', 'fab-atualizacao-incremental-modelo', 'fab-otimizar-relatorios-dax', 'fab-seg-workspace-item', 'fab-seg-sql', 'fab-seg-modelo', 'fab-governanca', 'fab-git', 'fab-pipelines-implantacao', 'fab-pbip-projetos', 'fab-xmla-reutilizaveis', 'fab-monitorar', 'fab-monitorar-modelo', 'fab-capacidade', 'fab-erros-otimizacao', 'fab-projeto-final', 'fab-guia-provas', 'fab-simulado-dp600-instrucoes', 'fab-simulado-dp700-instrucoes', 'xl-conhecendo-excel', 'xl-navegar-selecionar', 'xl-planilhas-linhas-colunas', 'xl-exibicao-janelas', 'xl-salvar-formatos', 'xl-preenchimento-series', 'xl-preenchimento-relampago', 'xl-copiar-colar-especial', 'xl-inserir-mover-celulas', 'xl-localizar-substituir-links', 'xl-fonte-alinhamento', 'xl-formatos-numero', 'xl-formatos-personalizados', 'xl-estilos-pincel-limpar', 'xl-importar-txt-csv', 'xl-power-query-basico', 'xl-texto-colunas-duplicatas', 'xl-validacao-dados', 'xl-tabelas-criar', 'xl-tabelas-estilos-totais', 'xl-classificar', 'xl-filtrar', 'xl-formulas-basico', 'xl-referencias', 'xl-nomes-definidos', 'xl-referencias-estruturadas', 'xl-funcoes-basicas', 'xl-funcao-se', 'xl-e-ou-ses-parametro', 'xl-agregacoes-condicionais', 'xl-funcao-let', 'xl-texto-extrair', 'xl-texto-limpar-juntar', 'xl-funcoes-data', 'xl-dias-uteis', 'xl-procx', 'xl-procv-proch', 'xl-indice-corresp', 'xl-matrizes-dinamicas', 'xl-sequencia-aleatoria', 'xl-formatacao-condicional', 'xl-formatacao-condicional-regras', 'xl-minigraficos', 'xl-graficos-criar', 'xl-graficos-dados', 'xl-graficos-elementos', 'xl-graficos-avancados', 'xl-tabela-dinamica-criar', 'xl-tabela-dinamica-valores', 'xl-tabela-dinamica-organizar', 'xl-grafico-dinamico', 'xl-subtotais-estrutura', 'xl-consolidar', 'xl-analise-hipoteses', 'xl-funcoes-financeiras', 'xl-auditoria', 'xl-erros-formulas', 'xl-calculo-circular', 'xl-configurar-pagina', 'xl-cabecalho-imprimir', 'xl-colaboracao-versoes', 'xl-proteger', 'xl-macros-gravar', 'xl-macros-editar', 'xl-macros-seguranca', 'xl-projeto-final', 'xl-projeto-resolucao', 'xl-guia-provas', 'xl-simulado-mo210-instrucoes', 'xl-simulado-mo211-instrucoes'];
$dir = dirname(__DIR__) . '/private-videos';
$acao = $_GET['acao'] ?? '';

if ($acao === 'fim') { @unlink(__FILE__); exit("REMOVIDO\n"); }

$id = $_GET['id'] ?? '';
if (!in_array($id, $PERMITIDOS, true)) { http_response_code(400); exit('id invalido'); }
if (!is_dir($dir)) { http_response_code(500); exit('sem private-videos'); }
$part = "$dir/$id.mp4.part";
$final = "$dir/$id.mp4";

if ($acao === 'chunk') {
    $offset = (int)($_GET['offset'] ?? -1);
    $atual = is_file($part) ? filesize($part) : 0;
    if ($offset === 0 && $atual > 0) { unlink($part); $atual = 0; }
    if ($offset !== $atual) { http_response_code(409); exit("offset $atual"); }
    $in = fopen('php://input', 'rb'); $out = fopen($part, 'ab');
    $n = stream_copy_to_stream($in, $out); fclose($in); fclose($out);
    clearstatcache();
    exit('OK ' . filesize($part) . " (+$n)\n");
}
if ($acao === 'concluir') {
    $tam = (int)($_GET['tamanho'] ?? -1); $sha = strtolower((string)($_GET['sha256'] ?? ''));
    if (!is_file($part)) { http_response_code(404); exit('sem parte'); }
    clearstatcache();
    if (filesize($part) !== $tam) { http_response_code(409); exit('tamanho ' . filesize($part)); }
    if (hash_file('sha256', $part) !== $sha) { http_response_code(409); exit('sha diferente'); }
    rename($part, $final);
    exit("PUBLICADO $id " . filesize($final) . "\n");
}
if ($acao === 'listar') {
    foreach ($PERMITIDOS as $p) echo $p, ' ', is_file("$dir/$p.mp4") ? filesize("$dir/$p.mp4") : '-', "\n";
    exit;
}
http_response_code(400); echo 'acao?';
