<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/_partials.php';
require_once __DIR__ . '/../mailer.php';
require_admin();

$pdo = db();
$error = null;
$success = null;

function fetch_cursos(PDO $pdo): array
{
    return $pdo->query('SELECT id, nome FROM cursos WHERE ativo = 1 ORDER BY nome')->fetchAll();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';
    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        $pdo->prepare('DELETE FROM alunos WHERE id = ?')->execute([$id]);
        header('Location: /admin/alunos.php?msg=removido');
        exit;
    }
    if ($action === 'save') {
        $id = (int)($_POST['id'] ?? 0);
        $nome = trim((string)($_POST['nome'] ?? ''));
        $email = trim((string)($_POST['email'] ?? ''));
        $cpf = cpf_digits((string)($_POST['cpf'] ?? ''));
        $cursoId = (int)($_POST['curso_id'] ?? 0);
        $senha = (string)($_POST['senha'] ?? '');
        if ($nome === '' || $email === '' || $cpf === '' || $cursoId === 0) $error = 'Preencha nome, e-mail, CPF e selecione um curso.';
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $error = 'E-mail inválido. Confira o endereço informado.';
        elseif (!cpf_is_valid($cpf)) $error = 'CPF inválido. Confira os 11 números.';
        elseif ($id === 0 && strlen($senha) < 6) $error = 'Defina uma senha com pelo menos 6 caracteres.';
        elseif ($senha !== '' && strlen($senha) < 6) $error = 'A nova senha precisa ter pelo menos 6 caracteres.';
        else {
            $dupStmt = $pdo->prepare('SELECT id FROM alunos WHERE (email = ? OR cpf = ?) AND id != ?');
            $dupStmt->execute([$email, $cpf, $id]);
            if ($dupStmt->fetch()) $error = 'Já existe um aluno com este e-mail ou CPF.';
            else {
                if ($id === 0) {
                    $stmt = $pdo->prepare('INSERT INTO alunos (nome, email, cpf, senha_hash, curso_id) VALUES (?, ?, ?, ?, ?)');
                    $stmt->execute([$nome, $email, $cpf, password_hash($senha, PASSWORD_DEFAULT), $cursoId]);
                    $cursoStmt = $pdo->prepare('SELECT nome FROM cursos WHERE id = ?');
                    $cursoStmt->execute([$cursoId]);
                    $cursoNome = $cursoStmt->fetchColumn() ?: 'Power BI Completo';
                    $emailEnviado = send_enrollment_email($email, $nome, $senha, ['nome' => $cursoNome]);
                    $success = $emailEnviado ? 'Aluno cadastrado e e-mail de matrícula enviado.' : 'Aluno cadastrado, mas o e-mail falhou. Envie o acesso manualmente.';
                } else {
                    if ($senha !== '') {
                        $stmt = $pdo->prepare('UPDATE alunos SET nome=?, email=?, cpf=?, curso_id=?, senha_hash=?, senha_temporaria=1 WHERE id=?');
                        $stmt->execute([$nome, $email, $cpf, $cursoId, password_hash($senha, PASSWORD_DEFAULT), $id]);
                    } else {
                        $stmt = $pdo->prepare('UPDATE alunos SET nome=?, email=?, cpf=?, curso_id=? WHERE id=?');
                        $stmt->execute([$nome, $email, $cpf, $cursoId, $id]);
                    }
                    $success = 'Aluno atualizado com sucesso.';
                }
                header('Location: /admin/alunos.php?msg=' . urlencode($success));
                exit;
            }
        }
    }
}

$editId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$editRow = null;
if ($editId > 0) {
    $stmt = $pdo->prepare('SELECT * FROM alunos WHERE id = ?');
    $stmt->execute([$editId]);
    $editRow = $stmt->fetch();
}
if (isset($_GET['msg']) && !$error) $success = $_GET['msg'] === 'removido' ? 'Aluno removido.' : (string)$_GET['msg'];

