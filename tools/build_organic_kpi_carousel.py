# -*- coding: utf-8 -*-
import json
import math
from pathlib import Path

from PIL import Image, ImageDraw, ImageEnhance, ImageFilter, ImageFont

ROOT = Path(__file__).resolve().parents[1]
OUT = ROOT / "output" / "organico" / "semana-01-kpi" / "carrossel"
HERO = ROOT / "output" / "organico" / "semana-01-kpi" / "hero-kpi-conflitante.png"
W, H = 1080, 1350
NAVY = "#07182c"
NAVY_2 = "#0d2744"
LIME = "#79e34c"
BLUE = "#3d8dff"
WHITE = "#f4f7f3"
MUTED = "#bed0e2"

SLIDES = [
    {"kind": "cover", "title": "5 PERGUNTAS", "subtitle": "ANTES DE CRIAR UM KPI", "note": "O número começa na regra. Não no gráfico."},
    {"kind": "content", "number": "01", "title": "QUAL DECISÃO", "accent": "ESTE INDICADOR APOIA?", "body": "Se ninguém sabe qual decisão será tomada, o KPI vira apenas decoração no dashboard.", "icon": "target"},
    {"kind": "content", "number": "02", "title": "O QUE ENTRA", "accent": "E O QUE FICA DE FORA?", "body": "Defina inclusões, exclusões e exceções antes de escrever qualquer medida.", "icon": "filter"},
    {"kind": "content", "number": "03", "title": "QUAL É O", "accent": "PERÍODO DE ANÁLISE?", "body": "Mês atual, últimos 90 dias, ano fiscal e acumulado respondem perguntas diferentes.", "icon": "calendar"},
    {"kind": "content", "number": "04", "title": "QUAL É A", "accent": "FONTE OFICIAL?", "body": "Sem uma fonte de verdade, duas áreas podem apresentar dois números corretos — e incompatíveis.", "icon": "database"},
    {"kind": "content", "number": "05", "title": "QUEM VALIDA", "accent": "A REGRA DO NEGÓCIO?", "body": "O analista traduz a necessidade. O responsável pelo processo valida o significado.", "icon": "approval"},
    {"kind": "cta", "title": "SALVE ESTE CHECKLIST", "subtitle": "ANTES DE ABRIR O POWER BI", "note": "Compartilhe com quem define os indicadores da empresa."},
]


def font(size: int, bold: bool = False):
    paths = [
        Path("C:/Windows/Fonts/arialbd.ttf" if bold else "C:/Windows/Fonts/arial.ttf"),
        Path("C:/Windows/Fonts/segoeuib.ttf" if bold else "C:/Windows/Fonts/segoeui.ttf"),
    ]
    for path in paths:
        if path.exists():
            return ImageFont.truetype(str(path), size)
    return ImageFont.load_default()


def fit_cover(path: Path):
    image = Image.open(path).convert("RGB")
    scale = max(W / image.width, H / image.height)
    image = image.resize((math.ceil(image.width * scale), math.ceil(image.height * scale)), Image.Resampling.LANCZOS)
    left = (image.width - W) // 2
    top = (image.height - H) // 2
    return image.crop((left, top, left + W, top + H))


def wrap(draw, text, selected_font, width):
    lines, line = [], ""
    for word in text.split():
        trial = (line + " " + word).strip()
        if draw.textbbox((0, 0), trial, font=selected_font)[2] <= width:
            line = trial
        else:
            if line:
                lines.append(line)
            line = word
    if line:
        lines.append(line)
    return lines


def brand_header(draw, index):
    draw.rounded_rectangle((72, 68, 230, 122), radius=20, fill=LIME)
    draw.text((98, 79), f"{index:02d}/07", font=font(25, True), fill=NAVY)
    draw.text((258, 79), "TECH SANTOS BR • POWER BI NA VIDA REAL", font=font(22, True), fill=WHITE)


def swipe_footer(draw, final=False):
    if final:
        text = "techsantos.com.br"
        draw.text((72, 1260), text, font=font(23), fill=MUTED)
    else:
        draw.text((72, 1260), "DESLIZE PARA CONTINUAR", font=font(22, True), fill=MUTED)
        draw.line((930, 1274, 995, 1274), fill=LIME, width=5)
        draw.line((975, 1254, 995, 1274), fill=LIME, width=5)
        draw.line((975, 1294, 995, 1274), fill=LIME, width=5)


