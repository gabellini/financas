export const ANO_INICIO = 1994;
export const ANO_FIM = 2025;
export const ANOS = Array.from({ length: ANO_FIM - ANO_INICIO + 1 }, (_, i) => ANO_INICIO + i);

const SALARIO_MIN = {
  1994: 64, 1995: 100, 1996: 112, 1997: 120, 1998: 130, 1999: 136,
  2000: 151, 2001: 180, 2002: 200, 2003: 240, 2004: 260, 2005: 300,
  2006: 350, 2007: 380, 2008: 415, 2009: 465, 2010: 510, 2011: 545,
  2012: 622, 2013: 678, 2014: 724, 2015: 788, 2016: 880, 2017: 937,
  2018: 954, 2019: 998, 2020: 1045, 2021: 1100, 2022: 1212,
  2023: 1320, 2024: 1412, 2025: 1518
};

const IPCA_ANO_PCT = {
  1994: 916.4,
  1995: 22.41, 1996: 9.56, 1997: 5.22, 1998: 1.65, 1999: 8.94,
  2000: 6.0, 2001: 7.67, 2002: 12.53, 2003: 9.3, 2004: 7.6,
  2005: 5.69, 2006: 3.14, 2007: 4.46, 2008: 5.9, 2009: 4.31,
  2010: 5.91, 2011: 6.5, 2012: 5.84, 2013: 5.91, 2014: 6.41,
  2015: 10.67, 2016: 6.29, 2017: 2.95, 2018: 3.75, 2019: 4.31,
  2020: 4.52, 2021: 10.06, 2022: 5.79, 2023: 4.62, 2024: 4.72,
  2025: 5.13
};

const BIGMAC_ANUAL = {
  1994: null, 1995: null, 1996: null, 1997: null, 1998: null, 1999: null,
  2000: 2.95, 2001: 3.52, 2002: 4.09, 2003: 4.66, 2004: 5.23,
  2005: 5.8, 2006: 6.34, 2007: 6.88, 2008: 7.42, 2009: 7.96,
  2010: 8.5, 2011: 9.58, 2012: 10.66, 2013: 11.74, 2014: 12.82,
  2015: 13.9, 2016: 14.8, 2017: 15.7, 2018: 16.6, 2019: 17.5,
  2020: 19.5, 2021: 21.75, 2022: 24.0, 2023: 25.4, 2024: 26.8, 2025: 28.0
};

const CESTA_SP_ANCHORS = {
  1994: 102.72, 1995: 109.17, 1996: 115.62, 1997: 122.07, 1998: 128.52, 1999: 134.97,
  2000: 141.43, 2001: 161.08, 2002: 180.73, 2003: 200.38, 2004: 220.03, 2005: 239.68,
  2006: 259.33, 2007: 278.98, 2008: 298.63, 2009: 318.28, 2010: 337.93, 2011: 357.58,
  2012: 377.26, 2013: 384.66, 2014: 392.07, 2015: 399.47, 2016: 406.88, 2017: 414.28,
  2018: 483.34, 2019: 552.4, 2020: 621.46, 2021: 690.51, 2022: 791.29,
  2023: 802.38, 2024: 813.46, 2025: 842.26
};

const CARRO_GOL_ANCHORS = {
  1994: 7243.0, 1995: 8802.33, 1996: 10361.67, 1997: 12021.0, 1998: 13680.33, 1999: 15339.67,
  2000: 16599.0, 2001: 17719.1, 2002: 18839.2, 2003: 19959.3, 2004: 21079.4, 2005: 22199.5,
  2006: 23319.6, 2007: 24439.7, 2008: 25559.8, 2009: 26679.9, 2010: 27800.0, 2011: 28765.67,
  2012: 29731.33, 2013: 30697.0, 2014: 31662.67, 2015: 32628.33, 2016: 33594.0, 2017: 37836.0,
  2018: 42078.0, 2019: 46320.0, 2020: 47020.0, 2021: 53260.0, 2022: 59500.0,
  2023: 78160.0, 2024: 78160.0, 2025: 78160.0
};

