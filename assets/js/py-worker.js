// Worker do laboratório de Python (curso de Python): roda o código do aluno com Pyodide
// fora da thread da página, para que um loop infinito possa ser interrompido
// (a página encerra o worker por tempo limite). Mensagens:
//   entrada: { id, codigo, arquivos: {nome: texto}, testes: [{py, msg}] }
//   saída:   { id, ok, saida, erro, imagens: [png base64], arquivos: [[nome, base64]], testes: [{ok, msg}] }
const PYODIDE = 'https://cdn.jsdelivr.net/pyodide/v0.26.4/full/';
importScripts(PYODIDE + 'pyodide.js');

let pronto = null;
async function iniciar() {
  const py = await loadPyodide({ indexURL: PYODIDE });
  return py;
}

// Bibliotecas da distribuição do Pyodide (loadPackage) e as que vêm do PyPI (micropip).
const PACOTES = { pandas: 'pandas', numpy: 'numpy', matplotlib: 'matplotlib' };
const PYPI = { openpyxl: 'openpyxl' };
const instalados = new Set();

self.onmessage = async (ev) => {
  const { id, codigo, arquivos = {}, testes = [] } = ev.data;
  try {
    if (!pronto) pronto = iniciar();
    const py = await pronto;
    // carrega só as bibliotecas que o código usa
    const precisa = Object.keys(PACOTES).filter(p => new RegExp('\\b(import|from)\\s+' + p).test(codigo + '\n' + testes.map(t => t.py).join('\n')));
    if (precisa.length) await py.loadPackage(precisa.map(p => PACOTES[p]));
    // tabelas inteiras na saída (o padrão de 80 colunas esconde colunas com "...")
    if (precisa.includes('pandas')) py.runPython("import pandas\npandas.set_option('display.width', 200)\npandas.set_option('display.max_columns', 30)");
    const doPypi = Object.keys(PYPI).filter(p => !instalados.has(p) && new RegExp('\\b(import|from)\\s+' + p).test(codigo + '\n' + testes.map(t => t.py).join('\n')));
    if (doPypi.length) {
      await py.loadPackage('micropip');
      const micropip = py.pyimport('micropip');
      for (const p of doPypi) { await micropip.install(PYPI[p]); instalados.add(p); }
    }
    // cada execução começa com a pasta limpa: um arquivo gravado numa tentativa anterior
    // não pode fazer a próxima passar nos testes
    for (const nome of py.FS.readdir('.')) {
      if (py.FS.isFile(py.FS.stat(nome).mode)) py.FS.unlink(nome);
    }
    for (const [nome, texto] of Object.entries(arquivos)) py.FS.writeFile(nome, texto);
    let saida = '';
    py.setStdout({ batched: s => { saida += s + '\n'; } });
    py.setStderr({ batched: s => { saida += s + '\n'; } });
    py.globals.set('__codigo_aluno', codigo);
    py.globals.set('__testes', py.toPy(testes.map(t => t.py)));
    const res = await py.runPythonAsync(`
import sys, traceback, io, base64, warnings
warnings.filterwarnings('ignore', category=DeprecationWarning)
warnings.filterwarnings('ignore', category=FutureWarning)
warnings.filterwarnings('ignore', message='.*non-GUI backend.*')
__ns = {'__name__': '__main__'}
__erro = None
__imgs = []
try:
    import matplotlib
    matplotlib.use('AGG')
except Exception:
    pass
import contextlib, os
# arquivos que já existiam (para devolver ao aluno só o que o código dele gerou)
__antes = {f: os.path.getmtime(f) for f in os.listdir('.') if os.path.isfile(f)}
__buf = io.StringIO()
try:
    with contextlib.redirect_stdout(__buf):
        exec(compile(__codigo_aluno, 'seu_codigo.py', 'exec'), __ns)
except SyntaxError as e:
    __erro = f"SyntaxError: {e.msg} (linha {e.lineno})"
except Exception as e:
    tb = traceback.extract_tb(e.__traceback__)
    linha = next((f.lineno for f in reversed(tb) if f.filename == 'seu_codigo.py'), None)
    __erro = f"{type(e).__name__}: {e}" + (f" (linha {linha})" if linha else "")
print(__buf.getvalue(), end='')
# os testes enxergam o que o aluno imprimiu na variável saida (e as linhas em linhas)
__ns['saida'] = __buf.getvalue()
__ns['__codigo_aluno'] = __codigo_aluno  # testes podem rodar o código de novo com outros valores
__ns['linhas'] = [l for l in __buf.getvalue().strip().splitlines()]
try:
    import matplotlib.pyplot as plt
    for n in plt.get_fignums():
        b = io.BytesIO(); plt.figure(n).savefig(b, format='png', dpi=90, bbox_inches='tight'); __imgs.append(base64.b64encode(b.getvalue()).decode())
except Exception:
    pass
# os testes rodam antes de fechar as figuras, para poderem conferir os gráficos
__res_testes = []
if __erro is None:
    for t in __testes:
        try:
            exec(t, __ns)
            __res_testes.append(True)
        except Exception:
            __res_testes.append(False)
try:
    import matplotlib.pyplot as plt
    plt.close('all')
except Exception:
    pass
__gerados = []
for f in sorted(os.listdir('.')):
    if os.path.isfile(f) and f.lower().endswith(('.xlsx', '.csv', '.json', '.txt', '.png')) and (f not in __antes or os.path.getmtime(f) != __antes[f]):
        with open(f, 'rb') as fh:
            __gerados.append([f, base64.b64encode(fh.read()).decode()])
[__erro, __imgs, __res_testes, __gerados]
`);
    const [erro, imagens, rt, gerados] = res.toJs();
    res.destroy();
    self.postMessage({ id, ok: !erro && rt.every(Boolean), saida: saida.replace(/\n$/, ''), erro, imagens, arquivos: gerados, testes: testes.map((t, i) => ({ ok: !!rt[i], msg: t.msg })) });
  } catch (e) {
    self.postMessage({ id, ok: false, saida: '', erro: String(e && e.message || e), imagens: [], testes: [] });
  }
};
