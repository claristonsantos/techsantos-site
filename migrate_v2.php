<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) {
    http_response_code(403);
    exit('Forbidden.');
}

$pdo = db();
$out = [];

function column_exists(PDO $pdo, string $table, string $column): bool
{
    $stmt = $pdo->prepare(
        "SELECT COUNT(*) FROM information_schema.COLUMNS
         WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ?"
    );
    $stmt->execute([$table, $column]);
    return (int)$stmt->fetchColumn() > 0;
}

$pdo->exec("CREATE TABLE IF NOT EXISTS progresso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    licao_id VARCHAR(60) NOT NULL,
    concluida_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_aluno_licao (aluno_id, licao_id),
    CONSTRAINT fk_progresso_aluno FOREIGN KEY (aluno_id) REFERENCES alunos(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
$out[] = 'Tabela progresso ok.';

$pdo->exec("CREATE TABLE IF NOT EXISTS avaliacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    curso_id INT NOT NULL,
    modulo_id VARCHAR(60) NOT NULL,
    titulo VARCHAR(200) NOT NULL,
    nota_minima INT NOT NULL DEFAULT 70,
    ativo TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_curso_modulo (curso_id, modulo_id),
    CONSTRAINT fk_avaliacoes_curso FOREIGN KEY (curso_id) REFERENCES cursos(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
$out[] = 'Tabela avaliacoes ok.';

$pdo->exec("CREATE TABLE IF NOT EXISTS avaliacao_questoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    avaliacao_id INT NOT NULL,
    enunciado TEXT NOT NULL,
    ordem INT NOT NULL DEFAULT 0,
    CONSTRAINT fk_questoes_avaliacao FOREIGN KEY (avaliacao_id) REFERENCES avaliacoes(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
$out[] = 'Tabela avaliacao_questoes ok.';

$pdo->exec("CREATE TABLE IF NOT EXISTS avaliacao_alternativas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    questao_id INT NOT NULL,
    texto VARCHAR(500) NOT NULL,
    correta TINYINT(1) NOT NULL DEFAULT 0,
    ordem INT NOT NULL DEFAULT 0,
    CONSTRAINT fk_alternativas_questao FOREIGN KEY (questao_id) REFERENCES avaliacao_questoes(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
$out[] = 'Tabela avaliacao_alternativas ok.';

$pdo->exec("CREATE TABLE IF NOT EXISTS avaliacao_tentativas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    avaliacao_id INT NOT NULL,
    nota DECIMAL(5,2) NOT NULL,
    aprovado TINYINT(1) NOT NULL,
    criada_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_tentativas_aluno FOREIGN KEY (aluno_id) REFERENCES alunos(id) ON DELETE CASCADE,
    CONSTRAINT fk_tentativas_avaliacao FOREIGN KEY (avaliacao_id) REFERENCES avaliacoes(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
$out[] = 'Tabela avaliacao_tentativas ok.';

$pdo->exec("CREATE TABLE IF NOT EXISTS certificados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    curso_id INT NOT NULL,
    codigo VARCHAR(20) NOT NULL UNIQUE,
    emitido_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_certificados_aluno FOREIGN KEY (aluno_id) REFERENCES alunos(id) ON DELETE CASCADE,
    CONSTRAINT fk_certificados_curso FOREIGN KEY (curso_id) REFERENCES cursos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
$out[] = 'Tabela certificados ok.';

if (!column_exists($pdo, 'alunos', 'senha_temporaria')) {
    $pdo->exec("ALTER TABLE alunos ADD COLUMN senha_temporaria TINYINT(1) NOT NULL DEFAULT 1 AFTER senha_hash");
    $out[] = 'Coluna alunos.senha_temporaria criada.';
}

if (!column_exists($pdo, 'cursos', 'proxima_turma_data')) {
    $pdo->exec("ALTER TABLE cursos ADD COLUMN proxima_turma_data DATE NULL AFTER modalidade");
    $out[] = 'Coluna cursos.proxima_turma_data criada.';
}
if (!column_exists($pdo, 'cursos', 'vagas_disponiveis')) {
    $pdo->exec("ALTER TABLE cursos ADD COLUMN vagas_disponiveis INT NULL AFTER proxima_turma_data");
    $out[] = 'Coluna cursos.vagas_disponiveis criada.';
}
if (!column_exists($pdo, 'cursos', 'carga_horaria_horas')) {
    $pdo->exec("ALTER TABLE cursos ADD COLUMN carga_horaria_horas INT NULL AFTER carga_horaria");
    $out[] = 'Coluna cursos.carga_horaria_horas criada.';
}

// Seed sample questions for the Power BI course (module 1 + final), only if none exist yet.
$cursoStmt = $pdo->prepare('SELECT id, proxima_turma_data FROM cursos WHERE slug = ?');
$cursoStmt->execute(['power-bi']);
$cursoRow = $cursoStmt->fetch();
$cursoId = $cursoRow['id'] ?? null;

if ($cursoId && empty($cursoRow['proxima_turma_data'])) {
    $upd = $pdo->prepare('UPDATE cursos SET proxima_turma_data = ?, vagas_disponiveis = ? WHERE id = ?');
    $upd->execute([date('Y-m-d', strtotime('+6 weeks')), 8, $cursoId]);
    $out[] = 'Próxima turma seed definida (editável em Admin > Cursos).';
}

if ($cursoId) {
    $seedAvaliacao = function (PDO $pdo, int $cursoId, string $moduloId, string $titulo, array $questoes) use (&$out) {
        $chk = $pdo->prepare('SELECT id FROM avaliacoes WHERE curso_id = ? AND modulo_id = ?');
        $chk->execute([$cursoId, $moduloId]);
        $avId = $chk->fetchColumn();
        if ($avId) {
            return;
        }
        $ins = $pdo->prepare('INSERT INTO avaliacoes (curso_id, modulo_id, titulo, nota_minima) VALUES (?, ?, ?, 70)');
        $ins->execute([$cursoId, $moduloId, $titulo]);
        $avId = (int)$pdo->lastInsertId();
        $insQ = $pdo->prepare('INSERT INTO avaliacao_questoes (avaliacao_id, enunciado, ordem) VALUES (?, ?, ?)');
        $insA = $pdo->prepare('INSERT INTO avaliacao_alternativas (questao_id, texto, correta, ordem) VALUES (?, ?, ?, ?)');
        foreach ($questoes as $i => $q) {
            $insQ->execute([$avId, $q['enunciado'], $i]);
            $qId = (int)$pdo->lastInsertId();
            foreach ($q['alternativas'] as $j => $alt) {
                $insA->execute([$qId, $alt[0], $alt[1] ? 1 : 0, $j]);
            }
        }
        $out[] = "Avaliação seed criada: $titulo (" . count($questoes) . " questões).";
    };

    $seedAvaliacao($pdo, (int)$cursoId, 'modelagem', 'Avaliação — Fundamentos de Modelagem de Dados', [
        ['enunciado' => 'O que é granularidade em um modelo de dados?', 'alternativas' => [
            ['O nível de detalhe que cada linha de uma tabela representa', true],
            ['A quantidade de colunas em uma tabela', false],
            ['O tipo de dado de uma coluna', false],
            ['O número de relacionamentos no modelo', false],
        ]],
        ['enunciado' => 'Qual é a principal vantagem da normalização de dados?', 'alternativas' => [
            ['Reduzir a redundância de dados e melhorar a integridade', true],
            ['Aumentar o número de tabelas sem necessidade', false],
            ['Deixar os dados mais difíceis de entender', false],
            ['Eliminar a necessidade de relacionamentos', false],
        ]],
        ['enunciado' => 'No esquema estrela (star schema), o que é uma tabela fato?', 'alternativas' => [
            ['A tabela central que registra o que aconteceu (ex.: vendas)', true],
            ['Uma tabela com os atributos descritivos, como nome e categoria', false],
            ['Uma tabela usada apenas para testes', false],
            ['A tabela com a menor quantidade de linhas', false],
        ]],
        ['enunciado' => 'Por que uma única tabela grande no Excel tem limitações para análise de dados?', 'alternativas' => [
            ['Porque mistura granularidades diferentes e gera redundância e duplicidade', true],
            ['Porque o Excel não aceita mais de 100 linhas', false],
            ['Porque não pode conter texto e número na mesma planilha', false],
            ['Porque não é possível abrir no Power BI', false],
        ]],
        ['enunciado' => 'O que a desnormalização prioriza, em geral?', 'alternativas' => [
            ['Facilitar o entendimento do modelo, mesmo aumentando a redundância', true],
            ['Eliminar totalmente a duplicidade de dados', false],
            ['Reduzir o número de tabelas para uma só sempre', false],
            ['Impedir relacionamentos entre tabelas', false],
        ]],
    ]);

    $seedAvaliacao($pdo, (int)$cursoId, 'encerramento', 'Avaliação Final — Power BI Completo', [
        ['enunciado' => 'Qual operação do Power Query combina duas tabelas diferentes com base em uma coluna-chave em comum?', 'alternativas' => [
            ['Mesclar consultas', true],
            ['Acrescentar consultas', false],
            ['Agrupar por', false],
            ['Dividir colunas', false],
        ]],
        ['enunciado' => 'Em DAX, qual função é usada para modificar o contexto de filtro de um cálculo?', 'alternativas' => [
            ['CALCULATE', true],
            ['SUM', false],
            ['IF', false],
            ['CONCATENATE', false],
        ]],
        ['enunciado' => 'Qual é a diferença principal entre uma coluna calculada e uma medida em DAX?', 'alternativas' => [
            ['A coluna calculada é armazenada fisicamente no modelo; a medida é calculada sob demanda', true],
            ['Não há diferença, são a mesma coisa', false],
            ['A medida sempre usa mais memória que a coluna calculada', false],
            ['A coluna calculada só funciona com texto', false],
        ]],
        ['enunciado' => 'O que é a segurança em nível de linha (RLS) no Power BI?', 'alternativas' => [
            ['Um recurso que mostra dados diferentes para usuários diferentes no mesmo relatório', true],
            ['Uma senha para abrir o arquivo do Power BI', false],
            ['Um tipo de gráfico de segurança', false],
            ['Um recurso exclusivo do Excel', false],
        ]],
        ['enunciado' => 'Qual é a arquitetura de modelo de dados recomendada pela Microsoft para o Power BI?', 'alternativas' => [
            ['Esquema estrela, com tabelas fato e dimensão', true],
            ['Uma única tabela com todas as colunas', false],
            ['Esquema em floco de neve invertido', false],
            ['Tabelas sem nenhum relacionamento', false],
        ]],
    ]);
}

header('Content-Type: text/plain; charset=utf-8');
echo "Migração v2 concluída.\n";
foreach ($out as $line) {
    echo "- $line\n";
}

@unlink(__FILE__);
echo "\nmigrate_v2.php removido do servidor.\n";
