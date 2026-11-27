<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
$aluno = require_aluno();

// Troca o curso ativo da área do aluno — só aceita cursos em que ele está
// matriculado (qualquer outro id cai de volta no curso atual). Aceita o curso
// por id ou por slug, e ?aula=<id da lição> abre direto naquela aula
// (usado pelas trilhas: "Ver a aula que explica isso").
$id = (int)($_GET['id'] ?? 0);
$slug = (string)($_GET['slug'] ?? '');
foreach ($aluno['matriculas'] as $m) {
    if ($m['id'] === $id || ($slug !== '' && $m['slug'] === $slug)) {
        $_SESSION['curso_ativo_id'] = $m['id'];
        break;
    }
}
$aula = (string)($_GET['aula'] ?? '');
header('Location: /aluno/' . (preg_match('/^[a-z0-9-]{1,80}$/', $aula) ? '#' . $aula : ''));
exit;
