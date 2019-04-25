<?php
activityLog('submit krisan');

$valid = validation([
    'requests' => _post(),
    'rules' => [
        'name' => 'required',
        'email' => 'required|email',
        'message' => 'required|min:15',
        'phone' => 'numeric',
        'website' => 'url',
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
    'phone' => _post('phone'),
    'website' => _post('website'),
    'thankyou' => bool(_post('thankyou')),
    'created_at' => date('Y-m-d H:i:s'),
    // 'updated_at' => date('Y-m-d H:i:s'),
]);

setFlashMessage('Ntaps! Nanti dibaca krisannya. Kalo sempet :p', 'success');
_goto(url('/#krisan'));
