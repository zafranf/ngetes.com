<?php
$_POST = (array) json_decode(file_get_contents("php://input"));
return response([
    'status' => true,
    'message' => 'Post data success!',
    'data' => _post(),
], 200, true);
