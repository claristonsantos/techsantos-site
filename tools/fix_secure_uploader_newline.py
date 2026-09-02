from pathlib import Path

p = Path("tools/hostinger_tus_upload_secure.js")
s = p.read_text(encoding="utf-8")
s = s.replace("if (!input.includes('\\n')) return;", "if (!/[\\r\\n]/.test(input)) return;")
p.write_text(s, encoding="utf-8")
