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
    # "Agora" foi testado em 2026-07-14 (3 opções comparadas) e a pronúncia
    # padrão do edge-tts já soa correta - não precisa de substituição.
    # Mantido documentado aqui para não ser re-testado à toa depois.
]


def fix_pronunciation(text: str) -> str:
    for pattern, replacement in PRONUNCIATION_FIXES:
        text = re.sub(pattern, replacement, text)
    return text
