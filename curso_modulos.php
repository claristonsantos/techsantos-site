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

function modulo_anterior(string $moduloId): ?string
{
    $ids = array_keys(MODULOS_POWER_BI);
    $idx = array_search($moduloId, $ids, true);
    if ($idx === false || $idx === 0) {
        return null;
    }
    return $ids[$idx - 1];
}

function modulo_seguinte(string $moduloId): ?string
{
    $ids = array_keys(MODULOS_POWER_BI);
    $idx = array_search($moduloId, $ids, true);
    if ($idx === false || $idx === count($ids) - 1) {
        return null;
    }
    return $ids[$idx + 1];
}