def icon(draw, kind, box):
    x1, y1, x2, y2 = box
    cx, cy = (x1 + x2) // 2, (y1 + y2) // 2
    draw.rounded_rectangle(box, radius=34, fill=(17, 48, 80), outline=LIME, width=4)
    if kind == "target":
        for radius in (82, 53, 24):
            draw.ellipse((cx-radius, cy-radius, cx+radius, cy+radius), outline=WHITE if radius != 24 else LIME, width=7)
        draw.line((cx+18, cy-18, cx+92, cy-92), fill=LIME, width=8)
    elif kind == "filter":
        draw.polygon([(cx-95, cy-82), (cx+95, cy-82), (cx+30, cy-8), (cx+30, cy+86), (cx-30, cy+60), (cx-30, cy-8)], outline=WHITE, fill=None)
        draw.line((cx-95, cy-82, cx+95, cy-82), fill=LIME, width=8)
    elif kind == "calendar":
        draw.rounded_rectangle((cx-95, cy-82, cx+95, cy+86), radius=18, outline=WHITE, width=7)
        draw.rectangle((cx-95, cy-82, cx+95, cy-34), fill=LIME)
        for row in range(2):
            for col in range(3):
                px, py = cx-55+col*55, cy+2+row*46
                draw.rounded_rectangle((px-13, py-13, px+13, py+13), radius=5, fill=WHITE)
    elif kind == "database":
        draw.ellipse((cx-95, cy-82, cx+95, cy-18), outline=LIME, width=7)
        draw.rectangle((cx-95, cy-52, cx+95, cy+70), outline=WHITE, width=7)
        draw.arc((cx-95, cy+18, cx+95, cy+86), 0, 180, fill=WHITE, width=7)
        draw.arc((cx-95, cy-18, cx+95, cy+50), 0, 180, fill=WHITE, width=7)
    elif kind == "approval":
        draw.ellipse((cx-72, cy-91, cx+72, cy+53), outline=WHITE, width=7)
        draw.arc((cx-102, cy+22, cx+102, cy+148), 190, 350, fill=WHITE, width=7)
        draw.line((cx-55, cy+12, cx-10, cy+57), fill=LIME, width=11)
        draw.line((cx-10, cy+57, cx+72, cy-36), fill=LIME, width=11)


def cover_slide(data, index):
    image = ImageEnhance.Contrast(fit_cover(HERO)).enhance(1.12).convert("RGBA")
    image = Image.alpha_composite(image, Image.new("RGBA", (W, H), (3, 15, 29, 112)))
    draw = ImageDraw.Draw(image)
    brand_header(draw, index)
    draw.rounded_rectangle((62, 692, 1018, 1192), radius=38, fill=(4, 18, 36, 230), outline=(121, 227, 76, 190), width=4)
    draw.text((92, 752), data["title"], font=font(91, True), fill=WHITE)
    draw.text((92, 862), data["subtitle"], font=font(66, True), fill=LIME)
    draw.rectangle((94, 964, 295, 975), fill=BLUE)
    for line_index, line in enumerate(wrap(draw, data["note"], font(37), 820)):
        draw.text((94, 1014 + line_index * 50), line, font=font(37), fill=MUTED)
    swipe_footer(draw)
    return image.convert("RGB")


def content_slide(data, index):
    base = fit_cover(HERO).filter(ImageFilter.GaussianBlur(7)).convert("RGBA")
    tint = Image.new("RGBA", (W, H), (5, 22, 41, 218 if index % 2 else 228))
    image = Image.alpha_composite(base, tint)
    draw = ImageDraw.Draw(image)
    brand_header(draw, index)
    draw.text((72, 188), data["number"], font=font(142, True), fill=(121, 227, 76))
    icon(draw, data["icon"], (706, 175, 996, 465))
    draw.text((72, 510), data["title"], font=font(67, True), fill=WHITE)
    draw.text((72, 592), data["accent"], font=font(54, True), fill=LIME)
    draw.rounded_rectangle((62, 722, 1018, 1127), radius=34, fill=(8, 31, 56, 235), outline=(61, 141, 255, 135), width=3)
    body_font = font(43)
    for line_index, line in enumerate(wrap(draw, data["body"], body_font, 820)):
        draw.text((105, 790 + line_index * 61), line, font=body_font, fill=MUTED)
    swipe_footer(draw)
    return image.convert("RGB")


def cta_slide(data, index):
    image = fit_cover(HERO).convert("RGBA")
    image = Image.alpha_composite(image, Image.new("RGBA", (W, H), (3, 16, 31, 168)))
    draw = ImageDraw.Draw(image)
    brand_header(draw, index)
    draw.rounded_rectangle((62, 355, 1018, 1135), radius=42, fill=(4, 18, 36, 236), outline=LIME, width=5)
    draw.ellipse((405, 420, 675, 690), fill=(121, 227, 76), outline=WHITE, width=5)
    draw.line((472, 558, 535, 621), fill=NAVY, width=18)
    draw.line((535, 621, 625, 503), fill=NAVY, width=18)
    draw.text((125, 745), data["title"], font=font(66, True), fill=WHITE)
    draw.text((125, 832), data["subtitle"], font=font(50, True), fill=LIME)
    for line_index, line in enumerate(wrap(draw, data["note"], font(35), 790)):
        draw.text((125, 946 + line_index * 48), line, font=font(35), fill=MUTED)
    swipe_footer(draw, final=True)
    return image.convert("RGB")


def main():
    OUT.mkdir(parents=True, exist_ok=True)
    outputs = []
    for index, data in enumerate(SLIDES, 1):
        if data["kind"] == "cover":
            image = cover_slide(data, index)
        elif data["kind"] == "cta":
            image = cta_slide(data, index)
        else:
            image = content_slide(data, index)
        path = OUT / f"slide-{index:02d}.png"
        image.save(path, optimize=True)
        outputs.append({"file": str(path), "bytes": path.stat().st_size})
    (OUT / "manifest.json").write_text(json.dumps(outputs, ensure_ascii=False, indent=2), encoding="utf-8")
    print(json.dumps(outputs, ensure_ascii=False, indent=2))


if __name__ == "__main__":
    main()
