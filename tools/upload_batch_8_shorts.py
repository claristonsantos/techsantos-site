# -*- coding: utf-8 -*-
import sys
import os
sys.path.insert(0, os.path.dirname(__file__))
from youtube_upload import upload

BASE = r"C:\rmp\out"

ITEMS = [
    {
        "file": os.path.join(BASE, "dica11-coluna-lenta.mp4"),
        "title": "Por que seu Power BI fica lento? #Shorts",
        "description": "Coluna calculada grava um valor fixo em cada linha e engorda o arquivo inteiro. Troque por uma medida sempre que der -- ela calcula na hora e não ocupa espaço a mais no modelo.\n\nCurso completo de Power BI: https://techsantos.com.br",
        "tags": "powerbi,dax,medida,colunacalculada,dica,excel",
        "publish_at": "2026-07-20T10:00:00-03:00",
    },
    {
        "file": os.path.join(BASE, "dica12-relacionamento.mp4"),
        "title": "Seu total duplicou sozinho no Power BI? #Shorts",
        "description": "Relacionamento muitos-pra-muitos escondido no modelo multiplica o valor. Sempre coloque uma dimensão no meio -- nunca deixe fato ligado direto com fato.\n\nCurso completo de Power BI: https://techsantos.com.br",
        "tags": "powerbi,relacionamento,modelagemdedados,dica",
        "publish_at": "2026-07-21T20:00:00-03:00",
    },
    {
        "file": os.path.join(BASE, "novidade-jun2026-copilot.mp4"),
        "title": "Copilot chegou na modelagem do Power BI #Shorts",
        "description": "Novidade de junho: o Copilot ajuda a modelar dados direto no navegador, sem precisar abrir o Power BI Desktop. Ainda em preview.\n\nCurso completo de Power BI: https://techsantos.com.br",
        "tags": "powerbi,copilot,novidades,ia",
        "publish_at": "2026-07-22T10:00:00-03:00",
    },
    {
        "file": os.path.join(BASE, "novidade-jun2026-data-relativa.mp4"),
        "title": "Slicer de data que rola sozinho no Power BI #Shorts",
        "description": "Novidade de junho: configure o período relativo uma vez (ex: últimos 6 meses) e ele avança sozinho a cada atualização.\n\nCurso completo de Power BI: https://techsantos.com.br",
        "tags": "powerbi,slicer,novidades",
        "publish_at": "2026-07-23T20:00:00-03:00",
    },
    {
        "file": os.path.join(BASE, "novidade-jun2026-matrix.mp4"),
        "title": "Matriz com Auto Expand no Power BI #Shorts",
        "description": "Novidade de junho: a matriz já abre com todos os níveis da hierarquia expandidos, sem clicar grupo por grupo.\n\nCurso completo de Power BI: https://techsantos.com.br",
        "tags": "powerbi,matriz,novidades",
        "publish_at": "2026-07-24T10:00:00-03:00",
    },
    {
        "file": os.path.join(BASE, "novidade-jun2026-datepicker.mp4"),
        "title": "Novo slicer Date Picker no Power BI #Shorts",
        "description": "Novidade de junho: o slicer de data ganhou um estilo novo, com calendário embutido direto no visual.\n\nCurso completo de Power BI: https://techsantos.com.br",
        "tags": "powerbi,slicer,datepicker,novidades",
        "publish_at": "2026-07-27T10:00:00-03:00",
    },
    {
        "file": os.path.join(BASE, "promo-reels-d.mp4"),
        "title": "O relatório que só você sabe mexer #Shorts",
        "description": "Construa um modelo de dados documentado que qualquer pessoa da equipe entende -- não fique refém do seu próprio relatório.\n\nCurso completo de Power BI: https://techsantos.com.br",
        "tags": "powerbi,curso,carreira",
        "publish_at": "2026-07-28T19:00:00-03:00",
    },
    {
        "file": os.path.join(BASE, "promo-reels-e.mp4"),
        "title": "Enquanto você só usa Excel... #Shorts",
        "description": "Aprenda a montar dashboards em Power BI que conectam direto na fonte e atualizam sozinhos, sem copiar e colar toda semana.\n\nCurso completo de Power BI: https://techsantos.com.br",
        "tags": "powerbi,excel,curso",
        "publish_at": "2026-07-29T19:00:00-03:00",
    },
]

for it in ITEMS:
    print(f"\n=== Enviando: {os.path.basename(it['file'])} ===")
    try:
        result = upload(
            file_path=it["file"],
            title=it["title"],
            description=it["description"],
            tags=it["tags"],
            category_id="27",
            privacy="private",
            publish_at=it["publish_at"],
        )
        print(f"OK id={result['id']} publish_at={it['publish_at']} url=https://youtube.com/watch?v={result['id']}")
    except Exception as e:
        print(f"FALHA em {it['file']}: {e}")

print("\nLote concluído.")
