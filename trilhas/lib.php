<?php
declare(strict_types=1);
require_once __DIR__ . '/../db.php';

/*
 * Trilhas de conhecimento (protótipo estilo Duolingo): cada trilha é um JSON
 * em trilhas/conteudo/, com nós em sequência. O aluno conclui um nó passando
 * no desafio, ou pula nós no teste de nivelamento. O vídeo do nó é opcional
 * e só é sugerido quando ele erra.
 */

const TRILHA_APROVACAO = 0.8; // fração mínima de acertos pra concluir um nó

function trilhas_ensure_schema(PDO $pdo): void
{
    static $done = false;
    if ($done) return;
    $done = true;
    $pdo->exec("CREATE TABLE IF NOT EXISTS trilha_progresso (
        aluno_id INT NOT NULL,
        trilha VARCHAR(40) NOT NULL,
        no_id VARCHAR(60) NOT NULL,
        status ENUM('concluido','nivelado') NOT NULL,
        melhor_pct TINYINT UNSIGNED NOT NULL DEFAULT 0,
        tentativas INT NOT NULL DEFAULT 0,
        atualizado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (aluno_id, trilha, no_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    // Um registro por dia de estudo: base da sequência de dias (streak).
    $pdo->exec("CREATE TABLE IF NOT EXISTS trilha_atividade (
        aluno_id INT NOT NULL,
        dia DATE NOT NULL,
        xp INT NOT NULL DEFAULT 0,
        PRIMARY KEY (aluno_id, dia)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
}

/** @return array<string, array> slug => conteúdo da trilha */
function trilhas_todas(): array
{
    static $cache = null;
    if ($cache !== null) return $cache;
    $cache = [];
    foreach (glob(__DIR__ . '/conteudo/*.json') ?: [] as $arquivo) {
        $t = json_decode((string)file_get_contents($arquivo), true);
        if (is_array($t) && isset($t['slug'], $t['nos'])) $cache[$t['slug']] = $t;
    }
    uasort($cache, static fn($a, $b) => ($a['ordem'] ?? 99) <=> ($b['ordem'] ?? 99));
    return $cache;
}

function trilha_no_existe(string $trilha, string $noId): bool
{
    foreach (trilhas_todas()[$trilha]['nos'] ?? [] as $no) {
        if ($no['id'] === $noId) return true;
    }
    return false;
}

/** @return array<string, array<string, array{status:string, pct:int}>> trilha => no_id => estado */
function trilhas_progresso(PDO $pdo, int $alunoId): array
{
    trilhas_ensure_schema($pdo);
    $stmt = $pdo->prepare('SELECT trilha, no_id, status, melhor_pct FROM trilha_progresso WHERE aluno_id = ?');
    $stmt->execute([$alunoId]);
    $out = [];
    foreach ($stmt->fetchAll() as $r) {
        $out[$r['trilha']][$r['no_id']] = ['status' => $r['status'], 'pct' => (int)$r['melhor_pct']];
    }
    return $out;
}

/** @return array{xp:int, sequencia:int, hoje:bool} */
function trilhas_estatisticas(PDO $pdo, int $alunoId): array
{
    trilhas_ensure_schema($pdo);
    $stmt = $pdo->prepare('SELECT dia, xp FROM trilha_atividade WHERE aluno_id = ? ORDER BY dia DESC');
    $stmt->execute([$alunoId]);
    $dias = $stmt->fetchAll();
    $xp = array_sum(array_map(static fn($d) => (int)$d['xp'], $dias));
    // Sequência: dias seguidos com estudo, contando de hoje (ou de ontem, se
    // ainda não estudou hoje — a sequência só quebra quando o dia acaba).
    $tz = new DateTimeZone('America/Sao_Paulo');
    $esperado = new DateTimeImmutable('today', $tz);
    $hoje = $dias && $dias[0]['dia'] === $esperado->format('Y-m-d');
    if (!$hoje) $esperado = $esperado->modify('-1 day');
    $sequencia = 0;
    foreach ($dias as $d) {
        if ($d['dia'] !== $esperado->format('Y-m-d')) break;
        $sequencia++;
        $esperado = $esperado->modify('-1 day');
    }
    return ['xp' => $xp, 'sequencia' => $sequencia, 'hoje' => $hoje];
}

function trilhas_somar_xp(PDO $pdo, int $alunoId, int $xp): void
{
    $dia = (new DateTimeImmutable('today', new DateTimeZone('America/Sao_Paulo')))->format('Y-m-d');
    $pdo->prepare('INSERT INTO trilha_atividade (aluno_id, dia, xp) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE xp = xp + VALUES(xp)')
        ->execute([$alunoId, $dia, $xp]);
}
