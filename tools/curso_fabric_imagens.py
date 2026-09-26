# -*- coding: utf-8 -*-
"""Imagens oficiais do Microsoft Learn para o curso de Microsoft Fabric.

    python tools/curso_fabric_imagens.py listar <url-da-pagina-learn>
    python tools/curso_fabric_imagens.py baixar <url-da-pagina-learn> <modulo> <nome-destino> <trecho-do-src>

`listar` mostra as imagens do conteúdo da página (src + alt) para escolher.
`baixar` salva a imagem em assets/img/curso-fabric/<modulo>/<nome-destino>.<ext>
e registra a origem em assets/img/curso-fabric/FONTES.md — é esse registro que
alimenta o crédito "Fonte: Microsoft Learn" em cada figura da aula.

learn.microsoft.com é renderizado no servidor, então um GET simples basta.
"""
import html
import re
import sys
import urllib.parse
import urllib.request
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
DEST = ROOT / "assets" / "img" / "curso-fabric"
UA = {"User-Agent": "Mozilla/5.0"}


def get(url: str) -> bytes:
    with urllib.request.urlopen(urllib.request.Request(url, headers=UA), timeout=60) as r:
        return r.read()


def imagens(url: str):
    page = get(url).decode("utf-8", "ignore")
    main = page[page.find("<main"):] if "<main" in page else page
    out = []
    for tag in re.findall(r"<img\b[^>]*>", main):
        src = re.search(r'\bsrc="([^"]+)"', tag)
        if not src or "media/" not in src.group(1):
            continue
        alt = re.search(r'\balt="([^"]*)"', tag)
        out.append((urllib.parse.urljoin(url, html.unescape(src.group(1))), html.unescape(alt.group(1)) if alt else ""))
    return out


def main():
    cmd, url = sys.argv[1], sys.argv[2]
    imgs = imagens(url)
    if cmd == "listar":
        for i, (src, alt) in enumerate(imgs):
            print(f"{i:2d}  {src.split("media/")[-1][:70]:70s}  {alt[:90]}")
        return
    modulo, nome, trecho = sys.argv[3], sys.argv[4], sys.argv[5]
    escolha = [x for x in imgs if trecho in x[0]]
    if not escolha:
        sys.exit(f"nenhuma imagem com '{trecho}' em {url}")
    src, alt = escolha[0]
    ext = Path(urllib.parse.urlparse(src).path).suffix or ".png"
    pasta = DEST / modulo
    pasta.mkdir(parents=True, exist_ok=True)
    arquivo = pasta / f"{nome}{ext}"
    arquivo.write_bytes(get(src))
    fontes = DEST / "FONTES.md"
    if not fontes.exists():
        fontes.write_text("# Fontes das imagens do curso de Microsoft Fabric\n\nTodas as imagens são da documentação oficial Microsoft Learn.\n\n| Arquivo | Descrição (alt original) | Página de origem |\n|---|---|---|\n", encoding="utf-8")
    rel = arquivo.relative_to(ROOT).as_posix()
    with fontes.open("a", encoding="utf-8") as f:
        f.write(f"| /{rel} | {alt.replace('|', '/')} | {url} |\n")
    print(f"OK /{rel}  ({arquivo.stat().st_size // 1024} KB)  alt: {alt[:80]}")


if __name__ == "__main__":
    main()
