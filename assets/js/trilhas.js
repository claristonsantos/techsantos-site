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
    if (i < 0 || !liberado(t, i)) return telaTrilha(t);
    if (modo === 'desafio') return telaQuiz(t, t.nos[i]);
    return telaEtapa(t, t.nos[i]);
  }
  window.addEventListener('hashchange', () => { rota(); window.scrollTo(0, 0); });

  /* ---------- início ---------- */
  function telaInicio() {
    app.innerHTML = `
      <section class="tr-hero">
        <p class="tr-eyebrow">Trilhas de conhecimento</p>
        <h1>Aprenda no seu ritmo, pule o que já sabe.</h1>
        <p>Cada etapa começa com um desafio curto. Passou, segue em frente. Errou, a explicação e o vídeo daquele assunto estão ali mesmo.</p>
      </section>
      <div class="tr-cards">
        ${S.trilhas.map((t) => {
          const f = feitos(t), tot = t.nos.length;
          return `<a class="tr-card" href="#${t.slug}" style="--cor:${esc(t.cor)}">
            <span class="tr-card-sigla">${esc(t.nome)}</span>
            <span class="tr-card-txt"><b>${esc(t.nome)}</b><small>${esc(t.descricao)}</small></span>
            <span class="tr-card-prog"><span class="tr-bar"><span style="width:${Math.round((f / tot) * 100)}%"></span></span><small>${f}/${tot} etapas</small></span>
          </a>`;
        }).join('')}
      </div>
      <p class="tr-nota">Protótipo: novas trilhas (Excel, Python, Linguagem M, VBA) entram aqui conforme o conteúdo fica pronto.</p>`;
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
          const aberto = liberado(t, i);
          const cls = st ? 'feito' : aberto ? 'atual' : 'bloqueado';
          const icone = st ? '✓' : aberto ? '★' : '🔒';
          const tag = st ? (st.status === 'nivelado' ? 'pulada no nivelamento' : `concluída · ${st.pct}%`) : aberto ? 'comece aqui' : 'bloqueada';
          const inner = `<span class="tr-no-circ">${icone}</span><span class="tr-no-txt"><b>${esc(n.titulo)}</b><small>${esc(n.resumo)}</small><em>${tag}</em></span>`;
          return `<li class="tr-no ${cls}" style="--x:${[0, 1, 2, 1][i % 4]}">${aberto ? `<a href="#${t.slug}/${n.id}">${inner}</a>` : `<div aria-disabled="true">${inner}</div>`}</li>`;
        }).join('')}
      </ol>`;
  }

  /* ---------- etapa: explicação, vídeo e desafio ---------- */
  function blocoVideo(n) {
    const v = n.video;
    if (!v) return '<p class="tr-video-off">🎬 Vídeo desta etapa em produção. Por enquanto, a explicação acima cobre o assunto.</p>';
    if (v.liberado) {
      return `<div class="tr-video"><video controls controlslist="nodownload" disablepictureinpicture playsinline preload="metadata" src="/video.php?id=${encodeURIComponent(v.licao)}"></video></div>`;
    }
    if (!v.publicado) return '<p class="tr-video-off">🎬 Vídeo desta etapa em produção.</p>';
    return `<p class="tr-video-off">🎬 O vídeo desta etapa é uma aula do curso de <b>${esc(v.curso_nome)}</b>. <a href="${esc(v.curso_pagina)}">Conhecer o curso</a></p>`;
  }

  function telaEtapa(t, n, aposErro) {
    const st = estadoNo(t.slug, n.id);
    app.innerHTML = `
      <a class="tr-voltar" href="#${t.slug}">← ${esc(t.nome)}</a>
      <section class="tr-etapa" style="--cor:${esc(t.cor)}">
        ${aposErro ? `<div class="tr-alerta">Faltou pouco! Revise a explicação${n.video && n.video.liberado ? ' ou o vídeo' : ''} e tente de novo.</div>` : ''}
        <h1>${esc(n.titulo)}</h1>
        <p class="tr-etapa-resumo">${esc(n.resumo)}${st ? ` · <b>${st.status === 'nivelado' ? 'você já domina' : `concluída com ${st.pct}%`}</b>` : ''}</p>
        <a class="btn btn-primary tr-cta" href="#${t.slug}/${n.id}/desafio">${st ? 'Refazer o desafio' : 'Começar o desafio'} · ${n.exercicios.length} perguntas</a>
        <details class="tr-bloco"${aposErro ? ' open' : ''}>
          <summary>📖 Explicação rápida</summary>
          ${n.teoria.map((p) => `<p>${esc(p)}</p>`).join('')}
          <pre class="tr-code">${esc(n.exemplo)}</pre>
        </details>
        <details class="tr-bloco"${aposErro && n.video && n.video.liberado ? ' open' : ''}>
          <summary>🎬 Vídeo do assunto (opcional)</summary>
          ${blocoVideo(n)}
        </details>
      </section>`;
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
      const corrigir = q.tipo === 'ordenar' ? montarOrdenar(q, box, ok) : montarEscolha(q, box, ok);
      ok.onclick = () => {
        if (ok.dataset.fase === 'seguir') return proxima();
        const certo = corrigir();
        acertos.push(certo);
        const fb = document.getElementById('trFb');
        fb.hidden = false;
        fb.className = 'tr-feedback ' + (certo ? 'certo' : 'errado');
        const resposta = q.tipo === 'ordenar' ? `<pre class="tr-code">${esc(q.pecas.join('\n'))}</pre>` : `<p><b>${esc(q.opcoes[q.correta])}</b></p>`;
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
      // Sai do endereço do desafio sem disparar a rota, senão o botão
      // "Refazer o desafio" apontaria pro mesmo endereço e não faria nada.
      history.replaceState(null, '', `#${t.slug}/${no.id}`);
      if (!passou) return telaEtapa(t, no, true);
      app.innerHTML = `
        <section class="tr-fim" style="--cor:${esc(t.cor)}">
          <div class="tr-fim-icone">🏆</div>
          <h1>Etapa concluída!</h1>
          <p>Você acertou <b>${pct}%</b>${r ? ` e ganhou <b>+${r.xp_ganho} XP</b>` : ''}.</p>
          ${r ? '' : '<p class="tr-alerta">Não consegui salvar seu progresso agora. Verifique a conexão e refaça o desafio mais tarde.</p>'}
          ${prox ? `<a class="btn btn-primary tr-cta" href="#${t.slug}/${prox.id}">Próxima: ${esc(prox.titulo)}</a>` : `<p><b>Você fechou a trilha de ${esc(t.nome)}! 🎉</b></p>`}
          <a class="tr-link" href="#${t.slug}">Ver o caminho</a>
        </section>`;
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

  function montarOrdenar(q, box, ok) {
    // Peças com o mesmo texto são tratadas como iguais na correção.
    const banco = embaralhar(q.pecas.concat(q.extras || []).map((txt, id) => ({ id, txt })));
    const resposta = [];
    box.innerHTML = `
      <p class="tr-eyebrow">Cenário</p>
      <h2 class="tr-pergunta">${esc(q.cenario)}</h2>
      <p class="tr-instrucao">Toque nas partes do código na ordem certa.${q.extras && q.extras.length ? ' Atenção: tem peça sobrando.' : ''}</p>
      <div class="tr-montagem" id="trMont" aria-label="Sua resposta"></div>
      <div class="tr-banco" id="trBanco" aria-label="Peças disponíveis"></div>`;
    const mont = box.querySelector('#trMont');
    const bancoEl = box.querySelector('#trBanco');
    const travado = () => ok.dataset.fase === 'seguir';

    function desenhar() {
      mont.innerHTML = resposta.length
        ? resposta.map((p, i) => `<button type="button" class="tr-peca na-resposta" data-pos="${i}"><span class="tr-linha">${i + 1}</span>${esc(p.txt)}</button>`).join('')
        : '<span class="tr-vazio">Sua consulta aparece aqui</span>';
      bancoEl.innerHTML = banco.map((p) => {
        const usada = resposta.includes(p);
        return `<button type="button" class="tr-peca${usada ? ' usada' : ''}" data-id="${p.id}"${usada ? ' disabled aria-hidden="true"' : ''}>${esc(p.txt)}</button>`;
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
  rota();
})();
