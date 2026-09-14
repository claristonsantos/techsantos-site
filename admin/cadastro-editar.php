<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/_partials.php';
require_admin();

$pdo = db();
$origem = (string)($_GET['origem'] ?? $_POST['origem'] ?? '');
$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$origensValidas = ['aluno_curso', 'aluno_aula', 'cliente'];
if (!in_array($origem, $origensValidas, true) || $id <= 0) {
    http_response_code(404);
    exit('Cadastro não encontrado.');
}

$error = null;
$success = null;

// Cada origem mapeia pra uma tabela/coluna diferente — não existe uma
// tabela única de "cadastros", essa tela só dá uma cara comum pra editar
// nome/e-mail/documento/telefone sem abrir a tela cheia (curso, valores,
// itens do orçamento etc) que não faz sentido mudar aqui.
if ($origem === 'aluno_curso') {
    $tabela = 'alunos';
    $titulo = 'Editar aluno (curso)';
} elseif ($origem === 'aluno_aula') {
    $tabela = 'aulas_particulares_leads';
    $titulo = 'Editar aluno (aula particular)';
} else {
    $tabela = 'propostas';
    $titulo = 'Editar cliente (proposta comercial)';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $nome = trim((string)($_POST['nome'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    $documento = trim((string)($_POST['documento'] ?? ''));
    $telefone = trim((string)($_POST['telefone'] ?? ''));

    if ($nome === '') {
        $error = 'Informe o nome.';
    } else {
        if ($origem === 'aluno_curso') {
            $cpf = cpf_digits($documento);
            if ($cpf !== '' && !cpf_is_valid($cpf)) {
                $error = 'CPF inválido. Confira os 11 números.';
            } else {
                $pdo->prepare('UPDATE alunos SET nome=?, email=?, cpf=? WHERE id=?')->execute([$nome, $email, $cpf ?: null, $id]);
            }
        } elseif ($origem === 'aluno_aula') {
            $pdo->prepare('UPDATE aulas_particulares_leads SET nome=?, email=?, telefone=? WHERE id=?')->execute([$nome, $email, $telefone, $id]);
        } else {
            $pdo->prepare('UPDATE propostas SET cliente=?, contato_email=?, contato_documento=? WHERE id=?')->execute([$nome, $email ?: null, $documento ?: null, $id]);
        }
        if (!$error) {
            header('Location: /admin/cadastros.php?msg=' . urlencode('Cadastro atualizado.'));
            exit;
        }
    }
}

if ($origem === 'aluno_curso') {
    $stmt = $pdo->prepare('SELECT nome, email, cpf AS documento, NULL AS telefone FROM alunos WHERE id = ?');
} elseif ($origem === 'aluno_aula') {
    $stmt = $pdo->prepare('SELECT nome, email, NULL AS documento, telefone FROM aulas_particulares_leads WHERE id = ?');
} else {
    $stmt = $pdo->prepare('SELECT cliente AS nome, contato_email AS email, contato_documento AS documento, NULL AS telefone FROM propostas WHERE id = ?');
}
$stmt->execute([$id]);
$registro = $stmt->fetch();
if (!$registro) {
    http_response_code(404);
    exit('Cadastro não encontrado.');
}
if (isset($_POST['nome']) && $error) {
    $registro = ['nome' => $_POST['nome'], 'email' => $_POST['email'] ?? '', 'documento' => $_POST['documento'] ?? '', 'telefone' => $_POST['telefone'] ?? ''];
}

admin_head($titulo);
admin_topbar('cadastros');
?>
<main class="admin-main">
  <div class="admin-head"><h1><?= htmlspecialchars($titulo, ENT_QUOTES) ?></h1></div>
  <p style="margin-bottom:1.5rem;"><a href="/admin/cadastros.php" style="color:var(--green-strong); font-size:0.88rem; text-decoration:none;">← Todos os cadastros</a></p>

  <?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES) ?></div><?php endif; ?>
  <?php if ($success): ?><div class="alert alert-success"><?= htmlspecialchars($success, ENT_QUOTES) ?></div><?php endif; ?>

  <div class="form-card">
    <form method="post" novalidate>
      <?= csrf_field() ?>
      <input type="hidden" name="origem" value="<?= htmlspecialchars($origem, ENT_QUOTES) ?>">
      <input type="hidden" name="id" value="<?= $id ?>">
      <div class="field">
        <label for="nome">Nome *</label>
        <input type="text" id="nome" name="nome" required value="<?= htmlspecialchars($registro['nome'] ?? '', ENT_QUOTES) ?>">
      </div>
      <div class="field">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($registro['email'] ?? '', ENT_QUOTES) ?>">
      </div>
      <?php if ($origem !== 'aluno_aula'): ?>
      <div class="field">
        <label for="documento">CPF/CNPJ</label>
        <input type="text" id="documento" name="documento" value="<?= htmlspecialchars($registro['documento'] ?? '', ENT_QUOTES) ?>">
      </div>
      <?php endif; ?>
      <?php if ($origem === 'aluno_aula'): ?>
      <div class="field">
        <label for="telefone">Telefone</label>
        <input type="text" id="telefone" name="telefone" value="<?= htmlspecialchars($registro['telefone'] ?? '', ENT_QUOTES) ?>">
      </div>
      <?php endif; ?>
      <?php if ($origem === 'cliente'): ?>
        <p class="hint">Isso atualiza só o cadastro (nome do cliente e contato). Pra mexer em escopo, valores ou itens da proposta, edite pela tela de Propostas comerciais.</p>
      <?php elseif ($origem === 'aluno_curso'): ?>
        <p class="hint">Isso atualiza só nome/e-mail/CPF. Pra mudar curso, senha ou status, edite pela tela de Alunos.</p>
      <?php else: ?>
        <p class="hint">Isso atualiza só nome/e-mail/telefone. Pra mudar agenda, valor ou status, edite pela tela de Aulas particulares.</p>
      <?php endif; ?>
      <div class="form-actions">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a class="btn btn-ghost on-light" href="/admin/cadastros.php">Cancelar</a>
      </div>
    </form>
  </div>
</main>
<?php admin_foot(); ?>
