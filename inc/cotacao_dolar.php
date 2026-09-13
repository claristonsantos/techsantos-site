<?php
declare(strict_types=1);

// Cotação PTAX (venda) do Banco Central, com cache de 1 dia em `cotacoes_dolar`.
// Se o BCB estiver fora do ar e não houver cotação nenhuma em cache, retorna
// valor 0.0 — quem chama deve tratar esse caso (esconder a conversão em BRL
// em vez de mostrar R$ 0,00).
function cotacao_dolar_bcb(PDO $pdo): array
{
    $hoje = date('Y-m-d');
    $stmt = $pdo->prepare('SELECT valor, data FROM cotacoes_dolar WHERE data = ?');
    $stmt->execute([$hoje]);
    $row = $stmt->fetch();
    if ($row) {
        return ['valor' => (float)$row['valor'], 'data' => $row['data']];
    }

    $valor = null;
    $dataCotacao = null;
    $inicio = date('m-d-Y', strtotime('-10 days'));
    $fim = date('m-d-Y');
    $url = "https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial='{$inicio}',dataFinalCotacao='{$fim}')?\$top=1&\$format=json&\$orderby=dataHoraCotacao%20desc";

    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 6,
            CURLOPT_HTTPHEADER => ['Accept: application/json'],
        ]);
        $resp = curl_exec($ch);
        curl_close($ch);
    } else {
        $ctx = stream_context_create(['http' => ['timeout' => 6]]);
        $resp = @file_get_contents($url, false, $ctx);
    }

    if ($resp) {
        $json = json_decode($resp, true);
        $item = $json['value'][0] ?? null;
        if ($item && isset($item['cotacaoVenda'])) {
            $valor = (float)$item['cotacaoVenda'];
            $dataCotacao = substr((string)($item['dataHoraCotacao'] ?? ''), 0, 10) ?: $hoje;
        }
    }

    if ($valor !== null && $valor > 0) {
        $pdo->prepare('INSERT INTO cotacoes_dolar (data, valor) VALUES (?, ?) ON DUPLICATE KEY UPDATE valor = VALUES(valor)')
            ->execute([$hoje, $valor]);
        return ['valor' => $valor, 'data' => $dataCotacao];
    }

    $fallback = $pdo->query('SELECT valor, data FROM cotacoes_dolar ORDER BY data DESC LIMIT 1')->fetch();
    if ($fallback) {
        return ['valor' => (float)$fallback['valor'], 'data' => $fallback['data']];
    }

    return ['valor' => 0.0, 'data' => null];
}
