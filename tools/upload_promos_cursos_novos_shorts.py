# -*- coding: utf-8 -*-
"""Shorts das promos dos cursos de Excel e Fabric (2026-09-28). No YouTube os
dias 06, 07, 14 e 15/10 já têm Shorts agendados, então estas entram logo depois
da fila existente, 1 por dia às 19h (regra fixa de melhores horários).

Retomável: guarda o que já subiu em youtube_state_promos_cursos_novos.json.
"""
import json
from pathlib import Path

from googleapiclient.errors import HttpError

from youtube_upload import upload

TOOLS = Path(__file__).resolve().parent
MEDIA = TOOLS.parents[1] / "techsantos-media" / "reels"
STATE = TOOLS / "youtube_state_promos_cursos_novos.json"

LINKS = {
    "excel": "https://techsantos.com.br/curso-excel.php?utm_source=youtube&utm_medium=shorts&utm_campaign=curso_excel&utm_content={slug}",
    "fabric": "https://techsantos.com.br/curso-microsoft-fabric.php?utm_source=youtube&utm_medium=shorts&utm_campaign=curso_fabric&utm_content={slug}",
}
CTA = {
    "excel": "Curso de Excel do zero ao avançado, preparatório MO-210 e MO-211: ",
    "fabric": "Curso de Microsoft Fabric, preparatório DP-600 e DP-700: ",
}
TAGS = {
    "excel": "curso de excel,excel avancado,excel,certificacao microsoft,mo-210,mo-211,tech santos br,shorts",
    "fabric": "microsoft fabric,curso microsoft fabric,dp-600,dp-700,power bi,engenharia de dados,tech santos br,shorts",
}
HASHTAGS = {"excel": "#Excel #CursoDeExcel #Shorts", "fabric": "#MicrosoftFabric #PowerBI #Shorts"}

# (arquivo, título, resumo, publishAt, curso)
ITEMS = [
    ("promo-excel-j-10porcento.mp4", "Você usa só 10% do Excel? #Shorts", "Soma, filtro, copia e cola, e o resto continua um mistério. Do zero ao avançado: PROCX, tabelas dinâmicas, gráficos, cenários, previsão e macros. 17 módulos, 68 aulas, R$ 97.", "2026-10-16T19:00:00-03:00", "excel"),
    ("promo-fabric-l-carreira.mp4", "Analista de Power BI: só Power BI já não basta #Shorts", "Lakehouse, Spark, OneLake: as vagas de dados já pedem Microsoft Fabric. A plataforma de ponta a ponta, em português, com as telas oficiais da Microsoft.", "2026-10-20T19:00:00-03:00", "fabric"),
    ("promo-excel-k-certificacao.mp4", "Excel avançado no currículo? Prove com certificação #Shorts", "O curso segue habilidade por habilidade as provas MO-210 e MO-211: teoria e áudio em cada aula, avaliação por módulo, 2 simulados, 208 questões e certificado.", "2026-10-21T19:00:00-03:00", "excel"),
    ("promo-fabric-m-dp600-dp700.mp4", "DP-600 e DP-700 num curso só #Shorts", "Cada habilidade cobrada nas provas virou uma aula: 82 aulas em 15 módulos, cada uma também em áudio, 192 questões e 2 simulados. R$ 129,90 com acesso vitalício.", "2026-10-22T19:00:00-03:00", "fabric"),
]


def main():
    state = json.loads(STATE.read_text(encoding="utf-8")) if STATE.exists() else {}
    for filename, title, summary, publish_at, kind in ITEMS:
        if filename in state:
            continue
        path = MEDIA / filename
        if not path.exists():
            print(f"MISSING|{filename}")
            continue
        slug = filename.removesuffix(".mp4")
        desc = f"{summary}\n\n{CTA[kind]}{LINKS[kind].format(slug=slug)}\n\n{HASHTAGS[kind]}"
        print(f"UPLOAD|{filename}|{publish_at}", flush=True)
        try:
            result = upload(file_path=str(path), title=title, description=desc, tags=TAGS[kind],
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
