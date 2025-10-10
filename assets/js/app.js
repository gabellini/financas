import { montarSeries, fmtBR, clamp } from './data.js';
import { slides } from './slides.js';

const state = {
  series: null,
  playing: false,
  timer: null,
  speed: 1000,
  i: 0,
  escalaLog: false
};

let chart;
let slideIdx = 0;

function atualizarKPIs() {
  const { series, i } = state;
  const ano = series.anos[i];
  document.getElementById('anoAtual').textContent = ano;

  const sal = series.salario[i];
  const cesta = series.cesta[i];
  const carro = series.carro[i];
  const big = series.bigmac[i];
  const inflAcum = ((series.ipca[i] / 100) - 1) * 100;
  const poderCompra = sal && cesta ? (sal / cesta) * 100 : null;

  document.getElementById('kpiSalario').textContent = fmtBR(sal);
  document.getElementById('kpiInflacao').textContent = Number.isFinite(inflAcum) ? `${inflAcum.toFixed(0)}%` : '—';
  document.getElementById('kpiCesta').textContent = fmtBR(cesta);
  document.getElementById('kpiCarro').textContent = fmtBR(carro);
  document.getElementById('kpiBigmac').textContent = big == null ? '—' : fmtBR(big);
  document.getElementById('kpiPoupanca').textContent = fmtBR(series.poupanca[i]);
  document.getElementById('kpiCDB').textContent = fmtBR(series.cdb[i]);
  document.getElementById('kpiBolsa').textContent = fmtBR(series.bolsa[i]);
  document.getElementById('kpiPoderCompra').textContent = poderCompra == null ? '—' : poderCompra.toFixed(0);

  const pct = (i / (series.anos.length - 1)) * 100;
  document.getElementById('barra').style.width = `${pct}%`;
}

