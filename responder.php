<?php
require __DIR__ . '/quiz-data.php';
$questions = load_quiz_questions();
$totalQuestions = count($questions);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Responder pelo celular — Quiz ao vivo</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/theme.css" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen">
  <div class="max-w-3xl mx-auto px-4 py-6 space-y-5">
    <header class="glass-panel p-4 border border-slate-800 flex flex-col gap-2">
      <div class="flex items-center justify-between gap-3">
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 rounded-2xl bg-emerald-500 text-slate-950 grid place-items-center font-bold tracking-tight">AF</div>
          <div class="min-w-0">
            <h1 class="text-xl font-extrabold text-slate-100">Responder ao vivo</h1>
            <p class="text-sm text-slate-400">Use seu celular para responder rápido. Perguntas liberadas pelo apresentador.</p>
          </div>
        </div>
        <a href="quizz.php" class="btn">🎯 Ver quiz</a>
      </div>
      <div class="text-xs text-slate-400">Perguntas preparadas: <?php echo $totalQuestions; ?>.</div>
    </header>

    <main class="glass-panel p-4 sm:p-6 space-y-5">
      <section class="space-y-3">
        <h2 class="text-lg font-semibold">1) Cadastre-se uma vez</h2>
        <p class="text-sm text-slate-400">Digite seu nome para participar. Salvamos no seu dispositivo e não dá para alterar depois.</p>
        <form id="registerForm" class="flex flex-col sm:flex-row gap-3">
          <input id="inputName" class="flex-1 rounded-xl px-4 py-3 bg-slate-900 border border-slate-800 focus:border-emerald-500 focus:outline-none" placeholder="Seu nome" />
          <button type="submit" class="btn btn-emerald">Salvar</button>
        </form>
        <div id="registerFeedback" class="text-sm text-emerald-400 hidden"></div>
      </section>

      <section class="space-y-3">
        <div class="flex items-center justify-between gap-3">
          <div>
            <h2 class="text-lg font-semibold">2) Atualize para ver a pergunta liberada</h2>
            <p class="text-sm text-slate-400">Só aparece quando o apresentador liberar.</p>
          </div>
          <button id="btnRefresh" class="btn">🔄 Atualizar</button>
        </div>
        <div id="questionCard" class="rounded-2xl border border-slate-800 bg-slate-900/70 p-4 space-y-3">
          <p id="questionStatus" class="text-sm text-slate-400">Nenhuma pergunta liberada ainda.</p>
          <div id="questionContent" class="space-y-3 hidden">
            <div class="text-xs uppercase tracking-wide text-slate-400">Pergunta <span id="questionNumber"></span></div>
            <h3 id="questionText" class="text-lg font-semibold text-slate-100"></h3>
            <div id="optionsList" class="space-y-2"></div>
            <div id="answerFeedback" class="text-sm"></div>
          </div>
        </div>
      </section>

      <section class="space-y-2 text-sm text-slate-400">
        <p>Regras rápidas:</p>
        <ul class="list-disc ml-5 space-y-1">
          <li>Somente quem acertar primeiro leva o ponto.</li>
          <li>Errou? Aguarde a próxima pergunta (não dá para tentar de novo).</li>
          <li>Não dá para ver a pergunta antes de ser liberada.</li>
        </ul>
      </section>
    </main>
  </div>

  <script type="module" src="assets/js/responder.js"></script>
</body>
</html>
