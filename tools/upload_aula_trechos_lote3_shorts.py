# -*- coding: utf-8 -*-
"""Shorts com trechos reais das aulas do curso de Power BI (2026-10-01).
Lote 3 (12 a 16/10): às 12h porque 10h e 19h já têm Shorts agendados nesses dias.

Retomável: guarda o que já subiu em youtube_state_aula_trechos_lote3.json.
"""
import json
from pathlib import Path

from googleapiclient.errors import HttpError

from youtube_upload import upload

TOOLS = Path(__file__).resolve().parent
MEDIA = TOOLS.parents[1] / "techsantos-media" / "reels"
STATE = TOOLS / "youtube_state_aula_trechos_lote3.json"

LINK = "https://techsantos.com.br/aula-gratis.php?utm_source=youtube&utm_medium=shorts&utm_campaign=aula_trecho&utm_content={slug}"
TAGS = "power bi,power query,curso power bi,modelagem de dados,dax,tech santos br,shorts"
HASHTAGS = "#PowerBI #PowerQuery #Shorts"

# (arquivo, título, resumo, publishAt)
ITEMS = [
    ("aula-trecho-nao-bate-com-excel.mp4", "Número do Power BI não bate com o Excel? #Shorts", "Quase sempre é contexto de filtro: segmentação, filtro do visual, da página e do painel. Trecho real da aula de DAX do curso de Power BI.", "2026-10-12T12:00:00-03:00"),
    ("aula-trecho-agrupar-por.mp4", "Agrupar por data e canal no Power Query #Shorts", "O Agrupar por avançado agrupa por várias colunas e cria várias saídas de uma vez. Trecho real da aula do curso de Power BI.", "2026-10-13T12:00:00-03:00"),
    ("aula-trecho-divide.mp4", "Divisão por zero no DAX? Use DIVIDE #Shorts", "O DIVIDE divide com segurança e aceita um resultado alternativo. Trecho real da aula de DAX do curso de Power BI.", "2026-10-14T12:00:00-03:00"),
    ("aula-trecho-linha-de-meta.mp4", "Linha de meta no gráfico do Power BI #Shorts", "Linha de referência constante no eixo Y para marcar a meta no gráfico. Trecho real da aula do curso de Power BI.", "2026-10-15T12:00:00-03:00"),
    ("aula-trecho-dividir-coluna.mp4", "Dividir coluna pela última vírgula no Power Query #Shorts", "Dividir por delimitador na extremidade direita separa só a última ocorrência. Trecho real da aula do curso de Power BI.", "2026-10-16T12:00:00-03:00"),
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
