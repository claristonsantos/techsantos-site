# -*- coding: utf-8 -*-
"""Grava a pronúncia (voz neural nativa) de cada frase em inglês do curso de Inglês.

    python tools/ingles_audio.py            # só o que falta
    python tools/ingles_audio.py --todos    # regrava tudo

Lê assets/js/course-data-ingles.js (via node) e coleta tudo que o motor
assets/js/pratica.js pode tocar: trechos lang="en" do texto, áudios e respostas
dos exercícios, palavras das fichas de montar e o lado inglês dos pares. Cada
frase vira assets/audio/ingles/<sha1(frase)[:12]>.mp3 — o mesmo hash que o
pratica.js calcula no navegador; sem o arquivo ele cai na voz do navegador.
"""
import asyncio
import hashlib
import html
import json
import re
import subprocess
import sys
from pathlib import Path

import edge_tts

ROOT = Path(__file__).resolve().parents[1]
OUT = ROOT / "assets" / "audio" / "ingles"
VOICE = "en-US-AvaNeural"


def carregar() -> list:
    js = ROOT / "assets" / "js" / "course-data-ingles.js"
    code = "global.window={};eval(require('fs').readFileSync(process.argv[1],'utf8')+';global.C=COURSE');process.stdout.write(JSON.stringify(C))"
    return json.loads(subprocess.check_output(["node", "-e", code, str(js)], encoding="utf-8"))


def falado(t: str) -> str:
    # Igual ao textoFalado() do pratica.js (o navegador já entrega o texto sem entidades).
    t = html.unescape(re.sub(r"<[^>]+>", "", t or ""))
    return re.sub(r"\s+", " ", t).strip()


def frases(curso: list) -> set:
    s = set()
    def en_spans(txt):
        for m in re.finditer(r'<(\w+)[^>]*lang="en"[^>]*>(.*?)</\1>', txt or "", flags=re.S):
            s.add(falado(m.group(2)))
    for mod in curso:
        for aula in mod["lessons"]:
            for campo in ("desc", "body"):
                en_spans(aula.get(campo))
            for o in aula.get("objetivos", []):
                en_spans(o)
            for b in aula.get("content", []):
                en_spans(b.get("p"))
                for it in b.get("items", []):
                    en_spans(it)
            for ex in aula.get("pratica", []):
                t = ex["t"]
                en_spans(ex.get("q"))
                if ex.get("ouvir"):
                    s.add(falado(ex["ouvir"]))
                if t == "escolha" and not ex.get("opPt"):
                    resp = ex["op"][ex["a"]]
                    if re.search(r"[a-z]", resp, re.I):
                        s.add(falado(resp))
                elif t == "lacuna":
                    s.add(falado(ex["frase"].replace("___", ex["op"][ex["a"]])))
                elif t == "montar":
                    s.add(falado(ex["en"]))
                    for w in re.sub(r"[.,!?]", "", ex["en"]).split() + ex.get("extra", []):
                        s.add(falado(w))
                elif t == "pares":
                    for en, _ in ex["pares"]:
                        s.add(falado(en))
                elif t in ("digitar", "falar"):
                    s.add(falado(ex["en"]))
    s.discard("")
    return s


def nome(frase: str) -> str:
    return hashlib.sha1(frase.encode("utf-8")).hexdigest()[:12]


async def gravar(frase: str, destino: Path):
    for tentativa in range(8):
        try:
            await edge_tts.Communicate(frase, VOICE, rate="-5%").save(str(destino))
            return
        except Exception as e:  # noqa: BLE001 — o serviço às vezes recusa (muitos pedidos); espera e tenta de novo
            if tentativa == 7:
                raise
            await asyncio.sleep(4 + 4 * tentativa)


async def main():
    todos = "--todos" in sys.argv
    OUT.mkdir(parents=True, exist_ok=True)
    lista = sorted(frases(carregar()))
    faltam = [f for f in lista if todos or not (OUT / f"{nome(f)}.mp3").exists()]
    print(f"{len(lista)} frases, {len(faltam)} para gravar")
    sem = asyncio.Semaphore(3)
    async def um(f):
        async with sem:
            await gravar(f, OUT / f"{nome(f)}.mp3")
    await asyncio.gather(*(um(f) for f in faltam))
    print("ok")


if __name__ == "__main__":
    asyncio.run(main())
