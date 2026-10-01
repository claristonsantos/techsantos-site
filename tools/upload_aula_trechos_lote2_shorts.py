# -*- coding: utf-8 -*-
"""Shorts com trechos reais das aulas do curso de Power BI (2026-10-01).
Lote 2 (05 a 11/10): às 12h porque 10h e 19h já têm Shorts agendados nesses dias.

Retomável: guarda o que já subiu em youtube_state_aula_trechos_lote2.json.
"""
import json
from pathlib import Path

from googleapiclient.errors import HttpError

from youtube_upload import upload

TOOLS = Path(__file__).resolve().parent
MEDIA = TOOLS.parents[1] / "techsantos-media" / "reels"
STATE = TOOLS / "youtube_state_aula_trechos_lote2.json"

LINK = "https://techsantos.com.br/aula-gratis.php?utm_source=youtube&utm_medium=shorts&utm_campaign=aula_trecho&utm_content={slug}"
TAGS = "power bi,power query,curso power bi,modelagem de dados,dax,tech santos br,shorts"
HASHTAGS = "#PowerBI #PowerQuery #Shorts"

# (arquivo, título, resumo, publishAt)
ITEMS = [
    ("aula-trecho-consulta-pasta.mp4", "Um Excel por mês? Junte tudo numa tabela no Power BI #Shorts", "Consulta de pasta no Power Query: todos os relatórios mensais numa tabela única, sem PROCV entre arquivos. Trecho real da aula do curso.", "2026-10-05T12:00:00-03:00"),
    ("aula-trecho-performance-analyzer.mp4", "Relatório do Power BI lento? Descubra qual visual #Shorts", "O Performance Analyzer mostra o tempo de resposta de cada visual. Trecho real da aula de otimização do curso de Power BI.", "2026-10-06T12:00:00-03:00"),
    ("aula-trecho-dax-allselected.mp4", "Percentual não dá 100%? ALL x ALLSELECTED no DAX #Shorts", "O ALL ignora a segmentação e o ALLSELECTED respeita a seleção. Trecho real da aula de DAX do curso de Power BI.", "2026-10-08T12:00:00-03:00"),
    ("aula-trecho-editar-interacoes.mp4", "Filtrar o mês sem mexer no gráfico do ano no Power BI #Shorts", "Editar interações define quais visuais a segmentação filtra. Trecho real da aula do curso de Power BI.", "2026-10-09T12:00:00-03:00"),
    ("aula-trecho-influenciadores.mp4", "O Power BI mostra o que influencia o seu resultado #Shorts", "O visual Principais Influenciadores usa IA para explicar o que mais pesa na métrica. Trecho real da aula do curso de Power BI.", "2026-10-10T12:00:00-03:00"),
    ("aula-trecho-assinatura-email.mp4", "Dashboard do Power BI chegando sozinho no e-mail #Shorts", "A assinatura do Power BI Service envia o dashboard por e-mail no horário que você escolher. Trecho real da aula do curso.", "2026-10-11T12:00:00-03:00"),
]


def main():
    state = json.loads(STATE.read_text(encoding="utf-8")) if STATE.exists() else {}
    for filename, title, summary, publish_at in ITEMS:
        if filename in state:
            continue
        path = MEDIA / filename
        if not path.exists():
            print(f"MISSING|{filename}")
            continue
        slug = filename.removesuffix(".mp4")
        desc = f"{summary}\n\nAssista grátis às 3 primeiras aulas do curso de Power BI: {LINK.format(slug=slug)}\n\n{HASHTAGS}"
        print(f"UPLOAD|{filename}|{publish_at}", flush=True)
        try:
            result = upload(file_path=str(path), title=title, description=desc, tags=TAGS,
                            category_id="27", privacy="private", publish_at=publish_at)
        except HttpError as e:
            if e.resp.status == 403 and b"quota" in e.content.lower():
                print("QUOTA_EXCEEDED|parando; rode de novo amanhã para continuar", flush=True)
                break
            raise
        state[filename] = {"id": result["id"], "publish_at": publish_at, "title": title}
        STATE.write_text(json.dumps(state, ensure_ascii=False, indent=2), encoding="utf-8")
        print(f"SCHEDULED|{result['id']}|{publish_at}|https://youtube.com/shorts/{result['id']}", flush=True)
    print(f"DONE|{len(state)}/{len(ITEMS)} agendados", flush=True)


if __name__ == "__main__":
    main()
