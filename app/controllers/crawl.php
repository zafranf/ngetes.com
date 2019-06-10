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
        'message' => 'forbidden access',
    ];

    return response($response, $statusCode);
}

$valid = validation([
    'requests' => _post(),
    'rules' => [
        'name' => 'required|regex:/^[a-zA-Z0-9_.]*$/',
        'token' => 'required',
    ],
]);

/* connect to gmail */
$hostname = config('imap')['hostname'];
$username = config('imap')['username'];
$password = config('imap')['password'];

// Construct the $mailbox handle
/* $mailbox = new \PhpImap\Mailbox($hostname, $username, $password);
$ids = $mailbox->searchMailbox('TO "' . _post('name') . '@ngetes.com"');
rsort($ids);
array_splice($ids, config('imap')['limit']);

$mails = $mailbox->getMailsInfo($ids);
$mailbox->disconnect(); */

$mails = db()->table('emails')->where('to', 'like', '%' . _post('name') . '@ngetes.com%')->where('is_deleted', 0)->get();
foreach ($mails as $mail) {
    $data[] = [
        'id' => $mail->id,
        'subject' => $mail->subject ?? '[no-subject]',
        'from' => [
            'name' => $mail->from_name ?? '',
            'email' => $mail->from_email ?? '',
        ],
        'date' => date("Y-m-d H:i:s", strtotime($mail->date)),
        'read' => $mail->is_read,
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
