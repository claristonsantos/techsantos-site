<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_aluno();

const EXERCICIOS = [
    'tipos-de-dados' => ['file' => 'tipos-de-dados.xlsx', 'label' => 'Tipos-de-Dados.xlsx'],
    'tabela-ou-intervalo' => ['file' => 'tabela-ou-intervalo.xlsx', 'label' => 'Tabela-ou-Intervalo.xlsx'],
    'importar-excel' => ['file' => 'importar-excel.xlsx', 'label' => 'Importar-Excel.xlsx'],
    'consulta-pasta' => ['file' => 'consulta-pasta.zip', 'label' => 'Consulta-de-Pasta.zip'],
    'preenchimento-colunas' => ['file' => 'preenchimento-colunas.xlsx', 'label' => 'Preenchimento-de-Colunas.xlsx'],
    'dividir-colunas' => ['file' => 'dividir-colunas.xlsx', 'label' => 'Dividir-Colunas.xlsx'],
    'dividir-linhas' => ['file' => 'dividir-linhas.xlsx', 'label' => 'Dividir-Linhas.xlsx'],
    'colunas-personalizadas' => ['file' => 'colunas-personalizadas.xlsx', 'label' => 'Colunas-Personalizadas.xlsx'],
    'coluna-exemplo' => ['file' => 'coluna-exemplo.xlsx', 'label' => 'Coluna-de-Exemplo.xlsx'],
    'mesclar-colunas' => ['file' => 'mesclar-colunas.xlsx', 'label' => 'Mesclar-Colunas.xlsx'],
    'classificar-filtrar' => ['file' => 'classificar-filtrar.xlsx', 'label' => 'Classificar-e-Filtrar.xlsx'],
    'formula-if' => ['file' => 'formula-if.xlsx', 'label' => 'Formula-IF.xlsx'],
    'formula-if-and' => ['file' => 'formula-if-and.xlsx', 'label' => 'Formula-IF-e-AND.xlsx'],
    'formula-adddays' => ['file' => 'formula-adddays.xlsx', 'label' => 'Formula-AddDays.xlsx'],
    'formulas-texto' => ['file' => 'formulas-texto.xlsx', 'label' => 'Formulas-de-Texto.xlsx'],
    'coluna-dinamica' => ['file' => 'coluna-dinamica.zip', 'label' => 'Coluna-Dinamica-Pivot.zip'],
    'transformar-colunas-linhas' => ['file' => 'transformar-colunas-linhas.xlsx', 'label' => 'Transformar-Colunas-em-Linhas.xlsx'],
    'agrupar-por' => ['file' => 'agrupar-por.xlsx', 'label' => 'Agrupar-Por.xlsx'],
    'acrescentar-consultas-1' => ['file' => 'acrescentar-consultas-1.zip', 'label' => 'Acrescentar-Consultas-Parte-1.zip'],
    'acrescentar-consultas-2' => ['file' => 'acrescentar-consultas-2.zip', 'label' => 'Acrescentar-Consultas-Parte-2.zip'],
    'mesclar-consultas' => ['file' => 'mesclar-consultas.zip', 'label' => 'Mesclar-Consultas.zip'],
    'lab-04a-dados' => ['file' => 'lab-04a.zip', 'label' => 'Lab-04A-Clientes-e-Cotacoes.zip'],
    'lab-04b-datas' => ['file' => 'lab-04b-datas.csv', 'label' => 'Lab-04B-Datas.csv'],
    'lab-04c-escritorios' => ['file' => 'lab-04c-escritorios.xlsx', 'label' => 'Lab-04C-Escritorios.xlsx'],
];

$id = (string)($_GET['id'] ?? '');
if (!isset(EXERCICIOS[$id])) {
    http_response_code(404);
    exit('Arquivo de exercício não encontrado.');
}

$info = EXERCICIOS[$id];
$path = __DIR__ . '/exercicios/' . $info['file'];
if (!is_file($path)) {
    http_response_code(404);
    exit('Arquivo de exercício não encontrado.');
}

$ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
$mime = $ext === 'zip'
    ? 'application/zip'
    : 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';

header('Content-Type: ' . $mime);
header('Content-Disposition: attachment; filename="' . $info['label'] . '"');
header('Content-Length: ' . (string)filesize($path));
header('Cache-Control: private, max-age=0, no-cache');
readfile($path);
