<?php
header('Content-Type: application/json; charset=utf-8');

$storageDir = __DIR__ . '/assets/data';
$storageFile = $storageDir . '/ranking.txt';

if (!is_dir($storageDir)) {
    mkdir($storageDir, 0755, true);
}

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

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$scores = load_scores($storageFile);

if ($method === 'GET') {
    echo json_encode(['placar' => $scores]);
    exit;
}

if ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input') ?: '{}', true);
    $name = trim($input['nome'] ?? '');

    if ($name === '') {
        http_response_code(400);
        echo json_encode(['error' => 'Nome é obrigatório.']);
        exit;
    }

    $key = mb_strtolower($name, 'UTF-8');
    if (!isset($scores[$key])) {
        $scores[$key] = ['nome' => $name, 'pontos' => 0];
    }

    if (empty($scores[$key]['nome'])) {
        $scores[$key]['nome'] = $name;
    }

    $scores[$key]['pontos'] += 1;

    save_scores($storageFile, $scores);
    echo json_encode(['placar' => $scores]);
    exit;
}

if ($method === 'DELETE') {
    $scores = [];
    save_scores($storageFile, $scores);
    echo json_encode(['placar' => $scores]);
    exit;
}

http_response_code(405);
echo json_encode(['error' => 'Método não permitido.']);
