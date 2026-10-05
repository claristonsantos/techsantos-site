# -*- coding: utf-8 -*-
"""Shorts com trechos reais das aulas do curso de Power BI (2026-10-01).
Lote 4 (17 a 21/10): às 12h porque 10h e 19h já têm Shorts agendados nesses dias.

Retomável: guarda o que já subiu em youtube_state_aula_trechos_lote4.json.
"""
import json
from pathlib import Path

from googleapiclient.errors import HttpError

from youtube_upload import upload

TOOLS = Path(__file__).resolve().parent
MEDIA = TOOLS.parents[1] / "techsantos-media" / "reels"
STATE = TOOLS / "youtube_state_aula_trechos_lote4.json"

LINK = "https://techsantos.com.br/aula-gratis.php?utm_source=youtube&utm_medium=shorts&utm_campaign=aula_trecho&utm_content={slug}"
TAGS = "power bi,power query,curso power bi,modelagem de dados,dax,tech santos br,shorts"
HASHTAGS = "#PowerBI #PowerQuery #Shorts"

# (arquivo, título, resumo, publishAt)
ITEMS = [
    ("aula-trecho-conta-gotas.mp4", "Não sabe o código da cor? Conta-gotas pro Power BI #Shorts", "Pegue a cor exata do layout com o conta-gotas do PowerPoint e use no relatório. Trecho real da aula do curso de Power BI.", "2026-10-17T12:00:00-03:00"),
    ("aula-trecho-dax-ytd.mp4", "Acumulado do ano (YTD) no DAX #Shorts", "DATESYTD vai somando mês a mês, e toda medida de tempo precisa de tabela calendário. Trecho real da aula de DAX.", "2026-10-18T12:00:00-03:00"),
    ("aula-trecho-seta-condicional.mp4", "Seta verde e vermelha no Power BI #Shorts", "Formatação condicional por ícones para mostrar se o resultado subiu ou caiu. Trecho real da aula do curso de Power BI.", "2026-10-19T12:00:00-03:00"),
    ("aula-trecho-mesclar-consultas.mp4", "O PROCV do Power Query: mesclar consultas #Shorts", "Mesclar consultas junta duas tabelas pela chave em comum; o left join mantém todas as linhas da primeira. Trecho real da aula.", "2026-10-20T12:00:00-03:00"),
    ("aula-trecho-rls.mp4", "Cada gestor vê só a sua loja: RLS no Power BI #Shorts", "Row Level Security filtra as linhas pelo usuário. Funções em Modelagem, Gerenciar funções. Trecho real da aula.", "2026-10-21T12:00:00-03:00"),
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
