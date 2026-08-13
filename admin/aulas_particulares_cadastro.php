<?php
declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../aulas_particulares_config.php';
require_once __DIR__ . '/_partials.php';
require_admin();
csrf_token();

$pdo = db();
$pricing = aulas_config($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $avulsa = max(1, (float)str_replace(',', '.', (string)($_POST['avulsa'] ?? '0')));
    $pacoteHoras = max(0.5, (float)str_replace(',', '.', (string)($_POST['pacote_horas'] ?? '0')));
    $pacoteValor = max(1, (float)str_replace(',', '.', (string)($_POST['pacote_valor'] ?? '0')));
    $mentoria = max(1, (float)str_replace(',', '.', (string)($_POST['mentoria'] ?? '0')));
    $stmt = $pdo->prepare('UPDATE aulas_particulares_config SET avulsa_centavos=?,pacote_horas=?,pacote_centavos=?,mentoria_centavos=? WHERE id=1');
    $stmt->execute([(int)round($avulsa * 100), $pacoteHoras, (int)round($pacoteValor * 100), (int)round($mentoria * 100)]);
    header('Location: /admin/aulas_particulares_cadastro.php?salvo=1');
    exit;
}

admin_head('Cadastro das aulas particulares');
admin_topbar('aulas_particulares_cadastro');
?>
<main class="admin-main" id="adminContent" tabindex="-1">
  <div class="admin-head"><div><span class="admin-eyebrow">Cadastros</span><h1>Cadastro das aulas particulares</h1><p>Configure os valores exibidos na página pública e usados nas propostas.</p></div><div class="admin-head-actions"><a class="btn btn-ghost on-light" href="/admin/aulas_particulares.php">Abrir painel de vendas</a><a class="btn btn-ghost on-light" href="/aulas-particulares-power-bi.php" target="_blank">Ver página pública</a></div></div>
  <?php if (isset($_GET['salvo'])): ?><div class="alert alert-success" role="status">Valores atualizados na página pública e nos cálculos.</div><?php endif; ?>
  <section class="admin-form-section"><div class="form-card"><div class="admin-form-section-head"><h2>Valores e pacote</h2></div>
    <form method="post"><?= csrf_field() ?>
      <div class="field"><label for="avulsa">Aula avulsa · valor por hora</label><input id="avulsa" name="avulsa" type="number" min="1" step="0.01" required value="<?= number_format((int)$pricing['avulsa_centavos']/100,2,'.','') ?>"></div>
      <div class="field"><label for="pacote_horas">Pacote · quantidade de horas</label><input id="pacote_horas" name="pacote_horas" type="number" min="0.5" step="0.5" required value="<?= htmlspecialchars((string)(float)$pricing['pacote_horas'],ENT_QUOTES) ?>"></div>
      <div class="field"><label for="pacote_valor">Pacote · valor total</label><input id="pacote_valor" name="pacote_valor" type="number" min="1" step="0.01" required value="<?= number_format((int)$pricing['pacote_centavos']/100,2,'.','') ?>"></div>
      <div class="field"><label for="mentoria">Mentoria · valor por hora</label><input id="mentoria" name="mentoria" type="number" min="1" step="0.01" required value="<?= number_format((int)$pricing['mentoria_centavos']/100,2,'.','') ?>"></div>
      <div class="form-actions"><button class="btn btn-primary" type="submit">Salvar valores</button></div>
    </form>
  </div></section>
</main>
<?php admin_foot(); ?>
