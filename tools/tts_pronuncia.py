# -*- coding: utf-8 -*-
"""Correções fonéticas para termos que o edge-tts (voz pt-BR-AntonioNeural)
lê errado em português. Cada uma foi confirmada por ouvido pelo usuário,
comparando opções lado a lado antes de aplicar.

Aplicar SOMENTE ao texto que vai para o motor de TTS, nunca às legendas
ou texto exibido na tela (que devem continuar com a grafia correta).
"""
import re

PRONUNCIATION_FIXES = [
    (r"\bPower BI\b", "Páuer Bi Ai"),
    (r"\bBR\b", "Bê Erre"),
    (r"\bPROCV\b", "PROC Vê"),
    (r"\bPROCX\b", "PROC Xis"),
    (r"\bDAX\b", "Dáks"),
    (r"\bdashboards\b", "déshibórdis"),
    (r"\bdashboard\b", "déshibórdi"),
    (r"\bControl T\b", "Control Tê"),
    (r"\bCtrl\+T\b", "Control Tê"),
    (r"\bDirectQuery\b", "Dairét Cuéri"),
    (r"\bCopilot\b", "Cópaylôt"),
    (r"\bPython\b", "Páiton"),
    (r"\bField [Pp]arameters\b", "Fiuld Páramiters"),
    # Termos do Microsoft Fabric — teste A/B com o usuário em 2026-09-26
    # (28 termos). Só entram aqui os que ele escolheu a alternativa (B); os
    # demais soaram bem na leitura padrão e ficam sem substituição:
    # Microsoft Fabric, OneLake, Spark, T-SQL, SKU, F64, CUs, PPU, workspace,
    # pipeline, Parquet, Purview, Direct Lake, Power Query.
    # Plurais usam a mesma grafia aprovada do singular (não foram testados à
    # parte). PySpark antes de Spark para a regra específica vencer.
    (r"\bPySpark\b", "Pái Ispárk"),
    (r"\b[Ll]akehouses?\b", "Lêique ráus"),
    (r"\b[Ww]arehouses?\b", "Uér ráus"),
    (r"\b[Ee]venthouses?\b", "Ivent ráus"),
    (r"\b[Ee]ventstreams?\b", "Ivent strím"),
    (r"\bKQL\b", "Ká Quê Éle"),
    (r"\b[Nn]otebooks?\b", "nôut búk"),
    (r"\bDataflows? Gen ?2\b", "Dêita flôu Gen dois"),
    (r"\bDelta Lake\b", "Délta Lêique"),
    (r"\bApache Airflow\b", "Apáche Ér flôu"),
    (r"\bAirflow\b", "Ér flôu"),
    (r"\bData Factory\b", "Dêita Féctori"),
    (r"\bReal-Time Intelligence\b", "Riál Taime Intélidjens"),
    (r"\bSaaS\b", "Sáss"),
    (r"\bOLTP\b", "Ó Éle Tê Pê"),
    # Segundo teste A/B (2026-09-26, 30 termos dos módulos 2-3). Ficaram na
    # leitura padrão: V-Order, SCD, MERGE, CDC, upsert, Iceberg, Scala,
    # Amazon S3, TMSL, SSMS, RLS, BigQuery, Cosmos DB, PostgreSQL, MySQL,
    # Microsoft Entra. "ADLS Gen2" reaproveita o "Gen dois" já aprovado.
    (r"\bOPTIMIZE\b", "Óptimaiz"),
    (r"\bVACUUM\b", "Vácuum"),
    (r"\bETL\b", "Ê Tê Éle"),
    (r"\bIDENTITY\b", "Aidêntiti"),
    (r"\b[Ss]taging\b", "stêidjin"),
    (r"\b[Ss]nowflake\b", "snôu flêik"),
    (r"\btime travel\b", "taime trével"),
    (r"\bADLS Gen ?2\b", "Á Dê Éle Ésse Gen dois"),
    (r"\bADLS\b", "Á Dê Éle Ésse"),
    (r"\bXMLA\b", "Xis Éme Éle Á"),
    (r"\bDatabricks\b", "Dêita bríks"),
    (r"\bJSON\b", "Djêison"),
    (r"\bCSV\b", "Cê Ésse Vê"),
    (r"\bdbo\b", "Dê Bê Ó"),
    # "Agora" foi testado em 2026-07-14 (3 opções comparadas) e a pronúncia
    # padrão do edge-tts já soa correta - não precisa de substituição.
    # Mantido documentado aqui para não ser re-testado à toa depois.
]


def fix_pronunciation(text: str) -> str:
    for pattern, replacement in PRONUNCIATION_FIXES:
        text = re.sub(pattern, replacement, text)
    return text
