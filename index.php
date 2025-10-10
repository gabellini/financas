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
  <div class="max-w-[1280px] mx-auto p-4">
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

    <div id="headerReturn" class="hidden flex justify-end mb-4">
      <button id="btnShowHeader" class="btn" title="Mostrar cabeçalho">⬇ Mostrar cabeçalho</button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
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
    titulo: "1) O que é dinheiro? 💵",
    conteudo: `
      <p>Dinheiro é uma <strong>ferramenta de troca</strong>. Ele permite comprar bens e serviços sem precisar trocar algo diretamente.</p>
      <p>Para ter valor, o dinheiro precisa ser <strong>aceito por todos</strong> e <strong>escasso</strong>. O governo controla sua emissão e o Banco Central cuida da estabilidade da moeda.</p>
      <p>Exemplo: se o governo imprime demais, o dinheiro perde valor — é o início da inflação.</p>
    `
  },
  {
    titulo: "2) Inflação 📈",
    conteudo: `
      <p>Inflação é o aumento <strong>geral e contínuo dos preços</strong>. Ela reduz o poder de compra do seu dinheiro.</p>
      <p>Exemplo: se o Big Mac custava R$5 e hoje custa R$25, o mesmo dinheiro compra menos — você empobreceu sem perceber.</p>
      <p>O índice mais conhecido é o <strong>IPCA</strong>, calculado pelo IBGE. Ele mede a variação média de uma cesta de produtos e serviços.</p>
    `
  },
  {
    titulo: "3) Causas da inflação 💡",
    conteudo: `
      <ul class="list-disc ml-5">
        <li><strong>Demanda maior que a oferta:</strong> muita gente comprando e poucos produtos disponíveis.</li>
        <li><strong>Custos de produção sobem:</strong> energia, insumos ou salário aumentam.</li>
        <li><strong>Expectativa:</strong> empresas sobem preços “por medo” da inflação futura.</li>
        <li><strong>Política monetária frouxa:</strong> juros muito baixos e crédito fácil.</li>
      </ul>
    `
  },
  {
    titulo: "4) Juros: o preço do dinheiro ⏳",
    conteudo: `
      <p>Juros são o <strong>preço do tempo</strong>. Quando você pega dinheiro emprestado, paga juros; quando empresta (investe), recebe juros.</p>
      <p>Juros altos desestimulam o consumo e controlam a inflação. Juros baixos estimulam o consumo e o investimento.</p>
      <p>No Brasil, a taxa básica é a <strong>Selic</strong>, definida pelo Banco Central.</p>
    `
  },
  {
    titulo: "5) Selic e CDI 🏦",
    conteudo: `
      <p><strong>Selic</strong> é a taxa de juros oficial. O <strong>CDI</strong> é a taxa de referência entre bancos e segue a Selic de perto.</p>
      <p>Quando você investe em um <strong>CDB</strong>, ele rende um percentual do CDI. Por isso, entender juros é entender quanto seu dinheiro pode crescer.</p>
    `
  },
  {
    titulo: "6) Renda fixa 💰",
    conteudo: `
      <p>Renda fixa é quando você já sabe (ou consegue prever) quanto vai ganhar. Exemplos:</p>
      <ul class="list-disc ml-5">
        <li><strong>Poupança:</strong> baixo rendimento, mas simples e com liquidez.</li>
        <li><strong>CDB:</strong> empresta dinheiro ao banco e recebe juros (geralmente % do CDI).</li>
        <li><strong>Tesouro Direto:</strong> empresta dinheiro ao governo. É o investimento mais seguro do país.</li>
      </ul>
      <p>Mesmo com segurança, é importante <strong>rendimento real</strong> — ganhar acima da inflação.</p>
    `
  },
  {
    titulo: "7) Rendimento real 🧮",
    conteudo: `
      <p>O que importa não é o quanto o investimento paga, mas o quanto <strong>sobra depois da inflação</strong>.</p>
      <p>Exemplo: se seu CDB rende 10% e a inflação é 5%, seu ganho real é de 4,76%.</p>
      <p>Rendimento real = ((1 + rendimento) / (1 + inflação)) − 1</p>
    `
  },
  {
    titulo: "8) Renda variável 📊",
    conteudo: `
      <p>Na renda variável, o retorno depende do mercado. Você pode ganhar muito — ou perder.</p>
      <ul class="list-disc ml-5">
        <li><strong>Ações:</strong> pedaços de empresas.</li>
        <li><strong>Fundos imobiliários:</strong> cotas de investimentos em imóveis.</li>
        <li><strong>ETFs:</strong> fundos que replicam índices, como o Ibovespa.</li>
      </ul>
      <p>Ideal para quem pensa no longo prazo e aceita oscilações.</p>
    `
  },
  {
    titulo: "9) Risco e diversificação ⚖️",
    conteudo: `
      <p>Todo investimento tem risco. A estratégia é <strong>não colocar todos os ovos na mesma cesta</strong>.</p>
      <p>Diversificar = reduzir o impacto de uma perda isolada.</p>
      <p>Uma carteira equilibrada mistura renda fixa, variável e reserva de emergência.</p>
    `
  },
  {
    titulo: "10) Oferta e demanda no trabalho 🧑‍🏭",
    conteudo: `
      <p>O mercado de trabalho também segue <strong>oferta e demanda</strong>:</p>
      <ul class="list-disc ml-5">
        <li>Se há poucos profissionais qualificados → salário sobe.</li>
        <li>Se há muitos → salário cai.</li>
      </ul>
      <p>Investir em capacitação é uma forma de “subir de preço” no mercado.</p>
    `
  },
  {
    titulo: "11) Mais-valia 💼",
    conteudo: `
      <p><strong>Mais-valia</strong> é o conceito criado por Karl Marx: a diferença entre o valor que o trabalhador produz e o que recebe.</p>
      <p>Se você gera R$10.000 em valor para a empresa e recebe R$3.000, a diferença (R$7.000) é o lucro do capital.</p>
      <p>Entender isso ajuda a pensar em como <strong>capturar parte do valor que você gera</strong> — seja negociando melhor ou empreendendo.</p>
    `
  },
  {
    titulo: "12) Política monetária e Banco Central 🏛️",
    conteudo: `
      <p>O Banco Central regula o volume de dinheiro e os juros para controlar a inflação.</p>
      <ul class="list-disc ml-5">
        <li>Se os preços sobem, ele <strong>aumenta juros</strong> → crédito mais caro → consumo cai.</li>
        <li>Se a economia desacelera, ele <strong>baixa juros</strong> → crédito barato → economia aquece.</li>
      </ul>
    `
  },
  {
    titulo: "13) Câmbio e dólar 💵🌎",
    conteudo: `
      <p>O valor do dólar afeta tudo: combustível, alimentos, eletrônicos. Isso porque o Brasil importa muitos produtos.</p>
      <p>Quando o dólar sobe, a inflação tende a subir também. Investidores buscam proteção com <strong>dólar, ouro ou fundos cambiais</strong>.</p>
    `
  },
  {
    titulo: "14) PIB e crescimento econômico 📊",
    conteudo: `
      <p>PIB é o <strong>Produto Interno Bruto</strong>: soma de tudo que o país produz. Quando cresce, o país gera mais empregos e renda.</p>
      <p>Crescimento sustentável depende de investimento, produtividade e estabilidade.</p>
    `
  },
  {
    titulo: "15) Como não perder para a inflação 🛡️",
    conteudo: `
      <p>1️⃣ Tenha uma reserva de emergência (3–6 meses de gastos).<br>2️⃣ Invista o que sobrar em aplicações que superem a inflação (CDB, Tesouro IPCA, fundos).<br>3️⃣ Evite deixar dinheiro parado em conta.</p>
      <p>Dinheiro sem rentabilidade é dinheiro perdendo valor.</p>
    `
  },
  {
    titulo: "16) Educação financeira é liberdade 🗝️",
    conteudo: `
      <p>Aprender a lidar com o dinheiro é ganhar <strong>liberdade de escolha</strong>.</p>
      <p>Quem entende juros, inflação e investimento não depende de sorte — constrói seu próprio caminho.</p>
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
  <footer class="max-w-[1280px] mx-auto p-4 text-xs text-slate-500">
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