$cursos = fetch_cursos($pdo);
$busca = trim((string)($_GET['busca'] ?? ''));
$status = in_array(($_GET['status'] ?? ''), ['ativo', 'inativo'], true) ? (string)$_GET['status'] : '';
$cursoFiltro = max(0, (int)($_GET['curso'] ?? 0));
$pagina = max(1, (int)($_GET['pagina'] ?? 1));
$porPagina = 25;
$where = [];
$params = [];
if ($busca !== '') { $where[] = '(a.nome LIKE ? OR a.email LIKE ? OR a.cpf LIKE ?)'; $like = '%' . $busca . '%'; $params = [$like, $like, $like]; }
if ($status !== '') { $where[] = 'a.ativo = ?'; $params[] = $status === 'ativo' ? 1 : 0; }
if ($cursoFiltro > 0) { $where[] = 'a.curso_id = ?'; $params[] = $cursoFiltro; }
$whereSql = $where ? ' WHERE ' . implode(' AND ', $where) : '';
$countStmt = $pdo->prepare('SELECT COUNT(*) FROM alunos a' . $whereSql);
$countStmt->execute($params);
$totalAlunos = (int)$countStmt->fetchColumn();
$paginas = max(1, (int)ceil($totalAlunos / $porPagina));
$pagina = min($pagina, $paginas);
$offset = ($pagina - 1) * $porPagina;
$stmt = $pdo->prepare('SELECT a.id,a.nome,a.email,a.cpf,a.ativo,c.nome AS curso_nome FROM alunos a JOIN cursos c ON c.id=a.curso_id' . $whereSql . ' ORDER BY a.created_at DESC LIMIT ' . $porPagina . ' OFFSET ' . $offset);
$stmt->execute($params);
$alunos = $stmt->fetchAll();
$showForm = $editRow || isset($_GET['novo']) || $error;

