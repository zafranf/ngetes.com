<?php
if (_server('REQUEST_METHOD') != 'POST') {
    return view_error(404);
}

$parse = parse_url(_post('website'));
$_POST['website'] = isset($parse['scheme']) ? _post('website') : 'http://' . _post('website');
activityLog('submit krisar');

$valid = validation([
    'requests' => _post(),
    'rules' => [
        'name' => 'required|max:50',
        'email' => 'required|email|max:100',
        'message' => 'required|min:15|max:1000',
        'phone' => 'nullable|numeric|max:15',
        'website' => 'nullable|url',
        'g-recaptcha-response' => 'required',
    ],
]);

$valid_captcha = validateCaptcha(_post('g-recaptcha-response'));
if (!$valid_captcha) {
    setFlashMessage('Gagal validasi captcha');
    _goto(url('/krisar'));
}

$save = db()->table('contacts')->insert([
    'name' => _post('name'),
    'email' => _post('email'),
    'phone' => _post('phone'),
    'website' => _post('website'),
    'message' => _post('message'),
    'thankyou' => bool(_post('thankyou')),
    'created_at' => date('Y-m-d H:i:s'),
    // 'updated_at' => date('Y-m-d H:i:s'),
]);

setFlashMessage('Ntaps! Nanti dibaca krisarnya. Kalo sempet. 😜', 'success');
_goto(url('/krisar'));
