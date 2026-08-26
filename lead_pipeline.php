<?php
declare(strict_types=1);

function lead_pipeline_ensure_schema(PDO $pdo): void
{
    $pdo->exec("CREATE TABLE IF NOT EXISTS whatsapp_lead_pipeline (
        lead_id INT NOT NULL PRIMARY KEY,
        status VARCHAR(30) NOT NULL DEFAULT 'novo',
        ultimo_contato_em DATETIME NULL,
        proxima_acao_em DATETIME NULL,
        observacoes TEXT NULL,
        atualizado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_whatsapp_pipeline_status (status),
        INDEX idx_whatsapp_pipeline_proxima (proxima_acao_em)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
}

function lead_pipeline_local_phone(string $raw): string
{
    $digits = preg_replace('/\D/', '', $raw) ?? '';
    return str_starts_with($digits, '55') && strlen($digits) > 11 ? substr($digits, 2) : $digits;
}

function lead_pipeline_mark_purchase(PDO $pdo, string $phone): int
{
    $localPhone = lead_pipeline_local_phone($phone);
    if (strlen($localPhone) < 10) return 0;
    lead_pipeline_ensure_schema($pdo);
    $stmt = $pdo->prepare("SELECT id FROM whatsapp_leads
        WHERE (CASE WHEN LEFT(telefone,2)='55' AND CHAR_LENGTH(telefone)>11 THEN SUBSTRING(telefone,3) ELSE telefone END) = ?");
    $stmt->execute([$localPhone]);
    $leadIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $upsert = $pdo->prepare("INSERT INTO whatsapp_lead_pipeline (lead_id,status,proxima_acao_em)
        VALUES (?,'comprou',NULL)
        ON DUPLICATE KEY UPDATE status='comprou',proxima_acao_em=NULL");
    foreach ($leadIds as $leadId) $upsert->execute([(int)$leadId]);
    return count($leadIds);
}

function lead_pipeline_backfill_purchases(PDO $pdo): int
{
    lead_pipeline_ensure_schema($pdo);
    $sql = "INSERT INTO whatsapp_lead_pipeline (lead_id,status,proxima_acao_em)
        SELECT DISTINCT w.id,'comprou',NULL
        FROM whatsapp_leads w
        JOIN pedidos p ON
          (CASE WHEN LEFT(w.telefone,2)='55' AND CHAR_LENGTH(w.telefone)>11 THEN SUBSTRING(w.telefone,3) ELSE w.telefone END)
          =
          (CASE WHEN LEFT(p.telefone,2)='55' AND CHAR_LENGTH(p.telefone)>11 THEN SUBSTRING(p.telefone,3) ELSE p.telefone END)
        WHERE p.status='pago' AND CHAR_LENGTH(w.telefone)>=10
        ON DUPLICATE KEY UPDATE status='comprou',proxima_acao_em=NULL";
    return $pdo->exec($sql);
}