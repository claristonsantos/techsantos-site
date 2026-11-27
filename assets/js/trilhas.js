/* Trilhas de conhecimento (protótipo estilo Duolingo).
 * Telas: início (trilhas) → caminho da trilha → etapa (explicação/vídeo/desafio)
 * → desafio → resultado. Nivelamento: uma pergunta por etapa; acertos seguidos
 * desde a primeira etapa liberam o caminho até ali. */
(function () {
  'use strict';

  const S = window.TRILHAS;
  const app = document.getElementById('trApp');
  const statsEl = document.getElementById('trStats');

  const esc = (s) => String(s).replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
  const embaralhar = (arr) => {
    const a = arr.slice();
    for (let i = a.length - 1; i > 0; i--) {
      const j = Math.floor(Math.random() * (i + 1));
      [a[i], a[j]] = [a[j], a[i]];
    }
    return a;
  };
  const trilha = (slug) => S.trilhas.find((t) => t.slug === slug);
  const estadoNo = (slug, noId) => (S.progresso[slug] || {})[noId] || null;
  const feitos = (t) => t.nos.filter((n) => estadoNo(t.slug, n.id)).length;
  // Etapas abrem em sequência: a próxima só libera quando todas as anteriores estão feitas.
  const liberado = (t, i) => t.nos.slice(0, i).every((n) => estadoNo(t.slug, n.id));
  // Parte grátis: as primeiras limite_livre etapas; o resto é do curso completo.
  const premium = (t, i) => !t.acesso_total && i >= t.limite_livre;
  const evento = (nome, dados) => { try { if (window.gtag) window.gtag('event', nome, dados); } catch (e) { /* sem analytics */ } };

  /* ---------- sons (sintetizados com Web Audio, sem arquivos) ---------- */
  const SOM_KEY = 'trilhas_som';
  let somLigado = true;
  try { somLigado = localStorage.getItem(SOM_KEY) !== '0'; } catch (e) { /* sem storage: fica ligado */ }
  let ctx = null;
  function audio() {
    if (!somLigado) return null;
    try {
      ctx = ctx || new (window.AudioContext || window.webkitAudioContext)();
      if (ctx.state === 'suspended') ctx.resume();
      return ctx;
    } catch (e) { return null; }
  }
  // Uma nota: frequência, início (s), duração (s), forma de onda e volume.
  function nota(ac, freq, ini, dur, tipo, vol, freqFim) {
    const t0 = ac.currentTime + ini;
    const osc = ac.createOscillator();
    const g = ac.createGain();
    osc.type = tipo;
    osc.frequency.setValueAtTime(freq, t0);
    if (freqFim) osc.frequency.exponentialRampToValueAtTime(freqFim, t0 + dur);
    g.gain.setValueAtTime(0.0001, t0);
    g.gain.exponentialRampToValueAtTime(vol, t0 + 0.01);
    g.gain.exponentialRampToValueAtTime(0.0001, t0 + dur);
    osc.connect(g).connect(ac.destination);
    osc.start(t0);
    osc.stop(t0 + dur + 0.02);
  }
  const som = {
    // Moedinha: duas notas agudas rápidas subindo.
    acerto() { const ac = audio(); if (!ac) return; nota(ac, 988, 0, 0.09, 'square', 0.08); nota(ac, 1319, 0.08, 0.32, 'square', 0.08); },
    // Erro: tom grave caindo, curto.
    erro() { const ac = audio(); if (!ac) return; nota(ac, 220, 0, 0.28, 'sawtooth', 0.06, 110); nota(ac, 165, 0.12, 0.3, 'triangle', 0.08, 90); },
    // Etapa concluída: arpejo de comemoração.
    vitoria() { const ac = audio(); if (!ac) return; [523, 659, 784, 1047].forEach((f, i) => nota(ac, f, i * 0.11, i === 3 ? 0.5 : 0.14, 'triangle', 0.1)); nota(ac, 1568, 0.44, 0.45, 'square', 0.04); },
    // Não passou: duas notas descendo, sem drama.
    tenteDeNovo() { const ac = audio(); if (!ac) return; nota(ac, 392, 0, 0.2, 'triangle', 0.09); nota(ac, 330, 0.18, 0.35, 'triangle', 0.09); },
  };
  function botaoSom() {
    let b = document.getElementById('trSom');
    if (!b) {
      b = document.createElement('button');
      b.id = 'trSom';
      b.type = 'button';
      b.className = 'tr-stat tr-som';
      b.addEventListener('click', () => {
        somLigado = !somLigado;
        try { localStorage.setItem(SOM_KEY, somLigado ? '1' : '0'); } catch (e) { /* ok */ }
        botaoSom();
        if (somLigado) som.acerto();
      });
      statsEl.after(b);
    }
    b.textContent = somLigado ? '🔊' : '🔇';
    b.title = somLigado ? 'Desligar sons' : 'Ligar sons';
    b.setAttribute('aria-label', b.title);
  }

  /* ---------- convite de compra (modal) ---------- */
  const modal = document.getElementById('trModal');
  function fecharModal() { modal.hidden = true; modal.innerHTML = ''; }
  modal.addEventListener('click', (e) => { if (e.target === modal || e.target.closest('[data-fechar]')) fecharModal(); });
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && !modal.hidden) fecharModal(); });

  function abrirOferta(t, motivo, aula) {
    const o = t.oferta;
    if (!o) return;
    evento('trilha_paywall', { trilha: t.slug, motivo });
    const titulo = motivo === 'aula'
      ? `Essa aula faz parte do curso de ${esc(o.curso_nome)}`
      : `Você chegou na parte do curso completo de ${esc(o.curso_nome)}`;
    const texto = motivo === 'aula'
      ? `A aula <b>${esc(aula || '')}</b> explica esse assunto passo a passo, com exemplos. Com o curso você libera esta e todas as outras aulas, a trilha inteira e o certificado.`
      : `As primeiras ${t.limite_livre} etapas de ${esc(t.nome)} são grátis. Para continuar a trilha, assistir às aulas e tirar o certificado, libere o curso completo.`;
    modal.innerHTML = `
      <div class="tr-modal-box" role="dialog" aria-modal="true" aria-labelledby="trModalT" style="--cor:${esc(t.cor)}">
        <button type="button" class="tr-modal-x" data-fechar aria-label="Fechar">✕</button>
        <div class="tr-fim-icone">${motivo === 'aula' ? '🎬' : '🔓'}</div>
        <h2 id="trModalT">${titulo}</h2>
        <p>${texto}</p>
        <a class="btn btn-primary tr-cta" id="trComprar" href="${esc(o.comprar)}">Quero o curso${o.preco ? ` por ${esc(o.preco)}` : ''}</a>
        <a class="tr-link" href="${esc(o.pagina)}" target="_blank" rel="noopener">Ver tudo o que tem no curso</a>
        <button type="button" class="tr-link tr-link-btn" data-fechar>${motivo === 'aula' ? 'Agora não, continuar na trilha' : 'Voltar para a trilha'}</button>
      </div>`;
    modal.hidden = false;
    document.getElementById('trComprar').addEventListener('click', () => evento('trilha_comprar_click', { trilha: t.slug, motivo }));
  }

  function renderStats() {
    const e = S.estatisticas;
    statsEl.innerHTML =
      `<span class="tr-stat${e.hoje ? ' on' : ''}" title="Dias seguidos estudando">🔥 <b>${e.sequencia}</b></span>` +
      `<span class="tr-stat" title="Pontos de experiência">⭐ <b>${e.xp}</b> XP</span>`;
  }

  async function salvar(dados) {
    try {
      const r = await fetch('/trilhas/api.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(dados) });
      if (!r.ok) throw new Error(r.status);
      const j = await r.json();
      S.progresso = j.progresso;
      S.estatisticas = j.estatisticas;
      renderStats();
      return j;
    } catch (e) {
      return null;
    }
  }

  /* ---------- navegação por hash: #, #sql, #sql/where, #sql/where/desafio, #sql/nivelamento ---------- */
  function rota() {
    const [slug, noId, modo] = location.hash.replace(/^#/, '').split('/');
    const t = slug && trilha(slug);
    if (!t) return telaInicio();
    if (noId === 'nivelamento') return telaQuiz(t, null);
    const i = t.nos.findIndex((n) => n.id === noId);
    if (i >= 0 && premium(t, i)) { telaTrilha(t); return abrirOferta(t, 'limite'); }
    if (i < 0 || !liberado(t, i)) return telaTrilha(t);
    if (modo === 'desafio') return telaQuiz(t, t.nos[i]);
    return telaEtapa(t, t.nos[i]);
  }
  window.addEventListener('hashchange', () => { rota(); window.scrollTo(0, 0); });

  /* ---------- início ---------- */
  function telaInicio() {
    const nome = S.usuario && S.usuario.nome ? `, ${esc(S.usuario.nome)}` : '';
    app.innerHTML = `
      <section class="tr-hero">
        <p class="tr-eyebrow">Trilhas de conhecimento</p>
        <h1>Bora aprender${nome}? Pule o que você já sabe.</h1>
        <p>Cada etapa começa com um desafio curto. Passou, segue em frente. Errou, a explicação e o vídeo daquele assunto estão ali mesmo.</p>
      </section>
      <div class="tr-cards">
        ${S.trilhas.map((t) => {
          const f = feitos(t), tot = t.nos.length;
          return `<a class="tr-card" href="#${t.slug}" style="--cor:${esc(t.cor)}">
            <span class="tr-card-sigla">${esc(t.sigla || t.nome)}</span>
            <span class="tr-card-txt"><b>${esc(t.nome)}</b><small>${esc(t.descricao)}</small></span>
            <span class="tr-card-prog"><span class="tr-bar"><span style="width:${Math.round((f / tot) * 100)}%"></span></span><small>${f}/${tot} etapas${t.acesso_total ? '' : ` · ${t.limite_livre} grátis`}</small></span>
          </a>`;
        }).join('')}
      </div>
      ${S.usuario && S.usuario.tipo === 'lead' ? '<p class="tr-nota">Metade de cada trilha é grátis. A outra metade, as aulas em vídeo e o certificado fazem parte do curso completo.</p>' : ''}`;
  }

  /* ---------- caminho da trilha ---------- */
  function telaTrilha(t) {
    const nada = feitos(t) === 0;
    app.innerHTML = `
      <a class="tr-voltar" href="#">← Trilhas</a>
      <section class="tr-trilha-head" style="--cor:${esc(t.cor)}">
        <h1>${esc(t.nome)}</h1>
        <p>${esc(t.descricao)}</p>
        <details class="tr-contexto"><summary>O cenário dos exercícios</summary><p>${esc(t.contexto)}</p></details>
        ${nada ? `<div class="tr-nivel">
          <div><b>Já sabe alguma coisa de ${esc(t.nome)}?</b><small>Faça o teste de nivelamento (${t.nivelamento.length} perguntas) e pule as etapas que você já domina.</small></div>
          <a class="btn btn-primary" href="#${t.slug}/nivelamento">Fazer nivelamento</a>
        </div>` : ''}
      </section>
      <ol class="tr-caminho" style="--cor:${esc(t.cor)}">
        ${t.nos.map((n, i) => {
          const st = estadoNo(t.slug, n.id);
          const pago = premium(t, i);
          const aberto = !pago && liberado(t, i);
          const cls = pago ? 'premium' : st ? 'feito' : aberto ? 'atual' : 'bloqueado';
          const icone = pago ? '🔒' : st ? '✓' : aberto ? '★' : '🔒';
          const tag = pago ? `no curso de ${esc(t.oferta ? t.oferta.curso_nome : t.nome)}` : st ? (st.status === 'nivelado' ? 'pulada no nivelamento' : `concluída · ${st.pct}%`) : aberto ? 'comece aqui' : 'bloqueada';
          const inner = `<span class="tr-no-circ">${icone}</span><span class="tr-no-txt"><b>${esc(n.titulo)}</b><small>${esc(n.resumo)}</small><em>${tag}</em></span>`;
          const divisa = pago && i === t.limite_livre
            ? `<li class="tr-divisa"><span>Daqui pra frente: curso completo</span><button type="button" class="btn btn-primary" data-oferta>Liberar a trilha inteira</button></li>` : '';
          const corpo = pago ? `<button type="button" class="tr-no-btn" data-oferta>${inner}</button>`
            : aberto ? `<a href="#${t.slug}/${n.id}">${inner}</a>` : `<div aria-disabled="true">${inner}</div>`;
          return `${divisa}<li class="tr-no ${cls}" style="--x:${[0, 1, 2, 1][i % 4]}">${corpo}</li>`;
        }).join('')}
      </ol>`;
    app.querySelectorAll('[data-oferta]').forEach((b) => b.addEventListener('click', () => abrirOferta(t, 'limite')));
  }

  /* ---------- etapa: explicação, vídeo e desafio ---------- */
  function blocoVideo(n) {
    const v = n.video;
    if (!v) return '<p class="tr-video-off">🎬 Vídeo desta etapa em produção. Por enquanto, a explicação acima cobre o assunto.</p>';
    if (v.liberado) {
      return `<div class="tr-video"><video controls controlslist="nodownload" disablepictureinpicture playsinline preload="metadata" src="/video.php?id=${encodeURIComponent(v.licao)}"></video></div>`;
    }
    if (v.aula_url) {
      return `<p class="tr-video-off">📘 A aula completa deste assunto está no seu curso de <b>${esc(v.curso_nome)}</b>.</p><a class="btn btn-primary" href="${esc(v.aula_url)}">Abrir a aula no curso</a>`;
    }
    return `<p class="tr-video-off">🎬 Este assunto tem uma aula completa no curso de <b>${esc(v.curso_nome)}</b>.</p><button type="button" class="btn btn-primary" data-aula>▶ Ver a aula</button>`;
  }

  function telaEtapa(t, n, aposErro) {
    const st = estadoNo(t.slug, n.id);
    const v = n.video;
    // Errou: oferece a aula daquele assunto. Aluno do curso abre o vídeo;
    // quem não é aluno recebe o convite de compra e pode seguir na trilha.
    const botaoAula = aposErro && v ? `<button type="button" class="btn btn-primary tr-cta" data-aula>▶ Ver a aula que explica isso</button>` : '';
    app.innerHTML = `
      <a class="tr-voltar" href="#${t.slug}">← ${esc(t.nome)}</a>
      <section class="tr-etapa" style="--cor:${esc(t.cor)}">
        ${aposErro ? `<div class="tr-alerta">Faltou pouco! Revise a explicação${v ? ' ou veja a aula' : ''} e tente de novo.${botaoAula}</div>` : ''}
        <h1>${esc(n.titulo)}</h1>
        <p class="tr-etapa-resumo">${esc(n.resumo)}${st ? ` · <b>${st.status === 'nivelado' ? 'você já domina' : `concluída com ${st.pct}%`}</b>` : ''}</p>
        <a class="btn btn-primary tr-cta" href="#${t.slug}/${n.id}/desafio">${st ? 'Refazer o desafio' : 'Começar o desafio'} · ${n.exercicios.length} perguntas</a>
        <details class="tr-bloco"${aposErro ? ' open' : ''}>
          <summary>📖 Explicação rápida</summary>
          ${n.teoria.map((p) => `<p>${esc(p)}</p>`).join('')}
          <pre class="tr-code">${esc(n.exemplo)}</pre>
        </details>
        <details class="tr-bloco" id="trBlocoVideo"${aposErro && v && v.liberado ? ' open' : ''}>
          <summary>🎬 Aula do assunto (opcional)</summary>
          ${blocoVideo(n)}
        </details>
      </section>`;
    app.querySelectorAll('[data-aula]').forEach((b) => b.addEventListener('click', () => {
      if (v && v.liberado) {
        const bloco = document.getElementById('trBlocoVideo');
        bloco.open = true;
        bloco.scrollIntoView({ behavior: 'smooth', block: 'start' });
        return;
      }
      if (v && v.aula_url) { location.href = v.aula_url; return; }
      abrirOferta(t, 'aula', n.titulo);
    }));
  }

  /* ---------- quiz: desafio de uma etapa (no) ou nivelamento (no = null) ---------- */
  function telaQuiz(t, no) {
    const itens = no ? embaralhar(no.exercicios) : t.nivelamento.slice();
    const acertos = [];
    let idx = 0;
    const voltar = no ? `#${t.slug}/${no.id}` : `#${t.slug}`;

    function pergunta() {
      const q = itens[idx];
      const pct = Math.round((idx / itens.length) * 100);
      app.innerHTML = `
        <div class="tr-quiz-top">
          <a class="tr-fechar" href="${voltar}" aria-label="Sair">✕</a>
          <span class="tr-bar grande" style="--cor:${esc(t.cor)}"><span style="width:${pct}%"></span></span>
          <small>${idx + 1}/${itens.length}</small>
        </div>
        <section class="tr-quiz" style="--cor:${esc(t.cor)}">
          ${!no ? '<p class="tr-eyebrow">Nivelamento</p>' : ''}
          <div id="trQ"></div>
          <div class="tr-feedback" id="trFb" hidden></div>
          <button class="btn btn-primary tr-verificar" id="trOk" disabled>Verificar</button>
        </section>`;
      const box = document.getElementById('trQ');
      const ok = document.getElementById('trOk');
      const montadores = { ordenar: montarOrdenar, lacuna: montarLacuna, vf: montarVF, pares: montarPares, digitar: montarDigitar };
      const corrigir = (montadores[q.tipo] || montarEscolha)(q, box, ok, t.rotulo_pecas || 'código');
      ok.onclick = () => {
        if (ok.dataset.fase === 'seguir') return proxima();
        const certo = corrigir();
        acertos.push(certo);
        if (certo) som.acerto(); else som.erro();
        const fb = document.getElementById('trFb');
        fb.hidden = false;
        fb.className = 'tr-feedback ' + (certo ? 'certo' : 'errado');
        const resposta = respostaCerta(q);
        fb.innerHTML = `<b>${certo ? 'Isso aí! ✓' : 'Não foi dessa vez.'}</b>${certo ? '' : `<p>Resposta certa:</p>${resposta}`}${q.explica ? `<p>${esc(q.explica)}</p>` : ''}`;
        ok.textContent = idx + 1 < itens.length ? 'Continuar' : 'Ver resultado';
        ok.dataset.fase = 'seguir';
        ok.disabled = false;
        ok.focus();
      };
    }

    function proxima() {
      idx++;
      if (idx < itens.length) return pergunta();
      return no ? fimDesafio() : fimNivelamento();
    }

    async function fimDesafio() {
      const pct = Math.round((acertos.filter(Boolean).length / itens.length) * 100);
      const passou = pct >= S.aprovacao * 100;
      app.innerHTML = '<p class="tr-salvando">Salvando…</p>';
      const r = await salvar({ acao: 'desafio', trilha: t.slug, no: no.id, pct });
      const i = t.nos.indexOf(no);
      const prox = t.nos[i + 1];
      const proxPaga = prox && premium(t, i + 1);
      // Sai do endereço do desafio sem disparar a rota, senão o botão
      // "Refazer o desafio" apontaria pro mesmo endereço e não faria nada.
      history.replaceState(null, '', `#${t.slug}/${no.id}`);
      if (!passou) { som.tenteDeNovo(); return telaEtapa(t, no, true); }
      som.vitoria();
      app.innerHTML = `
        <section class="tr-fim" style="--cor:${esc(t.cor)}">
          <div class="tr-fim-icone">🏆</div>
          <h1>Etapa concluída!</h1>
          <p>Você acertou <b>${pct}%</b>${r ? ` e ganhou <b>+${r.xp_ganho} XP</b>` : ''}.</p>
          ${r ? '' : '<p class="tr-alerta">Não consegui salvar seu progresso agora. Verifique a conexão e refaça o desafio mais tarde.</p>'}
          ${proxPaga ? `<p>Você concluiu a parte grátis de <b>${esc(t.nome)}</b>. A próxima etapa é <b>${esc(prox.titulo)}</b>.</p><button type="button" class="btn btn-primary tr-cta" data-oferta>Liberar a trilha inteira</button>`
            : prox ? `<a class="btn btn-primary tr-cta" href="#${t.slug}/${prox.id}">Próxima: ${esc(prox.titulo)}</a>` : `<p><b>Você fechou a trilha de ${esc(t.nome)}! 🎉</b></p>`}
          <a class="tr-link" href="#${t.slug}">Ver o caminho</a>
        </section>`;
      if (proxPaga) {
        app.querySelector('[data-oferta]').addEventListener('click', () => abrirOferta(t, 'limite'));
        abrirOferta(t, 'limite');
      }
    }

    async function fimNivelamento() {
      // Libera as etapas acertadas em sequência desde a primeira; a primeira
      // errada vira a etapa atual (as seguintes ficam pra depois).
      const pulados = [];
      for (let i = 0; i < itens.length && acertos[i]; i++) pulados.push(itens[i].no);
      app.innerHTML = '<p class="tr-salvando">Salvando…</p>';
      const r = pulados.length ? await salvar({ acao: 'nivelamento', trilha: t.slug, nos: pulados }) : true;
      history.replaceState(null, '', `#${t.slug}/`); // ≠ do link "Ver o caminho" (#slug), pra ele navegar
      const prox = t.nos.find((n) => !estadoNo(t.slug, n.id));
      if (pulados.length) som.vitoria();
      app.innerHTML = `
        <section class="tr-fim" style="--cor:${esc(t.cor)}">
          <div class="tr-fim-icone">${pulados.length ? '🚀' : '🌱'}</div>
          <h1>${pulados.length ? `Você pulou ${pulados.length} etapa${pulados.length > 1 ? 's' : ''}!` : 'Vamos começar do início'}</h1>
          <p>${pulados.length ? 'As etapas que você já domina ficaram marcadas. Os vídeos e explicações delas continuam disponíveis se quiser revisar.' : 'Sem problema: a trilha foi feita pra isso. Comece pela primeira etapa.'}</p>
          ${r ? '' : '<p class="tr-alerta">Não consegui salvar o nivelamento agora. Tente de novo mais tarde.</p>'}
          ${prox ? `<a class="btn btn-primary tr-cta" href="#${t.slug}/${prox.id}">Ir para: ${esc(prox.titulo)}</a>` : ''}
          <a class="tr-link" href="#${t.slug}">Ver o caminho</a>
        </section>`;
    }

    pergunta();
  }

  /* ---------- tipos de exercício: cada montador devolve a função de correção ---------- */
  function respostaCerta(q) {
    switch (q.tipo) {
      case 'ordenar': return `<pre class="tr-code">${esc(q.pecas.join('\n'))}</pre>`;
      case 'lacuna': return `<pre class="tr-code">${esc(q.codigo.replace('___', q.opcoes[q.correta]))}</pre>`;
      case 'vf': return `<p><b>${q.correta ? 'Verdadeiro' : 'Falso'}</b></p>`;
      case 'pares': return `<ul class="tr-pares-res">${q.pares.map((p) => `<li><b>${esc(p[0])}</b> → ${esc(p[1])}</li>`).join('')}</ul>`;
      case 'digitar': return `<pre class="tr-code">${esc(q.respostas[0])}</pre>`;
      default: return `<p><b>${esc(q.opcoes[q.correta])}</b></p>`;
    }
  }

  // Lacuna: o código aparece com ___ e a pessoa escolhe o que completa.
  function montarLacuna(q, box, ok) {
    const ordem = embaralhar(q.opcoes.map((_, i) => i));
    const [antes, depois] = q.codigo.split('___');
    box.innerHTML = `
      <p class="tr-eyebrow">Complete</p>
      <h2 class="tr-pergunta">${esc(q.pergunta)}</h2>
      <pre class="tr-code">${esc(antes)}<span class="tr-lacuna" id="trLac">   ?   </span>${esc(depois || '')}</pre>
      <div class="tr-chips">${ordem.map((i) => `<button type="button" class="tr-peca" data-i="${i}">${esc(q.opcoes[i])}</button>`).join('')}</div>`;
    let escolhida = null;
    const lac = box.querySelector('#trLac');
    box.querySelectorAll('[data-i]').forEach((b) => b.addEventListener('click', () => {
      if (ok.dataset.fase === 'seguir') return;
      box.querySelectorAll('[data-i]').forEach((x) => x.classList.remove('sel'));
      b.classList.add('sel');
      escolhida = Number(b.dataset.i);
      lac.textContent = q.opcoes[escolhida];
      lac.classList.add('cheia');
      ok.disabled = false;
    }));
    return () => {
      const certo = escolhida === q.correta;
      lac.classList.add(certo ? 'certa' : 'errada');
      box.querySelectorAll('[data-i]').forEach((b) => {
        if (Number(b.dataset.i) === q.correta) b.classList.add('certa');
        b.disabled = true;
      });
      return certo;
    };
  }

  // Verdadeiro ou falso.
  function montarVF(q, box, ok) {
    box.innerHTML = `
      <p class="tr-eyebrow">Verdadeiro ou falso?</p>
      <h2 class="tr-pergunta">${esc(q.afirmacao)}</h2>
      ${q.codigo ? `<pre class="tr-code">${esc(q.codigo)}</pre>` : ''}
      <div class="tr-vf">
        <button type="button" class="tr-opcao" data-v="1">👍 Verdadeiro</button>
        <button type="button" class="tr-opcao" data-v="0">👎 Falso</button>
      </div>`;
    let escolha = null;
    box.querySelectorAll('[data-v]').forEach((b) => b.addEventListener('click', () => {
      if (ok.dataset.fase === 'seguir') return;
      box.querySelectorAll('[data-v]').forEach((x) => x.setAttribute('aria-checked', 'false'));
      b.setAttribute('aria-checked', 'true');
      escolha = b.dataset.v === '1';
      ok.disabled = false;
    }));
    return () => {
      box.querySelectorAll('[data-v]').forEach((b) => {
        const v = b.dataset.v === '1';
        if (v === q.correta) b.classList.add('certa');
        else if (v === escolha) b.classList.add('errada');
        b.disabled = true;
      });
      return escolha === q.correta;
    };
  }

  // Pares: toque um item da esquerda e depois o par dele na direita.
  function montarPares(q, box, ok) {
    const esq = embaralhar(q.pares.map((p, i) => ({ i, txt: p[0] })));
    const dir = embaralhar(q.pares.map((p, i) => ({ i, txt: p[1] })));
    const ligacao = {}; // índice da esquerda -> índice da direita escolhido
    let ativo = null;
    box.innerHTML = `
      <p class="tr-eyebrow">Ligue os pares</p>
      <h2 class="tr-pergunta">${esc(q.pergunta)}</h2>
      <p class="tr-instrucao">Toque um item à esquerda e depois o par dele à direita.</p>
      <div class="tr-pares">
        <div>${esq.map((p) => `<button type="button" class="tr-peca tr-par" data-e="${p.i}">${esc(p.txt)}</button>`).join('')}</div>
        <div>${dir.map((p) => `<button type="button" class="tr-peca tr-par" data-d="${p.i}">${esc(p.txt)}</button>`).join('')}</div>
      </div>`;
    const cores = ['#5FA8E8', '#E8A33D', '#A78BFA', '#E8547A', '#33C481', '#F2C811'];
    function pintar() {
      const usadosD = {};
      Object.entries(ligacao).forEach(([e, d], k) => { usadosD[d] = e; });
      box.querySelectorAll('[data-e]').forEach((b) => {
        const e = b.dataset.e;
        b.style.borderColor = ligacao[e] !== undefined ? cores[Number(e) % cores.length] : '';
        b.classList.toggle('sel', ativo === e);
      });
      box.querySelectorAll('[data-d]').forEach((b) => {
        const e = usadosD[b.dataset.d];
        b.style.borderColor = e !== undefined ? cores[Number(e) % cores.length] : '';
      });
      ok.disabled = Object.keys(ligacao).length !== q.pares.length;
    }
    box.addEventListener('click', (ev) => {
      if (ok.dataset.fase === 'seguir') return;
      const be = ev.target.closest('[data-e]');
      const bd = ev.target.closest('[data-d]');
      if (be) { ativo = be.dataset.e; delete ligacao[ativo]; pintar(); return; }
      if (bd && ativo !== null) {
        Object.keys(ligacao).forEach((e) => { if (ligacao[e] === bd.dataset.d) delete ligacao[e]; });
        ligacao[ativo] = bd.dataset.d;
        ativo = null;
        pintar();
      }
    });
    return () => {
      let certo = true;
      box.querySelectorAll('[data-e]').forEach((b) => {
        const bom = ligacao[b.dataset.e] === b.dataset.e;
        if (!bom) certo = false;
        b.classList.add(bom ? 'certa' : 'errada');
        b.disabled = true;
      });
      box.querySelectorAll('[data-d]').forEach((b) => { b.disabled = true; });
      return certo;
    };
  }

  // Digitar: resposta curta (nome de função, palavra). Ignora maiúsculas,
  // acentos e espaços nas pontas; aceita qualquer item de q.respostas.
  function montarDigitar(q, box, ok) {
    const norm = (s) => String(s).normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/\s+/g, ' ').trim().toLowerCase();
    box.innerHTML = `
      <p class="tr-eyebrow">Digite a resposta</p>
      <h2 class="tr-pergunta">${esc(q.pergunta)}</h2>
      ${q.codigo ? `<pre class="tr-code">${esc(q.codigo)}</pre>` : ''}
      <input class="tr-digitar" id="trDig" type="text" autocomplete="off" autocapitalize="off" spellcheck="false" placeholder="${esc(q.dica || 'Sua resposta')}">`;
    const inp = box.querySelector('#trDig');
    inp.addEventListener('input', () => { ok.disabled = inp.value.trim() === ''; });
    inp.addEventListener('keydown', (e) => { if (e.key === 'Enter' && !ok.disabled) ok.click(); });
    setTimeout(() => inp.focus(), 50);
    return () => {
      const certo = q.respostas.some((r) => norm(r) === norm(inp.value));
      inp.classList.add(certo ? 'certa' : 'errada');
      inp.disabled = true;
      return certo;
    };
  }

  function montarEscolha(q, box, ok) {
    const ordem = embaralhar(q.opcoes.map((_, i) => i));
    box.innerHTML = `
      <h2 class="tr-pergunta">${esc(q.pergunta)}</h2>
      ${q.codigo ? `<pre class="tr-code">${esc(q.codigo)}</pre>` : ''}
      <div class="tr-opcoes" role="radiogroup">
        ${ordem.map((i) => `<button type="button" class="tr-opcao" role="radio" aria-checked="false" data-i="${i}">${esc(q.opcoes[i])}</button>`).join('')}
      </div>`;
    let escolhida = null;
    box.querySelectorAll('.tr-opcao').forEach((b) => b.addEventListener('click', () => {
      if (ok.dataset.fase === 'seguir') return;
      box.querySelectorAll('.tr-opcao').forEach((x) => x.setAttribute('aria-checked', 'false'));
      b.setAttribute('aria-checked', 'true');
      escolhida = Number(b.dataset.i);
      ok.disabled = false;
    }));
    return () => {
      box.querySelectorAll('.tr-opcao').forEach((b) => {
        const i = Number(b.dataset.i);
        if (i === q.correta) b.classList.add('certa');
        else if (i === escolhida) b.classList.add('errada');
        b.disabled = true;
      });
      return escolhida === q.correta;
    };
  }

  function montarOrdenar(q, box, ok, rotulo) {
    // Peças com o mesmo texto são tratadas como iguais na correção.
    const banco = embaralhar(q.pecas.concat(q.extras || []).map((txt, id) => ({ id, txt })));
    const resposta = [];
    box.innerHTML = `
      <p class="tr-eyebrow">Cenário</p>
      <h2 class="tr-pergunta">${esc(q.cenario)}</h2>
      <p class="tr-instrucao">Toque nas partes ${rotulo === 'frase' ? 'da frase' : 'do código'} na ordem certa.${q.extras && q.extras.length ? ' Atenção: tem peça sobrando.' : ''}</p>
      <div class="tr-montagem" id="trMont" aria-label="Sua resposta"></div>
      <div class="tr-banco" id="trBanco" aria-label="Peças disponíveis"></div>`;
    const mont = box.querySelector('#trMont');
    const bancoEl = box.querySelector('#trBanco');
    const travado = () => ok.dataset.fase === 'seguir';

    function desenhar() {
      mont.innerHTML = resposta.length
        ? resposta.map((p, i) => `<button type="button" class="tr-peca na-resposta" data-pos="${i}"><span class="tr-linha">${i + 1}</span><span class="tr-tx">${esc(p.txt)}</span></button>`).join('')
        : `<span class="tr-vazio">Sua ${rotulo === 'frase' ? 'frase' : 'resposta'} aparece aqui</span>`;
      bancoEl.innerHTML = banco.map((p) => {
        const usada = resposta.includes(p);
        return `<button type="button" class="tr-peca${usada ? ' usada' : ''}" data-id="${p.id}"${usada ? ' disabled aria-hidden="true"' : ''}><span class="tr-tx">${esc(p.txt)}</span></button>`;
      }).join('');
      ok.disabled = resposta.length === 0;
    }
    mont.addEventListener('click', (e) => {
      const b = e.target.closest('[data-pos]');
      if (!b || travado()) return;
      resposta.splice(Number(b.dataset.pos), 1);
      desenhar();
    });
    bancoEl.addEventListener('click', (e) => {
      const b = e.target.closest('[data-id]');
      if (!b || travado()) return;
      resposta.push(banco.find((p) => p.id === Number(b.dataset.id)));
      desenhar();
    });
    desenhar();

    return () => {
      const certo = resposta.length === q.pecas.length && resposta.every((p, i) => p.txt === q.pecas[i]);
      mont.querySelectorAll('.tr-peca').forEach((b, i) => {
        b.classList.add(resposta[i].txt === q.pecas[i] ? 'certa' : 'errada');
        b.disabled = true;
      });
      bancoEl.querySelectorAll('.tr-peca').forEach((b) => { b.disabled = true; });
      return certo;
    };
  }

  renderStats();
  botaoSom();
  rota();
})();
