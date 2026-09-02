# -*- coding: utf-8 -*-
import asyncio
import json
import subprocess
from pathlib import Path

import edge_tts
from PIL import Image, ImageDraw, ImageFont

ROOT = Path(__file__).resolve().parents[1]
OUT = ROOT / "assets" / "social-video" / "powerbi-ago2026"
TMP = OUT / "tmp"
W, H, FPS = 1080, 1920, 30
NAVY, NAVY2, GREEN, WHITE, MUTED, BLUE = "#061426", "#0d2947", "#72e33f", "#f7faf7", "#bfd0e3", "#3d8bfd"
VOICE = "pt-BR-AntonioNeural"
MUSIC = ROOT / "tools" / "fabric-reels" / "public" / "audio" / "tech-pulse.m4a"
LOGO = ROOT / "assets" / "img" / "logo.jpg"

TIPS = [
    {"slug":"dica-copilot-visuais-ocultos","tag":"COPILOT NO POWER BI","script":"Seu gráfico está escondido por um favorito? O Copilot agora consegue enxergá-lo. O resumo do Copilot pode considerar visuais ocultos por padrão e revelados por um favorito que altera somente a exibição. Ele lê o visual sem mudar o estado do favorito, e as regras de segurança continuam valendo. Salve para revisar seus favoritos antes do próximo resumo.","scenes":[("O COPILOT ENXERGA","visuais ocultos por favoritos","NOVIDADE"),("SEM ABRIR O VISUAL","o favorito não muda de estado","RLS E OLS CONTINUAM"),("USE COM CUIDADO","vale para favoritos de exibição","SALVE ESTA DICA")]},
    {"slug":"dica-atualizar-esquema-dados","tag":"POWER BI SERVICE","script":"Mudou uma coluna na fonte? Agora o Power BI Service oferece mais controle sobre a atualização. Você pode atualizar esquema e dados, sincronizar somente o esquema ou atualizar somente os dados. Também dá para atualizar uma tabela específica. Só revise antes: remover ou renomear colunas pode quebrar medidas, relacionamentos e visuais.","scenes":[("ATUALIZE SÓ O NECESSÁRIO","esquema e dados separados","MAIS CONTROLE"),("TRÊS OPÇÕES","esquema + dados, esquema ou dados","POR TABELA TAMBÉM"),("REVISE ANTES","mudanças podem quebrar o modelo","COMPARTILHE")]},
    {"slug":"dica-imagens-onelake-powerbi","tag":"ONELAKE + POWER BI","script":"A imagem do relatório não precisa mais ficar pública na internet. URLs de arquivos do OneLake podem alimentar imagens, cartões, tabelas, matrizes, segmentações e mapas. O Power BI autentica cada pessoa com a identidade do Microsoft Entra. Lembre: acesso ao relatório não libera automaticamente o arquivo.","scenes":[("IMAGEM PROTEGIDA","direto do OneLake no relatório","SEM URL PÚBLICA"),("FUNCIONA EM VISUAIS","cartão, tabela, matriz e mapa","URL AUTENTICADA"),("PERMISSÃO DUPLA","relatório e arquivo no OneLake","SALVE ESTA DICA")]},
    {"slug":"dica-valor-central-rosca","tag":"VISUAL DO POWER BI","script":"Pare de sobrepor um cartão no meio do gráfico de rosca. Agora existe valor central nativo. Abra Formatar visual, ative Valor central e escolha o total ou uma medida personalizada. O número acompanha filtros, realces, drill down e seleção das fatias. O recurso é do gráfico de rosca, não do gráfico de pizza.","scenes":[("TOTAL DENTRO DA ROSCA","sem cartão sobreposto","AGORA É NATIVO"),("FORMATE O VALOR","total ou medida personalizada","RESPONDE AOS FILTROS"),("ATENÇÃO","não está disponível no gráfico de pizza","ENVIE PARA O TIME")]},
    {"slug":"dica-matriz-expandir-colunas","tag":"MATRIZ DO POWER BI","script":"A matriz ganhou o sinal de mais também no cabeçalho das colunas. Com dois ou mais campos em Colunas, o usuário pode expandir ou recolher os níveis no próprio visual. Em Cabeçalhos de coluna, você personaliza cor e tamanho dos ícones. Também pode definir a expansão automática.","scenes":[("EXPANDA AS COLUNAS","mais e menos no cabeçalho","MATRIZ MAIS FÁCIL"),("USE HIERARQUIAS","ano, trimestre e mês","SEM TROCAR O VISUAL"),("PERSONALIZE","cor, tamanho e expansão automática","TESTE NO RELATÓRIO")]},
]

def font(size, bold=False):
    path = Path("C:/Windows/Fonts/arialbd.ttf" if bold else "C:/Windows/Fonts/arial.ttf")
    return ImageFont.truetype(str(path), size)

def fitted(draw, text, width, start=82, minimum=44):
    for size in range(start, minimum - 1, -2):
        f = font(size, True)
        if draw.textbbox((0,0), text, font=f)[2] <= width:
            return f
    return font(minimum, True)

