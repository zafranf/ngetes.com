<?php
visitorLog();
list($id, $name) = $params;
$data = [
    'id' => $id,
    'name' => $name,
];
return view($controller, $data);
