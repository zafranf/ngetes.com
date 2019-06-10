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

// Get INBOX emails after date 2017-01-01
$ids = $mailbox->searchMailbox('TO "' . _post('name') . '@ngetes.com"');
if (!in_array(_post('id'), $ids)) {
    $statusCode = 404;
    $response['message'] = 'mail not found';

    return response($response, $statusCode);
}

$body = $mailbox->getMail(_post('id'));
$mailbox->disconnect();

$content = $body->textHtml ?? nl2br($body->textPlain);
$content = trim($content);

$cssToInlineStyles = new \TijsVerkoyen\CssToInlineStyles\CssToInlineStyles();
$html = $cssToInlineStyles->convert($content);

$doc = new \DOMDocument('1.0', 'UTF-8');
@$doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
$links = $doc->getElementsByTagName('a');
foreach ($links as $link) {
    // $href = $link->getAttribute('href');
    // $link->setAttribute('href', url($href));
    $link->setAttribute('target', '_blank');
}

$bodyContent = $doc->getElementsByTagName('body');
if ($bodyContent && $bodyContent->length > 0) {
    $bodyContent = $bodyContent->item(0);
    $content = $doc->savehtml($bodyContent);
} else {
    $content = $doc->saveHTML();
}

$content = preg_replace('/(<(script|style)\b[^>]*>).*?(<\/\2>)/s', "", $content);
$content = preg_replace('/\ class="(.*?)"/', '', $content);

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

$statusCode = 200;
$response = [
    'status' => true,
    'message' => 'success',
    'data' => $data,
];

return response($response, $statusCode);
