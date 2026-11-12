<?php
declare(strict_types=1);

/*
 * Black Friday 2026: combo com os 4 cursos (Excel, Inglês, Power BI e Python)
 * por um preço único. O pedido é gravado com pedidos.oferta = BF_OFERTA e
 * curso_id = Power BI (curso âncora, para os relatórios e joins que já existem);
 * quando o pagamento é confirmado, marcar_pedido_pago() chama bf_aplicar(),
 * que matricula o aluno nos 4 cursos.
 * Vale pela data do PEDIDO, como no combo de outubro: um Pix feito no último
 * dia e compensado depois continua liberando os 4 cursos.
 * O servidor roda em UTC: 30/11 23:59:59 em Brasília = 01/12 02:59:59 UTC.
 */
const BF_OFERTA = 'black-friday-2026';
const BF_NOME = 'Combo Black Friday: Excel + Inglês + Power BI + Python';
const BF_PRECO_CENTAVOS = 11990;
const BF_FIM_UTC = '2026-12-01 02:59:59';
const BF_FIM_TEXTO = '30/11 às 23h59';
const BF_CURSOS = ['excel', 'ingles', 'power-bi', 'python'];
const BF_CURSO_ANCORA = 'power-bi';

function bf_ativa(?string $momentoUtc = null): bool
{
    $agora = $momentoUtc ?? gmdate('Y-m-d H:i:s');
    return $agora <= BF_FIM_UTC;
}

/** Cria a coluna pedidos.oferta na primeira vez (ALTER fora de transação: faz commit implícito). */
function bf_ensure_schema(PDO $pdo): void
{
    static $ok = false;
    if ($ok) return;
    $col = $pdo->query("SHOW COLUMNS FROM pedidos LIKE 'oferta'")->fetch();
    if (!$col) {
        $pdo->exec('ALTER TABLE pedidos ADD COLUMN oferta VARCHAR(40) NULL DEFAULT NULL');
    }
    $ok = true;
}

/** Os 4 cursos do combo (id, slug, nome, preço), na ordem de BF_CURSOS. */
function bf_cursos(PDO $pdo): array
{
    $in = implode(',', array_fill(0, count(BF_CURSOS), '?'));
    $stmt = $pdo->prepare("SELECT id, slug, nome, preco_centavos FROM cursos WHERE slug IN ($in)");
    $stmt->execute(BF_CURSOS);
    $porSlug = [];
    foreach ($stmt->fetchAll() as $c) $porSlug[$c['slug']] = $c;
    $out = [];
    foreach (BF_CURSOS as $s) if (isset($porSlug[$s])) $out[] = $porSlug[$s];
    return $out;
}

function bf_pedido_e_combo(array $pedido): bool
{
    return ($pedido['oferta'] ?? null) === BF_OFERTA;
}

/**
 * Matricula o aluno nos 4 cursos se o pedido pago é do combo Black Friday.
 * Retorna os ids matriculados (vazio se o pedido não é do combo).
 */
function bf_aplicar(PDO $pdo, array $pedido, int $alunoId): array
{
    if (!bf_pedido_e_combo($pedido)) return [];
    $ids = [];
    foreach (bf_cursos($pdo) as $c) {
        matricular($pdo, $alunoId, (int)$c['id']);
        $ids[] = (int)$c['id'];
    }
    return $ids;
}
