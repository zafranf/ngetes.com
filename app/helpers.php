<?php
function spaces($n = 4, $space = "&nbsp;")
{
    return str_repeat($space, $n);
}

function validateCaptcha($response)
{
    $client = new \GuzzleHttp\Client();
    $res = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
        'form_params' => [
            'secret' => config('recaptcha')['secret_key'],
            'response' => $response,
            'remoteip' => _server('REMOTE_ADDR'),
        ],
    ]);
    $response = json_decode($res->getBody()->getContents());

    return $response->success;
}

function activityLog($description)
{
/* Filter password */
    $sensor = 'xxx';
    if (isset($_POST['password'])) {
        $_POST['password'] = $sensor;
    }
    if (isset($_POST['password_confirmation'])) {
        $_POST['password_confirmation'] = $sensor;
    }
    if (isset($_POST['user_password'])) {
        $_POST['user_password'] = $sensor;
    }

    $save = db()->table('activity_logs')->insert([
        'description' => $description,
        'method' => _server('REQUEST_METHOD'),
        'path' => _server('REQUEST_URI'),
        'ip' => _server('REMOTE_ADDR'),
        'get' => json_encode(_get()),
        'post' => json_encode(_post()),
        'files' => json_encode(_files()),
        'created_at' => date('Y-m-d H:i:s'),
        // 'updated_at' => date('Y-m-d H:i:s'),
    ]);
}

function validation(array $params)
{
    $requests = $params['requests'];
    $rules = $params['rules'];
    $messages = $params['messages'] ?? [];
    $aliases = $params['aliases'] ?? [];
    $redirect = $params['redirect'] ?? _server('HTTP_REFERER');

    $validator = new \Rakit\Validation\Validator;
    $validation = $validator->make($requests, $rules);
    if (!empty($messages)) {
        $validation->setMessages($messages);
    }
    if (!empty($aliases)) {
        $validation->setAliases($aliases);
    }
    $validation->validate();

    if ($validation->fails()) {
        setFlashMessages($validation->errors->firstOfAll());
        return _goto($redirect);
    }
}

function generateFlashMessages()
{
    if (checkFlashMessages()) {
        echo '<div class="notification">';
        $messages = getFlashMessages();
        foreach ($messages as $key => $message) {
            $class = $messages['type_message'] == 'failed' ? 'has-text-danger' : 'has-text-link';
            if ($key != 'type_message') {
                echo '<span class="' . $class . '"><small>' . $message . '</small></span><br>';
            }
        }
        echo '</div>';
    }
}
