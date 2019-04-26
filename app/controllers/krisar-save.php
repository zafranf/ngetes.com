<?php
activityLog('submit krisar');

$valid = validation([
    'requests' => _post(),
    'rules' => [
        'name' => 'required|max:50',
        'email' => 'required|email|max:100',
        'message' => 'required|min:15|max:1000',
        'phone' => 'numeric|max:15',
        'website' => 'url',
        'g-recaptcha-response' => 'required',
    ],
]);

$valid_captcha = validateCaptcha(_post('g-recaptcha-response'));
if (!$valid_captcha) {
    setFlashMessage('Gagal validasi captcha');
    _goto(url('/#krisar'));
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

setFlashMessage('Ntaps! Nanti dibaca krisarnya. Kalo sempet :p', 'success');
_goto(url('/#krisar'));
