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
        'id' => 'required|numeric',
        'name' => 'required|regex:/^[a-zA-Z0-9_.]*$/',
        'token' => 'required',
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
if (!in_array(_post('id'), $ids)) {
    debug('gak ada');
}

$body = $mailbox->getMail(_post('id'));
$content = $body->textHtml ?? $body->textPlain;
$content = nl2br(trim($content));

$cssToInlineStyles = new \TijsVerkoyen\CssToInlineStyles\CssToInlineStyles();
$html = $cssToInlineStyles->convert($content);

$doc = new \DOMDocument();
@$doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
$links = $doc->getElementsByTagName('a');
foreach ($links as $link) {
    $link->setAttribute('target', '_blank');
}

$content = $doc->saveHTML();

$data = [
    'id' => $body->id,
    'subject' => $body->subject ?? '[no-subject]',
    'content' => $content,
    'from' => [
        'name' => $body->fromName ?? '',
        'email' => $body->fromAddress ?? '',
    ],
    'date' => date("Y-m-d H:i:s", strtotime($body->date)),
    'attachments' => count($body->getAttachments()),
];
$mailbox->disconnect();
$response['data'] = $data;

return response($response, $statusCode);
