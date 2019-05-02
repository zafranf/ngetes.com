<?php
visitorLog();

$data = [
    'name' => isset($params[0]) ? $params[0] : null,
    'id' => isset($params[1]) ? $params[1] : null,
];

return view($controller, $data);
