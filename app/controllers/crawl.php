<?php
if (_server('REQUEST_METHOD') != 'POST') {
    return view_error(404);
}

$data = [];
$statusCode = 200;
$response = [
    'status' => true,
    'message' => 'success',
    'data' => $data,
];

$token = generateToken(_post('name') . _session('token_time'));
if ($token != _post('token')) {
    $statusCode = 403;
    $response = [
        'status' => false,
        'message' => 'Nah, lho mau ngapain? 🤔',
    ];

    return response($response, $statusCode);
}

$private = ['admin', 'bantu', 'sosmed', 'tukang', 'janganbales'];
if (in_array(_post('name'), $private)) {
    $statusCode = 403;
    $response = [
        'status' => false,
        'message' => 'Jangan yang ini. Privasi ini mah. Yang lain gih! 😝',
    ];

    return response($response, $statusCode);
}

$valid = validation([
    'requests' => _post(),
    'rules' => [
        // 'name' => 'required|regex:/^[a-zA-Z0-9_.]*$/',
        'name' => [
            'required',
            'regex:/^[a-zA-Z-0-9_.]*$/',
            function ($value) {
                $private = ['admin', 'bantu', 'sosmed', 'tukang', 'janganbales'];

                return !in_array($value, $private);
            },
        ],
        'token' => 'required',
    ],
]);

/* connect to gmail */
// $hostname = config('imap')['hostname'];
// $username = config('imap')['username'];
// $password = config('imap')['password'];

// Construct the $mailbox handle
/* $mailbox = new \PhpImap\Mailbox($hostname, $username, $password);
$ids = $mailbox->searchMailbox('TO "' . _post('name') . '@ngetes.com"');
rsort($ids);
array_splice($ids, config('imap')['limit']);

$mails = $mailbox->getMailsInfo($ids);
$mailbox->disconnect(); */

$mails = db()->table('emails')->where('to', 'like', '%' . _post('name') . '@ngetes.com%')->where('is_deleted', 0)->where('is_spam', 0)->get();
foreach ($mails as $mail) {
    $from = $mail->from_name . ' <' . $mail->from_email . '>';
    $data[] = [
        'id' => $mail->id,
        'subject' => $mail->subject ?? '[no-subject]',
        'from' => str_replace(['<', '>', '"'], ['(', ')', ''], $from),
        'date' => date("Y-m-d H:i:s", strtotime($mail->date)),
        'read' => (int) $mail->is_read,
        'spam' => (int) $mail->is_spam,
    ];
}

$sort = 'desc';
usort($data, function ($a, $b) use ($sort) {
    if ($sort == 'desc') {
        return strtotime($b['date']) <=> strtotime($a['date']);
    } else {
        return strtotime($a['date']) <=> strtotime($b['date']);
    }
});
$response['data'] = $data;

return response($response, $statusCode);
