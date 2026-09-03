from pathlib import Path

root = Path(__file__).resolve().parents[1]
tag = '<script src="/assets/js/tiktok-pixel.js"></script>'

meta = root / "inc" / "meta-pixel.php"
text = meta.read_text(encoding="utf-8")
if tag not in text:
    text = text.rstrip() + "\n" + tag + "\n"
    meta.write_text(text, encoding="utf-8")

static_pages = [
    "index.html", "sobre.html", "servicos.html", "projetos.html",
    "treinamentos.html", "contato.html", "privacidade.html", "exclusao-dados.html",
]
for name in static_pages:
    page = root / name
    text = page.read_text(encoding="utf-8")
    if tag not in text:
        text = text.replace("</head>", f"{tag}\n</head>", 1)
        page.write_text(text, encoding="utf-8")

privacy = root / "privacidade.html"
text = privacy.read_text(encoding="utf-8")
text = text.replace(
    "dados de uso coletados via Meta Pixel (Facebook/Instagram) para medir a performance de anúncios e campanhas.",
    "dados de uso coletados via Meta Pixel (Facebook/Instagram) e TikTok Pixel para medir a performance de anúncios e campanhas.",
)
text = text.replace(
    "<strong>Meta (Facebook/Instagram)</strong> — anúncios, pixel de conversão e mensagens automáticas em comentários.",
    "<strong>Meta (Facebook/Instagram) e TikTok</strong> — anúncios, pixels de conversão e mensuração de campanhas.",
)
text = text.replace(
    "tecnologias semelhantes (como o Meta Pixel)",
    "tecnologias semelhantes (como os pixels da Meta e do TikTok)",
)
privacy.write_text(text, encoding="utf-8")
