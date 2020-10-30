<?php
$logs = [
    'request' => [
        'method' => $_SERVER['REQUEST_METHOD'],
        'uri' => $_SERVER['REQUEST_URI'],
        'body' => file_get_contents('php://input'),
        'GET' => $_GET,
        'POST' => $_POST,
        'FILES' => $_FILES,
        'headers' => getallheaders(),
    ],
];

$filelog = '../storage/logs/' . date('Ymd') . '.log';
file_put_contents($filelog, '[' . date("Y-m-d H:i:s") . '] ' . json_encode($logs) . "\n", FILE_APPEND);

echo "ok";
