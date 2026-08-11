# Plano de mensuração — TECH SANTOS BR

Atualizado em 10/08/2026.

## Ferramentas

- Google Analytics 4: `G-QD3YFBCMC6`
- Meta Pixel: carregado por `inc/meta-pixel.php`
- Meta Conversions API: compra confirmada pelo webhook do Mercado Pago
- GA4 Measurement Protocol: compra confirmada pelo webhook do Mercado Pago

## Eventos

| Evento GA4 | Evento Meta | Gatilho | Propriedades principais |
|---|---|---|---|
| `page_view` | `PageView` | Carregamento de página | automáticas |
| `view_item` | `ViewContent` | Página do curso | curso e categoria |
| `free_preview_viewed` | `ViewContent` | Página das aulas grátis | nome do conteúdo |
| `video_start` | `FreeLessonStarted` | Primeiro play de cada aula grátis | aula e título |
| `video_progress` | — | 25% e 75% assistidos | aula e percentual |
| `video_complete` | `FreeLessonCompleted` | Aula grátis concluída | aula e título |
| `generate_lead` | `Lead` | Telefone salvo com sucesso | WhatsApp e origem |
| `contact` | `Contact` | Clique em link do WhatsApp | página, texto e URL |
| `begin_checkout` | `InitiateCheckout` | Entrada no checkout | curso e moeda |
| `purchase` | `Purchase` | Pagamento aprovado pelo Mercado Pago | pedido, valor, moeda e curso |

## Conversões recomendadas

Marcar como eventos principais no GA4:

- `generate_lead`
- `begin_checkout`
- `purchase`

Manter como diagnóstico de conteúdo:

- `video_start`
- `video_progress`
- `video_complete`
- `contact`

## Convenção de UTM

- `utm_source`: `instagram`, `facebook`, `tiktok`, `youtube`, `blog`
- `utm_medium`: `organic_social`, `paid_social`, `video`, `referral`
- `utm_campaign`: objetivo e período, por exemplo `curso_power_bi_ago_2026`
- `utm_content`: identificação da peça, por exemplo `reel_seerro_hook_a`

Não enviar nome, telefone, e-mail ou CPF em eventos do navegador.
## Persistência de atribuição

- As UTMs válidas da página de entrada são guardadas durante a sessão e como último toque conhecido por até 90 dias.
- Os parâmetros `campaign_source`, `campaign_medium`, `campaign_name`, `campaign_content`, `campaign_term` e `campaign_landing_page` acompanham os eventos personalizados.
- A origem persistida é reutilizada no cadastro do telefone da aula gratuita, mesmo quando o visitante navega por outras páginas antes de converter.
- A compra aprovada continua vinculada ao GA4 pelo `ga4_client_id` salvo no pedido.
- Nenhum nome, telefone, e-mail ou CPF é armazenado na atribuição do navegador ou enviado como propriedade de campanha.

### Leitura recomendada do funil

1. `free_preview_viewed` por `campaign_source` e `campaign_content`.
2. `video_start` e `video_complete` por conteúdo de origem.
3. `generate_lead` ou `begin_checkout` por campanha.
4. `purchase` para receita confirmada.
5. `contact` separado entre páginas de curso e consultoria por `page_path`.
