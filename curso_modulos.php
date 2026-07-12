<?php
declare(strict_types=1);

const MODULOS_POWER_BI = [
    'modelagem' => 'Módulo 01 · Fundamentos de Modelagem de Dados',
    'perfil-dados' => 'Módulo 02 · Perfil dos Dados',
    'power-query-conectar' => 'Módulo 03 · Power Query — Conectando e Importando Dados',
    'power-query-transformar' => 'Módulo 04 · Power Query — Transformação e Limpeza de Dados',
    'otimizacao' => 'Módulo 05 · Modelo de Dados & Otimização de Desempenho',
    'labs-power-query' => 'Módulo 06 · Laboratórios Práticos de Power Query',
    'dax' => 'Módulo 07 · Fórmulas DAX',
    'relatorios' => 'Módulo 08 · Criar e Enriquecer Relatórios',
    'analise-avancada' => 'Módulo 09 · Análise Avançada & Insights de IA',
    'dashboards-governanca' => 'Módulo 10 · Dashboards, Publicação & Governança',
    'encerramento' => 'Avaliação final (Módulo 11 · Encerramento)',
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
