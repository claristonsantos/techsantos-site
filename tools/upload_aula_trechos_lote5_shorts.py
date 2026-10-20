# -*- coding: utf-8 -*-
"""Shorts com trechos reais das aulas — lote 5 (22 a 31/10/2026): Power BI + Microsoft Fabric, às 12h.

Retomável: guarda o que já subiu em youtube_state_aula_trechos_lote5.json.
"""
import json
from pathlib import Path

from googleapiclient.errors import HttpError

from youtube_upload import upload

TOOLS = Path(__file__).resolve().parent
MEDIA = TOOLS.parents[1] / "techsantos-media" / "reels"
STATE = TOOLS / "youtube_state_aula_trechos_lote5.json"

LINK = {
    "pbi": ("Assista grátis às 3 primeiras aulas do curso de Power BI",
            "https://techsantos.com.br/aula-gratis.php?utm_source=youtube&utm_medium=shorts&utm_campaign=aula_trecho&utm_content={slug}"),
    "fab": ("Curso completo de Microsoft Fabric",
            "https://techsantos.com.br/curso-microsoft-fabric.php?utm_source=youtube&utm_medium=shorts&utm_campaign=aula_trecho&utm_content={slug}"),
}
TAGS = {"pbi": "power bi,power query,curso power bi,modelagem de dados,dax,tech santos br,shorts",
        "fab": "microsoft fabric,lakehouse,onelake,engenharia de dados,power bi,tech santos br,shorts"}
HASHTAGS = {"pbi": "#PowerBI #PowerQuery #Shorts", "fab": "#MicrosoftFabric #Lakehouse #Shorts"}

# (arquivo, título, resumo, publishAt, curso)
ITEMS = [
    ("aula-trecho-coluna-exemplo.mp4", "Digite o exemplo e o Power Query escreve a fórmula #Shorts", "Coluna de exemplos: você digita o resultado e o Power Query descobre o padrão e gera a fórmula em M. Trecho real da aula do curso de Power BI.", "2026-10-22T12:00:00-03:00", "pbi"),
    ("aula-trecho-fabric-espelhamento.mp4", "Espelhamento no Microsoft Fabric é de graça? #Shorts", "Replicar é grátis, consultar consome capacidade, e o armazenamento é grátis até 1 TB por CU. Trecho real da aula do curso de Microsoft Fabric.", "2026-10-23T12:00:00-03:00", "fab"),
    ("aula-trecho-directquery.mp4", "DirectQuery ou Import no Power BI? #Shorts", "DirectQuery só quando o dado muda toda hora e alguém precisa ver. Pro dado de ontem, Import resolve. Trecho real da aula do curso de Power BI.", "2026-10-24T12:00:00-03:00", "pbi"),
    ("aula-trecho-fabric-atalho.mp4", "Apagou o atalho no Fabric. E o dado? #Shorts", "Excluir o atalho não apaga o destino; excluir um arquivo dentro do atalho, apaga. Trecho real da aula do curso de Microsoft Fabric.", "2026-10-25T12:00:00-03:00", "fab"),
    ("aula-trecho-tipo-de-dado.mp4", "Error ao juntar colunas no Power Query? #Shorts", "Texto com número não junta: mude o tipo e coloque a etapa antes da coluna personalizada. Trecho real da aula do curso de Power BI.", "2026-10-26T12:00:00-03:00", "pbi"),
    ("aula-trecho-fabric-endpoint-rls.mp4", "RLS no endpoint SQL não protege o Spark #Shorts", "A segurança do endpoint SQL só vale pra quem consulta por ele. Pra valer em tudo, segurança do OneLake. Trecho real da aula do curso de Microsoft Fabric.", "2026-10-27T12:00:00-03:00", "fab"),
    ("aula-trecho-esquema-estrela.mp4", "Fato ou dimensão? O Power BI prefere estrela #Shorts", "O motor do Power BI é otimizado pro esquema estrela: números na fato, textos nas dimensões. Trecho real da aula do curso de Power BI.", "2026-10-28T12:00:00-03:00", "pbi"),
    ("aula-trecho-fabric-arquivos-pequenos.mp4", "Lakehouse lento depois de meses? #Shorts", "Milhares de arquivos pequenos: a manutenção (OPTIMIZE, V-Order, VACUUM) resolve. Trecho real da aula do curso de Microsoft Fabric.", "2026-10-29T12:00:00-03:00", "fab"),
    ("aula-trecho-app-power-bi.mp4", "Vários relatórios num link só: app do Power BI #Shorts", "No workspace você agrupa os relatórios e publica um app. Trecho real da aula do curso de Power BI.", "2026-10-30T12:00:00-03:00", "pbi"),
    ("aula-trecho-fabric-chave-substituta.mp4", "Por que não usar o ID da origem na dimensão? #Shorts", "Chave substituta: gerada no DW, nunca muda e permite o SCD tipo 2. Trecho real da aula do curso de Microsoft Fabric.", "2026-10-31T12:00:00-03:00", "fab"),
]


def main():
    state = json.loads(STATE.read_text(encoding="utf-8")) if STATE.exists() else {}
    for filename, title, summary, publish_at, curso in ITEMS:
        if filename in state:
            continue
        path = MEDIA / filename
        if not path.exists():
            print(f"MISSING|{filename}")
            continue
        slug = filename.removesuffix(".mp4")
        label, link = LINK[curso]
        desc = f"{summary}\n\n{label}: {link.format(slug=slug)}\n\n{HASHTAGS[curso]}"
        print(f"UPLOAD|{filename}|{publish_at}", flush=True)
        try:
            result = upload(file_path=str(path), title=title, description=desc, tags=TAGS[curso],
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
