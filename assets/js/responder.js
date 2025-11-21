const API_URL = 'live-quiz.php';
const nameKey = 'liveQuizName';

const elements = {
  form: document.getElementById('registerForm'),
  nameInput: document.getElementById('inputName'),
  registerFeedback: document.getElementById('registerFeedback'),
  refresh: document.getElementById('btnRefresh'),
  questionStatus: document.getElementById('questionStatus'),
  questionContent: document.getElementById('questionContent'),
  questionNumber: document.getElementById('questionNumber'),
  questionText: document.getElementById('questionText'),
  optionsList: document.getElementById('optionsList'),
  answerFeedback: document.getElementById('answerFeedback')
};

let cachedName = localStorage.getItem(nameKey) || '';
let currentQuestionId = null;
let alreadyAnswered = false;

function setFeedback(message, success = true) {
  elements.registerFeedback.textContent = message;
  elements.registerFeedback.classList.toggle('hidden', false);
  elements.registerFeedback.classList.toggle('text-emerald-400', success);
  elements.registerFeedback.classList.toggle('text-amber-400', !success);
}

async function registerName(name) {
  const response = await fetch(API_URL, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ action: 'register', name })
  });

  if (!response.ok) {
    setFeedback('Não foi possível registrar. Tente novamente.', false);
    return;
  }

  const data = await response.json();
  if (data.error) {
    setFeedback(data.error, false);
    return;
  }

  cachedName = data.player?.nome || name;
  localStorage.setItem(nameKey, cachedName);
  setFeedback(`Nome salvo como "${cachedName}".`);
}

function showWaitingState() {
  elements.questionStatus.textContent = 'Nenhuma pergunta liberada no momento. Aguarde o apresentador.';
  elements.questionContent.classList.add('hidden');
  elements.optionsList.innerHTML = '';
  elements.answerFeedback.textContent = '';
  currentQuestionId = null;
  alreadyAnswered = false;
}

function renderOptions(question) {
  elements.optionsList.innerHTML = '';
  question.options.forEach((option, index) => {
    const button = document.createElement('button');
    button.type = 'button';
    button.className = 'option-btn w-full text-left text-base';
    button.innerHTML = `<span class="font-semibold text-slate-300 mr-2">${String.fromCharCode(65 + index)}.</span>${option}`;
    button.addEventListener('click', () => submitAnswer(index));
    elements.optionsList.appendChild(button);
  });
}

function renderQuestion(question) {
  elements.questionStatus.textContent = 'Pergunta liberada! Responda rápido.';
  elements.questionContent.classList.remove('hidden');
  elements.questionNumber.textContent = (question.id ?? 0) + 1;
  elements.questionText.textContent = question.text;
  elements.answerFeedback.textContent = '';
  alreadyAnswered = false;
  currentQuestionId = question.id;
  renderOptions(question);
}

async function fetchQuestion() {
  elements.answerFeedback.textContent = '';
  try {
    const response = await fetch(API_URL);
    const data = await response.json();

    if (data.status !== 'active' || !data.question) {
      showWaitingState();
      return;
    }

    renderQuestion(data.question);
  } catch (error) {
    elements.questionStatus.textContent = 'Erro ao buscar pergunta. Tente novamente.';
    elements.questionContent.classList.add('hidden');
  }
}

async function submitAnswer(optionIndex) {
  if (!cachedName) {
    setFeedback('Salve seu nome antes de responder.', false);
    return;
  }

  if (alreadyAnswered || currentQuestionId === null) {
    return;
  }

  alreadyAnswered = true;
  try {
    const response = await fetch(API_URL, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        action: 'answer',
        name: cachedName,
        questionId: currentQuestionId,
        option: optionIndex
      })
    });

    const data = await response.json();
    if (!response.ok || data.error) {
      elements.answerFeedback.textContent = data.error || 'Não foi possível registrar sua resposta.';
      elements.answerFeedback.className = 'text-amber-300';
      return;
    }

    if (data.result === 'correct') {
      elements.answerFeedback.textContent = 'Acertou! Você foi o primeiro? Aguarde a confirmação.';
      elements.answerFeedback.className = 'text-emerald-300';
    } else {
      elements.answerFeedback.textContent = 'Resposta incorreta. Aguarde a próxima pergunta.';
      elements.answerFeedback.className = 'text-rose-300';
    }

    if (data.winner) {
      elements.questionStatus.textContent = `Pergunta encerrada. Vencedor: ${data.winner.name}.`;
    }
  } catch (error) {
    elements.answerFeedback.textContent = 'Erro ao enviar resposta. Tente novamente.';
    elements.answerFeedback.className = 'text-amber-300';
  }
}

function syncNameField() {
  if (cachedName) {
    elements.nameInput.value = cachedName;
    setFeedback(`Você está respondendo como "${cachedName}".`);
  }
}

function setupEvents() {
  elements.form.addEventListener('submit', (event) => {
    event.preventDefault();
    const name = elements.nameInput.value.trim();
    if (!name) {
      setFeedback('Digite um nome para participar.', false);
      return;
    }
    registerName(name);
  });

  elements.refresh.addEventListener('click', fetchQuestion);
}

syncNameField();
setupEvents();
fetchQuestion();
