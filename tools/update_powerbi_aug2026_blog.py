from pathlib import Path

root = Path(__file__).resolve().parents[1]
index = root / "blog" / "index.php"
text = index.read_text(encoding="utf-8")
entry = """    [
        'slug' => 'novidades-power-bi-agosto-2026',
        'eyebrow' => 'Power BI',
        'title' => '5 novidades do Power BI em agosto de 2026 que valem testar',
        'excerpt' => 'Copilot, atualização seletiva, imagens do OneLake, valor central na rosca e matriz expansível explicados na prática.',
        'date' => '2026-09-02',
    ],
"""
if "'slug' => 'novidades-power-bi-agosto-2026'" not in text:
    text = text.replace("$posts = [\n", "$posts = [\n" + entry, 1)
    index.write_text(text, encoding="utf-8", newline="\n")

sitemap = root / "sitemap.xml"
text = sitemap.read_text(encoding="utf-8")
url = "  <url><loc>https://techsantos.com.br/blog/novidades-power-bi-agosto-2026.php</loc><lastmod>2026-09-02</lastmod><priority>0.8</priority></url>\n"
if "novidades-power-bi-agosto-2026.php" not in text:
    text = text.replace('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n', '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n' + url, 1)
text = text.replace('<url><loc>https://techsantos.com.br/blog/</loc><lastmod>2026-08-27</lastmod>', '<url><loc>https://techsantos.com.br/blog/</loc><lastmod>2026-09-02</lastmod>')
sitemap.write_text(text, encoding="utf-8", newline="\n")
