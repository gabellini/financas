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
  <div class="max-w-5xl mx-auto px-4 py-4 xl:px-8 space-y-5">
    <header class="glass-panel px-3 py-3 lg:px-5 lg:py-3 flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
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
        <div class="flex items-center gap-2 text-xs sm:text-sm text-slate-400">
          <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-900/50 border border-emerald-500/30 text-emerald-100 font-semibold">🔥 Dinâmico</span>
          <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-slate-900/70 border border-slate-700 text-slate-200">10+ slides</span>
        </div>
      </div>

      <div class="space-y-4">
        <div class="w-full bg-slate-900/60 border border-slate-800 rounded-2xl p-3">
          <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between text-xs sm:text-sm text-slate-300">
            <div class="flex items-center gap-3">
              <span id="slideLabel" class="font-semibold text-sm">Slide 1 de 10</span>
              <span class="hidden sm:inline text-slate-500">|</span>
              <span id="slideMood" class="text-emerald-300 font-semibold">Começando agora</span>
            </div>
            <div class="flex items-center gap-2 text-[11px] sm:text-xs text-slate-400">
              <span class="font-semibold text-emerald-200">Nome de quem acertou:</span>
              <input id="studentName" type="text" class="px-2 py-1 rounded-md bg-slate-950 border border-slate-800 text-slate-100 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 w-40" placeholder="Digite aqui" />
            </div>
          </div>
          <div class="mt-2 h-1 bg-slate-800 rounded-full overflow-hidden">
            <div id="slideProgress" class="h-full bg-gradient-to-r from-emerald-400 to-cyan-400 rounded-full transition-all duration-500" style="width: 0%;"></div>
          </div>
          <div class="mt-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="text-[11px] sm:text-xs text-slate-400">Valendo 1 ponto para quem acertar primeiro cada pergunta.</div>
            <div class="w-full sm:w-auto">
              <div class="p-2 rounded-xl border border-emerald-500/30 bg-emerald-950/40">
                <div class="text-[10px] uppercase tracking-[0.18em] text-emerald-300 font-semibold">Ranking rápido</div>
                <ol id="leaderboardList" class="mt-1 space-y-1 text-xs text-slate-100"></ol>
              </div>
            </div>
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
            <div class="p-4 rounded-2xl border border-emerald-500/30 bg-emerald-950/30 space-y-3">
              <div class="flex items-center justify-between gap-2">
                <div>
                  <p class="text-xs uppercase tracking-[0.14em] text-emerald-300 font-semibold">Rodada relâmpago</p>
                  <p class="text-sm text-slate-200 font-semibold">3 perguntas rápidas para somar pontos</p>
                </div>
                <span class="text-[11px] text-emerald-200 bg-emerald-900/40 border border-emerald-500/30 px-3 py-1 rounded-full">Quem acerta primeiro leva 1 ponto</span>
              </div>
              <div id="questionsList" class="space-y-3"></div>
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
        botao: 'Anote minha missão',
        perguntas: [
          {
            enunciado: 'Empreender, segundo o slide, é principalmente sobre o quê?',
            opcoes: ['Resolver problemas reais', 'Ter a ideia mais brilhante', 'Esperar o momento perfeito'],
            correta: 'Resolver problemas reais'
          },
          {
            enunciado: 'Qual exemplo mostra que você já empreende?',
            opcoes: ['Organizar um evento ou freela', 'Guardar uma ideia no caderno', 'Esperar ter 25 anos'],
            correta: 'Organizar um evento ou freela'
          },
          {
            enunciado: 'Qual é o recado para quem tem 17 anos?',
            opcoes: ['Pode começar com o que sabe hoje', 'Precisa de muito capital antes', 'Deve focar só em teoria'],
            correta: 'Pode começar com o que sabe hoje'
          }
        ]
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
        botao: 'Escolher a dor principal',
        perguntas: [
          {
            enunciado: 'Qual é o foco ao escolher uma ideia?',
            opcoes: ['Uma dor concreta', 'Uma tendência aleatória', 'O que já existe no mercado'],
            correta: 'Uma dor concreta'
          },
          {
            enunciado: 'Qual pergunta ajuda a validar a dor?',
            opcoes: ['A pessoa pagaria por isso?', 'Quantos likes vai dar?', 'Preciso de um investidor?'],
            correta: 'A pessoa pagaria por isso?'
          },
          {
            enunciado: 'Onde testar rápido?',
            opcoes: ['No colégio, bairro ou online', 'Esperar um evento grande', 'Somente após lançar um app'],
            correta: 'No colégio, bairro ou online'
          }
        ]
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
        botao: 'Registrar inspiração',
        perguntas: [
          {
            enunciado: 'Com o que a BetaLabs começou?',
            opcoes: ['Freelas para e-commerces', 'Aplicativo de delivery', 'Evento de marketing'],
            correta: 'Freelas para e-commerces'
          },
          {
            enunciado: 'Qual foi a virada na história?',
            opcoes: ['Perceber dor comum no backoffice', 'Ganhar um prêmio', 'Trocar de mercado'],
            correta: 'Perceber dor comum no backoffice'
          },
          {
            enunciado: 'O que manteve o crescimento?',
            opcoes: ['Ouvir clientes e cobrar desde o MVP', 'Ficar sem feedback', 'Parar de iterar'],
            correta: 'Ouvir clientes e cobrar desde o MVP'
          }
        ]
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
        botao: 'Planejar o MVP',
        perguntas: [
          {
            enunciado: 'Qual é o foco do MVP?',
            opcoes: ['Entregar resultado mínimo', 'Ser perfeito e completo', 'Evitar cobrar'],
            correta: 'Entregar resultado mínimo'
          },
          {
            enunciado: 'Qual prazo sugerido para montar o MVP?',
            opcoes: ['7 dias', '3 meses', '1 ano'],
            correta: '7 dias'
          },
          {
            enunciado: 'Por que cobrar algo simbólico?',
            opcoes: ['Para validar valor percebido', 'Para pagar anúncios', 'Para aumentar burocracia'],
            correta: 'Para validar valor percebido'
          }
        ]
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
        botao: 'Agendar testes',
        perguntas: [
          {
            enunciado: 'Quantas pessoas iniciais são sugeridas para testar?',
            opcoes: ['5 pessoas', '50 pessoas', 'Apenas 1 pessoa'],
            correta: '5 pessoas'
          },
          {
            enunciado: 'Que tipo de perguntas fazer?',
            opcoes: ['Curtas e objetivas', 'Somente perguntas abertas longas', 'Nenhuma pergunta'],
            correta: 'Curtas e objetivas'
          },
          {
            enunciado: 'Quando ajustar o MVP?',
            opcoes: ['No mesmo dia', 'Depois de um ano', 'Somente após lançar'],
            correta: 'No mesmo dia'
          }
        ]
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
        botao: 'Calcular preço',
        perguntas: [
          {
            enunciado: 'Preço é o quê?',
            opcoes: ['Um teste', 'Algo fixo para sempre', 'Apenas um chute'],
            correta: 'Um teste'
          },
          {
            enunciado: 'O que deve ser separado?',
            opcoes: ['Dinheiro do negócio e pessoal', 'Marketing e produto', 'Tempo de estudo e lazer'],
            correta: 'Dinheiro do negócio e pessoal'
          },
          {
            enunciado: 'Regra prática citada:',
            opcoes: ['Se o cliente economiza 100, cobrar 20 pode fazer sentido', 'Cobrar sempre 10% do salário', 'Nunca cobrar no MVP'],
            correta: 'Se o cliente economiza 100, cobrar 20 pode fazer sentido'
          }
        ]
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
        botao: 'Gravar agora',
        perguntas: [
          {
            enunciado: 'Que tipo de conteúdo postar?',
            opcoes: ['Bastidores e aprendizados', 'Somente vídeos perfeitos', 'Apenas memes aleatórios'],
            correta: 'Bastidores e aprendizados'
          },
          {
            enunciado: 'O que mostrar para provar valor?',
            opcoes: ['Feedbacks e antes/depois', 'Somente promessas', 'Nada, deixar suspense'],
            correta: 'Feedbacks e antes/depois'
          },
          {
            enunciado: 'O que não pode faltar na postagem?',
            opcoes: ['Chamada clara para ação', 'Somente hashtags', 'Texto sem objetivo'],
            correta: 'Chamada clara para ação'
          }
        ]
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
        botao: 'Fixar métrica',
        perguntas: [
          {
            enunciado: 'Qual ritmo é defendido?',
            opcoes: ['Melhorias semanais', 'Lançar uma vez por ano', 'Nunca mexer no produto'],
            correta: 'Melhorias semanais'
          },
          {
            enunciado: 'O que acompanhar toda semana?',
            opcoes: ['Uma métrica clara', 'Todas as métricas possíveis', 'Nenhum número'],
            correta: 'Uma métrica clara'
          },
          {
            enunciado: 'Como organizar ideias?',
            opcoes: ['Quadro simples: ideias, teste, aprovado, descartado', 'Guardar tudo na cabeça', 'Esperar inspiração'],
            correta: 'Quadro simples: ideias, teste, aprovado, descartado'
          }
        ]
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
        botao: 'Montar squad',
        perguntas: [
          {
            enunciado: 'Quem convidar para o time?',
            opcoes: ['Quem complementa você', 'Quem pensa igual em tudo', 'Quem não tem interesse'],
            correta: 'Quem complementa você'
          },
          {
            enunciado: 'O que um acordo simples deve ter?',
            opcoes: ['Quem faz o quê e como dividir a grana', 'Apenas um logo', 'Somente o nome do projeto'],
            correta: 'Quem faz o quê e como dividir a grana'
          },
          {
            enunciado: 'Periodicidade do feedback sugerido:',
            opcoes: ['Semanal', 'Anual', 'Nunca'],
            correta: 'Semanal'
          }
        ]
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
        botao: 'Salvar próximo passo',
        perguntas: [
          {
            enunciado: 'O que deve acontecer em 30 dias?',
            opcoes: ['Validar problema e ter MVP testado', 'Escalar globalmente', 'Parar os testes'],
            correta: 'Validar problema e ter MVP testado'
          },
          {
            enunciado: 'Meta para 60 dias:',
            opcoes: ['Cobrar pelo menos um cliente', 'Criar 10 features novas sem teste', 'Focar só em branding'],
            correta: 'Cobrar pelo menos um cliente'
          },
          {
            enunciado: 'Rotina aos 90 dias deve envolver:',
            opcoes: ['Produto, marketing e caixa semanalmente', 'Apenas marketing', 'Nenhum acompanhamento'],
            correta: 'Produto, marketing e caixa semanalmente'
          }
        ]
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
    const questionsList = document.getElementById('questionsList');
    const leaderboardList = document.getElementById('leaderboardList');
    const studentNameInput = document.getElementById('studentName');

    let current = 0;
    let placar = {};

    const saveNotes = () => localStorage.setItem('empreendedorismo-notes', anotacoes.value);
    const loadNotes = () => {
      const saved = localStorage.getItem('empreendedorismo-notes');
      if (saved) anotacoes.value = saved;
    };

    const saveScores = () => localStorage.setItem('empreendedorismo-placar', JSON.stringify(placar));

    const updateLeaderboard = () => {
      const entries = Object.values(placar).sort((a, b) => b.pontos - a.pontos).slice(0, 5);
      leaderboardList.innerHTML = '';
      if (!entries.length) {
        const li = document.createElement('li');
        li.textContent = 'Ainda sem pontuações — vale 1 ponto por acerto!';
        li.className = 'text-slate-400';
        leaderboardList.appendChild(li);
        return;
      }
      entries.forEach((item, index) => {
        const li = document.createElement('li');
        li.className = 'flex items-center justify-between gap-3 bg-slate-900/60 border border-slate-800 rounded-lg px-3 py-2';
        const name = document.createElement('span');
        name.textContent = `${index + 1}. ${item.nome}`;
        name.className = 'font-semibold';
        const score = document.createElement('span');
        score.textContent = `${item.pontos} ponto${item.pontos > 1 ? 's' : ''}`;
        score.className = 'text-emerald-300 text-xs';
        li.append(name, score);
        leaderboardList.appendChild(li);
      });
    };

    const loadScores = () => {
      const stored = localStorage.getItem('empreendedorismo-placar');
      if (stored) {
        try {
          placar = JSON.parse(stored);
        } catch (err) {
          placar = {};
        }
      }
      updateLeaderboard();
    };

    const registrarPonto = () => {
      let nome = studentNameInput.value.trim();
      if (!nome) {
        nome = (prompt('Digite o nome de quem acertou primeiro:') || '').trim();
      }
      if (!nome) return;
      const chave = nome.toLowerCase();
      if (!placar[chave]) {
        placar[chave] = { nome, pontos: 0 };
      }
      if (!placar[chave].nome) placar[chave].nome = nome;
      placar[chave].pontos += 1;
      studentNameInput.value = nome;
      saveScores();
      updateLeaderboard();
    };

    const renderQuestions = (questions) => {
      questionsList.innerHTML = '';
      questions.forEach((question, idx) => {
        const card = document.createElement('div');
        card.className = 'border border-emerald-800/40 bg-slate-900/70 rounded-xl p-3 space-y-2';
        const title = document.createElement('p');
        title.className = 'text-sm font-semibold text-slate-100';
        title.textContent = `Pergunta ${idx + 1}: ${question.enunciado}`;
        const status = document.createElement('p');
        status.className = 'text-xs text-slate-400';
        status.textContent = 'Acerte primeiro para ganhar 1 ponto.';

        const optionsWrapper = document.createElement('div');
        optionsWrapper.className = 'grid grid-cols-1 sm:grid-cols-3 gap-2';
        let respondida = false;

        question.opcoes.forEach((option) => {
          const btn = document.createElement('button');
          btn.textContent = option;
          btn.className = 'w-full text-left px-3 py-2 rounded-lg border border-slate-700 bg-slate-950 hover:border-emerald-500 hover:text-emerald-100 text-sm transition';
          btn.addEventListener('click', () => {
            if (respondida) return;
            if (option === question.correta) {
              respondida = true;
              status.textContent = 'Acertou! +1 ponto registrado para quem respondeu.';
              status.className = 'text-xs text-emerald-300 font-semibold';
              registrarPonto();
              optionsWrapper.querySelectorAll('button').forEach((button) => {
                button.disabled = true;
                button.classList.add('opacity-60');
                if (button.textContent === option) {
                  button.classList.add('border-emerald-400', 'text-emerald-200');
                }
              });
            } else {
              btn.disabled = true;
              btn.classList.add('line-through', 'opacity-50', 'border-amber-400', 'text-amber-200');
              status.textContent = 'Resposta eliminada, outra pessoa pode tentar!';
              status.className = 'text-xs text-amber-300 font-semibold';
            }
          });
          optionsWrapper.appendChild(btn);
        });

        card.append(title, optionsWrapper, status);
        questionsList.appendChild(card);
      });
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
      renderQuestions(slide.perguntas || []);
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
    loadScores();
    renderSlide(0);
  </script>
</body>
</html>
