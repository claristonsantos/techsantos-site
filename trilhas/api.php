<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/lib.php';

header('Content-Type: application/json; charset=utf-8');
$responder = static function (int $status, array $dados): void {
    http_response_code($status);
    echo json_encode($dados);
    exit;
};

if ($_SERVER['REQUEST_METHOD'] !== 'POST') $responder(405, ['error' => 'method not allowed']);

$pdo = db();
$usuario = trilhas_usuario($pdo);
if ($usuario === null) $responder(401, ['error' => 'login required']);

$input = json_decode(file_get_contents('php://input') ?: '[]', true) ?: [];
$acao = (string)($input['acao'] ?? '');
$trilha = (string)($input['trilha'] ?? '');

if (!isset(trilhas_publicas()[$trilha]) || !in_array($acao, ['desafio', 'nivelamento'], true)) {
    $responder(400, ['error' => 'invalid input']);
}

trilhas_ensure_schema($pdo);
$uid = $usuario['uid']; // aluno: id; lead: -id (ver trilhas_usuario)
$cursos = $usuario['cursos'];
$xp = 0;

if ($acao === 'desafio') {
    // A correção roda no navegador e o resultado chega pronto. Burlar só
    // engana a própria pessoa; o que o servidor garante é o limite grátis.
    $noId = (string)($input['no'] ?? '');
    $pct = max(0, min(100, (int)($input['pct'] ?? 0)));
    if (!trilha_no_existe($trilha, $noId)) $responder(400, ['error' => 'invalid node']);
    if (!trilha_no_liberado($trilha, $noId, $cursos)) $responder(403, ['error' => 'bloqueado']);
    $aprovado = $pct >= TRILHA_APROVACAO * 100;
    if ($aprovado) {
        $pdo->prepare(
            "INSERT INTO trilha_progresso (aluno_id, trilha, no_id, status, melhor_pct, tentativas)
             VALUES (?, ?, ?, 'concluido', ?, 1)
             ON DUPLICATE KEY UPDATE status = 'concluido', tentativas = tentativas + 1,
                                     melhor_pct = GREATEST(melhor_pct, VALUES(melhor_pct))"
        )->execute([$uid, $trilha, $noId, $pct]);
    }
    // Errar também conta como dia de estudo (XP pequeno), pra não punir quem tentou.
    $xp = $aprovado ? 10 + (int)round($pct / 10) : 2;
} else {
    $nos = array_filter((array)($input['nos'] ?? []), 'is_string');
    $stmt = $pdo->prepare(
        "INSERT INTO trilha_progresso (aluno_id, trilha, no_id, status, melhor_pct) VALUES (?, ?, ?, 'nivelado', 100)
         ON DUPLICATE KEY UPDATE no_id = no_id"
    );
    foreach ($nos as $noId) {
        if (trilha_no_existe($trilha, $noId) && trilha_no_liberado($trilha, $noId, $cursos)) {
            $stmt->execute([$uid, $trilha, $noId]);
            $xp += 5;
        }
    }
}

if ($xp > 0) trilhas_somar_xp($pdo, $uid, $xp);

echo json_encode([
    'ok' => true,
    'xp_ganho' => $xp,
    'progresso' => trilhas_progresso($pdo, $uid),
    'estatisticas' => trilhas_estatisticas($pdo, $uid),
]);
