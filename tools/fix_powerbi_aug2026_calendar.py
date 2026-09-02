from pathlib import Path
p=Path(__file__).resolve().parents[1]/"docs"/"dicas-power-bi-agosto-2026.md"
t=p.read_text(encoding="utf-8")
for old,new in [("04/09/2026","05/09/2026"),("07/09/2026","09/09/2026"),("09/09/2026","12/09/2026"),("11/09/2026","15/09/2026"),("14/09/2026","18/09/2026")]: t=t.replace(old,new,1)
p.write_text(t,encoding="utf-8",newline="\n")
