<?php
header('Content-Type: application/json; charset=utf-8');

require __DIR__ . '/quiz-data.php';

$storageDir = __DIR__ . '/assets/data';
$stateFile = $storageDir . '/live_quiz_state.json';
$playersFile = $storageDir . '/live_quiz_players.json';
$rankingFile = $storageDir . '/ranking.txt';

if (!is_dir($storageDir)) {
    mkdir($storageDir, 0755, true);
}

$questions = load_quiz_questions();

function load_scores(string $file): array
{
    if (!file_exists($file)) {
        return [];
    }

    $contents = trim((string) file_get_contents($file));
    if ($contents === '') {
        return [];
    }

    $data = json_decode($contents, true);
    return is_array($data) ? $data : [];
}

function save_scores(string $file, array $scores): void
{
    file_put_contents($file, json_encode($scores, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function load_json(string $file): array
{
    if (!file_exists($file)) {
        return [];
    }

    $content = trim((string) file_get_contents($file));
    if ($content === '') {
        return [];
    }

    $decoded = json_decode($content, true);
    return is_array($decoded) ? $decoded : [];
}

function save_json(string $file, array $data): void
{
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
}

function json_response(array $payload, int $statusCode = 200): void
{
    http_response_code($statusCode);
    echo json_encode($payload);
    exit;
}

function get_question(int $id, array $questions): ?array
{
    return $questions[$id] ?? null;
}

function get_state(string $stateFile): array
{
    $defaults = [
        'status' => 'waiting',
        'questionId' => null,
        'questionText' => '',
        'options' => [],
        'correctIndex' => null,
        'winner' => null,
        'releasedAt' => null,
        'closedAt' => null,
        'attempts' => [],
        'slideTitle' => '',
        'questionLabel' => ''
    ];

    $state = load_json($stateFile);
    return array_merge($defaults, $state);
}

function save_state(string $stateFile, array $state): void
{
    save_json($stateFile, $state);
}

function registrar_ponto(string $nome, string $arquivo): void
{
    if ($nome === '') {
        return;
    }

    $scores = load_scores($arquivo);
    $key = mb_strtolower($nome, 'UTF-8');

    if (!isset($scores[$key])) {
        $scores[$key] = ['nome' => $nome, 'pontos' => 0];
    }

    if (empty($scores[$key]['nome'])) {
        $scores[$key]['nome'] = $nome;
    }

    $scores[$key]['pontos'] += 1;
    save_scores($arquivo, $scores);
}

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$state = get_state($stateFile);

$sanitize_options = static function ($options): array {
    if (!is_array($options)) {
        return [];
    }

    $clean = array_values(array_filter(array_map(static function ($option) {
        return is_string($option) ? trim($option) : '';
    }, $options), static fn($value) => $value !== ''));

    return array_values(array_unique($clean));
};

if ($method === 'GET') {
    $question = null;
    $closedQuestion = null;
    if ($state['status'] === 'active' && ($state['questionId'] !== null || $state['questionText'])) {
        $question = [
            'id' => $state['questionId'],
            'text' => $state['questionText'],
            'options' => $state['options'],
            'slideTitle' => $state['slideTitle'],
            'questionLabel' => $state['questionLabel']
        ];
    }

    if ($state['status'] === 'closed' && ($state['questionId'] !== null || $state['questionText'])) {
        $closedQuestion = [
            'id' => $state['questionId'],
            'questionLabel' => $state['questionLabel'],
            'slideTitle' => $state['slideTitle'],
            'options' => $state['options'],
            'correctIndex' => $state['correctIndex']
        ];
    }

    json_response([
        'status' => $state['status'],
        'question' => $question,
        'closedQuestion' => $closedQuestion,
        'winner' => $state['winner'],
        'releasedAt' => $state['releasedAt'],
        'closedAt' => $state['closedAt']
    ]);
}

$input = json_decode(file_get_contents('php://input') ?: '{}', true);
$action = $input['action'] ?? '';

if ($action === 'register') {
    $name = trim($input['name'] ?? '');
    if ($name === '') {
        json_response(['error' => 'Nome é obrigatório.'], 400);
    }

    $players = load_json($playersFile);
    $key = mb_strtolower($name, 'UTF-8');
    if (!isset($players[$key])) {
        $players[$key] = ['nome' => $name, 'registradoEm' => time()];
    }
    save_json($playersFile, $players);

    json_response(['ok' => true, 'player' => $players[$key]]);
}

if ($action === 'release') {
    $questionId = $input['questionId'] ?? null;
    $questionText = trim((string) ($input['questionText'] ?? ''));
    $optionsFromRequest = $sanitize_options($input['options'] ?? []);
    $correctOption = isset($input['correctOption']) ? trim((string) $input['correctOption']) : null;
    $slideTitle = isset($input['slideTitle']) ? trim((string) $input['slideTitle']) : '';
    $questionLabel = isset($input['questionLabel']) ? trim((string) $input['questionLabel']) : '';

    $questionData = null;
    if ($questionText === '' || empty($optionsFromRequest) || $correctOption === null) {
        if ($questionId !== null && $questionId !== '') {
            $questionIndex = (int) $questionId;
            $questionData = get_question($questionIndex, $questions);
            $questionId = $questionIndex;
        }
    }

    if ($questionData) {
        $options = array_merge([$questionData['correct']], $questionData['alternatives']);
        shuffle($options);
        $questionText = $questionData['question'];
        $correctOption = $questionData['correct'];
    } else {
        $options = $optionsFromRequest;
        if ($questionText === '' || empty($options) || $correctOption === null) {
            json_response(['error' => 'Dados incompletos para liberar a pergunta.'], 400);
        }
    }

    $correctIndex = array_search($correctOption, $options, true);
    if ($correctIndex === false) {
        json_response(['error' => 'A alternativa correta precisa estar entre as opções enviadas.'], 400);
    }

    $state = [
        'status' => 'active',
        'questionId' => $questionId,
        'questionText' => $questionText,
        'options' => $options,
        'correctIndex' => $correctIndex,
        'winner' => null,
        'releasedAt' => time(),
        'closedAt' => null,
        'attempts' => [],
        'slideTitle' => $slideTitle,
        'questionLabel' => $questionLabel
    ];

    save_state($stateFile, $state);
    json_response(['ok' => true, 'state' => $state]);
}

if ($action === 'close') {
    $state['status'] = 'waiting';
    $state['questionId'] = null;
    $state['questionText'] = '';
    $state['options'] = [];
    $state['correctIndex'] = null;
    $state['winner'] = null;
    $state['releasedAt'] = null;
    $state['closedAt'] = time();
    $state['attempts'] = [];
    $state['slideTitle'] = '';
    $state['questionLabel'] = '';
    save_state($stateFile, $state);

    json_response(['ok' => true, 'state' => $state]);
}

if ($action === 'answer') {
    $name = trim($input['name'] ?? '');
    $questionId = isset($input['questionId']) ? (int) $input['questionId'] : null;
    $optionIndex = isset($input['option']) ? (int) $input['option'] : null;

    if ($name === '' || $questionId === null || $optionIndex === null) {
        json_response(['error' => 'Dados incompletos para responder.'], 400);
    }

    if ($state['status'] !== 'active' || $state['questionId'] === null) {
        json_response(['error' => 'Nenhuma pergunta liberada no momento.'], 409);
    }

    if ($questionId !== (int) $state['questionId']) {
        json_response(['error' => 'Essa pergunta não está mais valendo.'], 409);
    }

    if ($state['winner']) {
        json_response(['error' => 'Já existe um vencedor para esta pergunta.', 'winner' => $state['winner']], 409);
    }

    $key = mb_strtolower($name, 'UTF-8');
    if (isset($state['attempts'][$key])) {
        json_response(['error' => 'Você já respondeu esta pergunta.'], 409);
    }

    $isCorrect = $optionIndex === (int) $state['correctIndex'];
    $state['attempts'][$key] = [
        'name' => $name,
        'option' => $optionIndex,
        'correct' => $isCorrect,
        'answeredAt' => time()
    ];

    if ($isCorrect) {
        $state['winner'] = ['name' => $name, 'answeredAt' => time()];
        $state['status'] = 'closed';
        $state['closedAt'] = time();
        registrar_ponto($name, $rankingFile);
    }

    save_state($stateFile, $state);

    json_response([
        'result' => $isCorrect ? 'correct' : 'wrong',
        'winner' => $state['winner']
    ]);
}

json_response(['error' => 'Ação não permitida.'], 405);
