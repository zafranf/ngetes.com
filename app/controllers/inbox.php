<?php
visitorLog();

if (_session('token_time') == null) {
    $_SESSION['token_time'] = time();
}

return view($controller);
