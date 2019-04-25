<?php
activityLog('submit krisan');

$valid = validation([
    'requests' => _post(),
    'rules' => [
        'name' => 'required',
        'email' => 'required|email',
        'message' => 'required|min:15',
        'g-recaptcha-response' => 'required',
    ],
    'redirect' => url('/#krisan'),
]);

$valid_captcha = validateCaptcha(_post('g-recaptcha-response'));
if (!$valid_captcha) {
    setFlashMessage('Gagal validasi captcha');
    _goto(url('/#krisan'));
}

$save = db()->table('contacts')->insert([
    'name' => _post('name'),
    'email' => _post('email'),
    'message' => _post('message'),
    'accept' => bool(_post('thankyou')),
]);

setFlashMessage('Siap, krisan akan segera dibaca nanti. Kalo sempet!', 'success');
_goto(url('/#krisan'));
