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

/** Tabela dos pedidos de lembrete ("me avise antes de acabar"). */
function bf_lembretes_schema(PDO $pdo): void
{
    $pdo->exec("CREATE TABLE IF NOT EXISTS bf_lembretes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(120) NULL,
        email VARCHAR(190) NOT NULL,
        whatsapp VARCHAR(20) NULL,
        origem VARCHAR(80) NULL,
        criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        enviado_27_em DATETIME NULL,
        enviado_30_em DATETIME NULL,
        UNIQUE KEY uq_email (email)
    ) DEFAULT CHARSET=utf8mb4");
}

function bf_lembrete_salvar(PDO $pdo, string $nome, string $email, string $whatsapp, string $origem): void
{
    bf_lembretes_schema($pdo);
    $pdo->prepare('INSERT INTO bf_lembretes (nome, email, whatsapp, origem) VALUES (?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE nome = COALESCE(NULLIF(VALUES(nome), \'\'), nome), whatsapp = COALESCE(NULLIF(VALUES(whatsapp), \'\'), whatsapp)')
        ->execute([$nome ?: null, mb_strtolower($email), $whatsapp ?: null, $origem ?: null]);
}

/**
 * Envia os lembretes: 27/11 (dia da Black Friday) e 30/11 (último dia), a partir das 12h de Brasília (15h UTC).
 * Chamado pelo social_publish_cron (a cada 15 min). Não manda para quem já comprou o combo. Cópia ao dono.
 */
function bf_enviar_lembretes(PDO $pdo): int
{
    $agora = gmdate('Y-m-d H:i:s');
    $rodadas = [['enviado_27_em', '2026-11-27 15:00:00'], ['enviado_30_em', '2026-11-30 15:00:00']];
    $enviados = 0;
    foreach ($rodadas as [$col, $inicio]) {
        if ($agora < $inicio || !bf_ativa()) continue;
        bf_lembretes_schema($pdo);
        bf_ensure_schema($pdo);
        $rows = $pdo->query("SELECT l.* FROM bf_lembretes l WHERE l.$col IS NULL
            AND NOT EXISTS (SELECT 1 FROM pedidos p WHERE p.email = l.email AND p.status = 'pago' AND p.oferta = '" . BF_OFERTA . "')
            ORDER BY l.id LIMIT 15")->fetchAll();
        foreach ($rows as $r) {
            $ultimo = $col === 'enviado_30_em';
            $nome = trim((string)$r['nome']) !== '' ? explode(' ', trim((string)$r['nome']))[0] : '';
            $link = 'https://techsantos.com.br/black-friday.php?utm_source=email&utm_medium=lembrete&utm_campaign=black-friday-2026&utm_content=' . ($ultimo ? 'dia30' : 'dia27');
            $assunto = $ultimo ? 'Último dia: os 4 cursos por R$ 119,90 saem do ar hoje às 23h59' : 'Chegou a Black Friday: os 4 cursos por R$ 119,90';
            $abertura = $ultimo ? 'Como você pediu, este é o aviso: <strong>hoje, 30/11, às 23h59</strong> o combo da Black Friday sai do ar.'
                                : 'Como você pediu, este é o aviso: a <strong>Black Friday da TECH SANTOS BR</strong> está no ar e vai até segunda, 30/11, às 23h59.';
            $html = '<p>Oi' . ($nome ? ' ' . htmlspecialchars($nome, ENT_QUOTES) : '') . '!</p><p>' . $abertura . '</p>'
                . '<p>Excel, Power BI, Python e Inglês, os 4 cursos completos, com <strong>acesso vitalício</strong> e certificado em cada curso, '
                . 'por <strong>R$ 119,90</strong> (separados, R$ 336,70). E com garantia incondicional de 7 dias.</p>'
                . '<p><a href="' . $link . '" style="display:inline-block;background:#7ED956;color:#0F2440;font-weight:700;padding:12px 22px;border-radius:8px;text-decoration:none">Ver a oferta</a></p>'
                . ($ultimo ? '<p>Pix gerado hoje ainda vale, mesmo se o pagamento compensar depois.</p>' : '')
                . '<p>Clariston Santos<br>TECH SANTOS BR</p>';
            $txt = strip_tags(str_replace(['</p>', '<br>'], "\n", $html)) . "\n" . $link;
            $ok = send_html_email((string)$r['email'], $assunto, $html, $txt, OWNER_COPY_EMAIL);
            $pdo->prepare("UPDATE bf_lembretes SET $col = UTC_TIMESTAMP() WHERE id = ?")->execute([$r['id']]);
            if ($ok) $enviados++;
        }
    }
    return $enviados;
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
