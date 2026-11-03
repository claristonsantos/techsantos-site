<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/lib.php';
$aluno = require_aluno();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input') ?: '[]', true) ?: [];
$acao = (string)($input['acao'] ?? '');
$trilha = (string)($input['trilha'] ?? '');

if (!isset(trilhas_todas()[$trilha]) || !in_array($acao, ['desafio', 'nivelamento'], true)) {
    http_response_code(400);
    echo json_encode(['error' => 'invalid input']);
    exit;
}

$pdo = db();
trilhas_ensure_schema($pdo);
$alunoId = (int)$aluno['id'];
$xp = 0;

if ($acao === 'desafio') {
    // Protótipo: a correção roda no navegador e o resultado chega pronto.
    // Burlar só engana o próprio aluno; quando houver certificado de trilha,
    // a correção passa a ser feita aqui no servidor.
    $noId = (string)($input['no'] ?? '');
    $pct = max(0, min(100, (int)($input['pct'] ?? 0)));
    if (!trilha_no_existe($trilha, $noId)) {
        http_response_code(400);
        echo json_encode(['error' => 'invalid node']);
        exit;
    }
    $aprovado = $pct >= TRILHA_APROVACAO * 100;
    if ($aprovado) {
        $pdo->prepare(
            "INSERT INTO trilha_progresso (aluno_id, trilha, no_id, status, melhor_pct, tentativas)
             VALUES (?, ?, ?, 'concluido', ?, 1)
             ON DUPLICATE KEY UPDATE status = 'concluido', tentativas = tentativas + 1,
                                     melhor_pct = GREATEST(melhor_pct, VALUES(melhor_pct))"
        )->execute([$alunoId, $trilha, $noId, $pct]);
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
        if (trilha_no_existe($trilha, $noId)) {
            $stmt->execute([$alunoId, $trilha, $noId]);
            $xp += 5;
        }
    }
}

if ($xp > 0) trilhas_somar_xp($pdo, $alunoId, $xp);

echo json_encode([
    'ok' => true,
    'xp_ganho' => $xp,
    'progresso' => trilhas_progresso($pdo, $alunoId),
    'estatisticas' => trilhas_estatisticas($pdo, $alunoId),
]);
