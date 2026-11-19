<?php
declare(strict_types=1);
require_once __DIR__ . '/lib.php';
header('Content-Type: text/plain; charset=utf-8');
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
@unlink(__FILE__);
foreach (['https://www.sefaz.rs.gov.br/NFCE/NFCE-COM.aspx', 'https://www.fazenda.pr.gov.br/nfce/qrcode'] as $u) {
    $r = precos_baixar($u);
    echo $u, ' => ', isset($r['erro']) ? 'ERRO ' . $r['erro'] : 'OK ' . strlen($r['html']) . ' bytes', "\n";
}
