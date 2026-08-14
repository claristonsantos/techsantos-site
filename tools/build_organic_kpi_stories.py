# -*- coding: utf-8 -*-
import json
import math
from pathlib import Path

from PIL import Image, ImageDraw, ImageEnhance, ImageFilter, ImageFont

ROOT = Path(__file__).resolve().parents[1]
OUT = ROOT / "output" / "organico" / "semana-01-kpi" / "stories"
HERO = ROOT / "output" / "organico" / "semana-01-kpi" / "hero-kpi-conflitante.png"
W, H = 1080, 1920
NAVY = "#07182c"
LIME = "#79e34c"
BLUE = "#3d8dff"
WHITE = "#f4f7f3"
MUTED = "#bed0e2"

STORIES = [
    {
        "tag": "ENQUETE",
        "title": "DUAS ÁREAS JÁ MOSTRARAM",
        "accent": "VALORES DIFERENTES",
        "subtitle": "para o mesmo indicador?",
        "sticker": "ADICIONE A ENQUETE AQUI",
        "options": "SIM  •  MAIS DE UMA VEZ",
    },
    {
        "tag": "ESCOLHA",
        "title": "CLIENTE ATIVO",
        "accent": "SIGNIFICA O QUÊ?",
        "subtitle": "A resposta depende da regra do negócio.",
        "sticker": "ADICIONE A ENQUETE AQUI",
        "options": "COMPRA RECENTE  •  CONTRATO VIGENTE",
    },
    {
        "tag": "RESPOSTA",
        "title": "AS DUAS DEFINIÇÕES",
        "accent": "PODEM ESTAR CERTAS.",
        "subtitle": "O erro é não documentar qual regra o relatório utiliza.",
        "sticker": "REGRA CLARA = NÚMERO CONFIÁVEL",
        "options": "",
    },
    {
        "tag": "SUA VEZ",
        "title": "QUAL INDICADOR",
        "accent": "MAIS GERA DÚVIDA",
        "subtitle": "no seu trabalho? Sua resposta pode virar o próximo vídeo.",
        "sticker": "ADICIONE A CAIXA DE PERGUNTAS AQUI",
        "options": "",
    },
]


def font(size, bold=False):
    choices = [
        Path("C:/Windows/Fonts/arialbd.ttf" if bold else "C:/Windows/Fonts/arial.ttf"),
        Path("C:/Windows/Fonts/segoeuib.ttf" if bold else "C:/Windows/Fonts/segoeui.ttf"),
    ]
    for choice in choices:
        if choice.exists():
            return ImageFont.truetype(str(choice), size)
    return ImageFont.load_default()


def cover():
    image = Image.open(HERO).convert("RGB")
    scale = max(W / image.width, H / image.height)
    image = image.resize((math.ceil(image.width * scale), math.ceil(image.height * scale)), Image.Resampling.LANCZOS)
    left, top = (image.width - W) // 2, (image.height - H) // 2
    return image.crop((left, top, left + W, top + H))


def wrap(draw, text, selected_font, width):
    lines, current = [], ""
    for word in text.split():
        candidate = (current + " " + word).strip()
        if draw.textbbox((0, 0), candidate, font=selected_font)[2] <= width:
            current = candidate
        else:
            if current:
                lines.append(current)
            current = word
    if current:
        lines.append(current)
    return lines


def create_story(data, index):
    background = ImageEnhance.Contrast(cover()).enhance(1.1)
    if index in (2, 4):
        background = background.filter(ImageFilter.GaussianBlur(5))
    image = background.convert("RGBA")
    image = Image.alpha_composite(image, Image.new("RGBA", (W, H), (3, 16, 31, 125 if index in (1, 3) else 188)))
    draw = ImageDraw.Draw(image)

    # All essential content stays between y=285 and y=1520.
    draw.rounded_rectangle((58, 305, 1022, 1128), radius=40, fill=(4, 18, 36, 230), outline=(121, 227, 76, 180), width=4)
    draw.rounded_rectangle((86, 338, 278, 398), radius=22, fill=LIME)
    draw.text((117, 351), data["tag"], font=font(27, True), fill=NAVY)
    draw.text((310, 350), "TECH SANTOS BR", font=font(27, True), fill=WHITE)

    title_font = font(68, True)
    y = 482
    for line in wrap(draw, data["title"], title_font, 850):
        draw.text((88, y), line, font=title_font, fill=WHITE)
        y += 82
    accent_font = font(61, True)
    for line in wrap(draw, data["accent"], accent_font, 850):
        draw.text((88, y), line, font=accent_font, fill=LIME)
        y += 75
    draw.rectangle((88, y + 22, 276, y + 32), fill=BLUE)
    subtitle_font = font(38)
    for line in wrap(draw, data["subtitle"], subtitle_font, 835):
        draw.text((88, y + 75), line, font=subtitle_font, fill=MUTED)
        y += 49

    sticker_y1, sticker_y2 = 1190, 1465
    draw.rounded_rectangle((92, sticker_y1, 988, sticker_y2), radius=42, fill=(244, 247, 243, 238), outline=LIME, width=5)
    sticker_font = font(34, True)
    sticker_lines = wrap(draw, data["sticker"], sticker_font, 760)
    total_height = len(sticker_lines) * 46
    sticker_y = sticker_y1 + (sticker_y2 - sticker_y1 - total_height) // 2
    for line in sticker_lines:
        box = draw.textbbox((0, 0), line, font=sticker_font)
        draw.text(((W - (box[2] - box[0])) // 2, sticker_y), line, font=sticker_font, fill=NAVY)
        sticker_y += 46
    if data["options"]:
        options_font = font(24, True)
        box = draw.textbbox((0, 0), data["options"], font=options_font)
        draw.text(((W - (box[2] - box[0])) // 2, 1500), data["options"], font=options_font, fill=WHITE)

    draw.rounded_rectangle((58, 1585, 1022, 1668), radius=27, fill=(4, 18, 36, 220))
    footer = "RESPONDA • SUA DÚVIDA PODE VIRAR CONTEÚDO"
    footer_font = font(27, True)
    box = draw.textbbox((0, 0), footer, font=footer_font)
    draw.text(((W - (box[2] - box[0])) // 2, 1612), footer, font=footer_font, fill=LIME)
    draw.text((74, 1760), f"0{index}/04", font=font(25, True), fill=MUTED)
    draw.text((820, 1760), "@tech_santos_br", font=font(24), fill=MUTED)
    return image.convert("RGB")


def main():
    OUT.mkdir(parents=True, exist_ok=True)
    results = []
    for index, story in enumerate(STORIES, 1):
        path = OUT / f"story-{index:02d}.png"
        create_story(story, index).save(path, optimize=True)
        results.append({"file": str(path), "bytes": path.stat().st_size})
    (OUT / "manifest.json").write_text(json.dumps(results, ensure_ascii=False, indent=2), encoding="utf-8")
    print(json.dumps(results, ensure_ascii=False, indent=2))


if __name__ == "__main__":
    main()
