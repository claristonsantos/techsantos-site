(function () {
  'use strict';

  const sent = new Set();
  const attributionKey = 'ts_campaign_attribution_v1';
  const campaignMap = {
    utm_source: 'campaign_source',
    utm_medium: 'campaign_medium',
    utm_campaign: 'campaign_name',
    utm_content: 'campaign_content',
    utm_term: 'campaign_term'
  };

  const clean = (params) => Object.fromEntries(Object.entries(params || {}).filter(([, value]) => value !== undefined && value !== null && value !== ''));
  const safeCampaignValue = (value) => String(value || '').toLowerCase().replace(/[^a-z0-9_-]/g, '').slice(0, 100);

  function readStoredAttribution(storage) {
    try {
      const raw = storage.getItem(attributionKey);
      if (!raw) return {};
      const value = JSON.parse(raw);
      const maxAge = 90 * 24 * 60 * 60 * 1000;
      if (!value._stored_at || Date.now() - value._stored_at > maxAge) {
        storage.removeItem(attributionKey);
        return {};
      }
      const { _stored_at, ...publicAttribution } = value;
      return publicAttribution;
    } catch (_) {
      return {};
    }
  }

  function saveAttribution(value) {
    const serialized = JSON.stringify({ ...value, _stored_at: Date.now() });
    try { sessionStorage.setItem(attributionKey, serialized); } catch (_) {}
    try { localStorage.setItem(attributionKey, serialized); } catch (_) {}
  }

  function captureAttribution() {
    const query = new URLSearchParams(window.location.search);
    const current = {};
    Object.entries(campaignMap).forEach(([utm, property]) => {
      const value = safeCampaignValue(query.get(utm));
      if (value) current[property] = value;
    });

    if (Object.keys(current).length) {
      const value = {
        ...current,
        campaign_landing_page: window.location.pathname
      };
      saveAttribution(value);
      return value;
    }

    return {
      ...readStoredAttribution(localStorage),
      ...readStoredAttribution(sessionStorage)
    };
  }

  const attribution = captureAttribution();
  window.techSantosAttribution = function () { return { ...attribution }; };

  window.techSantosTrack = function (eventName, params, metaEventName, metaStandard, metaOptions) {
    const eventParams = clean({ ...attribution, ...(params || {}) });
    if (typeof window.gtag === 'function') window.gtag('event', eventName, eventParams);
    if (typeof window.fbq === 'function' && metaEventName) window.fbq(metaStandard ? 'track' : 'trackCustom', metaEventName, eventParams, metaOptions || {});
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
    const courseCta = link.getAttribute('data-course-cta');
    if (courseCta) {
      window.techSantosTrack('course_cta_click', {
        cta_position: courseCta,
        link_url: link.href,
        link_text: (link.textContent || '').trim().slice(0, 100),
        page_path: path
      });
    }
    if (/^(https?:\/\/)?(wa\.me|api\.whatsapp\.com)\//i.test(href)) {
      window.techSantosTrack('contact', {
        method: 'whatsapp',
        link_url: link.href,
        link_text: (link.textContent || '').trim().slice(0, 100),
        page_path: path
      }, 'Contact', true);
    }
  });
})();
