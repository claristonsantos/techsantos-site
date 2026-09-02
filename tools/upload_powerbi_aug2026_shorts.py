# -*- coding: utf-8 -*-
from pathlib import Path
from youtube_upload import upload

ROOT = Path(__file__).resolve().parents[1]
VIDEO_DIR = ROOT / "assets" / "social-video" / "powerbi-ago2026"
ITEMS = [
    ("dica-copilot-visuais-ocultos-1080x1920.mp4", "Copilot lê visuais ocultos no Power BI #Shorts", "O Copilot agora considera visuais ocultos por favoritos de exibição sem mudar o estado do relatório.", "2026-09-05T10:00:00-03:00"),
    ("dica-atualizar-esquema-dados-1080x1920.mp4", "Atualize esquema e dados separadamente no Power BI #Shorts", "O Power BI Service ganhou opções para atualizar esquema, dados ou uma tabela específica.", "2026-09-09T10:00:00-03:00"),
    ("dica-imagens-onelake-powerbi-1080x1920.mp4", "Imagens protegidas do OneLake no Power BI #Shorts", "Use URLs autenticadas do OneLake em imagens, cartões, tabelas, matrizes, segmentações e mapas.", "2026-09-12T10:00:00-03:00"),
    ("dica-valor-central-rosca-1080x1920.mp4", "Valor central nativo no gráfico de rosca #Shorts", "Mostre um total ou uma medida no centro da rosca sem sobrepor um cartão.", "2026-09-15T10:00:00-03:00"),
    ("dica-matriz-expandir-colunas-1080x1920.mp4", "Expanda as colunas da matriz no Power BI #Shorts", "Use os ícones de mais e menos para navegar pelos níveis do cabeçalho das colunas.", "2026-09-18T10:00:00-03:00"),
]

for filename, title, summary, publish_at in ITEMS:
    result = upload(
        file_path=str(VIDEO_DIR / filename), title=title,
        description=f"{summary}\n\nVeja o artigo completo: https://techsantos.com.br/blog/novidades-power-bi-agosto-2026.php?utm_source=youtube&utm_medium=organic_social&utm_campaign=powerbi_agosto_2026\n\n#PowerBI #MicrosoftFabric #Shorts",
        tags="power bi,copilot,microsoft fabric,dados,analytics,tech santos br,shorts",
        category_id="27", privacy="private", publish_at=publish_at,
    )
    print(f"SCHEDULED|{result['id']}|{publish_at}|https://youtube.com/watch?v={result['id']}")
