<?php
declare(strict_types=1);
require_once __DIR__ . '/../db.php';

/*
 * Comparador de preços de supermercado (protótipo, teste em família).
 * Os preços vêm do QR code da NFC-e: o link abre a consulta pública da Sefaz,
 * cuja página traz todos os itens com preço, quantidade, data e CNPJ da loja.
 * O servidor baixa essa página, extrai os itens e grava. CPF do consumidor
 * nunca é gravado. Preço de prateleira entra pelo cadastro manual.
 */

// Hash SHA-256 do código de convite da família (o código em si não fica no repositório).
const PRECOS_CONVITE_HASH = '1b84f38bda2d6c5a3e390e19d9605be196e1d5679214cf6b93e3e6a4626608c2';
const PRECOS_COOKIE = 'precos_token';

const PRECOS_UF = [
    '11' => 'RO', '12' => 'AC', '13' => 'AM', '14' => 'RR', '15' => 'PA', '16' => 'AP', '17' => 'TO',
    '21' => 'MA', '22' => 'PI', '23' => 'CE', '24' => 'RN', '25' => 'PB', '26' => 'PE', '27' => 'AL',
    '28' => 'SE', '29' => 'BA', '31' => 'MG', '32' => 'ES', '33' => 'RJ', '35' => 'SP', '41' => 'PR',
    '42' => 'SC', '43' => 'RS', '50' => 'MS', '51' => 'MT', '52' => 'GO', '53' => 'DF',
];

