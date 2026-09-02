from pathlib import Path

p = Path("seed_powerbi_aug2026_reels.php")
s = p.read_text(encoding="utf-8")
s = s.replace("https://media.techsantos.com.br/reels/", "https://media.techsantos.com.br/powerbi-ago2026/")
s = s.replace("'when'=>", "'ig_when'=>")
dates = {
    "2026-09-05 23:00:00": "2026-09-05 14:00:00",
    "2026-09-09 13:00:00": "2026-09-09 14:00:00",
    "2026-09-12 23:00:00": "2026-09-12 14:00:00",
    "2026-09-15 13:00:00": "2026-09-15 14:00:00",
    "2026-09-18 23:00:00": "2026-09-18 14:00:00",
}
for ig, fb in dates.items():
    marker = f"'ig_when'=>'{ig}'"
    s = s.replace(marker, marker + f",'fb_when'=>'{fb}'")
s = s.replace("$p['when']", "$p['ig_when']", 1)
s = s.replace("strtotime($p['when'].' UTC')", "strtotime($p['fb_when'].' UTC')")
s = s.replace("[$p['caption'],$url,$link,$p['when'],$videoId]", "[$p['caption'],$url,$link,$p['fb_when'],$videoId]")
p.write_text(s, encoding="utf-8")