def card(tip, scene, number, path):
    title, subtitle, badge = scene
    im = Image.new("RGB", (W,H), NAVY)
    d = ImageDraw.Draw(im)
    for y in range(H):
        r=y/H; d.line((0,y,W,y), fill=(6+int(8*r),20+int(25*r),38+int(42*r)))
    d.ellipse((650,100,1250,700), fill=(12,54,86), outline=GREEN, width=4)
    d.ellipse((-320,1180,380,1880), fill=(10,37,65), outline=BLUE, width=4)
    d.rounded_rectangle((62,280,610,350), radius=28, fill=GREEN)
    d.text((92,300), tip["tag"], font=font(25,True), fill=NAVY)
    d.text((936,300), f"0{number}", font=font(24,True), fill=MUTED)
    f=fitted(d,title,940); d.text((66,506),title,font=f,fill="#000000"); d.text((62,502),title,font=f,fill=WHITE)
    d.rectangle((62,640,290,652),fill=GREEN)
    sub=fitted(d,subtitle,930,50,34); d.text((62,730),subtitle,font=sub,fill=MUTED)
    d.rounded_rectangle((62,1190,1018,1385),radius=34,fill=(7,25,46),outline=GREEN,width=3)
    bf=fitted(d,badge,850,60,40); box=d.textbbox((0,0),badge,font=bf); d.text(((W-(box[2]-box[0]))/2,1250),badge,font=bf,fill=GREEN)
    if LOGO.exists(): im.paste(Image.open(LOGO).convert("RGB").resize((92,92)),(62,1510))
    d.text((180,1525),"TECH SANTOS BR",font=font(34,True),fill=WHITE)
    d.text((180,1572),"Fonte: Microsoft Learn · agosto de 2026",font=font(23),fill=MUTED)
    d.text((62,1730),"techsantos.com.br/blog",font=font(28,True),fill=WHITE)
    im.save(path,quality=95)

async def voice(tip):
    p=TMP/f"{tip['slug']}-voice.mp3"
    await edge_tts.Communicate(tip["script"],VOICE,rate="-3%",pitch="-2Hz").save(str(p)); return p

def duration(path):
    return float(subprocess.check_output(["ffprobe","-v","error","-show_entries","format=duration","-of","default=nw=1:nk=1",str(path)],text=True).strip())

def render(tip, audio):
    total=duration(audio)+.4; parts=[]
    for i,scene in enumerate(tip["scenes"],1):
        still=TMP/f"{tip['slug']}-{i}.jpg"; part=TMP/f"{tip['slug']}-{i}.mp4"; card(tip,scene,i,still)
        subprocess.run(["ffmpeg","-y","-loop","1","-i",str(still),"-vf",f"scale={W}:{H},fps={FPS},zoompan=z='min(zoom+0.0008,1.035)':d=1:s={W}x{H}:fps={FPS}","-t",f"{total/3:.3f}","-an","-c:v","libx264","-preset","medium","-crf","18","-pix_fmt","yuv420p",str(part)],check=True,stdout=subprocess.DEVNULL,stderr=subprocess.DEVNULL); parts.append(part)
    listing=TMP/f"{tip['slug']}.txt"; listing.write_text("\n".join(f"file '{p.as_posix()}'" for p in parts),encoding="utf-8")
    visual=TMP/f"{tip['slug']}-visual.mp4"; subprocess.run(["ffmpeg","-y","-f","concat","-safe","0","-i",str(listing),"-c","copy",str(visual)],check=True,stdout=subprocess.DEVNULL,stderr=subprocess.DEVNULL)
    final=OUT/f"{tip['slug']}-1080x1920.mp4"; inputs=["-i",str(visual),"-i",str(audio)]
    if MUSIC.exists():
        inputs += ["-stream_loop","-1","-i",str(MUSIC)]; mix=f"[1:a]loudnorm=I=-16:TP=-1.5:LRA=7[v];[2:a]atrim=0:{total:.3f},volume=.08[m];[v][m]amix=inputs=2:duration=longest:normalize=0[a]"
    else: mix="[1:a]loudnorm=I=-16:TP=-1.5:LRA=7[a]"
    subprocess.run(["ffmpeg","-y",*inputs,"-filter_complex",mix,"-map","0:v","-map","[a]","-t",f"{total:.3f}","-c:v","copy","-c:a","aac","-b:a","192k","-movflags","+faststart",str(final)],check=True,stdout=subprocess.DEVNULL,stderr=subprocess.DEVNULL)
    cover=OUT/f"{tip['slug']}-capa.jpg"; card(tip,tip["scenes"][0],1,cover); return final,cover

async def main():
    OUT.mkdir(parents=True,exist_ok=True); TMP.mkdir(parents=True,exist_ok=True); result=[]
    for tip in TIPS:
        a=await voice(tip); video,cover=render(tip,a); result.append({"slug":tip["slug"],"video":video.name,"cover":cover.name,"duration":round(duration(video),3),"bytes":video.stat().st_size,"resolution":"1080x1920","fps":FPS})
    (OUT/"manifest.json").write_text(json.dumps(result,ensure_ascii=False,indent=2),encoding="utf-8"); print(json.dumps(result,ensure_ascii=False,indent=2))

if __name__ == "__main__": asyncio.run(main())
