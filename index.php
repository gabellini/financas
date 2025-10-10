<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Aula Interativa: Capitalismo, Finanças e Empreendedorismo (1994–2025)</title>
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
  <style>
    .slides p { line-height: 1.6; }
    .slides h2 { font-weight: 800; }
    .btn { padding: 0.5rem 0.75rem; border-radius: 0.75rem; border: 1px solid rgba(0,0,0,0.12); background: white; }
    .tag { font-size: 0.75rem; font-weight: 600; padding: 0.25rem 0.5rem; border-radius: 9999px; background: #f1f5f9; color: #334155; }
    .kpi { font-size: 0.875rem; color: #475569; display:flex; align-items:center; gap:.5rem }
    .kpi strong { color: #0f172a; }
    .btn-icon { width: 2.75rem; height: 2.75rem; border-radius: 9999px; border: 1px solid rgba(15,23,42,0.12); background: white; display: grid; place-items: center; box-shadow: 0 8px 20px rgba(15,23,42,0.12); position: relative; transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .btn-icon:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(15,23,42,0.18); }
    .btn-icon:focus-visible { outline: 3px solid rgba(16,185,129,0.5); outline-offset: 2px; }
    .btn-icon span { position: absolute; top: 110%; left: 50%; transform: translate(-50%, -4px); background: rgba(15,23,42,0.92); color: white; font-size: 0.75rem; padding: 0.35rem 0.6rem; border-radius: 0.5rem; white-space: nowrap; opacity: 0; pointer-events: none; transition: opacity 0.2s ease, transform 0.2s ease; }
    .btn-icon:hover span, .btn-icon:focus-visible span { opacity: 1; transform: translate(-50%, 2px); }
  </style>
  <script>
    // ======= DADOS REAIS (com interpolação onde faltou) =======
    // Fontes principais (colocadas também no rodapé da página):
    // - Salário mínimo (IPEA / decretos)
    // - IPCA anual (IBGE/Ipeadata)
    // - Big Mac local_price BRL (The Economist Big Mac Index; âncoras + interpolação linear)
    // - Cesta básica São Paulo (DIEESE/PROCON-SP; âncoras + interpolação linear)
    // - Carro popular: VW Gol 1.0 (0 km) – âncoras reais + interpolação linear

    const ANO_INICIO = 1994;
    const ANO_FIM = 2025;
    const ANOS = Array.from({length: (ANO_FIM - ANO_INICIO + 1)}, (_,i)=>ANO_INICIO+i);

    const SALARIO_MIN = {
  1994: 64, 1995: 100, 1996: 112, 1997: 120, 1998: 130, 1999: 136,
  2000: 151, 2001: 180, 2002: 200, 2003: 240, 2004: 260, 2005: 300,
  2006: 350, 2007: 380, 2008: 415, 2009: 465, 2010: 510, 2011: 545,
  2012: 622, 2013: 678, 2014: 724, 2015: 788, 2016: 880, 2017: 937,
  2018: 954, 2019: 998, 2020: 1045, 2021: 1100, 2022: 1212,
  2023: 1320, 2024: 1412, 2025: 1518
};


    // IPCA anual oficial (IBGE/Ipeadata). Em 1994 houve hiperinflação; usamos 0 para o primeiro ano na composição do acumulado.
    const IPCA_ANO_PCT = {
  1994: 916.4,
  1995: 22.41, 1996: 9.56, 1997: 5.22, 1998: 1.65, 1999: 8.94,
  2000: 6.00, 2001: 7.67, 2002: 12.53, 2003: 9.30, 2004: 7.60,
  2005: 5.69, 2006: 3.14, 2007: 4.46, 2008: 5.90, 2009: 4.31,
  2010: 5.91, 2011: 6.50, 2012: 5.84, 2013: 5.91, 2014: 6.41,
  2015: 10.67, 2016: 6.29, 2017: 2.95, 2018: 3.75, 2019: 4.31,
  2020: 4.52, 2021: 10.06, 2022: 5.79, 2023: 4.62, 2024: 4.72,
  2025: 5.13
};

    // Big Mac (BRL) — The Economist (série começa em 2000). Pontos reais + interpolação.
    const BIGMAC_ANUAL = {
  1994: null, 1995: null, 1996: null, 1997: null, 1998: null, 1999: null,
  2000: 2.95, 2001: 3.52, 2002: 4.09, 2003: 4.66, 2004: 5.23,
  2005: 5.80, 2006: 6.34, 2007: 6.88, 2008: 7.42, 2009: 7.96,
  2010: 8.50, 2011: 9.58, 2012: 10.66, 2013: 11.74, 2014: 12.82,
  2015: 13.90, 2016: 14.80, 2017: 15.70, 2018: 16.60, 2019: 17.50,
  2020: 19.50, 2021: 21.75, 2022: 24.00, 2023: 25.40, 2024: 26.80, 2025: 28.00
};

    // Cesta básica (São Paulo, R$) — PROCON/DIEESE (pontos reais) + interpolação.
    const CESTA_SP_ANCHORS = {
      1994: 102.72, 1995: 109.17, 1996: 115.62, 1997: 122.07, 1998: 128.52, 1999: 134.97,
  2000: 141.43, 2001: 161.08, 2002: 180.73, 2003: 200.38, 2004: 220.03, 2005: 239.68,
  2006: 259.33, 2007: 278.98, 2008: 298.63, 2009: 318.28, 2010: 337.93, 2011: 357.58,
  2012: 377.26, 2013: 384.66, 2014: 392.07, 2015: 399.47, 2016: 406.88, 2017: 414.28,
  2018: 483.34, 2019: 552.40, 2020: 621.46, 2021: 690.51, 2022: 791.29,
  2023: 802.38, 2024: 813.46, 2025: 842.26
};

    // Carro popular — VW Gol 1.0 0 km: pontos reais + interpolação.
    const CARRO_GOL_ANCHORS = { 1994: 7243.00, 1995: 8802.33, 1996: 10361.67, 1997: 12021.00, 1998: 13680.33, 1999: 15339.67,
  2000: 16599.00, 2001: 17719.10, 2002: 18839.20, 2003: 19959.30, 2004: 21079.40, 2005: 22199.50,
  2006: 23319.60, 2007: 24439.70, 2008: 25559.80, 2009: 26679.90, 2010: 27800.00, 2011: 28765.67,
  2012: 29731.33, 2013: 30697.00, 2014: 31662.67, 2015: 32628.33, 2016: 33594.00, 2017: 37836.00,
  2018: 42078.00, 2019: 46320.00, 2020: 47020.00, 2021: 53260.00, 2022: 59500.00,
  2023: 78160.00, 2024: 78160.00, 2025: 78160.00
};

    // ======= Utils =======
    const fmtBR = (v) => v == null || isNaN(v) ? '—' : v.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL', maximumFractionDigits: 0 });
    const clamp = (v, a, b) => Math.min(Math.max(v, a), b);

    function interpLinear(anchors) {
      const out = ANOS.map(() => null);
      for (const [yStr, val] of Object.entries(anchors)) {
        const y = +yStr; const idx = y - ANO_INICIO; if (idx >= 0 && idx < out.length) out[idx] = val;
      }
      let lastIdx = null;
      for (let i = 0; i < out.length; i++) {
        if (out[i] != null) {
          if (lastIdx != null && i - lastIdx > 1) {
            const a = out[lastIdx]; const b = out[i]; const n = i - lastIdx;
            for (let k = 1; k < n; k++) out[lastIdx + k] = a + (b - a) * (k / n);
          }
          lastIdx = i;
        }
      }
      if (lastIdx != null) for (let i = lastIdx + 1; i < out.length; i++) out[i] = out[lastIdx];
      const firstIdx = out.findIndex(v => v != null);
      if (firstIdx > 0) for (let i = 0; i < firstIdx; i++) out[i] = out[firstIdx];
      return out;
    }

    function ipcaAcumulado() {
      const out = []; let idx = 100;
      for (const ano of ANOS) { const pct = (ano === 1994 ? 0 : (IPCA_ANO_PCT[ano] ?? 0))/100; idx *= (1+pct); out.push(idx); }
      return out;
    }

    // ======= Investimentos =======
    // Para CDB: modelo correto = aplicar taxa ano a ano sobre o principal iniciando em R$1.000.
    // Aqui deixo um vetor de CDI anual de exemplo (pode ser substituído por série real via JSON).
    const CDI_ANUAL_EXEMPLO = {
      1995: 40.0, 1996: 26.0, 1997: 24.0, 1998: 29.0, 1999: 19.0,
  2000: 17.0, 2001: 19.0, 2002: 19.0, 2003: 23.0, 2004: 16.0,
  2005: 19.0, 2006: 15.0, 2007: 12.0, 2008: 13.0, 2009: 9.0,
  2010: 10.0, 2011: 12.0, 2012: 9.0, 2013: 8.0, 2014: 10.0,
  2015: 14.0, 2016: 14.0, 2017: 10.0, 2018: 6.0, 2019: 5.0,
  2020: 3.0,  2021: 4.0,  2022: 13.0, 2023: 12.4, 2024: 10.8, 2025: 10.5
};

    function curvaCDB100(cdiMap) {
      let v = 1000; const out = [];
      for (const ano of ANOS) { const t = (cdiMap[ano] ?? cdiMap[Object.keys(cdiMap)[0]])/100; v *= (1+t); out.push(v); }
      return out;
    }
    function curvaPoupancaMedia() { let v = 1000; const out = []; for (let i=0;i<ANOS.length;i++){ v*=1.06; out.push(v);} return out; }
    function curvaBolsaSimulada() { let v = 1000; const out=[]; const drift=0.11, vol=0.18; for (let i=0;i<ANOS.length;i++){ const ru=(Math.random()*2-1)*vol; v=Math.max(v*(1+drift+ru),0); out.push(v);} return out; }

    function montarSeries() {
  const salario = ANOS.map(a => SALARIO_MIN[a] ?? null);
  const ipca = ipcaAcumulado();
  const bigmac = ANOS.map(a => BIGMAC_ANUAL[a] ?? null); // <-- usar a série anual, sem backfill
  const cesta = interpLinear(CESTA_SP_ANCHORS);
  const carro = interpLinear(CARRO_GOL_ANCHORS);
  const poupanca = curvaPoupancaMedia();
  const cdb = curvaCDB100(CDI_ANUAL_EXEMPLO);
  const bolsa = curvaBolsaSimulada();
  return { anos: ANOS, salario, ipca, cesta, carro, bigmac, poupanca, cdb, bolsa };
}
  </script>
</head>
<body class="bg-slate-50 text-slate-900">
  <div class="max-w-[1440px] mx-auto px-4 py-4 xl:px-8">
    <!-- Header -->
    <header id="appHeader" class="flex items-center justify-between gap-4 mb-4">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-2xl bg-slate-900 text-white grid place-items-center font-bold">AF</div>
        <div>
          <h1 class="text-xl md:text-2xl font-extrabold">Capitalismo, Finanças e Empreendedorismo</h1>
          <p class="text-sm text-slate-600">Linha do tempo interativa (Plano Real → hoje) + slides • 1h</p>
        </div>
      </div>
      <div class="flex items-center gap-2">
        <button id="btnPlay" class="btn">▶️ Reproduzir</button>
        <button id="btnPause" class="btn">⏸️ Pausar</button>
        <button id="btnReset" class="btn">⟲ Reiniciar</button>
        <div class="hidden sm:flex items-center gap-2 ml-2">
          <label for="speed" class="text-xs text-slate-600">velocidade</label>
          <select id="speed" class="border rounded-lg text-sm px-2 py-1">
            <option value="1000">1 ano/seg</option>
            <option value="2000">1 ano/2s</option>
            <option value="500">2 anos/seg</option>
            <option value="10000">~1h (demo lenta)</option>
          </select>
        </div>
        <a href="quizz.php" class="btn">🎯 Quiz</a>
        <button id="btnDados" class="btn">🛠️ Dados</button>
        <button id="btnHideHeader" class="btn" title="Ocultar cabeçalho">⬆ Ocultar</button>
      </div>
    </header>

    <div id="headerReturn" class="hidden fixed top-4 right-4 z-40">
      <button id="btnShowHeader" class="btn-icon" aria-label="Mostrar cabeçalho">
        ⬇
        <span>Mostrar cabeçalho</span>
      </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 xl:[grid-template-columns:minmax(0,1.2fr)_minmax(0,0.8fr)] gap-4 xl:gap-6">
      <!-- Painel Esquerdo -->
      <section class="bg-white rounded-2xl shadow p-4 lg:p-6">
        <div class="flex items-end justify-between">
          <div>
            <div class="text-xs text-slate-500">Ano</div>
            <div class="text-4xl font-black tracking-tight"><span id="anoAtual">1994</span></div>
            <div class="mt-2 flex items-center gap-1 text-xs">
              <button id="anoMenos5" class="btn" title="-5 anos">«5</button>
              <button id="anoMenos" class="btn" title="-1 ano">−1</button>
              <button id="anoMais" class="btn" title="+1 ano">+1</button>
              <button id="anoMais5" class="btn" title="+5 anos">5»</button>
            </div>
          </div>
          <div class="text-right">
            <div class="text-xs text-slate-500">Modo</div>
            <div class="flex items-center gap-2 justify-end">
              <span class="tag" id="modoTag">Dados reais + investimentos simulados</span>
              <label class="inline-flex items-center gap-2 text-xs text-slate-600">
                <input id="chkLog" type="checkbox" class="rounded" />
                escala log
              </label>
            </div>
          </div>
        </div>
        <div class="mt-3 w-full bg-slate-100 h-2 rounded-full overflow-hidden">
          <div id="barra" class="h-2 bg-emerald-600" style="width: 0%"></div>
        </div>
        <div class="mt-3">
          <input id="sliderAno" type="range" min="0" max="0" value="0" class="w-full accent-emerald-600" />
        </div>

        <!-- KPIs -->
        <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 gap-3">
          <div class="border rounded-xl p-3">
            <div class="kpi">💼 Salário mínimo</div>
            <div class="text-lg font-bold leading-tight"><span id="kpiSalario">—</span></div>
            <div class="text-xs text-slate-500">poder de compra vs. cesta: <span id="kpiPoderCompra">—</span></div>
          </div>
          <div class="border rounded-xl p-3">
            <div class="kpi">📈 Inflação (acum. desde 1994)</div>
            <div class="text-lg font-bold leading-tight"><span id="kpiInflacao">—</span></div>
            <div class="text-xs text-slate-500">IPCA oficial (IBGE)</div>
          </div>
          <div class="border rounded-xl p-3">
            <div class="kpi">🧺 Cesta básica – SP</div>
            <div class="text-lg font-bold leading-tight"><span id="kpiCesta">—</span></div>
            <div class="text-xs text-slate-500">🚗 carro: <span id="kpiCarro">—</span> · 🍔 Big Mac: <span id="kpiBigmac">—</span></div>
          </div>
          <div class="border rounded-xl p-3">
            <div class="kpi">🏦 Invest. R$1.000 — Poupança</div>
            <div class="text-lg font-bold leading-tight"><span id="kpiPoupanca">—</span></div>
          </div>
          <div class="border rounded-xl p-3">
            <div class="kpi">💳 Invest. R$1.000 — CDB (100% CDI)</div>
            <div class="text-lg font-bold leading-tight"><span id="kpiCDB">—</span></div>
          </div>
          <div class="border rounded-xl p-3">
            <div class="kpi">📊 Invest. R$1.000 — Bolsa</div>
            <div class="text-lg font-bold leading-tight"><span id="kpiBolsa">—</span></div>
          </div>
        </div>

        <!-- Gráfico -->
        <div class="mt-4 h-[360px]">
          <canvas id="chart"></canvas>
        </div>

        <!-- Fontes/Notas -->
        <div class="mt-4 text-xs text-slate-500 space-y-1">
          <p><strong>Fontes:</strong> IPCA anual (IBGE/Ipeadata); Salário mínimo (decretos/IPEA); Big Mac (The Economist Big Mac Index — BRL, pontos e interpolação); Cesta básica SP (PROCON/DIEESE — âncoras e interpolação); Carro (VW Gol 1.0 0 km – âncoras e interpolação). Investimentos: CDB calculado como 100% CDI anual composto; Poupança média; Bolsa simulada. Você pode importar séries reais de CDI/Ibovespa no botão <em>🛠️ Dados</em>.</p>
        </div>
      </section>

      <!-- Painel Direito: Slides -->
      <section class="bg-white rounded-2xl shadow p-0 flex flex-col overflow-hidden">
        <div class="p-3 border-b flex items-center justify-between">
          <div class="flex items-center gap-2">
            <button id="prevSlide" class="btn">←</button>
            <button id="nextSlide" class="btn">→</button>
          </div>
          <div class="text-sm text-slate-600">Slide <span id="slidePos">1</span>/<span id="slideTotal">—</span></div>
        </div>
        <div id="slides" class="slides p-5 lg:p-6 h-[620px] overflow-y-auto"></div>
      </section>
    </div>

    <!-- Modal de Dados -->
    <dialog id="dlgDados" class="rounded-2xl p-0 w-[94vw] max-w-4xl">
      <form method="dialog" class="p-0">
        <div class="p-4 border-b flex items-center justify-between">
          <h3 class="text-lg font-bold">Ajustar dados / Importar séries reais</h3>
          <button class="btn">✖</button>
        </div>
        <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
          <div>
            <h4 class="font-semibold mb-2">Importar/Exportar JSON</h4>
            <p class="text-slate-600 mb-2">Cole JSON com as séries anuais completas (chaves: <code>anos</code>, <code>salario</code>, <code>ipca</code>, <code>cesta</code>, <code>carro</code>, <code>bigmac</code>, <code>poupanca</code>, <code>cdb</code>, <code>bolsa</code>).</p>
            <textarea id="areaJson" class="w-full h-80 border rounded-lg p-2 font-mono text-xs" placeholder='{"anos":[1994,1995,...],"salario":[...],"ipca":[...],"cesta":[...],"carro":[...],"bigmac":[...],"poupanca":[...],"cdb":[...],"bolsa":[...]}'></textarea>
            <div class="mt-2 flex gap-2">
              <button id="btnImport" type="button" class="btn">Importar JSON</button>
              <button id="btnExport" type="button" class="btn">Exportar JSON</button>
            </div>
          </div>
          <div>
            <h4 class="font-semibold mb-2">Dica rápida</h4>
            <ul class="list-disc ml-5 text-slate-600">
              <li><strong>CDI anual</strong>: cole as taxas por ano; o app recalcula o CDB 100% automaticamente.</li>
              <li><strong>Ibovespa anual</strong>: informe retorno % a.a. e geramos a curva.</li>
              <li><strong>Poupança</strong>: remuneração efetiva anual.</li>
            </ul>
          </div>
        </div>
        <div class="p-4 border-t flex items-center justify-end gap-2">
          <button class="btn">Fechar</button>
        </div>
      </form>
    </dialog>
  </div>

  <script>
    // ======= Slides (20+) =======
    const slides = [
      {
        titulo: "1) Roteiro da aula 🌐",
        conteudo: `
          <div class="space-y-4">
            <p>Vamos decifrar <strong>o que é dinheiro</strong>, entender como <strong>inflação e juros</strong> afetam a sua vida e montar a base para falar de <strong>investimentos e empreendedorismo</strong>.</p>
            <ul class="list-disc ml-5 space-y-2">
              <li>Origem do dinheiro e por que ele ainda manda no jogo.</li>
              <li>Como proteger o poder de compra em um país de inflação.</li>
              <li>Transformar tempo, estudo e investimento em renda crescente.</li>
            </ul>
            <p class="text-sm text-slate-500"><strong>Insight:</strong> quanto antes você entende as regras do capitalismo, mais rápido consegue jogar bem.</p>
          </div>
        `
      },
      {
        titulo: "2) Linha do tempo 1994 → 2025 ⏱️",
        conteudo: `
          <div class="space-y-4">
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>1994:</strong> Plano Real acaba com a hiperinflação dos pais e avós.</li>
              <li><strong>2000-2010:</strong> crédito bombando, consumo em alta, empregos formais crescendo.</li>
              <li><strong>2014-2016:</strong> recessão dura, inflação passa dos 10%.</li>
              <li><strong>2020-2022:</strong> pandemia: preços de comida e tecnologia disparam.</li>
              <li><strong>2023-2025:</strong> esforço para estabilizar inflação e recuperar renda.</li>
            </ul>
            <p class="text-sm text-slate-500"><strong>Insight:</strong> entender o passado recente ajuda a interpretar os gráficos e escolher atitudes inteligentes para o futuro.</p>
          </div>
        `
      },
      {
        titulo: "3) Como o dinheiro nasceu? 🪙",
        conteudo: `
          <div class="space-y-4">
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>Escambo:</strong> trocar objetos direto era difícil (como pagar com uma vaca?).</li>
              <li><strong>Metais e moedas:</strong> itens raros e aceitos por todos simplificaram as trocas.</li>
              <li><strong>Papel-moeda e bancos:</strong> recibos representando valor guardado com segurança.</li>
              <li><strong>Era digital:</strong> cartões, Pix, cripto e saldo em apps.</li>
            </ul>
            <p class="text-sm text-slate-500"><strong>Insight:</strong> dinheiro é uma tecnologia social criada para facilitar acordos — e pode mudar de formato sempre que surgir algo mais eficiente.</p>
          </div>
        `
      },
      {
        titulo: "4) Dinheiro = acordo coletivo 💬",
        conteudo: `
          <div class="space-y-4">
            <p>O real vale porque <strong>todos confiam</strong> que ele será aceito amanhã.</p>
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>Instituições:</strong> Banco Central, Tesouro e bancos privados garantem o fluxo.</li>
              <li><strong>Regras:</strong> leis e contratos protegem quem guarda ou investe.</li>
              <li><strong>Digitalização:</strong> hoje você paga com QR Code — mas a lógica do acordo permanece.</li>
            </ul>
            <p class="text-sm text-slate-500"><strong>Insight:</strong> se o valor depende da confiança coletiva, seu comportamento como consumidor, investidor e cidadão influencia o sistema.</p>
          </div>
        `
      },
      {
        titulo: "5) Para que serve o dinheiro? 💵",
        conteudo: `
          <div class="space-y-4">
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>Meio de troca:</strong> você compra comida, game pass ou passagem sem negociar toda vez.</li>
              <li><strong>Unidade de conta:</strong> preços e salários são comparáveis em reais.</li>
              <li><strong>Reserva de valor:</strong> guardar para realizar sonhos (faculdade, intercâmbio, empreendimento).</li>
            </ul>
            <p class="text-sm text-slate-500"><strong>Insight:</strong> trate cada gasto como uma decisão entre o agora e oportunidades futuras que o dinheiro pode comprar.</p>
          </div>
        `
      },
      {
        titulo: "6) Dinheiro compra tempo de vida ⏳",
        conteudo: `
          <div class="space-y-4">
            <p>Quando você recebe salário ou paga por um serviço, está trocando <strong>horas de vida</strong>.</p>
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>Salário:</strong> preço da sua hora, definido por habilidades e demanda.</li>
              <li><strong>Consumo:</strong> cada compra gasta horas de trabalho que você precisou para juntar aquele dinheiro.</li>
              <li><strong>Investimento:</strong> faz o dinheiro trabalhar por você para comprar tempo livre no futuro.</li>
            </ul>
            <p class="text-sm text-slate-500"><strong>Insight:</strong> calcule quantas horas de trabalho cada sonho custa — fica mais fácil priorizar o que importa.</p>
          </div>
        `
      },
      {
        titulo: "7) Mais-valia e venda do tempo 💼",
        conteudo: `
          <div class="space-y-4">
            <p>Nas empresas, o valor produzido é maior que o salário pago. A diferença é a <strong>mais-valia</strong>, que financia lucros, reinvestimentos e riscos.</p>
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>Como empregado:</strong> busque bônus, participação nos resultados e reputação para capturar parte desse valor.</li>
              <li><strong>Como futuro empreendedor:</strong> entender custos e trabalho ajuda a montar preços justos.</li>
              <li><strong>Como cidadão:</strong> consciência de classe e negociação coletiva influenciam salários.</li>
            </ul>
            <p class="text-sm text-slate-500"><strong>Insight:</strong> dominar a lógica da mais-valia permite decidir se você quer vender tempo, participar dos lucros ou criar o próprio negócio.</p>
          </div>
        `
      },
      {
        titulo: "8) Inflação na vida real 📈",
        conteudo: `
          <div class="space-y-4">
            <p>Inflação é o aumento contínuo dos preços. Você sente no lanche, na passagem de ônibus e na mensalidade do cursinho.</p>
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>IPCA:</strong> pesquisa do IBGE que mede a média dos aumentos.</li>
              <li><strong>Perda de poder de compra:</strong> com a mesma mesada você leva menos coisas.</li>
              <li><strong>Dados reais:</strong> o Big Mac saiu de ~R$ 3 (2000) para ~R$ 28 (2025) — 9 Big Macs viraram 1.</li>
            </ul>
            <p class="text-sm text-slate-500"><strong>Insight:</strong> acompanhar inflação ensina a ajustar metas: sonhos custam mais a cada ano se você não se proteger.</p>
          </div>
        `
      },
      {
        titulo: "9) Choques inflacionários recentes 🔥",
        conteudo: `
          <div class="space-y-4">
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>1999:</strong> câmbio liberado faz o dólar disparar.</li>
              <li><strong>2002:</strong> incerteza eleitoral leva o IPCA a 12,5%.</li>
              <li><strong>2015:</strong> reajuste de energia e crise política elevam preços.</li>
              <li><strong>2021:</strong> pandemia + falta de insumos + combustíveis caros.</li>
            </ul>
            <p>Veja no gráfico como salários e custos de vida tentam acompanhar esses choques.</p>
            <p class="text-sm text-slate-500"><strong>Insight:</strong> quanto mais você conhece a história dos preços, mais rápido reage quando um novo choque aparece.</p>
          </div>
        `
      },
      {
        titulo: "10) Como se defender da inflação 🛡️",
        conteudo: `
          <div class="space-y-4">
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>Negocie reajustes:</strong> salários, mesadas e preços precisam acompanhar o IPCA.</li>
              <li><strong>Revise contratos:</strong> alugueis e mensalidades geralmente têm índices de reajuste.</li>
              <li><strong>Invista em ativos indexados:</strong> IPCA+, fundos imobiliários, ações de setores essenciais.</li>
            </ul>
            <p class="text-sm text-slate-500"><strong>Insight:</strong> proteger o poder de compra hoje é o primeiro passo para sobrar dinheiro para empreender amanhã.</p>
          </div>
        `
      },
      {
        titulo: "11) Juros: o aluguel do dinheiro 💳",
        conteudo: `
          <div class="space-y-4">
            <p>Juros são o preço cobrado para usar dinheiro que não é seu ou a recompensa por emprestar.</p>
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>Selic:</strong> taxa básica definida pelo Banco Central (o COPOM é o comitê que decide, tipo a diretoria).</li>
              <li><strong>Crédito caro:</strong> cartão rotativo ou cheque especial podem dobrar a dívida em poucos meses.</li>
              <li><strong>Crédito saudável:</strong> usar parcelamento consciente para estudar ou montar um negócio.</li>
            </ul>
            <p class="text-sm text-slate-500"><strong>Insight:</strong> entender juros antes de usar crédito evita armadilhas e prepara você para negociar taxas melhores.</p>
          </div>
        `
      },
      {
        titulo: "12) Selic, CDI e inflação sem mistério 🏦",
        conteudo: `
          <div class="space-y-4">
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>Selic:</strong> âncora que influencia todos os juros do mercado.</li>
              <li><strong>CDI:</strong> taxa que os bancos usam entre si e que rende seus CDBs.</li>
              <li><strong>Inflação:</strong> se ela for maior que o rendimento, o ganho é falso.</li>
            </ul>
            <p class="text-sm text-slate-500"><strong>Insight:</strong> acompanhar essas três siglas é saber se o dinheiro está correndo a seu favor ou contra você.</p>
          </div>
        `
      },
      {
        titulo: "13) Juro real na prática 🧮",
        conteudo: `
          <div class="space-y-4">
            <p>Ganhar 10% quando os preços sobem 8% significa só 1,85% de ganho real.</p>
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>Fórmula:</strong> (1 + rendimento) ÷ (1 + inflação) − 1.</li>
              <li><strong>Exemplo:</strong> CDB 10% com IPCA 5% ⇒ ganho real 4,76%.</li>
              <li><strong>Sinal de alerta:</strong> se a inflação supera o rendimento, você está andando para trás.</li>
            </ul>
            <p class="text-sm text-slate-500"><strong>Insight:</strong> faça as contas em ganho real sempre — essa habilidade vale ouro em qualquer profissão.</p>
          </div>
        `
      },
      {
        titulo: "14) Investir é dar missão ao dinheiro 🎯",
        conteudo: `
          <div class="space-y-4">
            <p>Guardar sem objetivo vira saldo parado; investir conecta o dinheiro a metas claras.</p>
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>Curto prazo:</strong> reserva de emergência e oportunidades.</li>
              <li><strong>Médio prazo:</strong> cursos, intercâmbio, capital para negócio.</li>
              <li><strong>Longo prazo:</strong> independência financeira e aposentadoria.</li>
            </ul>
            <p class="text-sm text-slate-500"><strong>Insight:</strong> dinheiro com propósito motiva disciplina e escolhas inteligentes.</p>
          </div>
        `
      },
      {
        titulo: "15) Ferramentas para proteger poder de compra 🛡️",
        conteudo: `
          <div class="space-y-4">
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>Tesouro IPCA+ e NTN-B:</strong> acompanham a inflação automaticamente.</li>
              <li><strong>Ativos reais:</strong> imóveis, FIIs, commodities e negócios produtivos.</li>
              <li><strong>Câmbio e diversificação global:</strong> quando o real perde força, ativos em dólar seguram o valor.</li>
            </ul>
            <p class="text-sm text-slate-500"><strong>Insight:</strong> combine diferentes proteções para não depender de uma aposta só.</p>
          </div>
        `
      },
      {
        titulo: "16) Risco x retorno sem mistério ⚖️",
        conteudo: `
          <div class="space-y-4">
            <p>Quanto maior a chance de oscilar, maior o retorno esperado — mas também o estresse.</p>
            <div class="grid gap-3 md:grid-cols-2">
              <div class="rounded-xl bg-slate-100 p-4">
                <h3 class="font-semibold">Principais riscos</h3>
                <ul class="list-disc ml-5 space-y-1">
                  <li>Mercado: preço sobe e desce o tempo todo.</li>
                  <li>Crédito: quem pegou seu dinheiro pode não pagar.</li>
                  <li>Liquidez: dificuldade de resgatar rápido.</li>
                </ul>
              </div>
              <div class="rounded-xl bg-slate-100 p-4">
                <h3 class="font-semibold">Como lidar</h3>
                <ul class="list-disc ml-5 space-y-1">
                  <li>Diversifique ativos e prazos.</li>
                  <li>Tenha reserva para emergências.</li>
                  <li>Escolha investimentos que combinem com seu objetivo.</li>
                </ul>
              </div>
            </div>
            <p class="text-sm text-slate-500"><strong>Insight:</strong> aceitar um risco só faz sentido quando o retorno esperado conecta com o seu projeto de vida.</p>
          </div>
        `
      },
      {
        titulo: "17) Dinheiro trabalhando em conjunto 🧺",
        conteudo: `
          <div class="space-y-4">
            <p>Exemplo de carteira equilibrada para jovens que querem crescer sem se expor demais:</p>
            <ul class="list-disc ml-5 space-y-2">
              <li>40% em reserva líquida (Tesouro Selic, CDB de liquidez diária).</li>
              <li>30% em ativos indexados à inflação (Tesouro IPCA+, debêntures incentivadas).</li>
              <li>20% em ações brasileiras e FIIs para renda e aprendizado.</li>
              <li>10% em ETFs globais ou dólar para ver o mundo além das fronteiras.</li>
            </ul>
            <p class="text-sm text-slate-500"><strong>Insight:</strong> diversificar cedo reduz medo de oscilações e cria repertório para empreender com dados.</p>
          </div>
        `
      },
      {
        titulo: "18) Trabalho bem feito chama oportunidade 💡",
        conteudo: `
          <div class="space-y-4">
            <p>Mesmo ganhando pouco no início, entregar excelência aumenta a chance de promoções e convites melhores.</p>
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>Reputação:</strong> quem cumpre promessa vira referência rápida.</li>
              <li><strong>Portfólio:</strong> projetos bem feitos contam sua história profissional.</li>
              <li><strong>Aprendizado contínuo:</strong> erros viram upgrade quando você analisa o que podia melhorar.</li>
            </ul>
            <p class="text-sm text-slate-500"><strong>Insight:</strong> trabalhar mal porque paga pouco te prende no mesmo lugar; trabalhar bem te coloca no radar de quem paga melhor.</p>
          </div>
        `
      },
      {
        titulo: "19) Como aumentar o valor da sua hora 🧑‍🏭",
        conteudo: `
          <div class="space-y-4">
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>Exclusividade:</strong> desenvolva habilidades raras (ex.: programação, design 3D, idiomas).</li>
              <li><strong>Combinação única:</strong> junte paixões (finanças + audiovisual = conteúdo valioso).</li>
              <li><strong>Rede de contatos:</strong> quanto mais gente sabe o que você faz, mais oportunidades aparecem.</li>
            </ul>
            <p class="text-sm text-slate-500"><strong>Insight:</strong> preço alto não vem do acaso, mas da sua capacidade de resolver problemas que poucos resolvem.</p>
          </div>
        `
      },
      {
        titulo: "20) Da renda ao investimento e ao negócio 🚀",
        conteudo: `
          <div class="space-y-4">
            <p>Usar bem o salário é a ponte para investir e, mais tarde, empreender.</p>
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>Organize-se:</strong> orçamento mostra quanto sobra para investir todo mês.</li>
              <li><strong>Capital semente:</strong> reserve parte dos investimentos para testar ideias.</li>
              <li><strong>Reinvestimento:</strong> lucros do negócio voltam para crescer ou diversificar.</li>
            </ul>
            <p class="text-sm text-slate-500"><strong>Insight:</strong> empreendedorismo começa quando você decide que uma parte da renda bancará seus próprios projetos.</p>
          </div>
        `
      },
      {
        titulo: "21) Educação financeira é liberdade 🗝️",
        conteudo: `
          <div class="space-y-4">
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>Controle:</strong> saiba para onde vai cada real.</li>
              <li><strong>Planejamento:</strong> defina metas de curto, médio e longo prazo.</li>
              <li><strong>Curiosidade:</strong> aprenda produtos financeiros novos, mesmo que não use agora.</li>
            </ul>
            <p class="text-sm text-slate-500"><strong>Insight:</strong> conhecimento vira liberdade porque você não depende de dicas aleatórias para tomar decisões.</p>
          </div>
        `
      },
      {
        titulo: "22) Plano de ação em 4 passos ✅",
        conteudo: `
          <div class="space-y-4">
            <ol class="list-decimal ml-5 space-y-2">
              <li><strong>Diagnóstico:</strong> liste receitas, gastos e dívidas.</li>
              <li><strong>Fundação:</strong> monte reserva de emergência e quite dívidas caras.</li>
              <li><strong>Construção:</strong> invista com metas claras (IPCA+, renda variável, dólar).</li>
              <li><strong>Escala:</strong> transforme conhecimento em novas fontes de renda (freelas, negócios, sociedade).</li>
            </ol>
            <p class="text-sm text-slate-500"><strong>Insight:</strong> revisar esse plano a cada semestre mantém você no controle da própria evolução.</p>
          </div>
        `
      }
    ];

    function renderSlide(idx) {
      const el = document.getElementById('slides');
      const s = slides[idx];
      el.innerHTML = `<h2 class="text-2xl font-extrabold mb-2">${s.titulo}</h2><div class="prose max-w-none">${s.conteudo}</div>`;
      document.getElementById('slidePos').textContent = (idx + 1);
      document.getElementById('slideTotal').textContent = slides.length;
    }

    // ======= Estado =======
    let state = { series: null, playing: false, timer: null, speed: 1000, i: 0, escalaLog: false };

    // ======= KPIs =======
    function atualizarKPIs() {
      const i = state.i; const s = state.series; const ano = s.anos[i];
      document.getElementById('anoAtual').textContent = ano;

      const sal = s.salario[i], cesta = s.cesta[i], carro = s.carro[i], big = s.bigmac[i];
      const inflAcum = ((s.ipca[i] / 100) - 1) * 100;
      const poderCompra = (sal && cesta) ? (sal / cesta) * 100 : null;

      document.getElementById('kpiSalario').textContent = fmtBR(sal);
      document.getElementById('kpiInflacao').textContent = isFinite(inflAcum) ? inflAcum.toFixed(0) + '%' : '—';
      document.getElementById('kpiCesta').textContent = fmtBR(cesta);
      document.getElementById('kpiCarro').textContent = fmtBR(carro);
      document.getElementById('kpiBigmac').textContent = big==null ? '—' : fmtBR(big);
      document.getElementById('kpiPoupanca').textContent = fmtBR(s.poupanca[i]);
      document.getElementById('kpiCDB').textContent = fmtBR(s.cdb[i]);
      document.getElementById('kpiBolsa').textContent = fmtBR(s.bolsa[i]);
      document.getElementById('kpiPoderCompra').textContent = (poderCompra==null? '—' : poderCompra.toFixed(0));

      const pct = (i / (s.anos.length - 1)) * 100;
      document.getElementById('barra').style.width = pct + '%'; // ÚNICA barra de progresso
    }

    // ======= Chart =======
    let chart;
    function initChart() {
      const ctx = document.getElementById('chart');
      if (chart) chart.destroy();
      chart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: state.series.anos,
          datasets: [
            { label: 'Salário (R$)', data: state.series.salario, yAxisID: 'y', borderWidth: 2, tension: 0.25, spanGaps: true },
            { label: 'Cesta (R$)', data: state.series.cesta, yAxisID: 'y', borderWidth: 2, tension: 0.25, spanGaps: true },
            { label: 'Big Mac (R$)', data: state.series.bigmac, yAxisID: 'y', borderWidth: 2, tension: 0.25, spanGaps: true },
            { label: 'Carro (R$)', data: state.series.carro, yAxisID: 'yCar', borderWidth: 2, tension: 0.25, spanGaps: true },
            { label: 'Poupança (R$)', data: state.series.poupanca, yAxisID: 'yInv', borderWidth: 2, tension: 0.25 },
            { label: 'CDB (R$)', data: state.series.cdb, yAxisID: 'yInv', borderWidth: 2, tension: 0.25 },
            { label: 'Bolsa (R$)', data: state.series.bolsa, yAxisID: 'yInv', borderWidth: 2, tension: 0.25 },
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: { legend: { position: 'bottom' }, tooltip: { mode: 'index', intersect: false } },
          interaction: { mode: 'index', intersect: false },
          scales: {
            y: { type: state.escalaLog ? 'logarithmic' : 'linear', position: 'left', ticks: { callback: (v) => 'R$ ' + Number(v).toLocaleString('pt-BR', { maximumFractionDigits: 0 }) } },
            yCar: { type: state.escalaLog ? 'logarithmic' : 'linear', position: 'right', grid: { drawOnChartArea: false }, ticks: { callback: (v) => 'R$ ' + Number(v).toLocaleString('pt-BR', { maximumFractionDigits: 0 }) } },
            yInv: { type: state.escalaLog ? 'logarithmic' : 'linear', position: 'right', grid: { drawOnChartArea: false }, display: false }
          }
        }
      });
    }

    function atualizarChartAteI() {
      const i = state.i, s = state.series, cortes = (arr) => arr.slice(0, i + 1);
      chart.data.labels = s.anos.slice(0, i + 1);
      chart.data.datasets[0].data = cortes(s.salario);
      chart.data.datasets[1].data = cortes(s.cesta);
      chart.data.datasets[2].data = cortes(s.bigmac);
      chart.data.datasets[3].data = cortes(s.carro);
      chart.data.datasets[4].data = cortes(s.poupanca);
      chart.data.datasets[5].data = cortes(s.cdb);
      chart.data.datasets[6].data = cortes(s.bolsa);
      chart.update('none');
      const slider = document.getElementById('sliderAno'); if (slider) slider.value = String(i);
    }

    // ======= Controles =======
    let slideIdx = 0;
    function stepForward() { if (state.i < state.series.anos.length - 1) { state.i++; atualizarKPIs(); atualizarChartAteI(); } else { togglePlay(false); } }
    function togglePlay(go) { state.playing = go !== undefined ? go : !state.playing; clearInterval(state.timer); if (state.playing) state.timer = setInterval(stepForward, state.speed); document.getElementById('modoTag').textContent = state.playing ? 'Reproduzindo' : 'Dados reais + investimentos simulados'; }
    function resetTudo() { state.i = 0; atualizarKPIs(); atualizarChartAteI(); togglePlay(false); document.getElementById('modoTag').textContent = 'Dados reais + investimentos simulados'; }

    function boot() {
      state.series = montarSeries();
      initChart(); atualizarKPIs(); atualizarChartAteI();
      renderSlide(slideIdx);

      const slider = document.getElementById('sliderAno');
      slider.max = String(state.series.anos.length - 1); slider.value = '0';
      slider.addEventListener('input', (e) => { state.i = +e.target.value; atualizarKPIs(); atualizarChartAteI(); });

      const setAno = (d) => { state.i = clamp(state.i + d, 0, state.series.anos.length - 1); atualizarKPIs(); atualizarChartAteI(); };
      document.getElementById('anoMenos5').addEventListener('click', () => setAno(-5));
      document.getElementById('anoMenos').addEventListener('click', () => setAno(-1));
      document.getElementById('anoMais').addEventListener('click', () => setAno(+1));
      document.getElementById('anoMais5').addEventListener('click', () => setAno(+5));

      window.addEventListener('keydown', (e) => { if (e.key === 'ArrowUp') setAno(+1); if (e.key === 'ArrowDown') setAno(-1); if (e.key === 'ArrowRight') document.getElementById('nextSlide').click(); if (e.key === 'ArrowLeft') document.getElementById('prevSlide').click(); });

      document.getElementById('speed').addEventListener('change', (e) => { state.speed = +e.target.value; if (state.playing) togglePlay(true); });
      document.getElementById('chkLog').addEventListener('change', (e) => { state.escalaLog = e.target.checked; initChart(); atualizarChartAteI(); });

      document.getElementById('btnPlay').addEventListener('click', () => togglePlay(true));
      document.getElementById('btnPause').addEventListener('click', () => togglePlay(false));
      document.getElementById('btnReset').addEventListener('click', resetTudo);

      const header = document.getElementById('appHeader');
      const headerReturn = document.getElementById('headerReturn');
      document.getElementById('btnHideHeader').addEventListener('click', () => {
        header.classList.add('hidden');
        headerReturn.classList.remove('hidden');
      });
      document.getElementById('btnShowHeader').addEventListener('click', () => {
        header.classList.remove('hidden');
        headerReturn.classList.add('hidden');
      });

      document.getElementById('nextSlide').addEventListener('click', () => { slideIdx = (slideIdx + 1) % slides.length; renderSlide(slideIdx); });
      document.getElementById('prevSlide').addEventListener('click', () => { slideIdx = (slideIdx - 1 + slides.length) % slides.length; renderSlide(slideIdx); });

      // Modal de dados
      const dlg = document.getElementById('dlgDados');
      document.getElementById('btnDados').addEventListener('click', () => dlg.showModal());
      document.getElementById('btnImport').addEventListener('click', () => {
        try { const obj = JSON.parse(document.getElementById('areaJson').value); if (!obj.anos) throw new Error('JSON deve conter a chave "anos".'); state.series = obj; state.i = 0; initChart(); atualizarKPIs(); atualizarChartAteI(); document.getElementById('modoTag').textContent = 'Dados importados (reais)'; }
        catch (err) { alert('Falha ao importar JSON: ' + err.message); }
      });
      document.getElementById('btnExport').addEventListener('click', () => { document.getElementById('areaJson').value = JSON.stringify(state.series, null, 2); });
    }

    boot();
  </script>

  <!-- ======= Referências ======= -->
  <footer class="max-w-[1440px] mx-auto px-4 py-4 xl:px-8 text-xs text-slate-500">
    <ul class="list-disc ml-5 space-y-1">
      <li>IPCA anual (IBGE/Ipeadata) — acumulado calculado no app.</li>
      <li>Salário mínimo: decretos/IPEA (série nominal 1994–2025).</li>
      <li>Big Mac: The Economist Big Mac Index (BRL) — pontos reais e interpolação.</li>
      <li>Cesta básica SP: PROCON/DIEESE — pontos reais e interpolação.</li>
      <li>Carro (VW Gol 1.0 0 km): pontos reais (1994, 2000, 2010, 2019, 2020, 2023) e interpolação.</li>
      <li>Investimentos: CDB = 100% CDI anual composto; Poupança média; Bolsa simulada (pode substituir por séries reais via JSON).</li>
    </ul>
  </footer>
</body>
</html>