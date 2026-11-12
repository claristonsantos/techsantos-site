<?php
declare(strict_types=1);
require_once __DIR__ . '/../promo_black_friday.php';

/*
 * Faixa da Black Friday no topo das páginas de venda. Some sozinha depois de
 * BF_FIM_UTC. Estilo inline para não depender do tema (modo claro/escuro).
 * A home (index.html, estática) tem uma cópia desta faixa com o mesmo texto,
 * escondida por JavaScript depois do fim da oferta.
 */
function bf_banner(string $origem): string
{
    if (!bf_ativa()) return '';
    $href = '/black-friday.php?utm_source=site&utm_medium=banner&utm_campaign=black-friday-2026&utm_content=' . rawurlencode($origem);
    return '<a href="' . htmlspecialchars($href, ENT_QUOTES) . '" style="display:block;background:#0B0B0F;color:#F4F4F5;text-align:center;'
        . 'padding:.7rem 1rem;font:600 .95rem/1.4 system-ui,-apple-system,Segoe UI,sans-serif;text-decoration:none;border-bottom:3px solid #FACC15;">'
        . '<span style="background:#FACC15;color:#0B0B0F;font-weight:800;letter-spacing:.08em;padding:.15rem .5rem;border-radius:4px;margin-right:.5rem;">BLACK FRIDAY</span>'
        . '4 cursos (Excel, Power BI, Python e Inglês) por <strong style="color:#FACC15;">R$ 119,90</strong> · até ' . BF_FIM_TEXTO
        . ' <span style="text-decoration:underline;margin-left:.35rem;">Ver oferta →</span></a>';
}
