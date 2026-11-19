<?php
declare(strict_types=1);
require_once __DIR__ . '/lib.php';
header('X-Robots-Tag: noindex');
$pdo = db();
precos_ensure_schema($pdo);
$usuario = precos_usuario_atual($pdo);
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<meta name="robots" content="noindex">
<meta name="theme-color" content="#0F7B45">
<link rel="manifest" href="manifest.webmanifest">
<link rel="icon" href="icone.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="icone-192.png">
<title>Preço Certo</title>
<style>
:root{--bg:#F4F7F5;--card:#FFFFFF;--tx:#14231B;--mu:#5B6B62;--line:#DCE5DF;--ac:#0F7B45;--ac2:#E8F5EE;--bad:#B42318;--ok:#0F7B45;--onac:#FFFFFF}
@media (prefers-color-scheme:dark){:root{--bg:#0E1512;--card:#17211C;--tx:#EAF2ED;--mu:#9DB0A5;--line:#26352D;--ac:#34C17A;--ac2:#18342A;--bad:#F97066;--ok:#34C17A;--onac:#06140C}}
*{box-sizing:border-box}
body{margin:0;background:var(--bg);color:var(--tx);font:16px/1.45 system-ui,-apple-system,Segoe UI,Roboto,sans-serif;padding-bottom:84px}
header{background:#0F7B45;color:#fff;padding:16px;padding-top:max(16px,env(safe-area-inset-top))}
header h1{margin:0;font-size:20px}header p{margin:2px 0 0;opacity:.85;font-size:14px}
main{max-width:640px;margin:0 auto;padding:16px}
.card{background:var(--card);border:1px solid var(--line);border-radius:14px;padding:14px;margin-bottom:12px}
input,button{font:inherit}
input{width:100%;padding:12px;border:1px solid var(--line);border-radius:10px;background:var(--card);color:var(--tx)}
label{display:block;font-size:14px;color:var(--mu);margin:10px 0 4px}
button.pri{width:100%;margin-top:12px;padding:13px;border:0;border-radius:10px;background:var(--ac);color:var(--onac);font-weight:700}
button.sec{padding:10px 14px;border:1px solid var(--line);border-radius:10px;background:var(--card);color:var(--tx)}
nav{position:fixed;bottom:0;left:0;right:0;display:flex;background:var(--card);border-top:1px solid var(--line);padding-bottom:env(safe-area-inset-bottom)}
nav button{flex:1;border:0;background:none;color:var(--mu);padding:10px 4px;font-size:12px;display:flex;flex-direction:column;align-items:center;gap:2px}
nav button svg{width:24px;height:24px}
nav button.on{color:var(--ac);font-weight:700}
.tela{display:none}.tela.on{display:block}
.msg{padding:12px;border-radius:10px;margin-top:12px;font-size:15px}
.msg.ok{background:var(--ac2);color:var(--ok)}.msg.erro{background:rgba(180,35,24,.1);color:var(--bad)}
.prod h3{margin:0 0 8px;font-size:15px}
.linha{display:flex;justify-content:space-between;gap:10px;padding:8px 0;border-top:1px solid var(--line);font-size:14px}
.linha:first-of-type{border-top:0}
.linha .p{font-weight:800;white-space:nowrap}
.linha.min .p{color:var(--ok)}
.mu{color:var(--mu);font-size:13px}
.tag{display:inline-block;font-size:11px;padding:1px 6px;border-radius:6px;background:var(--ac2);color:var(--ok);margin-left:4px}
#leitor{width:100%;border-radius:12px;overflow:hidden}
.stats{display:grid;grid-template-columns:repeat(2,1fr);gap:8px}
.stats div{background:var(--ac2);border-radius:10px;padding:10px;text-align:center}
.stats b{display:block;font-size:22px;color:var(--ok)}
</style>
</head>
<body>
<header><h1>Preço Certo</h1><p>Compare o preço do supermercado com a sua família</p></header>
<main>
<?php if (!$usuario): ?>
  <div class="card">
    <h2 style="margin-top:0;font-size:18px">Entrar</h2>
    <p class="mu">O app está em teste fechado. Use o código de convite que você recebeu.</p>
    <label for="nome">Seu nome</label><input id="nome" maxlength="60" autocomplete="given-name">
    <label for="convite">Código de convite</label><input id="convite" autocapitalize="characters" autocomplete="off">
    <button class="pri" id="btEntrar">Entrar</button>
    <div id="msgEntrar"></div>
  </div>
<?php else: ?>
  <section class="tela on" id="t-buscar">
    <div class="card">
      <label for="q" style="margin-top:0">Qual produto você procura?</label>
      <input id="q" placeholder="ex.: arroz 5kg, leite, café" enterkeyhint="search">
      <button class="pri" id="btBuscar">Buscar preços</button>
    </div>
    <div id="resultados"></div>
  </section>

  <section class="tela" id="t-nota">
    <div class="card">
      <h2 style="margin-top:0;font-size:18px">Escanear nota fiscal</h2>
      <p class="mu">Aponte a câmera para o QR code do cupom do mercado. Todos os preços da nota entram de uma vez.</p>
      <div id="leitor"></div>
      <button class="pri" id="btCamera">Abrir câmera</button>
      <label for="url">Ou cole o link do QR code</label>
      <input id="url" inputmode="url" placeholder="https://...sefaz...">
      <button class="sec" id="btUrl" style="margin-top:8px;width:100%">Enviar link</button>
      <div id="msgNota"></div>
    </div>
  </section>

  <section class="tela" id="t-manual">
    <div class="card">
      <h2 style="margin-top:0;font-size:18px">Adicionar preço da prateleira</h2>
      <label for="mProduto">Produto</label><input id="mProduto" maxlength="200" placeholder="ex.: Arroz Camil tipo 1 5kg">
      <label for="mPreco">Preço (R$)</label><input id="mPreco" inputmode="decimal" placeholder="21,90">
      <label for="mLoja">Mercado</label><input id="mLoja" maxlength="150" list="listaLojas" placeholder="ex.: Supermercado Bom Preço - Centro">
      <datalist id="listaLojas"></datalist>
      <button class="pri" id="btManual">Salvar preço</button>
      <div id="msgManual"></div>
    </div>
  </section>

  <section class="tela" id="t-eu">
    <div class="card">
      <h2 style="margin-top:0;font-size:18px" id="ola">Olá</h2>
      <div class="stats" id="stats"></div>
    </div>
    <div class="card"><h3 style="margin-top:0;font-size:16px">Suas notas</h3><div id="minhas"></div></div>
    <div class="card mu">Instale no celular: no Chrome, toque nos três pontinhos e em "Adicionar à tela inicial". No iPhone, use Compartilhar e "Adicionar à Tela de Início".</div>
  </section>
<?php endif; ?>
</main>
<?php if ($usuario): ?>
<nav>
  <button class="on" data-t="buscar"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>Buscar</button>
  <button data-t="nota"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><path d="M14 14h3v3h-3zM20 14v7M14 20h3"/></svg>Escanear nota</button>
  <button data-t="manual"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>Adicionar</button>
  <button data-t="eu"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 21c1.5-4 4.5-6 8-6s6.5 2 8 6"/></svg>Eu</button>
</nav>
<script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<?php endif; ?>
<script>
const $ = s => document.querySelector(s);
const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
const brl = c => (c / 100).toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'});
const dataBR = d => d ? new Date(d.replace(' ', 'T')).toLocaleDateString('pt-BR') : '';
async function api(dados) {
  const r = await fetch('api.php', {method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify(dados), credentials: 'same-origin'});
  if (r.status === 401) { location.reload(); return {}; }
  return r.json().catch(() => ({ok: false, msg: 'Resposta inválida do servidor.'}));
}
function aviso(el, ok, texto) { $(el).innerHTML = `<div class="msg ${ok ? 'ok' : 'erro'}">${esc(texto)}</div>`; }

<?php if (!$usuario): ?>
$('#btEntrar').onclick = async () => {
  const r = await api({acao: 'entrar', nome: $('#nome').value, convite: $('#convite').value});
  if (r.ok) location.reload(); else aviso('#msgEntrar', false, r.erro || 'Não foi possível entrar.');
};
<?php else: ?>
document.querySelectorAll('nav button').forEach(b => b.onclick = () => {
  document.querySelectorAll('nav button').forEach(x => x.classList.toggle('on', x === b));
  document.querySelectorAll('.tela').forEach(t => t.classList.toggle('on', t.id === 't-' + b.dataset.t));
  if (b.dataset.t !== 'nota') pararCamera();
  if (b.dataset.t === 'eu') carregarResumo();
  if (b.dataset.t === 'manual') carregarLojas();
});

async function buscar() {
  const q = $('#q').value.trim();
  if (q.length < 2) return;
  $('#resultados').innerHTML = '<p class="mu">Buscando...</p>';
  const r = await api({acao: 'buscar', q});
  const prods = r.produtos || [];
  if (!prods.length) { $('#resultados').innerHTML = '<div class="card mu">Nenhum preço registrado para isso ainda. Escaneie uma nota ou adicione o preço da prateleira.</div>'; return; }
  $('#resultados').innerHTML = prods.map(p => `<div class="card prod"><h3>${esc(p.descricao)}</h3>${
    p.lojas.map((l, i) => `<div class="linha ${i === 0 && p.lojas.length > 1 ? 'min' : ''}"><div>${esc(l.loja)}${i === 0 && p.lojas.length > 1 ? '<span class="tag">mais barato</span>' : ''}<div class="mu">${dataBR(l.data)}${l.origem === 'manual' ? ' · prateleira' : ' · nota fiscal'}</div></div><div class="p">${brl(l.preco)}</div></div>`).join('')
  }</div>`).join('');
}
$('#btBuscar').onclick = buscar;
$('#q').addEventListener('keydown', e => { if (e.key === 'Enter') buscar(); });

let leitor = null, enviando = false;
async function enviarNota(url) {
  if (enviando) return;
  enviando = true;
  aviso('#msgNota', true, 'Lendo a nota na Sefaz...');
  const r = await api({acao: 'importar', url});
  aviso('#msgNota', !!r.ok, r.msg || r.erro || 'Erro.');
  enviando = false;
}
function pararCamera() { if (leitor) { leitor.stop().catch(() => {}); leitor = null; $('#btCamera').style.display = ''; } }
$('#btCamera').onclick = async () => {
  if (typeof Html5Qrcode === 'undefined') { aviso('#msgNota', false, 'Leitor de QR não carregou. Cole o link.'); return; }
  leitor = new Html5Qrcode('leitor');
  $('#btCamera').style.display = 'none';
  try {
    await leitor.start({facingMode: 'environment'}, {fps: 10, qrbox: {width: 250, height: 250}}, texto => { pararCamera(); enviarNota(texto); });
  } catch (e) { pararCamera(); aviso('#msgNota', false, 'Não consegui abrir a câmera. Permita o acesso ou cole o link.'); }
};
$('#btUrl').onclick = () => { const u = $('#url').value.trim(); if (u) enviarNota(u); };

let lojas = [];
async function carregarLojas() {
  const r = await api({acao: 'lojas'});
  lojas = r.lojas || [];
  $('#listaLojas').innerHTML = lojas.map(l => `<option value="${esc(l.nome)}">`).join('');
}
$('#btManual').onclick = async () => {
  const loja = $('#mLoja').value.trim();
  const achada = lojas.find(l => l.nome === loja);
  const r = await api({acao: 'manual', produto: $('#mProduto').value, preco: $('#mPreco').value, loja, loja_id: achada ? achada.id : 0});
  aviso('#msgManual', !!r.ok, r.msg || r.erro || 'Erro.');
  if (r.ok) { $('#mProduto').value = ''; $('#mPreco').value = ''; }
};

async function carregarResumo() {
  const r = await api({acao: 'resumo'});
  if (!r.ok) return;
  $('#ola').textContent = 'Olá, ' + r.nome;
  const t = r.totais;
  $('#stats').innerHTML = `<div><b>${t.precos}</b>preços</div><div><b>${t.notas}</b>notas</div><div><b>${t.lojas}</b>mercados</div><div><b>${t.pessoas}</b>pessoas</div>`;
  $('#minhas').innerHTML = r.minhas_notas.length ? r.minhas_notas.map(n => `<div class="linha"><div>${esc(n.loja)}<div class="mu">${dataBR(n.emitida_em)} · ${n.itens} itens</div></div><div class="p">${brl(n.total_centavos)}</div></div>`).join('') : '<p class="mu">Você ainda não escaneou nenhuma nota.</p>';
}
<?php endif; ?>
</script>
</body>
</html>
