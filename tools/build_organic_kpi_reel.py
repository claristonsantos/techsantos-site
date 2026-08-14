# -*- coding: utf-8 -*-
import asyncio
import json
import math
import subprocess
from pathlib import Path

import edge_tts
from PIL import Image, ImageDraw, ImageEnhance, ImageFont

ROOT = Path(__file__).resolve().parents[1]
OUT = ROOT / "output" / "organico" / "semana-01-kpi"
TMP = OUT / "tmp"
W, H, FPS = 1080, 1920, 30
NAVY = "#07182c"
LIME = "#79e34c"
WHITE = "#f4f7f3"
MUTED = "#bfd0e3"
VOICE = "pt-BR-AntonioNeural"
HERO = OUT / "hero-kpi-conflitante.png"
MUSIC = Path(r"C:\Users\clari\Documents\Codex\2026-08-13\tenta-novamente\output\meta-course-multiformat\trilha-impacto-cinematica.wav")

SCRIPT_TTS = (
    "O seu déchibórdi pode calcular tudo corretamente e ainda levar a uma decisão errada. "
    "Isso acontece quando ninguém definiu, por exemplo, o que realmente significa cliente ativo. "
    "Comprou neste mês? Nos últimos noventa dias? Possui contrato vigente? "
    "Antes de criar a medida, defina a regra do negócio. "
    "Porque um indicador sem definição é apenas um número bonito. "
    "Salve este vídeo e revise um indicador do seu relatório hoje."
)

SCENES = [
    ("O NÚMERO ESTÁ CERTO.", "A decisão pode estar errada."),
    ("O QUE É CLIENTE ATIVO?", "Este mês? 90 dias? Contrato vigente?"),
    ("DEFINA A REGRA", "Antes de criar a medida."),
    ("INDICADOR SEM DEFINIÇÃO", "É apenas um número bonito."),
]


def font(size: int, bold: bool = False):
    candidates = [
        Path("C:/Windows/Fonts/arialbd.ttf" if bold else "C:/Windows/Fonts/arial.ttf"),
        Path("C:/Windows/Fonts/segoeuib.ttf" if bold else "C:/Windows/Fonts/segoeui.ttf"),
    ]
    for candidate in candidates:
        if candidate.exists():
            return ImageFont.truetype(str(candidate), size)
    return ImageFont.load_default()


def cover(asset: Path) -> Image.Image:
    image = Image.open(asset).convert("RGB")
    scale = max(W / image.width, H / image.height)
    image = image.resize((math.ceil(image.width * scale), math.ceil(image.height * scale)), Image.Resampling.LANCZOS)
    left = (image.width - W) // 2
    top = (image.height - H) // 2
    return image.crop((left, top, left + W, top + H))


def wrap(draw: ImageDraw.ImageDraw, text: str, selected_font, max_width: int):
    lines, line = [], ""
    for word in text.split():
        trial = (line + " " + word).strip()
        if draw.textbbox((0, 0), trial, font=selected_font)[2] <= max_width:
            line = trial
        else:
            if line:
                lines.append(line)
            line = word
    if line:
        lines.append(line)
    return lines


def create_scene(headline: str, subline: str, output: Path, index: int):
    background = ImageEnhance.Contrast(cover(HERO)).enhance(1.08).convert("RGBA")
    veil = Image.new("RGBA", (W, H), (4, 16, 31, 76))
    background = Image.alpha_composite(background, veil)
    draw = ImageDraw.Draw(background)

    draw.rounded_rectangle((48, 292, 1032, 760), radius=34, fill=(4, 18, 36, 224), outline=(121, 227, 76, 180), width=3)
    draw.rounded_rectangle((80, 326, 226, 382), radius=20, fill=LIME)
    draw.text((111, 337), f"0{index}", font=font(27, True), fill=NAVY)
    draw.text((252, 334), "TECH SANTOS BR • POWER BI NA VIDA REAL", font=font(23, True), fill=WHITE)

    headline_font = font(69, True)
    y = 432
    for line in wrap(draw, headline, headline_font, 880):
        draw.text((84, y + 4), line, font=headline_font, fill=(0, 0, 0, 170))
        draw.text((80, y), line, font=headline_font, fill=WHITE)
        y += 84
    draw.rectangle((80, y + 20, 252, y + 29), fill=LIME)
    draw.text((80, y + 58), subline, font=font(36), fill=MUTED)

    draw.rounded_rectangle((48, 1485, 1032, 1635), radius=28, fill=(4, 18, 36, 222))
    footer = "SALVE E REVISE UM KPI" if index == 4 else "A FÓRMULA EXECUTA. A REGRA DEFINE."
    footer_font = font(36, True)
    footer_box = draw.textbbox((0, 0), footer, font=footer_font)
    footer_x = (W - (footer_box[2] - footer_box[0])) // 2
    draw.text((footer_x, 1537), footer, font=footer_font, fill=LIME)
    draw.text((80, 1740), "techsantos.com.br", font=font(26), fill=(205, 217, 230))
    background.convert("RGB").save(output, quality=96)