function precos_ensure_schema(PDO $pdo): void
{
    static $done = false;
    if ($done) return;
    $done = true;
    $pdo->exec("CREATE TABLE IF NOT EXISTS precos_usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(60) NOT NULL,
        token_hash CHAR(64) NOT NULL UNIQUE,
        criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    $pdo->exec("CREATE TABLE IF NOT EXISTS precos_lojas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        cnpj CHAR(14) NULL UNIQUE,
        nome VARCHAR(150) NOT NULL,
        endereco VARCHAR(255) NOT NULL DEFAULT '',
        criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    $pdo->exec("CREATE TABLE IF NOT EXISTS precos_notas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        chave CHAR(44) NOT NULL UNIQUE,
        uf CHAR(2) NOT NULL DEFAULT '',
        loja_id INT NOT NULL,
        usuario_id INT NOT NULL,
        emitida_em DATETIME NULL,
        total_centavos INT NOT NULL DEFAULT 0,
        itens INT NOT NULL DEFAULT 0,
        criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    $pdo->exec("CREATE TABLE IF NOT EXISTS precos_itens (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nota_id INT NULL,
        loja_id INT NOT NULL,
        usuario_id INT NOT NULL,
        descricao VARCHAR(200) NOT NULL,
        descricao_norm VARCHAR(200) NOT NULL,
        codigo VARCHAR(30) NOT NULL DEFAULT '',
        chave_produto VARCHAR(220) NOT NULL,
        quantidade DECIMAL(12,4) NOT NULL DEFAULT 1,
        unidade VARCHAR(10) NOT NULL DEFAULT '',
        preco_unit_centavos INT NOT NULL,
        data_preco DATETIME NOT NULL,
        origem ENUM('nfce','manual') NOT NULL,
        criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        KEY idx_produto (chave_produto(100)),
        KEY idx_desc (descricao_norm(100)),
        KEY idx_data (data_preco)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    // Páginas da Sefaz que o leitor não entendeu (CPF mascarado): servem para adaptar o leitor a cada estado.
    $pdo->exec("CREATE TABLE IF NOT EXISTS precos_falhas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        host VARCHAR(120) NOT NULL,
        motivo VARCHAR(200) NOT NULL,
        html MEDIUMTEXT NULL,
        criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
}

function precos_usuario_atual(PDO $pdo): ?array
{
    $token = (string)($_COOKIE[PRECOS_COOKIE] ?? '');
    if (!preg_match('/^[a-f0-9]{64}$/', $token)) return null;
    $st = $pdo->prepare('SELECT id, nome FROM precos_usuarios WHERE token_hash = ?');
    $st->execute([hash('sha256', $token)]);
    return $st->fetch() ?: null;
}

function precos_entrar(PDO $pdo, string $nome, string $convite): ?array
{
    $nome = trim(preg_replace('/\s+/', ' ', $nome) ?? '');
    if ($nome === '' || mb_strlen($nome) > 60) return null;
    if (!hash_equals(PRECOS_CONVITE_HASH, hash('sha256', strtoupper(trim($convite))))) return null;
    $token = bin2hex(random_bytes(32));
    $pdo->prepare('INSERT INTO precos_usuarios (nome, token_hash) VALUES (?, ?)')->execute([$nome, hash('sha256', $token)]);
    setcookie(PRECOS_COOKIE, $token, [
        'expires' => time() + 365 * 86400, 'path' => '/precos/', 'secure' => true, 'httponly' => true, 'samesite' => 'Lax',
    ]);
    return ['id' => (int)$pdo->lastInsertId(), 'nome' => $nome];
}

function precos_normalizar(string $s): string
{
    $s = mb_strtoupper(trim($s), 'UTF-8');
    $s = strtr($s, ['Á'=>'A','À'=>'A','Â'=>'A','Ã'=>'A','Ä'=>'A','É'=>'E','Ê'=>'E','È'=>'E','Í'=>'I','Ì'=>'I','Ó'=>'O','Ô'=>'O','Õ'=>'O','Ò'=>'O','Ú'=>'U','Ù'=>'U','Ü'=>'U','Ç'=>'C']);
    $s = preg_replace('/[^A-Z0-9,.\/ ]+/', ' ', $s) ?? $s;
    return trim(preg_replace('/\s+/', ' ', $s) ?? $s);
}

function precos_gtin_valido(string $c): bool
{
    if (!preg_match('/^\d{8}$|^\d{12,14}$/', $c)) return false;
    $d = array_map('intval', str_split(str_pad($c, 14, '0', STR_PAD_LEFT)));
    $soma = 0;
    for ($i = 0; $i < 13; $i++) $soma += $d[$i] * ($i % 2 === 0 ? 3 : 1);
    return (10 - $soma % 10) % 10 === $d[13];
}

// Mesmo produto em mercados diferentes: pelo código de barras quando a nota traz um GTIN válido; senão, pela descrição normalizada.
function precos_chave_produto(string $codigo, string $descNorm): string
{
    return precos_gtin_valido($codigo) ? 'gtin:' . ltrim($codigo, '0') : 'desc:' . $descNorm;
}

function precos_num(string $s): float
{
    $s = trim(str_replace(["\xc2\xa0", ' ', 'R$'], '', $s));
    if (strpos($s, ',') !== false) $s = str_replace(['.', ','], ['', '.'], $s);
    return (float)$s;
}

function precos_host_permitido(string $url): bool
{
    $p = parse_url($url);
    if (!$p || !in_array(strtolower($p['scheme'] ?? ''), ['http', 'https'], true)) return false;
    if (isset($p['port']) || isset($p['user'])) return false;
    $host = strtolower($p['host'] ?? '');
    return (bool)preg_match('/^[a-z0-9.-]+\.gov\.br$/', $host);
}

// Baixa a página só de domínios *.gov.br, seguindo no máximo 3 redirecionamentos (cada um conferido).
function precos_baixar(string $url): array
{
    // Mesmo handle em todos os saltos: alguns portais (RS) gravam cookie e redirecionam para a mesma página.
    $ch = curl_init();
    for ($i = 0; $i < 6; $i++) {
        if (!precos_host_permitido($url)) { curl_close($ch); return ['erro' => 'endereco fora da Sefaz']; }
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_COOKIEFILE => '',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_ENCODING => '',
            CURLOPT_PROTOCOLS => CURLPROTO_HTTP | CURLPROTO_HTTPS,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Linux; Android 14) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0 Mobile Safari/537.36',
            CURLOPT_HTTPHEADER => ['Accept: text/html,application/xhtml+xml', 'Accept-Language: pt-BR,pt;q=0.9'],
        ]);
        $html = curl_exec($ch);
        $code = (int)curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $destino = (string)curl_getinfo($ch, CURLINFO_REDIRECT_URL);
        $err = curl_error($ch);
        if ($html === false) { curl_close($ch); return ['erro' => 'Sefaz nao respondeu (' . $err . ')']; }
        if ($code >= 300 && $code < 400 && $destino !== '') { $url = $destino; continue; }
        curl_close($ch);
        if ($code !== 200) return ['erro' => 'Sefaz respondeu HTTP ' . $code];
        if (stripos(substr($html, 0, 3000), 'charset=iso-8859-1') !== false || !mb_check_encoding($html, 'UTF-8')) {
            $html = mb_convert_encoding($html, 'UTF-8', 'ISO-8859-1');
        }
        return ['html' => $html, 'url' => $url];
    }
    curl_close($ch);
    return ['erro' => 'redirecionamentos demais'];
}

function precos_txt(?DOMNode $n): string
{
    return $n ? trim(preg_replace('/\s+/u', ' ', str_replace("\xc2\xa0", ' ', $n->textContent)) ?? '') : '';
}

/*
 * Leitor do layout padrão nacional da consulta NFC-e (portal da maioria dos estados):
 * itens em #tabResult com .txtTit (descrição), .RCod, .Rqtd, .RUN, .RvlUnit;
 * emitente em #u20/.txtTopo; data em "Emissão:". Retorna null se não reconhecer.
 */
function precos_ler_nfce(string $html): ?array
{
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML('<?xml encoding="UTF-8">' . $html);
    libxml_clear_errors();
    $x = new DOMXPath($dom);
    $cls = static fn(string $c) => "contains(concat(' ', normalize-space(@class), ' '), ' $c ')";

    $itens = [];
    foreach ($x->query("//table[@id='tabResult']//tr") as $tr) {
        $desc = precos_txt($x->query(".//span[{$cls('txtTit')} or {$cls('txtTit2')}]", $tr)->item(0));
        $unit = precos_txt($x->query(".//span[{$cls('RvlUnit')}]", $tr)->item(0));
        if ($desc === '' || $unit === '') continue;
        $cod = precos_txt($x->query(".//span[{$cls('RCod')}]", $tr)->item(0));
        $qtd = precos_txt($x->query(".//span[{$cls('Rqtd')}]", $tr)->item(0));
        $un = precos_txt($x->query(".//span[{$cls('RUN')}]", $tr)->item(0));
        preg_match('/[\d.,]+/', str_replace(['Vl. Unit.:', 'Vl.Unit.:'], '', $unit), $mu);
        preg_match('/[\d.,]+/', str_replace('Qtde.:', '', $qtd), $mq);
        preg_match('/(\d+)/', $cod, $mc);
        $preco = (int)round(precos_num($mu[0] ?? '0') * 100);
        if ($preco <= 0) continue;
        $itens[] = [
            'descricao' => mb_substr($desc, 0, 200),
            'codigo' => $mc[1] ?? '',
            'quantidade' => precos_num($mq[0] ?? '1') ?: 1,
            'unidade' => mb_substr(trim(str_replace('UN:', '', $un)), 0, 10),
            'preco' => $preco,
        ];
    }
    if (!$itens) return null;

    $emitente = precos_txt($x->query("//*[@id='u20'] | //div[{$cls('txtTopo')}]")->item(0));
    $textos = [];
    foreach ($x->query("//div[@id='conteudo']//div[{$cls('text')}] | //div[{$cls('txtCenter')}]//div[{$cls('text')}]") as $d) $textos[] = precos_txt($d);
    $todo = precos_txt($dom->documentElement);
    preg_match('/CNPJ:?\s*([\d.\/-]{14,18})/', $todo, $mcnpj);
    $endereco = '';
    foreach ($textos as $t) {
        if (stripos($t, 'CNPJ') === false && $t !== '' && preg_match('/[A-Za-z]/', $t)) { $endereco = $t; break; }
    }
    preg_match('/Emiss[ãa]o:?\s*(\d{2})\/(\d{2})\/(\d{4})\s+(\d{2}:\d{2}:\d{2})/u', $todo, $md);
    preg_match('/Valor a pagar R\$:?\s*([\d.,]+)/u', $todo, $mt);

    return [
        'loja_nome' => mb_substr($emitente ?: 'Loja sem nome', 0, 150),
        'cnpj' => preg_replace('/\D/', '', $mcnpj[1] ?? '') ?? '',
        'endereco' => mb_substr($endereco, 0, 255),
        'emitida_em' => $md ? "{$md[3]}-{$md[2]}-{$md[1]} {$md[4]}" : null,
        'total' => (int)round(precos_num($mt[1] ?? '0') * 100),
        'itens' => $itens,
    ];
}

function precos_registrar_falha(PDO $pdo, string $url, string $motivo, ?string $html): void
{
    if ($html !== null) {
        // Nunca guarda CPF do consumidor.
        $html = preg_replace('/\d{3}\.?\d{3}\.?\d{3}-?\d{2}(?!\d)/', '***CPF***', mb_substr($html, 0, 400000)) ?? '';
    }
    $pdo->prepare('INSERT INTO precos_falhas (host, motivo, html) VALUES (?, ?, ?)')
        ->execute([mb_substr((string)parse_url($url, PHP_URL_HOST), 0, 120), mb_substr($motivo, 0, 200), $html]);
}

function precos_loja(PDO $pdo, string $cnpj, string $nome, string $endereco): int
{
    if ($cnpj !== '') {
        $st = $pdo->prepare('SELECT id FROM precos_lojas WHERE cnpj = ?');
        $st->execute([$cnpj]);
        $id = $st->fetchColumn();
        if ($id !== false) return (int)$id;
        $pdo->prepare('INSERT INTO precos_lojas (cnpj, nome, endereco) VALUES (?, ?, ?)')->execute([$cnpj, $nome, $endereco]);
        return (int)$pdo->lastInsertId();
    }
    $st = $pdo->prepare('SELECT id FROM precos_lojas WHERE cnpj IS NULL AND nome = ?');
    $st->execute([$nome]);
    $id = $st->fetchColumn();
    if ($id !== false) return (int)$id;
    $pdo->prepare('INSERT INTO precos_lojas (cnpj, nome, endereco) VALUES (NULL, ?, ?)')->execute([$nome, $endereco]);
    return (int)$pdo->lastInsertId();
}

function precos_chave_da_url(string $url): string
{
    $q = (string)parse_url($url, PHP_URL_QUERY);
    parse_str($q, $params);
    foreach (['p', 'chNFe', 'chave'] as $k) {
        if (isset($params[$k]) && preg_match('/(\d{44})/', (string)$params[$k], $m)) return $m[1];
    }
    return preg_match('/(\d{44})/', $url, $m) ? $m[1] : '';
}

function precos_importar_nota(PDO $pdo, int $usuarioId, string $url): array
{
    $url = trim($url);
    if (!precos_host_permitido($url)) return ['ok' => false, 'msg' => 'Esse QR code não é de nota fiscal (link fora da Sefaz).'];
    $chave = precos_chave_da_url($url);
    if ($chave === '') return ['ok' => false, 'msg' => 'Não achei a chave de 44 dígitos nesse QR code.'];
    $st = $pdo->prepare('SELECT id FROM precos_notas WHERE chave = ?');
    $st->execute([$chave]);
    if ($st->fetchColumn() !== false) return ['ok' => false, 'msg' => 'Essa nota já foi registrada. Obrigado!'];

    $r = precos_baixar($url);
    if (isset($r['erro'])) {
        precos_registrar_falha($pdo, $url, $r['erro'], null);
        return ['ok' => false, 'msg' => 'Não consegui abrir a nota na Sefaz agora: ' . $r['erro'] . '. Tente de novo mais tarde.'];
    }
    $nota = precos_ler_nfce($r['html']);
    if ($nota === null && preg_match('/<iframe[^>]+src="([^"]+)"/i', $r['html'], $mf)) {
        $src = html_entity_decode($mf[1]);
        if (!preg_match('#^https?://#', $src)) {
            $base = parse_url($r['url']);
            $src = $base['scheme'] . '://' . $base['host'] . (str_starts_with($src, '/') ? '' : '/') . $src;
        }
        $r2 = precos_baixar($src);
        if (isset($r2['html'])) { $nota = precos_ler_nfce($r2['html']); if ($nota === null) $r = $r2; }
    }
    if ($nota === null) {
        $captcha = stripos($r['html'], 'captcha') !== false;
        precos_registrar_falha($pdo, $url, $captcha ? 'captcha' : 'layout nao reconhecido', $r['html']);
        return ['ok' => false, 'msg' => $captcha
            ? 'A Sefaz desse estado pediu captcha, então não dá para ler automático. Use o cadastro manual.'
            : 'Ainda não sei ler a nota desse estado. Guardei a página para adaptar o leitor.'];
    }

    $uf = PRECOS_UF[substr($chave, 0, 2)] ?? '';
    $quando = $nota['emitida_em'] ?? date('Y-m-d H:i:s');
    $pdo->beginTransaction();
    try {
        $lojaId = precos_loja($pdo, $nota['cnpj'], $nota['loja_nome'], $nota['endereco']);
        $pdo->prepare('INSERT INTO precos_notas (chave, uf, loja_id, usuario_id, emitida_em, total_centavos, itens) VALUES (?, ?, ?, ?, ?, ?, ?)')
            ->execute([$chave, $uf, $lojaId, $usuarioId, $nota['emitida_em'], $nota['total'], count($nota['itens'])]);
        $notaId = (int)$pdo->lastInsertId();
        $ins = $pdo->prepare('INSERT INTO precos_itens (nota_id, loja_id, usuario_id, descricao, descricao_norm, codigo, chave_produto, quantidade, unidade, preco_unit_centavos, data_preco, origem) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, \'nfce\')');
        foreach ($nota['itens'] as $it) {
            $norm = precos_normalizar($it['descricao']);
            $ins->execute([$notaId, $lojaId, $usuarioId, $it['descricao'], $norm, $it['codigo'], precos_chave_produto($it['codigo'], $norm),
                $it['quantidade'], $it['unidade'], $it['preco'], $quando]);
        }
        $pdo->commit();
    } catch (Throwable $e) {
        $pdo->rollBack();
        throw $e;
    }
    return ['ok' => true, 'msg' => count($nota['itens']) . ' preços registrados de ' . $nota['loja_nome'] . '.', 'loja' => $nota['loja_nome'], 'itens' => count($nota['itens'])];
}

function precos_buscar(PDO $pdo, string $termo): array
{
    $tokens = array_values(array_filter(explode(' ', precos_normalizar($termo)), static fn($t) => mb_strlen($t) >= 2));
    if (!$tokens) return [];
    $params = array_map(static fn($t) => '%' . $t . '%', array_slice($tokens, 0, 6));
    $where = implode(' AND ', array_fill(0, count($params), 'i.descricao_norm LIKE ?'));
    $st = $pdo->prepare("SELECT i.descricao, i.chave_produto, i.unidade, i.preco_unit_centavos, i.data_preco, i.origem, l.id AS loja_id, l.nome AS loja, l.endereco
                         FROM precos_itens i JOIN precos_lojas l ON l.id = i.loja_id
                         WHERE $where ORDER BY i.data_preco DESC, i.id DESC LIMIT 800");
    $st->execute($params);
    $produtos = [];
    foreach ($st as $r) {
        $k = $r['chave_produto'];
        if (!isset($produtos[$k])) $produtos[$k] = ['descricao' => $r['descricao'], 'unidade' => $r['unidade'], 'lojas' => []];
        if (isset($produtos[$k]['lojas'][$r['loja_id']])) continue; // fica só o preço mais recente de cada loja
        $produtos[$k]['lojas'][$r['loja_id']] = [
            'loja' => $r['loja'], 'endereco' => $r['endereco'], 'preco' => (int)$r['preco_unit_centavos'],
            'data' => $r['data_preco'], 'origem' => $r['origem'],
        ];
    }
    $out = [];
    foreach ($produtos as $p) {
        $lojas = array_values($p['lojas']);
        usort($lojas, static fn($a, $b) => $a['preco'] <=> $b['preco']);
        $p['lojas'] = $lojas;
        $out[] = $p;
    }
    usort($out, static fn($a, $b) => count($b['lojas']) <=> count($a['lojas']));
    return array_slice($out, 0, 40);
}