admin_head('Alunos');
admin_topbar('alunos');
?>
<main class="admin-main">
  <div class="admin-head"><div><span class="admin-eyebrow">Vendas e alunos</span><h1>Alunos</h1><p>Cadastros, acessos e acompanhamento da jornada.</p></div><?php if (!$showForm): ?><a class="btn btn-primary" href="/admin/alunos.php?novo=1">Adicionar aluno</a><?php endif; ?></div>
  <?php if ($error): ?><div class="alert alert-error" role="alert"><?= htmlspecialchars($error, ENT_QUOTES) ?></div><?php endif; ?>
  <?php if ($success): ?><div class="alert alert-success" role="status"><?= htmlspecialchars($success, ENT_QUOTES) ?></div><?php endif; ?>

  <?php if ($showForm): ?><section class="admin-form-section" aria-labelledby="formAlunoTitle">
    <div class="admin-form-section-head"><h2 id="formAlunoTitle"><?= $editRow ? 'Editar aluno' : 'Adicionar aluno' ?></h2><a href="/admin/alunos.php">Fechar formulário</a></div>
    <div class="form-card"><form method="post" novalidate>
      <?= csrf_field() ?><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?= (int)($editRow['id'] ?? 0) ?>">
      <div class="field"><label for="nome">Nome completo *</label><input type="text" id="nome" name="nome" required autocomplete="name" value="<?= htmlspecialchars($editRow['nome'] ?? '', ENT_QUOTES) ?>"></div>
      <div class="field-row"><div class="field"><label for="email">E-mail *</label><input type="email" id="email" name="email" required autocomplete="email" value="<?= htmlspecialchars($editRow['email'] ?? '', ENT_QUOTES) ?>"></div><div class="field"><label for="cpf">CPF *</label><input type="text" id="cpf" name="cpf" required inputmode="numeric" maxlength="14" placeholder="000.000.000-00" value="<?= htmlspecialchars($editRow ? cpf_format($editRow['cpf']) : '', ENT_QUOTES) ?>"><span class="hint">Necessário para o certificado.</span></div></div>
      <div class="field"><label for="curso_id">Curso *</label><select id="curso_id" name="curso_id" required><option value="">Selecione…</option><?php foreach ($cursos as $c): ?><option value="<?= (int)$c['id'] ?>" <?= ($editRow && (int)$editRow['curso_id'] === (int)$c['id']) ? 'selected' : '' ?>><?= htmlspecialchars($c['nome'], ENT_QUOTES) ?></option><?php endforeach; ?></select></div>
      <div class="field"><label for="senha"><?= $editRow ? 'Nova senha (opcional)' : 'Senha provisória *' ?></label><input type="text" id="senha" name="senha" autocomplete="new-password" <?= $editRow ? '' : 'required' ?>><button type="button" class="gen-pw-btn" id="genPw">Gerar senha segura</button></div>
      <div class="form-actions"><button type="submit" class="btn btn-primary"><?= $editRow ? 'Salvar alterações' : 'Cadastrar e enviar acesso' ?></button><a class="btn btn-ghost on-light" href="/admin/alunos.php">Cancelar</a></div>
    </form></div>
  </section><?php endif; ?>

  <form class="admin-filter-bar" method="get" aria-label="Filtros de alunos">
    <div class="field"><label for="busca">Buscar</label><input type="search" id="busca" name="busca" placeholder="Nome, e-mail ou CPF" value="<?= htmlspecialchars($busca, ENT_QUOTES) ?>"></div>
    <div class="field"><label for="status">Status</label><select id="status" name="status"><option value="">Todos</option><option value="ativo" <?= $status === 'ativo' ? 'selected' : '' ?>>Ativos</option><option value="inativo" <?= $status === 'inativo' ? 'selected' : '' ?>>Inativos</option></select></div>
    <div class="field"><label for="curso">Curso</label><select id="curso" name="curso"><option value="0">Todos</option><?php foreach ($cursos as $c): ?><option value="<?= (int)$c['id'] ?>" <?= $cursoFiltro === (int)$c['id'] ? 'selected' : '' ?>><?= htmlspecialchars($c['nome'], ENT_QUOTES) ?></option><?php endforeach; ?></select></div>
    <div class="admin-filter-actions"><button class="btn btn-primary" type="submit">Filtrar</button><a class="btn btn-ghost on-light" href="/admin/alunos.php">Limpar</a></div>
  </form>
  <div class="admin-list-head"><div><h2>Cadastros</h2><span><?= $totalAlunos ?> resultado(s)</span></div></div>
  <div class="table-wrap"><table class="data-table"><thead><tr><th>Nome</th><th>E-mail</th><th>CPF</th><th>Curso</th><th>Status</th><th>Ações</th></tr></thead><tbody>
    <?php if (!$alunos): ?><tr class="empty-row"><td colspan="6">Nenhum aluno encontrado com estes filtros.</td></tr><?php endif; ?>
    <?php foreach ($alunos as $a): ?><tr><td><strong><?= htmlspecialchars($a['nome'], ENT_QUOTES) ?></strong></td><td><?= htmlspecialchars($a['email'], ENT_QUOTES) ?></td><td><?= htmlspecialchars(cpf_format((string)$a['cpf']), ENT_QUOTES) ?></td><td><?= htmlspecialchars($a['curso_nome'], ENT_QUOTES) ?></td><td><span class="admin-status status-<?= $a['ativo'] ? 'success' : 'neutral' ?>"><?= $a['ativo'] ? 'Ativo' : 'Inativo' ?></span></td><td><div class="admin-table-actions"><a href="/admin/alunos.php?edit=<?= (int)$a['id'] ?>">Editar</a><a href="/admin/jornada.php?aluno=<?= (int)$a['id'] ?>">Jornada</a><form method="post" onsubmit="return confirm('Remover este aluno? Esta ação não pode ser desfeita.');"><?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$a['id'] ?>"><button type="submit" class="danger">Remover</button></form></div></td></tr><?php endforeach; ?>
  </tbody></table></div>
  <?php admin_pagination($pagina, $paginas, $totalAlunos); ?>
</main>
<?php if ($showForm): ?><script>
var cpf=document.getElementById('cpf'); if(cpf) cpf.addEventListener('input',function(){var d=this.value.replace(/\D/g,'').slice(0,11),v=d;if(d.length>9)v=d.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/,'$1.$2.$3-$4');else if(d.length>6)v=d.replace(/(\d{3})(\d{3})(\d{1,3})/,'$1.$2.$3');else if(d.length>3)v=d.replace(/(\d{3})(\d{1,3})/,'$1.$2');this.value=v;});
document.getElementById('genPw')?.addEventListener('click',function(){var chars='ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789',arr=new Uint32Array(10),pw='';crypto.getRandomValues(arr);for(var i=0;i<10;i++)pw+=chars[arr[i]%chars.length];document.getElementById('senha').value=pw;});
</script><?php endif; ?>
<?php admin_foot(); ?>
