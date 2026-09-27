# -*- coding: utf-8 -*-
"""Gera o áudio (modo podcast) das aulas de um curso a partir do texto.

    python tools/curso_audio.py microsoft-fabric                 # todas as aulas
    python tools/curso_audio.py microsoft-fabric fab-o-que-e-fabric ...

Lê assets/js/course-data-<slug>.js (via node), monta o roteiro falado de cada
aula (título, descrição, teoria, legendas das imagens, "como cai na prova" e
fechamento), aplica tools/tts_pronuncia.py e grava private-audio/<id-aula>.mp3
(mono, 48 kbps — voz fica ótima e o arquivo pequeno). O áudio é protegido:
só sai pelo audio.php, para aluno logado e matriculado.

Rode de novo sempre que o texto da aula mudar.
"""
import asyncio
import html
import json
import re
import subprocess
import sys
from pathlib import Path

import edge_tts

sys.path.insert(0, str(Path(__file__).resolve().parent))
from tts_pronuncia import fix_pronunciation  # noqa: E402

ROOT = Path(__file__).resolve().parents[1]
OUT = ROOT / "private-audio"
VOICE = "pt-BR-AntonioNeural"


def carregar_curso(slug: str) -> list:
    js = ROOT / "assets" / "js" / f"course-data-{slug}.js"
    code = "global.window={};eval(require('fs').readFileSync(process.argv[1],'utf8')+';global.C=COURSE');process.stdout.write(JSON.stringify(C))"
    return json.loads(subprocess.check_output(["node", "-e", code, str(js)], encoding="utf-8"))


def _codigo_falado(m: re.Match) -> str:
    # Código e endereços não se leem em voz alta: comando/URI vira remissão ao
    # texto; nome simples (_delta_log, IsEnabled) é lido como palavras.
    c = html.unescape(m.group(1))
    if re.search(r"://|[()=<>{}\[\]\"']|\.\w+\.", c):
        return "conforme o exemplo no texto da aula"
    return re.sub(r"[_./]+", " ", c).strip()


def limpo(t: str) -> str:
    t = re.sub(r"<code>(.*?)</code>", _codigo_falado, t or "", flags=re.S)
    t = html.unescape(re.sub(r"<[^>]+>", "", t))
    t = t.replace("→", ", ").replace("×", " ou ").replace("“", "").replace("”", "")
    return re.sub(r"\s+", " ", t).strip()


def frase(t: str) -> str:
    t = limpo(t)
    return t if not t or t[-1] in ".!?:" else t + "."


def roteiro(modulo: dict, aula: dict) -> str:
    partes = [f"{frase(aula['title'])} Aula do {frase(modulo['title'].replace('·', ','))}", frase(aula.get("desc")), frase(aula.get("body"))]
    for bloco in aula.get("content") or []:
        if bloco.get("h"):
            partes.append("... " + frase(bloco["h"]))
        if bloco.get("p"):
            partes.append(frase(bloco["p"]))
        for item in bloco.get("items") or []:
            partes.append(frase(item))
        img = bloco.get("img")
        if img and img.get("caption"):
            partes.append("Na imagem desta parte, no texto da aula: " + frase(img["caption"]))
    partes.append(f"... Fim da aula: {frase(aula['title'])} Os links oficiais da Microsoft estão no texto da aula. Até a próxima.")
    return " ".join(p for p in partes if p)


async def gerar(texto: str, destino: Path) -> float:
    bruto = destino.with_suffix(".raw.mp3")
    # O serviço do edge-tts às vezes para de responder sem erro; sem limite
    # de tempo o processo fica preso para sempre. Aulas longas levam ~2 min.
    for tentativa in range(1, 4):
        try:
            await asyncio.wait_for(edge_tts.Communicate(fix_pronunciation(texto), VOICE).save(str(bruto)), timeout=420)
            break
        except (asyncio.TimeoutError, edge_tts.exceptions.EdgeTTSException, OSError) as e:
            print(f"  tentativa {tentativa} falhou ({type(e).__name__}), repetindo...", flush=True)
            bruto.unlink(missing_ok=True)
    else:
        raise RuntimeError(f"edge-tts não respondeu para {destino.name}")
    subprocess.check_call(["ffmpeg", "-y", "-loglevel", "error", "-i", str(bruto), "-ac", "1", "-ar", "24000", "-b:a", "48k", str(destino)])
    bruto.unlink()
    dur = subprocess.check_output(["ffprobe", "-v", "error", "-show_entries", "format=duration", "-of", "csv=p=0", str(destino)])
    return float(dur)


async def main():
    slug, filtro = sys.argv[1], set(sys.argv[2:])
    OUT.mkdir(exist_ok=True)
    for modulo in carregar_curso(slug):
        for aula in modulo["lessons"]:
            if filtro and aula["id"] not in filtro:
                continue
            destino = OUT / f"{aula['id']}.mp3"
            dur = await gerar(roteiro(modulo, aula), destino)
            print(f"OK {aula['id']}: {dur / 60:.1f} min, {destino.stat().st_size // 1024} KB", flush=True)


if __name__ == "__main__":
    asyncio.run(main())