function initChart() {
  const canvas = document.getElementById('chart');
  if (!canvas) return;
  if (chart) chart.destroy();

  const toRGBA = (hex, alpha = 1) => {
    const clean = hex.replace('#', '');
    const bigint = parseInt(clean, 16);
    const r = (bigint >> 16) & 255;
    const g = (bigint >> 8) & 255;
    const b = bigint & 255;
    return `rgba(${r}, ${g}, ${b}, ${alpha})`;
  };

  const datasetStyles = [
    { label: 'Salário (R$)', data: state.series.salario, color: '#38bdf8' },
    { label: 'Cesta (R$)', data: state.series.cesta, color: '#f59e0b' },
    { label: 'Big Mac (R$)', data: state.series.bigmac, color: '#f97316', dashed: [6, 4] },
    { label: 'Carro (R$)', data: state.series.carro, color: '#a855f7', axis: 'yCar' },
    { label: 'Poupança (R$)', data: state.series.poupanca, color: '#0ea5e9', axis: 'yInv', dashed: [4, 3] },
    { label: 'CDB (R$)', data: state.series.cdb, color: '#22c55e', axis: 'yInv' },
    { label: 'Bolsa (R$)', data: state.series.bolsa, color: '#ef4444', axis: 'yInv', dashed: [5, 4] }
  ];

  const textColor = '#cbd5f5';
  const gridColor = 'rgba(148, 163, 184, 0.14)';
  const zeroLineColor = 'rgba(148, 163, 184, 0.28)';
  const axisTitleColor = '#94a3b8';

  Chart.defaults.font.family = "'Inter', 'Segoe UI', sans-serif";

  chart = new Chart(canvas, {
    type: 'line',
    data: {
      labels: state.series.anos,
      datasets: datasetStyles.map((item) => ({
        label: item.label,
        data: item.data,
        yAxisID: item.axis || 'y',
        borderWidth: 2.5,
        borderColor: item.color,
        backgroundColor: toRGBA(item.color, 0.18),
        tension: 0.32,
        spanGaps: true,
        pointRadius: 0,
        pointHoverRadius: 5,
        borderCapStyle: 'round',
        borderJoinStyle: 'round',
        fill: false,
        segment: item.dashed ? { borderDash: item.dashed } : undefined
      }))
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      layout: {
        padding: {
          top: 18,
          right: 18,
          bottom: 12,
          left: 8
        }
      },
      plugins: {
        legend: {
          position: 'bottom',
          align: 'center',
          labels: {
            color: textColor,
            usePointStyle: true,
            pointStyle: 'circle',
            boxWidth: 9,
            padding: 18,
            font: {
              size: 12,
              weight: '600'
            }
          }
        },
        tooltip: {
          mode: 'index',
          intersect: false,
          backgroundColor: 'rgba(15, 23, 42, 0.92)',
          borderColor: 'rgba(14, 165, 233, 0.35)',
          borderWidth: 1,
          titleColor: '#f8fafc',
          bodyColor: '#e2e8f0',
          titleFont: {
            weight: '700'
          },
          bodyFont: {
            weight: '500'
          },
          padding: 12,
          callbacks: {
            label: (ctx) => {
              const value = ctx.parsed.y;
              if (value == null) return ctx.dataset.label;
              return `${ctx.dataset.label}: R$ ${Number(value).toLocaleString('pt-BR', {
                maximumFractionDigits: value >= 1000 ? 0 : 2
              })}`;
            }
          }
        }
      },
      interaction: { mode: 'index', intersect: false },
      scales: {
        x: {
          ticks: {
            color: textColor,
            maxRotation: 0,
            autoSkipPadding: 16
          },
          grid: {
            color: gridColor,
            drawBorder: false
          },
          title: {
            display: true,
            text: 'Ano',
            color: axisTitleColor,
            padding: { top: 12 },
            font: {
              size: 12,
              weight: '600'
            }
          }
        },
        y: {
          type: state.escalaLog ? 'logarithmic' : 'linear',
          position: 'left',
          ticks: {
            color: textColor,
            callback: (v) => `R$ ${Number(v).toLocaleString('pt-BR', { maximumFractionDigits: 0 })}`
          },
          grid: {
            color: (ctx) => (ctx.tick.value === 0 ? zeroLineColor : gridColor),
            drawBorder: false
          },
          title: {
            display: true,
            text: 'Consumo e salário',
            color: axisTitleColor,
            font: {
              size: 12,
              weight: '600'
            }
          }
        },
        yCar: {
          type: state.escalaLog ? 'logarithmic' : 'linear',
          position: 'right',
          ticks: {
            color: textColor,
            callback: (v) => `R$ ${Number(v).toLocaleString('pt-BR', { maximumFractionDigits: 0 })}`
          },
          grid: { drawOnChartArea: false },
          title: {
            display: true,
            text: 'Bens duráveis',
            color: axisTitleColor,
            font: {
              size: 12,
              weight: '600'
            }
          }
        },
        yInv: {
          type: state.escalaLog ? 'logarithmic' : 'linear',
          position: 'right',
          grid: { drawOnChartArea: false },
          display: false
        }
      }
    }
  });
}

function atualizarChartAteI() {
  if (!chart) return;
  const { i, series } = state;
  const cortes = (arr) => arr.slice(0, i + 1);
  chart.data.labels = series.anos.slice(0, i + 1);
  chart.data.datasets.forEach((dataset, idx) => {
    const origem = [
      series.salario,
      series.cesta,
      series.bigmac,
      series.carro,
      series.poupanca,
      series.cdb,
      series.bolsa
    ][idx];
    dataset.data = cortes(origem);
  });
  chart.update('none');
  const slider = document.getElementById('sliderAno');
  if (slider) slider.value = String(i);
}

function renderSlide(idx) {
  const el = document.getElementById('slides');
  if (!el) return;
  const slide = slides[idx];
  el.innerHTML = `<h2 class="text-2xl font-extrabold mb-3 text-slate-100">${slide.titulo}</h2><div class="space-y-4 text-slate-200 leading-relaxed">${slide.conteudo}</div>`;
  document.getElementById('slidePos').textContent = String(idx + 1);
  document.getElementById('slideTotal').textContent = String(slides.length);
}

function stepForward() {
  if (state.i < state.series.anos.length - 1) {
    state.i += 1;
    atualizarKPIs();
    atualizarChartAteI();
  } else {
    togglePlay(false);
  }
}

function togglePlay(go) {
  state.playing = go !== undefined ? go : !state.playing;
  clearInterval(state.timer);
  if (state.playing) {
    state.timer = setInterval(stepForward, state.speed);
  }
  document.getElementById('modoTag').textContent = state.playing
    ? 'Reproduzindo'
    : 'Dados reais + investimentos simulados';
}

