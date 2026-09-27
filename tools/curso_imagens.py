# -*- coding: utf-8 -*-
"""Imagens oficiais da Microsoft (Learn ou Suporte) para qualquer curso do site.

    python tools/curso_imagens.py <curso> listar <url-da-pagina>
    python tools/curso_imagens.py <curso> baixar <url-da-pagina> <modulo> <nome-destino> <trecho-do-src>

Salva em assets/img/curso-<curso>/<modulo>/<nome-destino>.<ext> e registra a
origem em assets/img/curso-<curso>/FONTES.md (crédito da figura na aula).

As páginas do Suporte (support.microsoft.com) redirecionam para outro caminho
e usam src relativo (../media/...): o endereço da imagem precisa ser montado a
partir da URL FINAL, depois do redirecionamento — senão dá 404.
"""
import html
import re
import sys
import urllib.parse
import urllib.request
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
UA = {"User-Agent": "Mozilla/5.0"}


def get(url: str):
    with urllib.request.urlopen(urllib.request.Request(url, headers=UA), timeout=60) as r:
        return r.read(), r.geturl()


def imagens(url: str):
    raw, final = get(url)
    page = raw.decode("utf-8", "ignore")
    main = page[page.find("<main"):] if "<main" in page else page
    out = []
    for tag in re.findall(r"<img\b[^>]*>", main):
        src = re.search(r'\bsrc="([^"]+)"', tag)
        if not src or "media/" not in src.group(1):
            continue
        alt = re.search(r'\balt="([^"]*)"', tag)
        out.append((urllib.parse.urljoin(final, html.unescape(src.group(1))), html.unescape(alt.group(1)) if alt else ""))
    return out


def main():
    curso, cmd, url = sys.argv[1], sys.argv[2], sys.argv[3]
    dest = ROOT / "assets" / "img" / f"curso-{curso}"
    imgs = imagens(url)
    if cmd == "listar":
        for i, (src, alt) in enumerate(imgs):
            print(f"{i:2d}  {src.split('media/')[-1][:70]:70s}  {alt[:90]}")
        return
    modulo, nome, trecho = sys.argv[4], sys.argv[5], sys.argv[6]
    escolha = [x for x in imgs if trecho in x[0]]
    if not escolha:
        sys.exit(f"nenhuma imagem com '{trecho}' em {url}")
    src, alt = escolha[0]
    ext = Path(urllib.parse.urlparse(src).path).suffix or ".png"
    pasta = dest / modulo
    pasta.mkdir(parents=True, exist_ok=True)
    arquivo = pasta / f"{nome}{ext}"
    arquivo.write_bytes(get(src)[0])
    fontes = dest / "FONTES.md"
    if not fontes.exists():
        fontes.write_text(f"# Fontes das imagens do curso {curso}\n\nTodas as imagens são da documentação oficial da Microsoft (Learn e Suporte).\n\n| Arquivo | Descrição (alt original) | Página de origem |\n|---|---|---|\n", encoding="utf-8")
    rel = arquivo.relative_to(ROOT).as_posix()
    with fontes.open("a", encoding="utf-8") as f:
        f.write(f"| /{rel} | {alt.replace('|', '/')} | {url} |\n")
    print(f"OK /{rel}  ({arquivo.stat().st_size // 1024} KB)  alt: {alt[:80]}")


if __name__ == "__main__":
    main()