async def make_voice() -> Path:
    path = TMP / "kpi-sem-definicao-voice.mp3"
    await edge_tts.Communicate(SCRIPT_TTS, VOICE, rate="-7%", pitch="-2Hz").save(str(path))
    return path


def duration(path: Path) -> float:
    return float(subprocess.check_output([
        "ffprobe", "-v", "error", "-show_entries", "format=duration", "-of", "default=nw=1:nk=1", str(path)
    ], text=True).strip())


def render(voice: Path) -> Path:
    total = duration(voice) + 0.45
    scene_length = total / len(SCENES)
    segments = []
    for index, (headline, subline) in enumerate(SCENES, 1):
        still = TMP / f"kpi-sem-definicao-scene-{index}.jpg"
        segment = TMP / f"kpi-sem-definicao-scene-{index}.mp4"
        create_scene(headline, subline, still, index)
        subprocess.run([
            "ffmpeg", "-y", "-loop", "1", "-i", str(still),
            "-vf", f"scale={W}:{H},fps={FPS}", "-t", f"{scene_length:.3f}", "-an",
            "-c:v", "libx264", "-preset", "medium", "-crf", "18", "-pix_fmt", "yuv420p", str(segment),
        ], check=True, stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
        segments.append(segment)

    concat = TMP / "kpi-sem-definicao-concat.txt"
    concat.write_text("\n".join(f"file '{segment.as_posix()}'" for segment in segments), encoding="utf-8")
    visual = TMP / "kpi-sem-definicao-visual.mp4"
    subprocess.run([
        "ffmpeg", "-y", "-f", "concat", "-safe", "0", "-i", str(concat), "-c", "copy", str(visual)
    ], check=True, stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)

    final = OUT / "reel-kpi-sem-definicao-1080x1920.mp4"
    subprocess.run([
        "ffmpeg", "-y", "-i", str(visual), "-i", str(voice), "-stream_loop", "-1", "-i", str(MUSIC),
        "-filter_complex",
        f"[1:a]highpass=f=90,lowpass=f=15000,loudnorm=I=-16:TP=-1.5:LRA=7[voice];"
        f"[2:a]atrim=0:{total:.3f},highpass=f=105,lowpass=f=11000,volume=0.11,"
        f"afade=t=in:st=0:d=0.35,afade=t=out:st={max(total-0.8, 0):.3f}:d=0.8[music];"
        "[voice][music]amix=inputs=2:duration=longest:normalize=0[a]",
        "-map", "0:v", "-map", "[a]", "-t", f"{total:.3f}", "-c:v", "libx264", "-preset", "medium",
        "-crf", "18", "-pix_fmt", "yuv420p", "-r", str(FPS), "-c:a", "aac", "-b:a", "192k",
        "-movflags", "+faststart", str(final),
    ], check=True, stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
    return final


async def main():
    OUT.mkdir(parents=True, exist_ok=True)
    TMP.mkdir(parents=True, exist_ok=True)
    if not HERO.exists() or not MUSIC.exists():
        raise FileNotFoundError("Imagem principal ou trilha não encontrada.")
    voice = await make_voice()
    final = render(voice)
    result = {"file": str(final), "duration": duration(final), "bytes": final.stat().st_size}
    (OUT / "manifest.json").write_text(json.dumps(result, ensure_ascii=False, indent=2), encoding="utf-8")
    print(json.dumps(result, ensure_ascii=False, indent=2))


if __name__ == "__main__":
    asyncio.run(main())
