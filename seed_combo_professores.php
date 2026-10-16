<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: agenda os Reels do combo Mês dos Professores (IG + Threads, horários UTC). Publicado pelo social_publish_cron.php.
$posts = json_decode(<<<'JSON'
[{"canal": "instagram", "when": "2026-10-16 22:00:00", "text": "Outubro é o mês dos professores e aqui na Tech Santos BR quem ganha presente é você 🎁\n\nAté 31/10, quem comprar o curso de Power BI leva o curso de Excel completo junto, sem pagar nada a mais:\n✅ Power BI: modelagem, Power Query, DAX e dashboards\n✅ Excel: 68 videoaulas, do básico às macros, preparatório MO-210/MO-211\n✅ Os dois na mesma conta, com acesso vitalício\n\n2 cursos por R$ 129,90. Comenta COMBO que eu te mando o link 👇\n\n#powerbi #excel #cursodepowerbi #cursodeexcel #diadosprofessores #analisededados", "url": "https://media.techsantos.com.br/reels/promo-combo-selfie.mp4"}, {"canal": "threads", "when": "2026-10-16 22:30:00", "text": "Outubro é o mês dos professores, e aqui quem ganha presente é você.\n\nAté 31/10: comprou o curso de Power BI, leva o curso de Excel completo junto (68 videoaulas, do básico às macros). Os dois na mesma conta, acesso vitalício, R$ 129,90.\n\ntechsantos.com.br/curso-power-bi.php", "url": "https://media.techsantos.com.br/reels/promo-combo-selfie.mp4"}, {"canal": "instagram", "when": "2026-10-22 22:00:00", "text": "Compre o Power BI e leve o Excel de presente 🎁\n\nNo mês dos professores, quem entra no curso de Power BI ganha o curso de Excel completo: a base no Excel e os dashboards no Power BI, liberados na mesma conta.\n\nR$ 129,90 pelos dois, só até 31/10. Comenta COMBO que eu te mando o link 👇\n\n#powerbi #excel #cursodepowerbi #cursodeexcel #diadosprofessores #analisededados", "url": "https://media.techsantos.com.br/reels/promo-combo-presente.mp4"}, {"canal": "threads", "when": "2026-10-22 22:30:00", "text": "Power BI + Excel de presente, só em outubro.\n\nO Excel como base, o Power BI pros seus dashboards. Dois cursos completos na mesma conta por R$ 129,90 até 31/10.\n\ntechsantos.com.br/curso-power-bi.php", "url": "https://media.techsantos.com.br/reels/promo-combo-presente.mp4"}, {"canal": "instagram", "when": "2026-10-28 22:00:00", "text": "R$ 226 em cursos por R$ 129,90 ⏳\n\nAprender Power BI sem base de Excel é começar a casa pelo telhado. Por isso, até 31/10, o curso de Excel vai de presente para quem compra o Power BI. Liberado na hora, na mesma conta, acesso vitalício aos dois.\n\nÚltimos dias! Comenta COMBO que eu te mando o link 👇\n\n#powerbi #excel #cursodepowerbi #cursodeexcel #diadosprofessores #analisededados", "url": "https://media.techsantos.com.br/reels/promo-combo-urgencia.mp4"}, {"canal": "threads", "when": "2026-10-28 22:30:00", "text": "Últimos dias: R$ 226 em cursos por R$ 129,90.\n\nQuem compra o curso de Power BI até 31/10 leva o curso de Excel de presente, liberado na hora na mesma conta.\n\ntechsantos.com.br/curso-power-bi.php", "url": "https://media.techsantos.com.br/reels/promo-combo-urgencia.mp4"}]
JSON, true);
$pdo = db();
$exists = $pdo->prepare("SELECT id FROM social_posts WHERE canal=? AND agendado_para=? AND imagem_url=? LIMIT 1");
$ins = $pdo->prepare("INSERT INTO social_posts (canal,tipo,midia_tipo,legenda,imagem_url,agendado_para,status) VALUES (?,'reels','video',?,?,?,'pendente')");
header('Content-Type: text/plain; charset=utf-8');
foreach ($posts as $p) {
    $h = @get_headers($p['url'], true);
    if (!is_array($h) || !str_contains((string)($h[0] ?? ''), '200')) { echo "MIDIA|ERRO|{$p['canal']}|{$p['when']}
"; continue; }
    $exists->execute([$p['canal'], $p['when'], $p['url']]);
    if ($exists->fetchColumn()) { echo "IGNORADO|{$p['canal']}|{$p['when']}
"; continue; }
    $ins->execute([$p['canal'], $p['text'], $p['url'], $p['when']]);
    echo "OK|id={$pdo->lastInsertId()}|{$p['canal']}|{$p['when']}
";
}
@unlink(__FILE__);
