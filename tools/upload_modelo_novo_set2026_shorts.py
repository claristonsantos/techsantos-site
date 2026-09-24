# -*- coding: utf-8 -*-
"""Shorts do modelo novo (padrão fabric-reels) que ainda não estavam no YouTube
em 2026-09-24: 2 Fabric, 13 dicas e 6 promos. Agenda = regra fixa de melhores
horários (1 por dia; educativo 10h, promo 19h em terça/quarta).

Cota padrão da API = 10.000 unidades/dia e cada upload custa 1.600, então só
cabem ~6 uploads por dia. O script é retomável: guarda o que já subiu em
youtube_state_modelo_novo_set2026.json, pula esses itens e para limpo ao bater
na cota. Rode de novo no dia seguinte até completar.
"""
import json
from pathlib import Path

from googleapiclient.errors import HttpError

from youtube_upload import upload

TOOLS = Path(__file__).resolve().parent
MEDIA = TOOLS.parents[1] / "techsantos-media" / "reels"
STATE = TOOLS / "youtube_state_modelo_novo_set2026.json"

LINK = "https://techsantos.com.br/aula-gratis.php?utm_source=youtube&utm_medium=shorts&utm_campaign=aula_gratis&utm_content={slug}"
LINK_AULAS = "https://techsantos.com.br/aulas-particulares-power-bi.php?utm_source=youtube&utm_medium=shorts&utm_campaign=aula_particular&utm_content={slug}"

