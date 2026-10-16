<?php
declare(strict_types=1);

/*
 * Combo Mês dos Professores (outubro/2026): quem compra o curso de Power BI
 * leva o curso de Excel junto, sem custo. Vale pela data do PEDIDO (não do
 * pagamento), para um Pix/boleto feito no dia 31 e compensado depois não
 * perder o bônus. O servidor roda em UTC: 31/10 23:59:59 em Brasília = 01/11 02:59:59 UTC.
 */
const PROMO_COMBO_FIM_UTC = '2026-11-01 02:59:59';
const PROMO_COMBO_CURSO_PAGO = 'power-bi';
const PROMO_COMBO_CURSO_BONUS = 'excel';

function promo_combo_ativa(?string $momentoUtc = null): bool
{
    $agora = $momentoUtc ?? gmdate('Y-m-d H:i:s');
    return $agora <= PROMO_COMBO_FIM_UTC;
}

/** Banner curto para as páginas de venda; vazio fora do período. */
function promo_combo_banner(string $classe = 'promo-combo'): string
{
    if (!promo_combo_ativa()) return '';
    return '<div class="' . htmlspecialchars($classe, ENT_QUOTES) . '" role="note">'
        . '<strong>Mês dos Professores:</strong> comprando o Power BI até 31/10 você <strong>leva o curso de Excel completo de presente</strong> '
        . '(68 videoaulas, preparatório MO-210/MO-211). Liberado automaticamente na mesma conta.</div>';
}

/**
 * Libera o curso bônus se o pedido pago é do curso de Power BI e foi criado
 * dentro do período. Retorna o id do curso bônus liberado, ou null.
 */
function promo_combo_aplicar(PDO $pdo, array $pedido, int $alunoId): ?int
{
    $stmt = $pdo->prepare('SELECT slug FROM cursos WHERE id = ?');
    $stmt->execute([(int)$pedido['curso_id']]);
    if ($stmt->fetchColumn() !== PROMO_COMBO_CURSO_PAGO) return null;
    if (!promo_combo_ativa((string)($pedido['criado_em'] ?? gmdate('Y-m-d H:i:s')))) return null;
    $stmt = $pdo->prepare('SELECT id FROM cursos WHERE slug = ?');
    $stmt->execute([PROMO_COMBO_CURSO_BONUS]);
    $bonusId = $stmt->fetchColumn();
    if (!$bonusId) return null;
    matricular($pdo, $alunoId, (int)$bonusId);
    return (int)$bonusId;
}
