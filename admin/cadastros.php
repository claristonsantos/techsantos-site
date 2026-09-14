<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/_partials.php';
require_admin();

$pdo = db();

function cadastros_table_exists(PDO $pdo, string $table): bool
{
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?');
    $stmt->execute([$table]);
    return (bool)$stmt->fetchColumn();
}

$cadastros = [];

$alunos = $pdo->query(
    "SELECT a.id, a.nome, a.email, a.cpf, a.created_at, c.nome AS curso_nome
     FROM alunos a JOIN cursos c ON c.id = a.curso_id
     ORDER BY a.created_at DESC"
)->fetchAll();
foreach ($alunos as $a) {
    $cadastros[] = [
        'nome' => $a['nome'],
        'tipo' => 'Aluno',
        'origem' => 'Curso: ' . $a['curso_nome'],
        'email' => $a['email'],
        'documento' => $a['cpf'] ? cpf_format($a['cpf']) : '',
        'telefone' => '',
        'data' => $a['created_at'],
        'href' => '/admin/alunos.php?edit=' . (int)$a['id'],
        'acao' => 'Editar',
    ];
}

if (cadastros_table_exists($pdo, 'aulas_particulares_leads')) {
    $aulas = $pdo->query("SELECT id, nome, email, telefone, interesse, criado_em FROM aulas_particulares_leads ORDER BY criado_em DESC")->fetchAll();
    $vistoAula = [];
    foreach ($aulas as $au) {
        $chave = mb_strtolower(trim($au['nome'])) . '|' . mb_strtolower(trim((string)$au['email']));
        if (isset($vistoAula[$chave])) continue;
        $vistoAula[$chave] = true;
        $cadastros[] = [
            'nome' => $au['nome'],
            'tipo' => 'Aluno',
            'origem' => 'Aula particular: ' . $au['interesse'],
            'email' => $au['email'],
            'documento' => '',
            'telefone' => $au['telefone'] ?? '',
            'data' => $au['criado_em'],
            'href' => '/admin/aulas_particulares.php?editar=' . (int)$au['id'],
            'acao' => 'Editar',
        ];
    }
}

if (cadastros_table_exists($pdo, 'propostas')) {
    $propCli = $pdo->query("SELECT id, cliente, contato_email, contato_documento, created_at FROM propostas ORDER BY created_at DESC")->fetchAll();
    $vistoCliente = [];
    foreach ($propCli as $cp) {
        if (isset($vistoCliente[$cp['cliente']])) continue;
        $vistoCliente[$cp['cliente']] = true;
        $cadastros[] = [
            'nome' => $cp['cliente'],
            'tipo' => 'Cliente',
            'origem' => 'Proposta comercial',
            'email' => $cp['contato_email'] ?? '',
            'documento' => $cp['contato_documento'] ?? '',
            'telefone' => '',
            'data' => $cp['created_at'],
            'href' => '/admin/propostas.php?edit=' . (int)$cp['id'],
            'acao' => 'Editar',
            'href_ver' => '/admin/propostas.php?f_cliente=' . urlencode($cp['cliente']),
        ];
    }
}

$fTipo = trim((string)($_GET['f_tipo'] ?? ''));
$fBusca = trim((string)($_GET['f_busca'] ?? ''));
if ($fTipo !== '') {
    $cadastros = array_values(array_filter($cadastros, fn($c) => $c['tipo'] === $fTipo));
}
if ($fBusca !== '') {
    $buscaLower = mb_strtolower($fBusca);
    $cadastros = array_values(array_filter($cadastros, function ($c) use ($buscaLower) {
        return str_contains(mb_strtolower($c['nome']), $buscaLower) || str_contains(mb_strtolower((string)$c['email']), $buscaLower);
    }));
}
usort($cadastros, fn($a, $b) => strtotime($b['data']) <=> strtotime($a['data']));

admin_head('Cadastros');
admin_topbar('cadastros');
?>
<main class="admin-main">
  <div class="admin-head"><h1>Cadastros</h1><p>Todo mundo já cadastrado — alunos de curso, leads de aula particular e clientes de propostas comerciais.</p></div>

  <form method="get" class="admin-filter-bar" style="grid-template-columns:1fr 1fr auto;">
    <div class="field">
      <label for="f_busca">Buscar por nome ou e-mail</label>
      <input type="text" id="f_busca" name="f_busca" value="<?= htmlspecialchars($fBusca, ENT_QUOTES) ?>">
    </div>
    <div class="field">
      <label for="f_tipo">Tipo</label>
      <select id="f_tipo" name="f_tipo">
        <option value="">Todos</option>
        <option value="Aluno" <?= $fTipo === 'Aluno' ? 'selected' : '' ?>>Aluno</option>
        <option value="Cliente" <?= $fTipo === 'Cliente' ? 'selected' : '' ?>>Cliente</option>
      </select>
    </div>
    <div class="admin-filter-actions">
      <button type="submit" class="btn btn-primary">Filtrar</button>
      <?php if ($fTipo !== '' || $fBusca !== ''): ?><a class="btn btn-ghost on-light" href="/admin/cadastros.php">Limpar</a><?php endif; ?>
    </div>
  </form>

  <p class="admin-status-filter-summary"><?= count($cadastros) ?> cadastro(s)</p>

  <div class="table-wrap">
    <table class="data-table">
      <thead><tr><th>Nome</th><th>Tipo</th><th>Origem</th><th>E-mail</th><th>CPF/CNPJ</th><th>Telefone</th><th>Data</th><th>Ações</th></tr></thead>
      <tbody>
        <?php if (!$cadastros): ?>
          <tr class="empty-row"><td colspan="8">Nenhum cadastro encontrado.</td></tr>
        <?php endif; ?>
        <?php foreach ($cadastros as $c): ?>
          <tr>
            <td><strong><?= htmlspecialchars($c['nome'], ENT_QUOTES) ?></strong></td>
            <td><span class="admin-status status-<?= $c['tipo'] === 'Aluno' ? 'neutral' : 'success' ?>"><?= htmlspecialchars($c['tipo'], ENT_QUOTES) ?></span></td>
            <td><?= htmlspecialchars($c['origem'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($c['email'] ?: '—', ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($c['documento'] ?: '—', ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($c['telefone'] ?: '—', ENT_QUOTES) ?></td>
            <td><?= date('d/m/Y', strtotime($c['data'])) ?></td>
            <td class="admin-table-actions">
              <a href="<?= htmlspecialchars($c['href'], ENT_QUOTES) ?>"><?= htmlspecialchars($c['acao'] ?? 'Ver', ENT_QUOTES) ?></a>
              <?php if (!empty($c['href_ver'])): ?><a href="<?= htmlspecialchars($c['href_ver'], ENT_QUOTES) ?>">Ver propostas</a><?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>
<?php admin_foot(); ?>
