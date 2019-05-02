<?php
visitorLog();

$data = [
    'name' => isset($params[0]) ? $params[0] : null,
];

if (_session('token_time') == null) {
    $_SESSION['token_time'] = time();
}
if (_session('email_name') == null) {
    if (isset($data['name'])) {
        $_SESSION['email_name'] = $data['name'];
    }
}

return view($controller, $data);
