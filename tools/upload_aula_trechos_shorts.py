# -*- coding: utf-8 -*-
"""Shorts com trechos reais das aulas do curso de Power BI (2026-10-01).
Mesmos dias dos Reels; às 19h porque o horário das 10h já tem Short agendado.

Retomável: guarda o que já subiu em youtube_state_aula_trechos.json.
"""
import json
from pathlib import Path

from googleapiclient.errors import HttpError

from youtube_upload import upload

TOOLS = Path(__file__).resolve().parent
MEDIA = TOOLS.parents[1] / "techsantos-media" / "reels"
STATE = TOOLS / "youtube_state_aula_trechos.json"

LINK = "https://techsantos.com.br/aula-gratis.php?utm_source=youtube&utm_medium=shorts&utm_campaign=aula_trecho&utm_content={slug}"
TAGS = "power bi,power query,curso power bi,modelagem de dados,dax,tech santos br,shorts"
HASHTAGS = "#PowerBI #PowerQuery #Shorts"

# (arquivo, título, resumo, publishAt)
ITEMS = [
    ("aula-trecho-perfil-dados.mp4", "Seu número não bate? Olhe isto no Power Query antes #Shorts", "A qualidade da coluna mostra o que é válido, erro e vazio antes de você transformar os dados. Trecho real da aula do curso de Power BI.", "2026-10-01T19:00:00-03:00"),
    ("aula-trecho-total-repetido.mp4", "Total repetido em todas as linhas do Power BI? #Shorts", "Duas tabelas fato e o filtro que não chega: o problema de contexto de filtro explicado num trecho real da aula de modelagem.", "2026-10-02T19:00:00-03:00"),
    ("aula-trecho-pivotar-nao-precisa.mp4", "Pivotar no Power Query? Não precisa #Shorts", "Deixe o dado tabular e monte a visão dinâmica no visual de matriz do Power BI. Trecho real da aula do curso.", "2026-10-03T19:00:00-03:00"),
    ("aula-trecho-preencher-abaixo.mp4", "Coluna cheia de null? Preencher abaixo no Power Query #Shorts", "O Preenchimento copia o valor para baixo e deixa a tabela no formato tabular. Trecho real da aula do curso de Power BI.", "2026-10-04T19:00:00-03:00"),
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
