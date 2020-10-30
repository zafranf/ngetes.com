<?php
include "helpers.php";

/* set variable input */
$r = _input();
$files = _files();
if (config('app')['debug']) {
    $logs = [
        'request' => [
            'get' => _get(),
            'post' => _post(),
            'files' => _files(),
            'input' => _input(),
            'fgc' => file_get_contents("php://input"),
        ],
    ];

    $filelog = STORAGE_PATH . 'logs/' . date('Ymd') . '.log';
    file_put_contents($filelog, '[' . date("Y-m-d H:i:s") . '] ' . json_encode($logs) . "\n", FILE_APPEND);
}
if (empty(_post())) {
    return true;
}

/* set variable */
$to = $r['to'] ?? ($r['To'] ?? null);
$cc = $r['Cc'] ?? null;
$from = $r['from'] ?? ($r['From'] ?? null);
$from = parseFrom($from);
$attachments = isset($r['attachment-count']) && $r['attachment-count'] > 0 ? processFiles(_files()) : [];

/* set content */
$content = $r['body-html'] ?? nl2br(trim(($r['body-plain'] ?? null)));
$content = trim($content);

/* convert inline styles */
$cssToInlineStyles = new \TijsVerkoyen\CssToInlineStyles\CssToInlineStyles();
$html = $cssToInlineStyles->convert($content);

/* add target link */
$doc = new \DOMDocument('1.0', 'UTF-8');
@$doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
$links = $doc->getElementsByTagName('a');
foreach ($links as $link) {
    $link->setAttribute('target', '_blank');
}

/* save content */
$bodyContent = $doc->getElementsByTagName('body');
if ($bodyContent && $bodyContent->length > 0) {
    $bodyContent = $bodyContent->item(0);
    $content = $doc->saveHTML($bodyContent);
} else {
    $content = $doc->saveHTML();
}

/* clear tags */
$content = preg_replace('/(<(script|style)\b[^>]*>).*?(<\/\2>)/s', "", $content);
$content = preg_replace('/\ class="(.*?)"/', "", $content);
$content = preg_replace('/\ id="(.*?)"/', "", $content);
$content = preg_replace('/\<body(.*?)>/', "", $content);
$content = str_replace(['<body>', '</body>'], "", $content);

/* check flag */
$is_plain = !empty($r['body-plain']) && !empty($content);
$is_spam = isset($r['X-Mailgun-Sflag']) && bool($r['X-Mailgun-Sflag']) ? 1 : 0;
if (!$is_spam) {
    $is_spam = strpos($r['message-headers'], "\"X-Mailgun-Sflag\", \"yes\"") !== false ? 1 : 0;
}

$data = [
    // 'id' => $mail->id,
    'message_id' => str_replace(['<', '>'], "", $r['Message-Id']),
    'date' => date("Y-m-d H:i:s", $r['timestamp']),
    'sender' => $r['sender'] ?? $r['Sender'],
    'from_name' => trim($from['name']),
    'from_email' => $from['email'],
    'to' => $to,
    'cc' => $cc,
    // 'bcc' => json_encode($mail->bcc),
    'reply_to' => $r['reply-to'] ?? ($r['Reply-To'] ?? null),
    'subject' => $r['subject'] ?? ($r['Subject'] ?? null),
    'text' => strip_tags(trim($content)),
    'html' => $content,
    'attachment_count' => count($attachments),
    'attachments' => json_encode($attachments),
    'headers' => $r['message-headers'] ?? null, //json_encode($r['message-headers']),
    // 'headers_raw' => json_encode($r['message-headers']),
    'size' => null,
    'is_read' => 0,
    'is_deleted' => 0,
    'is_spam' => $is_spam,
    'created_at' => date("Y-m-d H:i:s"),
];
db()->table('emails')->insert($data);
