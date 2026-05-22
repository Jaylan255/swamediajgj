<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Method not allowed'
    ]);
    exit;
}

$apiKey = getenv('MONGIKE_API_KEY');
if (!$apiKey) {
    $apiKey = 'mk_c3cc4ef6fe9618f93e91f16aae28537e388966f712244d9e';
}

$incomingKey = $_SERVER['HTTP_X_API_KEY'] ?? '';
if ($incomingKey !== $apiKey) {
    http_response_code(401);
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid webhook signature'
    ]);
    exit;
}

$rawInput = file_get_contents('php://input');
$logLine = '[' . date('c') . '] ' . $rawInput . PHP_EOL;
@file_put_contents(__DIR__ . '/mongike-webhook.log', $logLine, FILE_APPEND);

http_response_code(200);
echo json_encode([
    'status' => 'success',
    'message' => 'Webhook received'
]);
