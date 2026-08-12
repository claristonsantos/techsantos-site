<?php
declare(strict_types=1);

/** Mapa canônico das lições exigidas antes de cada avaliação. */
const LICOES_POR_MODULO_POWER_BI = [
    'modelagem' => ['apresentacao-curso', 'introducao', 'checklist-projeto-power-bi', 'normalizacao-desnormalizacao', 'modelagem-pratica', 'granularidade-sem-duplicidade', 'esquema-estrela', 'relacionamentos-cardinalidade-filtros', 'importancia-modelagem'],
    'perfil-dados' => ['perfil-dos-dados', 'checklist-qualidade-dados'],
    'power-query-conectar' => ['criando-consulta', 'intro-power-query', 'tipos-de-dados', 'tabela-ou-intervalo', 'importar-excel', 'consulta-pasta', 'consulta-pasta-sharepoint'],
    'power-query-transformar' => ['preenchimento-colunas', 'dividir-colunas', 'dividir-linhas', 'colunas-personalizadas', 'coluna-exemplo', 'mesclar-colunas', 'classificar-filtrar', 'formula-if', 'formula-if-and', 'formula-adddays', 'formulas-texto', 'coluna-dinamica', 'transformar-colunas-linhas', 'agrupar-por', 'acrescentar-consultas-1', 'acrescentar-consultas-2', 'mesclar-consultas', 'boas-praticas-power-query'],
    'labs-power-query' => ['desafio-vendas-2025'],
    'otimizacao' => ['otimizar-modelo', 'modos-armazenamento', 'modelo-semantico-profissional'],
    'dax' => ['dax-sintaxe-medidas', 'dax-contexto-modelo', 'contextos-dax', 'dax-colunas-medidas-matematica', 'dax-logica-erros-texto', 'dax-calculate-filter', 'padroes-medidas-dax', 'dax-tabelas-tempo', 'validar-medidas-dax'],
    'relatorios' => ['construindo-visualizacoes', 'escolher-grafico-correto', 'enriquecendo-relatorios', 'storytelling-hierarquia-visual'],
    'analise-avancada' => ['explorando-dados', 'insights-ia'],
    'lab-dax-dataviz' => ['lab-dashboard-comercial'],
    'dashboards-governanca' => ['workspaces-apps', 'criar-dashboards', 'implantar-manter', 'checklist-publicacao-profissional'],
    'exercicio-guiado-tsbr' => ['exercicio-basico', 'exercicio-final'],
    'encerramento' => ['conclusao-curso'],
];

function licoes_pendentes_modulo(PDO $pdo, int $alunoId, string $moduloId): array
{
    $exigidas = LICOES_POR_MODULO_POWER_BI[$moduloId] ?? [];
    if (!$exigidas) return [];
    $placeholders = implode(',', array_fill(0, count($exigidas), '?'));
    $stmt = $pdo->prepare("SELECT licao_id FROM progresso WHERE aluno_id = ? AND licao_id IN ($placeholders)");
    $stmt->execute(array_merge([$alunoId], $exigidas));
    $concluidas = array_flip($stmt->fetchAll(PDO::FETCH_COLUMN));
    return array_values(array_filter($exigidas, static fn(string $id): bool => !isset($concluidas[$id])));
}
