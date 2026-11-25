<?php
declare(strict_types=1);
require_once __DIR__ . '/../promo_black_friday.php';

/*
 * Cartão da Black Friday (imagem de fundo + 4 cursos + preço + CTA) para o blog e a página de consultoria.
 * Some sozinho depois de BF_FIM_UTC. Estilo inline para não depender do tema (modo claro/escuro).
 * O clique é medido pelo evento course_cta_click (data-course-cta), sem UTM em link interno.
 */
function bf_card(string $origem, string $titulo = 'Aprenda a fazer isso (e muito mais) com 4 cursos completos'): string
{
    if (!bf_ativa()) return '';
    $href = '/black-friday.php?origem=' . rawurlencode($origem);
    $chips = '';
    foreach (['Power BI', 'Excel', 'Python', 'Inglês'] as $c) {
        $chips .= '<span style="background:#7ED956;color:#0F2440;font-weight:800;border-radius:999px;padding:.3rem .85rem;font-size:.95rem;">' . $c . '</span>';
    }
    $e = fn(string $s) => htmlspecialchars($s, ENT_QUOTES);
    return '<aside style="margin:2.5rem 0;border-radius:18px;overflow:hidden;position:relative;color:#F8FAFC;'
        . 'background:#050B16 url(/assets/img/bf-card-bg.jpg) right center/cover no-repeat;box-shadow:0 12px 40px rgba(5,11,22,.35);">'
        . '<div style="background:linear-gradient(90deg,rgba(5,11,22,.96) 0%,rgba(5,11,22,.88) 55%,rgba(5,11,22,.35) 100%);padding:2rem 1.75rem;">'
        . '<p style="margin:0 0 .6rem;font:800 .8rem/1 system-ui,sans-serif;letter-spacing:.14em;color:#7ED956;">BLACK FRIDAY · ATÉ ' . $e(mb_strtoupper(BF_FIM_TEXTO, 'UTF-8')) . '</p>'
        . '<p style="margin:0 0 1rem;font:800 1.55rem/1.2 system-ui,sans-serif;color:#F8FAFC;max-width:34rem;">' . $e($titulo) . '</p>'
        . '<div style="display:flex;flex-wrap:wrap;gap:.5rem;margin-bottom:1.1rem;">' . $chips . '</div>'
        . '<p style="margin:0 0 1.2rem;font:600 1rem/1.4 system-ui,sans-serif;color:#CBD5E1;">'
        . 'De <s style="text-decoration-color:#EF4444;">R$ 336,70</s> por <strong style="color:#7ED956;font-size:1.6rem;">R$ 119,90</strong>'
        . ' · acesso vitalício · garantia incondicional de 7 dias · parcelado em até 12x</p>'
        . '<a href="' . $e($href) . '" data-course-cta="' . $e('bf-card-' . $origem) . '" style="display:inline-block;background:#7ED956;color:#0F2440;'
        . 'font:800 1.05rem/1 system-ui,sans-serif;text-decoration:none;border-radius:999px;padding:.95rem 1.6rem;">Ver a oferta →</a>'
        . '</div></aside>';
}
