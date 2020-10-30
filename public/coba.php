<?php
include '../vendor/zafranf/helpers/src/helpers.php';

$logs = [
    'request' => [
        'method' => $_SERVER['REQUEST_METHOD'],
        'uri' => $_SERVER['REQUEST_URI'],
        'body' => file_get_contents('php://input'),
        'request' => $_REQUEST,
        'GET' => $_GET,
        'POST' => $_POST,
        'FILES' => $_FILES,
        'headers' => getallheaders(),
        '_input' => _input(),
        '_post' => _post(),
        '_get' => _get(),
        '_files' => _files(),
    ],
];

header('Content-Type: application/json');
echo json_encode($logs);
