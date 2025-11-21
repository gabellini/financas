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
<body class="min-h-screen bg-slate-950 text-slate-100">
  <div class="max-w-6xl mx-auto px-4 py-4 xl:px-6 space-y-4 xl:space-y-3">
    <section class="glass-panel p-5 lg:p-6 xl:p-5 space-y-4 xl:space-y-3">
      <div class="flex flex-col gap-3">
        <div>
          <p class="text-xs uppercase tracking-[0.18em] text-emerald-300 font-semibold">Trilha guiada</p>
          <h1 class="text-3xl font-black tracking-tight">Slides interativos de empreendedorismo</h1>
        </div>
      </div>

      <div class="space-y-3">
        <div class="w-full bg-slate-900/60 border border-slate-800 rounded-2xl p-3">
          <div class="grid xl:grid-cols-[1.45fr_0.95fr] gap-4 xl:items-start">
            <div class="space-y-2 text-xs sm:text-sm text-slate-300">
              <div class="grid gap-3 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
                <div class="flex items-center gap-3 flex-wrap">
                  <span id="slideLabel" class="font-semibold text-sm">Slide 1 de 10</span>
                  <span class="hidden sm:inline text-slate-500">|</span>
                  <span id="slideMood" class="text-emerald-300 font-semibold">Começando agora</span>
                </div>
                <div class="flex flex-wrap items-center gap-2 justify-start lg:justify-end text-[11px] sm:text-xs text-slate-300">
                  <span class="px-3 py-1 rounded-full border border-emerald-500/40 bg-emerald-950/40 text-emerald-200">Pontuação soma em cada acerto</span>
                  <span class="px-3 py-1 rounded-full border border-slate-700 bg-slate-950/50">Ranking ao vivo ao lado</span>
                </div>
              </div>
              <div class="h-1 bg-slate-800 rounded-full overflow-hidden">
                <div id="slideProgress" class="h-full bg-gradient-to-r from-emerald-400 to-cyan-400 rounded-full transition-all duration-500" style="width: 0%;"></div>
              </div>
              <p id="statusInfo" class="text-[11px] sm:text-xs text-slate-300">Você está no início da trilha.</p>
              <div class="text-[11px] sm:text-xs text-slate-300 flex items-center gap-2 bg-slate-900/70 border border-slate-800 rounded-xl px-3 py-2">Rodada vale 1 ponto para o acerto mais rápido.</div>
            </div>
            <div class="p-3 rounded-xl border border-emerald-500/30 bg-emerald-950/40 h-full">
              <div class="text-[10px] uppercase tracking-[0.18em] text-emerald-300 font-semibold">Ranking rápido</div>
              <ol id="leaderboardList" class="mt-2 space-y-1 text-xs text-slate-100"></ol>
              <button id="resetRanking" type="button" class="mt-3 w-full text-xs px-3 py-2 rounded-lg border border-amber-400/60 text-amber-100 hover:bg-amber-500 hover:text-slate-950 transition">Zerar ranking</button>
            </div>
          </div>
        </div>

        <article class="p-5 border border-slate-800/80 rounded-2xl bg-slate-900/60 space-y-4 shadow-lg shadow-emerald-900/20">
          <div class="grid xl:grid-cols-[1.05fr_0.95fr] gap-4 xl:items-start">
            <div class="space-y-3">
              <header class="space-y-1">
                <p id="slideTag" class="text-xs uppercase tracking-[0.14em] text-emerald-300 font-semibold">Ação</p>
                <h3 id="slideTitle" class="text-2xl font-bold">Título do slide</h3>
                <p id="slideSummary" class="text-slate-300 text-sm leading-relaxed">Resumo do slide aparece aqui.</p>
              </header>
              <div>
                <h4 class="text-sm font-semibold text-slate-200 uppercase tracking-[0.08em]">Pontos-chave</h4>
                <ul id="slideBullets" class="mt-2 space-y-2 list-disc ml-5 text-slate-300 text-sm"></ul>
              </div>
            </div>

            <div class="space-y-3">
              <div class="p-4 rounded-2xl border border-emerald-500/30 bg-emerald-950/30 space-y-3">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                  <div>
                    <p class="text-xs uppercase tracking-[0.14em] text-emerald-300 font-semibold">Rodada relâmpago</p>
                    <p class="text-sm text-slate-200 font-semibold">Perguntas em tela cheia com controle de quem acertou</p>
                  </div>
                  <div class="flex flex-wrap items-center gap-2">
                    <span class="text-[11px] text-emerald-200 bg-emerald-900/40 border border-emerald-500/30 px-3 py-1 rounded-full">Pontos acumulam na apresentação</span>
                    <button id="openQuestions" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-emerald-500 text-slate-900 font-semibold text-sm hover:bg-emerald-400 transition">Abrir perguntas</button>
                  </div>
                </div>
                <p id="liveStatus" class="text-xs text-slate-400">Escolha a pergunta para liberar individualmente.</p>
                <div id="questionsList" class="grid grid-cols-1 md:grid-cols-2 gap-2"></div>
              </div>

            </div>
          </div>
        </article>

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between border-t border-slate-800 pt-3">
          <div class="text-xs uppercase tracking-[0.14em] text-slate-400">Navegação</div>
          <div class="flex items-center gap-2 w-full sm:w-auto">
            <button id="prevSlide" class="flex-1 sm:flex-none px-3 py-2 rounded-lg border border-slate-700 text-slate-200 hover:border-emerald-400 hover:text-emerald-100 transition text-sm">Anterior</button>
            <button id="nextSlide" class="flex-1 sm:flex-none px-3 py-2 rounded-lg bg-emerald-500 text-slate-900 font-semibold text-sm hover:bg-emerald-400 transition">Próximo</button>
          </div>
        </div>
      </div>
    </section>
  </div>

  <div id="nameModal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-lg hidden z-50">
    <div class="max-w-md mx-auto mt-16 p-4">
      <div class="rounded-2xl border border-slate-800 bg-slate-900/90 shadow-xl shadow-emerald-900/30 p-5 space-y-4">
        <div class="space-y-1">
          <p class="text-xs uppercase tracking-[0.14em] text-emerald-300 font-semibold">Quem acertou?</p>
          <h4 class="text-lg font-bold text-slate-100">Selecione um nome ou cadastre um novo</h4>
          <p class="text-sm text-slate-400">Os nomes já usados aparecem abaixo. Você também pode digitar outro.</p>
        </div>
        <div class="space-y-3">
          <label class="block text-xs text-slate-300" for="savedNames">Usar nome salvo</label>
          <select id="savedNames" class="w-full px-3 py-2 rounded-lg border border-slate-700 bg-slate-950 text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            <option value="">Selecione do ranking</option>
          </select>
          <div class="text-center text-[11px] text-slate-500">ou</div>
          <div class="space-y-1">
            <label class="block text-xs text-slate-300" for="newName">Cadastrar nome novo</label>
            <input id="newName" type="text" class="w-full px-3 py-2 rounded-lg border border-slate-700 bg-slate-950 text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Digite um nome" />
          </div>
        </div>
        <div class="flex justify-end gap-2">
          <button id="cancelName" type="button" class="px-3 py-2 rounded-lg border border-slate-700 text-slate-200 hover:border-emerald-400 hover:text-emerald-100 text-sm">Cancelar</button>
          <button id="confirmName" type="button" class="px-3 py-2 rounded-lg bg-emerald-500 text-slate-900 font-semibold text-sm hover:bg-emerald-400">Confirmar</button>
        </div>
      </div>
    </div>
  </div>

  <div id="questionModal" class="fixed inset-0 bg-slate-950/90 backdrop-blur-lg hidden z-40">
    <div class="max-w-6xl mx-auto p-4 h-full flex flex-col">
      <div class="flex items-center justify-between pb-3 border-b border-slate-800">
        <div>
          <p class="text-xs uppercase tracking-[0.14em] text-emerald-300 font-semibold">Perguntas em tela cheia</p>
          <h4 id="modalSlideLabel" class="text-lg font-bold">Slide</h4>
        </div>
        <button id="closeModal" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-slate-700 text-slate-200 hover:border-emerald-400 hover:text-emerald-100 transition text-sm">Fechar</button>
      </div>
      <div id="modalQuestions" class="mt-4 flex-1 overflow-hidden"></div>
    </div>
  </div>

  <div id="correctAnswerModal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-lg hidden z-50 flex items-center justify-center px-4">
    <div class="max-w-lg w-full rounded-2xl border border-emerald-700 bg-slate-900/90 shadow-2xl shadow-emerald-900/30 p-6 space-y-4">
      <div class="flex items-start gap-3">
        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-500/20 border border-emerald-400/60 text-emerald-200 text-xl">✅</div>
        <div class="space-y-1">
          <p class="text-xs uppercase tracking-[0.14em] text-emerald-300 font-semibold">Resposta registrada</p>
          <h4 class="text-xl font-bold text-slate-100" id="correctAnswerTitle">Alguém acertou!</h4>
          <p class="text-sm text-slate-300" id="correctAnswerDescription"></p>
        </div>
      </div>
      <div class="flex justify-end">
        <button id="closeCorrectAnswer" type="button" class="px-4 py-2 rounded-lg bg-emerald-500 text-slate-900 font-semibold text-sm hover:bg-emerald-400 transition">Fechar</button>
      </div>
    </div>
  </div>

  <script>
    const slides = [
      {
        titulo: '1) O que é empreender de verdade 🚀',
        resumo: 'Empreender é resolver uma dor concreta com produto ou serviço que entrega valor rápido.',
        tag: 'Comece agora',
        humor: 'Modo executando',
        bullets: [
          'Empreender ≠ abrir CNPJ: é entregar solução que alguém usa ou paga.',
          'Valor pode ser digital (app, planilha) ou físico (aula, reparo, entrega).',
          'Comece com o que sabe e com os recursos que já tem à mão.'
        ],
        acao: 'Escreva em uma linha: qual dor real você quer resolver primeiro?',
        botao: 'Anotar minha dor',
        perguntas: [
          {
            enunciado: 'Segundo o slide, empreender é principalmente…',
            opcoes: ['Resolver uma dor concreta', 'Abrir empresa antes de tudo', 'Esperar investimento chegar', 'Ter a ideia mais rara do mundo'],
            correta: 'Resolver uma dor concreta'
          },
          {
            enunciado: 'Que tipo de entrega vale como empreendedorismo?',
            opcoes: ['Produto digital ou serviço físico que gere valor', 'Somente um app complexo', 'Só vale franquia', 'Apenas quando há escritório próprio'],
            correta: 'Produto digital ou serviço físico que gere valor'
          },
          {
            enunciado: 'Qual ponto de partida recomendado?',
            opcoes: ['Usar o que já sabe e possui', 'Esperar formar uma grande equipe', 'Comprar equipamentos caros primeiro', 'Viajar para pesquisar tendências'],
            correta: 'Usar o que já sabe e possui'
          }
        ]
      },
      {
        titulo: '2) Como encontrar uma boa ideia (problema → solução) 🔍',
        resumo: 'Ideia boa nasce de dor observada, não de chute. Olhe o cotidiano e ouça as pessoas.',
        tag: 'Foco na dor',
        humor: 'Radar ligado',
        bullets: [
          'Mapeie frustrações: tempo perdido, filas, dúvidas, serviços ruins, falta de opção.',
          'Converse e pergunte: como resolvem hoje? pagariam por algo melhor? quanto? ',
          'Escolha a dor mais frequente e com maior urgência de pagar ou usar.'
        ],
        acao: 'Liste 3 dores de pessoas próximas e marque a que mais gera incômodo e pagamento.',
        botao: 'Escolher a dor principal',
        perguntas: [
          {
            enunciado: 'De onde deve surgir a boa ideia?',
            opcoes: ['De uma dor observada', 'De um palpite aleatório', 'De copiar um app famoso', 'De esperar inspiração mágica'],
            correta: 'De uma dor observada'
          },
          {
            enunciado: 'Que pergunta ajuda a validar a dor?',
            opcoes: ['Pagaria por algo melhor?', 'Qual cor do logo?', 'Preciso de um investidor agora?', 'Qual será o nome do domínio?'],
            correta: 'Pagaria por algo melhor?'
          },
          {
            enunciado: 'Que dor priorizar?',
            opcoes: ['A mais frequente e urgente', 'A mais rara e curiosa', 'A que só você entende', 'A que exige tecnologia cara'],
            correta: 'A mais frequente e urgente'
          }
        ]
      },
      {
        titulo: '3) Testar antes de gastar (MVP de verdade) ⚙️',
        resumo: 'Valide rápido com versões simples: formulário, vídeo-demo, protótipo no Figma ou serviço manual.',
        tag: 'Mão na massa',
        humor: 'Prototipando',
        bullets: [
          'Formule a hipótese: quem é o cliente, que dor sente e qual promessa você faz.',
          'Use ferramentas simples: landing, grupo no WhatsApp, planilha automatizada, kit de serviço.',
          'Meça interesse: clique, resposta, pré-inscrição ou pagamento simbólico.'
        ],
        acao: 'Desenhe seu MVP que cabe em 7 dias e qual sinal de interesse vai medir.',
        botao: 'Planejar meu MVP',
        perguntas: [
          {
            enunciado: 'O que vem antes de gastar em produção?',
            opcoes: ['Um MVP simples', 'Comprar estoque grande', 'Contratar time completo', 'Abrir escritório'],
            correta: 'Um MVP simples'
          },
          {
            enunciado: 'Qual ferramenta vale como MVP?',
            opcoes: ['Landing page ou formulário', 'Aplicativo perfeito sem teste', 'Máquina industrial cara', 'Somente propaganda'],
            correta: 'Landing page ou formulário'
          },
          {
            enunciado: 'Como medir interesse rapidamente?',
            opcoes: ['Cliques, respostas ou pagamento simbólico', 'Esperar meses para feedback', 'Olhar apenas curtidas', 'Ignorar qualquer dado'],
            correta: 'Cliques, respostas ou pagamento simbólico'
          }
        ]
      },
      {
        titulo: '4) Como cobrar e como ganhar dinheiro 💰',
        resumo: 'Preço simples e claro, baseado em valor entregue. Conta precisa fechar para produto e serviço.',
        tag: 'Modelo de grana',
        humor: 'Contas na mesa',
        bullets: [
          'Calcule custo mínimo: ferramentas, tempo, matéria-prima e impostos.',
          'Preço inicial pode ser pacote ou assinatura; teste com clientes reais.',
          'Regra prática: se você gera R$ 100 de ganho ou economia, cobrar R$ 20–R$ 30 é justo para validar.'
        ],
        acao: 'Defina seu preço de teste e quantas vendas precisa para cobrir custos do mês.',
        botao: 'Calcular preço de lançamento',
        perguntas: [
          {
            enunciado: 'Preço deve ser baseado em…',
            opcoes: ['Valor entregue ao cliente', 'Somente no que a concorrência cobra', 'Um número aleatório', 'Apenas no gosto pessoal'],
            correta: 'Valor entregue ao cliente'
          },
          {
            enunciado: 'O que entra no custo mínimo?',
            opcoes: ['Ferramentas, tempo e matéria-prima', 'Somente anúncios', 'Apenas decoração do escritório', 'Somente impostos de grandes empresas'],
            correta: 'Ferramentas, tempo e matéria-prima'
          },
          {
            enunciado: 'Qual regra prática sugerida?',
            opcoes: ['Se gera R$ 100, cobrar R$ 20–R$ 30 para validar', 'Nunca cobrar em testes', 'Sempre cobrar o dobro do concorrente', 'Cobrar só após um ano de uso'],
            correta: 'Se gera R$ 100, cobrar R$ 20–R$ 30 para validar'
          }
        ]
      },
      {
        titulo: '5) Marketing básico que realmente funciona 📣',
        resumo: 'Foque no essencial: quem é o cliente, onde ele está e como chamar atenção com prova.',
        tag: 'Comunicação',
        humor: 'Megafone ligado',
        bullets: [
          'Defina persona simples: idade, rotina, dor principal e quanto pode pagar.',
          'Encontre o canal ativo: escola, bairro, grupos online, feiras, redes sociais.',
          'Mostre prova rápida: antes e depois, depoimento, demonstração em vídeo ou amostra do serviço.'
        ],
        acao: 'Escreva o cliente ideal e o canal principal onde vai falar com ele hoje.',
        botao: 'Mapear cliente e canal',
        perguntas: [
          {
            enunciado: 'Quais são os 3 pilares do marketing básico aqui?',
            opcoes: ['Quem é o cliente, onde ele está, como chamar atenção', 'Logo, slogan, cor', 'Postar todo dia sem estratégia', 'Comprar anúncios caros primeiro'],
            correta: 'Quem é o cliente, onde ele está, como chamar atenção'
          },
          {
            enunciado: 'Como provar valor rapidamente?',
            opcoes: ['Mostrar depoimento ou antes/depois', 'Usar frases genéricas', 'Prometer sem mostrar nada', 'Esconder resultados'],
            correta: 'Mostrar depoimento ou antes/depois'
          },
          {
            enunciado: 'Onde falar com o cliente?',
            opcoes: ['No canal em que ele já está', 'Somente em eventos caros', 'Apenas em outdoors', 'Nunca em grupos online'],
            correta: 'No canal em que ele já está'
          }
        ]
      },
      {
        titulo: '6) Vendas na prática 🎯',
        resumo: 'Vender é conversar, entender a dor e mostrar como você resolve. Produto ou serviço, a lógica é a mesma.',
        tag: 'Fechamento',
        humor: 'Pitch pronto',
        bullets: [
          'Roteiro simples: ouvir a dor, repetir o problema, apresentar solução e preço.',
          'Use exemplos reais e prazos claros para reduzir dúvida.',
          'Peça o sim: teste, pré-venda, sinal ou contrato curto.'
        ],
        acao: 'Escreva seu pitch de 30 segundos com problema, solução e chamada para ação.',
        botao: 'Ensaiar pitch',
        perguntas: [
          {
            enunciado: 'Qual o primeiro passo de uma venda efetiva?',
            opcoes: ['Ouvir a dor do cliente', 'Falar sem parar', 'Enviar o link sem contexto', 'Discutir concorrência'],
            correta: 'Ouvir a dor do cliente'
          },
          {
            enunciado: 'O que ajuda a reduzir dúvida?',
            opcoes: ['Exemplos reais e prazos claros', 'Promessas vagas', 'Evitar detalhes', 'Esconder preço'],
            correta: 'Exemplos reais e prazos claros'
          },
          {
            enunciado: 'Como finalizar a conversa?',
            opcoes: ['Pedindo um passo concreto como teste ou sinal', 'Deixando para depois', 'Mudando de assunto', 'Mandando só o link do site'],
            correta: 'Pedindo um passo concreto como teste ou sinal'
          }
        ]
      },
      {
        titulo: '7) Organização e rotina do empreendedor 📅',
        resumo: 'Disciplina simples mantém a ideia viva. Agenda curta vale mais que promessa longa.',
        tag: 'Rotina',
        humor: 'Checklists ativados',
        bullets: [
          'Defina metas semanais: teste de cliente, entrega de versão, postagem-chave.',
          'Use quadro visual (Kanban) para priorizar: fazer, fazendo, feito.',
          'Reserve blocos de tempo para vendas, produto e finanças.'
        ],
        acao: 'Monte sua lista da semana com 3 tarefas: uma de venda, uma de produto/serviço e uma de caixa.',
        botao: 'Organizar semana',
        perguntas: [
          {
            enunciado: 'Qual rotina ajuda a manter o projeto vivo?',
            opcoes: ['Metas semanais curtas', 'Planejar apenas por ano', 'Esperar inspiração', 'Trabalhar sem priorizar'],
            correta: 'Metas semanais curtas'
          },
          {
            enunciado: 'Como visualizar prioridades?',
            opcoes: ['Usar um quadro Kanban', 'Guardar tudo na memória', 'Escrever apenas no fim do mês', 'Pedir para amigos lembrarem'],
            correta: 'Usar um quadro Kanban'
          },
          {
            enunciado: 'Quais blocos de tempo separar?',
            opcoes: ['Vendas, produto/serviço e finanças', 'Somente lazer', 'Apenas redes sociais', 'Nenhuma divisão é necessária'],
            correta: 'Vendas, produto/serviço e finanças'
          }
        ]
      },
      {
        titulo: '8) Medo, insegurança e síndrome do impostor 🧠',
        resumo: 'Todo mundo começa inseguro. Mentalidade prática ajuda a seguir testando e aprendendo.',
        tag: 'Mindset',
        humor: 'Coragem em construção',
        bullets: [
          'Compare consigo mesmo, não com cases gigantes.',
          'Pequenas vitórias semanais (primeiro lead, primeiro feedback) reduzem medo.',
          'Compartilhe progresso com amigos ou comunidade para ganhar apoio.'
        ],
        acao: 'Anote uma pequena vitória da semana e quem pode te cobrar do próximo passo.',
        botao: 'Celebrar e seguir',
        perguntas: [
          {
            enunciado: 'Como lidar com a síndrome do impostor?',
            opcoes: ['Comparando com o próprio progresso', 'Comparando com unicórnios', 'Escondendo resultados', 'Nunca pedindo feedback'],
            correta: 'Comparando com o próprio progresso'
          },
          {
            enunciado: 'O que reduz o medo?',
            opcoes: ['Pequenas vitórias semanais', 'Esperar o cenário perfeito', 'Focar só em teoria', 'Evitar qualquer teste'],
            correta: 'Pequenas vitórias semanais'
          },
          {
            enunciado: 'Como ganhar apoio?',
            opcoes: ['Compartilhando progresso com pessoas de confiança', 'Trabalhando isolado', 'Escondendo erros', 'Postando apenas quando estiver perfeito'],
            correta: 'Compartilhando progresso com pessoas de confiança'
          }
        ]
      },
      {
        titulo: '9) Erros que quebram negócios ❌',
        resumo: 'Evite tropeços clássicos para manter o ritmo. Melhor prevenir do que tentar salvar depois.',
        tag: 'Alertas',
        humor: 'Farol amarelo',
        bullets: [
          'Pular validação: construir antes de ouvir clientes gasta tempo e grana.',
          'Preço errado: cobrar muito baixo ou nunca cobrar mata o caixa.',
          'Desorganização: sem rotina e registro de custos, o negócio trava.'
        ],
        acao: 'Marque qual desses riscos você está correndo e escreva como vai corrigir hoje.',
        botao: 'Cortar riscos agora',
        perguntas: [
          {
            enunciado: 'Qual erro clássico deve ser evitado primeiro?',
            opcoes: ['Ignorar validação com clientes', 'Pular direto para o luxo', 'Contratar muitas pessoas no início', 'Comprar escritório'],
            correta: 'Ignorar validação com clientes'
          },
          {
            enunciado: 'O que acontece com preço errado?',
            opcoes: ['Mata o caixa e inviabiliza o negócio', 'Garante lucro automático', 'Não muda nada', 'Só afeta marketing'],
            correta: 'Mata o caixa e inviabiliza o negócio'
          },
          {
            enunciado: 'Por que a organização importa?',
            opcoes: ['Sem rotina e registro de custos o negócio trava', 'Porque deixa o pitch bonito', 'Para postar mais', 'Para parecer ocupado'],
            correta: 'Sem rotina e registro de custos o negócio trava'
          }
        ]
      },
      {
        titulo: '10) O futuro do trabalho e oportunidades reais 🔮',
        resumo: 'Novos modelos abrem portas para produto e serviço: assinaturas, economia criativa, IA e micro negócios.',
        tag: 'Próximos passos',
        humor: 'Visão de futuro',
        bullets: [
          'Assinaturas e comunidade: conteúdo recorrente, manutenção mensal, suporte contínuo.',
          'Serviços digitais e microtarefas: automação com IA, edição, design, consultoria rápida.',
          'Mercado local + online: experiências presenciais com venda digital aumentam alcance.'
        ],
        acao: 'Escolha uma oportunidade para testar nos próximos 7 dias e escreva o primeiro passo.',
        botao: 'Escolher caminho',
        perguntas: [
          {
            enunciado: 'Qual modelo citado gera receita recorrente?',
            opcoes: ['Assinaturas e comunidade', 'Venda única sem contato', 'Apenas eventos anuais', 'Somente doação'],
            correta: 'Assinaturas e comunidade'
          },
          {
            enunciado: 'Exemplo de serviço digital citado:',
            opcoes: ['Automação com IA ou edição', 'Somente construção civil', 'Apenas plantio de alimentos', 'Só serviços presenciais'],
            correta: 'Automação com IA ou edição'
          },
          {
            enunciado: 'Como ampliar alcance de algo local?',
            opcoes: ['Combinar experiência presencial com venda online', 'Ficar sem presença digital', 'Depender só de panfleto', 'Vender apenas para vizinhos'],
            correta: 'Combinar experiência presencial com venda online'
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
    const slideMood = document.getElementById('slideMood');
    const statusInfo = document.getElementById('statusInfo');
    const prevSlide = document.getElementById('prevSlide');
    const nextSlide = document.getElementById('nextSlide');
    const questionsList = document.getElementById('questionsList');
    const leaderboardList = document.getElementById('leaderboardList');
    const resetRankingBtn = document.getElementById('resetRanking');
    const openQuestionsBtn = document.getElementById('openQuestions');
    const liveStatus = document.getElementById('liveStatus');
    const questionModal = document.getElementById('questionModal');
    const closeModal = document.getElementById('closeModal');
    const modalQuestions = document.getElementById('modalQuestions');
    const modalSlideLabel = document.getElementById('modalSlideLabel');
    const nameModal = document.getElementById('nameModal');
    const savedNamesSelect = document.getElementById('savedNames');
    const newNameInput = document.getElementById('newName');
    const confirmNameBtn = document.getElementById('confirmName');
    const cancelNameBtn = document.getElementById('cancelName');
    const correctAnswerModal = document.getElementById('correctAnswerModal');
    const correctAnswerTitle = document.getElementById('correctAnswerTitle');
    const correctAnswerDescription = document.getElementById('correctAnswerDescription');
    const closeCorrectAnswer = document.getElementById('closeCorrectAnswer');

    const rankingEndpoint = 'ranking.php';
    const liveQuizEndpoint = 'live-quiz.php';
    let current = 0;
    let placar = {};
    let questionStates = {};
    let liveStateInterval = null;
    let expandedQuestion = null;
    let resolveNamePromise = null;
    let releasingQuestion = false;
    let ultimoAnuncioRemoto = '';

    const exibirModalAcerto = (nome, enunciado) => {
      correctAnswerTitle.textContent = `${nome} acertou!`;
      correctAnswerDescription.textContent = `A pergunta foi marcada como respondida por ${nome}.${enunciado ? `\n\nPergunta: ${enunciado}` : ''}`;
      correctAnswerModal.classList.remove('hidden');
      document.body.classList.add('overflow-hidden');
    };

    const fecharModalAcerto = () => {
      correctAnswerModal.classList.add('hidden');
      document.body.classList.remove('overflow-hidden');
    };

    closeCorrectAnswer.addEventListener('click', fecharModalAcerto);

    const populateSavedNames = () => {
      const entries = Object.values(placar).sort((a, b) => a.nome.localeCompare(b.nome));
      savedNamesSelect.innerHTML = '<option value="">Selecione do ranking</option>';
      entries.forEach((item) => {
        const option = document.createElement('option');
        option.value = item.nome;
        option.textContent = item.nome;
        savedNamesSelect.appendChild(option);
      });
    };

    const closeNameModal = () => {
      nameModal.classList.add('hidden');
      document.body.classList.remove('overflow-hidden');
      newNameInput.value = '';
      savedNamesSelect.value = '';
      resolveNamePromise = null;
    };

    const solicitarNome = () => new Promise((resolve) => {
      resolveNamePromise = resolve;
      populateSavedNames();
      nameModal.classList.remove('hidden');
      document.body.classList.add('overflow-hidden');
      newNameInput.focus();
    });

    confirmNameBtn.addEventListener('click', () => {
      if (!resolveNamePromise) return;
      const chosen = savedNamesSelect.value || newNameInput.value.trim();
      if (!chosen) return;
      resolveNamePromise(chosen);
      closeNameModal();
    });

    cancelNameBtn.addEventListener('click', () => {
      if (resolveNamePromise) resolveNamePromise(null);
      closeNameModal();
    });

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
      populateSavedNames();
    };

    const loadScores = async () => {
      try {
        const response = await fetch(rankingEndpoint);
        if (response.ok) {
          const data = await response.json();
          placar = data.placar || {};
        }
      } catch (err) {
        console.error('Erro ao carregar ranking', err);
      }
      updateLeaderboard();
    };

    const registrarPonto = async (nome) => {
      if (!nome) return;
      try {
        const response = await fetch(rankingEndpoint, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ nome })
        });
        if (response.ok) {
          const data = await response.json();
          placar = data.placar || placar;
        }
      } catch (err) {
        console.error('Erro ao salvar ponto', err);
        alert('Não foi possível salvar o ponto agora.');
      }
      updateLeaderboard();
    };

    const setLiveStatus = (message, highlight = false) => {
      if (!liveStatus) return;
      liveStatus.textContent = message;
      liveStatus.classList.toggle('text-emerald-300', highlight);
    };

    const buildQuestionId = (slideIndex, questionIndex) => slideIndex * 100 + questionIndex;

    const escolherPerguntaParaLiberar = (customIndex = null) => {
      const questions = slides[current].perguntas || [];
      if (!questions.length) return null;
      const states = ensureQuestionState(current);
      const pendingIndex = states.findIndex((item) => !item.answered);
      const targetIndex = customIndex !== null ? customIndex : pendingIndex >= 0 ? pendingIndex : 0;

      return { question: questions[targetIndex], index: targetIndex };
    };

    const marcarComoRespondida = (slideIndex, questionIndex, vencedor) => {
      const questions = slides[slideIndex]?.perguntas || [];
      const question = questions[questionIndex];
      const states = ensureQuestionState(slideIndex);
      if (!question) return;

      states.forEach((state, idx) => {
        states[idx] = { ...state, liberada: false };
      });

      states[questionIndex] = { answered: true, vencedor: vencedor || '—', correta: question.correta, liberada: false };

      if (slideIndex === current) {
        renderQuestionSummary();
        renderModalQuestions();
      }

      if (vencedor) {
        exibirModalAcerto(vencedor, question.enunciado);
      }
    };

    const registrarVencedorRemoto = (slideIndex, questionIndex, vencedor) => {
      const key = `${slideIndex}-${questionIndex}-${vencedor}`;
      if (!vencedor || key === ultimoAnuncioRemoto) return;
      ultimoAnuncioRemoto = key;
      marcarComoRespondida(slideIndex, questionIndex, vencedor);
    };

    const liberarPerguntaNosCelulares = async (targetIndex = null) => {
      if (releasingQuestion) return;

      const alvo = escolherPerguntaParaLiberar(targetIndex);
      if (!alvo) {
        setLiveStatus('Não há perguntas neste slide para liberar.');
        return;
      }

      const states = ensureQuestionState(current);
      states.forEach((state, idx) => {
        if (idx !== alvo.index) {
          states[idx] = { ...state, liberada: false };
        }
      });

      releasingQuestion = true;
      setLiveStatus('Liberando pergunta para os celulares...');
      const payload = {
        action: 'release',
        questionId: buildQuestionId(current, alvo.index),
        questionText: alvo.question.enunciado,
        options: alvo.question.opcoes,
        correctOption: alvo.question.correta,
        slideTitle: slides[current].titulo,
        questionLabel: `Slide ${current + 1} — Pergunta ${alvo.index + 1}`
      };

      try {
        const response = await fetch(liveQuizEndpoint, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });

        const data = await response.json();
        if (!response.ok || data.error) {
          setLiveStatus(data.error || 'Não foi possível liberar a pergunta agora.');
          return;
        }

        states[alvo.index] = { ...states[alvo.index], liberada: true };
        setLiveStatus(`Pergunta ${alvo.index + 1} liberada para quem está no celular.`, true);
        renderQuestionSummary();
        renderModalQuestions();
      } catch (error) {
        console.error('Erro ao liberar pergunta', error);
        setLiveStatus('Erro ao liberar a pergunta. Confira a conexão.');
      } finally {
        releasingQuestion = false;
      }
    };

    const ensureQuestionState = (index) => {
      const defaults = { answered: false, vencedor: '', correta: '', liberada: false };
      const base = questionStates[index] || [];
      const questions = slides[index].perguntas || [];

      questionStates[index] = questions.map((_, idx) => ({
        ...defaults,
        ...(base[idx] || {})
      }));

      return questionStates[index];
    };

    const renderQuestionSummary = () => {
      const questions = slides[current].perguntas || [];
      const states = ensureQuestionState(current);
      questionsList.innerHTML = '';

      if (!questions.length) {
        const p = document.createElement('p');
        p.textContent = 'Este slide não possui perguntas.';
        p.className = 'text-sm text-slate-400';
        questionsList.appendChild(p);
        return;
      }

      questions.forEach((question, idx) => {
        const card = document.createElement('div');
        card.className = 'flex items-start justify-between gap-3 rounded-lg border border-emerald-900/40 bg-slate-900/60 px-3 py-2';
        const info = document.createElement('div');
        const title = document.createElement('p');
        title.className = 'text-sm font-semibold text-slate-100';
        title.textContent = `Pergunta ${idx + 1}: ${question.enunciado}`;
        const status = document.createElement('p');
        status.className = 'text-xs text-slate-400';

        if (states[idx].answered) {
          status.textContent = `Respondida por ${states[idx].vencedor}. Acerto: ${states[idx].correta}`;
          status.classList.add('text-emerald-300', 'font-semibold');
        } else if (states[idx].liberada) {
          status.textContent = 'Liberada para os alunos neste momento';
          status.classList.add('text-emerald-200');
        } else {
          status.textContent = 'Em aberto';
        }
        info.append(title, status);

        const badge = document.createElement('span');
        badge.className = `text-[11px] px-2 py-1 rounded-full border ${states[idx].answered ? 'border-emerald-400 text-emerald-200 bg-emerald-900/50' : states[idx].liberada ? 'border-cyan-400 text-cyan-100 bg-cyan-900/40' : 'border-slate-700 text-slate-300 bg-slate-900/70'}`;
        badge.textContent = states[idx].answered ? 'Respondida' : states[idx].liberada ? 'Liberada' : 'Pendente';

        const actions = document.createElement('div');
        actions.className = 'flex items-center gap-2';

        const releaseBtn = document.createElement('button');
        releaseBtn.type = 'button';
        releaseBtn.textContent = 'Liberar';
        releaseBtn.className = 'text-xs px-3 py-1 rounded-lg border border-emerald-500 text-emerald-100 hover:bg-emerald-500 hover:text-slate-900 transition disabled:opacity-50 disabled:cursor-not-allowed';
        releaseBtn.disabled = states[idx].answered || states[idx].liberada;
        releaseBtn.addEventListener('click', () => liberarPerguntaNosCelulares(idx));

        actions.append(badge, releaseBtn);

        card.append(info, actions);
        questionsList.appendChild(card);
      });
    };

    const renderModalQuestions = () => {
      const slide = slides[current];
      const questions = slide.perguntas || [];
      const states = ensureQuestionState(current);
      modalSlideLabel.textContent = `${slide.titulo} — ${questions.length} pergunta${questions.length === 1 ? '' : 's'}`;
      modalQuestions.innerHTML = '';

      if (!questions.length) {
        const empty = document.createElement('p');
        empty.textContent = 'Este slide não possui perguntas.';
        empty.className = 'text-sm text-slate-400';
        modalQuestions.appendChild(empty);
        return;
      }

      expandedQuestion = Math.min(Math.max(expandedQuestion ?? 0, 0), questions.length - 1);

      const layout = document.createElement('div');
      layout.className = 'flex flex-col lg:flex-row gap-4 h-full';

      const list = document.createElement('div');
      list.className = 'lg:w-[36%] space-y-2 overflow-y-auto pr-1';

      const detail = document.createElement('div');
      detail.className = 'flex-1 rounded-2xl border border-emerald-800/50 bg-slate-900/70 p-4 lg:p-5 shadow-inner overflow-y-auto';

        const renderDetail = (idx) => {
          const question = questions[idx];
          const state = states[idx];
          detail.innerHTML = '';

        const header = document.createElement('div');
        header.className = 'flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between';
        const title = document.createElement('h5');
        title.className = 'text-lg font-bold text-slate-100';
        title.textContent = `Pergunta ${idx + 1}`;
        const status = document.createElement('span');
        let statusLabel = 'Em aberto';
        let statusClasses = 'border-slate-700 text-slate-300 bg-slate-950/70';

        if (state.answered) {
          statusLabel = `Respondida por ${state.vencedor} · ${state.correta}`;
          statusClasses = 'border-emerald-400 text-emerald-200 bg-emerald-900/50';
        } else if (state.liberada) {
          statusLabel = 'Liberada para os alunos';
          statusClasses = 'border-cyan-400 text-cyan-100 bg-cyan-900/40';
        }

        status.className = `text-[11px] px-3 py-1 rounded-full border ${statusClasses}`;
        status.textContent = statusLabel;

        const actions = document.createElement('div');
        actions.className = 'flex flex-wrap items-center gap-2';
        const releaseBtn = document.createElement('button');
        releaseBtn.type = 'button';
        releaseBtn.className = 'text-xs px-3 py-2 rounded-lg border border-emerald-400 text-emerald-100 hover:bg-emerald-500 hover:text-slate-900 transition disabled:opacity-50 disabled:cursor-not-allowed';
        releaseBtn.textContent = state.liberada ? '📡 Liberada' : '📡 Liberar esta pergunta';
        releaseBtn.disabled = state.answered || state.liberada;
        releaseBtn.addEventListener('click', () => liberarPerguntaNosCelulares(idx));
        actions.append(status, releaseBtn);

        header.append(title, actions);

        const statement = document.createElement('p');
        statement.className = 'text-base text-slate-200 leading-relaxed';
        statement.textContent = question.enunciado;

        const optionsWrapper = document.createElement('div');
        optionsWrapper.className = 'grid grid-cols-1 md:grid-cols-2 gap-3 mt-4';

        question.opcoes.forEach((option) => {
          const btn = document.createElement('button');
          btn.textContent = option;
          btn.className = 'w-full text-left px-4 py-3 rounded-xl border border-slate-700 bg-slate-950 hover:border-emerald-500 hover:text-emerald-100 text-sm transition shadow-sm';

          if (state.answered) {
            btn.disabled = true;
            btn.classList.add('opacity-60');
            if (option === question.correta) {
              btn.classList.add('border-emerald-400', 'text-emerald-200', 'bg-emerald-900/40');
            }
          }

          btn.addEventListener('click', async () => {
            if (state.answered) return;
            if (option === question.correta) {
              const nome = await solicitarNome();
              if (!nome) return;
              states[idx] = { answered: true, vencedor: nome, correta: question.correta };
              await registrarPonto(nome);
              renderQuestionSummary();
              renderModalQuestions();
              exibirModalAcerto(nome, question.enunciado);
            } else {
              btn.disabled = true;
              btn.classList.add('line-through', 'opacity-50', 'border-amber-400', 'text-amber-200');
            }
          });

          optionsWrapper.appendChild(btn);
        });

        detail.append(header, statement, optionsWrapper);
      };

      questions.forEach((question, idx) => {
        const state = states[idx];
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = `w-full text-left px-3 py-2 rounded-xl border ${expandedQuestion === idx ? 'border-emerald-400 bg-emerald-950/60 shadow-lg' : 'border-slate-800 bg-slate-950/70 hover:border-emerald-500'} transition flex flex-col gap-1`;
        const label = document.createElement('span');
        label.className = 'text-sm font-semibold text-slate-100';
        label.textContent = `Pergunta ${idx + 1}`;
        const summary = document.createElement('span');
        summary.className = 'text-xs text-slate-400 leading-snug';
        summary.textContent = question.enunciado;
        const chip = document.createElement('span');
        let chipLabel = 'Aguardando';
        let chipClasses = 'border-slate-700 text-slate-300 bg-slate-900/70';

        if (state.answered) {
          chipLabel = `Respondida por ${state.vencedor}`;
          chipClasses = 'border-emerald-400 text-emerald-200 bg-emerald-900/50';
        } else if (state.liberada) {
          chipLabel = 'Liberada agora';
          chipClasses = 'border-cyan-400 text-cyan-100 bg-cyan-900/40';
        }

        chip.className = `mt-1 text-[11px] px-2 py-1 rounded-full border w-fit ${chipClasses}`;
        chip.textContent = chipLabel;

        btn.append(label, summary, chip);

        btn.addEventListener('click', () => {
          expandedQuestion = idx;
          renderModalQuestions();
        });

        list.appendChild(btn);
      });

      layout.append(list, detail);
      modalQuestions.appendChild(layout);
      renderDetail(expandedQuestion);
    };

    const renderSlide = (index) => {
      current = Math.max(0, Math.min(index, slides.length - 1));
      const slide = slides[current];
      slideTitle.textContent = slide.titulo;
      slideSummary.textContent = slide.resumo;
      slideTag.textContent = slide.tag;
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
      statusInfo.textContent = current === 0 ? 'Você está no início da trilha.' : current + 1 === slides.length ? 'Último slide, hora de executar!' : 'Continue avançando, cada slide é um passo.';
      ensureQuestionState(current);
      renderQuestionSummary();
      setLiveStatus('Selecione uma pergunta deste slide para liberar individualmente.');
    };

    prevSlide.addEventListener('click', () => renderSlide(current - 1));
    nextSlide.addEventListener('click', () => renderSlide(current + 1));
    openQuestionsBtn.addEventListener('click', () => {
      expandedQuestion = null;
      renderModalQuestions();
      questionModal.classList.remove('hidden');
      document.body.classList.add('overflow-hidden');
    });
    closeModal.addEventListener('click', () => {
      questionModal.classList.add('hidden');
      document.body.classList.remove('overflow-hidden');
    });

    resetRankingBtn.addEventListener('click', async () => {
      if (!confirm('Deseja zerar o ranking e limpar os pontos?')) return;
      try {
        const response = await fetch(rankingEndpoint, { method: 'DELETE' });
        if (response.ok) {
          placar = {};
          questionStates = {};
          await fetch(liveQuizEndpoint, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'close' })
          });
          setLiveStatus('Ranking e estado ao vivo zerados. Pronto para liberar novamente.');
        }
      } catch (err) {
        console.error('Erro ao zerar ranking', err);
        alert('Não foi possível zerar o ranking agora.');
      }
      renderQuestionSummary();
      renderModalQuestions();
      updateLeaderboard();
    });

    const sincronizarPerguntaAoVivo = async () => {
      try {
        const response = await fetch(liveQuizEndpoint);
        const data = await response.json();

        if (data.status === 'active' && data.question && typeof data.question.id === 'number') {
          const slideIndex = Math.floor((data.question.id ?? 0) / 100);
          const questionIndex = (data.question.id ?? 0) % 100;
          const states = ensureQuestionState(slideIndex);
          if (states[questionIndex]) {
            states.forEach((state, idx) => {
              states[idx] = { ...state, liberada: idx === questionIndex };
            });
            if (slideIndex === current) {
              renderQuestionSummary();
              renderModalQuestions();
              setLiveStatus(`Pergunta ${questionIndex + 1} está liberada para os alunos.`, true);
            }
          }
        }
        
        if (data.status === 'waiting') {
          Object.keys(questionStates).forEach((key) => {
            questionStates[key] = ensureQuestionState(Number(key)).map((state) => ({ ...state, liberada: false }));
          });

          renderQuestionSummary();
          renderModalQuestions();
        }

        if (data.status === 'closed' && data.winner && data.closedQuestion) {
          const slideIndex = Math.floor((data.closedQuestion.id ?? 0) / 100);
          const questionIndex = (data.closedQuestion.id ?? 0) % 100;
          registrarVencedorRemoto(slideIndex, questionIndex, data.winner.name || data.winner);
          setLiveStatus(`Pergunta encerrada. Vencedor: ${data.winner.name || data.winner}.`, true);
        }

        if (data.winner && data.closedQuestion && typeof data.closedQuestion.id !== 'undefined') {
          const slideIndex = Math.floor((data.closedQuestion.id ?? 0) / 100);
          const questionIndex = (data.closedQuestion.id ?? 0) % 100;
          registrarVencedorRemoto(slideIndex, questionIndex, data.winner.name || data.winner);
        }
      } catch (error) {
        console.error('Erro ao sincronizar pergunta ao vivo', error);
      }
    };

    const iniciarAtualizacoesAoVivo = () => {
      if (liveStateInterval) clearInterval(liveStateInterval);
      liveStateInterval = setInterval(() => {
        loadScores();
        sincronizarPerguntaAoVivo();
      }, 4000);
    };

    loadScores().then(() => {
      renderSlide(0);
      iniciarAtualizacoesAoVivo();
    });
  </script>
</body>
</html>
