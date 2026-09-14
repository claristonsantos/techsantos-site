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