# (arquivo, título, resumo, publishAt, tipo) — ordenado pela data de publicação
ITEMS = [
    ("dica-powerbi-botoes.mp4", "Botões de navegação no Power BI #Shorts", "Trava numa página do relatório sem jeito de voltar? Botões de navegação levam o usuário direto para a página certa, sem depender das abas.", "2026-09-25T10:00:00-03:00", "dica"),
    ("dica-excel-index-corresp.mp4", "PROCV só olha pra direita? Use ÍNDICE + CORRESP #Shorts", "Quando a coluna de retorno fica à esquerda, o PROCV não resolve. ÍNDICE junto com CORRESP busca em qualquer direção.", "2026-09-26T10:00:00-03:00", "dica"),
    ("fabric-direct-lake.mp4", "Nem Import nem DirectQuery: Direct Lake no Fabric #Shorts", "Direct Lake lê os dados do OneLake direto, sem cópia no modelo e sem consulta a cada clique. Entenda quando usar esse modo de armazenamento.", "2026-09-27T10:00:00-03:00", "fabric"),
    ("dica-powerbi-marcadores.mp4", "Dois cenários sem duplicar página no Power BI #Shorts", "Marcadores salvam o estado do relatório: filtros, seleção e visibilidade. Mostre cenários diferentes na mesma página.", "2026-09-28T10:00:00-03:00", "dica"),
    ("promo-f2-prova-social.mp4", "5.0 estrelas em 46 avaliações reais #Shorts", "Não precisa confiar em mim: assista às 3 primeiras aulas do curso de Power BI de graça, na plataforma real do curso. Sem cartão.", "2026-09-29T19:00:00-03:00", "promo"),
    ("promo-g2-dor-procv.mp4", "Ainda repete o mesmo PROCV toda semana? #Shorts", "Veja em 3 aulas grátis como montar no Power BI um relatório que se atualiza sozinho. Do zero, sem programar.", "2026-09-30T19:00:00-03:00", "promo"),
    ("dica-excel-escala-cor.mp4", "Compare números de relance com escala de cor no Excel #Shorts", "Escala de cor na formatação condicional pinta os valores do menor ao maior. Você enxerga o padrão sem ler número por número.", "2026-10-01T10:00:00-03:00", "dica"),
    ("dica-copilot-dax.mp4", "Copilot escreve a medida DAX pra você #Shorts", "Descreva em português o que quer calcular e o Copilot do Power BI sugere o DAX. Revise sempre antes de aplicar no modelo.", "2026-10-02T10:00:00-03:00", "dica"),
    ("fabric-dataflows-gen2.mp4", "Transformar dados sem código com Dataflows Gen2 #Shorts", "Dataflows Gen2 usam a experiência do Power Query para limpar e transformar dados no Microsoft Fabric e gravar em destinos como Lakehouse e Warehouse.", "2026-10-03T10:00:00-03:00", "fabric"),
    ("dica-excel-lambda.mp4", "Crie sua própria função no Excel com LAMBDA #Shorts", "Pare de colar a mesma fórmula gigante em toda coluna. Com LAMBDA e o Gerenciador de Nomes sua lógica vira uma função com nome, sem VBA.", "2026-10-04T10:00:00-03:00", "dica"),
    ("dica-powerbi-tempo-relativo.mp4", "Filtro de data que se atualiza sozinho no Power BI #Shorts", "Filtro de tempo relativo mostra sempre os últimos dias, semanas ou meses, sem você lembrar de trocar a data.", "2026-10-05T10:00:00-03:00", "dica"),
    ("promo-curso-apostila.mp4", "Curso bom não é só preço baixo #Shorts", "O curso de Power BI tem apostila própria, com teoria e exercício aplicado em cada módulo. Veja a apostila nas aulas grátis.", "2026-10-06T19:00:00-03:00", "promo"),
    ("promo-h2-objecao-garantia.mp4", "Medo de pagar um curso e não gostar? #Shorts", "Assista às 3 primeiras aulas de Power BI de graça antes de decidir. Se comprar e tiver visto menos de 20%, devolvemos 100%.", "2026-10-07T19:00:00-03:00", "promo"),
    ("dica-powerbi-rls.mp4", "Cada vendedor só vê o que é dele: RLS no Power BI #Shorts", "Segurança em nível de linha filtra os dados por quem está logado. Crie a regra em Gerenciar Funções e teste com Exibir Como antes de publicar.", "2026-10-08T10:00:00-03:00", "dica"),
    ("dica-excel-python.mp4", "Python direto na célula do Excel #Shorts", "Com =PY() você usa pandas e matplotlib dentro da planilha e o resultado aparece na própria célula, sem sair do Excel.", "2026-10-09T10:00:00-03:00", "dica"),
    ("dica-powerbi-tema.mp4", "Seu relatório com a cara da empresa: tema no Power BI #Shorts", "Um tema personalizado aplica cores, fontes e estilos no relatório inteiro de uma vez, em vez de formatar visual por visual.", "2026-10-10T10:00:00-03:00", "dica"),
    ("dica-copilot-resumo.mp4", "Copilot resume seu relatório do Power BI #Shorts", "Ninguém lê 12 páginas toda semana. Peça ao Copilot um resumo em linguagem natural do que mudou e do que chama atenção nos dados.", "2026-10-11T10:00:00-03:00", "dica"),
    ("dica-powerbi-fieldparams.mp4", "Um slicer troca a métrica inteira no Power BI #Shorts", "Field parameters juntam várias medidas num controle só. Pare de duplicar o mesmo gráfico para cada métrica.", "2026-10-12T10:00:00-03:00", "dica"),
    ("promo-i2-autoridade.mp4", "Quem te ensina Power BI já entregou projeto? #Shorts", "Instrutor certificado Microsoft, com mais de 50 projetos de BI entregues. Veja o método nas 3 aulas grátis do curso.", "2026-10-13T19:00:00-03:00", "promo"),
    ("promo-aula-objecao.mp4", "Aula particular de Power BI é cara? #Shorts", "Ficar travado no mesmo erro por semanas custa mais caro. Uma hora bem aplicada resolve o que travaria dias. Online, individual, no seu horário.", "2026-10-14T19:00:00-03:00", "aula"),
    ("dica-powerbi-powerpoint.mp4", "Power BI ao vivo dentro do PowerPoint #Shorts", "O suplemento do Power BI para PowerPoint coloca o relatório interativo no slide, com dados atualizados, em vez de um print parado.", "2026-10-15T10:00:00-03:00", "dica"),
]

TAGS = {
    "dica": "power bi,excel,dica,dax,analise de dados,tech santos br,shorts",
    "fabric": "microsoft fabric,power bi,dados,engenharia de dados,tech santos br,shorts",
    "promo": "curso power bi,power bi,curso online,aula gratis,tech santos br,shorts",
    "aula": "aula particular power bi,power bi,mentoria,tech santos br,shorts",
}
HASHTAGS = {
    "dica": "#PowerBI #Excel #Shorts",
    "fabric": "#MicrosoftFabric #PowerBI #Shorts",
    "promo": "#PowerBI #CursoPowerBI #Shorts",
    "aula": "#PowerBI #AulaParticular #Shorts",
}


def description(summary, kind, slug):
    if kind == "aula":
        cta = "Aula particular de Power BI, online e no seu horário: " + LINK_AULAS.format(slug=slug)
    else:
        cta = "Assista grátis às 3 primeiras aulas do curso de Power BI: " + LINK.format(slug=slug)
    return f"{summary}\n\n{cta}\n\n{HASHTAGS[kind]}"


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
        print(f"UPLOAD|{filename}|{publish_at}", flush=True)
        try:
            result = upload(
                file_path=str(path),
                title=title,
                description=description(summary, kind, slug),
                tags=TAGS[kind],
                category_id="27",
                privacy="private",
                publish_at=publish_at,
            )
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
