<?php
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST' || $method === 'GET') {
    // Check if password is valid right at the start
    $data = [];
    if ($method === 'POST') {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true) ?? $_POST;
    } elseif ($method === 'GET') {
        $data = $_GET;
    }

    if (!isset($data['password']) || $data['password'] !== 'connector lsl password') {
        http_response_code(400);
        echo json_encode(['error' => 'invalid connector password']);
        exit;
    }

    // Proceed with the rest if password is valid
    if (isset($data['prompt'])) {
        $uuid = $data['uuid'];
        $roomid = $data['channelid'];
        $dataprompt = trim($data['prompt']);
        $blockedWords = ['!wack', '!reset'];

        if (
            $dataprompt === '' || 
            preg_match('/\b(' . implode('|', array_map('preg_quote', $blockedWords)) . ')\b/i', $dataprompt)
        ) {
            http_response_code(204); // Silently ignore
            exit;
        }

        $keyword = "make image";
        $pos = strpos($dataprompt, $keyword);
        if ($pos !== false) {
            $dataprompt = substr($dataprompt, $pos);
        }

        $payload = json_encode([
            'type' => 'text',
            'uuid' => $uuid,
            'roomid' => $roomid,
            'passwordtoapi' => 'api file password',
            'message' => $dataprompt
        ]);

        $ch = curl_init('api file address');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-User-Id:' . $uuid,
            'X-Channel-Id:' . $roomid,
            'Content-Length: ' . strlen($payload)
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Handle different responses
        $result = '';

        // Match image first
        if (preg_match('/https:\/\/files\.shapes\.inc\/[a-zA-Z0-9_\-]+\.(png|jpg|jpeg|gif)/', $response, $match)) {
            $result = $match[0];
        }
        // Then match MP3 in a "content" string
        elseif (preg_match('/"content":"(.*?)(https:\/\/files\.shapes\.inc\/[a-zA-Z0-9_\-]+\.mp3)"/s', $response, $match)) {
            $rawText = stripslashes($match[1]);
            $text = substr($rawText, 0, -1); // remove last character
            $mp3 = trim($match[2]);
            $result = $text . ' Voice: ' . $mp3;
        }
        // Fallback: try to pull anything in a content field
        elseif (preg_match('/"content":"(.*?)"/s', $response, $match)) {
            $result = trim($match[1]);
        }
        // Final fallback
        else {
            $result = 'Unknown response format: ' . $response;
        }

        header('Content-Type: text/plain');
        echo $result;

    } else {
        http_response_code(400);
        echo "Missing 'prompt' parameter";
    }
} else {
    http_response_code(405);
    echo "Only GET and POST methods allowed";
}
