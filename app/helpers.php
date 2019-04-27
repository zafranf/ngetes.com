<?php
function generateToken($string)
{
    return md5($string . config('app')['key']);
}

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

function visitorLog()
{
    $device = '';
    $agent = new \Jenssegers\Agent\Agent();
    if ($agent->isPhone()) {
        $device = 'phone';
    } else if ($agent->isTablet()) {
        $device = 'tablet';
    } else if ($agent->isDesktop()) {
        $device = 'desktop';
    }
    $device_name = $agent->device();
    $ip = (_server('REMOTE_ADDR') != null) ? _server('REMOTE_ADDR') : '127.0.0.1';
    $browser_agent = $agent->getUserAgent();
    $browser = $agent->browser();
    $browser_version = $agent->version($browser);
    $os = $agent->platform();
    $os_version = $agent->version($os);
    $page = (_server('REQUEST_URI') != null) ? _server('REQUEST_URI') : '/';
    $referrer = (_server('HTTP_REFERER') != null) ? _server('HTTP_REFERER') : '';
    $referral = str_replace(url('/'), "/", $referrer);
    $is_robot = $agent->isRobot() ? 1 : 0;
    $robot_name = $is_robot ? $agent->robot : '';

    $params = [
        'ip' => $ip,
        'page' => $page,
        'referral' => $referral,
        'agent' => $browser_agent,
        'browser' => $browser,
        'browser_version' => $browser_version,
        'device' => $device,
        'device_name' => $device_name,
        'os' => $os,
        'os_version' => $os_version,
        'is_robot' => $is_robot,
        'robot_name' => $robot_name,
    ];

    $table = db()->table('visitor_logs');
    $q = $table->where(function ($q) {
        $q->whereBetween('created_at', date("Y-m-d H:00:00"), date("Y-m-d H:59:59"));
    });
    foreach ($params as $key => $value) {
        $q->where($key, $value);
    }
    $find = $q->first();

    if (!$find) {
        $params['count'] = db()->raw('count+1');
        $params['created_at'] = date("Y-m-d H:i:s");
        $table->insert($params);
    } else {
        $q->update([
            'count' => db()->raw('count+1'),
        ]);
    }
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
        return _goto(($redirect ?? '/'));
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

function getImapAttachments($imap, $uid)
{
    $structure = imap_fetchstructure($imap, $uid, FT_UID);
    debug($structure);

    $attachments = array();
    if (isset($structure->parts) && count($structure->parts)) {
        for ($i = 0; $i < count($structure->parts); $i++) {
            /* $attachments[$i] = array(
            'is_attachment' => false,
            'filename' => '',
            'name' => '',
            'attachment' => ''); */

            if ($structure->parts[$i]->ifdparameters) {
                foreach ($structure->parts[$i]->dparameters as $object) {
                    if (strtolower($object->attribute) == 'filename') {
                        $attachments[$i]['is_attachment'] = true;
                        $attachments[$i]['filename'] = $object->value;
                    }
                }
            }

            if ($structure->parts[$i]->ifparameters) {
                foreach ($structure->parts[$i]->parameters as $object) {
                    if (strtolower($object->attribute) == 'name') {
                        $attachments[$i]['is_attachment'] = true;
                        $attachments[$i]['name'] = $object->value;
                    }
                }
            }

            /* if (isset($attachments[$i]['is_attachment'])) {
        $attachments[$i]['attachment'] = imap_fetchbody($imap, $uid, $i + 1, FT_UID);
        if ($structure->parts[$i]->encoding == 3) { // 3 = BASE64
        $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
        } elseif ($structure->parts[$i]->encoding == 4) { // 4 = QUOTED-PRINTABLE
        $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
        }
        } */
        } // for($i = 0; $i < count($structure->parts); $i++)
    } // if(isset($structure->parts) && count($structure->parts))

    return $attachments;
}

function response($data, $statusCode = 200, $json = true)
{
    http_response_code($statusCode);
    if ($json) {
        header('Content-Type: application/json');
    }

    echo json_encode($data);
}
