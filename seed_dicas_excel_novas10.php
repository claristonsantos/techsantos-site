<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$out = [];

$ins = $pdo->prepare(
    "INSERT INTO social_posts (canal, tipo, midia_tipo, legenda, imagem_url, agendado_para, status)
     SELECT ?, ?, ?, ?, ?, ?, 'pendente'
     WHERE NOT EXISTS (
         SELECT 1 FROM social_posts
         WHERE canal = 'instagram' AND tipo = 'reels' AND imagem_url = ? AND agendado_para = ?
     )"
);

function queue_instagram_reel(PDOStatement $ins, string $videoUrl, string $legenda, string $agendadoParaUtc, array &$out): void
{
    $ins->execute(['instagram', 'reels', 'video', $legenda, $videoUrl, $agendadoParaUtc, $videoUrl, $agendadoParaUtc]);
    $out[] = $ins->rowCount() > 0
        ? "Enfileirado reel: {$videoUrl} para {$agendadoParaUtc} UTC"
        : "Ignorado (já existia): {$videoUrl} para {$agendadoParaUtc} UTC";
}

// Ter 12/08 10h BRT = 13h UTC
queue_instagram_reel(
    $ins,
    'https://media.techsantos.com.br/reels/dica-excel-flashfill.mp4',
    "Você ainda digita nome e sobrenome separados, célula por célula?\n\nTem um atalho que preenche o resto sozinho: digite o primeiro exemplo do jeito que quer o resultado, selecione a coluna, e aperta Ctrl+E.\n\nChama Preenchimento Relâmpago — funciona pra juntar, separar ou extrair texto.\n\nMais dicas assim: link na bio.",
    '2026-08-12 13:00:00', $out
);

// Qui 13/08 20h BRT = 23h UTC
queue_instagram_reel(
    $ins,
    'https://media.techsantos.com.br/reels/dica-excel-condicional.mp4',
    "Sua planilha tem status importante mas você lê linha por linha pra achar?\n\nSeleciona a tabela, Formatação Condicional → Nova Regra → Usar fórmula. Uma fórmula com cifrão trava a coluna e colore a linha inteira.\n\nMais dicas assim: link na bio.",
    '2026-08-13 23:00:00', $out
);

// Ter 18/08 10h BRT = 13h UTC
queue_instagram_reel(
    $ins,
    'https://media.techsantos.com.br/reels/dica-excel-f4.mp4',
    "Formatou uma célula e precisa repetir em mais dez?\n\nAperta F4 e o Excel repete o último comando sozinho. Dentro de uma fórmula, F4 trava a referência com cifrão.\n\nUm atalho, dois usos. Mais dicas assim: link na bio.",
    '2026-08-18 13:00:00', $out
);

// Qua 19/08 20h BRT = 23h UTC
queue_instagram_reel(
    $ins,
    'https://media.techsantos.com.br/reels/dica-excel-duplicados.mp4',
    "Cliente cadastrado duas vezes na sua base?\n\nSeleciona a tabela, Dados → Remover Duplicados, escolhe as colunas que definem duplicado, e pronto.\n\nMais dicas assim: link na bio.",
    '2026-08-19 23:00:00', $out
);

// Qui 20/08 10h BRT = 13h UTC
queue_instagram_reel(
    $ins,
    'https://media.techsantos.com.br/reels/dica-excel-selecaorapida.mp4',
    "Ainda clica na letra da coluna pra selecionar ela inteira?\n\nCtrl+Espaço seleciona a coluna. Shift+Espaço seleciona a linha. Sem tirar a mão do teclado.\n\nMais dicas assim: link na bio.",
    '2026-08-20 13:00:00', $out
);

// Ter 25/08 20h BRT = 23h UTC
queue_instagram_reel(
    $ins,
    'https://media.techsantos.com.br/reels/dica-excel-seerro.mp4',
    "Fórmula quebrada cheia de #DIV/0! ou #N/D?\n\nEnvolve com =SEERRO(fórmula; valor). Se der erro, mostra o que você definir, e o resto da planilha continua funcionando.\n\nMais dicas assim: link na bio.",
    '2026-08-25 23:00:00', $out
);

// Qua 26/08 10h BRT = 13h UTC
queue_instagram_reel(
    $ins,
    'https://media.techsantos.com.br/reels/dica-excel-altenter.mp4',
    "Texto grande espremido numa célula só?\n\nAperta Alt+Enter enquanto digita e quebra a linha sem sair da célula.\n\nMais dicas assim: link na bio.",
    '2026-08-26 13:00:00', $out
);

// Qui 27/08 20h BRT = 23h UTC
queue_instagram_reel(
    $ins,
    'https://media.techsantos.com.br/reels/dica-excel-nomearintervalo.mp4',
    "Fórmula cheia de \$B\$2:\$B\$50 que ninguém entende?\n\nSeleciona o intervalo, dá um nome na caixa de nome, e a fórmula vira =SOMA(Vendas). Ctrl+F3 abre o Gerenciador de Nomes.\n\nMais dicas assim: link na bio.",
    '2026-08-27 23:00:00', $out
);

// Ter 01/09 10h BRT = 13h UTC
queue_instagram_reel(
    $ins,
    'https://media.techsantos.com.br/reels/dica-excel-congelarpaineis.mp4',
    "Rolou a planilha e perdeu o cabeçalho lá em cima?\n\nExibição → Congelar Painéis trava linha e coluna na tela, mesmo rolando mil linhas.\n\nMais dicas assim: link na bio.",
    '2026-09-01 13:00:00', $out
);

// Qua 02/09 20h BRT = 23h UTC
queue_instagram_reel(
    $ins,
    'https://media.techsantos.com.br/reels/dica-excel-transpor.mp4',
    "Montou a tabela deitada quando devia estar em pé?\n\nCopia, Colar Especial, marca Transpor. Linha vira coluna, coluna vira linha, sem refazer nada.\n\nMais dicas assim: link na bio.",
    '2026-09-02 23:00:00', $out
);

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";

@unlink(__FILE__);
