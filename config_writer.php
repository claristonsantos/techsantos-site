<?php
declare(strict_types=1);

/**
 * Grava um define('NOME', '...') no config.php do servidor. O config.php fica
 * fora do git, então tokens renovados (Instagram, Threads) são gravados direto
 * aqui — sem aparecer na tela nem passar por chat. Troca atômica via arquivo
 * temporário + rename.
 */
function config_set_define(string $name, string $value, ?string &$error = null): bool
{
    $path = __DIR__ . '/config.php';
    $src = @file_get_contents($path);
    if ($src === false) { $error = 'não consegui ler config.php'; return false; }
    $line = "define('" . $name . "', " . var_export($value, true) . ");";
    $pattern = "/define\\(\\s*'" . preg_quote($name, '/') . "'\\s*,\\s*'[^']*'\\s*\\);/";
    $existed = (bool)preg_match($pattern, $src);
    $new = $existed
        ? preg_replace($pattern, str_replace(['\\', '$'], ['\\\\', '\\$'], $line), $src, 1)
        : rtrim($src) . "\n" . $line . "\n";
    // Trava: config.php quebrado derruba o site inteiro. Só troca o arquivo se
    // a contagem de define( bater e a linha nova estiver lá.
    $expected = substr_count($src, 'define(') + ($existed ? 0 : 1);
    if (!is_string($new) || substr_count($new, 'define(') !== $expected || strpos($new, $line) === false || strpos($new, '<?php') !== 0) {
        $error = 'verificação de segurança falhou, config.php não foi alterado';
        return false;
    }
    $tmp = $path . '.tmp-' . bin2hex(random_bytes(4));
    if (@file_put_contents($tmp, $new, LOCK_EX) === false || !@rename($tmp, $path)) {
        @unlink($tmp);
        $error = 'não consegui gravar config.php';
        return false;
    }
    if (function_exists('opcache_invalidate')) @opcache_invalidate($path, true);
    return true;
}
