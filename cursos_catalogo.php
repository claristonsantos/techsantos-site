<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

/*
 * Catálogo de cursos à venda: o banco (tabela cursos) guarda nome, preço e se
 * está ativo; aqui ficam os textos de vitrine e a página de vendas de cada um.
 * Usado pelo checkout (comprar.php) e pela vitrine da Área do Aluno.
 */
const CURSOS_VITRINE = [
    'power-bi' => [
        'etiqueta' => 'Do zero ao certificado',
        'pagina' => '/curso-power-bi.php',
        'imagem' => '/assets/img/promo-curso-1.jpg',
        'resumo' => 'Modelagem, Power Query, DAX e relatórios, do zero ao dashboard pronto para apresentar.',
        'itens' => [
            '13 módulos, 46 videoaulas práticas (mais de 7 horas) + apostila com referências oficiais Microsoft',
            'Avaliações por módulo e avaliação final com certificado de conclusão',
            'Acesso liberado automaticamente após a confirmação do pagamento',
        ],
    ],
    'microsoft-fabric' => [
        'etiqueta' => 'Preparatório DP-600 e DP-700',
        'pagina' => '/curso-microsoft-fabric.php',
        'imagem' => '/assets/img/curso-fabric/m01/arquitetura-fabric.png',
        'resumo' => 'Preparatório completo para as certificações DP-600 e DP-700: OneLake, lakehouse, warehouse, Spark, Real-Time Intelligence, modelos semânticos e DAX.',
        'itens' => [
            '15 módulos e 82 aulas com teoria completa, imagens oficiais da Microsoft e áudio (modo podcast) em todas as aulas',
            'Conteúdo mapeado habilidade por habilidade nas provas DP-600 e DP-700',
            'Avaliação em cada módulo, 2 simulados finais de 40 questões e certificado de conclusão',
            'Acesso liberado automaticamente após a confirmação do pagamento',
        ],
    ],
    'ingles' => [
        'etiqueta' => 'Do básico ao avançado · A1 ao C1',
        'pagina' => '/curso-ingles.php',
        'imagem' => '/assets/img/curso-ingles/capa.jpg',
        'resumo' => 'Inglês do zero à fluência profissional, com videoaulas em conversa com personagens, prática interativa estilo Duolingo e áudio nativo em todas as frases.',
        'itens' => [
            '17 módulos e 66 aulas do A1 ao C1, com videoaulas em formato de conversa e teoria completa em português',
            'Mais de 800 exercícios interativos: ouvir, montar frases, ligar pares, escrever e falar com reconhecimento de voz',
            'Inglês para o trabalho e para dados e tecnologia: e-mails, reuniões, apresentações, Excel e Power BI',
            'Avaliação em cada módulo, teste final de 40 questões e certificado de conclusão',
        ],
    ],
    'python' => [
        'etiqueta' => 'Do zero até Python para dados',
        'pagina' => '/curso-python.php',
        'imagem' => '/assets/img/curso-python/capa.jpg',
        'resumo' => 'Python do zero até Python para dados, programando desde a primeira aula num laboratório dentro do navegador: pandas, gráficos e automação de planilhas Excel.',
        'itens' => [
            '14 módulos e 55 aulas, com teoria em português e todo exemplo executável no navegador, sem instalar nada',
            '54 desafios de cenário real: você escreve o script e o site confere o resultado na hora',
            'pandas para limpar, cruzar e resumir dados, gráficos com matplotlib e relatórios Excel automáticos',
            'Avaliação em cada módulo, teste final de 40 questões e certificado de conclusão',
        ],
    ],
    'excel' => [
        'etiqueta' => 'Do zero ao avançado · MO-210 e MO-211',
        'pagina' => '/curso-excel.php',
        'imagem' => '/assets/img/curso-excel/m09/procx-basico.jpg',
        'resumo' => 'Excel do zero ao avançado, preparatório para as certificações MO-210 e MO-211: fórmulas, PROCX, tabelas dinâmicas, gráficos, análise de hipóteses e macros.',
        'itens' => [
            '17 módulos e 68 videoaulas com demonstração no Excel, teoria completa, imagens oficiais da Microsoft e áudio (modo podcast)',
            'Conteúdo mapeado habilidade por habilidade nas provas MO-210 (Associate) e MO-211 (Expert)',
            'Avaliação em cada módulo, 2 simulados finais de 40 questões e certificado de conclusão',
            'Acesso liberado automaticamente após a confirmação do pagamento',
        ],
    ],
];

function curso_vitrine(string $slug): array
{
    return CURSOS_VITRINE[$slug] ?? ['etiqueta' => '', 'pagina' => '/', 'imagem' => '/assets/img/logo.jpg', 'resumo' => '', 'itens' => []];
}

/** Curso pelo slug, só se puder ser vendido (ativo e com preço). */
function curso_a_venda(PDO $pdo, string $slug): ?array
{
    if (!preg_match('/^[a-z0-9-]+$/', $slug)) return null;
    $stmt = $pdo->prepare('SELECT id, nome, slug, carga_horaria, descricao, modalidade, preco_centavos FROM cursos WHERE slug = ? AND ativo = 1 AND preco_centavos > 0');
    $stmt->execute([$slug]);
    return $stmt->fetch() ?: null;
}

/** Todos os cursos à venda, na ordem de criação. */
function cursos_a_venda(PDO $pdo): array
{
    return $pdo->query('SELECT id, nome, slug, descricao, preco_centavos FROM cursos WHERE ativo = 1 AND preco_centavos > 0 ORDER BY id')->fetchAll();
}

function preco_formatado(?int $centavos): ?string
{
    return $centavos ? number_format($centavos / 100, 2, ',', '.') : null;
}

/** Ordem de apresentação no catálogo público: a trilha Excel → Power BI → Fabric. */
const CURSOS_ORDEM = ['excel', 'power-bi', 'microsoft-fabric', 'python', 'ingles'];

function cursos_a_venda_ordenados(PDO $pdo): array
{
    $cursos = cursos_a_venda($pdo);
    usort($cursos, function (array $a, array $b): int {
        $ia = array_search($a['slug'], CURSOS_ORDEM, true);
        $ib = array_search($b['slug'], CURSOS_ORDEM, true);
        return ($ia === false ? 99 : $ia) <=> ($ib === false ? 99 : $ib);
    });
    return $cursos;
}
