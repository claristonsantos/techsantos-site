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
