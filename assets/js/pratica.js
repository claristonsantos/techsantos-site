// Prática interativa das aulas (estilo Duolingo), usada pelo curso de Inglês.
// Cada aula pode ter `pratica: [exercícios]`; o motor monta uma sessão com
// barra de progresso, correção na hora e fila de revisão: o exercício errado
// volta para o fim até o aluno acertar.
//
// Tipos de exercício:
//   escolha  { q, op:[...], a, ouvir?, opPt? } múltipla escolha (ouvir = toca o áudio; opPt = opções em português, não lê a resposta)
//   lacuna   { frase:'She ___ a teacher.', op, a, pt? }
//   montar   { pt, en, alt?:[], extra?:[] }  traduzir montando com as palavras
//   pares    { pares:[[en, pt], ...] }        ligar inglês ↔ português
//   digitar  { pt?, ouvir?, en, alt?:[] }     escrever a tradução ou o que ouviu
//   falar    { en }                           repetir em voz alta (reconhecimento de voz do navegador)
// Qualquer tipo aceita `exp`: explicação mostrada quando o aluno erra.
//
// Áudio: tools/ingles_audio.py grava cada frase em inglês em
// /assets/audio/ingles/<sha1(frase)[:12]>.mp3 (voz neural nativa). Sem o arquivo,
// cai na voz do próprio navegador. Qualquer elemento [lang="en"] no texto da aula
// vira clicável para ouvir a pronúncia.
(function () {
  const AUDIO_DIR = '/assets/audio/ingles/';
  const XP_POR_ACERTO = 10;
  const esc = s => String(s ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
  const embaralhar = arr => { const a = arr.slice(); for (let i = a.length - 1; i > 0; i--) { const j = Math.floor(Math.random() * (i + 1)); [a[i], a[j]] = [a[j], a[i]]; } return a; };
  const normalizar = s => String(s || '').toLowerCase().replace(/[’‘`]/g, "'").replace(/[.,!?;:"“”()]/g, ' ').replace(/\s+/g, ' ').trim();
  const textoFalado = s => String(s || '').replace(/<[^>]+>/g, '').replace(/\s+/g, ' ').trim();

  // ---------- áudio ----------
  const cacheHash = new Map();
  async function hashFrase(texto) {
    if (cacheHash.has(texto)) return cacheHash.get(texto);
    let h = null;
    try {
      const buf = await crypto.subtle.digest('SHA-1', new TextEncoder().encode(texto));
      h = Array.from(new Uint8Array(buf)).map(b => b.toString(16).padStart(2, '0')).join('').slice(0, 12);
    } catch (e) { h = null; }
    cacheHash.set(texto, h);
    return h;
  }
  let audioAtual = null;
  async function falar(texto, lento = false) {
    texto = textoFalado(texto);
    if (!texto) return;
    if (audioAtual) { audioAtual.pause(); audioAtual = null; }
    const h = await hashFrase(texto);
    const vozNavegador = () => {
      if (!('speechSynthesis' in window)) return;
      speechSynthesis.cancel();
      const u = new SpeechSynthesisUtterance(texto);
      u.lang = 'en-US';
      u.rate = lento ? 0.6 : 0.95;
      speechSynthesis.speak(u);
    };
    if (!h) return vozNavegador();
    const a = new Audio(AUDIO_DIR + h + '.mp3');
    a.playbackRate = lento ? 0.65 : 1;
    if ('preservesPitch' in a) a.preservesPitch = true;
    audioAtual = a;
    a.play().catch(vozNavegador);
    a.addEventListener('error', vozNavegador, { once: true });
  }

  // ---------- sons de acerto/erro ----------
  let ctx = null;
  function bip(notas) {
    try {
      ctx = ctx || new (window.AudioContext || window.webkitAudioContext)();
      let t = ctx.currentTime;
      notas.forEach(([freq, dur]) => {
        const o = ctx.createOscillator(); const g = ctx.createGain();
        o.type = 'sine'; o.frequency.value = freq;
        g.gain.setValueAtTime(0.0001, t); g.gain.exponentialRampToValueAtTime(0.18, t + 0.02); g.gain.exponentialRampToValueAtTime(0.0001, t + dur);
        o.connect(g); g.connect(ctx.destination); o.start(t); o.stop(t + dur + 0.02);
        t += dur * 0.85;
      });
    } catch (e) { /* sem áudio, segue */ }
  }
  const somAcerto = () => bip([[660, 0.12], [880, 0.18]]);
  const somErro = () => bip([[300, 0.18], [220, 0.22]]);
  const somFim = () => bip([[523, 0.12], [659, 0.12], [784, 0.12], [1046, 0.3]]);

  // ---------- progresso local (XP, sequência de dias) ----------
  const CHAVE = 'ts-pratica-' + (typeof ALUNO_ID !== 'undefined' ? ALUNO_ID : 'anon');
  function lerEstado() { try { return JSON.parse(localStorage.getItem(CHAVE)) || {}; } catch (e) { return {}; } }
  function gravarEstado(s) { try { localStorage.setItem(CHAVE, JSON.stringify(s)); } catch (e) { /* modo privado */ } }
  function hoje() { const d = new Date(); return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0'); }
  function registrarSessao(aulaId, xp, precisao) {
    const s = lerEstado();
    s.xp = (s.xp || 0) + xp;
    s.aulas = s.aulas || {};
    const ant = s.aulas[aulaId] || {};
    s.aulas[aulaId] = { melhor: Math.max(ant.melhor || 0, precisao), vezes: (ant.vezes || 0) + 1 };
    const d = hoje();
    if (s.ultimoDia !== d) {
      const ontem = new Date(); ontem.setDate(ontem.getDate() - 1);
      const o = ontem.getFullYear() + '-' + String(ontem.getMonth() + 1).padStart(2, '0') + '-' + String(ontem.getDate()).padStart(2, '0');
      s.sequencia = s.ultimoDia === o ? (s.sequencia || 0) + 1 : 1;
      s.ultimoDia = d;
    }
    gravarEstado(s);
    return s;
  }

  // ---------- comparação de respostas ----------
  function distancia(a, b) {
    const m = a.length, n = b.length; if (!m) return n; if (!n) return m;
    let prev = Array.from({ length: n + 1 }, (_, j) => j);
    for (let i = 1; i <= m; i++) {
      const cur = [i];
      for (let j = 1; j <= n; j++) cur[j] = Math.min(prev[j] + 1, cur[j - 1] + 1, prev[j - 1] + (a[i - 1] === b[j - 1] ? 0 : 1));
      prev = cur;
    }
    return prev[n];
  }
  // 'ok' | 'quase' (erro de digitação) | 'errado'
  function conferirTexto(resposta, aceitas) {
    const r = normalizar(resposta);
    if (!r) return 'errado';
    let melhor = Infinity;
    for (const a of aceitas) {
      const n = normalizar(a);
      if (r === n) return 'ok';
      melhor = Math.min(melhor, distancia(r, n));
    }
    return (melhor <= 1 && r.length > 5) || (melhor <= 2 && r.length > 14) ? 'quase' : 'errado';
  }

  // ---------- render de cada tipo ----------
  const ICON_SOM = '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 5 6 9H2v6h4l5 4V5z"/><path d="M15.5 8.5a5 5 0 0 1 0 7"/><path d="M19 5a9 9 0 0 1 0 14"/></svg>';
  const btnOuvir = (texto, rotulo = 'Ouvir') => `<button type="button" class="pr-ouvir" data-falar="${esc(texto)}" aria-label="${rotulo}">${ICON_SOM}</button><button type="button" class="pr-ouvir pr-lento" data-falar="${esc(texto)}" data-lento="1" aria-label="Ouvir devagar">🐢</button>`;

  const TIPOS = {
    escolha(ex) {
      const ops = embaralhar(ex.op.map((t, i) => ({ t, i })));
      return {
        titulo: ex.ouvir ? 'O que você ouviu?' : (ex.titulo || 'Escolha a resposta certa'),
        html: `${ex.ouvir ? `<div class="pr-audio-grande">${btnOuvir(ex.ouvir)}</div>` : ''}${ex.q ? `<p class="pr-enunciado">${ex.q}</p>` : ''}
          <div class="pr-opcoes">${ops.map((o, k) => `<button type="button" class="pr-opcao" data-i="${o.i}"><span class="pr-k">${k + 1}</span>${esc(o.t)}</button>`).join('')}</div>`,
        montar(el, api) { escolhaUnica(el, api); if (ex.ouvir) setTimeout(() => falar(ex.ouvir), 250); },
        conferir(sel) { return { ok: Number(sel) === ex.a, certa: ex.op[ex.a], falar: ex.ouvir || (!ex.opPt && /[a-z]/i.test(ex.op[ex.a]) ? ex.op[ex.a] : null) }; }
      };
    },
    lacuna(ex) {
      const ops = embaralhar(ex.op.map((t, i) => ({ t, i })));
      const frase = esc(ex.frase).replace('___', '<span class="pr-lacuna">____</span>');
      return {
        titulo: 'Complete a frase',
        html: `<p class="pr-frase-en" lang="en">${frase}</p>${ex.pt ? `<p class="pr-dica">${esc(ex.pt)}</p>` : ''}
          <div class="pr-opcoes pr-opcoes-linha">${ops.map((o, k) => `<button type="button" class="pr-opcao" data-i="${o.i}"><span class="pr-k">${k + 1}</span>${esc(o.t)}</button>`).join('')}</div>`,
        montar(el, api) {
          escolhaUnica(el, api, btn => { el.querySelector('.pr-lacuna').textContent = ex.op[btn.dataset.i]; });
        },
        conferir(sel) { const certa = ex.frase.replace('___', ex.op[ex.a]); return { ok: Number(sel) === ex.a, certa, falar: certa }; }
      };
    },
    montar(ex) {
      const palavras = ex.en.replace(/[.,!?]/g, '').split(/\s+/).filter(Boolean);
      const fichas = embaralhar(palavras.concat(ex.extra || []).map((t, i) => ({ t, i })));
      return {
        titulo: 'Traduza para o inglês',
        html: `<p class="pr-enunciado pr-pt">${esc(ex.pt)}</p>
          <div class="pr-montagem-linha"><div class="pr-montagem" aria-label="Sua resposta"></div><span class="pr-pontuacao" lang="en">${esc((ex.en.match(/[.!?]$/) || [''])[0])}</span></div>
          <div class="pr-banco">${fichas.map(f => `<button type="button" class="pr-ficha" data-f="${f.i}">${esc(f.t)}</button>`).join('')}</div>`,
        montar(el, api) {
          const area = el.querySelector('.pr-montagem');
          const atualizar = () => api.pronto(area.children.length > 0);
          el.querySelectorAll('.pr-banco .pr-ficha').forEach(b => b.addEventListener('click', () => {
            if (b.classList.contains('usada') || api.travado()) return;
            b.classList.add('usada');
            const c = document.createElement('button');
            c.type = 'button'; c.className = 'pr-ficha'; c.textContent = b.textContent; c.dataset.f = b.dataset.f;
            c.addEventListener('click', () => { if (api.travado()) return; c.remove(); b.classList.remove('usada'); atualizar(); });
            area.appendChild(c);
            falar(b.textContent);
            atualizar();
          }));
          api.valor(() => Array.from(area.children).map(c => c.textContent).join(' '));
        },
        conferir(v) { const r = conferirTexto(v, [ex.en].concat(ex.alt || [])); return { ok: r === 'ok', certa: ex.en, falar: ex.en }; }
      };
    },
    pares(ex) {
      const esq = embaralhar(ex.pares.map((p, i) => ({ t: p[0], i })));
      const dir = embaralhar(ex.pares.map((p, i) => ({ t: p[1], i })));
      return {
        titulo: 'Toque nos pares',
        semBotao: true,
        html: `<div class="pr-pares"><div>${esq.map(p => `<button type="button" class="pr-par" data-lado="en" data-i="${p.i}" lang="en">${esc(p.t)}</button>`).join('')}</div>
          <div>${dir.map(p => `<button type="button" class="pr-par" data-lado="pt" data-i="${p.i}">${esc(p.t)}</button>`).join('')}</div></div>`,
        montar(el, api) {
          let sel = null; let feitos = 0; let erros = 0;
          el.querySelectorAll('.pr-par').forEach(b => b.addEventListener('click', () => {
            if (b.classList.contains('feito')) return;
            if (b.dataset.lado === 'en') falar(b.textContent);
            if (!sel || sel.dataset.lado === b.dataset.lado) {
              if (sel) sel.classList.remove('sel');
              sel = b; b.classList.add('sel'); return;
            }
            if (sel.dataset.i === b.dataset.i) {
              [sel, b].forEach(x => { x.classList.remove('sel'); x.classList.add('feito'); });
              bip([[700, 0.08]]);
              feitos++;
              if (feitos === ex.pares.length) api.concluir(erros === 0);
            } else {
              erros++;
              const a = sel;
              [a, b].forEach(x => x.classList.add('errou'));
              setTimeout(() => [a, b].forEach(x => x.classList.remove('errou', 'sel')), 450);
              somErro();
            }
            sel = null;
          }));
        },
        conferir() { return { ok: true }; }
      };
    },
    digitar(ex) {
      return {
        titulo: ex.ouvir ? 'Escreva o que você ouviu' : 'Escreva em inglês',
        html: `${ex.ouvir ? `<div class="pr-audio-grande">${btnOuvir(ex.ouvir)}</div>` : `<p class="pr-enunciado pr-pt">${esc(ex.pt)}</p>`}
          <textarea class="pr-texto" rows="2" lang="en" spellcheck="false" autocapitalize="off" autocomplete="off" placeholder="${ex.ouvir ? 'Digite em inglês…' : 'Sua tradução…'}"></textarea>`,
        montar(el, api) {
          const t = el.querySelector('.pr-texto');
          t.addEventListener('input', () => api.pronto(t.value.trim().length > 0));
          t.addEventListener('keydown', e => { if (e.key === 'Enter') { e.preventDefault(); api.enter(); } });
          api.valor(() => t.value);
          setTimeout(() => { t.focus(); if (ex.ouvir) falar(ex.ouvir); }, 250);
        },
        conferir(v) {
          const r = conferirTexto(v, [ex.en].concat(ex.alt || []));
          return { ok: r !== 'errado', quase: r === 'quase', certa: ex.en, falar: ex.en };
        }
      };
    },
    falar(ex) {
      return {
        titulo: 'Fale esta frase',
        html: `<div class="pr-falar"><div class="pr-audio-grande">${btnOuvir(ex.en)}</div><p class="pr-frase-en" lang="en">${esc(ex.en)}</p>
          <button type="button" class="pr-microfone">🎤 Toque e fale</button><p class="pr-ouvido"></p></div>`,
        montar(el, api) {
          const SR = window.SpeechRecognition || window.webkitSpeechRecognition;
          const mic = el.querySelector('.pr-microfone');
          const ouvido = el.querySelector('.pr-ouvido');
          if (!SR) { ouvido.textContent = 'Seu navegador não reconhece voz — leia a frase em voz alta e toque em Verificar.'; mic.hidden = true; api.valor(() => ex.en); api.pronto(true); return; }
          let texto = '';
          api.valor(() => texto);
          mic.addEventListener('click', () => {
            const r = new SR(); r.lang = 'en-US'; r.interimResults = false; r.maxAlternatives = 3;
            mic.classList.add('gravando'); mic.textContent = '🎙️ Ouvindo…';
            r.onresult = e => {
              const alts = Array.from(e.results[0]).map(a => a.transcript);
              texto = alts.find(a => similaridade(a, ex.en) >= 0.75) || alts[0];
              ouvido.textContent = '“' + texto + '”';
              api.pronto(true);
            };
            r.onerror = e => {
              ouvido.textContent = {
                'not-allowed': 'O navegador bloqueou o microfone. Clique no cadeado ao lado do endereço do site, permita o microfone e tente de novo.',
                'service-not-allowed': 'O navegador bloqueou o microfone. Clique no cadeado ao lado do endereço do site, permita o microfone e tente de novo.',
                'no-speech': 'Não ouvi nada. Toque no botão e fale logo em seguida, perto do microfone.',
                'audio-capture': 'Nenhum microfone encontrado neste aparelho.',
                'network': 'O reconhecimento de voz precisa de internet e funciona melhor no Chrome. Tente de novo ou toque em "Não posso falar agora".'
              }[e.error] || 'Não consegui ouvir. Confira o microfone e tente de novo.';
            };
            r.onend = () => { mic.classList.remove('gravando'); mic.textContent = '🎤 Tentar de novo'; };
            r.start();
          });
          setTimeout(() => falar(ex.en), 250);
        },
        conferir(v) { return { ok: similaridade(v, ex.en) >= 0.75, certa: ex.en, falar: ex.en }; }
      };
    }
  };

  function similaridade(a, b) {
    const x = normalizar(a).split(' '), y = normalizar(b).split(' ');
    if (!y.length) return 0;
    const pool = x.slice(); let hit = 0;
    y.forEach(w => { const k = pool.indexOf(w); if (k >= 0) { hit++; pool.splice(k, 1); } });
    return hit / Math.max(y.length, x.length);
  }

  function escolhaUnica(el, api, aoSelecionar) {
    const botoes = el.querySelectorAll('.pr-opcao');
    let valor = null;
    botoes.forEach(b => b.addEventListener('click', () => {
      if (api.travado()) return;
      botoes.forEach(x => x.classList.toggle('sel', x === b));
      valor = b.dataset.i;
      aoSelecionar?.(b);
      api.pronto(true);
    }));
    api.valor(() => valor);
    api.teclas(n => botoes[n - 1]?.click());
  }

  // ---------- sessão ----------
  function iniciar(host, aula, aoConcluirAula) {
    const exercicios = (aula.pratica || []).filter(ex => TIPOS[ex.t]);
    let fila = exercicios.map((ex, i) => ({ ex, i, tentativas: 0 }));
    const total = fila.length;
    let acertos = 0, primeiraTentativa = 0, pulados = 0, semFalar = false;
    const s = lerEstado();

    host.innerHTML = `<div class="pr-sessao" tabindex="-1">
      <div class="pr-topo"><button type="button" class="pr-sair" aria-label="Sair da prática">✕</button><div class="pr-barra"><span></span></div><span class="pr-xp">⚡ ${s.xp || 0}</span></div>
      <div class="pr-corpo"></div>
      <div class="pr-rodape"><div class="pr-msg"></div><div class="pr-acoes"><button type="button" class="pr-pular">Pular</button><button type="button" class="pr-verificar" disabled>Verificar</button></div></div>
    </div>`;
    const sessao = host.querySelector('.pr-sessao');
    const corpo = sessao.querySelector('.pr-corpo');
    const rodape = sessao.querySelector('.pr-rodape');
    const msg = sessao.querySelector('.pr-msg');
    const verificar = sessao.querySelector('.pr-verificar');
    const pular = sessao.querySelector('.pr-pular');
    const barra = sessao.querySelector('.pr-barra span');
    sessao.querySelector('.pr-sair').addEventListener('click', () => { if (confirm('Sair da prática? O progresso desta rodada se perde.')) mostrarInicio(host, aula, aoConcluirAula); });
    sessao.focus({ preventScroll: true });
    sessao.scrollIntoView({ behavior: 'smooth', block: 'start' });

    let atual = null, estado = 'responder', getValor = () => null, teclas = null;

    function proximo() {
      if (semFalar) fila = fila.filter(f => f.ex.t !== 'falar');
      if (!fila.length) return terminar();
      atual = fila.shift();
      const tipo = TIPOS[atual.ex.t](atual.ex);
      atual.tipo = tipo;
      estado = 'responder';
      rodape.className = 'pr-rodape';
      msg.innerHTML = '';
      verificar.textContent = 'Verificar';
      verificar.disabled = true;
      verificar.hidden = !!tipo.semBotao;
      pular.hidden = false;
      pular.textContent = atual.ex.t === 'falar' ? 'Não posso falar agora' : 'Pular';
      corpo.innerHTML = `<h3 class="pr-titulo">${tipo.titulo}</h3>${atual.tentativas ? '<div class="pr-revisao">↻ Revisão do erro anterior</div>' : ''}<div class="pr-ex">${tipo.html}</div>`;
      const el = corpo.querySelector('.pr-ex');
      getValor = () => null; teclas = null;
      tipo.montar(el, {
        pronto: v => { verificar.disabled = !v; },
        valor: fn => { getValor = fn; },
        travado: () => estado !== 'responder',
        enter: () => { if (!verificar.disabled) verificar.click(); },
        teclas: fn => { teclas = fn; },
        concluir: limpo => resultado({ ok: true }, limpo)
      });
      ligarOuvir(el);
    }

    function resultado(r, primeiraLimpa = true) {
      estado = 'feedback';
      atual.tentativas++;
      pular.hidden = true;
      verificar.hidden = false;
      verificar.disabled = false;
      verificar.textContent = 'Continuar';
      if (r.ok) {
        acertos++;
        if (atual.tentativas === 1 && primeiraLimpa) primeiraTentativa++;
        rodape.className = 'pr-rodape pr-certo';
        msg.innerHTML = `<strong>${r.quase ? 'Quase perfeito!' : ['Muito bem!', 'Isso aí!', 'Perfeito!', 'Mandou bem!'][Math.floor(Math.random() * 4)]}</strong>${r.quase ? `<span>Atenção à escrita: <b lang="en">${esc(r.certa)}</b></span>` : ''}`;
        somAcerto();
      } else {
        fila.push(atual);
        rodape.className = 'pr-rodape pr-errado';
        msg.innerHTML = `<strong>Resposta correta:</strong><span lang="en">${esc(r.certa)}</span>${atual.ex.exp ? `<em class="pr-exp">${atual.ex.exp}</em>` : ''}`;
        somErro();
      }
      if (r.falar) falar(r.falar);
      barra.style.width = Math.round(acertos / total * 100) + '%';
    }

    verificar.addEventListener('click', () => {
      if (estado === 'feedback') return proximo();
      resultado(atual.tipo.conferir(getValor()));
    });
    pular.addEventListener('click', () => {
      if (atual.ex.t === 'falar') { const n = 1 + fila.filter(f => f.ex.t === 'falar').length; semFalar = true; acertos += n; pulados += n; barra.style.width = Math.round(acertos / total * 100) + '%'; return proximo(); }
      resultado({ ok: false, certa: atual.tipo.conferir(null).certa || '' });
    });
    sessao.addEventListener('keydown', e => {
      if (e.target.tagName === 'TEXTAREA') return;
      if (e.key === 'Enter' && !verificar.disabled && !verificar.hidden) { e.preventDefault(); verificar.click(); }
      else if (estado === 'responder' && teclas && /^[1-9]$/.test(e.key)) teclas(Number(e.key));
    });

    function terminar() {
      const avaliados = total - pulados;
      const precisao = avaliados > 0 ? Math.round(primeiraTentativa / avaliados * 100) : 100;
      const xp = (acertos - pulados) * XP_POR_ACERTO + (precisao === 100 ? 20 : 0);
      const st = registrarSessao(aula.id, xp, precisao);
      somFim();
      window.techSantosTrack?.('pratica_concluida', { course_id: typeof COURSE_SLUG !== 'undefined' ? COURSE_SLUG : '', lesson_id: aula.id, precisao });
      sessao.innerHTML = `<div class="pr-fim">
        <div class="pr-trofeu">${precisao === 100 ? '🏆' : precisao >= 70 ? '🎉' : '💪'}</div>
        <h3>${precisao === 100 ? 'Prática perfeita!' : 'Prática concluída!'}</h3>
        <div class="pr-stats"><div><b>+${xp}</b><span>XP</span></div><div><b>${precisao}%</b><span>de primeira</span></div><div><b>🔥 ${st.sequencia || 1}</b><span>dia${(st.sequencia || 1) > 1 ? 's' : ''} seguido${(st.sequencia || 1) > 1 ? 's' : ''}</span></div></div>
        <div class="pr-fim-acoes"><button type="button" class="btn btn-ghost on-light pr-denovo">Praticar de novo</button>${aoConcluirAula ? '<button type="button" class="btn btn-primary pr-concluir">Concluir aula</button>' : ''}</div>
      </div>`;
      sessao.querySelector('.pr-denovo').addEventListener('click', () => iniciar(host, aula, aoConcluirAula));
      sessao.querySelector('.pr-concluir')?.addEventListener('click', aoConcluirAula);
    }

    proximo();
  }

  function mostrarInicio(host, aula, aoConcluirAula) {
    const s = lerEstado();
    const meu = (s.aulas || {})[aula.id];
    const n = (aula.pratica || []).length;
    host.innerHTML = `<div class="pr-inicio">
      <div class="pr-inicio-icone">🧩</div>
      <div class="pr-inicio-txt"><strong>Pratique esta aula</strong><span>${n} exercícios: ouvir, montar frases, ligar pares, escrever e falar. Errou? A questão volta no fim até você acertar.</span>
      ${meu ? `<span class="pr-melhor">Seu melhor: ${meu.melhor}% de primeira · ${meu.vezes} rodada${meu.vezes > 1 ? 's' : ''}</span>` : ''}</div>
      <button type="button" class="btn btn-primary pr-comecar">${meu ? 'Praticar de novo' : 'Começar prática'}</button>
    </div>`;
    host.querySelector('.pr-comecar').addEventListener('click', () => iniciar(host, aula, aoConcluirAula));
  }

  // Palavras e frases em inglês no texto da aula ficam clicáveis para ouvir.
  function ligarOuvir(raiz) {
    raiz.querySelectorAll('[data-falar]').forEach(b => {
      if (b.dataset.ligado) return; b.dataset.ligado = '1';
      b.addEventListener('click', e => { e.preventDefault(); e.stopPropagation(); falar(b.dataset.falar, b.dataset.lento === '1'); });
    });
  }
  function ligarTexto(raiz) {
    raiz.querySelectorAll('.lesson-body [lang="en"], .reading-card [lang="en"], .objectives [lang="en"]').forEach(el => {
      if (el.dataset.ligado) return; el.dataset.ligado = '1';
      el.classList.add('pr-en');
      el.title = 'Clique para ouvir';
      el.addEventListener('click', () => falar(el.textContent));
    });
  }

  window.Pratica = {
    montar(host, aula, aoConcluirAula) { if (host && aula?.pratica?.length) mostrarInicio(host, aula, aoConcluirAula); },
    ligarTexto,
    falar,
    estado: lerEstado
  };
})();
