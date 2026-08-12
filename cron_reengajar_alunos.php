<?php
declare(strict_types=1);
if (php_sapi_name() !== 'cli') { http_response_code(403); exit('CLI only.'); }
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/mailer.php';
require_once __DIR__ . '/aluno_atividade.php';

$dryRun = in_array('--dry-run', $argv ?? [], true);
$pdo = db();
ensure_aluno_atividade_tables($pdo);
$sql = "SELECT a.id, a.nome, a.email,
        DATEDIFF(NOW(), COALESCE(at.ultimo_acesso, MAX(p.concluida_em), a.created_at)) AS dias_inativo,
        COUNT(DISTINCT p.licao_id) AS aulas_concluidas
    FROM alunos a
    LEFT JOIN aluno_atividade at ON at.aluno_id = a.id
    LEFT JOIN progresso p ON p.aluno_id = a.id
    WHERE a.ativo = 1
    GROUP BY a.id, a.nome, a.email, at.ultimo_acesso, a.created_at
    HAVING aulas_concluidas < 63 AND dias_inativo >= 7";
$alunos = $pdo->query($sql)->fetchAll();

foreach ($alunos as $aluno) {
    $dias = (int)$aluno['dias_inativo'];
    $faixa = $dias >= 30 ? 30 : ($dias >= 14 ? 14 : 7);
    $sent = $pdo->prepare('SELECT 1 FROM aluno_reengajamento WHERE aluno_id = ? AND faixa_dias = ? LIMIT 1');
    $sent->execute([(int)$aluno['id'], $faixa]);
    if ($sent->fetchColumn()) continue;
    if ($dryRun) {
        echo "DRY RUN aluno {$aluno['id']}: {$dias} dias, faixa {$faixa}, {$aluno['aulas_concluidas']}/63 aulas\n";
        continue;
    }
    $ok = send_student_reengagement_email($aluno['email'], $aluno['nome'], (int)$aluno['aulas_concluidas'], $faixa);
    if ($ok) {
        $pdo->prepare('INSERT INTO aluno_reengajamento (aluno_id, faixa_dias) VALUES (?, ?)')->execute([(int)$aluno['id'], $faixa]);
        echo "aluno {$aluno['id']}: lembrete da faixa {$faixa} enviado\n";
    } else echo "aluno {$aluno['id']}: falha no envio\n";
}
if (!$alunos) echo "nenhum aluno inativo elegível\n";
