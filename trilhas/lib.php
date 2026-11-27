<?php
declare(strict_types=1);
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../matriculas.php';

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
    return trilha_no_indice($trilha, $noId) !== null;
}

/** Trilhas que aparecem para o público (as marcadas "oculta" ficam de fora). */
function trilhas_publicas(): array
{
    return array_filter(trilhas_todas(), static fn($t) => empty($t['oculta']));
}

function trilha_no_indice(string $trilha, string $noId): ?int
{
    foreach (trilhas_todas()[$trilha]['nos'] ?? [] as $i => $no) {
        if ($no['id'] === $noId) return $i;
    }
    return null;
}

/*
 * Acesso: metade de cada trilha (arredondada pra cima) é grátis pra quem se
 * cadastra; o resto libera pra quem tem o curso da trilha ("curso" no JSON).
 */
function trilha_limite_livre(array $t): int
{
    return (int)ceil(count($t['nos']) / 2);
}

function trilha_acesso_total(array $t, array $cursos): bool
{
    return isset($t['curso']) && in_array($t['curso'], $cursos, true);
}

function trilha_no_liberado(string $trilha, string $noId, array $cursos): bool
{
    $t = trilhas_todas()[$trilha] ?? null;
    $i = trilha_no_indice($trilha, $noId);
    if (!$t || $i === null) return false;
    return $i < trilha_limite_livre($t) || trilha_acesso_total($t, $cursos);
}

/*
 * Visitante sem conta entra nas trilhas deixando nome, e-mail e WhatsApp
 * (trilha_leads). O progresso dele usa o id NEGATIVO do lead em aluno_id,
 * pra caber nas mesmas tabelas sem colidir com alunos; quando ele compra e
 * entra como aluno, o progresso é transferido (trilhas_migrar_lead).
 */
function trilhas_leads_schema(PDO $pdo): void
{
    static $done = false;
    if ($done) return;
    $done = true;
    $pdo->exec("CREATE TABLE IF NOT EXISTS trilha_leads (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(120) NOT NULL,
        email VARCHAR(190) NOT NULL,
        telefone VARCHAR(20) NOT NULL,
        utm_source VARCHAR(80) NULL,
        utm_campaign VARCHAR(120) NULL,
        aluno_id INT NULL,
        criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        ultimo_acesso TIMESTAMP NULL,
        UNIQUE KEY uq_trilha_leads_email (email)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
}

function trilhas_lead_salvar(PDO $pdo, string $nome, string $email, string $telefone, string $utmSource, string $utmCampaign): int
{
    trilhas_leads_schema($pdo);
    $pdo->prepare(
        'INSERT INTO trilha_leads (nome, email, telefone, utm_source, utm_campaign, ultimo_acesso) VALUES (?, ?, ?, ?, ?, NOW())
         ON DUPLICATE KEY UPDATE nome = VALUES(nome), telefone = VALUES(telefone), ultimo_acesso = NOW(), id = LAST_INSERT_ID(id)'
    )->execute([$nome, mb_strtolower($email), $telefone, $utmSource ?: null, $utmCampaign ?: null]);
    return (int)$pdo->lastInsertId();
}

/**
 * Quem está usando as trilhas: aluno logado ou lead cadastrado (sessão).
 * @return array{uid:int, tipo:string, nome:string, cursos:string[]}|null
 */
function trilhas_usuario(PDO $pdo): ?array
{
    if (aluno_logged_id() !== null) {
        $aluno = require_aluno();
        $cursos = array_map(static fn($m) => $m['slug'], $aluno['matriculas'] ?? matriculas_do_aluno($pdo, (int)$aluno['id']));
        trilhas_migrar_lead($pdo, (int)$aluno['id'], (string)$aluno['email']);
        return ['uid' => (int)$aluno['id'], 'tipo' => 'aluno', 'nome' => (string)$aluno['nome'], 'cursos' => $cursos];
    }
    $leadId = (int)($_SESSION['trilha_lead_id'] ?? 0);
    if ($leadId <= 0) return null;
    trilhas_leads_schema($pdo);
    $st = $pdo->prepare('SELECT id, nome FROM trilha_leads WHERE id = ?');
    $st->execute([$leadId]);
    $lead = $st->fetch();
    if (!$lead) { unset($_SESSION['trilha_lead_id']); return null; }
    return ['uid' => -(int)$lead['id'], 'tipo' => 'lead', 'nome' => (string)$lead['nome'], 'cursos' => []];
}

/** Lead que virou aluno (mesmo e-mail): o progresso passa pra conta do aluno, uma vez só. */
function trilhas_migrar_lead(PDO $pdo, int $alunoId, string $email): void
{
    trilhas_leads_schema($pdo);
    trilhas_ensure_schema($pdo);
    $st = $pdo->prepare('SELECT id FROM trilha_leads WHERE email = ? AND aluno_id IS NULL');
    $st->execute([mb_strtolower($email)]);
    $leadId = (int)($st->fetchColumn() ?: 0);
    if ($leadId <= 0) return;
    // IGNORE: se o aluno já tem a mesma etapa/dia, fica o registro dele.
    $pdo->prepare('UPDATE IGNORE trilha_progresso SET aluno_id = ? WHERE aluno_id = ?')->execute([$alunoId, -$leadId]);
    $pdo->prepare('UPDATE IGNORE trilha_atividade SET aluno_id = ? WHERE aluno_id = ?')->execute([$alunoId, -$leadId]);
    $pdo->prepare('DELETE FROM trilha_progresso WHERE aluno_id = ?')->execute([-$leadId]);
    $pdo->prepare('DELETE FROM trilha_atividade WHERE aluno_id = ?')->execute([-$leadId]);
    $pdo->prepare('UPDATE trilha_leads SET aluno_id = ? WHERE id = ?')->execute([$alunoId, $leadId]);
    unset($_SESSION['trilha_lead_id']);
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
