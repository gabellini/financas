<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Aula: Empreendedorismo na prática</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/theme.css" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="text-slate-100">
  <div class="max-w-5xl mx-auto px-4 py-6 xl:px-8 space-y-6">
    <header class="glass-panel px-4 py-4 lg:px-6 lg:py-4 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
      <div class="header-brand flex items-center gap-3 w-full lg:w-auto">
        <div class="header-brand__badge">AF</div>
        <div class="min-w-0">
          <h1 class="header-title text-lg sm:text-xl font-extrabold text-slate-100">Aula especial: Empreendedorismo</h1>
          <p class="header-subtitle text-xs sm:text-sm text-slate-400">Prática, conceitos-chave e bastidores da minha trajetória</p>
        </div>
      </div>
      <nav class="header-controls" aria-label="Navegação secundária">
        <div class="header-controls__surface">
          <div class="header-controls__group header-controls__group--stack">
            <a href="index.php" class="btn btn-header">
              <span class="btn-header__icon" aria-hidden="true">🏠</span>
              <span class="btn-header__label">Voltar à linha do tempo</span>
            </a>
            <a href="quizz.php" class="btn btn-header">
              <span class="btn-header__icon" aria-hidden="true">🎯</span>
              <span class="btn-header__label">Quiz interativo</span>
            </a>
          </div>
        </div>
      </nav>
    </header>

    <section class="glass-panel p-5 lg:p-7 space-y-6">
      <div class="flex flex-col gap-3">
        <p class="text-sm text-emerald-300 font-semibold uppercase tracking-[0.18em]">Bastidores</p>
        <h2 class="text-3xl font-black tracking-tight">Minha jornada empreendedora</h2>
        <p class="text-slate-300 text-lg leading-relaxed">Comecei empreendendo por necessidade: freelas de design aos 17 anos, agência digital aos 21, e depois uma plataforma SaaS B2B focada em dados de mercado. Cresci bootstrapped, reinvestindo lucro, errando em planejamento de produto e aprendendo a vender. O que deu certo: ouvir clientes toda semana, criar um processo comercial repetível e manter caixa de 12 meses para suportar ciclos longos.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="p-4 border border-slate-800/80 rounded-2xl bg-slate-900/60 space-y-3">
          <h3 class="font-semibold text-lg">Linha do tempo BetaLabs</h3>
          <ul class="list-disc ml-5 text-sm text-slate-300 space-y-2">
            <li><strong>2010:</strong> fundação ainda na faculdade, depois de freelas de sistemas e e-commerce.</li>
            <li><strong>2011-2013:</strong> primeiras integrações, foco em resolver o backoffice para lojistas.</li>
            <li><strong>2014:</strong> equipe cresce para atender novos contratos, empresa aparece na mídia e em listas de jovens empreendedores.</li>
          </ul>
          <p class="text-xs text-slate-400">Recortes das matérias anexadas mostram a dupla Felipe Cataldi e Luan Gabellini recebendo destaque nacional e contratando para acompanhar a demanda.</p>
        </div>
        <div class="p-4 border border-slate-800/80 rounded-2xl bg-slate-900/60 space-y-3">
          <h3 class="font-semibold text-lg">O que sustentou o crescimento</h3>
          <ul class="list-disc ml-5 text-sm text-slate-300 space-y-2">
            <li>Metas claras e compartilhadas com o time.</li>
            <li>Releases curtos e feedback constante dos clientes.</li>
            <li>Contratações alinhadas à entrada de receita.</li>
            <li>Reinvestimento dos lucros em marketing e produto.</li>
          </ul>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="metric-card p-4 space-y-2">
          <div class="kpi">Primeiro salto</div>
          <p class="text-slate-300 text-sm">2013 → primeiros contratos recorrentes. Aprendi a diferenciar projeto pontual de assinatura.</p>
        </div>
        <div class="metric-card p-4 space-y-2">
          <div class="kpi">Virada para produto</div>
          <p class="text-slate-300 text-sm">2017 → MVP SaaS lançado em 60 dias; cobrou desde o primeiro dia para validar valor.</p>
        </div>
        <div class="metric-card p-4 space-y-2">
          <div class="kpi">Escala sustentável</div>
          <p class="text-slate-300 text-sm">2021 → equipe enxuta (8 pessoas), ticket médio 3x maior, churn &lt; 3% ao mês.</p>
        </div>
      </div>
    </section>

    <section class="glass-panel p-5 lg:p-7 space-y-6">
      <div class="flex items-center justify-between flex-wrap gap-2">
        <h2 class="text-2xl font-bold tracking-tight">Pilares que aprendi na prática</h2>
        <span class="tag">Guia de campo</span>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <article class="p-4 border border-slate-800/80 rounded-2xl bg-slate-900/60 space-y-3">
          <h3 class="font-semibold text-lg">Problema real &gt; ideia brilhante</h3>
          <p class="text-sm text-slate-300 leading-relaxed">Escolha um problema que dói, que as pessoas pagam para resolver. Valide cobrando cedo: entrevistas semanais, protótipos rápidos e uma landing page com botão de pagamento.</p>
          <ul class="list-disc ml-5 text-sm text-slate-400 space-y-2">
            <li>Defina uma persona clara e o momento de uso.</li>
            <li>Mensagens de venda devem falar do ganho (tempo, dinheiro, status).</li>
            <li>Métricas: % de conversão, LTV/CAC, payback.</li>
          </ul>
        </article>
        <article class="p-4 border border-slate-800/80 rounded-2xl bg-slate-900/60 space-y-3">
          <h3 class="font-semibold text-lg">Produto enxuto e iterativo</h3>
          <p class="text-sm text-slate-300 leading-relaxed">Construa o menor produto que entrega o resultado principal. Entregue, ouça, corrija. Cada ciclo precisa gerar aprendizado ou receita.</p>
          <ul class="list-disc ml-5 text-sm text-slate-400 space-y-2">
            <li>Roadmap em 3 horizontes: agora, próximo, depois.</li>
            <li>Feature flag para testar sem quebrar tudo.</li>
            <li>Doc curto de lançamento: problema, solução, como medir.</li>
          </ul>
        </article>
        <article class="p-4 border border-slate-800/80 rounded-2xl bg-slate-900/60 space-y-3">
          <h3 class="font-semibold text-lg">Vendas como processo</h3>
          <p class="text-sm text-slate-300 leading-relaxed">Pipeline simples: prospecção → diagnóstico → demo → proposta → follow-up. Use script, CRM leve e acompanhe taxas de conversão por etapa.</p>
          <ul class="list-disc ml-5 text-sm text-slate-400 space-y-2">
            <li>Clareza de ICP define quem você recusa.</li>
            <li>Storytelling de caso real vence pitch genérico.</li>
            <li>Melhorar follow-up aumenta receita mais rápido que lançar nova feature.</li>
          </ul>
        </article>
        <article class="p-4 border border-slate-800/80 rounded-2xl bg-slate-900/60 space-y-3">
          <h3 class="font-semibold text-lg">Finanças e caixa</h3>
          <p class="text-sm text-slate-300 leading-relaxed">Caixa de 6–12 meses evita decisões ruins. Separe contas pessoais, acompanhe DRE mensal, e faça cenário pessimista antes de contratar.</p>
          <ul class="list-disc ml-5 text-sm text-slate-400 space-y-2">
            <li>Preço precisa cobrir suporte, aquisição e imposto.</li>
            <li>Negocie prazo com fornecedor, não com cliente.</li>
            <li>Reserva de emergência do negócio é tão importante quanto a pessoal.</li>
          </ul>
        </article>
      </div>
    </section>

    <section class="glass-panel p-5 lg:p-7 space-y-5">
      <div class="flex items-center justify-between flex-wrap gap-2">
        <h2 class="text-2xl font-bold tracking-tight">Checklist rápido para lançar</h2>
        <span class="tag">Use antes de ir para a rua</span>
      </div>
      <ol class="list-decimal ml-6 space-y-3 text-sm text-slate-200">
        <li>Problema validado com pelo menos 5 conversas pagantes ou cartas de intenção.</li>
        <li>Landing page com proposta de valor clara, preço e chamada para ação.</li>
        <li>MVP funcional que entrega o resultado principal (nem que seja manual nos bastidores).</li>
        <li>Roteiro de vendas de 5 minutos e material de apoio (deck ou demo gravada).</li>
        <li>Plano financeiro com cenários: base, otimista e pessimista.</li>
        <li>Métrica de sucesso para os primeiros 30 dias (ex.: 20 clientes ativos, NPS &gt; 50).</li>
      </ol>
    </section>

    <section class="glass-panel p-5 lg:p-7 space-y-5">
      <div class="flex items-center justify-between flex-wrap gap-3">
        <h2 class="text-2xl font-bold tracking-tight">Frameworks favoritos</h2>
        <span class="tag">Aplicáveis hoje</span>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="p-4 border border-slate-800/80 rounded-2xl bg-slate-900/60 space-y-2">
          <h3 class="font-semibold">Momento → Ação → Métrica</h3>
          <p class="text-sm text-slate-300 leading-relaxed">Para cada etapa da jornada do cliente, defina qual ação você quer e como vai medir. Ajuda a priorizar funcionalidades e campanhas.</p>
        </div>
        <div class="p-4 border border-slate-800/80 rounded-2xl bg-slate-900/60 space-y-2">
          <h3 class="font-semibold">Jobs To Be Done</h3>
          <p class="text-sm text-slate-300 leading-relaxed">Entenda o "trabalho" que o cliente quer resolver. Foque no progresso que ele busca, não apenas no perfil demográfico.</p>
        </div>
        <div class="p-4 border border-slate-800/80 rounded-2xl bg-slate-900/60 space-y-2">
          <h3 class="font-semibold">Flywheel enxuto</h3>
          <p class="text-sm text-slate-300 leading-relaxed">Entregue valor rápido → peça depoimento → use na venda → invista em produto que acelera entrega de valor. Repetir.</p>
        </div>
      </div>
    </section>

    <footer class="text-xs text-slate-500 pb-6 text-center">
      <p>Conteúdo prático criado para complementar a aula interativa de finanças. Atualizado em 2025.</p>
    </footer>
  </div>
</body>
</html>
