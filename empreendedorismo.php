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
          <p class="header-subtitle text-xs sm:text-sm text-slate-400">Conteúdo pensado para jovens de 17 anos, com exemplos reais e linguagem prática.</p>
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

    <section class="glass-panel p-5 lg:p-7 space-y-5">
      <div class="flex flex-wrap gap-3 items-center justify-between">
        <div>
          <p class="text-xs uppercase tracking-[0.18em] text-emerald-300 font-semibold">Trilha guiada</p>
          <h2 class="text-3xl font-black tracking-tight">Slides interativos de empreendedorismo</h2>
          <p class="text-slate-300 text-sm mt-1">Passeie pelos 10 slides: ao abrir, você já está no primeiro. Cada um tem ação rápida para tirar a ideia do papel.</p>
        </div>
        <div class="flex items-center gap-2 text-sm text-slate-400">
          <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-900/50 border border-emerald-500/30 text-emerald-100 font-semibold">🔥 Dinâmico</span>
          <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-slate-900/70 border border-slate-700 text-slate-200">10+ slides</span>
        </div>
      </div>

      <div class="space-y-4">
        <div class="w-full bg-slate-900/60 border border-slate-800 rounded-2xl p-3">
          <div class="flex items-center justify-between text-sm text-slate-300">
            <span id="slideLabel" class="font-semibold">Slide 1 de 10</span>
            <span id="slideMood" class="text-emerald-300 font-semibold">Começando agora</span>
          </div>
          <div class="mt-3 h-2 bg-slate-800 rounded-full overflow-hidden">
            <div id="slideProgress" class="h-full bg-gradient-to-r from-emerald-400 to-cyan-400 rounded-full transition-all duration-500" style="width: 0%;"></div>
          </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-4">
          <article class="p-5 border border-slate-800/80 rounded-2xl bg-slate-900/60 space-y-4 shadow-lg shadow-emerald-900/20">
            <header class="space-y-1">
              <p id="slideTag" class="text-xs uppercase tracking-[0.14em] text-emerald-300 font-semibold">Ação</p>
              <h3 id="slideTitle" class="text-2xl font-bold">Título do slide</h3>
              <p id="slideSummary" class="text-slate-300 text-sm leading-relaxed">Resumo do slide aparece aqui.</p>
            </header>
            <div>
              <h4 class="text-sm font-semibold text-slate-200 uppercase tracking-[0.08em]">Pontos-chave</h4>
              <ul id="slideBullets" class="mt-2 space-y-2 list-disc ml-5 text-slate-300 text-sm"></ul>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
              <div class="p-3 rounded-xl border border-emerald-500/25 bg-emerald-950/40">
                <div class="text-xs uppercase tracking-[0.14em] text-emerald-300 font-semibold">Desafio rápido</div>
                <p id="slideAction" class="text-sm text-slate-100 mt-1">Ação prática do slide.</p>
                <button id="actionButton" class="mt-3 inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-emerald-500 text-slate-900 font-semibold text-sm hover:bg-emerald-400 transition">Marcar como concluído</button>
              </div>
              <div class="p-3 rounded-xl border border-slate-700 bg-slate-950/40 space-y-2">
                <div class="text-xs uppercase tracking-[0.14em] text-cyan-300 font-semibold">Guarda-ideias</div>
                <label for="anotacoes" class="text-xs text-slate-400">Anote insights e tarefas. O texto fica salvo enquanto você estiver aqui.</label>
                <textarea id="anotacoes" class="w-full mt-1 rounded-lg bg-slate-900 border border-slate-700 text-slate-100 text-sm p-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" rows="4" placeholder="Escreva o que não quer esquecer"></textarea>
              </div>
            </div>
          </article>

          <aside class="p-4 border border-slate-800/80 rounded-2xl bg-slate-900/60 space-y-4">
            <div class="flex items-center justify-between">
              <h4 class="text-sm font-semibold uppercase tracking-[0.1em] text-slate-200">Navegação</h4>
              <div class="flex items-center gap-2">
                <button id="prevSlide" class="px-3 py-2 rounded-lg border border-slate-700 text-slate-200 hover:border-emerald-400 hover:text-emerald-100 transition text-sm">Anterior</button>
                <button id="nextSlide" class="px-3 py-2 rounded-lg bg-emerald-500 text-slate-900 font-semibold text-sm hover:bg-emerald-400 transition">Próximo</button>
              </div>
            </div>
            <div class="space-y-3 text-sm text-slate-300">
              <p class="text-slate-200 font-semibold">Dicas para aproveitar</p>
              <ul class="list-disc ml-5 space-y-2">
                <li>Cada slide traz uma ação que você consegue testar em menos de 15 minutos.</li>
                <li>Linguagem direta para quem está terminando o ensino médio e quer começar já.</li>
                <li>Exemplos reais como a BetaLabs para mostrar como ideias viram produto.</li>
              </ul>
            </div>
            <div class="p-3 rounded-xl border border-emerald-500/25 bg-emerald-950/30">
              <p class="text-xs uppercase tracking-[0.14em] text-emerald-300 font-semibold">Status</p>
              <p id="statusInfo" class="text-sm text-slate-100 mt-1">Você está no início da trilha.</p>
            </div>
          </aside>
        </div>
      </div>
    </section>
  </div>

  <script>
    const slides = [
      {
        titulo: '1) Bem-vindo ao jogo do empreendedorismo 🚀',
        resumo: 'Empreender é resolver problemas reais com criatividade. Nada de papo difícil: é usar o que você sabe hoje para gerar valor.',
        tag: 'Comece agora',
        humor: 'Slide inicial ativado',
        bullets: [
          'Você já empreende quando vende um serviço, organiza um evento ou faz um freela.',
          'Ideia só vale quando alguém topa usar ou pagar.',
          'Gente de 17 anos já criou apps, brechós online e bots de estudo — por que não você?'
        ],
        acao: 'Escreva uma frase sobre qual problema do seu dia a dia você quer resolver.',
        botao: 'Anote minha missão'
      },
      {
        titulo: '2) Problema real > ideia brilhante 🔍',
        resumo: 'Foque numa dor concreta de pessoas reais. Quanto mais específica, mais fácil testar.',
        tag: 'Foco na dor',
        humor: 'Detectando problemas',
        bullets: [
          'Procure o que irrita amigos: filas, burocracia, falta de grana, falta de tempo.',
          'Pergunte: a pessoa pagaria por isso ou trocaria algo para resolver? ',
          'Teste no colégio, no bairro ou online: feedback rápido é ouro.'
        ],
        acao: 'Liste 3 dores reais de colegas e escolha a mais urgente.',
        botao: 'Escolher a dor principal'
      },
      {
        titulo: '3) Exemplo BetaLabs: da dupla ao SaaS ⚡',
        resumo: 'A BetaLabs começou com dois amigos resolvendo o caos das lojas virtuais e virou uma plataforma com time e clientes recorrentes.',
        tag: 'Caso real',
        humor: 'História inspiradora',
        bullets: [
          'Primeiros projetos: freelas para e-commerces pequenos.',
          'Virada: perceberam que todas as lojas sofriam com o backoffice → criaram um sistema.',
          'Crescimento: entregas rápidas, ouvir clientes toda semana e cobrar desde o MVP.'
        ],
        acao: 'Anote qual parte dessa história você copiaria no seu projeto.',
        botao: 'Registrar inspiração'
      },
      {
        titulo: '4) MVP relâmpago ⚙️',
        resumo: 'Construa o mínimo que entrega resultado. Pode ser formulário, vídeo-demo ou planilha com automação.',
        tag: 'Mão na massa',
        humor: 'Prototipando',
        bullets: [
          'Defina o resultado: o que a pessoa consegue depois de usar seu MVP?',
          'Monte em 7 dias: vale usar ferramentas no-code, templates e ajuda de IA.',
          'Cobre algo simbólico (R$ 10) para validar que as pessoas enxergam valor.'
        ],
        acao: 'Escreva qual entrega você consegue colocar no ar esta semana.',
        botao: 'Planejar o MVP'
      },
      {
        titulo: '5) Teste com gente de verdade 🗣️',
        resumo: 'Mostre o MVP para 5 pessoas, peça opinião sincera e ajuste sem apego.',
        tag: 'Feedback rápido',
        humor: 'Hora do teste',
        bullets: [
          'Faça perguntas curtas: o que foi confuso? o que fariam diferente?',
          'Grave as respostas (com permissão) para não esquecer detalhes.',
          'Atualize o MVP no mesmo dia: velocidade impressiona.'
        ],
        acao: 'Convide 2 colegas hoje para testar e marcar horário.',
        botao: 'Agendar testes'
      },
      {
        titulo: '6) Dinheiro sem medo 💰',
        resumo: 'Preço é teste, não sentença. Comece simples e transparente.',
        tag: 'Modelo de grana',
        humor: 'Contas claras',
        bullets: [
          'Cobre pelo resultado, não pelas horas.',
          'Separe o dinheiro do negócio do seu dinheiro pessoal.',
          'Regra prática: se o cliente economiza R$ 100, cobrar R$ 20 pode fazer sentido.'
        ],
        acao: 'Defina um preço inicial e quanto precisa vender para cobrir custos básicos.',
        botao: 'Calcular preço'
      },
      {
        titulo: '7) Marca e rede social que convertem 📣',
        resumo: 'Use o que você já domina: stories, TikTok, Discord. Conte a história do problema e do progresso.',
        tag: 'Comunicação',
        humor: 'Vibe criativa',
        bullets: [
          'Poste bastidores: como você está construindo e o que já aprendeu.',
          'Mostre provas: prints de feedback, antes/depois, números simples.',
          'Chamada clara: link para teste, direct ou lista de espera.'
        ],
        acao: 'Grave um vídeo de 30s explicando a dor que você resolve.',
        botao: 'Gravar agora'
      },
      {
        titulo: '8) Produto que melhora sempre 🔁',
        resumo: 'Itere: lançar, ouvir, ajustar. Pequenas melhorias semanais vencem grandes planos parados.',
        tag: 'Iteração',
        humor: 'Evoluindo',
        bullets: [
          'Escolha 1 métrica para acompanhar toda semana (ex.: número de testers ativos).',
          'Crie um quadro simples: ideias → em teste → aprovado → descartado.',
          'Libere versões curtas, peça review e publique o que mudou.'
        ],
        acao: 'Defina qual métrica vai olhar toda sexta e escreva a meta.',
        botao: 'Fixar métrica'
      },
      {
        titulo: '9) Time e colaboração 🤝',
        resumo: 'Parceria certa acelera tudo. Combine expectativas e responsabilidades.',
        tag: 'Gente boa',
        humor: 'Jogo em equipe',
        bullets: [
          'Convide quem complementa você: design, código, venda ou organização.',
          'Acordo simples: quem faz o quê, horário de check-in e como dividir grana.',
          'Feedback honesto semanal: o que manter, melhorar e eliminar.'
        ],
        acao: 'Liste 2 pessoas que poderiam colaborar e como elas ajudariam.',
        botao: 'Montar squad'
      },
      {
        titulo: '10) Plano 30-60-90 e próximos passos 🏁',
        resumo: 'Transforme vontade em calendário. Marque datas curtas para não perder ritmo.',
        tag: 'Ritmo',
        humor: 'Checklist final',
        bullets: [
          '30 dias: validar problema e ter um MVP testado por 10 pessoas.',
          '60 dias: cobrar pelo menos um cliente ou carta de intenção assinada.',
          '90 dias: rotina semanal de produto, marketing e caixa.'
        ],
        acao: 'Escreva o próximo passo para as próximas 24h e compartilhe com alguém.',
        botao: 'Salvar próximo passo'
      }
    ];

    const slideTitle = document.getElementById('slideTitle');
    const slideSummary = document.getElementById('slideSummary');
    const slideBullets = document.getElementById('slideBullets');
    const slideLabel = document.getElementById('slideLabel');
    const slideProgress = document.getElementById('slideProgress');
    const slideTag = document.getElementById('slideTag');
    const slideAction = document.getElementById('slideAction');
    const slideMood = document.getElementById('slideMood');
    const statusInfo = document.getElementById('statusInfo');
    const actionButton = document.getElementById('actionButton');
    const prevSlide = document.getElementById('prevSlide');
    const nextSlide = document.getElementById('nextSlide');
    const anotacoes = document.getElementById('anotacoes');

    let current = 0;

    const saveNotes = () => localStorage.setItem('empreendedorismo-notes', anotacoes.value);
    const loadNotes = () => {
      const saved = localStorage.getItem('empreendedorismo-notes');
      if (saved) anotacoes.value = saved;
    };

    const renderSlide = (index) => {
      current = Math.max(0, Math.min(index, slides.length - 1));
      const slide = slides[current];
      slideTitle.textContent = slide.titulo;
      slideSummary.textContent = slide.resumo;
      slideTag.textContent = slide.tag;
      slideAction.textContent = slide.acao;
      slideMood.textContent = slide.humor;
      slideBullets.innerHTML = '';
      slide.bullets.forEach((item) => {
        const li = document.createElement('li');
        li.textContent = item;
        slideBullets.appendChild(li);
      });
      slideLabel.textContent = `Slide ${current + 1} de ${slides.length}`;
      const pct = (current / (slides.length - 1)) * 100;
      slideProgress.style.width = `${pct}%`;
      statusInfo.textContent = current === 0 ? 'Você está no início da trilha.' : current + 1 === slides.length ? 'Último slide: hora de executar!' : 'Continue avançando, cada slide é um passo.';
      actionButton.textContent = slide.botao;
      actionButton.dataset.done = 'false';
      actionButton.classList.remove('bg-emerald-700');
      actionButton.classList.add('bg-emerald-500');
    };

    actionButton.addEventListener('click', () => {
      const done = actionButton.dataset.done === 'true';
      actionButton.dataset.done = (!done).toString();
      actionButton.textContent = done ? slides[current].botao : 'Concluído! ✅';
      actionButton.classList.toggle('bg-emerald-700');
    });

    prevSlide.addEventListener('click', () => renderSlide(current - 1));
    nextSlide.addEventListener('click', () => renderSlide(current + 1));
    anotacoes.addEventListener('input', saveNotes);

    loadNotes();
    renderSlide(0);
  </script>
</body>
</html>
