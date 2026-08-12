<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';

function aulas_config_ensure(PDO $pdo): void
{
    $pdo->exec("CREATE TABLE IF NOT EXISTS aulas_particulares_config (
        id TINYINT PRIMARY KEY,
        avulsa_centavos INT NOT NULL DEFAULT 8000,
        pacote_horas DECIMAL(5,2) NOT NULL DEFAULT 5,
        pacote_centavos INT NOT NULL DEFAULT 35000,
        mentoria_centavos INT NOT NULL DEFAULT 12000,
        atualizado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    $pdo->exec("INSERT IGNORE INTO aulas_particulares_config (id,avulsa_centavos,pacote_horas,pacote_centavos,mentoria_centavos) VALUES (1,8000,5,35000,12000)");
}

function aulas_config(PDO $pdo): array
{
    aulas_config_ensure($pdo);
    $row = $pdo->query('SELECT * FROM aulas_particulares_config WHERE id=1')->fetch();
    return $row ?: ['avulsa_centavos'=>8000,'pacote_horas'=>5,'pacote_centavos'=>35000,'mentoria_centavos'=>12000];
}

function aulas_money(int $centavos): string
{
    return 'R$ ' . number_format($centavos / 100, 2, ',', '.');
}

