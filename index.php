<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Aula Interativa: Capitalismo, Finanças e Empreendedorismo (1994–2025)</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/theme.css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
</head>
<body class="text-slate-100">
  <div class="max-w-[1440px] mx-auto px-4 py-6 xl:px-8 space-y-6">
    <header id="appHeader" class="glass-panel px-4 py-4 lg:px-6 lg:py-4 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
      <div class="header-brand flex items-center gap-3 w-full lg:w-auto">
        <div class="header-brand__badge">AF</div>
        <div class="min-w-0">
          <h1 class="header-title text-lg sm:text-xl font-extrabold text-slate-100">Capitalismo, Finanças e Empreendedorismo</h1>
          <p class="header-subtitle text-xs sm:text-sm text-slate-400">Linha do tempo interativa (Plano Real → hoje) + slides • 1h</p>
        </div>
      </div>
      <div class="header-actions flex flex-col gap-2 w-full lg:w-auto">
        <div class="flex justify-end lg:hidden">
          <button id="toggleHeaderMenu" class="btn btn-header" aria-expanded="false" aria-controls="headerControls">
            <span class="btn-header__icon" aria-hidden="true">☰</span>
            <span class="btn-header__label">Menu rápido</span>
          </button>
        </div>
        <nav id="headerControls" class="header-controls hidden lg:flex" aria-label="Controles principais">
          <div class="header-controls__surface">
            <div class="header-controls__section" role="group" aria-label="Controle de reprodução">
              <span class="header-section-title">Linha do tempo</span>
              <div class="header-controls__group header-controls__group--fluid">
                <button id="btnPlay" class="btn btn-header">
                  <span class="btn-header__icon" aria-hidden="true">▶️</span>
                  <span class="btn-header__label">Reproduzir</span>
                </button>
                <button id="btnPause" class="btn btn-header">
                  <span class="btn-header__icon" aria-hidden="true">⏸️</span>
                  <span class="btn-header__label">Pausar</span>
                </button>
                <button id="btnReset" class="btn btn-header">
                  <span class="btn-header__icon" aria-hidden="true">⟲</span>
                  <span class="btn-header__label">Reiniciar</span>
                </button>
              </div>
            </div>
            <div class="header-controls__section" role="group" aria-label="Velocidade da linha do tempo">
              <span class="header-section-title">Ritmo</span>
              <div class="header-controls__group">
                <label class="header-speed-label" for="speed">Velocidade</label>
                <select id="speed" class="header-speed-select">
                  <option value="1000">1 ano/seg</option>
                  <option value="2000">1 ano/2s</option>
                  <option value="500">2 anos/seg</option>
                  <option value="10000">~1h (demo lenta)</option>
                </select>
              </div>
            </div>
            <div class="header-controls__section" role="group" aria-label="Ações adicionais">
              <span class="header-section-title">Ferramentas</span>
              <div class="header-controls__group header-controls__group--stack">
                <a href="quizz.php" class="btn btn-header">
                  <span class="btn-header__icon" aria-hidden="true">🎯</span>
                  <span class="btn-header__label">Quiz</span>
                </a>
                <a href="empreendedorismo.php" class="btn btn-header">
                  <span class="btn-header__icon" aria-hidden="true">🚀</span>
                  <span class="btn-header__label">Aula de empreendedorismo</span>
                </a>
                <button id="btnHideHeader" class="btn btn-header" title="Ocultar cabeçalho">
                  <span class="btn-header__icon" aria-hidden="true">⬆</span>
                  <span class="btn-header__label">Ocultar</span>
                </button>
              </div>
            </div>
          </div>
        </nav>
      </div>
    </header>

    <div id="headerReturn" class="hidden fixed top-4 right-4 z-40">
      <button id="btnShowHeader" class="btn-icon" aria-label="Mostrar cabeçalho">
        ⬇
        <span>Mostrar cabeçalho</span>
      </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 xl:[grid-template-columns:minmax(0,1.2fr)_minmax(0,0.8fr)] gap-5 xl:gap-7">
      <section class="glass-panel p-4 lg:p-6 space-y-5">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
          <div class="space-y-2">
            <div class="text-xs uppercase tracking-wide text-slate-400">Ano</div>
            <div class="text-4xl font-black tracking-tight text-slate-100"><span id="anoAtual">1994</span></div>
            <div class="mt-2 flex flex-wrap items-center gap-2 text-xs">
              <button id="anoMenos5" class="btn" title="-5 anos">«5</button>
              <button id="anoMenos" class="btn" title="-1 ano">−1</button>
              <button id="anoMais" class="btn" title="+1 ano">+1</button>
              <button id="anoMais5" class="btn" title="+5 anos">5»</button>
            </div>
          </div>
          <div class="text-right space-y-2">
            <div class="text-xs uppercase tracking-wide text-slate-400">Modo</div>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-2 text-xs text-slate-300">
              <span class="tag" id="modoTag">Dados reais + investimentos simulados</span>
              <label class="inline-flex items-center gap-2">
                <input id="chkLog" type="checkbox" class="rounded accent-emerald-500" />
                escala log
              </label>
            </div>
          </div>
        </div>
        <div class="mt-1 w-full bg-slate-800 h-2 rounded-full overflow-hidden">
          <div id="barra" class="h-2 bg-emerald-500 transition-all" style="width: 0%"></div>
        </div>
        <div class="mt-2">
          <input id="sliderAno" type="range" min="0" max="0" value="0" class="w-full accent-emerald-500" />
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
          <div class="metric-card p-3 space-y-1">
            <div class="kpi">💼 Salário mínimo</div>
            <div class="text-lg font-bold leading-tight text-slate-100"><span id="kpiSalario">—</span></div>
            <div class="text-xs text-slate-400">poder de compra vs. cesta: <span id="kpiPoderCompra">—</span></div>
          </div>
          <div class="metric-card p-3 space-y-1">
            <div class="kpi">📈 Inflação (acum. desde 1994)</div>
            <div class="text-lg font-bold leading-tight text-slate-100"><span id="kpiInflacao">—</span></div>
            <div class="text-xs text-slate-400">IPCA oficial (IBGE)</div>
          </div>
          <div class="metric-card p-3 space-y-1">
            <div class="kpi">🧺 Cesta básica – SP</div>
            <div class="text-lg font-bold leading-tight text-slate-100"><span id="kpiCesta">—</span></div>
            <div class="text-xs text-slate-400">🚗 carro: <span id="kpiCarro">—</span> · 🍔 Big Mac: <span id="kpiBigmac">—</span></div>
          </div>
          <div class="metric-card p-3 space-y-1">
            <div class="kpi">🏦 Invest. R$1.000 — Poupança</div>
            <div class="text-lg font-bold leading-tight text-slate-100"><span id="kpiPoupanca">—</span></div>
          </div>
          <div class="metric-card p-3 space-y-1">
            <div class="kpi">💳 Invest. R$1.000 — CDB (100% CDI)</div>
            <div class="text-lg font-bold leading-tight text-slate-100"><span id="kpiCDB">—</span></div>
          </div>
          <div class="metric-card p-3 space-y-1">
            <div class="kpi">📊 Invest. R$1.000 — Bolsa</div>
            <div class="text-lg font-bold leading-tight text-slate-100"><span id="kpiBolsa">—</span></div>
          </div>
        </div>

        <div class="chart-card mt-2 h-[360px]">
          <canvas id="chart"></canvas>
        </div>

        <div class="mt-4 text-xs text-slate-400 space-y-1">
          <p><strong>Fontes:</strong> IPCA anual (IBGE/Ipeadata); Salário mínimo (decretos/IPEA); Big Mac (The Economist Big Mac Index — BRL, pontos e interpolação); Cesta básica SP (PROCON/DIEESE — âncoras e interpolação); Carro (VW Gol 1.0 0 km – âncoras e interpolação). Investimentos: CDB calculado como 100% CDI anual composto; Poupança média; Bolsa simulada.</p>
        </div>
      </section>

      <section class="glass-panel flex flex-col overflow-hidden">
        <div class="p-4 border-b border-slate-800/80 flex items-center justify-between">
          <div class="flex items-center gap-2">
            <button id="prevSlide" class="btn">←</button>
            <button id="nextSlide" class="btn">→</button>
          </div>
          <div class="text-sm text-slate-300">Slide <span id="slidePos">1</span>/<span id="slideTotal">—</span></div>
        </div>
        <div id="slides" class="slides p-5 lg:p-6 h-[620px] overflow-y-auto space-y-4"></div>
      </section>
    </div>

    <dialog id="dlgDados" class="dialog-panel rounded-3xl border border-slate-800/80 w-[94vw] max-w-4xl backdrop-blur">
      <form method="dialog" class="p-0">
        <div class="p-4 border-b border-slate-800/70 flex items-center justify-between">
          <h3 class="text-lg font-bold text-slate-100">Ajustar dados / Importar séries reais</h3>
          <button class="btn">✖</button>
        </div>
        <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
          <div class="space-y-3">
            <h4 class="font-semibold text-slate-100">Importar/Exportar JSON</h4>
            <p class="text-slate-400">Cole JSON com as séries anuais completas (chaves: <code>anos</code>, <code>salario</code>, <code>ipca</code>, <code>cesta</code>, <code>carro</code>, <code>bigmac</code>, <code>poupanca</code>, <code>cdb</code>, <code>bolsa</code>).</p>
            <textarea id="areaJson" class="w-full h-80 border border-slate-800 rounded-lg p-3 font-mono text-xs bg-slate-950/80 text-slate-100" placeholder='{"anos":[1994,1995,...],"salario":[...],"ipca":[...],"cesta":[...],"carro":[...],"bigmac":[...],"poupanca":[...],"cdb":[...],"bolsa":[...]}'></textarea>
            <div class="flex flex-wrap gap-2">
              <button id="btnImport" type="button" class="btn">Importar JSON</button>
              <button id="btnExport" type="button" class="btn">Exportar JSON</button>
            </div>
          </div>
          <div class="space-y-3">
            <h4 class="font-semibold text-slate-100">Dica rápida</h4>
            <ul class="list-disc ml-5 text-slate-400 space-y-2">
              <li><strong>CDI anual</strong>: cole as taxas por ano; o app recalcula o CDB 100% automaticamente.</li>
              <li><strong>Ibovespa anual</strong>: informe retorno % a.a. e geramos a curva.</li>
              <li><strong>Poupança</strong>: remuneração efetiva anual.</li>
            </ul>
          </div>
        </div>
        <div class="p-4 border-t border-slate-800/70 flex items-center justify-end gap-2">
          <button class="btn">Fechar</button>
        </div>
      </form>
    </dialog>

    <footer class="text-xs text-slate-500">
      <ul class="list-disc ml-5 space-y-1">
        <li>IPCA anual (IBGE/Ipeadata) — acumulado calculado no app.</li>
        <li>Salário mínimo: decretos/IPEA (série nominal 1994–2025).</li>
        <li>Big Mac: The Economist Big Mac Index (BRL) — pontos reais e interpolação.</li>
        <li>Cesta básica SP: PROCON/DIEESE — pontos reais e interpolação.</li>
        <li>Carro (VW Gol 1.0 0 km): pontos reais e interpolação.</li>
        <li>Investimentos: CDB = 100% CDI anual composto; Poupança média; Bolsa simulada (substituível por séries reais via JSON).</li>
      </ul>
    </footer>
  </div>

  <script type="module" src="assets/js/app.js"></script>
</body>
</html>
