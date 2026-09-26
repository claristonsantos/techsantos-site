<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
$aluno = require_aluno();

// Troca o curso ativo da área do aluno — só aceita cursos em que ele está
// matriculado (qualquer outro id cai de volta no curso atual).
$id = (int)($_GET['id'] ?? 0);
foreach ($aluno['matriculas'] as $m) {
    if ($m['id'] === $id) {
        $_SESSION['curso_ativo_id'] = $id;
        break;
    }
}
header('Location: /aluno/');
exit;
