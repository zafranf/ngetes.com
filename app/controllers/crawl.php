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
}

$valid = validation([
    'requests' => _post(),
    'rules' => [
        'name' => 'required|regex:/^[a-zA-Z0-9_.]*$/',
    ],
]);

/* connect to gmail */
$hostname = '{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX';
$username = 'catchall.ngetes.com@gmail.com';
$password = 'saiiaganteng';

// Construct the $mailbox handle
$mailbox = new \PhpImap\Mailbox($hostname, $username, $password);

// Get INBOX emails after date 2017-01-01
$ids = $mailbox->searchMailbox('TO "' . _post('name') . '@ngetes.com"');
/* itung jumlah */
$count = count($ids);
/* urutin desc */
rsort($ids);
/* ambil 30 terakhir */
array_splice($ids, 30);
$mails = $mailbox->getMailsInfo($ids);
foreach ($mails as $mail) {
    // debug($mail);
    // $head = $mailbox->getMailHeader($mail->uid);
    // debug($head);
    $markAsSeen = false;
    $body = $mailbox->getMail($mail->uid, $markAsSeen);
    $data[] = [
        'id' => $body->id,
        'subject' => $body->subject ?? '[no-subject]',
        'message' => strlen($body->textPlain) > 50 ? substr($body->textPlain, 0, 50) . '...' : $body->textPlain,
        'from' => [
            'name' => $body->fromName ?? '',
            'email' => $body->fromAddress ?? '',
        ],
        'date' => date("Y-m-d H:i:s", strtotime($body->date)),
        'attachments' => count($body->getAttachments()),
        'read' => $mail->seen,
    ];
    // debug($data);
}
$mailbox->disconnect();
// debug($ids);/*  */
rsort($data);
$response['data'] = $data;
// debug($emails, 'a');

http_response_code($statusCode);
header('Content-Type: application/json');
echo json_encode($response);
