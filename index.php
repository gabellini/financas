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
            <p>Vamos conectar <strong>história econômica</strong>, <strong>finanças pessoais</strong> e <strong>empreendedorismo</strong> de 1994 a 2025.</p>
            <ul class="list-disc ml-5 space-y-2">
              <li>Plano Real e a virada contra a inflação.</li>
              <li>Como juros e preços mexem com seu bolso.</li>
              <li>Estratégias de investimento e geração de renda.</li>
            </ul>
            <p class="text-sm text-slate-500">Use os controles para acompanhar os dados em tempo real enquanto apresentamos os slides.</p>
          </div>
        `
      },
      {
        titulo: "2) Linha do tempo 1994 → 2025 ⏱️",
        conteudo: `
          <div class="space-y-4">
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>1994:</strong> Plano Real estabiliza preços após hiperinflação.</li>
              <li><strong>2000-2010:</strong> crédito em expansão, consumo em alta.</li>
              <li><strong>2014-2016:</strong> recessão, inflação acima de 10% em 2015.</li>
              <li><strong>2020-2022:</strong> choque da pandemia, juros mínimos → máximos.</li>
              <li><strong>2023-2025:</strong> foco em inflação controlada e retomada do emprego.</li>
            </ul>
            <p>Essa cronologia explica as curvas que você vê no painel ao lado.</p>
          </div>
        `
      },
      {
        titulo: "3) Para que serve o dinheiro? 💵",
        conteudo: `
          <div class="space-y-4">
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>Meio de troca:</strong> facilita compras sem escambo.</li>
              <li><strong>Unidade de conta:</strong> precifica produtos e salários.</li>
              <li><strong>Reserva de valor:</strong> permite guardar poder de compra.</li>
            </ul>
            <p><strong>Exemplo:</strong> seu salário é pago em reais porque todos aceitam, conseguem comparar preços e confiam que não perderá valor rapidamente.</p>
          </div>
        `
      },
      {
        titulo: "4) O que sustenta o valor da moeda? 🛡️",
        conteudo: `
          <div class="space-y-4">
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>Estabilidade fiscal:</strong> governo gasta dentro do orçamento.</li>
              <li><strong>Banco Central independente:</strong> controla a inflação com juros.</li>
              <li><strong>Confiança coletiva:</strong> todos acreditam que o dinheiro vale algo amanhã.</li>
            </ul>
            <p>Quando um desses pilares falha, a moeda perde força e os preços disparam.</p>
          </div>
        `
      },
      {
        titulo: "5) Inflação: inimiga silenciosa 📈",
        conteudo: `
          <div class="space-y-4">
            <p>Inflação é o aumento <strong>persistente</strong> dos preços. Você sente no mercado, no aluguel e no transporte.</p>
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>IPCA:</strong> indicador oficial medido pelo IBGE.</li>
              <li><strong>Poder de compra:</strong> com a mesma renda você leva menos produtos pra casa.</li>
              <li><strong>Exemplo real:</strong> Big Mac passou de ~R$3 (2000) para ~R$28 (2025).</li>
            </ul>
          </div>
        `
      },
      {
        titulo: "6) Choques inflacionários na história recente 🔥",
        conteudo: `
          <div class="space-y-4">
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>1999:</strong> câmbio flutuante → dólar dispara → preços sobem.</li>
              <li><strong>2002:</strong> incerteza eleitoral → IPCA 12,5%.</li>
              <li><strong>2015:</strong> crise política e tarifária → IPCA 10,7%.</li>
              <li><strong>2021:</strong> pandemia + commodities → IPCA 10%.</li>
            </ul>
            <p>Observe no gráfico como o salário mínimo precisou subir para compensar o impacto.</p>
          </div>
        `
      },
      {
        titulo: "7) Por que os preços sobem? 💡",
        conteudo: `
          <div class="grid gap-3 md:grid-cols-2">
            <div>
              <h3 class="font-semibold">Pressões de demanda</h3>
              <ul class="list-disc ml-5 space-y-1">
                <li>Crescimento rápido dos salários.</li>
                <li>Crédito fácil e juros baixos.</li>
                <li>Consumo maior que a produção.</li>
              </ul>
            </div>
            <div>
              <h3 class="font-semibold">Pressões de oferta</h3>
              <ul class="list-disc ml-5 space-y-1">
                <li>Alta de energia e insumos importados.</li>
                <li>Quebras de safra e logística cara.</li>
                <li>Expectativas negativas de empresários.</li>
              </ul>
            </div>
          </div>
        `
      },
      {
        titulo: "8) Juros: o preço do tempo ⏳",
        conteudo: `
          <div class="space-y-4">
            <p>Juros remuneram quem <strong>adiou consumo</strong> e punem quem adiantou com crédito.</p>
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>Selic:</strong> taxa básica definida pelo COPOM.</li>
              <li><strong>Spread bancário:</strong> juros cobrados em empréstimos = Selic + risco + custos.</li>
              <li><strong>Exemplo:</strong> comprar uma TV no cartão 12× com juros transforma R$ 3.000 em R$ 3.960.</li>
            </ul>
          </div>
        `
      },
      {
        titulo: "9) Selic x CDI x inflação 🏦",
        conteudo: `
          <div class="space-y-4">
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>Selic meta:</strong> âncora para o custo do dinheiro.</li>
              <li><strong>CDI:</strong> taxa entre bancos que remunera CDBs e fundos DI.</li>
              <li><strong>Inflação:</strong> parâmetro para definir se o juro real é positivo.</li>
            </ul>
            <p>Em 2023, Selic 13,75% − IPCA 4,6% ⇒ <strong>juro real ≈ 8,8%</strong> ao ano.</p>
          </div>
        `
      },
      {
        titulo: "10) Rendimento nominal x real 🧮",
        conteudo: `
          <div class="space-y-4">
            <p>Foque no poder de compra, não apenas no número mostrado no extrato.</p>
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>Fórmula:</strong> (1 + rendimento) ÷ (1 + inflação) − 1.</li>
              <li><strong>Exemplo:</strong> CDB 10% com IPCA 5% ⇒ ganho real 4,76%.</li>
              <li><strong>Atenção:</strong> se inflação > rendimento, você está perdendo dinheiro.</li>
            </ul>
          </div>
        `
      },
      {
        titulo: "11) Renda fixa no Brasil 💰",
        conteudo: `
          <div class="space-y-4">
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>Poupança:</strong> simples, mas geralmente abaixo da inflação.</li>
              <li><strong>CDB / LCI / LCA:</strong> remuneram um % do CDI, com ou sem imposto.</li>
              <li><strong>Tesouro Direto:</strong> prefixado, Selic ou IPCA+; ideal para metas específicas.</li>
            </ul>
            <p>Dica: combine liquidez (Tesouro Selic) com metas longas (Tesouro IPCA+).</p>
          </div>
        `
      },
      {
        titulo: "12) Entendendo o Tesouro IPCA+ 📜",
        conteudo: `
          <div class="space-y-4">
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>Pagamento:</strong> juros reais fixos + variação do IPCA.</li>
              <li><strong>Uso ideal:</strong> aposentadoria, faculdade dos filhos, metas acima de 5 anos.</li>
              <li><strong>Exemplo:</strong> investir R$ 10 mil a IPCA + 5% pode virar ~R$ 26 mil em 10 anos se a inflação média for 4%.</li>
            </ul>
            <p>Observe no painel a curva de CDB vs inflação para contextualizar.</p>
          </div>
        `
      },
      {
        titulo: "13) Renda variável: onde está o crescimento 📊",
        conteudo: `
          <div class="space-y-4">
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>Ações:</strong> participação nos lucros e dividendos.</li>
              <li><strong>Fundos imobiliários:</strong> renda mensal com imóveis profissionais.</li>
              <li><strong>ETFs / BDRs:</strong> diversificação instantânea e acesso a empresas globais.</li>
            </ul>
            <p><strong>Exemplo histórico:</strong> Ibovespa multiplicou ~5× entre 2003 e 2010, mas caiu 50% em 2008.</p>
          </div>
        `
      },
      {
        titulo: "14) Risco x Retorno ⚖️",
        conteudo: `
          <div class="space-y-4">
            <p>Retornos altos costumam vir acompanhados de <strong>volatilidade</strong>.</p>
            <div class="grid gap-3 md:grid-cols-2">
              <div class="rounded-xl bg-slate-100 p-4">
                <h3 class="font-semibold">Riscos a considerar</h3>
                <ul class="list-disc ml-5 space-y-1">
                  <li>Mercado: oscilações de preço.</li>
                  <li>Crédito: calote do emissor.</li>
                  <li>Liquidez: dificuldade de vender rápido.</li>
                </ul>
              </div>
              <div class="rounded-xl bg-slate-100 p-4">
                <h3 class="font-semibold">Como mitigar</h3>
                <ul class="list-disc ml-5 space-y-1">
                  <li>Diversificar ativos e prazos.</li>
                  <li>Manter reserva de emergência.</li>
                  <li>Respeitar seu perfil de risco.</li>
                </ul>
              </div>
            </div>
          </div>
        `
      },
      {
        titulo: "15) Diversificação prática 🧺",
        conteudo: `
          <div class="space-y-4">
            <p>Exemplo de carteira equilibrada para objetivos de médio prazo:</p>
            <ul class="list-disc ml-5 space-y-2">
              <li>40% em Tesouro Selic / CDB liquidez diária (reserva).</li>
              <li>30% em Tesouro IPCA+ / debêntures incentivadas (proteção real).</li>
              <li>20% em ações brasileiras / FIIs (renda e crescimento).</li>
              <li>10% em ETFs globais / dólar (proteção cambial).</li>
            </ul>
            <p>Ajuste as proporções conforme idade, renda e tolerância ao risco.</p>
          </div>
        `
      },
      {
        titulo: "16) Trabalho e capital humano 🧑‍🏭",
        conteudo: `
          <div class="space-y-4">
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>Oferta x demanda:</strong> áreas com profissionais escassos pagam mais.</li>
              <li><strong>Upskilling:</strong> cursos, idiomas e tecnologia elevam seu valor.</li>
              <li><strong>Networking:</strong> amplia oportunidades e reduz tempo de desemprego.</li>
            </ul>
            <p>Compare a evolução do salário mínimo com os custos de vida para dimensionar a necessidade de renda adicional.</p>
          </div>
        `
      },
      {
        titulo: "17) Entendendo a mais-valia 💼",
        conteudo: `
          <div class="space-y-4">
            <p>Mais-valia é a diferença entre o valor produzido pelo trabalhador e o salário que ele recebe.</p>
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>Perspectiva do capital:</strong> margem necessária para reinvestir e remunerar o risco.</li>
              <li><strong>Perspectiva do trabalhador:</strong> buscar participação nos resultados, bônus ou sociedade.</li>
              <li><strong>Empreendedorismo:</strong> usar habilidades para capturar parte dessa diferença como dono.</li>
            </ul>
          </div>
        `
      },
      {
        titulo: "18) Empreender em ciclos econômicos 🚀",
        conteudo: `
          <div class="space-y-4">
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>Expansão:</strong> crédito farto → foque em escala e marketing.</li>
              <li><strong>Recessão:</strong> custos apertados → destaque eficiência e valor essencial.</li>
              <li><strong>Alta de juros:</strong> priorize caixa e negocie prazos com fornecedores.</li>
            </ul>
            <p>Exemplo: negócios digitais cresceram durante a pandemia; restaurantes se adaptaram com delivery.</p>
          </div>
        `
      },
      {
        titulo: "19) Indicadores que todo empreendedor monitora 📊",
        conteudo: `
          <div class="space-y-4">
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>Ticket médio:</strong> receita ÷ número de vendas.</li>
              <li><strong>Margem de contribuição:</strong> quanto sobra para pagar despesas fixas.</li>
              <li><strong>Giro de caixa:</strong> tempo entre pagar fornecedores e receber clientes.</li>
              <li><strong>Ponto de equilíbrio:</strong> volume mínimo para não ter prejuízo.</li>
            </ul>
            <p>Use o painel de dados para ilustrar como inflação e juros impactam custos e preços.</p>
          </div>
        `
      },
      {
        titulo: "20) Proteções contra inflação 🛡️",
        conteudo: `
          <div class="space-y-4">
            <ul class="list-disc ml-5 space-y-2">
              <li><strong>Indexados ao IPCA:</strong> Tesouro IPCA+, NTN-B, debêntures incentivadas.</li>
              <li><strong>Ativos reais:</strong> imóveis, FIIs, commodities agrícolas.</li>
              <li><strong>Câmbio:</strong> dólar, ouro, fundos globais para crises internas.</li>
            </ul>
            <p><strong>Checklist:</strong> revise sua carteira anualmente e rebalanceie se o IPCA fugir da meta (3,0% ± 1,5 p.p.).</p>
          </div>
        `
      },
      {
        titulo: "21) Educação financeira é liberdade 🗝️",
        conteudo: `
          <div class="space-y-4">
            <ul class="list-disc ml-5 space-y-2">
              <li>Controle de gastos e orçamento consciente.</li>
              <li>Planejamento de metas de curto, médio e longo prazo.</li>
              <li>Conhecimento de produtos financeiros para escolher melhor.</li>
            </ul>
            <p>Quanto mais você entende o sistema, menos depende de terceiros para tomar decisões.</p>
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
              <li><strong>Escala:</strong> busque novas fontes de renda (freelas, negócios, investimentos em si).</li>
            </ol>
            <p>Revisite o plano a cada 6 meses e ajuste conforme a economia e seus objetivos mudarem.</p>
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