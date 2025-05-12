<?php
$config = require('config.php');
$input = json_decode(file_get_contents('php://input'), true);

// Make sure the required fields are present
if (!isset($input['type']) || !in_array($input['type'], ['text', 'image'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing or invalid "type" (must be text or image).']);
    exit;
}

// 👇 Add password protection here!
if (!isset($input['passwordtoapi']) || $input['passwordtoapi'] !== 'your api file password here') {
    http_response_code(400);
    echo json_encode(['error' => 'invalid api password']);
    exit;
    }
// TEXT CHAT HANDLER
if ($input['type'] === 'text') {
    if (!isset($input['message'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing "message" for text request.']);
        exit;
    }

    $data = [
        "model" => "shapesinc/your shape handle",
        "messages" => [
            ["role" => "user", "content" => $input['message']]
        ]
    ];

    $ch = curl_init($config['text_api']['endpoint']);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'X-User-Id:' . $input['uuid'],
            'X-Channel-Id:' . $input['roomid'],
            'Authorization: Bearer ' . $config['text_api']['apikey']
            
        ],
        CURLOPT_POSTFIELDS => json_encode($data)
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    echo $response;
    exit;
}

// IMAGE GENERATION HANDLER
if ($input['type'] === 'image') {
    if (!isset($input['prompt'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing "prompt" for image request.']);
        exit;
    }

     $data = [
        "model" => "shapesinc/your shape handle",
        "messages" => [
            ["role" => "user", "content" => $input['prompt']]
        ]
    ];

    $ch = curl_init($config['image_api']['endpoint']);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'X-User-Id:' . $input['uuid'],
            'X-Channel-Id:' . $input['roomid'],
            'Authorization: Bearer ' . $config['image_api']['apikey']
        ],
        CURLOPT_POSTFIELDS => json_encode($data)
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    echo $response;
    exit;
}
