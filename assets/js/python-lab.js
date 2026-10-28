// Laboratório de Python do curso de Python (Pyodide num worker: assets/js/py-worker.js).
//  - Blocos de código da aula (pre.lesson-code) ganham o botão "▶ Executar".
//  - Desafios de cenário (aula.desafios): o aluno escreve o script, executa e
//    o site confere com testes escondidos. Dicas em camadas e solução só depois de tentar.
// Desafio: { titulo, cenario (html), arquivos: {nome: texto ou 'base64:...' para binários},inicial, testes: [{py, msg}], dicas: [..], solucao }
(function () {
  const TEMPO_LIMITE = 20000;
  const esc = s => String(s ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
  let worker = null, seq = 0, aquecido = false;
  const pendentes = new Map();

  function novoWorker() {
    worker = new Worker('/assets/js/py-worker.js?v=1');
    worker.onmessage = ev => { aquecido = true; const p = pendentes.get(ev.data.id); if (p) { clearTimeout(p.t); pendentes.delete(ev.data.id); p.ok(ev.data); } };
  }

  function executar(codigo, arquivos = {}, testes = []) {
    if (!worker) novoWorker();
    const id = ++seq;
    return new Promise(ok => {
      const t = setTimeout(() => {
        // código preso (loop infinito?): encerra o worker e começa outro limpo
        worker.terminate(); worker = null; aquecido = false; pendentes.delete(id);
        ok({ ok: false, saida: '', erro: 'Tempo esgotado: o código rodou por mais de 20 segundos. Verifique se há um laço que nunca termina.', imagens: [], testes: [] });
      }, TEMPO_LIMITE + (aquecido ? 0 : 60000)); // a primeira execução também carrega o Python e as bibliotecas
      pendentes.set(id, { ok, t });
      worker.postMessage({ id, codigo, arquivos, testes });
    });
  }

  function saidaHtml(r) {
    let h = '';
    if (r.saida) h += `<pre class="lab-saida">${esc(r.saida)}</pre>`;
    if (r.erro) h += `<pre class="lab-saida lab-erro">${esc(r.erro)}</pre>`;
    (r.imagens || []).forEach(b => { h += `<img class="lab-img" src="data:image/png;base64,${b}" alt="Gráfico gerado pelo código">`; });
    // arquivos que o código gerou (Excel, CSV...): o aluno baixa e abre no próprio computador
    (r.arquivos || []).forEach(([nome, b64]) => { h += `<a class="lab-arquivo" download="${esc(nome)}" href="data:application/octet-stream;base64,${b64}">⬇ Baixar ${esc(nome)}</a>`; });
    if (!h) h = '<pre class="lab-saida lab-vazia">(o código rodou sem imprimir nada)</pre>';
    return h;
  }

  // Editor simples: textarea com Tab = 4 espaços e Enter mantendo a indentação.
  function editor(ta) {
    ta.addEventListener('keydown', e => {
      const { selectionStart: a, selectionEnd: b, value: v } = ta;
      if (e.key === 'Tab') {
        e.preventDefault();
        ta.value = v.slice(0, a) + '    ' + v.slice(b); ta.selectionStart = ta.selectionEnd = a + 4;
      } else if (e.key === 'Enter') {
        e.preventDefault();
        const linha = v.slice(v.lastIndexOf('\n', a - 1) + 1, a);
        let ind = (linha.match(/^\s*/) || [''])[0];
        if (/:\s*$/.test(linha)) ind += '    ';
        ta.value = v.slice(0, a) + '\n' + ind + v.slice(b); ta.selectionStart = ta.selectionEnd = a + 1 + ind.length;
      }
      ta.style.height = 'auto'; ta.style.height = Math.max(160, ta.scrollHeight + 4) + 'px';
    });
  }

  // arquivos: os mesmos arquivos de exemplo dos desafios da aula, para os blocos poderem lê-los
  function blocosExecutaveis(raiz, arquivos) {
    raiz.querySelectorAll('pre.lesson-code').forEach(pre => {
      if (pre.dataset.lab) return; pre.dataset.lab = '1';
      const box = document.createElement('div'); box.className = 'lab-bloco';
      const btn = document.createElement('button'); btn.type = 'button'; btn.className = 'lab-run-mini'; btn.textContent = '▶ Executar';
      const out = document.createElement('div');
      pre.after(box); box.append(btn, out);
      btn.addEventListener('click', async () => {
        btn.disabled = true; btn.textContent = aquecido ? 'Executando…' : 'Carregando o Python…';
        const r = await executar(pre.textContent, arquivos);
        out.innerHTML = saidaHtml(r); btn.disabled = false; btn.textContent = '▶ Executar de novo';
      });
    });
  }

  function desafio(host, d, idx, aulaId) {
    const chave = `ts-pylab-${aulaId}-${idx}`;
    let salvo = null; try { salvo = localStorage.getItem(chave); } catch (e) { /* sem storage */ }
    let tentativas = 0, dicasMostradas = 0;
    const el = document.createElement('div'); el.className = 'lab-desafio';
    el.innerHTML = `<div class="lab-topo"><span class="lab-tag">💻 Desafio ${idx + 1}</span><strong>${esc(d.titulo)}</strong></div>
      <div class="lab-cenario">${d.cenario}</div>
      ${Object.keys(d.arquivos || {}).length ? `<div class="lab-arquivos">${Object.entries(d.arquivos).map(([n, t]) => t.startsWith('base64:')
        // arquivo binário (planilha Excel): sem prévia em texto, o aluno baixa e abre no Excel
        ? `<details><summary>📊 ${esc(n)} (arquivo disponível no seu código)</summary><a class="lab-arquivo" download="${esc(n)}" href="data:application/octet-stream;base64,${t.slice(7)}">⬇ Baixar ${esc(n)} para ver no Excel</a></details>`
        : `<details><summary>📄 ${esc(n)} (arquivo disponível no seu código)</summary><pre>${esc(t.split('\n').slice(0, 12).join('\n'))}${t.split('\n').length > 12 ? '\n…' : ''}</pre></details>`).join('')}</div>` : ''}
      <textarea class="lab-editor" spellcheck="false" autocapitalize="off" autocomplete="off">${esc(salvo ?? d.inicial ?? '')}</textarea>
      <div class="lab-acoes"><button type="button" class="lab-run">▶ Executar</button><button type="button" class="lab-check">✓ Verificar</button><button type="button" class="lab-dica">💡 Dica</button><button type="button" class="lab-reset">↺ Recomeçar</button></div>
      <div class="lab-saida-box"></div><div class="lab-resultado"></div><div class="lab-dicas"></div>`;
    host.appendChild(el);
    const ta = el.querySelector('.lab-editor'); editor(ta); ta.style.height = Math.max(160, ta.scrollHeight + 4) + 'px';
    const out = el.querySelector('.lab-saida-box'), res = el.querySelector('.lab-resultado'), dicas = el.querySelector('.lab-dicas');
    const run = el.querySelector('.lab-run'), check = el.querySelector('.lab-check');
    ta.addEventListener('input', () => { try { localStorage.setItem(chave, ta.value); } catch (e) { /* ok */ } });
    const rodar = async (comTestes) => {
      [run, check].forEach(b => b.disabled = true);
      const b = comTestes ? check : run; const txt = b.textContent;
      b.textContent = aquecido ? 'Executando…' : 'Carregando o Python…';
      const r = await executar(ta.value, d.arquivos || {}, comTestes ? d.testes : []);
      out.innerHTML = saidaHtml(r);
      if (comTestes) {
        tentativas++;
        if (r.erro) res.innerHTML = `<div class="lab-falhou">❌ O código parou com um erro. Leia a mensagem acima: ela diz o tipo do erro e a linha.</div>`;
        else res.innerHTML = `<ul class="lab-testes">${r.testes.map(t => `<li class="${t.ok ? 'ok' : 'nok'}">${t.ok ? '✅' : '❌'} ${esc(t.msg)}</li>`).join('')}</ul>` +
          (r.ok ? `<div class="lab-passou">🎉 Desafio resolvido!</div>` : '');
        if (r.ok) { el.classList.add('resolvido'); window.techSantosTrack?.('desafio_resolvido', { course_id: 'python', lesson_id: aulaId, desafio: idx + 1, tentativas }); }
        if (!r.ok && tentativas >= 3 && d.solucao && !el.querySelector('.lab-ver-solucao')) {
          const s = document.createElement('button'); s.type = 'button'; s.className = 'lab-ver-solucao'; s.textContent = '👀 Ver uma solução comentada';
          s.addEventListener('click', () => { dicas.insertAdjacentHTML('beforeend', `<div class="lab-solucao"><strong>Uma solução possível</strong><pre>${esc(d.solucao)}</pre></div>`); s.remove(); });
          res.appendChild(s);
        }
      }
      b.textContent = txt; [run, check].forEach(x => x.disabled = false);
    };
    run.addEventListener('click', () => rodar(false));
    check.addEventListener('click', () => rodar(true));
    el.querySelector('.lab-dica').addEventListener('click', e => {
      const lista = d.dicas || [];
      if (dicasMostradas < lista.length) { dicas.insertAdjacentHTML('beforeend', `<div class="lab-dica-txt">💡 ${lista[dicasMostradas]}</div>`); dicasMostradas++; }
      if (dicasMostradas >= lista.length) { e.target.disabled = true; e.target.textContent = 'Sem mais dicas'; }
    });
    el.querySelector('.lab-reset').addEventListener('click', () => { if (confirm('Voltar ao código inicial? O que você escreveu será apagado.')) { ta.value = d.inicial || ''; try { localStorage.removeItem(chave); } catch (e) { /* ok */ } } });
  }

  window.PyLab = {
    executar,
    montar(raiz, aula) {
      blocosExecutaveis(raiz, Object.assign({}, ...((aula && aula.desafios) || []).map(d => d.arquivos || {})));
      const host = raiz.querySelector('#desafiosHost');
      if (host && aula.desafios) aula.desafios.forEach((d, i) => desafio(host, d, i, aula.id));
    }
  };
})();
