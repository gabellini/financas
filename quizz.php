<?php
require __DIR__ . '/quiz-data.php';

$questions = load_quiz_questions();

foreach ($questions as $index => &$question) {
    $question['id'] = $index;
    $options = array_merge([$question['correct']], $question['alternatives']);
    shuffle($options);
    $question['options'] = $options;
    $question['correctIndex'] = array_search($question['correct'], $options, true);
    unset($question['alternatives']);
}
unset($question);
shuffle($questions);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Quiz Quem Quer Ser um Milionário - Aula Interativa</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/theme.css" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen">
  <div class="max-w-4xl mx-auto px-4 py-6 space-y-6">
    <header class="bg-slate-900/60 border border-slate-800 backdrop-blur rounded-3xl px-4 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 shadow-lg">
      <div class="flex items-center gap-3">
        <div class="w-12 h-12 rounded-2xl bg-emerald-500 text-slate-950 grid place-items-center font-bold tracking-tight shadow-lg">AF</div>
        <div>
          <h1 class="text-2xl font-extrabold text-slate-100">Quiz Quem Quer Ser um Milionário</h1>
          <p class="text-sm text-slate-400">35 perguntas sobre capitalismo, finanças e empreendedorismo</p>
        </div>
      </div>
      <a href="index.php" class="btn">⬅ Voltar à aula</a>
    </header>

    <section class="bg-slate-900/60 border border-slate-800 backdrop-blur rounded-3xl shadow-lg p-6 space-y-6">
      <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div class="space-y-2">
          <span class="inline-flex items-center gap-2 text-xs uppercase tracking-wide font-semibold text-slate-400">Pergunta <span id="questionNumber" class="text-slate-100">1</span> / 35</span>
          <h2 id="questionText" class="text-xl font-bold text-slate-100"></h2>
        </div>
        <div class="flex flex-wrap items-center gap-2">
          <button id="lifelineOne" class="btn btn-amber">🧠 Eliminar 1</button>
          <button id="lifelineTwo" class="btn btn-emerald">🎯 Eliminar 2</button>
          <button id="skipQuestion" class="btn btn-indigo">⏭ Pular</button>
          <button id="nextQuestion" class="btn btn-muted" disabled>Próxima pergunta</button>
        </div>
      </div>

      <div id="optionsContainer" class="grid gap-3"></div>

      <div id="feedback" class="feedback text-base" data-state=""></div>

      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-sm text-slate-400">
        <span id="studentsRemaining"><?php echo count($questions); ?> estudantes na fila</span>
        <span id="scoreBoard">Acertos: 0 • Erros: 0</span>
      </div>
    </section>

    <section class="bg-slate-900/60 border border-slate-800 backdrop-blur rounded-3xl shadow-lg p-6 space-y-4">
      <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
        <div>
          <h2 class="text-lg font-bold text-slate-100">Controle do apresentador</h2>
          <p class="text-sm text-slate-400">Libere a pergunta atual para quem estiver no celular. Só o primeiro acerto vale.</p>
        </div>
        <div class="flex flex-wrap gap-2">
          <a href="responder.php" class="btn btn-emerald">📱 URL dos alunos</a>
          <button id="syncLive" class="btn btn-muted">🔄 Atualizar status</button>
        </div>
      </div>
      <p id="liveStatus" class="text-sm text-slate-300">Nenhuma pergunta liberada no momento.</p>
      <div class="flex flex-wrap gap-2">
        <button id="broadcastQuestion" class="btn btn-emerald">📡 Liberar pergunta atual</button>
        <button id="closeLive" class="btn btn-amber">⏹ Encerrar pergunta</button>
      </div>
      <p class="text-xs text-slate-400">A pergunta só aparece quando liberada. Quem errar perde a vez; apenas o primeiro acerto fica registrado.</p>
    </section>
  </div>

  <script id="quiz-data" type="application/json"><?php echo json_encode($questions, JSON_UNESCAPED_UNICODE); ?></script>
  <script type="module" src="assets/js/quiz.js"></script>
</body>
</html>
