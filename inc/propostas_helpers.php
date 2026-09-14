<?php
declare(strict_types=1);

function proposta_item_total(array $item): float
{
    return ((float)($item['horas'] ?? 0)) * ((float)($item['valor_hora'] ?? 0));
}

function proposta_itens_total(array $itens): float
{
    $total = 0.0;
    foreach ($itens as $item) {
        $total += proposta_item_total($item);
    }
    return $total;
}

function proposta_fmt_moeda(float $v, string $moeda): string
{
    return $moeda === 'BRL' ? 'R$ ' . number_format($v, 2, ',', '.') : '$' . number_format($v, 2, ',', '.') . ' USD';
}

// Converte um total na moeda nativa da proposta para equivalente em real.
// BRL passa direto, sem conversão — só dólar usa a cotação do Banco Central.
function proposta_total_em_brl(float $totalNativo, string $moeda, float $cotacaoValor): float
{
    return $moeda === 'BRL' ? $totalNativo : $totalNativo * $cotacaoValor;
}

// Curso e aulas particulares pedem outro vocabulário no formulário e no PDF
// (ementa/carga horária em vez de escopo técnico de projeto de BI) — pesquisa
// rápida em modelos de proposta de treinamento/aula particular confirmou os
// campos padrão do setor: conteúdo programático, público-alvo, modalidade.
function proposta_natureza_labels(string $natureza): array
{
    $mapas = [
        'curso' => [
            'projeto' => 'Nome do curso',
            'projeto_placeholder' => 'Ex.: Power BI Completo',
            'formato' => 'Modalidade do curso',
            'formato_placeholder' => 'Ex.: Online ao vivo, gravado, presencial',
            'escopo' => 'Conteúdo programático / Ementa',
            'objetivo' => 'Público-alvo e pré-requisitos',
            'item_placeholder' => 'Ex.: Curso completo de Power BI',
        ],
        'aulas' => [
            'projeto' => 'Assunto das aulas',
            'projeto_placeholder' => 'Ex.: Power BI para análise financeira',
            'formato' => 'Modalidade das aulas',
            'formato_placeholder' => 'Ex.: Online, individual, pacote de horas',
            'escopo' => 'Temas e objetivos das aulas',
            'objetivo' => 'Frequência e duração combinada',
            'item_placeholder' => 'Ex.: Aula particular de Power BI',
        ],
    ];
    $default = [
        'projeto' => 'Nome do projeto',
        'projeto_placeholder' => 'Ex.: Automação DRE e fluxo de caixa',
        'formato' => 'Formato / tecnologia',
        'formato_placeholder' => 'Ex.: Excel, Power BI, Python',
        'escopo' => 'Escopo',
        'objetivo' => 'Objetivo',
        'item_placeholder' => 'Ex.: ETL - tratamento dos dados',
    ];
    return $mapas[$natureza] ?? $default;
}
