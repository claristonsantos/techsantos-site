<?php
declare(strict_types=1);

const MODULOS_POWER_BI = [
    'modelagem' => 'Módulo 01 · Fundamentos de Modelagem de Dados',
    'perfil-dados' => 'Módulo 02 · Perfil dos Dados',
    'power-query-conectar' => 'Módulo 03 · Power Query — Conectando e Importando Dados',
    'power-query-transformar' => 'Módulo 04 · Power Query — Transformação e Limpeza de Dados',
    'labs-power-query' => 'Módulo 05 · Laboratórios Práticos de Power Query',
    'otimizacao' => 'Módulo 06 · Modelo de Dados & Otimização de Desempenho',
    'dax' => 'Módulo 07 · Fórmulas DAX',
    'relatorios' => 'Módulo 08 · Criar e Enriquecer Relatórios',
    'analise-avancada' => 'Módulo 09 · Análise Avançada & Insights de IA',
    'lab-dax-dataviz' => 'Módulo 10 · Laboratório Prático — DAX e DataViz',
    'dashboards-governanca' => 'Módulo 11 · Dashboards, Publicação & Governança',
    'exercicio-guiado-tsbr' => 'Módulo 12 · Estudo de Caso Final — Construa Seu Relatório do Zero',
    'encerramento' => 'Módulo 13 · Encerramento & Avaliação Final',
];

// Avaliações que precisam estar aprovadas para emitir o certificado, por curso.
// O certificado sai quando o aluno passa na última delas que faltava.
const CERTIFICADO_AVALIACOES = [
    'power-bi' => ['encerramento'],
    'microsoft-fabric' => ['fab-simulado-dp600', 'fab-simulado-dp700'],
    'excel' => ['xl-simulado-mo210', 'xl-simulado-mo211'],
    'ingles' => ['en-m17'],
    'python' => ['py-m14'],
];

/*
 * Módulos de cada curso (id => título), lidos do mesmo arquivo de conteúdo que
 * a área do aluno usa (assets/js/course-data*.js). O id do módulo é o mesmo
 * gravado em avaliacoes.modulo_id. Só as linhas de módulo (recuo de 4 espaços)
 * casam; as aulas ficam mais recuadas.
 */
const CURSO_DADOS_ARQUIVO = [
    'power-bi' => 'course-data.js',
    'excel' => 'course-data-excel.js',
    'python' => 'course-data-python.js',
    'ingles' => 'course-data-ingles.js',
    'microsoft-fabric' => 'course-data-microsoft-fabric.js',
];

function modulos_do_curso(string $cursoSlug): array
{
    static $cache = [];
    if (isset($cache[$cursoSlug])) return $cache[$cursoSlug];
    $mods = [];
    $arq = CURSO_DADOS_ARQUIVO[$cursoSlug] ?? null;
    $src = $arq ? @file_get_contents(__DIR__ . '/assets/js/' . $arq) : false;
    if ($src !== false && preg_match_all("/^    id: '([a-z0-9-]+)', title: '((?:[^'\\\\]|\\\\.)*)', kind:/m", $src, $m, PREG_SET_ORDER)) {
        foreach ($m as $x) $mods[$x[1]] = stripslashes($x[2]);
    }
    if (!$mods && $cursoSlug === 'power-bi') $mods = MODULOS_POWER_BI;
    return $cache[$cursoSlug] = $mods;
}

function avaliacoes_do_certificado(string $cursoSlug): array
{
    return CERTIFICADO_AVALIACOES[$cursoSlug] ?? [];
}

function modulo_anterior(string $moduloId): ?string
{
    $ids = array_keys(MODULOS_POWER_BI);
    $idx = array_search($moduloId, $ids, true);
    if ($idx === false || $idx === 0) {
        return null;
    }
    return $ids[$idx - 1];
}

function modulo_seguinte(string $moduloId, string $cursoSlug = 'power-bi'): ?string
{
    $ids = array_keys(modulos_do_curso($cursoSlug) ?: MODULOS_POWER_BI);
    $idx = array_search($moduloId, $ids, true);
    if ($idx === false || $idx === count($ids) - 1) {
        return null;
    }
    return $ids[$idx + 1];
}
