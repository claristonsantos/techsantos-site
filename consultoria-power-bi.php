<?php declare(strict_types=1); $enviado = isset($_GET['enviado']); $erro = isset($_GET['erro']); ?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Consultoria Power BI para Empresas | TECH SANTOS BR</title>
<meta name="description" content="Diagnóstico, integração com ERP, modelagem de dados e dashboards em Power BI para empresas. Atendimento em todo o Brasil." />
<link rel="canonical" href="https://techsantos.com.br/consultoria-power-bi.php" />
<meta property="og:type" content="website" />
<meta property="og:locale" content="pt_BR" />
<meta property="og:url" content="https://techsantos.com.br/consultoria-power-bi.php" />
<meta property="og:title" content="Consultoria Power BI para Empresas | TECH SANTOS BR" />
<meta property="og:description" content="Organize dados de planilhas, ERP e APIs em painéis que a equipe realmente usa." />
<meta property="og:image" content="https://techsantos.com.br/assets/img/logo.jpg" />
<meta name="twitter:card" content="summary_large_image" />
<link rel="icon" type="image/png" href="/assets/img/favicon-32.png" />
<link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png" />
<link rel="stylesheet" href="/assets/css/style.css" />
<?php require_once __DIR__ . '/inc/meta-pixel.php'; ?>
<?php require_once __DIR__ . '/inc/google-analytics.php'; ?>
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"Service","name":"Consultoria Power BI para empresas","provider":{"@type":"Organization","name":"TECH SANTOS BR","url":"https://techsantos.com.br/"},"areaServed":"BR","serviceType":"Consultoria, implementação e sustentação de Business Intelligence","url":"https://techsantos.com.br/consultoria-power-bi.php"}
</script>
<style>
  .biz-hero { background:var(--navy); color:var(--navy-ink); padding:clamp(3rem,7vw,6.5rem) 0; overflow:hidden; }
  .biz-hero-grid { width:min(1180px,calc(100% - 2.5rem)); margin:auto; display:grid; grid-template-columns:minmax(0,1.05fr) minmax(380px,.95fr); gap:clamp(2.5rem,6vw,6rem); align-items:center; }
  .biz-hero h1 { color:var(--navy-ink); font-size:clamp(2.8rem,6vw,5.8rem); max-width:10ch; margin:.7rem 0 1.25rem; }
  .biz-hero h1 em { color:var(--green-bright); font-style:normal; }
  .biz-hero .lead { max-width:58ch; }
  .biz-trust { display:flex; flex-wrap:wrap; gap:.6rem 1.2rem; margin-top:1.4rem; color:var(--navy-ink-soft); font-size:.82rem; }
  .biz-trust span::before { content:'✓'; color:var(--green-bright); margin-right:.4rem; font-weight:700; }
  .data-route { position:relative; border:1px solid var(--navy-line); background:color-mix(in srgb,var(--navy-2) 82%,transparent); padding:1.25rem; border-radius:10px; box-shadow:0 28px 70px rgba(0,0,0,.24); }
  .data-route::before { content:''; position:absolute; inset:50% 18% auto; height:1px; background:linear-gradient(90deg,var(--navy-line),var(--green-bright),var(--navy-line)); }
  .route-label { font-family:'Plex Mono',monospace; font-size:.68rem; letter-spacing:.12em; text-transform:uppercase; color:var(--navy-ink-soft); margin-bottom:1rem; }
  .route-grid { position:relative; display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
  .route-node { min-height:115px; padding:1rem; border:1px solid var(--navy-line); border-radius:7px; background:var(--navy); display:flex; flex-direction:column; justify-content:space-between; }
  .route-node small { color:var(--navy-ink-soft); font-size:.72rem; }
  .route-node strong { font-size:.98rem; }
  .route-node.output { grid-column:1/-1; min-height:100px; border-color:color-mix(in srgb,var(--green-bright) 60%,var(--navy-line)); background:linear-gradient(135deg,var(--navy),color-mix(in srgb,var(--green) 22%,var(--navy))); }
  .route-node.output strong { color:var(--green-bright); font-size:1.15rem; }
  .route-pulse { position:absolute; width:8px; height:8px; border-radius:50%; background:var(--green-bright); top:calc(50% - 4px); left:18%; box-shadow:0 0 14px var(--green-bright); animation:route 3.5s ease-in-out infinite; }
  @keyframes route { 0%,100%{left:18%;opacity:.2} 50%{left:80%;opacity:1} }
  .biz-section { padding:clamp(3.5rem,7vw,6rem) 0; }
  .biz-inner { width:min(1120px,calc(100% - 2.5rem)); margin:auto; }
  .biz-section-head { display:grid; grid-template-columns:.65fr 1.35fr; gap:2rem; align-items:start; margin-bottom:2.2rem; }
  .biz-section-head h2 { font-size:clamp(2rem,4vw,3.5rem); max-width:16ch; }
  .biz-section-head p { color:var(--ink-soft); max-width:65ch; }
  .pain-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:1px; background:var(--line); border:1px solid var(--line); }
  .pain-card { background:var(--surface); padding:1.5rem; min-height:190px; }
  .pain-card .signal { font-family:'Plex Mono',monospace; color:var(--green-strong); font-size:.7rem; letter-spacing:.1em; text-transform:uppercase; }
  .pain-card h3 { margin:.8rem 0 .6rem; font-size:1.35rem; }
  .pain-card p { color:var(--ink-soft); font-size:.92rem; }
  .delivery { background:var(--surface-2); }
  .delivery-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:1rem; }
  .delivery-card { background:var(--surface); border:1px solid var(--line); border-radius:8px; padding:1.5rem; }
  .delivery-card h3 { margin-bottom:.55rem; }
  .delivery-card p { color:var(--ink-soft); }
  .case-strip { display:grid; grid-template-columns:repeat(4,1fr); border:1px solid var(--line); }
  .case-item { padding:1.35rem; border-right:1px solid var(--line); }
  .case-item:last-child { border-right:0; }
  .case-item strong { display:block; color:var(--green-strong); font-family:'Plex Mono',monospace; font-size:1.25rem; margin-bottom:.4rem; }
  .case-item span { color:var(--ink-soft); font-size:.84rem; }
  .biz-process { display:grid; grid-template-columns:repeat(4,1fr); gap:1.2rem; counter-reset:step; }
  .biz-step { counter-increment:step; border-top:3px solid var(--line); padding-top:1rem; }
  .biz-step::before { content:counter(step,decimal-leading-zero); font-family:'Plex Mono',monospace; color:var(--green-strong); font-size:.78rem; }
  .biz-step h3 { margin:.7rem 0 .5rem; }
  .biz-step p { color:var(--ink-soft); font-size:.9rem; }
  .diagnostic { background:var(--navy); color:var(--navy-ink); }
  .diagnostic-grid { display:grid; grid-template-columns:.8fr 1.2fr; gap:clamp(2rem,6vw,5rem); align-items:start; }
  .diagnostic h2 { color:var(--navy-ink); font-size:clamp(2.2rem,4.5vw,4rem); margin:.7rem 0 1rem; }
  .diagnostic .lead { color:var(--navy-ink-soft); }
  .diagnostic-list { list-style:none; padding:0; margin:1.5rem 0 0; display:grid; gap:.75rem; color:var(--navy-ink-soft); font-size:.9rem; }
  .diagnostic-list li::before { content:'→'; color:var(--green-bright); margin-right:.55rem; }
  .biz-form { background:var(--surface); color:var(--ink); padding:clamp(1.4rem,4vw,2.2rem); border-radius:10px; }
  .biz-form-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
  .biz-form .field { margin:0; }
  .biz-form .wide { grid-column:1/-1; }
  .biz-form textarea { min-height:130px; resize:vertical; }
  .biz-form input[type="text"],.biz-form input[type="email"],.biz-form input[type="tel"],.biz-form select,.biz-form textarea { width:100%; font:inherit; padding:.75rem; color:var(--ink); background:var(--surface); border:1px solid var(--line); border-radius:6px; }
  .biz-form input:focus,.biz-form select:focus,.biz-form textarea:focus { outline:3px solid color-mix(in srgb,var(--green-bright) 28%,transparent); border-color:var(--green-strong); }
  .biz-form .btn-block { width:100%; justify-content:center; }
  .biz-consent { display:flex; align-items:flex-start; gap:.6rem; font-size:.78rem; color:var(--ink-soft); margin:1rem 0; }
  .biz-consent input { margin-top:.2rem; }
  .biz-form-message { display:none; padding:.8rem 1rem; border-radius:6px; margin-bottom:1rem; font-size:.9rem; }
  .biz-form-message.show { display:block; }
  .biz-form-message.ok { background:var(--green-soft); color:var(--green-strong); }
  .biz-form-message.error { background:#FDE8E8; color:#9B1C1C; }
  .hp-field { position:absolute!important; left:-9999px!important; }
  @media(max-width:900px){.biz-hero-grid,.diagnostic-grid{grid-template-columns:1fr}.biz-hero h1{max-width:12ch}.biz-section-head{grid-template-columns:1fr}.pain-grid{grid-template-columns:1fr 1fr}.case-strip{grid-template-columns:1fr 1fr}.case-item:nth-child(2){border-right:0}.case-item:nth-child(-n+2){border-bottom:1px solid var(--line)}.biz-process{grid-template-columns:1fr 1fr}}
  @media(max-width:600px){.biz-hero-grid,.biz-inner{width:min(100% - 1.5rem,1120px)}.pain-grid,.delivery-grid,.biz-form-grid,.biz-process,.case-strip{grid-template-columns:1fr}.case-item{border-right:0;border-bottom:1px solid var(--line)}.case-item:last-child{border-bottom:0}}
  @media(prefers-reduced-motion:reduce){.route-pulse{animation:none;left:50%;opacity:1}}
</style>
</head>
<body>
<header class="site">
  <div class="nav-row">
    <a class="brand" href="/"><img src="/assets/img/logo.jpg" alt="Tech Santos BR" /><span>TECH <em>SANTOS BR</em></span></a>
    <nav class="links"><a href="/">Home</a><a href="/sobre.html">Sobre</a><a href="/servicos.html" aria-current="page">Serviços</a><a href="/projetos.html">Projetos</a><a href="/blog/">Blog</a><a href="/contato.html">Contato</a></nav>
    <div class="nav-actions"><a class="btn btn-primary desktop-only" href="#diagnostico">Solicitar diagnóstico</a><button class="nav-toggle" aria-label="Abrir menu" aria-expanded="false"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg></button></div>
  </div>
</header>
<main>
  <section class="biz-hero">
    <div class="biz-hero-grid">
      <div><p class="eyebrow on-dark">Consultoria Power BI para empresas</p><h1>Seu dado precisa chegar à <em>decisão.</em></h1><p class="lead">Conectamos planilhas, ERP, APIs e bancos de dados em uma estrutura confiável, com painéis que a equipe entende e consegue usar no dia a dia.</p><div class="hero-cta"><a class="btn btn-primary" href="#diagnostico">Solicitar diagnóstico</a><a class="btn btn-ghost" href="/projetos.html">Ver projetos reais</a></div><div class="biz-trust"><span>Atendimento em todo o Brasil</span><span>50+ projetos de BI</span><span>Microsoft Partner Network desde 2021</span></div></div>
      <div class="data-route" aria-label="Fluxo do dado até o painel"><p class="route-label">Mapa do dado</p><div class="route-grid"><div class="route-node"><small>Entradas</small><strong>ERP · planilhas · APIs</strong></div><div class="route-node"><small>Base confiável</small><strong>Integração · modelo · qualidade</strong></div><div class="route-node output"><small>Uso pela equipe</small><strong>Painel atualizado para acompanhar decisões</strong></div><span class="route-pulse" aria-hidden="true"></span></div></div>
    </div>
  </section>

  <section class="biz-section"><div class="biz-inner"><div class="biz-section-head"><div><p class="eyebrow">Quando faz sentido</p><h2>O problema raramente é falta de gráfico.</h2></div><p>O projeto começa antes do Power BI. Primeiro identificamos onde o dado nasce, por que os números divergem e quem precisa tomar decisões com ele.</p></div><div class="pain-grid"><div class="pain-card"><span class="signal">Sinal 01</span><h3>Planilhas demais</h3><p>A equipe copia, cola e consolida arquivos todo mês, sem uma fonte única de verdade.</p></div><div class="pain-card"><span class="signal">Sinal 02</span><h3>Números que não batem</h3><p>Financeiro, comercial e operação chegam à reunião com versões diferentes do mesmo indicador.</p></div><div class="pain-card"><span class="signal">Sinal 03</span><h3>ERP sem visão gerencial</h3><p>O sistema registra a operação, mas não entrega a análise necessária para acompanhar metas e desvios.</p></div></div></div></section>

  <section class="biz-section delivery"><div class="biz-inner"><div class="biz-section-head"><div><p class="eyebrow">O que entregamos</p><h2>Da fonte ao painel em produção.</h2></div><p>A solução é dimensionada para o cenário real da empresa. Nem todo projeto precisa da mesma arquitetura, quantidade de páginas ou automações.</p></div><div class="delivery-grid"><div class="delivery-card"><h3>Diagnóstico e arquitetura</h3><p>Mapeamento de processos, fontes, regras de negócio, usuários e indicadores prioritários.</p></div><div class="delivery-card"><h3>Integração e modelagem</h3><p>Conexão com ERP, APIs, arquivos ou bancos; tratamento, histórico e modelo dimensional.</p></div><div class="delivery-card"><h3>Dashboards em Power BI</h3><p>Painéis orientados ao uso, com indicadores, filtros e navegação adequados a cada área.</p></div><div class="delivery-card"><h3>Sustentação e treinamento</h3><p>Monitoramento das cargas, correções, evolução do ambiente e capacitação da equipe.</p></div></div></div></section>

  <section class="biz-section"><div class="biz-inner"><div class="biz-section-head"><div><p class="eyebrow">Experiência comprovável</p><h2>Operações diferentes, dados em uso.</h2></div><p>Os números abaixo representam indicadores acompanhados nos projetos publicados da TECH SANTOS BR, não promessa de resultado comercial.</p></div><div class="case-strip"><div class="case-item"><strong>50+</strong><span>projetos de Business Intelligence implementados</span></div><div class="case-item"><strong>9 safras</strong><span>reunidas em uma visão histórica para agroindústria</span></div><div class="case-item"><strong>201 sensores</strong><span>centralizados em monitoramento industrial</span></div><div class="case-item"><strong>2.778 vendas</strong><span>acompanhadas em painel de varejo</span></div></div><p class="section-foot"><a class="btn btn-ghost on-light" href="/projetos.html">Conhecer os projetos →</a></p></div></section>

  <section class="biz-section delivery"><div class="biz-inner"><div class="biz-section-head"><div><p class="eyebrow">Processo</p><h2>Quatro etapas, com decisão em cada uma.</h2></div><p>Um projeto de baixa complexidade costuma ser entregue em aproximadamente 30 dias. O prazo final depende das fontes, regras e disponibilidade dos dados.</p></div><div class="biz-process"><div class="biz-step"><h3>Diagnóstico</h3><p>Entendemos processo, fontes, usuários e decisões que o painel precisa apoiar.</p></div><div class="biz-step"><h3>Base de dados</h3><p>Conectamos, tratamos e modelamos os dados com regras documentadas.</p></div><div class="biz-step"><h3>Painel e validação</h3><p>Construímos e validamos indicadores com quem conhece a operação.</p></div><div class="biz-step"><h3>Entrada em produção</h3><p>Publicamos, configuramos acessos e acompanhamos a adoção pela equipe.</p></div></div></div></section>

  <section class="biz-section diagnostic" id="diagnostico"><div class="biz-inner diagnostic-grid"><div><p class="eyebrow on-dark">Diagnóstico inicial</p><h2>Conte como os dados funcionam hoje.</h2><p class="lead">Não precisa preparar uma apresentação. Informe os sistemas utilizados, o número aproximado de usuários e o problema que deseja resolver.</p><ul class="diagnostic-list"><li>Retorno com uma leitura inicial do cenário</li><li>Indicação do caminho técnico mais adequado</li><li>Próximo passo e prazo estimado para proposta</li></ul></div>
    <form class="biz-form" id="businessLeadForm" action="/capturar_lead_empresa.php" method="post">
      <div class="biz-form-message<?= $enviado ? ' show ok' : ($erro ? ' show error' : '') ?>" id="businessFormMessage" role="status"><?= $enviado ? 'Solicitação recebida. Vamos analisar o cenário e entrar em contato.' : ($erro ? 'Não foi possível enviar. Revise os campos ou fale pelo WhatsApp.' : '') ?></div>
      <div class="hp-field" aria-hidden="true"><label for="website">Site</label><input type="text" id="website" name="website" tabindex="-1" autocomplete="off" /></div>
      <input type="hidden" name="origem" value="landing-consultoria" /><input type="hidden" name="utm_source" /><input type="hidden" name="utm_medium" /><input type="hidden" name="utm_campaign" /><input type="hidden" name="utm_content" /><input type="hidden" name="utm_term" /><input type="hidden" name="landing_page" />
      <div class="biz-form-grid"><div class="field"><label for="nome">Seu nome</label><input id="nome" name="nome" type="text" autocomplete="name" required /></div><div class="field"><label for="empresa">Empresa</label><input id="empresa" name="empresa" type="text" autocomplete="organization" required /></div><div class="field"><label for="email">E-mail profissional</label><input id="email" name="email" type="email" autocomplete="email" required /></div><div class="field"><label for="telefone">WhatsApp com DDD</label><input id="telefone" name="telefone" type="tel" autocomplete="tel" placeholder="(64) 99999-8888" required /></div><div class="field"><label for="sistemas">Sistemas usados hoje</label><input id="sistemas" name="sistemas" type="text" placeholder="Ex.: ERP, Excel, SQL" /></div><div class="field"><label for="usuarios">Pessoas que usarão os painéis</label><select id="usuarios" name="usuarios"><option value="">Selecione</option><option>1 a 5</option><option>6 a 20</option><option>21 a 50</option><option>Mais de 50</option></select></div><div class="field wide"><label for="objetivo">O que você precisa acompanhar ou resolver?</label><textarea id="objetivo" name="objetivo" required placeholder="Ex.: consolidar vendas de filiais e acompanhar meta, margem e estoque diariamente."></textarea></div></div>
      <label class="biz-consent"><input type="checkbox" name="consentimento" value="1" required /><span>Autorizo a TECH SANTOS BR a usar estes dados para analisar a solicitação e entrar em contato. Consulte a <a href="/privacidade.html">Política de Privacidade</a>.</span></label>
      <button class="btn btn-primary btn-block" type="submit">Enviar cenário para análise</button>
      <p style="font-size:.76rem;color:var(--ink-faint);margin-top:.8rem;text-align:center;">Prefere conversar agora? <a href="https://wa.me/5564992905785?text=Ol%C3%A1%21%20Quero%20avaliar%20um%20projeto%20de%20Power%20BI%20para%20minha%20empresa." target="_blank" rel="noopener">Chame no WhatsApp</a>.</p>
    </form>
  </div></section>
</main>
<footer class="site footer-wide"><div class="container"><div class="footer-grid"><div class="footer-brand"><a class="brand" href="/"><img src="/assets/img/logo.jpg" alt="Tech Santos BR" /><span>TECH <em>SANTOS BR</em></span></a><p>Consultoria e treinamento em Power BI e Excel. Itumbiara-GO, atendimento para todo o Brasil.</p></div><div class="footer-col"><h4>Empresas</h4><a href="/consultoria-power-bi.php">Consultoria Power BI</a><a href="/servicos.html">Serviços</a><a href="/projetos.html">Projetos</a></div><div class="footer-col"><h4>Formação</h4><a href="/curso-power-bi.php">Curso Power BI</a><a href="/aula-gratis.php">Aulas grátis</a><a href="/login.php">Área do Aluno</a></div><div class="footer-col"><h4>Contato</h4><a href="mailto:claristonsantos@techsantos.com.br">claristonsantos@techsantos.com.br</a><a href="https://wa.me/5564992905785" target="_blank" rel="noopener">(64) 99290-5785</a></div></div><div class="footer-bottom"><span>© 2026 TECH SANTOS BR · CNPJ 41.135.509/0001-29</span></div></div></footer>
<script src="/assets/js/nav.js"></script><script src="/assets/js/analytics-events.js"></script>
<script>
(function(){
  const form=document.getElementById('businessLeadForm'); if(!form)return;
  const attribution=typeof window.techSantosAttribution==='function'?window.techSantosAttribution():{};
  const map={campaign_source:'utm_source',campaign_medium:'utm_medium',campaign_name:'utm_campaign',campaign_content:'utm_content',campaign_term:'utm_term',campaign_landing_page:'landing_page'};
  Object.entries(map).forEach(([key,name])=>{const el=form.elements[name];if(el&&attribution[key])el.value=attribution[key];});
  if(form.elements.landing_page&&!form.elements.landing_page.value)form.elements.landing_page.value=location.pathname;
  form.addEventListener('submit',async function(event){
    if(!form.reportValidity())return; event.preventDefault();
    const button=form.querySelector('button[type="submit"]'); const message=document.getElementById('businessFormMessage');
    button.disabled=true; button.textContent='Enviando cenário...'; message.className='biz-form-message';
    try{const response=await fetch(form.action,{method:'POST',body:new FormData(form),headers:{'Accept':'application/json','X-Requested-With':'XMLHttpRequest'}});const result=await response.json();if(!response.ok||!result.ok)throw new Error(result.message||'Não foi possível enviar.');message.textContent=result.message;message.className='biz-form-message show ok';form.reset();if(typeof window.techSantosTrack==='function')window.techSantosTrack('generate_lead',{lead_type:'consultoria',form_name:'diagnostico_empresarial'},'Lead',true);}
    catch(error){message.textContent=error.message||'Não foi possível enviar. Fale conosco pelo WhatsApp.';message.className='biz-form-message show error';}
    finally{button.disabled=false;button.textContent='Enviar cenário para análise';message.scrollIntoView({behavior:'smooth',block:'nearest'});}
  });
})();
</script>
</body>
</html>
