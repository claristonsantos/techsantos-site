<?php
declare(strict_types=1);
require_once __DIR__ . '/lib.php';
// Uso único: testa o leitor de NFC-e com HTML no layout padrão e se o servidor alcança portais da Sefaz. Apaga a si mesmo.
header('Content-Type: text/plain; charset=utf-8');
if (!hash_equals(SETUP_KEY, (string)($_GET['key'] ?? ''))) { http_response_code(403); exit('Forbidden.'); }
@unlink(__FILE__);

$html = '<html><body><div id="conteudo"><div class="txtCenter"><div id="u20" class="txtTopo">SUPERMERCADO EXEMPLO LTDA</div>'
    . '<div class="text">CNPJ: 12.345.678/0001-95</div><div class="text">RUA A, 100, , CENTRO, ITUMBIARA, GO</div></div>'
    . '<table id="tabResult"><tr id="Item + 1"><td><span class="txtTit">ARROZ T1 CAMIL 5KG</span><span class="RCod">(Código: 7896006716112 )</span><br>'
    . '<span class="Rqtd"><strong>Qtde.:</strong>2</span><span class="RUN"><strong>UN: </strong>UN</span><span class="RvlUnit"><strong>Vl. Unit.:</strong>&nbsp;24,99</span></td>'
    . '<td class="txtTit noWrap">Vl. Total<br><span class="valor">49,98</span></td></tr>'
    . '<tr id="Item + 2"><td><span class="txtTit">BANANA PRATA KG</span><span class="RCod">(Código: 1234 )</span><br>'
    . '<span class="Rqtd"><strong>Qtde.:</strong>1,235</span><span class="RUN"><strong>UN: </strong>KG</span><span class="RvlUnit"><strong>Vl. Unit.:</strong>&nbsp;6,49</span></td>'
    . '<td class="txtTit noWrap">Vl. Total<br><span class="valor">8,02</span></td></tr></table>'
    . '<div id="totalNota"><div id="linhaTotal"><label>Valor a pagar R$:</label><span class="totalNumb txtMax">58,00</span></div></div>'
    . '<div id="infos"><ul><li><strong>Número: </strong>123 <strong>Série: </strong>1 <strong>Emissão: </strong>18/11/2026 10:22:33 - Via Consumidor</li></ul>'
    . '<strong>CPF: </strong>123.456.789-09</div></div></body></html>';
echo "LEITOR:\n";
print_r(precos_ler_nfce($html));
echo "GTIN valido 7896006716112: ", var_export(precos_gtin_valido('7896006716112'), true), "\n";
echo "norm: ", precos_normalizar('Café Pilão 500g – extra forte'), "\n";
echo "chave url: ", precos_chave_da_url('https://nfeweb.sefaz.go.gov.br/nfeweb/sites/nfce/danfeNFCe?p=52261112345678000195650010000001231000001234|2|1|1|abc'), "\n";
echo "host ok: ", var_export(precos_host_permitido('http://evil.com/?x=.gov.br'), true), var_export(precos_host_permitido('https://nfce.fazenda.sp.gov.br/x'), true), "\n";

echo "\nALCANCE SEFAZ:\n";
foreach (['https://nfeweb.sefaz.go.gov.br/nfeweb/sites/nfce/danfeNFCe', 'https://www.sefaz.rs.gov.br/NFCE/NFCE-COM.aspx', 'https://www.fazenda.pr.gov.br/nfce/qrcode', 'https://www.nfce.fazenda.sp.gov.br/NFCeConsultaPublica/Paginas/ConsultaQRCode.aspx', 'https://portalsped.fazenda.mg.gov.br/portalnfce/sistema/qrcode.xhtml'] as $u) {
    $r = precos_baixar($u);
    echo $u, ' => ', isset($r['erro']) ? 'ERRO ' . $r['erro'] : 'OK ' . strlen($r['html']) . ' bytes', "\n";
}
$pdo = db();
precos_ensure_schema($pdo);
echo "\nschema ok\n";
