<?php
visitorLog();

if (_session('token_time') == null) {
    $_SESSION['token_time'] = time();
}
if (_session('email_name') == null) {
    if (_get('name')) {
        $_SESSION['email_name'] = _get('name');
    }
}

return view($controller);
