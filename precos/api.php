<?php
declare(strict_types=1);
require_once __DIR__ . '/lib.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function precos_resp(array $d, int $code = 200): void
{
    http_response_code($code);
    echo json_encode($d, JSON_UNESCAPED_UNICODE);
    exit;
}

// Só aceita POST com corpo JSON: formulário de outro site não consegue mandar esse tipo sem preflight (proteção CSRF).
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || stripos((string)($_SERVER['CONTENT_TYPE'] ?? ''), 'application/json') !== 0) {
    precos_resp(['erro' => 'metodo invalido'], 405);
}
$in = json_decode(file_get_contents('php://input') ?: '[]', true);
if (!is_array($in)) precos_resp(['erro' => 'json invalido'], 400);
$acao = (string)($in['acao'] ?? '');

$pdo = db();
precos_ensure_schema($pdo);

if ($acao === 'entrar') {
    $u = precos_entrar($pdo, (string)($in['nome'] ?? ''), (string)($in['convite'] ?? ''));
    if (!$u) precos_resp(['erro' => 'Código de convite inválido ou nome vazio.'], 403);
    precos_resp(['ok' => true, 'nome' => $u['nome']]);
}

$usuario = precos_usuario_atual($pdo);
if (!$usuario) precos_resp(['erro' => 'sessao expirada'], 401);
$uid = (int)$usuario['id'];

switch ($acao) {
    case 'importar':
        try {
            precos_resp(precos_importar_nota($pdo, $uid, (string)($in['url'] ?? '')));
        } catch (Throwable $e) {
            error_log('precos importar: ' . $e->getMessage());
            precos_resp(['ok' => false, 'msg' => 'Erro ao gravar a nota. Tente de novo.'], 500);
        }

    case 'manual':
        $desc = trim((string)($in['produto'] ?? ''));
        $preco = (int)round(precos_num((string)($in['preco'] ?? '0')) * 100);
        $lojaNome = trim((string)($in['loja'] ?? ''));
        if ($desc === '' || mb_strlen($desc) > 200 || $preco <= 0 || $preco > 10000000 || $lojaNome === '' || mb_strlen($lojaNome) > 150) {
            precos_resp(['ok' => false, 'msg' => 'Preencha produto, preço e mercado.'], 400);
        }
        $lojaId = (int)($in['loja_id'] ?? 0);
        if ($lojaId > 0) {
            $st = $pdo->prepare('SELECT id FROM precos_lojas WHERE id = ? AND nome = ?');
            $st->execute([$lojaId, $lojaNome]);
            if ($st->fetchColumn() === false) $lojaId = 0;
        }
        if ($lojaId === 0) $lojaId = precos_loja($pdo, '', $lojaNome, '');
        $norm = precos_normalizar($desc);
        $pdo->prepare("INSERT INTO precos_itens (nota_id, loja_id, usuario_id, descricao, descricao_norm, codigo, chave_produto, quantidade, unidade, preco_unit_centavos, data_preco, origem)
                       VALUES (NULL, ?, ?, ?, ?, '', ?, 1, '', ?, NOW(), 'manual')")
            ->execute([$lojaId, $uid, mb_strtoupper($desc, 'UTF-8'), $norm, 'desc:' . $norm, $preco]);
        precos_resp(['ok' => true, 'msg' => 'Preço registrado. Obrigado!']);

    case 'buscar':
        precos_resp(['ok' => true, 'produtos' => precos_buscar($pdo, (string)($in['q'] ?? ''))]);

    case 'lojas':
        $rows = $pdo->query('SELECT l.id, l.nome, l.endereco, COUNT(i.id) AS precos FROM precos_lojas l LEFT JOIN precos_itens i ON i.loja_id = l.id GROUP BY l.id ORDER BY precos DESC, l.nome LIMIT 200')->fetchAll();
        precos_resp(['ok' => true, 'lojas' => $rows]);

    case 'resumo':
        $tot = $pdo->query('SELECT (SELECT COUNT(*) FROM precos_notas) AS notas, (SELECT COUNT(*) FROM precos_itens) AS precos, (SELECT COUNT(*) FROM precos_lojas) AS lojas, (SELECT COUNT(*) FROM precos_usuarios) AS pessoas')->fetch();
        $st = $pdo->prepare('SELECT n.emitida_em, n.total_centavos, n.itens, l.nome AS loja FROM precos_notas n JOIN precos_lojas l ON l.id = n.loja_id WHERE n.usuario_id = ? ORDER BY n.id DESC LIMIT 20');
        $st->execute([$uid]);
        precos_resp(['ok' => true, 'nome' => $usuario['nome'], 'totais' => $tot, 'minhas_notas' => $st->fetchAll()]);

    default:
        precos_resp(['erro' => 'acao invalida'], 400);
}
