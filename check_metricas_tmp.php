<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/config.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('forbidden');
}

$pdo = db();
header('Content-Type: text/plain; charset=utf-8');

function q(PDO $pdo, string $titulo, string $sql): void
{
    echo "\n=== {$titulo} ===\n";
    try {
        $rows = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        if (!$rows) { echo "  (vazio)\n"; return; }
        foreach ($rows as $r) echo '  ' . implode(' | ', array_map(static fn($k, $v) => "$k=" . ($v ?? 'NULL'), array_keys($r), $r)) . "\n";
    } catch (Throwable $e) {
        echo '  ERRO: ' . $e->getMessage() . "\n";
    }
}

echo 'agora UTC: ' . gmdate('Y-m-d H:i') . "\n";

$tabelas = ['pedidos', 'matriculas', 'alunos', 'whatsapp_leads', 'aulas_particulares_leads', 'consultoria_leads', 'progresso', 'aluno_atividade', 'trilha_progresso', 'trilha_atividade', 'avaliacao_tentativas', 'certificados', 'social_posts', 'social_auto_reply_log', 'aulas_particulares'];
$in = "'" . implode("','", $tabelas) . "'";
q($pdo, 'colunas', "SELECT table_name t, GROUP_CONCAT(column_name ORDER BY ordinal_position) cols FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name IN ($in) GROUP BY table_name");

// Vendas
q($pdo, 'pedidos por mes/status (desde ago)', "SELECT DATE_FORMAT(criado_em,'%Y-%m') mes, status, COUNT(*) n, SUM(valor_centavos)/100 reais FROM pedidos WHERE criado_em >= '2026-08-01' GROUP BY mes, status ORDER BY mes, status");
q($pdo, 'pedidos desde 2026-10-20', "SELECT p.id, p.criado_em, p.status, c.slug curso, p.valor_centavos/100 reais, p.utm_source, p.utm_medium, p.utm_campaign, p.landing_page, LEFT(p.email, 3) email3 FROM pedidos p LEFT JOIN cursos c ON c.id = p.curso_id WHERE p.criado_em >= '2026-10-20' ORDER BY p.id");
q($pdo, 'matriculas por curso (total / ultimos 30d)', "SELECT c.slug, COUNT(*) total, SUM(m.criado_em >= NOW() - INTERVAL 30 DAY) d30 FROM matriculas m JOIN cursos c ON c.id = m.curso_id GROUP BY c.slug");
q($pdo, 'alunos novos por semana (60d)', "SELECT YEARWEEK(criado_em, 3) semana, MIN(DATE(criado_em)) de, COUNT(*) n FROM alunos WHERE criado_em >= NOW() - INTERVAL 60 DAY GROUP BY semana ORDER BY semana");
q($pdo, 'cursos ativos', "SELECT id, slug, ativo, preco_centavos/100 preco FROM cursos ORDER BY id");

// Leads
q($pdo, 'whatsapp_leads por semana/origem (60d)', "SELECT YEARWEEK(criado_em, 3) semana, origem, COUNT(*) n FROM whatsapp_leads WHERE criado_em >= NOW() - INTERVAL 60 DAY GROUP BY semana, origem ORDER BY semana");
q($pdo, 'whatsapp_leads total', "SELECT COUNT(*) n, MAX(criado_em) ultimo FROM whatsapp_leads");
q($pdo, 'aulas_particulares_leads (60d)', "SELECT DATE(criado_em) dia, utm_source, utm_medium, interesse, LEFT(email, 3) email3 FROM aulas_particulares_leads WHERE criado_em >= NOW() - INTERVAL 60 DAY ORDER BY criado_em");
q($pdo, 'consultoria_leads (60d)', "SELECT * FROM consultoria_leads WHERE criado_em >= NOW() - INTERVAL 60 DAY");
q($pdo, 'aulas_particulares (status)', "SELECT status, COUNT(*) n, SUM(valor_centavos)/100 reais, MAX(data_aula) ultima FROM aulas_particulares GROUP BY status");

// Engajamento dos alunos
q($pdo, 'aluno_atividade: alunos ativos por semana (60d)', "SELECT YEARWEEK(criado_em, 3) semana, COUNT(DISTINCT aluno_id) alunos, COUNT(*) eventos FROM aluno_atividade WHERE criado_em >= NOW() - INTERVAL 60 DAY GROUP BY semana ORDER BY semana");
q($pdo, 'progresso: aulas concluidas por semana (60d)', "SELECT YEARWEEK(concluido_em, 3) semana, COUNT(DISTINCT aluno_id) alunos, COUNT(*) aulas FROM progresso WHERE concluido_em >= NOW() - INTERVAL 60 DAY GROUP BY semana ORDER BY semana");
q($pdo, 'avaliacao_tentativas (30d)', "SELECT COUNT(*) tentativas, COUNT(DISTINCT aluno_id) alunos FROM avaliacao_tentativas WHERE criado_em >= NOW() - INTERVAL 30 DAY");
q($pdo, 'certificados (por mes)', "SELECT DATE_FORMAT(emitido_em,'%Y-%m') mes, COUNT(*) n FROM certificados GROUP BY mes ORDER BY mes DESC LIMIT 6");
q($pdo, 'trilhas: progresso', "SELECT trilha, status, COUNT(*) etapas, COUNT(DISTINCT aluno_id) alunos FROM trilha_progresso GROUP BY trilha, status");
q($pdo, 'trilhas: atividade', "SELECT dia, COUNT(DISTINCT aluno_id) alunos, SUM(xp) xp FROM trilha_atividade GROUP BY dia ORDER BY dia");

// Social
q($pdo, 'social_posts por canal/status (01/11 em diante)', "SELECT canal, status, COUNT(*) n FROM social_posts WHERE agendado_para >= '2026-11-01' GROUP BY canal, status ORDER BY canal, status");
q($pdo, 'social_posts com erro (desde 25/10)', "SELECT id, canal, tipo, agendado_para, LEFT(erro_msg, 160) erro FROM social_posts WHERE status = 'erro' AND agendado_para >= '2026-10-25' ORDER BY agendado_para");
q($pdo, 'fila pendente (ultimo agendado por canal)', "SELECT canal, COUNT(*) pendentes, MIN(agendado_para) proximo, MAX(agendado_para) ultimo FROM social_posts WHERE status IN ('pendente','processando','agendado_meta') GROUP BY canal");
q($pdo, 'publicados ultimos 10 dias', "SELECT id, canal, tipo, agendado_para, meta_post_id FROM social_posts WHERE status = 'publicado' AND agendado_para >= NOW() - INTERVAL 10 DAY ORDER BY agendado_para");
q($pdo, 'auto reply (30d por regra)', "SELECT * FROM social_auto_reply_log WHERE criado_em >= NOW() - INTERVAL 30 DAY ORDER BY id DESC LIMIT 25");

echo "\ndone\n";
@unlink(__FILE__);
