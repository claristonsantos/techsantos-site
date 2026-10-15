<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/meta_social.php';
$key = $_GET['key'] ?? '';
if (!hash_equals(SETUP_KEY, $key)) { http_response_code(403); exit('Forbidden.'); }

// Dia dos Professores (15/10/2026). Horários em UTC: Story 16:30 (13h30 Brasília),
// Reels Instagram/Facebook 23:30 (20h30 Brasília), Threads 23:45.
$pdo = db();
$out = [];
$hoje = $pdo->query("SELECT canal, tipo, agendado_para FROM social_posts WHERE agendado_para BETWEEN '2026-10-15 03:00:00' AND '2026-10-16 03:00:00' ORDER BY agendado_para")->fetchAll(PDO::FETCH_ASSOC);
foreach ($hoje as $h) { $out[] = "JA_AGENDADO|{$h['agendado_para']}|{$h['canal']}|{$h['tipo']}"; }

$reel = 'https://media.techsantos.com.br/reels/reel-dia-dos-professores.mp4';
$story = 'https://media.techsantos.com.br/stories/2026-10/1015-dia-dos-professores.jpg';
$legenda = "Feliz Dia dos Professores! 🍎\n\nCada aula aqui é gravada de verdade: tela real, exemplo real e muita revisão por trás de poucos minutos de vídeo.\n\nObrigado a todos os professores que transformam vidas todos os dias — e a você, que escolheu aprender com a gente. 💚\n\nMarque um professor que fez diferença na sua vida. 👇\n\n#DiaDosProfessores #Professor #Educacao #PowerBI #MicrosoftFabric #Excel";
$threads = "Feliz Dia dos Professores! 🍎\n\nObrigado a todos que ensinam todos os dias — e a você, que aprende com a gente. Marque um professor que fez diferença na sua vida.";

$existe = $pdo->prepare("SELECT id FROM social_posts WHERE canal=? AND imagem_url=? LIMIT 1");
$ins = $pdo->prepare("INSERT INTO social_posts (canal,tipo,midia_tipo,legenda,imagem_url,link_url,agendado_para,status,meta_post_id) VALUES (?,?,?,?,?,NULL,?,?,?)");

$existe->execute(['instagram', $story]);
if (!$existe->fetchColumn()) { $ins->execute(['instagram', 'story', 'imagem', '', $story, '2026-10-15 16:30:00', 'pendente', null]); $out[] = "STORY|OK"; } else { $out[] = "STORY|IGNORADO"; }

$existe->execute(['instagram', $reel]);
if (!$existe->fetchColumn()) { $ins->execute(['instagram', 'reels', 'video', $legenda, $reel, '2026-10-15 23:30:00', 'pendente', null]); $out[] = "IG|OK"; } else { $out[] = "IG|IGNORADO"; }

$existe->execute(['threads', $reel]);
if (!$existe->fetchColumn()) { $ins->execute(['threads', 'reels', 'video', $threads, $reel, '2026-10-15 23:45:00', 'pendente', null]); $out[] = "THREADS|OK"; } else { $out[] = "THREADS|IGNORADO"; }

$existe->execute(['facebook', $reel]);
if ($existe->fetchColumn()) {
    $out[] = "FB|IGNORADO";
} else {
    $error = null;
    $vid = meta_schedule_facebook_reel($legenda, $reel, strtotime('2026-10-15 23:30:00 UTC'), $error);
    if ($vid === null) { $out[] = "FB|ERRO|{$error}"; }
    else { $ins->execute(['facebook', 'reels', 'video', $legenda, $reel, '2026-10-15 23:30:00', 'agendado_meta', $vid]); $out[] = "FB|OK|{$vid}"; }
}
header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $out) . "\n";
@unlink(__FILE__);
