<?php
declare(strict_types=1);if(php_sapi_name()!=='cli'){http_response_code(403);exit('CLI only.');}require_once __DIR__.'/aulas_particulares_automacao.php';$pdo=db();aulas_automation_ensure($pdo);
$windows=[['24h','lembrete_24h_em',23*60,25*60],['1h','lembrete_1h_em',30,90]];
foreach($windows as[$label,$column,$minMinutes,$maxMinutes]){$stmt=$pdo->query("SELECT * FROM aulas_particulares_leads WHERE status='pago' AND data_aula IS NOT NULL AND {$column} IS NULL AND TIMESTAMPDIFF(MINUTE,NOW(),data_aula) BETWEEN {$minMinutes} AND {$maxMinutes}");foreach($stmt->fetchAll() as$lead){if(aulas_send_reminder($lead,$label)){$pdo->prepare("UPDATE aulas_particulares_leads SET {$column}=NOW(),email_ultimo_erro=NULL WHERE id=?")->execute([$lead['id']]);echo "aula {$lead['id']} {$label}: enviado\n";}else{$pdo->prepare('UPDATE aulas_particulares_leads SET email_ultimo_erro=? WHERE id=?')->execute(["Falha no lembrete {$label}",$lead['id']]);echo "aula {$lead['id']} {$label}: falha\n";}}}