const CDI_ANUAL_EXEMPLO = {
  1995: 40.0, 1996: 26.0, 1997: 24.0, 1998: 29.0, 1999: 19.0,
  2000: 17.0, 2001: 19.0, 2002: 19.0, 2003: 23.0, 2004: 16.0,
  2005: 19.0, 2006: 15.0, 2007: 12.0, 2008: 13.0, 2009: 9.0,
  2010: 10.0, 2011: 12.0, 2012: 9.0, 2013: 8.0, 2014: 10.0,
  2015: 14.0, 2016: 14.0, 2017: 10.0, 2018: 6.0, 2019: 5.0,
  2020: 3.0, 2021: 4.0, 2022: 13.0, 2023: 12.4, 2024: 10.8, 2025: 10.5
};

export const fmtBR = (v) => (v == null || Number.isNaN(v)
  ? '—'
  : v.toLocaleString('pt-BR', {
      style: 'currency',
      currency: 'BRL',
      maximumFractionDigits: 0
    }));

export const clamp = (value, min, max) => Math.min(Math.max(value, min), max);

function interpLinear(anchors) {
  const out = ANOS.map(() => null);
  Object.entries(anchors).forEach(([yearStr, val]) => {
    const year = Number(yearStr);
    const idx = year - ANO_INICIO;
    if (idx >= 0 && idx < out.length) out[idx] = val;
  });

  let lastIdx = null;
  for (let i = 0; i < out.length; i += 1) {
    if (out[i] != null) {
      if (lastIdx != null && i - lastIdx > 1) {
        const start = out[lastIdx];
        const end = out[i];
        const span = i - lastIdx;
        for (let k = 1; k < span; k += 1) {
          out[lastIdx + k] = start + (end - start) * (k / span);
        }
      }
      lastIdx = i;
    }
  }

  if (lastIdx != null) {
    for (let i = lastIdx + 1; i < out.length; i += 1) {
      out[i] = out[lastIdx];
    }
  }

  const firstIdx = out.findIndex((val) => val != null);
  if (firstIdx > 0) {
    for (let i = 0; i < firstIdx; i += 1) {
      out[i] = out[firstIdx];
    }
  }

  return out;
}

function ipcaAcumulado() {
  const serie = [];
  let acumulado = 100;
  ANOS.forEach((ano) => {
    const percentual = (ano === 1994 ? 0 : (IPCA_ANO_PCT[ano] ?? 0)) / 100;
    acumulado *= (1 + percentual);
    serie.push(acumulado);
  });
  return serie;
}

function curvaCDB100(cdiMap) {
  let valor = 1000;
  const serie = [];
  ANOS.forEach((ano) => {
    const taxa = (cdiMap[ano] ?? cdiMap[Object.keys(cdiMap)[0]]) / 100;
    valor *= (1 + taxa);
    serie.push(valor);
  });
  return serie;
}

function curvaPoupancaMedia() {
  let valor = 1000;
  const serie = [];
  ANOS.forEach(() => {
    valor *= 1.06;
    serie.push(valor);
  });
  return serie;
}

function curvaBolsaSimulada() {
  let valor = 1000;
  const serie = [];
  const drift = 0.11;
  const vol = 0.18;
  ANOS.forEach(() => {
    const ruido = (Math.random() * 2 - 1) * vol;
    valor = Math.max(valor * (1 + drift + ruido), 0);
    serie.push(valor);
  });
  return serie;
}

export function montarSeries() {
  const salario = ANOS.map((ano) => SALARIO_MIN[ano] ?? null);
  const ipca = ipcaAcumulado();
  const bigmac = ANOS.map((ano) => BIGMAC_ANUAL[ano] ?? null);
  const cesta = interpLinear(CESTA_SP_ANCHORS);
  const carro = interpLinear(CARRO_GOL_ANCHORS);
  const poupanca = curvaPoupancaMedia();
  const cdb = curvaCDB100(CDI_ANUAL_EXEMPLO);
  const bolsa = curvaBolsaSimulada();
  return { anos: ANOS, salario, ipca, cesta, carro, bigmac, poupanca, cdb, bolsa };
}
