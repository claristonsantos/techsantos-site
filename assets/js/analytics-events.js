(function () {
  'use strict';
  const sent = new Set();
  const clean = (params) => Object.fromEntries(Object.entries(params || {}).filter(([, value]) => value !== undefined && value !== null && value !== ''));
  window.techSantosTrack = function (eventName, params, metaEventName, metaStandard) {
    if (typeof window.gtag === 'function') window.gtag('event', eventName, clean(params));
    if (typeof window.fbq === 'function' && metaEventName) window.fbq(metaStandard ? 'track' : 'trackCustom', metaEventName, clean(params));
  };
  function once(key, eventName, params, metaEventName, metaStandard) {
    if (sent.has(key)) return;
    sent.add(key);
    window.techSantosTrack(eventName, params, metaEventName, metaStandard);
  }
  const path = window.location.pathname.toLowerCase();
  const course = { currency: 'BRL', items: [{ item_id: 'power-bi', item_name: 'Curso Power BI', item_category: 'Curso online' }] };
  if (path.endsWith('/curso-power-bi.php')) once('course_view', 'view_item', course);
  if (path.endsWith('/aula-gratis.php')) once('free_preview_view', 'free_preview_viewed', { content_name: '3 aulas grátis — Curso Power BI' }, 'ViewContent', true);
  if (path.endsWith('/comprar.php')) once('checkout_view', 'begin_checkout', course);
  document.addEventListener('click', function (event) {
    const link = event.target.closest('a[href]');
    if (!link) return;
    const href = link.getAttribute('href') || '';
    if (/^(https?:\/\/)?(wa\.me|api\.whatsapp\.com)\//i.test(href)) {
      window.techSantosTrack('contact', { method: 'whatsapp', link_url: link.href, link_text: (link.textContent || '').trim().slice(0, 100), page_path: path }, 'Contact', true);
    }
  });
})();
