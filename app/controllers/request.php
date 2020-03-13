<?php
$data = [];
$input = file_get_contents("php://input");
if (is_json($input)) {
    $_POST = (array) json_decode($input);
} else {
    parse_str($input, $_POST);
}
$method = $_SERVER['REQUEST_METHOD'];
$methods = ['post', 'put', 'patch', 'delete'];

if (strtolower($method) == "get") {
    $data = _get();
} else if (in_array(strtolower($method), $methods)) {
    $data = _post();
}

return response([
    'status' => true,
    'message' => $method . ' data success!',
    'data' => $data,
], 200, true);
