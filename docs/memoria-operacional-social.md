# Memória operacional — conteúdo e redes sociais

Atualizada em 10/08/2026.

## Objetivo

- Promover a Tech Santos e aumentar as vendas do curso de Power BI.
- Alternar conteúdos inéditos de Excel, Power BI e Microsoft Fabric.
- Não repetir assuntos ou vídeos já publicados ou agendados.

## Regras permanentes

- Conteúdo sobre produtos Microsoft deve usar imagens, capturas e diagramas oficiais da Microsoft Learn.
- Elementos gráficos próprios podem complementar as imagens oficiais.
- Revisar todas as pronúncias técnicas antes da aprovação.
- A legenda e o texto visual mantêm a nomenclatura oficial; somente o texto interno da voz pode receber grafia fonética.
- Não colocar vídeos em `public` nem enviá-los ao Git, para não prejudicar os deploys.
- Fazer upload manual dos MP4 para `media.techsantos.com.br/reels/`.
- Antes de agendar, confirmar resposta HTTP 200, `Content-Type: video/mp4` e tamanho do arquivo.
- Não guardar chaves, tokens ou senhas nesta memória.

## Fluxos por plataforma

- Instagram Reels: registros na tabela `social_posts` com `canal=instagram`, `tipo=reels`, `midia_tipo=video` e `status=pendente`. O `social_publish_cron.php` publica na data.
- O banco trabalha com UTC. Horário de 10h em Brasília corresponde a 13h UTC.
- Inclusões devem ser idempotentes, verificando `imagem_url` para impedir duplicação.
- YouTube Shorts: upload e agendamento direto pela API do YouTube.
- TikTok: depende do Metricool; o site não possui publicação automática para TikTok.
- Stories do Instagram são replicados automaticamente para a Página do Facebook após a publicação; não criar um segundo agendamento de Story no Facebook.
- Facebook Reels: integrado ao painel do site pela Video Reels API v25.0, com agendamento nativo da Meta. Feed permanece no fluxo anterior.
- Utilitários temporários de produção usam `SETUP_KEY`, executam uma vez e são removidos depois. Nunca registrar a chave.

## Série Microsoft Fabric aprovada

Quatro vídeos inéditos, verticais 1080×1920, 30 segundos, H.264/AAC, música original discreta e voz `pt-BR-AntonioNeural`:

- `fabric-onelake.mp4`
- `fabric-lakehouse-warehouse.mp4`
- `fabric-data-factory.mp4`
- `fabric-pipeline.mp4`

Arquivos locais: `assets/social-video/fabric/`.

Fontes e projeto de produção: `tools/fabric-reels/`.

Pacote para Hostinger: `fabric-videos-hostinger.zip`.

Termos cuja pronúncia foi revisada: Microsoft Fabric, Power BI, OneLake, workspaces, Lakehouse, Warehouse, Spark, T-SQL, Data Factory, Dataflow Gen2, pipeline, pipelines, notebooks, dataflows e API.

## URLs públicas

- `https://media.techsantos.com.br/reels/fabric-onelake.mp4`
- `https://media.techsantos.com.br/reels/fabric-lakehouse-warehouse.mp4`
- `https://media.techsantos.com.br/reels/fabric-data-factory.mp4`
- `https://media.techsantos.com.br/reels/fabric-pipeline.mp4`

## Instagram agendado

- ID 162 — OneLake — 14/08/2026, 10h BRT — `pendente`.
- ID 163 — Lakehouse ou Warehouse — 17/08/2026, 10h BRT — `pendente`.
- ID 164 — Data Factory — 21/08/2026, 10h BRT — `pendente`.
- ID 165 — Pipelines — 24/08/2026, 10h BRT — `pendente`.

## Facebook Reels agendado

- ID 166 — OneLake — `post_id 1718586190275611` — 14/08/2026, 10h BRT — `agendado_meta`.
- ID 167 — Lakehouse ou Warehouse — `post_id 1718586600275570` — 17/08/2026, 10h BRT — `agendado_meta`.
- ID 168 — Data Factory — `post_id 1718586706942226` — 21/08/2026, 10h BRT — `agendado_meta`.
- ID 169 — Pipelines — `post_id 1718586793608884` — 24/08/2026, 10h BRT — `agendado_meta`.

Observação técnica: o CDN da Hostinger respondeu HTTP 429 quando a Meta tentou buscar os MP4. Para este lote, os arquivos locais foram enviados diretamente ao servidor de upload da Meta. A integração usa v25.0 somente para Facebook Reels, sem alterar feed, Instagram ou Stories.
## YouTube Shorts agendado

- OneLake — ID `LtLuK8m4q4o` — 14/08/2026, 10h BRT.
- Lakehouse ou Warehouse — ID `jEsAFyB3imo` — 17/08/2026, 10h BRT.
- Data Factory — ID `vtuDZB1yq_I` — 21/08/2026, 10h BRT.
- Pipelines — ID `E8s9_ppfi28` — 24/08/2026, 10h BRT.

## Calendário Excel existente

As dez dicas de Excel já estão agendadas em 12, 13, 18, 19, 20, 25, 26 e 27 de agosto e 1 e 2 de setembro de 2026. Não repetir nem substituir essas publicações.

## Histórico técnico

- `0f4dde2`: adicionou o agendador temporário dos Reels do Fabric.
- `5c2cd9e`: adicionou o verificador temporário da fila.
- `4f9c3ca`: removeu os dois utilitários temporários após a confirmação.
