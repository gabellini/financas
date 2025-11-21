const dataElement = document.getElementById('quiz-data');
const quizData = JSON.parse(dataElement.textContent || '[]');

const elements = {
  questionNumber: document.getElementById('questionNumber'),
  questionText: document.getElementById('questionText'),
  options: document.getElementById('optionsContainer'),
  feedback: document.getElementById('feedback'),
  next: document.getElementById('nextQuestion'),
  lifelineOne: document.getElementById('lifelineOne'),
  lifelineTwo: document.getElementById('lifelineTwo'),
  skip: document.getElementById('skipQuestion'),
  studentsRemaining: document.getElementById('studentsRemaining'),
  scoreBoard: document.getElementById('scoreBoard'),
  broadcast: document.getElementById('broadcastQuestion'),
  closeLive: document.getElementById('closeLive'),
  syncLive: document.getElementById('syncLive'),
  liveStatus: document.getElementById('liveStatus')
};

const state = {
  currentIndex: 0,
  answered: false,
  correct: 0,
  wrong: 0
};

function setLiveStatus(message, isHighlight = false) {
  elements.liveStatus.textContent = message;
  elements.liveStatus.classList.toggle('text-emerald-300', isHighlight);
}

function updateStudentsRemaining() {
  const remaining = Math.max(0, quizData.length - state.currentIndex);
  elements.studentsRemaining.textContent = `${remaining} estudante${remaining === 1 ? '' : 's'} na fila`;
}

function resetLifelines() {
  [elements.lifelineOne, elements.lifelineTwo, elements.skip].forEach((btn) => {
    btn.disabled = false;
    btn.classList.remove('opacity-50');
  });
}

function createOptionButton(optionText, idx, isCorrect) {
  const button = document.createElement('button');
  button.type = 'button';
  button.className = 'option-btn text-base';
  button.dataset.correct = isCorrect ? 'true' : 'false';
  button.innerHTML = `<span class="font-semibold text-slate-300 mr-2">${String.fromCharCode(65 + idx)}.</span>${optionText}`;
  button.addEventListener('click', () => handleAnswer(button));
  return button;
}

function renderQuestion() {
  const question = quizData[state.currentIndex];
  elements.questionNumber.textContent = state.currentIndex + 1;
  elements.questionText.textContent = question.question;
  elements.feedback.textContent = '';
  elements.feedback.dataset.state = '';
  elements.options.innerHTML = '';
  state.answered = false;
  elements.next.disabled = true;
  resetLifelines();
  updateStudentsRemaining();

  question.options.forEach((optionText, idx) => {
    const button = createOptionButton(optionText, idx, idx === question.correctIndex);
    elements.options.appendChild(button);
  });
}

async function syncLiveState() {
  try {
    const response = await fetch('live-quiz.php');
    const data = await response.json();

    if (data.status === 'active' && data.question) {
      setLiveStatus(`Pergunta ${data.question.id + 1} liberada para os alunos.`, true);
    } else if (data.winner && data.winner.name) {
      setLiveStatus(`Pergunta encerrada. Vencedor: ${data.winner.name}.`);
    } else {
      setLiveStatus('Nenhuma pergunta liberada no momento.');
    }
  } catch (error) {
    setLiveStatus('Não foi possível sincronizar o status agora.');
  }
}

async function broadcastQuestion() {
  const currentQuestion = quizData[state.currentIndex];
  if (!currentQuestion) {
    setLiveStatus('Nenhuma pergunta selecionada.');
    return;
  }

  try {
    const response = await fetch('live-quiz.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ action: 'release', questionId: currentQuestion.id })
    });

    const data = await response.json();
    if (!response.ok || data.error) {
      setLiveStatus(data.error || 'Não foi possível liberar a pergunta.');
      return;
    }

    setLiveStatus(`Pergunta ${currentQuestion.id + 1} liberada para os alunos.`, true);
  } catch (error) {
    setLiveStatus('Erro ao liberar a pergunta.');
  }
}

async function closeLiveQuestion() {
  try {
    const response = await fetch('live-quiz.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ action: 'close' })
    });

    const data = await response.json();
    if (!response.ok || data.error) {
      setLiveStatus(data.error || 'Não foi possível encerrar.');
      return;
    }

    setLiveStatus('Pergunta encerrada para respostas.');
  } catch (error) {
    setLiveStatus('Erro ao encerrar as respostas.');
  }
}

function disableOptions() {
  elements.options.querySelectorAll('button').forEach((btn) => {
    btn.disabled = true;
  });
}

function markCorrectButton() {
  const correctBtn = elements.options.querySelector('button[data-correct="true"]');
  if (correctBtn) {
    correctBtn.dataset.state = 'correct';
  }
}

function handleAnswer(button) {
  if (state.answered) return;
  state.answered = true;
  disableOptions();

  const isCorrect = button.dataset.correct === 'true';
  if (isCorrect) {
    button.dataset.state = 'correct';
    elements.feedback.textContent = 'Resposta correta! Parabéns!';
    elements.feedback.dataset.state = 'correct';
    state.correct += 1;
  } else {
    button.dataset.state = 'wrong';
    elements.feedback.textContent = 'Resposta incorreta. Continue estudando!';
    elements.feedback.dataset.state = 'wrong';
    state.wrong += 1;
    markCorrectButton();
  }

  elements.scoreBoard.textContent = `Acertos: ${state.correct} • Erros: ${state.wrong}`;
  elements.next.disabled = state.currentIndex >= quizData.length - 1;
  [elements.lifelineOne, elements.lifelineTwo, elements.skip].forEach((btn) => {
    btn.disabled = true;
    btn.classList.add('opacity-50');
  });
}

function eliminateOptions(amount) {
  const buttons = Array.from(elements.options.querySelectorAll('button'));
  const wrongButtons = buttons.filter((btn) => btn.dataset.correct !== 'true' && btn.style.visibility !== 'hidden' && !btn.disabled);
  if (!wrongButtons.length) return;
  const toRemove = Math.min(amount, wrongButtons.length);
  for (let i = 0; i < toRemove; i += 1) {
    const randomIndex = Math.floor(Math.random() * wrongButtons.length);
    const btn = wrongButtons.splice(randomIndex, 1)[0];
    btn.style.visibility = 'hidden';
  }
}

elements.lifelineOne.addEventListener('click', () => {
  eliminateOptions(1);
  elements.lifelineOne.disabled = true;
  elements.lifelineOne.classList.add('opacity-50');
});

elements.lifelineTwo.addEventListener('click', () => {
  eliminateOptions(2);
  elements.lifelineTwo.disabled = true;
  elements.lifelineTwo.classList.add('opacity-50');
});

elements.skip.addEventListener('click', () => {
  if (state.answered) return;
  state.answered = true;
  disableOptions();
  markCorrectButton();
  elements.feedback.textContent = 'Pergunta pulada! Veja a resposta correta e siga em frente.';
  elements.feedback.dataset.state = 'skip';
  elements.next.disabled = state.currentIndex >= quizData.length - 1;
  [elements.lifelineOne, elements.lifelineTwo, elements.skip].forEach((btn) => {
    btn.disabled = true;
    btn.classList.add('opacity-50');
  });
});

elements.next.addEventListener('click', () => {
  if (state.currentIndex < quizData.length - 1) {
    state.currentIndex += 1;
    renderQuestion();
  }
});

elements.broadcast.addEventListener('click', broadcastQuestion);
elements.closeLive.addEventListener('click', closeLiveQuestion);
elements.syncLive.addEventListener('click', syncLiveState);

syncLiveState();
renderQuestion();