function resetTudo() {
  state.i = 0;
  atualizarKPIs();
  atualizarChartAteI();
  togglePlay(false);
  document.getElementById('modoTag').textContent = 'Dados reais + investimentos simulados';
}

function setupHeaderMenu() {
  const toggleBtn = document.getElementById('toggleHeaderMenu');
  const controls = document.getElementById('headerControls');
  if (!toggleBtn || !controls) return;

  controls.dataset.mobileOpen = 'false';
  toggleBtn.setAttribute('aria-expanded', 'false');

  const mq = window.matchMedia('(min-width: 1024px)');

  const syncVisibility = () => {
    if (mq.matches) {
      controls.classList.remove('hidden');
      toggleBtn.setAttribute('aria-expanded', 'true');
    } else {
      const open = controls.dataset.mobileOpen === 'true';
      controls.classList.toggle('hidden', !open);
      toggleBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
    }
  };

  toggleBtn.addEventListener('click', () => {
    const isHidden = controls.classList.toggle('hidden');
    const open = !isHidden;
    controls.dataset.mobileOpen = open ? 'true' : 'false';
    toggleBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
  });

  mq.addEventListener('change', syncVisibility);
  syncVisibility();
}

function boot() {
  state.series = montarSeries();
  initChart();
  atualizarKPIs();
  atualizarChartAteI();
  renderSlide(slideIdx);

  const slider = document.getElementById('sliderAno');
  slider.max = String(state.series.anos.length - 1);
  slider.value = '0';
  slider.addEventListener('input', (e) => {
    state.i = Number(e.target.value);
    atualizarKPIs();
    atualizarChartAteI();
  });

  const setAno = (delta) => {
    state.i = clamp(state.i + delta, 0, state.series.anos.length - 1);
    atualizarKPIs();
    atualizarChartAteI();
  };

  document.getElementById('anoMenos5').addEventListener('click', () => setAno(-5));
  document.getElementById('anoMenos').addEventListener('click', () => setAno(-1));
  document.getElementById('anoMais').addEventListener('click', () => setAno(1));
  document.getElementById('anoMais5').addEventListener('click', () => setAno(5));

  window.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowUp') setAno(1);
    if (e.key === 'ArrowDown') setAno(-1);
    if (e.key === 'ArrowRight') document.getElementById('nextSlide').click();
    if (e.key === 'ArrowLeft') document.getElementById('prevSlide').click();
  });

  document.getElementById('speed').addEventListener('change', (e) => {
    state.speed = Number(e.target.value);
    if (state.playing) togglePlay(true);
  });

  document.getElementById('chkLog').addEventListener('change', (e) => {
    state.escalaLog = e.target.checked;
    initChart();
    atualizarChartAteI();
  });

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

  document.getElementById('nextSlide').addEventListener('click', () => {
    slideIdx = (slideIdx + 1) % slides.length;
    renderSlide(slideIdx);
  });
  document.getElementById('prevSlide').addEventListener('click', () => {
    slideIdx = (slideIdx - 1 + slides.length) % slides.length;
    renderSlide(slideIdx);
  });

  const dlg = document.getElementById('dlgDados');
  if (dlg) {
    const btnDados = document.getElementById('btnDados');
    if (btnDados) {
      btnDados.addEventListener('click', () => dlg.showModal());
    }

    const areaJson = document.getElementById('areaJson');
    const btnImport = document.getElementById('btnImport');
    const btnExport = document.getElementById('btnExport');

    if (btnImport && areaJson) {
      btnImport.addEventListener('click', () => {
        try {
          const obj = JSON.parse(areaJson.value);
          if (!obj.anos) throw new Error('JSON deve conter a chave "anos".');
          state.series = obj;
          state.i = 0;
          initChart();
          atualizarKPIs();
          atualizarChartAteI();
          document.getElementById('modoTag').textContent = 'Dados importados (reais)';
        } catch (err) {
          alert(`Falha ao importar JSON: ${err.message}`);
        }
      });
    }

    if (btnExport && areaJson) {
      btnExport.addEventListener('click', () => {
        areaJson.value = JSON.stringify(state.series, null, 2);
      });
    }
  }

  setupHeaderMenu();
}

document.addEventListener('DOMContentLoaded', boot);
