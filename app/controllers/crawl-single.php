<?php
if (_server('REQUEST_METHOD') != 'POST') {
    return view_error(404);
}

$data = [];
$statusCode = 500;
$response = [
    'status' => false,
    'message' => 'failed',
    'data' => $data,
];

$token = generateToken(_post('name') . _session('token_time'));
if ($token != _post('token')) {
    $statusCode = 403;
    $response['message'] = 'forbidden access';

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
$hostname = config('imap')['hostname'];
$username = config('imap')['username'];
$password = config('imap')['password'];

// Construct the $mailbox handle
$mailbox = new \PhpImap\Mailbox($hostname, $username, $password);

// Get INBOX emails
$ids = $mailbox->searchMailbox('TO "' . _post('name') . '@ngetes.com"');
if (!in_array(_post('id'), $ids)) {
    $statusCode = 404;
    $response['message'] = 'Mail not found';

    return response($response, $statusCode);
}

$mail = $mailbox->getMail(_post('id'));
$mailbox->disconnect();

$content = $mail->textHtml ?? nl2br($mail->textPlain);
$content = trim($content);

$cssToInlineStyles = new \TijsVerkoyen\CssToInlineStyles\CssToInlineStyles();
$html = $cssToInlineStyles->convert($content);

$doc = new \DOMDocument('1.0', 'UTF-8');
@$doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
$links = $doc->getElementsByTagName('a');
foreach ($links as $link) {
    $link->setAttribute('target', '_blank');
}

$bodyContent = $doc->getElementsByTagName('body');
if ($bodyContent && $bodyContent->length > 0) {
    $bodyContent = $bodyContent->item(0);
    $content = $doc->saveHTML($bodyContent);
} else {
    $content = $doc->saveHTML();
}

$content = preg_replace('/(<(script|style)\b[^>]*>).*?(<\/\2>)/s', "", $content);
$content = preg_replace('/\ class="(.*?)"/', "", $content);
$content = preg_replace('/\ id="(.*?)"/', "", $content);
$content = str_replace(['<body>', '</body>'], "", $content);

$table = db()->table('emails');
$q = $table->where('id', _post('id'))->where('is_deleted', 0);
$qmail = $q->first();
/* if ($qmail) {
$q->update([
'is_read' => 1,
'updated_at' => date("Y-m-d H:i:s"),
]);
} else {
$statusCode = 404;
$response['message'] = 'Mail not found';

return response($response, $statusCode);
} */

$data = [
    'id' => $mail->id,
    'subject' => $mail->subject ?? '[no-subject]',
    'content' => $content,
    'from' => [
        'name' => $mail->fromName ?? '',
        'email' => $mail->fromAddress ?? '',
    ],
    'date' => date("Y-m-d H:i:s", strtotime($mail->date)),
    'attachments' => count($mail->getAttachments()),
];

$statusCode = 200;
$response = [
    'status' => true,
    'message' => 'success',
    'data' => $data,
];

return response($response, $statusCode);
