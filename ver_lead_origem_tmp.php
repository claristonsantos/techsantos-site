<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único, somente leitura: origem (UTM/landing) do lead Villela + resumo de origem dos leads de consultoria.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
$pdo = db();
$q = function (string $t, string $sql) use ($pdo) { echo "== $t\n"; try { foreach ($pdo->query($sql) as $r) echo "  " . implode(' | ', array_map(fn($k, $v) => "$k=$v", array_keys($r), $r)) . "\n"; } catch (Throwable $e) { echo "  ERRO " . $e->getMessage() . "\n"; } };
$q('lead villela', "SELECT id, criado_em, origem, utm_source, utm_medium, utm_campaign, utm_content, utm_term, landing_page FROM consultoria_leads WHERE empresa LIKE '%villela%' ORDER BY id DESC LIMIT 3");
$q('leads consultoria por origem (todos)', "SELECT COALESCE(utm_source,'(sem utm)') src, COALESCE(utm_medium,'-') med, COALESCE(utm_campaign,'-') camp, COUNT(*) n, MAX(criado_em) ultimo FROM consultoria_leads GROUP BY src, med, camp ORDER BY ultimo DESC");
