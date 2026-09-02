from pathlib import Path

p = Path("seed_powerbi_aug2026_reels.php")
s = p.read_text(encoding="utf-8")
s = s.replace("https://media.techsantos.com.br/powerbi-ago2026/", "https://media.techsantos.com.br/reels/")
p.write_text(s, encoding="utf-8")
