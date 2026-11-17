<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
// Uso único: confirma que pedidos.php/mailer.php carregam e os slugs do mapa Hotmart existem. Só leitura.
header('Content-Type: text/plain; charset=utf-8');
@unlink(__FILE__);
require_once __DIR__ . '/pedidos.php';
echo 'funcoes: ' . (function_exists('marcar_pedido_pago') && function_exists('send_enrollment_email') ? 'ok' : 'FALTA') . "\n";
foreach (db()->query("SELECT slug, nome, ativo, preco_centavos FROM cursos WHERE slug IN ('power-bi','excel','python','ingles')") as $r) echo json_encode($r, JSON_UNESCAPED_UNICODE) . "\n";
